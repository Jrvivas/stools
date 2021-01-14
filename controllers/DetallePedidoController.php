<?php

namespace app\controllers;

use app\models\Apps;
use Yii;
use app\models\DetallePedido;
use app\models\DetallePedidoSearch;
use app\models\Productos;
use app\models\AppController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DetallePedidoController implements the CRUD actions for DetallePedido model.
 */
class DetallePedidoController extends AppController
{

    /**
     * Lists all DetallePedido models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DetallePedidoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DetallePedido model.
     * @param integer $id
     * @param integer $pedido_id
     * @param string $app_idApp
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $pedido_id, $app_idApp)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $pedido_id, $app_idApp),
        ]);
    }

    /**
     * Creates a new DetallePedido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idPedido,$idApp)
    {
        $model = new DetallePedido();
        $model->pedido_id=$idPedido;
        $model->app_idApp=$idApp;
        $app=Apps::get($idApp);
        $productos=$app->productos;

        if ($model->load(Yii::$app->request->post()) ) {
            $model->id=$model->maxId($idApp,$idPedido)+1;
            if($model->save()){
                return $this->redirect(['pedido/update', 'id' => $model->pedido_id, 'app_idApp' => $model->app_idApp]);
            }

            
        }

        return $this->render('create', [
            'model' => $model,
            'productos'=>$productos
        ]);
    }

    /**
     * Updates an existing DetallePedido model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $pedido_id
     * @param string $app_idApp
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $pedido_id, $app_idApp)
    {
        $model = $this->findModel($id, $pedido_id, $app_idApp);
        $app=Apps::get($app_idApp);
        $productos=$app->productos;
      

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['pedido/update', 'id' => $model->pedido_id, 'app_idApp' => $model->app_idApp]);
        }

        return $this->render('update', [
            'model' => $model,
            'productos'=>$productos
           
        ]);
    }

    /**
     * Deletes an existing DetallePedido model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $pedido_id
     * @param string $app_idApp
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $pedido_id, $app_idApp)
    {
        $this->findModel($id, $pedido_id, $app_idApp)->delete();

        return $this->redirect(['pedido/update', 'id' => $pedido_id, 'app_idApp' => $app_idApp]);

        //return $this->redirect(['index']);
    }

    /**
     * Finds the DetallePedido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $pedido_id
     * @param string $app_idApp
     * @return DetallePedido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $pedido_id, $app_idApp)
    {
        if (($model = DetallePedido::findOne(['id' => $id, 'pedido_id' => $pedido_id, 'app_idApp' => $app_idApp])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
