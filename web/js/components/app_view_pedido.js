'use strict';

const getTel=(txtTel,paisCodigo)=>{
    return(paisCodigo+txtTel.replace(/['\-','_',' ','(',')']/g,''))
}



/**
 * Componente que muestra la lista de pedidos
 */
class ViewPedido extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            idApp: idApp, //variable global
            pedidos: [],
            dlgShow: false,
            dlgContenido: null,
            cltPedidos:null ,
            page:'PEDIDOS_ESPERA'
        }
    }
  

    componentDidMount() {

        (new Server).consulta('index.php?r=pedido%2Findex-react&idApp=' + this.state.idApp, { '_csrf': yii.getCsrfToken() }, (rst) => {

            if (rst) {
                console.log(rst.data)
                this.setState({ 
                    pedidos: rst.data,
                    cltPedidos:null ,
                    clienteSel:null,
                    page:'PEDIDOS_TODOS'
                })

            }
        });
    }

    /*----------------------------------Styles------------- */
    styleLista = {
        overflow: 'auto',
        height: '600px'
    }
    styMes={
        height:' 30px',
        border: 'solid 1px',
        padding:' 5px 10px',
        background: 'navajowhite',
        color: 'black',
        margin: '5px',
    }


    serverListaPedidos=(cliente)=>{

        Pedido.getPedidosClienteXMes(cliente,(pdos)=>{
             this.setState({ cltPedidos: pdos,
                                page:'PEDIDOS_CLIENTE',
                                clienteSel:cliente,
                                dlgShow: false,})
        })
        this.setState({  page:'PEDIDOS_ESPERA'})
     
    }

    serverListaPedidosXMes=(cliente)=>{

        Pedido.getPedidosClienteXMes(cliente,(pdos)=>{
             this.setState({ cltPedidos: pdos,
                                page:'PEDIDOS_CLIENTE',
                                clienteSel:cliente,
                                dlgShow: false,})
        })
         this.setState({  page:'PEDIDOS_ESPERA'})
     
    }

    /*------------------------Handlers-----------------------*/
    onDlgShowContenido = (accion, obj) => {
        if (accion === 'CONECTAR-CLIENTE') {
            let contenido = <InfoCliente cliente={obj} onClickHitoriaHander={this.serverListaPedidos}/>

            this.setState({
                dlgContenido: contenido,
                dlgShow: true,
            })
        }
    }
    onClickItemHandler=(pedido)=>{
            if(pedido){
                window.location.href=urlBase+"/index.php?r=pedido/update&app_idApp="+pedido.app_idApp+"&id="+pedido.id;
            }
    }

    onBackHandler=(page)=>{
        if(page){
            this.setState({
                page:page,
                clienteSel:null,
                dlgContenido: null,
                dlgShow: false,
            })
        }

    }
    onClickAddPedidoHandle=(e)=>{
        
            window.location.href=urlBase+"/index.php?r=pedido/create&idApp="+this.state.idApp;
      
    }
