<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_settings".
 *
 * @property int $id
 * @property int $notice_category_id
 * @property int $user_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property NoticeCategory $noticeCategory
 * @property User $user
 */
class UserSettings extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notice_category_id', 'user_id'], 'required'],
            [['notice_category_id', 'user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['notice_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => NoticeCategory::className(), 'targetAttribute' => ['notice_category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
}
