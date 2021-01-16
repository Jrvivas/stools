<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Categoria;
use yii\helpers\ArrayHelper;

use yii\web\View ;
/* @var $this yii\web\View */
/* @var $model app\models\Productos */
/* @var $form yii\widgets\ActiveForm */


$AyudaBotPrecio='No permite definir precios segú clientes o por listas';
$estados=['ACTIVO'=>'Activo','INACTIVO'=>'Inactivo','SUSPENSO'=>'Suspenso'];


$categorias = Categoria::find()->where(['app_idApp' => $model->app_idApp])->orderBy(['nombre' => SORT_DESC])->all();
$listCategorias = ArrayHelper::map($categorias, 'codigo', 'nombre');


$unidades=['UN'=>'Unidad','CJ'=>'Caja','PL'=>'Pallet','M2'=>'Superficie m2','ML'=>'Metro lineal'];

$urlfoto=Yii::getAlias('@web').'/assets/imgs/dist_productos.jpg';
$urlIconConf=Yii::getAlias('@web').'/assets/icons/gear.svg';

if (!empty($model->urlFoto)){
   $urlfoto=$model->urlFoto;
}
if(empty($model->costoBase)){
    $model->costoBase=0;
}
if(empty($model->categoriaCodigo)){
    $model->categoriaCodigo=NULL;
}
if(empty($model->costoInstalacion)){
    $model->costoInstalacion=0;
}

if(empty($model->unxCaja)){
    $model->unxCaja=0;
}
if(empty($model->cajaxPallet)){
    $model->cajaxPallet=0;
}

$idProducto=$model->id;
$idApp=$model->app_idApp;
$this->registerJsFile(Yii::getAlias('@web').'/js/app_api_producto.js?v=0.000',['position'=>View::POS_END] ,null);

$script=<<<JS
 $(document).ready(function() {
        var crtStock=null;
        var idProducto='$idProducto';
        if(parseInt(idProducto)>0){
            new CtrProductoStock('idcrtStock','$idApp',idProducto);
        }

        idApp='$idApp';
    });
JS;
$this->registerJs($script, View::POS_END, 'my-options'); 

?>

<div class="row productos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row" style="font-size:1.5em; background-color:rgba(255,255,255,0.5); border-style:solid; border-width:1px; border-radius:5px; border-color:var(--primary); padding:10px; margin:5px">

        <div class="col-md-4"> 
            <img src="<?=$urlfoto?>" alt="foto">
        </div>
        <div class="col-md-6"> 
            <div class="row">
                <div class="col-md-2"> 
                    <?= $form->field($model, 'id')->textInput(['maxlength' => true, 'disabled' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'categoriaCodigo')->dropdownList($listCategorias,['prompt'=>'-Selecione-']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-12">    
                    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'descripcion')->textArea() ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'estado')->dropdownList($estados);?>
                </div>
                <div class="col-md-4">
                <div class="row">
                        <div class="col-xs-10 col-md-8" style="padding-right:1px">
                            <?= $form->field($model, 'precio')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-2 col-md-4" style="padding-left:1px"> 
                            <button type="button" 
                            class="btn btn-primary" 
                            data-toggle="modal" 
                            data-target="#ModalProducto" 
                            style="margin-top: 3.3rem;" 
                            title="<?=$AyudaBotPrecio?>"
                            onclick="mostrarManejoPrecio('<?=$model->app_idApp?>',<?=$model->id?>,'ModalProducto')">
                                <img src="<?=$urlIconConf?>" alt="*" style="width:24px;padding:0px">
                             </button>
                        </div>
                   
                
                    </div>
                </div>
                <div class="col-md-4">    
                    <?= $form->field($model, 'costo')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-4"> 
                    <?= $form->field($model, 'costoBase')->textInput() ?>
                </div>
                <div class="col-md-4"> 
                    <?= $form->field($model, 'costoInstalacion')->textInput() ?>
                </div>    

                <div class="col-md-12">
                   <div id="idcrtStock"></div>
                </div>
 
                <div class="col-md-4">
                    <?= $form->field($model, 'unidad')->dropdownList($unidades) ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'unxCaja')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'cajaxPallet')->textInput(['maxlength' => true]) ?>
                </div>


            </div>    
            
        </div>

    </div>

    <div class="form-group">
        <?= Html::a('Cancelar', ['productos/index','idApp'=>$model->app_idApp], ['class' => 'btn btn-danger  mx-2','style' => 'font-size:1.5em;']) ?>
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>



    <?php ActiveForm::end(); ?>

</div>
<?php  echo $this->render('/controls/_modalView', ['id' => 'ModalProducto','title'=>'Opciones del producto']); ?>
