<?php

namespace app\controllers;

use Yii;
use app\models\Cuenta;
use app\models\Apps;
use app\models\CuentaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CuentaController implements the CRUD actions for Cuenta model.
 */
class CuentaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Cuenta models.
     * @return mixed
     */
    public function actionIndex($idApp)
    {
        if($this->setLayoutApp($idApp)){

            $searchModel = new CuentaSearch();
            $searchModel->app_idApp=$idApp;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'idApp'=>$idApp,
            ]);
        }

        return $this->redirect(['/apps/index', 
            'error' => 'No hay una app seleccionada',
            'idApp'=> $idApp ]);

      
    }

    /**
     * Displays a single Cuenta model.
     * @param string $app_idApp
     * @param integer $contacto_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($app_idApp, $contacto_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($app_idApp, $contacto_id),
        ]);
    }



    /**
     * Creates a new Cuenta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idApp)
    {
        if($this->setLayoutApp($idApp)){
            $model = new Cuenta();
            $model->app_idApp=$idApp;

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
               // return $this->redirect(['view', 'app_idApp' => $model->app_idApp, 'contacto_id' => $model->contacto_id]);
                return $this->redirect(['index', 'idApp' => $model->app_idApp]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
        return $this->redirect(['/apps/index', 
        'error' => 'No hay una app seleccionada',
        'idApp'=> $idApp ]);
    }


    /**
     * Updates an existing Cuenta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $app_idApp
     * @param integer $contacto_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($app_idApp, $contacto_id)
    {
        $model = $this->findModel($app_idApp, $contacto_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'app_idApp' => $model->app_idApp, 'contacto_id' => $model->contacto_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cuenta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $app_idApp
     * @param integer $contacto_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($app_idApp, $contacto_id)
    {
        $this->findModel($app_idApp, $contacto_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cuenta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $app_idApp
     * @param integer $contacto_id
     * @return Cuenta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($app_idApp, $contacto_id)
    {
        if (($model = Cuenta::findOne(['app_idApp' => $app_idApp, 'contacto_id' => $contacto_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


//-----------------------------------------------------------------
    /**
     * Obtiena la aplicacion y le asigna un layout segun su tipo
     */
    protected function setLayoutApp($idApp){
        //Identificar el tipo de app
        $app=$this->findApp($idApp);
        if($app){
            Yii::$app->variables=['idApp'=>$idApp];
            Yii::$app->name=Apps::findOne($idApp)->nombre;

            switch ($app->codigoApp){
                case Apps::APP_COMMERCE_GRAFICA:
                    $this->layout = 'layout_grafica';
                break;
                case Apps::APP_COMMERCE_DITRIBUIDORA;
                    $this->layout='layout_distribuidora';
                break;

            }
            return true;
        }else{
            return false;
        }    

    }


    protected function findApp($app_idApp){
        return Apps::findOne(['idApp'=>$app_idApp]);
    }
}
