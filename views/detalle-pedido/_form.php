<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\DetallePedido */
/* @var $form yii\widgets\ActiveForm */

$lstProductos=ArrayHelper::map($productos,'id','nombre' )

?>

<div class="detalle-pedido-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row marcoItems" >

            <div class="col-md-2">
                <?= $form->field($model, 'id')->textInput(['disabled' => true]) ?>
            </div>

            <div class="col-md-2">
                <?= $form->field($model, 'productos_id')->dropDownList($lstProductos) ?>
            </div>    
            <div class="col-md-2">
                <?= $form->field($model, 'cantidad')->textInput(['maxlength' => true]) ?>
            </div>    
            <div class="col-md-2">    
                <?= $form->field($model, 'ancho')->textInput(['maxlength' => true]) ?>
            </div>    
            <div class="col-md-2">
                <?= $form->field($model, 'alto')->textInput(['maxlength' => true]) ?>
            </div>    
            <div class="col-md-2">
                <?= $form->field($model, 'detalle')->textInput(['maxlength' => true]) ?>
            </div>    
            <div class="col-md-2">
                <?= $form->field($model, 'monto')->textInput(['maxlength' => true]) ?>
            </div>    
            <div class="col-md-2">
                <?= $form->field($model, 'fraccion')->textInput(['maxlength' => true]) ?>
            </div>    
            <div class="col-md-2">
                <?= $form->field($model, 'inst')->textInput() ?>
            </div>  
    </div>   


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
