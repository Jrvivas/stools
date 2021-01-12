<?php

use app\views\controls\Img;
use yii\helpers\Html;

$nombreUser=Yii::$app->params['sesionApp']['userName'];
$urlLogo=Yii::getAlias('@web').'/assets/imgs/avatar.png';
if (!empty($model->urlLogo)){
   $urlLogo=$model->urlLogo;
}

if($model->cliente=='SI'){
    $colorFondo='#fdff75';
}else{
    $colorFondo='#ff8989';
}
?>
<div class="row "  style="background: white; padding: 5px; margin: 0px 0px 0px 5px; height: 100px; border-bottom: 1px solid grey;" onclick="botPedidoEditar(<?=$model->id?>)">
    <div class="col-md-1 col-xs-3">
    <?php  if($model->urlFoto!=null or $model->urlFoto!="") { ?>
        <img src="<?=$model->urlFoto?>" class="imgIcon" alt="" onclick="botContactoEditar(<?=$model->id?>)">
    <?php }else{ ?>
        <img src="<?=$urlLogo?>" class="imgIcon" alt="" onclick="botContactoEditar(<?=$model->id?>)">
    <?php } ?>
    </div>
    <div class="col-md-5  col-xs-2" style="height: 100%; border-left: 5px solid <?=$colorFondo?>;">
                <h4 class="truncate" style="margin: 1px 3px;"><strong><?=$model->nombre?></strong> (<?=$model->empresa?>)</h4>

                <div  style="overflow: auto;">
                 <h4><?php echo $model->direccion; ?>  <?php if($model->localidad!=null or $model->localidad!=""){
                     echo ' '.$model->localidad;
                 }?></h3>
            </div>          
    </div>
    <div class="col-md-4 col-xs-6">
            
            <div  style="overflow: auto;">
                 <h4>cel:<?=$model->cel?> <?php if($model->tel!=null or $model->tel!=""){
                     echo '| tel:'.$model->tel;
                 }
                 ?></h3>
            </div> 
    </div>

    <div class="col-md-2 col-sm-3">
        <button  type="button"  class="btn btn-secondary px-3" style="width:46px; height:46px" onclick="botProductoEditar(<?=$model->id?>)">
           <!-- <img src="assets/imgs/edit-2.svg"  alt="" style="width:32px; height:32px"> -->
            <img src="assets/icons/pencil.svg"  alt="" style="width:32px; height:32px"> 
        </button>
        <button  type="button"  class="btn btn-secondary px-3"  style="width:46px; height:46px" onclick="botProductoBorrar()">
             <img src="assets/icons/trash.svg"  alt="" style="width:32px; height:32px"> 
        </button>

    </div>  
</div>