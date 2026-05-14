<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Управление моделями';
$this->params['breadcrumbs'][] = ['label' => 'Панель администратора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$models = $dataProvider->getModels();
$pagination = $dataProvider->pagination;
?>

<div class="admin-models bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <div class="mb-6">
            <?= Html::a('<i class="fas fa-plus-circle mr-2"></i> Добавить модель', ['create-model'], [
                'class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom'
            ]) ?>
        </div>

        <?php if (empty($models)): ?>
            <div class="bg-form-bg p-12 rounded-xl shadow-strong text-center">
                <div class="text-6xl mb-4">🚘</div>
                <h3 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-2">Нет моделей</h3>
                <p class="text-gray-600 font-lexend">Добавьте первую модель.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($models as $model): ?>
                    <div class="bg-light-bg rounded-xl shadow-strong hover:shadow-stronger transition-all overflow-hidden">
                        <div class="p-5">
                            <h3 class="text-xl font-bold font-outfit text-sport-dark-blue">
                                <?= Html::encode($model->brand->name . ' ' . $model->name) ?>
                            </h3>
                            <p class="text-sm text-gray-600 font-lexend mt-2">
                                Годы выпуска: <?= $model->year_start ?: '—' ?> – <?= $model->year_end ?: 'н.в.' ?>
                            </p>
                            <div class="mt-4 flex justify-end gap-2">
                                <?= Html::a('<i class="fas fa-edit mr-1"></i> Редактировать', ['update-model', 'id' => $model->id], [
                                    'class' => 'py-2 px-4 border border-sport-red text-sm font-medium rounded-md text-sport-red hover:bg-sport-red hover:text-white transition-colors'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-trash mr-1"></i> Удалить', ['delete-model', 'id' => $model->id], [
                                    'class' => 'py-2 px-4 border border-red-600 text-sm font-medium rounded-md text-red-600 hover:bg-red-600 hover:text-white transition-colors',
                                    'data-confirm' => 'Вы уверены, что хотите удалить эту модель?',
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