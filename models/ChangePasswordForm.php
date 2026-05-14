<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $old_password;
    public $new_password;
    public $confirm_password;

    public function rules()
    {
        return [
            [['old_password', 'new_password', 'confirm_password'], 'required'],
            ['new_password', 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password'],
            ['old_password', 'validateOldPassword'],
        ];
    }

    public function validateOldPassword($attribute, $params)
    {
        $user = Yii::$app->user->identity;
        if (!$user || !$user->validatePassword($this->old_password)) {
            $this->addError($attribute, 'Неверный текущий пароль.');
        }
    }

    public function changePassword()
    {
        if ($this->validate()) {
            $user = Yii::$app->user->identity;
            $user->setPassword($this->new_password);
            $user->generateAuthKey();
            return $user->save();
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'old_password' => 'Текущий пароль',
            'new_password' => 'Новый пароль',
            'confirm_password' => 'Подтверждение пароля',
        ];
    }
}