<?php
/**
 * @var  UsersForm $usersSearchForm
 * @var Category $categories
 */

use common\models\Category;
use frontend\forms\UsersForm;
use frontend\helpers\TemplateCheckbox;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'search-task__form'],
    'method' => 'GET'
]) ?>

<fieldset class="search-task__categories">
    <legend>Категории</legend>
    <?= Html::activeCheckboxList($usersSearchForm, 'categories', (array)$categories, ['item' =>
        function ($index, $label, $name, $checked, $value) {
            return TemplateCheckbox::create($label, $name, $checked, $value);
        }]);
    ?>
</fieldset>
<fieldset class="search-task__categories">
    <legend>Дополнительно</legend>
    <?= Html::activeCheckboxList($usersSearchForm, 'additionally',
        [
            'free' => 'Сейчас свободен',
            'online' => 'Сейчас онлайн',
            'responses' => 'Есть отзывы',
            'favorites' => 'В избранном'
        ],
        ['item' => function ($index, $label, $name, $checked, $value) {
            return TemplateCheckbox::create($label, $name, $checked, $value);
        }]);
    ?>
</fieldset>
<label class="search-task__name" for="9">Поиск по названию</label>
<?= Html::activeInput('search', $usersSearchForm, 'search', ['class' => 'input-middle input']) ?>
<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']); ?>
</div>
<?php $form = ActiveForm::end() ?>
