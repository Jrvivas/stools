<?php

use app\models\Pedido;
use yii\helpers\Html;
use app\views\controls\Img;


$urlLogo=Yii::getAlias('@web').'/assets/imgs/avatar.png';

$urlWathsapp=Yii::getAlias('@web').'/assets/imgs/whatsapp.png';

if (!empty($model->urlLogo)){
   $urlLogo=$model->urlLogo;
}

$urlEstado='assets/icons/box-arrow-in-right.svg';
switch($model->estado){
    case "ESPERA":
         $urlEstado='assets/icons/hourglass.svg';
    break;
    case "DISENIO":
        $urlEstado='assets/icons/brush.svg';
    break;
    case "PRESUPUESTO":
        $urlEstado='assets/icons/card-checklist.svg';
    break;
    case "ELABORACION":
        $urlEstado='assets/icons/gear.svg';
    break;
    case "RETRASADO":
        $urlEstado='assets/icons/alarm-fill.svg';
    break;
    case "TERMINADO":
        $urlEstado='assets/icons/check2-square.svg';
    break;
     case "ENTREGADO":
        $urlEstado='assets/icons/box-arrow-right.svg';
    break;
    
}
$colorFondo='#FFFFFF';
switch($model->prioridad){
    case 0:
        $colorFondo='#FFFFFF';
    break;
    case 2:
        $colorFondo='#f9eddd';
    break;
    case 4:
        $colorFondo='#fdff75';
    break;

    case 8:
        $colorFondo='#ffb575';
    break;

    case 10:
            $colorFondo='#ff8989';
        break;
    
}



$nombreUser=Yii::$app->params['sesionApp']['userName'];

$colorAlertaEntrega='';

$viewFecha=Img::icon_fecha('grey');

if($model->diasEntrega()<0){
    if($model->diasEntrega()!=Pedido::$_FECHA_NO_NECESARIA){
        $viewFecha=$model->diasEntrega(). ' días&nbsp;'.Img::icon_fecha('red'); 
    }
     
}else{
     $viewFecha=$model->diasEntrega(). ' días&nbsp;'.Img::icon_fecha('green'); 
}



?>
<div class="row "  style="background: white; padding: 5px; margin: 0px 0px 0px 5px; height: 100px; border-bottom: 1px solid grey;" onclick="botPedidoEditar(<?=$model->id?>)">
    <div class="col-md-1 col-xs-3">
            <img src="<?=$urlLogo?>" class="imgIcon" alt="">
    </div>
    <div class="col-md-11  col-xs-9" style="height: 100%; border-left: 5px solid <?=$colorFondo?>;">
                <h5 class="truncate" style="margin: 1px 3px;"><strong><?=$model->cliente->nombre?></strong> (<?=$model->cliente->empresa?>)</h5>
                <p class="truncate" style="margin: 1px 3px;"><?=$model->comentarios?> </p>
                <span><img src="<?=$urlEstado?>" alt="" style="width: 16px;"></span><span style="float: right; margin: 2px 5px;"><?=Img::icon_dinero('red')?></span>
                <span style="float: right; font-size: 1.2em; color: black;">$<?=$model->saldo?></span>

                <div class="truncate">
                    <span class="truncate">
                         <?=Img::icon_user()?>&nbsp;<?=$nombreUser?>
                    </span>
                    <span style="float: right;"><?=$viewFecha?></span>
                </div>
    </div>
</div>