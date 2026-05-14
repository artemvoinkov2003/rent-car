<?php

/** @var yii\web\View $this */
/** @var app\models\Car $car */
/** @var int $totalBookings */
/** @var int $completedBookings */
/** @var float $totalIncome */
/** @var array $monthlyIncome */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'Статистика: ' . $car->model->brand->name . ' ' . $car->model->name;
$this->params['breadcrumbs'][] = ['label' => 'Мои автомобили', 'url' => ['cars']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js');
?>

<div class="owner-stats bg-gradient-to-br from-white to-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-sport-red/10 rounded-full flex items-center justify-center">
                <i class="fas fa-chart-line text-sport-red text-xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fadeInUp">
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-lexend text-gray-500">Всего бронирований</p>
                        <p class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= $totalBookings ?></p>
                    </div>
                    <div class="w-12 h-12 bg-sport-red/10 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-check text-2xl text-sport-red"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-lexend text-gray-500">Завершённых</p>
                        <p class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= $completedBookings ?></p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-2xl text-green-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-lexend text-gray-500">Общий доход</p>
                        <p class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= Yii::$app->formatter->asCurrency($totalIncome, 'RUB') ?></p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-ruble-sign text-2xl text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-xl transition-all animate-fadeInUp">
            <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line text-sport-red"></i> Доход по месяцам
            </h3>
            <?php if (array_sum($monthlyIncome) == 0): ?>
                <div class="py-12 text-center">
                    <div class="text-6xl mb-4">📊</div>
                    <p class="text-gray-500 font-lexend">В данный момент дохода нет.</p>
                    <p class="text-sm text-gray-400 mt-2">После первых завершённых бронирований здесь появится график.</p>
                </div>
            <?php else: ?>
                <canvas id="incomeChart" width="400" height="200"></canvas>
            <?php endif; ?>
        </div>

        <div class="mt-6 text-center">
            <?= Html::a('Вернуться к списку', ['cars'], ['class' => 'py-2 px-6 border border-transparent text-sm font-medium rounded-xl text-white btn-gradient-custom shadow-md hover:shadow-lg transition-all']) ?>
        </div>
    </div>
</div>

<?php
if (array_sum($monthlyIncome) > 0) {
    $labels = json_encode(array_keys($monthlyIncome));
    $values = json_encode(array_values($monthlyIncome));
    $js = <<<JS
    var ctx = document.getElementById('incomeChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: $labels,
            datasets: [{
                label: 'Доход, ₽',
                data: $values,
                borderColor: '#dc2626',
                backgroundColor: 'rgba(220,38,38,0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#e5e7eb' } },
                x: { grid: { display: false } }
            }
        }
    });
    JS;
    $this->registerJs($js);
}
?>