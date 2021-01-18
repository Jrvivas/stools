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
        <img src="<?=$model->urlFoto?>" class="imgIcon" alt="" >
    <?php }else{ ?>
        <img src="<?=$urlLogo?>" class="imgIcon" alt="" >
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
                 <?php if($model->cel!=null or $model->cel!=""){
                    echo '<a href="https://api.whatsapp.com/send?phone=+549'.$model->cel.'&text=hola,%20qué%20tal?" target="_blank"> <img src="assets/icons/whatsapp.svg"  alt="" style="width:32px; height:32px"> </a>';
                 }
                 ?>
            </div> 
    </div>

    <div class="col-md-2 col-sm-3">
        
        <!--<?= Html::a('<img src="assets/icons/pencil.svg"  alt="" style="width:32px; height:32px"> ', ['update', 'id' => $model->id, 'app_idApp' => $model->app_idApp], ['class' => 'btn btn-primary']) ?>-->
        <?= Html::a('<img src="assets/icons/trash.svg"  alt="" style="width:32px; height:32px"> ', ['delete', 'id' => $model->id, 'app_idApp' => $model->app_idApp], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro que desea borrar este Contacto?',
                'method' => 'post',
            ],
        ]) ?>
        

    </div>  
</div>