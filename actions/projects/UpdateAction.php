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

        $usersSearch = \Yii::$container->get(UsersSearch::class);
        $rolesSearch = \Yii::$container->get(ProjectRolesSearch::class);

        $inputModel = \Yii::$container->get(ProjectInputForm::class);
        $inputModel->loadFormProject($project);

        if ($inputModel->load(\Yii::$app->request->post()) && $inputModel->save()) {
            return $this->controller->redirect(['view', 'id' => $inputModel->id]);
        }

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