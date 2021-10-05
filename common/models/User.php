<?php

namespace common\models;

use Exception;
use phpDocumentor\Reflection\Types\Integer;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $full_name
 * @property string|null $email
 * @property int|null $role_id
 * @property int|null $city_id
 * @property int|null $user_status_id
 * @property string $date_birth
 * @property string|null $about
 * @property string $password
 * @property int|null $phone
 * @property string|null $skype
 * @property string|null $messenger
 * @property double $rating
 * @property bool $hidden
 * @property double $view_only_customer
 * @property string $avatar
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CategoryExecutor[] $categoryExecutors
 * @property Comment[] $comments
 * @property Comment[] $comments0
 * @property Message[] $messages
 * @property Notice[] $notices
 * @property Response[] $responses
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property City $city
 * @property Role $role
 * @property UserStatus $userStatus
 * @property UserSettings[] $userSettings
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const ADMIN = 1;
    public const CUSTOMER = 2;
    public const EXECUTOR = 3;
    public const MAX_RATING = 5;
    public const RATING_DEFAULT = 0;

    public $specials;
    public $settings;

    public function init()
    {
        $this->rating = self::RATING_DEFAULT;
        $this->role_id = self::CUSTOMER;
        $this->hidden = 0;
        $this->view_only_customer = 0;
        $this->user_status_id = 1;
        parent::init();
    }

    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @param int|string $id
     * @return User|IdentityInterface|null
     */

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @param null $names
     * @param array $except
     * @return array
     */

    public function getAttributes($names = null, $except = [])
    {
        $currentColumns = array_keys($this->fields());
        return parent::getAttributes($currentColumns, $except); // TODO: Change the autogenerated stub
    }

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
        $this->specials = ArrayHelper::map($this->categoryExecutors, 'id', 'category_id');
        $this->settings = ArrayHelper::map($this->userSettings, 'id', 'notice_category_id');
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function setHash()
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'password', 'rating', 'hidden', 'view_only_customer'], 'required'],
            [['role_id', 'city_id', 'user_status_id', 'phone'], 'integer'],
            [['date_birth', 'created_at', 'updated_at', 'rating', 'specials', 'settings'], 'safe'],
            [['about', 'avatar'], 'string'],
            [['full_name', 'email', 'password', 'skype', 'messenger'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
            [['user_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserStatus::class, 'targetAttribute' => ['user_status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Имя',
            'email' => 'Электронная почта',
            'role_id' => 'Role ID',
            'city_id' => 'Город',
            'user_status_id' => 'User Status ID',
            'date_birth' => 'Дата рождения',
            'about' => 'Информация о себе',
            'password' => 'Password',
            'phone' => 'Телефон',
            'skype' => 'Skype',
            'rating' => 'Рейдинг',
            'messenger' => 'Messenger',
            'hidden' => 'Показывать мои контакты только заказчику',
            'view_only_customer' => 'Не показывать мой профиль',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields(); // TODO: Change the autogenerated stub
        unset($fields['password']);

        return $fields;
    }

    /**
     * @return ActiveQuery
     */
    public function getPhotoJobs()
    {
        return $this->hasMany(PhotoJob::class, ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategoryExecutors()
    {
        return $this->hasMany(CategoryExecutor::class, ['user_id' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('categoryExecutor');
    }

    /**
     * @return ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::class, ['sender' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Message::class, ['recipient' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::class, ['user_id' => 'id']);
    }

    /**
     * @param $taskId
     * @return bool
     */

    public function isRespondedByTask($taskId)
    {
        return $this->hasMany(Response::class, ['user_id' => 'id'])->where(['task_id' => $taskId])->exists();
    }

    /**
     * @return ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Task::class, ['executor_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
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
    public function getNotices()
    {
        return $this->hasMany(Notice::class, ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUserSettings()
    {
        return $this->hasMany(UserSettings::class, ['user_id' => 'id']);
    }

    public function getSettings()
    {
        return $this->hasMany(NoticeCategory::class, ['notice_category_id' => 'id'])->via('userSettings');
    }

    /**
     * @return ActiveQuery
     */
    public function getUserStatus()
    {
        return $this->hasOne(UserStatus::class, ['id' => 'user_status_id']);
    }

    /**
     * @return bool
     */

    public function isAdmin()
    {
        return $this->role_id === self::ADMIN;
    }

    /**
     * @return bool
     */

    public function isCustomer()
    {
        return $this->role_id === self::CUSTOMER;
    }

    /**
     * @return bool
     */

    public function isExecutor()
    {
        return $this->role_id === self::EXECUTOR;
    }

    /**
     * @param $rating
     * @throws Exception
     */

    public function setRating($rating)
    {
        $this->rating = $rating;

        if (!$this->save()) {
            throw new Exception('Rating has been successfully updated');
        }
    }

    /**
     * @param integer $id
     * @param string $name
     * @param string $avatar
     * @throws Exception
     */

    public static function createNewAuthVk(Integer $id, string $name, string $avatar)
    {
        $user = new self();
        $user->id = $id;
        $user->full_name = $name;
        $user->city_id = 1;
        $user->avatar = $avatar;
        $user->password = Yii::$app->security->generatePasswordHash(Yii::$app->security->generateRandomString(10));

        if (!$user->save()) {
            throw new Exception('User creation failed');
        }
    }

    /**
     * Create new user
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public static function create(array $attributes): bool
    {
        $user = new self($attributes);
        $user->setHash();
        if ($user->save()) {
            return true;
        } else {
            throw new \Exception('User creation failed');
        }
    }
}
