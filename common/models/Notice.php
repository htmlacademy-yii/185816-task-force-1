<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'notice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
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
    public function attributeLabels(): array
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
    public function getNoticeCategory(): ActiveQuery
    {
        return $this->hasOne(NoticeCategory::class, ['id' => 'notice_category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
