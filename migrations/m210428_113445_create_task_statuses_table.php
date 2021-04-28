<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_statuses}}`.
 */
class m210428_113445_create_task_statuses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task_statuses}}', [
            'id'            => $this->primaryKey(),
            'name'          => $this->string()->notNull(),
            'slug'          => $this->string()->notNull(),
            'is_kanban'     => $this->tinyInteger()->notNull()->defaultValue(0),
            'is_default'    => $this->tinyInteger()->notNull()->defaultValue(0),
            'kanban_order'  => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->createIndex(
            'task_statuses_IDX_is_default',
            'task_statuses',
            'is_default'
        );

        $this->createIndex(
            'task_statuses_IDX_slug',
            'task_statuses',
            'slug',
            true
        );

        $this->createIndex(
            'task_statuses_IDX_is_kanban',
            'task_statuses',
            'is_kanban'
        );

        $this->createIndex(
            'task_statuses_IDX_kanban_order',
            'task_statuses',
            'kanban_order'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('task_statuses_IDX_is_default', 'task_statuses');
        $this->dropIndex('task_statuses_IDX_slug', 'task_statuses');
        $this->dropIndex('task_statuses_IDX_is_kanban', 'task_statuses');
        $this->dropIndex('task_statuses_IDX_kanban_order', 'task_statuses');

        $this->dropTable('{{%task_statuses}}');
    }
}
