<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;

$statusCode = property_exists($exception, 'statusCode') ? $exception->statusCode : 500;
?>

<div class="site-error min-h-screen flex items-center justify-center bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full space-y-8 bg-form-bg p-10 rounded-xl shadow-strong fade-in text-center">
        <div class="mb-6">
            <?php if ($statusCode == 404): ?>
                <div class="text-9xl font-bold text-sport-red font-outfit">404</div>
                <h1 class="mt-4 text-4xl font-bold text-sport-dark-blue font-outfit">Страница не найдена</h1>
                <p class="mt-2 text-lg text-gray-700 font-lexend">
                    Кажется, вы заблудились. Такой страницы не существует.
                </p>
                <div class="mt-6">
                    <?= Html::a('Вернуться на главную', ['/'], [
                        'class' => 'inline-block py-3 px-8 border border-transparent text-base font-medium rounded-md text-white btn-gradient-custom focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sport-dark-blue'
                    ]) ?>
                </div>
            <?php elseif ($statusCode == 403): ?>
                <div class="text-9xl font-bold text-sport-red font-outfit">403</div>
                <h1 class="mt-4 text-4xl font-bold text-sport-dark-blue font-outfit">Доступ запрещён</h1>
                <p class="mt-2 text-lg text-gray-700 font-lexend">
                    У вас нет прав для просмотра этой страницы.
                </p>
                <div class="mt-6">
                    <?= Html::a('На главную', ['/'], [
                        'class' => 'inline-block py-3 px-8 border border-transparent text-base font-medium rounded-md text-white btn-gradient-custom focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sport-dark-blue'
                    ]) ?>
                </div>
            <?php elseif ($statusCode == 500): ?>
                <div class="text-9xl font-bold text-sport-red font-outfit">500</div>
                <h1 class="mt-4 text-4xl font-bold text-sport-dark-blue font-outfit">Ошибка сервера</h1>
                <p class="mt-2 text-lg text-gray-700 font-lexend">
                    Что-то пошло не так. Мы уже работаем над исправлением.
                </p>
                <div class="mt-6">
                    <?= Html::a('Попробовать снова', ['/'], [
                        'class' => 'inline-block py-3 px-8 border border-transparent text-base font-medium rounded-md text-white btn-gradient-custom focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sport-dark-blue'
                    ]) ?>
                </div>
            <?php else: ?>
                <div class="text-9xl font-bold text-sport-red font-outfit"><?= $statusCode ?></div>
                <h1 class="mt-4 text-4xl font-bold text-sport-dark-blue font-outfit"><?= Html::encode($name) ?></h1>
                <p class="mt-2 text-lg text-gray-700 font-lexend">
                    <?= nl2br(Html::encode($message)) ?>
                </p>
                <div class="mt-6">
                    <?= Html::a('На главную', ['/'], [
                        'class' => 'inline-block py-3 px-8 border border-transparent text-base font-medium rounded-md text-white btn-gradient-custom focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sport-dark-blue'
                    ]) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>