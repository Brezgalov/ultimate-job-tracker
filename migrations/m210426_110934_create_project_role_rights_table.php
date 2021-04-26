<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project_role_rights}}`.
 */
class m210426_110934_create_project_role_rights_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project_role_rights}}', [
            'id' => $this->primaryKey(),
            'project_role_id' => $this->integer()->notNull(),
            'rights_code' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'project_role_rights_IDX_project_role_id',
            'project_role_rights',
            'project_role_id'
        );

        $this->createIndex(
            'project_role_rights_IDX_rights_code',
            'project_role_rights',
            'rights_code'
        );

        $this->addForeignKey(
            'project_role_rights_IDX_project_role_id',
            'project_role_rights',
            'project_role_id',
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
            'project_role_rights_IDX_project_role_id',
            'project_role_rights'
        );

        $this->dropIndex(
            'project_role_rights_IDX_project_role_id',
            'project_role_rights'
        );

        $this->dropIndex(
            'project_role_rights_IDX_rights_code',
            'project_role_rights'
        );

        $this->dropTable('{{%project_roles_rights}}');
    }
}
