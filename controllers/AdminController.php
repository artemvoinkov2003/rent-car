<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\models\User;
use app\models\Car;
use app\models\CarBrand;
use app\models\CarModel;
use app\models\CarImage;
use app\models\CarFeature;
use app\models\Booking;
use app\models\Review;
use yii\data\ActiveDataProvider;

class AdminController extends Controller
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
                            return $user && $user->role === 'admin';
                        },
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $totalUsers = User::find()->count();
        $totalCars = Car::find()->count();
        $totalBookings = Booking::find()->count();
        $totalIncome = Booking::find()->where(['status' => 'completed'])->sum('total_price') ?: 0;

        return $this->render('index', [
            'totalUsers' => $totalUsers,
            'totalCars' => $totalCars,
            'totalBookings' => $totalBookings,
            'totalIncome' => $totalIncome,
        ]);
    }

    public function actionUsers()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        return $this->render('users', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdateUser($id)
    {
        $model = $this->findUser($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Пользователь обновлён.');
            return $this->redirect(['users']);
        }

        return $this->render('user-form', [
            'model' => $model,
        ]);
    }

    public function actionDeleteUser($id)
    {
        $model = $this->findUser($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Пользователь удалён.');
        }
        return $this->redirect(['users']);
    }

    public function actionCars()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Car::find()->with('model.brand', 'owner'),
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        return $this->render('cars', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateCar()
    {
        $model = new Car();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Автомобиль успешно добавлен.');
            return $this->redirect(['cars']);
        }

        return $this->render('car-form', [
            'model' => $model,
        ]);
    }

    public function actionUpdateCar($id)
    {
        $model = $this->findCar($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Автомобиль обновлён.');
            return $this->redirect(['cars']);
        }

        return $this->render('car-form', [
            'model' => $model,
        ]);
    }

    public function actionDeleteCar($id)
    {
        $model = $this->findCar($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Автомобиль удалён.');
        }
        return $this->redirect(['cars']);
    }

    public function actionCarBrands()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CarBrand::find(),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('car-brands', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateBrand()
    {
        $model = new CarBrand();
        return $this->handleBrandForm($model);
    }

    public function actionUpdateBrand($id)
    {
        $model = $this->findBrand($id);
        return $this->handleBrandForm($model);
    }

    private function handleBrandForm($model)
    {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Бренд сохранён.');
            return $this->redirect(['car-brands']);
        }
        return $this->render('brand-form', ['model' => $model]);
    }

    public function actionDeleteBrand($id)
    {
        $model = $this->findBrand($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Бренд удалён.');
        }
        return $this->redirect(['car-brands']);
    }

    public function actionCarModels()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CarModel::find()->with('brand'),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('car-models', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateModel()
    {
        $model = new CarModel();
        return $this->handleModelForm($model);
    }

    public function actionUpdateModel($id)
    {
        $model = $this->findModel($id);
        return $this->handleModelForm($model);
    }

    private function handleModelForm($model)
    {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Модель сохранена.');
            return $this->redirect(['car-models']);
        }
        $brands = CarBrand::find()->all();
        return $this->render('model-form', [
            'model' => $model,
            'brands' => $brands,
        ]);
    }

    public function actionDeleteModel($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Модель удалена.');
        }
        return $this->redirect(['car-models']);
    }

    public function actionCarFeatures()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CarFeature::find(),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('car-features', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateFeature()
    {
        $model = new CarFeature();
        return $this->handleFeatureForm($model);
    }

    public function actionUpdateFeature($id)
    {
        $model = $this->findFeature($id);
        return $this->handleFeatureForm($model);
    }

    private function handleFeatureForm($model)
    {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Характеристика сохранена.');
            return $this->redirect(['car-features']);
        }
        return $this->render('feature-form', ['model' => $model]);
    }

    public function actionDeleteFeature($id)
    {
        $model = $this->findFeature($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Характеристика удалена.');
        }
        return $this->redirect(['car-features']);
    }

    public function actionBookings()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Booking::find()->with('car.model.brand', 'user'),
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        return $this->render('bookings', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdateBooking($id)
    {
        $model = $this->findBooking($id);

        if ($model->load(Yii::$app->request->post())) {
            
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Статус бронирования обновлён.');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при обновлении статуса.');
            }
            return $this->redirect(['bookings']);
        }

        return $this->render('booking-form', [
            'model' => $model,
        ]);
    }

    public function actionDeleteBooking($id)
    {
        $model = $this->findBooking($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Бронирование удалено.');
        }
        return $this->redirect(['bookings']);
    }

    public function actionReviews()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Review::find()->with('booking.user', 'booking.car'),
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        return $this->render('reviews', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDeleteReview($id)
    {
        $model = Review::findOne($id);
        if ($model && $model->delete()) {
            Yii::$app->session->setFlash('success', 'Отзыв удалён.');
        }
        return $this->redirect(['reviews']);
    }
    
    public function actionStatistics()
    {
        $months = [];
        $income = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $start = date('Y-m-01 00:00:00', strtotime("-$i months"));
            $end = date('Y-m-t 23:59:59', strtotime("-$i months"));
            $months[] = $month;
            $income[] = Booking::find()
                ->where(['status' => 'completed'])
                ->andWhere(['between', 'end_date', $start, $end])
                ->sum('total_price') ?: 0;
        }

        $bookingsByStatus = [
            'pending'   => Booking::find()->where(['status' => 'pending'])->count(),
            'confirmed' => Booking::find()->where(['status' => 'confirmed'])->count(),
            'cancelled' => Booking::find()->where(['status' => 'cancelled'])->count(),
            'completed' => Booking::find()->where(['status' => 'completed'])->count(),
        ];

        $popularCars = (new \yii\db\Query())
            ->select(['cars.id', 'cars.model_id', 'COUNT(bookings.id) as bookings_count'])
            ->from('cars')
            ->leftJoin('bookings', 'cars.id = bookings.car_id')
            ->groupBy('cars.id')
            ->orderBy(['bookings_count' => SORT_DESC])
            ->limit(5)
            ->all();
        $popularCarsData = [];
        foreach ($popularCars as $car) {
            $carModel = Car::findOne($car['id']);
            if ($carModel) {
                $popularCarsData[] = [
                    'name'  => $carModel->model->brand->name . ' ' . $carModel->model->name,
                    'count' => (int)$car['bookings_count'],
                ];
            }
        }

        $usersByRole = [
            'user'  => User::find()->where(['role' => 'user'])->count(),
            'owner' => User::find()->where(['role' => 'owner'])->count(),
            'admin' => User::find()->where(['role' => 'admin'])->count(),
        ];

        $weekDays = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
        $bookingsByWeekday = array_fill(0, 7, 0);
        $last30Days = date('Y-m-d', strtotime('-30 days'));
        $bookings = Booking::find()
            ->select(['created_at'])
            ->where(['>=', 'created_at', $last30Days])
            ->all();
        foreach ($bookings as $booking) {
            $dayOfWeek = (int) date('N', strtotime($booking->created_at)) - 1;
            $bookingsByWeekday[$dayOfWeek]++;
        }

        $topClients = (new \yii\db\Query())
            ->select(['users.id', 'users.username', 'users.first_name', 'users.last_name', 'SUM(bookings.total_price) as total_spent'])
            ->from('users')
            ->leftJoin('bookings', 'users.id = bookings.user_id AND bookings.status = "completed"')
            ->groupBy('users.id')
            ->orderBy(['total_spent' => SORT_DESC])
            ->limit(5)
            ->all();

        return $this->render('statistics', [
            'months'            => $months,
            'income'            => $income,
            'bookingsByStatus'  => $bookingsByStatus,
            'popularCarsData'   => $popularCarsData,
            'usersByRole'       => $usersByRole,
            'bookingsByWeekday' => $bookingsByWeekday,
            'weekDays'          => $weekDays,
            'topClients'        => $topClients,
        ]);
    }

    public function actionCarImages()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CarImage::find()->with('car'),
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        return $this->render('car-images', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateCarImage()
    {
        $model = new CarImage();
        return $this->handleCarImageForm($model);
    }

    public function actionUpdateCarImage($id)
    {
        $model = $this->findCarImage($id);
        return $this->handleCarImageForm($model);
    }

    private function handleCarImageForm($model)
    {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Изображение сохранено.');
            return $this->redirect(['car-images']);
        }
        $cars = Car::find()->with('model.brand')->all();
        return $this->render('car-image-form', [
            'model' => $model,
            'cars'  => $cars,
        ]);
    }

    public function actionDeleteCarImage($id)
    {
        $model = $this->findCarImage($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Изображение удалено.');
        }
        return $this->redirect(['car-images']);
    }

    protected function findCarImage($id)
    {
        if (($model = CarImage::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Изображение не найдено.');
    }

  
    protected function findUser($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Пользователь не найден.');
    }

    protected function findCar($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Автомобиль не найден.');
    }

    protected function findBrand($id)
    {
        if (($model = CarBrand::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Бренд не найден.');
    }

    protected function findModel($id)
    {
        if (($model = CarModel::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Модель не найдена.');
    }

    protected function findFeature($id)
    {
        if (($model = CarFeature::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Характеристика не найдена.');
    }

    protected function findBooking($id)
    {
        if (($model = Booking::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Бронирование не найдено.');
    }
}