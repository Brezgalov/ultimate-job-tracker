<?php

namespace app\models;

use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "project_roles".
 *
 * @property int $id
 * @property string $slug
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
            [['slug', 'name'], 'required'],
            [['slug', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'slug' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'ensureUnique' => true,
                'immutable' => true,
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
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
