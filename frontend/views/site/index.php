<?php
/**
 * @var array $tasks frontend\model\Task
 */

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$this->title = 'Task-force';
?>
<div style="width: 1098px; margin: auto;">
    <?php if (Yii::$app->session->getFlash('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo Yii::$app->session->getFlash('success') ?></div>
    <?php endif; ?>
    <?php if (Yii::$app->session->getFlash('error')): ?>
        <div class="alert alert-danger" role="alert"><?php echo Yii::$app->session->getFlash('error') ?></div>
    <?php endif; ?>
</div>
<div class="landing-container">
    <div class="landing-top" style="margin-bottom: 50px;">
        <h1>Работа для всех.<br>
            Найди исполнителя на любую задачу.</h1>
        <p>Сломался кран на кухне? Надо отправить документы? Нет времени самому гулять с собакой?
            У нас вы быстро найдёте исполнителя для любой жизненной ситуации?<br>
            Быстро, безопасно и с гарантией. Просто, как раз, два, три. </p>
        <a href="<?= Url::to(['register/index']) ?>" class="button" style="margin-bottom: 40px;">Создать аккаунт</a>
    </div>
    <div class="landing-center">
        <div class="landing-instruction">
            <div class="landing-instruction-step">
                <div class="instruction-circle circle-request"></div>
                <div class="instruction-description">
                    <h3>Публикация заявки</h3>
                    <p>Создайте новую заявку.</p>
                    <p>Опишите в ней все детали
                        и стоимость работы.</p>
                </div>
            </div>
            <div class="landing-instruction-step">
                <div class="instruction-circle  circle-choice"></div>
                <div class="instruction-description">
                    <h3>Выбор исполнителя</h3>
                    <p>Получайте отклики от мастеров.</p>
                    <p>Выберите подходящего<br>
                        вам исполнителя.</p>
                </div>
            </div>
            <div class="landing-instruction-step">
                <div class="instruction-circle  circle-discussion"></div>
                <div class="instruction-description">
                    <h3>Обсуждение деталей</h3>
                    <p>Обсудите все детали работы<br>
                        в нашем внутреннем чате.</p>
                </div>
            </div>
            <div class="landing-instruction-step">
                <div class="instruction-circle circle-payment"></div>
                <div class="instruction-description">
                    <h3>Оплата&nbsp;работы</h3>
                    <p>По завершении работы оплатите
                        услугу и закройте задание</p>
                </div>
            </div>
        </div>
        <div class="landing-notice">
            <div class="landing-notice-card card-executor">
                <h3>Исполнителям</h3>
                <ul class="notice-card-list">
                    <li>
                        Большой выбор заданий
                    </li>
                    <li>
                        Работайте где  удобно
                    </li>
                    <li>
                        Свободный график
                    </li>
                    <li>
                        Удалённая работа
                    </li>
                    <li>
                        Гарантия оплаты
                    </li>
                </ul>
            </div>
            <div class="landing-notice-card card-customer">
                <h3>Заказчикам</h3>
                <ul class="notice-card-list">
                    <li>
                        Исполнители на любую задачу
                    </li>
                    <li>
                        Достоверные отзывы
                    </li>
                    <li>
                        Оплата по факту работы
                    </li>
                    <li>
                        Экономия времени и денег
                    </li>
                    <li>
                        Выгодные цены
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="landing-bottom">
        <div class="landing-bottom-container">
            <h2>Последние задания на сайте</h2>
            <?php foreach ($tasks as $task):?>
            <div class="landing-task">
                <div class="landing-task-top task-courier"></div>
                <div class="landing-task-description">
                    <h3><a href="<?= Url::to(['tasks/view', 'id' => $task->id])?>" class="link-regular"><?=Html::encode(StringHelper::truncate($task->title, 30))?></a></h3>
                    <p><?=Html::encode(StringHelper::truncate($task->description, 30))?></p>
                </div>
                <div class="landing-task-info">
                    <div class="task-info-left">
                        <p><a href="#" class="link-regular"><?=Html::encode($task->category->category_name)?></a></p>
                        <p>25 минут назад</p>
                    </div>
                    <span><?=Html::encode($task->budget)?> <b>₽</b></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="landing-bottom-container">
            <button type="button" class="button red-button">смотреть все задания</button>
        </div>
    </div>
</div>
