<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;

abstract class BaseSearch extends Model implements ISearch
{
    /**
     * @return \yii\db\ActiveQuery
     */
    abstract public function getQuery();

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        $this->load($params, '');
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $this->getQuery(),
        ]);

        if (!$this->validate()) {
            $dataProvider->query->andWhere([0 => '1']);

            return $dataProvider;
        }

        return $dataProvider;
    }
}