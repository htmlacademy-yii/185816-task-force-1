<?php

namespace common\models;

use common\models\ResponseModelTrait;
use Exception;
use frontend\forms\NewResponseForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "response".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $amount
 * @property string|null $message
 * @property int|null $task_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 *
 * @property User $user
 * @property Task $task
 */

class Response extends ActiveRecord
{
    use ResponseModelTrait;

    const STATUS_ACTIVE = 'active';
    const STATUS_DISABLED = 'disabled';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'response';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'task_id'], 'integer'],
            ['message', 'string'],
            [['created_at', 'updated_at', 'status', 'message'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'amount' => 'Amount',
            'task_id' => 'Task ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function init()
    {
        $this->status = self::STATUS_ACTIVE;
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    /***
     * @return bool
     */

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /***
     * @return bool
     */

    public function isDisabled()
    {
        return $this->status === self::STATUS_DISABLED;
    }

    /**
     * @param Response $response
     * @param User $currentUser
     * @throws Exception
     */

    public static function blockedResponse(Response $response ,User $currentUser): void
    {
        if ($response->task->user_id !== $currentUser->id) {
            throw new Exception('Вы не владелец текущего задания');
        }

        if ($currentUser->isExecutor()) {
            throw new Exception('У вас не достаточно прав');
        }

        $response->status = $response::STATUS_DISABLED;

        if (!$response->save()) {
            throw new Exception('Отклик не был сохранен');
        }
    }

    /**
     * @param Task $task
     * @param User $currentUser
     * @param NewResponseForm $form
     * @throws Exception
     */

    public static function createResponse(Task $task, User $currentUser,  NewResponseForm $form): void
    {
        $response = new self();

        $response->attributes = $form->attributes;
        $response->task_id = $task->id;
        $response->user_id = $currentUser->id;

        if ($currentUser->isCustomer()) {
            throw new \Exception('Только испольнитель может оставлять отклик');
        }

        if ($task->isUserOwner($currentUser)) {
            throw new \Exception('Вы не можете быть исполнителем своего задания');
        }

        if(self::findOne(['user_id' => $currentUser->id, 'task_id' => $task->id]) !== null) {
            throw new \Exception('Вы уже отликались на текущее задание');
        }

        if (!$response->save()) {
            throw new \Exception('Отклик не был сохранен');
        }
    }

    /**
     * @param $id
     * @return int
     */
    public static function getCountActiveByTaskId($id)
    {
        return count(self::find()->where(['task_id' => $id, 'status' => 'active'])->all());
    }

    public static function getResponedUserByTaskId($taskId, $userId)
    {
        return self::find()->where(['task_id' => $taskId, 'user_id' => $userId])->exists();
    }
}
