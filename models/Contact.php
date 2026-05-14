<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "contacts".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string $message
 * @property string $created_at
 */
class Contact extends ActiveRecord
{
    public static function tableName()
    {
        return 'contacts';
    }

    public function rules()
    {
        return [
            [['name', 'email', 'message'], 'required'],
            ['email', 'email'],
            ['phone', 'string', 'max' => 20],
            [['name', 'email', 'message'], 'string', 'max' => 255],
            ['message', 'string', 'min' => 10],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'message' => 'Сообщение',
            'created_at' => 'Дата отправки',
        ];
    }
}