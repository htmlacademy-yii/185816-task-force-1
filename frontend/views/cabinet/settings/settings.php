<?php

/***
 * @var User $user
 * @var UserSettingsForm $formModel
 */

use common\models\Category;
use common\models\City;
use common\models\NoticeCategory;
use common\models\User;
use frontend\forms\UserSettingsForm;
use frontend\helpers\TemplateCheckbox;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Настройки | ' . $user->full_name;
?>
<div style="width: 1098px; margin: auto;">
    <?php if (Yii::$app->session->getFlash('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo Yii::$app->session->getFlash('success') ?></div>
    <?php endif; ?>
    <?php if (Yii::$app->session->getFlash('role')): ?>
        <div class="alert alert alert-info" role="alert"><?php echo Yii::$app->session->getFlash('role') ?></div>
    <?php endif; ?>
    <?php if (Yii::$app->session->getFlash('error')): ?>
        <div class="alert alert-danger" role="alert"><?php echo Yii::$app->session->getFlash('error') ?></div>
    <?php endif; ?>
</div>
<div class="main-container page-container">
    <section class="account__redaction-wrapper">
        <h1>Редактирование настроек профиля</h1>
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]) ?>
        <div class="account__redaction-section">
            <h3 class="div-line">Настройки аккаунта</h3>
            <div class="account__redaction-section-wrapper">
                <div class="account__redaction-avatar">
                    <img src="<?= Html::encode($user->avatar) ?>" width="156" height="156"
                         alt="<?= Html::encode($user->full_name) ?>" title="<?= Html::encode($user->full_name) ?>">
                    <?= $form->field($formModel,
                        'image', [
                            'inputOptions' => [
                                'id' => 'upload-avatar',
                            ]
                        ]
                    )->fileInput()->label(false) ?>
                    <label for="upload-avatar" class="link-regular">Сменить аватар</label>
                </div>
                <div class="account__redaction">
                    <div class="account__input account__input--name">
                        <?= $form->field($formModel,
                            'full_name', [
                                'inputOptions' => [
                                    'class' => 'input textarea',
                                    'style' => 'display:block; width: 100%',
                                    'disabled' => 'disabled'
                                ]
                            ]
                        ) ?>
                    </div>
                    <div class="account__input account__input--email">
                        <?= $form->field($formModel,
                            'email',
                            [
                                'inputOptions' => [
                                    'class' => 'input textarea',
                                    'style' => 'display:block; width: 100%',
                                ]
                            ]
                        ) ?>
                    </div>
                    <div class="account__input account__input--name">
                        <?= $form->field($formModel, 'city_id',
                            [
                                'inputOptions' => [
                                    'class' => 'multiple-select input multiple-select-big',
                                    'style' => 'display:block; width: 100%',
                                ]])->dropDownList(City::find()->select('name')->indexBy('id')->column()
                        ) ?>
                    </div>
                    <div class="account__input account__input--date">
                        <?= $form->field($formModel,
                            'date_birth', [
                                'inputOptions' => [
                                    'class' => 'input textarea',
                                    'style' => 'display:block; width: 100%',
                                    'type' => 'date'
                                ]
                            ]
                        ) ?>
                    </div>
                    <div class="account__input account__input--info">
                        <?= $form->field($formModel,
                            'about', [
                                'inputOptions' => [
                                    'class' => 'input textarea',
                                    'style' => 'display:block; width: 100%'
                                ]
                            ]
                        )->textarea(['rows' => 7]) ?>
                    </div>
                </div>
            </div>
            <h3 class="div-line">Выберите свои специализации</h3>
            <div class="account__redaction-section-wrapper">
                <div class="search-task__categories account_checkbox--bottom">
                    <?= $form->field($formModel, 'specials',
                        [
                            'options' => ['tag' => false],
                        ])
                        ->checkboxList(
                            Category::find()->select('category_name')->indexBy('id')->column(),
                            [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    return TemplateCheckbox::create($label, $name, $checked, $value);
                                },
                                'tag' => false
                            ]
                        )
                        ->label(false) ?>
                </div>
            </div>
            <h3 class="div-line">Безопасность</h3>
            <div class="account__redaction-section-wrapper account__redaction">
                <div class="account__input">
                    <?= $form->field($formModel,
                        'password_new', [
                            'inputOptions' => [
                                'placeholder' => 'Новый пароль',
                                'class' => 'input textarea',
                                'style' => 'display:block; width: 100%',
                                'type' => 'password'
                            ]
                        ]
                    ) ?>
                </div>
                <div class="account__input">
                    <?= $form->field($formModel,
                        'password_verify', [
                            'inputOptions' => [
                                'placeholder' => 'Повторите пароль',
                                'class' => 'input textarea',
                                'style' => 'display:block; width: 100%',
                                'type' => 'password'
                            ]
                        ]
                    ) ?>
                </div>
            </div>
            <h3 class="div-line">Фото работ</h3>

            <div class="account__redaction-section-wrapper account__redaction">
                <span class="dropzone" style="width: 100%; display: block">
            </div>

            <h3 class="div-line">Контакты</h3>
            <div class="account__redaction-section-wrapper account__redaction">
                <div class="account__input">
                    <?= $form->field(
                        $formModel,
                        'phone',
                        [
                            'inputOptions' => [
                                'class' => 'input-middle input input-date',
                                'style' => 'display: block;',
                                'type' => 'tel'
                            ]
                        ]
                    ) ?>
                </div>
                <div class="account__input">
                    <?= $form->field(
                        $formModel,
                        'skype',
                        [
                            'inputOptions' => [
                                'class' => 'input-middle input input-date',
                                'style' => 'display: block;',
                            ]
                        ]
                    ) ?>
                </div>
                <div class="account__input">
                    <?= $form->field(
                        $formModel,
                        'messenger',
                        [
                            'inputOptions' => [
                                'class' => 'input-middle input input-date',
                                'style' => 'display: block;',
                            ]
                        ]
                    ) ?>
                </div>
            </div>
            <h3 class="div-line">Настройки сайта</h3>
            <h4>Уведомления</h4>
            <div class="account__redaction-section-wrapper account_section--bottom">
                <div class="search-task__categories account_checkbox--bottom">
                    <?= $form->field($formModel, 'settings', ['options' => ['tag' => false]])
                        ->checkboxList(
                            NoticeCategory::find()->select('name')->indexBy('id')->column(), [
                            'item' => function ($index, $label, $name, $checked, $value) {
                                return TemplateCheckbox::create($label, $name, $checked, $value);
                            },
                            'tag' => false
                        ])
                        ->label(false) ?>
                </div>
                <div class="search-task__categories account_checkbox account_checkbox--secrecy">
                    <?= $form->field($formModel, 'hidden', ['template' => "{input}{label}{error}"])
                        ->checkbox(['class' => 'checkbox__input visually-hidden'], false)
                    ?>
                    <?= $form->field($formModel, 'view_only_customer', ['template' => "{input}{label}{error}"])
                        ->checkbox(['class' => 'checkbox__input visually-hidden'], false)
                    ?>
                </div>
            </div>
        </div>
        <button class="button" type="submit">Сохранить изменения</button>
        <?php $form::end() ?>
    </section>
</div>
<script src="/js/dropzone.js"></script>
<script>
    var dropzoneObject = new Dropzone(
        ".dropzone",
        {
            url: window.location.href,
            maxFiles: 6,
            parallelUploads: 6,
            maxFilesize: 2,
            paramName: 'PhotoJobForm[photos]',
            acceptedFiles: 'image/*',
            previewTemplate: '<a href="#"><img data-dz-thumbnail alt="Фото работы"></a>',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
            }
        }
    );
</script>
