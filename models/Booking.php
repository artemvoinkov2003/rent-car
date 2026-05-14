<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "bookings".
 *
 * @property int $id
 * @property int $car_id
 * @property int $user_id
 * @property string $start_date
 * @property string $end_date
 * @property float $total_price
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Car $car
 * @property User $user
 * @property Payment|null $payment
 * @property Review|null $review
 */
class Booking extends ActiveRecord
{
    public static function tableName()
    {
        return 'bookings';
    }

    public function rules()
    {
        return [
            [['car_id', 'user_id', 'start_date', 'end_date', 'total_price'], 'required'],
            [['car_id', 'user_id'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['total_price'], 'number'],
            [['status'], 'in', 'range' => ['pending', 'confirmed', 'cancelled', 'completed']],
            [['car_id'], 'exist', 'skipOnError' => true, 'targetClass' => Car::class, 'targetAttribute' => ['car_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['driver_name', 'driver_phone', 'driver_email'], 'string', 'max' => 255],
            ['driver_email', 'email'],
            [['need_child_seat', 'need_navigator', 'need_extra_insurance'], 'boolean'],
            [['driver_license_series', 'driver_license_number', 'driver_license_issued_by', 'driver_license_issue_date', 'insurance_type', 'terms_accepted'], 'required'],
            ['driver_license_series', 'string', 'max' => 4],
            ['driver_license_number', 'string', 'max' => 6],
            ['driver_license_issue_date', 'date', 'format' => 'php:Y-m-d'],
            ['insurance_type', 'in', 'range' => ['basic', 'extended']],
            ['insurance_company', 'string', 'max' => 100],
            ['insurance_policy_number', 'string', 'max' => 50],
            ['terms_accepted', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'car_id' => Yii::t('app', 'Автомобиль'),
            'user_id' => Yii::t('app', 'Арендатор'),
            'start_date' => Yii::t('app', 'Дата начала'),
            'end_date' => Yii::t('app', 'Дата окончания'),
            'total_price' => Yii::t('app', 'Общая стоимость'),
            'status' => Yii::t('app', 'Статус'),
            'driver_name' => 'Имя водителя',
            'driver_phone' => 'Телефон',
            'driver_email' => 'Почта',
            'need_child_seat' => 'Детское кресло',
            'need_navigator' => 'Навигатор',
            'need_extra_insurance' => 'Расширенная страховка',
            'driver_license_series' => 'Серия ВУ',
            'driver_license_number' => 'Номер ВУ',
            'driver_license_issued_by' => 'Кем выдано',
            'driver_license_issue_date' => 'Дата выдачи',
            'insurance_type' => 'Тип страховки',
            'insurance_company' => 'Страховая компания',
            'insurance_policy_number' => 'Номер полиса',
            'terms_accepted' => 'Я согласен с условиями аренды',
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
        ];
    }

    /**
     * Gets query for [[Car]].
     */
    public function getCar()
    {
        return $this->hasOne(Car::class, ['id' => 'car_id']);
    }

    /**
     * Gets query for [[User]].
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Payment]].
     */
    public function getPayment()
    {
        return $this->hasOne(Payment::class, ['booking_id' => 'id']);
    }

    /**
     * Gets query for [[Review]].
     */
    public function getReview()
    {
        return $this->hasOne(Review::class, ['booking_id' => 'id']);
    }
}