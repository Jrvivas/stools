<?php
//NUEVO PROGRAMANDO
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */

$this->title = $model->id;

\yii\web\YiiAsset::register($this);
?>
<div class="pedido-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'app_idApp' => $model->app_idApp], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'app_idApp' => $model->app_idApp], [
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
            'app_idApp',
            'contacto_id',
            'nombre',
            'fechaIni',
            'fechaFin',
            'fechaEntrega',
            'delivery',
            'comentarios',
            'monto',
            'descuento',
            'impuesto',
            'estado',
        ],
    ]) ?>

</div>
