<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DetallePedido */

$this->title = 'Update Detalle Pedido: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Detalle Pedidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'pedido_id' => $model->pedido_id, 'app_idApp' => $model->app_idApp]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="detalle-pedido-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
