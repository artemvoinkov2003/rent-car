<?php

/** @var yii\web\View $this */
/** @var app\models\RegisterForm $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="auth-double-triangle">
    <div class="left"></div>
    <div class="right"></div>
</div>

<div class="site-register min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
       
        <div class="w-full h-1.5 bg-gradient-to-r from-sport-red to-sport-dark-blue rounded-t-2xl"></div>

        <div class="bg-white border border-sport-dark-blue rounded-b-2xl shadow-2xl overflow-hidden">
            <div class="p-8 md:p-10">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-sport-red/10 rounded-full mb-4">
                        <i class="fas fa-user-plus text-2xl text-sport-red"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-sport-dark-blue font-outfit">
                        Создать аккаунт
                    </h2>
                    <p class="mt-2 text-sm text-sport-red font-lexend">Заполните форму для регистрации</p>
                </div>

                <?php $form = ActiveForm::begin([
                    'id' => 'register-form',
                    'options' => ['class' => 'space-y-5'],
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => ['class' => 'block text-sm font-medium text-gray-700 font-lexend mb-1'],
                        'inputOptions' => ['class' => 'w-full px-4 py-3 pl-12 rounded-xl border border-sport-dark-blue focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all duration-200 font-lexend hover:border-sport-red'],
                        'errorOptions' => ['class' => 'text-red-500 text-sm mt-1 font-lexend'],
                    ],
                ]); ?>

                <div class="relative">
                    <?= $form->field($model, 'username')->textInput(['placeholder' => 'Придумайте логин']) ?>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="relative">
                        <?= $form->field($model, 'first_name')->textInput(['placeholder' => 'Имя']) ?>
                    </div>
                    <div class="relative">
                        <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Фамилия']) ?>
                    </div>
                </div>

                <div class="relative">
                    <?= $form->field($model, 'patronymic')->textInput(['placeholder' => 'Отчество (необязательно)']) ?>
                </div>

                <div class="relative">
                    <?= $form->field($model, 'email')->input('email', ['placeholder' => 'your@email.ru']) ?>
                </div>

                <div class="relative">
                    <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                        'mask' => '+7 (999) 999-99-99',
                        'options' => [
                            'placeholder' => '+7 (___) ___-__-__',
                            'class' => 'w-full px-4 py-3 pl-12 rounded-xl border border-sport-dark-blue focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all duration-200 font-lexend hover:border-sport-red'
                        ]
                    ]) ?>
                </div>

                <div class="relative">
                    <?= $form->field($model, 'password', [
                        'template' => "{label}\n<div class=\"relative\">{input}<button type=\"button\" class=\"absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 toggle-password\"><i class=\"far fa-eye\"></i></button></div>\n{error}"
                    ])->passwordInput(['placeholder' => 'Минимум 6 символов']) ?>
                </div>
         
                <div class="relative">
                    <?= $form->field($model, 'password_repeat', [
                        'template' => "{label}\n<div class=\"relative\">{input}<button type=\"button\" class=\"absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 toggle-password\"><i class=\"far fa-eye\"></i></button></div>\n{error}"
                    ])->passwordInput(['placeholder' => 'Повторите пароль']) ?>
                </div>

                <div class="flex justify-center pt-4">
                    <?= Html::submitButton('<span class="flex items-center justify-center gap-2"><i class="fas fa-user-plus"></i> Зарегистрироваться</span>', [
                        'class' => 'group relative py-2 px-16 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sport-dark-blue'
                    ]) ?>
                </div>

                <div class="text-center mt-6">
                    <span class="text-gray-500 font-lexend">Уже есть аккаунт?</span>
                    <?= Html::a('Войти', ['login'], ['class' => 'ml-1 text-sport-red hover:text-sport-dark-blue font-semibold transition']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJsFile('@web/js/script.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>