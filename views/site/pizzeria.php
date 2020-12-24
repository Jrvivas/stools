<?php

/* @var $this yii\web\View */
$url = Yii::getAlias("@web");

$this->title = 'App Pizzeria';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Su nombre de usuario es </h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 text-center">
                <h2>Clientes</h2>
                <img src="<?=$url?>/assets/imgs/pizzeria_app.png" alt="Pizzeria" class="appBotonIni">

                <p>Gestion de Clientes</p>

                <p><a class="btn btn-default" href="http://graficasigma.com.ar/apps/web/apps.php?r=pizzeria">Ejecutar la aplicación &raquo;</a></p>
            </div>
          
        </div>

    </div>
</div>
