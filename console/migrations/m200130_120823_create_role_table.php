<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%role}}`.
 */
class m200130_120823_create_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('role', [
            'id' => $this->primaryKey('255')->unique(),
            'role' => $this->char('200')->notNull(),
            'actions' => $this->text(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()'),
            'updated_at' => $this->dateTime()->defaultExpression('NOW()')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('role');
    }
}
