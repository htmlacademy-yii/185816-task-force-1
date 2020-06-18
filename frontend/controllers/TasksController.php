<?php

namespace frontend\controllers;

use frontend\forms\TasksForm;
use common\models\Category;
use common\models\Task;
use common\models\User;
use Yii;
use frontend\providers\TasksProvider;
use yii\web\NotFoundHttpException;

class TasksController extends BaseController
{
    public function actionIndex()
    {
        $form = new TasksForm();
        $request = Yii::$app->request;

        $form->load(Yii::$app->getRequest()->get());

        return $this->render('index', [
            'tasks' => TasksProvider::getContent($form->attributes, false),
            'model' => $form,
            'categories' => Category::find()->select(['category_name'])->indexBy('id')->column()
        ]);
    }

    public function actionView($id)
    {
        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;

        /**
         * @var Task $task
         */
        $task = Task::find()->where(['id' => $id])->with(['user', 'responses','responses.user', 'category'])->one();

        if($task === null) {
            throw new NotFoundHttpException('Такого задания не существует');
        }

        if ($task->isDefaultStatus()) {
            return $this->render('task', [
                'task' => $task,
            ]);
        } else if ($task->isUserOwner($user) || $task->isUserExecutor($user)) {
            return $this->render('task', [
                'task' => $task,
            ]);
        } else {
            throw new NotFoundHttpException('У вас нет прав просматривать текущее задание');
        }

    }
}
