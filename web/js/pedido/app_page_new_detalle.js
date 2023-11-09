class PageNewDetalle extends Page{
    static _page_new_detalle=`
    <div class="row mt-3">
    <!-- <div class="col-2 col-xs-1"></div>-->
     <div class="col-8 col-xs-12">
         <button id="bot-ped-producto"  class="btn boton-primary" style="height:50px; width:100%" data-toggle="collapse" data-target="#ped-producto">
         <img src="assets/imgs/carrito_cantidad.svg" alt="Cliente" style="width: 42px ;float: left;"/>
              <h4>Producto</h4>
         </button>

         <div id="ped-producto" class="collapse">
          <!-- Contenido-->
          <div class="row">
                     <div class="col-md-12 mt-3 ">
                         <div class="row marco_app" style="height: 300px; overflow: overlay;">
                             <div>  <img src="assets/imgs/producto_buscar.svg" alt="producto" style="width: 42px ;float: left; background: var(--app-ctr-bg-color); border-radius: 10px; padding: 5px;margin-right: 10px;"/> 
                             <input  id="textBuscarProducto" class="" placeholder="Buscar Producto" type="text"  style="width: 70% " />
                                 <ul  class="list-group "  style=" margin-top: 10px;" id="list-producto">
                                     <li>cargando...</li>
                                 </ul>
                             </div>
                         </div>
                     </div>
                 </div>
          <!-- -->   
         </div>
     </div>
    <!-- <div class="col-2 col-xs-1"></div>-->
 </div>

     <!-- Opciones de destalles simple-->
     <div class="row  mt-3 marco_app" id="detalle_opciones_simple" style=" margin: 5px 11%; display:none">
         <style>
             label{
                 font-size: 0.8em;
             }
         </style>

         <div class="col-xs-12">
             <!-- Manejo de cantidad -->
             <div class="row mt-3">
                 <div class="col">
                     <label for="detalle_cantidad">Cantidad</label>
                     <input class="input-edit" type="number" id="detalle_cantidad" value="1" style="width: 50%";>
                 </div>
             </div>
             <!-- Manejo de descripción -->
             <div class="row mt-3">
                 <div class="col">
                     <label for="detalle_descripcion">Descripción</label>
                     <input class="input-edit" type="text" id="detalle_descripcion" placeholder="Escriba alguna descripción" style="width: 100%;font-size:0.8em">
                 </div>
             </div>

               <!-- Manejo de Monto-->
               <div class="row mt-3">
                 <div class="col">
                 <img src="assets/imgs/suma_monto.svg" alt="producto" style="width: 32px ;float: left; background: var(--app-ctr-bg-color); border-radius: 10px; padding: 5px;margin-right: 10px;"/>
                     <label for="detalle_monto">Monto</label>
                     <input class="input-edit" type="number" id="detalle_monto" value="0.00" style="max-width: 130px; float:right; text-align:right">
                 </div>
             </div>

         </div>

     </div>

     <!-- Opciones de destalles en productos en cajas-->
     <div class="row  mt-3 marco_app" id="detalle_opciones_cajas" style=" margin: 5px 11%; display:none">
         <style>
             label{
                 font-size: 0.8em;
             }
         </style>

         <div class="col-xs-12">
             <!-- Manejo de unidades -->
             <div class="row mt-3">
                 <div class="col">
                     <label for="detalle_cantidad_unidad">Unidades</label>
                     <inputclass="input-edit"  type="number" id="detalle_cantidad_unidad" value="1" style="width: 50%";>
                 </div>
             </div>
             <!-- Manejo de Cajas -->
             <div class="row mt-3">
                 <div class="col">
                     <label for="detalle_cajas">Cajas</label>
                     <input class="input-edit" type="number" id="detalle_cajas" value="1" style="width: 50%";>
                 </div>
             </div>

             <!-- Manejo de Pallet -->
             <div class="row mt-3">
                 <div class="col">
                     <label for="detalle_pallets">Pallets</label>
                     <input class="input-edit" type="number" id="detalle_pallets" value="1" style="width: 50%";>
                 </div>
             </div>


             <!-- Manejo de descripción -->
             <div class="row mt-3">
                 <div class="col">
                     <label for="detalle_descripcion_caja">Descripción</label>
                     <input type="text" id="detalle_descripcion_caja" placeholder="Escriba alguna descripción" style="width: 100% ;font-size:0.8em">
                 </div>
             </div>

               <!-- Manejo de Monto-->
               <div class="row mt-3">
                 <div class="col">
                 <img src="assets/imgs/suma_monto.svg" alt="producto" style="width: 32px ;float: left; background: var(--app-ctr-bg-color); border-radius: 10px; padding: 5px;margin-right: 10px;"/>
                     <label for="detalle_monto_caja">Monto</label>
                     <input class="input-edit" type="number" id="detalle_monto_caja" value="0.00" style="max-width: 130px; float:right; text-align:right">
                 </div>
             </div>
         </div>

     </div>

     <!-- Opciones de destalles en productos fraccion-->
     <div class="row  mt-3 marco_app" id="detalle_opciones_fraccion" style=" margin: 5px 11%; display:none">
         <style>
             label{
                 font-size: 0.8em;
             }
         </style>

         <div class="col-xs-12">
             <!-- Manejo de Cantidad -->
             <div class="row mt-3">
                 <div class="col">
                     <label for="detalle_cantidad_fraccion">Cantidad</label>
                     <input class="input-edit" type="number" id="detalle_cantidad_fraccion" value="1" style="width: 50%";>
                 </div>
             </div>
             <!-- Manejo de Cajas -->
             <div class="row mt-3">
                 <div class="col">
                     <label for="detalle_ancho">Ancho</label>
                     <input class="input-edit" type="number" id="detalle_ancho" value="1" style="width: 50%";>
                 </div>
             </div>

             <!-- Manejo de Pallet -->
             <div class="row mt-3">
                 <div class="col">
                     <label for="detalle_alto">alto</label>
                     <input class="input-edit" type="number" id="detalle_alto" value="1" style="width: 50%";>
                 </div>
             </div>


             <!-- Manejo de descripción -->
             <div class="row mt-3">
                 <div class="col">
                     <label for="detalle_descripcion_fraccion">Descripción</label>
                     <input class="input-edit" type="text" id="detalle_descripcion_fraccion" placeholder="Escriba alguna descripción" style="width: 100% ;font-size:0.8em">
                 </div>
             </div>

               <!-- Manejo de Monto-->
               <div class="row mt-3">
                 <div class="col">
                 <img src="assets/imgs/suma_monto.svg" alt="producto" style="width: 32px ;float: left; background: var(--app-ctr-bg-color); border-radius: 10px; padding: 5px;margin-right: 10px;"/>
                     <label for="detalle_monto_fraccion">Monto</label>
                     <input class="input-edit" type="number" id="detalle_monto_fraccion" value="0.00" style="max-width: 130px; float:right; text-align:right">
                 </div>
             </div>

         </div>

     </div>        
     <!--  carrito  -->
 <div class="row mt-3">
    <!-- <div class="col-2 col-xs-1"></div>-->
     <div class="col-8 col-xs-12">
         <button id="bot-ped-carrito"  class="btn boton-primary" style="height:50px; width:100%" data-toggle="collapse" data-target="#ped-carrito">
         <img src="assets/imgs/carrito_cantidad.svg" alt="Cliente" style="width: 42px ;float: left;"/>
         <span  id="lbl_cantidad_carrito" class="carrito-cantidad">0</span>
            
             <h4 style="float:left">Carrito</h4>
             <h4  id="lbl_monto" style="float:right">$0.00</h4>
         </button>

         <div id="ped-carrito" class="collapse">
          <!-- Contenido-->
             <div class="row">
                 <div class="col-md-12 mt-3 ">
                     <div class="row marco_app" style="height: 300px; overflow: overlay;">
                             <ul  class="list-group "  style=" margin-top: 10px;" id="list_carrito">
                                 <li>cargando...</li>
                             </ul>
                     </div>
                 </div>
             </div>
          <!-- -->   
         </div>
     </div>
    <!-- <div class="col-2 col-xs-1"></div>-->
 </div>
 
 <!-- Botones -->

 <div id="botonera" class="row mt-3">
 <div class="col-xs-4 text-center">
     <button id="boton_cancelar_detalle" class="boton-redondo " style="float:left; background: red; ">
             <img src="assets/imgs/icon-cancel.svg" alt="X" style="width: 42px"/>
     </button>

 </div>
 <div class="col-xs-4">
     <button id="boton_aceptar_add" class="boton-redondo " style="left:40%; right:40%; background:green;">
             <img src="assets/imgs/icon-aceptar-add.svg" alt="D" style="width: 42px;   "/>
     </button>
 </div>
 <div class="col-xs-4">
     <button id="boton_aceptar_detalle"  class="boton-redondo"  style="float:right; background: green; ">
         <img src="assets/imgs/icon-aceptar.svg" alt="V" style="width: 42px"/>
     </button>   
 </div> 

</div>
    `
    constructor(nombre,visible=false){
        super(nombre,PageNewDetalle._page_new_detalle,visible,function(){
            let me=this;
            let vcont=''
                let idOpciones='#detalle_opciones_simple'

                 //MANEJO DE EVENTOS-------------------------------------
                /* $(".boton-primary").click(function(){
                    if(!$("#"+this.id.split("-")[1]+"-"+this.id.split("-")[2]).hasClass("in")) { //Revisar
                        $("#botonera").hide()
                    }else{
                        $("#botonera").show()
                      
                    }

                    me.refresh()
                })*/
    
                $("#textBuscarProducto").keyup(()=>{
                    this.listarProductos()
                })



                $("input[id^='detalle_monto']").keyup((event)=>{
                    if(!isNaN($("#"+event.target.id).val())){
                        this.parent.detalleSel.monto=parseFloat($("#"+event.target.id).val())
                    }else{
                        alert("No es un valor válido")
                        me.refresh()
                        //("#"+event.target.id).val('0.00')
                    }
                })



                this.iniciarBotonera=()=>{


                      $("#boton_cancelar_detalle").click(()=>{
                            me.parent.setPageSelect('pag_presupuesto')
                      })

                      $("#boton_aceptar_detalle").click(()=>{

                        // si hay un propiedad edit boleana en true solo salir
                            if(!(me.props && me.props.edit)){
                                me.addDetalle()
                            }else{
                                me.parent.pedido.refresh()
                            }
                            
                            me.parent.setPageSelect('pag_presupuesto')
                        })

                        $("#boton_aceptar_add").click(()=>{
                            me.addDetalle()
                        me.parent.detalleSel=null
                        me.parent.productoSel=null
                        $(me.idOpciones).hide(200)  // desplegamos el panel de detalles
                        
                        //Cargamos los datos del producto a boton
                        $("#bot-ped-producto").html(    
                            `<img src="assets/imgs/producto.svg" alt="Cliente" style="width: 42px ;float: left;"/>
                            <h4  class="truncate"  style="margin:0px">Buscar otro producto</h4><p class="truncate"  style="margin:0px;font-size:0.8em"></p>`
                            )
                        $("#bot-ped-producto").click()      // contaemos el Colapse
                        
                        me.refresh()
                        })
                }    
              
     
                // configurar la calculadora
                 $("#detalle_cantidad").click(()=>{
                      this.parent.setPageSelect('pag_calculadora',{title:'Cantidad de '+me.parent.productoSel.nombre,variable:'CANTIDAD'});
                 })
                
                 $("#detalle_cantidad_unidad").click(()=>{
                      this.parent.setPageSelect('pag_calculadora',{title:'Cantidad de '+me.parent.productoSel.nombre,variable:'UNIDAD'});
                 })

                 $("#detalle_cantidad_fraccion").click(()=>{
                      this.parent.setPageSelect('pag_calculadora',{title:'Cantidad de '+me.parent.productoSel.nombre,variable:'CANTIDAD'});
                 })

                // configurar la calculadora par el Ancho
                 $("#detalle_ancho").click(()=>{
                    this.parent.setPageSelect('pag_calculadora',{title:'Ancho en metros de '+me.parent.productoSel.nombre,variable:'ANCHO'});
                 })
                $("#detalle_alto").click(()=>{
                    this.parent.setPageSelect('pag_calculadora',{title:'Alto en metros de '+me.parent.productoSel.nombre,variable:'ALTO'});
                 })


                 $("input[id^='detalle_descripcion']").click((event)=>{

                    // si esta en movil o tablet
                    if(me.parent.isTablet()||me.parent.isMovil()){

                        vcont=$("#botonera").html()
                        let ce=this.parent.getPage('pag_text_editor')
                        
                        //pasamos el contenido de la descripción al editor
                        ce.props={text: this.parent.detalleSel.detalle,idInput:event.target.id}
                    
                    
                        //Mostran en el contenedor de las botoneras
                        ce.show('botonera');

                        

                        //Definir la accion del botón aceptar
                        ce.onClickAceptar=()=>{
                            this.parent.detalleSel.detalle=ce.text
                            $("#"+ce.props.idInput).val(ce.text)
                            $("#botonera").html(vcont)
                            this.iniciarBotonera()
                        } 
                        ce.onClickCancel=()=>{
                            $("#botonera").html(vcont)
                            this.iniciarBotonera()
                        } 
                    }
  
                 })

                 $("input[id^='detalle_descripcion']").keyup((event)=>{
                    this.parent.detalleSel.detalle=$("#"+event.target.id).val()

                 })



               /* $("#detalle_cantidad").keyup(function(){
                    me.parent.detalleSel.setCantidad(this.value)
                    me.refresh()
                })*/

                //-------------------------------------------------------
                this.cargarDatosProducto=()=>{
                    if (me.parent.productoSel != null) {
                        let precio = `
                            <span>$${me.parent.productoSel.precio} </span>
                        `
                        if (me.parent.productoSel.precioEspecial > 0) {
                            precio = `
                            <span style="float:right"><span style="font-size:0.8em"><del>$${me.parent.productoSel.precio} </del></span><p>$${me.parent.productoSel.precioEspecial}</p> </span>
                            `
                        }
                        $("#bot-ped-producto").html(
                            ` <div class="row">
                                <div class="col-xs-2">
                                    <img src="assets/imgs/producto.svg" alt="Cliente" style="width: 42px ;float: left;"/>
                                </div>
                                <div class="col-xs-6">
                                         <h4  class="truncate" style="margin:0px">${me.parent.productoSel.nombre}</h4> 
                                </div>
                                <div class="col-xs-4">
                                 <span>${precio} </span>
                                </div>
                               
                               
                            </div>
                        `
                            
                        )
                    }else{
                         $("#bot-ped-producto").html(
                            `<img src="assets/imgs/producto.svg" alt="Cliente" style="width: 42px ;float: left;"/>
                             <h4  class="truncate" style="margin:0px">No hay producto seleccionado</h4>`
                        )
                    }
                   
   
                }

                this.addDetalle=()=>{
                    if(me.parent.detalleSel){

                        me.parent.addCarrito()
                    }
                }
               

                this.listarProductos=()=>{
                    let filtroPrto=$("#textBuscarProducto").val().toUpperCase()

                    if(filtroPrto.length>0){
                        $('html, body').animate( { scrollTop : 90 }, 800 ); // desplaza hacia arriba la me.parent
                    }
    
                    let prtoFiltrado=me.parent.productos.filter(function(prto){
                        return prto.nombre.toUpperCase().indexOf(filtroPrto)>-1||prto.codigo.toUpperCase().indexOf(filtroPrto)>-1||prto.descripcion.toUpperCase().indexOf(filtroPrto)>-1 })
                        

                    // limpiamos la lista y dibujamos los elementos en la lista    
                    $("#list-producto").empty() 
                    
                    for(let prto of prtoFiltrado){
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
                            me.selectProducto(this.id)
                        })
                    }
                }

            //Funccion que selecciona un producto
                this.selectProducto=(idboton)=>{

                    let productoSel=me.parent.productos.filter(function(cte){return cte.id==idboton.split('_')[1]})[0];

                    if(productoSel){
                        me.parent.productoSel=productoSel

                        Producto.find(me.parent.idApp,productoSel.id,me.parent.clienteSel.id,(pto)=>{
                           me.parent.productoSel=pto
                           me.iniciarDetalle()
                           me.refresh()

                        })
                     
                        //$("#ped-cliente").removeClass("in")
                        $("#bot-ped-producto").click()      // contaemos el Colapse
                
                        //Cargamos los datos del producto a boton
                        $("#bot-ped-producto").html(    
                            `<img src="assets/imgs/producto.svg" alt="Cliente" style="width: 42px ;float: left;"/>
                                 <h4  class="truncate" style="margin:0px">cargando...</h4>`
                            )

                        this.iniciarDetalle();

                        this.parent.setPageSelect('pag_calculadora',{title:'Cantidad de '+me.parent.productoSel.nombre,variable:'CANTIDAD'})

                        this.refresh()
                        
    
                        //pantalla.setPageSelect('pag_newdetalle') //vamos a la pantalla para cargar los productos
                    }



                    $('html, body').animate( { scrollTop : 0 }, 300 ); // desplaza hacia arriba la pantalla
                    
                }


            //Funccion que inicio aun nuevo detalle
            this.iniciarDetalle=()=>{

                if(me.parent.productoSel){
                    switch(me.parent.productoSel.unidad){
                            case Producto.UNIDAD_PRECIO_UNIDAD:
                                me.idOpciones='#detalle_opciones_simple'
                                break
                            case Producto.UNIDAD_PRECIO_M2:
                                me.idOpciones='#detalle_opciones_fraccion'
                                break    
                            case Producto.UNIDAD_PRECIO_CAJA:
                            case Producto.UNIDAD_PRECIO_PALLET: 
                                me.idOpciones='#detalle_opciones_cajas'
                                break   


                    }
                }
                pantalla.detalleSel=new DetallePedido()

                $(me.idOpciones).show(200)  // desplegamos el panel de detalles

                pantalla.detalleSel.setProducto(pantalla.productoSel)
                pantalla.detalleSel.setCantidad(1)
                $("#detalle_cantidad").focus()
                $('html, body').animate( { scrollTop :20 }, 100 ); // desplaza hacia arriba la pantalla
                this.refresh()
            } 
            
            

           this.refresh=()=>{
                     
             if(pantalla.detalleSel){
                 $("#detalle_monto").val(pantalla.detalleSel.monto)
                 $("#detalle_monto_caja").val(pantalla.detalleSel.monto)
                 $("#detalle_monto_fraccion").val(pantalla.detalleSel.monto)


                 $("#detalle_cantidad").val(pantalla.detalleSel.cantidad)
                 $("#detalle_cantidad_unidad").val(pantalla.detalleSel.cantidad)
                 $("#detalle_cantidad_caja").val(pantalla.detalleSel.cantidad)
                 $("#detalle_cantidad_fraccion").val(pantalla.detalleSel.cantidad)

                 if(me.parent.productoSel.unidad===Producto.UNIDAD_PRECIO_M2){
                     $("#detalle_alto").val(me.parent.detalleSel.alto)
                     $("#detalle_ancho").val(me.parent.detalleSel.ancho)
                 }
                 $("input[id^='detalle_descripcion']").val(pantalla.detalleSel.detalle)
                 $(me.idOpciones).show(200)  // desplegamos el panel de detalles
                 me.cargarDatosProducto()
             }

           }

           //------------INICIO---
            // - Cargar Productos a lista 
            this.listarProductos()
            this.iniciarBotonera()

            // Chequear si hay un cliente seleccionado
            if(pantalla.productoSel){
                me.cargarDatosProducto()
            }else{
              $("#bot-ped-producto").click()
              $("#textBuscarProducto").focus()
              
            }
            this.refresh()
        
        
        })
    }
}