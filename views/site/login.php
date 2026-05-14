<?php

/** @var yii\web\View $this */
/** @var app\models\LoginForm $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="auth-double-triangle">
    <div class="left"></div>
    <div class="right"></div>
</div>

<div class="site-login min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
     
        <div class="w-full h-1.5 bg-gradient-to-r from-sport-red to-sport-dark-blue rounded-t-2xl"></div>

        <div class="bg-white border border-sport-dark-blue rounded-b-2xl shadow-2xl overflow-hidden">
            <div class="p-8 md:p-10">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-sport-red/10 rounded-full mb-4">
                        <i class="fas fa-car text-2xl text-sport-red"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-sport-dark-blue font-outfit">
                        Добро пожаловать!
                    </h2>
                    <p class="mt-2 text-sm text-sport-red font-lexend">Войдите в свой аккаунт</p>
                </div>

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'space-y-6'],
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => ['class' => 'block text-sm font-medium text-gray-700 font-lexend mb-1'],
                        'inputOptions' => ['class' => 'w-full px-4 py-3 pl-12 rounded-xl border border-sport-dark-blue focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all duration-200 font-lexend hover:border-sport-red'],
                        'errorOptions' => ['class' => 'text-red-500 text-sm mt-1 font-lexend'],
                    ],
                ]); ?>

                <div class="relative">
                    <?= $form->field($model, 'username')->textInput([
                        'autofocus' => true,
                        'placeholder' => 'Имя пользователя или email',
                    ]) ?>
                </div>

                <div class="relative">
                    <?= $form->field($model, 'password', [
                        'template' => "{label}\n<div class=\"relative\">{input}<button type=\"button\" class=\"absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 toggle-password\"><i class=\"far fa-eye\"></i></button></div>\n{error}"
                    ])->passwordInput(['placeholder' => 'Ваш пароль']) ?>
                </div>

                <div class="flex items-center justify-between">
                    <?= $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<div class=\"flex items-center\">{input} {label}</div>",
                        'labelOptions' => ['class' => 'ml-2 text-sm text-gray-600 font-lexend'],
                        'inputOptions' => ['class' => 'h-4 w-4 rounded border-gray-300 text-sport-red focus:ring-sport-red'],
                    ]) ?>
                    <div class="text-sm">
                        <a href="#" class="text-gray-500 hover:text-sport-red transition font-lexend">Забыли пароль?</a>
                    </div>
                </div>

                <div class="flex justify-center pt-2">
                    <?= Html::submitButton('<span class="flex items-center justify-center gap-2"><i class="fas fa-sign-in-alt"></i> Войти</span>', [
                        'class' => 'group relative py-2 px-16 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sport-dark-blue'
                    ]) ?>
                </div>

                <div class="text-center mt-6">
                    <span class="text-gray-500 font-lexend">Нет аккаунта?</span>
                    <?= Html::a('Зарегистрироваться', ['register'], ['class' => 'ml-1 text-sport-red hover:text-sport-dark-blue font-semibold transition']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJsFile('@web/js/script.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>