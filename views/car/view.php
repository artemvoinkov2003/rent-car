<?php

/** @var yii\web\View $this */
/** @var app\models\Car $car */
/** @var array $bookedDates */
/** @var bool $isFavorite */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $car->model->brand->name . ' ' . $car->model->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['/catalog/index']];
$this->params['breadcrumbs'][] = $this->title;


function translateDriveType($type) {
    $map = ['rear' => 'Задний', 'front' => 'Передний', 'all' => 'Полный'];
    return $map[$type] ?? $type;
}
function translateFuelType($type) {
    $map = ['petrol' => 'Бензин', 'diesel' => 'Дизель', 'electric' => 'Электро', 'hybrid' => 'Гибрид'];
    return $map[$type] ?? $type;
}
function translatePaymentOptions($options) {
    if (!$options) return '—';
    $map = ['cash' => 'Наличные', 'card' => 'Карта', 'transfer' => 'Перевод'];
    $selected = explode(',', $options);
    $result = [];
    foreach ($selected as $opt) {
        if (isset($map[$opt])) $result[] = $map[$opt];
    }
    return implode(', ', $result);
}
function translateInsuranceOptions($options) {
    if (!$options) return '—';
    $map = ['basic' => 'Базовая защита', 'full' => 'Полное покрытие'];
    $selected = explode(',', $options);
    $result = [];
    foreach ($selected as $opt) {
        if (isset($map[$opt])) $result[] = $map[$opt];
    }
    return implode(', ', $result);
}
function translateBodyType($type) {
    $map = [
        'sedan' => 'Седан', 'hatchback' => 'Хэтчбек', 'suv' => 'Внедорожник',
        'coupe' => 'Купе', 'convertible' => 'Кабриолет', 'wagon' => 'Универсал'
    ];
    return $map[$type] ?? $type;
}

$similarCars = \app\models\Car::find()
    ->where(['model_id' => $car->model_id, 'status' => 'available'])
    ->andWhere(['<>', 'id', $car->id])
    ->limit(3)
    ->all();
if (empty($similarCars)) {
    $similarCars = \app\models\Car::find()
        ->where(['status' => 'available'])
        ->andWhere(['<>', 'id', $car->id])
        ->limit(3)
        ->all();
}

$csrfToken = Yii::$app->request->csrfToken;
?>

