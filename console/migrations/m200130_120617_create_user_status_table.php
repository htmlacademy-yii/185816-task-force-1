<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_status}}`.
 */
class m200130_120617_create_user_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_status', [
            'id' => $this->primaryKey('255')->unique(),
            'status' => $this->text()->notNull(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()'),
            'updated_at' => $this->dateTime()->defaultExpression('NOW()')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_status');
    }
}
