<?php
/**
 * @var User $user
 */

use common\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="content-view__feedback-card user__search-wrapper">
    <div class="feedback-card__top">
        <div class="user__search-icon">
            <a href="<?= Url::to(['users/view', 'id' => $user->id]) ?>">
                <img src="<?= Html::encode($user->avatar) ?>" width="65" height="65"
                     alt="<?= Html::encode($user->full_name) ?>"
                     title="<?= Html::encode($user->full_name) ?>">
            </a>
            <span><?= Html::encode(count($user->tasks)) ?> заданий</span>
            <span><?= Html::encode(count($user->comments)) ?> отзывов</span>
        </div>
        <div class="feedback-card__top--name user__search-card">
            <p class="link-name">
                <a href="<?= Url::to(['users/view', 'id' => $user->id]) ?>"
                   class="link-regular"><?= Html::encode($user->full_name) ?></a>
            </p>
            <?php for ($i = 0; $i < $user::MAX_RATING; $i++): ?>
                <?php if ($user->rating > $i): ?>
                    <span></span>
                <?php else: ?>
                    <span class="star-disabled"></span>
                <?php endif; ?>
            <?php endfor; ?>
            <b><?= Html::encode($user->rating) ?></b>
            <p class="user__search-content">
                <?= Html::encode($user->about) ?>
            </p>
        </div>
        <span class="new-task__time">Был на сайте 25 минут назад</span>
    </div>
    <div class="link-specialization user__search-link--bottom">
        <?php foreach ($user->categoryExecutors as $cat): ?>
            <a href="<?= Url::to(['users/index', 'UsersForm[categories][]='=> $cat->category->id ]) ?>" class="link-regular"><?= Html::encode($cat->category->category_name) ?></a>
        <?php endforeach; ?>
    </div>
</div>
