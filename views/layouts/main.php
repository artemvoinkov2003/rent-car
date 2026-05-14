<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;


AppAsset::register($this);
$this->registerCssFile('@web/css/style.css', ['depends' => [AppAsset::class]]);

$this->registerMetaTag(['name' => 'description', 'content' => 'Аренда автомобилей в Кургане. 
Большой выбор авто, удобное бронирование, лучшие цены. РентКар – ваш надежный партнер в аренде машин.']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'кпк, kpk, kpk45, rent-car, рент-кар, 
аренда авто Курган, прокат автомобилей, каршеринг, взять машину напрокат']);
$this->registerMetaTag(['name' => 'author', 'content' => 'Воинков Артём']);
$this->registerMetaTag(['name' => 'robots', 'content' => 'index, follow']);

$this->registerMetaTag(['property' => 'og:title', 'content' => 'РентКар – аренда автомобилей в Кургане']);
$this->registerMetaTag(['property' => 'og:description', 
'content' => 'Быстрая и удобная аренда автомобилей. Большой выбор, прозрачные условия.']);
$this->registerMetaTag(['property' => 'og:type', 'content' => 'website']);
$this->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->request->absoluteUrl]);
$this->registerMetaTag(['property' => 'og:image', 'content' => Yii::getAlias('@web/images/og-image.jpg')]);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="/img/logo.png" alt="РентКар" style="height: 8vh;">',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-expand-md navbar-custom navbar-red-blue fixed-top',
        ],
    ]);

    $menuItems = [
        ['label' => 'Главная', 'url' => ['/site/index']],
        ['label' => 'Каталог', 'url' => ['/catalog/index']],
        ['label' => 'О нас', 'url' => ['/site/about']],
        ['label' => 'Контакты', 'url' => ['/site/contact']],
    ];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
        $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/register']];
    } else {
        $identity = Yii::$app->user->identity;    
        $user = \app\models\User::findOne($identity->id);
        if (!$user) {
            $user = $identity;
        }
        $role = $user->role;

        $cabinetItems = [
            ['label' => 'Профиль', 'url' => ['/cabinet/profile']],
            ['label' => 'Мои бронирования', 'url' => ['/cabinet/bookings']],
            ['label' => 'Избранное', 'url' => ['/cabinet/favorites']],
        ];

        if ($role === 'owner') {
            $cabinetItems[] = ['label' => 'Мои автомобили', 'url' => ['/owner/cars']];
            $cabinetItems[] = ['label' => 'Заявки на бронирование', 'url' => ['/owner/bookings']];
            $cabinetItems[] = ['label' => 'Статистика владельца', 'url' => ['/owner/index']];
        }

        if ($role === 'admin') {
            $cabinetItems[] = ['label' => 'Дашборд', 'url' => ['/admin/index']];
            $cabinetItems[] = ['label' => 'Управление пользователями', 'url' => ['/admin/users']];
            $cabinetItems[] = ['label' => 'Управление автомобилями', 'url' => ['/admin/cars']];
            $cabinetItems[] = ['label' => 'Управление изображениями', 'url' => ['/admin/car-images']];
            $cabinetItems[] = ['label' => 'Управление брендами', 'url' => ['/admin/car-brands']];
            $cabinetItems[] = ['label' => 'Управление моделями', 'url' => ['/admin/car-models']];
            $cabinetItems[] = ['label' => 'Управление характеристиками', 'url' => ['/admin/car-features']];
            $cabinetItems[] = ['label' => 'Управление бронированиями', 'url' => ['/admin/bookings']];
            $cabinetItems[] = ['label' => 'Управление отзывами', 'url' => ['/admin/reviews']];
            $cabinetItems[] = ['label' => 'Статистика', 'url' => ['/admin/statistics']];
        }

        $cabinetItems[] = '-';
        $cabinetItems[] = [
            'label' => 'Выход (' . Html::encode($user->username) . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post'],
        ];

        $menuItems[] = [
            'label' => 'Личный кабинет',
            'items' => $cabinetItems,
        ];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'items' => $menuItems,
        'encodeLabels' => false,
        'activateParents' => true,
    ]);

    NavBar::end();
    ?>
</header>

<main id="main" class="flex-grow-1 flex-shrink-0" role="main">
    <div class="container" style="margin-top: 80px;">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="footer-custom footer-red-blue">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img src="/img/logo.png" alt="РентКар" style="height: 8vh; margin-bottom: 10px;">
                <p>Сервис аренды автомобилей для любых путешествий. Быстро, удобно, надёжно.</p>
            </div>
            <div class="col-md-4">
                <h5>Навигация</h5>
                <ul class="list-unstyled">
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['/site/index']) ?>">Главная</a></li>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['/catalog/index']) ?>">Каталог</a></li>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['/site/about']) ?>">О нас</a></li>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['/site/contact']) ?>">Контакты</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Социальные сети</h5>
                <div class="social-icons">
                    <a href="https://vk.com/artem_voinkov"><i class="fab fa-vk"></i></a>
                    <a href="https://t.me/Art3moon_444"><i class="fab fa-telegram"></i></a>
                </div>
                <p class="mt-3">Почта: artem.voinkov@yandex.ru</p>
                <p>Телефон: +7 (912) 522-64-20</p>
            </div>
        </div>
        <div class="row copyright">
            <div class="col text-center">
                &copy; Воинков Артём. РентКар <?= date('Y') ?>. Все права защищены.
            </div>
        </div>
    </div>

    <button id="back-to-top" class="fixed bottom-6 right-6 w-12 h-12 rounded-full bg-gradient-to-r from-[#FBBF24] to-[#06B6D4] text-white shadow-lg hover:shadow-xl transition-all duration-300 hidden items-center justify-center z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    </button>
    
</footer>

<?php $this->endBody() ?>

<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000",
    };
</script>

</body>
</html>
<?php $this->endPage() ?>