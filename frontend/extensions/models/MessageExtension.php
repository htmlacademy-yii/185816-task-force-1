<?php


namespace frontend\extensions\models;


use common\models\Message;
use Yii;

class MessageExtension extends Message
{

    /**
     * Send message to recipient, before save Message
     *
     * @param bool $insert
     * @param array $changedAttributes
     */

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        try {
            NoticeExtension::create(
                Yii::$app->request->post('recipient'),
                NoticeExtension::CATEGORY_MESSAGE,
                Yii::$app->request->post('task_id')
            );
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