//-------------------------------------------------------

    urlLoad=(url)=>{
        if(url){
                window.location.href=urlBase+url;
            }
    }

    buscarText = (text) => {
        (new Server).consulta('index.php?r=pedido%2Findex-react&idApp=' + this.state.idApp + '&PedidoSearchJson%5BtxtSearch%5D=' + text, { '_csrf': yii.getCsrfToken() }, (rst) => {

            if (rst) {
                this.setState({ pedidos: rst.data })

            }
        });
    }


    pageListaPedidos=()=>{
            let cont=null

            if(this.state.pedidos.length>0){
                cont=this.state.pedidos.map((pd) => {
                    return (<ItemPedido key={pd.id} pedido={pd} onDlgHandle={this.onDlgShowContenido} onClick={this.onClickItemHandler} />)
                })
            }


        return(
            <div>
               
                <BarraBusqueda nombre="Pedidos" onChangeText={this.buscarText} pageBack={''} onBack={null} onClickAddPedido={this.onClickAddPedidoHandle}/>

                <div style={this.styleLista}>
                    {cont}
                </div>
                <Dialogo show={this.state.dlgShow} contenido={this.state.dlgContenido} />

                <h2>barra de estado</h2>
            </div>
        )
    }

    
    pageListaPedidosCliente=(cliente)=>{
           let cont=null

            if(this.state.cltPedidos&&this.state.cltPedidos instanceof Array && this.state.cltPedidos.length>0){
                cont=this.state.cltPedidos.map((pd) => {
                    return (<ItemPedidoCliente key={pd.id} pedido={pd} onDlgHandle={this.onDlgShowContenido} onClick={this.onClickItemHandler} />)
                })
            }

            if(this.state.cltPedidos &&this.state.cltPedidos instanceof Map){
                cont=[];
                for (var [key, value] of this.state.cltPedidos) {
                   
                    cont.push(<div style={this.styMes}> {key}<span style={{float:'right'}}>{'$'+value.monto}</span></div>)
                    cont.push(value.pdos.map((pd) => {
                              return (<ItemPedidoCliente key={pd.id} pedido={pd} onDlgHandle={this.onDlgShowContenido} onClick={this.onClickItemHandler} />)
                         }))
                  }
            }
        
        return(
            <div>
                <BarraBusqueda nombre={cliente.nombre} onChangeText={this.buscarText} pageBack={'PEDIDOS_TODOS'} onBack={this.onBackHandler} onClickAddPedido={this.onClickAddPedidoHandle}/>
                <div style={this.styleLista}>
                    {cont}
                </div>
                <Dialogo show={this.state.dlgShow} contenido={this.state.dlgContenido} />
            </div>
        )
    
    }


    pagePedidosEspera=()=>{
        return(<div className="espera">
            <img src="assets/imgs/espera.gif" alt="Cargando..." style={{width:'50px',height:"50px"}}/>Cargando...
            </div>)
    }


    render() {
        if(this.state.page==='PEDIDOS_ESPERA')return (this.pagePedidosEspera())
        if(this.state.page==='PEDIDOS_TODOS')return (this.pageListaPedidos())
        if(this.state.page==='PEDIDOS_CLIENTE')return (this.pageListaPedidosCliente(this.state.clienteSel))
        
    }
}


/**
 * Componente que muestra la información del cliente
 * @param {*} props 
 */

function InfoCliente(props){
    let pais='Argentina'
    return(
        <div>
             <div className="row">
                    <div class="col-md-12" style={{textAlign: 'center'}}>
                        <img src="assets/imgs/icon_call.png" alt="" className="imgIcon" style={{width:'80px',height:'80px', margin:'5px'}}/>
                        <h3  style={{margin: '1px'}}>{props.cliente.nombre}</h3>
                        <h5  style={{margin: '1px'}}>{props.cliente.empresa}</h5>
                        <span>{'Cel: '+props.cliente.cel}</span>
                        <span>{' Tel: '+props.cliente.tel}</span>
                        <span>{' dirección: '+props.cliente.direccion+' - '+props.cliente.localidad}</span>
                        <span>{' e-mail: '+props.cliente.email}</span>
                    </div>
             </div>
             <div className="row" style={{margin:'10px',textAlign: 'center'}}>
                     <h5>Conectarce</h5>
                     <hr style={{border:'solid 1px gray',margin:'1px 5px'}}/>
                    <span id="bot_call"> <a href={"tel:"+getTel(props.cliente.cel,'+54')}><img src="assets/imgs/icon_call.png" alt=""  style={styBotonDlg}/></a> </span>
                    <span id="bot_whatsapp"  ><a href={"https://wa.me/"+getTel(props.cliente.cel,'54')}><img src="assets/imgs/icon_whatsapp.png" alt=""  style={styBotonDlg}/> </a></span>
                    <span id="bot_email"   ><a href={"mailto:"+props.cliente.email}><img src="assets/imgs/icon_email.png" alt=""  style={styBotonDlg}/></a> </span>
                    <span id="bot_dir"  ><a href={"https://www.google.com.gt/maps/place/"+props.cliente.direccion+"+"+"+"+props.cliente.localidad+"+"+pais} target="_blank"><img src="assets/imgs/icon_dir.png" alt=""  style={styBotonDlg}/></a> </span>
                    <h5>Resumen</h5>
                     <hr style={{border:'solid 1px gray',margin:'1px 5px'}}/>
                    <span id="bot_historia"  ><img src="assets/imgs/icon_pedido.png" alt="" style={styBotonDlg} onClick={(e)=>props.onClickHitoriaHander(props.cliente)}/> </span>
                    <span id="bot_favorito"  ><img src="assets/imgs/icon_productos_favorito.png" alt=""  style={styBotonDlg}/> </span></div>

             </div>
    )
}

