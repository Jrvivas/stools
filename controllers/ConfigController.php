<?php

namespace app\controllers;

use Yii;
use app\models\Apps;
use app\models\AppController;
use yii\web\Controller;

/**
 * AppsController implements the CRUD actions for Apps model.
 */
class ConfigController extends AppController{
        /**
     * Lists all Apps models.
     * @return mixed
     */
    public function actionIndex($idApp)
    {

        return $this->render('index', ['idApp'=>$idApp
        ]);
    }

}