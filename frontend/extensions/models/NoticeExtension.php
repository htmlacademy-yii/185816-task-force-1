<?php

namespace frontend\extensions\models;

use common\models\Notice;
use Yii;
use yii\db\Exception;
use yii\helpers\Url;

class NoticeExtension extends Notice
{
    /**
     * Category email message
     */
    const CATEGORY_MESSAGE = 1;
    const CATEGORY_ACTION = 2;
    const CATEGORY_RESPONSE = 3;

    /**
     * Relations category to message
     */
    const messageMap = [
        self::CATEGORY_RESPONSE => '@frontend/mail/response-html',
        self::CATEGORY_ACTION => '@frontend/mail/action-html',
        self::CATEGORY_MESSAGE => '@frontend/mail/message-html'
    ];

    const FROM = 'task-force@academy.ru';
    protected $taskID;

    public $class = [
        '1' => 'lightbulb__new-task--message',
        '2' => 'lightbulb__new-task--executor',
        '3' => 'lightbulb__new-task--close'
    ];

    /**
     * Add status disable
     *
     * @param Notice $notice
     * @return bool
     */

    public static function hidden(Notice $notice): bool
    {
        $notice->visible = false;
        return $notice->save();
    }

    /**
     * Get visible notice current user
     *
     * @param $id
     * @return bool
     */

    public static function getVisibleNoticesByUser($id): bool
    {
        return self::find()
            ->where([
                'visible' => true,
                'user_id' => $id
            ])
            ->exists();
    }

    /**
     * @param int $userID
     * @param int $categoryID
     * @param int $taskID
     * @throws Exception
     * @throws \Exception
     */
    public static function create(int $userID, int $categoryID, int $taskID)
    {
        $notice = new self([
            'user_id' => $userID,
            'visible' => true,
            'notice_category_id' => $categoryID,
            'message' => Yii::$app->urlManager->createUrl(['tasks/view', 'id' => $taskID])
        ]);

        if($notice->save()) {
            $notice->send($taskID, $categoryID);
        } else {
            throw new Exception('Notice not saved');
        }
    }

    /**
     * Sending message
     *
     * @param int $taskID
     * @param int $categoryID
     * @return bool
     * @throws \Exception
     */
    protected function send(int $taskID, int $categoryID): bool
    {
        $message = Yii::$app->mailer->compose(self::messageMap[$categoryID], [
            'user' => $this->user,
            'taskID' => $taskID
        ])
            ->setFrom(self::FROM)
            ->setTo($this->user->email)
            ->setSubject($this->noticeCategory->name);

        if($message->send()) {
            return true;
        } else {
            throw new \Exception('Mail is not send');
        }
    }
}
