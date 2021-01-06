<?php

use yii\helpers\Html;
use yii\widgets\ListView;

use yii\web\View;
/* @var $this yii\web\View */
/* @var $searchModel app\modelsProductosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Productos';
//$this->params['breadcrumbs'][] = $this->title;

$script= "var idApp='".$idApp."';"; // Pasar el idApp para los menu
$script .= "function botProductoCalculoRapido() {alert('Programando...') ;}"; 
$script .= "function botProductoEditar(id) { window.location.href ='" . \Yii::$app->urlManager->createUrl(['distribuidora/update-producto','app_idApp'=>$idApp])."&id='+id;}";  //ver
$script .= "function botProductoBorrar() {alert('No es posible borrar este producto');}";     
$this->registerJs($script, View::POS_END, 'my-options'); 

?>
<?= Html::cssFile("@web/assets/apps/".$idApp."/css/site.css?v=0.005") ?>
<div class="productos-index">

   
       <?php  echo $this->render('/controls/_search_categoria', ['title'=> Html::encode($this->title),'model' => $searchModel,'categorias'=>$categorias,'label'=>'Productos','action'=>'productos','actionCreate'=>'create-producto']); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_itemProducto',
    ]) ?>


</div>
