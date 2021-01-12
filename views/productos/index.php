<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use app\models\Categoria;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\modelsProductosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Productos';

// Obtener la lista de Categorias
$queryCategorias=Categoria::find()->where(['app_idApp'=>$idApp])->orderBy(['nombre'=>SORT_DESC])->all();
$categorias=ArrayHelper::map($queryCategorias,'codigo','nombre');

//$this->params['breadcrumbs'][] = $this->title;

$script= "var idApp='".$idApp."';"; // Pasar el idApp para los menu
$script .= "function botProductoCalculoRapido() {alert('Programando...') ;}"; 
$script .= "function botProductoEditar(id) { window.location.href ='" . \Yii::$app->urlManager->createUrl(['productos/update','app_idApp'=>$idApp])."&id='+id;}";  //ver
$script .= "function botProductoBorrar() {alert('No es posible borrar este producto');};";    
$script .= "window.onload=function() {  $('#txtBusq').on('keyup touchend', function(e) { $('#productossearch-txtsearch').val(this.value);$('form#w0').submit();})};";    
$this->registerJs($script, View::POS_END, 'my-options'); 

?>
<?= Html::cssFile("@web/assets/apps/".$idApp."/css/site.css?v=0.005") ?>
<div class="productos-index">

<?= Html::input('text', 'busqueda', '', ['class' => 'input-group-text','id'=>'txtBusq', ]) ?>

  <?php  
Pjax::begin(['id' => 'search','enablePushState' => false   // para que no cambie el url
]); 
     //echo $this->render('/controls/_search_categoria', ['title'=> Html::encode($this->title),'model' => $searchModel,'categorias'=>$categorias,'label'=>'Productos','action'=>'index','actionCreate'=>'create']);

     $form = ActiveForm::begin([
                 'action' => ['index','idApp'=>$idApp],
                 'method' => 'get',
                 'options' => ['class' => ' form-inline my-3','data-pjax' => true ]
     ]);
     echo $form->field($searchModel, 'txtSearch')->textInput(['class' => ' mx-2','data-pjax'=>"0",'style' => 'display:none; color:black; font-size:1.5em;border-radius: 10px;max-width: 230px; margin-top: 5px;'])->label('Buscar');

     echo Html::submitButton(' <img src="assets/icons/search_white.png" color:white; alt="" style=" width:32px;"> ', ['class' => 'btn btn-success mx-2 bot-search','style' => 'height: 32px; padding-top: 0px; width: 42px;']) ;


     ?>
 
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_itemProducto',
    ]) ?>
 <?php 
 
ActiveForm::end(); 

  Pjax::end(); ?>

</div>
