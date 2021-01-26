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
            this.var={clientes:[],
              estado:'NORMAL'
            }

            /**Definimos las funciones de la Pagina
             */
            this.fun={selectCliente:null, selectContacto:null}
            /**Shay un cliente seleccionado lo carga */
            if(pantalla.clienteSel){
                $("#bot-ped-cliente").html(
                `<img src="assets/imgs/cliente_buscar.svg" alt="Cliente" style="width: 42px ;float: left;"/>
                <h4  style="margin:0px">${pantalla.clienteSel.nombre}</h4><p  style="margin:0px;font-size:0.8em">${pantalla.clienteSel.direccion+" - "+pantalla.clienteSel.localidad+" ("+pantalla.clienteSel.cel+")"}</p>`
                )
            }



            //MANEJO DE EVENTOS-------------------------------------
            $(".boton-primary").click(function(){
                if(!$("#"+this.id.split("-")[1]+"-"+this.id.split("-")[2]).hasClass("in")) { //Revisar
                    $("#botonera").hide()
                }else{
                    $("#botonera").show()
                    //me.var.estado='NORMAL'
                }
                /*
                if(this.id.indexOf('cliente')>-1) {
                    me.var.estado='BCLIENTE'
                } 
                if(this.id.indexOf('producto')>-1){
                     me.var.estado='BPRODUCTO'
                } */
                me.refresh()
            })

            $("#textBuscarCliente").keyup(()=>{
                this.var.estado='BCLIENTE'
                this.refresh()
            })

            /*$("#textBuscarProducto").keyup(()=>{
                this.var.estado='BPRODUCTO'
                this.refresh()
            })*/

            $("#boton_cancelar").click(()=>{
                pantalla.setPageSelect('select_opcion')
            })
            //------------------------------

 
            
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

                     pantalla.setPageSelect('pag_newdetalle') //vamos a la pantalla para cargar los productos
                }

                
            }

            /*
            //Operaciones de inicio
            // - Cargar clientes a lista 
            let clte=Contacto.getClientes(idApp,(rst)=>{
                    if(rst){
                        this.var.clientes=rst;

                        if(this.debug)console.log("Clientes:",this.var.clientes);

                        this.refresh()
      
                    }
                });

            let Prto=Producto.getList(idApp,(rst)=>{
                 if(rst){
                    this.var.productos=rst
                    if(this.debug)console.log("Productos:",this.var.clientes);
                    this.refresh()
                 }
            })    */

            // filtrar clientes cuando cambia en cuadro de texto

            this.refresh=()=>{

                //==Manejo Cliente
               
       
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
                                //$("#lista_Productos").append( "<button id=\""+idBot+"\" type=\"button\" class=\"btn btn-primary \" style=\"margin: 5px;\"  data-toggle=\"modal\" data-target=\"#ModalPedidos\">"+prto.nombre+"</button>");
                                $("#list-cliente").append( `<li id="${idBot}" class="list-group-item list-group-item-success" data-toggle="modal" data-target="#ModalPedidos">${clte.nombre}(${clte.empresa})-${clte.localidad}</li>`)
                                
                                let me=this
                                $("#"+idBot).click(function(){
                                    //alert('Dibujar el dialogo para '+prto.nombre+ ' id:'+prto.id)
                                    me.fun.selectCliente(this.id)
                                })
                            }
           
 
                //=========================



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
                        //me.var.estado='NORMAL'
                    }
                    /*
                    if(this.id.indexOf('cliente')>-1) {
                        me.var.estado='BCLIENTE'
                    } 
                    if(this.id.indexOf('producto')>-1){
                         me.var.estado='BPRODUCTO'
                    } */
                    me.refresh()
                })
    
            $("#textBuscarProducto").keyup(()=>{
                this.refresh()
            })
        
            $("#boton_cancelar_detalle").click(()=>{
                pantalla.setPageSelect('pag_presupuesto')
            })

            this.refresh=()=>{
                
                let filtroPrto=$("#textBuscarProducto").val().toUpperCase()

                if(filtroPrto.length>0){
                    $('html, body').animate( { scrollTop : 140 }, 800 ); // desplaza hacia arriba la pantalla
                }

                let prtoFiltrado=pantalla.productos.filter(function(prto){
                    return prto.nombre.toUpperCase().indexOf(filtroPrto)>-1||prto.codigo.toUpperCase().indexOf(filtroPrto)>-1||prto.descripcion.toUpperCase().indexOf(filtroPrto)>-1 })

                $("#list-producto").empty() 
                
                for(prto of prtoFiltrado){
                    idBot="prto_"+prto.id;
                    //$("#lista_Productos").append( "<button id=\""+idBot+"\" type=\"button\" class=\"btn btn-primary \" style=\"margin: 5px;\"  data-toggle=\"modal\" data-target=\"#ModalPedidos\">"+prto.nombre+"</button>");
                    $("#list-producto").append( `<li id="${idBot}" class="list-group-item list-group-item-success" data-toggle="modal" data-target="#ModalPedidos">${prto.nombre}(${prto.codigo})</li>`)
                    
                    let me=this
                    $("#"+idBot).click(function(){
                        //alert('Dibujar el dialogo para '+prto.nombre+ ' id:'+prto.id)
                        me.fun.selectProducto(this.id)
                    })
                }
            }

     }))


     pantalla.refresh()
   
     
 };