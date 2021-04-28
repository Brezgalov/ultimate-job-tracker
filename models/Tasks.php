<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $project_id
 * @property int|null $parent_task_id
 * @property int $status_id
 * @property string $title
 * @property string|null $description
 * @property float $hours_est
 * @property float $hours_real
 * @property int|null $start_at
 * @property int|null $end_at
 * @property int|null $created_at
 *
 * @property Tasks $parentTask
 * @property Tasks[] $tasks
 * @property Projects $project
 * @property TaskStatuses $status
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'status_id', 'title'], 'required'],
            [['project_id', 'parent_task_id', 'status_id', 'start_at', 'end_at', 'created_at'], 'integer'],
            [['description'], 'string'],
            [['hours_est', 'hours_real'], 'number'],
            [['hours_est', 'hours_real'], 'default', 'value' => 0],
            [['title'], 'string', 'max' => 255],
            [['parent_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['parent_task_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::class, 'targetAttribute' => ['project_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatuses::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
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
            'project_id' => 'Project ID',
            'parent_task_id' => 'Parent Task ID',
            'status_id' => 'Status ID',
            'title' => 'Title',
            'description' => 'Description',
            'hours_est' => 'Hours Est',
            'hours_real' => 'Hours Real',
            'start_at' => 'Start At',
            'end_at' => 'End At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[ParentTask]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'parent_task_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['parent_task_id' => 'id']);
    }

    /**
     * Gets query for [[Project]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Projects::class, ['id' => 'project_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(TaskStatuses::class, ['id' => 'status_id']);
    }
}
