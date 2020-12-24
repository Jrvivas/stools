<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cuenta */

$this->title = $model->app_idApp;
$this->params['breadcrumbs'][] = ['label' => 'Cuentas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cuenta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'app_idApp' => $model->app_idApp, 'contacto_id' => $model->contacto_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'app_idApp' => $model->app_idApp, 'contacto_id' => $model->contacto_id], [
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
            'app_idApp',
            'contacto_id',
            'nombre',
            'saldo',
            'fecha',
            'estado',
        ],
    ]) ?>

</div>
