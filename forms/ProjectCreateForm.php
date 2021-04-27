<?php

namespace app\forms;

use yii\base\Model;

class ProjectCreateForm extends Model
{
    /**
     * @var array
     */
    public $users = [];

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $slug;
}