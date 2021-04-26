<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projects".
 *
 * @property int $id
 * @property string $name_url
 * @property string $name
 * @property int|null $created_at
 *
 * @property ProjectsUsers[] $projectsUsers
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_url', 'name'], 'required'],
            [['created_at'], 'integer'],
            [['name_url', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_url' => 'Name Url',
            'name' => 'Name',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[ProjectsUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsUsers()
    {
        return $this->hasMany(ProjectsUsers::class, ['project_id' => 'id']);
    }
}
