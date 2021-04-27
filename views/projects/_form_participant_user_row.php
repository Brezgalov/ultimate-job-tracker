<?php

use yii\helpers\ArrayHelper;

/* @var $userData array */
/* @var $rolesAvailable array */
/* @var $formName string */

if (!array_key_exists('user_id', $userData) || !$userData['user_id']) {
    return '';
}

?>

<div class="project-participant-row form-inline" data-id="<?= $userData['user_id'] ?>">
    <span class="worker-name"><?= ArrayHelper::getValue($userData, 'user_name', "Пользователь #{$userData['user_id']}") ?></span>

    <input type="hidden" name="<?= $formName ?>[users][<?= $userData['user_id'] ?>][user_id]" value="<?= $userData['user_id'] ?>" />

    <div>
        <select class="form-control" name="<?= $formName ?>[users][<?= $userData['user_id'] ?>][role_id]">
            <?php foreach ($rolesAvailable as $roleId => $roleName): ?>
                <option value="<?= $roleId ?>" <?= $roleId == ArrayHelper::getValue($userData, 'role_id') ? 'selected' : '' ?>>
                    <?= $roleName ?>
                </option>
            <?php endforeach;?>
        </select>
        <i class="trash-participant-row glyphicon glyphicon-remove" data-id="<?= $userData['user_id'] ?>"></i>
    </div>

</div>