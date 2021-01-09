<?php

namespace app\controllers;

use Yii;
use app\models\Productos;
use app\models\ProductosSearch;
use app\models\AppController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductosController implements the CRUD actions for Productos model.
 */
class ProductosController extends AppController
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
     * Lists all Productos models.
     * @return mixed
     */
    public function actionIndex($idApp)
    {
   
        $searchModel = new ProductosSearch();
        $searchModel->app_idApp=$idApp;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idApp'=>$idApp
        ]);
    }

    


    /**
     * Displays a single Productos model.
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
     * Creates a new Productos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idApp)
    {
       
        $model = new Productos();
        $model->app_idApp=$idApp;

        if ($model->load(Yii::$app->request->post())){
            $model->id=$model->maxId($idApp)+1;
            if($model->save()){
                 return $this->redirect(['index', 'idApp'  => $model->app_idApp]);
            } 
                              
        }

        return $this->render('create', [
            'model' => $model,
            'idApp'=>$idApp
        ]);
    }

    /**
     * Updates an existing Productos model.
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
            //return $this->redirect(['view', 'id' => $model->id, 'app_idApp' => $model->app_idApp]);
            return $this->redirect(['index', 'idApp'  => $model->app_idApp]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Productos model.
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

    //----------------EXTRAS--------------------------
    public function actionStock($idApp){
        $searchModel = new ProductosSearch();
        $searchModel->app_idApp=$idApp;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('stock', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idApp'=>$idApp
        ]);

    }
    //------------------------------------------------

    /**
     * Finds the Productos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $app_idApp
     * @return Productos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $app_idApp)
    {
        if (($model = Productos::findOne(['id' => $id, 'app_idApp' => $app_idApp])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    //-------------------------------AJAX-------------------------------
    /**
     * Lists all Productos models.
     * @return mixed
     */
    public function actionListaAjax($idApp,$catCodigo=NULL)
    {
        $searchModel = new Productos();

       if (Yii::$app->request->isAjax) {
           
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_null($catCodigo)){
                if($catCodigo==''){
                    $poductos =Productos::find()->where(['app_idApp'=>$idApp])->all();
                }else{
                    $poductos =Productos::find()->where(['app_idApp'=>$idApp,'categoriaCodigo'=>$catCodigo])->all();
                }
                
            }else{
                $poductos =Productos::find()->where(['app_idApp'=>$idApp])->all();
            }
            
            
            if ($poductos ) {
                $data=array();
                foreach($poductos as $row)
                {

                    $data[]=['id'=>$row->id,
                            'nombre'=>$row->nombre,
                            'unidad'=>$row->unidad,
                            'descripcion'=>$row->descripcion,
                            'precio'=>$row->precio,
                            'costoBase'=>$row->costoBase,
                            'unxCaja'=>$row->unxCaja,
                            'cajaxPallet'=>$row->cajaxPallet,
                            'costoInstalacion'=>$row->costoInstalacion,
                            ];
                }
                return [
                        'error'=>0,
                        'data'=>$data,
                        'message' => 'ok',
                         ];

                
            } else {
                return [
                    'error'=>1,
                    'data'=>'',
                    'message' => 'no hay datos',
                ];
            }

        }

      
      
    }

    public function actionGetInfoCliente($idApp,$idProducto,$idCliente){
        $pto= $this->findModel($idProducto, $idApp);


        if (Yii::$app->request->isAjax) {
           
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


            if($pto){
                $data=['precioDif'=>$pto->getPrecio($idCliente),
                        ];

                return [
                    'error'=>0,
                    'data'=>$data,
                    'message' => 'ok',
                    ];

            } else {
                return [
                    'error'=>1,
                    'data'=>'',
                    'message' => 'Problemas para obtener las información',
                ];
            }


        }
    }

        /**
     * Lists all Productos models.
     * @return mixed
     */
    public function actionListaAjaxAll($idApp)
    {
        $searchModel = new Productos();

       if (Yii::$app->request->isAjax) {
           
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          
            $poductos =Productos::find()->where(['app_idApp'=>$idApp])->all();
               
            
            
            if ($poductos ) {
                $data=array();
                foreach($poductos as $row)
                {

                    $data[]=['id'=>$row->id,
                            'nombre'=>$row->nombre,
                            'unidad'=>$row->unidad,
                            'descripcion'=>$row->descripcion,
                            'categoria'=>$row->categoria!=NULL?$row->categoria->nombre:'sin categoria',
                            'precio'=>$row->precio,
                            'stock'=>$row->stock!=NULL?$row->stock->cantidad:'-',
                            'costoBase'=>$row->costoBase,
                            'unxCaja'=>$row->unxCaja,
                            'cajaxPallet'=>$row->cajaxPallet,
                            'costoInstalacion'=>$row->costoInstalacion,
                            ];
                }
                return [
                        'error'=>0,
                        'data'=>$data,
                        'message' => 'ok',
                         ];

                
            } else {
                return [
                    'error'=>1,
                    'data'=>'',
                    'message' => 'no hay datos',
                ];
            }

        }

      
      
    }

    public function actionFindAjax($idApp,$id,$idCliente=null){
        $pto=$this->findModel($id, $idApp);
        if (isset($idCliente)){

        }

        if (Yii::$app->request->isAjax) {
           
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


            if($pto){
                $data=$pto;

                return [
                    'error'=>0,
                    'data'=>$data,
                    'message' => 'ok',
                    ];

            } else {
                return [
                    'error'=>1,
                    'data'=>'',
                    'message' => 'Problemas para obtener el producto',
                ];
            }


        }
    }
    

}
