<?php

/** @var yii\web\View $this */
/** @var app\models\Car[] $popularCars */
/** @var app\models\Car[] $sliderCars */
/** @var app\models\Contact[] $feedbacks */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Аренда автомобилей РентКар';
?>

<div class="site-index">    

    <div class="welcome-banner relative overflow-hidden rounded-2xl shadow-stronger my-8 mx-4 md:mx-0" 
         style="background: linear-gradient(135deg, #1e293b 0%, #252850 50%, #1a1f3a 100%);">
        
        <div class="particles absolute inset-0 overflow-hidden pointer-events-none">
            <div class="particle particle-1"></div>
            <div class="particle particle-2"></div>
            <div class="particle particle-3"></div>
            <div class="particle particle-4"></div>
            <div class="particle particle-5"></div>
            <div class="particle particle-6"></div>
            <div class="particle particle-7"></div>
            <div class="particle particle-8"></div>
        </div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-sport-red opacity-10 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-sea opacity-10 rounded-full blur-3xl -ml-20 -mb-20"></div>
        <div class="absolute top-1/2 left-1/4 w-40 h-40 bg-sand opacity-5 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between px-6 py-10 md:px-12 md:py-16">
            <div class="text-center lg:text-left lg:max-w-2xl">
                <span class="inline-block px-4 py-1.5 mb-4 text-xs font-semibold tracking-wider uppercase rounded-full bg-sport-red bg-opacity-90 text-white shadow-md transform hover:scale-105 transition">
                    🚗 Первая поездка со скидкой 15%
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-outfit font-bold text-white leading-tight mb-4">
                    Аренда автомобилей <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-sand via-chrome to-sea">с заботой о вас</span>
                </h1>
                <p class="text-gray-200 text-lg md:text-xl font-lexend max-w-xl lg:mx-0 mx-auto mb-8">
                    Выберите идеальный автомобиль для путешествий, командировок или повседневных дел. Прозрачные условия, страховка и поддержка 24/7.
                </p>
                <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                    <?= Html::a('В каталог', ['/catalog/index'], [
                        'class' => 'inline-flex items-center px-8 py-3.5 border border-transparent text-base font-medium rounded-full shadow-lg text-white bg-sport-red hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sport-red transition-all duration-300 transform hover:-translate-y-0.5'
                    ]) ?>
                    <?= Html::a('О сервисе', ['/site/about'], [
                        'class' => 'inline-flex items-center px-8 py-3.5 border-2 border-white text-base font-medium rounded-full text-white hover: transition-all duration-300 transform hover:-translate-y-0.5'
                    ]) ?>
                </div>
                <div class="mt-10 flex flex-wrap items-center gap-6 text-sm text-gray-300 font-lexend justify-center lg:justify-start">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-sand" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span>Более 500 авто</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-sand" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Страховка включена</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-sand" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                        <span>Поддержка 24/7</span>
                    </div>
                </div>
            </div>
          
            <div class="hidden lg:block relative w-96 h-96">
                <div class="absolute inset-0 bg-gradient-to-br from-sand/20 to-sea/20 rounded-full blur-3xl"></div>
                <div class="relative z-10 w-full h-full flex flex-col items-center justify-center text-center">
                    <div class="text-white text-opacity-80">
                        <i class="fas fa-car-side text-8xl mb-4 text-sand"></i>
                        <p class="text-lg font-lexend">Выберите авто<br>в нашем каталоге</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($popularCars)): ?>
        <div class="container mx-auto px-4 py-12">
            <h2 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-8 text-center">Популярные автомобили</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($popularCars as $car): 
                    $imageUrl = $car->mainImage ? $car->mainImage->image_path : '/images/no-car.png';
                ?>
                    <div class="group bg-light-bg rounded-xl overflow-hidden shadow-strong hover:shadow-stronger transition-all duration-300">
                        <div class="h-56 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('<?= $imageUrl ?>');"></div>
                        <div class="p-5">
                            <h3 class="text-xl font-bold font-outfit text-sport-dark-blue"><?= Html::encode($car->model->brand->name . ' ' . $car->model->name) ?></h3>
                            <p class="text-gray-600 font-lexend mt-1"><?= $car->year ?> г., <?= $car->price_per_day ?> ₽/день</p>
                            <div class="mt-4">
                                <?= Html::a('Подробнее', ['/car/view', 'id' => $car->id], [
                                    'class' => 'inline-block py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom transition-all'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="bg-gradient-to-r from-sport-dark-blue/5 to-sport-red/5 py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div class="counter-item">
                    <div class="text-4xl font-bold text-sport-red font-outfit counter" data-target="500">0</div>
                    <p class="text-gray-600 font-lexend mt-2">+ автомобилей в парке</p>
                </div>
                <div class="counter-item">
                    <div class="text-4xl font-bold text-sport-red font-outfit counter" data-target="1000">0</div>
                    <p class="text-gray-600 font-lexend mt-2">довольных клиентов</p>
                </div>
                <div class="counter-item">
                    <div class="text-4xl font-bold text-sport-red font-outfit counter" data-target="24">0</div>
                    <p class="text-gray-600 font-lexend mt-2">часа поддержки</p>
                </div>
                <div class="counter-item">
                    <div class="text-4xl font-bold text-sport-red font-outfit counter" data-target="99">0</div>
                    <p class="text-gray-600 font-lexend mt-2">% положительных отзывов</p>
                </div>
            </div>
        </div>
    </div>


    <div class="bg-gradient-to-r from-sport-dark-blue to-sport-red py-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold font-outfit mb-2">Скидка 15% на первый заказ!</h2>
            <p class="text-lg font-lexend mb-6">Успейте забронировать автомобиль до окончания акции</p>
            <div class="flex justify-center gap-4 text-4xl font-bold font-outfit countdown-timer">
                <div class="bg-white text-sport-dark-blue rounded-lg px-4 py-2">00</div>
                <span class="text-white">:</span>
                <div class="bg-white text-sport-dark-blue rounded-lg px-4 py-2">00</div>
                <span class="text-white">:</span>
                <div class="bg-white text-sport-dark-blue rounded-lg px-4 py-2">00</div>
                <span class="text-white">:</span>
                <div class="bg-white text-sport-dark-blue rounded-lg px-4 py-2">00</div>
            </div>
        </div>
    </div>

    <div class="bg-white py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-8 text-center">Почему выбирают нас</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center p-6 hover:bg-gray-50 rounded-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-16 h-16 mx-auto bg-sport-red bg-opacity-10 rounded-full flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                        <i class="fas fa-car text-3xl text-sport-red"></i>
                    </div>
                    <h3 class="text-xl font-bold font-outfit text-sport-dark-blue mb-2">Большой выбор</h3>
                    <p class="text-gray-600 font-lexend">Более 500 автомобилей разных классов</p>
                </div>
                <div class="text-center p-6 hover:bg-gray-50 rounded-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-16 h-16 mx-auto bg-sport-red bg-opacity-10 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-clock text-3xl text-sport-red"></i>
                    </div>
                    <h3 class="text-xl font-bold font-outfit text-sport-dark-blue mb-2">Быстрое бронирование</h3>
                    <p class="text-gray-600 font-lexend">Процесс занимает всего несколько минут</p>
                </div>
                <div class="text-center p-6 hover:bg-gray-50 rounded-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-16 h-16 mx-auto bg-sport-red bg-opacity-10 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-3xl text-sport-red"></i>
                    </div>
                    <h3 class="text-xl font-bold font-outfit text-sport-dark-blue mb-2">Надёжность</h3>
                    <p class="text-gray-600 font-lexend">Все автомобили застрахованы</p>
                </div>
                <div class="text-center p-6 hover:bg-gray-50 rounded-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-16 h-16 mx-auto bg-sport-red bg-opacity-10 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-headset text-3xl text-sport-red"></i>
                    </div>
                    <h3 class="text-xl font-bold font-outfit text-sport-dark-blue mb-2">Поддержка 24/7</h3>
                    <p class="text-gray-600 font-lexend">Круглосуточная помощь на дороге</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-light-bg py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-4">Мы находимся здесь</h2>
                    <p class="text-gray-600 font-lexend mb-6">Приезжайте к нам в офис или свяжитесь онлайн</p>
                    <div class="w-full h-64 bg-gray-200 rounded-xl shadow-lg overflow-hidden">
                        <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Aваш_ключ&source=constructor" width="100%" height="100%" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($feedbacks)): ?>
    <div class="bg-light-bg py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-8 text-center">Что говорят наши клиенты</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($feedbacks as $feedback): ?>
                    <div class="bg-white p-6 rounded-xl shadow-strong hover:shadow-stronger transition">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-sport-red bg-opacity-10 flex items-center justify-center mr-4">
                                <i class="fas fa-user text-sport-red"></i>
                            </div>
                            <div>
                                <h4 class="font-bold font-outfit text-sport-dark-blue"><?= Html::encode($feedback->name) ?></h4>
                                <p class="text-sm text-gray-500"><?= Yii::$app->formatter->asDate($feedback->created_at) ?></p>
                            </div>
                        </div>
                        <p class="text-gray-600 font-lexend"><?= Html::encode($feedback->message) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="bg-gradient-to-r from-sport-dark-blue to-sport-red py-12 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold font-outfit mb-4">Готовы отправиться в путь?</h2>
            <p class="text-xl font-lexend mb-6">Забронируйте автомобиль прямо сейчас и получите скидку 10% на первую поездку!</p>
            <?= Html::a('Перейти в каталог', ['/catalog/index'], [
                'class' => 'group relative py-2 px-8 border border-transparent text-sm font-medium rounded-md text-white btn-gradient-custom focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sport-dark-blue'
            ]) ?>
        </div>
    </div>
</div>

<?php
$js = <<<JS
  
    new Swiper('.brandSwiper', {
        slidesPerView: 2,
        spaceBetween: 30,
        loop: true,
        autoplay: { delay: 2000 },
        breakpoints: {
            640: { slidesPerView: 3 },
            768: { slidesPerView: 4 },
            1024: { slidesPerView: 6 },
        },
        pagination: { el: '.swiper-pagination', clickable: true },
    });

    function animateCounter(el) {
        const target = parseInt(el.dataset.target);
        let current = 0;
        const increment = target / 50;
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                el.innerText = Math.ceil(current);
                requestAnimationFrame(updateCounter);
            } else {
                el.innerText = target;
            }
        };
        updateCounter();
    }
    const counters = document.querySelectorAll('.counter');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    counters.forEach(counter => observer.observe(counter));

    function startCountdown() {
        const targetDate = new Date().getTime() + 24 * 60 * 60 * 1000;
        const timer = setInterval(() => {
            const now = new Date().getTime();
            const diff = targetDate - now;
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            const timerElements = document.querySelectorAll('.countdown-timer div');
            if (timerElements.length >= 4) {
                timerElements[0].innerText = String(hours).padStart(2, '0');
                timerElements[1].innerText = String(minutes).padStart(2, '0');
                timerElements[2].innerText = String(seconds).padStart(2, '0');
                
            }
            if (diff < 0) clearInterval(timer);
        }, 1000);
    }
    startCountdown();
JS;
$this->registerJs($js);
?>

