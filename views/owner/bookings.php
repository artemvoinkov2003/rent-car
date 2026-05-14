<?php

/** @var yii\web\View $this */
/** @var array $bookings */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Заявки на бронирование';
$this->params['breadcrumbs'][] = ['label' => 'Панель владельца', 'url' => ['/owner/index']];
$this->params['breadcrumbs'][] = $this->title;

$statusMap = [
    'pending' => 'Ожидает',
    'confirmed' => 'Подтверждено',
    'cancelled' => 'Отменено',
    'completed' => 'Завершено',
];
?>

<div class="owner-bookings bg-gradient-to-br from-white to-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-sport-red/10 rounded-full flex items-center justify-center">
                <i class="fas fa-clipboard-list text-sport-red text-xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= Html::encode($this->title) ?></h1>
        </div>

        <?php if (empty($bookings)): ?>
            <div class="bg-white p-12 rounded-2xl shadow-xl text-center border-2 border-dashed border-sport-red/30">
                <div class="text-6xl mb-4">📭</div>
                <h3 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-2">Нет заявок</h3>
                <p class="text-gray-600 font-lexend">Пока никто не бронирует ваши автомобили.</p>
            </div>
        <?php else: ?>
            <div class="space-y-5">
                <?php foreach ($bookings as $booking): 
                    $car = $booking->car;
                    $imageUrl = $car->mainImage ? $car->mainImage->image_path : '/images/no-car.png';
                ?>
                    <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border-2 border-sport-dark-blue/20 overflow-hidden">
                        <div class="flex flex-col md:flex-row gap-5 p-5">
                            <div class="w-full md:w-56 h-40 flex-shrink-0 overflow-hidden rounded-xl shadow-md bg-gray-100">
                                <img src="<?= $imageUrl ?>" alt="<?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?>" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                            </div>
                            
                            <div class="flex-1">
                                <h3 class="text-xl font-bold font-outfit text-sport-dark-blue mb-2">
                                    <?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?>
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-1 text-sm font-lexend text-gray-600">
                                    <div><i class="fas fa-user mr-2 text-sport-red w-5"></i> Арендатор: <?= Html::encode($booking->user->first_name . ' ' . $booking->user->last_name) ?></div>
                                    <div><i class="fas fa-calendar-alt mr-2 text-sport-red w-5"></i> <?= Yii::$app->formatter->asDate($booking->start_date) ?> — <?= Yii::$app->formatter->asDate($booking->end_date) ?></div>
                                    <div><i class="fas fa-ruble-sign mr-2 text-sport-red w-5"></i> Сумма: <?= Yii::$app->formatter->asCurrency($booking->total_price, 'RUB') ?></div>
                                </div>
                            </div>

                            <div class="flex flex-row md:flex-col justify-between md:justify-start items-end gap-3 min-w-[130px]">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium shadow-sm 
                                    <?= $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                        ($booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                        ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) ?>">
                                    <?= $statusMap[$booking->status] ?>
                                </span>
                                <?php if ($booking->status === 'pending'): ?>
                                    <div class="flex gap-2">
                                        <?= Html::a('Подтвердить', ['confirm-booking', 'id' => $booking->id], [
                                            'class' => 'py-1.5 px-3 border border-green-600 text-sm rounded-xl text-green-600 hover:bg-green-600 hover:text-white transition-all shadow-sm',
                                            'data-method' => 'post',
                                        ]) ?>
                                        <?= Html::a('Отклонить', ['cancel-booking', 'id' => $booking->id], [
                                            'class' => 'py-1.5 px-3 border border-red-600 text-sm rounded-xl text-red-600 hover:bg-red-600 hover:text-white transition-all shadow-sm',
                                            'data-method' => 'post',
                                        ]) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>