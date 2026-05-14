<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "car_brands".
 *
 * @property int $id
 * @property string $name
 * @property string|null $logo
 * @property string|null $description
 *
 * @property CarModel[] $carModels
 */
class CarBrand extends ActiveRecord
{
    public static function tableName()
    {
        return 'car_brands';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['logo'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Название бренда'),
            'logo' => Yii::t('app', 'Логотип'),
            'description' => Yii::t('app', 'Описание'),
        ];
    }

    /**
     * Gets query for [[CarModels]].
     */
    public function getCarModels()
    {
        return $this->hasMany(CarModel::class, ['brand_id' => 'id']);
    }
}