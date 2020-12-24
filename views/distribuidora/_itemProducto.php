<?php
use yii\helpers\Html;


$urlLogo=Yii::getAlias('@web').'/assets/imgs/dist_productos.jpg';
if (!empty($model->urlLogo)){
   $urlLogo=$model->urlLogo;
}
$unidades=['UN'=>'Unidad','CJ'=>'Caja','PL'=>'Pallet'];

?>
<div class="row marcoItems" >
    <div class=" col-xs-3 col-sm-2">
      
           <img src="<?=$urlLogo?>"  alt="" class="imgIcon"> 


    </div>


    <div class="col-xs-6 col-sm-7">
        <div class="row">
            <div class="col-sm-3">
               <span style="display:inline"> <img src="assets/icons/upc-scan.svg"  alt="" style="width:32px; height:32px; margin:0px; padding:0px 2px 2px 2px;">  </span>
                <h2  style="display:inline"><?=$model->codigo?></h1>
            </div>
            <div class="col-sm-6">
                 <h4><?=$model->nombre?></h3>
            </div>
            <div class="col-sm-3">
                 <h2>$<?=$model->precio?></h3>
                 <h5>Stock: <?=$model->stock->cantidad?$model->stock->cantidad:'-'?> unidades</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <p><?=$model->descripcion?></p>
            </div>
        </div>
        
        
        
    </div>
    <div class="col-xs-3 col-sm-3">
        <button  type="button"  class="btn btn-secondary px-3"  style="width:46px; height:46px" onclick="botProductoCalculoRapido()">
              <img src="assets/icons/file-spreadsheet.svg"  alt="" style="width:32px; height:32px"> 
        </button>

        <button  type="button"  class="btn btn-secondary px-3" style="width:46px; height:46px" onclick="botProductoEditar(<?=$model->id?>)">
           <!-- <img src="assets/imgs/edit-2.svg"  alt="" style="width:32px; height:32px"> -->
            <img src="assets/icons/pencil.svg"  alt="" style="width:32px; height:32px"> 
        </button>
        <button  type="button"  class="btn btn-secondary px-3"  style="width:46px; height:46px" onclick="botProductoBorrar()">
             <img src="assets/icons/trash.svg"  alt="" style="width:32px; height:32px"> 
        </button>

    </div>
</div>