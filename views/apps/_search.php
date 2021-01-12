<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AppsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apps-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idApp') ?>

    <?= $form->field($model, 'idUser') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'codigoApp') ?>

    <?= $form->field($model, 'urlLogo') ?>

    <?php // echo $form->field($model, 'color1') ?>

    <?php // echo $form->field($model, 'color2') ?>

    <?php // echo $form->field($model, 'color3') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
