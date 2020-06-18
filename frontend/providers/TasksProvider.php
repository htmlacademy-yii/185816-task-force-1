<?php

namespace frontend\providers;

use common\models\Task;
use yii\data\ActiveDataProvider;

class TasksProvider extends Provider
{
    protected static function getDate($period)
    {
        $now = strtotime('now');
        $diff = $now - $period;

        return date('Y-m-d H:i:s', $diff);
    }

    /***
     * @param array $attributes
     * @param bool $sort
     * @return ActiveDataProvider
     */

    public static function getContent(array $attributes, $sort = false): ActiveDataProvider
    {
        $query = Task::find()->where(['status_id' => Task::STATUS_DEFAULT])->with(['city', 'category']);

        if (!empty($attributes['categories'])) {
            $query->andWhere([
                'category_id' => $attributes['categories'],
            ]);
        }

        if (!empty($attributes['period'])) {
            $query->andWhere([
                '>=', 'created_at', self::getDate($attributes['period'])
            ]);
        }

        if (!empty($attributes['search'])) {
            $query->andWhere([
                'like', 'title', $attributes['search']
            ]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::SIZE_ELEMENT
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);
    }
}
