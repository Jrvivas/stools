

const _page_selec_opcion=`
    <div class="row">
    <div class="col-md-3"> </div>
    <div class="col-md-6 text-center"> 
        <a id="bot_opt_presupuesto" class= "btn bot-inicio mx-2" style ="font-size:1.5em;"> <img src="assets/icons/card-checklist.svg" alt="Presupuesto"  style="width:72px;height:72px; margin:25px"/>  </a>
        <h3 style='margin-top: -0.5em;'>Presupuesto</h3>
    </div>
    <div class="col-md-3"> </div>
    </div>

    <div class="row">
    <div class="col-md-3"> </div>
    <div class="col-md-6 text-center"> 
        <a id="bot_opt_pedido" class= "btn bot-inicio mx-2" style ="font-size:1.5em;"> <img src="assets/icons/cart-check.svg" alt="Pedido"  style="width:72px;height:72px; margin:25px"/>  </a>
        <h3 style='margin-top: -0.5em;'>Pedido</h3>
    </div>
    <div class="col-md-3"> </div>
    </div>

    <div class="row">
    <div class="col-md-3"> </div>
    <div class="col-md-6 text-center"> 
        <a id="bot_opt_venta" class= "btn bot-inicio mx-2" style ="font-size:1.5em;"> <img src="assets/icons/cart-plus.svg" alt="Venta"  style="width:72px;height:72px; margin:25px"/>  </a>
       <h3 style='margin-top: -0.5em;'>Venta Rapida</h3>
    </div>
    <div class="col-md-3"> </div>
    </div>

    <div class="row">
    <div class="col-md-3"> </div>
    <div class="col-md-6 text-center"> 
        <a id="bot_opt_cancel" class= "btn bot-inicio mx-2" style ="font-size:1.5em;"> <img src="assets/imgs/icon-cancel.svg" alt="Venta"  style="width:72px;height:72px; margin:25px"/>  </a>
       <h3 style='margin-top: -0.5em;'>Volver</h3>
    </div>
    <div class="col-md-3"> </div>
    </div>
`;

const _page_presupuesto=document.querySelector("#pag-presupuesto").innerHTML
document.querySelector("#pag-presupuesto").innerHTML=''

/*const _page_new_detalle=document.querySelector("#pag_new_detalle").innerHTML
document.querySelector("#pag_new_detalle").innerHTML=''*/



class Pantalla extends View{
    constructor(idApp){
        super(idApp)
        this.clientes=[]
        this.clienteSel=null
        this.productos=[]
        this.productoSel=null
        this.detalles=[];
        this.detalleSel=null;
        this.pedido=new Pedido(0,idApp)

        this.pedido.fechaIni=new Date().toISOString().slice(0, 19).replace('T', ' ');
        this.pedido.fechaEntrega=new Date().toISOString().slice(0, 19).replace('T', ' ');

        this.pedido.estado=Pedido.ESTADO_PRESUPUESTO;

         //Operaciones de inicio
            // - Cargar clientes a lista 
        Contacto.getClientes(idApp,(rst)=>{
                if(rst){
                    this.clientes=rst;

                    if(this.debug)console.log("Clientes:",this.clientes);

                    this.refresh()
  
                }
            });

        Producto.getList(idApp,(rst)=>{
             if(rst){
                this.productos=rst
                if(this.debug)console.log("Productos:",this.productos);
                this.refresh()
             }
        })    
    }


    refresh(){
        super.refresh()
        $("#lbl_monto").html('$'+this.pedido.saldo)
        $("#lbl_cantidad_carrito").html(this.pedido.detalles.length)
        this.listCarrito()
    }



    addCarrito(){
        if(this.detalleSel){
           // this.detalleSel.setProducto(this.productoSel)
            this.pedido.addDetalle(this.detalleSel)
            this.refresh()
        }
    }
    listCarrito(){
          // limpiamos la lista y dibujamos los elementos en la lista    
          $("#list_carrito").empty() 
          let i=0;          
          for(let prto of pantalla.pedido.detalles){
              idBot="detalle_"+i++;
              let icon='assets/imgs/icon-cancel.svg'
              if(prto.urlFoto && prto.urlFoto!=''){
                  icon=clte.urlFoto
              }
          
              $("#list_carrito").append( `<li id="${idBot}" class="list-item " ">
             
                  <div class="row" >`+
                    
                    `  <div class="col-xs-7 truncate text-left">
                        <span style="font-size:0.9; margin:0px">${prto.cantidad+' '}${prto.detalle}</span>
                        <p style="font-size:0.8em ;margin:0px">${prto.producto.nombre}</p>
                      </div>
                       <div class="col-xs-3 text-right">
                          <h4>$${prto.monto}</h4>
                      </div>
                     <div id="detalle_delete_${idBot}" class="col-xs-2" >
                        <img src="${icon}" alt="Cte" class="boton-redondo" style="width: 24px; height:24px; background: red; padding: 2px;"/>
                     </div>
                  </div>
              
              </li>`)
              
              let me=this
              $("#"+idBot).click(function(){
                  //alert('Dibujar el dialogo para '+prto.nombre+ ' id:'+prto.id)
                  me.selectDetalle(this.id)//TODO
              })
            $("#detalle_delete_"+idBot).click(function(event){
                  //alert('Dibujar el dialogo para '+prto.nombre+ ' id:'+prto.id)
                  if(confirm("está seguro/a de querer borrar el item?"))me.deleteDetalle(this.id)//TODO
                  event.stopPropagation();
              })
              
          }
    }

