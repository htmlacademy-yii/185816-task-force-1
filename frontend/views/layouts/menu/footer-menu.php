<?php

use yii\widgets\Menu;

?>

<div class="page-footer__links">
    <?php echo Menu::widget([
        'options' => ['class' => 'links__list'],
        'itemOptions' => [
            'class' => 'links__item'
        ],
        'items' => [
            ['label' => 'Задания', 'url' => ['tasks/index']],
            ['label' => 'Мой профиль', 'url' => ['cabinet/settings']],
            ['label' => 'Исполнители', 'url' => ['users/index']],
            ['label' => 'Регистрация', 'url' => ['register/index']],
            ['label' => 'Создать задание', 'url' => ['task/create']],
            ['label' => 'Справка', 'url' => ['help/index']]
        ],
    ]);
    ?>
</div>

