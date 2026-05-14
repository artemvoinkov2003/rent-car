<?php

/** @var yii\web\View $this */
/** @var app\models\Favorite[] $favorites */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Избранное';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/cabinet/index']];
$this->params['breadcrumbs'][] = $this->title;

$userId = Yii::$app->user->id;
?>

<div class="cabinet-favorites bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <?php if (empty($favorites)): ?>
            <div class="bg-form-bg p-12 rounded-xl shadow-strong text-center">
                <div class="text-6xl mb-4">❤️</div>
                <h3 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-2">Избранное пусто</h3>
                <p class="text-gray-600 font-lexend">Добавляйте понравившиеся автомобили в избранное.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($favorites as $favorite): 
                    $car = $favorite->car;
                    $imageUrl = $car->mainImage ? $car->mainImage->image_path : '/images/no-car.png';
                ?>
                    <div class="group card-premium rounded-xl overflow-hidden shadow-strong hover:shadow-stronger transition-all duration-300 hover:ring-2 hover:ring-sport-red">
                        <div class="h-48 bg-cover bg-center relative" style="background-image: url('<?= $imageUrl ?>');">
                            <?= Html::beginForm(['/favorite/toggle'], 'post', ['class' => 'absolute top-2 right-2 z-10']) ?>
                                <?= Html::hiddenInput('car_id', $car->id) ?>
                                <button type="submit" class="w-10 h-10 rounded-full bg-white bg-opacity-80 hover:bg-sport-red text-sport-red hover:text-white transition-colors flex items-center justify-center">
                                    <i class="fas fa-heart"></i>
                                </button>
                            <?= Html::endForm() ?>
                        </div>
                        <div class="p-5">
                            <h3 class="text-xl font-bold font-outfit text-premium-black">
                                <?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?>
                            </h3>
                            <p class="text-sm font-lexend text-gray-600">
                                <?= $car->year ?> г., <?= $car->engine_volume ?> л, <?= $car->transmission == 'automatic' ? 'автомат' : 'механика' ?>
                            </p>
                            <div class="mt-4 flex justify-between items-center">
                                <div>
                                    <span class="text-2xl font-bold text-premium-black">
                                        <?= Yii::$app->formatter->asCurrency($car->price_per_day, 'RUB') ?>
                                    </span>
                                    <span class="text-sm text-gray-600">/день</span>
                                </div>
                                <?= Html::a('Подробнее', ['/car/view', 'id' => $car->id], [
                                    'class' => 'py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>