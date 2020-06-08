<?php

namespace frontend\controllers\cabinet;

use common\models\User;
use frontend\controllers\BaseController;
use frontend\forms\UserSettingsForm;
use Yii;
use yii\web\UploadedFile;

class SettingsController extends BaseController
{
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->id);
        $formModel = UserSettingsForm::create($user);
        $request = Yii::$app->request->post();

        if ($formModel->load($request)) {
            $user->attributes = $formModel->getAttributes();
            $user->avatar = $formModel->upload();

             $user->save();
             Yii::$app->session->setFlash('success', 'Данные успешно обновлены');
             return Yii::$app->response->redirect(['cabinet/settings/']);
        }

        return $this->render('settings', [
            'formModel' => $formModel,
            'user' => $user
        ]);
    }
}
