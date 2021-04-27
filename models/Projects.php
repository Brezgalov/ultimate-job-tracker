<?php

namespace app\models;

use app\queries\ProjectsQuery;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "projects".
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $description
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
     * @return ProjectsQuery
     */
    public static function find()
    {
        return new ProjectsQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['slug', 'name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 65000],
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
            'slug' => 'Url названия',
            'name' => 'Название',
            'description' => 'Описание',
            'created_at' => 'Дата создания',
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
