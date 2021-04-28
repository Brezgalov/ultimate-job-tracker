<?php

namespace app\queries;

use yii\db\ActiveQuery;

class TaskStatusesQuery extends ActiveQuery
{
    /**
     * @param $slug
     * @return TaskStatusesQuery
     */
    public function slug($slug)
    {
        return $this->andWhere(['slug' => $slug]);
    }

    /**
     * @return TaskStatusesQuery
     */
    public function default()
    {
        return $this
            ->andWhere(['is_default' => 1])
            ->limit(1)
            ->orderBy('id DESC');
    }
}