<?php

/** @var yii\web\View $this */
/** @var app\models\Review $review */
/** @var app\models\Booking $booking */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Оставить отзыв';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/cabinet/index']];
$this->params['breadcrumbs'][] = ['label' => 'Мои бронирования', 'url' => ['bookings']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="review-create bg-gradient-to-br from-white to-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-sport-red/10 rounded-full flex items-center justify-center">
                <i class="fas fa-star text-sport-red text-xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-sport-dark-blue to-sport-red"></div>
                <div class="p-6 md:p-8">
                    <div class="bg-gray-50 p-4 rounded-xl mb-6 flex items-start gap-3">
                        <div class="w-12 h-12 bg-sport-red/10 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-car text-sport-red text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-700 font-lexend">
                                Вы оставляете отзыв на бронирование автомобиля 
                                <strong class="text-sport-dark-blue"><?= Html::encode($booking->car->model->brand->name . ' ' . $booking->car->model->name) ?></strong>
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-calendar-alt mr-1"></i> <?= Yii::$app->formatter->asDate($booking->start_date) ?> – <?= Yii::$app->formatter->asDate($booking->end_date) ?>
                            </p>
                        </div>
                    </div>

                    <?php $form = ActiveForm::begin(['options' => ['class' => 'space-y-6']]); ?>

                    <div>
                        <label class="block text-sm font-medium text-sport-dark-blue font-lexend mb-3">Ваша оценка</label>
                        <div class="flex items-center space-x-2 rating-stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="star cursor-pointer text-4xl transition-all hover:scale-110 <?= $i <= ($review->rating ?: 0) ? 'text-yellow-400' : 'text-gray-300' ?>" data-value="<?= $i ?>">★</span>
                            <?php endfor; ?>
                        </div>
                        <?= $form->field($review, 'rating')->hiddenInput(['id' => 'rating-value'])->label(false) ?>
                    </div>

                    <?= $form->field($review, 'comment')->textarea([
                        'rows' => 5,
                        'placeholder' => 'Поделитесь впечатлениями об автомобиле...',
                        'class' => 'w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-sport-red focus:ring-2 focus:ring-sport-red/20 transition-all font-lexend'
                    ]) ?>

                    <div class="flex justify-end gap-3">
                        <?= Html::a('Отмена', ['bookings'], ['class' => 'px-6 py-2 border border-sport-red text-sm font-medium rounded-xl text-sport-red hover:bg-sport-red hover:text-white transition-all']) ?>
                        <?= Html::submitButton('<i class="fas fa-paper-plane mr-2"></i> Отправить отзыв', [
                            'class' => 'px-6 py-2 border border-transparent text-sm font-medium rounded-xl text-white btn-gradient-custom shadow-md hover:shadow-lg transition-all'
                        ]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
$('.rating-stars .star').hover(
    function() {
        var value = $(this).data('value');
        $(this).prevAll('.star').addBack().addClass('text-yellow-400').removeClass('text-gray-300');
        $(this).nextAll('.star').removeClass('text-yellow-400').addClass('text-gray-300');
    },
    function() {
        var current = $('#rating-value').val();
        $('.rating-stars .star').each(function() {
            var val = $(this).data('value');
            if (val <= current) {
                $(this).addClass('text-yellow-400').removeClass('text-gray-300');
            } else {
                $(this).removeClass('text-yellow-400').addClass('text-gray-300');
            }
        });
    }
).click(function() {
    var value = $(this).data('value');
    $('#rating-value').val(value);
});
JS;
$this->registerJs($js);
?>