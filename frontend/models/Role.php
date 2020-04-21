<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property string|null $role
 * @property string|null $actions
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User[] $users
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actions'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['role'], 'string', 'max' => 255],
            [['role'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Role',
            'actions' => 'Actions',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['role_id' => 'id']);
    }
}
