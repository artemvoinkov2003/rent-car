<?php

/** @var yii\web\View $this */
/** @var app\models\Car $car */
/** @var app\models\Booking $booking */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Подтверждение бронирования';
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['/catalog/index']];
$this->params['breadcrumbs'][] = ['label' => $car->model->brand->name . ' ' . $car->model->name, 'url' => ['/car/view', 'id' => $car->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="booking-confirm bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
   
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4">Информация об автомобиле</h3>
                <div class="space-y-2">
                    <p><strong>Модель:</strong> <?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?></p>
                    <p><strong>Год:</strong> <?= $car->year ?></p>
                    <p><strong>Цвет:</strong> <?= $car->color ?></p>
                    <p><strong>Цена за день:</strong> <?= Yii::$app->formatter->asCurrency($car->price_per_day, 'RUB') ?></p>
                    <p><strong>Дата начала:</strong> <?= Yii::$app->formatter->asDate($booking->start_date) ?></p>
                    <p><strong>Дата окончания:</strong> <?= Yii::$app->formatter->asDate($booking->end_date) ?></p>
                </div>
                <div class="mt-4 p-3 bg-gray-100 rounded-lg">
                    <p class="font-semibold">Предварительная стоимость: <span id="price-preview" class="font-bold"><?= Yii::$app->formatter->asCurrency($booking->total_price, 'RUB') ?></span></p>
                </div>
            </div>

            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <?php $form = ActiveForm::begin(); ?>

                <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4">Данные водителя</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <?= $form->field($booking, 'driver_license_series')->textInput(['maxlength' => 4, 'placeholder' => '0000']) ?>
                    <?= $form->field($booking, 'driver_license_number')->textInput(['maxlength' => 6, 'placeholder' => '000000']) ?>
                    <?= $form->field($booking, 'driver_license_issued_by')->textInput(['placeholder' => 'Например: УГИБДД по г. Курган']) ?>
                    <?= $form->field($booking, 'driver_license_issue_date')->input('date') ?>
                </div>

                <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mt-6 mb-4">Страховка</h3>
                <div class="grid grid-cols-1 gap-4">
                    <?= $form->field($booking, 'insurance_type')->dropDownList([
                        'basic' => 'Базовая (включена в стоимость)',
                        'extended' => 'Расширенная (+1000 ₽/день)',
                    ], ['id' => 'insurance-type']) ?>
                    <?= $form->field($booking, 'insurance_company')->textInput(['placeholder' => 'Название страховой компании']) ?>
                    <?= $form->field($booking, 'insurance_policy_number')->textInput(['placeholder' => 'Номер полиса']) ?>
                </div>

                <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mt-6 mb-4">Документы и согласие</h3>
                <?= $form->field($booking, 'terms_accepted')->checkbox([
                    'template' => "<div class=\"flex items-start\">{input} <label class=\"ml-2 block text-sm text-gray-700\">{label}</label></div>\n{error}",
                ]) ?>

                <div class="mt-6">
                    <?= Html::submitButton('Завершить бронирование', ['class' => 'w-full py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
$('#insurance-type').change(function() {
    var insuranceType = $(this).val();
    $.ajax({
        url: '/booking/calculate-price',
        method: 'post',
        data: {
            car_id: {$car->id},
            start_date: '{$booking->start_date}',
            end_date: '{$booking->end_date}',
            insurance_type: insuranceType
        },
        success: function(data) {
            if (data.price) {
                $('#price-preview').html(new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', minimumFractionDigits: 0 }).format(data.price));
            }
        },
        error: function() {
            console.error('Ошибка пересчёта стоимости');
        }
    });
});
JS;
$this->registerJs($js);
?>