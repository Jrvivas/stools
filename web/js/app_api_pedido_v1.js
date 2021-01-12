
var isDebug=true;
var productos=[];
var productoSel=null;
var detalles=[];
var clienteSel=null;
var hostApp='http://'+window.location.host+'/apps/web';



/**Dibuja los botones de productos */
function listaProductos() {
    var a=new Server; 
    a.consulta('index.php?r=productos%2Flista-ajax&id='+idApp,{'_csrf': yii.getCsrfToken()},function(rst){
        
            if(rst){
                productos=rst.data;
                    console.log("Datas :",productos);

                    dibujarBotones(productos);

            }
        });
  }

function  listarProductosCateg(codigo){
    let codigo=codigo.replace('cat_','');
    (new server).consulta('index.php?r=productos%2Flista-ajax&id='+idApp+'&catCodigo='+codigo,{'_csrf': yii.getCsrfToken()},function(rst){
        
            if(rst){
                productos=rst.data;
                    console.log("Datas :",productos);

                    dibujarBotones(productos);

            }
        });
 
}

/**Dibuja los botones de productos */
function listaCategorias() {
    var a=new Server; 
    a.consulta('index.php?r=categoria%2Flista-ajax&idApp='+idApp,{'_csrf': yii.getCsrfToken()},function(rst){
        
            if(rst){
                categorias=rst.data;
                    console.log("categorias :",Categorias);

                    dibujarBotonesCateg(categorias);

            }
        });
  };

  
 /**
  * Listar los Clientes
  */
function listaClientes(filtro) {
    var a=new Server; 
    a.consulta('index.php?r=contacto%2Flista-ajax&id='+idApp,{'_csrf': yii.getCsrfToken()},function(rst){
        
            if(rst){
                clientes=rst.data;
                    console.log("Datas :",clientes);

                    dibujarCliente(clientes,filtro);

            }
        });
  };


  
/**Dibuja los detalles del pedido
 */        
function listarDetalle(){
        $("#detallesPedido").html(tabla())
    
}

/**
 * Selector de Clientes
 * 
 */
function seleccionarCliente(){
    let htmltext=`<div class="row">
                        <div class="col-md-12 mt-5 ">
                            <div class="row marco_app" style="height: 500px; overflow: overlay;">
                                <h2 class="text-center">Clientes</h2>
                                <div> Buscar <input  class="form-control" type="text" onkeyup="dibujarCliente(clientes,this.value)"/>
                                <ul  class="list-group "  style="    margin-top: 10px;" id="lista_clientes">
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>`

     //if($("#pedido-contacto_id").val()!=''){

             $("#idModalPedido").html(htmltext);                 
             $("#ModalPedidosLabel").html('Lista de Clientes'); 
            listaClientes(''); 
    // }else{
   //      $("#idModalPedido").html("<h2>Por favor seleccione un cliente, gracias</h2>");  
    // }

     


}


/**Seleccionar el producto
 * 
 */
