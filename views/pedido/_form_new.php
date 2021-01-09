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

//use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */


// Hacemos la lista de Clientes
$contacto = Contacto::find()->where(['app_idApp' => $model->app_idApp, 'cliente' => 'SI'])->orderBy(['nombre' => SORT_DESC])->all();

$clientes=[];

foreach($contacto as $clt){
    $clientes[]=['id'=>$clt['id'],'nombre'=>$clt['nombre'],'empresa'=>$clt['empresa'],'cel'=>$clt['cel'],'localidad'=>$clt['localidad'],'tel'=>$clt['tel'],'cuit'=>$clt['cuit']];
}/**/

//Descripcion del pedido
$model->nombre = 'PEDIDO_' . date('Y-m-d');

//Lista de las prioridades
$prioridades = Pedido::listaPrioridades();

$estados = Pedido::listEstados();

$idApp = $model->app_idApp;
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

$script = "var clientes=" . json_encode($clientes);


//$this->registerJsFile(Yii::getAlias('@web').'/js/html2canvas.min.js',['position'=>View::POS_END] ,null);

//$this->registerJsFile('https://unpkg.com/react@16/umd/react.development.js', ['position' => View::POS_END], null);//Agregamos React
//$this->registerJsFile('https://unpkg.com/react-dom@16/umd/react-dom.development.js', ['position' => View::POS_END], null);//Agregamos React
//$this->registerJsFile('https://unpkg.com/babel-standalone@6/babel.min.js', ['position' => View::POS_END], null);//Agregamos React


//$this->registerJsFile(Yii::getAlias('@web') . '/js/app_api_pedido.js?v=0.004', ['position' => View::POS_END], null);
$this->registerJsFile(Yii::getAlias('@web') . '/js/app_widget.js?v=0.001', ['position' => View::POS_END], null);


$script .= <<<JS
//----------------------------------
 function seleccionarCliente(){
 
    let htmltext=`<div class="row">
                        <div class="col-md-12 mt-5 ">
                            <div class="row marco_app" style="height: 500px; overflow: overlay;">
                                <h2 class="text-center">Clientes</h2>
                                <div> Buscar <input  class="form-control" type="text" onkeyup="dibujarCliente(clientes,this.value)"/>
                                <ul  class="list-group "  style="    margin-top: 10px;" id="lista_clientes">
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>`
             $("#idModalPedido").show();
             $("#idModalPedido").html(htmltext);                 
             $("#ModalPedidosLabel").html('Lista de Clientes'); 
             dibujarCliente(clientes,'')
 }
  
 /**
  * Listar los Clientes
  */
  function dibujarCliente(ctes,filtro){
          let idBot="";
          if(clientes){

            $("#lista_clientes").html('');
            let index=1;
            idBot="";
            filtro=filtro.toUpperCase()
            let ClteFiltrado=clientes.filter(function(cte){
                return cte.nombre.toUpperCase().indexOf(filtro)>-1||cte.empresa.toUpperCase().indexOf(filtro)>-1||cte.cel.toUpperCase().indexOf(filtro)>-1||cte.tel.toUpperCase().indexOf(filtro)>-1||cte.localidad.toUpperCase().indexOf(filtro)>-1||cte.cuit.toUpperCase().indexOf(filtro)>-1
            })

            for(clte of ClteFiltrado){
                let idBot="cliete_"+clte.id;
                //$("#lista_Productos").append( "<button id=\""+idBot+"\" type=\"button\" class=\"btn btn-primary \" style=\"margin: 5px;\"  data-toggle=\"modal\" data-target=\"#ModalPedidos\">"+prto.nombre+"</button>");
                $("#lista_clientes").append( '<li id="'+idBot+'" class="list-group-item list-group-item-success" data-toggle="modal" data-target="#ModalPedidos">'+clte.nombre+'('+clte.empresa+')-'+clte.localidad+'</li>')
                 
                
                $("#"+idBot).click(function(){
                    //alert('Dibujar el dialogo para '+prto.nombre+ ' id:'+prto.id)
                    selectCliente(this.id)
                })
            }
          }
    }
/**
 * Manejo de la Seleccion del cliente
 */
    function selectCliente(idboton){
        clienteSel=clientes.filter(function(cte){return cte.id==idboton.split('_')[1]});
        $("#pedido-contacto_id").val(idboton.split('_')[1])

        $("#dataCliente").html(clienteSel[0].nombre+'('+clienteSel[0].empresa+')')
    }

    function nuevoDetalle(){
    
        $("#pedido-accion").val('newDetalle')

        $("#w1").submit()
    }







window.onload=function() {
       // listaProductos();
       // listarDetalle();

       // dibujarDetallesPedido()
       // _setDetalles(detalles);
       //  calcularMostrarTotalPedido();

        
    };
  
JS;
$this->registerJs($script, View::POS_BEGIN, 'my-options');
//$this->registerJsFile(Yii::getAlias('@web') . '/js/models/app_model_pedido.js?v=0.005', ['depends' => [yii\web\YiiAsset::className()],'position' => View::POS_END], null);//Agregamos React
//$this->registerJsFile(Yii::getAlias('@web') . '/js/components/app_new_detalle_pedido.js?v=0.009', ['type'=>'text/babel','position' => View::POS_END], null);//Agregamos React
//$this->registerJsFile(Yii::getAlias('@web') . '/js/components/app_new_detalle_pedido_opt.js?v=0.000', ['depends' => [yii\web\YiiAsset::className()],'position' => View::POS_END], null);//Agregamos React

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
                        <button class="btn btn-primary" type="button" onclick="nuevoDetalle()" style="font-size:1.5rem;" >Nuevo detalle</button>
                        <?= $form->field($model, 'accion')->hiddenInput()->label(false)?> 
                       
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