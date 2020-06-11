<?php


namespace frontend\providers;


use common\models\CategoryExecutor;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class UsersProvider extends Provider
{

    /***
     * @param array $attributes frontend\Forms\UserForm
     * @param bool|Sort $sort
     * @return ActiveDataProvider
     */

    public static function getContent(array $attributes = [], $sort = false): ActiveDataProvider
    {
        $query = CategoryExecutor::find()
            ->alias('ce')
            ->select('user_id')
            ->innerJoinWith('user u')
            ->groupBy('ce.user_id')
        ;

        if (!empty($attributes['categories'])) {
            $query->andwhere([
                'category_id' => $attributes['categories'],
            ]);
        }

        if (!empty($attributes['search'])) {
            $query->andwhere([
                'like', 'u.full_name', $attributes['search']
            ]);
        }

        if ($sort) {
            $query->orderBy($sort->orders);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::SIZE_ELEMENT
            ]
        ]);
    }
}
