<?php
/**
 * @var common\models\Category $categories
 * @var DataProvider $tasks
 * @var Task $task
 * @var TasksForm $taskForm
 **/

use common\models\Task;
use frontend\forms\TasksForm;
use yii\debug\models\timeline\DataProvider;

$this->title = 'Задания';
?>
<div style="width: 1098px; margin: auto;">
    <?php if (Yii::$app->session->getFlash('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo Yii::$app->session->getFlash('success') ?></div>
    <?php endif; ?>
    <?php if (Yii::$app->session->getFlash('error')): ?>
        <div class="alert alert-danger" role="alert"><?php echo Yii::$app->session->getFlash('error') ?></div>
    <?php endif; ?>
</div>
<div class="main-container page-container">
    <section class="new-task">
        <div class="new-task__wrapper">
            <?php if (empty($tasks->getModels())) : ?>
                <h1><?= 'Задания не найдены' ?></h1>
            <?php else: ?>
                <h1>Новые задания</h1>
            <?php endif ?>
            <?php foreach ($tasks->getModels() as $task) : ?>
               <?= $this->renderFile(__DIR__ . '/components/task-card.php', [
                   'task' => $task
                ]) ?>
            <?php endforeach; ?>
            <?= yii\widgets\ListView::widget([
                'dataProvider' => $tasks,
                'layout' => "{pager}"
            ]); ?>
        </div>
    </section>
    <?= $this->renderFile(__DIR__ . '/components/asideFilter.php', [
        'taskForm' => $taskForm,
        'categories' => $categories
    ])?>
</div>
