<?php

use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */

$this->title = 'Nuevo Pedido';
/*Agregamos los modelos */
$this->registerJsFile(Yii::getAlias('@web').'/js/models/app_model_view.js',['position'=>View::POS_END] ,null);
/*Agregamos el escript que manejara los contactos  */
$this->registerJsFile(Yii::getAlias('@web').'/js/models/app_model_producto.js',['position'=>View::POS_END] ,null);
/*Agregamos el escript que manejara los contactos  */
$this->registerJsFile(Yii::getAlias('@web').'/js/models/app_model_contacto.js',['position'=>View::POS_END] ,null);
/*Agregamos el escript que manejara pedido  */
$this->registerJsFile(Yii::getAlias('@web').'/js/models/app_model_pedido.js',['position'=>View::POS_END] ,null);
/*Agregamos el escript que manejara la pantalla  */
$this->registerJsFile(Yii::getAlias('@web').'/js/app_view_create_pedido.js',['position'=>View::POS_END,'depends' => [yii\web\JqueryAsset::className()]] ,null);

?>
<div  id='app-contenedor' class="pedido-create">

</div>
    <!--  Panel de nuevo pedido -->

<div id='pag-presupuesto'>
    <!--  BUscar cliente -->
    <div class="row mt-3">
        <div class="col-2 col-xs-1"></div>
        <div class="col-8 col-xs-10">
            <button id="bot-ped-cliente" class="btn boton-primary" style="height:50px; width:100%" data-toggle="collapse" data-target="#ped-cliente" >
            <img src="assets/imgs/cliente_buscar.svg" alt="Cliente" style="width: 42px ;float: left;"/>
                <h4>Buscar Cliente</h4>
            </button>

            <div id="ped-cliente" class="collapse">
            <!-- Contenido-->
                    <div class="row">
                        <div class="col-md-12 mt-3 ">
                            <div class="row marco_app" style="height: 300px; overflow: overlay;">
                                <div>  <img src="assets/imgs/cliente_buscar.svg" alt="Cliente" style="width: 42px ;float: left; background: var(--app-ctr-bg-color); border-radius: 10px; padding: 5px;margin-right: 10px;"/> 
                                <input  id="textBuscarCliente" class="" placeholder="Buscar cliente" type="text"  style="width: 70% " />
                                    <ul  class="list-group "  style=" margin-top: 10px;" id="list-cliente">
                                        <li>cargando...</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
              <!---->      
            </div>
        </div>
        <div class="col-2 col-xs-1"></div>
    </div>

<!--  Buscar cargar carrito  -->
    <div class="row mt-3">
        <div class="col-2 col-xs-1"></div>
        <div class="col-8 col-xs-10">
            <button id="bot-ped-carrito"  class="btn boton-primary" style="height:50px; width:100%" data-toggle="collapse" data-target="#ped-carrito">
            <img src="assets/imgs/carrito_cantidad.svg" alt="Cliente" style="width: 42px ;float: left;"/>
            <span class="carrito-cantidad">0</span>
                <h4>Carrito</h4>
            </button>

            <div id="ped-carrito" class="collapse">
             <!-- Contenido-->
             <div class="row">
                        <div class="col-md-12 mt-3 ">
                            <div class="row marco_app" style="height: 300px; overflow: overlay;">
                                    <ul  class="list-group "  style=" margin-top: 10px;" id="list-detalle">
                                        <li>cargando...</li>
                                    </ul>
                               
                            </div>
                        </div>
                    </div>
             <!-- -->   
            </div>
        </div>
        <div class="col-2 col-xs-1"></div>
    </div>

<!-- Detalles extras  -->
    <div class="row mt-3">
        <div class="col-2 col-xs-1"></div>
        <div class="col-8 col-xs-10">
            <button id="bot-ped-extra" class="btn boton-primary" style="height:50px; width:100%" data-toggle="collapse" data-target="#ped-extra">
            <img src="assets/imgs/extra-tiempo.svg" alt="Cliente" style="width: 42px ;float: left;"/>
                <h4 class="truncate">Fecha de entrega, comentarios</h4>
            </button>

            <div id="ped-extra" class="collapse">
                 <!-- Contenido-->
                <input type="text">
                <ul class="list-unstyled">
                    <li>Text</li>
                </ul>
                <!-- -->
            </div>
        </div>
        <div class="col-2 col-xs-1"></div>
    </div>


