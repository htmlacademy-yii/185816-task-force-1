<?php


namespace frontend\forms;

use yii\base\Model;

class UsersForm extends Model
{
    public $categories;
    public $additionally;
    public $search;

    public function rules()
    {
        return [
            [['categories', 'additionally', 'search'], 'safe'],
        ];
    }
}
