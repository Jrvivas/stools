<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Contacto;
use app\models\Util;
use yii\helpers\ArrayHelper;
use yii\web\View ;
//use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */
$contacto=Contacto::find()->where(['app_idApp'=>$model->app_idApp,'cliente'=>'SI'])->orderBy(['nombre'=>SORT_DESC])->all();
$clientes=ArrayHelper::map($contacto,'id','nombre');


$estados=['ESPERA'=>'Espera','APROBADO'=>'Aprobado','ENTREGADO'=>'Entregado','RECHAZADO'=>'Rechazado'];
$script="var idApp='".$model->app_idApp."';";

if(empty($model->estado)){
    $model->estado='ESPERA';
}

$detalles='[';
$sep='';
foreach($model->detallesPedido as $d){
        $detalles.=$sep.'{"id":'.$d->id.',"productos_id":'.$d->productos_id.',"producto":"'.$d->producto->nombre.'","cantidad":'.$d->cantidad.',"ancho":'.$d->ancho.
            ',"alto":'.$d->alto.',"inst":'.$d->inst.',"detalle":"'.$d->detalle.'","monto":'.$d->monto.',"estado":"ACTIVO"}';
            $sep=',';

}
if(empty($model->descuento)) $model->descuento=0;
if(empty($model->impuesto)) $model->impuesto=0;
if(empty($model->estado)) $model->estado='ESPERA';

$detalles.=']';
$script.="var detalles=".$detalles;

$idApp=$model->app_idApp;

