<?php

/** @var yii\web\View $this */
/** @var app\models\User $user */
/** @var int $totalBookings */
/** @var int $activeBookings */
/** @var int $completedBookings */
/** @var int $cancelledBookings */
/** @var float $totalSpent */
/** @var int $favoritesCount */
/** @var app\models\Booking[] $recentBookings */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cabinet-index bg-white py-8">
    <div class="container mx-auto px-4">
        
        <div class="bg-gradient-to-r from-sport-dark-blue to-sport-red rounded-xl shadow-strong p-8 mb-8 text-sport-dark-blue fade-in">
            <h1 class="text-4xl font-bold font-outfit mb-2">Здравствуйте, <?= Html::encode($user->first_name) ?>!</h1>
            <p class="text-xl font-lexend opacity-90">Добро пожаловать в ваш личный кабинет</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-light-bg p-6 rounded-xl shadow-strong hover:shadow-stronger transition-all fade-in delay-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-lexend text-gray-600">Всего бронирований</p>
                        <p class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= $totalBookings ?></p>
                    </div>
                    <div class="w-12 h-12 bg-sport-red bg-opacity-10 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-check text-2xl text-sport-red"></i>
                    </div>
                </div>
            </div>
            <div class="bg-light-bg p-6 rounded-xl shadow-strong hover:shadow-stronger transition-all fade-in delay-2">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-lexend text-gray-600">Активные</p>
                        <p class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= $activeBookings ?></p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-spinner text-2xl text-green-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-light-bg p-6 rounded-xl shadow-strong hover:shadow-stronger transition-all fade-in delay-3">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-lexend text-gray-600">Завершено</p>
                        <p class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= $completedBookings ?></p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-2xl text-blue-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-light-bg p-6 rounded-xl shadow-strong hover:shadow-stronger transition-all fade-in delay-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-lexend text-gray-600">В избранном</p>
                        <p class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= $favoritesCount ?></p>
                    </div>
                    <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-heart text-2xl text-pink-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-sport-dark-blue to-sport-red rounded-xl shadow-strong p-6 text-sport-dark-blue fade-in delay-5 lg:col-span-1">
                <h3 class="text-lg font-outfit mb-2">Потрачено всего</h3>
                <p class="text-3xl font-bold"><?= Yii::$app->formatter->asCurrency($totalSpent, 'RUB') ?></p>
                <p class="text-sm opacity-80 mt-2">на завершённые поездки</p>
            </div>
            <div class="bg-light-bg p-6 rounded-xl shadow-strong fade-in delay-5 lg:col-span-1">
                <h3 class="text-lg font-outfit text-sport-dark-blue mb-2">Отменено</h3>
                <p class="text-3xl font-bold text-sport-dark-blue"><?= $cancelledBookings ?></p>
                <p class="text-sm text-gray-600 mt-2">бронирований</p>
            </div>
            <div class="bg-light-bg p-6 rounded-xl shadow-strong fade-in delay-5 lg:col-span-1">
                <h3 class="text-lg font-outfit text-sport-dark-blue mb-4">Быстрые действия</h3>
                <div class="space-y-2">
                    <a href="<?= Url::to(['/catalog/index']) ?>" class="block py-2 px-4 bg-sport-red bg-opacity-10 text-sport-dark-blue rounded-lg hover:bg-sport-red hover:text-white transition-colors">
                        <i class="fas fa-car mr-2"></i> Перейти в каталог
                    </a>
                    <a href="<?= Url::to(['/cabinet/bookings']) ?>" class="block py-2 px-4 bg-sport-red bg-opacity-10 text-sport-dark-blue rounded-lg hover:bg-sport-red hover:text-white transition-colors">
                        <i class="fas fa-list mr-2"></i> Мои бронирования
                    </a>
                    <a href="<?= Url::to(['/cabinet/favorites']) ?>" class="block py-2 px-4 bg-sport-red bg-opacity-10 text-sport-dark-blue rounded-lg hover:bg-sport-red hover:text-white transition-colors">
                        <i class="fas fa-heart mr-2"></i> Избранное
                    </a>
                </div>
            </div>
        </div>

        <?php if (!empty($recentBookings)): ?>
            <div class="fade-in delay-6">
                <h2 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-4">Последние бронирования</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php foreach ($recentBookings as $booking): 
                        $car = $booking->car;
                        $imageUrl = $car->mainImage ? $car->mainImage->image_path : '/images/no-car.png';
                    ?>
                        <div class="bg-light-bg rounded-xl shadow-strong hover:shadow-stronger transition-all overflow-hidden">
                            <div class="h-48 overflow-hidden bg-gray-100 flex items-center justify-center">
                                <img src="<?= $imageUrl ?>" alt="<?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?>" class="w-full h-auto object-contain">
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-bold font-outfit text-sport-dark-blue">
                                    <?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?>
                                </h3>
                                <p class="text-sm text-sport-dark-blue font-lexend">
                                    <?= Yii::$app->formatter->asDate($booking->start_date) ?> - <?= Yii::$app->formatter->asDate($booking->end_date) ?>
                                </p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span class="text-sm font-medium 
                                        <?= $booking->status === 'pending' ? 'text-yellow-600' : 
                                            ($booking->status === 'confirmed' ? 'text-green-600' : 
                                            ($booking->status === 'cancelled' ? 'text-red-600' : 'text-gray-600')) ?>">
                                        <?= $booking->status === 'pending' ? 'Ожидает' : 
                                            ($booking->status === 'confirmed' ? 'Подтверждено' : 
                                            ($booking->status === 'cancelled' ? 'Отменено' : 'Завершено')) ?>
                                    </span>
                                    <?= Html::a('Подробнее', ['/booking/view', 'id' => $booking->id], [
                                        'class' => 'text-sm text-sport-red hover:underline'
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>