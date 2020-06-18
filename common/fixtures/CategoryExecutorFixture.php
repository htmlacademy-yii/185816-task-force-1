<?php


namespace common\fixtures;


use common\models\Category;
use common\models\User;
use yii\test\ActiveFixture;
use common\models\CategoryExecutor;

class CategoryExecutorFixture extends ActiveFixture
{
    public $tableName = 'category_executor';
    public $modelClass = CategoryExecutorFixture::class;
    public $depends = [CategoryFixture::class, UserFixture::class];
}
