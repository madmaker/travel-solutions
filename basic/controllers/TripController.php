<?php
declare(strict_types=1);

namespace app\controllers;

use app\models\AirportName;
use app\models\Trip;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class TripController extends Controller
{
    /**
     * @return string
     * @throws BadRequestHttpException
     * @throws \Throwable
     */
    public function actionIndex(): string
    {
        $request = Yii::$app->request;

        $corporateId = $request->get('corporate_id');
        $serviceId = $request->get('service_id');
        $airportName = $request->get('airport');

        if (
            !$corporateId ||
            !$serviceId ||
            !$airportName
        ) {
            throw  new BadRequestHttpException('Неверный запрос. Не переданы обязательные параметры');
        }

        $airportNameModel = new AirportName();
        $airport = $airportNameModel->getAirportByName($airportName);

        if (!$airport) {
            throw  new BadRequestHttpException('Аэропорт не найден');
        }

        $trips = Trip::find()
            ->innerJoin('trip_service', 'trip.id = trip_service.trip_id')
            ->innerJoin('flight_segment', 'trip_service.id=flight_segment.flight_id')
            ->where('trip.corporate_id=:corporate_id')
            ->andWhere('trip_service.service_id=:service_id')
            ->andWhere('flight_segment.depAirportId=:airport_id')
            ->params([
                'airport_id' => $airport->airport_id,
                'corporate_id' => $corporateId,
                'service_id' => $serviceId,
            ]);

        $tripsDataProvider = new ActiveDataProvider([
            'query' => $trips,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'tripsDataProvider' => $tripsDataProvider,
        ]);
    }
}