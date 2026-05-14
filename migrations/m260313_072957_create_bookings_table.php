<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bookings}}`.
 */
class m260313_072957_create_bookings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bookings}}', [
            'id' => $this->primaryKey(),
            'car_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'start_date' => $this->dateTime()->notNull(),
            'end_date' => $this->dateTime()->notNull(),
            'total_price' => $this->decimal(10, 2)->notNull(),
            'status' => "ENUM('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending'",
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');

        $this->addForeignKey(
            'fk-bookings-car_id',
            '{{%bookings}}',
            'car_id',
            '{{%cars}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-bookings-user_id',
            '{{%bookings}}',
            'user_id',
            '{{%users}}',
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
        $this->dropTable('{{%bookings}}');
        $this->dropForeignKey('fk-bookings-car_id', '{{%bookings}}');
        $this->dropForeignKey('fk-bookings-user_id', '{{%bookings}}');
    }
}
