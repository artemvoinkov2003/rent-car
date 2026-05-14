<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "payments".
 *
 * @property int $id
 * @property int $booking_id
 * @property float $amount
 * @property string|null $payment_method
 * @property string $status
 * @property string|null $transaction_id
 * @property string $created_at
 *
 * @property Booking $booking
 */
class Payment extends ActiveRecord
{
    public static function tableName()
    {
        return 'payments';
    }

    public function rules()
    {
        return [
            [['booking_id', 'amount'], 'required'],
            [['booking_id'], 'integer'],
            [['amount'], 'number'],
            [['status'], 'in', 'range' => ['pending', 'paid', 'failed']],
            [['payment_method', 'transaction_id'], 'string', 'max' => 50],
            [['created_at'], 'safe'],
            [['booking_id'], 'exist', 'skipOnError' => true, 'targetClass' => Booking::class, 'targetAttribute' => ['booking_id' => 'id']],
            [['booking_id'], 'unique'], 
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'booking_id' => Yii::t('app', 'Бронирование'),
            'amount' => Yii::t('app', 'Сумма'),
            'payment_method' => Yii::t('app', 'Способ оплаты'),
            'status' => Yii::t('app', 'Статус'),
            'transaction_id' => Yii::t('app', 'ID транзакции'),
            'created_at' => Yii::t('app', 'Дата оплаты'),
        ];
    }

    /**
     * Gets query for [[Booking]].
     */
    public function getBooking()
    {
        return $this->hasOne(Booking::class, ['id' => 'booking_id']);
    }
}