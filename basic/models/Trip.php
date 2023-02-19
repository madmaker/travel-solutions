<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Connection;

class Trip extends ActiveRecord
{
    /**
     * @return mixed|object|Connection|null
     */
    public static function getDb()
    {
        // использовать компонент приложения "db2"
        return Yii::$app->db_cbt;
    }
}