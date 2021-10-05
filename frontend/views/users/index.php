<?php

/**
 * @var common\models\Category $categories
 * @var UsersProvider $users
 * @var User $user
 * @var Category $categories
 * @var Sort $sort
 * @var DataProvider $users
 * @var UsersForm $usersSearchForm
 **/

use common\models\Category;
use common\models\User;
use frontend\forms\UsersForm;
use frontend\providers\UsersProvider;
use yii\data\Sort;
use yii\debug\models\timeline\DataProvider;

$this->title = 'Пользователи';
?>

<div class="main-container page-container">
    <section class="user__search">
        <div class="user__search-link">
            <p>Сортировать по:</p>
            <ul class="user__search-list">
                <li class="user__search-item user__search-item--current">
                    <?php echo $sort->link('rating') ?>
                </li>
                <li class="user__search-item">
                    <?php echo $sort->link('order') ?>
                </li>
                <li class="user__search-item">
                    <?php echo $sort->link('popular') ?>
                </li>
            </ul>
        </div>
        <?php foreach ($users->getModels() as $user) : ?>
            <?php $user = $user->user ?>
           <!--User card-->
            <?= $this->renderFile(__DIR__ . '/components/user-card.php', [
                'user' => $user
            ]) ?>
        <?php endforeach; ?>
        <?= yii\widgets\ListView::widget([
            'dataProvider' => $users,
            'layout' => "{pager}"
        ]); ?>
    </section>
    <section class="search-task">
        <div class="search-task__wrapper">
            <!--Aside section-->
            <?= $this->renderFile(__DIR__ . '/components/asideFilter.php', [
                'usersSearchForm' => $usersSearchForm,
                'categories' => $categories
            ]) ?>
        </div>
    </section>
</div>
