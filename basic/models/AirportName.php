<?php
declare(strict_types=1);

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Connection;

class AirportName extends ActiveRecord
{
    /**
     * @param string $airport_name - Имя аэропорта в БД
     * @return AirportName|null Объект Аэропорт
     * @throws \Throwable
     */
    public function getAirportByName(string $airport_name): ?AirportName
    {
        return AirportName::getDb()->cache(function ($db) use ($airport_name) {
            return AirportName::findOne(['value' => $airport_name]);
        });
    }

    /**
     * @return mixed|object|Connection|null
     */
    public static function getDb()
    {
        // использовать компонент приложения "db2"
        return Yii::$app->db_guide_etalon;
    }
}