<?php
namespace common\fixtures;

use common\models\Response;
use yii\test\ActiveFixture;

class ResponseFixture extends ActiveFixture
{
    public $modelClass = Response::class;
    public $depends = [UserStatusFixture::class, TaskFixture::class];
}
