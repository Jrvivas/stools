<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Movimiento */

$this->title = 'Update Movimiento: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Movimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'app_idApp' => $model->app_idApp, 'contacto_id' => $model->contacto_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="movimiento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
