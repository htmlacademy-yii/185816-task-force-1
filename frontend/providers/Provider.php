<?php

namespace frontend\providers;

use yii\data\ActiveDataProvider;

abstract class Provider
{
    const SIZE_ELEMENT = 10;

    /**
     * Sort default params. ON or OF sorting content
     *
     * @param array $attributes
     * @param $sort
     * @return ActiveDataProvider
     */

    abstract static function getContent(array $attributes, $sort): ActiveDataProvider;
}
