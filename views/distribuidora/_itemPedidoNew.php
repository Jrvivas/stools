<?php
use yii\helpers\Html;


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





$colorAlertaEntrega='';
if($model->diasEntrega()<0){
    $colorAlertaEntrega=' background:red';
}
?>
<div class="row marcoItems"  style="background:<?=$colorFondo?>;" onclick="botPedidoEditar(<?=$model->id?>)">

    <div  class="col-xs-4 col-sm-2" style="min-width: 60px;">
      
           <img src="<?=$urlLogo?>"  alt="" class="imgIcon"> 
           <?php if(strlen ( $model->cliente->cel)>9){?>

             <a href="https://wa.me/54<?=str_replace('-','',str_replace(' ','',trim($model->cliente->cel)))?>"  target="_blank" onclick="clickCel=true;"> <img src="<?=$urlWathsapp?>"  alt="whatsapp" style="width:32px; height:32px; padding: 3px;position: absolute; z-index: 1000; ">  </a>
           <?php } ?>
    </div>

    <div class="col-xs-8 col-sm-4">


                <div class="tituloList"><strong><?=$model->cliente->nombre?></strong><i>(<?=$model->cliente->empresa?>)</i></div>
                <div class="subtituloList"><?=$model->nombre.'('.$model->comentarios.')'?></div>

        
    </div>

    <div  class="col-xs-4 col-sm-3" style="min-width: 60px;">
        <?php
        if($model->estado!='ENTREGADO'){
        ?>
        <div class="comentariosList"> <img src="assets/icons/box-arrow-in-right.svg"  alt="" style="width:24px; height:24px; padding: 3px; "> <?=$model->diasInicio().'d - <img src="assets/icons/clock.svg"  alt="" style="width:24px; height:24px; padding: 3px; '.$colorAlertaEntrega.'">'.$model->diasEntrega().'d'?></div>
        <?php }?>
        <div style="border-radius:5px;background-color: #ffffff7a; padding: 1px 2px 1px 5px;">
           <span style="font-size:1rem"><?=$model->estado?></span><img src="<?=$urlEstado?>"  alt="" style="width:24px; height:24px; padding: 3px;">
        </div>
    </div>

    <div  class="col-xs-8 col-sm-3" style="min-width: 60px;">

                <h3 style="text-align: end;margin: 1px">$<?=$model->monto?></h3>
               <h5 style="text-align: end">Saldo:$<?=$model->saldo?></h5>
               <p style="font-size:1.2rem">Responsable:<strong><?=$model->responsable->nombre?$model->responsable->nombre:$model->responsable->username?></strong></p>
    </div>
</div>