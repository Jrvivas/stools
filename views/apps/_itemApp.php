<?php

use yii\helpers\Html;
use yii\web\View ;

$urlLogo = Yii::getAlias('@web') . '/assets/imgs/logo.png';
$urlApp = \Yii::$app->urlManager->createUrl(['/apps/view', 'id' => $model->idApp]);
/*
if ($model->codigoApp == 'GRAFICA') {
   $urlLogo = Yii::getAlias('@web') . '/assets/imgs/bot_graphic.png';
   $urlApp = \Yii::$app->urlManager->createUrl(['/grafica/index', 'id' => $model->idApp]);
}
if ($model->codigoApp == 'DISTRIBUIDORA') {
   $urlLogo = Yii::getAlias('@web') . '/assets/apps/' . $model->idApp . '/logo_124.png';
   $urlApp = \Yii::$app->urlManager->createUrl(['/distribuidora/index', 'id' => $model->idApp]);
}
*/
if (!empty($model->urlLogo)) {
   $urlLogo = Yii::getAlias('@web') . '/assets/apps/' . $model->idApp . '/imgs/logo_94.png';
}
$urlUpdate= \Yii::$app->urlManager->createUrl(['config/index','idApp'=>$model->idApp]);
$script=<<<JS
 $(document).ready(function() {
    $('#botConf').click(function(e) {
      window.location.href ="$urlUpdate";
      e.stopPropagation();
    });
});
    
JS;
$this->registerJs($script, View::POS_END, 'my-options'); 



/*
<div class="col-sm-3">
 <div class="text-center">
    <?=Html::button( '<img src="'.$urlLogo.'" alt="" style="width:94px; height:94px;"> <p>'.$model->nombre.'</p>', ['class' => 'appBotonIni', 'onclick'=>"window.location.href = '" .$urlApp . "';",])?>
 
 </div>
</div>
*/


/*
Este item representa a la aplicación y desde aquí podrá acceder ella
*/
?>

<div class="col-lg-3 col-md-3 " onclick="window.location.href ='<?= $urlApp ?>';" style=" border: solid 2px var(--app-ctr-bg-color); border-radius: 10px; padding:5px; margin: 10px;text-align: center">

   <img class="img-fluid d-block imgIconGrande" src="<?= $urlLogo ?>" width="94" alt="<?= $model->nombre ?>">
   <h4> <b><?= $model->nombre ?></b> </h4>
   <p><?= $model->codigoApp ?></p>
   <div class="row">
      <div class="col-md-6"> <i>"-"</i></div>
      <div class="col-md-6"> 
      
      <?= Html::button('<img src="assets/icons/gear.svg" alt="config" width="42px" title="Abre el panel de configuración"/>',
       ['id'=>'botConf','class' => 'btn btn-primary','style'=>"float:right; margin:5px", ])?>
   
       </div>
   
    </div>
</div>