<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Productos */

$this->title = 'Actualizar Pedido: ' . $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Pedido', 'url' => ['distribuidora/pedidos']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'app_idApp' => $model->app_idApp]];
//$this->params['breadcrumbs'][] = 'Update';


?>
<div class="pedido-update">
<?= Html::cssFile("@web/assets/apps/".$idApp."/css/site.css") ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formPedido_new', [
        'model' => $model,
        'edit'=>true,
    ]) ?>

</div>
