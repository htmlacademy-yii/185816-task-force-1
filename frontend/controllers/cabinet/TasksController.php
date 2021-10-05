<?php

namespace frontend\controllers\cabinet;

use frontend\controllers\BaseController;
use frontend\helpers\Date;
use common\models\Task;
use common\models\User;
use frontend\providers\MyTasksProvider;
use Yii;

class TasksController extends BaseController
{

    /**
     * @var User $currentUser
     */
    protected $currentUser;

    public function beforeAction($action)
    {
        $this->currentUser = Yii::$app->user->identity;
        return parent::beforeAction($action);
    }

    public function actionNew()
    {

        $tasks = MyTasksProvider::getContent([
            'user_id' => $this->currentUser->id,
            'status_id' => Task::STATUS_DEFAULT
        ]);

        return $this->render('index', [
            'tasks' => $tasks->getModels()
        ]);
    }

    public function actionComplete()
    {
        $tasks = MyTasksProvider::getCommonContent([
            'status_id' => Task::STATUS_COMPLETE
        ], $this->currentUser);

        return $this->render('index', [
            'tasks' => $tasks->getModels()
        ]);
    }

    public function actionCancel()
    {
        $tasks = MyTasksProvider::getCommonContent([
            'status_id' => Task::STATUS_CANCELED
        ], $this->currentUser, true);

        return $this->render('index', [
            'tasks' => $tasks->getModels()
        ]);
    }

    public function actionActive()
    {
        $tasks = MyTasksProvider::getCommonContent([
            'status_id' => Task::STATUS_WORK
        ], $this->currentUser);

        return $this->render('index', [
            'tasks' => $tasks->getModels()
        ]);
    }

    public function actionOverdue()
    {
        $tasks = MyTasksProvider::getCommonContent([
            'user_id' => $this->currentUser->id,
            'status_id' => Task::STATUS_WORK
        ], $this->currentUser, false, Date::getDateNow());

        return $this->render('index', [
            'tasks' => $tasks->getModels()
        ]);
    }
}
