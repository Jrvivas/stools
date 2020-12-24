<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Productos */

$this->title = 'Nuevo Productos';

?>
<?= Html::cssFile("@web/assets/apps/".$idApp."/css/site.css") ?>
<div class="productos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formProducto', [
        'model' => $model,
    ]) ?>

</div>
