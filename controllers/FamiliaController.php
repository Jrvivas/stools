<?php

namespace app\controllers;

use Yii;
use app\models\Familia;
use app\models\FamiliaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FamiliaController implements the CRUD actions for Familia model.
 */
class FamiliaController extends Controller
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
     * Lists all Familia models.
     * @return mixed
     */
    public function actionIndex($idApp)
    {
        if($this->setLayoutApp($idApp)){

            $searchModel = new FamiliaSearch();
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
        //<<< programar Index

    }

    /**
     * Displays a single Familia model.
     * @param integer $id
     * @param string $app_idApp
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $app_idApp)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $app_idApp),
        ]);
    }

    /**
     * Creates a new Familia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Familia();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'app_idApp' => $model->app_idApp]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Familia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param string $app_idApp
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $app_idApp)
    {
        $model = $this->findModel($id, $app_idApp);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'app_idApp' => $model->app_idApp]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Familia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param string $app_idApp
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $app_idApp)
    {
        $this->findModel($id, $app_idApp)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Familia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $app_idApp
     * @return Familia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $app_idApp)
    {
        if (($model = Familia::findOne(['id' => $id, 'app_idApp' => $app_idApp])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
