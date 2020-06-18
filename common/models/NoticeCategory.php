<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notice_category".
 *
 * @property int $id
 * @property string $name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Notice[] $notices
 * @property UserSettings[] $userSettings
 */
class NoticeCategory extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notice_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getNotices()
    {
        return $this->hasMany(Notice::class, ['notice_category_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUserSettings()
    {
        return $this->hasMany(UserSettings::class, ['notice_category_id' => 'id']);
    }

    /**
     * @param $id
     * @return string
     */
}
