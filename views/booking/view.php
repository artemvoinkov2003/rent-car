<?php

/** @var yii\web\View $this */
/** @var app\models\Booking $booking */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Детали бронирования';
$this->params['breadcrumbs'][] = ['label' => 'Мои бронирования', 'url' => ['/cabinet/bookings']];
$this->params['breadcrumbs'][] = $this->title;

$car = $booking->car;
$statusMap = [
    'pending' => 'Ожидает подтверждения',
    'confirmed' => 'Подтверждено',
    'cancelled' => 'Отменено',
    'completed' => 'Завершено',
];
$imageUrl = $car->mainImage ? $car->mainImage->image_path : '/images/no-car.png';
$start = new \DateTime($booking->start_date);
$end = new \DateTime($booking->end_date);
$days = $start->diff($end)->days;
?>

<div class="booking-view bg-gradient-to-br from-white to-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-sport-red/10 rounded-full flex items-center justify-center"><i class="fas fa-receipt text-sport-red text-xl"></i></div>
            <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl border-2 border-sport-dark-blue/20 overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-sport-dark-blue to-sport-red"></div>
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row gap-6 mb-6">
                        <div class="w-full md:w-72 h-48 overflow-hidden rounded-xl shadow-md bg-gray-100"><img src="<?= $imageUrl ?>" class="w-full h-full object-contain"></div>
                        <div><h2 class="text-2xl font-bold text-sport-dark-blue font-outfit"><?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?></h2><p class="text-gray-600"><?= $car->year ?> г., <?= $car->color ?></p><div class="mt-3 flex items-center gap-2"><i class="fas fa-tag text-sport-red"></i><span class="text-xl font-bold text-sport-red"><?= Yii::$app->formatter->asCurrency($car->price_per_day, 'RUB') ?></span><span class="text-gray-500">/ день</span></div></div>
                    </div>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-gray-100 pt-6">
                        <div class="bg-gray-50 p-3 rounded-xl"><dt class="text-sm text-gray-500">Дата начала</dt><dd class="text-lg font-semibold"><?= Yii::$app->formatter->asDate($booking->start_date) ?></dd></div>
                        <div class="bg-gray-50 p-3 rounded-xl"><dt class="text-sm text-gray-500">Дата окончания</dt><dd class="text-lg font-semibold"><?= Yii::$app->formatter->asDate($booking->end_date) ?></dd></div>
                        <div class="bg-gray-50 p-3 rounded-xl"><dt class="text-sm text-gray-500">Количество дней</dt><dd class="text-lg font-semibold"><?= $days ?></dd></div>
                        <div class="bg-gray-50 p-3 rounded-xl"><dt class="text-sm text-gray-500">Цена за сутки</dt><dd class="text-lg font-semibold"><?= Yii::$app->formatter->asCurrency($car->price_per_day, 'RUB') ?></dd></div>
                        <div class="md:col-span-2 bg-gray-50 p-3 rounded-xl"><dt class="text-sm text-gray-500">Итоговая стоимость</dt><dd class="text-2xl font-bold text-sport-dark-blue"><?= Yii::$app->formatter->asCurrency($booking->total_price, 'RUB') ?></dd></div>
                        <div class="md:col-span-2"><dt class="text-sm text-gray-500">Статус</dt><dd><span class="inline-block px-3 py-1 rounded-full text-sm font-medium <?= $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) ?>"><?= $statusMap[$booking->status] ?></span></dd></div>
                        <div class="md:col-span-2 bg-gray-50 p-3 rounded-xl"><dt class="text-sm text-gray-500">Водительское удостоверение</dt><dd><?= Html::encode($booking->driver_license_series . ' ' . $booking->driver_license_number) ?><br><span class="text-sm">Выдано: <?= Html::encode($booking->driver_license_issued_by) ?></span><br><span class="text-sm">Дата выдачи: <?= Yii::$app->formatter->asDate($booking->driver_license_issue_date) ?></span></dd></div>
                        <div class="md:col-span-2 bg-gray-50 p-3 rounded-xl"><dt class="text-sm text-gray-500">Страховка</dt><dd><?= $booking->insurance_type === 'extended' ? 'Расширенная' : 'Базовая' ?><?php if ($booking->insurance_company): ?><br><span class="text-sm">Компания: <?= Html::encode($booking->insurance_company) ?></span><br><span class="text-sm">Полис: <?= Html::encode($booking->insurance_policy_number) ?></span><?php endif; ?></dd></div>
                        <div class="md:col-span-2"><dt class="text-sm text-gray-500">Согласие с условиями</dt><dd><?= $booking->terms_accepted ? 'Да' : 'Нет' ?></dd></div>
                    </dl>
                    <div class="mt-8 text-center"><?= Html::a('Вернуться к бронированиям', ['/cabinet/bookings'], ['class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-xl text-white btn-gradient-custom shadow-md hover:shadow-lg transition-all']) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>