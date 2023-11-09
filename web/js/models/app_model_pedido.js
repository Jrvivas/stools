
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
       this.pago=0;
       this.saldo=0;
       this.descuento='0';
       this.impuesto='0';
       
   }

   addDetalle(detalle){
       if(detalle){
           this.detalles.push(detalle)
           this.refresh()
       }
   }


   setDescuento(descuento){
       if(descuento){
           this.descuento=descuento
           this.refresh()
       }
   }
   setImpuesto(impuesto){
        if(impuesto){
            this.impuesto=impuesto
            this.refresh()
        }
    }

   setFechaEntrega(fecha){
       if(fecha){
           this.fechaEntrega=fecha
           this.refresh()
       }
   } 
   
   refresh(){
        this.monto=0
        this.costo=0
        this.tiempo=0
        

        this.detalles.forEach((d)=>{
            this.monto+=parseFloat(d.monto)
            this.costo+=parseFloat(d.costo)
            this.tiempo+=parseFloat(d.tiempo)
        })
        let descuento=0
        let impuesto=0
        if(this.descuento.indexOf('%')>=0){
            descuento=isNaN(this.descuento.split('%')[0])?0:this.monto*parseFloat(this.descuento.split('%')[0])/100
        }else{
            descuento=isNaN(this.descuento)?0:parseFloat(this.descuento)
        }
        if(this.impuesto.indexOf('%')>=0){
            impuesto=isNaN(this.impuesto.split('%')[0])?0:this.monto*parseFloat(this.impuesto.split('%')[0])/100
        }else{
            impuesto=isNaN(this.impuesto)?0:parseFloat(this.impuesto)
        }

        
        this.saldo=(this.monto-descuento+impuesto-parseFloat(this.pago)).toFixed(2)


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

    dbSet=(done)=>{
        // actualizar los datos antes de enviar
        this.refresh()
        if(this.app_idApp){
            let server=new Server()

            server.consulta('index.php?r=pedido%2Fcreate-ajax&idApp='+this.app_idApp,{data:this},function(rst){
                    if(done){
                        done(rst)
                    }
            })
        }
    }


    validate=()=>{return true //TODO-------------------

    }
    

}
