<?php

use app\models\Report;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Tabs;

use yii\web\View ;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider*/

$this->title="Reportes";


$actives=['est'=>true,'res'=>false,'vta-clte'=>false,'vta-user'=>false];
activeTag($actives,$model->tipo);

//Constante para las urls
$urlEstadistica= \Yii::$app->urlManager->createUrl(['report/index','idApp'=>Yii::$app->params['sesionApp']['idApp'],'tipo'=>Report::$_TIPO_ESTADISTICA]);
$urlResumen= \Yii::$app->urlManager->createUrl(['report/index','idApp'=>Yii::$app->params['sesionApp']['idApp'],'tipo'=>Report::$_TIPO_REPORTES]);

///mmm
$script=<<<JS

        //Despues de cargar la pagina
        $(document).ready(function() {

                //Click en botón estadistica
                $('#bot_report_estadistica').click(function(e) {

                window.location.href ="$urlEstadistica";
                e.stopPropagation();

                });

                //Click en botón Resumen
                $('#bot_report_resumen').click(function(e) {
                    alert("hola")
                window.location.href ="$urlResumen";
                e.stopPropagation();

                });
            });

JS;
$this->registerJs($script, View::POS_END, 'my-options'); 


?>
<div class="report_class">

    <h4><?=$this->title?></h4>

    <?php
    echo Tabs::widget([
        'items' => [
            [
                'label' => 'Estadisticas',
                'content' => $this->render('@app/views/controls/_viewStadistic',['idApp'=>$model->idApp]),// showEstadistica($model),
                'active' =>$actives['est'],
                //'options' => ['id' => 'bot_report_estadistica'],
                'url'=>$urlEstadistica,
            ],
            [
                'label' => 'Resumen',
                //'options' => ['id' => 'bot_report_resumen'],
                'content' => showResumen($model,$dataProvider),
                'active' =>$actives['res'],
                'url'=>$urlResumen,

            ],

        ],
    ]);
 

    ?>




</div>


<?php   //FUNCINES DE SORTE
//---- Funciones de Visualizacion

    function showEstadistica($model){
        return  Yii::$app->view->render('@app/views/controls/_viewStadistic',['idApp'=>$model->idApp]);
    }

    /*
    function showResumen($model,$tipoSelect,$dataProvider){
      
        //Abrimos el contenedor
        $html='<div class="container">';

       // $model->tipo=$tipoSelect;       // analisar

        switch ($tipoSelect){
            case Report::$_TIPO_REPORTES_VENTA_CLIENTE:
                 
                    if(isset($dataProvider)){
                       return Yii::$app->view->render('_list_reporte',['dataProvider'=>$dataProvider,'model'=>$model]); 
                        
                    }else{
                        return Yii::$app->view->render('_form_reportes',['model'=>$model,'tipo'=>Report::$_TIPO_REPORTES_VENTA_CLIENTE]); 
                    }
                   
                
              

            break;

            case Report::$_TIPO_REPORTES_VENTA_USUARIO:

                if(isset($dataProvider)){
                    return Yii::$app->view->render('_list_reporte',['dataProvider'=>$dataProvider,'model'=>$model]); 
                     
                 }else{
                     return Yii::$app->view->render('_form_reportes',['model'=>$model,'tipo'=>Report::$_TIPO_REPORTES_VENTA_USUARIO]); 
                 }

            break;
            
        }
        
        $html.='</div>';
        
        
        return $html;
    }*/

 function showResumen($model,$dataProvider){
      
        //Abrimos el contenedor
        $html='<div class="container">';

       // $model->tipo=$tipoSelect;       // analisar

        switch ($model->tipo){
            case Report::$_TIPO_REPORTES:
                 return Yii::$app->view->render('_option_resume',['model'=>$model]); 

            case Report::$_TIPO_REPORTES_VENTA_CLIENTE:
            case Report::$_TIPO_REPORTES_VENTA_CLIENTE+900:
                 
                    if(isset($dataProvider)){
                       return Yii::$app->view->render('_list_reporte',['dataProvider'=>$dataProvider,'model'=>$model]); 
                        
                    }else{
                        return Yii::$app->view->render('_form_reportes',['model'=>$model,'tipo'=>Report::$_TIPO_REPORTES_VENTA_CLIENTE]); 
                    }

            break;

            case Report::$_TIPO_REPORTES_VENTA_USUARIO:
            case Report::$_TIPO_REPORTES_VENTA_USUARIO+900:

                if(isset($dataProvider)){
                    return Yii::$app->view->render('_list_reporte',['dataProvider'=>$dataProvider,'model'=>$model]); 
                     
                 }else{
                     return Yii::$app->view->render('_form_reportes',['model'=>$model,'tipo'=>Report::$_TIPO_REPORTES_VENTA_USUARIO]); 
                 }

            break;
            
        }
        
        $html.='</div>';
        
        
        return $html;
    }



    function activeTag(&$actives,$idTipo){

        foreach($actives as &$act){
            $act=false;
        }    
        switch($idTipo){
            case Report::$_TIPO_ESTADISTICA:
                $actives['est']=true;
            break;
            case Report::$_TIPO_REPORTES:
                $actives['res']=true; 
            break;
            case Report::$_TIPO_REPORTES_VENTA_CLIENTE:
                $actives['res']=true;
            case (900+Report::$_TIPO_REPORTES_VENTA_CLIENTE):
                    $actives['res']=true;    
            break;

            case (900+Report::$_TIPO_REPORTES_VENTA_USUARIO):
                $actives['res']=true;
            break;
            case Report::$_TIPO_REPORTES_VENTA_USUARIO:
                $actives['res']=true;
            break;

        }
        
    }

    
    function sumarizeFooter($model,$field){
        $iSum = 0;
        foreach ($model as  $obj){
            $iSum += floatval($obj->{$field});
        }
        return '$'.number_format($iSum, 2, ',', '.');;
    }
    

//-------------------------------
