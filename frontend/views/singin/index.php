<?php
/**
 * @var \yii\base\Model $model \frontend\forms\SinginForm
 */

use yii\widgets\ActiveForm;

$this->title = 'Вход';
?>

<div class="main-container page-container">
    <section class="registration__user">
        <?php if(Yii::$app->session->getFlash('reg')) {
            echo '<p style="padding: 12px 15px; margin: auto;" class="alert-success">' . Yii::$app->session->getFlash('reg') . ' </p>';
        } ?>
        <h1>Вход</h1>
        <div class="registration-wrapper">
            <?php $form = ActiveForm::begin(['options' => [
                'class'=> 'registration__user-form form-create'
            ]])?>
            <?=$form->field($model, 'email',
                [
                    'inputOptions' => ['class' => 'input textarea', 'placeholder' => 'kumarm@mail.ru', 'style' => 'width: 100%']
                ]
            ) ?>
            <?=$form->field($model, 'password',
                [
                    'inputOptions' => ['class' => 'input textarea', 'style' => 'width: 100%', 'type' => 'password']
                ]
            ) ?>
            <button class="button button__registration" type="submit">Войти</button>
            <?php ActiveForm::end()?>
        </div>
    </section>
</div>
