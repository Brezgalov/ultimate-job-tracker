<?php

namespace app\commands;

use app\forms\UserCreateForm;
use app\models\ProjectRoles;
use app\models\Projects;
use app\models\Users;
use yii\console\Controller;

/**
 * Class InitController
 * @package app\commands
 */
class InitController extends Controller
{
    /**
     *
     */
    public function actionIndex()
    {
        $this->actionCreateUsers();

        $this->actionCreateRoles();

        $this->actionCreateProjects();
    }

    public function actionCreateUsers()
    {
        $adminEmail = 'admin@default.me';

        $admin = Users::findOne(['email' => $adminEmail]);
        if (empty($admin)) {
            $createUserForm = \Yii::$container->get(UserCreateForm::class, [], [
                'email' => $adminEmail,
                'password' => 'adminadmin',
                'name' => 'Admin',
                'login' => 'admin',
            ]);

            $admin = $createUserForm->createUser();
            $admin->save();
        }
    }

    public function actionCreateRoles()
    {
        $roles = [
            'admin' => [
                'name' => 'Super Админ',
            ],
            'manager' => [
                'name' => 'Менаджер',
            ],
            'worker' => [
                'name' => 'Сотрудник',
            ],
        ];

        foreach ($roles as $slug => $roleData) {
            $nextRoleExists = ProjectRoles::find()
                ->andWhere(['slug' => $slug])
                ->exists();

            if ($nextRoleExists) {
                continue;
            }

            $nextRole = new ProjectRoles([
                'name' => $roleData['name'],
                'slug' => $slug
            ]);

            $nextRole->save();
        }
    }

    public function actionCreateProjects()
    {
        $testProjectExists = Projects::find()
            ->andWhere(['slug' => 'test'])
            ->exists();

        if (!$testProjectExists) {
            $testProject = new Projects();

            $testProject->load([
                'name' => 'Test Project',
                'slug' => 'test',
            ], '');

            $testProject->save();
        }
    }
}
