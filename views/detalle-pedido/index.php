<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DetallePedidoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Detalle Pedidos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalle-pedido-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Detalle Pedido', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->id), ['view', 'id' => $model->id, 'pedido_id' => $model->pedido_id, 'app_idApp' => $model->app_idApp]);
        },
    ]) ?>


</div>
