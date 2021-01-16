
class Pantalla extends View{
    constructor(idApp){
        super(idApp);
        this.clienteSel=null;
        this.clientes=[];
        this.pedido=null;
    }

    refresh(){
        this.showDatosCliente()

    }
    /**
     * Evento seleccionar un cliente
     * @param {int} idCliente 
     */
    handlerSelectCliente=(idCliente)=>{
        if(idCliente>0){

            this.msg(this.MSG_ESPERA,true)         //hacemos visible el mensaje de espera

            $("#pedido-contacto_id").val(idCliente)
            
            this.clienteSel=Contacto.find(this.idApp,idCliente,(cliente)=>{
                if(cliente){

                    // ### EL cliente debe tener el precio de la lista
                    //     O es pecial segun el cliente
                    
                    this.clienteSel=cliente
                    this.msg(this.MSG_ESPERA,false) //ocultamos el mensaje de espera
                    
                    this.refresh()
                }else{
                    this.msg(Pantalla.MSG_ERROR,'No fue posible cargar el cliente')
                }
            });
            
        }
    }

    showDatosCliente(){
       
        let textHtml=`<h4>${this.clienteSel.nombre}</h4> 
                        <span>Empresa:${this.clienteSel.empresa}&nbsp;-&nbsp; Localidad:${this.clienteSel.localidad}</span>
                      <h5>Cel:${this.clienteSel.cel}</h5> 
                        `
        $("#dataCliente").html(textHtml)
    }

    /**
     * Evento del boton busca de cliente
     */
    handlerBuscarCliente(){
         //Desplegar la ventana flotante
         $("#body-ModalPedidos").html(Helpers.listFind('Clientes','list_clientes',`pantalla.listarContactos('list_clientes')`));
         this.listarContactos('list_clientes')

    }

    /**
     * 
     * @param {string} idLst id del la lista
     */
    listarContactos(idLst){
        $("#"+idLst).html('')
        let filtro=$("#textBuscar").val().toUpperCase();
        let ctosFiltrado=this.clientes.filter(function(pto){
           return   pto.nombre.toUpperCase().indexOf(filtro)>-1||
                    pto.empresa.toUpperCase().indexOf(filtro)>-1||
                    pto.cel.toUpperCase().indexOf(filtro)>-1 ||
                    pto.localidad.toUpperCase().indexOf(filtro)>-1
                })
         ctosFiltrado.forEach(element => {
           $("#"+idLst).append(`<li  id="p-${element.id}"class="list-group-item list-group-item-success" data-toggle="modal" data-target="#ModalPedidos"  onclick="pantalla.handlerSelectCliente(${element.id})"><strong>${element.nombre}</strong>&nbsp;&nbsp;(${element.empresa})</li>`)

       });
   }

   handlerNuevoDetalle(){
    
        $("#pedido-accion").val('newDetalle')
        $("#w1").submit()
    }


   handlerChangeDescuento(){
        this.calcularMostrarTotalPedido()
   } 

   handlerChangeImpuesto(){
        this.calcularMostrarTotalPedido()
    } 

    handlerChangePago(){
        this.calcularMostrarTotalPedido()
    } 

    handlerImprimir(){
        alert('En construcción...')
        this.generarComprobante()
    }
/**
     * Funcion que calcula el Monto total del pedido
     */
calcularMostrarTotalPedido(){
        let total=this.pedido?this.pedido.monto*1:0;
        let descuento=$("#pedido-descuento").val();
        let recargo=$("#pedido-impuesto").val();
        let pago=$("#pedido-pago").val();
        let saldo=$("#pedido-saldo").val();

      

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

        if(pago && pago*1>=0){
            if(saldo){
                $("#pedido-saldo").val((total-(pago*1)).toFixed(2))
            }
        }else{
             if(pago){
                $("#pedido-pago").val(0)
            }
        }
        $("#pedido-monto").val(total.toFixed(2));
    }

    // ======================IMPLEMENTAR EN UNA CLASE DISTINTA======================

