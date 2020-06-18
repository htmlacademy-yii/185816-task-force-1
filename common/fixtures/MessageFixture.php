<?php
namespace common\fixtures;

use common\models\Message;
use common\models\UserStatus;
use yii\test\ActiveFixture;

class MessageFixture extends ActiveFixture
{
    public $modelClass = Message::class;
    public $depends = [UserStatusFixture::class, TaskFixture::class];
}
