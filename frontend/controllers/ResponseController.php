<?php


namespace frontend\controllers;

use frontend\extensions\models\NoticeExtension;
use frontend\forms\NewResponseForm;
use common\models\Response;
use common\models\Task;
use common\models\User;
use yii\helpers\Url;
use Yii;
use yii\base\Action;
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

    /**
     * Add response from current task
     *
     * @param $task_id
     * @return \yii\web\Response
     */

    public function actionNew($task_id): \yii\web\Response
    {
        $task = Task::findOne(['id' => $task_id]);
        $form = new NewResponseForm();
        $request = Yii::$app->request->post();

        if ($form->load($request) && $form->validate()) {
            try {
                Response::createResponse($task, $this->currentUser, $form);
                NoticeExtension::create($task->user_id, NoticeExtension::CATEGORY_RESPONSE, $task_id);
                Yii::$app->session->setFlash('success', 'Вы откликнулись на задание  "' . $task->title . '"');
                return $this->redirect(Url::to(['tasks/view', 'id' => $task->id]));
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(Url::to(['tasks/view', 'id' => $task->id]));
            }
        } else {
            return $this->redirect(Url::to(['tasks/view', 'id' => $task->id]));
        }
    }


    /**
     * Canceled response
     *
     * @return \yii\web\Response
     */

    public function actionCancel(): \yii\web\Response
    {
        try {
            Response::blockedResponse($this->response ,$this->currentUser);
            Yii::$app->session->setFlash('success', 'Вы отказали  ' . $this->response->user->full_name . '  в выполнении задания');
            return $this->redirect(Url::to(['tasks/view', 'id' => $this->response->task->id]));

        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(Url::to(['tasks/view', 'id' => $this->response->task->id]));
        }
    }
}
