<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Contacto;
use yii\helpers\ArrayHelper;
use yii\web\View;

$estados = ['0' => 'Normal'];  

?>
 
        <div class="form-group">
               <?php $form = ActiveForm::begin(); ?>

                 <?= $form->field($model, 'contacto_id',['options' =>['style'=>[]]])->hiddenInput()->label(false) ?> 
            
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
            
           
                <?= $form->field($model, 'saldo')->textInput(['maxlength' => true]) ?>
          
                 <?= $form->field($model, 'estado')->dropDownList($estados) ?>
            
        </div>

        <div class="form-group">
            <?= Html::a('Cancelar', ['index','idApp'=>$model->app_idApp], ['class' => 'btn btn-danger']) ?>
            <?= Html::submitButton('Aceptar', ['class' => 'btn btn-success']) ?>
        </div>

  <?php ActiveForm::end(); ?>
    

