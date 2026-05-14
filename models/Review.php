<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $booking_id
 * @property int $rating
 * @property string|null $comment
 * @property string $created_at
 *
 * @property Booking $booking
 */
class Review extends ActiveRecord
{
    public static function tableName()
    {
        return 'reviews';
    }

    public function rules()
    {
        return [
            [['booking_id', 'rating'], 'required'],
            [['booking_id', 'rating'], 'integer'],
            [['rating'], 'in', 'range' => [1,2,3,4,5]],
            [['comment'], 'string'],
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
            'rating' => Yii::t('app', 'Оценка'),
            'comment' => Yii::t('app', 'Комментарий'),
            'created_at' => Yii::t('app', 'Дата'),
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