<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "car_features".
 *
 * @property int $id
 * @property string $name
 * @property string|null $icon
 *
 * @property Car[] $cars
 */
class CarFeature extends ActiveRecord
{
    public static function tableName()
    {
        return 'car_features';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['name'], 'string', 'max' => 100],
            [['icon'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Название особенности'),
            'icon' => Yii::t('app', 'Иконка'),
        ];
    }

    /**
     * Gets query for [[Cars]] via many-to-many.
     */
    public function getCars()
    {
        return $this->hasMany(Car::class, ['id' => 'car_id'])
            ->viaTable('car_feature_assignments', ['feature_id' => 'id']);
    }
}