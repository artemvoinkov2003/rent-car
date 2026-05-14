<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Управление пользователями';
$this->params['breadcrumbs'][] = ['label' => 'Панель администратора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$users = $dataProvider->getModels();
$pagination = $dataProvider->pagination;
?>

<div class="admin-users bg-white py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-sport-dark-blue font-outfit mb-6"><?= Html::encode($this->title) ?></h1>

        <?php if (empty($users)): ?>
            <div class="bg-form-bg p-12 rounded-xl shadow-strong text-center">
                <div class="text-6xl mb-4">👥</div>
                <h3 class="text-2xl font-bold text-sport-dark-blue font-outfit mb-2">Нет пользователей</h3>
                <p class="text-gray-600 font-lexend">В системе пока нет зарегистрированных пользователей.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($users as $user): ?>
                    <div class="bg-light-bg rounded-xl shadow-strong hover:shadow-stronger transition-all overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-200 flex-shrink-0">
                                    <?php if ($user->avatar): ?>
                                        <img src="<?= $user->avatar ?>" alt="Аватар" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-3xl text-gray-500">
                                            <i class="fas fa-user-circle"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold font-outfit text-sport-dark-blue">
                                        <?= Html::encode($user->first_name . ' ' . $user->last_name) ?>
                                    </h3>
                                    <p class="text-sm text-gray-600 font-lexend">@<?= Html::encode($user->username) ?></p>
                                </div>
                            </div>

                            <div class="space-y-2 text-sm font-lexend text-gray-700">
                                <p><i class="fas fa-envelope w-5 text-sport-red"></i> <?= Html::encode($user->email) ?></p>
                                <p><i class="fas fa-phone w-5 text-sport-red"></i> <?= $user->phone ? Html::encode($user->phone) : '—' ?></p>
                                <p><i class="fas fa-tag w-5 text-sport-red"></i> 
                                    <?php
                                    $roleLabels = ['user' => 'Пользователь', 'owner' => 'Владелец', 'admin' => 'Администратор'];
                                    echo $roleLabels[$user->role] ?? $user->role;
                                    ?>
                                </p>
                            </div>

                            <div class="mt-6 flex justify-end gap-2">
                                <?= Html::a('<i class="fas fa-edit mr-1"></i> Редактировать', ['update-user', 'id' => $user->id], [
                                    'class' => 'py-2 px-4 border border-sport-red text-sm font-medium rounded-md text-sport-red hover:bg-sport-red hover:text-white transition-colors'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-trash mr-1"></i> Удалить', ['delete-user', 'id' => $user->id], [
                                    'class' => 'py-2 px-4 border border-red-600 text-sm font-medium rounded-md text-red-600 hover:bg-red-600 hover:text-white transition-colors',
                                    'data-confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
                                    'data-method' => 'post',
                                ]) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($pagination && $pagination->totalCount > $pagination->pageSize): ?>
                <div class="mt-8 flex justify-center">
                    <?= LinkPager::widget([
                        'pagination' => $pagination,
                        'options' => ['class' => 'flex space-x-2'],
                        'linkOptions' => ['class' => 'w-10 h-10 rounded-full bg-light-bg border border-sport-red text-sport-dark-blue font-lexend flex items-center justify-center hover:bg-sport-red hover:text-white transition-colors'],
                        'activePageCssClass' => 'bg-sport-red text-white',
                        'disabledPageCssClass' => 'opacity-50 cursor-not-allowed',
                        'prevPageLabel' => '‹',
                        'nextPageLabel' => '›',
                        'firstPageLabel' => '«',
                        'lastPageLabel' => '»',
                    ]); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>