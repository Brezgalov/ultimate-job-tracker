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
class UsersSearch extends BaseSearch
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

    /**
     * @return \yii\db\ActiveQuery
     */
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
}
