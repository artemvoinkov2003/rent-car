<?php

/** @var yii\web\View $this */
/** @var app\models\Contact $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Контакты';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-contact bg-white py-12">
    <div class="container mx-auto px-4">
       
        <div class="relative bg-gradient-to-r from-sport-dark-blue to-sport-red rounded-2xl shadow-strong p-12 mb-16 text-center overflow-hidden">
            <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl -ml-20 -mt-20"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-sand opacity-10 rounded-full blur-3xl -mr-20 -mb-20"></div>
            <h1 class="text-4xl md:text-5xl font-bold font-outfit text-sport-dark-blue mb-4">Свяжитесь с нами</h1>
            <p class="text-xl font-lexend text-white/90 max-w-2xl mx-auto">Мы всегда на связи и готовы ответить на любые вопросы</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <div class="space-y-6">
                <div class="bg-light-bg rounded-xl shadow-strong p-6 transition hover:shadow-stronger">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-sport-red/10 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-xl text-sport-red"></i>
                        </div>
                        <div>
                            <h3 class="font-bold font-outfit text-sport-dark-blue text-lg">Адрес</h3>
                            <p class="text-gray-600 font-lexend">г. Курган, ул. Карельцева, 32, кабинет 206</p>
                        </div>
                    </div>
                </div>
                <div class="bg-light-bg rounded-xl shadow-strong p-6 transition hover:shadow-stronger">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-sport-red/10 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone-alt text-xl text-sport-red"></i>
                        </div>
                        <div>
                            <h3 class="font-bold font-outfit text-sport-dark-blue text-lg">Телефон</h3>
                            <p class="text-gray-600 font-lexend"><a href="tel:+79125226420" class="hover:text-sport-red transition">+7 (912) 522-64-20</a></p>
                        </div>
                    </div>
                </div>
                <div class="bg-light-bg rounded-xl shadow-strong p-6 transition hover:shadow-stronger">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-sport-red/10 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-xl text-sport-red"></i>
                        </div>
                        <div>
                            <h3 class="font-bold font-outfit text-sport-dark-blue text-lg">Почта</h3>
                            <p class="text-gray-600 font-lexend"><a href="mailto:artem.voinkov@yandex.ru" class="hover:text-sport-red transition">artem.voinkov@yandex.ru</a></p>
                        </div>
                    </div>
                </div>
                <div class="bg-light-bg rounded-xl shadow-strong p-6 transition hover:shadow-stronger">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-sport-red/10 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clock text-xl text-sport-red"></i>
                        </div>
                        <div>
                            <h3 class="font-bold font-outfit text-sport-dark-blue text-lg">Режим работы</h3>
                            <p class="text-gray-600 font-lexend">Пн-Пт: 9:00 - 20:00<br>Сб-Вс: 10:00 - 18:00</p>
                        </div>
                    </div>
                </div>

                <div class="bg-light-bg rounded-xl shadow-strong overflow-hidden">
                    <div class="h-64 bg-gray-200">
                        <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Aваш_ключ&source=constructor" width="100%" height="100%" frameborder="0"></iframe>
                    </div>
                    <p class="text-xs text-gray-500 p-3">* Для реальной карты нужно получить API-ключ Яндекса и указать координаты.</p>
                </div>
            </div>

            <div class="bg-light-bg rounded-xl shadow-strong p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-sport-red rounded-full flex items-center justify-center">
                        <i class="fas fa-pen-alt text-white text-sm"></i>
                    </div>
                    <h2 class="text-2xl font-bold font-outfit text-sport-dark-blue">Напишите нам</h2>
                </div>

                <?php $form = ActiveForm::begin(['options' => ['class' => 'space-y-5']]); ?>

                <?= $form->field($model, 'name')->textInput([
                    'placeholder' => 'Ваше имя',
                    'class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-sport-red focus:ring-2 focus:ring-sport-red font-lexend transition'
                ])->label(false) ?>

                <?= $form->field($model, 'email')->textInput([
                    'placeholder' => 'Email',
                    'class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-sport-red focus:ring-2 focus:ring-sport-red font-lexend transition'
                ])->label(false) ?>

                <?= $form->field($model, 'phone')->textInput([
                    'placeholder' => 'Телефон (необязательно)',
                    'class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-sport-red focus:ring-2 focus:ring-sport-red font-lexend transition'
                ])->label(false) ?>

                <?= $form->field($model, 'message')->textarea([
                    'rows' => 5,
                    'placeholder' => 'Ваше сообщение',
                    'class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-sport-red focus:ring-2 focus:ring-sport-red font-lexend transition'
                ])->label(false) ?>

                <div>
                    <?= Html::submitButton('Отправить сообщение', [
                        'class' => 'w-full py-3 px-6 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom hover:shadow-lg transition'
                    ]) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>