<!-- Monto descuentos costos  -->
    <div class="row mt-3">
        <div class="col-2 col-xs-1"></div>
        <div class="col-8 col-xs-10">
            <button id="bot-ped-resumen" class="btn boton-primary" style="height:50px; width:100%" data-toggle="collapse" data-target="#ped-resumen">
            <img src="assets/imgs/resumen-tiket.svg" alt="Cliente" style="width: 30px ;float: left;"/>
            <span class="resumen-monto">$30000</span>
                <h4>Monto</h4>
            </button>

            <div id="ped-resumen" class="collapse">
                 <!-- Contenido-->
              
                <!-- -->
            </div>
        </div>
        <div class="col-2 col-xs-1"></div>
    </div>

<!-- Botones -->
    <div id="botonera">
       <button id="boton_cancelar" class="boton-float " style="left: 10%; background: red; ">
             <img src="assets/imgs/icon-cancel.svg" alt="X" style="width: 42px"/>
       </button>
       <button id="boton_descargar" class="boton-float " style="left:40%; right:40%; background: var(--app-ctr-bg-color);">
             <img src="assets/imgs/icon-dowload.svg" alt="D" style="width: 42px;   "/>
       </button>
       <button id="boton_aceptar"  class="boton-float"  style="right: 10%; background: green; ">
             <img src="assets/imgs/icon-aceptar.svg" alt="V" style="width: 42px"/>
       </button>
    </div>

</div>

<div id="pag_new_detalle">
    <!--  Buscar cargar carrito  -->
    <div class="row mt-3">
        <div class="col-2 col-xs-1"></div>
        <div class="col-8 col-xs-10">
            <button id="bot-ped-detalle"  class="btn boton-primary" style="height:50px; width:100%" data-toggle="collapse" data-target="#ped-producto">
            <img src="assets/imgs/carrito_cantidad.svg" alt="Cliente" style="width: 42px ;float: left;"/>
                 <h4>Producto</h4>
            </button>

            <div id="ped-producto" class="collapse">
             <!-- Contenido-->
             <div class="row">
                        <div class="col-md-12 mt-3 ">
                            <div class="row marco_app" style="height: 300px; overflow: overlay;">
                                <div>  <img src="assets/imgs/producto_buscar.svg" alt="producto" style="width: 42px ;float: left; background: var(--app-ctr-bg-color); border-radius: 10px; padding: 5px;margin-right: 10px;"/> 
                                <input  id="textBuscarProducto" class="" placeholder="Buscar Producto" type="text"  style="width: 70% " />
                                    <ul  class="list-group "  style=" margin-top: 10px;" id="list-producto">
                                        <li>cargando...</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
             <!-- -->   
            </div>
        </div>
        <div class="col-2 col-xs-1"></div>
    </div>
        <!--  carrito  -->
    <div class="row mt-3">
        <div class="col-2 col-xs-1"></div>
        <div class="col-8 col-xs-10">
            <button id="bot-ped-carrito"  class="btn boton-primary" style="height:50px; width:100%" data-toggle="collapse" data-target="#ped-carrito">
            <img src="assets/imgs/carrito_cantidad.svg" alt="Cliente" style="width: 42px ;float: left;"/>
            <span class="carrito-cantidad">0</span>
                <h4>Carrito</h4>
            </button>

            <div id="ped-carrito" class="collapse">
             <!-- Contenido-->
                <div class="row">
                    <div class="col-md-12 mt-3 ">
                        <div class="row marco_app" style="height: 300px; overflow: overlay;">
                                <ul  class="list-group "  style=" margin-top: 10px;" id="list-detalle">
                                    <li>cargando...</li>
                                </ul>
                        </div>
                    </div>
                </div>
             <!-- -->   
            </div>
        </div>
        <div class="col-2 col-xs-1"></div>
    </div>
    
    <!-- Botones -->
    <div id="botonera">
        <button id="boton_cancelar_detalle" class="boton-float " style="left: 10%; background: red; ">
                <img src="assets/imgs/icon-cancel.svg" alt="X" style="width: 42px"/>
        </button>
        <button id="boton_aceptar_add" class="boton-float " style="left:40%; right:40%; background: var(--app-ctr-bg-color);">
                <img src="assets/imgs/icon-dowload.svg" alt="D" style="width: 42px;   "/>
        </button>
        <button id="boton_aceptar_detalle"  class="boton-float"  style="right: 10%; background: green; ">
                <img src="assets/imgs/icon-aceptar.svg" alt="V" style="width: 42px"/>
        </button>
        </div>



</div>