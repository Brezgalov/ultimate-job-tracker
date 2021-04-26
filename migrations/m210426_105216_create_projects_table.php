<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%projects}}`.
 */
class m210426_105216_create_projects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%projects}}', [
            'id'            => $this->primaryKey(),
            'name_url'      => $this->string()->notNull(),
            'name'          => $this->string()->notNull(),
            'created_at'    => $this->integer(11),
        ]);

        $this->createIndex(
            'projects_IDX_name',
            'projects',
            'name'
        );

        $this->createIndex(
            'projects_IDX_name_url',
            'projects',
            'name_url'
        );

        $this->createIndex(
            'projects_IDX_created_at',
            'projects',
            'created_at'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'projects_IDX_created_at',
            'projects'
        );

        $this->dropIndex(
            'projects_IDX_name_url',
            'projects'
        );

        $this->dropIndex(
            'projects_IDX_name',
            'projects'
        );

        $this->dropTable('{{%projects}}');
    }
}
