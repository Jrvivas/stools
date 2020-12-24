<?php

use app\models\Report;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView; //


$cliente=$model->getCliente();

$fechas= date("d/m/Y", strtotime($model->fechaIni))." - ". date("d/m/Y", strtotime($model->fechaFin));

?>
<?php switch ($model->tipo){ 
    case Report::$_TIPO_REPORTES_VENTA_CLIENTE:
        echo "<h3>Resumen del Cliente ".$model->getCliente()->nombre." entre las fecha $fechas </h3>";
    break;
    case Report::$_TIPO_REPORTES_VENTA_USUARIO:  
        echo "<h3>Resumen del Usuario ".$model->getUser()->nombre." entre las fecha $fechas</h3>";
    break;  

 }?> 

<?=  GridView::widget([

    'dataProvider' => $dataProvider,
    'showFooter' => true,
    'options'=>["style"=>"overflow: auto;"],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        // Simple columns defined by the data contained in $dataProvider.
        // Data from the model's column will be used.
        'id',
        [
            'label'=>'Fecha',
            'value'=>function($data){
                return date("d/m/Y", strtotime($data->fechaIni));
            }
        ],
               [
            'label'=>'Cliente',
            'value'=>function($data){
                return $data->cliente->nombre." (".$data->cliente->empresa.")";
            },
        ],
        [
            'label'=>'Responsable',
            'value'=>function($data){
                return $data->responsable->nombre?$data->responsable->nombre:$data->responsable->username;
            },
        ],
        [
            'label'=>'Modificó',
            'value'=>function($data){
                if(isset($data->modifico)){
                    return $data->modifico->nombre?$data->modifico->nombre:$data->modifico->username;
                }else{
                    return "-";
                }
                
            },
        ],
        [
            'label'=>'Monto',
            'value' => function ($data) {
                      return '$'.number_format($data->monto, 2, ',', '.'); // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
            'footer' => sumarizeFooter( $dataProvider->getModels(),'monto' ),
           
        ],
         [
            'label'=>'Saldo',
            'value' => function ($data) {
                      return '$'.number_format($data->saldo, 2, ',', '.'); // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
            'footer' => sumarizeFooter( $dataProvider->getModels(),'saldo' ),
            
        ],
       
    ],

]) ?>


    <?php $form = ActiveForm::begin();?>
         <?=$form->field($model, 'idResponsable')->hiddenInput(['value'=> $model->idResponsable])->label(false)?>
        <?=$form->field($model, 'fechaIni')->hiddenInput(['value'=> $model->fechaIni])->label(false)?>
        <?=$form->field($model, 'fechaFin')->hiddenInput(['value'=> $model->fechaFin])->label(false)?>
        <?=$form->field($model, 'tipo')->hiddenInput(['value'=> $model->tipo+900])->label(false)?>
        <div class="form-group">
            <?= Html::submitButton('Editar Reporte', ['class' => 'btn btn-success']) ?>
        </div>


    <?php ActiveForm::end(); ?>

<?php


?>