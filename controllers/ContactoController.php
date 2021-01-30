<?php

namespace app\controllers;

use Yii;
use app\models\Contacto;
use app\models\AppController;
use app\models\ContactoSearch;
use app\models\Cuenta;
use app\models\Productos;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

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
     * Lists all clientes del models.
     * @return mixed
     */
    public function actionListaAjax($idApp)
    {
        $searchModel = new Contacto();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $contactos =Contacto::find()->where(['app_idApp'=>$idApp,'cliente'=>'SI'])->all();
            
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

    public function actionCuenta($idApp,$idContacto)
    {
        
        if (($model = Cuenta::findOne(['app_idApp' => $idApp, 'contacto_id' => $idContacto])) !== null) {
            $cuenta= $model;
        }else{
            $cuenta=null;
        }
        //echo $nombreCuenta;
        /*$searchModel = new ContactoSearch();
        $searchModel->app_idApp=$idApp;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //var_dump(json_encode($dataProvider ));*/
        if($cuenta!=null){
                
                $estados = ['0' => 'Normal','1' => 'Especial']; 
                $template='';
                $template='<div class="field-cuenta-app_idApp required">

                <input type="hidden" id="cuenta-app_idApp" class="form-control" name="Cuenta[app_idApp]" value="'.$cuenta['app_idApp'].'">

                <div class="help-block"></div>
                </div>
                <div class="field-cuenta-contacto_id required">

                <input type="hidden" id="cuenta-contacto_id" class="form-control" name="Cuenta[contacto_id]" value="'.$cuenta['contacto_id'].'">
                
                <div class="help-block"></div>
                </div>';
                /*$form = ActiveForm::begin();
                //$template.=$form = ActiveForm::begin();
                $template.=$form->field($cuenta, 'contacto_id',['options' =>['style'=>[]]])->hiddenInput()->label(false);
                $template.=$form->field($cuenta, 'nombre')->textInput(['maxlength' => true]);
                $template.=$form->field($cuenta, 'saldo')->textInput(['maxlength' => true]);
                $template.=$form->field($cuenta, 'estado')->dropDownList($estados);
                $template.=Html::submitButton('Guardar', ['class' => 'btn btn-success']);
                ActiveForm::end();*/
            $template.=' <div class="form-group field-cuenta-nombre required">
                    <label class="control-label" for="cuenta-nombre">Nombre</label>
                    <input type="text" id="cuenta-nombre" class="form-control" name="Cuenta[nombre]" value="'.$cuenta['nombre'].'" maxlength="124" aria-required="true">

                        <div class="help-block"></div>
                    </div>';
                $template.=' <div class="form-group field-cuenta-nombre required">
                <label class="control-label" for="cuenta-saldo">Saldo</label>
                <input type="number" id="cuenta-saldo" class="form-control" name="Cuenta[saldo]" value="'.$cuenta['saldo'].'" maxlength="124" aria-required="true">

                    <div class="help-block"></div>
                </div>';
                $hh='';
                foreach($estados as $key=>$value){
                    if($key==$cuenta['estado']){
                        $hh.='<option value="'.$key.'" selected>'.$value.'</option>';
                    }else{
                        $hh.='<option value="'.$key.'" >'.$value.'</option>';
                    }
                    
                }
                $template.='<div class="form-group">
                <label class="control-label" for="cuenta-estado">Estado</label>
                <select id="cuenta-estado" class="form-control" name="Cuenta[estado]">
                '.$hh.'
                </select>
                
                <div class="help-block"></div>
                </div>';
                $template.='<div class="form-group"><button id="guardarCuenta" type="button" class="btn btn-primary" onclick="guardarCuentaContacto('.$cuenta['contacto_id'].');">Guardar</button></div>';
                return $template;
                /*return $this->render('_cuentaUpdate', [
                    'model' =>$cuenta
                ]);*/
            
        }else{
             
            $estados = ['0' => 'Normal','1' => 'Especial']; 
            $template='';
        $template.=' <div class="form-group field-cuenta-nombre required">
                <label class="control-label" for="cuenta-nombre">Nombre</label>
                <input type="text" id="cuenta-nombre" class="form-control" name="Cuenta[nombre]" value="" placeholder="Nombre de la cuenta" maxlength="124" aria-required="true">

                    <div class="help-block"></div>
                </div>';
            $template.=' <div class="form-group field-cuenta-nombre required">
            <label class="control-label" for="cuenta-saldo">Saldo</label>
            <input type="number" id="cuenta-saldo" class="form-control" name="Cuenta[saldo]" value="" placeholder="0.00" maxlength="124" aria-required="true">

                <div class="help-block"></div>
            </div>';
            $hh='';
            foreach($estados as $key=>$value){
                
                    $hh.='<option value="'.$key.'" >'.$value.'</option>';
                
                
            }
            $template.='<div class="form-group">
            <label class="control-label" for="cuenta-estado">Estado</label>
            <select id="cuenta-estado" class="form-control" name="Cuenta[estado]">
            '.$hh.'
            </select>
            
            <div class="help-block"></div>
            </div>';
            $template.='<div class="form-group"><button id="guardarCuenta" type="button" class="btn btn-primary" onclick="crearCuentaContacto('.$idContacto.');">Guardar</button></div>';
            return $template;
            /*return $this->render('_cuentaUpdate', [
                'model' =>$cuenta
            ]);*/
        }
        
    }

    public function actionCuentaupdate($idApp,$idContacto)
    {
        $request=Yii::$app->request->post();
        /*echo var_dump($request);
        echo '</br>';
        echo $idApp.' - '.$idContacto;*/
        $model = Cuenta::findOne(['app_idApp' => $idApp, 'contacto_id' => $idContacto]);
        $model->nombre=$request['nombre'];
        $model->saldo=$request['saldo'];
        $model->estado=$request['estado'];
        if($model->update()){
            echo 'Se guardo correctamente';
        }else{
            echo 'no se pudo guardar';
        }
        
        
    }

    public function actionCuentacreate($idApp,$idContacto)
    {
        $request=Yii::$app->request->post();
        /*echo var_dump($request);
        echo '</br>';
        echo $idApp.' - '.$idContacto;*/
        $model=new Cuenta();
        $model->app_idApp=$idApp;
        $model->contacto_id=$idContacto;
        $model->nombre=$request['nombre'];
        $model->saldo=$request['saldo'];
        $model->estado=$request['estado'];
        $model->fecha= date("Y-m-d H:i:s");
        if($model->save()){
            echo 'Se guardo correctamente';
        }else{
            echo 'no se pudo guardar';
        }
        
        
    }

    public function actionContactoproducto($idApp,$idContacto){
        
        $query = new Query;
            $query->select('id,nombre,precio')
            ->from('productos')
            ->where("app_idApp='". $idApp."'");      
            $productos=$query->all();

        $query = new Query;
            $query->select('idProducto,precio')
            ->from('precio')
            ->where("app_idApp='". $idApp."' AND idCliente=".$idContacto."");      
            $precios=$query->all();
            //echo var_dump($precios[0]);
        $html='<input style="margin-bottom:2px;width: 100%;padding: 3px;margin-bottom: 3px;" type="text" id="filtrarProducto" onKeyUp="filtrarProducto();" placeholder="Producto"> <table id="preciosEspeciales"><thead>
        <tr><th style="display:none">idProducto</th><th>Producto</th><th>Precio Producto</th><th>Precio Especial</th></tr>
        </thead>
        <tbody>';
        $centinela=0;
        foreach($productos as $producto){
            $html.='<tr><td style="display:none">'.$producto['id'].'</td>
            <td>'.$producto['nombre'].'</td>
            <td>'.$producto['precio'].'</td>';
            foreach($precios as $precio){
                if($precio['idProducto']==$producto['id']){
                    $html.='<td><input type="number" value="'.$precio['precio'].'"></td></tr>';
                    $centinela=1;
                }
            }
            if($centinela!=1){
                $html.='<td><input type="number" ></td></tr>';
            }
            $centinela=0;
        }
        $html.='</tbody></table>
        <div style="margin-top:5px">
        <button id="'.$idApp.'" onclick="guardarPrecios(this,'.$idContacto.');" type="button"  class="btn btn-success">Guardar precios</button>
        <button style="border-radius:50%; float:right;" onclick="menosDiez();" type="button"  class="btn btn-primary">10%</button>
        <button style="border-radius:50%; float:right;" onclick="menosVeinte();" type="button"  class="btn btn-primary">20%</button>
        <button style="border-radius:50%; float:right;" onclick="menosTreinta();" type="button"  class="btn btn-primary">30%</button>
        </div>';
        
        return $html;
    }
    public function actionPreciosespeciales($idApp,$idContacto){
        $request=Yii::$app->request->post();
        $query = new Query;
            $query->select('idProducto,precio')
            ->from('precio')
            ->where("app_idApp='". $idApp."' AND idCliente=".$idContacto."");      
            $preciosViejos=$query->all();
            $centinela=true;
            for($i=0; $i < count($request['precios']) ; $i++ ){
                foreach($preciosViejos as $pv){
                    //$request['precios'][$i][0] es el id de producto
                    if($request['precios'][$i][0]==$pv['idProducto']){
                        //echo 'vamos a cambiar el precio: '.$pv['precio'].' a: '.$request['precios'][$i][1];
                        $centinela=false;
                        Yii::$app->db->createCommand()
                        ->update('precio', ['precio'=>$request['precios'][$i][1]], ['app_idApp'=>$idApp,'idCliente'=>$idContacto,'idProducto'=>$request['precios'][$i][0]])
                        ->execute();
                    }
                }
                if($centinela){
                    //echo 'vamos a insertar el precio: '.$request['precios'][$i][1];
                    $command = Yii::$app->db->createCommand();
                    $command->insert('precio',['app_idApp'=>$idApp,'idProducto'=>$request['precios'][$i][0],'idCliente'=>$idContacto,'precio'=>$request['precios'][$i][1],'nombre'=>'prueba','fechaAct'=>date("Y-m-d h:i:s")])
                    ->execute();
                }
                $centinela=true;
            }
            echo 'cambios guardados';
    }
}
