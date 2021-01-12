<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\URL;
use yii\web\View;


$url = Yii::getAlias("@web");

AppAsset::register($this);

if(isset(Yii::$app->variables['idApp'])){
    $idApp=Yii::$app->variables['idApp'];
}else{
    $idApp='';
}

$script = "var idApp='$idApp';";
  
$this->registerJs($script, View::POS_HEAD , 'my-options'); 


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#000000"/>
	<link rel="apple-touch-icon" href="react/logo192.png"/>
    <link rel="manifest" href="react/manifest.json"/>


    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body >
<?php $this->beginBody() ?>


        <?= $content ?>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ;

?>
