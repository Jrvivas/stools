<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cuenta */

$this->title = 'Nueva Cuenta';
//$this->params['breadcrumbs'][] = ['label' => 'Cuentas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$iconCuenta=Yii::getAlias('@web').'/assets/imgs/cuenta.png';
?>
<div class="cuenta-create">

    <div class="row bg-primary" style="border-radius: 5px;padding: 5px; margin-bottom:10px">
        <div class="col-md-1">
            <img src="<?=$iconCuenta?>" alt="" style="width:94px">
        </div>
        <div class="col-md-10">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>
    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
