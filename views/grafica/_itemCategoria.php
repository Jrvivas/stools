<?php
use yii\helpers\Html;


$urlLogo=Yii::getAlias('@web').'/assets/imgs/categoria.png';
if (!empty($model->urlIcono)){
   $urlLogo=$model->urlLogo;
}
?>
<div class="row marcoItems" >
    <div class="col-sm-2">
      
           <img src="<?=$urlLogo?>"  alt="" class="imgIcon"> 

    </div>


    <div class="col-sm-10">
       <h4><?=$model->nombre?></h3>

    </div>
</div>