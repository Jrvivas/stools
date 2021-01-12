//@require util 
//@require models/app_model_producto


class Pantalla{
    static MSG_ERROR=1
    static MSG_ALERTA=2
    static MSG_PELIGRO=3
    static MSG_ESPERA=4

    constructor(idApp){
        this.idApp=idApp;
        this.handleSelectProducto=null;
        this.productoSel=null;
        this.detalle=new DetallePedido();
        this.idCliente=null;

    }
    //metodo que refresca la pantalla luego de una modificación
    refresh(){
            //- Mostrar los datos del producto seleccionado
            this.showDatosProducto()
            // - actualizar campos

            this.showDatosCampos()

            //- Adaptar la ventana según la unidad de medida del producto
            //- Mostrar los calculos según el cambio de parametros

    }

    showDatosProducto(){
        let textHtml=`<h5>Codigo:${this.productoSel.codigo}</h5> 
                        <span>${this.productoSel.descripcion}</span>
                        <h4>Precio:$${this.productoSel.precio}</h4>
                        <span>Unidad:${this.productoSel.unidad}</span>`
        $("#detalle-datos-producto").html(textHtml)
    }

    showDatosCampos(){
        let descripcion='medidas ('+this.detalle.ancho+' X '+this.detalle.alto+') '+this.productoSel.nombre;

        switch(this.productoSel.unidad){
            case Producto.UNIDAD_PRECIO_UNIDAD:
                $("#field-alto").hide()
                $("#field-ancho").hide()
                $("#field-fraccion").hide()
                descripcion=this.productoSel.nombre
                break;
            case Producto.UNIDAD_PRECIO_M2:
                $("#field-alto").show()
                $("#field-ancho").show()
                $("#field-fraccion").show()
                descripcion='medidas ('+this.detalle.ancho+'m X '+this.detalle.alto+'m) '+this.productoSel.nombre;
                break;
            case Producto.UNIDAD_PRECIO_MLINEAL:
                $("#field-alto").hide()
                $("#field-ancho").show()
                $("#field-fraccion").show()
                descripcion='medidas ('+this.detalle.ancho+'m X '+this.detalle.alto+'m) '+this.productoSel.nombre;
                break;    
            default:
               $("#field-alto").hide()
               $("#field-ancho").hide()
               $("#field-fraccion").hide()
               descripcion='producto '+this.productoSel.nombre;



        }
        $("#detallepedido-cantidad").val(this.detalle.cantidad)
        $("#detallepedido-alto").val(this.detalle.alto)
        $("#detallepedido-ancho").val(this.detalle.ancho)
        $("#detallepedido-monto").val(this.detalle.monto)
        $("#detallepedido-fraccion").val(this.detalle.fraccion)
        $("#detallepedido-detalle").val(descripcion)
        $("#detallepedido-inst").val(this.detalle.inst)
        $("#detallepedido-costo").val(this.detalle.costo)
        $("#detallepedido-tiempo").val(this.detalle.tiempo)

    }

    /**
     * Metodo que muestra una ventana para la busqueda de un producto
     */
    showBuscarProducto(){

        //Desplegar la ventana flotante
        $("#body-modal").html(Helpers.listFind('Productos','list_productos','pantalla.handlerSelectProducto(this.value)'));
        


    }

    //cuando selecciona un producto
    handlerSelectProducto=(idProducto)=>{
        if(idProducto>0){

            this.msg(this.MSG_ESPERA,true)         //hacemos visible el mensaje de espera

            this.productoSel=Producto.find(this.idApp,idProducto,this.idCliente,(producto)=>{
                if(producto){

                    // ### EL producto debe tener el precio de la lista
                    //     O es pecial segun el cliente
                    this.productoSel=producto
                    this.detalle.producto=producto
                    this.detalle.calcularMonto();// calcula es mosnto para el nuevo producto

                    this.msg(this.MSG_ESPERA,false) //ocultamos el mensaje de espera
                    
                    this.refresh()
                }else{
                    this.msg(Pantalla.MSG_ERROR,'No fue posible cargar el producto')
                }
            });
            
        }
    }
    /**
     * Cuando cambia el valor cantidad 
     */
    handlerChangeCantidad=(newCantidad)=>{
        if(!isNaN(newCantidad)){
            this.detalle.setCantidad(newCantidad*1)   //comvertimos en numero
            this.refresh()
        }
    }

    /**
     * Cuando cambia el valor Ancho
     */
    handlerChangeAncho=(newCantidad)=>{
        if(!isNaN(newCantidad)){
            this.detalle.setAncho(newCantidad*1)   //comvertimos en numero
            this.refresh()
        }
    }

    /**
     * Cuando cambia el valor Alto
     */
    handlerChangeAlto=(newCantidad)=>{
        if(!isNaN(newCantidad)){
            this.detalle.setAlto(newCantidad*1)   //comvertimos en numero
            this.refresh()
        }
    }
    
    /**
     * Metodo que maneja los mensaje en la pantalla
     * @param {int} codigoMsg 
     * @param {mix} option 
     */
    msg(codigoMsg,option){
        switch(codigoMsg){
            case Pantalla.MSG_ERROR:
                 //TODO
                 console.log('ERROR: ' + option);
                 break;
            case Pantalla.MSG_ALERTA:
                 //TODO
                 alert('Mensaje: ' + option);
                 break;  
            case Pantalla.MSG_PELIGRO:
                 //TODO
                 alert('¡PELIGRO!: ' + option);
                 break;
            case Pantalla.MSG_ESPERA:
                  //TODO
                  if(option===true){
                      console.log('Esperando...')
                  }else{
                      console.log('Fin de espera')
                  }
                  break;            
        }

    }

}

var pantalla=null;

//Despues de cargar pantalla
window.onload=function() {
    //crear una intancia de la clase Pantalla
    pantalla=new Pantalla(idApp)
    if(detalle){
        this.pantalla.detalle.fromJson(detalle);
        this.pantalla.handlerSelectProducto(detalle.productos_id)
    }
     
 };