$script .= <<<JS
//----------------------------------
    var isDebug=true;
    var productos=[];
    var productoSel=null;
   // var detalles=[];

    function listaProductos() {
        var a=new Server; 
        a.consulta('index.php?r=productos%2Flista-ajax&id='+idApp,{'_csrf': yii.getCsrfToken()},function(rst){
           
                if(rst){
                    productos=rst.data;
                     console.log("Datas :",productos);

                     dibujarBotones(productos);

                }
            });
            };
    
    function listarDetalle(){
            $("#detallesPedido").html(tabla())
        
    }

    function dibujarBotones(productos){
          if(productos){
            $("#lista_Productos").html('');
            let index=1;
            idBot="";
            for(prto of productos){
                idBot="producto_"+prto.id;
                $("#lista_Productos").append( "<button id=\""+idBot+"\" type=\"button\" class=\"btn btn-primary \" style=\"margin: 5px;\"  data-toggle=\"modal\" data-target=\"#ModalPedidos\">"+prto.nombre+"</button>");
                $("#"+idBot).click(function(){
                    //alert('Dibujar el dialogo para '+prto.nombre+ ' id:'+prto.id)
                    dibujarPanelNewDetallePedido(this.id)
                })
            }
          }
    }

    function getProducto(id){
        if (productos){
            for(p of productos){
                if((''+p.id)===id){
                    return p;
                }
              }
            return null;
        }
    }

    function dibujarPanelNewDetallePedido(idboton){

        productoSel=getProducto(idboton.split('_')[1]);
        //----------------------------------------21-07-2020
        //Obtener el precio de cliente si lo tiene
            let idCliente=document.querySelector("#pedido-contacto_id").value;
            if(idCliente){
                //alert(idCliente)
                new Server().consulta('index.php?r=precio%2Fget-precio-cliente-ajax&id='+idApp+'&idProducto='+productoSel.id+'&idCliente='+idCliente,{'_csrf': yii.getCsrfToken()},function(rta){
                        if(rta.error==0){
                            productoSel.precioCliente=rta.data.precio;
                            productoSel.fechaActPrecio=rta.data.fechaAct;
                            let lblprecio =document.querySelector("#lbl_precio");
                            lblprecio.innerHTML='<span style="color:grey; ">$'+productoSel.precio+'</span>'+
                                                '<span style="color:green;margin-left:10px">$'+productoSel.precioCliente+'</span>';
                            $("#detalle-pedido-monto").val(calcularMonto().toFixed(2)) 
                        }else{
                            productoSel.precioCliente=null;
                            productoSel.fechaActPrecio=null;
                            $("#detalle-pedido-monto").val(calcularMonto().toFixed(2)) 
                        }
                })
            }
        //---------------------------------------------------





        $("#ModalPedidosLabel").html(productoSel.nombre);
        if(productoSel){
              if(productoSel.unidad=='M2'){
                    let body=''+
                             '<p>'+productoSel.descripcion+'</p>'+
                             '<h5 id="lbl_precio">$'+productoSel.precio+'</h5>'+
                             input('pedido-cantidad','cantidad','1',4)+
                             input('pedido-ancho','Ancho(m)','1',4)+
                             input('pedido-alto','Alto(m)','1',4)+
                             selectSINO('pedido-instalar','Con instalacion','0')+
                             input('pedido-descripcion','Descripcion','',12)+
                             input('detalle-pedido-monto','Monto $','0.00',6);
                             //'<h2 id="detallePedidoMonto" class="text-center">$0.00</h2>'


                    $("#idModalPedido").html("<form>"+continer(body)+"</form")

                    $("#pedido-cantidad").keyup(function(evt){
                        $("#detalle-pedido-monto").val(calcularMonto().toFixed(2)) ;
                    })
                    $("#pedido-ancho").keyup(function(evt){
                        $("#detalle-pedido-monto").val(calcularMonto().toFixed(2)) ;
                    })
                    $("#pedido-alto").keyup(function(evt){
                        $("#detalle-pedido-monto").val(calcularMonto().toFixed(2)) ;
                    })
                    $("#pedido-instalar").change(function(evt){
                        $("#detalle-pedido-monto").val(calcularMonto().toFixed(2)) ;
                    })

                     $("#detalle-pedido-monto").val(calcularMonto().toFixed(2)) ;//Math.round(num * 100) / 100).toFixed(2)
                } 

              document.querySelector("#modalBotAceptar").onclick=aceptarBoton;
        }
        
     
       
    }

    function calcularMostrarTotalPedido(){
        let total=0;
        if(detalles.length>0){
            for(d of detalles){
                if(d.estado!='BORRADO'){
                    total+=d.monto;
                }
                
            }
        }
        if(isDebug){
            console.log('total calculado '+total)
        }
        document.querySelector("#pedido-monto").value=total;
    }

    function addDetalle(){
        let idProducto=productoSel.id;
        let nombreProducto=productoSel.nombre;
        let cantidad=$("#pedido-cantidad").val()*1;
        let ancho=$("#pedido-ancho").val()*1;
        let alto=$("#pedido-alto").val()*1;
        let inst=$("#pedido-instalar").val()*1;
        let monto=$("#detalle-pedido-monto").val()*1;
        let desc=$("#pedido-descripcion").val();

        let detalle={"id":0,
                    "productos_id":idProducto,
                    "producto":productoSel.nombre,
                    "cantidad":cantidad,
                     "ancho":ancho,
                     "alto":alto,
                     "inst":inst,
                     "detalle":desc,
                     "monto":monto,
                     "estado":"ACTIVO"};
        detalles.push(detalle);
        dibujarDetallesPedido();
        calcularMostrarTotalPedido()
        productoSel=null;
    }

    function calcularMonto(){
        let cantidad=$("#pedido-cantidad").val()*1;
        let ancho=$("#pedido-ancho").val()*1;
        let alto=$("#pedido-alto").val()*1;
        let inst=$("#pedido-instalar").val()*1;
        if(productoSel){
            let costIns=0
            let precio=productoSel.precio;
            if(productoSel.precioCliente && productoSel.precioCliente>0){
                precio=productoSel.precioCliente
            }
            if(inst){
                costIns=productoSel.costoBase*1
            }
           return Math.round((cantidad*ancho*alto*precio+(cantidad*ancho*alto*costIns)+productoSel.costoBase*1)/10)*10;
        }
        return 0;

    }

    function getVal(id){
        return $("#"+id).val();
    }

    function aceptarBoton(){
        addDetalle()
    }

    function borrarItem(item){
        if(item>-1){
            detalles[item].estado="BORRADO";
        }
        dibujarDetallesPedido()
        calcularMostrarTotalPedido()
        
    }

    function dibujarDetallesPedido(){
        document.querySelector("table tbody").innerHTML="";
        let rows='';
        let i=0;
        for(r of detalles){
            if( r.estado==='ACTIVO'){
               rows+='     <tr style="font-size: 1.5rem;">'+
              '     <td>'+r.cantidad+'</td>'+
              '     <td>'+r.detalle+'  ' +r.producto+'</td>'+
              '     <td>$'+r.monto+'</td>'+
              '     <td><button id="bot_item" onclick="borrarItem('+i+')" type="button" class="btn btn-danger">x</button></td>'+
              '     </tr>';
            }
            i++;

        }
        document.querySelector("table tbody").innerHTML=rows;

    }

    //--------------------------------Controles-------------------------------
    function continer(body){
        return'<div class="row" style="font-size:1.5em; background-color:rgba(255,255,255,0.5); border-style:solid; border-width:1px; border-radius:5px; border-color:var(--primary); padding:10px; margin:5px">'+body+'</div>';
    }

    function input(nombre,label,valor,col){
        if(!valor)valor='';
        return '<div class="col-md-'+col+'"> '+
               ' <div class="form-group field-'+nombre+' required">'+
               ' <label class="control-label" for="'+nombre+'">'+label+'</label>'+
               ' <input type="text" id="'+nombre+'" class="form-control" name="Pedido[nombre]" maxlength="45" aria-required="true" value="'+valor+'" >'+
               ' <div class="help-block"></div>'+
               ' </div>            </div>'
    }
    function selectSINO(nombre,label,valor){
        return'<div class="col-md-3"> <label class="control-label" for="'+nombre+'">'+label+'</label>'+
                '<select id="'+nombre+'" class="form-control" name="'+nombre+'" aria-invalid="false" value="'+valor+'">'+
                '<option value="0">No</option>'+
                '<option value="1">Si</option>'+
                '</select></div>';
    }

    function tabla(){
        return' <table class="table">'+
              '  <thead>'+
              '     <tr style="font-size: 1.5rem;">'+
              '     <th scope="col">Cant.</th>'+
              '     <th scope="col">Detalle</th>'+
              '     <th scope="col">Monto</th>'+
              '     <th scope="col"></th>'+
              '     </tr>'+
              ' </thead>'+
              ' <tbody>'+
              '     <tr>'+
              '     <th scope="row">-</th>'+
              '     <td>-</td>'+
              '     <td>-</td>'+
              '     <td>-</td>'+
              '     </tr>'+
              '  </tbody>'+
              ' </table>';  
    }
    //------------------------------------------------------------------------

    function botEnviar(){
            //obtener datos y verificar
            let newPedido={"id":getVal("pedido-id"),
                           "fechaini":getVal("pedido-fechaini"),
                           "fechaEntrega":getVal("pedido-fechaEntrega"),
                           "fechaentrega":"00-00-00",
                           "contacto_id":getVal("pedido-contacto_id"),
                           "nombre":getVal("pedido-nombre"),
                           "delivery":getVal("pedido-delivery"),
                           "comentario":getVal("pedido-comentario"),
                           "recargo":getVal("pedido-recargo"),
                           "descuento":getVal("pedido-descuento"),
                           "monto":getVal("pedido-monto"),
                           "estado":getVal("pedido-estado"),
                           "detalles":detalles};


            console.log('se enviará');     


            let server=new Server; 
            server.consulta('index.php?r=pedido%2Fcreate-ajax&id='+idApp,{'_csrf': yii.getCsrfToken(),'data':newPedido},function(rst){
            
                    if(rst){
                        console.log("Datas :",rst.data);
                        if(rst.error>0){
                            alert(rst.mensaje+' ',rst.data)
                        }else{
                            window.locationf="grafica/pedidos&id="+idApp;
                        }


                    }
                });               

    }
   
    $(document).ready(function() {
        listaProductos();
        listarDetalle();
        dibujarDetallesPedido()
        idApp='$idApp';
    });