    /**
     * Generar comprobante del pedido
     */
    generarComprobante(){
        

        let urlmembrete='assets/apps/'+idApp+'/membrete_1000x200.jpg';

        $("#ModalPedidosLabel").html('Comprobante');
        let body=` <div id="contenedorCanvas" style="border: 1px solid gray; overflow: scroll; height:500px">
        <canvas id="cvRecibo" width="600" height="700" style="background-color:#fff;">   </canvas>
      
        </div>
        <a id="download" class="btn btn-primary" download="recibo.jpg" href="" onclick="pantalla.download_img(this);">Bajar Recibo</a>
        `


        $("#body-ModalPedidos").html(""+continer(body)+"")

       
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
                ctx.fillText('Fecha pedido:'+$("#pedido-fechaini"), mg+col*2, altoM+rgl*1);
                ctx.fillText('Fecha entrega:'+$("#pedido-fechaentrega"), mg+col*2, altoM+rgl*2);

                ctx.moveTo(mg, altoM+5+rgl*2.5);
                ctx.lineTo(550,  altoM+5+rgl*2.5);
                ctx.stroke();

                ctx.font = '14px serif';
                ctx.fillText('Flete:'+($("#pedido-delivery")==='0'?' NO':' SI'), mg, altoM+rgl*4);
                ctx.fillText('Comentario:'+$("#pedido-comentarios"), mg, altoM+rgl*6);

                ctx.font = '16px serif';
                ctx.fillText('Detalle:', mg, altoM+rgl*7.5);
                ctx.font = '12px sans-serif';

                 ctx.moveTo(mg, altoM+5+rgl*8);
                ctx.lineTo(550,  altoM+5+rgl*8);
                ctx.stroke();
                let i=0;/*
                for(r of detalles){
                    if( r.estado==='ACTIVO'||r.estado==='NOEDIT'){

                        ctx.fillText(r.cantidad, mg*3, altoM+rgl*(10+i));
                        ctx.fillText(r.detalle+' '+r.producto, mg*3+Math.abs(col/5), altoM+rgl*(10+i));

                        ctx.fillStyle = "#FFFFFF";
                        ctx.fillRect(mg*5+col*2.3, altoM+rgl*(9+i), 200, 16);
                        ctx.fillStyle = "#000000";

                        ctx.fillText('$'+r.monto, mg*6+col*2.3, altoM+rgl*(10+i));
                        i++;

                    }
                    
                }*/
                ctx.moveTo(mg, altoM+5+rgl*28);
                ctx.lineTo(550,  altoM+5+rgl*28);
                ctx.stroke();
                ctx.font = '14px serif';
                ctx.fillText('Recargo: '+$("#pedido-impuesto"), mg, altoM+rgl*(30));
                ctx.fillText('Descuento: '+$("#pedido-descuento"), mg, altoM+rgl*(31));
                ctx.fillText('Pagado: $'+$("#pedido-pago"), mg, altoM+rgl*(33));
                ctx.font = '18px serif';
                ctx.fillText('Total: $'+$("#pedido-monto"), mg, altoM+rgl*(35))
                ctx.font = '20px serif';
                ctx.fillText('saldo: $'+$("#pedido-saldo"), mg+col*2, altoM+rgl*(35));
              
                 if($("#pedido-estado")==="PRESUPUESTO" || $("#pedido-estado")==="ESPERA"){
                     ctx.font = '10px serif';
                     ctx.fillText('Este presupuesto tiene validez  dentro los 15 días ', mg, altoM+rgl*(37))
                 }
               
               
                        

            }

            // Now set the source of the image that we want to load
            image.src =urlmembrete;

       


    }
   
    download_img(el){
        // get image URI from canvas object
        var imageURI = document.getElementById('cvRecibo').toDataURL("image/jpg");
        el.href = imageURI;
      }
      //===============================================================


}

var pantalla=null;

//Despues de cargar pantalla
window.onload=function() {
    //crear una intancia de la clase Pantalla
    pantalla=new Pantalla(idApp);
    //asignamos la lista de clientes
    pantalla.clientes=clientes;
    //asignamos datos del pedido
    pantalla.pedido=JSON.parse(pedido);
    pantalla.calcularMostrarTotalPedido();
   
     
 };