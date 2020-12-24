<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categorias';

?>
<div class="categoria-index">

    
    <!--  Barra de busqueda -->

     <?php echo $this->render('/controls/_searchV01', ['title' => Html::encode($this->title), 'model' => $searchModel,'icono'=>$iconCuenta=Yii::getAlias('@web').'/assets/imgs/categorias.png', 'label' => 'Categorias', 'action' => 'index', 'actionCreate' => 'create']); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_item',
    ]) ?>


</div>
