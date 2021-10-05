<?php


namespace frontend\controllers;

use Yii;
use yii\web\Response;

class LogoutController extends BaseController
{

    /**
     * Logout route
     *
     * @return Response
     */

    public function actionIndex(): Response
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
