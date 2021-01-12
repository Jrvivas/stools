<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CuentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cuentas';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuenta-index">

    <!--  Barra de busqueda -->

    <?php echo $this->render('/controls/_searchV01', ['title' => Html::encode($this->title), 'model' => $searchModel,'icono'=>$iconCuenta=Yii::getAlias('@web').'/assets/imgs/cuenta.png', 'label' => 'Cuentas', 'action' => 'index', 'actionCreate' => 'create']); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_item',
    ]) ?>


</div>


<div class="container">
    <div class="row bg-primary">
        <div class="col-12 m-5" style="margin-left:10px">
            <h2>Saldo: $0.00</h2>
        </div>
    </div>
</div>