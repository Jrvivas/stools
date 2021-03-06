
<?php

use app\models\Contacto;
use app\models\Cuenta;
use yii\bootstrap\Collapse;
use yii\db\Query;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Contacto */
/* @var $form yii\widgets\ActiveForm */
//echo var_dump($model);
$script = <<<JS
//----------------------------------
function cuentaCorriente(idApp,id){
        event.preventDefault();
        var token=yii.getCsrfToken();
        //alert(token+' - '+idApp+' - '+id);
        var url='index.php?r=contacto%2Fcuenta&idApp='+idApp+'&idContacto='+id;
        $.ajax({
            url: url,
            type: 'GET',
            data: {_csrf: yii.getCsrfToken()},
            success: function (respuesta) {

                $('#modal-body-CC').html(respuesta);
                $('#cuentaCorriente').modal('show');
            }
        });
    }
function guardarCuentaContacto(id){
    event.preventDefault();
    //alert('guardar');
    var token=yii.getCsrfToken();
        //alert(token+' - '+idApp+' - '+id);
        var url='index.php?r=contacto%2Fcuentaupdate&idApp='+idApp+'&idContacto='+id;
        $.ajax({
            url: url,
            type: 'POST',
            data: {_csrf: yii.getCsrfToken(),nombre:$('#cuenta-nombre').val(),saldo:$('#cuenta-saldo').val(),estado:$('#cuenta-estado').val()},
            success: function (respuesta) {
                alert(respuesta);
            }
        });
        return false;
}
function crearCuentaContacto(id){
    event.preventDefault();
    //alert('guardar');
    var token=yii.getCsrfToken();
        //alert(token+' - '+idApp+' - '+id);
        var url='index.php?r=contacto%2Fcuentacreate&idApp='+idApp+'&idContacto='+id;
        $.ajax({
            url: url,
            type: 'POST',
            data: {_csrf: yii.getCsrfToken(),nombre:$('#cuenta-nombre').val(),saldo:$('#cuenta-saldo').val(),estado:$('#cuenta-estado').val()},
            success: function (respuesta) {
                alert(respuesta);
            }
        });
        return false;
}

function preciosEspeciales(idApp,id){
  event.preventDefault();
    //alert('guardar');
    var token=yii.getCsrfToken();
        //alert(token+' - '+idApp+' - '+id);
        var url='index.php?r=contacto%2Fcontactoproducto&idApp='+idApp+'&idContacto='+id;
        $.ajax({
            url: url,
            type: 'POST',
            data: {_csrf: yii.getCsrfToken()},
            success: function (respuesta) {
              $('#modal-body-PE').html(respuesta);
              $('#preciosEspeciales').modal('show');
            }
        });
        return false;
    
}
function filtrarProducto(){
		var txt=$("#filtrarProducto").val();
		//console.log(txt);
		var texto="";
		var posi=true;
		t = document.getElementById('preciosEspeciales');
		filas = t.getElementsByTagName('tr');
		$('#preciosEspeciales tr').each(function (index) {			
					if (index!=0){
						var texto = $(this).find("td").eq(1).html();
						var ele=filas[index];
						
						if (texto!=null){
							texto=texto.toUpperCase();
							posi = (texto.indexOf(txt.toUpperCase()) != -1);
							ele.style.display = (posi) ? '' : 'none';
							//console.log(texto);
						}
					}

			});

		

	}
  function guardarPrecios(elemento,id){
    event.preventDefault();
    var arr=[];
		t = document.getElementById('preciosEspeciales');
		filas = t.getElementsByTagName('tr');
		$('#preciosEspeciales tr').each(function (index) {			
					if (index!=0){
						var idProducto = $(this).find("td").eq(0).text();
            var producto = $(this).find("td").eq(1).text();
            var precioEspecial = $(this).find("td").eq(3).find("input").val();
            //console.log(precioEspecial);
						
						
						if (precioEspecial!='' && precioEspecial!=null){
				      var arr2=[idProducto, precioEspecial]
              arr.push(arr2);
							//console.log(texto);
						}
					}

			});
      console.log((arr));
      var token=yii.getCsrfToken();
        //alert(token+' - '+idApp+' - '+id);
        var idApp_=$(elemento).attr('id');
        console.log(idApp_);
        console.log(id);
        var url='index.php?r=contacto%2Fpreciosespeciales&idApp='+idApp_+'&idContacto='+id;
        $.ajax({
            url: url,
            type: 'POST',
            data: {_csrf: yii.getCsrfToken(), precios:arr},
            success: function (respuesta) {
              alert(respuesta);
            }
        });
        return false;

		

	}
  function aplicarPorcentaje(){
    t = document.getElementById('preciosEspeciales');
		filas = t.getElementsByTagName('tr');
		$('#preciosEspeciales tr').each(function (index) {			
					if (index!=0){

            var ele=filas[index];
						
						//console.log(ele.style.display);
            if(ele.style.display!='none'){
              var idProducto = $(this).find("td").eq(0).text();
              var producto = $(this).find("td").eq(1).text();
              var precioAnterior = $(this).find("td").eq(2).text();
              var porcentaje=$('#valorPorcentaje').val();
              if(porcentaje<0){
                console.log(porcentaje)
                var porcentajeFinal=-porcentaje/100;
                var precioNuevo=parseFloat(precioAnterior)-(precioAnterior*porcentajeFinal);
                $(this).find("td").eq(3).find("input").val(precioNuevo);
              }else{
                console.log(porcentaje)
                var porcentajeFinal=porcentaje/100;
                console.log(precioAnterior*porcentajeFinal);
                var precioNuevo=parseFloat(precioAnterior)+(precioAnterior*porcentajeFinal);
                $(this).find("td").eq(3).find("input").val(precioNuevo);
              }
              
            }
						
					}

			});
  }
  function reiniciar(elemento,id){
    event.preventDefault();
    var idApp=$(elemento).attr('id');
    var token=yii.getCsrfToken();
        //alert(token+' - '+idApp+' - '+id);
        var url='index.php?r=contacto%2Fcontactoproducto&idApp='+idApp+'&idContacto='+id;
        $.ajax({
            url: url,
            type: 'POST',
            data: {_csrf: yii.getCsrfToken()},
            success: function (respuesta) {
              $('#modal-body-PE').html(respuesta);
              //$('#preciosEspeciales').modal('show');
            }
        });
        return false;
  }
