<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $username;
    public $first_name;
    public $last_name;
    public $patronymic;
    public $email;
    public $phone;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['username', 'first_name', 'last_name', 'email', 'password', 'password_repeat'], 'required'],
            [['username', 'email'], 'unique', 'targetClass' => User::class],
            ['email', 'email'],
            ['phone', 'string', 'max' => 20],
            ['patronymic', 'string', 'max' => 100],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Логин должен содержать только латиницу и цифры' ],
            ['first_name', 'match', 'pattern' => '/^[а-яА-ЯёЁ\s]+$/u', 'message' => 'Имя должно содержать только символы кириллицы'],
            ['last_name', 'match', 'pattern' => '/^[а-яА-ЯёЁ\s]+$/u', 'message' => 'Фамилия должно содержать только символы кириллицы'],
            ['patronymic', 'match', 'pattern' => '/^[а-яА-ЯёЁ\s]+$/u', 'message' => 'Отчество должно содержать только символы кириллицы'],
            //['phone', 'match', 'pattern' => '/^+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/', 'message' => 'Телефон должен быть в виде: 8(XXX)XXX-XX-XX'],
        ];
    }

        public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Имя пользователя'),
            'first_name' => Yii::t('app', 'Имя'),
            'last_name' => Yii::t('app', 'Фамилия'),
            'patronymic' => Yii::t('app', 'Отчество'),
            'email' => Yii::t('app', 'Почта'),
            'password' => Yii::t('app', 'Пароль'),
            'password_repeat' => Yii::t('app', 'Повтор пароля'),
            'phone' => Yii::t('app', 'Телефон'),
        ];
    }

    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->patronymic = $this->patronymic;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->role = 'user';
            return $user->save();
        }
        return false;
    }
}