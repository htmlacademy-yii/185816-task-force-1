<?php


namespace frontend\forms;

use yii\base\Model;
use common\models\User;

class SingupForm extends Model
{
    const DEFAULT_ROLE = 2;
    const DEFAULT_STATUS = 1;
    public $email;
    public $full_name;
    public $city_id;
    public $password;
    public $role_id = self::DEFAULT_ROLE;
    public $user_status_id = self::DEFAULT_STATUS;

    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта',
            'full_name' => 'Выше имя',
            'city_id' => 'Город проживания',
            'password' => 'Пароль'
        ];
    }

    public function rules()
    {
        return [
            ['email', 'unique', 'targetClass'=> User::class, 'message' => 'Этот email уже занят'],
            ['email', 'email', 'message' => 'Введите валидный email'],
            ['email', 'required', 'message' => 'Введите валидный email'],
            ['full_name', 'required', 'message' => 'Введите ваше имя и фамилию'],
            ['password', 'required', 'message' => 'Введите пароль'],
            ['password', 'string', 'length' => [8, 50], 'message' => 'Длина пароля от 8 символов'],
            ['city_id', 'required', 'message' => 'Укажите город, чтобы находить подходящие задачи']
        ];
    }
}
