<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DetallePedido */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Detalle Pedidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="detalle-pedido-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'pedido_id' => $model->pedido_id, 'app_idApp' => $model->app_idApp], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'pedido_id' => $model->pedido_id, 'app_idApp' => $model->app_idApp], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cantidad',
            'ancho',
            'alto',
            'detalle',
            'monto',
            'fraccion',
            'inst',
            'productos_id',
            'pedido_id',
            'app_idApp',
        ],
    ]) ?>

</div>
