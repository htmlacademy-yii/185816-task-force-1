<?php

namespace frontend\providers;

use yii\data\ActiveDataProvider;
use yii\data\Sort;

abstract class Provider
{
    const SIZE_ELEMENT = 10;

    abstract static function getContent(array $attributes, $sort = false): ActiveDataProvider;
}
