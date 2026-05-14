<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cars}}`.
 */
class m260313_072516_create_cars_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('{{%cars}}', [
            'id' => $this->primaryKey(),
            'owner_id' => $this->integer()->notNull(),
            'model_id' => $this->integer()->notNull(),
            'year' => $this->integer(4),
            'color' => $this->string(50),
            'license_plate' => $this->string(20)->unique(),
            'mileage' => $this->integer(),
            'price_per_day' => $this->decimal(10, 2),
            'price_per_hour' => $this->decimal(10, 2),
            'deposit' => $this->decimal(10, 2),
            'status' => "ENUM('available','booked','repair') NOT NULL DEFAULT 'available'",
            'description' => $this->text(),
            'views' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');

        $this->addForeignKey(
            'fk-cars-owner_id',
            '{{%cars}}',
            'owner_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-cars-model_id',
            '{{%cars}}',
            'model_id',
            '{{%car_models}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cars}}');
        $this->dropForeignKey('fk-cars-owner_id', '{{%cars}}');
        $this->dropForeignKey('fk-cars-model_id', '{{%cars}}');
    }
}
