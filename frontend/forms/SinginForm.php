<?php


namespace frontend\forms;

use yii\base\Model;
use common\models\User;

class SinginForm extends Model
{
    public $email;
    public $password;

    private $_user;

    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта',
            'password' => 'Пароль'
        ];
    }

    public function rules()
    {
        return [
            ['email', 'required', 'message' => 'Введите валидный email'],
            ['email', 'exist', 'targetClass' => User::class, 'message' => 'Такого пользователя не существует'],
            ['email', 'email', 'message' => 'Введите валидный email'],
            ['password', 'required', 'message' => 'Введите пароль'],
            ['password', 'validatePassword']
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Вы ввели не верный пароль');
            }
        }
    }

    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }
}
