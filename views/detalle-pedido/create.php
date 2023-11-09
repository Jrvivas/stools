<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DetallePedido */

$this->title = 'Create Detalle Pedido';

?>
<div class="detalle-pedido-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'productos'=>$productos
    ]) ?>

</div>
