<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\Contact;
use app\models\ChangePasswordForm;
use app\models\Car;
use app\models\User;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $popularCars = Car::find()
            ->joinWith(['model.brand', 'mainImage'])
            ->orderBy(['views' => SORT_DESC])
            ->limit(6)
            ->all();

            $feedbacks = Contact::find()
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(6)
            ->all();

        $sliderCars = Car::find()
            ->joinWith('mainImage')
            ->where(['is not', 'car_images.image_path', null])
            ->andWhere(['cars.status' => 'available'])
            ->limit(6)
            ->all();

        return $this->render('index', [
            'popularCars' => $popularCars,
            'sliderCars' => $sliderCars,
            'feedbacks' => $feedbacks,
        ]);      


    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                if (Yii::$app->request->isAjax) {
                    return $this->asJson(['success' => true, 'redirect' => Yii::$app->user->returnUrl]);
                } else {
                    Yii::$app->session->setFlash('success', 'Вы успешно авторизовались!');
                    return $this->goBack();
                }
            } else {
                if (Yii::$app->request->isAjax) {
                    return $this->asJson(['success' => false, 'errors' => $model->errors]);
                }
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->register()) {
                if (Yii::$app->request->isAjax) {
                    return $this->asJson(['success' => true, 'redirect' => ['login']]);
                } else {
                    Yii::$app->session->setFlash('success', 'Вы успешно зарегистрировались!');
                    return $this->redirect(['login']);
                }
            } else {
                if (Yii::$app->request->isAjax) {
                    return $this->asJson(['success' => false, 'errors' => $model->errors]);
                }
            }
        }

        $model->password = '';
        $model->password_repeat = '';
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new Contact();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Спасибо! Ваше сообщение отправлено.');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        $team = User::find()
            ->where(['role' => ['admin', 'owner']])
            ->orderBy(['id' => SORT_ASC])
            ->all();

        return $this->render('about', [
            'team' => $team,
        ]);
    }

    public function actionRules()
    {
        return $this->render('rules');
    }

    public function actionForgot()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }

        $model = new ChangePasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            Yii::$app->session->setFlash('success', 'Пароль успешно изменён.');
            return $this->redirect(['/cabinet/profile']);
        }

        return $this->render('forgot', [
            'model' => $model,
        ]);
    }


    public function actionSearchSuggestions($q)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $q = trim($q);
        if (strlen($q) < 2) {
            return [];
        }
        $cars = Car::find()
            ->joinWith(['model.brand'])
            ->where(['like', 'car_models.name', $q])
            ->orWhere(['like', 'car_brands.name', $q])
            ->limit(10)
            ->all();
        $result = [];
        foreach ($cars as $car) {
            $result[] = [
                'id' => $car->id,
                'text' => $car->model->brand->name . ' ' . $car->model->name . ' (' . $car->year . ')',
                'url' => \yii\helpers\Url::to(['/car/view', 'id' => $car->id]),
            ];
        }
        return $result;
    }
}