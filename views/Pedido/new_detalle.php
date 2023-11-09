<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */

$this->title = 'Nuevo detalles de pedido ' . $model->pedido->nombre;

?>
<div class="pedido-update">

    <div class="row">
        <div class="col-md-1 col-xs-2"> <?=Html::a('Volver',['pedido/update','id'=>$model->pedido->id,'app_idApp'=>$model->app_idApp])?></div>
        <div class="col-md-11 col-xs-10"> <h3><?= Html::encode($this->title) ?></h3> </div>
    </div>

    <?= $this->render('_form_detalle', [
        'model' => $model,
    ]) ?>

</div>
