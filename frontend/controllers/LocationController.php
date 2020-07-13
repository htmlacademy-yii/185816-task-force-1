<?php

namespace frontend\controllers;

use frontend\services\LocationService;
use Yii;

class LocationController extends BaseController
{
    protected $address;

    public function beforeAction($action)
    {
        $this->address = Yii::$app->request->get('address');
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
       $data = new LocationService();
        try {
            return $data->getResponse($this->address);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function actionCoords()
    {
        $data = new LocationService();
        try {
            return $data->getCoords($this->address);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
