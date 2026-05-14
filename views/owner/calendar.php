<?php

/** @var yii\web\View $this */
/** @var app\models\Car $car */
/** @var array $bookings */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Календарь занятости: ' . $car->model->brand->name . ' ' . $car->model->name;
$this->params['breadcrumbs'][] = ['label' => 'Мои автомобили', 'url' => ['cars']];
$this->params['breadcrumbs'][] = $this->title;

$month = date('n');
$year = date('Y');
$firstDay = mktime(0,0,0, $month, 1, $year);
$daysInMonth = date('t', $firstDay);
$firstWeekday = date('N', $firstDay); 

$bookedDates = [];
$upcomingBookings = [];
foreach ($bookings as $booking) {
    $start = strtotime($booking->start_date);
    $end = strtotime($booking->end_date);
    for ($d = $start; $d <= $end; $d = strtotime('+1 day', $d)) {
        $bookedDates[date('Y-m-d', $d)] = true;
    }
    if (strtotime($booking->start_date) >= time()) {
        $upcomingBookings[] = $booking;
    }
}
usort($upcomingBookings, function($a, $b) {
    return strtotime($a->start_date) - strtotime($b->start_date);
});
$upcomingBookings = array_slice($upcomingBookings, 0, 5);
?>

<div class="owner-calendar bg-gradient-to-br from-white to-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-sport-red/10 rounded-full flex items-center justify-center">
                <i class="fas fa-calendar-alt text-sport-red text-xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-sport-dark-blue"><?= Yii::$app->formatter->asDate(time(), 'MMMM yyyy') ?></h2>
                    </div>
                    <div class="grid grid-cols-7 gap-2 text-center font-bold text-sport-dark-blue mb-3">
                        <div>Пн</div><div>Вт</div><div>Ср</div><div>Чт</div><div>Пт</div><div>Сб</div><div>Вс</div>
                    </div>
                    <div class="grid grid-cols-7 gap-2">
                        <?php
                        for ($i = 1; $i < $firstWeekday; $i++) {
                            echo '<div class="p-3 text-gray-400 text-center bg-gray-50 rounded-xl">-</div>';
                        }
                        for ($day = 1; $day <= $daysInMonth; $day++) {
                            $date = date('Y-m-d', mktime(0,0,0, $month, $day, $year));
                            $isBooked = isset($bookedDates[$date]);
                            $class = $isBooked 
                                ? 'bg-sport-red text-white font-bold shadow-md' 
                                : 'bg-white border border-gray-200 hover:border-sport-red transition-colors';
                            if (date('Y-m-d') == $date && !$isBooked) {
                                $class = 'bg-blue-100 border-2 border-blue-500 font-bold';
                            }
                            echo '<div class="p-3 rounded-xl text-center transition-all ' . $class . '">' . $day . '</div>';
                        }
                        $totalCells = $firstWeekday - 1 + $daysInMonth;
                        $remainder = (7 - ($totalCells % 7)) % 7;
                        for ($i = 0; $i < $remainder; $i++) {
                            echo '<div class="p-3 text-gray-400 text-center bg-gray-50 rounded-xl">-</div>';
                        }
                        ?>
                    </div>
                    <div class="mt-5 flex flex-wrap gap-4 text-sm">
                        <div class="flex items-center"><span class="w-4 h-4 bg-sport-red rounded-full mr-2"></span> Занято</div>
                        <div class="flex items-center"><span class="w-4 h-4 bg-blue-100 border-2 border-blue-500 rounded-full mr-2"></span> Сегодня</div>
                        <div class="flex items-center"><span class="w-4 h-4 bg-white border border-gray-300 rounded-full mr-2"></span> Свободно</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4 flex items-center gap-2">
                        <i class="fas fa-clock text-sport-red"></i> Ближайшие бронирования
                    </h3>
                    <?php if (empty($upcomingBookings)): ?>
                        <div class="text-center py-8">
                            <div class="text-5xl mb-3">📅</div>
                            <p class="text-gray-500 font-lexend">Нет предстоящих бронирований</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-3">
                            <?php foreach ($upcomingBookings as $booking): ?>
                                <div class="p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                    <div class="font-semibold text-sport-dark-blue">
                                        <?= Yii::$app->formatter->asDate($booking->start_date) ?> – <?= Yii::$app->formatter->asDate($booking->end_date) ?>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        <?= Yii::$app->formatter->asCurrency($booking->total_price, 'RUB') ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="mt-5 pt-4 border-t border-gray-100">
                        <?= Html::a('Все бронирования', ['bookings'], ['class' => 'text-sm text-sport-red hover:underline']) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            <?= Html::a('Вернуться к списку', ['cars'], ['class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-xl text-white btn-gradient-custom shadow-md hover:shadow-lg transition-all']) ?>
        </div>
    </div>
</div>