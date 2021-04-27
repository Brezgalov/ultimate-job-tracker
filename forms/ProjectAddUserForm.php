<?php

namespace app\forms;

use yii\base\Model;

class ProjectAddUserForm extends Model
{
    public $user_id;

    public $project_id;

    public $role_code;
}