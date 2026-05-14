<?php

/** @var yii\web\View $this */
/** @var app\models\Car $car */
/** @var array $models */
/** @var array $features */
/** @var array $selectedFeatures */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = $car->isNewRecord ? 'Добавить автомобиль' : 'Редактировать автомобиль';
$this->params['breadcrumbs'][] = ['label' => 'Мои автомобили', 'url' => ['cars']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="owner-form bg-gradient-to-br from-white to-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-sport-red/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-car text-sport-red text-xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= Html::encode($this->title) ?></h1>
            </div>

            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-sport-dark-blue to-sport-red"></div>
                <div class="p-6 md:p-8">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'space-y-8']]); ?>

                    <div class="bg-light-bg p-5 rounded-xl shadow-sm hover:shadow-md transition-all">
                        <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4 flex items-center gap-2">
                            <i class="fas fa-info-circle text-sport-red"></i> Основная информация
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                            <?= $form->field($car, 'model_id')->dropDownList(
                                ArrayHelper::map($models, 'id', function($model) {
                                    return $model->brand->name . ' ' . $model->name;
                                }),
                                ['class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend', 'prompt' => 'Выберите модель']
                            ) ?>
                            <?= $form->field($car, 'year')->textInput(['type' => 'number', 'class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend', 'placeholder' => '2021']) ?>
                            <?= $form->field($car, 'color')->textInput(['class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend', 'placeholder' => 'Белый']) ?>
                            <?= $form->field($car, 'license_plate')->textInput(['class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend', 'placeholder' => 'А123ВВ777']) ?>
                            <?= $form->field($car, 'mileage')->textInput(['type' => 'number', 'class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend', 'placeholder' => '50000']) ?>
                        </div>
                    </div>

                    <div class="bg-light-bg p-5 rounded-xl shadow-sm hover:shadow-md transition-all">
                        <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4 flex items-center gap-2">
                            <i class="fas fa-ruble-sign text-sport-red"></i> Цены и залог
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <?= $form->field($car, 'price_per_day')->textInput(['type' => 'number', 'step' => '0.01', 'class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend', 'placeholder' => '3500']) ?>
                            <?= $form->field($car, 'price_per_hour')->textInput(['type' => 'number', 'step' => '0.01', 'class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend', 'placeholder' => '250']) ?>
                            <?= $form->field($car, 'deposit')->textInput(['type' => 'number', 'step' => '0.01', 'class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend', 'placeholder' => '5000']) ?>
                        </div>
                    </div>

                    <div class="bg-light-bg p-5 rounded-xl shadow-sm hover:shadow-md transition-all">
                        <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4 flex items-center gap-2">
                            <i class="fas fa-cogs text-sport-red"></i> Технические характеристики
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                            <?= $form->field($car, 'body_type')->dropDownList([
                                'sedan' => 'Седан',
                                'hatchback' => 'Хэтчбек',
                                'suv' => 'Внедорожник',
                                'coupe' => 'Купе',
                                'convertible' => 'Кабриолет',
                                'wagon' => 'Универсал',
                            ], ['class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend', 'prompt' => 'Выберите тип кузова']) ?>
                            <?= $form->field($car, 'transmission')->dropDownList([
                                'manual' => 'Механика',
                                'automatic' => 'Автомат',
                                'robotic' => 'Робот',
                                'variator' => 'Вариатор',
                            ], ['class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend', 'prompt' => 'Выберите КПП']) ?>
                            <?= $form->field($car, 'engine_volume')->textInput(['type' => 'number', 'step' => '0.1', 'class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend', 'placeholder' => '2.0']) ?>
                            <?= $form->field($car, 'fuel_type')->dropDownList([
                                'petrol' => 'Бензин',
                                'diesel' => 'Дизель',
                                'electric' => 'Электро',
                                'hybrid' => 'Гибрид',
                            ], ['class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend', 'prompt' => 'Выберите топливо']) ?>
                            <?= $form->field($car, 'drive_type')->dropDownList([
                                'rear' => 'Задний',
                                'front' => 'Передний',
                                'all' => 'Полный',
                            ], ['class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend', 'prompt' => 'Выберите привод']) ?>
                            <?= $form->field($car, 'fuel_consumption')->textInput(['type' => 'number', 'step' => '0.1', 'class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend', 'placeholder' => '8.5']) ?>
                        </div>
                    </div>

                    <div class="bg-light-bg p-5 rounded-xl shadow-sm hover:shadow-md transition-all">
                        <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4 flex items-center gap-2">
                            <i class="fas fa-sliders-h text-sport-red"></i> Дополнительные опции
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 font-lexend mb-2">Способы оплаты</label>
                                <?= $form->field($car, 'payment_options')->checkboxList([
                                    'cash' => 'Наличные',
                                    'card' => 'Карта',
                                    'transfer' => 'Перевод',
                                ], ['class' => 'space-y-2', 'itemOptions' => ['class' => 'mr-2 rounded border-gray-300 text-sport-red focus:ring-sport-red']])->label(false) ?>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 font-lexend mb-2">Страховка</label>
                                <?= $form->field($car, 'insurance_options')->checkboxList([
                                    'basic' => 'Базовая защита',
                                    'full' => 'Полное покрытие',
                                ], ['class' => 'space-y-2', 'itemOptions' => ['class' => 'mr-2 rounded border-gray-300 text-sport-red focus:ring-sport-red']])->label(false) ?>
                            </div>
                        </div>
                        <div class="mt-4">
                            <?= $form->field($car, 'category')->dropDownList([
                                'premium' => 'Премиум',
                                'sport' => 'Спорт',
                            ], ['class' => 'w-full md:w-1/2 px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend']) ?>
                        </div>
                        <?= $form->field($car, 'description')->textarea(['rows' => 4, 'class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend', 'placeholder' => 'Описание автомобиля...']) ?>
                    </div>

                    <div class="bg-light-bg p-5 rounded-xl shadow-sm hover:shadow-md transition-all">
                        <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4 flex items-center gap-2">
                            <i class="fas fa-star text-sport-red"></i> Особенности
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <?php foreach ($features as $feature): ?>
                                <label class="flex items-center gap-2 p-2 border border-sport-red rounded-xl hover:bg-sport-red/5 transition-all cursor-pointer">
                                    <input type="checkbox" name="features[]" value="<?= $feature->id ?>" 
                                        <?= in_array($feature->id, $selectedFeatures ?? []) ? 'checked' : '' ?>
                                        class="rounded border-gray-300 text-sport-red focus:ring-sport-red">
                                    <span class="text-sm font-lexend text-gray-700"><?= $feature->name ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="bg-light-bg p-5 rounded-xl shadow-sm hover:shadow-md transition-all">
                        <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4 flex items-center gap-2">
                            <i class="fas fa-images text-sport-red"></i> Фотографии
                        </h3>
                        <?= $form->field($car, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*', 'class' => 'w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend']) ?>
                        <p class="text-xs text-gray-500 mt-1">Можно выбрать несколько изображений. Первое будет главным.</p>
                        <?php if (!$car->isNewRecord && $car->carImages): ?>
                            <div class="mt-4">
                                <h4 class="font-medium text-gray-700 mb-2">Текущие фото</h4>
                                <div class="flex flex-wrap gap-3">
                                    <?php foreach ($car->carImages as $image): ?>
                                        <div class="relative w-24 h-24 group">
                                            <img src="<?= $image->image_path ?>" class="w-full h-full object-cover rounded-lg shadow-md border-2 <?= $image->is_main ? 'border-sport-red' : 'border-gray-200' ?>">
                                            <?php if (!$image->is_main): ?>
                                                <?= Html::a('Главное', ['/owner/set-main-image', 'id' => $image->id], [
                                                    'class' => 'absolute bottom-0 left-0 right-0 text-xs bg-black/60 text-white text-center py-1 rounded-b-lg opacity-0 group-hover:opacity-100 transition',
                                                    'data-method' => 'post',
                                                ]) ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <?= Html::a('Отмена', ['cars'], ['class' => 'px-6 py-2 border border-sport-red text-sm font-medium rounded-xl text-sport-red hover:bg-sport-red hover:text-white transition-all']) ?>
                        <?= Html::submitButton($car->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'px-8 py-2 border border-transparent text-sm font-medium rounded-xl text-white btn-gradient-custom shadow-md hover:shadow-lg transition-all']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>