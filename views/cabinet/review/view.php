<?php

/** @var yii\web\View $this */
/** @var app\models\Booking $booking */
/** @var app\models\Review $review */

use yii\helpers\Html;

$this->title = 'Отзыв о бронировании';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/cabinet/index']];
$this->params['breadcrumbs'][] = ['label' => 'Мои бронирования', 'url' => ['bookings']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="review-view bg-gradient-to-br from-white to-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-sport-red/10 rounded-full flex items-center justify-center">
                <i class="fas fa-comment-dots text-sport-red text-xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-sport-dark-blue to-sport-red"></div>
                <div class="p-6 md:p-8">
                    <div class="bg-gray-50 p-4 rounded-xl mb-6 flex items-start gap-3">
                        <div class="w-12 h-12 bg-sport-red/10 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-car text-sport-red text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-700 font-lexend">
                                <strong class="text-sport-dark-blue"><?= Html::encode($booking->car->model->brand->name . ' ' . $booking->car->model->name) ?></strong>
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-calendar-alt mr-1"></i> <?= Yii::$app->formatter->asDate($booking->start_date) ?> – <?= Yii::$app->formatter->asDate($booking->end_date) ?>
                            </p>
                        </div>
                    </div>

                    <?php if ($review): ?>
                        <div class="border border-gray-100 rounded-xl p-5 bg-white shadow-sm">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-yellow-500 text-2xl">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star <?= $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' ?>"></i>
                                        <?php endfor; ?>
                                    </span>
                                    <span class="text-sm text-gray-500 font-lexend">
                                        <i class="far fa-calendar-alt mr-1"></i> <?= Yii::$app->formatter->asDate($review->created_at) ?>
                                    </span>
                                </div>
                            </div>
                            <p class="text-gray-700 font-lexend leading-relaxed"><?= Html::encode($review->comment) ?></p>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <div class="text-6xl mb-4">📝</div>
                            <p class="text-gray-500 font-lexend mb-4">Отзыв ещё не оставлен.</p>
                            <?= Html::a('Написать отзыв', ['create-review', 'booking_id' => $booking->id], [
                                'class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-xl text-white btn-gradient-custom shadow-md hover:shadow-lg transition-all'
                            ]) ?>
                        </div>
                    <?php endif; ?>

                    <div class="mt-6 text-center">
                        <?= Html::a('← Вернуться к бронированиям', ['bookings'], [
                            'class' => 'text-sport-red hover:text-sport-dark-blue transition-colors font-lexend'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>