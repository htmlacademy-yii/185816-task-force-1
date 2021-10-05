<?php

use yii\db\Migration;

/**
 * Class m200130_112712_create_category
 */
class m200130_112712_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey('255')->unique(),
            'category_name' => $this->text()->notNull(),
            'tag' => $this->text()->notNull(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()'),
            'updated_at' => $this->dateTime()->defaultExpression('NOW()')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200130_112712_create_category cannot be reverted.\n";

        return false;
    }
    */
}
