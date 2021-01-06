<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;


$model->tipo=$tipo;
if(!isset($model->fechaIni)){
    $fecha_actual = date("y-M-d");
    $model->fechaIni=date("y-M-d",strtotime($fecha_actual."- 1 month"));
}

if(!isset($model->fechaFin)){
    $model->fechaFin=date("Y-m-d");
}

$listResp=$model->listResp();
?>


<div class="reporte-form">

    <?php $form = ActiveForm::begin();?>

    <?=$form->field($model,'idResponsable')->dropDownList($listResp, ['prompt' => 'Seleccionar el Cliente' ])->label('Clente');?>
    
    <?=$form->field($model,'fechaIni')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'es',
        'dateFormat' => 'yyyy-MM-dd',
    ])->label('Fecha de inicio del Reporte');?>

    <?=$form->field($model,'fechaFin')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'es',
        'dateFormat' => 'yyyy-MM-dd',
    ])->label('Fecha de fin del Reporte');?>

     <?=$form->field($model, 'tipo')->hiddenInput(['value'=> $model->tipo])->label(false);?>

    <div class="form-group">
        <?= Html::submitButton('Generar', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div> 
