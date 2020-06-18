<?php

use yii\db\Migration;

/**
 * Class m200529_103631_create_table_notice
 */
class m200529_103631_create_table_notice extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notice}}', [
            'id' => $this->primaryKey(),
            'message' => $this->text(),
            'notice_category_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'visible' => $this->boolean()->notNull(),
            'created_at' => $this->dateTime()->defaultValue(date('Y-m-d H:i:s')),
            'updated_at' => $this->dateTime()->defaultValue(date('Y-m-d H:i:s'))
        ]);

        $this->addForeignKey('fk-notice-cat', 'notice', 'notice_category_id', 'notice_category', 'id');
        $this->addForeignKey('fk-notice-user', 'notice', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%notice}}');

        $this->dropForeignKey('fk-notice-cat', 'notice');
        $this->dropForeignKey('fk-notice-user', 'notice');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200529_103631_create_table_notice cannot be reverted.\n";

        return false;
    }
    */
}
