<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\Booking $model */

$this->title = 'Редактирование бронирования';
$this->params['breadcrumbs'][] = ['label' => 'Бронирования', 'url' => ['bookings']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-booking-form bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <div class="max-w-2xl mx-auto">
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'status')->dropDownList([
                    'pending' => 'Ожидает',
                    'confirmed' => 'Подтверждено',
                    'cancelled' => 'Отменено',
                    'completed' => 'Завершено',
                ], ['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>

                <div class="mt-6">
                    <?= Html::submitButton('Сохранить', ['class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>