'use strict';

const icon_check=<svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-check2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
</svg>;

const icon_check_doble=<svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-check2-all" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" d="M12.354 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
<path d="M6.25 8.043l-.896-.897a.5.5 0 1 0-.708.708l.897.896.707-.707zm1 2.414l.896.897a.5.5 0 0 0 .708 0l7-7a.5.5 0 0 0-.708-.708L8.5 10.293l-.543-.543-.707.707z"/>
</svg>

const icon_time=<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-hourglass-split" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0c0 .701.478 1.236 1.011 1.492A3.5 3.5 0 0 1 11.5 13s-.866-1.299-3-1.48V8.35z"/>
</svg>

const icon_dinero=(color='currentColor')=><svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-cash-stack" fill={color} xmlns="http://www.w3.org/2000/svg">
<path d="M14 3H1a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1h-1z"/>
<path fill-rule="evenodd" d="M15 5H1v8h14V5zM1 4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H1z"/>
<path d="M13 5a2 2 0 0 0 2 2V5h-2zM3 5a2 2 0 0 1-2 2V5h2zm10 8a2 2 0 0 1 2-2v2h-2zM3 13a2 2 0 0 0-2-2v2h2zm7-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
</svg>

const icon_proceso=<svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-hammer" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
<path d="M9.812 1.952a.5.5 0 0 1-.312.89c-1.671 0-2.852.596-3.616 1.185L4.857 5.073V6.21a.5.5 0 0 1-.146.354L3.425 7.853a.5.5 0 0 1-.708 0L.146 5.274a.5.5 0 0 1 0-.706l1.286-1.29a.5.5 0 0 1 .354-.146H2.84C4.505 1.228 6.216.862 7.557 1.04a5.009 5.009 0 0 1 2.077.782l.178.129z"/>
<path fill-rule="evenodd" d="M6.012 3.5a.5.5 0 0 1 .359.165l9.146 8.646A.5.5 0 0 1 15.5 13L14 14.5a.5.5 0 0 1-.756-.056L4.598 5.297a.5.5 0 0 1 .048-.65l1-1a.5.5 0 0 1 .366-.147z"/>
</svg>

const icon_rechazado=<svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-x-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
</svg>

const icon_user=<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                </svg>

const icon_fecha_ini=<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-calendar-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                    <path fill-rule="evenodd" d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                    </svg>     
const icon_fecha_ent=<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-calendar-week" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                    <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                    </svg>                              
const icon_fecha_fin=<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-calendar2-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                    <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z"/>
                    <path fill-rule="evenodd" d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                    </svg>  
const icon_ojo=(w='1em',h='1em',color='currentColor')=><svg width={w} height={h} viewBox="0 0 16 16" class="bi bi-eye" fill={color} xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"/>
                <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                </svg> 
const icon_embudo=(w='1em',h='1em',color='currentColor')=><svg width={w} height={h} viewBox="0 0 16 16" class="bi bi-funnel" fill={color}  xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
                                                        </svg>
const icon_lista=(w='1em',h='1em',color='currentColor')=><svg width={w} height={h}  viewBox="0 0 16 16" class="bi bi-list-task" fill={color} xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5H2zM3 3H2v1h1V3z"/>
                                                        <path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9z"/>
                                                        <path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V7zM2 7h1v1H2V7zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5H2zm1 .5H2v1h1v-1z"/>
                                                        </svg>         
const icon_buscar=(w='1em',h='1em',color='currentColor')=><svg width={w} height={h}  viewBox="0 0 16 16" class="bi bi-search" fill={color}  xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                                            </svg>                                                       
const icon_tarea=(w='1em',h='1em',color='currentColor')=><svg width={w} height={h}  viewBox="0 0 16 16" class="bi bi-clipboard" fill={color}  xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                                                        <path fill-rule="evenodd" d="M9.5 1h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                                                        </svg>                                                                                                                      

const icon_circulo_cruz=(w='1em',h='1em',color='currentColor')=><svg  width={w} height={h} viewBox="0 0 16 16" class="bi bi-x-circle" fill={color} xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                                <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                                </svg>                                                                                                                    
const icon_add_pedido=(w='1em',h='1em',color='currentColor')=><svg width={w} height={h} viewBox="0 0 16 16" class="bi bi-clipboard-plus" fill={color} xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                                                                <path fill-rule="evenodd" d="M9.5 1h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3zM8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                                                                </svg>                                                                                                                    
  
 const icon_flecha_izq=(w='1em',h='1em',color='currentColor')=><svg width={w} height={h} viewBox="0 0 16 16" class="bi bi-arrow-left" fill={color} xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                                                </svg>                                                                                                                    

  
const _spc='&nbsp;'
const stySaldo={
    'float':'right',
    'fontSize':'1.2em',
    'color':'black'
}

const styFechaMin={
    'float':'right',
    'fontSize':'1.0em',
    'color':'black'
}
const styDinero={
    'float':'right',
    'margin':'2px 5px',
    
}
const styBotonDlg={
    width:'42px',
    height:'42px',
    display:'inline'
    
}
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