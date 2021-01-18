<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContactoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contactos';
//$this->params['breadcrumbs'][] = $this->title;

$script= "var idApp='".$idApp."';"; // Pasar el idApp para los menu
$script .= "function botProductoCalculoRapido() {alert('Programando...') ;}"; 
$script .= "function botContactoEditar(id) { window.location.href ='" . \Yii::$app->urlManager->createUrl(['contacto/update','app_idApp'=>$idApp])."&id='+id;}";  //ver
$script .= "function botContactoBorrar() {alert('No es posible borrar este producto');};";    
$script .= "window.onload=function() {  $('#txtBusq').on('keyup touchend', function(e) { $('#productossearch-txtsearch').val(this.value);$('form#w0').submit();})};";    
$this->registerJs($script, View::POS_END, 'my-options'); 

?>
<div class="contacto-index">

<?php  echo $this->render('/controls/_searchContacto', ['title'=> Html::encode($this->title),'model' => $searchModel,'label'=>'Contacto','action'=>'index','actionCreate'=>'contacto/create']); ?>

    <!--<p>
        <?= Html::a('Create Contacto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

    

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_itemContacto',
    ]) ?>


</div>
