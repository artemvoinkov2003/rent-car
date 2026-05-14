<?php

use yii\helpers\Html;

$this->title = 'Панель администратора';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-index bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-lexend text-gray-600">Пользователи</p>
                        <p class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= $totalUsers ?></p>
                    </div>
                    <div class="w-12 h-12 bg-sport-red bg-opacity-10 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-2xl text-sport-red"></i>
                    </div>
                </div>
            </div>
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-lexend text-gray-600">Автомобили</p>
                        <p class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= $totalCars ?></p>
                    </div>
                    <div class="w-12 h-12 bg-sport-red bg-opacity-10 rounded-full flex items-center justify-center">
                        <i class="fas fa-car text-2xl text-sport-red"></i>
                    </div>
                </div>
            </div>
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-lexend text-gray-600">Бронирования</p>
                        <p class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= $totalBookings ?></p>
                    </div>
                    <div class="w-12 h-12 bg-sport-red bg-opacity-10 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-check text-2xl text-sport-red"></i>
                    </div>
                </div>
            </div>
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-lexend text-gray-600">Доход</p>
                        <p class="text-3xl font-bold text-sport-dark-blue font-outfit"><?= Yii::$app->formatter->asCurrency($totalIncome, 'RUB') ?></p>
                    </div>
                    <div class="w-12 h-12 bg-sport-red bg-opacity-10 rounded-full flex items-center justify-center">
                        <i class="fas fa-ruble-sign text-2xl text-sport-red"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4">Быстрые действия</h3>
                <div class="space-y-2">
                    <?= Html::a('Управление пользователями', ['users'], ['class' => 'block py-2 px-4 bg-sport-red bg-opacity-10 text-white rounded-lg hover:bg-sport-red hover:text-white transition']) ?>
                    <?= Html::a('Управление автомобилями', ['cars'], ['class' => 'block py-2 px-4 bg-sport-red bg-opacity-10 text-white rounded-lg hover:bg-sport-red hover:text-white transition']) ?>
                    <?= Html::a('Управление брендами', ['car-brands'], ['class' => 'block py-2 px-4 bg-sport-red bg-opacity-10 text-white rounded-lg hover:bg-sport-red hover:text-white transition']) ?>
                    <?= Html::a('Статистика', ['statistics'], ['class' => 'block py-2 px-4 bg-sport-red bg-opacity-10 text-white rounded-lg hover:bg-sport-red hover:text-white transition']) ?>
                </div>
            </div>
            <div class="bg-light-bg p-6 rounded-xl shadow-strong">
                <h3 class="text-xl font-bold text-sport-dark-blue font-outfit mb-4">Последние действия</h3>
                <p class="text-gray-600">Здесь можно вывести последние бронирования или отзывы.</p>
            </div>
        </div>
    </div>
</div>