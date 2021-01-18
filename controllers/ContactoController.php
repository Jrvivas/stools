<?php

namespace app\controllers;

use Yii;
use app\models\Contacto;
use app\models\AppController;
use app\models\ContactoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContactoController implements the CRUD actions for Contacto model.
 */
class ContactoController extends AppController
{


    /**
     * Lists all Contacto models.
     * @return mixed
     */
    public function actionIndex($idApp)
    {
        $searchModel = new ContactoSearch();
        $searchModel->app_idApp=$idApp;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //var_dump(json_encode($dataProvider ));
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idApp'=>$idApp,
        ]);
    }

    /**
     * Displays a single Contacto model.
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
     * Creates a new Contacto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contacto();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'app_idApp' => $model->app_idApp]);
        }

        return $this->render('create', [
            'model' => $model,
            'app_idApp'=>$model->app_idApp
        ]);
    }

    /**
     * Updates an existing Contacto model.
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
     * Deletes an existing Contacto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param string $app_idApp
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $app_idApp)
    {
        $this->findModel($id, $app_idApp)->delete();

        $searchModel = new ContactoSearch();
        $searchModel->app_idApp=$app_idApp;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //var_dump(json_encode($dataProvider ));
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idApp'=>$app_idApp,
        ]);

        //return $this->redirect(['index']);
    }

     /**
     * Lists all Productos models.
     * @return mixed
     */
    public function actionListaAjax($id)
    {
        $searchModel = new Contacto();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $contactos =Contacto::find()->where(['app_idApp'=>$id,'cliente'=>'SI'])->all();
            
            if ($contactos ) {
                $data=array();
                foreach($contactos as $row)
                {

                    $data[]=['id'=>$row->id,
                            'nombre'=>$row->nombre,
                            'direccion'=>$row->direccion,
                            'localidad'=>$row->localidad,
                            'empresa'=>$row->empresa,
                            'cel'=>$row->cel,
                            'tel'=>$row->tel,
                            'cuit'=>$row->cuit
                            
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

    /*
    obtiene todos los pedidos del cliente
    */
    public function actionGetPedidos($idApp,$id){
      

        if (true) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $contactos =Contacto::findOne(['app_idApp'=>$idApp,'id'=>$id]);
            $pedidos=$contactos->pedidos;
            return [
                'error'=>0,
                'data'=>$pedidos,
                'message' => 'ok',
                 ];
        }
          return "<div>['error'=>1,'data'=>'{}','message' => 'No es una llamada ajax',]</div>";
            
    }


    /**
     * Devuelve un json con los datos del contacto solicitado
     * @return json
     */
    public function actionFindAjax($idApp,$id){
        $cto=$this->findModel($id, $idApp);
 
        if (Yii::$app->request->isAjax) {
           
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


            if($cto){
                $data=$cto;

                return [
                    'error'=>0,
                    'data'=>$data,
                    'message' => 'ok',
                    ];

            } else {
                return [
                    'error'=>1,
                    'data'=>'',
                    'message' => 'Problemas para obtener el Contacto',
                ];
            }


        }
    }


    /**
     * Finds the Contacto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $app_idApp
     * @return Contacto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $app_idApp)
    {
        if (($model = Contacto::findOne(['id' => $id, 'app_idApp' => $app_idApp])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
