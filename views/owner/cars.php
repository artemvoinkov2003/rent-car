<?php

/** @var yii\web\View $this */
/** @var array $cars */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Мои автомобили';
$this->params['breadcrumbs'][] = ['label' => 'Панель владельца', 'url' => ['/owner/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="owner-cars bg-gradient-to-br from-white to-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-sport-red/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-car text-sport-red text-xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= Html::encode($this->title) ?></h1>
            </div>
            <?= Html::a('<i class="fas fa-plus-circle mr-2"></i> Добавить автомобиль', ['create'], [
                'class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-xl text-white btn-gradient-custom shadow-md hover:shadow-lg transition-all'
            ]) ?>
        </div>

        <?php if (empty($cars)): ?>
            <div class="bg-white p-12 rounded-2xl shadow-xl text-center border-2 border-dashed border-sport-red/30">
                <div class="text-6xl mb-4">🚗</div>
                <h3 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-2">У вас пока нет автомобилей</h3>
                <p class="text-gray-600 font-lexend">Нажмите «Добавить автомобиль», чтобы разместить объявление.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($cars as $car): 
                    $imageUrl = $car->mainImage ? $car->mainImage->image_path : '/images/no-car.png';
                ?>
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 border-2 border-sport-dark-blue/20 hover:border-sport-red/50">
                        <div class="relative h-52 overflow-hidden">
                            <img src="<?= $imageUrl ?>" alt="<?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute top-3 right-3 flex gap-2">
                                <span class="px-3 py-1 text-xs font-medium rounded-full shadow-md 
                                    <?= $car->status === 'available' ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' ?>">
                                    <?= $car->status === 'available' ? 'Доступен' : 'Занят' ?>
                                </span>
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="text-xl font-bold font-outfit text-sport-dark-blue mb-1">
                                <?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?>
                            </h3>
                            <p class="text-sm text-gray-500 mb-3"><?= $car->year ?> г., <?= $car->color ?></p>
                            <div class="flex justify-between items-center mb-4">
                                <div class="text-2xl font-bold text-sport-red font-outfit">
                                    <?= Yii::$app->formatter->asCurrency($car->price_per_day, 'RUB') ?>
                                </div>
                                <span class="text-sm text-gray-500">/ день</span>
                            </div>
                            <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
                                <?= Html::a('<i class="fas fa-chart-line"></i>', ['stats', 'id' => $car->id], [
                                    'class' => 'w-9 h-9 rounded-full bg-gray-100 text-red-600 hover:bg-red-600 hover:text-white transition-all flex items-center justify-center',
                                    'title' => 'Статистика'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-calendar-alt"></i>', ['calendar', 'id' => $car->id], [
                                    'class' => 'w-9 h-9 rounded-full bg-gray-100 text-red-600 hover:bg-red-600 hover:text-white transition-all flex items-center justify-centerr',
                                    'title' => 'Календарь'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $car->id], [
                                    'class' => 'w-9 h-9 rounded-full bg-gray-100 text-red-600 hover:bg-red-600 hover:text-white transition-all flex items-center justify-center',
                                    'title' => 'Редактировать'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $car->id], [
                                    'class' => 'w-9 h-9 rounded-full bg-gray-100 text-red-600 hover:bg-red-600 hover:text-white transition-all flex items-center justify-center',
                                    'title' => 'Удалить',
                                    'data-confirm' => 'Вы уверены, что хотите удалить этот автомобиль?',
                                    'data-method' => 'post',
                                ]) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>