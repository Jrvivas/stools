<?php

namespace app\controllers;

use Yii;
use app\models\Precio;
use app\models\Contacto;
//use app\models\PrecioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

/**
 * PrecioController implements the CRUD actions for Precio model.
 */
class PrecioController extends Controller
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
     * Lists all Precio models.
     * @return mixed
     */
    public function actionIndex()
    {
   


        $searchModel = new PrecioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Precio models.
     * @return mixed
     */
    public function actionListaClientesAjax($id,$idProducto)
    {
        $searchModel = new Precio();
        

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            /*$preciosclientes=Contacto::find();
            $preciosclientes->select('contacto.nombre as cliente,contacto.id as idCliente,precio.precio as precio, precio.fechaAct as fechaAct')
            ->leftJoin('precio', '`precio`.`idCliente` = `contacto`.`id` AND `contacto`.`app_idApp`=`precio`.`app_idApp`')
            ->andWhere("contacto.app_idApp='". $id."' AND contacto.cliente='SI' ");      
            $rows=$preciosclientes->all();*/
            $query = new Query;
            $query->select('contacto.nombre as cliente,contacto.id as idCliente,precio.precio as precio, precio.fechaAct as fechaAct')
            ->from('contacto')
            ->leftJoin('precio', '`precio`.`idCliente` = `contacto`.`id` AND `contacto`.`app_idApp`=`precio`.`app_idApp` AND `precio`.`idProducto`='.$idProducto)
            ->where("contacto.app_idApp='". $id."' AND contacto.cliente='SI' ");      
            $rows=$query->all();
            
            if ($rows ) {
                $data=array();
                //$text=print_r($rows);
                foreach($rows as $row)
                {
                    //[{'cliente':"Juan Perez",idCliente:20,idPrecio:0,precio:0,fechaAct:0}
                    $data[]=['idCliente'=>$row['idCliente'],
                            'cliente'=>$row['cliente'],
                            'idPrecio'=>'',
                            'precio'=>$row['precio'],
                            'fechaAct'=>$row['fechaAct']
                            ];
                    //$text.=print_r($row, 1).' ! ';      

                }
                //"SELECT `contacto`.`nombre` AS `cliente`, `contacto`.`id` AS `idCliente`, `precio`.`precio` AS `precio`, `precio`.`fechaAct` AS `fechaAct` FROM `contacto` LEFT JOIN `precio` ON `precio`.`idCliente` = `contacto`.`id` AND `contacto`.`app_idApp`=`precio`.`app_idApp` WHERE contacto.app_idApp='216b68d3638b76c2-20200527081443' AND contacto.cliente='SI' "
                //$data=$preciosclientes->createCommand()->sql;
               // $data=$text;
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

     /**
     * upload precio de cliente.
     * @return mixed
     */
    public function actionSetPrecioClienteAjax($id,$idProducto,$idCliente,$valor)
    {
            $precio=new Precio();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $precio=Precio::find()->where("app_idApp='".$id."' AND idProducto=".$idProducto." AND idCliente=".$idCliente)->one();
            if($precio){
                //Si el precio es '-' se borra 
                if(trim($valor)=='-' &&  $precio->delete()){
                   return [
                        'error'=>0,
                        'data'=>'Precio borrado',
                        'message' => 'ok',
                         ];
                }
                $precio->precio=$valor;
                $precio->fechaAct=date("Y-m-d H:i:s");
                if($precio->save()){

                     return [
                        'error'=>0,
                        'data'=>'Precio actualizado',
                        'message' => 'ok',
                         ];

                
                    } else {
                        return [
                            'error'=>1,
                            'data'=>[$precio->errors],
                            'message' => 'no pudo ser actualizado el precio',
                        ];
                    }
            }else{
                $precio=new Precio();
                $precio->app_idApp=$id;
                $precio->idProducto=$idProducto;
                $precio->idCliente=$idCliente;
                $precio->precio=$valor;
                $precio->fechaAct=date("Y-m-d H:i:s");
                if($precio->validate() && $precio->save()){
                    return [
                        'error'=>0,
                        'data'=>'Precio actualizado',
                        'message' => 'ok',
                         ];

                
                    } else {
                        return [
                            'error'=>1,
                            'data'=>$precio->errors,
                            'message' => 'no pudo ser actualizado el precio',
                        ];
                    }

            }
        
        }

    }

    /**
     * obtener  precio de cliente.
     * @return mixed
     */
    public function actionGetPrecioClienteAjax($id,$idProducto,$idCliente)
    {
            $precio=new Precio();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $precio=Precio::find()->where("app_idApp='".$id."' AND idProducto=".$idProducto." AND idCliente=".$idCliente)->one();
            if($precio){


                return [
                'error'=>0,
                'data'=>['precio'=>$precio->precio,'fechaAct'=>$precio->fechaAct,'idCliente'=>$precio->idCliente,'idProducto'=>$precio->idProducto],
                'message' => 'ok',
                    ];

        
            } else {
                return [
                    'error'=>1,
                    'data'=>[$precio->errors],
                    'message' => 'no encontro o se produjo un error',
                ];
            }

        
        }

    }




    /**
     * Displays a single Precio model.
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
     * Creates a new Precio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       
        $model = new Precio();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id, 'app_idApp' => $model->app_idApp]);
            return $this->redirect(['Precio', 'id'  => $model->app_idApp]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Precio model.
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
     * Deletes an existing Precio model.
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
     * Finds the Precio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $app_idApp
     * @return Precio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $app_idApp)
    {
        if (($model = Precio::findOne(['id' => $id, 'app_idApp' => $app_idApp])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
