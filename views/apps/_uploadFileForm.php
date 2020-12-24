<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
?>

<?php 
Pjax::begin([
    // Pjax options
]);
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','data-pjax' => '']]) ?>

    <?= Html::img($model->urlFile,['style'=>['width' => '300px']]);?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <button>Submit</button>

<?php ActiveForm::end();
Pjax::end(); ?>
