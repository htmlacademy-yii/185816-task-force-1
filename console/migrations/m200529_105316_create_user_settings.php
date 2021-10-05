<?php

use yii\db\Migration;

/**
 * Class m200529_105316_create_user_settings
 */
class m200529_105316_create_user_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_settings}}', [
            'id' => $this->primaryKey(),
            'notice_category_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()'),
            'updated_at' => $this->dateTime()->defaultExpression('NOW()')
        ]);

        $this->addForeignKey('fk-set-user', 'user_settings', 'user_id', 'user', 'id');
        $this->addForeignKey('fk-set-notice-cat', 'user_settings', 'notice_category_id', 'notice_category', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_settings}}');

        $this->dropForeignKey('fk-set-user', 'user_settings');
        $this->dropForeignKey('fk-set-notice-cat', 'user_settings');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200529_105316_create_user_settings cannot be reverted.\n";

        return false;
    }
    */
}
