<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Productos */

$this->title = 'Nuevo Pedido';
//$this->params['breadcrumbs'][] = ['label' => 'Pedidos', 'url' => ['pedidos']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedidos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formPedido_new', [
        'model' => $model,
        'edit' => false,
    ]) ?>

</div>
