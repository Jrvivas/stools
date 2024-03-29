<?php

use app\models\Contacto;
use app\models\ContactoSearch;
use app\views\controls\Img;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\db\ActiveRecord;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this yii\web\View */
/* @var $model \yii\db\ActiveRecord */
/* @var $form yii\widgets\ActiveForm */
/* @var $label string */
//Yii::$app->urlManager->createUrl()
?>

<?php 

$viewType=1;
$handlerCreate='window.location.href ="'.\Yii::$app->urlManager->createUrl([$actionCreate,'idApp'=>$model->app_idApp]).'"';
$aa= new Contacto;
$array=$aa->find()->where(['app_idApp'=>$model->app_idApp])->one()->toArray();
$sel= '<select name="ContactoSearch[nombreCampo]" style="margin-right:15px;height:30px; width: 100px">';
$sel.= '<option>Todos</option>';
 foreach(array_keys($array) as $titulo){
   if($titulo!= 'id' && $titulo!= 'app_idApp' && $titulo!= 'urlFoto'){
    $sel.= '<option>'.$titulo.'</option>';
   }
   
 }
$sel.= '</select>';
$items=[           
                '<li><a>'. Html::beginForm([$action,'idApp'=>$model->app_idApp],'get')
              //.'<div style="display:inline"><spam style="margin-right:5px">'.Img::icon('segmented-nav').'</spam>'. Html::dropDownList('estado', $viewType,array_merge(['TODO'=>'-Todos-'],Pedido::listEstados()),['onchange'=>'this.form.submit()','style'=>'margin-right:15px;height:30px; width: 100px',]).'</div>'
              //.'<div style="display:inline"><spam style="margin-right:5px">'.Img::icon('eye').'</spam>'. Html::dropDownList('View', $viewType,[1=>'Ficha',2=>'Tabla'],['onchange'=>'this.form.submit()','style'=>'margin-right:15px;height:30px; width: 100px',]).'</div>'
              .'<div style="display:inline"> <p style="display:inline; margin-right:6vh;" ><b>Encuentra tus contactos</b></p></div>'
              .$sel
              .'<div style="display:inline" style="margin-left:5px"><spam style="margin-right:5px">'.Img::icon('search').'</spam>'. Html::activeInput('text',$model,'txtSearch',['style'=>'margin-right:15px;height:30px; width: 200px']).'</div>'
              . Html::submitButton( 'Buscar',['class' => 'btn btn-primary logout','style'=>''])
              //.Html::Button( 'Agregar...'.img::icon('plus','42px','42px'),['class' => 'btn btn-primary bot-add','style'=>''])
              . Html::endForm(). '</div></a></li>'];

// Html::activeDropDownList($users, 'id', ArrayHelper::map($userModels, 'id', 'name')) 
//https://www.yiiframework.com/doc/guide/2.0/en/helper-html

NavBar::begin(['brandLabel' => $title
,'options' => [
  'style' => 'border: solid 2px var(--app-ctr-bg-color); border-radius:10px;',
],]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav  navbar-right','style'=>'margin-right:30px'],
    'items' => $items,
]);
echo Html::Button( 'Agregar...'.img::icon('plus','42px','42px'),['class' => 'btn btn-primary bot-float','style'=>'', 'title'=>'Agregar un nuevo '.$label,'onclick'=>$handlerCreate]);
NavBar::end();

?>