<?php

namespace app\actions\projects;

use app\forms\ProjectAddUserForm;
use app\forms\ProjectInputForm;
use app\models\Projects;
use app\models\search\ProjectRolesSearch;
use app\models\search\UsersSearch;
use yii\base\Action;

class UpdateAction extends Action
{
    public function run($slug)
    {
        /* @var $project Projects */
        $project = Projects::find()->slug($slug)->one();
        if (empty($project)) {
            // redirect 404
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