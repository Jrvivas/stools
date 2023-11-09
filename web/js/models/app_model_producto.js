/*
*@require util
*@require app_server
*/

/**
 * Clase responsable de manejo de los productos
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

    /**
     * 
     * @param {string} idApp Id de la Aplicacion
     * @param {int} id 
     * @param {int} idCliente ide del cliente si existe
     * @param {obj} done funcion callback
     */
    static find(idApp,id,idCliente,done){
        if(idApp!=null && !isNaN(id) ){
            (new Server()).consulta('index.php?r=productos%2Ffind-ajax&idApp='+idApp+'&id='+id+'&idCliente='+idCliente,{'_csrf': yii.getCsrfToken()},function(rst){
                if(rst.error==0){
                    let producto=rst.data;
                        //console.log("Datas :",producto);
                        let objProducto=new Producto();
                        objProducto.fromJson(producto)
                        if(done){
                            done(objProducto);
                        };
    
                }else{
                    Msg.error('Producto.find','Se produjo un error de servidor '+rst.message)  
                }
            });
        }
    }
    /**
     * Devuelve la lista de productos disponible
     * @param {string} idApp 
     * @param {fun} done 
     */
    static getList(idApp,done){
        if(idApp!=null){
            (new Server()).consulta('index.php?r=productos%2Flista-ajax&idApp='+idApp,{},function(rst){
                if(rst.error==0){
                    let productos=rst.data
                    if(done){
                        done(productos)
                    }
                }
            })
        }else{
            Msg.error('Producto.getList','Se produjo un error de servidor '+rst.message)  
        }
    }


    

   constructor( id=0,
                app_idApp='',
                codigo='',
                nombre='',
                descripcion='',
                urlFoto='',
                estado=Producto.ESTADO_ACTIVO,
                precio=0,
                costo=0,
                tiempo=0,   //tiempo de elavoracion del producto
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

    /**metodo standar  que carga un objeto desde un json*/
    fromJson(dataJson){

        if(dataJson){
            let key;
            for(key in dataJson){
                if(dataJson.hasOwnProperty(key)){
                    this[key] =dataJson[key];
                  }
                console.log(key)
            }
            
        }else{
            Msg.error('Producto.fromJson','la variable pasada es null')
        }
    }

}
