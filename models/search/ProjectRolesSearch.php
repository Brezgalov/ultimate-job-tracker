<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProjectRoles;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * Class ProjectRolesSearch
 * @package app\models\search
 */
class ProjectRolesSearch extends BaseSearch
{
    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'name'], 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function getRolesDropdownItems()
    {
        $itemsFound = $this->getQuery()
            ->select(new Expression("id, CONCAT(name, ' (', slug, ')') as name"))
            ->asArray()
            ->all();

        return ArrayHelper::map($itemsFound, 'id', 'name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuery()
    {
        $query = ProjectRoles::find();

        $query
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $query;
    }
}
