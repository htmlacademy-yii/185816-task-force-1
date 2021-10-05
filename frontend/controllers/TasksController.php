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
    public function actionIndex(): string
    {
        $taskForm = new TasksForm();

        $taskForm->load(Yii::$app->getRequest()->get());

        return $this->render('index', [
            'tasks' => TasksProvider::getContent($taskForm->attributes, false),
            'taskForm' => $taskForm,
            'categories' => Category::find()->select(['category_name'])->indexBy('id')->column()
        ]);
    }

    public function actionView($id): string
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
