<?php

use app\forms\ProjectAddUserForm;
use app\models\search\UsersSearch;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Projects */
/* @var $usersSearch UsersSearch */
/* @var $addUserForm ProjectAddUserForm*/

$this->title = 'Создание Проекта';
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,

        'usersSearch' => $usersSearch,
        'addUserForm' => $addUserForm,
    ]) ?>

</div>
