<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Управление изображениями автомобилей';
$this->params['breadcrumbs'][] = ['label' => 'Панель администратора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$images = $dataProvider->getModels();
$pagination = $dataProvider->pagination;
?>

<div class="admin-car-images bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <div class="mb-6">
            <?= Html::a('<i class="fas fa-plus-circle mr-2"></i> Добавить изображение', ['create-car-image'], [
                'class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom'
            ]) ?>
        </div>

        <?php if (empty($images)): ?>
            <div class="bg-form-bg p-12 rounded-xl shadow-strong text-center">
                <div class="text-6xl mb-4">🖼️</div>
                <h3 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-2">Нет изображений</h3>
                <p class="text-gray-600 font-lexend">Добавьте первое изображение.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($images as $image): 
                    $car = $image->car;
                ?>
                    <div class="bg-light-bg rounded-xl shadow-strong hover:shadow-stronger transition-all overflow-hidden">
                        <div class="h-40 bg-cover bg-center" style="background-image: url('<?= $image->image_path ?>');"></div>
                        <div class="p-5">
                            <h3 class="text-xl font-bold font-outfit text-sport-dark-blue">
                                <?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?>
                            </h3>
                            <div class="mt-2 space-y-1 text-sm font-lexend text-gray-700">
                                <p><i class="fas fa-link w-5 text-sport-red"></i> Путь: <?= Html::encode($image->image_path) ?></p>
                                <p><i class="fas fa-star w-5 text-sport-red"></i> Главное: <?= $image->is_main ? 'Да' : 'Нет' ?></p>
                                <p><i class="fas fa-sort-amount-down w-5 text-sport-red"></i> Порядок: <?= $image->sort_order ?></p>
                            </div>
                            <div class="mt-4 flex justify-end gap-2">
                                <?= Html::a('<i class="fas fa-edit mr-1"></i> Редактировать', ['update-car-image', 'id' => $image->id], [
                                    'class' => 'py-2 px-4 border border-sport-red text-sm font-medium rounded-md text-sport-red hover:bg-sport-red hover:text-white transition-colors'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-trash mr-1"></i> Удалить', ['delete-car-image', 'id' => $image->id], [
                                    'class' => 'py-2 px-4 border border-red-600 text-sm font-medium rounded-md text-red-600 hover:bg-red-600 hover:text-white transition-colors',
                                    'data-confirm' => 'Вы уверены, что хотите удалить это изображение?',
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