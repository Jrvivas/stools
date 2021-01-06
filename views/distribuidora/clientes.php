<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\URL;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $searchModel app\modelsProductosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Clientes';
//$this->params['breadcrumbs'][] = $this->title;

$script="var idApp='".$idApp."';"; // Pasar el idApp para los menu
$script .= "function botClienteCalculoRapido() {alert('Programando...') ;}"; 
$script .= "function botClienteEditar(id) { window.location.href ='" . \Yii::$app->urlManager->createUrl(['distribuidora/update-cliente','app_idApp'=>$idApp])."&id='+id;}";  //ver
$script .= "function botClienteBorrar() {alert('No es posible borrar este Cliente');}";     
$this->registerJs($script, View::POS_END, 'my-options'); 

?>
<?= Html::cssFile("@web/assets/apps/".$idApp."/css/site.css?v=0.005") ?>
<div class="cliente-index">

    <!--  Barra de busqueda -->
   
    <?php  echo $this->render('/controls/_search', ['title'=>Html::encode($this->title),'model' => $searchModel,'label'=>'Clientes','action'=>'clientes','actionCreate'=>'create-cliente']); ?>
    

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_itemCliente',
    ]) ?>


</div>
