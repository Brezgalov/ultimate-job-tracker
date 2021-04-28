<?php

namespace app\actions\projects;

use app\forms\ProjectAddUserForm;
use app\forms\ProjectInputForm;
use app\models\Projects;
use app\models\search\ProjectRolesSearch;
use app\models\search\ProjectsSearch;
use app\models\search\UsersSearch;
use yii\base\Action;

class UpdateAction extends Action
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

        $inputModel = \Yii::$container->get(ProjectInputForm::class);
        $inputModel->loadFormProject($project);

        if (\Yii::$app->request->isPost) {
            $inputModel->load(\Yii::$app->request->post());

            $result = $inputModel->storeProject();

            if ($result) {
                return $this->controller->redirect(['update', 'slug' => $result->slug]);
            }
        }

        $usersSearch = \Yii::$container->get(UsersSearch::class);
        $rolesSearch = \Yii::$container->get(ProjectRolesSearch::class);

        $usersAvailableList = $usersSearch->getUsersDropdownItems();

        foreach (array_keys($inputModel->users) as $userAlreadyAddedId) {
            unset($usersAvailableList[$userAlreadyAddedId]);
        }

        return $this->controller->render('update', [
            'model' => $inputModel,

            'rolesAvailable'        => $rolesSearch->getRolesDropdownItems(),
            'usersAvailableList'    => $usersAvailableList,
            'addUserForm'           => \Yii::$container->get(ProjectAddUserForm::class),
        ]);
    }
}