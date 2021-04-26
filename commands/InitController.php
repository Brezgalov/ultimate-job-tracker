<?php

namespace app\commands;

use app\forms\CreateUserForm;
use app\models\Users;
use yii\console\Controller;

/**
 * Class InitController
 * @package app\commands
 */
class InitController extends Controller
{
    /**
     *
     */
    public function actionIndex()
    {
        $adminEmail = 'admin@default.me';

        $admin = Users::findOne(['email' => $adminEmail]);
        if (empty($admin)) {
            $createUserForm = \Yii::$container->get(CreateUserForm::class, [], [
                'email' => $adminEmail,
                'password' => 'adminadmin',
                'name' => 'Admin',
                'login' => 'admin',
            ]);

            $user = $createUserForm->createUser();
            $user->save();
        }
    }
}
