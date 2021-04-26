<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_roles".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 *
 * @property ProjectRoleRights[] $projectRoleRights
 * @property ProjectsUsers[] $projectsUsers
 */
class ProjectRoles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[ProjectRoleRights]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectRoleRights()
    {
        return $this->hasMany(ProjectRoleRights::class, ['project_role_id' => 'id']);
    }

    /**
     * Gets query for [[ProjectsUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsUsers()
    {
        return $this->hasMany(ProjectsUsers::class, ['role_id' => 'id']);
    }
}
