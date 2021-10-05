<?php

use yii\db\Migration;

/**
 * Class m200529_103107_create_table_noticeCategory
 */
class m200529_103107_create_table_notice_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notice_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->char(255)->notNull(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()'),
            'updated_at' => $this->dateTime()->defaultExpression('NOW()')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%notice_category}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200529_103107_create_table_noticeCategory cannot be reverted.\n";

        return false;
    }
    */
}