class BotAgregar extends React.Component {
    constructor(props) {
        super(props);
        this.state = {  }
    }
    styBot={width:' 70px',height: '40px',borderRadius: '10px', boxShadow:'3px 5px 10px 0px black'}
    render() { 
        return ( <button className="btn btn-success bot-add" style={ this.styBot} onClick={this.props.onClick}>{icon_add_pedido('28px','28px','white')}</button> );
    }
}
 


class Dialogo extends React.Component{
    constructor(props){
       super(props)
       this.state={
           desplegado:props.show
       }
   }

   componentWillReceiveProps(nextProps) {
        // ¡Esto borrará cualquier actualización del estado local!
        // No lo hagas.
        this.setState({ desplegado: nextProps.show });
    }

   onClickHander=(e)=>{
    let desp=!this.state.desplegado
    this.setState({ desplegado: desp })
    //this.props.setDlgShow(desp)
    }

    styDialogo=()=>{

       
        if(this.state.desplegado){
            return'block'
        }else{
             return'none'
        }
    }

   render() {
       return (
            <div  onClick={this.onClickHander} style={{display:this.styDialogo(),position:'fixed',background:'#00000069',width:'100%',height:'100%',top:'0px',left:'0px',Zindex:'1000'}}>
                <div style={{display:'block',position:'fixed',border:'solid 2px gray',borderRadius:'10px',background:'#ffffffd1',width:'60%',height:'60%',top:'20%',left:'20%',Zindex:'1000',overflow:'auto'}}>
                    {this.props.contenido}
                </div>
            </div>
       );
   }
}

/**
 * Item de pedidos 
 * Contiene toda la imformaciòn de los pedidos para las lista
 */
class ItemPedido extends React.Component{
     constructor(props){
        super(props)


    }

   styRow={
            background:'white',
            padding:'5px',
            margin:'0px', 
            height:'100px', 
            borderBottomStyle:'Solid',
            borderBottomWidth:'1px',
            borderBottomColor:'grey',
            paddingLeft: '5px',
            marginLeft: '5px'
            }
    styPedido=(color='gray')=>{
           return{  
                    height: '100%',
                    borderLeftStyle:'Solid',
                    borderLeftWidth:'5px',
                    borderLeftColor:color}
    }   
    
   onAccion=(accion)=>{
       if(accion==='CONECTAR-CLIENTE'){
           this.props.onDlgHandle(accion,this.props.pedido.cliente)
       }

   }

