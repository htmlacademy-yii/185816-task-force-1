<?php


namespace frontend\forms;


use frontend\models\Category;
use yii\base\Model;

class UsersFilter extends Model
{
    public $categories;
    public $additionally;
    public $search;

    private function getArrayAttr()
    {
        $categories = Category::find()->asArray()->all();
        $checkboxes = [];

        foreach ($categories as $cat) {
            $checkboxes += [$cat['id'] => $cat['category_name']];
        }

        return $checkboxes;
    }

    public function attributeLabels()
    {
        return $this->getArrayAttr();
    }
}