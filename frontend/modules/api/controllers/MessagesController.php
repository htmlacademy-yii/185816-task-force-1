<?php

namespace app\modules\api\controllers;

use common\models\Message;
use yii\helpers\Json;
use yii\rest\ActiveController;

/**
 * Messages controller for the `api` module
 */
class MessagesController extends ActiveController
{
    public $modelClass = Message::class;

    public function actionTask($id)
    {
        return Message::find()->where(['task_id' => $id])->all();
    }
}
