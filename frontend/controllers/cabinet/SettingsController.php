<?php

namespace frontend\controllers\cabinet;

use common\models\PhotoJob;
use common\models\User;
use frontend\controllers\BaseController;
use frontend\forms\PhotoJobForm;
use frontend\forms\UserSettingsForm;
use frontend\helpers\SessionNotices;
use frontend\services\UserAdditionService;
use Yii;
use yii\db\Exception;

class SettingsController extends BaseController
{
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->id);
        $formModel = UserSettingsForm::create($user);

        if (Yii::$app->request->isAjax) {
            try {
                $photoJobForm = PhotoJobForm::loadFile();
                PhotoJob::createNewPhotoJob($photoJobForm);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        if ($formModel->load(Yii::$app->request->post())) {
            try {
                UserAdditionService::changeUserSettings($user, $formModel);
                SessionNotices::createSuccessNotice('Данные успешно обновлены');
                return $this->redirect(['cabinet/settings']);
            } catch (\Exception $e) {
                SessionNotices::createErrorNotice($e->getMessage());
                return $this->redirect(['cabinet/settings']);
            }
        }

        return $this->render('settings', [
            'formModel' => $formModel,
            'user' => $user
        ]);
    }
}
