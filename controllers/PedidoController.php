<?php

namespace app\controllers;

use Yii;
use app\models\Pedido;
use app\models\DetallePedido;
use app\models\PedidoSearch;
use app\models\PedidoSearchJson;
use app\models\AppController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PedidoController implements the CRUD actions for Pedido model.
 */
class PedidoController extends  AppController
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
     * Lists all Pedido models.
     * @return mixed
     */
    public function actionIndex($idApp)
    {

        $searchModel = new PedidoSearch();
        $searchModel->app_idApp=$idApp;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idApp'=>$idApp
        ]);
    }

        /**
     * Lists all Pedido models.
     * @return mixed
     */
    public function actionIndexReact($idApp)
    {

        $searchModel = new PedidoSearchJson();
        $searchModel->app_idApp=$idApp;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    

    
        if (Yii::$app->request->isAjax) {
           Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
            return [
                'error'=>0,
                'data'=>$dataProvider->all(),
                'message' => 'ok',
                 ];

        }else{
             return $this->render('index_react', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idApp'=>$idApp,
           
        ]); 
        }


    }

 public function actionAjaxPedido($idApp)
    {

        $searchModel = new PedidoSearchJson();
        $searchModel->app_idApp=$idApp;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    

         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
            return [
                'error'=>0,
                'data'=>$dataProvider->all(),
                'message' => 'ok',
                 ];




    }
    

    /**
     * Displays a single Pedido model.
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
     * Creates a new Pedido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idApp,$newDetalle=false) //se agrego newDetalle
    {
      

        $model = new Pedido();
        $model->app_idApp=$idApp;


        if ($model->load(Yii::$app->request->post()) ) {
            // Verifica si del formulario es nuevo
            //var_dump($model);
           
            //Nombre del pedido
            if(!isset($model->nombre)){
                $fecha= date("Y-m-d h:i:sa");
                $model->nombre='Pedido_'.$model->cliente->nombre.'_'.$fecha;
 
            }
            if(!isset($model->id)){
                $model->id= $model->maxId($idApp)+1;
            }
            

            if($model->save()){
                //var_dump($model);
                    if($model->accion==="newDetalle"){
                        $modelDetalle=new DetallePedido();
                        $modelDetalle->pedido_id=$model->id;
                        $modelDetalle->app_idApp=$idApp;
                        //return $this->render('@app\view\detalle-pedido\create', ['model' => $modelDetalle, 'idApp' => $idApp]);
                        return $this->redirect(["detalle-pedido/create",'idPedido' =>$model->id, 'idApp' => $idApp]);
                    }
                    return $this->redirect(['view', 'id' => $model->id, 'app_idApp' => $model->app_idApp]);
            }
            $model->id=null;
           
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    /**
     * Updates an existing Pedido model.
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
            if($model->accion==="newDetalle"){
                $modelDetalle=new DetallePedido();
                $modelDetalle->pedido_id=$model->id;
                $modelDetalle->app_idApp=$app_idApp;
                return $this->render('\new_detalle', ['model' => $modelDetalle, 'idApp' => $app_idApp]);
            }
            return $this->redirect(['view', 'id' => $model->id, 'app_idApp' => $model->app_idApp]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

     /**
     * Creates a new Pedido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateAjax($idApp)
    {
        
        $model = new Pedido();
        $request = Yii::$app->request;
        $post    = $request->post();
        $actualizar=false;
        $actualizarStock=false;
        

        if (Yii::$app->request->isAjax ) {
           // $model->load(Yii::$app->request->post());
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

          

            //$data= implode( ", ", $request->getBodyParams('data'));
            //$data=[$request->queryParams,$post,$request->bodyParams,json_decode($request->getRawBody(),true)];
            $data=json_decode(Yii::$app->request->getRawBody(),true);
            
            $data=$data['data'];
               
            
            if(!empty($data['id']) && $model=$this->findModel($data['id'], $idApp)){
                //$model=$this->findModel($data['id'], $idApp);
                $actualizar=true;
                
            }else{
                $model = new Pedido();//??
                $model->id=$model->maxId($idApp)+1; 
                $model->app_idApp=$idApp; //04-12-20
                $model->idResponsable=Yii::$app->user->identity->id;//04-12-20
            }
          


           if($actualizar==true){
                $model->idModifico=Yii::$app->user->identity->id;
            }
            
            $model->fechaIni=$data['fechaini'];
            $model->fechaFin=$data['fechafin'];
            $model->nombre=$data['nombre'];
            $model->comentarios=$data['comentario'];
            $model->estado=$data['estado'];
            $model->prioridad=$data['prioridad'];
            $model->monto=$data['monto'];
            $model->pago=$data['pago'];
            $model->saldo=$data['saldo'];
            $model->contacto_id=$data['contacto_id'];
            $model->fechaEntrega=$data['fechaentrega'];
            $model->descuento=$data['descuento'];
            $model->impuesto=$data['impuesto'];
            $model->delivery=$data['delivery'];
            $detalles=$data['detalles'];
          if(empty($model->fechaFin) && $model->estado=='ENTREGADO'){
              //if( $model->estado=='ENTREGADO'){
                $actualizarStock=true;
                $model->fechaFin=date("Y-m-d H:i:s");
            }

            
            if ($model->validate()){

                if($model->save()){
                    $errores=[];

                    //Guardar detalles
                    foreach( $detalles as $d){
                        
                        if(!$actualizar){

                            if($d['estado']=='BORRADO'){
                                continue;
                            }
                            $newDetalle= new DetallePedido();
                            $newDetalle->id=$newDetalle->maxId($idApp,$model->id)+1;
                        } else{
                            
                            if (($newDetalle = DetallePedido::findOne(['id' =>$d['id'] , 'app_idApp' =>$idApp, 'pedido_id'=>$model->id])) == null){

                                if($d['estado']=='BORRADO'){
                                    continue;
                                }
                                $newDetalle= new DetallePedido();
                                $newDetalle->id=$newDetalle->maxId($idApp,$model->id)+1;
                            }else{
                                if($d['estado']=='BORRADO'){
                                        $newDetalle->delete(); 
                                        continue;
                                }
                            }
                            
                        }
                        
                         
                        
                        $newDetalle->pedido_id=$model->id;
                        $newDetalle->app_idApp=$idApp;
                        $newDetalle->productos_id=$d['productos_id'];
                        $newDetalle->detalle=$d['detalle'];
                        $newDetalle->cantidad=$d['cantidad'];
                        $newDetalle->fraccion=$d['fraccion'];
                        $newDetalle->alto=$d['alto'];
                        $newDetalle->ancho=$d['ancho'];
                        $newDetalle->monto=$d['monto'];
                      
                        if(!$newDetalle->validate() ){
                            
                            $errores[]=$newDetalle->errors;
                           
                        }else{
                            if($newDetalle->save() && $actualizarStock){
                                if($newDetalle->stock){
                                    $newDetalle->stock->remStock($newDetalle->cantidad);
                                }
                                
                            }
                        }

                    }

                    if(empty($errores)){
                         return [
                                'error'=>0,
                                'data'=>[$model,$detalles],
                                'mensaje' => 'Operación exitosa!',
                            ];
                    }else{
                        return [
                                'error'=>1,
                                'data'=>$errores,
                                'mensaje' => 'Error al guardar los detalles',
                            ];
                    }


                }else{

                    return [
                        'error'=>1,
                        'data'=>$model->errors,
                        'mensaje' => 'Error al querer guardar el pedido',
                    ];
                }
                 
        
            }else{
                return [
                'error'=>1,
                'data'=>[$model,$model->errors],
                'mensaje' => 'No fue posible validar el pedido',
            ];
            }
            
        }
        return [
            'error'=>1,
            'data'=>'ERROR desconocido',
            'mensaje' => 'No fue posible validar el pedido',
        ];
    }


    /**
     * Deletes an existing Pedido model.
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
     * Finds the Pedido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $app_idApp
     * @return Pedido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $app_idApp)
    {
        if (($model = Pedido::findOne(['id' => $id, 'app_idApp' => $app_idApp])) !== null) {
            return $model;
        }
        return null;


        //throw new NotFoundHttpException('The requested page does not exist.');
    }
}
