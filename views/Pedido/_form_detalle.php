<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */


?>
<div class="pedido-detalla">
        <?php $form=ActiveForm::begin();?>
            <?= $form->field($model,'productos_id')?>
            <?= $form->field($model,'cantidad')?>
            <?= $form->field($model,'monto')?>
            
            <div class="form-group">
                <?= Html::a('Cancelar', ['pedido/create', 'idApp' => $model->app_idApp], ['class' => 'btn btn-danger  mx-2', 'style' => 'font-size:1.5em;']) ?>
                <?= Html::a('Aceptar', ['detalle-pedido/create', 'idApp' => $model->app_idApp,'id'=>$model->id], ['class' => 'btn btn-success  mx-2', 'style' => 'font-size:1.5em;']) ?>
            </div>


        <?php  ActiveForm::end();?>
</div>