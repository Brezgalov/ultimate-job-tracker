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
class ProjectRolesSearch extends Model implements ISearch
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ProjectRoles::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
