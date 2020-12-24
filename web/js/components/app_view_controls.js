export class View extends React.Component {
    constructor(props) {
        super(props);
        this.state = {  }
    }
    render() { 
        return ( <div>
            {this.props.contenido}
            <button> Cancelar</button>
            <button>Aceptar</button>
        </div> );
    }
}
 

/**
 * props.user
 * props.texto
 */
export class Saludo extends React.Component{
    constructor(props) {
        super(props);
        this.state = {  }
    }
    render() { 
        return ( <div>
           {this.props.text}
            </div> );
    }
}

export class Avatar extends React.Component{
     constructor(props) {
        super(props);
        this.state = {  }
    }
    render() { 
        return ( <div>
           {this.props.text}
            </div> );
    }
}

