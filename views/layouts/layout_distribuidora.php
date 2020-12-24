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
use app\models\User;






$url = Yii::getAlias("@web");

AppAsset::register($this);
if(isset(Yii::$app->variables['idApp'])){
    $idApp=Yii::$app->variables['idApp'];
}else{
    $idApp='';
}

$script = "var idApp='$idApp';var urlBase='".Url::base(true)."'; _csrf='".Yii::$app->request->csrfToken."';";
$script.= "function mostrarReportes() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/report/index','idApp'=>$idApp,'tipo'=>0]) . "';}"; 
//$script.= "function mostrarProductos() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/distribuidora/productos','id'=>'']) . "'+idApp;}"; 
$script.= "function mostrarProductos() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/productos/index','idApp'=>'']) . "'+idApp;}"; 
$script .= "function mostrarPedidos() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/distribuidora/pedidos','id'=>'']) . "'+idApp;}";  
$script .= "function mostrarPedidosB() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/pedido/index-react','idApp'=>'']) . "'+idApp;}";  
$script .= "function mostrarCategorias() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/categoria/index','idApp'=>'']) . "'+idApp;}";  
$script.= "function mostrarStock() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/productos/stock','idApp'=>'']) . "'+idApp;}"; 
$script .= "function mostrarClientes() { window.location.href = '" . \Yii::$app->urlManager->createUrl(['/distribuidora/clientes','id'=>'']) . "'+idApp;}";     
$this->registerJs($script, View::POS_HEAD , 'my-options'); 

$admin_roles = [User::ROLE_ADMIN, User::ROLE_SUPERUSER];
$Responsable_roles = [User::ROLE_RESPONSABLE];

$menuArray=[ ['label' => 'Pedidos',  'options'=>['onclick' => 'mostrarPedidos();']],
['label' => 'Pedidos beta',  'options'=>['style'=>['background'=>'#fff70047'],'onclick' => 'mostrarPedidosB();']],
            ['label' => 'Clientes',  'options'=>['onclick' => 'mostrarClientes();']],
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
  )];


//==================================RESPOSNSABLE===============================
if(in_array(User::getRole(Yii::$app->variables['idApp']), $Responsable_roles)){
    $menuArray=[ ['label' => 'Pedidos',  'options'=>['onclick' => 'mostrarPedidos();']],
    ['label' => 'Pedidos beta',  'options'=>['style'=>['background'=>'#fff70047'],'onclick' => 'mostrarPedidosB();']],
    
        ['label' => 'Clientes',  'options'=>['onclick' => 'mostrarClientes();']]
        ,
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
        )];
}
  
//==================================ADMINISTRADOR===============================
if(in_array(User::getRole(Yii::$app->variables['idApp']), $admin_roles)){
    $menuArray=[
        ['label' => 'Reportes',  'options'=>['onclick' => 'mostrarReportes();']],
        ['label' => 'Pedidos beta',  'options'=>['style'=>['background'=>'#fff70047'],'onclick' => 'mostrarPedidosB();']],
        ['label' => 'Pedidos',  'options'=>['onclick' => 'mostrarPedidos();']],
        ['label' => 'Productos', 'options'=>['onclick' => 'mostrarProductos();']],
        ['label' => 'Clientes',  'options'=>['onclick' => 'mostrarClientes();']],
        ['label' => 'Categorias', 'options'=>['onclick' => 'mostrarCategorias();']],
        ['label' => 'Stock', 'options'=>['onclick' => 'mostrarStock();']]
        ,
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
        )];
}


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="js/app_server.js?v=0.001"></script>
    <script src="js/util.js?v=0.001"></script>

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head()  ?>
    <?= Html::cssFile("@web/assets/apps/".Yii::$app->variables['idApp']."/css/site.css?v=0.001") ?>
</head>
<body >
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->urlManager->createUrl(['distribuidora/index','id'=>Yii::$app->variables['idApp']]) ,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top navColor',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuArray,
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
