
//Punteros para actualizar conponentes desde otras funciones
var _setEstado=null  //referencia al cambio de estado del panel de detalle
var _setDetalles=null
var _onSelectDetalle=null


class Pedido{
    static ESTADO_ESPERA='ESPERA'
    static ESTADO_ACEPTADO='ACEPTADO'
    static ESTADO_PROCESO='PROCESO'
    static ESTADO_RECHAZADO='RECHAZADO'
    static ESTADO_ENTREGADO='ENTREGADO'
      
    static PEDIDOS_TODOS='PEDIDOS_TODOS'
    static PEDIDOS_CLIENTE='PEDIDOS_CLIENTE'

   
    static PRIORIDAD_NORMAL={codigo:0,color:'green'}
    static PRIORIDAD_MEDIA={codigo:2,color:'yellow'}
    static PRIORIDAD_ALTA={codigo:4,color:'orange'}
    static PRIORIDAD_URGENTE={codigo:8,color:'red'}
    static PRIORIDAD_HOY={codigo:10,color:'violet'}
    
    static getColorPrioridad(codigo){
        if(codigo==this.PRIORIDAD_NORMAL.codigo)return this.PRIORIDAD_NORMAL.color
        if(codigo==this.PRIORIDAD_MEDIA.codigo)return this.PRIORIDAD_MEDIA.color
        if(codigo==this.PRIORIDAD_ALTA.codigo)return this.PRIORIDAD_ALTA.color
        if(codigo==this.PRIORIDAD_URGENTE.codigo)return this.PRIORIDAD_URGENTE.color
        if(codigo==this.PRIORIDAD_HOY.codigo)return this.PRIORIDAD_HOY.color
        
    }
    static getPedidosCliente(cliente = null, done) {
       //Esta consulta falta que me devuelva los datos del responsable
        (new Server).consulta('index.php?r=contacto%2Fget-pedidos&idApp=' + cliente.app_idApp + '&id=' + cliente.id, { '_csrf': yii.getCsrfToken() }, (rst) => {

            if (rst) {
                console.log({'getPedidosCliente: ':rst.data})
                if (done) done(rst.data)

            }
        });

        }

    /**
     * 
     * @param {Entrega un Map con cleves de cada mes y sus pedidos } cliente 
     * @param {*} done 
     */
    static getPedidosClienteXMes(cliente,done){
        (new Server).consulta('index.php?r=contacto%2Fget-pedidos&idApp=' + cliente.app_idApp + '&id=' + cliente.id, { '_csrf': yii.getCsrfToken() }, (rst) => {
            let meses=new Map()
            if (rst) {
                console.log({'getPedidosClienteXMes ' : rst.data})
              
                for (const pdo of rst.data) {
                    let dt=new Date(pdo.fechaIni)
                    let pref=dt.getFullYear()+'-'+(dt.getMonth() + 1).toString().padStart(2, "0");
                    let data={pdos:[],monto:0}
                    if(meses.get(pref)!=null){
                        data=meses.get(pref)
                    }
                    
                    data.pdos.push(pdo)
                    data.monto+=parseFloat(pdo.monto)
                    data.saldo+=parseFloat(pdo.saldo)
                    meses.set(pref,data)
                }

                if (done) done(meses)

            }
        });
    }

}



const ProductoJson={
    cajaxPallet: "0.00",
    categoria: "",
    costoBase: "0",
    costoInstalacion: "0.00",
    descripcion: "",
    id: 0,
    nombre: "",
    precio: "0",
    stock: "0",
    unidad: "UN",
    unxCaja: "0",
}

/**
 * Producto
 * M
 */
class Producto{
    static UNIDAD_PRECIO_UNIDAD='UN'
    static UNIDAD_PRECIO_CAJA='CJ'
    static UNIDAD_PRECIO_PALLET='PL'
    static UNIDAD_PRECIO_M2='M2'
    static UNIDAD_PRECIO_MLINEAL='ML'

    static ESTADO_ACTIVO='ACTIVO'
    static ESTADO_BORRADO='BORRADO'
    static ESTADO_SUSPENSO='SUSPENSO'

    static getInfoCliente(idApp,idProducto,idCliente,done){
        (new Server).consulta('index.php?r=productos%2Fget-info-cliente&idApp=' + idApp+'&idProducto='+idProducto+'&idCliente='+idCliente, 
                                { '_csrf': yii.getCsrfToken() }, 
                                (rst) => {

                                        if (rst && rst.error==0) {
                                            console.log('getInfoCliente: '+rst.data)
                                            if(done) done(rst.data)
  

                                        }else{

                                            if(rst){
                                                console.log('--ERROR-- :'+rst.messeger)
                                            }
                                        }
                                    }
                                )

    }
    constructor(id=0,
                app_idApp='',
                codigo='',
                nombre='',
                descripcion='',
                urlFoto='',
                estado=Producto.ESTADO_ACTIVO,
                precio=0,
                costo=0,
                unidad=Producto.UNIDAD_PRECIO_UNIDAD,
                unxCaja=0,
                cajaxPallet=0,
                idTipoProducto=0,
                categoriaCodigo=''){
             this.id=id
             this.app_idApp=app_idApp
             this.codigo=codigo
             this.nombre=nombre
             this.descripcion=descripcion
             this.urlFoto=urlFoto
             this.estado=estado
             this.precio=precio
             this.costo=costo
             this.unidad=unidad
             this.unxCaja=unxCaja
             this.cajaxPallet=cajaxPallet
             this.idTipoProducto=idTipoProducto
             this.categoriaCodigo=categoriaCodigo
             this.costoBase=0
             this.costoInstalacion=0
             this.opciones=''// usar
             this.idLista=0 //?



    }
}


class Detalle{
    static ESTADO_ACTIVO='ACTIVO'
    static ESTADO_BORRADO='BORRADO'
    static ESTADO_EDIT='EDIT'
    static ESTADO_NOEDIT='NOEDIT'

    constructor(id,cantidad,producto,monto,estado=Detalle.ESTADO_ACTIVO,ancho=1,alto=1,detalle=''){
        this.id=id
        this.cantidad=cantidad
        this.producto=producto
        this.precioDif=0  // Precio diferencial se usa cuando el precio del producto varia segun condiciones
        this.monto=monto
        this.ancho=ancho
        this.alto=alto
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



    calcularMonto(){
       
            let cantidad=parseFloat(this.cantidad);
            let precio=parseFloat(this.producto.precio)
            let unxcaja=parseFloat(this.producto.unxCaja)
            let cajaxpallet=parseFloat(this.producto.cajaxPallet)

            if(this.precioDif>0){
                precio=this.precioDif
            }
            
            this.fraccion=this.alto*this.ancho;

            let monto=this.producto.precio*cantidad;
            
            unxcaja=unxcaja!=0?unxcaja:1
            cajaxpallet=cajaxpallet!=0?cajaxpallet:1

            switch(this.producto.unidad){
            case Producto.UNIDAD_PRECIO_UNIDAD:
                monto=precio*cantidad
                break
            case Producto.UNIDAD_PRECIO_CAJA:
                monto=(precio/unxcaja)*cantidad
                break
            case Producto.UNIDAD_PRECIO_PALLET:
                monto=(precio/cajaxpallet/unxcaja)*cantidad
                break
            case Producto.UNIDAD_PRECIO_M2:
                monto=precio*this.fraccion*cantidad
                break
            case Producto.UNIDAD_PRECIO_MLINEAL:
                monto=precio*cantidad
                break
            }
            this.monto=monto.toFixed(2);
          
       
    }
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
}
