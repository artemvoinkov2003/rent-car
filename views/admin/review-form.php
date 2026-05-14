<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\Review $model */

$this->title = 'Редактирование отзыва';
$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['reviews']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-review-form bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <div class="max-w-2xl mx-auto">
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <?php $form = ActiveForm::begin(); ?>

                <div class="mb-4">
                    <p class="text-sm font-lexend text-gray-600">
                        Автомобиль: <strong><?= Html::encode($model->booking->car->model->brand->name . ' ' . $model->booking->car->model->name) ?></strong><br>
                        Пользователь: <strong><?= Html::encode($model->booking->user->username) ?></strong>
                    </p>
                </div>

                <?= $form->field($model, 'rating')->textInput(['type' => 'number', 'min' => 1, 'max' => 5, 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>

                <?= $form->field($model, 'comment')->textarea(['rows' => 5, 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>

                <div class="mt-6">
                    <?= Html::submitButton('Сохранить', ['class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>