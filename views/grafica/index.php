<?php

use yii\helpers\Html;
use yii\web\View;
$script="var idApp='".$model->idApp."';"; // Pasar el idApp para los menu
$script.= <<<JS

    $("#botClientes").click(function(){
        console.log('fafaf')
        window.location="http://graficasigma.com.ar/apps/web/index.php?r=grafica/clientes&id="+idApp;
    })
    $("#botPedidos").click(function(){
        window.location="http://graficasigma.com.ar/apps/web/index.php?r=grafica/pedidos&id="+idApp;
    })
     $("#botProductos").click(function(){
        window.location="http://graficasigma.com.ar/apps/web/index.php?r=grafica/productos&id="+idApp;
    })
   

JS;

$this->registerJs($script, View::POS_END, 'my-options'); 

?>
<div class="container p-2">
    <div class="row">
        <div class="col-md-2" style="margin-bottom: 50px;">
            <div class="botonRedondo" id="botPedidos">
                <img src="assets/icons/clipboard.svg" alt="Pedidos" >
                <h4 class="text-center">Pedidos</h4>
            </div>
            
        </div>
        <div class="col-md-2"  style="margin-bottom: 50px;">
            <div id="botClientes" class="botonRedondo" >
                <img src="assets/icons/people-fill.svg" alt="Clientes" >
                <h4 class="text-center">Clientes</h4>
            </div>
            
        </div>
        <div class="col-md-2"  style="margin-bottom: 50px;">
            <div class="botonRedondo" id="botProductos">
                <img src="assets/icons/box-seam.svg" alt="Productos" >
                <h4 class="text-center">Productos</h4>
            </div>
            
        </div>
    </div>

</div>
