<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Perfil;
use yii\helpers\URL;
use yii\web\View;
use app\views\controls\Img;


$url = Yii::getAlias("@web");

AppAsset::register($this);

// Variables de la aplicacion---------------------

$idApp= Yii::$app->params['sesionApp']['idApp'];                                    //id de la aplicación
$nameApp=Yii::$app->params['sesionApp']['nameApp'];                                 //Nombre de la aplicación
$userName= Yii::$app->params['sesionApp']['userName'];                              //Nombre del usuario
$codPerfil=Perfil::roleToCodePerfil(Yii::$app->params['sesionApp']['userRole']);    // Perfil que se usará en la Aplicacion
$urlHome=Yii::$app->urlManager->createUrl(['apps/view','id'=>$idApp]) ;
$urlImgApp="assets/apps/".$idApp."/imgs/";

//Definimos las variables disponibles para los js------
$script = "var idApp='$idApp'; var urlBase='".Url::base(true)."'; _csrf='".Yii::$app->request->csrfToken."';";

$this->registerJs($script, View::POS_HEAD , 'my-options'); 



?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link  rel="icon"   href="<?=$urlImgApp?>logo_16.png" type="image/png" />

    <script src="js/app_server.js?v=0.002"></script>
    <script src="js/util.js"></script>

    <?php $this->registerCsrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <?= Html::cssFile("@web/assets/apps/".$idApp."/css/site.css?v=".rand(0, 100)) ?> 
    <!-- CSS only -->
   
</head>
<body >
<?php $this->beginBody() ?>

        <div class="wrap">

                <?php
                // BOTON LOGUOT
                $botLogout=[Yii::$app->user->isGuest ? (['label' => 'Login', 'url' => ['/site/login']]) :('<li>'. Html::beginForm(['/site/logout'], 'post')
                                                                . Html::submitButton( Img::icon('person') .'Salir (' . $userName. ')',
                                                                ['class' => 'btn btn-primary logout','style'=>' padding: 5px 10px; margin-top: 3px;']
                                                                ). Html::endForm(). '</li>')];
                //MENU DE PERFIL
                $menuPerfil=Perfil::getItemsMenu($codPerfil,$idApp);


                //LOS DOS MENU UNIDOS
                $items=array_merge($menuPerfil,$botLogout);

                // --- BARRA DE NAVEGACION ---
                NavBar::begin([
                    'brandLabel' =>Html::img($urlImgApp.'logo_42.png',['style'=>'width: 32px; display: inline; margin-right: 2px;']).$nameApp,
                    'brandUrl' => $urlHome,
                    'options' => [
                        'class' => 'navbar-inverse navbar-fixed-top navColor',
                    ],
                ]);

                    echo Nav::widget([
                        'options' => ['class' => 'navbar-nav navbar-right'],
                        'items' => $items,
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
