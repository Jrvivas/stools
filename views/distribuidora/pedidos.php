<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\URL;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $searchModel app\modelsProductosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Pedidos';
//$this->params['breadcrumbs'][] = $this->title;

$script="var idApp='".$idApp."';var clickCel=false;"; // Pasar el idApp para los menu
$script .= "function botPedidoCalculoRapido() {alert('Programando...') ;}"; 
$script .= "function botPedidoEditar(id) { if(!clickCel)window.location.href ='" . \Yii::$app->urlManager->createUrl(['distribuidora/update-pedido','app_idApp'=>$idApp])."&id='+id;else clickCel=false;}";  //ver
$script .= "function botPedidoBorrar(id) { window.location.href ='" . \Yii::$app->urlManager->createUrl(['distribuidora/borrar-pedido','app_idApp'=>$idApp])."&id='+id;}";     

$this->registerMetaTag([
    'http-equiv' => 'refresh',
    'content' => '180'
]);

$this->registerJs($script, View::POS_END, 'my-options'); 
$this->registerJsFile(
    '@web/js/app_components.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>
<?= Html::cssFile("@web/assets/apps/".$idApp."/css/site.css?v=0.005") ?>
<div class="pedido-index">

    <!--  Barra de busqueda -->
  
    <?php  echo $this->render('/controls/_search', ['title'=> Html::encode($this->title) ,'model' => $searchModel,'label'=>'Pedidos','action'=>'pedidos','actionCreate'=>'create-pedido']); ?>
    

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_itemPedidoNew',
    ]) ?>


</div>
