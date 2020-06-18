<?php

namespace common\models;

use common\models\TaskModelTrait;
use frontend\forms\CreateTaskForm;
use frontend\services\LocationService;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $category_id
 * @property string|null $title
 * @property string|null $description
 * @property int $city_id
 * @property int $user_id
 * @property int|null $executor_id
 * @property int|null $budget
 * @property string $location
 * @property string $address
 * @property string $deadline
 * @property int $status_id
 * @property string|null $file
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Comment[] $comments
 * @property Message[] $messages
 * @property Message[] $messages0
 * @property Response[] $responses
 * @property Category $category
 * @property City $city
 * @property User $executor
 * @property Status $status
 * @property User $user
 */
class Task extends ActiveRecord
{

    use TaskModelTrait;

    public const STATUS_DEFAULT = 5;
    public const STATUS_WORK = 1;
    public const STATUS_FAILED = 3;
    public const STATUS_COMPLETE = 2;
    public const STATUS_CANCELED = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'city_id', 'user_id', 'status_id', 'location', 'address'], 'required'],
            [['category_id', 'user_id', 'executor_id', 'budget', 'status_id'], 'integer'],
            [['description', 'location'], 'string'],
            [['deadline', 'created_at', 'updated_at'], 'safe'],
            [['title', 'file'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['executor_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
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
            'category_id' => 'Category ID',
            'title' => 'Title',
            'description' => 'Description',
            'city_id' => 'City ID',
            'user_id' => 'User ID',
            'executor_id' => 'Executor ID',
            'budget' => 'Budget',
            'deadline' => 'Deadline',
            'status_id' => 'Status ID',
            'file' => 'File',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['task_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::class, ['recipient' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Message::class, ['task_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::class, ['task_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::class, ['id' => 'executor_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function init()
    {
        $this->status_id = self::STATUS_DEFAULT;
    }

    /**
     * @return int
     */

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getExecutorId()
    {
        return $this->executor_id;
    }

    /**
     * @return int
     */

    public function getStatusId(): int
    {
        return $this->status_id;
    }

    /**
     * @return bool
     */
    public function isDefaultStatus(): bool
    {
        return $this->status_id === self::STATUS_DEFAULT;
    }

    /***
     * @return bool
     */

    public function isWorkStatus(): bool
    {
        return $this->status_id === self::STATUS_WORK;
    }

    /***
     * @return bool
     */

    public function isNewStatus(): bool
    {
        return $this->status_id === self::STATUS_DEFAULT;
    }

    /***
     * @return bool
     */

    public function isFailedStatus(): bool
    {
        return $this->status_id === self::STATUS_FAILED;
    }

    /***
     * @param User $executor
     * @return bool
     */

    public function changeStatusWork(User $executor): bool
    {
        $this->status_id = Task::STATUS_WORK;
        $this->executor_id = $executor->id;

        return $this->save();
    }

    /**
     * @return bool
     */
    public function changeStatusFailed(): bool
    {
        $this->status_id = Task::STATUS_FAILED;
        return $this->save();
    }

    /***
     * @return bool
     */

    public function changeStatusCanceled(): bool
    {
        $this->status_id = Task::STATUS_CANCELED;

        return $this->save();
    }

    /***
     * @return bool
     */

    public function changeStatusCompleted(): bool
    {
        $this->status_id = Task::STATUS_COMPLETE;

        return $this->save();
    }

    /****
     * @param User $user
     * @return bool
     */

    public function isUserOwner(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    /**
     * @param User $user
     * @return bool
     */

    public function isUserExecutor(User $user): bool
    {
        return $this->executor_id === $user->id;
    }

    public function getLocation()
    {
        return array_reverse(explode(' ', str_replace('"', '', $this->location)));
    }

    /**
     * @param CreateTaskForm $form
     * @param User $user
     * @param LocationService $location
     * @throws InvalidConfigException
     * @throws \Exception
     */

    static function createTask(CreateTaskForm $form, User $user, LocationService $location)
    {
        $task = new self();
        $coords = $location->getCoords($form->address);

        $task->attributes = $form->attributes;
        $task->user_id = $user->id;
        $task->city_id = $user->city->id;
        $task->deadline = Yii::$app->formatter->asDate($task->deadline, 'php:Y-m-d');
        $task->file = $form->upload();
        $task->location = $coords;

        if (!$task->save()) {
            throw new \Exception('Задание не сохранено');
        }
    }
}
