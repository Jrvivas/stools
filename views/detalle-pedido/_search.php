<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DetallePedidoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalle-pedido-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cantidad') ?>

    <?= $form->field($model, 'ancho') ?>

    <?= $form->field($model, 'alto') ?>

    <?= $form->field($model, 'detalle') ?>

    <?php // echo $form->field($model, 'monto') ?>

    <?php // echo $form->field($model, 'fraccion') ?>

    <?php // echo $form->field($model, 'inst') ?>

    <?php // echo $form->field($model, 'productos_id') ?>

    <?php // echo $form->field($model, 'pedido_id') ?>

    <?php // echo $form->field($model, 'app_idApp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