    selectDetalle(idItem){
        let detalleEdit=null
        if(idItem){
            let item=idItem.split('_')[1]
            if(!isNaN(item))
            this.detalleSel=this.pedido.detalles[item*1]
            this.setPageSelect('pag_newdetalle',{edit:true})
        }

    }

}

var pantalla=null
//Despues de cargar pantalla
window.onload=function() {
    //crear una intancia de la clase Pantalla
    pantalla=new Pantalla(idApp);

    pantalla.addPagina(new Page('select_opcion',_page_selec_opcion,true,()=>{
        $("#bot_opt_presupuesto").click(()=>pantalla.setPageSelect('pag_presupuesto'))
        $("#bot_opt_pedido").click(()=>pantalla.setPageSelect('pag_pedido'))
        $("#bot_opt_venta").click(()=>pantalla.setPageSelect('pag_venta'))
        $("#bot_opt_cancel").click(()=>pantalla.loadUrl('index?r=pedido%2Findex&idApp='+this.idApp))
    }))

    /**Pagina presupuesto */
    pantalla.addPagina(new Page('pag_presupuesto',_page_presupuesto,false,function(){

            //Iniciamos la variable de depuracion en true
            this.debug=true
            let me=this
                   
            /**Definimos las variable que se usaran en la pagina */
          
            /**Definimos las funciones de la Pagina
             */
            




            //MANEJO DE EVENTOS-------------------------------------
           /* $(".boton-primary").click(function(){
                if(!$("#"+this.id.split("-")[1]+"-"+this.id.split("-")[2]).hasClass("in")) { //Revisar
                    $("#botonera").hide()
                }else{
                    $("#botonera").show()
                }
              
                me.refresh()
            })*/

            $("#pedido-fecha-entrega").change(function(){
                if(this.value.length==0){
                    me.parent.pedido.setFechaEntrega(getFechaAMDMysql(new Date()))
                }else{
                    me.parent.pedido.setFechaEntrega(this.value)
                }
                
                me.refresh()
            })
            $("#pedido-comentario").change(function(){
               
                me.parent.pedido.comentario=this.value
                me.refresh()
            })
            $("#pedido-descuento").change(function(){
                if(this.value.length==0){
                    me.parent.pedido.setDescuento('0')
                }else{
                   me.parent.pedido.setDescuento(this.value) 
                }
                
                me.refresh()
            })
            $("#pedido-recargo").change(function(){
                 if(this.value.length==0){
                    me.parent.pedido.setImpuesto('0')
                }else{
                     me.parent.pedido.setImpuesto(this.value)
                }
                me.refresh()
            })

            $("#textBuscarCliente").keyup(()=>{
                //this.refresh()
                this.listarClientes()
            })

          
            $("#boton_cancelar").click(()=>{
                this.parent.setPageSelect('select_opcion')
            })

            $("#boton_aceptar").click(()=>{
                if(this.parent.pedido.validate()){
                    this.parent.pedido.dbSet((rst)=>{
                        if(rst.error==0){
                           me.parent.loadUrl('index?r=pedido%2Findex&idApp='+me.parent.idApp)
                        }
                    })
                }
            })


            $("#boton_add_detalle").click(()=>{
                this.parent.productoSel=null
                this.parent.detalleSel=null
                this.parent.setPageSelect('pag_newdetalle',{edit:false}) //vamos a la pantalla para cargar los productos
                    
            })

            //------------------------------

 
            //Funccion que selecciona un cliente
            this.selectCliente=(idboton)=>{
               let clienteSel=this.parent.clientes.filter(function(cte){return cte.id==idboton.split('_')[1]})[0];
                if(clienteSel){
                    this.parent.clienteSel=clienteSel
                    this.parent.pedido.nombre=clienteSel.nombre+'_'+this.parent.fechaIni
                    this.parent.pedido.contacto_id=clienteSel.id
                   //$("#ped-cliente").removeClass("in")
                   $("#bot-ped-cliente").click()
              
                    $("#bot-ped-cliente").html(
                    `<img src="assets/imgs/cliente_buscar.svg" alt="Cliente" style="width: 42px ;float: left;"/>
                    <h4  style="margin:0px">${this.parent.clienteSel.nombre}</h4><p  style="margin:0px;font-size:0.8em">${this.parent.clienteSel.direccion+" - "+this.parent.clienteSel.localidad+" ("+this.parent.clienteSel.cel+")"}</p>`
                    )
              
   
                    this.refresh()
                   // $('html, body').animate( { scrollTop : 0 }, 800 ); // desplaza hacia arriba la this.parent
                    if(this.parent.pedido.detalles.length==0) this.parent.setPageSelect('pag_newdetalle',{edit:false}) //vamos a la pantalla para cargar los productos
                }

                
            }

            //que lista los clientes
            this.listarClientes=()=>{

                let filtro=$("#textBuscarCliente").val().toUpperCase()

                if(filtro.length>0){

                       $('html, body').animate( { scrollTop : 90 }, 800 ); // desplaza hacia arriba la pantalla
             
                }
                    let ClteFiltrado=this.parent.clientes.filter(function(cte){
                        return cte.nombre.toUpperCase().indexOf(filtro)>-1||cte.empresa.toUpperCase().indexOf(filtro)>-1||cte.cel.toUpperCase().indexOf(filtro)>-1||cte.tel.toUpperCase().indexOf(filtro)>-1||cte.localidad.toUpperCase().indexOf(filtro)>-1||cte.cuit.toUpperCase().indexOf(filtro)>-1
                    })

                    $("#list-cliente").empty() 
                
                    for(clte of ClteFiltrado){
                            idBot="cliete_"+clte.id;

                            let icon='assets/imgs/avatar_borde.svg'
                            if(clte.urlFoto && clte.urlFoto!=''){
                                icon=clte.urlFoto
                            }
                            $("#list-cliente").append( `<li id="${idBot}" class="list-item " >
                                <div class="row" >
                                    <div class="col-3">
                                        <img src="${icon}" alt="Cte" class="icon-avatar" style="width: 32px; height:32px"/>
                                    </div>
                                    <div class="col-9 truncate text-center">
                                      <h4 style="margin:0px">${clte.nombre}</h4>
                                      <p style="font-size:0.8em ;margin:0px">${clte.empresa}-${clte.localidad}</p>
                                     </div>
                                 </div>
                                </li>`)
                            
                            let me=this
                            $("#"+idBot).click(function(){
                                //alert('Dibujar el dialogo para '+prto.nombre+ ' id:'+prto.id)
                                me.selectCliente(this.id)
                            })
                        }
            
               
            }
            //=========================
            this.refresh=()=>{
                $("#pedido-fecha-entrega").val(getFechaAMDMysql(this.parent.pedido.fechaEntrega))
                $("#pedido-comentario").val(this.parent.pedido.comentario)
                $("#pedido-descuento").val(this.parent.pedido.descuento)
                $("#pedido-recargo").val(this.parent.pedido.impuesto)
                $("#lbl_monto").html('$'+this.parent.pedido.saldo)
                
            }
            
            //-------------------------------Operaciones de inicio
            // - Cargar clientes a lista 
            this.listarClientes()

            // Chequear si hay un cliente seleccionado
            if(this.parent.clienteSel){
                $("#bot-ped-cliente").html(
                `<img src="assets/imgs/cliente_buscar.svg" alt="Cliente" style="width: 42px ;float: left;"/>
                <h4  style="margin:0px">${this.parent.clienteSel.nombre}</h4><p  style="margin:0px;font-size:0.8em">${this.parent.clienteSel.direccion+" - "+this.parent.clienteSel.localidad+" ("+this.parent.clienteSel.cel+")"}</p>`
                )
            }else{
              $("#bot-ped-cliente").click()
              $("#textBuscarCliente").focus()
            }


 
        })
        )



    /**Calculadora */
     pantalla.addPagina(new PageNewDetalle('pag_newdetalle'))

     /**Calculadora */
     pantalla.addPagina(new PageCalculadora('pag_calculadora'))

     pantalla.addPagina(new TextEditor('pag_text_editor'))


     pantalla.refresh()
   
     
 };