JS;


$this->registerJs($script, View::POS_END, 'my-options'); 


?>
<div class="pedido-form">
    <div class="row">
        <div class="col-md-4 mt-5 ">
            <div class="row marco_app">
                <h2 class="text-center">Productos</h2>
                <div id="lista_Productos">
                </div>
            </div>
        </div>
        <div class="col-md-8">
                    <?php $form = ActiveForm::begin(); ?>
            <div class="row" style="font-size:1.5em; background-color:rgba(255,255,255,0.5); border-style:solid; border-width:1px; border-radius:5px; border-color:var(--primary); padding:10px; margin:5px">
            
            <div class="col-md-2"> 
                <?= $form->field($model, 'id')->textInput(['disabled' => true]) ?>
            </div>

            <div class="col-md-4"> 
                <?= $form->field($model, 'fechaIni')->textInput(['type' => 'date','value'=>(new DateTime($model->fechaIni))->format('Y-m-d')]) ?>
            </div>
            <div class="col-md-4"> 
                <?= $form->field($model, 'fechaEntrega')->textInput(['type' => 'date','value'=>(new DateTime($model->fechaEntrega))->format('Y-m-d')]) ?>
            </div>
            <div class="col-md-4"> 

                <?= $form->field($model, 'contacto_id')->dropDownList($clientes,  ['prompt'=>'Select...'])->label('Cliente'); ?>
            </div>

            <div class="col-md-4"> 
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-2"> 
                <?= $form->field($model, 'delivery')->dropDownList(['0'=>'No','1'=>'Si']) ?>
                </div>
            <div class="col-md-6"> 
                <?= $form->field($model, 'comentarios')->textInput(['maxlength' => true]) ?>

                </div>
             <div id="detallesPedido" class="col-md-12" style="height:300px">
             
             </div>   
            <div class="col-md-3"> 
                <?= $form->field($model, 'impuesto')->textInput(['maxlength' => true])->label('Recargo $') ?>
                </div>
        
            <div class="col-md-3"> 
                <?= $form->field($model, 'descuento')->textInput(['maxlength' => true])->label('Descuento $') ?>
                </div>    
            <div class="col-md-3"> 
                <?= $form->field($model, 'monto')->textInput(['maxlength' => true])->label('Monto $') ?>
                </div>

            <div class="col-md-4"> 
                <?= $form->field($model, 'estado')->dropDownList($estados) ?>
            </div>

            </div>

            <div class="form-group">
                <?= Html::a('Cancelar', ['grafica/pedidos','id'=>$model->app_idApp], ['class' => 'btn btn-danger  mx-2','style' => 'font-size:1.5em;']) ?>
             
                <button class="btn btn-success" onclick="botEnviar()" style="font-size:1.5em;">Aceptar</button>
                
            </div>

            <?php ActiveForm::end(); ?>
            
        </div>
    </div>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="ModalPedidos" tabindex="-1" role="dialog" aria-labelledby="ModalPedidosLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalPedidosLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="idModalPedido" class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button id="modalBotAceptar" type="button" data-dismiss="modal" class="btn btn-success">Aceptar</button>
      </div>
    </div>
  </div>
</div>


</div>
