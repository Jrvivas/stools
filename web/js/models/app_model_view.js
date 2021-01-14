/**
 * Interface para el manejo de la vista de forma dinamica usando Ajax o operaciones Frontend
 * 
 * -Para el manejo de eventos usar la nomeclatura siguente
 *  
 *      handler<nombreDelEvento>(){}
 * 
 * -Para Actualizar datos en pantalla usar 
 * 
 *      show<nombreDeLaAccion>(){}
 */
class View{
        static MSG_ERROR=1
        static MSG_ALERTA=2
        static MSG_PELIGRO=3
        static MSG_ESPERA=4
    
        constructor(idApp){
            this.idApp=idApp;
    
        }
     /**
      * metodo que refresca la pantalla luego de una modificación
      */
    refresh(){
       
        // - Actualizar campos
        this.showDatosCampos()

            //- Adaptar la ventana según la unidad de medida del producto
            //- Mostrar los calculos según el cambio de parametros

    }

    /**
     * Acemos las actualizaciones de los campos de datos
     */
    showDatosCampos(){
        //Codificamos para actualizar los campos
    }

    /*
    *  Para el manejo de eventos usar la nomeclatura siguente
    *  handler<nombreDelEvento>(){}
    * 
    * Para Actualizar datos en pantalla usar 
    * show<nombreDeLaAccion(){}
    */
   


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