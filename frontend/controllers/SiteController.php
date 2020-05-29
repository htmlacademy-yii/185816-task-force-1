<?php
namespace frontend\controllers;

use frontend\forms\SinginForm;
use common\models\Task;
use Yii;
use yii\filters\AccessControl;


/**
 * Site controller
 */
class SiteController extends BaseController
{

    public $model;

    public function behaviors()
    {
        $rules = parent::behaviors();
        $rule = [
            'actions' => ['index'],
            'allow' => true,
            'roles' => ['?'],
            'denyCallback' => function ($rule, $action) {
                return Yii::$app->response->redirect('/tasks');
            }
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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'landing';
        $request = Yii::$app->request->post();
        $session = Yii::$app->session;
        $model = new SinginForm();
        $this->model = $model;

        if ($model->load($request)) {
            if ($model->validate()) {
                $user = $model->getUser();
                \Yii::$app->user->login($user);
                $session->setFlash('success', "Добро пожаловать $user->full_name");
                return $this->goHome();
            } else {
                $session->setFlash('error', "Логин или пароль не совпадают");
            }
        }

        return $this->render('index',
            [
                'tasks' => Task::find()->orderBy(['created_at' => SORT_DESC])->limit(4)->all(),
                'model' => $model
            ]
        );
    }
}
