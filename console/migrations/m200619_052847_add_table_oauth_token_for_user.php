<?php

use yii\db\Migration;

/**
 * Class m200619_052847_add_table_oauth_token_for_user
 */
class m200619_052847_add_table_oauth_token_for_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'auth_token', $this->string());
        $this->addColumn('{{%user}}', 'refresh_auth_token', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'auth_token');
        $this->dropColumn('{{%user}}', 'refresh_auth_token');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200619_052847_add_table_oauth_token_for_user cannot be reverted.\n";

        return false;
    }
    */
}
