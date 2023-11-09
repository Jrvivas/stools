<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Inicio de sesion';
?>

<div class="container">
    <div class="row mt-5  justify-content-md-cente">
        <div class="col-md-4 col text-center"></div>
        <div class="col-md-4 col text-center">
            <img src="assets/imgs/avatar.svg" class="img-avatar" alt="" style="width: 120px; height: 120px;">
        </div>
        <div class="col-md-4 col text-center"></div>
    </div>

    <div class="row mt-3  justify-content-md-cente">
    <div class="col-md-4 text-center"></div>
        <div class=" col-md-4 text-center">
    <?php $form = ActiveForm::begin(); ?>
       

        <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>'USUARIO'])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'CLAVE'])->label(false) ?>

        <?= $form->field($model, 'rememberMe')->checkbox()->label("Recordar datos") ?>

   
          <?= Html::submitButton('Iniciar sesion', ['class' => 'btn boton-primary mt-3', 'name' => 'login-button','style'=>"width: 100%;"]) ?>
       
         <p class="mt-3">Si usted no tiene una cuenta puede registrarce y obtener una</p>
        
         <?= Html::Button('Registrarce', ['class' => 'btn boton-primary ', 'name' => 'registro-button','style'=>"width: 100%;",'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['site/register']) . "';"]) ?>


          <?php ActiveForm::end(); ?>
         </div>
        <div class="col-md-4  text-center"></div> 
    </div>


</div>