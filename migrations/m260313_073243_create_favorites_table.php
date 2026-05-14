<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%favorites}}`.
 */
class m260313_073243_create_favorites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%favorites}}', [
            'user_id' => $this->integer()->notNull(),
            'car_id' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk-favorites', '{{%favorites}}', ['user_id', 'car_id']);

        $this->addForeignKey(
            'fk-favorites-user_id',
            '{{%favorites}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-favorites-car_id',
            '{{%favorites}}',
            'car_id',
            '{{%cars}}',
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
        $this->dropTable('{{%favorites}}');
        $this->dropForeignKey('fk-favorites-user_id', '{{%favorites}}');
        $this->dropForeignKey('fk-favorites-car_id', '{{%favorites}}');
    }
}
