<?php

namespace app\forms;

use app\models\Projects;
use app\models\Tasks;
use app\models\TaskStatuses;
use yii\base\Model;

class TaskCreateForm extends Model
{
    /**
     * @var int
     */
    public $project_id;

    /**
     * @var int
     */
    public $parent_task_id;

    /**
     * @var int
     */
    public $status_id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var float
     */
    public $hours_est;

    /**
     * @var int
     */
    public $start_at;

    /**
     * @var int
     */
    public $end_at;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['project_id', 'status_id', 'title'], 'required'],
            ['title', 'string', 'max' => 255],
            ['description', 'string', 'max' => 65000],
            ['parent_task_id', 'validateParentTaskId'],
            ['status_id', 'exist', 'targetClass' => TaskStatuses::class, 'targetAttribute' => 'id'],
            ['project_id', 'exist', 'targetClass' => Projects::class, 'targetAttribute' => 'id'],
            [['hours_est', 'start_at', 'end_at'], 'number', 'min' => '0'],
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if (empty($this->status_id)) {
            $defaultStatuses = TaskStatuses::find()
                ->select('id')
                ->default()
                ->column();

            if (!empty($defaultStatuses)) {
                $this->status_id = $defaultStatuses[0];
            }
        }

        if (empty($this->status_id)) {
            $anyStatuses = TaskStatuses::find()
                ->select('id')
                ->limit(1)
                ->column();

            if (!empty($anyStatuses)) {
                $this->status_id = $anyStatuses[0];
            }
        }

        return parent::beforeValidate();
    }

    /**
     * Проверка статуса на валидность в соответствии с деревом
     */
    public function validateParentTaskId()
    {
        // @todo: implement
    }

    /**
     * @return Tasks|false
     */
    public function createTask()
    {
        if (!$this->validate()) {
            return false;
        }

        $task = new Tasks($this->toArray());

        if (!$task->save()) {
            $this->addErrors($task->getErrors());
            return false;
        }

        return $task;
    }

}