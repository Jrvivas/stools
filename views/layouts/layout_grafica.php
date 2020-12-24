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


$script = "var idApp='$idApp'; var urlBase='".Url::base(true)."'; _csrf='".Yii::$app->request->csrfToken."';";
$script.= "function mostrarReportes() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/grafica/dashboard','id'=>'']) . "'+idApp;}"; 
//$script.= "function mostrarProductos() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/grafica/productos','id'=>'']) . "'+idApp;}"; 
$script.= "function mostrarProductos() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/productos/index','idApp'=>'']) . "'+idApp;}"; 
$script .= "function mostrarPedidos() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/grafica/pedidos','id'=>'']) . "'+idApp;}";  
$script .= "function mostrarPedidosB() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/pedido/index-react','idApp'=>'']) . "'+idApp;}";  
$script .= "function mostrarClientes() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/grafica/clientes','id'=>'']) . "'+idApp;}";   
$script .= "function mostrarCategorias() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/categoria/index','idApp'=>'']) . "'+idApp;}";  
$script .= "function mostrarCuentas() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/cuenta','idApp'=>'']) . "'+idApp;}";   
$this->registerJs($script, View::POS_HEAD , 'my-options'); 


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link  rel="icon"   href="assets/apps/<?=$idApp?>/imgs/logo_16.png" type="image/png" />

    <script src="js/app_server.js?v=0.002"></script>
    <script src="js/util.js"></script>

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= Html::cssFile("@web/assets/apps/".Yii::$app->variables['idApp']."/css/site.css?v=".rand(0, 100)) ?>
</head>
<body >
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->urlManager->createUrl(['grafica/index','id'=>'000']) ,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top navColor',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Reportes',  'options'=>['onclick' => 'mostrarReportes();']],
            ['label' => 'Pedidos beta',  'options'=>['style'=>['background'=>'#fff70047'],'onclick' => 'mostrarPedidosB();']],
            ['label' => 'Pedidos',  'options'=>['onclick' => 'mostrarPedidos();']],
          // ['label' => 'Productos', 'url' => ['/grafica/productos']],
            ['label' => 'Productos', 'options'=>['onclick' => 'mostrarProductos();']],
            ['label' => 'Clientes',  'options'=>['onclick' => 'mostrarClientes();']],
            ['label' => 'Categorias',  'options'=>['onclick' => 'mostrarCategorias() ;']], 
            ['label' => 'Cuentas',  'options'=>['onclick' => 'mostrarCuentas();']],
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
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Gráfica Sigma <?= date('Y') ?></p>

       
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ;

?>
