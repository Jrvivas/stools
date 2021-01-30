<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contacto */

$this->title = 'Actualizar Contacto: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Contactos', 'url' => ['index','idApp'=>$model->app_idApp]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'app_idApp' => $model->app_idApp]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contacto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formUpdate', [
        'model' => $model,
    ]) ?>

</div>
