<?php

namespace app\controllers;

use app\models\Util;
use app\models\Apps;
use app\models\Categoria;
use app\models\Productos;
use app\models\Pedido;
use app\models\CuentaSearch;
use app\models\Cuenta;
use app\models\DetallePedido;
use app\models\Contacto;
use app\models\ProductosSearch;
use app\models\PedidoSearch;
use app\models\ContactoSearch;
use app\models\AppsSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use Yii;
/**
 * ProductosController implements the CRUD actions for Productos model.
 */
class GraficaController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $this->layout = 'layout_grafica';
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
     * Inicio de la Aplicacion
     * @return mixed
     */
    public function actionIndex($id)
    {
        if(Yii::$app->user->isGuest){
 
            return $this->redirect(['site/login']);
        }



        $this->layout = 'layout_grafica';

        $model=Apps::findOne($id);

        //Variables para el layout
        Yii::$app->variables=['idApp'=>$id];
       
        Yii::$app->name=$model->nombre;
            
            
        

        if($model && $model->codigoApp===Apps::APP_COMMERCE_GRAFICA){
            return $this->render('index', [
                'model' => $model,
                
            ]);
        }
        return $this->redirect(['apps/index']); 
    }

    //----------------------DASHBOARD-----------------------------------------

    public function actionDashboard($id){
        $this->layout = 'layout_grafica';

        $model=Apps::findOne($id);

        //Variables para el layout
        Yii::$app->variables=['idApp'=>$id];
       
        Yii::$app->name=$model->nombre;
            
        return $this->render('dashboard',['idApp'=>$id]);
    }

      //----------------------CUENTAS-----------------------------------------

      public function actionCuenta($id){
        $this->layout = 'layout_grafica';
        $searchModel = new CuentaSearch();
        $searchModel->app_idApp=$id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model=Apps::findOne($id);
 
        //Variables para el layout
        Yii::$app->variables=['idApp'=>$id];
       
        Yii::$app->name=$model->nombre;
            
        return $this->render('cuentas',['idApp'=>$id,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,]);
    }

    
     /**
      * Crear un nuevo producto
      */
      public function actionCreateCuenta($id){
        $model = new Cuenta();
        $model->app_idApp=$id;
       // $model->id=$model->maxId($id)+1;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id, 'app_idApp' => $model->app_idApp]);
            return $this->redirect(['cuenta', 'id'  => $model->app_idApp]);
        }
          return $this->render('newCuenta', [
            'model' => $model
        ]);

     }
    //-----------------------------------------------------------------------------


    public function actionReportAjax($id,$data=''){
         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

         if(!empty($data)){
            $query=base64_decode($data);
            if($query){
                $data=\Yii::$app->db->createCommand($query)->queryAll();
                       return [
                        'error'=>0,
                        'data'=>$data,
                        'mensaje' => 'Operación exitosa!',
                    ];
            }
         }
            return [
                'error'=>1,
                'data'=>[],
                'mensaje' => 'Se produjo un error!',
            ];
  
    }

    //----------------------------------------------------------- Manejo de productos------------------------------------------
    /**
     * Listar los Productos de las aplicación
     */
     public function actionProductos($id){
        
         // crear un data provide
        
      
        $this->layout = 'layout_grafica';

  
        $queryCategorias=Categoria::find()->where(['app_idApp'=>$id])->orderBy(['nombre'=>SORT_DESC])->all();
        $categorias=ArrayHelper::map($queryCategorias,'codigo','nombre');
        $dataCategorias = new ActiveDataProvider([
            'query' => Categoria::find()->where(['app_idApp'=>$id]),
        ]);
        
        $searchModel = new ProductosSearch();
        $searchModel->app_idApp=$id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('productos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataCategorias'=>$dataCategorias,
            'categorias'=>$categorias,
            'idApp'=>$id
        ]);


     }

     /**
      * Crear un nuevo producto
      */
     public function actionCreateProducto($id){
        $model = new Productos();
        $model->app_idApp=$id;
        $model->id=$model->maxId($id)+1;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id, 'app_idApp' => $model->app_idApp]);
            return $this->redirect(['productos', 'id'  => $model->app_idApp]);
        }
          return $this->render('newProducto', [
            'model' => $model
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
    public function actionUpdateProducto($id, $app_idApp)
        {
            $model = $this->findProductoModel($id, $app_idApp);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['productos', 'id'  => $model->app_idApp]);
            }

            return $this->render('editProducto', [
                'model' => $model,
            ]);
        }


     //---------------------------------------------------------------------------------------------------------------
     //----------------------------------------------------------- Manejo de Pedidos------------------------------------------
         /**
     * Listar los Pedidos de las aplicación
     */
    public function actionPedidos($id){
        
        // crear un data provide
       

       $this->layout = 'layout_grafica';

       $searchModel = new PedidoSearch();
       $searchModel->app_idApp=$id;
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       

       return $this->render('pedidos', [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
           'idApp'=>$id
       ]);


    }
         /**
      * Crear un nuevo Pedido
      */
      public function actionCreatePedido($id){
        $model = new Pedido();
        $model->app_idApp=$id;
       // $model->id=$model->maxId($id)+1;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id, 'app_idApp' => $model->app_idApp]);
            return $this->redirect(['pedidos', 'id'  => $model->app_idApp]);
        }
          return $this->render('newPedido', [
            'model' => $model
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
        public function actionUpdatePedido($id, $app_idApp)
        {
            $model = $this->findPedidoModel($id, $app_idApp);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['pedidos', 'id'  => $model->app_idApp]);
            }

            return $this->render('editPedido', [
                'model' => $model,
            ]);
        }


                /**
         * Borrar Pedido
         */
        public function actionBorrarPedido($id,$app_idApp){
            $model = $this->findPedidoModel($id, $app_idApp);
            Yii::$app->variables=['idApp'=>$app_idApp];

            
            if(DetallePedido::deleteAll("app_idApp='".$app_idApp."' AND pedido_id=".$id)){
                if($model && $model->delete()){
                    return $this->redirect(['pedidos', 'id'  => $model->app_idApp]);
               }
            }
             return $this->redirect(['pedidos', 'id'  => $model->app_idApp]);

        }
     //---------------------------------------------------------------------------------------------------------------
     //----------------------------------------------------------- Manejo de Contactos------------------------------------------
         /**
         * Listar los Clientes de las aplicación
         */
        public function actionClientes($id){
            
            // crear un data provide
        

        $this->layout = 'layout_grafica';

        $searchModel = new ContactoSearch();
        $searchModel->app_idApp=$id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('clientes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idApp'=>$id
        ]);


        }
            /**
         * Crear un nuevo Pedido
        */
        public function actionCreateCliente($id){
            $model = new Contacto();
            $model->app_idApp=$id;
            $model->id=$model->maxId($id)+1;
            $model->cliente='SI';
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                //return $this->redirect(['view', 'id' => $model->id, 'app_idApp' => $model->app_idApp]);
                return $this->redirect(['clientes', 'id'  => $model->app_idApp]);
            }
            return $this->render('newCliente', [
                'model' => $model
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
    public function actionUpdateCliente($id, $app_idApp)
    {
        $model = $this->findClienteModel($id, $app_idApp);
        $model->cliente='SI';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['clientes', 'id'  => $model->app_idApp]);
        }

        return $this->render('editCliente', [
            'model' => $model,
        ]);
    }
     //---------------------------------------------------------------------------------------------------------------

     private function getIdApp(){
        
            $idUser=Yii::$app->user->getId();
            $query=Apps::find()->where(['idUser']);

     }


              /**
     * Finds the Productos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $app_idApp
     * @return Productos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findProductoModel($id, $app_idApp)
    {
        if (($model = Productos::findOne(['id' => $id, 'app_idApp' => $app_idApp])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
         /**
     * Finds the Productos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $app_idApp
     * @return Contacto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findClienteModel($id, $app_idApp)
    {
        if (($model = Contacto::findOne(['id' => $id, 'app_idApp' => $app_idApp])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


         /**
     * Finds the Productos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $app_idApp
     * @return Pedido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPedidoModel($id, $app_idApp)
    {
        if (($model = Pedido::findOne(['id' => $id, 'app_idApp' => $app_idApp])) !== null) {
            return $model;
        }
        return null;

        //throw new NotFoundHttpException('The requested page does not exist.');
    }



}