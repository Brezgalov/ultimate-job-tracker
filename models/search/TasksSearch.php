<?php

namespace app\models\search;

use DateTime;
use app\models\Tasks;
use yii\db\ActiveQuery;

/**
 * Class TasksSearch
 * @package app\models\search
 */
class TasksSearch extends BaseSearch
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $project_id;

    /**
     * @var integer
     */
    public $parent_task_id = 0;

    /**
     * @var integer
     */
    public $status_id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $any_text;

    /**
     * @var integer
     */
    public $start_from;

    /**
     * @var integer
     */
    public $end_before;

    /**
     * @var integer
     */
    public $created_at;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'parent_task_id', 'status_id', 'start_from', 'end_before', 'created_at'], 'integer'],
            [['title', 'any_text'], 'string'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер Задачи',
            'project_id' => 'Проект',
            'status_id' => 'Статус',
            'title' => 'Заголовок',
            'any_text' => 'Текст',
            'start_from' => 'Начало от',
            'end_before' => 'Завершение до',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuery()
    {
        $query = Tasks::find();

        $query->andFilterWhere(['like', 'title', $this->title]);

        $query->andFilterWhere([
            'id' => $this->id,
            'project_id' => $this->project_id,
            'status_id' => $this->status_id,
        ]);

        if ($this->parent_task_id !== null) {
            if ($this->parent_task_id) {
                $query->andWhere(['parent_task_id' => $this->parent_task_id]);
            } else {
                $query->andWhere(['parent_task_id' => null]);
            }
        }

        if ($this->any_text) {
            $query->andWhere([
                'and',
                ['title' => $this->any_text],
                ['description' => $this->any_text],
            ]);
        }

        if ($this->start_from) {
            $query->andWhere(['>=', 'start_at', $this->start_from]);
        }

        if ($this->end_before) {
            $query->andWhere(['<', 'end_at', $this->end_before]);
        }

        if ($this->created_at) {
            $date = DateTime::createFromFormat('U', $this->created_at);
            $date->setTime(0, 0, 0, 0);

            $dateTimestamp = $date->getTimestamp();

            $query->andWhere([
                'and',
                ['>=', 'created_at', $dateTimestamp],
                ['<', 'created_at', $dateTimestamp + 24 * 3600],
            ]);
        }

        return $query;
    }

    public function search(array $params)
    {
        $dataProvider = parent::search($params);

        /* @var $query ActiveQuery */
        $query = &$dataProvider->query;

        $query
            ->with('status')
            ->with('project');

        return $dataProvider;
    }
}
