<?php

namespace app\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $login
 * @property string $email
 * @property string $name
 * @property string $password_hash
 * @property string $auth_key
 * @property int|null $created_at
 *
 * @property ProjectsUsers[] $projectsUsers
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @param int|string $id
     * @return Users|IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return Users|IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'name', 'password_hash'], 'required'],
            [['created_at'], 'integer'],
            [['email', 'name', 'password_hash'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'email' => 'E-mail',
            'name' => 'Имя',
            'password_hash' => 'Хэш пароля',
            'auth_key' => 'Ключ авторизации',
            'created_at' => 'Дата создания',
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
            'auth_key' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['auth_key'],
                ],
                'value' => function() {
                    return \Yii::$app->security->generateRandomString();
                }
            ]
        ]);
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return false
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key == $authKey;
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @return int|null
     */
    public function getDefaultProjectSlug()
    {
        $ids = Projects::find()->select('slug')->orderBy('id DESC')->column();

        return array_shift($ids);
    }

    /**
     * Gets query for [[ProjectsUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsUsers()
    {
        return $this->hasMany(ProjectsUsers::class, ['user_id' => 'id']);
    }
}
