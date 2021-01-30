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
        <?= Html::a('<img src="'.$model->urlFoto.'"  alt="" class="imgIcon"> ', ['update', 'id' => $model->id, 'app_idApp' => $model->app_idApp]) ?>
        <!--<img src="<?=$model->urlFoto?>" class="imgIcon" alt="" > -->
        
    <?php }else{ ?>
        <?= Html::a('<img src="'.$urlLogo.'"  alt="" class="imgIcon"> ', ['update', 'id' => $model->id, 'app_idApp' => $model->app_idApp]) ?>
        <!--<img src="<?=$urlLogo?>" class="imgIcon" alt="" > -->
    <?php } ?>
    </div>
    <div class="col-md-5  col-xs-2" style="height: 100%; border-left: 5px solid <?=$colorFondo?>;">
                <h4 class="truncate" style="margin: 1px 3px;"><strong><?=$model->nombre?></strong> (<?=$model->empresa?>)</h4>

                        
    </div>
    <div class="col-md-4 col-xs-6">
            
            <div style="overflow: auto; display:inline-block;">
                 <?php if($model->cel!=null or $model->cel!=""){
                    echo '<a href="https://api.whatsapp.com/send?phone=+549'.$model->cel.'&text=hola,%20qué%20tal?" target="_blank"> <img src="assets/imgs/whatsapp.png"  alt="" style="width:45px; height:45px"> </a>';
                 }
                 ?>
            </div> 
            <div  style="overflow: auto; display:inline-block;">
                 <?php 
                    if($model->direccion!=null or $model->direccion!=""){
                        echo '<a href="http://maps.google.com/?q='.$model->direccion.'" target="_blank"> <img src="assets/imgs/icon_dir.png"  alt="" style="width:45px; height:45px"> </a>';
                    }
                 ?>
                    <!--<h4><?php echo $model->direccion; ?>  <?php if($model->localidad!=null or $model->localidad!=""){
                        echo ' '.$model->localidad;
                    }?></h3>-->
            </div>
            <div style="overflow: auto; display:inline-block;">
                 <?php if($model->cel!=null or $model->cel!=""){
                    echo '<a href="tel:'.$model->cel.'" target="_blank"> <img src="assets/imgs/icon_call.png"  alt="" style="width:45px; height:45px"> </a>';
                 }
                 ?>
            </div> 
            <div style="overflow: auto; display:inline-block;">
                 <?php if($model->email!=null or $model->email!=""){
                    echo '<a href="mailto:'.$model->email.'" target="_blank"> <img src="assets/imgs/icon_email.png"  alt="" style="width:45px; height:45px"> </a>';
                 }
                 ?>
            </div>   
    </div>

    <div class="col-md-1 col-sm-2">
        
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