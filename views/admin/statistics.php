<?php

use yii\helpers\Html;
use yii\web\JsExpression;

$this->title = 'Статистика';
$this->params['breadcrumbs'][] = ['label' => 'Панель администратора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js');
?>

<div class="admin-statistics bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4">Доход по месяцам</h3>
                <canvas id="incomeChart" width="400" height="200"></canvas>
            </div>
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4">Статусы бронирований</h3>
                <canvas id="statusChart" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4">Популярные автомобили</h3>
                <canvas id="popularCarsChart" width="400" height="200"></canvas>
            </div>
            
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4">Пользователи по ролям</h3>
                <canvas id="usersByRoleChart" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 mb-8">
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4">Бронирования по дням недели (последние 30 дней)</h3>
                <canvas id="weekdayChart" width="800" height="250"></canvas>
            </div>
        </div>

        <div class="bg-light-bg p-6 rounded-xl shadow-strong">
            <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4">Топ клиентов по сумме потраченных средств</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Клиент</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Потрачено</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($topClients as $client): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?= Html::encode($client['first_name'] . ' ' . $client['last_name'] . ' (@' . $client['username'] . ')') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= Yii::$app->formatter->asCurrency($client['total_spent'] ?: 0, 'RUB') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$monthsJson = json_encode($months);
$incomeJson = json_encode($income);
$statusLabels = json_encode(array_keys($bookingsByStatus));
$statusJson = json_encode(array_values($bookingsByStatus));

$popularNames = json_encode(array_column($popularCarsData, 'name'));
$popularCounts = json_encode(array_column($popularCarsData, 'count'));

$roleLabels = json_encode(['Пользователи', 'Владельцы', 'Админы']);
$roleCounts = json_encode(array_values($usersByRole));


$weekdayLabels = json_encode($weekDays);
$weekdayCounts = json_encode($bookingsByWeekday);

$js = <<<JS

new Chart(document.getElementById('incomeChart'), {
    type: 'line',
    data: {
        labels: $monthsJson,
        datasets: [{
            label: 'Доход, ₽',
            data: $incomeJson,
            borderColor: '#dc2626',
            backgroundColor: 'rgba(220,38,38,0.1)',
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});

new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: $statusLabels,
        datasets: [{
            data: $statusJson,
            backgroundColor: ['#fbbf24', '#34d399', '#ef4444', '#9ca3af']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});

new Chart(document.getElementById('popularCarsChart'), {
    type: 'bar',
    data: {
        labels: $popularNames,
        datasets: [{
            label: 'Количество бронирований',
            data: $popularCounts,
            backgroundColor: '#dc2626',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

new Chart(document.getElementById('usersByRoleChart'), {
    type: 'doughnut',
    data: {
        labels: $roleLabels,
        datasets: [{
            data: $roleCounts,
            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});

new Chart(document.getElementById('weekdayChart'), {
    type: 'bar',
    data: {
        labels: $weekdayLabels,
        datasets: [{
            label: 'Количество бронирований',
            data: $weekdayCounts,
            backgroundColor: '#3b82f6',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
JS;
$this->registerJs($js);
?>