<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Inicio';
//$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Aplicaciones</h1>
<div class="container scrool" style="height: 60vh;">
<div class="row mt-3"> 
    <div class="col-ms-4 text-center">
        <?= Html::button( '<img src="assets/imgs/bot_user.svg" alt="" width="94px" height=94px> <p>Pedidos</p>', ['class' => 'appBotonIni']) ?>
    </div>

</div>
</div>