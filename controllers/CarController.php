<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Car;
use app\models\Booking;
use app\models\Favorite; 

class CarController extends Controller
{
    public function actionView($id)
    {
        $car = Car::find()
            ->where(['cars.id' => $id])
            ->joinWith(['model.brand', 'carImages', 'features', 'reviews.booking.user'])
            ->with(['owner'])
            ->one();

        if (!$car) {
            throw new NotFoundHttpException('Автомобиль не найден.');
        }

        $bookedDates = Booking::find()
            ->select(['start_date', 'end_date'])
            ->where(['car_id' => $id, 'status' => ['confirmed', 'pending']])
            ->asArray()
            ->all();

        $isFavorite = false;
        if (!Yii::$app->user->isGuest) {
            $isFavorite = Favorite::find()
                ->where(['user_id' => Yii::$app->user->id, 'car_id' => $id])
                ->exists();
        }

        return $this->render('view', [
            'car' => $car,
            'bookedDates' => $bookedDates,
            'isFavorite' => $isFavorite, 
        ]);
    }
}