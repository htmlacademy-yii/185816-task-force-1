<?php

namespace app\modules\api\controllers;

use frontend\extensions\models\MessageExtension;
use yii\db\ActiveRecord;
use yii\rest\ActiveController;

/**
 * Messages controller for the `api` module
 */
class MessagesController extends ActiveController
{
    public $modelClass = MessageExtension::class;

    /**
     * Return messages current task
     *
     * @param $id
     * @return array|ActiveRecord[]
     */

    public function actionTask($id): array
    {
        return MessageExtension::find()->where(['task_id' => $id])->all();
    }
}
