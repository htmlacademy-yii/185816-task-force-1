<?php


namespace frontend\controllers;


use common\models\Notice;
use Yii;
use yii\web\Controller;

class EventController extends Controller
{
    public function actionIndex()
    {
        return json_encode(Notice::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all(), JSON_UNESCAPED_UNICODE);
    }

    public function actionDisable($id)
    {
        if (Yii::$app->request->isPost) {
            $notice = Notice::find()->where(['id' => $id])->one();
            return $notice->disable();
        }

        return Yii::$app->response->redirect('/');
    }
}
