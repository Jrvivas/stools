<?php

use yii\helpers\Html;
use yii\web\View;
use app\models\Perfil;

$idApp= Yii::$app->params['sesionApp']['idApp'];                                    //id de la aplicación
$nameApp=Yii::$app->params['sesionApp']['nameApp'];                                 //Nombre de la aplicación
$userName= Yii::$app->params['sesionApp']['userName'];                              //Nombre del usuario
$codPerfil=Perfil::roleToCodePerfil(Yii::$app->params['sesionApp']['userRole']);

$tool=Perfil::getConfigMenu($codPerfil,$idApp);

$script="var idApp='".$model->idApp."';"; // Pasar el idApp para los menu

foreach($tool as $t){
    $nombBot="#bot".ucfirst($t['nombre']);
    $script.= <<<JS

    $("$nombBot").click(function(){
       
        window.location="$t[url]";
    })
JS;
    
}


$this->registerJs($script, View::POS_END, 'my-options'); 

?>
<div class="container p-2">
    <div class="row">

        <?php

             foreach($tool as $t){
                echo "  <div class=\"col-md-3 text-center \" title=\"{$t['help']}\">";
                echo Html::button( "<img src=\"{$t['urlIcon']}\" style=\"width:72px;height:72px\" alt=\"{$t['label']}\"/>",['id'=>"bot".ucfirst($t['nombre']),'class'=>' bot-inicio']);
                echo "<h3 style='margin-top: -0.5em;'>{$t['label']}</h3>";
                echo     " </div>";
                    

                }
        ?>
    </div>

</div>
