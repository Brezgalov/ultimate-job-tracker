<?php

namespace app\commands;

use app\forms\ProjectInputForm;
use app\forms\TaskCreateForm;
use app\forms\UserCreateForm;
use app\models\ProjectRoles;
use app\models\Projects;
use app\models\Tasks;
use app\models\TaskStatuses;
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

        $this->actionCreateTaskStatuses();

        $this->actionCreateTasks();
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

            if (!$createProjectForm->storeProject()) {
                throw new \Exception('Не удается создать тестовый проект');
            }
        }

        $trans->commit();
    }

    public function actionCreateTaskStatuses()
    {
        $trans = \Yii::$app->db->beginTransaction();

        $taskStatuses = [
            [
                'name' => 'Новое',
                'slug' => 'new',
                'is_default' => 1,
                'is_kanban' => 1,
                'kanban_order' => 0,
            ],
            [
                'name' => 'В процессе',
                'slug' => 'in_progress',
                'is_default' => 0,
                'is_kanban' => 1,
                'kanban_order' => 1,
            ],
            [
                'name' => 'Готово к тестированию',
                'slug' => 'ready_for_test',
                'is_default' => 0,
                'is_kanban' => 1,
                'kanban_order' => 2,
            ],
            [
                'name' => 'Завершено',
                'slug' => 'complete',
                'is_default' => 0,
                'is_kanban' => 1,
                'kanban_order' => 3,
            ],
            [
                'name' => 'Архив',
                'slug' => 'archived',
                'is_default' => 0,
                'is_kanban' => 0,
                'kanban_order' => 0,
            ],
        ];

        foreach ($taskStatuses as $taskStatusData) {
            $statusExist = TaskStatuses::find()->slug($taskStatusData['slug'])->exists();

            if ($statusExist) {
                continue;
            }

            $status = new TaskStatuses($taskStatusData);
            if (!$status->save()) {
                throw new \Exception("Не удается сохранить статус {$status->slug}");
            }
        }

        $trans->commit();
    }

    public function actionCreateTasks()
    {
        $trans = \Yii::$app->db->beginTransaction();

        $project = Projects::find()->slug('test')->one();
        if (empty($project)) {
            return;
        }

        $tasks = [
            [
                'title' => 'Тестовая задача #1',
                'subTasks' => [],
            ],
            [
                'title' => 'Тестовая задача #2',
                'subTasks' => [
                    [
                        'title' => 'Тестовая задача #2.1',
                    ],
                    [
                        'title' => 'Тестовая задача #2.2',
                    ],
                ],
            ],
            [
                'title' => 'Тестовая задача #3',
                'subTasks' => [
                    [
                        'title' => 'Тестовая задача #3.1',
                    ],
                ],
            ],
        ];

        foreach ($tasks as $task) {
            $taskInstance = $this->createSingleTask($project->id, $task);

            if (!$taskInstance) {
                continue;
            }

            foreach ($task['subTasks'] as $subTask) {
                $subTask['parent_task_id'] = $taskInstance->id;

                $this->createSingleTask($project->id, $subTask);
            }
        }

        $trans->commit();
    }

    private function createSingleTask($projectId, array $params)
    {
        $form = \Yii::$container->get(TaskCreateForm::class);
        $form->load($params, '');
        $form->project_id = $projectId;

        $taskExists = Tasks::find()->andWhere(['title' => $form->title])->one();
        if ($taskExists) {
            return null;
        }

        $task = $form->createTask();
        if (!$task) {
            throw new \Exception('Не удается создать задачу "' . $form->title . '"');
        }

        return $task;
    }
}
