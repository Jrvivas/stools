<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cuenta */

$this->title = 'Create Cuenta';

?>
<div class="cuenta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formCuenta', [
        'model' => $model,
    ]) ?>

</div>
