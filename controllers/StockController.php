<?php

namespace app\controllers;

use Yii;
use app\models\Stock;
use app\models\Productos;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

/**
 * StockController implements the CRUD actions for Stock model.
 */
class StockController extends Controller
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
     * upload precio de cliente.
     * @return mixed
     */
    public function actionAddStockAjax($id,$idProducto,$cantidad)
    {
            $stock=new Stock();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $stock=Stock::find()->where("app_idApp='".$id."' AND idProducto=".$idProducto)->one();
            if($stock){

                //-----HACER UN METODO----------//
                $stock->cantidad+=$cantidad;
                $stock->fechaAct=date("Y-m-d H:i:s");
                if($stock->save()){

                     return [
                        'error'=>0,
                        'data'=>['cantidad'=>$stock->cantidad,'fechaAct'=>$stock->fechaAct,'cantidadMin'=>$stock->cantidadMin],
                        'message' => 'ok',
                         ];

                
                    } else {
                        return [
                            'error'=>1,
                            'data'=>[$stock->errors],
                            'message' => 'no pudo ser actualizado el stock',
                        ];
                    }
            }else{
                $stock=new Stock();
                $stock->app_idApp=$id;
                $stock->idProducto=$idProducto;
                $stock->cantidad=$cantidad;
                $stock->cantidadMin=1;
                $stock->fechaAct=date("Y-m-d H:i:s");
                if($stock->validate() && $stock->save()){
                    return [
                        'error'=>0,
                        'data'=>['cantidad'=>$stock->cantidad,'fechaAct'=>$stock->fechaAct,'cantidadMin'=>$stock->cantidadMin],
                        'message' => 'ok',
                         ];

                
                    } else {
                        return [
                            'error'=>1,
                            'data'=>$stock->errors,
                            'message' => 'no pudo ser actualizado el stock',
                        ];
                    }

            }
        
        }

    }

       /**
     * upload precio de cliente.
     * @return mixed
     */
    public function actionRemStockAjax($id,$idProducto,$cantidad)
    {
            $stock=new Stock();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $stock=Stock::find()->where("app_idApp='".$id."' AND idProducto=".$idProducto)->one();
            //detecta si encontro un producto con stock
            if($stock){

                //-----HACER UN METODO----------//
                $stock->cantidad-=$cantidad;
                $stock->fechaAct=date("Y-m-d H:i:s");
                if($stock->save()){

                     return [
                        'error'=>0,
                        'data'=>['cantidad'=>$stock->cantidad,'fechaAct'=>$stock->fechaAct,'cantidadMin'=>$stock->cantidadMin],
                        'message' => 'ok',
                         ];

                
                    } else {
                        return [
                            'error'=>1,
                            'data'=>[$stock->errors],
                            'message' => 'no pudo ser actualizado el stock',
                        ];
                    }
            }else{
                $stock=new Stock();
                $stock->app_idApp=$id;
                $stock->idProducto=$idProducto;
                $stock->cantidad=-$cantidad;
                $stock->cantidadMin=1;
                $stock->fechaAct=date("Y-m-d H:i:s");
                if($stock->validate() && $stock->save()){
                    return [
                        'error'=>0,
                        'data'=>['cantidad'=>$stock->cantidad,'fechaAct'=>$stock->fechaAct,'cantidadMin'=>$stock->cantidadMin],
                        'message' => 'ok',
                         ];

                
                    } else {
                        return [
                            'error'=>1,
                            'data'=>$stock->errors,
                            'message' => 'no pudo ser actualizado el stock',
                        ];
                    }

            }
        
        }

    }

    /**
     * obtener  stock de cliente.
     * @return mixed
     */
    public function actionGetStockAjax($id,$idProducto)
    {
            $stock=new Stock();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $stock=Stock::find()->where("app_idApp='".$id."' AND idProducto=".$idProducto)->one();


            if($stock){


                return [
                'error'=>0,
                'data'=>['cantidad'=>$stock->cantidad,'fechaAct'=>$stock->fechaAct,'cantidadMin'=>$stock->cantidadMin],
                'message' => 'ok',
                    ];

        
            } else {
               

                
                return [
                    'error'=>1,
                    'data'=>[$stock->errors],
                    'message' => 'no encontro productos o se produjo un error',
                ];
            }

        
        }

    }

    /**
     * Creates a new Stock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       
        $model = new Stock();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id, 'app_idApp' => $model->app_idApp]);
            return $this->redirect(['Stock', 'id'  => $model->app_idApp]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Stock model.
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
     * Deletes an existing Stock model.
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
     * Finds the Stock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $app_idApp
     * @return Stock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $app_idApp)
    {
        if (($model = Stock::findOne(['id' => $id, 'app_idApp' => $app_idApp])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
