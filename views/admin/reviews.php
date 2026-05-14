<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Управление отзывами';
$this->params['breadcrumbs'][] = ['label' => 'Панель администратора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$reviews = $dataProvider->getModels();
$pagination = $dataProvider->pagination;
?>

<div class="admin-reviews bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <?php if (empty($reviews)): ?>
            <div class="bg-form-bg p-12 rounded-xl shadow-strong text-center">
                <div class="text-6xl mb-4">💬</div>
                <h3 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-2">Нет отзывов</h3>
                <p class="text-gray-600 font-lexend">Пока никто не оставлял отзывы.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($reviews as $review): 
                    $booking = $review->booking;
                    $car = $booking->car ?? null;
                ?>
                    <div class="bg-light-bg rounded-xl shadow-strong hover:shadow-stronger transition-all overflow-hidden">
                        <div class="p-5">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-full bg-sport-red bg-opacity-10 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-sport-red"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold font-outfit text-sport-dark-blue"><?= Html::encode($booking->user->first_name . ' ' . $booking->user->last_name) ?></h4>
                                    <p class="text-xs text-gray-500"><?= Yii::$app->formatter->asDate($review->created_at) ?></p>
                                </div>
                            </div>
                            <?php if ($car): ?>
                                <p class="text-sm font-lexend text-gray-700 mb-2">
                                    <i class="fas fa-car text-sport-red mr-1"></i> <?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?>
                                </p>
                            <?php endif; ?>
                            <div class="flex items-center mb-2">
                                <?php for ($i=1; $i<=5; $i++): ?>
                                    <i class="fas fa-star <?= $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="text-gray-700 font-lexend text-sm"><?= Html::encode($review->comment) ?></p>
                            <div class="mt-4 flex justify-end">
                                <?= Html::a('<i class="fas fa-trash mr-1"></i> Удалить', ['delete-review', 'id' => $review->id], [
                                    'class' => 'py-2 px-4 border border-red-600 text-sm font-medium rounded-md text-red-600 hover:bg-red-600 hover:text-white transition-colors',
                                    'data-confirm' => 'Вы уверены, что хотите удалить этот отзыв?',
                                    'data-method' => 'post',
                                ]) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($pagination && $pagination->totalCount > $pagination->pageSize): ?>
                <div class="mt-8 flex justify-center">
                    <?= LinkPager::widget([
                        'pagination' => $pagination,
                        'options' => ['class' => 'flex space-x-2'],
                        'linkOptions' => ['class' => 'w-10 h-10 rounded-full bg-light-bg border border-sport-red text-sport-dark-blue font-lexend flex items-center justify-center hover:bg-sport-red hover:text-white transition-colors'],
                        'activePageCssClass' => 'bg-sport-red text-white',
                        'disabledPageCssClass' => 'opacity-50 cursor-not-allowed',
                        'prevPageLabel' => '‹',
                        'nextPageLabel' => '›',
                        'firstPageLabel' => '«',
                        'lastPageLabel' => '»',
                    ]); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>