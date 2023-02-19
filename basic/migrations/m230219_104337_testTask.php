<?php

use yii\db\Migration;

/**
 * Class m230219_104337_testTask
 */
class m230219_104337_testTask extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db = Yii::$app->db_cbt;

        $this->dropColumn('trip', 'trip_purpose_id');
        $this->dropColumn('trip', 'trip_purpose_parent_id');
        $this->dropColumn('trip', 'trip_purpose_desc');
        $this->dropColumn('trip', 'status');

        $this->dropIndex('number', 'trip');
        $this->dropIndex('corporate_id_2', 'trip');
        $this->dropIndex('corporate_id_coord', 'trip');
        $this->dropIndex('created_at', 'trip');
        $this->dropIndex('status', 'trip');

        $this->createIndex('corporate_id','trip','corporate_id');

        $this->dropColumn('trip_service', 'deadline');
        $this->dropColumn('trip_service', 'date_start');
        $this->dropColumn('trip_service', 'date_end');
        $this->dropColumn('trip_service', 'start_city_id');
        $this->dropColumn('trip_service', 'start_point_id');
        $this->dropColumn('trip_service', 'end_point_id');
        $this->dropColumn('trip_service', 'end_city_id');
        $this->dropColumn('trip_service', 'description');

        $this->dropIndex('trip_id', 'trip_service');
        $this->dropIndex('trip_id_2', 'trip_service');
        $this->dropIndex('date_start', 'trip_service');
        $this->dropIndex('end_city_id', 'trip_service');
        $this->dropIndex('deadline_time', 'trip_service');
        $this->dropIndex('end_point_id', 'trip_service');
        $this->dropIndex('date_end', 'trip_service');
        $this->dropIndex('start_point_id', 'trip_service');
        $this->dropIndex('confirmation_number', 'trip_service');
        $this->dropIndex('status', 'trip_service');
        $this->dropIndex('start_city_id', 'trip_service');
        $this->dropIndex('variants', 'trip_service');

        $this->createIndex('trip_id', 'trip_service','trip_id');

        $this->dropIndex('fk_flight_segment_flight','flight_segment');

        $this->createIndex('flight_id','flight_segment','flight_id');

        $this->addForeignKey('trip_id_fk','trip_service','trip_id','trip','id','CASCADE','CASCADE');
        $this->addForeignKey('flight_id_fk','flight_segment','flight_id','trip_service','id','CASCADE','CASCADE');
//        $this->addForeignKey('depAirportId_fk','flight_segment','depAirportId','guide_etalon.airport_name','airport_id','CASCADE','CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230219_104337_testTask cannot be reverted.\n";

        $this->db = Yii::$app->db_cbt;
        $this->addColumn('trip', 'trip_purpose_id', 'int');
        $this->addColumn('trip', 'trip_purpose_parent_id', 'int');
        $this->addColumn('trip', 'trip_purpose_desc', 'text');
        $this->addColumn('trip', 'status', 'tinyint(1)');

        $this->dropIndex('corporate_id','trip');

        $this->createIndex('number', 'trip',['corporate_id','number'],true);
        $this->createIndex('corporate_id_2', 'trip',['corporate_id','user_id','status']);
        $this->createIndex('corporate_id_coord', 'trip',['corporate_id','status','coordination_at']);
        $this->createIndex('created_at', 'trip','created_at');
        $this->createIndex('status', 'trip',['status','created_at']);

        $this->addColumn('trip_service', 'deadline', 'int');
        $this->addColumn('trip_service', 'date_start', 'int');
        $this->addColumn('trip_service', 'date_end', 'int');
        $this->addColumn('trip_service', 'start_city_id', 'int');
        $this->addColumn('trip_service', 'start_point_id', 'int');
        $this->addColumn('trip_service', 'end_point_id', 'int');
        $this->addColumn('trip_service', 'end_city_id', 'int');
        $this->addColumn('trip_service', 'description', 'text');

        $this->dropIndex('trip_id','trip_service');

        $this->createIndex('confirmation_number', 'trip_service',['trip_id','confirmation_number']);
        $this->createIndex('date_end', 'trip_service',['trip_id','date_end']);
        $this->createIndex('date_start', 'trip_service',['trip_id','date_start']);
        $this->createIndex('deadline_time', 'trip_service',['trip_id','deadline']);
        $this->createIndex('end_city_id', 'trip_service',['trip_id','end_city_id']);
        $this->createIndex('end_point_id', 'trip_service',['trip_id','end_point_id']);
        $this->createIndex('start_city_id', 'trip_service',['trip_id','start_city_id']);
        $this->createIndex('start_point_id', 'trip_service',['trip_id','start_point_id']);
        $this->createIndex('status', 'trip_service',['trip_id','status']);
        $this->createIndex('trip_id', 'trip_service',['trip_id','service_id','type_booking','variants']);
        $this->createIndex('trip_id_2', 'trip_service',['trip_id','type_booking']);
        $this->createIndex('variants', 'trip_service',['trip_id','variants']);

        $this->dropIndex('flight_id','flight_segment');

        $this->createIndex('fk_flight_segment_flight','flight_segment',['flight_id','`group`','depTimestamp']);

        $this->dropForeignKey('trip_id_fk','trip_service');
        $this->dropForeignKey('flight_id_fk','flight_segment');
//        $this->dropForeignKey('depAirportId_fk','flight_segment');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230219_104337_testTask cannot be reverted.\n";

        return false;
    }
    */
}
