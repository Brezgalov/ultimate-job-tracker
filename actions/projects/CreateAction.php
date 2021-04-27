<?php

namespace app\actions\projects;

use app\forms\ProjectAddUserForm;
use app\forms\ProjectInputForm;
use app\models\search\ProjectRolesSearch;
use app\models\search\UsersSearch;
use yii\base\Action;

class CreateAction extends Action
{
    public function run()
    {
        $usersSearch = \Yii::$container->get(UsersSearch::class);
        $rolesSearch = \Yii::$container->get(ProjectRolesSearch::class);

        $inputModel = \Yii::$container->get(ProjectInputForm::class);

        if ($inputModel->load(\Yii::$app->request->post()) && $inputModel->save()) {
            return $this->controller->redirect(['view', 'id' => $inputModel->id]);
        }

        return $this->controller->render('create', [
            'model' => $inputModel,

            'rolesAvailable'        => $rolesSearch->getRolesDropdownItems(),
            'usersAvailableList'    => $usersSearch->getUsersDropdownItems(),
            'addUserForm'           => \Yii::$container->get(ProjectAddUserForm::class),
        ]);
    }
}