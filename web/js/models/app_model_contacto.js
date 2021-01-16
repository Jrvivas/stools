
/**
 * Clase responsable de manejo de los Contacto
 */
class Contacto{

    static find(idApp,id,done){
        if(idApp!=null && !isNaN(id) ){
            (new Server()).consulta('index.php?r=contacto%2Ffind-ajax&idApp='+idApp+'&id='+id,{},function(rst){
                if(rst){
                    let contacto=rst.data;
                    let objCliente=new Contacto();
                    objCliente.fromJson(contacto)
                        if(done){
                            done(objCliente);
                        };
    
                }else{
                    Msg.error('Contacto.find','Se produsco un error cuando llamamos al servidor')  
                }
            });
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
                Msg.error('Contacto.fromJson','la variable pasada es null')
            }
        }
}