<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Управление автомобилями';
$this->params['breadcrumbs'][] = ['label' => 'Панель администратора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$cars = $dataProvider->getModels();
$pagination = $dataProvider->pagination;

$statusLabels = [
    'available' => 'Доступен',
    'booked' => 'Занят',
    'repair' => 'Ремонт',
];
?>

<div class="admin-cars bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <div class="mb-6">
            <?= Html::a('<i class="fas fa-plus-circle mr-2"></i> Добавить автомобиль', ['create-car'], [
                'class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom'
            ]) ?>
        </div>

        <?php if (empty($cars)): ?>
            <div class="bg-form-bg p-12 rounded-xl shadow-strong text-center">
                <div class="text-6xl mb-4">🚗</div>
                <h3 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-2">Нет автомобилей</h3>
                <p class="text-gray-600 font-lexend">В системе пока нет автомобилей.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($cars as $car): 
                    $imageUrl = $car->mainImage ? $car->mainImage->image_path : '/images/no-car.png';
                ?>
                    <div class="bg-light-bg rounded-xl shadow-strong hover:shadow-stronger transition-all overflow-hidden">
                        <div class="h-40 bg-cover bg-center" style="background-image: url('<?= $imageUrl ?>');"></div>
                        <div class="p-5">
                            <h3 class="text-xl font-bold font-outfit text-sport-dark-blue">
                                <?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?>
                            </h3>
                            <p class="text-sm text-gray-600 font-lexend mb-2">
                                <?= $car->year ?> г., <?= $car->color ?>, <?= $car->engine_volume ?> л
                            </p>
                            <div class="space-y-1 text-sm font-lexend text-gray-700">
                                <p><i class="fas fa-user w-5 text-sport-red"></i> Владелец: <?= Html::encode($car->owner->username) ?></p>
                                <p><i class="fas fa-tag w-5 text-sport-red"></i> Цена: <?= Yii::$app->formatter->asCurrency($car->price_per_day, 'RUB') ?>/день</p>
                                <p><i class="fas fa-info-circle w-5 text-sport-red"></i> Статус: 
                                    <span class="px-2 py-1 rounded-full text-xs font-medium 
                                        <?= $car->status === 'available' ? 'bg-green-100 text-green-800' : 
                                            ($car->status === 'booked' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') ?>">
                                        <?= $statusLabels[$car->status] ?>
                                    </span>
                                </p>
                            </div>
                            <div class="mt-4 flex justify-end gap-2">
                                <?= Html::a('<i class="fas fa-edit mr-1"></i> Редактировать', ['update-car', 'id' => $car->id], [
                                    'class' => 'py-2 px-4 border border-sport-red text-sm font-medium rounded-md text-sport-red hover:bg-sport-red hover:text-white transition-colors'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-trash mr-1"></i> Удалить', ['delete-car', 'id' => $car->id], [
                                    'class' => 'py-2 px-4 border border-red-600 text-sm font-medium rounded-md text-red-600 hover:bg-red-600 hover:text-white transition-colors',
                                    'data-confirm' => 'Вы уверены, что хотите удалить этот автомобиль?',
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