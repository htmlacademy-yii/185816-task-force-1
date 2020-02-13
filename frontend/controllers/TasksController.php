<?php

namespace frontend\controllers;

use frontend\behaviors\AccessBehaviors;
use frontend\forms\TasksForm;
use frontend\models\Category;
use frontend\models\Response;
use frontend\models\Task;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use frontend\providers\TasksProvider;
use yii\web\NotFoundHttpException;
use frontend\helpers\AccessSettings;

class TasksController extends Controller
{
    public function behaviors()
    {
        return AccessSettings::Guest();
    }

    public function actionIndex()
    {
        $form = new TasksForm();
        $request = Yii::$app->request->post();

        if ($form->load($request)) {
            $form->attributes = $request['TasksForm'];
        }

        return $this->render('index', [
            'tasks' => TasksProvider::getContent($form->attributes),
            'model' => $form,
            'categories' => Category::find()->select(['category_name'])->indexBy('id')->column()
        ]);
    }

    public function actionView($id)
    {
        $task = Task::findOne($id);

        if($task === null) {
            throw new NotFoundHttpException('Такого задания не существует');
        }

        return $this->render('task', [
            'task' => $task,
        ]);
    }
}
