<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\grid\GridView;
use app\models\Categoria;
use yii\helpers\ArrayHelper;

use yii\web\View;
/* @var $this yii\web\View */
/* @var $searchModel app\modelsProductosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Productos';

// Obtener la lista de Categorias
$queryCategorias=Categoria::find()->where(['app_idApp'=>$idApp])->orderBy(['nombre'=>SORT_DESC])->all();
$categorias=ArrayHelper::map($queryCategorias,'codigo','nombre');

//$this->params['breadcrumbs'][] = $this->title;

$script= "var idApp='".$idApp."';"; // Pasar el idApp para los menu
$script .= "function botProductoCalculoRapido() {alert('Programando...') ;}"; 
$script .= "function botProductoEditar(id) { window.location.href ='" . \Yii::$app->urlManager->createUrl(['productos/update','app_idApp'=>$idApp])."&id='+id;}";  //ver
$script .= "function botProductoBorrar() {alert('No es posible borrar este producto');}";     
$this->registerJs($script, View::POS_END, 'my-options'); 

?>
<?= Html::cssFile("@web/assets/apps/".$idApp."/css/site.css?v=0.005") ?>
<div class="productos-index">

   
       <?php  echo $this->render('/controls/_search_categoria', ['title'=> Html::encode($this->title),'model' => $searchModel,'categorias'=>$categorias,'label'=>'Productos','action'=>'stock','actionCreate'=>'create']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // Columnas sencillas definidas por los datos contenidos en $dataProvider.
            // Se usarán los datos de la columna del modelo.
            'codigo',
            'nombre',
            [   'label'=>'Categoria',
                'value'=>function($data){
                    if(is_null($data->categoria)){
                        return '- SIN CATEGORIA -';
                    }else{
                        return $data->categoria->nombre;
                    }
                    
                }
            ],
            [
                'label'=>'Stock',
                'value'=>function($data){
                    if(is_null($data->stock)){
                        return '-';
                    }else{
                         return $data->stock->cantidad;
                    }
                }
            ],
            
       
        ],
    ]); 
    ?>


</div>
