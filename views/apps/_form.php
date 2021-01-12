<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use consynki\yii\input\ImageInput;
use yii\helpers\ArrayHelper;
use app\models\Plan;
use app\models\Apps;

use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Apps */
/* @var $form yii\widgets\ActiveForm */
if(is_null($model->color1)){
    $model->color1='#002180';
}
if(is_null($model->color2)){
    $model->color2='#008005';
}
if(is_null($model->color3)){
    $model->color3='#e47703';
}
if(is_null($model->color4)){
    $model->color4='#000';
}
//Faltan 'FAST_FOOD','PIZZERIA';


//$tipoApps=['GRAFICA'=>'Venta productos y servicios','DISTRIBUIDORA'=>'Distribuidoras'];
$planes= ArrayHelper::map(Plan::list(), 'codigo', 'nombre');

$rubros=Apps::getRubros();

if(!isset($model->codigoApp)){
    $model->codigoApp='VENTA_SERVICIO';
}

?>

<div class="apps-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row" style="font-size:1.5em; background-color:rgba(255,255,255,0.5); border-style:solid; border-width:1px; border-radius:5px; border-color:var(--primary); padding:10px; margin:5px">

        <div class="col-md-8">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'codigoApp')->dropdownList($rubros, ['prompt'=>'-Seleccione un rubro-'])->label("Rubro");?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'codigoPlan')->dropdownList($planes, ['prompt'=>'-Seleccione un tipo-']);?>
        </div>
    </div>

    <div class="row" style="font-size:1.5em; background-color:rgba(255,255,255,0.5); border-style:solid; border-width:1px; border-radius:5px; border-color:var(--primary); padding:10px; margin:5px">   
        
         <div class="col-md-4">

            <?=
            $form->field($model, 'imageFile',['options'=>['style'=>'width:100px;']])
            ->fileInput(
                    ['name' => 'file', 'class' => 'inputfile','title'=>'Haga clic aquí para subir su logo'])
            ->widget(ImageInput::className(),[
                'value' => $model->urlLogo ? $model->urlLogo : 'assets/imgs/logo.png', //Optional current value
                 ])->label('Logotipo');
                            ?>
        </div>
         



        <div class="col-md-4">
            <?= $form->field($model, 'color1')->textInput(['maxlength' => true,'type'=>'color','style'=>"height:50px;width: 80px;"])->label("Color de controles") ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'color2')->textInput(['maxlength' => true,'type'=>'color','style'=>"height:50px;width: 80px;"])->label("Color de texto de controles")  ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'color3')->textInput(['maxlength' => true,'type'=>'color','style'=>"height:50px;width: 80px;"])->label("Color Fondo")  ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'color4')->textInput(['maxlength' => true,'type'=>'color','style'=>"height:50px;width: 80px;"])->label("Color texto items")  ?>
        </div>
        

    </div>    
    
    <div class="form-group">
      <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-danger  mx-2','style' => 'font-size:1em;']) ?>
        <?= Html::submitButton('Aceptar', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>



</div>