   onClickHandler=()=>{
       this.props.onClick(this.props.pedido)
   }
    render() {
        let pdo=this.props.pedido
        let iconoEstado= icon_proceso
        let iconoPago=icon_dinero()
        let iconoFecha=icon_fecha_ent
        let lblFecha=days_between(new Date(),new Date(this.props.pedido.fechaEntrega))+'días'
        let styPedido=this.styPedido(Pedido.getColorPrioridad(this.props.pedido.prioridad))

        if(pdo.estado===Pedido.ESTADO_ESPERA){
            iconoEstado= icon_time
            iconoFecha=icon_fecha_ini
            lblFecha=getFechaDMA(new Date(this.props.pedido.fechaIni))
        }
        if(pdo.estado===Pedido.ESTADO_ENTREGADO){
            iconoEstado= icon_check_doble
            iconoFecha=icon_fecha_fin
            lblFecha=getFechaDMA(new Date(this.props.pedido.fechaFin))
            styPedido=this.styPedido(Pedido.getColorPrioridad('gray'))
        }
        if(pdo.estado===Pedido.ESTADO_RECHAZADO){
            iconoEstado= icon_rechazado
        }

        if(parseFloat(pdo.pago)>0){
            iconoPago=icon_dinero('green') 
        }
        if(parseFloat(pdo.saldo)>0 && pdo.estado===Pedido.ESTADO_ENTREGADO){
            iconoPago=icon_dinero('red') 
        }

       
       /*<span style={{float:'right'}}>{icon_fecha_ini}{days_between(new Date(this.props.pedido.fechaIni),new Date())+'días'}</span> */

        return (
             <div className="row" style={this.styRow}>

                 <div className="col-md-1 col-xs-3">
                 <AvatarCliente cliente={this.props.pedido.cliente} onClick={this.onAccion}/> 
                 </div>
                 <div className="col-md-11  col-xs-9" style={styPedido} onClick={this.onClickHandler}>
                     <h5 className='truncate' style={{margin:'1px 3px'}}><strong>{this.props.pedido.cliente.nombre}</strong>{' ('+this.props.pedido.cliente.empresa+')'}</h5>
                     <p className='truncate' style={{margin:'1px 3px'}}>{this.props.pedido.comentarios}</p>

                    <span>{iconoEstado}</span> <span style={styDinero}>{iconoPago}</span><span style={stySaldo}>{'$'+this.props.pedido.saldo}</span>
                    <div className='truncate'>
                       <span className='truncate'>{icon_user}&nbsp;{this.props.pedido.respNombre?this.props.pedido.respNombre:this.props.pedido.respUserName}</span> 
                       
                       <span style={{float:'right'}}>{iconoFecha}&nbsp;{lblFecha}</span>
                    </div>
                     
                 </div>

               

             </div>
        );
    }
}


/**
 * Item de pedidos 
 * Contiene toda la imformaciòn de los pedidos para las lista
 */
class ItemPedidoCliente extends React.Component{
    constructor(props){
       super(props)


   }

  styRow={
           background:'white',
           padding:'5px',
           margin:'0px', 
           height:'80px', 
           borderBottomStyle:'Solid',
           borderBottomWidth:'1px',
           borderBottomColor:'grey',
           paddingLeft: '5px',
           marginLeft: '5px'
           }
   styPedido=(color='gray')=>{
          return{  
                   height: '100%',
                   borderLeftStyle:'Solid',
                   borderLeftWidth:'5px',
                   borderLeftColor:color}
   }   
   
  onAccion=(accion)=>{
      if(accion==='CONECTAR-CLIENTE'){
          this.props.onDlgHandle(accion,this.props.pedido.cliente)
      }

  }

