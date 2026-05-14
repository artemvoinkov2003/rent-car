<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%car_images}}`.
 */
class m260313_072805_create_car_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%car_images}}', [
            'id' => $this->primaryKey(),
            'car_id' => $this->integer()->notNull(),
            'image_path' => $this->string(255)->notNull(),
            'is_main' => $this->boolean()->defaultValue(false),
            'sort_order' => $this->integer()->defaultValue(0),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');

        $this->addForeignKey(
            'fk-car_images-car_id',
            '{{%car_images}}',
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
        $this->dropTable('{{%car_images}}');
        $this->dropForeignKey('fk-car_images-car_id', '{{%car_images}}');
    }
}
