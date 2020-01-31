<?php

namespace frontend\controllers;

use frontend\forms\TasksForm;
use frontend\models\Category;
use frontend\models\Response;
use frontend\models\Task;
use yii\web\Controller;
use Yii;
use frontend\providers\TasksProvider;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $form = new TasksForm();
        $request = Yii::$app->request->post();

        if($form->load($request)) {
            $form->attributes = $request['TasksForm'];
        }

        return $this->render('index', [
            'tasks' => TasksProvider::getContent($form->attributes)->getModels(),
            'provider' => TasksProvider::getContent($form->attributes),
            'model' => $form,
            'categories' => Category::find()->select(['category_name'])->indexBy('id')->column(),
            'result' => $form->attributes
        ]);
    }

    public function actionView($id)
    {
        return $this->render('task', [
            'task' => Task::findOne($id),
            'responses' => Response::find()->where(['task_id' => $id])->all()
        ]);
    }
}
