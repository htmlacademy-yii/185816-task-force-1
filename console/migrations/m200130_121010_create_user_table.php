<?php

use yii\db\Migration;
use frontend\helpers\Date;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m200130_121010_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey('255')->unique(),
            'full_name' => $this->char('255')->notNull(),
            'email' => $this->char(255)->unique(),
            'role_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'user_status_id' => $this->integer()->notNull(),
            'date_birth' => $this->date(),
            'about' => $this->text(),
            'password' => $this->char('255'),
            'phone' => $this->char('50'),
            'skype' => $this->char('100'),
            'messenger' => $this->text(),
            'hidden' => $this->boolean()->defaultValue(false),
            'view_only_customer' => $this->boolean()->defaultValue(false),
            'avatar' => $this->string()->defaultValue('/img/default-avatar.jpg'),
            'rating' => $this->float()->notNull()->defaultValue(0),
            'created_at' => $this->dateTime()->defaultValue(Date::getDateNow())->notNull(),
            'updated_at' => $this->dateTime()->defaultValue(Date::getDateNow())->notNull()
        ]);

        $this->addForeignKey('fk-role_id', 'user', 'role_id', 'role', 'id');
        $this->addForeignKey('fk-city_id', 'user', 'city_id', 'city', 'id');
        $this->addForeignKey('fk-user_status_id', 'user', 'user_status_id', 'user_status', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');

        $this->dropForeignKey('fk-role_id', 'user');
        $this->dropForeignKey('fk-city_id', 'user');
        $this->dropForeignKey('fk-user_status_id', 'user');
    }
}
