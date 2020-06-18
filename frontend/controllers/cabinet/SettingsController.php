<?php

namespace frontend\controllers\cabinet;

use common\models\PhotoJob;
use common\models\User;
use frontend\controllers\BaseController;
use frontend\forms\PhotoJobForm;
use frontend\forms\UserSettingsForm;
use frontend\services\UserAdditionService;
use Yii;
use yii\db\Exception;

class SettingsController extends BaseController
{
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->id);
        $formModel = UserSettingsForm::create($user);
        $request = Yii::$app->request->post();
        $photoJobForm = new PhotoJobForm();

        if (Yii::$app->request->isAjax) {
            try {
                $photoJobForm->img = $photoJobForm->upload($photoJobForm, 'photos');
                PhotoJob::createNewPhotoJob($photoJobForm);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        if ($formModel->load($request)) {
            $formModel->avatar = $formModel->upload($formModel, 'image', $formModel->avatar);
            $newUser = new UserAdditionService($user, $formModel);
            $newUser->update();

            Yii::$app->session->setFlash('success', 'Данные успешно обновлены');
            return Yii::$app->response->redirect(['cabinet/settings']);

        }

        return $this->render('settings', [
            'formModel' => $formModel,
            'user' => $user
        ]);
    }
}
