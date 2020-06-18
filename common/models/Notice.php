<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notice".
 *
 * @property int $id
 * @property string|null $message
 * @property int $notice_category_id
 * @property int $user_id
 * @property bool visible
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property NoticeCategory $noticeCategory
 * @property User $user
 */
class Notice extends ActiveRecord
{
    public $class = [
        '1' => 'lightbulb__new-task--message',
        '2' => 'lightbulb__new-task--executor',
        '3' => 'lightbulb__new-task--close'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['notice_category_id', 'user_id'], 'required'],
            [['notice_category_id', 'user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['notice_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => NoticeCategory::class, 'targetAttribute' => ['notice_category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'notice_category_id' => 'Notice Category ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getNoticeCategory()
    {
        return $this->hasOne(NoticeCategory::class, ['id' => 'notice_category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return bool
     */

    public function disable()
    {
        $this->visible = false;
        return $this->save();
    }

    /**
     * @param $id
     * @return bool
     */

    public static function getVisibleNoticesByUser($id)
    {
        return self::find()
            ->where([
                'visible' => true,
                'user_id' => $id
            ])
            ->exists();
    }
}
