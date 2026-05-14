<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['users']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-user-form bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <div class="max-w-2xl mx-auto">
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <?php $form = ActiveForm::begin(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?= $form->field($model, 'username')->textInput(['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'email')->textInput(['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'first_name')->textInput(['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'last_name')->textInput(['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'patronymic')->textInput(['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'phone')->textInput(['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($model, 'role')->dropDownList([
                        'user' => 'Пользователь',
                        'owner' => 'Владелец',
                        'admin' => 'Администратор',
                    ], ['class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                </div>

                <div class="mt-6">
                    <?= Html::submitButton('Сохранить', ['class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>