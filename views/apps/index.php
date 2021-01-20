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

$this->title = 'Aplicaciones';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apps-index">


        <div class="row mt-5">
            <div class="col-md-3"></div>
            <div class="col-md-6 ">
                <img src="assets/imgs/avatar.svg" class="img-avatar" alt="" style="width: 62px; height: 62px;">
                <span class="mx-2 h3">Bienvenido <?=Yii::$app->params['sesionApp']['userName']?></span> 
            </div>
            <div class="col-md-3"></div>
            </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="text-descripcion">
        A continuación  se listan las aplicaciones propias y las de otro usuario a las que usted tiene acceso
    </p>

    <hr/>
    <p class="text-descripcion" style="font-size:1.2em">
        Si desea crear una nueva aplicación para su negocio o emprendimiento presione el siguiente botón
    </p>

    <?php
        $cant=$dataProvider->getCount(); //optiene la cantidad de aplicaciones que tiene el usuario
        
      //  if($userRol== User::ROLE_ADMIN && $cantApps>$cant){
            if($cant==0){
                echo '<div class="text-ayuda"> Usted no tiene una aplicación para su negocio todavía, para crear una, presione el botón siguiente y siga los pasos cargando la información que le solicita y listo </div>';
            }
           echo '<p style="margin:10px 5px">'. Html::a('Create una Aplicación', ['create'], ['class' => 'btn btn-success']) .' </p>';
     //   }

    ?>
   

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_itemApp' ]); ?>


</div>


<?php 


