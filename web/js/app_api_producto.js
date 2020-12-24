
//---------------------------------Manejo de precios------------------
//  - Abrir la ventana de manejo de precios
    function mostrarManejoPrecio(idApp,idProducto,id){
        let body=document.querySelector("#body"+id);

                          /*     <div class="col-xs-6 text-center">
                                <button type="button" class="btn btn-primary">Por Cliente</button>
                            </div> 
                            <div class="col-xs-6 text-center">
                                <button type="button"  class="btn btn-primary">Por Lista</button>
                            </div> */
        body.innerHTML=`<div class="row">
                           <div class="col">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons" style="width:90%; margin:10px">
                                <label class="btn btn-primary active" style="width:50%">
                                    <input type="radio" name="options" id="option1" autocomplete="off" checked> Por Cliente
                                </label>
                                <label class="btn btn-primary" style="width:50%">
                                    <input type="radio" name="options" id="option2" autocomplete="off"> Por Lista
                                </label>

                            </div>
                            </div>
                        </div>
                        <div class="row" style="height: 300px;overflow-y: scroll;">
                       
                        <table class="table" id="tablePreciosCliente">
                            <thead>
                                <tr>
                                <th scope="col">Cliente</th>
                                <th scope="col">Precio</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_${id}">
                                <tr>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>

                            </tbody>
                            </table>
                        </div>`;

             getPreciosPorClientes(idApp,idProducto,function(rta){
                    if(rta.error==0){
                        //el data es una matriz de clientes 
                        //con los precios si es que los tiene
                        //[{'cliente':"Juan Perez",idCliente:20,idPrecio:0,precio:0,fechaAct:0},...]
                        tbody="";
                        for(r of rta.data){
                            let precio='-';
                            if(r.precio!=null){
                                precio=r.precio;
                            }

                            tbody+= `<tr>
                                        <td>${r.cliente}</td>
                                        <td>$<input id="${r.idCliente}" onchange=" cambioPrecio(this.id,'${idApp}',${idProducto},this.value);" tipe="number" value="${precio}"></td>
                                    </tr>`
                        }
                        document.querySelector("#tbody_"+id).innerHTML=tbody;
                       
                    }
             })   

    }
    function getPreciosPorClientes(idApp,idProducto,done){
        let server=new Server();

        server.consulta('index.php?r=precio%2Flista-clientes-ajax&id='+idApp+'&idProducto='+idProducto,{'_csrf': yii.getCsrfToken()},done)

    }

    function cambioPrecio(id,idApp,idProducto,precio){
        if(id){
            console.log('id:'+id+', precio:'+precio)
            if(isNumber(precio) || precio.trim()==='-'){
                let server=new Server();
               
                server.consulta('index.php?r=precio%2Fset-precio-cliente-ajax&id='+idApp+'&idProducto='+idProducto+'&idCliente='+id+'&valor='+precio,{'_csrf': yii.getCsrfToken()},function(rta){
                    if(rta.error==0){
                        console.log(rta.data)
                    }else{
                        alert('Ocurrio el siguiente Error '+rta.data)
                    }
                })
            }else{
                alert("El valor '"+precio+"' no es un número")
            }
        
        }
    }
//  - Obtener precios por clientes
//  - Mostrar lista de precios
//  - Actualizar precio

//-------------------------------------Control de Stock--------------------------
/**
 * 
 */
class CtrProductoStock{
    constructor(idDiv,idApp,idProducto){
        this.idDiv=idDiv;
        this.idApp=idApp;
        this.idProducto=idProducto;
        this.cantidad=0;
        this.fechaAct=null;
        this.cantidadMin=0;

        this.ayuda={'_ayudaBotAddStock':'Haciendo click le permitirá agregar productos al Stock',
        '_ayudaBotRemStock':'Haciendo click podrá sacar productos del stock'}
        if(idApp && idProducto){
            this.show();
        }else{
            this.errorShow();
        }
        

    }

