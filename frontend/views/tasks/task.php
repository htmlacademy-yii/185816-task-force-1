<?php
/**
 * @var Task $task
 * @var User $user
 **/

use common\models\User;
use frontend\forms\CompleteTaskForm;
use frontend\forms\NewResponseForm;
use common\models\Response;
use common\models\Task;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$user = Yii::$app->user->identity;
$form_response_model = new NewResponseForm();
$form_complete_model = new CompleteTaskForm();
$this->title = $task->title;
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
    <section class="content-view">
        <div class="content-view__card">
            <div class="content-view__card-wrapper">
                <div class="content-view__header">
                    <div class="content-view__headline">
                        <h1><?= Html::encode($task->title) ?></h1>
                        <span>Размещено в категории
                            <a href="#" class="link-regular"><?= Html::encode($task->category->category_name) ?></a>
                            <?php echo \frontend\helpers\Date::getTimeHasPassed($task->created_at) ?>
                        </span>
                    </div>
                    <b class="new-task__price new-task__price--clean content-view-price"><?= Html::encode(
                            $task->budget
                        ) ?><b> ₽</b></b>
                    <div class="new-task__icon new-task__icon--clean content-view-icon"></div>
                </div>
                <div class="content-view__description">
                    <h3 class="content-view__h3">Общее описание</h3>
                    <p>
                        <?= Html::encode($task->description) ?>
                    </p>
                </div>
                <?php if (isset($task->file)) : ?>
                    <div class="content-view__attach">
                        <h3 class="content-view__h3">Вложения</h3>
                        <a href="<?= Url::to(['/' . $task->file]) ?>"><?= $task->file ?></a>
                    </div>
                <?php endif; ?>
                <div class="content-view__location">
                    <h3 class="content-view__h3">Расположение</h3>
                    <div class="content-view__location-wrapper">
                        <div class="content-view__map" id="map" style="width: 361px; height: 292px;"
                             data-one="<?= $task->getLocation()[0] ?>" data-two="<?= $task->getLocation()[1] ?>">
                        </div>
                        <div class="content-view__address" id="address">
                            <span><?= $task->address ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($user->isExecutor()): ?>
                <div class="content-view__action-buttons">
                    <?php if ($task->isDefaultStatus() && !$user->isRespondedByTask($task->id)): ?>
                        <button class=" button button__big-color response-button open-modal"
                                type="button" data-for="response-form">Откликнуться
                        </button>
                    <?php elseif ($task->isWorkStatus()) : ?>
                        <button class="button button__big-color refusal-button open-modal"
                                type="button" data-for="refuse-form">Отказаться
                        </button>
                    <?php endif; ?>
                </div>
            <?php elseif ($user->isCustomer() && $task->isWorkStatus()): ?>
                <div class="content-view__action-buttons">
                    <button class="button button__big-color request-button open-modal"
                            type="button" data-for="complete-form">Завершить
                    </button>
                </div>
            <?php elseif ($task->isNewStatus() && $task->isUserOwner($user)) : ?>
                <div class="content-view__action-buttons">
                    <a href="<?= Url::to(['task/cancel/', 'id' => $task->id]) ?>"
                       class="button button__big-color request-button open-modal"
                       type="button">Отменить задание
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($task->isDefaultStatus()): ?>
            <?php if (!$user->isExecutor() && $user->getId() === $task->getUserId()): ?>
                <div class="content-view__feedback">
                    <h2>Отклики <span><?= count($task->responses) ?></span></h2>
                    <div class="content-view__feedback-wrapper">
                        <?php foreach ($task->responses as $response) : ?>
                            <div class="content-view__feedback-card">
                                <div class="feedback-card__top">
                                    <a href="<?= Url::to(['users/view', 'id' => $response->user->id]) ?>">
                                        <img src="/img/man-glasses.jpg" width="55" height="55"></a>
                                    <div class="feedback-card__top--name">
                                        <p><a href="<?= Url::to(['users/view', 'id' => $response->user->id]) ?>"
                                              class="link-regular"><?= Html::encode(
                                                    $response->user->full_name
                                                ) ?></a></p>
                                        <?php for ($i = 0; $i < $user::MAX_RATING; $i++): ?>
                                            <?php if ($response->user->rating > $i): ?>
                                                <span></span>
                                            <?php else: ?>
                                                <span class="star-disabled"></span>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <b><?= Html::encode($response->user->rating) ?></b>
                                    </div>
                                    <span class="new-task__time">25 минут назад</span>
                                </div>
                                <div class="feedback-card__content">
                                    <p>
                                        <?= Html::encode($response->message) ?>
                                    </p>
                                    <span><?= Html::encode($response->amount) ?> ₽</span>
                                </div>
                                <?php if ($response->isActive()) : ?>
                                    <div class="feedback-card__actions">
                                        <a href="<?= Url::to(
                                            ['task/work', 'id' => $task->id, 'executor' => $response->user->id]
                                        ) ?>"
                                           class="button__small-color request-button button"
                                           type="button">Подтвердить</a>
                                        <a href="<?= Url::to(['response/cancel', 'id' => $response->id]) ?>"
                                           class="button__small-color refusal-button button"
                                           type="button">Отказать</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="content-view__feedback">
                    <h2>Отклики <span><?= count($task->responses) ?></span></h2>
                    <div class="content-view__feedback-wrapper">
                        <?php foreach ($task->responses as $response) : ?>
                            <div class="content-view__feedback-card">
                                <div class="feedback-card__top">
                                    <a href="<?= Url::to(['users/view', 'id' => $response->user->id]) ?>">
                                        <img src="/img/man-glasses.jpg"
                                             width="55" height="55"></a>
                                    <div class="feedback-card__top--name">
                                        <p><a href="<?= Url::to(['users/view', 'id' => $response->user->id]) ?>"
                                              class="link-regular"><?= Html::encode(
                                                    $response->user->full_name
                                                ) ?></a></p>
                                        <?php for ($i = 0; $i < $user::MAX_RATING; $i++): ?>
                                            <?php if ($response->user->rating > $i): ?>
                                                <span></span>
                                            <?php else: ?>
                                                <span class="star-disabled"></span>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <b><?= Html::encode($response->user->rating) ?></b>
                                    </div>
                                    <span class="new-task__time">25 минут назад</span>
                                </div>
                                <div class="feedback-card__content">
                                    <p>
                                        <?= Html::encode($response->message) ?>
                                    </p>
                                    <span><?= Html::encode($response->amount) ?> ₽</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </section>
    <section class="connect-desk">
        <div class="connect-desk__profile-mini">
            <div class="profile-mini__wrapper">
                <h3>Заказчик</h3>
                <div class="profile-mini__top">
                    <img src="../../../img/man-brune.jpg" width="62" height="62"
                         alt="<?= Html::encode($task->user->full_name) ?>">
                    <div class="profile-mini__name five-stars__rate">
                        <p><?= Html::encode($task->user->full_name) ?></p>
                    </div>
                </div>
                <p class="info-customer">
                    <span><?= Html::encode(count($task->user->tasks)) ?> заданий</span>
                    <span class="last-">на сайте c <?= Html::encode(date('Y', strtotime($task->user->created_at))) ?> года</span>
                </p>
                <a href="<?= Url::to(['users/view', 'id' => $task->user->id]) ?>" class="link-regular">Смотреть
                    профиль</a>
            </div>
        </div>
        <?php if ($user->getId() === $task->getUserId() || $user->getId() === $task->getExecutorId()): ?>
            <?php if ($task->isWorkStatus()) : ?>
                <div id="chat-container">
                    <!--                    добавьте сюда атрибут task с указанием в нем id текущего задания-->
                    <chat class="connect-desk__chat" task="<?= $task->id ?>" sender="<?= Yii::$app->user->id ?>"
                          recipient="<?= $task->user->id ?>"></chat>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </section>
