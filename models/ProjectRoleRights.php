<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_role_rights".
 *
 * @property int $id
 * @property int $project_role_id
 * @property string $rights_code
 *
 * @property ProjectRoles $projectRole
 */
class ProjectRoleRights extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_role_rights';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_role_id', 'rights_code'], 'required'],
            [['project_role_id'], 'integer'],
            [['rights_code'], 'string', 'max' => 255],
            [['project_role_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectRoles::class, 'targetAttribute' => ['project_role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_role_id' => 'Project Role ID',
            'rights_code' => 'Rights Code',
        ];
    }

    /**
     * Gets query for [[ProjectRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectRole()
    {
        return $this->hasOne(ProjectRoles::class, ['id' => 'project_role_id']);
    }
}
