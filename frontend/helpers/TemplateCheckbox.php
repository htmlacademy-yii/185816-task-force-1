<?php

namespace frontend\helpers;

use yii\helpers\Html;

class TemplateCheckbox
{
    /**
     * @param $label
     * @param $name
     * @param $checked
     * @param $value
     * @return string
     */
    public static function create($label, $name, $checked, $value)
    {
        $identity = uniqid();
        return Html::checkbox($name, $checked, ['id' => $identity, 'class' => 'checkbox__input visually-hidden', 'value' => $value]) . ' ' . Html::label($label, $identity);
    }
}
