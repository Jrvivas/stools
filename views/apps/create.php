<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Apps */

$this->title = 'Nueva Aplicación';

?>
<div class="apps-create">
    <div class="row">
        <div class="col-md-4 text-center">
        <img src="assets/imgs/img_nueva_app.png" alt="" style="width:150px; height:150px ;margin:20px 10px">
        </div>
        <div class="col-md-8">
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="text-descripcion">
                Aquí usted va a crear una nueva aplicación para su emprendimiento o negocio
            </p>
        </div>
    </div>
    <hr/>
    <!-- Formulario de la aplicacion-->
    <div class="row">
        <div class="col-12">

           <?= $this->render('_form', [
                'model' => $model,
            
            ]) ?>
        
        </div>
        
    </div>



 

</div>
