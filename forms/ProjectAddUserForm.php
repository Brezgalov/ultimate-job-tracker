<?php

namespace app\forms;

use app\models\ProjectRoles;
use app\models\Projects;
use app\models\ProjectsUsers;
use app\models\Users;
use yii\base\Model;

class ProjectAddUserForm extends Model
{
    /**
     * @var int
     */
    public $user_id;

    /**
     * @var int
     */
    public $project_id;

    /**
     * @var int
     */
    public $role_id;

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            ['user_id', 'exist', 'targetClass' => Users::class, 'targetAttribute' => 'id'],
            ['project_id', 'exist', 'targetClass' => Projects::class, 'targetAttribute' => 'id'],
            ['role_id', 'exist', 'targetClass' => ProjectRoles::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'user_id'       => 'Пользователь',
            'role_id'       => 'Роль',
            'project_id'    => 'Проект',
        ];
    }

    /**
     * @return bool
     */
    public function addUserToProject()
    {
        if (!$this->validate()) {
            return false;
        }

        $userAdded = ProjectsUsers::findOne([
            'project_id' => $this->project_id,
            'user_id' => $this->user_id,
        ]);

        if (empty($userAdded)) {
            $userAdded = new ProjectsUsers([
                'project_id' => $this->project_id,
                'user_id' => $this->user_id,
            ]);
        }

        if ((int)$userAdded->role_id !== (int)$this->role_id) {
            $userAdded->role_id = $this->role_id;
            if (!$userAdded->save()) {
                $this->addErrors(
                    $userAdded->getErrors()
                );
                return false;
            }
        }

        return true;
    }
}