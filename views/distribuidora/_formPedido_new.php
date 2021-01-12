<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Contacto;
use app\models\Util;
use yii\helpers\ArrayHelper;
use yii\web\View ;
//use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */
$contacto=Contacto::find()->where(['app_idApp'=>$model->app_idApp,'cliente'=>'SI'])->orderBy(['nombre'=>SORT_DESC])->all();
$clientes=ArrayHelper::map($contacto,'id','nombre');

$model->nombre='PEDIDO_'.date('Y-m-d');

$estados=['ESPERA'=>'Espera','PRESUPUESTO'=>'Presupuesto','ELABORACION'=>'Elaboración','RETRASADO'=>'Retrasado','ENTREGADO'=>'Entregado','ANULADO'=>'Rechazado'];
$prioridades=[0=>'Normal',2=>'Media',4=>'Alta',8=>'Urgente',10=>'Hoy'];
$script="var idApp='".$model->app_idApp."';";

$editable=true;
if($model->estado=='ENTREGADO'){
    $editable=false;
}else{
    $editable=true;
}

$detalles='[';
$sep='';
foreach($model->detallesPedido as $d){
        if(empty($d->ancho))$d->ancho=0;
        if(empty($d->alto))$d->alto=0;
        if(empty($d->inst))$d->inst=0;
        $estado='ACTIVO';
        if(!$editable)$estado='NOEDIT';
        $detalles.=$sep.'{"id":'.$d->id.',"productos_id":'.$d->productos_id.',"producto":"'.$d->producto->nombre.'","cantidad":'.$d->cantidad.',"ancho":'.$d->ancho.
            ',"alto":'.$d->alto.',"fraccion":'.($d->fraccion?$d->fraccion:'0.00').',"inst":'.$d->inst.',"detalle":"'.$d->detalle.'","monto":'.$d->monto.',"estado":"'.$estado.'"}';
            $sep=',';

}
if(empty($model->descuento)) $model->descuento=0;
if(empty($model->impuesto)) $model->impuesto=0;
if(empty($model->pago)) $model->pago=0;
if(empty($model->saldo)) $model->saldo=1;
if(empty($model->estado)) $model->estado='ESPERA';
if(empty($model->prioridad)) $model->prioridad=0;//Normal

$detalles.=']';
$script.="var detalles=".$detalles;

$idApp=$model->app_idApp;
$this->registerJsFile(Yii::getAlias('@web').'/js/html2canvas.min.js',['position'=>View::POS_END] ,null);

$this->registerJsFile(Yii::getAlias('@web').'/js/app_api_pedido.js?v=0.002',['position'=>View::POS_END] ,null);


$script .= <<<JS
//----------------------------------


   $(document).ready(function() {
        listaProductos();
        listarDetalle();
        dibujarDetallesPedido()
        detalles=$detalles;
        idApp='$idApp';
        calcularMostrarTotalPedido();
    });
  
JS;


$this->registerJs($script, View::POS_END, 'my-options'); 


?>
<div class="pedido-form">
    <div class="row mx-5">
        <div class="col-md-12">
                    <?php $form = ActiveForm::begin(); ?>
            <div class="row" style="font-size:1.5em; background-color:rgba(255,255,255,0.5); border-style:solid; border-width:1px; border-radius:5px; border-color:var(--primary); padding:10px; margin:5px">
            
            <div class="col-md-2"> 
                <?= $form->field($model, 'id')->textInput(['disabled' => true]) ?>
            </div>

            <div class="col-md-4"> 
                <?= $form->field($model, 'fechaIni')->textInput(['type' => 'date','value'=>(new DateTime($model->fechaIni))->format('Y-m-d')]) ?>
            </div>
            <div class="col-md-4"> 
                <?= $form->field($model, 'fechaEntrega')->textInput(['type' => 'date','value'=>(new DateTime($model->fechaEntrega))->format('Y-m-d')]) ?>
                <?= $form->field($model, 'fechaFin')->textInput(['type' => 'hidden'])->label(false) ?>
            </div>
            <div class="col-xs-8 col-md-3"> 
                <?= $form->field($model, 'contacto_id')->dropDownList($clientes,  ['prompt'=>'Select...'])->label('Cliente'); ?>
                
            </div>   
            <div class="col-xs-4 col-md-2">  <button id="botCliente" class="btn btn-primary" data-toggle="modal" data-target="#ModalPedidos" type="button" onclick="seleccionarCliente()" style="margin-top: 35px;">Buscar Cliente</button></div>        


   

            <div class="col-md-2"> 
                <?= $form->field($model, 'delivery')->dropDownList(['0'=>'No','1'=>'Si'])->label('Flete'); ?>
                </div>
            <div class="col-md-12"> 
                <?= $form->field($model, 'comentarios')->textInput(['maxlength' => true]) ?>

                </div>
             <div id="detallesPedido" class="col-md-12" style="height:300px;overflow: overlay;">
             
             </div>   
             <hr> 
  

             <?php if($editable){?>
                <div class=" col-md-12 text-right ">
                    <button class="btn btn-primary"  type="button" onclick="seleccionarProducto()" style="font-size:1.5rem;" data-toggle="modal" data-target="#ModalPedidos">Nuevo detalle</button>
                </div>
            <?php }?>
            <div class="col-md-3"> 
                <?= $form->field($model, 'impuesto')->textInput(['maxlength' => true,'onchange'=>'calcularMostrarTotalPedido()'])->label('Recargo ($ / %)') ?>
                </div>
        
            <div class="col-md-3"> 
                <?= $form->field($model, 'descuento')->textInput(['maxlength' => true,'onchange'=>'calcularMostrarTotalPedido()'])->label('Descuento ($ / %)') ?>
                </div>    
            <div class="col-md-3"> 
                <?= $form->field($model, 'monto')->textInput(['maxlength' => true])->label('Monto $') ?>
                </div>
            <div class="col-md-3"> 
                 <?= $form->field($model, 'pago')->textInput(['maxlength' => true,'onchange'=>'calcularMostrarTotalPedido()'])->label('Pagos $') ?>
            </div>
            <div class="col-md-3"> 
                <?= $form->field($model, 'saldo')->textInput(['maxlength' => true,'disabled' => true])->label('Saldos $') ?>
            </div>  

            <div class="col-md-4"> 
                <?= $form->field($model, 'prioridad')->dropDownList($prioridades) ?>
            </div>

            <div class="col-md-4"> 
                <?= $form->field($model, 'estado')->dropDownList($estados,['disabled' => $editable ? false: true ]) ?>
            </div>

            </div>

            <div class="form-group">
                <?= Html::a('Cancelar', ['distribuidora/pedidos','id'=>$model->app_idApp], ['class' => 'btn btn-danger  mx-2','style' => 'font-size:1.5em;']) ?>
             
                <button class="btn btn-success" type="button" onclick="botEnviar(this,'distribuidora')" style="font-size:1.5em;">Aceptar</button>
              
            </div>

            <?php ActiveForm::end(); ?> 
            <button id="botImprimir" class="btn btn-primary" data-toggle="modal" data-target="#ModalPedidos" type="button" onclick="generarComprobante()" >Imprimir</button>
            
        </div>
    </div>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="ModalPedidos" tabindex="-1" role="dialog" aria-labelledby="ModalPedidosLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalPedidosLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="idModalPedido1" class="modal-body" style="padding: 0px 20px;">
                    ...
       </div>
      <div id="idModalPedido" class="modal-body">
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