    show(){
        let d=document.querySelector('#'+this.idDiv);
        d.innerHTML=`<div class="row" style="border-style: solid;border-width: 1px;border-radius: 5px; padding:2px 3px">
                            <div class="col-xs-2 col-md-1">
                                <span style="font-size:1.2rem;">Stock</span>
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-grid-3x3-gap" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4 2H2v2h2V2zm1 12v-2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1zm0-5V7a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1zm0-5V2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1zm5 10v-2a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1zm0-5V7a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1zm0-5V2a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1zM9 2H7v2h2V2zm5 0h-2v2h2V2zM4 7H2v2h2V7zm5 0H7v2h2V7zm5 0h-2v2h2V7zM4 12H2v2h2v-2zm5 0H7v2h2v-2zm5 0h-2v2h2v-2zM12 1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zm-1 6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V7zm1 4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1h-2z"/>
                                </svg>
                            </div>
                            <div class="col-xs-4 col-md-3">
                                <div id="lbl_stock_${this.idProducto}" class="text-primary">${this.cantidad} un.</div>
                            </div>
                            <div class="col-xs-6 col-md-3" style="padding: 10px 3px;">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bell" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2z"/>
                                    <path fill-rule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
                                </svg>
                                <input   class="form-control" id="txt_stock_min_${this.idProducto}"  type="text"  placeholder="Cantidad Minima" style="max-width: 150px; width:50%; padding:1px 2px; margin: 1px 5px;display: inline;" value="${this.cantidadMin}" title="Cantidad minima de stock antes de emitir una alerta">un.
                            </div>

                            <div  class="col-xs-8 col-md-3" style="padding: 10px 3px;">
                                <div class="btn-group" role="group" aria-label="controles">
                                    <button id="botAddStock_${this.idProducto}" type="button"  class="btn btn-primary" style="padding: 5px 6px; height: 35px; width: 50px;"  title="${this.ayuda._ayudaBotAddStock}">
                                         <svg width="1.8em" height="1.8em" viewBox="0 0 16 16" class="bi bi-box-arrow-in-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M8.146 11.354a.5.5 0 0 1 0-.708L10.793 8 8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z"/>
                                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 1 8z"/>
                                            <path fill-rule="evenodd" d="M13.5 14.5A1.5 1.5 0 0 0 15 13V3a1.5 1.5 0 0 0-1.5-1.5h-8A1.5 1.5 0 0 0 4 3v1.5a.5.5 0 0 0 1 0V3a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-.5.5h-8A.5.5 0 0 1 5 13v-1.5a.5.5 0 0 0-1 0V13a1.5 1.5 0 0 0 1.5 1.5h8z"/>
                                         </svg>
                                    </button>
                                   
                                    <button id="botRemStock_${this.idProducto}" type="button" class="btn btn-primary" style="padding: 5px 6px;height: 35px; width: 50px;" title="${this.ayuda._ayudaBotRemStock}">
                                         <svg width="1.8em" height="1.8em" viewBox="0 0 16 16" class="bi bi-box-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M11.646 11.354a.5.5 0 0 1 0-.708L14.293 8l-2.647-2.646a.5.5 0 0 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z"/>
                                            <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
                                            <path fill-rule="evenodd" d="M2 13.5A1.5 1.5 0 0 1 .5 12V4A1.5 1.5 0 0 1 2 2.5h7A1.5 1.5 0 0 1 10.5 4v1.5a.5.5 0 0 1-1 0V4a.5.5 0 0 0-.5-.5H2a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5v-1.5a.5.5 0 0 1 1 0V12A1.5 1.5 0 0 1 9 13.5H2z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div id="est_stock_${this.idProducto}" class="col-xs-2 col-md-1" style="padding: 10px 3px;">
                                <img src="assets/imgs/espera.gif" style="width:32px;height:32px; padding: 0px;" alt="*"/>
                            </div>

                            <div id="input_stock_${this.idProducto}" class="col-xs-12 col-md-12"></div>
                      </div>

        `
       

        let botAdd=document.querySelector("#botAddStock_"+this.idProducto);
        let botRem=document.querySelector("#botRemStock_"+this.idProducto);
        let me=this;
        botAdd.onclick=function(){
            let inputAdd=document.querySelector('#input_stock_'+me.idProducto);
            inputAdd.innerHTML= ` <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-box-seam" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                                </svg>
                                <p style=" font-size: 1.2rem; width:120px;display: inline-flex;">Cantidad que se agregará al stock</p>
                                <input   class="form-control" id="txt_add_stock_${me.idProducto}"  type="text"  placeholder="agregar cantidad" style="max-width: 150px; width:50%; padding:1px 2px; margin: 1px 5px;display: inline;">un.
                               
                                <div class="btn-group" role="group" aria-label="controles">
                                    <button id="cancelarAddStock_${me.idProducto}" type="button"  class="btn btn-danger" style="padding: 5px 6px;" >
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
                                            <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
                                        </svg>
                                    </button>
                                   
                                    <button  id="aceptarAddStock_${me.idProducto}" type="button" class="btn btn-success" style="padding: 5px 6px;"">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                        </svg>
                                    </button>
                                </div>
                                `
                                document.querySelector('#cancelarAddStock_'+me.idProducto).onclick=function(){
                                    document.querySelector('#input_stock_'+me.idProducto).innerHTML='';
                                }
                                document.querySelector('#aceptarAddStock_'+me.idProducto).onclick=function(){
                                    if( me.addStock(document.querySelector('#txt_add_stock_'+me.idProducto).value)){
                                        document.querySelector('#input_stock_'+me.idProducto).innerHTML='';
                                    }
                                    
                                }

        }
        botRem.onclick=function(){
            let inputAdd=document.querySelector('#input_stock_'+me.idProducto);
            inputAdd.innerHTML= ` <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-box-seam" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                                </svg>
                                <p style=" font-size: 1.2rem; width:120px;display: inline-flex;">Cantidad que se quitará del stock</p>
                                <input   class="form-control" id="txt_add_stock_${me.idProducto}"  type="text"  placeholder="agregar cantidad" style="max-width: 150px; width:50%; padding:1px 2px; margin: 1px 5px;display: inline;">un.
                               
                                <div class="btn-group" role="group" aria-label="controles">
                                    <button id="cancelarAddStock_${me.idProducto}" type="button"  class="btn btn-danger" style="padding: 5px 6px;" >
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
                                            <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
                                        </svg>
                                    </button>
                                   
                                    <button  id="aceptarAddStock_${me.idProducto}" type="button" class="btn btn-success" style="padding: 5px 6px;"">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                        </svg>
                                    </button>
                                </div>
                                `
                                document.querySelector('#cancelarAddStock_'+me.idProducto).onclick=function(){
                                    document.querySelector('#input_stock_'+me.idProducto).innerHTML='';
                                }
                                document.querySelector('#aceptarAddStock_'+me.idProducto).onclick=function(){
                                    if( me.remStock(document.querySelector('#txt_add_stock_'+me.idProducto).value)){
                                        document.querySelector('#input_stock_'+me.idProducto).innerHTML='';
                                    }
                                    
                                }

        }

        this.getData()
    }


