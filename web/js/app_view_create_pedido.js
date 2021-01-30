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
`;

const _page_presupuesto=document.querySelector("#pag-presupuesto").innerHTML
document.querySelector("#pag-presupuesto").innerHTML=''

const _page_new_detalle=document.querySelector("#pag_new_detalle").innerHTML
document.querySelector("#pag_new_detalle").innerHTML=''

class Pantalla extends View{
    constructor(idApp){
        super(idApp)
        this.clientes=[]
        this.clienteSel=null
        this.productos=[]
        this.productoSel=null
        this.detalles=[];
        this.detalleSel=null;
        this.pedido=new Pedido()
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
        $("#lbl_monto").html('$'+this.pedido.monto)
        $("#lbl_cantidad_carrito").html(this.pedido.detalles.length)
        this.listCarrito()
    }



    addCarrito(){
        if(this.detalleSel){
            this.pedido.addDetalle(this.detalleSel)
            this.refresh()
        }
    }
    listCarrito(){
          // limpiamos la lista y dibujamos los elementos en la lista    
          $("#list_carrito").empty() 
          let i=0;          
          for(prto of pantalla.pedido.detalles){
              idBot="detalle_"+i++;
              let icon='assets/imgs/producto.svg'
              if(prto.urlFoto && prto.urlFoto!=''){
                  icon=clte.urlFoto
              }
          
              $("#list_carrito").append( `<li id="${idBot}" class="list-item " ">
             
                  <div class="row" >
                      <div class="col-3">
                          <img src="${icon}" alt="Cte" class="icon-avatar" style="width: 32px; height:32px"/>
                      </div>
                      <div class="col-9 truncate text-center">
                      <h4 style="margin:0px">${prto.detalle}</h4>
                      <p style="font-size:0.8em ;margin:0px">${prto.producto.nombre}${'  $'+prto.monto}</p>
                      </div>
                  </div>
              
              </li>`)
              
              let me=this
              $("#"+idBot).click(function(){
                  //alert('Dibujar el dialogo para '+prto.nombre+ ' id:'+prto.id)
                  this.selectDetalle(this.id)//TODO
              })
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
    }))

    /**Pagina presupuesto */
    pantalla.addPagina(new Page('pag_presupuesto',_page_presupuesto,false,function(){

            //Iniciamos la variable de depuracion en true
            this.debug=true
            let me=this
                   
            /**Definimos las variable que se usaran en la pagina */
          
            /**Definimos las funciones de la Pagina
             */
            this.fun={selectCliente:null,listarClientes:null}




            //MANEJO DE EVENTOS-------------------------------------
            $(".boton-primary").click(function(){
                if(!$("#"+this.id.split("-")[1]+"-"+this.id.split("-")[2]).hasClass("in")) { //Revisar
                    $("#botonera").hide()
                }else{
                    $("#botonera").show()
                }
              
                me.refresh()
            })

            $("#textBuscarCliente").keyup(()=>{
                //this.refresh()
                this.fun.listarClientes()
            })

          
            $("#boton_cancelar").click(()=>{
                pantalla.setPageSelect('select_opcion')
            })

            $("#boton_add_detalle").click(()=>{
                pantalla.productoSel=null
                pantalla.detalleSel=null
                pantalla.setPageSelect('pag_newdetalle') //vamos a la pantalla para cargar los productos
                    
            })

            //------------------------------

 
            //Funccion que selecciona un cliente
            this.fun.selectCliente=(idboton)=>{
               let clienteSel=pantalla.clientes.filter(function(cte){return cte.id==idboton.split('_')[1]})[0];
                if(clienteSel){
                    pantalla.clienteSel=clienteSel
                   
                   //$("#ped-cliente").removeClass("in")
                   $("#bot-ped-cliente").click()
              
                    $("#bot-ped-cliente").html(
                    `<img src="assets/imgs/cliente_buscar.svg" alt="Cliente" style="width: 42px ;float: left;"/>
                    <h4  style="margin:0px">${pantalla.clienteSel.nombre}</h4><p  style="margin:0px;font-size:0.8em">${pantalla.clienteSel.direccion+" - "+pantalla.clienteSel.localidad+" ("+pantalla.clienteSel.cel+")"}</p>`
                    )
              
   
                    this.refresh()
                   // $('html, body').animate( { scrollTop : 0 }, 800 ); // desplaza hacia arriba la pantalla
                    if(pantalla.pedido.detalles.length==0) pantalla.setPageSelect('pag_newdetalle') //vamos a la pantalla para cargar los productos
                }

                
            }

            //que lista los clientes
            this.fun.listarClientes=()=>{

                let filtro=$("#textBuscarCliente").val().toUpperCase()

                if(filtro.length>0){

                       $('html, body').animate( { scrollTop : 90 }, 800 ); // desplaza hacia arriba la pantalla
             
                }
                    let ClteFiltrado=pantalla.clientes.filter(function(cte){
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
                                me.fun.selectCliente(this.id)
                            })
                        }
            
               
            }
            //=========================
            this.refresh=()=>{

            }
            
            //-------------------------------Operaciones de inicio
            // - Cargar clientes a lista 
            this.fun.listarClientes()

            // Chequear si hay un cliente seleccionado
            if(pantalla.clienteSel){
                $("#bot-ped-cliente").html(
                `<img src="assets/imgs/cliente_buscar.svg" alt="Cliente" style="width: 42px ;float: left;"/>
                <h4  style="margin:0px">${pantalla.clienteSel.nombre}</h4><p  style="margin:0px;font-size:0.8em">${pantalla.clienteSel.direccion+" - "+pantalla.clienteSel.localidad+" ("+pantalla.clienteSel.cel+")"}</p>`
                )
            }else{
              $("#bot-ped-cliente").click()
              $("#textBuscarCliente").focus()
            }


 
        })
        )

     /**Pagina nuevo detalle */  
     pantalla.addPagina(new Page('pag_newdetalle',_page_new_detalle,false,function(){

                let me=this
                 //MANEJO DE EVENTOS-------------------------------------
                 $(".boton-primary").click(function(){
                    if(!$("#"+this.id.split("-")[1]+"-"+this.id.split("-")[2]).hasClass("in")) { //Revisar
                        $("#botonera").hide()
                    }else{
                        $("#botonera").show()
                      
                    }

                    me.refresh()
                })
    
                $("#textBuscarProducto").keyup(()=>{
                    this.fun.listarProductos()
                })
            
                $("#boton_cancelar_detalle").click(()=>{
                    pantalla.setPageSelect('pag_presupuesto')
                })
                $("#boton_aceptar_detalle").click(()=>{
                    me.addDetalle()
                    pantalla.setPageSelect('pag_presupuesto')
                })
                $("#boton_aceptar_add").click(()=>{
                    me.addDetalle()
                   pantalla.detalleSel=null
                   pantalla.productoSel=null
                   $("#detalle_opciones").hide(200)  // desplegamos el panel de detalles
                
                   //Cargamos los datos del producto a boton
                   $("#bot-ped-producto").html(    
                       `<img src="assets/imgs/producto.svg" alt="Cliente" style="width: 42px ;float: left;"/>
                       <h4  style="margin:0px">Buscar otro producto</h4><p  style="margin:0px;font-size:0.8em"></p>`
                     )
                   $("#bot-ped-producto").click()      // contaemos el Colapse
                   
                   me.refresh()
                })
     
     


                $("#detalle_cantidad").keyup(function(){
                    pantalla.detalleSel.setCantidad(this.value)
                    me.refresh()
                })

                //-------------------------------------------------------
                this.addDetalle=()=>{
                    if(pantalla.detalleSel){
                        pantalla.addCarrito()
                    }
                }
                this.fun={listarProductos:null}

                this.fun.listarProductos=()=>{
                    let filtroPrto=$("#textBuscarProducto").val().toUpperCase()

                    if(filtroPrto.length>0){
                        $('html, body').animate( { scrollTop : 90 }, 800 ); // desplaza hacia arriba la pantalla
                    }
    
                    let prtoFiltrado=pantalla.productos.filter(function(prto){
                        return prto.nombre.toUpperCase().indexOf(filtroPrto)>-1||prto.codigo.toUpperCase().indexOf(filtroPrto)>-1||prto.descripcion.toUpperCase().indexOf(filtroPrto)>-1 })
                        

                    // limpiamos la lista y dibujamos los elementos en la lista    
                    $("#list-producto").empty() 
                    
                    for(prto of prtoFiltrado){
                        idBot="prto_"+prto.id;
                        let icon='assets/imgs/producto.svg'
                        if(prto.urlFoto && prto.urlFoto!=''){
                            icon=clte.urlFoto
                        }
                    
                        $("#list-producto").append( `<li id="${idBot}" class="list-item " ">
                       
                            <div class="row" >
                                <div class="col-3">
                                    <img src="${icon}" alt="Cte" class="icon-avatar" style="width: 32px; height:32px"/>
                                </div>
                                <div class="col-9 truncate text-center">
                                <h4 style="margin:0px">${prto.nombre}(${prto.codigo})</h4>
                                <p style="font-size:0.8em ;margin:0px">${prto.descripcion}-${prto.precio}</p>
                                </div>
                            </div>
                        
                        </li>`)
                        
                        let me=this
                        $("#"+idBot).click(function(){
                            //alert('Dibujar el dialogo para '+prto.nombre+ ' id:'+prto.id)
                            me.fun.selectProducto(this.id)
                        })
                    }
                }

            //Funccion que selecciona un producto
                this.fun.selectProducto=(idboton)=>{
                    let productoSel=pantalla.productos.filter(function(cte){return cte.id==idboton.split('_')[1]})[0];
                    if(productoSel){
                        pantalla.productoSel=productoSel
                        
                        //$("#ped-cliente").removeClass("in")
                        $("#bot-ped-producto").click()      // contaemos el Colapse
                
                        //Cargamos los datos del producto a boton
                        $("#bot-ped-producto").html(    
                            `<img src="assets/imgs/producto.svg" alt="Cliente" style="width: 42px ;float: left;"/>
                            <h4  style="margin:0px">${pantalla.productoSel.nombre+" ("+pantalla.productoSel.precio+")"}</h4><p  style="margin:0px;font-size:0.8em">${pantalla.productoSel.descripcion+" - "+pantalla.productoSel.unidad}</p>`
                            )

                        this.fun.iniciarDetalle();

                        this.refresh()
                        
    
                        //pantalla.setPageSelect('pag_newdetalle') //vamos a la pantalla para cargar los productos
                    }
                    $('html, body').animate( { scrollTop : 0 }, 300 ); // desplaza hacia arriba la pantalla
                    
                }


            //Funccion que inicio aun nuevo detalle
            this.fun.iniciarDetalle=()=>{

                pantalla.detalleSel=new DetallePedido()
                $("#detalle_opciones").show(200)  // desplegamos el panel de detalles

                pantalla.detalleSel.producto=pantalla.productoSel
                pantalla.detalleSel.setCantidad(1)
                $("#detalle_cantidad").focus()
                $('html, body').animate( { scrollTop :90 }, 100 ); // desplaza hacia arriba la pantalla
                this.refresh()
            } 
            
            

           this.refresh=()=>{
                     
             if(pantalla.detalleSel)$("#detalle_monto").val(pantalla.detalleSel.monto)

           }

           //------------INICIO---
            // - Cargar Productos a lista 
            this.fun.listarProductos()

            // Chequear si hay un cliente seleccionado
            if(pantalla.productoSel){
                $("#bot-ped-producto").html(
                `<img src="assets/imgs/producto.svg" alt="Cliente" style="width: 42px ;float: left;"/>
                <h4  style="margin:0px">${pantalla.productoSel.nombre+" ("+pantalla.productoSel.precio+")"}</h4><p  style="margin:0px;font-size:0.8em">${pantalla.productoSel.descripcion+" - "+pantalla.productoSel.unidad}</p>`
                )
            }else{
              $("#bot-ped-producto").click()
              $("#textBuscarProducto").focus()
              
            }


     }))


     pantalla.refresh()
   
     
 };