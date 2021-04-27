<?php

namespace app\commands;

use app\forms\ProjectInputForm;
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
        $trans = \Yii::$app->db->beginTransaction();

        $users = [
            [
                'login' => 'admin',
                'name' => 'Admin',
                'password' => 'adminadmin',
            ],
            [
                'login' => 'manager1',
                'name' => 'Алексей Венидиктов',
                'password' => '1111',
            ],
            [
                'login' => 'worker1',
                'name' => 'Александр Плющев',
                'password' => '1111',
            ],
            [
                'login' => 'worker2',
                'name' => 'Григорий Юдин',
                'password' => '1111',
            ],
            [
                'login' => 'worker3',
                'name' => 'Максим Курников',
                'password' => '1111',
            ],
            [
                'login' => 'worker4',
                'name' => 'Татьяна Фельгенгауэр',
                'password' => '1111',
            ],
            [
                'login' => 'worker5',
                'name' => 'Александр Климов',
                'password' => '1111',
            ],
            [
                'login' => 'worker5',
                'name' => 'Маша Маерс',
                'password' => '1111',
            ],
            [
                'login' => 'worker6',
                'name' => 'Алексей Нарышкин',
                'password' => '1111',
            ],
        ];

        foreach ($users as $userData) {
            $nextUser = Users::findOne(['login' => $userData['login']]);
            if (empty($nextUser)) {
                $createUserForm = \Yii::$container->get(UserCreateForm::class, [], $userData);

                $nextUser = $createUserForm->createUser();
                if (!$nextUser->save()) {
                    throw new \Exception("Не удается создать пользователя {$userData['login']}");
                }
            }
        }



        $trans->commit();
    }

    public function actionCreateRoles()
    {
        $trans = \Yii::$app->db->beginTransaction();

        $roles = [
            ProjectRoles::ROLE_ADMIN_SLUG => [
                'name' => 'Super Админ',
            ],
            ProjectRoles::ROLE_MANAGER_SLUG => [
                'name' => 'Менаджер',
            ],
            ProjectRoles::ROLE_WORKER_SLUG => [
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

            if (!$nextRole->save()) {
                throw new \Exception("Не удается создать роль {$slug}");
            }
        }

        $trans->commit();
    }

    public function actionCreateProjects()
    {
        $trans = \Yii::$app->db->beginTransaction();

        $testProjectExists = Projects::find()
            ->andWhere(['slug' => 'test'])
            ->exists();

        if (!$testProjectExists) {
            $createProjectForm = \Yii::$container->get(ProjectInputForm::class, [], [
                'name'  => 'Тестовый проект',
                'slug'  => 'test',
            ]);

            $usersToAdd = [
                'admin' => ProjectRoles::ROLE_ADMIN_SLUG,
                'manager1' => ProjectRoles::ROLE_MANAGER_SLUG,
                'worker1' => ProjectRoles::ROLE_WORKER_SLUG,
                'worker2' => ProjectRoles::ROLE_WORKER_SLUG,
                'worker3' => ProjectRoles::ROLE_WORKER_SLUG,
            ];

            foreach ($usersToAdd as $login => $roleSlug) {
                $nextUserId = Users::find()
                    ->select('id')
                    ->andWhere(['login' => $login])
                    ->column();
                $nextUserId = empty($nextUserId) ? null : $nextUserId[0];

                $nextRoleId = ProjectRoles::find()
                    ->select('id')
                    ->andWhere(['slug' => $roleSlug])
                    ->column();
                $nextRoleId = empty($nextRoleId) ? null : $nextRoleId[0];

                if ($nextUserId && $nextRoleId) {
                    $createProjectForm->users[$nextUserId] = [
                            'user_id' => $nextUserId,
                            'role_id' => $nextRoleId,
                    ];
                }
            }

            if (!$createProjectForm->createProject()) {
                throw new \Exception('Не удается создать тестовый проект');
            }
        }

        $trans->commit();
    }
}
