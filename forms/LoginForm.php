<?php

namespace app\forms;

use app\models\Users;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read Users|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();

            if (empty($user)) {
                return false;
            }

            $drop = 100;
            do {
                $user->auth_key = \Yii::$app->security->generateRandomString();

                $authKeyIsUnique = Users::find()->where(['auth_key' => $user->auth_key])->exists();
                $drop -= 1;
            } while (!$authKeyIsUnique || $drop <= 0);

            $user->save();

            return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return Users|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Users::find()->where(['login' => $this->username])->one();
        }

        return $this->_user;
    }
}
