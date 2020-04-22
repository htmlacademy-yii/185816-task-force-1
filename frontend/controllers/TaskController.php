<?php

namespace frontend\controllers;

use frontend\forms\CompleteTaskForm;
use frontend\forms\CreateTaskForm;
use frontend\models\Comment;
use frontend\models\Task;
use frontend\models\User;
use frontend\src\exceptions\StatusException;
use frontend\src\status\CancelAction;
use frontend\src\status\CompleteAction;
use frontend\src\status\FailedAction;
use frontend\src\status\RefuseAction;
use frontend\src\status\WorkAction;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Url;


class TaskController extends BaseController
{
    /**
     * @var Task $task
     */
    protected $task;

    /**
     * @var User $currentUser
     */
    protected $currentUser;

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\NotFoundHttpException
     */

    public function beforeAction($action)
    {
        if (Yii::$app->request->get('id') && Yii::$app->request->get('id') !== null) {
            $this->task = Task::findOrFail(['id' => Yii::$app->request->get('id')]);
        }

        $this->currentUser = Yii::$app->user->identity;

        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionCreate()
    {
        $model = new CreateTaskForm();
        $request = Yii::$app->request->post();

        if ($model->load($request) && $model->validate()) {
            try {
                $task = Task::createTask($model, $this->currentUser);
            } catch (InvalidConfigException $e) {
                Yii::$app->session->setFlash('error', 'Не верный формат даты');
                return $this->redirect(Url::to(['/tasks/index']));
            }

            $task->save();

            Yii::$app->session->setFlash('success', 'Ваше задание успешно опубликовано');
            $this->redirect(Url::to(['tasks/index']));
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionCancel($id)
    {
        $task = Task::findOne(['id' => $id]);

        if ($task === null) {
            Yii::$app->session->setFlash('error', 'Такого задание не существует');
            $this->redirect(Url::to(['/tasks/']));
        }

        try {
            $cancelAction = new CancelAction($this->task, $this->currentUser);
            $cancelAction->apply();
            Yii::$app->session->setFlash('success', 'Задание успешно отменено');
            $this->redirect(Url::to(['/tasks/']));
        } catch (StatusException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            $this->redirect(Url::to(['/tasks/']));
        }
    }

    public function actionComplete($id)
    {
        $form = new CompleteTaskForm();
        $request = Yii::$app->request->post();
        $executor = User::findOne(['id' => $this->task->executor_id]);

        if ($form->load($request) && $form->validate()) {
            $completedField = intval($request['complete']);
            $completeAction = new CompleteAction($this->task, $this->currentUser, $completedField);

            if ($completeAction->isComplete()) {
                try {
                    Comment::createCompleteComment($this->task, $form);
                    $executor->setRating(Comment::getRating($executor->id));
                    $completeAction->apply();

                    Yii::$app->session->setFlash('success', 'Задание успешно выполненно');
                    $this->redirect(Url::to(['/tasks/']));
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('error', $e->getMessage());
                    $this->redirect(Url::to(['/tasks/']));
                }
            } else {
                $completeAction = new FailedAction($this->task, $this->currentUser);
                $completeAction->finishedFailed();
                try {
                    Comment::createCompleteComment($this->task, $form);
                    $executor->setRating(Comment::getRating($executor->id));
                    $completeAction->apply();

                    Yii::$app->session->setFlash('success', 'Задание переведено в статус провалено');
                    $this->redirect(Url::to(['/tasks/']));
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('error', $e->getMessage());
                    $this->redirect(Url::to(['/tasks/']));
                }
            }
        } else {
            $this->redirect(Url::to(['/tasks/']));
        }
    }

    public function actionRefuse()
    {
        $refuseAction = new RefuseAction($this->task, $this->currentUser);

        try {
            Comment::createFailedComment($this->task);
            $this->currentUser->setRating(Comment::getRating($this->currentUser->id));
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            $this->redirect(Url::to(['/tasks/']));
        }

        try {
            $refuseAction->apply();
            Yii::$app->session->setFlash('success', 'Вы отказались от задания, это повлияет на общий рейтинг');
            $this->redirect(Url::to(['/tasks/']));
        } catch (StatusException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            $this->redirect(Url::to(['/tasks/']));
        }
    }

    public function actionWork($executor)
    {
        $executor = User::findOne(['id' => $executor]);

        try {
            $workAction = new WorkAction($this->task, $this->currentUser, $executor);
            $workAction->apply();
            Yii::$app->session->setFlash('success',
                'На задание "' . $this->task->title . '" назначен исполнитель: ' . $executor->full_name);
            $this->redirect(Url::to(['/tasks/']));
        } catch (StatusException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            $this->redirect(Url::to(['/tasks/']));
        }
    }
}