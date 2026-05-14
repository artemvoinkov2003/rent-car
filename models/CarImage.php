<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "car_images".
 *
 * @property int $id
 * @property int $car_id
 * @property string $image_path
 * @property int|null $is_main
 * @property int|null $sort_order
 *
 * @property Car $car
 */
class CarImage extends ActiveRecord
{
    public static function tableName()
    {
        return 'car_images';
    }

    public function rules()
    {
        return [
            [['car_id', 'image_path'], 'required'],
            [['car_id', 'is_main', 'sort_order'], 'integer'],
            [['image_path'], 'string', 'max' => 255],
            [['car_id'], 'exist', 'skipOnError' => true, 'targetClass' => Car::class, 'targetAttribute' => ['car_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'car_id' => Yii::t('app', 'Автомобиль'),
            'image_path' => Yii::t('app', 'Путь к изображению'),
            'is_main' => Yii::t('app', 'Главное'),
            'sort_order' => Yii::t('app', 'Порядок сортировки'),
        ];
    }

    /**
     * Gets query for [[Car]].
     */
    public function getCar()
    {
        return $this->hasOne(Car::class, ['id' => 'car_id']);
    }
}