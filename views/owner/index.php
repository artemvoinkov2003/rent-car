<?php

/** @var yii\web\View $this */
/** @var int $totalCars */
/** @var int $activeBookings */
/** @var float $monthIncome */
/** @var array $recentBookings */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Панель владельца';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/cabinet/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="owner-index bg-gradient-to-br from-white to-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="bg-gradient-to-r from-sport-dark-blue to-sport-red rounded-2xl shadow-xl p-8 mb-8 text-sport-dark-blue fade-in">
            <h1 class="text-4xl font-bold font-outfit mb-2">Здравствуйте, <?= Html::encode(Yii::$app->user->identity->first_name) ?>!</h1>
            <p class="text-xl font-lexend opacity-90">Ваш кабинет владельца автомобилей</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-sport-dark-blue/20 hover:border-sport-red/50 fade-in delay-1 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div><p class="text-sm font-lexend text-gray-500">Всего автомобилей</p><p class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= $totalCars ?></p></div>
                    <div class="w-12 h-12 bg-sport-red/10 rounded-full flex items-center justify-center"><i class="fas fa-car text-2xl text-sport-red"></i></div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-sport-dark-blue/20 hover:border-sport-red/50 fade-in delay-2 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div><p class="text-sm font-lexend text-gray-500">Активные бронирования</p><p class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= $activeBookings ?></p></div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center"><i class="fas fa-calendar-check text-2xl text-green-600"></i></div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-sport-dark-blue/20 hover:border-sport-red/50 fade-in delay-3 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div><p class="text-sm font-lexend text-gray-500">Доход за месяц</p><p class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= Yii::$app->formatter->asCurrency($monthIncome, 'RUB') ?></p></div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center"><i class="fas fa-ruble-sign text-2xl text-blue-600"></i></div>
                </div>
            </div>
        </div>

        <?php if (!empty($recentBookings)): ?>
        <div class="fade-in delay-4">
            <h2 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-4">Последние бронирования ваших авто</h2>
            <div class="space-y-4">
                <?php foreach ($recentBookings as $booking): ?>
                <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-sport-dark-blue/20 hover:border-sport-red/50 flex flex-wrap justify-between items-center gap-3">
                    <div><h3 class="text-lg font-bold font-outfit text-sport-dark-blue"><?= Html::encode($booking->car->model->brand->name . ' ' . $booking->car->model->name) ?></h3><p class="text-sm text-gray-600"><?= Yii::$app->formatter->asDate($booking->start_date) ?> — <?= Yii::$app->formatter->asDate($booking->end_date) ?></p></div>
                    <div class="text-right"><span class="inline-block px-3 py-1 rounded-full text-sm font-medium shadow-sm <?= $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) ?>"><?= $booking->status === 'pending' ? 'Ожидает' : ($booking->status === 'confirmed' ? 'Подтверждено' : ($booking->status === 'cancelled' ? 'Отменено' : 'Завершено')) ?></span><?= Html::a('Подробнее', ['/booking/view', 'id' => $booking->id], ['class' => 'ml-3 text-sm text-sport-red hover:underline font-medium']) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 fade-in delay-5">
            <?= Html::a('<i class="fas fa-plus-circle mr-2"></i> Добавить автомобиль', ['create'], ['class' => 'block py-4 px-6 bg-sport-red text-white rounded-2xl shadow-lg hover:shadow-xl transition-all text-center text-lg font-outfit hover:scale-[1.02]']) ?>
            <?= Html::a('<i class="fas fa-list mr-2"></i> Управление заявками', ['bookings'], ['class' => 'block py-4 px-6 bg-sport-dark-blue text-white rounded-2xl shadow-lg hover:shadow-xl transition-all text-center text-lg font-outfit hover:scale-[1.02]']) ?>
        </div>
    </div>
</div>