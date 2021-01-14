
class Pantalla extends View{
    constructor(idApp){
        super(idApp);
        this.clienteSel=null;
        this.clientes=[];
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


}

var pantalla=null;

//Despues de cargar pantalla
window.onload=function() {
    //crear una intancia de la clase Pantalla
    pantalla=new Pantalla(idApp);
    pantalla.clientes=clientes;
   
     
 };