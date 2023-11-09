
    
class PageCalculadora extends Page{
        
     static _page_panel_calculadora=`
     <style>
            .boton-calculadora, .boton-calculadora-aceptar, .boton-calculadora-cancel{
                width: 100%;
                height: 50px;
                margin: 3px;
                background: var(--app-ctr-bg-color);
                color: var(--app-ctr-text-color);
                border-radius: 20px;
                border: solid 2px var(--app-ctr-text-color);
                box-shadow:rgba(0, 0, 0, 0.425) 5px 5px;
            }
            .boton-calculadora-aceptar{
                background: green;
            }
            .boton-calculadora-cancel{
                background: red;
            }
            .boton-calculadora:hover{
                
                background-image: linear-gradient(to top,var(--app-ctr-bg-color), rgba(253, 249, 249, 0.411));
            }
            .boton-calculadora:active{
                box-shadow:rgba(0, 0, 0, 0.425) 1px 1px;
                background: var(--app-ctr-text-color);
                color: var(--app-ctr-bg-color);
                border: solid 2px var(--app-ctr-bg-color);
                margin: 7px 7px;
            }
            .display_calculadora{
                background: #ccc;
                font-size: 2em;
                padding: 10Px;
                margin: 5px;
                border: solid 2px #777777;
                border-radius: 5px;
                width: 100%;

            }
     </style>
        <div class="row" style="width: 95%;height:80%;">
            <div class="col-xs-12">
            <h3  id="calc_title" class="text-center">Calculadora</h3>
            <h3  id="calc_display" class="text-right display_calculadora">0.00</h3>
            </div>
            <div class="row">
                <div class="col-xs-6"><button id="bc_C" class="boton-calculadora">C</button></div>
                <div class="col-xs-3"><button id="bc_Pr" class="boton-calculadora"><</button></div>
                <div class="col-xs-3"><button id="bc_D" class="boton-calculadora">/</button></div>
            </div>

            <div class="row">
                <div  class="col-xs-3"><button id="bc_7" class="boton-calculadora" >7</button></div>
                <div  class="col-xs-3"><button id="bc_8" class="boton-calculadora" >8</button></div>
                <div  class="col-xs-3"><button id="bc_9" class="boton-calculadora" >9</button></div>
                <div  class="col-xs-3"><button id="bc_X" class="boton-calculadora" >X</button></div>
            </div>
            <div class="row">
                <div  class="col-xs-3"><button id="bc_4" class="boton-calculadora" >4</button></div>
                <div  class="col-xs-3"><button id="bc_5" class="boton-calculadora" >5</button></div>
                <div  class="col-xs-3"><button id="bc_6" class="boton-calculadora" >6</button></div>
                <div  class="col-xs-3"><button id="bc_R" class="boton-calculadora" >-</button></div>
            </div>
            <div class="row">
                <div  class="col-xs-3"><button id="bc_1" class="boton-calculadora" >1</button></div>
                <div  class="col-xs-3"><button id="bc_2" class="boton-calculadora" >2</button></div>
                <div  class="col-xs-3"><button id="bc_3" class="boton-calculadora" >3</button></div>
                <div  class="col-xs-3"><button id="bc_A" class="boton-calculadora" >+</button></div>
            </div>
            <div class="row">
                <div  class="col-xs-6"><button id="bc_0" class="boton-calculadora" >0</button></div>
                <div  class="col-xs-3"><button id="bc_Pt" class="boton-calculadora" >.</button></div>
                <div  class="col-xs-3"><button id="bc_Ig" class="boton-calculadora" >=</button></div>
            </div>
            <div class="row">
                <div  class="col-xs-6"><button id="bc_0"  class="boton-calculadora-cancel" > <img src="assets/imgs/icon-cancel.svg" alt="X" style="width: 42px"/></button></div>
                <div  class="col-xs-6"><button id="bc_Pt" class="boton-calculadora-aceptar"> <img src="assets/imgs/icon-aceptar.svg" alt="V" style="width: 42px"/></button></div>
            
            </div>
        </div>`;
    

    constructor(nombre,visible=false){
        super(nombre,PageCalculadora._page_panel_calculadora,visible,function(){
            let me=this
            let valor='0.00';
            let title='Calculadora';
            let variable='CANTIDAD'

            
            if(this.props && this.props.valor){
                valor= this.props.valor
            }
            if(this.props && this.props.title){
                title= this.props.title
            }
           if(this.props && this.props.variable){
                variable= this.props.variable
            }
    
            //eventos
            $(".boton-calculadora").click((event)=>{
                  if(!isNaN(event.target.innerHTML)){
                      if(parseFloat(valor)==0 && valor!=='0.')valor=''
                      valor+=''+event.target.innerHTML
                  }else{
                      switch(event.target.innerHTML){
                          case '=':
                              valor=valor.replace("X","*")
                              valor=parseFloat(eval(valor)).toFixed(2);
                              break;
                          case "C":
                              valor=0
                              break
                          case "&lt;":
                                if(valor.length>0){
                                    valor=valor.substr(0,valor.length-1)
                                    if(valor.length==0) valor=0
                                }
                                
                              break    
    
                          default:
                               valor+=''+event.target.innerHTML
                        
                      }
    
                  } 
                  $("#calc_display").html(valor)
            })
    
            $(".boton-calculadora-aceptar").click(()=>{
                switch(variable){
                    case 'CANTIDAD':
                        this.parent.detalleSel.setCantidad(parseFloat(valor)) 
                        break                       
                    case 'UNIDADES':
                        this.parent.detalleSel.setCantidad(parseFloat(valor)) 
                        break
                    case 'ANCHO':
                        this.parent.detalleSel.setAncho(parseFloat(valor)) 
                        break
                    case 'ALTO':
                        this.parent.detalleSel.setAlto(parseFloat(valor)) 
                        break
                }
                
                this.parent.setPageSelect('pag_newdetalle')
            })
            $(".boton-calculadora-cancel").click(()=>{
              this.parent.setPageSelect('pag_newdetalle')
            })
            
           



            //ini
            $("#calc_display").html(valor)
            $("#calc_title").html(title)
       })
    }

}
