<?php

namespace common\models;

use Exception;
use frontend\forms\CompleteTaskForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $description
 * @property int|null $task_id
 * @property integer|null $executor_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $rating
 *
 * @property User $user
 * @property Task $task
 */
class Comment extends ActiveRecord
{
    const MESSAGE_FAILED = 'Задание провалено';
    const RATING_DEFAULT = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'rating'], 'safe'],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']
            ],
            [
                ['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::class,
                'targetAttribute' => ['task_id' => 'id']
            ],
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
            'description' => 'Description',
            'task_id' => 'Task ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
    public function getExecutor()
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
     * @param Task $task
     * @throws Exception
     */

    public static function createFailedComment(Task $task)
    {
        $comment = new self();

        $comment->task_id = $task->id;
        $comment->user_id = $task->user_id;
        $comment->executor_id = $task->executor_id;
        $comment->description = self::MESSAGE_FAILED;
        $comment->rating = self::RATING_DEFAULT;

        if (!$comment->save()) {
            throw new Exception('Не удалось сохранить комментарий');
        }
    }

    /**
     * @param Task $task
     * @param CompleteTaskForm $form
     * @throws Exception
     */

    public static function createCompleteComment(Task $task, CompleteTaskForm $form): void
    {
        $comment = new self();
        $comment->attributes = $form->attributes;

        $comment->task_id = $task->id;
        $comment->user_id = $task->user_id;
        $comment->executor_id = $task->executor_id;

        if (!$comment->save()) {
            throw new Exception('Не удалось сохранить комментарий');
        }
    }

    /**
     * @param $id
     * @return int|mixed
     */

    public static function getRating($id)
    {
        $rating = self::find()
            ->select(['executor_id', 'rating' => 'avg(rating)'])
            ->groupBy('executor_id')
            ->where(['executor_id' => $id])
            ->asArray(true)->all();

        if (!empty($rating)) {
            return $rating[0]['rating'];
        } else {
            return 0;
        }
    }
}
