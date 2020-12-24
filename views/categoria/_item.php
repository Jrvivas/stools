<?php
use yii\helpers\Html;
use yii\web\View ;
use yii\helpers\URL;



//$urlEdit= \Yii::$app->urlManager->createUrl(['/categoria/update',['codigo'=>$model->codigo,'app_idApp'=>$model->app_idApp]]) ;
//$urlEdit= Url::to(['categoria/update', 'codigo' => $model->codigo, 'app_idApp' =>$model->app_idApp ]);
$urlEdit= Url::to(['categoria/update', 'app_idApp' =>$model->app_idApp ]);
$urlDelete= Url::to(['categoria/delete', 'app_idApp' =>$model->app_idApp ]);

$script=<<<JS

    function editar(id){
         window.location.href = '$urlEdit'+'&codigo='+id;
    }
     function borrar(id){
         window.location.href = '$urlDelete'+'&codigo='+id;;
    }
    
    $(document).ready(function() {
       /* $("#botEdit").click(function(){
            window.location.href = '$urlEdit';
        });
       $("#botDelete").click(function(){
            window.location.href = '$urlDelete';
        });*/
    });
JS;
$this->registerJs($script, View::POS_END, 'my-options'); 


$urlLogo=Yii::getAlias('@web').'/assets/imgs/categoria.png';
if (!empty($model->urlLogo)){
   $urlLogo=$model->urlLogo;
}
?>
<div class="row marcoItems" >
    <div class="col-sm-2">
      
           <img src="<?=$urlLogo?>"  alt="" class="imgIcon"> 


    </div>
     <div class="col-sm-2">
         <h2><?=$model->codigo?></h2>
      </div>
      <div class="col-sm-6">
        
        <h2><?=$model->nombre?></h2>
        <p>descripción: <?=$model->descripcion?></p>
    </div>
     <div class="col-sm-2">
        
     <button  type="button"  class="btn btn-secondary px-3" style="width:46px; height:46px" onclick="editar('<?=$model->codigo?>')" >
            <img src="assets/icons/pencil.svg"  alt="" style="width:32px; height:32px"> 
        </button>
        <button   type="button"  class="btn btn-secondary px-3"  style="width:46px; height:46px" onclick="borrar('<?=$model->codigo?>')">
             <img src="assets/icons/trash.svg"  alt="" style="width:32px; height:32px"> 
        </button>
    </div>

</div>