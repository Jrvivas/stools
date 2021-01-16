<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Contacto;
use app\models\DetallePedido;
use app\models\Pedido;
use yii\grid\GridView; 
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\data\ActiveDataProvider;

use yii\helpers\URL;

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */

$idApp=$model->app_idApp;
// Hacemos la lista de Clientes
$contacto = Contacto::find()->where(['app_idApp' => $idApp, 'cliente' => 'SI'])->orderBy(['nombre' => SORT_DESC])->all();

$clientes=[];

foreach($contacto as $clt){
    $clientes[]=['id'=>$clt['id'],'nombre'=>$clt['nombre'],'empresa'=>$clt['empresa'],'cel'=>$clt['cel'],'localidad'=>$clt['localidad'],'tel'=>$clt['tel'],'cuit'=>$clt['cuit']];
}/**/


//Descripcion del pedido
$model->nombre = 'PEDIDO_' . date('Y-m-d');

//Lista de las prioridades
$prioridades = Pedido::listaPrioridades();

//Lista de Estados posibles
$estados = Pedido::listEstados();

//$idApp = $model->app_idApp;
$editable = $model->isEditable();

//TODO 
$listDetalle = new ActiveDataProvider([
    'query' =>DetallePedido::find()->where(['app_idApp'=>$idApp, 'pedido_id'=>$model->id]),
    'pagination' => [
        'pageSize' => 10,
    ],
]);


$cliente=$model->cliente;

$lblCliente='-Sin Cliente-';

if($cliente){
    $lblCliente=$cliente->nombre.'('.$cliente->empresa.')';
}

$script = "var clientes=" . json_encode($clientes).";";
$script.= "var pedido=".json_encode($model->toJson()).";";
//===================Registramos los script necesarios
$this->registerJs($script, View::POS_END, 'my-options'); 
/*Agregamos los modelos */
$this->registerJsFile(Yii::getAlias('@web').'/js/models/app_model_view.js',['position'=>View::POS_END] ,null);
/*Agregamos el escript que manejara los contactos  */
$this->registerJsFile(Yii::getAlias('@web').'/js/models/app_model_contacto.js',['position'=>View::POS_END] ,null);
/*Agregamos el escript que manejara pedido  */
$this->registerJsFile(Yii::getAlias('@web').'/js/models/app_model_pedido.js',['position'=>View::POS_END] ,null);
/*Agregamos el escript que manejara la pantalla  */
$this->registerJsFile(Yii::getAlias('@web').'/js/app_view_pedido.js',['position'=>View::POS_END] ,null);
?>


<div class="pedido-form">
    <div class="row mx-5">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(); ?>
           <!-- <div class="row " style="font-size:1.5em; background-color:rgba(255,255,255,0.5); border-style:solid; border-width:1px; border-radius:5px; border-color:var(--primary); padding:10px; margin:5px">-->
         <div class="row marcoItems" >

                

                 <div class="col-md-4">
                    <?= $form->field($model, 'estado')->dropDownList($estados, ['disabled' => $editable ? false : true,'style'=>'font-size: 1.2em;font-weight: bold;']) ?>
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
                     
                     <button id="botCliente" class="btn btn-primary" data-toggle="modal" data-target="#ModalPedidos" type="button" onclick="pantalla.handlerBuscarCliente()" style="margin-top: 15px;">Buscar Cliente</button>
                   
                  </div>


                <div class=" col-md-4">
                    <?= $form->field($model, 'delivery')->dropDownList(['0' => 'No', '1' => 'Si'])->label('Entrega a domicilio'); ?>
                </div>

                <div class="col-md-12">
                    <?= $form->field($model, 'comentarios')->textInput() ?>

                </div>
             

                <?=  GridView::widget([

                    'dataProvider' => $listDetalle,
                    'showFooter' => true,
                    'options'=>["style"=>""],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'cantidad',
                        'detalle',
                        'monto',
                        [   'class' => 'yii\grid\ActionColumn',
                            'template'=>'{update}{delete}',
                            'urlCreator' => function ($action, $model, $key, $index) {

                                if ($action === 'update') {
                                    $url=Url::to(['detalle-pedido/update','id'=>$model->id,'pedido_id'=>$model->pedido_id,'app_idApp'=>$model->app_idApp]);
                                    return $url;
                                }
                                if ($action === 'delete') {
                                    $url=Url::to(['detalle-pedido/delete','id'=>$model->id,'pedido_id'=>$model->pedido_id,'app_idApp'=>$model->app_idApp]);
                                    return $url;
                                }

                        
                            }
                        ],
                    ]
                                    ])
                ?>
                <!-- hasta aca modificando-->

                <hr>
                <?php if ($editable) { ?>
                    <div class=" col-md-12 text-right ">
                        <button class="btn btn-primary" type="button" onclick="pantalla.handlerNuevoDetalle()" style="font-size:1.5rem;" >Nuevo detalle</button>
                        <?= $form->field($model, 'accion')->hiddenInput()->label(false)?> 
                       
                    </div>
                <?php } ?>

                <div class="col-md-3">
                    <?= $form->field($model, 'impuesto')->textInput(['maxlength' => true, 'onchange' => 'pantalla.handlerChangeImpuesto()'])->label('Recargo ($ / %)') ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'descuento')->textInput(['maxlength' => true, 'onchange' => 'pantalla.handlerChangeDescuento()'])->label('Descuento ($ / %)') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'monto')->textInput(['maxlength' => true,'disabled' => true])->label('Monto $') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'costo')->textInput(['maxlength' => true,'disabled' => true])->label('Costo $') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'pago')->textInput(['maxlength' => true, 'onchange' => 'pantalla.handlerChangePago()'])->label('Pagos $') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'saldo')->textInput(['maxlength' => true, 'disabled' => true])->label('Saldos $') ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'prioridad')->dropDownList($prioridades) ?>
                </div>

            </div>

            <div class="form-group">
                <?= Html::a('Cancelar', ['pedido/index', 'idApp' => $model->app_idApp], ['class' => 'btn btn-danger  mx-2', 'style' => 'font-size:1.5em;']) ?>

                <?= Html::submitButton('Aceptar', ['class' => 'btn btn-success']) ?>

            </div>

            <?php ActiveForm::end(); ?>
            <button id="botImprimir" class="btn btn-primary" data-toggle="modal" data-target="#ModalPedidos" type="button" onclick="pantalla.handlerImprimir()">Imprimir</button>

        </div>
    </div>
    <!-- Button trigger modal -->


    <!-- Modal -->
    <?php  echo $this->render('/controls/_modalView', ['id'=>'ModalPedidos','title'=> Html::encode($this->title) ]); ?>

</div>
