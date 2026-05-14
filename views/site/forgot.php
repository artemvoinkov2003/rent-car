<?php

/** @var yii\web\View $this */
/** @var app\models\ChangePasswordForm $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Смена пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-forgot min-h-screen flex items-center justify-center bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-light-bg p-10 rounded-xl shadow-strong fade-in">
        <div>
            <h2 class="mt-6 text-center text-3xl font-bold text-sport-red font-outfit">
                <?= Html::encode($this->title) ?>
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600 font-lexend">
                Введите текущий и новый пароль
            </p>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'change-password-form',
            'options' => ['class' => 'mt-8 space-y-6'],
        ]); ?>

        <?= $form->field($model, 'old_password')->passwordInput(['placeholder' => 'Текущий пароль']) ?>

        <?= $form->field($model, 'new_password')->passwordInput(['placeholder' => 'Новый пароль']) ?>

        <?= $form->field($model, 'confirm_password')->passwordInput(['placeholder' => 'Подтверждение']) ?>

        <div>
            <?= Html::submitButton('Изменить пароль', [
                'class' => 'w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>