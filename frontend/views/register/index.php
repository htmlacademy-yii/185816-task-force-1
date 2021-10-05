<?php

/**
 * @var $model SingupForm
 * @var $cities City
 */

use common\models\City;
use frontend\forms\SingupForm;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация';

?>

<div class="main-container page-container">
    <section class="registration__user">
        <h1>Регистрация аккаунта</h1>
        <div class="registration-wrapper">
            <?php $form = ActiveForm::begin(['options' => [
                'class'=> 'registration__user-form form-create'
            ]])?>
            <?=$form->field($model, 'email',
                [
                    'inputOptions' => ['class' => 'input textarea', 'placeholder' => 'kumarm@mail.ru', 'style' => 'width: 100%']
                ]
            ) ?>
            <?=$form->field($model, 'full_name',
                [
                    'inputOptions' => ['class' => 'input textarea', 'placeholder' => 'Мамедов Кумар', 'style' => 'width: 100%']
                ]
            ) ?>
            <?=$form->field($model, 'city_id',
                [
                    'inputOptions' => ['class' => 'multiple-select input town-select registration-town', 'style' => 'width: 100%']
                ]
            )->dropDownList($cities) ?>
            <?=$form->field($model, 'password',
                [
                    'inputOptions' => ['class' => 'input textarea', 'style' => 'width: 100%', 'type' => 'password']
                ]
            ) ?>
            <button class="button button__registration" type="submit">Cоздать аккаунт</button>
            <?php ActiveForm::end()?>
        </div>
    </section>
</div>
