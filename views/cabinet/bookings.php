<?php

/** @var yii\web\View $this */
/** @var app\models\Booking[] $bookings */
/** @var string $currentStatus */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Мои бронирования';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/cabinet/index']];
$this->params['breadcrumbs'][] = $this->title;

$statusMap = ['pending' => 'Ожидает подтверждения', 'confirmed' => 'Подтверждено', 'cancelled' => 'Отменено', 'completed' => 'Завершено'];
$totalSum = 0;
foreach ($bookings as $booking) {
    if (in_array($booking->status, ['pending', 'confirmed'])) $totalSum += $booking->total_price;
}
$activeCount = count(array_filter($bookings, fn($b) => in_array($b->status, ['pending', 'confirmed'])));
?>

<div class="cabinet-bookings bg-gradient-to-br from-white to-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-sport-red/10 rounded-full flex items-center justify-center"><i class="fas fa-bookmark text-sport-red text-xl"></i></div>
            <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="mb-6 flex flex-wrap gap-2">
            <a href="<?= Url::to(['bookings']) ?>" class="px-4 py-2 rounded-full border border-sport-red <?= !$currentStatus ? 'bg-sport-red text-white' : 'bg-white text-sport-dark-blue hover:bg-sport-red hover:text-white' ?> transition-colors">Все</a>
            <?php foreach (array_keys($statusMap) as $status): ?>
                <a href="<?= Url::to(['bookings', 'status' => $status]) ?>" class="px-4 py-2 rounded-full border border-sport-red <?= $currentStatus === $status ? 'bg-sport-red text-white' : 'bg-white text-sport-dark-blue hover:bg-sport-red hover:text-white' ?> transition-colors"><?= $statusMap[$status] ?></a>
            <?php endforeach; ?>
        </div>

        <?php if (empty($bookings)): ?>
            <div class="bg-white p-12 rounded-2xl shadow-xl text-center border-2 border-dashed border-sport-red/30">
                <div class="text-6xl mb-4">📅</div>
                <h3 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-2">Нет бронирований</h3>
                <p class="text-gray-600 font-lexend">Перейдите в <a href="<?= Url::to(['/catalog/index']) ?>" class="text-sport-red hover:underline">каталог</a>, чтобы арендовать автомобиль.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <div class="lg:col-span-3 space-y-5">
                    <?php foreach ($bookings as $booking): $car = $booking->car; $imageUrl = $car->mainImage ? $car->mainImage->image_path : '/images/no-car.png'; ?>
                        <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-2 border-sport-dark-blue/30 hover:border-sport-red/50 flex flex-col sm:flex-row gap-5 p-5">
                            <div class="w-full sm:w-48 h-32 flex-shrink-0 overflow-hidden rounded-xl shadow-md bg-gray-100"><img src="<?= $imageUrl ?>" class="w-full h-full object-cover transition-transform hover:scale-105 duration-300"></div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold font-outfit text-sport-dark-blue"><?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?></h3>
                                <p class="text-sm text-gray-600 mt-1"><?= Yii::$app->formatter->asDate($booking->start_date) ?> — <?= Yii::$app->formatter->asDate($booking->end_date) ?></p>
                                <div class="mt-3 flex flex-wrap items-center gap-4">
                                    <span class="text-sm text-gray-600">Цена за сутки: <?= Yii::$app->formatter->asCurrency($car->price_per_day, 'RUB') ?></span>
                                    <span class="text-xl font-bold text-sport-dark-blue"><?= Yii::$app->formatter->asCurrency($booking->total_price, 'RUB') ?></span>
                                </div>
                            </div>
                            <div class="text-right flex flex-col justify-between gap-3 min-w-[130px]">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium shadow-sm 
                                    <?= $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) ?>">
                                    <?= $statusMap[$booking->status] ?>
                                </span>
                                <div class="flex flex-wrap justify-end gap-2">
                                    <?= Html::a('Подробнее', ['/booking/view', 'id' => $booking->id], ['class' => 'py-1.5 px-4 border border-sport-red text-sm rounded-xl text-sport-red hover:bg-sport-red hover:text-white transition-all']) ?>
                                    <?php if (in_array($booking->status, ['pending', 'confirmed'])): ?>
                                        <?= Html::a('Отменить', ['cancel-booking', 'id' => $booking->id], ['class' => 'py-1.5 px-4 border border-red-600 text-sm rounded-xl text-red-600 hover:bg-red-600 hover:text-white transition-all', 'data-confirm' => 'Вы уверены?', 'data-method' => 'post']) ?>
                                    <?php endif; ?>
                                    <?php if ($booking->status === 'completed'): ?>
                                        <?php if ($booking->review): ?>
                                            <?= Html::a('Посмотреть отзыв', ['view-review', 'booking_id' => $booking->id], ['class' => 'py-1.5 px-4 border border-sport-red text-sm rounded-xl text-sport-red hover:bg-sport-red hover:text-white']) ?>
                                        <?php else: ?>
                                            <?= Html::a('Написать отзыв', ['create-review', 'booking_id' => $booking->id], ['class' => 'py-1.5 px-4 border border-sport-red text-sm rounded-xl text-sport-red hover:bg-sport-red hover:text-white']) ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-xl sticky top-24 border border-sport-dark-blue/30">
                        <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4">Итоги</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                                <span class="text-gray-600">Всего бронирований:</span>
                                <span class="font-bold text-sport-dark-blue"><?= count($bookings) ?></span>
                            </div>
                            <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                                <span class="text-gray-600">Активные:</span>
                                <span class="font-bold text-green-600"><?= $activeCount ?></span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-gray-600">Общая сумма активных:</span>
                                <span class="font-bold text-sport-red text-lg"><?= Yii::$app->formatter->asCurrency($totalSum, 'RUB') ?></span>
                            </div>
                        </div>
                        <div class="mt-6 p-3 bg-gray-50 rounded-xl text-center">
                            <i class="fas fa-chart-line text-sport-red mr-2"></i>
                            <span class="text-sm text-gray-600">Средний чек: <?= $activeCount > 0 ? Yii::$app->formatter->asCurrency($totalSum / $activeCount, 'RUB') : '0 ₽' ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>