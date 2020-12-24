<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Registro de usuarios';

?>



<h2>Registro de usuarios</h2>

<h3><?= $msg ?></h3>

<?php $form = ActiveForm::begin([
    'method' => 'post',
 'id' => 'formulario',
 'enableClientValidation' => false,
 'enableAjaxValidation' => true,
]);

?>
<div class="form-group">
   
 <?= $form->field($model, "nombre")->input("text")->label('Nombre:  <span class="text-info"> (Ingrese su nombre completo (Nombre Apellido) )</span>') ?>   
</div>

<div class="form-group">
 <?= $form->field($model, "username")->input("text")->label('Usuario:  <span class="text-info"> (nombre que usará para ingresar al sistema más de 8 letras o números)</span>') ?>   
</div>

<div class="form-group">
 <?= $form->field($model, "email")->input("email")->label('Email:  <span class="text-info"> (e-mail para poder veridicar los datos y enviarles un enlace de activación)</span>')?>   
</div>

<div class="form-group">
 <?= $form->field($model, "password")->input("password")->label('Clave:  <span class="text-info"> (ésta va a ser su clave de acceso al sistema tambien más de 8 letras o números)</span>') ?>   
</div>

<div class="form-group">
 <?= $form->field($model, "password_repeat")->input("password")->label('Repetir clave:  <span class="text-info"> (vuelva a repetir la clave para evitar error de escritura)</span>') ?>   
</div>

<?= Html::submitButton("Enviar Solicitud", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>

