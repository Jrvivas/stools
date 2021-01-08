<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\Web\View;

/* @var $this yii\web\View */
/* @var $model app\models\DetallePedido */
/* @var $form yii\widgets\ActiveForm */
//la variable _csrf tiene que esta declarada en el layout <---TEMPORAL

$js=$model->toJson();
$script="var idApp='$model->app_idApp';var _csrf='".Yii::$app->request->csrfToken."';";
$script.="var detalle=JSON.parse('$js')";

$this->registerJs($script, View::POS_END, 'my-options'); 
/*Agregamos el js para el manejo de ajax */
$this->registerJsFile(Yii::getAlias('@web').'/js/app_server.js',['position'=>View::POS_END] ,null);

/*las funciones utile */
$this->registerJsFile(Yii::getAlias('@web').'/js/util.js',['position'=>View::POS_END] ,null);

/*Agregamos los modelos */
$this->registerJsFile(Yii::getAlias('@web').'/js/models/app_model_producto.js',['position'=>View::POS_END] ,null);

/*Agregamos los modelos */
$this->registerJsFile(Yii::getAlias('@web').'/js/models/app_model_detalle_pedido.js',['position'=>View::POS_END] ,null);

/*Agregamos el escript que manejara la pantalla  */
$this->registerJsFile(Yii::getAlias('@web').'/js/app_view_detalle_pedido.js',['position'=>View::POS_END] ,null);

$lstProductos=ArrayHelper::map($productos,'id','nombre' )

?>

<div class="detalle-pedido-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row marcoItems" >

            <div class="col-md-2">
                <?= $form->field($model, 'id')->textInput(['disabled' => true]) ?>
            </div>

            <div class="col-md-2">
                <?= $form->field($model, 'productos_id')->dropDownList($lstProductos,['onchange'=>'pantalla.handlerSelectProducto(this.value)']) ?>
            </div> 
            <div class="col-md-6">
                <div id="detalle-datos-producto"></div>
            </div>    
            <div class="col-md-2">
                <?= $form->field($model, 'cantidad')->textInput(['maxlength' => true,'onchange'=>'pantalla.handlerChangeCantidad(this.value)']) ?>
            </div>    
            <div class="col-md-2">    
                <?= $form->field($model, 'ancho')->textInput(['maxlength' => true,'onchange'=>'pantalla.handlerChangeAncho(this.value)']) ?>
            </div>    
            <div class="col-md-2">
                <?= $form->field($model, 'alto')->textInput(['maxlength' => true,'onchange'=>'pantalla.handlerChangeAlto(this.value)']) ?>
            </div>    
            <div class="col-md-2">
                <?= $form->field($model, 'detalle')->textInput(['maxlength' => true]) ?>
            </div>    
            <div class="col-md-2">
                <?= $form->field($model, 'monto')->textInput(['maxlength' => true]) ?>
            </div>    
            <div class="col-md-2">
                <?= $form->field($model, 'fraccion')->textInput(['maxlength' => true]) ?>
            </div>    
            <div class="col-md-2">
                <?= $form->field($model, 'inst')->textInput() ?>
            </div>  
    </div>   


    <div class="form-group">
        <?= Html::a('Cancelar', ['pedido/update', 'id'=>$model->pedido_id,'app_idApp' => $model->app_idApp], ['class' => 'btn btn-danger  mx-2', 'style' => 'font-size:1.5em;']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