function seleccionarProducto(){
    let htmltext=`<div class="row">
                        <div class="col-md-12 mt-5 ">
                            <div class="row marco_app">
                                <h2 class="text-center">Productos</h2>
                                <div id="lista_Productos">
                                </div>
                            </div>
                        </div>
                    </div>`

     if($("#pedido-contacto_id").val()!=''){

             $("#idModalPedido").html(htmltext);                 
             $("#ModalPedidosLabel").html('Lista de Productos'); 
            // listaProductos(); 
             listaCategorias()
     }else{
         $("#idModalPedido").html("<h2>Por favor seleccione un cliente, gracias</h2>");  
     }

     


}

   function dibujarBotonesCateg(categorias){
          if(categorias){
            $("#lista_Productos").html('');
            let index=1;
            idBot="";
            for(Cat of categorias){
                idBot="cat_"+Cat.id;
                //$("#lista_Productos").append( "<button id=\""+idBot+"\" type=\"button\" class=\"btn btn-primary \" style=\"margin: 5px;\"  data-toggle=\"modal\" data-target=\"#ModalPedidos\">"+Cat.nombre+"</button>");
                $("#lista_Productos").append( "<button id=\""+idBot+"\" type=\"button\" class=\"btn btn-primary \" style=\"margin: 5px;\"  >"+Cat.nombre+"</button>");
                
                $("#"+idBot).click(function(){
                    //alert('Dibujar el dialogo para '+Cat.nombre+ ' id:'+Cat.id)
                   listarProductosCateg(this.id)
                })
            }
          }
    }

    function dibujarBotones(productos){
          if(productos){
            $("#lista_Productos").html('');
            let index=1;
            idBot="";
            for(prto of productos){
                idBot="producto_"+prto.id;
                //$("#lista_Productos").append( "<button id=\""+idBot+"\" type=\"button\" class=\"btn btn-primary \" style=\"margin: 5px;\"  data-toggle=\"modal\" data-target=\"#ModalPedidos\">"+prto.nombre+"</button>");
                $("#lista_Productos").append( "<button id=\""+idBot+"\" type=\"button\" class=\"btn btn-primary \" style=\"margin: 5px;\"  >"+prto.nombre+"</button>");
                
                $("#"+idBot).click(function(){
                    //alert('Dibujar el dialogo para '+prto.nombre+ ' id:'+prto.id)
                    dibujarPanelNewDetallePedido(this.id)
                })
            }
          }
    }

    function dibujarCliente(clientes,filtro){
          if(clientes){

            $("#lista_clientes").html('');
            let index=1;
            idBot="";
            filtro=filtro.toUpperCase()
            let ClteFiltrado=clientes.filter(function(cte){
                return cte.nombre.toUpperCase().indexOf(filtro)>-1||cte.empresa.toUpperCase().indexOf(filtro)>-1||cte.cel.toUpperCase().indexOf(filtro)>-1||cte.tel.toUpperCase().indexOf(filtro)>-1||cte.localidad.toUpperCase().indexOf(filtro)>-1||cte.cuit.toUpperCase().indexOf(filtro)>-1
            })

            for(clte of ClteFiltrado){
                idBot="cliete_"+clte.id;
                //$("#lista_Productos").append( "<button id=\""+idBot+"\" type=\"button\" class=\"btn btn-primary \" style=\"margin: 5px;\"  data-toggle=\"modal\" data-target=\"#ModalPedidos\">"+prto.nombre+"</button>");
                $("#lista_clientes").append( `<li id="${idBot}" class="list-group-item list-group-item-success" data-toggle="modal" data-target="#ModalPedidos">${clte.nombre}(${clte.empresa})-${clte.localidad}</li>`)
                 
                
                $("#"+idBot).click(function(){
                    //alert('Dibujar el dialogo para '+prto.nombre+ ' id:'+prto.id)
                    selectCliente(this.id)
                    document.querySelector('#detalle-contacto-select').innerHTML='<h2>'+clte.nombre+'</h2><p>'+clte.empresa+'</p>'
                })
            }
          }
    }


    function selectCliente(idboton){
        clienteSel=clientes.filter(function(cte){return cte.id===idboton.split('_')[1]});
        $("#pedido-contacto_id").val(idboton.split('_')[1])
    }


    

    function getProducto(id){
        if (productos){
            for(p of productos){
                if((''+p.id)===id){
                    return p;
                }
              }            return null;
        }
    }


    //Dibujar nueva pantalla
    function dibujarPanelNewDetallePedido(idboton){

        productoSel=getProducto(idboton.split('_')[1]);


        //---------------------------------------------------
        $("#ModalPedidosLabel").html(productoSel.nombre);
        if(productoSel){

                if(productoSel.unidad==='UN' || productoSel.unidad==='CJ' || productoSel.unidad==='BT'){
                    let body=''+
                             '<p>'+productoSel.descripcion+'</p>'+
                             '<h5 id="lbl_precio" >$'+productoSel.precio+'</h5>'+
                             input('detalle-pedido-cantidad','cantidad','1',3)+
                             input('detalle-pedido-unidad','unidades','0',3)+
                             input('detalle-pedido-caja','Cajas','0',3)+
                             input('detalle-pedido-pallet','Pallets','0',3)+
                             input('detalle-pedido-descripcion','Descripcion','',12)+
                             input('detalle-pedido-monto','Monto $','0.00',6);
                             //'<h2 id="detallePedidoMonto" class="text-center">$0.00</h2>'


                    $("#idModalPedido").html("<form>"+continer(body)+"</form")

                    $("#detalle-pedido-cantidad,#detalle-pedido-unidad,#detalle-pedido-caja,#detalle-pedido-pallet").keyup(function(evt){
                        if(evt.target.id==='detalle-pedido-cantidad'){
                           $("#detalle-pedido-unidad").val(0);
                           $("#detalle-pedido-caja").val(0);
                           $("#detalle-pedido-pallet").val(0);
                        }
                        $("#detalle-pedido-monto").val(calcularMonto().toFixed(2)) ;
                    })
                  
                     $("#detalle-pedido-monto").val(calcularMonto().toFixed(2)) ;//Math.round(num * 100) / 100).toFixed(2)
                } 
                if(productoSel.unidad=='M2'){
                    let body=''+
                             '<p>'+productoSel.descripcion+'</p>'+
                             '<h5 id="lbl_precio">$'+productoSel.precio+'</h5>'+
                             input('detalle-pedido-cantidad','cantidad','1',4)+
                             input('detalle-pedido-ancho','Ancho(m)','1',4)+
                             input('detalle-pedido-alto','Alto(m)','1',4)+
                             selectSINO('detalle-pedido-instalar','Con instalacion','0')+
                             input('detalle-pedido-descripcion','Descripcion','',12)+
                             input('detalle-pedido-monto','Monto $','0.00',6);
                             //'<h2 id="detallePedidoMonto" class="text-center">$0.00</h2>'


                            $("#idModalPedido").html("<form>"+continer(body)+"</form")

                            $("#detalle-pedido-cantidad,#detalle-pedido-ancho,#detalle-pedido-alto,#detalle-pedido-instalar").keyup(function(evt){
                                $("#detalle-pedido-monto").val(calcularMonto().toFixed(2)) ;
                            })
                            $("#detalle-pedido-instalar").change( function(evt){$("#detalle-pedido-monto").val(calcularMonto().toFixed(2)) ;
                            });


                            $("#detalle-pedido-monto").val(calcularMonto().toFixed(2)) ;//Math.round(num * 100) / 100).toFixed(2)
                        } 



              document.querySelector("#modalBotAceptar").onclick=aceptarBoton;
        }


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
     
       
    }


    /**
     * Funcion que calcula el Monto total del pedido
     */
    function calcularMostrarTotalPedido(){
        let total=0;
        let descuento=$("#pedido-descuento").val();
        let recargo=$("#pedido-impuesto").val();
        let pago=$("#pedido-pago").val();
        let saldo=$("#pedido-saldo").val();

       

        if(detalles.length>0){
            for(d of detalles){
                if(d.estado!='BORRADO'){
                    total+=d.monto;
                }
                
            }
        }

        if(descuento.indexOf('%')>-1){
            let valor=descuento.split('%')[0]*1
            if(valor){
                descuento=(total*valor/100)
            }
        }
        if(recargo.indexOf('%')>-1){
            let valor=recargo.split('%')[0]*1
            if(valor){
                recargo=(total*valor/100)
            }
        }


        if(descuento*1>0){
            total-=descuento*1;
        }else{
            $("#pedido-descuento").val(0);
        }
        if(recargo*1>0){
            total+=recargo*1;
        }else{
            $("#pedido-impuesto").val(0);
        }


        if(isDebug){
            console.log('total calculado '+total)
        }

        if(pago && pago*1>=0){
            if(saldo){
                $("#pedido-saldo").val(total-(pago*1))
            }
        }else{
             if(pago){
                $("#pedido-pago").val(0)
            }
        }
        document.querySelector("#pedido-monto").value=total;
    }

