<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;


$tipo=$model->tipo;
$idApp=$model->idApp;

?>


<div class="reporte-form my-4">



    <?php $form = ActiveForm::begin();?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-3">
             <h4 class="text-center">Haga click en el tipo de reporte que quiere</h4>
            <a href="<?= Url::to(['report/index', 'idApp' =>$idApp , 'tipo' => @app\models\Report::$_TIPO_REPORTES_VENTA_CLIENTE]);?>" class="btn btn-primary btn-lg btn-block active" role="button" aria-pressed="true">Ventas por Cliente</a>
            <a href="<?= Url::to(['report/index', 'idApp' =>$idApp , 'tipo' => @app\models\Report::$_TIPO_REPORTES_VENTA_USUARIO]);?>" class="btn btn-primary btn-lg btn-block active" role="button" aria-pressed="true">Ventas por Usuario</a>
            <a href="#" class="btn btn-primary btn-lg btn-block disabled" role="button" aria-pressed="true">Costos</a>
            <a href="#" class="btn btn-primary btn-lg btn-block disabled" role="button" aria-pressed="true">Gastos</a>
        </div>
        <div class="col-md-3"></div>
    </div>


    <?php ActiveForm::end(); ?>

</div> 
