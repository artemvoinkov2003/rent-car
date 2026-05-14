<?php

/** @var yii\web\View $this */
/** @var app\models\Car[] $cars */
/** @var yii\data\Pagination $pages */
/** @var app\models\CarBrand[] $brands */
/** @var app\models\CarFeature[] $allFeatures */
/** @var array $filters */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Каталог автомобилей';
$this->params['breadcrumbs'][] = $this->title;

$driveTypes = ['rear' => 'Задний', 'front' => 'Передний', 'all' => 'Полный'];
$paymentOptions = ['cash' => 'Наличные', 'card' => 'Карта', 'transfer' => 'Перевод'];
$insuranceOptions = ['basic' => 'Базовая защита', 'full' => 'Полное покрытие'];

$userId = Yii::$app->user->isGuest ? null : Yii::$app->user->id;
?>

<div class="catalog-index bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <div class="bg-white p-6 rounded-2xl shadow-xl mb-8 border border-sport-dark-blue/20">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['/catalog/index'],
                'options' => ['class' => 'space-y-5', 'id' => 'filter-form'],
            ]); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5">
                <div>
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-tag mr-1"></i> Бренд</label>
                    <?= Html::dropDownList('brand', $filters['brand'] ?? '', 
                        \yii\helpers\ArrayHelper::map($brands, 'id', 'name'), 
                        ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all bg-white', 'prompt' => 'Все бренды']) ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-ruble-sign mr-1"></i> Цена от</label>
                    <?= Html::input('number', 'price_min', $filters['price_min'] ?? '', ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all', 'placeholder' => 'от']) ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-ruble-sign mr-1"></i> Цена до</label>
                    <?= Html::input('number', 'price_max', $filters['price_max'] ?? '', ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all', 'placeholder' => 'до']) ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-calendar-alt mr-1"></i> Год от</label>
                    <?= Html::input('number', 'year_min', $filters['year_min'] ?? '', ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all', 'placeholder' => 'от']) ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-calendar-alt mr-1"></i> Год до</label>
                    <?= Html::input('number', 'year_max', $filters['year_max'] ?? '', ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all', 'placeholder' => 'до']) ?>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <div>
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-car mr-1"></i> Тип кузова</label>
                    <?= Html::dropDownList('body_type', $filters['body_type'] ?? '', [
                        'sedan' => 'Седан',
                        'hatchback' => 'Хэтчбек',
                        'suv' => 'Внедорожник',
                        'coupe' => 'Купе',
                        'convertible' => 'Кабриолет',
                        'wagon' => 'Универсал',
                    ], ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all bg-white', 'prompt' => 'Любой']) ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-cogs mr-1"></i> Коробка</label>
                    <?= Html::dropDownList('transmission', $filters['transmission'] ?? '', [
                        'manual' => 'Механика',
                        'automatic' => 'Автомат',
                        'robotic' => 'Робот',
                        'variator' => 'Вариатор',
                    ], ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all bg-white', 'prompt' => 'Любая']) ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-industry mr-1"></i> Привод</label>
                    <?= Html::dropDownList('drive_type', $filters['drive_type'] ?? '', $driveTypes, ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all bg-white', 'prompt' => 'Любой']) ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-gas-pump mr-1"></i> Топливо</label>
                    <?= Html::dropDownList('fuel_type', $filters['fuel_type'] ?? '', [
                        'petrol' => 'Бензин',
                        'diesel' => 'Дизель',
                        'electric' => 'Электро',
                        'hybrid' => 'Гибрид',
                    ], ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all bg-white', 'prompt' => 'Любой']) ?>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <div>
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-oil-can mr-1"></i> Объём, от (л)</label>
                    <?= Html::input('number', 'engine_volume_min', $filters['engine_volume_min'] ?? '', ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all', 'placeholder' => 'от', 'step' => '0.1']) ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-oil-can mr-1"></i> Объём, до (л)</label>
                    <?= Html::input('number', 'engine_volume_max', $filters['engine_volume_max'] ?? '', ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all', 'placeholder' => 'до', 'step' => '0.1']) ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-tachometer-alt mr-1"></i> Расход, от (л/100км)</label>
                    <?= Html::input('number', 'consumption_min', $filters['consumption_min'] ?? '', ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all', 'placeholder' => 'от', 'step' => '0.1']) ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-tachometer-alt mr-1"></i> Расход, до (л/100км)</label>
                    <?= Html::input('number', 'consumption_max', $filters['consumption_max'] ?? '', ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all', 'placeholder' => 'до', 'step' => '0.1']) ?>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-credit-card mr-1"></i> Оплата</label>
                    <?= Html::dropDownList('payment', $filters['payment'] ?? '', $paymentOptions, ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all bg-white', 'prompt' => 'Любой']) ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-shield-alt mr-1"></i> Страховка</label>
                    <?= Html::dropDownList('insurance', $filters['insurance'] ?? '', $insuranceOptions, ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all bg-white', 'prompt' => 'Любая']) ?>
                </div>
            </div>

            <div class="flex flex-wrap items-end gap-5 pt-3">
                <div class="w-48">
                    <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1"><i class="fas fa-sort-amount-down mr-1"></i> Сортировка</label>
                    <?= Html::dropDownList('sort', $filters['sort'] ?? '', [
                        'default' => 'По умолчанию',
                        'price_asc' => 'Цена (возрастание)',
                        'price_desc' => 'Цена (убывание)',
                        'year_asc' => 'Год (старые)',
                        'year_desc' => 'Год (новые)',
                        'rating_desc' => 'По рейтингу',
                    ], ['class' => 'w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all bg-white']) ?>
                </div>
                <div class="flex gap-3">
                    <?= Html::submitButton('<i class="fas fa-search mr-2"></i> Применить', ['class' => 'py-2.5 px-6 border border-transparent text-sm font-medium rounded-xl text-white btn-gradient-custom shadow-md hover:shadow-lg transition-all']) ?>
                    <?= Html::a('<i class="fas fa-undo-alt mr-2"></i> Сбросить', ['/catalog/index'], ['class' => 'py-2.5 px-6 border border-sport-red text-sm font-medium rounded-xl text-sport-red hover:bg-sport-red transition-all shadow-sm']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <?php if (empty($cars)): ?>
            <div class="bg-form-bg p-12 rounded-xl shadow-strong text-center">
                <div class="text-6xl mb-4">🚗❌</div>
                <h3 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-2">Автомобили не найдены</h3>
                <p class="text-gray-600 font-lexend">Попробуйте изменить параметры фильтрации.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($cars as $car): 
                    $isSport = $car->category === 'sport';
                    $mainImage = $car->mainImage;
                    $imageUrl = $mainImage ? $mainImage->image_path : '/images/no-car.png';
                    $inFavorite = $userId ? \app\models\Favorite::find()->where(['user_id' => $userId, 'car_id' => $car->id])->exists() : false;
                ?>
                    <div class="group <?= $isSport ? 'card-sport' : 'card-premium' ?> rounded-xl overflow-hidden shadow-strong hover:shadow-stronger transition-all duration-300 hover:ring-2 hover:ring-sport-red">
                        <div class="h-48 bg-cover bg-center relative" style="background-image: url('<?= $imageUrl ?>');">
                            <?php if (!Yii::$app->user->isGuest): ?>
                                <?= Html::beginForm(['/favorite/toggle'], 'post', ['class' => 'absolute top-2 right-2 z-10']) ?>
                                    <?= Html::hiddenInput('car_id', $car->id) ?>
                                    <button type="submit" class="w-10 h-10 rounded-full flex items-center justify-center transition-colors
                                        <?= $inFavorite ? 'bg-sport-red text-white hover:bg-red-700' : 'bg-white bg-opacity-80 text-sport-red hover:bg-sport-red hover:text-white' ?>">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                <?= Html::endForm() ?>
                            <?php endif; ?>
                        </div>
                        <div class="p-5">
                            <h3 class="text-xl font-bold font-outfit <?= $isSport ? 'text-white' : 'text-premium-black' ?>">
                                <?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?>
                            </h3>
                            <p class="text-sm font-lexend <?= $isSport ? 'text-gray-200' : 'text-gray-600' ?>">
                                <?= $car->year ?> г., <?= $car->engine_volume ?> л, <?= $car->transmission == 'automatic' ? 'автомат' : 'механика' ?>, <?= $car->drive_type ?>
                            </p>
                            <div class="mt-3 flex flex-wrap gap-2">
                                <?php foreach ($car->features as $feature): ?>
                                    <span class="inline-block px-2 py-1 text-xs rounded-full <?= $isSport ? 'bg-sport-red text-white' : 'bg-sport-red bg-opacity-10 text-white' ?>">
                                        <i class="<?= $feature->icon ?> mr-1"></i><?= $feature->name ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                            <div class="mt-4 flex justify-between items-center">
                                <div>
                                    <span class="text-2xl font-bold <?= $isSport ? 'text-white' : 'text-premium-black' ?>">
                                        <?= Yii::$app->formatter->asCurrency($car->price_per_day, 'RUB') ?>
                                    </span>
                                    <span class="text-sm <?= $isSport ? 'text-gray-200' : 'text-gray-600' ?>">/день</span>
                                </div>
                                <?= Html::a('Подробнее', ['/car/view', 'id' => $car->id], [
                                    'class' => 'py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-10 flex justify-center">
                <div class="pagination-wrapper">
                    <?= \yii\widgets\LinkPager::widget([
                        'pagination' => $pages,
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
    </div>
</div>