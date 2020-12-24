<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modelsProductosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="productos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'app_idApp') ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'urlFoto') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'precio') ?>

    <?php // echo $form->field($model, 'costo') ?>

    <?php // echo $form->field($model, 'precio1') ?>

    <?php // echo $form->field($model, 'precio2') ?>

    <?php // echo $form->field($model, 'opciones') ?>

    <?php // echo $form->field($model, 'unidad') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
