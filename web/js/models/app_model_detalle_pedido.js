//@require app_model_producto


class DetallePedido{
    static ESTADO_ACTIVO='ACTIVO'
    static ESTADO_BORRADO='BORRADO'
    static ESTADO_EDIT='EDIT'
    static ESTADO_NOEDIT='NOEDIT'

    constructor(id=0,cantidad=1,producto=null,monto=0,estado=DetallePedido.ESTADO_ACTIVO,ancho=1,alto=1,detalle=''){
        this.id=id
        this.cantidad=cantidad
        this.producto=producto
        this.productos_id=producto?producto.id:0;
        this.precioDif=producto?producto.precioEspecial:0  // Precio diferencial se usa cuando el precio del producto varia segun condiciones
        this.monto=monto
        this.ancho=ancho
        this.alto=alto
        this.costo=0
        this.tiempo=0
        this.fraccion=alto*ancho
        this.inst=0
        this.detalle=''//descripcion
        this.estado=estado
    }

    setCantidad=(cantidad)=>{

        if(cantidad){
            this.cantidad=cantidad
            this.calcularMonto()
            return true; 
        }else{

            return false;
        }
    }

    setAlto=(alto)=>{

        if(alto){
            this.alto=alto
            this.calcularMonto()
            return true; 
        }else{

            return false;
        }
    }
    setAncho=(ancho)=>{

        if(ancho){
            this.ancho=ancho
            this.calcularMonto()
            return true; 
        }else{

            return false;
        }
    }
    setProducto=(producto)=>{
        this.productos_id=producto.id;
        this.producto=producto;
        this.precioDif=producto.precioEspecial

        this.calcularMonto()
    }

   



    calcularMonto(){
       
            let cantidad=parseFloat(this.cantidad);
            let precio=this.producto.precioEspecial==0?parseFloat(this.producto.precio):parseFloat(this.producto.precioEspecial);
            let unxcaja=parseFloat(this.producto.unxCaja)
            let cajaxpallet=parseFloat(this.producto.cajaxPallet)
            let costoPrto=parseFloat(this.producto.costo?this.producto.costo:0)
            let tiempoPrto=parseFloat(this.producto.tiempo)
            

           /* if(this.precioDif>0){
                precio=this.precioDif
            }*/
            
            this.fraccion=this.alto*this.ancho;

            let monto=this.producto.precio*cantidad;

            let costo=costoPrto*cantidad* this.fraccion;
            let tiempo=tiempoPrto*cantidad* this.fraccion;

            
            unxcaja=unxcaja!=0?unxcaja:1
            cajaxpallet=cajaxpallet!=0?cajaxpallet:1
            this.detalle='-'
            switch(this.producto.unidad){

                case Producto.UNIDAD_PRECIO_UNIDAD:
                    monto=precio*cantidad
                
                    break

                case Producto.UNIDAD_PRECIO_CAJA:
                    monto=(precio/unxcaja)*cantidad
                    costo=(costoPrto/unxcaja)*cantidad
                    tiempo=(tiempoPrto/unxcaja)*cantidad

                    break

                case Producto.UNIDAD_PRECIO_PALLET:
                    monto=(precio/cajaxpallet/unxcaja)*cantidad
                    costo=(costoPrto/cajaxpallet/unxcaja)*cantidad
                    tiempo=(tiempoPrto/cajaxpallet/unxcaja)*cantidad
                    break

                case Producto.UNIDAD_PRECIO_M2:
                    monto=precio*this.fraccion*cantidad
                    costo=costoPrto*cantidad* this.fraccion;
                    tiempo=tiempoPrto*cantidad* this.fraccion;
                    this.detalle='medidas ('+this.ancho.toFixed(2)+'x'+this.alto.toFixed(2)+') '
                    break


                case Producto.UNIDAD_PRECIO_MLINEAL:
                    monto=precio*cantidad
                    costo=costoPrto*cantidad;
                    tiempo=tiempoPrto*cantidad;
                    break
            }
            this.monto=monto.toFixed(2);
            this.costo=costo.toFixed(2);
            this.tiempo=tiempo.toFixed(2);
           
          
       
    }

   

    /**TODO */
    toJson(){
        return {id:this.id,
        productos_id:this.producto.id,
        producto:this.producto.nombre,
        cantidad:this.cantidad,
        ancho:this.ancho,
        alto:this.alto,
        fraccion:this.fraccion,
        inst:this.inst,
        detalle:this.detalle,
        monto:this.monto,
        estado:this.estado}
    }
    /**
     * Metodo standar  que carga un objeto desde un json
     * */
    fromJson(dataJson){

        if(dataJson){
            let key;
            for(key in dataJson){
                if(dataJson.hasOwnProperty(key)){
                    this[key] =dataJson[key];
                  }
                //console.log(key)
            }
            
        }else{
            Msg.error('DetalleProducto.fromJson','la variable pasada es null')
        }
    }
}
