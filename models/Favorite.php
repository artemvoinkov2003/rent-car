<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "favorites".
 *
 * @property int $user_id
 * @property int $car_id
 *
 * @property User $user
 * @property Car $car
 */
class Favorite extends ActiveRecord
{
    public static function tableName()
    {
        return 'favorites';
    }

    public function rules()
    {
        return [
            [['user_id', 'car_id'], 'required'],
            [['user_id', 'car_id'], 'integer'],
            [['user_id', 'car_id'], 'unique', 'targetAttribute' => ['user_id', 'car_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['car_id'], 'exist', 'skipOnError' => true, 'targetClass' => Car::class, 'targetAttribute' => ['car_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'Пользователь'),
            'car_id' => Yii::t('app', 'Автомобиль'),
        ];
    }

    /**
     * Gets query for [[User]].
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Car]].
     */
    public function getCar()
    {
        return $this->hasOne(Car::class, ['id' => 'car_id']);
    }
}