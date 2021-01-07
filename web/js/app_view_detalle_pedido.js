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
        this.detalle=new DetallePedido()
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
       
        $("#detallepedido-cantidad").val(this.detalle.cantidad)
        $("#detallepedido-alto").val(this.detalle.alto)
        $("#detallepedido-ancho").val(this.detalle.ancho)
        $("#detallepedido-monto").val(this.detalle.monto)
        $("#detallepedido-fraccion").val(this.detalle.fraccion)
        $("#detallepedido-detalle").val(descripcion)
        $("#detallepedido-inst").val(this.detalle.inst)
    }

    //cuando selecciona un producto
    handlerSelectProducto=(idProducto)=>{
        if(idProducto>0){

            this.msg(this.MSG_ESPERA,true)         //hacemos visible el mensaje de espera

            this.productoSel=Producto.find(this.idApp,idProducto,(producto)=>{
                if(producto){
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

    handlerChangeCantidad=(newCantidad)=>{
        if(!isNaN(newCantidad)){
            this.detalle.setCantidad(newCantidad*1)   //comvertimos en numero
            this.refresh()
        }
    }
    handlerChangeAncho=(newCantidad)=>{
        if(!isNaN(newCantidad)){
            this.detalle.setAncho(newCantidad*1)   //comvertimos en numero
            this.refresh()
        }
    }
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
     
 };