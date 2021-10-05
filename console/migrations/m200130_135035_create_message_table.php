<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message}}`.
 */
class m200130_135035_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey('255')->unique(),
            'sender' => $this->integer()->notNull(),
            'recipient' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'task_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()'),
            'updated_at' => $this->dateTime()->defaultExpression('NOW()')
        ]);

        $this->addForeignKey('fkm-sender', 'message', 'sender', 'user', 'id');
        $this->addForeignKey('fkm-recipient', 'message', 'recipient', 'task', 'id');
        $this->addForeignKey('fkm-task_id', 'message', 'task_id', 'task', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%message}}');

        $this->dropForeignKey('fkm-sender', 'message');
        $this->dropForeignKey('fkm-recipient', 'message');
        $this->dropForeignKey('fkm-task_id', 'message');
    }
}
