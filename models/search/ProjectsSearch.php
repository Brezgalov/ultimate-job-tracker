<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Projects;

/**
 * Class ProjectsSearch
 * @package app\models\search
 */
class ProjectsSearch extends BaseSearch
{
    /**
     * @var string
     */
    public $any;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'name', 'any', 'description'], 'string'],
        ];
    }

    /**
     * @return \app\queries\ProjectsQuery|\yii\db\ActiveQuery
     */
    public function getQuery()
    {
        $query = Projects::find();

        if ($this->any) {
            $query->andWhere([
                'or',
                ['like', 'slug', $this->any],
                ['like', 'name', $this->any],
                ['like', 'description', $this->any]
            ]);
        }

        $query
            ->andFilterWhere(['slug' => $this->slug])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $query;
    }
}
