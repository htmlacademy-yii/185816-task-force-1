<?php
namespace common\fixtures;

use common\models\Category;
use common\models\Task;
use yii\test\ActiveFixture;

class TaskFixture extends ActiveFixture
{
    public $modelClass = Task::class;
    public $depends = [CategoryFixture::class, UserFixture::class, CityFixture::class];
}
