<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Правила аренды';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-rules bg-white py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-sport-dark-blue font-outfit mb-8 text-center"><?= Html::encode($this->title) ?></h1>

        <div class="max-w-3xl mx-auto bg-light-bg p-8 rounded-xl shadow-strong prose prose-lg font-lexend text-gray-700">
            <h2 class="text-2xl font-bold text-sport-dark-blue font-outfit mt-4">1. Общие условия</h2>
            <p>Аренда автомобиля возможна только при наличии действующего водительского удостоверения и паспорта. Возраст арендатора — от 21 года, водительский стаж — от 3 лет.</p>

            <h2 class="text-2xl font-bold text-sport-dark-blue font-outfit mt-6">2. Оплата и залог</h2>
            <p>Оплата производится онлайн на сайте или при получении. Залог блокируется на карте и возвращается после возврата автомобиля при отсутствии нарушений. Сумма залога зависит от класса автомобиля.</p>

            <h2 class="text-2xl font-bold text-sport-dark-blue font-outfit mt-6">3. Возврат автомобиля</h2>
            <p>Автомобиль должен быть возвращён с тем же уровнем топлива и в чистом состоянии (или оплачена мойка). За опоздание более чем на 1 час взимается штраф в размере суточной аренды.</p>

            <h2 class="text-2xl font-bold text-sport-dark-blue font-outfit mt-6">4. Штрафы и ответственность</h2>
            <p>При нарушении ПДД арендатор оплачивает штрафы самостоятельно. В случае ДТП арендатор обязан немедленно связаться со службой поддержки. Франшиза по страховке может варьироваться.</p>

            <h2 class="text-2xl font-bold text-sport-dark-blue font-outfit mt-6">5. Отмена бронирования</h2>
            <p>Отмена бронирования бесплатна за 24 часа до начала аренды. При более поздней отмене взимается штраф в размере 50% от стоимости.</p>

            <p class="mt-8 text-sm text-gray-500">Последнее обновление: 14 марта 2026 г.</p>
        </div>
    </div>
</div>