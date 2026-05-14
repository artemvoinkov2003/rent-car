<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payments}}`.
 */
class m260313_073050_create_payments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payments}}', [
            'id' => $this->primaryKey(),
            'booking_id' => $this->integer()->notNull(),
            'amount' => $this->decimal(10, 2)->notNull(),
            'payment_method' => $this->string(50),
            'status' => "ENUM('pending','paid','failed') NOT NULL DEFAULT 'pending'",
            'transaction_id' => $this->string(100),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');

        $this->addForeignKey(
            'fk-payments-booking_id',
            '{{%payments}}',
            'booking_id',
            '{{%bookings}}',
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
        $this->dropTable('{{%payments}}');
        $this->dropForeignKey('fk-payments-booking_id', '{{%payments}}');
    }
}
