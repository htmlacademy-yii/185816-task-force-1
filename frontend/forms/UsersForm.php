<?php


namespace frontend\forms;


use common\models\Category;
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
