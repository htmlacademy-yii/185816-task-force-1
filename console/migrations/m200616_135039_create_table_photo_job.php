<?php

use yii\db\Migration;

/**
 * Class m200616_135039_create_table_photo_job
 */
class m200616_135039_create_table_photo_job extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%photo_job}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'img' => $this->string(),
            'created_at' => $this->dateTime()->defaultValue(date('Y-m-d H:i:s')),
            'updated_at' => $this->dateTime()->defaultValue(date('Y-m-d H:i:s'))
        ]);

        $this->addForeignKey('fk-pj-user', 'photo_job', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('{{%photo_job}}');

       $this->dropForeignKey('fk-pj-user', 'photo_job');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200616_135039_create_table_photo_job cannot be reverted.\n";

        return false;
    }
    */
}
