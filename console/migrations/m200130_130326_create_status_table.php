<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%status}}`.
 */
class m200130_130326_create_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('status', [
            'id' => $this->primaryKey('255')->unique(),
            'name' => $this->char('200')->notNull(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()'),
            'updated_at' => $this->dateTime()->defaultExpression('NOW()')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('status');
    }
}
