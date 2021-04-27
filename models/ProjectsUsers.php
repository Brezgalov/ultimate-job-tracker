<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "projects_users".
 *
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 * @property int $role_id
 * @property int|null $created_at
 *
 * @property Projects $project
 * @property ProjectRoles $role
 * @property Users $user
 */
class ProjectsUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projects_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id', 'role_id'], 'required'],
            [['project_id', 'user_id', 'role_id', 'created_at'], 'integer'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::class, 'targetAttribute' => ['project_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectRoles::class, 'targetAttribute' => ['role_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
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
            'project_id' => 'Project ID',
            'user_id' => 'User ID',
            'role_id' => 'Role ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Project]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Projects::class, ['id' => 'project_id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(ProjectRoles::class, ['id' => 'role_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
}
