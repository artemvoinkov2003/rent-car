<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Car;

/** @var app\models\CarImage $model */
/** @var app\models\Car[] $cars */

$this->title = $model->isNewRecord ? 'Добавить изображение' : 'Редактировать изображение';
$this->params['breadcrumbs'][] = ['label' => 'Изображения', 'url' => ['car-images']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-car-image-form bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <div class="max-w-2xl mx-auto">
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'car_id')->dropDownList(
                    ArrayHelper::map($cars, 'id', function($car) {
                        return $car->model->brand->name . ' ' . $car->model->name;
                    }),
                    ['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']
                ) ?>

                <?= $form->field($model, 'image_path')->textInput([
                    'maxlength' => true, 
                    'placeholder' => '/uploads/cars/example.jpg',
                    'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend'
                ]) ?>

                <?= $form->field($model, 'is_main')->checkbox([
                    'class' => 'rounded border-sport-red text-sport-red focus:ring-sport-red mr-2'
                ]) ?>

                <?= $form->field($model, 'sort_order')->textInput([
                    'type' => 'number',
                    'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend'
                ]) ?>

                <div class="mt-6">
                    <?= Html::submitButton('Сохранить', ['class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>