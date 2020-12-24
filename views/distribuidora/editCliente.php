<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Productos */

$this->title = 'Actualizar Cliente: ' . $model->id;



?>
<div class="cliente-update">
<?= Html::cssFile("@web/assets/apps/".$idApp."/css/site.css") ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formCliente', [
        'model' => $model,
    ]) ?>

</div>
