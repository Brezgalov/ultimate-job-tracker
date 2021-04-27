<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * UsersSearch represents the model behind the search form of `app\models\Users`.
 */
class UsersSearch extends Model implements ISearch
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['email', 'name'], 'string'],
        ];
    }

    /**
     * @return array
     */
    public function getUsersDropdownItems()
    {
        $itemsFound = $this->getQuery()
            ->select(new Expression("id, CONCAT(name, ' (', login, ')') as name"))
            ->asArray()
            ->all();

        return ArrayHelper::map($itemsFound, 'id', 'name');
    }

    public function getQuery()
    {
        $query = Users::find();

        // grid filtering conditions
        $query
            ->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['like', 'email', $this->email])
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
        $query = Users::find();

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
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