    errorShow(){
        let d=document.querySelector('#'+this.idDiv);
        d.innerHTML=`<div class="row">
                            <div class="col-md-12 text-center text-danger" >
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-exclamation-triangle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.938 2.016a.146.146 0 0 0-.054.057L1.027 13.74a.176.176 0 0 0-.002.183c.016.03.037.05.054.06.015.01.034.017.066.017h13.713a.12.12 0 0 0 .066-.017.163.163 0 0 0 .055-.06.176.176 0 0 0-.003-.183L8.12 2.073a.146.146 0 0 0-.054-.057A.13.13 0 0 0 8.002 2a.13.13 0 0 0-.064.016zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
                                    <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
                                </svg>
                                <spam>Error, el control nececita datos para poder conectarce</spam>
                            </div>
                           

                      </div>
                      `

    }
    /**
     * Éste método le pide al servidor los datos de stock del producto para 
     * cargarlo en el control
     */
    getData(){
        this.setEstado('ESPERA');
        var me=this;
        new Server().consulta('index.php?r=stock%2Fget-stock-ajax&id='+this.idApp+'&idProducto='+this.idProducto,{'_csrf': yii.getCsrfToken()},function(rta){
                //Resultado: 'cantidad':number,'fechaAct':aaaa-mm-dd hh:mm:ss,'cantidadMin':number}

                if(rta.error==0){
                    me.cantidad=rta.data.cantidad;
                    me.fechaAct=rta.data.fechaAct;
                    me.cantidadMin=rta.data.cantidadMin;
                    me.setEstado('RECIBIDO');
                    me.refreshData();
                }else{
                   me.setEstado('ERROR',rta.message);
                }
        })
    }