<div class="car-view bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6 fade-in"><?= Html::encode($this->title) ?></h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
           
            <div class="lg:col-span-2 space-y-6">

                
                <?php if ($car->carImages): ?>
                    <div class="bg-light-bg p-4 rounded-xl shadow-strong fade-in delay-1">
                       
                        <div class="mb-4 overflow-hidden rounded-xl shadow-lg cursor-pointer group" onclick="showImage('<?= $car->carImages[0]->image_path ?>')">
                            <img src="<?= $car->carImages[0]->image_path ?>" alt="Главное фото" 
                                 class="w-full h-96 object-cover transition-transform duration-700 group-hover:scale-105">
                        </div>
                        
                        <div class="grid grid-cols-4 gap-2">
                            <?php foreach ($car->carImages as $index => $image): ?>
                                <div class="overflow-hidden rounded-lg cursor-pointer border-2 transition-all duration-200 <?= $index === 0 ? 'border-sport-red' : 'border-transparent hover:border-gray-300' ?>" 
                                     onclick="showImage('<?= $image->image_path ?>')">
                                    <img src="<?= $image->image_path ?>" alt="Миниатюра" 
                                         class="w-full h-24 object-cover transition-transform duration-300 hover:scale-110">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="bg-light-bg p-6 rounded-xl shadow-strong hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 fade-in delay-2">
                    <h2 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-sport-red"></i> Характеристики
                    </h2>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-0">
                        <?php 
                        $attrs = [
                            'year' => ['label' => 'Год выпуска', 'icon' => 'fas fa-calendar-alt', 'value' => $car->year],
                            'color' => ['label' => 'Цвет', 'icon' => 'fas fa-palette', 'value' => $car->color],
                            'mileage' => ['label' => 'Пробег', 'icon' => 'fas fa-tachometer-alt', 'value' => Yii::$app->formatter->asInteger($car->mileage) . ' км'],
                            'body_type' => ['label' => 'Тип кузова', 'icon' => 'fas fa-car', 'value' => translateBodyType($car->body_type)],
                            'transmission' => ['label' => 'Коробка передач', 'icon' => 'fas fa-cogs', 'value' => $car->transmission == 'automatic' ? 'Автомат' : 'Механика'],
                            'engine_volume' => ['label' => 'Объём двигателя', 'icon' => 'fas fa-oil-can', 'value' => $car->engine_volume . ' л'],
                            'fuel_type' => ['label' => 'Топливо', 'icon' => 'fas fa-gas-pump', 'value' => translateFuelType($car->fuel_type)],
                            'drive_type' => ['label' => 'Привод', 'icon' => 'fas fa-industry', 'value' => translateDriveType($car->drive_type)],
                            'fuel_consumption' => ['label' => 'Расход топлива', 'icon' => 'fas fa-chart-line', 'value' => $car->fuel_consumption ? $car->fuel_consumption . ' л/100км' : '—'],
                            'payment_options' => ['label' => 'Способы оплаты', 'icon' => 'fas fa-credit-card', 'value' => translatePaymentOptions($car->payment_options)],
                            'insurance_options' => ['label' => 'Страховка', 'icon' => 'fas fa-shield-alt', 'value' => translateInsuranceOptions($car->insurance_options)],
                        ];
                        $i = 0;
                        foreach ($attrs as $key => $attr):
                            $bg = $i % 2 == 0 ? 'bg-white/50' : '';
                        ?>
                            <div class="flex items-start gap-3 py-3 px-2 border-b border-gray-100 <?= $bg ?> hover:bg-gray-50 transition-colors">
                                <div class="w-8 text-sport-red">
                                    <i class="<?= $attr['icon'] ?>"></i>
                                </div>
                                <div class="flex-1">
                                    <dt class="text-sm font-medium text-gray-500 font-lexend"><?= $attr['label'] ?></dt>
                                    <dd class="text-base font-semibold text-gray-800 font-lexend"><?= $attr['value'] ?></dd>
                                </div>
                            </div>
                        <?php $i++; endforeach; ?>
                    </dl>
                </div>

                <?php if ($car->features): ?>
                <div class="bg-light-bg p-6 rounded-xl shadow-strong hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 fade-in delay-3">
                    <h2 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-4 flex items-center gap-2">
                        <i class="fas fa-star text-sport-red"></i> Особенности
                    </h2>
                    <div class="flex flex-wrap gap-3">
                        <?php foreach ($car->features as $feature): ?>
                            <span class="px-4 py-2 bg-sport-red text-white rounded-full text-sm font-lexend shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                                <i class="<?= $feature->icon ?> mr-1"></i> <?= $feature->name ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($car->reviews): ?>
                <div class="bg-light-bg p-6 rounded-xl shadow-strong hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 fade-in delay-4">
                    <h2 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-4 flex items-center gap-2">
                        <i class="fas fa-comments text-sport-red"></i> Отзывы
                    </h2>
                    <?php foreach ($car->reviews as $review): ?>
                        <div class="border-b border-sport-red/20 last:border-0 py-4 hover:bg-white/30 transition-colors rounded-lg px-2">
                            <div class="flex items-center mb-2">
                                <span class="text-yellow-500">
                                    <?php for ($i=1; $i<=5; $i++): ?>
                                        <i class="fas fa-star <?= $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' ?>"></i>
                                    <?php endfor; ?>
                                </span>
                                <span class="ml-2 text-sm text-gray-600 font-lexend"><?= Yii::$app->formatter->asDate($review->created_at) ?></span>
                            </div>
                            <p class="text-gray-700 font-lexend"><?= Html::encode($review->comment) ?></p>
                            <p class="text-sm text-gray-500 mt-1">— <?= Html::encode($review->booking->user->username) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="lg:col-span-1 space-y-6">
                
                <div class="bg-light-bg p-6 rounded-xl shadow-strong sticky top-24 hover:shadow-xl transition-all duration-300 fade-in delay-2">
                    <div class="text-center mb-6">
                        <span class="text-4xl font-bold text-sport-dark-blue font-outfit"><?= Yii::$app->formatter->asCurrency($car->price_per_day, 'RUB') ?></span>
                        <span class="text-gray-600 font-lexend">/ день</span>
                        <?php if ($car->price_per_hour): ?>
                            <p class="text-sm text-gray-600 font-lexend">или <?= Yii::$app->formatter->asCurrency($car->price_per_hour, 'RUB') ?>/час</p>
                        <?php endif; ?>
                    </div>

                    <?php $form = ActiveForm::begin(['action' => ['/booking/create'], 'method' => 'post']); ?>
                        <?= Html::hiddenInput('car_id', $car->id) ?>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1">Дата начала</label>
                            <input type="date" name="start_date" class="w-full px-3 py-2 border border-sport-red rounded-md font-lexend focus:ring-2 focus:ring-sport-red transition-all" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-1">Дата окончания</label>
                            <input type="date" name="end_date" class="w-full px-3 py-2 border border-sport-red rounded-md font-lexend focus:ring-2 focus:ring-sport-red transition-all" required>
                        </div>
                        <?= Html::submitButton('Забронировать', [
                            'class' => 'w-full py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom mb-3 hover:shadow-lg transition-all'
                        ]) ?>
                    <?php ActiveForm::end(); ?>

                    <?php if (!Yii::$app->user->isGuest): ?>
                        <button class="w-full py-2 px-4 border border-sport-red text-sm font-medium rounded-md transition-all duration-200 <?= $isFavorite ? 'bg-sport-red text-white' : 'text-sport-red hover:bg-sport-red hover:text-white' ?> favorite-btn-car" data-car-id="<?= $car->id ?>" data-favorite="<?= $isFavorite ? 1 : 0 ?>">
                            <i class="fas fa-heart mr-2"></i><?= $isFavorite ? 'В избранном' : 'В избранное' ?>
                        </button>
                    <?php else: ?>
                        <p class="text-sm text-gray-600 text-center font-lexend"><?= Html::a('Войдите', ['/site/login'], ['class' => 'text-sport-red hover:underline']) ?>, чтобы добавить в избранное</p>
                    <?php endif; ?>
                </div>

                <?php if (!empty($similarCars)): ?>
                <div class="bg-light-bg p-6 rounded-xl shadow-strong hover:shadow-xl transition-all duration-300 fade-in delay-3">
                    <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4 flex items-center gap-2">
                        <i class="fas fa-copy text-sport-red"></i> Похожие автомобили
                    </h3>
                    <div class="space-y-3">
                        <?php foreach ($similarCars as $similarCar): 
                            $simImage = $similarCar->mainImage ? $similarCar->mainImage->image_path : '/images/no-car.png';
                        ?>
                            <a href="<?= Url::to(['/car/view', 'id' => $similarCar->id]) ?>" class="flex items-center gap-3 p-2 rounded-lg transition-all duration-200 hover:bg-white hover:shadow-md hover:-translate-y-0.5 group">
                                <div class="w-16 h-16 rounded-md overflow-hidden bg-gray-100 flex-shrink-0">
                                    <img src="<?= $simImage ?>" alt="<?= Html::encode($similarCar->model->brand->name . ' ' . $similarCar->model->name) ?>" class="w-full h-full object-cover transition-transform group-hover:scale-110">
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 font-lexend group-hover:text-sport-red"><?= Html::encode($similarCar->model->brand->name . ' ' . $similarCar->model->name) ?></p>
                                    <p class="text-sm text-gray-500"><?= Yii::$app->formatter->asCurrency($similarCar->price_per_day, 'RUB') ?>/день</p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50" onclick="this.classList.add('hidden')">
    <img id="modalImage" src="" class="max-w-full max-h-full" alt="Увеличенное фото">
</div>

<?php
$js = <<<JS
function showImage(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
}

$('.favorite-btn-car').click(function(e) {
    e.preventDefault();
    var btn = $(this);
    var carId = btn.data('car-id');
    $.ajax({
        url: '/favorite/toggle',
        method: 'post',
        data: {car_id: carId, _csrf: '{$csrfToken}'},
        success: function(data) {
            if (data.added) {
                btn.html('<i class="fas fa-heart mr-2"></i>В избранном').addClass('bg-sport-red text-white').removeClass('text-sport-red hover:bg-sport-red hover:text-white');
                toastr.success('Автомобиль добавлен в избранное');
            } else {
                btn.html('<i class="fas fa-heart mr-2"></i>В избранное').removeClass('bg-sport-red text-white').addClass('text-sport-red hover:bg-sport-red hover:text-white');
                toastr.info('Автомобиль удалён из избранного');
            }
        }
    });
});
JS;
$this->registerJs($js);
?>