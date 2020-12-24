<?php

namespace app\controllers;

use Yii;
use app\models\Categoria;
use app\models\CategoriaSearch;
use app\models\AppController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriaController implements the CRUD actions for Categoria model.
 */
class CategoriaController extends  AppController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    { 
       //--------Verifica la Aplicacion----
             $this->verifApp();
       //-------------------------

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
     * Lists all Categoria models.
     * @return mixed
     */
    public function actionIndex($idApp)
    {
 
            $searchModel = new CategoriaSearch();
            $searchModel->app_idApp=$idApp;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'idApp'=>$idApp,
            ]);
        
       

    }

    /**
     * Displays a single Categoria model.
     * @param string $codigo
     * @param string $app_idApp
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($codigo, $app_idApp)
    {
        return $this->render('view', [
            'model' => $this->findModel($codigo, $app_idApp),
        ]);
    }



    /**
     * Creates a new Categoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idApp)
    {
            $model = new Categoria();
            $model->app_idApp=$idApp;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index', 'idApp' => $model->app_idApp]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
      
    }

    /**
     * Updates an existing Categoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $codigo
     * @param string $app_idApp
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($codigo, $app_idApp)
    {
               $model = $this->findModel($codigo, $app_idApp);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
               // return $this->redirect(['view', 'codigo' => $model->codigo, 'app_idApp' => $model->app_idApp]);
                return $this->redirect(['index', 'idApp' => $model->app_idApp]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        
      
    }

    /**
     * Deletes an existing Categoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $codigo
     * @param string $app_idApp
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($codigo, $app_idApp)
    {
       
        $this->findModel($codigo, $app_idApp)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Categoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $codigo
     * @param string $app_idApp
     * @return Categoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($codigo, $app_idApp)
    {
        if (($model = Categoria::findOne(['codigo' => $codigo, 'app_idApp' => $app_idApp])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

//----------AJAX---------------

public function actionListaAjax($idApp){
    
    if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $categorias=Categoria::find()->where(['app_idApp'=>$idApp])->all();
        
        if ($categorias ) {
            $data=array();
            foreach($categorias as $row)
            {

                $data[]=['codigo'=>$row->codigo,
                        'nombre'=>$row->nombre,
                        'descripcion'=>$row->descripcion,
                        'url-icono'=>$row->urlIcono
                        ];
            }
            return [
                    'error'=>0,
                    'data'=>$data,
                    'message' => 'ok',
                     ];

            
        }
    } 
    return [
                'error'=>1,
                'data'=>'',
                'message' => 'no hay datos',
            ];

}
    

}
