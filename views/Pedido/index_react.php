<?php
use yii\web\View;


$this->registerJsFile('https://unpkg.com/react@16/umd/react.production.min.js', ['depends' => [yii\web\YiiAsset::className()],'position' => View::POS_END], null);//Agregamos React
$this->registerJsFile('https://unpkg.com/react-dom@16/umd/react-dom.production.min.js', ['depends' => [yii\web\YiiAsset::className()],'position' => View::POS_END], null);//Agregamos React

$this->registerJsFile(Yii::getAlias('@web') . '/js/models/app_model_pedido.js?v=0.002', ['position' => View::POS_END], null);

$this->registerJsFile(Yii::getAlias('@web') . '/js/components/app_view_style.js', ['position' => View::POS_END], null);
$this->registerJsFile(Yii::getAlias('@web') . '/js/components/app_view_pedido_opt.js?v=0.001', ['depends' => [yii\web\YiiAsset::className()],'position' => View::POS_END], null);//Agregamos React


$this->title = 'Pedidos';

?>

<div id="view-pedido" class="pedido-index">
        <img src="assets/imgs/espera.gif" alt="Cargando..." style="width:50px;height:50px"/><p>Cargando...</p>
</div>
