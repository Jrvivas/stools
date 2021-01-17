<?php

use app\models\Contacto;
use yii\bootstrap\Collapse;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Contacto */
/* @var $form yii\widgets\ActiveForm */
//echo var_dump($model);
$ulId= new Contacto;
$id=$ulId->maxId($_GET['idApp'])+1;
?>

<div class="contacto-form">
     
    <?php $form = ActiveForm::begin(); ?>

    <?php
    $content=[
    $form->field($model, 'nombre')->textInput(['maxlength' => true])->label('Nombre y Apellido'),
    $form->field($model, 'cel')->textInput(['maxlength' => true])->label('Celular')
    ];
    $content2=[
        $form->field($model, 'direccion')->textInput(['maxlength' => true]),
        $form->field($model, 'localidad')->textInput(['maxlength' => true]),
        $form->field($model, 'tel')->textInput(['maxlength' => true])->label('Telefono Fijo'),
        $form->field($model, 'email')->textInput(['maxlength' => true]) ,
        $form->field($model, 'urlFoto')->textInput(['maxlength' => true]),
        $form->field($model, 'empresa')->textInput(['maxlength' => true]),
        $form->field($model, 'cuit')->textInput(['maxlength' => true]),
        $form->field($model, 'tipo')->textInput(['maxlength' => true])->label('Tipo de Contacto'),
        $form->field($model, 'id')->hiddenInput(['value'=> $id])->label(false),
        $form->field($model, 'app_idApp')->hiddenInput(['value'=> $_GET['idApp']])->label(false)
    ];
    echo Collapse::widget([
        'items' => [
            // equivalent to the above
            [
                'label' => 'Contacto Rapido',
                'content' => $content,
                // open its content by default
                'contentOptions' => ['class' => 'in','style'=>'text-align:center;']
            ],
            // another group item
            [
                'label' => 'Agregar mas datos',
                'content' => $content2,
                'contentOptions' => ['style'=>'text-align:center;']
            ],
        ]
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

