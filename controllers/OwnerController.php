<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\models\Car;
use app\models\CarModel;
use app\models\CarBrand;
use app\models\CarFeature;
use app\models\CarImage;
use app\models\Booking;

class OwnerController extends Controller
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
                        'matchCallback' => function ($rule, $action) {
                            $user = Yii::$app->user->identity;
                            return $user && $user->role === 'owner';
                        },
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $userId = Yii::$app->user->id;

        $totalCars = Car::find()->where(['owner_id' => $userId])->count();

        $activeBookings = Booking::find()
            ->joinWith('car')
            ->where(['cars.owner_id' => $userId])
            ->andWhere(['bookings.status' => ['pending', 'confirmed']])
            ->count();

        $startOfMonth = date('Y-m-01 00:00:00');
        $endOfMonth = date('Y-m-t 23:59:59');
        $monthIncome = Booking::find()
            ->joinWith('car')
            ->where(['cars.owner_id' => $userId])
            ->andWhere(['bookings.status' => 'completed'])
            ->andWhere(['between', 'bookings.end_date', $startOfMonth, $endOfMonth])
            ->sum('bookings.total_price') ?: 0;

        $recentBookings = Booking::find()
            ->joinWith('car')
            ->where(['cars.owner_id' => $userId])
            ->orderBy(['bookings.created_at' => SORT_DESC])
            ->limit(5)
            ->all();

        return $this->render('index', [
            'totalCars' => $totalCars,
            'activeBookings' => $activeBookings,
            'monthIncome' => $monthIncome,
            'recentBookings' => $recentBookings,
        ]);
    }


    public function actionCars()
    {
        $userId = Yii::$app->user->id;
        $cars = Car::find()
            ->where(['owner_id' => $userId])
            ->with('model.brand', 'mainImage')
            ->all();

        return $this->render('cars', [
            'cars' => $cars,
        ]);
    }


    public function actionCreate()
    {
        $car = new Car();
        $car->owner_id = Yii::$app->user->id;
        $car->status = 'available';
        $car->category = 'premium';

        if ($car->load(Yii::$app->request->post())) {
            $car->save(); 

            if ($features = Yii::$app->request->post('features')) {
                foreach ($features as $featureId) {
                    $car->link('features', CarFeature::findOne($featureId));
                }
            }

            $images = UploadedFile::getInstances($car, 'imageFiles');
            foreach ($images as $index => $file) {
                $path = 'uploads/cars/' . $car->id . '_' . time() . '_' . $index . '.' . $file->extension;
                if ($file->saveAs($path)) {
                    $image = new CarImage();
                    $image->car_id = $car->id;
                    $image->image_path = '/' . $path;
                    $image->is_main = ($index === 0); 
                    $image->save();
                }
            }

            Yii::$app->session->setFlash('success', 'Автомобиль успешно добавлен.');
            return $this->redirect(['cars']);
        }

        $models = CarModel::find()->with('brand')->all();
        $features = CarFeature::find()->all();

        return $this->render('form', [
            'car' => $car,
            'models' => $models,
            'features' => $features,
        ]);
    }


    public function actionUpdate($id)
    {
        $car = Car::findOne(['id' => $id, 'owner_id' => Yii::$app->user->id]);
        if (!$car) {
            throw new NotFoundHttpException('Автомобиль не найден.');
        }

        if ($car->load(Yii::$app->request->post())) {
            $car->save();

            $car->unlinkAll('features', true);
            if ($features = Yii::$app->request->post('features')) {
                foreach ($features as $featureId) {
                    $car->link('features', CarFeature::findOne($featureId));
                }
            }

            $images = UploadedFile::getInstances($car, 'imageFiles');
            foreach ($images as $index => $file) {
                $path = 'uploads/cars/' . $car->id . '_' . time() . '_' . $index . '.' . $file->extension;
                if ($file->saveAs($path)) {
                    $image = new CarImage();
                    $image->car_id = $car->id;
                    $image->image_path = '/' . $path;
                    $image->is_main = 0; 
                    $image->save();
                }
            }

            Yii::$app->session->setFlash('success', 'Автомобиль обновлён.');
            return $this->redirect(['cars']);
        }

        $models = CarModel::find()->with('brand')->all();
        $features = CarFeature::find()->all();
        $selectedFeatures = $car->getFeatures()->select('id')->column();

        return $this->render('form', [
            'car' => $car,
            'models' => $models,
            'features' => $features,
            'selectedFeatures' => $selectedFeatures,
        ]);
    }


    public function actionDelete($id)
    {
        $car = Car::findOne(['id' => $id, 'owner_id' => Yii::$app->user->id]);
        if ($car) {
            $car->delete();
            Yii::$app->session->setFlash('success', 'Автомобиль удалён.');
        }
        return $this->redirect(['cars']);
    }

    public function actionBookings()
    {
        $userId = Yii::$app->user->id;

        $bookings = Booking::find()
            ->joinWith('car')
            ->where(['cars.owner_id' => $userId])
            ->orderBy(['bookings.created_at' => SORT_DESC])
            ->all();

        return $this->render('bookings', [
            'bookings' => $bookings,
        ]);
    }


    public function actionConfirmBooking($id)
    {
        $booking = Booking::findOne($id);
        if ($booking && $booking->car->owner_id == Yii::$app->user->id) {
            $booking->status = 'confirmed';
            $booking->save();
            Yii::$app->session->setFlash('success', 'Бронирование подтверждено.');
        }
        return $this->redirect(['bookings']);
    }


    public function actionCancelBooking($id)
    {
        $booking = Booking::findOne($id);
        if ($booking && $booking->car->owner_id == Yii::$app->user->id) {
            $booking->status = 'cancelled';
            $booking->save();
            Yii::$app->session->setFlash('success', 'Бронирование отклонено.');
        }
        return $this->redirect(['bookings']);
    }


    public function actionCalendar($id)
    {
        $car = Car::findOne(['id' => $id, 'owner_id' => Yii::$app->user->id]);
        if (!$car) {
            throw new NotFoundHttpException('Автомобиль не найден.');
        }

        $bookings = Booking::find()
            ->where(['car_id' => $id, 'status' => ['confirmed', 'pending']])
            ->orderBy(['start_date' => SORT_ASC])
            ->all();

        return $this->render('calendar', [
            'car' => $car,
            'bookings' => $bookings,
        ]);
    }


    public function actionStats($id)
    {
        $car = Car::findOne(['id' => $id, 'owner_id' => Yii::$app->user->id]);
        if (!$car) {
            throw new NotFoundHttpException('Автомобиль не найден.');
        }

        $totalBookings = Booking::find()->where(['car_id' => $id])->count();
        $completedBookings = Booking::find()->where(['car_id' => $id, 'status' => 'completed'])->count();
        $totalIncome = Booking::find()->where(['car_id' => $id, 'status' => 'completed'])->sum('total_price') ?: 0;

        $monthlyIncome = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $start = date('Y-m-01 00:00:00', strtotime("-$i months"));
            $end = date('Y-m-t 23:59:59', strtotime("-$i months"));
            $income = Booking::find()
                ->where(['car_id' => $id, 'status' => 'completed'])
                ->andWhere(['between', 'end_date', $start, $end])
                ->sum('total_price') ?: 0;
            $monthlyIncome[$month] = $income;
        }

        return $this->render('stats', [
            'car' => $car,
            'totalBookings' => $totalBookings,
            'completedBookings' => $completedBookings,
            'totalIncome' => $totalIncome,
            'monthlyIncome' => $monthlyIncome,
        ]);
    }
}