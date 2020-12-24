<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Contacto;
use yii\helpers\ArrayHelper;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Cuenta */
/* @var $form yii\widgets\ActiveForm */

$contacto = Contacto::find()->where(['app_idApp' => $model->app_idApp, 'cliente' => 'SI'])->orderBy(['nombre' => SORT_DESC])->all();
$clientes = ArrayHelper::map($contacto, 'id', 'nombre');
$estados = ['0' => 'Normal'];
$idApp = $model->app_idApp;
if (empty($model->fecha)) $model->fecha= date("Y-m-d H:i:s");
if (empty($model->saldo)) $model->saldo = 0;


$this->registerJsFile(Yii::getAlias('@web') . '/js/app_api_pedido.js?v=0.004', ['position' => View::POS_END], null);
$script = <<<JS
//----------------------------------


   $(document).ready(function() {
       idApp='$idApp';

       
    });
  
JS;


$this->registerJs($script, View::POS_END, 'my-options');

?>

<div class="cuenta-form">
    <div class="row mx-5">

        <?php $form = ActiveForm::begin(); ?>
     <div class="col-md-4">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label('Nombre de Cuenta') ?>
        </div>
        <div class="col-md-4">
            <h3>Contacto</h3>
            <div id='detalle-contacto-select'></div>
        </div>
        <div class="col-xs-8 col-md-3">
                    <?= $form->field($model, 'contacto_id')->dropDownList($clientes,  ['prompt' => 'Select...'])->label('Cliente'); ?>

                </div>

  
        <div class="col-md-4">
            <?= $form->field($model, 'saldo')->textInput(['maxlength' => true])->label('Saldo $') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'fecha')->textInput(['type' => 'date', 'value' => (new DateTime($model->fecha))->format('Y-m-d')]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'estado')->dropDownList($estados) ?>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

  
</div>