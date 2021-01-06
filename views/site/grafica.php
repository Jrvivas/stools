<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Inicio';
$url = Yii::getAlias("@web");
//Url::toRoute('site/index');
//$this->params['breadcrumbs'][] = $this->title;
$herramientas=[['nombre'=>'Productos','icono'=>'assets/imgs/bot_producto.svg','url'=>'grafica/productos'],
['nombre'=>'Clientes','icono'=>'assets/imgs/bot_cliente.svg','url'=>'grafica/clientes'],
['nombre'=>'Pedidos','icono'=>'assets/imgs/bot_pedido.svg','url'=>'grafica/pedidos']];



?>
<h1 class="text-center text-white">Gráfica</h1>
<div class="container scrool" style="height: 60vh;">
<div class="row mt-3  "> 
    
        <?php 
            foreach ($herramientas as &$herr) {
                echo '<div class="col-sm-3">';
                   echo ' <div class="text-center">';
                    echo  Html::button( '<img src="'.$herr['icono'].'" alt="" width="94px" height=94px> <p>'.$herr['nombre'].'</p>', ['class' => 'appBotonIni']);
                    echo '</div>';
                 echo '</div>';
            }
        
        ?>

</div>
</div>