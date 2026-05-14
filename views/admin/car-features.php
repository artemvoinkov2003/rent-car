<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Управление характеристиками';
$this->params['breadcrumbs'][] = ['label' => 'Панель администратора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$features = $dataProvider->getModels();
$pagination = $dataProvider->pagination;
?>

<div class="admin-features bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <div class="mb-6">
            <?= Html::a('<i class="fas fa-plus-circle mr-2"></i> Добавить характеристику', ['create-feature'], [
                'class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom'
            ]) ?>
        </div>

        <?php if (empty($features)): ?>
            <div class="bg-form-bg p-12 rounded-xl shadow-strong text-center">
                <div class="text-6xl mb-4">🔧</div>
                <h3 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-2">Нет характеристик</h3>
                <p class="text-gray-600 font-lexend">Добавьте первую характеристику.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($features as $feature): ?>
                    <div class="bg-light-bg rounded-xl shadow-strong hover:shadow-stronger transition-all overflow-hidden">
                        <div class="p-5">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 bg-sport-red bg-opacity-10 rounded-full flex items-center justify-center text-2xl text-sport-red">
                                    <i class="<?= Html::encode($feature->icon) ?>"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold font-outfit text-sport-dark-blue"><?= Html::encode($feature->name) ?></h3>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 font-lexend mb-4">Иконка: <code><?= Html::encode($feature->icon) ?></code></p>
                            <div class="flex justify-end gap-2">
                                <?= Html::a('<i class="fas fa-edit mr-1"></i> Редактировать', ['update-feature', 'id' => $feature->id], [
                                    'class' => 'py-2 px-4 border border-sport-red text-sm font-medium rounded-md text-sport-red hover:bg-sport-red hover:text-white transition-colors'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-trash mr-1"></i> Удалить', ['delete-feature', 'id' => $feature->id], [
                                    'class' => 'py-2 px-4 border border-red-600 text-sm font-medium rounded-md text-red-600 hover:bg-red-600 hover:text-white transition-colors',
                                    'data-confirm' => 'Вы уверены, что хотите удалить эту характеристику?',
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