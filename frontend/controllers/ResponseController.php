<?php


namespace frontend\controllers;

use frontend\forms\NewResponseForm;
use common\models\Response;
use common\models\Task;
use common\models\User;
use yii\helpers\Url;
use Yii;
use yii\base\Action;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ResponseController extends BaseController
{

    /**
     * @var Response $response
     */
    protected $response;

    /**
     * @var User $currentUser
     */
    protected $currentUser;

    /**
     * @param Action $action
     * @return bool
     * @throws NotFoundHttpException
     */

    public function beforeAction($action)
    {
        if (Yii::$app->request->get('id') && Yii::$app->request->get('id') !== null) {
            $this->response = Response::findOrFail(['id' => Yii::$app->request->get('id')]);
        }

        $this->currentUser = Yii::$app->user->identity;

        return parent::beforeAction($action);
    }

    public function actionNew($task_id)
    {
        $task = Task::findOne(['id' => $task_id]);
        $form = new NewResponseForm();
        $request = Yii::$app->request->post();

        if ($form->load($request) && $form->validate()) {
            try {
                Response::createResponse($task, $this->currentUser, $form);
                Yii::$app->session->setFlash('success', 'Вы откликнулись на задание  "' . $task->title . '"');
                $this->redirect(Url::to(['tasks/view', 'id' => $task->id]));
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
                $this->redirect(Url::to(['tasks/view', 'id' => $task->id]));
            }
        } else {
            $this->redirect(Url::to(['tasks/view', 'id' => $task->id]));
        }
    }

    public function actionCancel()
    {
        try {
            Response::blockedResponse($this->response ,$this->currentUser);
            Yii::$app->session->setFlash('success', 'Вы отказали  ' . $this->response->user->full_name . '  в выполнении задания');
            $this->redirect(Url::to(['tasks/view', 'id' => $this->response->task->id]));

        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            $this->redirect(Url::to(['tasks/view', 'id' => $this->response->task->id]));
        }
    }
}
