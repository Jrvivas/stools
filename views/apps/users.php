<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use app\models\User;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\AppsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apps-user">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $users,
        'itemView' => '_itemUsers'
         ]); ?>


</div>


<?php 


