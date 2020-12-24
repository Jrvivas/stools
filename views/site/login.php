<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Inicio de sesion';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <div style="text-align: center;">
<img src="assets/imgs/image_login.png"alt="" style="width:200px">
</div>
    

    <p>Por favor complete los siguientes datos para iniciar sesión</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => '{label}<div class="col-lg-3">{input}</div><div class="col-lg-8">{error}</div>',
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
        <div class="row" style="font-size:1.4em; background-color:rgba(255,255,255,0.6); border-style:solid; border-width:1px; border-radius:5px; color:black; border-color:var(--primary); padding:10px; margin:5px">

        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label("Usuario") ?>

        <?= $form->field($model, 'password')->passwordInput()->label("Clave") ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ])->label("Recordar datos") ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Iniciar sesion', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

            </div>

        </div>

        </div>
        <div class="row" style="font-size:1.5em; background-color:rgba(255,255,255,0.6);color:black; border-style:solid; border-width:1px; border-radius:5px; border-color:var(--primary); padding:10px; margin:15px 5px">
            <p>Si usted no tiene una cuenta puede registrarce y obtener una</p>
             <?= Html::Button('Registrarce', ['class' => 'btn btn-primary', 'name' => 'registro-button','onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['site/register']) . "';"]) ?>
    
        </div>
                <?php ActiveForm::end(); ?>

    <!--NO SE DEBE USAR ESTE CODIGO POR EL MOMENTO-->
    <!--<div class="col-lg-offset-1" style="color:#999;">
        You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
        To modify the username/password, please check out the code <code>app\models\User::$users</code>.
    </div>-->
</div>
