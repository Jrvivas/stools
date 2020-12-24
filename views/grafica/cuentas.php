<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CuentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cuentas';

?>
<div class="cuenta-index">


      <!--  Barra de busqueda -->
   
      <?php  echo $this->render('/controls/_search', ['title'=> Html::encode($this->title),'model' => $searchModel,'label'=>'Cuentas','action'=>'cuentas','actionCreate'=>'create-cuenta']); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->app_idApp), ['view', 'app_idApp' => $model->app_idApp, 'contacto_id' => $model->contacto_id]);
        },
    ]) ?>

    <div class="row">
        <div class="col-12"><h2>Saldo: $0.00</h2></div>
    </div>


</div>
