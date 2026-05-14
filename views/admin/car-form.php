<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\CarModel;
use app\models\User;

/** @var app\models\Car $model */

$this->title = $model->isNewRecord ? 'Добавить автомобиль' : 'Редактировать автомобиль';
$this->params['breadcrumbs'][] = ['label' => 'Автомобили', 'url' => ['cars']];
$this->params['breadcrumbs'][] = $this->title;

$models = CarModel::find()->with('brand')->all();
$owners = User::find()->where(['role' => 'owner'])->all();
?>

<div class="admin-car-form bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <div class="max-w-4xl mx-auto">
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?= $form->field($model, 'owner_id')->dropDownList(
                        ArrayHelper::map($owners, 'id', 'username'),
                        ['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']
                    ) ?>

                    <?= $form->field($model, 'model_id')->dropDownList(
                        ArrayHelper::map($models, 'id', function($m) {
                            return $m->brand->name . ' ' . $m->name;
                        }),
                        ['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']
                    ) ?>

                    <?= $form->field($model, 'year')->textInput(['type' => 'number', 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'color')->textInput(['maxlength' => true, 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'license_plate')->textInput(['maxlength' => true, 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'mileage')->textInput(['type' => 'number', 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'price_per_day')->textInput(['type' => 'number', 'step' => '0.01', 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'price_per_hour')->textInput(['type' => 'number', 'step' => '0.01', 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'deposit')->textInput(['type' => 'number', 'step' => '0.01', 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'status')->dropDownList([
                        'available' => 'Доступен',
                        'booked' => 'Занят',
                        'repair' => 'Ремонт',
                    ], ['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'body_type')->dropDownList([
                        'sedan' => 'Седан',
                        'hatchback' => 'Хэтчбек',
                        'suv' => 'Внедорожник',
                        'coupe' => 'Купе',
                        'convertible' => 'Кабриолет',
                        'wagon' => 'Универсал',
                    ], ['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'transmission')->dropDownList([
                        'manual' => 'Механика',
                        'automatic' => 'Автомат',
                        'robotic' => 'Робот',
                        'variator' => 'Вариатор',
                    ], ['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'engine_volume')->textInput(['type' => 'number', 'step' => '0.1', 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'fuel_type')->dropDownList([
                        'petrol' => 'Бензин',
                        'diesel' => 'Дизель',
                        'electric' => 'Электро',
                        'hybrid' => 'Гибрид',
                    ], ['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'drive_type')->dropDownList([
                        'front' => 'Передний',
                        'rear' => 'Задний',
                        'all' => 'Полный',
                    ], ['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                </div>

                <?= $form->field($model, 'description')->textarea(['rows' => 4, 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>

                <div class="mt-6">
                    <?= Html::submitButton('Сохранить', ['class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>