<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%car_brands}}`.
 */
class m260313_072308_create_car_brands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%car_brands}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull()->unique(),
            'logo' => $this->string(255),
            'description' => $this->text(),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%car_brands}}');
    }
}
