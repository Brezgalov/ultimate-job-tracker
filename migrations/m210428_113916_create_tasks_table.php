<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 */
class m210428_113916_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks}}', [
            'id'                => $this->primaryKey(),
            'project_id'        => $this->integer()->notNull(),
            'parent_task_id'    => $this->integer(),
            'status_id'         => $this->integer()->notNull(),
            'title'             => $this->string()->notNull(),
            'description'       => $this->text(),
            'hours_est'         => $this->float()->notNull()->defaultValue(0),
            'hours_real'        => $this->float()->notNull()->defaultValue(0),
            'start_at'          => $this->integer(11),
            'end_at'            => $this->integer(11),
            'created_at'        => $this->integer(11),
        ]);

        $this->createIndex(
            'tasks_IDX_project_id',
            'tasks',
            'project_id'
        );

        $this->addForeignKey(
            'tasks_FK_project_id',
            'tasks',
            'project_id',
            'projects',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'tasks_IDX_parent_task_id',
            'tasks',
            'parent_task_id'
        );

        $this->addForeignKey(
            'tasks_FK_parent_task_id',
            'tasks',
            'parent_task_id',
            'tasks',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'tasks_IDX_status_id',
            'tasks',
            'status_id'
        );

        $this->addForeignKey(
            'tasks_FK_status_id',
            'tasks',
            'status_id',
            'task_statuses',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('tasks_FK_status_id', 'tasks');
        $this->dropForeignKey('tasks_FK_project_id', 'tasks');
        $this->dropForeignKey('tasks_FK_parent_task_id', 'tasks');

        $this->dropIndex('tasks_IDX_status_id', 'tasks');
        $this->dropIndex('tasks_IDX_project_id', 'tasks');
        $this->dropIndex('tasks_IDX_parent_task_id', 'tasks');

        $this->dropTable('{{%tasks}}');
    }
}
