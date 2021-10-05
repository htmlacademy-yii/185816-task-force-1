<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m200130_134539_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey('255')->unique(),
            'task_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'description' => $this->text(),
            'executor_id' => $this->integer()->notNull(),
            'rating' => $this->double()->notNull()->defaultValue(0),
            'created_at' => $this->dateTime()->defaultExpression('NOW()'),
            'updated_at' => $this->dateTime()->defaultExpression('NOW()')
        ]);

        $this->addForeignKey('fkc-user_id', 'comment', 'user_id', 'user', 'id');
        $this->addForeignKey('fkc-task_id', 'comment', 'executor_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comment}}');

        $this->dropForeignKey('fkc-user_id', 'comment');
        $this->dropForeignKey('fkc-task_id', 'comment');
    }
}
