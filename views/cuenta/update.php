<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cuenta */

$this->title = 'Update Cuenta: ' . $model->app_idApp;
$this->params['breadcrumbs'][] = ['label' => 'Cuentas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->app_idApp, 'url' => ['view', 'app_idApp' => $model->app_idApp, 'contacto_id' => $model->contacto_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cuenta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