  onClickHandler=()=>{
      this.props.onClick(this.props.pedido)
  }
   render() {
       let pdo=this.props.pedido
       let iconoEstado= icon_proceso
       let iconoPago=icon_dinero()
       let iconoFecha=icon_fecha_ent
       let lblFecha=days_between(new Date(),new Date(this.props.pedido.fechaEntrega))+'días'
       let styPedido=this.styPedido(Pedido.getColorPrioridad(this.props.pedido.prioridad))

       if(pdo.estado===Pedido.ESTADO_ESPERA){
           iconoEstado= icon_time
           iconoFecha=icon_fecha_ini
           lblFecha=getFechaDMA(new Date(this.props.pedido.fechaIni))
       }
       if(pdo.estado===Pedido.ESTADO_ENTREGADO){
           iconoEstado= icon_check_doble
           iconoFecha=icon_fecha_fin
           lblFecha=getFechaDMA(new Date(this.props.pedido.fechaFin))
           styPedido=this.styPedido(Pedido.getColorPrioridad('gray'))
       }
       if(pdo.estado===Pedido.ESTADO_RECHAZADO){
           iconoEstado= icon_rechazado
       }

       if(parseFloat(pdo.pago)>0){
           iconoPago=icon_dinero('green') 
       }
       if(parseFloat(pdo.saldo)>0 && pdo.estado===Pedido.ESTADO_ENTREGADO){
           iconoPago=icon_dinero('red') 
       }

       let resp= <span>{icon_user}&nbsp;{'no hay'}</span> 



      /*<span style={{float:'right'}}>{icon_fecha_ini}{days_between(new Date(this.props.pedido.fechaIni),new Date())+'días'}</span> */

       return (
           <div className="row" style={this.styRow}>

               <div className="col-md-2 col-xs-3" style={{padding:' 2px'}}>
                   <span>{iconoEstado}</span> 
                  
                   <span style={styFechaMin}>{getFechaDMA(new Date(this.props.pedido.fechaIni))}</span>
               </div>
               <div className="col-md-10  col-xs-9" style={styPedido} onClick={this.onClickHandler}>
                   <h5 className='truncate' style={{ margin: '1px 3px' }}><strong>{this.props.pedido.nombre}</strong></h5>
                   <p className='truncate' style={{ margin: '1px 3px' }}>{this.props.pedido.comentarios}</p>

                   <div className='truncate'>
                       <span style={{ float: 'left' }}>{iconoFecha}&nbsp;{lblFecha}</span>
                        <span style={stySaldo}>{'$' + this.props.pedido.saldo}</span> <span style={styDinero}>{iconoPago}</span>
                   </div>
                  

               </div>

           </div>
       );
   }
}




class AvatarCliente extends React.Component{
    constructor(props){
        super(props)
        this.state={
            desplegado:false
        }
    }

    onClickHander=(e)=>{
       this.props.onClick('CONECTAR-CLIENTE')
    }

    styleBot=(efecto,x,y)=>{
        return(
            {
                position:'absolute',
                height: '64px',
                width: '64px',
                top: y+'px',
                left: x+'px',
                animationName: efecto,
                animationDuration: '0.5s',
                Zindex: '100'

           })
    }

    styControles=()=>{
        if(this.state.desplegado){
            return{display:'block'}
        }else{
             return{display:'none'}
        }
    }

    render() {
        let cliente=this.props.cliente
        let icono="assets/imgs/avatar.png"
        let cel=null
        let email=null
        let dir=null
        if (cliente){
            icono=cliente.urlFoto?cliente.urlFoto:"assets/imgs/avatar.png"
            cel=cliente.cel?cliente.cel:null
            email=cliente.email?cliente.email:null
            if(cliente.localidad){
                if(cliente.direccion)dir=cliente.direccion+' - '
                dir+=cliente.localidad

            }
           
        }

        return (
        <div onClick={this.onClickHander}>
                <img src={icono} alt="" className="imgIcon"/> 
                <span style={{display:'none'}} >
                    <span id="bot_call" style={this.styleBot('botEmergenteA',10,-40)}><img src="/yii2/web/assets/imgs/icon_call.png" alt="" className="botFlotante"/> </span>
                    <span id="bot_whatsapp" style={this.styleBot('botEmergenteB',60,-30)}><img src="/yii2/web/assets/imgs/icon_whatsapp.png" alt="" className="botFlotante"/> </span>
                    <span id="bot_email" style={this.styleBot('')}><img src="/yii2/web/assets/imgs/icon_email.png" alt="" className="botFlotante"/> </span>
                    <span id="bot_dir" style={this.styleBot('')}><img src="/yii2/web/assets/imgs/iconDir.png" alt="" className="botFlotante"/> </span>
                    <span id="bot_historia" style={this.styleBot('')}><img src="/yii2/web/assets/imgs/iconHistoria.png" alt="" className="botFlotante"/> </span>
                    <span id="bot_favorito" style={this.styleBot('')}><img src="/yii2/web/assets/imgs/iconFavorito.png" alt="" className="botFlotante"/> </span>
                </span>
        </div>
             
        );
    }
}


/**
 * Barra de busqueda con distintos filtros
 */
