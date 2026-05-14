<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\models\Booking;
use app\models\Car;

class BookingController extends Controller
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


    public function actionCreate()
    {
        $carId = Yii::$app->request->post('car_id');
        $startDate = Yii::$app->request->post('start_date');
        $endDate = Yii::$app->request->post('end_date');

        $car = Car::findOne($carId);
        if (!$car) {
            Yii::$app->session->setFlash('error', 'Автомобиль не найден.');
            return $this->redirect(['/catalog/index']);
        }

        // Валидация дат
        try {
            $start = new \DateTime($startDate);
            $end = new \DateTime($endDate);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Некорректные даты.');
            return $this->redirect(['/car/view', 'id' => $carId]);
        }

        if ($end <= $start) {
            Yii::$app->session->setFlash('error', 'Дата окончания должна быть позже даты начала.');
            return $this->redirect(['/car/view', 'id' => $carId]);
        }

        $existing = Booking::find()
            ->where(['car_id' => $carId])
            ->andWhere(['status' => ['pending', 'confirmed']])
            ->andWhere(['<', 'start_date', $endDate])
            ->andWhere(['>', 'end_date', $startDate])
            ->exists();
        if ($existing) {
            Yii::$app->session->setFlash('error', 'Автомобиль уже забронирован на выбранные даты.');
            return $this->redirect(['/car/view', 'id' => $carId]);
        }

        $session = Yii::$app->session;
        $session->set('booking_car_id', $carId);
        $session->set('booking_start_date', $startDate);
        $session->set('booking_end_date', $endDate);

        return $this->redirect(['confirm']);
    }
    
    public function actionView($id)
{
    $booking = Booking::findOne($id);
    if (!$booking) {
        throw new NotFoundHttpException('Бронирование не найдено.');
    }
    $userId = Yii::$app->user->id;
    $isOwner = ($booking->car->owner_id == $userId);
    if ($booking->user_id != $userId && !$isOwner) {
        throw new NotFoundHttpException('У вас нет доступа к этому бронированию.');
    }
    return $this->render('view', ['booking' => $booking]);
}

  
    public function actionConfirm()
    {
        $session = Yii::$app->session;
        $carId = $session->get('booking_car_id');
        $startDate = $session->get('booking_start_date');
        $endDate = $session->get('booking_end_date');

        if (!$carId || !$startDate || !$endDate) {
            Yii::$app->session->setFlash('error', 'Сначала выберите даты бронирования.');
            return $this->redirect(['/catalog/index']);
        }

        $car = Car::findOne($carId);
        if (!$car) {
            Yii::$app->session->setFlash('error', 'Автомобиль не найден.');
            return $this->redirect(['/catalog/index']);
        }

        $booking = new Booking();
        $booking->car_id = $carId;
        $booking->user_id = Yii::$app->user->id;
        $booking->start_date = $startDate;
        $booking->end_date = $endDate;
        $booking->total_price = $this->calculatePrice($car, $startDate, $endDate, 'basic');

        if ($booking->load(Yii::$app->request->post())) {
            // Пересчитываем стоимость с учётом выбранной страховки
            $booking->total_price = $this->calculatePrice($car, $startDate, $endDate, $booking->insurance_type);
            if ($booking->save()) {
                $session->remove('booking_car_id');
                $session->remove('booking_start_date');
                $session->remove('booking_end_date');
                Yii::$app->session->setFlash('success', 'Бронирование успешно создано!');
                return $this->redirect(['view', 'id' => $booking->id]);
            }
        }

        return $this->render('confirm', [
            'car' => $car,
            'booking' => $booking,
        ]);
    }

 
    public function actionCalculatePrice()
    {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $carId = Yii::$app->request->post('car_id');
        $startDate = Yii::$app->request->post('start_date');
        $endDate = Yii::$app->request->post('end_date');
        $insuranceType = Yii::$app->request->post('insurance_type', 'basic');

        $car = Car::findOne($carId);
        if (!$car || !$startDate || !$endDate) {
            return ['price' => 0];
        }

        $price = $this->calculatePrice($car, $startDate, $endDate, $insuranceType);
        return ['price' => $price];
    }


   
    private function calculatePrice(Car $car, string $startDate, string $endDate, string $insuranceType = 'basic'): float
    {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $days = $start->diff($end)->days;
        if ($days == 0) $days = 1;

        $total = $days * (float)$car->price_per_day;
        if ($insuranceType === 'extended') {
            $total += $days * 1000; 
        }
        return $total;
    }
}