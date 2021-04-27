<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m210426_104013_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id'            => $this->primaryKey(),
            'login'         => $this->string()->notNull(),
            'email'         => $this->string(),
            'name'          => $this->string()->notNull(),
            'password_hash' => $this->string()->notNull(),
            'auth_key'      => $this->string()->notNull(),
            'created_at'    => $this->integer(11),
        ]);

        $this->createIndex(
            'users_IDX_login',
            'users',
            'login',
            true
        );

        $this->createIndex(
            'users_IDX_email',
            'users',
            'email'
        );

        $this->createIndex(
            'users_IDX_created_at',
            'users',
            'created_at'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'users_IDX_created_at',
            'users'
        );

        $this->dropIndex(
            'users_IDX_email',
            'users'
        );

        $this->dropIndex(
            'users_IDX_login',
            'users'
        );

        $this->dropTable('{{%users}}');
    }
}
