<?php

/**
 * @var $task Task;
 */

use common\models\Task;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="new-task__card">
    <div class="new-task__title">
        <a href="<?= Url::to(['tasks/view', 'id' => $task->id]) ?>" class="link-regular">
            <h2><?= Html::encode($task->title) ?></h2>
        </a>
        <a class="new-task__type link-regular" href="<?= Url::to(['tasks/index', 'TasksForm[categories][]='=> $task->category_id ]) ?>">
            <p><?= Html::encode($task->category->category_name) ?></p></a>
    </div>
    <div class="new-task__icon new-task__icon--translation"></div>
    <p class="new-task_description">
        <?= Html::encode($task->description) ?>
    </p>
    <b class="new-task__price new-task__price--translation"><?= Html::encode($task->budget) ?><b> ₽</b></b>
    <p class="new-task__place"><?= Html::encode($task->city->name) ?></p>
    <span
        class="new-task__time"><?= Html::encode(Yii::$app->formatter->asDate($task->created_at)) ?></span>
</div>
