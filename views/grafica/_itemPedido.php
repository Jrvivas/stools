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
<div class="row marcoItems"  style="background:<?=$colorFondo?>;">
    <div class="col-xs-3 col-sm-2">
      
           <img src="<?=$urlLogo?>"  alt="" class="imgIcon"> 
           <?php if(strlen ( $model->cliente->cel)>9){?>

             <a href="https://wa.me/54<?=str_replace('-','',str_replace(' ','',trim($model->cliente->cel)))?>"  target="_blank"> <img src="<?=$urlWathsapp?>"  alt="whatsapp" style="width:50px; height:50px; padding: 3px; ">  </a>
           <?php } ?>
          
           

    </div>

    <div class="col-xs-7 col-sm-9">

        <div class="row">
            <div class="col-sm-1">
              
            </div>
            <div class="col-sm-7">
                <div class="tituloList"><strong><?=$model->cliente->nombre?></strong><i>(<?=$model->cliente->empresa?>)</i></div>
                <div class="subtituloList"><?=$model->nombre.'('.$model->comentarios.')'?></div>
                <?php
                if($model->estado!='ENTREGADO'){
                ?>
                <div class="comentariosList"> <img src="assets/icons/box-arrow-in-right.svg"  alt="" style="width:24px; height:24px; padding: 3px; "> <?=$model->diasInicio().'d - <img src="assets/icons/clock.svg"  alt="" style="width:24px; height:24px; padding: 3px; '.$colorAlertaEntrega.'">'.$model->diasEntrega().'d'?></div>
                <?php }?>

                
            </div>
            <div class="col-sm-4">
               <h3>$<?=$model->monto?></h3>
               <h5>Saldo:$<?=$model->saldo?></h5>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                
            <span style="font-size:1rem"><?=$model->estado?></span><img src="<?=$urlEstado?>"  alt="" style="width:24px; height:24px; padding: 3px;">
            </div>
        </div>
        
        
        
    </div>
    <div class=" col-xs-2 col-sm-1">


        <button  type="button"  class="btn btn-secondary px-3" style="width:46px; height:46px" onclick="botPedidoEditar(<?=$model->id?>)">
           <!-- <img src="assets/imgs/edit-2.svg"  alt="" style="width:32px; height:32px"> -->
            <img src="assets/icons/pencil.svg"  alt="" style="width:32px; height:32px"> 
        </button>
        <button  type="button"  class="btn btn-secondary px-3"  style="width:46px; height:46px" onclick="botPedidoBorrar(<?=$model->id?>)">
             <img src="assets/icons/trash.svg"  alt="" style="width:32px; height:32px"> 
        </button>

    </div>
</div>