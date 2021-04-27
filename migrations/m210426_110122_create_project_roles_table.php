<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project_roles}}`.
 */
class m210426_110122_create_project_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project_roles}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'project_roles_IDX_slug',
            'project_roles',
            'slug'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'project_roles_IDX_slug',
            'project_roles'
        );

        $this->dropTable('{{%project_roles}}');
    }
}
