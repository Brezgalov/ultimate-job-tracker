<?php

namespace app\queries;

use yii\db\ActiveQuery;

class ProjectsQuery extends ActiveQuery
{
    /**
     * @param $slug
     * @return ProjectsQuery
     */
    public function slug($slug)
    {
        return $this->andWhere(['slug' => $slug]);
    }
}