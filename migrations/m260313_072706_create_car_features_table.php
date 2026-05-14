<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%car_features}}`.
 */
class m260313_072706_create_car_features_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%car_features}}', [
            'id' => $this->primaryKey(), 'name' => $this->string(100)->notNull()->unique(),
            'icon' => $this->string(50),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%car_features}}');
    }
}
