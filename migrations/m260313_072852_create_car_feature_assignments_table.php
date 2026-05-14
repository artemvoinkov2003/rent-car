<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%car_feature_assignments}}`.
 */
class m260313_072852_create_car_feature_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%car_feature_assignments}}', [
            'car_id' => $this->integer()->notNull(),
            'feature_id' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk-car_feature_assignments', '{{%car_feature_assignments}}', ['car_id', 'feature_id']);

        $this->addForeignKey(
            'fk-car_feature_assignments-car_id',
            '{{%car_feature_assignments}}',
            'car_id',
            '{{%cars}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-car_feature_assignments-feature_id',
            '{{%car_feature_assignments}}',
            'feature_id',
            '{{%car_features}}',
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
        $this->dropTable('{{%car_feature_assignments}}');
        $this->dropForeignKey('fk-car_feature_assignments-car_id', '{{%car_feature_assignments}}');
        $this->dropForeignKey('fk-car_feature_assignments-feature_id', '{{%car_feature_assignments}}');
    }
}
