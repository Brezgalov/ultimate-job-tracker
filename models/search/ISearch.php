<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

interface ISearch
{
    /**
     * @return ActiveQuery
     */
    public function getQuery();

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params);
}