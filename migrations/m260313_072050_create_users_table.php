<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m260313_072050_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull()->unique(),
            'first_name' => $this->string(100)->notNull(),
            'last_name' => $this->string(100)->notNull(),
            'patronymic' => $this->string(100),
            'email' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255)->notNull(), 
            'auth_key' => $this->string(32)->notNull(),
            'phone' => $this->string(20),
            'avatar' => $this->string(255),
            'role' => $this->string(20)->notNull()->defaultValue('user'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
