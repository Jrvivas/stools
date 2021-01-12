<?php
use yii\helpers\Html;


$urlLogo=Yii::getAlias('@web').'/assets/imgs/vinilo_corte.jpg';
if (!empty($model->urlLogo)){
   $urlLogo=$model->urlLogo;
}
?>
<div class="row marcoItems" >
    <div class="col-sm-2">
      
           <img src="<?=$urlLogo?>"  alt="" class="imgIcon"> 


    </div>

    <div class="col-sm-7">

        <h2><?=$model->nombre?></h2>
        <p>Fecha de ultimo movimiento <?=$model->fecha?></p>
        
    </div>

    <div class="col-sm-3">
      <h2>Saldo:$<?=$model->saldo?></h2>
    </div>
</div>