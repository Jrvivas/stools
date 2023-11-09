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
            this.pagSelect=0;
            this.pages=[];
            this.idContenedor='app-contenedor'
    
        }
     /**
      * metodo que refresca la pantalla luego de una modificación
      */
    refresh(){
       
        // - Actualizar campos
        this.showDatosCampos()

            //- Adaptar la ventana según la unidad de medida del producto
            //- Mostrar los calculos según el cambio de parametros
       this.pages[this.pagSelect].show(this.idContenedor)  
       $("#"+this.idContenedor).show(200)  

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
   
   addPagina(newContenedor){
       if(newContenedor){
           newContenedor.parent=this
            this.pages.push(newContenedor)
            if(newContenedor.visible){
            
                this.pagSelect=this.pages.length-1
            }  
       }
        

    }

    /**
     * 
     * @param {string} idPage Identificador de la pagina a visualizar
     * @param {obj} props Lista de propiedades que se necesitan en la pagina
     */
    setPageSelect(idPage,props=null){

      
         $("#"+this.idContenedor).hide()
   
        if(isNaN(idPage)){
            let encontro=false;
            for(let i=0;i<this.pages.length; i++){
                if(this.pages[i].nombre==idPage){
                this.pagSelect=i
                encontro=true;
                break ;    
                }
            }
            if(!encontro)alert("no se encontró la pagina "+idPage)
        }else{
            this.pagSelect=idPage
        }
        if(props){
            this.pages[this.pagSelect].props=props
        }
        
        this.refresh()
    }

    getPage(idPage,props=null){
        let id=0;

        if(isNaN(idPage)){
            let encontro=false;
            for(let i=0;i<this.pages.length; i++){
                if(this.pages[i].nombre==idPage){
                id=i
                encontro=true;
                break ;    
                }
            }
            if(!encontro){
                alert("no se encontró la pagina "+idPage)
                return null
            }
        }else{
            id=idPage
        }
        if(props){
            this.pages[id].props=props
        }
        return this.pages[id]
        

    }

    loadUrl(url){
        window.location.href =url
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

    isMovil(){
        return (this.sizeWindow().w<480)
    }
    isTablet(){
        return (this.sizeWindow().w<800)
    }
    isLaptop(){
             return (this.sizeWindow().w>=800)
    }
    sizeWindow(){
        let width = window.innerWidth;
        let height = window.innerHeight;// - 200;
        return{w:width,h:height}
    }
}
/**
 * Controla un paginado de la pantalla
 */
class Page{
    constructor(nombre,txtHtml,visible=true,onInit=null){
        this.nombre=nombre
        this.txtHtml=txtHtml
        this.visible=visible
        this.onInit=onInit
        this.props=null
        this.var=null //Conjunto de variables en json
        this.parent=null
    }
    show(id){
        //$("#"+id).html(this.txtHtml)
        document.querySelector("#"+id).innerHTML=this.txtHtml;
        if(this.onInit){
            this.onInit()
        }

    }
}