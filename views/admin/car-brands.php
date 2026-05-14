<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Управление брендами';
$this->params['breadcrumbs'][] = ['label' => 'Панель администратора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$brands = $dataProvider->getModels();
$pagination = $dataProvider->pagination;
?>

<div class="admin-brands bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <div class="mb-6">
            <?= Html::a('<i class="fas fa-plus-circle mr-2"></i> Добавить бренд', ['create-brand'], [
                'class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom'
            ]) ?>
        </div>

        <?php if (empty($brands)): ?>
            <div class="bg-form-bg p-12 rounded-xl shadow-strong text-center">
                <div class="text-6xl mb-4">🏷️</div>
                <h3 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-2">Нет брендов</h3>
                <p class="text-gray-600 font-lexend">Добавьте первый бренд.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($brands as $brand): ?>
                    <div class="bg-light-bg rounded-xl shadow-strong hover:shadow-stronger transition-all overflow-hidden">
                        <div class="p-5">
                            <div class="flex items-center gap-4 mb-4">
                                <?php if ($brand->logo): ?>
                                    <div class="w-16 h-16 flex-shrink-0">
                                        <img src="<?= $brand->logo ?>" alt="Логотип" class="w-full h-full object-contain">
                                    </div>
                                <?php else: ?>
                                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center text-3xl text-gray-500">
                                        <i class="fas fa-car"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <h3 class="text-xl font-bold font-outfit text-sport-dark-blue"><?= Html::encode($brand->name) ?></h3>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 font-lexend mb-4"><?= Html::encode($brand->description) ?></p>
                            <div class="flex justify-end gap-2">
                                <?= Html::a('<i class="fas fa-edit mr-1"></i> Редактировать', ['update-brand', 'id' => $brand->id], [
                                    'class' => 'py-2 px-4 border border-sport-red text-sm font-medium rounded-md text-sport-red hover:bg-sport-red hover:text-white transition-colors'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-trash mr-1"></i> Удалить', ['delete-brand', 'id' => $brand->id], [
                                    'class' => 'py-2 px-4 border border-red-600 text-sm font-medium rounded-md text-red-600 hover:bg-red-600 hover:text-white transition-colors',
                                    'data-confirm' => 'Вы уверены, что хотите удалить этот бренд?',
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