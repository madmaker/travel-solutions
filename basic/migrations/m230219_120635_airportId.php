<?php

use yii\db\Migration;

/**
 * Class m230219_120635_airportId
 */
class m230219_120635_airportId extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db = Yii::$app->db_cbt;

        $this->createIndex('depAirportId','flight_segment','depAirportId');

        $this->db = Yii::$app->db_guide_etalon;
        $this->dropIndex('object_id','airport_name');
        $this->dropIndex('language','airport_name');
        $this->dropIndex('object_id_2','airport_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230219_120635_airportId cannot be reverted.\n";

        $this->db = Yii::$app->db_cbt;

        $this->dropIndex('depAirportId','flight_segment');

        $this->db = Yii::$app->db_guide_etalon;
        $this->createIndex('object_id','airport_name',['airport_id','language_id'],true);
        $this->createIndex('language','airport_name','language_id');
        $this->createIndex('object_id_2','airport_name','airport_id');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230219_120635_airportId cannot be reverted.\n";

        return false;
    }
    */
}
