<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%projects_users}}`.
 */
class m210426_110125_create_projects_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%projects_users}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'role_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(11),
        ]);

        $this->createIndex(
            'projects_users_IDX_project_id',
            'projects_users',
            'project_id'
        );

        $this->createIndex(
            'projects_users_IDX_user_id',
            'projects_users',
            'user_id'
        );

        $this->createIndex(
            'projects_users_IDX_role_id',
            'projects_users',
            'role_id'
        );

        $this->addForeignKey(
            'projects_users_IDX_project_id',
            'projects_users',
            'project_id',
            'projects',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'projects_users_IDX_user_id',
            'projects_users',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'projects_users_IDX_role_id',
            'projects_users',
            'role_id',
            'project_roles',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'projects_users_IDX_project_id',
            'projects_users'
        );

        $this->dropForeignKey(
            'projects_users_IDX_user_id',
            'projects_users'
        );

        $this->dropForeignKey(
            'projects_users_IDX_role_id',
            'projects_users'
        );

        $this->dropIndex(
            'projects_users_IDX_project_id',
            'projects_users'
        );

        $this->dropIndex(
            'projects_users_IDX_user_id',
            'projects_users'
        );

        $this->dropIndex(
            'projects_users_IDX_role_id',
            'projects_users'
        );

        $this->dropTable('{{%projects_users}}');
    }
}
