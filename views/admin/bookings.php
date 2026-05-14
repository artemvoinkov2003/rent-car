<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Управление бронированиями';
$this->params['breadcrumbs'][] = ['label' => 'Панель администратора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$bookings = $dataProvider->getModels();
$pagination = $dataProvider->pagination;

$statusLabels = [
    'pending' => 'Ожидает',
    'confirmed' => 'Подтверждено',
    'cancelled' => 'Отменено',
    'completed' => 'Завершено',
];

$statusColors = [
    'pending' => 'bg-yellow-100 text-yellow-800',
    'confirmed' => 'bg-green-100 text-green-800',
    'cancelled' => 'bg-red-100 text-red-800',
    'completed' => 'bg-blue-100 text-blue-800',
];
?>

<div class="admin-bookings bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <?php if (empty($bookings)): ?>
            <div class="bg-form-bg p-12 rounded-xl shadow-strong text-center">
                <div class="text-6xl mb-4">📅</div>
                <h3 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-2">Нет бронирований</h3>
                <p class="text-gray-600 font-lexend">Пока никто не бронировал автомобили.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($bookings as $booking): 
                    $car = $booking->car;
                ?>
                    <div class="bg-light-bg rounded-xl shadow-strong hover:shadow-stronger transition-all overflow-hidden">
                        <div class="p-5">
                            <h3 class="text-xl font-bold font-outfit text-sport-dark-blue">
                                <?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?>
                            </h3>
                            <p class="text-sm text-gray-600 font-lexend">
                                Арендатор: <?= Html::encode($booking->user->first_name . ' ' . $booking->user->last_name) ?>
                            </p>
                            <div class="mt-2 space-y-1 text-sm font-lexend text-gray-700">
                                <p><i class="fas fa-calendar-alt w-5 text-sport-red"></i> <?= Yii::$app->formatter->asDate($booking->start_date) ?> – <?= Yii::$app->formatter->asDate($booking->end_date) ?></p>
                                <p><i class="fas fa-ruble-sign w-5 text-sport-red"></i> <?= Yii::$app->formatter->asCurrency($booking->total_price, 'RUB') ?></p>
                                <p><i class="fas fa-info-circle w-5 text-sport-red"></i> Статус: 
                                    <span class="px-2 py-1 rounded-full text-xs font-medium <?= $statusColors[$booking->status] ?>">
                                        <?= $statusLabels[$booking->status] ?>
                                    </span>
                                </p>
                            </div>
                            <div class="mt-4 flex justify-end gap-2">
                                <?= Html::a('<i class="fas fa-edit mr-1"></i> Изменить статус', ['update-booking', 'id' => $booking->id], [
                                    'class' => 'py-2 px-4 border border-sport-red text-sm font-medium rounded-md text-sport-red hover:bg-sport-red hover:text-white transition-colors'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-trash mr-1"></i> Удалить', ['delete-booking', 'id' => $booking->id], [
                                    'class' => 'py-2 px-4 border border-red-600 text-sm font-medium rounded-md text-red-600 hover:bg-red-600 hover:text-white transition-colors',
                                    'data-confirm' => 'Вы уверены, что хотите удалить это бронирование?',
                                    'data-method' => 'post',
                                ]) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($pagination && $pagination->totalCount > $pagination->pageSize): ?>
                <div class="mt-8 flex justify-center">
                    <div class="pagination-wrapper">
                        <?= LinkPager::widget([
                            'pagination' => $pagination,
                            'options' => ['class' => 'pagination-custom'],
                            'linkOptions' => ['class' => 'page-link'],
                            'activePageCssClass' => 'active',
                            'disabledPageCssClass' => 'disabled',
                            'prevPageLabel' => '‹',
                            'nextPageLabel' => '›',
                            'firstPageLabel' => '«',
                            'lastPageLabel' => '»',
                            'maxButtonCount' => 6,
                        ]); ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>