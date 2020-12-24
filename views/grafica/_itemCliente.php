<?php
use yii\helpers\Html;


$urlLogo=Yii::getAlias('@web').'/assets/imgs/avatar.png';
if (!empty($model->urlLogo)){
   $urlLogo=$model->urlLogo;
}
?>
<div class="row marcoItems" >
    <div class="col-sm-2">
      
           <img src="<?=$urlLogo?>"  alt="" class="imgIcon"> 


    </div>


    <div class="col-sm-7">
        <div class="row">
            <div class="col-sm-2">

            </div>
            <div class="col-sm-6">
                 <h2><?=$model->nombre?></h2>
                 <p  style="font-size:1.5rem"><?=$model->empresa?></p>
            </div>
            <div class="col-sm-4">
                 <h4> <img src="assets/icons/phone.svg"  alt="Cel:" style="width:54px; height:54px"> <?=$model->cel?></h4>
                 <h4><img src="assets/icons/phone-old.svg"  alt="Tel:" style="width:54px; height:54px"><?=$model->tel?></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <p><?=$model->direccion.' - '.$model->localidad?></p>
            </div>
        </div>
        
        
        
    </div>
    <div class="col-sm-3">


        <button  type="button"  class="btn btn-secondary px-3" style="width:46px; height:46px" onclick="botClienteEditar(<?=$model->id?>)">
           <!-- <img src="assets/imgs/edit-2.svg"  alt="" style="width:32px; height:32px"> -->
            <img src="assets/icons/pencil.svg"  alt="" style="width:32px; height:32px"> 
        </button>
        <button  type="button"  class="btn btn-secondary px-3"  style="width:46px; height:46px" onclick="botClienteBorrar()">
             <img src="assets/icons/trash.svg"  alt="" style="width:32px; height:32px"> 
        </button>

    </div>
</div>