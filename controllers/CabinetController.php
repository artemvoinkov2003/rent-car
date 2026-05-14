<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\models\User;
use app\models\Booking;
use app\models\Favorite;
use app\models\Review;

class CabinetController extends Controller
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

    public function actionProfile()
    {
        $user = Yii::$app->user->identity;

        if ($user->load(Yii::$app->request->post())) {
            $user->avatarFile = UploadedFile::getInstance($user, 'avatarFile');
            if ($user->validate()) {
                if ($user->uploadAvatar() && $user->save(false)) {
                    Yii::$app->session->setFlash('success', 'Профиль обновлён.');
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка при загрузке аватара.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка валидации данных.');
            }
            return $this->refresh();
        }

        return $this->render('profile', [
            'user' => $user,
        ]);
    }

    public function actionBookings()
    {
        $query = Booking::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->with('car.model.brand')
            ->orderBy(['created_at' => SORT_DESC]);

        $status = Yii::$app->request->get('status');
        if ($status && in_array($status, ['pending', 'confirmed', 'cancelled', 'completed'])) {
            $query->andWhere(['status' => $status]);
        }

        $bookings = $query->all();

        return $this->render('bookings', [
            'bookings' => $bookings,
            'currentStatus' => $status,
        ]);
    }

    public function actionCancelBooking($id)
    {
        $booking = Booking::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);
        if ($booking && in_array($booking->status, ['pending', 'confirmed'])) {
            $booking->status = 'cancelled';
            if ($booking->save()) {
                Yii::$app->session->setFlash('success', 'Бронирование отменено.');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при отмене.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Бронирование не найдено или не может быть отменено.');
        }
        return $this->redirect(['bookings']);
    }

    public function actionFavorites()
    {
        $favorites = Favorite::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->with('car.model.brand', 'car.mainImage')
            ->all();

        return $this->render('favorites', [
            'favorites' => $favorites,
        ]);
    }

    public function actionRemoveFavorite($carId)
    {
        $favorite = Favorite::findOne(['user_id' => Yii::$app->user->id, 'car_id' => $carId]);
        if ($favorite && $favorite->delete()) {
            Yii::$app->session->setFlash('success', 'Автомобиль удалён из избранного.');
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка при удалении.');
        }
        return $this->redirect(['favorites']);
    }

    public function actionIndex()
    {
        $userId = Yii::$app->user->id;
        $user = Yii::$app->user->identity;

        $totalBookings = Booking::find()->where(['user_id' => $userId])->count();
        $activeBookings = Booking::find()
            ->where(['user_id' => $userId])
            ->andWhere(['status' => ['pending', 'confirmed']])
            ->count();
        $completedBookings = Booking::find()
            ->where(['user_id' => $userId, 'status' => 'completed'])
            ->count();
        $cancelledBookings = Booking::find()
            ->where(['user_id' => $userId, 'status' => 'cancelled'])
            ->count();
      
        $totalSpent = Booking::find()
            ->where(['user_id' => $userId, 'status' => 'completed'])
            ->sum('total_price') ?: 0;

        $favoritesCount = Favorite::find()->where(['user_id' => $userId])->count();

        $recentBookings = Booking::find()
            ->where(['user_id' => $userId])
            ->with('car.model.brand')
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(3)
            ->all();

        return $this->render('index', [
            'user' => $user,
            'totalBookings' => $totalBookings,
            'activeBookings' => $activeBookings,
            'completedBookings' => $completedBookings,
            'cancelledBookings' => $cancelledBookings,
            'totalSpent' => $totalSpent,
            'favoritesCount' => $favoritesCount,
            'recentBookings' => $recentBookings,
        ]);
    }

    /**
     * 
     * @param int $booking_id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreateReview($booking_id)
    {
        $booking = Booking::findOne(['id' => $booking_id, 'user_id' => Yii::$app->user->id]);
        if (!$booking) {
            throw new NotFoundHttpException('Бронирование не найдено.');
        }
        if ($booking->status !== 'completed') {
            Yii::$app->session->setFlash('error', 'Отзыв можно оставить только после завершения аренды.');
            return $this->redirect(['bookings']);
        }

        
        if ($booking->review) {
            Yii::$app->session->setFlash('error', 'Отзыв уже оставлен.');
            return $this->redirect(['view-review', 'booking_id' => $booking_id]);
        }

        $review = new Review();
        $review->booking_id = $booking_id;

        if ($review->load(Yii::$app->request->post()) && $review->save()) {
            Yii::$app->session->setFlash('success', 'Спасибо! Ваш отзыв сохранён.');
            return $this->redirect(['view-review', 'booking_id' => $booking_id]);
        }

        return $this->render('review/create', [
            'review' => $review,
            'booking' => $booking,
        ]);
    }

    /**
     * 
     * @param int $booking_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionViewReview($booking_id)
    {
        $booking = Booking::findOne(['id' => $booking_id, 'user_id' => Yii::$app->user->id]);
        if (!$booking) {
            throw new NotFoundHttpException('Бронирование не найдено.');
        }

        $review = $booking->review;

        return $this->render('review/view', [
            'booking' => $booking,
            'review' => $review,
        ]);
    }

}