<?php


namespace frontend\forms;


use common\models\City;
use common\models\UploadFileTrait;
use common\models\User;
use yii\base\Model;


class UserSettingsForm extends Model
{
    use UploadFileTrait;

    public $full_name;
    public $email;
    public $city_id;
    public $date_birth;
    public $about;
    public $password_new;
    public $password_verify;
    public $phone;
    public $skype;
    public $messenger;
    public $specials;
    public $settings;
    public $hidden;
    public $view_only_customer;
    public $avatar;
    public $image;
    protected $dir = 'upload/';

    public function rules()
    {
        return [
            [['full_name', ], 'required'],
            [['city_id',], 'integer'],
            [['date_birth', 'settings','specials', 'hidden', 'view_only_customer', 'avatar', 'photos', 'phone'], 'safe'],
            [['about', 'avatar'], 'string'],
            [['full_name', 'email', 'skype', 'messenger'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
            [['image'], 'file', 'message' => 'Изображение должно иметь формат jpg, png, jpeg', 'extensions' => ['png', 'jpg', 'jpeg'],
                'maxSize' => 1024 * 1024],
            [['password_new',  'password_verify'], 'string', 'min' => 8]
        ];
    }

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
            'password' => 'Новый пароль',
            'password_new' => 'Новый пароль',
            'password_verify' => 'Подтвердите пароль',
            'phone' => 'Телефон',
            'specials' => 'Специализации',
            'skype' => 'Skype',
            'notice' => 'Уведомления',
            'hidden' => 'Показывать мои контакты только заказчику',
            'view_only_customer' => 'Не показывать мой профиль',
            'settings' => 'Настройки',
            'messenger' => 'Messenger',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @param User $user
     * @return UserSettingsForm
     */

    public static function create(User $user): UserSettingsForm
    {
        $form = new self;
        $form->attributes = $user->getAttributes();
        $form->specials = $user->specials;
        $form->settings = $user->settings;

        return $form;
    }

    public function load($data, $formName = null)
    {
        if (parent::load($data, $formName)) {
            return $this->avatar = $this->upload($this, 'image', $this->avatar);
        }
        return false;
    }
}
