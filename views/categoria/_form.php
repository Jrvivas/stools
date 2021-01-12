<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Categoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categoria-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row marco_app ">

        <div class="col-md-2 .col-xl-4">

            <?= $form->field($model, 'codigo')->textInput(['maxlength' => true,'title'=>'Código de la categoría debe ser único']) ?>

        </div>
        <div class="col-md-6 .col-xl-12">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true,'title'=>'El nombre de identificación de la categoría']) ?>
        </div>
        <div class="col-md-12 .col-xl-12">
            <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,'title'=>'descripción breve de la categoria si es necesario']) ?>
        </div>


    </div>
    <div class="form-group">
        <?= Html::a('Cancelar', ['index','idApp'=>$model->app_idApp], ['class' => 'btn btn-danger']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>