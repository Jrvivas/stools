//@require util 
//@require models/app_model_producto
//@require models/app_model_view

class Pantalla extends View{

    constructor(idApp){
        super(idApp)
        this.handleSelectProducto=null;
        this.productoSel=null;
        this.detalle=new DetallePedido();
        this.idCliente=null;
        this.productos=[];

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
        let txtprecio=this.productoSel.precioEspecial==0?'$'+this.productoSel.precio:'$<strike>'+this.productoSel.precio+'</strike>&nbsp;<strong>$'+this.productoSel.precioEspecial+'</strong>'
        let textHtml=`<h5>Codigo:${this.productoSel.codigo}</h5> 
                        <span>${this.productoSel.descripcion}</span>
                        <h4>Precio:${txtprecio}</h4>
                        <span>Unidad:${this.productoSel.unidad}</span><span>&nbsp;-&nbsp;Stock:<strong>${this.productoSel.stockActual}</strong></span>`
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
               // $("#field-fraccion").show()
                descripcion='medidas ('+this.detalle.ancho+'m X '+this.detalle.alto+'m) '+this.productoSel.nombre;
                break;
            case Producto.UNIDAD_PRECIO_MLINEAL:
                $("#field-alto").hide()
                $("#field-ancho").show()
               // $("#field-fraccion").show()
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
        $("#body-modal").html(Helpers.listFind('Productos','list_productos',`pantalla.listarProductos('list_productos')`));
        this.listarProductos('list_productos')
        


    }

    //cuando selecciona un producto
    handlerSelectProducto=(idProducto)=>{
        if(idProducto>0){

            this.msg(this.MSG_ESPERA,true)         //hacemos visible el mensaje de espera

            $("#detallepedido-productos_id").val(idProducto)
            
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
     * Método que lista los productos filtrado según la palabra escrita en el área de texto
     * @param {string} idLst Identificador del control de lista
     */
    listarProductos(idLst){
         $("#"+idLst).html('')
         let filtro=$("#textBuscar").val().toUpperCase();
         let ptosFiltrado=this.productos.filter(function(pto){
            return pto.nombre.toUpperCase().indexOf(filtro)>-1||pto.nombre.toUpperCase().indexOf(filtro)>-1||pto.codigo.toUpperCase().indexOf(filtro)>-1 })
          ptosFiltrado.forEach(element => {
            $("#"+idLst).append(`<li  id="p-${element.id}"class="list-group-item list-group-item-success" data-toggle="modal" data-target="#modal"  onclick="pantalla.handlerSelectProducto(${element.id})">[<strong>${element.codigo}</strong>]${element.nombre}</li>`)
             
          
        });
    }
    


}

var pantalla=null;

//Despues de cargar pantalla
window.onload=function() {
    //crear una intancia de la clase Pantalla
    pantalla=new Pantalla(idApp);
    pantalla.productos=productos ;       //Lista de producto que se obtiene en la vista
    pantalla.idCliente=idCliente;       //Variabla global pasada por el modelo
    if(detalle){
        pantalla.detalle.fromJson(detalle);    //json detalle  que se obtiene en la vista
        pantalla.handlerSelectProducto(detalle.productos_id)
        
    }
     
 };