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

    static find(idApp,id,done){
        if(idApp!=null && !isNaN(id) ){
            (new Server()).consulta('index.php?r=productos%2Ffind-ajax&idApp='+idApp+'&id='+id,{'_csrf': yii.getCsrfToken()},function(rst){
                if(rst){
                    let producto=rst.data;
                        console.log("Datas :",producto);
                        let objProducto=new Producto();
                        objProducto.setFromJson(producto)
                        if(done){
                            done(objProducto);
                        };
    
                }else{
                    Msg.error('Producto.find','Se produsco un error cuando llamamos al servidor')  
                }
            });
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
    setFromJson(dataJson){
        if(dataJson){
            this.id=dataJson.id
            this.app_idApp=dataJson.app_idApp
            this.codigo=dataJson.codigo
            this.nombre=dataJson.nombre
            this.descripcion=dataJson.descripcion
            this.urlFoto=dataJson.urlFoto
            this.estado=dataJson.estado
            this.precio=dataJson.precio
            this.costo=dataJson.costo
            this.unidad=dataJson.unidad
            this.unxCaja=dataJson.unxCaja
            this.cajaxPallet=dataJson.cajaxPallet
            this.idTipoProducto=dataJson.idTipoProducto
            this.categoriaCodigo=dataJson.categoriaCodigo
            this.costoBase=dataJson.costoBase
            this.costoInstalacion=dataJson.costoInstalacion
            this.opciones=dataJson.opciones// usar
            this.idLista=dataJson.idLista //
            //idMarca

        }else{
            Msg.error('Producto.setFromJson','la variable pasada es null')
        }

    }
}
