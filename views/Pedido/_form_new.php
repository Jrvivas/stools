<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Contacto;
use app\models\Pedido;
use app\models\Util;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\data\ActiveDataProvider;
//use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */

// Hacemos la lista de Clientes
$contacto = Contacto::find()->where(['app_idApp' => $model->app_idApp, 'cliente' => 'SI'])->orderBy(['nombre' => SORT_DESC])->all();
$clientes = ArrayHelper::map($contacto, 'id', 'nombre');

/*foreach($contacto as $clt){
    $clientes[]=[$clt['id']=>$clt['nombre']];
}*/

//Descripcion del pedido
$model->nombre = 'PEDIDO_' . date('Y-m-d');

//Lista de las prioridades
$prioridades = Pedido::listaPrioridades();

$estados = Pedido::listEstados();

$idApp = $model->app_idApp;
$editable = $model->isEditable();



// reemplazar por un data provider
//-----------------------------------
$detalles = '[';
$sep = '';

foreach ($model->detallesPedido as $d) {
    if (empty($d->ancho)) $d->ancho = 0;
    if (empty($d->alto)) $d->alto = 0;
    if (empty($d->inst)) $d->inst = 0;
    if(empty($d->fraccion))$d->fraccion=1;
    $estado = 'ACTIVO';
    if (!$editable) $estado = 'NOEDIT';
     
    $detalles .= $sep . '{"id":' . $d->id . ',"productos_id":' . $d->productos_id . ',"producto":"' . $d->producto->nombre . '","cantidad":' . $d->cantidad . ',"ancho":' . $d->ancho .
        ',"alto":' . $d->alto . ',"fraccion":' .$d->fraccion .',"inst":' . $d->inst . ',"detalle":"' . str_replace('"', "'", $d->detalle) . '","monto":' . $d->monto . ',"estado":"' . $estado . '"}';
    $sep = ',';
}
//------------------------------------------------------

//TODO 
$listDetalle = new ActiveDataProvider([
    'query' =>$model->detallesPedido,
    'pagination' => [
        'pageSize' => 10,
    ],
]);


$cliente=$model->cliente;
$lblCliente='-Sin Cliente-';
if($cliente){
    $lblCliente=$cliente->nombre.'('.$cliente->empresa.')';
}
$detalles .= ']';
$script = "var detalles=" . $detalles;


//$this->registerJsFile(Yii::getAlias('@web').'/js/html2canvas.min.js',['position'=>View::POS_END] ,null);

$this->registerJsFile('https://unpkg.com/react@16/umd/react.development.js', ['position' => View::POS_END], null);//Agregamos React
$this->registerJsFile('https://unpkg.com/react-dom@16/umd/react-dom.development.js', ['position' => View::POS_END], null);//Agregamos React
$this->registerJsFile('https://unpkg.com/babel-standalone@6/babel.min.js', ['position' => View::POS_END], null);//Agregamos React


$this->registerJsFile(Yii::getAlias('@web') . '/js/app_api_pedido.js?v=0.004', ['position' => View::POS_END], null);



$script .= <<<JS
//----------------------------------


window.onload=function() {
       // listaProductos();
        listarDetalle();
        
        detalles=$detalles;
        dibujarDetallesPedido()
       // _setDetalles(detalles);
         calcularMostrarTotalPedido();

        
    };
  
JS;
$this->registerJs($script, View::POS_BEGIN, 'my-options');
$this->registerJsFile(Yii::getAlias('@web') . '/js/models/app_model_pedido.js?v=0.005', ['depends' => [yii\web\YiiAsset::className()],'position' => View::POS_END], null);//Agregamos React
//$this->registerJsFile(Yii::getAlias('@web') . '/js/components/app_new_detalle_pedido.js?v=0.009', ['type'=>'text/babel','position' => View::POS_END], null);//Agregamos React
$this->registerJsFile(Yii::getAlias('@web') . '/js/components/app_new_detalle_pedido_opt.js?v=0.000', ['depends' => [yii\web\YiiAsset::className()],'position' => View::POS_END], null);//Agregamos React

