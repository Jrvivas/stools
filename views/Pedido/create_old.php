<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */

$this->title = 'Nuevo Pedido';
//$this->params['breadcrumbs'][] = ['label' => 'Pedidos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedido-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
