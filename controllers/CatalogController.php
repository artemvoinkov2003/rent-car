<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Car;
use app\models\CarBrand;
use app\models\CarFeature;

class CatalogController extends Controller
{
    public function actionIndex()
    {
        $query = Car::find()
            ->joinWith(['model.brand', 'mainImage'])
            ->with(['reviews', 'features'])
            ->groupBy('cars.id');

        if ($search = Yii::$app->request->get('search')) {
            $query->joinWith(['model.brand'])->andWhere([
                'or',
                ['like', 'car_models.name', $search],
                ['like', 'car_brands.name', $search],
            ]);
        }

        if ($brandId = Yii::$app->request->get('brand')) {
            $query->andWhere(['car_brands.id' => $brandId]);
        }

        $priceMin = Yii::$app->request->get('price_min');
        $priceMax = Yii::$app->request->get('price_max');
        if ($priceMin !== '' && $priceMin !== null) {
            $query->andWhere(['>=', 'price_per_day', $priceMin]);
        }
        if ($priceMax !== '' && $priceMax !== null) {
            $query->andWhere(['<=', 'price_per_day', $priceMax]);
        }

        $yearMin = Yii::$app->request->get('year_min');
        $yearMax = Yii::$app->request->get('year_max');
        if ($yearMin !== '' && $yearMin !== null) {
            $query->andWhere(['>=', 'year', $yearMin]);
        }
        if ($yearMax !== '' && $yearMax !== null) {
            $query->andWhere(['<=', 'year', $yearMax]);
        }
      
        if ($color = Yii::$app->request->get('color')) {
            $query->andWhere(['like', 'color', $color]);
        }

        if ($transmission = Yii::$app->request->get('transmission')) {
            $query->andWhere(['transmission' => $transmission]);
        }

        $engineVolumeMin = Yii::$app->request->get('engine_volume_min');
        $engineVolumeMax = Yii::$app->request->get('engine_volume_max');
        if ($engineVolumeMin !== '' && $engineVolumeMin !== null) {
            $query->andWhere(['>=', 'engine_volume', $engineVolumeMin]);
        }
        if ($engineVolumeMax !== '' && $engineVolumeMax !== null) {
            $query->andWhere(['<=', 'engine_volume', $engineVolumeMax]);
        }

        if ($driveType = Yii::$app->request->get('drive_type')) {
            $query->andWhere(['drive_type' => $driveType]);
        }

        if ($fuelType = Yii::$app->request->get('fuel_type')) {
            $query->andWhere(['fuel_type' => $fuelType]);
        }

        if ($bodyType = Yii::$app->request->get('body_type')) {
            $query->andWhere(['body_type' => $bodyType]);
        }

        $consumptionMin = Yii::$app->request->get('consumption_min');
        $consumptionMax = Yii::$app->request->get('consumption_max');
        if ($consumptionMin !== '' && $consumptionMin !== null) {
            $query->andWhere(['>=', 'fuel_consumption', $consumptionMin]);
        }
        if ($consumptionMax !== '' && $consumptionMax !== null) {
            $query->andWhere(['<=', 'fuel_consumption', $consumptionMax]);
        }

        if ($payment = Yii::$app->request->get('payment')) {
            $query->andWhere('FIND_IN_SET(:payment, payment_options)', [':payment' => $payment]);
        }

        if ($insurance = Yii::$app->request->get('insurance')) {
            $query->andWhere('FIND_IN_SET(:insurance, insurance_options)', [':insurance' => $insurance]);
        }

        if ($options = Yii::$app->request->get('options')) {
            $query->joinWith('features')
                  ->andWhere(['car_features.id' => $options]);
        }

        $sort = Yii::$app->request->get('sort', 'default');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy(['price_per_day' => SORT_ASC]);
                break;
            case 'price_desc':
                $query->orderBy(['price_per_day' => SORT_DESC]);
                break;
            case 'year_asc':
                $query->orderBy(['year' => SORT_ASC]);
                break;
            case 'year_desc':
                $query->orderBy(['year' => SORT_DESC]);
                break;
            case 'rating_desc':
                $query->leftJoin('reviews', 'reviews.booking_id IN (SELECT id FROM bookings WHERE car_id = cars.id)')
                      ->groupBy('cars.id')
                      ->orderBy(['AVG(reviews.rating)' => SORT_DESC]);
                break;
            default:
                $query->orderBy(['created_at' => SORT_DESC]);
        }

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $cars = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $brands = CarBrand::find()->all();
        $allFeatures = CarFeature::find()->all();

        return $this->render('index', [
            'cars' => $cars,
            'pages' => $pages,
            'brands' => $brands,
            'allFeatures' => $allFeatures,
            'filters' => Yii::$app->request->get(),
        ]);
    }
}