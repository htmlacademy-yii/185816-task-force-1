<?php


namespace frontend\controllers;


use common\models\Notice;
use frontend\extensions\models\NoticeExtension;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class EventController extends Controller
{

    public function actionIndex()
    {
        return json_encode(Notice::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param $id
     * @return bool|Response
     */

    public function actionDisable(int $id): bool
    {
        if (Yii::$app->request->isPost) {
            /**
             * @var $notice Notice
             */
            $notice = Notice::find()->where(['id' => $id])->one();
            return NoticeExtension::hidden($notice);
        }

        return Yii::$app->response->redirect('/');
    }
}
