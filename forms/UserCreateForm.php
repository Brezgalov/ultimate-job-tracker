<?php

namespace app\forms;

use app\models\Users;
use yii\base\Model;

class UserCreateForm extends Model
{
    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $name;

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [['login', 'password', 'name'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * Создание пользователя
     * @return Users|false
     */
    public function createUser()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new Users([
            'login' => $this->login,
            'email' => $this->email,
            'name' => $this->name,
        ]);

        $user->setPassword($this->password);

        return $user;
    }
}