</div>
<section class="modal response-form form-modal" id="response-form">
    <h2>Отклик на задание</h2>
    <?php $form_response = ActiveForm::begin(
        ['action' => \yii\helpers\Url::toRoute(['/response/new/', 'task_id' => $task->id])]
    ) ?>
    <p>
        <?= $form_response->field($form_response_model, 'amount')->textInput(
            ['class' => 'response-form-payment input input-middle input-money']
        )->label(null, ['class' => 'form-modal-description', 'style' => 'display: block']) ?>
    </p>
    <p>
        <?= $form_response->field($form_response_model, 'message')->textarea(
            [
                'class' => 'input textarea',
                'style' => 'display: block; width: 100%',
                'rows' => 4,
                'placeholder' => 'Place you text'
            ]
        )->label(null, ['class' => 'form-modal-description', 'style' => 'display: block']) ?>
    </p>
    <?php echo Html::submitInput('Отправить', ['class' => 'button modal-button']) ?>
    <?php $form_response::end() ?>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
<section class="modal completion-form form-modal" id="complete-form">
    <h2>Завершение задания</h2>
    <p class="form-modal-description">Задание выполнено?</p>
    <?php $form_complete = ActiveForm::begin([
        'action' => Url::to(['task/complete', 'id' => $task->id])
    ]) ?>
    <input class="visually-hidden completion-input completion-input--yes" type="radio" id="completion-radio--yes"
           name="complete" value="1">
    <label class="completion-label completion-label--yes" for="completion-radio--yes">Да</label>
    <input class="visually-hidden completion-input completion-input--difficult" type="radio" id="completion-radio--yet"
           name="complete" value="0">
    <label class="completion-label completion-label--difficult" for="completion-radio--yet">Возникли проблемы</label>
    <?= $form_complete->field($form_complete_model, 'description')
        ->textarea([
            'class' => 'input textarea',
            'style' => 'display: block; width: 100%',
            'placeholder' => 'Place you text',
            'rows' => 4
        ])
        ->label(null, [
            'class' => 'form-modal-description',
            'style' => 'display: block; width: 100%',
        ]) ?>
    <p class="form-modal-description">
        <?= $form_complete->field($form_complete_model, 'rating')->input('hidden', ['id' => 'rating']) ?>
    <div class="feedback-card__top--name completion-form-star">
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
    </div>
    </p>
    <?php echo Html::submitInput('Отправить', ['class' => 'button modal-button']) ?>
    <?php $form_complete::end() ?>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
<section class="modal form-modal refusal-form" id="refuse-form">
    <h2>Отказ от задания</h2>
    <p>
        Вы собираетесь отказаться от выполнения задания.
        Это действие приведёт к снижению вашего рейтинга.
        Вы уверены?
    </p>
    <button class="button__form-modal button" id="close-modal"
            type="button">Отмена
    </button>
    <a href="<?= \yii\helpers\Url::toRoute(['/task/refuse/', 'id' => $task->id]) ?>"
       class="button__form-modal refusal-button button"
       type="button">Отказаться</a>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
