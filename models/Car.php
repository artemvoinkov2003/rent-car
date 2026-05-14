<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "cars".
 *
 * @property int $id
 * @property int $owner_id
 * @property int $model_id
 * @property int|null $year
 * @property string|null $color
 * @property string|null $license_plate
 * @property int|null $mileage
 * @property float|null $price_per_day
 * @property float|null $price_per_hour
 * @property float|null $deposit
 * @property string $status
 * @property string|null $description
 * @property int|null $views
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $owner
 * @property CarModel $model
 * @property CarImage[] $carImages
 * @property Booking[] $bookings
 * @property Review[] $reviews
 * @property CarFeature[] $features
 */
class Car extends ActiveRecord
{

    public $imageFiles;
    public static function tableName()
    {
        return 'cars';
    }

    public function rules()
    {
        return [
            [['owner_id', 'model_id'], 'required'],
            [['owner_id', 'model_id', 'year', 'mileage', 'views'], 'integer'],
            [['price_per_day', 'price_per_hour', 'deposit'], 'number'],
            [['status'], 'in', 'range' => ['available', 'booked', 'repair']],
            [['description'], 'string'],
            [['color', 'license_plate'], 'string', 'max' => 50],
            [['license_plate'], 'unique'],
            [['created_at', 'updated_at'], 'safe'],
            [['category', 'body_type', 'transmission', 'fuel_type'], 'string'],
            ['engine_volume', 'number'],
            [['drive_type', 'payment_options', 'insurance_options'], 'string'],
            ['fuel_consumption', 'number', 'min' => 1, 'max' => 30],
            ['drive_type', 'in', 'range' => ['rear', 'front', 'all']],
            ['payment_options', 'in', 'range' => ['cash', 'card', 'transfer']],
            ['insurance_options', 'in', 'range' => ['basic', 'full']],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 10, 'skipOnEmpty' => true],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['owner_id' => 'id']],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarModel::class, 'targetAttribute' => ['model_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => Yii::t('app', 'Владелец'),
            'model_id' => Yii::t('app', 'Модель'),
            'year' => Yii::t('app', 'Год выпуска'),
            'color' => Yii::t('app', 'Цвет'),
            'license_plate' => Yii::t('app', 'Госномер'),
            'mileage' => Yii::t('app', 'Пробег'),
            'price_per_day' => Yii::t('app', 'Цена за день'),
            'price_per_hour' => Yii::t('app', 'Цена за час'),
            'deposit' => Yii::t('app', 'Залог'),
            'status' => Yii::t('app', 'Статус'),
            'description' => Yii::t('app', 'Описание'),
            'views' => Yii::t('app', 'Просмотры'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
            'category' => Yii::t('app', 'Категория'),
            'body_type' => Yii::t('app', 'Тип кузова'),
            'transmission' => Yii::t('app', 'Коробка передач'),
            'engine_volume' => Yii::t('app', 'Объём двигателя'),
            'fuel_type' => Yii::t('app', 'Тип топлива'),
            'drive_type' => Yii::t('app', 'Привод'),
            'fuel_consumption' => Yii::t('app', 'Расход топлива (л/100км)'),
            'payment_options' => Yii::t('app', 'Способы оплаты'),
            'insurance_options' => Yii::t('app', 'Страховка'),
            'imageFiles' => Yii::t('app', 'Изображение'),
        ];
    }

    /**
     * Gets query for [[Owner]].
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['id' => 'owner_id']);
    }

    /**
     * Gets query for [[Model]].
     */
    public function getModel()
    {
        return $this->hasOne(CarModel::class, ['id' => 'model_id']);
    }

    /**
     * Gets query for [[CarImages]].
     */
    public function getCarImages()
    {
        return $this->hasMany(CarImage::class, ['car_id' => 'id']);
    }

    /**
     * Gets query for [[Bookings]].
     */
    public function getBookings()
    {
        return $this->hasMany(Booking::class, ['car_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]] via bookings.
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['booking_id' => 'id'])->via('bookings');
    }

    /**
     * Gets query for [[CarFeatures]] via many-to-many relation.
     */
    public function getFeatures()
    {
        return $this->hasMany(CarFeature::class, ['id' => 'feature_id'])
            ->viaTable('car_feature_assignments', ['car_id' => 'id']);
    }

    /**
     * Gets main image if exists.
     */
    public function getMainImage()
    {
        return $this->hasOne(CarImage::class, ['car_id' => 'id'])
            ->andWhere(['is_main' => 1]);
    }
    public function getAvgRating()
    {
        return $this->hasMany(Review::class, ['booking_id' => 'id'])->via('bookings')->average('rating');

    }
    
}