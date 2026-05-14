<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "car_models".
 *
 * @property int $id
 * @property int $brand_id
 * @property string $name
 * @property int|null $year_start
 * @property int|null $year_end
 *
 * @property CarBrand $brand
 * @property Car[] $cars
 */
class CarModel extends ActiveRecord
{
    public static function tableName()
    {
        return 'car_models';
    }

    public function rules()
    {
        return [
            [['brand_id', 'name'], 'required'],
            [['brand_id', 'year_start', 'year_end'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarBrand::class, 'targetAttribute' => ['brand_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => Yii::t('app', 'Бренд'),
            'name' => Yii::t('app', 'Название модели'),
            'year_start' => Yii::t('app', 'Год начала выпуска'),
            'year_end' => Yii::t('app', 'Год окончания выпуска'),
        ];
    }

    /**
     * Gets query for [[Brand]].
     */
    public function getBrand()
    {
        return $this->hasOne(CarBrand::class, ['id' => 'brand_id']);
    }

    /**
     * Gets query for [[Cars]].
     */
    public function getCars()
    {
        return $this->hasMany(Car::class, ['model_id' => 'id']);
    }
}