?>
<div class="pedido-form">
    <div class="row mx-5">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(); ?>
           <!-- <div class="row " style="font-size:1.5em; background-color:rgba(255,255,255,0.5); border-style:solid; border-width:1px; border-radius:5px; border-color:var(--primary); padding:10px; margin:5px">-->
         <div class="row marcoItems" >

                <div class="col-md-2">
                    <?= $form->field($model, 'id')->textInput(['disabled' => true]) ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'fechaIni')->textInput(['type' => 'date', 'value' => (new DateTime($model->fechaIni))->format('Y-m-d')]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'fechaEntrega')->textInput(['type' => 'date', 'value' => (new DateTime($model->fechaEntrega))->format('Y-m-d')]) ?>
                    <?= $form->field($model, 'fechaFin')->textInput(['type' => 'hidden'] )->label(false) ?>
                </div>
                
                   
                
                <div class="col-md-8 " style="  border-style: groove; padding: 2px 20px; border-radius: 10px;">
                   <span id="dataCliente"><?=$lblCliente?></span> 
                   <?= $form->field($model, 'contacto_id')->hiddenInput()->label(false)?> 
                </div>
                  <div class=" col-md-4"> 
                     
                     <button id="botCliente" class="btn btn-primary" data-toggle="modal" data-target="#ModalPedidos" type="button" onclick="seleccionarCliente()" style="margin-top: 15px;">Buscar Cliente</button>
                   
                  </div>

                <div class=" col-md-4">
                    <?= $form->field($model, 'delivery')->dropDownList(['0' => 'No', '1' => 'Si'])->label('Viaje'); ?>
                </div>

                <div class="col-md-12">
                    <?= $form->field($model, 'comentarios')->textInput() ?>

                </div>
              
                <div id="detallesPedido" class="col-md-12" style="height:300px;overflow: overlay;">
                        <h3>-No hay detalles-</h3>
                </div>

                <hr>
                <?php if ($editable) { ?>
                    <div class=" col-md-12 text-right ">
                        <button class="btn btn-primary" type="button" onclick="nuevoDetalle()" style="font-size:1.5rem;" data-toggle="modal" data-target="#ModalPedidos">Nuevo detalle</button>
                    </div>
                <?php } ?>

                <div class="col-md-3">
                    <?= $form->field($model, 'impuesto')->textInput(['maxlength' => true, 'onchange' => 'calcularMostrarTotalPedido()'])->label('Recargo ($ / %)') ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'descuento')->textInput(['maxlength' => true, 'onchange' => 'calcularMostrarTotalPedido()'])->label('Descuento ($ / %)') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'monto')->textInput(['maxlength' => true])->label('Monto $') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'pago')->textInput(['maxlength' => true, 'onchange' => 'calcularMostrarTotalPedido()'])->label('Pagos $') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'saldo')->textInput(['maxlength' => true, 'disabled' => true])->label('Saldos $') ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'prioridad')->dropDownList($prioridades) ?>
                </div>


                <div class="col-md-4">
                    <?= $form->field($model, 'estado')->dropDownList($estados, ['disabled' => $editable ? false : true]) ?>
                </div>

            </div>

            <div class="form-group">
                <?= Html::a('Cancelar', ['pedido/index-react', 'idApp' => $model->app_idApp], ['class' => 'btn btn-danger  mx-2', 'style' => 'font-size:1.5em;']) ?>

                <button class="btn btn-success" type="button" onclick="botNewEnviar(this)" style="font-size:1.5em;"  >Aceptar</button>

            </div>

            <?php ActiveForm::end(); ?>
            <button id="botImprimir" class="btn btn-primary" data-toggle="modal" data-target="#ModalPedidos" type="button" onclick="generarComprobante()">Imprimir</button>

        </div>
    </div>
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="ModalPedidos" tabindex="-1" role="dialog" aria-labelledby="ModalPedidosLabel" aria-hidden="true" style="color:var(--app-ctr-bg-color)">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding:8px 15px">
                    <h2 class="modal-title" id="ModalPedidosLabel" style="display:inline">Modal title</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="idModalPedido1" class="modal-body" style="padding: 0px 20px;">
                    ...
                </div>
                <div id="idModalPedido" class="modal-body" style="padding: 0px 20px;">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button id="modalBotAceptar" type="button" data-dismiss="modal" class="btn btn-success">Aceptar</button>

                </div>
            </div>
        </div>
    </div>
</div>