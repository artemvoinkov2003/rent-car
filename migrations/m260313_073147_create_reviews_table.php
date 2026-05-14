<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reviews}}`.
 */
class m260313_073147_create_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey(),
            'booking_id' => $this->integer()->notNull()->unique(), 
            'rating' => $this->tinyInteger(1)->notNull(),
            'comment' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');

        $this->addForeignKey(
            'fk-reviews-booking_id',
            '{{%reviews}}',
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
        $this->dropTable('{{%reviews}}');
        $this->dropForeignKey('fk-reviews-booking_id', '{{%reviews}}');
    }
}
