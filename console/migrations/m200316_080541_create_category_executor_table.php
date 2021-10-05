<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category_executor}}`.
 */
class m200316_080541_create_category_executor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category_executor}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()'),
            'updated_at' => $this->dateTime()->defaultExpression('NOW()'),
        ]);

        $this->addForeignKey('fke-user-executor', 'category_executor', 'user_id', 'user', 'id' );
        $this->addForeignKey('fke-category-executor', 'category_executor', 'category_id', 'category', 'id' );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category_executor}}');
    }
}
