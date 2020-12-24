<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Apps */

$this->title = 'Modificar ' . $model->idApp;

?>
<div class="apps-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
