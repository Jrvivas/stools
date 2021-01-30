
class Pedido{
       
    static ESTADO_PRESUPUESTO="PRESUPUESTO";
    static ESTADO_ESPERA="ESPERA";
    static ESTADO_APROBADO="APROBADO";
    static ESTADO_DISENIO="DISENIO";
    static ESTADO_PRODUCCION="PRODUCCION"; //ELABORACION
    static ESTADO_RETRASADO="RETRASADO";
    static ESTADO_TERMINADO="TERMINADO";
    static ESTADO_ENTREGADO="ENTREGADO";
    static ESTADO_RECHAZADO="RECHAZADO";

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
   
   constructor(id=0,app_idApp="#"){
       this.id=id;
       this.app_idApp=app_idApp;
       this.fechaIni="";
       this.fechaEntrega="";
       this.fechaFin="";
       this.contacto_id=0;
       this.idResponsable=0;
       this.detalles=[]
       this.monto=0;
       this.costo=0;
       this.tiempo=0;
       
   }

   addDetalle(detalle){
       if(detalle){
           this.detalles.push(detalle)
           this.monto+=parseFloat(detalle.monto)
           this.consto+=parseFloat(detalle.costo)
           this.tiempo+=parseFloat(detalle.tiempo)
       }
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
            Msg.error('Pedido.fromJson','la variable pasada es null')
        }
    }
    

}
