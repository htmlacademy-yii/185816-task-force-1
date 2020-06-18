<?php


namespace frontend\controllers;


use frontend\forms\SingupForm;
use common\models\City;
use common\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

class SingupController extends BaseController
{
    public $model;

    public function behaviors()
    {
        $rules = parent::behaviors();
        $rule = [
            'actions' => ['index'],
            'allow' => true,
            'roles' => ['?'],
        ];

        array_unshift($rules['access']['rules'], $rule);

        return $rules;
    }

    public function beforeAction($action)
    {
        if(Yii::$app->user->isGuest) {
            return 'you guest';
        } else {
            return Yii::$app->response->redirect('/tasks/');
        }
    }

    public function actionIndex ()
    {
        $this->layout = 'landing';
        $model = new SingupForm();
        $this->model = new SingupForm();
        $request = Yii::$app->request->post();
        $session = Yii::$app->session;
        $user = new User;

        if ($model->load($request) && $model->validate()) {
            $user->attributes = $model->attributes;
            $user->setHash();
            $user->save();
            $session->setFlash('reg','Вы успешно зарегистрировались');
            return $this->redirect('/singin');
        }

        return $this->render('index',
            [
                'model' => $model,
                'cities' => City::find()->select(['name'])->indexBy('id')->column(),
            ]);
    }
}
