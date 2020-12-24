<?php

use yii\helpers\Html;
use yii\web\View;
use app\models\User;

/*$this->registerCssFile("@web/assets/apps/".$model->idApp."/css/site.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    'media' => '',
], 'css-print-theme');*/

$admin_roles = [User::ROLE_ADMIN, User::ROLE_SUPERUSER];
$responsable_roles = [User::ROLE_RESPONSABLE];

$script="var idApp='".$model->idApp."';"; // Pasar el idApp para los menu
$script.= <<<JS

    $("#botClientes").click(function(){
        console.log('fafaf')
        window.location="http://graficasigma.com.ar/apps/web/index.php?r=distribuidora/clientes&id="+idApp;
    })
    $("#botPedidos").click(function(){
        window.location="http://graficasigma.com.ar/apps/web/index.php?r=distribuidora/pedidos&id="+idApp;
    })
     $("#botProductos").click(function(){
        window.location="http://graficasigma.com.ar/apps/web/index.php?r=distribuidora/productos&id="+idApp;
    })
   

JS;

$this->registerJs($script, View::POS_END, 'my-options'); 

?>
<?= Html::cssFile("@web/assets/apps/".$model->idApp."/css/site.css") ?>

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
    </div>
        <?php
        if(in_array(User::getRole($model->idApp), $admin_roles)){
            echo '

        <div class="col-md-2"  style="margin-bottom: 50px;">
            <div class="botonRedondo" id="botProductos">
                <img src="assets/icons/box-seam.svg" alt="Productos" >
                <h4 class="text-center">Productos</h4>
            </div>
            
        </div>
    </div>';
        }
        ?>
         <?php
        if(in_array(User::getRole($model->idApp), $responsable_roles)){
            echo '
       
        </div>';
        }
        ?>

</div>
