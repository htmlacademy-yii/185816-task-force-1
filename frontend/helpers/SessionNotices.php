<?php


namespace frontend\helpers;


use Yii;

class SessionNotices
{
    const FLAG_SUCCESS = 'success';
    const FLAG_ERROR = 'error';

    public function __construct($flag, $msg)
    {
        Yii::$app->session->setFlash($flag, $msg);
    }

    /**
     * Create success message for session
     *
     * @param string $msg
     * @return SessionNotices
     */
    public static function createSuccessNotice(string $msg): SessionNotices
    {
        return new self(self::FLAG_SUCCESS, $msg);
    }

    /**
     * Create error message for session
     *
     * @param string $msg
     * @return SessionNotices
     */
    public static function createErrorNotice(string $msg): SessionNotices
    {
        return new self(self::FLAG_ERROR, $msg);
    }
}