/**funcion que agrega un detalle
 * 
 */
    function addDetalle(){
        let idProducto=productoSel.id;
        let nombreProducto=productoSel.nombre;
        let cantidad=$("#detalle-pedido-cantidad").val()*1;
        let ancho=$("#detalle-pedido-ancho").val()*1;
        let alto=$("#detalle-pedido-alto").val()*1;
        let inst=$("#detalle-pedido-instalar").val()*1;
        let monto=$("#detalle-pedido-monto").val()*1;
        let desc=$("#detalle-pedido-descripcion").val().replace('"',"'");

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
        //Obtener Valores
        let cantidad=$("#detalle-pedido-cantidad").val()*1;
        let ancho=0;
        let alto=0;
        let inst=0;
        let unidades=$("#detalle-pedido-unidad").val()*1;;
        let cajas=$("#detalle-pedido-caja").val()*1;;
        let pallets=$("#detalle-pedido-pallet").val()*1;

        $("#label-detalle-pedido-cantidad").html('Cantidad de productos')
        if(productoSel.unidad==='CJ'){
            $("#label-detalle-pedido-cantidad").html('Cantidad de cajas')
        }
        if(productoSel.unidad==='PL'){
            $("#label-detalle-pedido-cantidad").html('Cantidad de pallets')

        }

        //Manejo de los controles de unidades
        if(!unidades && unidades<0){
            unidades=0;
            $("#detalle-pedido-unidad").val(0)
        }
        if(!cajas && cajas<0){
            cajas=0;
            $("#detalle-pedido-caja").val(0)
         }

         if(!pallets && pallets<0){
            pallets=0;
            $("#detalle-pedido-pallet").val(0)
         }


        if(productoSel.unidad=='M2'){
            ancho=$("#detalle-pedido-ancho").val()*1;
            alto=$("#detalle-pedido-alto").val()*1;
            inst=$("#detalle-pedido-instalar").val()*1;
        }

        if(productoSel){
            let costIns=0
            let precio=productoSel.precio;
            
            //Precio diferencial por cliente
            if(productoSel.precioCliente && productoSel.precioCliente>0){
                precio=productoSel.precioCliente
            }
            // Manejo del precio de instalacion
            if(inst){
                costIns=productoSel.costoInstalacion*1
            }
            //Manejo de precio por unidad
            if(productoSel.unidad=='M2'){
        
                $("#detalle-pedido-descripcion").val('Medidas ('+ancho+'m x '+alto+'m)'+(inst==1?' más colocación ':''))
                return Math.round((cantidad*ancho*alto*precio+(cantidad*ancho*alto*costIns)+productoSel.costoBase*1)/10)*10;
            }

           
            if(unidades>0||cajas>0||pallets>0){
                 $("#detalle-pedido-descripcion").val('')
                let txtDesc='';
                //Calculamos la cantidad de productos segun lo indicado
                cantidad=unidades+cajas*productoSel.unxCaja+pallets*productoSel.cajaxPallet*productoSel.unxCaja;
                $("#detalle-pedido-cantidad").val(cantidad);
                txtDesc='son '+(unidades>0?unidades+' unidades ':'')+(cajas>0?cajas+' cajas ':'')+(pallets>0?pallets+' pallets':'');
                
                $("#detalle-pedido-descripcion").val(txtDesc)
                
                if(productoSel.unidad==='CJ'){
                    precio=precio/productoSel.unxCaja
                }
                if(productoSel.unidad==='PL'){
                    precio=precio/productoSel.unxCaja/productoSel.cajaxPallet

                }
                $("#label-detalle-pedido-cantidad").html('Cantidad de productos')

            }

           return Math.round((cantidad*precio+productoSel.costoBase*1)*10)/10;
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
              '     <td><button id="bot_item_'+i+'" onclick="borrarItem('+i+')" type="button" class="btn btn-danger">x</button></td>'+
              '     </tr>';
            }
            i++;

        }
        document.querySelector("table tbody").innerHTML=rows;

    }


    function botEnviar(obj,tipoApp){
            obj.disabled = true; // ponemos el boton inactivo para que no envia varias veces
            //obtener datos y verificar
            let newPedido={"id":getVal("pedido-id"),
                           "fechaini":getVal("pedido-fechaini"),
                           "fechaentrega":getVal("pedido-fechaentrega"),
                           "fechafin":"00-00-00",
                           "contacto_id":getVal("pedido-contacto_id"),
                           "nombre":'Pedido_'+getVal("pedido-fechaini")+'_'+$("#pedido-contacto_id").find('option:selected').text().replace(' ','_'),
                           "delivery":getVal("pedido-delivery"),
                           "comentario":getVal("pedido-comentarios").replace('"',"'"),
                           "impuesto":getVal("pedido-impuesto"),
                           "descuento":getVal("pedido-descuento"),
                           "monto":getVal("pedido-monto"),
                           "pago":getVal("pedido-pago"),
                           "saldo":getVal("pedido-saldo"),
                           "estado":getVal("pedido-estado"),
                           "detalles":detalles};


            console.log('se enviará');     


            let server=new Server; 
            server.consulta('index.php?r=pedido%2Fcreate-ajax&id='+idApp,{'_csrf': yii.getCsrfToken(),'data':newPedido},function(rst){
            
                    if(rst){
                        console.log("Datas :",rst.data);
                        if(rst.error>0){
                            alert(rst.mensaje+' ',rst.data)
                            obj.disabled = false; // abilitamos el boton para resolver el problema y seguir

                        }else{
                            window.location.href ="index.php?r="+tipoApp+"/pedidos&id="+idApp;
                        }


                    }
                });               

    }

    /**
     * Generar comprobante del pedido
     */
    function generarComprobante(){
        

        let urlmembrete='assets/apps/'+idApp+'/membrete_1000x200.jpg';

        $("#ModalPedidosLabel").html('Comprobante');
        let body=` <div id="contenedorCanvas" style="border: 1px solid gray; overflow: scroll; height:500px">
        <canvas id="cvRecibo" width="600" height="700" style="background-color:#fff;">   </canvas>
      
        </div>
        <a id="download" class="btn btn-primary" download="recibo.jpg" href="" onclick="download_img(this);">Bajar Recibo</a>
        `


        $("#idModalPedido").html(""+continer(body)+"")

       
            // Create an image object. This is not attached to the DOM and is not part of the page.
            var image = new Image();

            // When the image has loaded, draw it to the canvas
            image.onload = function()
            {
               
                var ctx = document.getElementById('cvRecibo').getContext('2d');
                let rgl=15;
                let mg=8;
                let col=200;
                let altoM=125;
                ctx.fillStyle = "#FFFFFF";
                ctx.fillRect(0, 0, 600, 800);
                ctx.fillStyle = "#000000";

                ctx.drawImage(image, 0, 0,1000,200,0,0,600,120);
                ctx.font = '16px serif';
                ctx.fillText('Cliente:', mg, altoM+rgl);
                ctx.font = '14px serif';
                ctx.fillText($("#pedido-contacto_id").find('option:selected').text(), mg, altoM+rgl*2);
                ctx.fillText('Fecha pedido:'+getVal("pedido-fechaini"), mg+col*2, altoM+rgl*1);
                ctx.fillText('Fecha entrega:'+getVal("pedido-fechaentrega"), mg+col*2, altoM+rgl*2);

                ctx.moveTo(mg, altoM+5+rgl*2.5);
                ctx.lineTo(550,  altoM+5+rgl*2.5);
                ctx.stroke();

                ctx.font = '14px serif';
                ctx.fillText('Flete:'+(getVal("pedido-delivery")==='0'?' NO':' SI'), mg, altoM+rgl*4);
                ctx.fillText('Comentario:'+getVal("pedido-comentarios"), mg, altoM+rgl*6);

                ctx.font = '16px serif';
                ctx.fillText('Detalle:', mg, altoM+rgl*7.5);
                ctx.font = '12px sans-serif';

                 ctx.moveTo(mg, altoM+5+rgl*8);
                ctx.lineTo(550,  altoM+5+rgl*8);
                ctx.stroke();
                let i=0;
                for(r of detalles){
                    if( r.estado==='ACTIVO'){

                        ctx.fillText(r.cantidad, mg*5, altoM+rgl*(10+i));
                        ctx.fillText(r.detalle+' '+r.producto, mg*5+Math.abs(col/3), altoM+rgl*(10+i));
                        ctx.fillText('$'+r.monto, mg*5+col*2.3, altoM+rgl*(10+i));

                    }
                    i++;
                }
                ctx.moveTo(mg, altoM+5+rgl*28);
                ctx.lineTo(550,  altoM+5+rgl*28);
                ctx.stroke();
                ctx.font = '14px serif';
                ctx.fillText('Recargo: '+getVal("pedido-impuesto"), mg, altoM+rgl*(29+i));
                ctx.fillText('Descuento: '+getVal("pedido-descuento"), mg, altoM+rgl*(30+i));
                ctx.fillText('Pagado: $'+getVal("pedido-pago"), mg, altoM+rgl*(32+i));
                ctx.font = '18px serif';
                ctx.fillText('Total: $'+getVal("pedido-monto"), mg, altoM+rgl*(34+i))
                ctx.font = '20px serif';
                ctx.fillText('saldo: $'+getVal("pedido-saldo"), mg+col*2, altoM+rgl*(34+i));
              
                 if(getVal("pedido-estado")==="PRESUPUESTO" || getVal("pedido-estado")==="ESPERA"){
                     ctx.font = '10px serif';
                     ctx.fillText('Este presupuesto tiene validez  dentro los 15 días ', mg, altoM+rgl*(36+i))
                 }
               
               
                        

            }

            // Now set the source of the image that we want to load
            image.src =urlmembrete;

       


    }
   
    download_img = function(el) {
        // get image URI from canvas object
        var imageURI = document.getElementById('cvRecibo').toDataURL("image/jpg");
        el.href = imageURI;
      };