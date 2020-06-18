<?php

/**
 * @var \common\models\User $user
 **/

use yii\helpers\Html;


$this->title = $user->full_name;
?>
<div class="main-container page-container">
    <section class="content-view">
        <div class="user__card-wrapper">
            <div class="user__card">
                <img src="../../../img/man-hat.png" width="120" height="120" alt="Аватар пользователя">
                <div class="content-view__headline">
                    <h1><?=Html::encode($user->full_name)?></h1>
                    <p><?=Html::encode($user->city->name)?></p>
                    <div class="profile-mini__name five-stars__rate">
                        <?php for ($i = 0; $i < $user::MAX_RATING; $i++): ?>
                            <?php if ($user->rating > $i): ?>
                                <span></span>
                            <?php else: ?>
                                <span class="star-disabled"></span>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <b><?=Html::encode(Yii::$app->formatter->asDecimal($user->rating, ['max' => 1]))?></b>
                    </div>
                    <?php if ($user->tasks) :?>
                        <b class="done-task">Выполнил <?=count($user->tasks)?> заказов</b>
                    <?php else: ?>
                        <b class="done-task">Пока не выполнял заказов</b>
                    <?php endif ?>
                    <?php if ($comments) :?>
                        <b class="done-review">Получил <?=count($comments)?> отзывов</b>
                    <?php else: ?>
                        <b class="done-review">Отзывов пока нет</b>
                    <?php endif ?>
                </div>
                <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                    <span>Был на сайте 25 минут назад</span>
                    <a href="#"><b></b></a>
                </div>
            </div>
            <div class="content-view__description">
                <p><?= Html::encode($user->about) ?></p>
            </div>
            <div class="user__card-general-information">
                <div class="user__card-info">
                    <h3 class="content-view__h3">Специализации</h3>
                    <div class="link-specialization">
                        <?php foreach ($user->categoryExecutors as $cat): ?>
                            <a href="#" class="link-regular"><?= Html::encode($cat->category->category_name) ?></a>
                        <?php endforeach; ?>
                    </div>
                    <h3 class="content-view__h3">Контакты</h3>
                    <div class="user__card-link">
                        <a class="user__card-link--tel link-regular" href="tel:<?= Html::encode($user->phone) ?>"><?= Html::encode($user->phone) ?></a>
                        <a class="user__card-link--email link-regular" href="mailto:<?= Html::encode($user->email) ?>"><?= Html::encode($user->email) ?></a>
                        <a class="user__card-link--skype link-regular" href="skype:<?= Html::encode($user->skype) ?>"><?= Html::encode($user->skype) ?></a>
                    </div>
                </div>
                <div class="user__card-photo">
                    <h3 class="content-view__h3">Фото работ</h3>
                    <a href="#"><img src="../../../img/rome-photo.jpg" width="85" height="86" alt="Фото работы"></a>
                    <a href="#"><img src="../../../img/smartphone-photo.png" width="85" height="86" alt="Фото работы"></a>
                    <a href="#"><img src="../../../img/dotonbori-photo.png" width="85" height="86" alt="Фото работы"></a>
                </div>
            </div>
        </div>
        <div class="content-view__feedback">
            <?php if($comments === null) :?>
                <h2>Отзывов пока нет</h2>
            <?php else:?>
                <h2>Отзывы<span>(<?=Html::encode(count($comments))?>)</span></h2>
            <?php endif;?>
            <?php if($comments): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="content-view__feedback-wrapper reviews-wrapper">
                        <div class="feedback-card__reviews">
                            <p class="link-task link">Задание <a href="#" class="link-regular"><?=Html::encode($comment->task->title)?></a></p>
                            <div class="card__review">
                                <a href="/users/view/<?=Html::encode($comment->user_id)?>">
                                    <img src="../../../img/man-glasses.jpg" width="55" height="54">
                                </a>
                                <div class="feedback-card__reviews-content">
                                    <p class="link-name link"><a href="/users/view/<?=Html::encode($comment->user_id)?>" class="link-regular"><?=Html::encode($comment->user->full_name)?></a></p>
                                    <p class="review-text">
                                        <?=Html::encode($comment->description)?>
                                    </p>
                                </div>
                                <div class="card__review-rate">
                                    <p class="five-rate big-rate"><?=Html::encode($comment->rating)?><span></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endif?>
        </div>
    </section>
    <section class="connect-desk">
        <div class="connect-desk__chat">

        </div>
    </section>
</div>