    addStock(cantidad){
        if(cantidad && isNumber(cantidad)){
            this.setEstado('ESPERA');
            var me=this;
            new Server().consulta('index.php?r=stock%2Fadd-stock-ajax&id='+this.idApp+'&idProducto='+this.idProducto+'&cantidad='+cantidad,{'_csrf': yii.getCsrfToken()},function(rta){
                    //Resultado: 'cantidad':number,'fechaAct':aaaa-mm-dd hh:mm:ss,'cantidadMin':number}

                    if(rta.error==0){
                        me.cantidad=rta.data.cantidad;
                        me.fechaAct=rta.data.fechaAct;
                        me.cantidadMin=rta.data.cantidadMin;
                        me.setEstado('RECIBIDO');
                        me.refreshData()
                    }else{
                    me.setEstado('ERROR',rta.message);
                    }
            })
            return true;
        }else{
             alert('no es una cantidad valida '+ cantidad)
             return false;
        }
        
    }

    
    remStock(cantidad){
        if(cantidad && isNumber(cantidad)){
            this.setEstado('ESPERA');
            var me=this;
            new Server().consulta('index.php?r=stock%2Frem-stock-ajax&id='+this.idApp+'&idProducto='+this.idProducto+'&cantidad='+cantidad,{'_csrf': yii.getCsrfToken()},function(rta){
                    //Resultado: 'cantidad':number,'fechaAct':aaaa-mm-dd hh:mm:ss,'cantidadMin':number}

                    if(rta.error==0){
                        me.cantidad=rta.data.cantidad;
                        me.fechaAct=rta.data.fechaAct;
                        me.cantidadMin=rta.data.cantidadMin;
                        me.setEstado('RECIBIDO');
                        me.refreshData()
                    }else{
                    me.setEstado('ERROR',rta.message);
                    }
            })
            return true;
        }else{
             alert('no es una cantidad valida '+ cantidad)
             return false;
        }
        
    }

    refreshData(){
        document.querySelector("#lbl_stock_"+this.idProducto).innerHTML=this.cantidad+'un.';
        document.querySelector("#txt_stock_min_"+this.idProducto).value=this.cantidadMin;
    }

    setEstado(txtEstado,mensaje){
        let e=document.querySelector('#est_stock_'+this.idProducto);
        e.innerHTML=`<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-exclamation" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
      </svg>`;
        switch(txtEstado){
            case 'ESPERA':
                e.innerHTML=`<img src="assets/imgs/espera.gif" style="width:32px;height:32px;padding: 0px;" alt="*"/>`
                break;
            case 'RECIBIDO':
                e.innerHTML=`<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
              </svg>`;
                break; 
            case 'ERROR':
                e.innerHTML=`<svg  width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-exclamation-triangle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M7.938 2.016a.146.146 0 0 0-.054.057L1.027 13.74a.176.176 0 0 0-.002.183c.016.03.037.05.054.06.015.01.034.017.066.017h13.713a.12.12 0 0 0 .066-.017.163.163 0 0 0 .055-.06.176.176 0 0 0-.003-.183L8.12 2.073a.146.146 0 0 0-.054-.057A.13.13 0 0 0 8.002 2a.13.13 0 0 0-.064.016zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
                    <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
                </svg>`;
                e.title=mensaje;
                break;         
        }
        
    }
}