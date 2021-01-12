<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Contacto;
use yii\helpers\ArrayHelper;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Cuenta */
/* @var $form yii\widgets\ActiveForm */
$contacto = Contacto::find()->where(['app_idApp' => $model->app_idApp])->orderBy(['nombre' => SORT_DESC])->all();
$clientes = ArrayHelper::map($contacto, 'id', 'nombre');
$estados = ['0' => 'Normal'];
$lstContactos='';

foreach($contacto as $cto){
    $lstContactos.='<li><p onclick="selectContacto('.$cto->id.',\''.$cto->nombre.'  ('.$cto->empresa.')'.'\');">'.$cto->nombre.'('.$cto->empresa.')'.'</p></li>';
}

if (empty($model->fecha)) $model->fecha= date("Y-m-d H:i:s");
if (empty($model->saldo)) $model->saldo = 0;

$script = <<<JS
//----------------------------------
function selectContacto(id,nombre){
    document.querySelector("#cuenta-contacto_id").value=id;
    document.querySelector("#botContacto").innerHTML=nombre;
    if(document.querySelector("#cuenta-nombre").value==''){
        document.querySelector("#cuenta-nombre").value=nombre;
    };

}
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dropdown-menu li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
JS;


$this->registerJs($script, View::POS_END, 'my-options');
?>

<div class="cuenta-form">
 

        <?php $form = ActiveForm::begin(); ?>

         <div class="row marco_app ">
     
            <div class="col-md-4 .col-xl-6">
                 <?= $form->field($model, 'contacto_id',['options' =>['style'=>[]]])->hiddenInput()->label(false) ?>
                    <div class="dropdown">
                      <label class="control-label" for="botContacto" style="display: block;">Contacto</label>
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" id="botContacto">Seleccionar...
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu" style="height: 300px;overflow: auto; padding: 10px">
                        <input class="form-control" id="myInput" type="text" placeholder="Search..">
                           <?=$lstContactos?>
                        </ul>
                    </div>
                   
            </div>
            <div class="col-md-4 .col-xl-6">
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4 .col-xl-6">

            </div>
           
            
            <div class="col-md-4 .col-xl-6">
                <?= $form->field($model, 'saldo')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4 .col-xl-6">
                 <?= $form->field($model, 'estado')->dropDownList($estados) ?>
            </div>
            <div class="col-md-4 .col-xl-6">
                
            </div>
       
        </div>

        <div class="form-group">
            <?= Html::a('Cancelar', ['index','idApp'=>$model->app_idApp], ['class' => 'btn btn-danger']) ?>
            <?= Html::submitButton('Aceptar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    

</div>
