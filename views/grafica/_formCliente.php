<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View ;

/* @var $this yii\web\View */
/* @var $model app\models\Contacto */
/* @var $form yii\widgets\ActiveForm */
$model->cliente="SI";

$idApp=$model->app_idApp;
$script=<<<JS
 $(document).ready(function() {

        idApp='$idApp';
    });
JS;
$this->registerJs($script, View::POS_END, 'my-options'); 

?>

<div class="contacto-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row" style="font-size:1.5em; background-color:rgba(255,255,255,0.5); border-style:solid; border-width:1px; border-radius:5px; border-color:var(--primary); padding:10px; margin:5px">
    
        <div class="col-md-4"> 
            <?= $form->field($model, 'id')->textInput(['disabled' => true]) ?>
        </div>

        <div class="col-md-4">

            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">

            <?= $form->field($model, 'localidad')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'cel')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        
        <div class="col-md-4">
            <?= $form->field($model, 'empresa')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'cuit')->textInput(['maxlength' => true]) ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::a('Cancelar', ['grafica/clientes','id'=>$model->app_idApp], ['class' => 'btn btn-danger  mx-2','style' => 'font-size:1.5em;']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
