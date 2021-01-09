<?php

use yii\helpers\Html;
use yii\web\View ;
use app\views\controls\Img;


$urlUpdate= \Yii::$app->urlManager->createUrl(['apps/update','id'=>$idApp]);
$urlUsers= \Yii::$app->urlManager->createUrl(['apps/user','idApp'=>$idApp]);
$urlEnter= \Yii::$app->urlManager->createUrl(['apps/index','id'=>$idApp]);
$script=<<<JS
 $(document).ready(function() {
    $('#botStyle').click(function(e) {
      window.location.href ="$urlUpdate";
      e.stopPropagation();
    });
    $('#botUsers').click(function(e) {
      window.location.href ="$urlUsers";
      e.stopPropagation();
    });
    $('#botEnter').click(function(e) {
      window.location.href ="$urlEnter";
      e.stopPropagation();
    });
});
    
JS;
$this->registerJs($script, View::POS_END, 'my-options'); 


$this->title = 'Configuración';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <div class="row">

        <div class="col-md-3">
                <?=Html::button(Img::icon('brush','94px','94px').'<p>Estetica e información de la aplicación</p>',
                    ['id'=>'botStyle','class'=>'bot-inicio'])?>
        </div>
        <div class="col-md-3">
                <?=Html::button(Img::icon('person','94px','94px').'<p>Manejo de los usuarios del sistema</p>',
                    ['id'=>'botUsers','class'=>'bot-inicio'])?>
        </div>

        <div class="col-md-3">
          <?=Html::button(Img::icon('box-arrow-in-right','94px','94px').'<p>Entrar al Sistema</p>',
                    ['id'=>'botEnter','class'=>'bot-inicio'])?>
        </div>
    </div>

    

</div>
