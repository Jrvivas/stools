<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Contacto */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Contactos', 'url' => ['index','idApp'=>$model->app_idApp]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contacto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'app_idApp' => $model->app_idApp], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'app_idApp' => $model->app_idApp], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro que desea borrar este Contacto?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'app_idApp',
            'nombre',
            'direccion',
            'localidad',
            'cel',
            'tel',
            'email:email',
            'urlFoto',
            'empresa',
            'cuit',
            'tipo',
        ],
    ]) ?>

</div>
