<?php


namespace frontend\controllers;

use frontend\forms\UsersForm;
use common\models\Category;
use common\models\Comment;
use common\models\User;
use frontend\providers\UsersProvider;
use Yii;
use yii\data\Sort;
use yii\web\NotFoundHttpException;

class UsersController extends BaseController
{

    public function actionIndex()
    {
        $form = new UsersForm();

        $sort = new Sort([
            'attributes' => [
                'rating' => [
                    'asc' => ['u.rating' => SORT_ASC],
                    'desc' => ['u.rating' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Рейтингу',
                ],
                'order' => [
                    'asc' => ['order' => SORT_ASC],
                    'desc' => ['order' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Числу заказов',
                ],
                'popular' => [
                    'asc' => ['popular' => SORT_ASC],
                    'desc' => ['popular' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Популярности',
                ],
            ],
        ]);

        $form->load(Yii::$app->getRequest()->get());

        return $this->render('index', [
            'users' => UsersProvider::getContent($form->attributes, $sort),
            'categories' => Category::find()->select(['category_name'])->indexBy('id')->column(),
            'model' => $form,
            'sort' => $sort
        ]);
    }

    public function actionView($id)
    {
        $user = User::findOne($id);
        if (Comment::find()->where(['executor_id' => $id])->exists()) {
            $comments = Comment::find()->where(['executor_id' => $id])->all();
        } else {
            $comments = null;
        }

        if ($user === null) {
            throw new NotFoundHttpException('Такого пользователя не существует');
        }

        return $this->render('user', [
            'user' => $user,
            'comments' => $comments
        ]);
    }
}
