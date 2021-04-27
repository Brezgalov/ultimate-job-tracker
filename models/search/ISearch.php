<?php

namespace app\models\search;

use yii\db\ActiveQuery;

interface ISearch
{
    /**
     * @return ActiveQuery
     */
    public function getQuery();
}