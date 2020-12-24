<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\db\ActiveRecord;

/* @var $this yii\web\View */
/* @var $model \yii\db\ActiveRecord */
/* @var $form yii\widgets\ActiveForm */
/* @var $label string */
//Yii::$app->urlManager->createUrl()
?>

        <div class="row bg-primary" style="border-radius: 5px;padding: 5px;">
            <!--  style=" padding: 10px 5px;height: 60px;"-->
          
            <div class="col-md-5 col-xl-6" > 
                 <img src="<?=$icono?>" alt="" style="width:64px">
                 <span style="font-size:2.5rem"><?=$title?></span>
             </div>
            <div class="col-md-7 col-xl-6" style=" padding: 3px 5px; height: 60px;">

                <?php
                    $form = ActiveForm::begin([
                            'action' => [$action,'idApp'=>$model->app_idApp],
                            'method' => 'get',
                            'options' => ['class' => ' form-inline my-3']
                            ]);
                            ?>

                        <?= $form->field($model, 'txtSearch')->textInput(['class' => ' mx-2','style' => 'color:black; font-size:1.5em;border-radius: 10px;max-width: 230px; margin-top: 5px;'])->label('Buscar') ?>

                        <span class="">
                        <?= Html::submitButton(' <img src="assets/icons/search_white.png" color:white; alt="" style=" width:32px;"> ', ['class' => 'btn btn-success mx-2 bot-search','style' => 'height: 32px; padding-top: 0px; width: 42px;']) ?>
                        </span>
                        <span   class="" style="position: absolute;right: 5px;">
                            <?= Html::a(' <img src="assets/icons/plus.svg" color:white; alt="" style="width:64px; margin-top: -0.2em;margin-left: -0.4em;"><span>Agregar '.$label.'</span>' , [$actionCreate,'idApp'=>$model->app_idApp], ['class' => 'btn btn-success  mx-2 bot-add','style' => 'font-size:1.5em;']) ?>
                        </span>

                    <?php ActiveForm::end(); ?>

            </div>
        </div>
