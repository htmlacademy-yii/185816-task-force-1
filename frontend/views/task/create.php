<?php

/**
 * @var object $form yii\widgets\ActiveForm
 * @var object $model frontend\forms\CreateTaskForm
 * @var array $errors
 */

use yii\widgets\ActiveForm;
use common\models\Category;
use common\models\City;

$this->title = 'Публикация нового задания';

?>

<div class="main-container page-container">
    <section class="create__task">
        <h1>Публикация нового задания</h1>
        <div class="create__task-main">
            <?php $form = ActiveForm::begin(
                [
                    'options' => [
                        'class' => 'create__task-form form-create',
                        'enctype' => 'multipart/form-data'
                    ]
                ]
            ) ?>
            <?= $form->field(
                $model,
                'title',
                [
                    'inputOptions' => [
                        'class' => 'input textarea',
                        'placeholder' => 'Повесить полку',
                        'style' => 'display: block; width: 100%'
                    ]
                ]
            ) ?>
            <span>Кратко опишите суть работы</span>
            <?= $form->field(
                $model,
                'description',
                [
                    'inputOptions' => [
                        'class' => 'input textarea',
                        'placeholder' => 'Введите текст',
                        'style' => 'display: block; width: 100%'
                    ]
                ]
            )->textarea(['rows' => 7, 'cols' => 5]) ?>
            <span>Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться</span>
            <?= $form->field(
                $model,
                'category_id',
                [
                    'inputOptions' => [
                        'class' => 'multiple-select input multiple-select-big',
                        'placeholder' => 'Введите текст',
                        'style' => 'display: block; width: 100%'
                    ]
                ]
            )->dropDownList(Category::find()->select(['category_name', 'id'])->indexBy('id')->column()) ?>
            <span>Выберите категорию</span>
            <label>Файлы</label>
            <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>
            <div class="create__file">
                <span>Добавить новый файл</span>
                <?= $form->field($model, 'file')->fileInput() ?>
            </div>
            <?= $form->field(
                $model,
                'address',
                [
                    'inputOptions' => [
                        'class' => 'input-navigation input-middle input',
                        'placeholder' => 'Санкт-Петербург, Калининский район',
                        'style' => 'display: block; width: 100%',
                        'id' => 'autoComplete'
                    ]
                ]
            ) ?>
            <span>Укажите адрес исполнения, если задание требует присутствия</span>
            <div class="create__price-time">
                <div class="create__price-time--wrapper">
                    <?= $form->field(
                        $model,
                        'budget',
                        [
                            'inputOptions' => [
                                'class' => 'input textarea input-money',
                                'placeholder' => 'Бюджет',
                                'style' => 'display: block;'
                            ]
                        ]
                    ) ?>
                    <span>Не заполняйте для оценки исполнителем</span>
                </div>
                <div class="create__price-time--wrapper">
                    <?= $form->field(
                        $model,
                        'deadline',
                        [
                            'inputOptions' => [
                                'class' => 'input-middle input input-date',
                                'placeholder' => '2020-10-11 15:00',
                                'style' => 'display: block;',
                                'type' => 'date'
                            ]
                        ]
                    ) ?>
                    <span>Укажите крайний срок исполнения</span>
                </div>
            </div>
            <button type="submit" class="button">Опубликовать</button>
            <?php ActiveForm::end() ?>
            <div class="create__warnings">
                <div class="warning-item warning-item--advice">
                    <h2>Правила хорошего описания</h2>
                    <h3>Подробности</h3>
                    <p>Друзья, не используйте случайный<br>
                        контент – ни наш, ни чей-либо еще. Заполняйте свои
                        макеты, вайрфреймы, мокапы и прототипы реальным
                        содержимым.</p>
                    <h3>Файлы</h3>
                    <p>Если загружаете фотографии объекта, то убедитесь,
                        что всё в фокусе, а фото показывает объект со всех
                        ракурсов.</p>
                </div>
                <?php if ($model->getErrors()) : ?>
                    <div class="warning-item warning-item--error">
                        <h2>Ошибки заполнения формы</h2>
                        <?php foreach ($model->getErrors() as $error => $value): ?>
                            <h3><?= $model->attributeLabels()[$error] ?></h3>
                            <?php foreach ($value as $key): ?>
                                <p><?= $key ?></p>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
