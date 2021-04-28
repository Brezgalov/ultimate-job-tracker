<?php

namespace app\actions\projects;

use app\models\Projects;
use app\models\search\ProjectsSearch;
use yii\base\Action;

class KanbanAction extends Action
{
    /**
     * @param $slug
     * @return string|\yii\web\Response
     */
    public function run($slug)
    {
        $projectSearch = \Yii::$container->get(ProjectsSearch::class, [], ['slug' => $slug]);

        /* @var $project Projects */
        $project = $projectSearch->getQuery()->one();
        if (empty($project)) {
            // @todo: redirect 404
            return $this->controller->redirect('/');
        }

        return $this->controller->render('kanban', [
            'project' => $project,
        ]);
    }
}