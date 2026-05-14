<?php

/** @var yii\web\View $this */
/** @var app\models\User $user */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Booking;
use app\models\Favorite;

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/cabinet/index']];
$this->params['breadcrumbs'][] = $this->title;

$userId = Yii::$app->user->id;
$totalSpent = Booking::find()->where(['user_id' => $userId, 'status' => 'completed'])->sum('total_price') ?: 0;
$completedBookings = Booking::find()->where(['user_id' => $userId, 'status' => 'completed'])->count();
$favoritesCount = Favorite::find()->where(['user_id' => $userId])->count();
?>

<div class="cabinet-profile bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <div class="flex items-center mb-6">
                    <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200 mr-4">
                        <?php if ($user->avatar): ?>
                            <img src="<?= $user->avatar ?>" alt="Аватар" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-500 text-4xl">
                                <i class="fas fa-user-circle"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?= $form->field($user, 'avatarFile')->fileInput(['accept' => 'image/*', 'class' => 'form-control']) ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?= $form->field($user, 'first_name')->textInput(['maxlength' => true, 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($user, 'last_name')->textInput(['maxlength' => true, 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($user, 'patronymic')->textInput(['maxlength' => true, 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($user, 'email')->textInput(['maxlength' => true, 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                    <?= $form->field($user, 'phone')->textInput(['maxlength' => true, 'class' => 'w-full px-3 py-2 border border-sport-red rounded-md font-lexend']) ?>
                </div>

                <div class="mt-6">
                    <?= Html::submitButton('Сохранить', ['class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom']) ?>
                    <?= Html::a('Сменить пароль', ['/site/forgot'], ['class' => 'ml-4 py-2 px-6 border border-sport-red text-sm font-medium rounded-md text-sport-red hover:bg-sport-red hover:text-white transition-colors']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

            <div class="space-y-6">
                <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                    <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4">Ваша активность</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                            <span class="text-gray-600 font-lexend">✅ Завершённых поездок</span>
                            <span class="text-lg font-bold text-sport-dark-blue"><?= $completedBookings ?></span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                            <span class="text-gray-600 font-lexend">❤️ В избранном</span>
                            <span class="text-lg font-bold text-sport-dark-blue"><?= $favoritesCount ?></span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-gray-600 font-lexend">💰 Всего потрачено</span>
                            <span class="text-xl font-bold text-sport-red"><?= Yii::$app->formatter->asCurrency($totalSpent, 'RUB') ?></span>
                        </div>
                    </div>
                </div>

                <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                    <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4">Быстрый доступ</h3>
                    <div class="space-y-2">
                        <a href="<?= \yii\helpers\Url::to(['/cabinet/bookings']) ?>" class="flex items-center p-3 rounded-lg border border-sport-red hover:bg-sport-red hover:text-white transition-colors">
                            <i class="fas fa-calendar-alt w-6 text-sport-red group-hover:text-white"></i>
                            <span class="ml-3 font-lexend">Мои бронирования</span>
                        </a>
                        <a href="<?= \yii\helpers\Url::to(['/cabinet/favorites']) ?>" class="flex items-center p-3 rounded-lg border border-sport-red hover:bg-sport-red hover:text-white transition-colors">
                            <i class="fas fa-heart w-6 text-sport-red group-hover:text-white"></i>
                            <span class="ml-3 font-lexend">Избранное</span>
                        </a>
                        <a href="<?= \yii\helpers\Url::to(['/catalog/index']) ?>" class="flex items-center p-3 rounded-lg border border-sport-red hover:bg-sport-red hover:text-white transition-colors">
                            <i class="fas fa-car w-6 text-sport-red group-hover:text-white"></i>
                            <span class="ml-3 font-lexend">Каталог автомобилей</span>
                        </a>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-sport-dark-blue to-sport-red p-6 rounded-xl shadow-strong text-sport-dark-blue">
                    <h3 class="text-xl font-bold font-outfit mb-2">Нужна помощь?</h3>
                    <p class="font-lexend text-sm opacity-90">Свяжитесь с нашей службой поддержки</p>
                    <div class="mt-3">
                        <a href="mailto:support@rentcar.ru" class="inline-block px-4 py-2 bg-white text-sport-dark-blue rounded-lg font-medium hover:bg-opacity-90 transition">support@rentcar.ru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>