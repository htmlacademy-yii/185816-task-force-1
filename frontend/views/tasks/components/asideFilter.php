<?php
/**
 * @var common\models\Category $categories
 * @var common\models\Task $tasks
 * @var TasksForm $taskForm
 **/

use frontend\forms\TasksForm;
use yii\widgets\ActiveForm;
use frontend\helpers\TemplateCheckbox;
use yii\helpers\Url;
use yii\helpers\Html;
?>

<section class="search-task">
    <div class="search-task__wrapper">
        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'search-task__form'],
            'action' => Url::to(['tasks/']),
            'method' => 'GET'
        ]) ?>
        <fieldset class="search-task__categories">
            <legend>Категории</legend>
            <?= Html::activeCheckboxList($taskForm, 'categories', $categories, ['item' =>
                function ($index, $label, $name, $checked, $value) {
                    return TemplateCheckbox::create($label, $name, $checked, $value);
                }]);
            ?>
        </fieldset>
        <fieldset class="search-task__categories">
            <legend>Дополнительно</legend>
            <?= Html::activeCheckboxList($taskForm, 'additionally',
                ['response' => 'Без откликов', 'telework' => 'Удаленная работа'],
                ['item' => function ($index, $label, $name, $checked, $value) {
                    return TemplateCheckbox::create($label, $name, $checked, $value);
                }]);
            ?>
        </fieldset>
        <label class="search-task__name" for="tasksform-period">Период</label>
        <?= Html::activeDropDownList($taskForm, 'period', [
            '0' => 'За все время',
            '86000' => 'За день',
            '604800' => 'За неделю',
            '2419200' => 'За менсяц'],
            ['class' => 'multiple-select input']);
        ?>
        <label class="search-task__name" for="tasksform-search">Поиск по названию</label>
        <?= Html::activeInput('search', $taskForm, 'search', ['class' => 'input-middle input']) ?>
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']); ?>
        <?php $form = ActiveForm::end() ?>
    </div>
</section>
