<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ActiveField;

?>

<section class="search-task">
    <div class="search-task__wrapper">
        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'search-task__form']
        ]) ?>
        <fieldset class="search-task__categories">
            <legend>Категории</legend>
            <?php
            echo $form->field($model, 'categories')->checkboxList($model->attributeLabels())->label(false);
            ?>
        </fieldset>
        <fieldset class="search-task__categories">
            <legend>Дополнительно</legend>
            <?php
            echo $form->field($model, 'additionally')->checkboxList([
                'no response' => 'Без откликов',
                'telework' => 'Удаленная работа'
            ])->label(false);
            ?>
        </fieldset>
        <label class="search-task__name" for="8">Период</label>
        <?php echo $form->field($model, 'period')->dropDownList(['day' => 'За день', 'week' => 'За неделю', 'month' => 'За менсяц'], ['class' => 'multiple-select input'])->label(false)?>
        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php $form = ActiveForm::end() ?>
    </div>
</section>
