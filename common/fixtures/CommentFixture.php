<?php
namespace common\fixtures;

use common\models\Comment;
use common\models\Task;
use yii\test\ActiveFixture;

class CommentFixture extends ActiveFixture
{
    public $modelClass = Comment::class;
    public $depends = [UserStatusFixture::class, TaskFixture::class];
}
