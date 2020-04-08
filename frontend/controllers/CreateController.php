<?php


namespace frontend\controllers;


use frontend\forms\CreateTaskForm;
use frontend\models\Task;
use frontend\models\User;
use Yii;

class CreateController extends BaseController
{
    public function actionIndex()
    {
        $model = new CreateTaskForm();
        $task = new Task();
        $request = Yii::$app->request->post();
        $errors = '';

        $id = Yii::$app->user->id;
        $user = User::findOne($id);

        if ($user->role->id === User::EXECUTOR) {
            Yii::$app->session->setFlash('error', 'У вас недостаточно прав на публикацию задания');
            return $this->redirect('/tasks/');
        }

        if ($model->load($request) && $model->validate()) {
            $task->attributes = $request['CreateTaskForm'];
            $task->user_id = $user->id;
            $task->city_id = $user->city->id;
            $task->deadline = Yii::$app->formatter->asDate($task->deadline, 'php:Y-m-d');
            $task->file = $model->upload();
            $task->save();
            $this->redirect('/tasks/');
        }


        return $this->render(
            'index',
            [
                'model' => $model,
                'errors' => $model->getErrors(),
                'task' => $task
            ]
        );
    }
}
