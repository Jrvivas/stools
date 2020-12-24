<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

if($navbar){
  $items=[];
  foreach($navbar['links'] as $l){
      $items[]=['label'=>$l['label'],'url'=>[$l['url']]];
  }

  NavBar::begin([
      'brandLabel' => $navbar['nombre'],
      'brandUrl' =>$navbar['urlHome'],
      'options' => [
          'class' => 'navbar-inverse navbar-fixed-top navColor',
      ],
    ]);
    echo Nav::widget([
      'options' => ['class' => 'navbar-nav navbar-right'],
      'items' => array_merge($items,[
          
          Yii::$app->user->isGuest ? (
              ['label' => 'Login', 'url' => ['/site/login']]
          ) : (
              '<li>'
              . Html::beginForm(['/site/logout'], 'post')
              . Html::submitButton(
                  'Logout (' . Yii::$app->user->identity->username . ')',
                  ['class' => 'btn btn-link logout']
              )
              . Html::endForm()
              . '</li>'
          )
      ]),
    ]);
    NavBar::end();


}
  
?>
