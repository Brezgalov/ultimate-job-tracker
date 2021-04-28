<?php

namespace app\models;

use app\queries\TaskStatusesQuery;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "task_statuses".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $is_kanban
 * @property int $is_default
 * @property int $kanban_order
 *
 * @property Tasks[] $tasks
 */
class TaskStatuses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_statuses';
    }

    /**
     * @return TaskStatusesQuery
     */
    public static function find()
    {
        return new TaskStatusesQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['is_kanban', 'is_default', 'kanban_order'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'slug' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'ensureUnique' => true,
                'immutable' => true,
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'is_kanban' => 'Is Kanban',
            'is_default' => 'Is Default',
            'kanban_order' => 'Kanban Order',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['status_id' => 'id']);
    }
}
