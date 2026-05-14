<?php

/** @var yii\web\View $this */
/** @var app\models\User[] $team */

use yii\helpers\Html;

$this->title = 'О компании';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-about bg-white py-12">
    <div class="container mx-auto px-4">
        
        <div class="relative bg-gradient-to-r from-sport-dark-blue to-sport-red rounded-2xl shadow-strong p-12 mb-16 text-center overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-sand opacity-10 rounded-full blur-3xl -ml-20 -mb-20"></div>
            <h1 class="text-4xl md:text-5xl font-bold font-outfit text-sport-dark-blue mb-4 relative z-10">О компании РентКар</h1>
            <p class="text-xl font-lexend text-white/90 max-w-2xl mx-auto relative z-10">Ваш надёжный партнёр в мире мобильности и комфорта</p>
        </div>

        <div class="max-w-4xl mx-auto">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                <div class="bg-light-bg p-6 rounded-xl shadow-strong hover:shadow-stronger transition">
                    <div class="w-14 h-14 bg-sport-red/10 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-bullseye text-2xl text-sport-red"></i>
                    </div>
                    <h3 class="text-2xl font-bold font-outfit text-sport-dark-blue mb-3">Наша миссия</h3>
                    <p class="font-lexend text-gray-700 leading-relaxed">Сделать аренду автомобиля максимально простой, быстрой и доступной для каждого. Мы предлагаем прозрачные условия, никаких скрытых платежей — только честные цены и качественный сервис.</p>
                </div>
                <div class="bg-light-bg p-6 rounded-xl shadow-strong hover:shadow-stronger transition">
                    <div class="w-14 h-14 bg-sport-red/10 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-star-of-life text-2xl text-sport-red"></i>
                    </div>
                    <h3 class="text-2xl font-bold font-outfit text-sport-dark-blue mb-3">Наши ценности</h3>
                    <p class="font-lexend text-gray-700 leading-relaxed">Надёжность, скорость, честность и забота о клиентах. Каждый автомобиль проходит тщательную проверку, а вы всегда можете рассчитывать на поддержку 24/7.</p>
                </div>
            </div>

            <div class="bg-light-bg rounded-xl shadow-strong p-8 mb-16">
                <h2 class="text-2xl font-bold font-outfit text-sport-dark-blue mb-4 flex items-center gap-2"><i class="fas fa-history text-sport-red"></i> Наша история</h2>
                <p class="font-lexend text-gray-700 leading-relaxed">РентКар начал свой путь в Кургане в 2020 году с нескольких автомобилей и мечты изменить представление об аренде машин. За это время мы выросли в команду профессионалов, расширили автопарк до более чем 500 автомобилей разных классов и помогли тысячам клиентов осуществить незабываемые поездки. Каждый день мы работаем над тем, чтобы ваш опыт аренды был безупречным.</p>
            </div>

            <div class="mb-16">
                <h2 class="text-3xl font-bold font-outfit text-sport-dark-blue mb-8 text-center">Наша команда</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php foreach ($team as $member): ?>
                    <div class="bg-light-bg rounded-xl shadow-strong hover:shadow-stronger transition overflow-hidden group">
                        <div class="relative h-48 bg-gradient-to-r from-sport-dark-blue/20 to-sport-red/20 flex items-center justify-center">
                            <?php if ($member->avatar): ?>
                                <img src="<?= $member->avatar ?>" alt="<?= Html::encode($member->first_name) ?>" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                            <?php else: ?>
                                <div class="w-32 h-32 rounded-full bg-white flex items-center justify-center text-6xl text-gray-400 shadow-lg">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold font-outfit text-sport-dark-blue"><?= Html::encode($member->first_name . ' ' . $member->last_name) ?></h3>
                            <p class="text-gray-600 font-lexend"><?= $member->role === 'admin' ? 'Администратор' : 'Владелец' ?></p>
                            <div class="mt-3 flex justify-center gap-3">
                                <a href="#" class="text-gray-400 hover:text-sport-red transition"><i class="fab fa-vk"></i></a>
                                <a href="#" class="text-gray-400 hover:text-sport-red transition"><i class="fab fa-telegram"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-sport-dark-blue to-sport-red rounded-xl p-6 text-center text-sport-dark-blue shadow-strong">
                    <i class="fas fa-car text-4xl mb-2"></i>
                    <p class="text-3xl font-bold">500+</p>
                    <p class="font-lexend opacity-90">автомобилей в парке</p>
                </div>
                <div class="bg-gradient-to-br from-sport-dark-blue to-sport-red rounded-xl p-6 text-center text-sport-dark-blue shadow-strong">
                    <i class="fas fa-users text-4xl mb-2"></i>
                    <p class="text-3xl font-bold">1000+</p>
                    <p class="font-lexend opacity-90">довольных клиентов</p>
                </div>
                <div class="bg-gradient-to-br from-sport-dark-blue to-sport-red rounded-xl p-6 text-center text-sport-dark-blue shadow-strong">
                    <i class="fas fa-clock text-4xl mb-2"></i>
                    <p class="text-3xl font-bold">24/7</p>
                    <p class="font-lexend opacity-90">поддержка</p>
                </div>
            </div>
        </div>
    </div>
</div>