JS;


$this->registerJs($script, View::POS_END, 'my-options');


?>

<div class="contacto-form">
     
    <?php $form = ActiveForm::begin(); ?>

    <?php
    $content=[
    $form->field($model, 'nombre')->textInput(['maxlength' => true])->label('Nombre y Apellido'),
    $form->field($model, 'cel')->textInput(['maxlength' => true])->label('Celular')
    ];
    $content2=[
        $form->field($model, 'direccion')->textInput(['maxlength' => true]),
        $form->field($model, 'localidad')->textInput(['maxlength' => true]),
        $form->field($model, 'tel')->textInput(['maxlength' => true])->label('Telefono Fijo'),
        $form->field($model, 'email')->textInput(['maxlength' => true]) ,
        $form->field($model, 'urlFoto')->textInput(['maxlength' => true]),
        $form->field($model, 'empresa')->textInput(['maxlength' => true]),
        $form->field($model, 'cuit')->textInput(['maxlength' => true]),
        $form->field($model, 'tipo')->textInput(['maxlength' => true])->label('Tipo de Contacto'),
        $form->field($model, 'id')->textInput()->label(false),
        $form->field($model, 'app_idApp')->textInput()->label(false)
    ];
    echo Collapse::widget([
        'items' => [
            // equivalent to the above
            [
                'label' => 'Contacto Rapido',
                'content' => $content,
                // open its content by default
                'contentOptions' => ['class' => 'in','style'=>'text-align:center;']
            ],
            // another group item
            [
                'label' => 'Agregar mas datos',
                'content' => $content2,
                'contentOptions' => ['style'=>'text-align:center;']
            ],
        ]
    ]);
    ?>

    <div class="form-group" >
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <button onclick="cuentaCorriente('<?php echo $_GET['app_idApp'];?>', <?php echo $_GET['id'];?>);" class="btn btn-primary" style=" float:right;">Cuenta Corriente</button>
        <button onclick="preciosEspeciales('<?php echo $_GET['app_idApp'];?>', <?php echo $_GET['id'];?>);" class="btn btn-info" style=" float:right;">Precios Especiales</button>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<div class="modal fade" id="cuentaCorriente" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ss">Cuenta Corriente <?php echo $model->nombre;?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modal-body-CC" class="modal-body">
      <div class="text-center"> 
         <img src="assets/imgs/espera.gif" alt="*" style="width:64px;padding:0px">
      </div>
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button id="modalBotAceptar" type="button" data-dismiss="modal" class="btn btn-success">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="preciosEspeciales" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ss">Precios Especiales <?php echo $model->nombre;?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modal-body-PE" class="modal-body">
      <div class="text-center"> 
         <img src="assets/imgs/espera.gif" alt="*" style="width:64px;padding:0px">
      </div>
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button id="modalBotAceptar" type="button" data-dismiss="modal" class="btn btn-success">Aceptar</button>
      </div>
    </div>
  </div>
</div>