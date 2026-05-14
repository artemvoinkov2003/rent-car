<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Favorite;

class FavoriteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionToggle()
    {
        $carId = Yii::$app->request->post('car_id');
        if (!$carId) {
            Yii::$app->session->setFlash('error', 'Не указан автомобиль');
            return $this->redirect(Yii::$app->request->referrer ?: ['/catalog/index']);
        }

        $userId = Yii::$app->user->id;
        $favorite = Favorite::findOne(['user_id' => $userId, 'car_id' => $carId]);

        if ($favorite) {
            if ($favorite->delete()) {
                Yii::$app->session->setFlash('success', 'Автомобиль удалён из избранного');
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось удалить из избранного');
            }
        } else {
            $favorite = new Favorite(['user_id' => $userId, 'car_id' => $carId]);
            if ($favorite->save()) {
                Yii::$app->session->setFlash('success', 'Автомобиль добавлен в избранное');
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось добавить в избранное');
            }
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['/catalog/index']);
    }
}