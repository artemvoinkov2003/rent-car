<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%car_models}}`.
 */
class m260313_072405_create_car_models_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%car_models}}', [
            'id' => $this->primaryKey(),
            'brand_id' => $this->integer()->notNull(),
            'name' => $this->string(100)->notNull(),
            'year_start' => $this->integer(4),
            'year_end' => $this->integer(4),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');

        $this->addForeignKey(
            'fk-car_models-brand_id',
            '{{%car_models}}',
            'brand_id',
            '{{%car_brands}}',
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
        $this->dropTable('{{%car_models}}');
        $this->dropForeignKey('fk-car_models-brand_id', '{{%car_models}}');
    }
}
