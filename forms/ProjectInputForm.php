<?php

namespace app\forms;

use app\models\Projects;
use app\models\Users;
use yii\base\Model;

class ProjectInputForm extends Model
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var array
     */
    public $users = [];

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $description;

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id', 'name', 'slug', 'users', 'description'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Url названия',
            'name' => 'Название',
            'description' => 'Описание',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * @param Projects $project
     */
    public function loadFormProject(Projects $project)
    {
        $this->load($project->toArray(), '');

        foreach ($project->projectsUsers as $projectsUser) {
            $user = $projectsUser->user;

            $this->users[$user->id] = [
                'project_id' => $project->id,
                'user_id' => $user->id,
                'user_name' => "{$user->name} ({$user->login})",
                'role_id' => $projectsUser->role_id,
            ];
        }
    }

    /**
     * @return bool
     */
    public function storeProject()
    {
        if (!$this->validate()) {
            return false;
        }

        $project = null;

        if ($this->id) {
            $project = Projects::findOne($this->id);
        }

        if (empty($project)) {
            $project = new Projects();
        }

        $project->load([
            'name'          => $this->name,
            'slug'          => $this->slug,
            'description'   => $this->description,
        ], '');

        if (!$project->save()) {
            $this->addErrors(
                $project->getErrors()
            );
            return false;
        }

        if (!empty($this->users) && is_array($this->users)) {
            $addUserForm = \Yii::$container->get(ProjectAddUserForm::class, [], [
                'project_id' => $project->id,
            ]);

            foreach ($this->users as $userData) {
                $addUserForm->load($userData, '');

                if (!$addUserForm->addUserToProject()) {
                    $this->addErrors($addUserForm->getErrors());
                    return false;
                }
            }
        }

        return $project;
    }
}