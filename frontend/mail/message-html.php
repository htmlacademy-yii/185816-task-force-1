<?php

use common\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $taskID int */
/* @var $recipient common\models\User  */

$recipient = User::findOne(Yii::$app->user->id);

$linkToTask = Yii::$app->urlManager->createAbsoluteUrl(['tasks/view', 'id' => $taskID]);
?>

<div class="password-reset">
    <p>Hello <?= Html::encode($user->full_name) ?>,</p>

    <p>You have a new message from <?=$recipient->full_name ?></p>

    <p><?= Html::a(Html::encode($linkToTask), $linkToTask) ?></p>
</div>
