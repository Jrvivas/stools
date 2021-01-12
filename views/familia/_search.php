<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FamiliaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="familia-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'app_idApp') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'prefijo') ?>

    <?= $form->field($model, 'idPadre') ?>

    <?php // echo $form->field($model, 'esProducto') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