class BarraBusqueda extends React.Component{
    constructor(props){
        super(props)
        this.state={
            visTextBusq:false,
            pageBack:props.pageBack
        }

    }
    onChangeText=(e)=>{
        if(e.target.value.length>0){
            console.log('se escribio '+e.target.value)
            this.props.onChangeText(e.target.value)
        }
    }
    onClickBusqHandle=(e)=>{
        let txtBq=!this.state.visTextBusq
        if(!txtBq){
            this.props.onChangeText('')
        }
        this.setState({visTextBusq:txtBq})
    }

    onClickAddHandler=(e)=>{
        this.props.onClickAddPedido()
    }
    //WARNING! To be deprecated in React v17. Use new lifecycle static getDerivedStateFromProps instead.
    componentWillReceiveProps(nextProps) {
        let state=this.state

        this.setState({
            visTextBusq:false,
            pageBack:nextProps.pageBack,
            visTextBusq:state.visTextBusq
           })
    }

    toolBack=()=>{return this.state.pageBack?<div style={this.styBot} onClick={(e)=>this.props.onBack(this.state.pageBack)}>{icon_flecha_izq('24px', '24px')}</div>:<div></div>}

    toolNombre=(col)=>{
       return <div className={"col-md-"+col+" col-xs-"+(col+1)+" truncate"} style={{textAlign: 'left'}}>
                {this.toolBack()}
                {icon_tarea('24px', '24px')}{this.props.nombre}
        </div>
    }

    txtBusqueda=<input className="form-contro" type="text" placehome="Buscar" onKeyUp={this.onChangeText} style={{width:'60%'}}/>
   

    styBotView={ 
                    border:'solid 1px',
                    padding:'1px 10px',
                    margin:'1px 10px',
                    textAlign: 'center',
                    display: 'inline-block',
                    borderRadius: '10px',
                    height: '32px',
                  
                
                }
    styBarra={ 
                border:'solid 2px',
                padding:'5px',
                margin:'1px 1px 10px',
                textAlign: 'center',
               borderRadius: '10px',
               background:'var(--app-ctr-bg-color)'
               
            
            }  
    styBot={ 
            border:'solid 1px',
            padding:'2px 5px',
            margin:'2px 10px',
            textAlign: 'center',
            borderRadius: '10px',
            width: '40px',
            display:'inline-block'
 
        
        }                  




    render(){
        let toolView=<div className="col-md-4 col-xs-4" >
                     <span>{icon_ojo('24px', '24px')}</span>{icon_flecha_izq('24px', '24px')}<span style={this.styBotView}>{icon_lista('24px', '24px')}</span>
                   </div>
        let toolFiltro=<div className="col-md-4 col-xs-4">
                            <span>{icon_embudo('24px', '24px')}</span>
                            <span style={this.styBotView}>Normal</span>
                        </div>

      
        
       /* let toolNombre=<div className="col-md-5 col-xs-6 truncate">
                              {toolBack}
                              {icon_tarea('24px', '24px')}{this.props.nombre}
                        </div>*/

         let toolBuscar= <div className="col-md-4 col-xs-3" style={{textAlign: 'right'}} onClick={this.onClickBusqHandle}>
                            {icon_buscar('24px', '24px')}
                          </div>
         let toolTextBusq=<div className="col-md-9 col-xs-7" >
                            {icon_buscar('24px', '24px')} {this.txtBusqueda} <span onClick={this.onClickBusqHandle}>{icon_circulo_cruz('24px', '24px','red')}</span> 
                          </div>                 
          let toolBotAdd=<div className="col-md-2 col" style={{textAlign: 'right'}}>
                              <BotAgregar onClick={this.onClickAddHandler}/>
                          </div>     
        
        let tools=<div className="row" style={this.styBarra}>
                       {this.toolNombre(6)}
                       {toolBuscar} 
                       {toolBotAdd}
                  </div>

         if(this.state.visTextBusq){
             tools=<div className="row" style={this.styBarra}>
                        {this.toolNombre(4)}
                        {toolTextBusq}
             </div>
         }

        return (tools)
    }

}


ReactDOM.render(<ViewPedido/>, document.getElementById('view-pedido'));