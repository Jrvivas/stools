'use strict';

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

const getIcon = (nombre = "alt", ancho = '32px', alto = '32px', onClickHandle = null) => {
  return /*#__PURE__*/React.createElement("img", {
    onClick: onClickHandle,
    src: "assets/icons/" + nombre + ".svg",
    alt: "",
    style: {
      width: ancho,
      height: alto
    }
  });
};

function PanelFraccion(cantidad = 1, ancho = 1, alto = 1, fraccion = 1) {
  return /*#__PURE__*/React.createElement("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    width: "100%",
    height: "128.53",
    viewBox: "0 0 90.089 34.008"
  }, /*#__PURE__*/React.createElement("g", {
    transform: "translate(-64.568 -78.246)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "40.448",
    height: "29.901",
    x: "-106.86",
    y: "-110.13",
    fill: "#b7c4c8",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "89.825",
    height: "33.744",
    x: "64.701",
    y: "78.378",
    fill: "none",
    stroke: "#000",
    strokeLinecap: "round",
    strokeWidth: "0.265",
    ry: "3.405"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "18.047",
    height: "18.126",
    x: "-140.58",
    y: "-104.39",
    fill: "gray",
    stroke: "#000",
    strokeLinecap: "round",
    strokeWidth: "0.265",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("g", {
    fontFamily: "sans-serif"
  }, /*#__PURE__*/React.createElement("text", {
    x: "67.112",
    y: "85.4",
    strokeWidth: "0.104",
    fontSize: "4.169",
    style: {
      lineHeight: "1.25"
    }
  }, /*#__PURE__*/React.createElement("tspan", {
    x: "67.112",
    y: "85.4"
  }, "Cantidad:")), /*#__PURE__*/React.createElement("text", {
    x: "88.847",
    y: "85.4",
    strokeWidth: "0.104",
    fontSize: "4.586",
    style: {
      lineHeight: "1.25"
    }
  }, /*#__PURE__*/React.createElement("tspan", {
    x: "88.847",
    y: "85.4",
    fontWeight: "bold"
  }, cantidad)), /*#__PURE__*/React.createElement("g", {
    fontSize: "3.881"
  }, /*#__PURE__*/React.createElement("text", {
    x: "67.592",
    y: "94.284",
    strokeWidth: "0.104",
    style: {
      lineHeight: "1.25"
    }
  }, /*#__PURE__*/React.createElement("tspan", {
    x: "67.592",
    y: "94.284"
  }, "Ancho:", ancho)), /*#__PURE__*/React.createElement("text", {
    x: "67.898",
    y: "100.484",
    strokeWidth: "0.076",
    style: {
      lineHeight: "1.25"
    }
  }, /*#__PURE__*/React.createElement("tspan", {
    x: "67.898",
    y: "100.484"
  }, "Alto:", alto)), /*#__PURE__*/React.createElement("text", {
    x: "67.898",
    y: "106.081",
    strokeWidth: "0.076",
    style: {
      lineHeight: "1.25"
    }
  }, /*#__PURE__*/React.createElement("tspan", {
    x: "67.898",
    y: "106.081"
  }, "Sup.:", fraccion))))));
} //====================== Ventana de manejo de nuevo detalle=======================


class DetallePedido extends React.Component {
  constructor(props) {
    super(props);

    _defineProperty(this, "ESTADO_BUSQUEDA", "BUSQUEDA");

    _defineProperty(this, "ESTADO_ADD_DETALLE", 'ADD-DETALLE');

    _defineProperty(this, "ESTADO_EDIT_DETALLE", 'EDIT-DETALLE');

    _defineProperty(this, "txtbusqHandler", even => {
      if (even && even.target.value.length > 0) {
        let value = even.target.value;
        let newlista = [];
        newlista = this.state.productos.filter(prto => prto.nombre.toUpperCase().indexOf(value.toUpperCase()) != -1);
        this.setState({
          lista: newlista,
          paneles: {
            busqueda: true,
            categorias: false
          }
        });
      } else {
        this.setState({
          lista: this.state.productos,
          paneles: {
            busqueda: true,
            categorias: true
          }
        });
      }
    });

    _defineProperty(this, "selectProductHandler", idProducto => {
      //alert('se eligio del producto id '+ idProducto)
      let prto = this.state.productos.filter(function (pto) {
        return pto.id === idProducto;
      });

      if (prto.length > 0) {
        prto = prto[0];
      } else {
        prto = null;
      }

      this.setState({
        estado: this.ESTADO_ADD_DETALLE,
        productoSelect: prto
      }); // ocultar los botones de aceptar y cancelar

      document.querySelector(".modal-footer").style = "display:none";
    });

    _defineProperty(this, "selectDetalleEdit", itemDetalle => {});

    _defineProperty(this, "selectCategHandler", idCateg => {
      if (idCateg.length > 0) {
        let newlista = [];
        newlista = this.state.productos.filter(prto => prto.categoria.toUpperCase() === idCateg.toUpperCase());
        this.setState({
          lista: newlista,
          paneles: {
            busqueda: false,
            categorias: true
          }
        });
      } else {
        this.setState({
          lista: this.state.productos,
          paneles: {
            busqueda: true,
            categorias: true
          }
        });
      }
    });

    _defineProperty(this, "obtenerCategorias", productos => {
      let categs = productos.map(function (c) {
        return c.categoria;
      });
      return categs.filter(function (value, index, self) {
        return self.indexOf(value) === index;
      });
    });

    _defineProperty(this, "setEstado", est => {
      let clte = clienteSel[0];
      this.setState({
        estado: est,
        clienteSel: clte
      });
    });

    _defineProperty(this, "setDetalle", newDetalle => {
      let prto = this.state.productoSelect;

      if (prto != null) {
        if (newDetalle != null) {
          detalles.push(newDetalle); //---funciones externas reemplasar

          listarDetalle();
          dibujarDetallesPedido();
          calcularMostrarTotalPedido();
        }

        this.setEstado(this.ESTADO_BUSQUEDA);
        this.setState({
          detalles: detalles
        });
        this.txtbusqHandler(); //_setDetalles(detalles) // conectamos la funcion del componente listar
      }
    });

    _defineProperty(this, "onSelectDetalle", detalle => {
      let detalleSel = new Detalle(detalle.id, detalle.cantidad, null, detalle.monto, detalle.estado, detalle.ancho, detalle.alto, detalle.detalle);
      this.setState({
        detalleSelect: detalleSel,
        estado: this.ESTADO_EDIT_DETALLE
      });
    });

    this.state = {
      productos: [],
      lista: [],
      estado: this.ESTADO_BUSQUEDA,
      //BUSQUEDA | ADD-DETALLE
      idApp: idApp,
      paneles: {
        busqueda: true,
        categorias: true
      },
      categCodigo: '',
      productoSelect: null,
      detelleSelect: null,
      clienteSel: this.props.cliente,
      cantidad: 0,
      detalles: detalles
    };
  }

  componentWillMount() {
    new Server().consulta('index.php?r=productos%2Flista-ajax-all&idApp=' + this.state.idApp, {
      '_csrf': yii.getCsrfToken()
    }, rst => {
      if (rst) {
        let categorias = this.obtenerCategorias(rst.data);
        this.setState({
          productos: rst.data,
          lista: rst.data,
          categorias: categorias
        });
      }
    });
  }

  componentDidMount() {
    _setEstado = this.setEstado; // referenciamos una funcion de react con una externa

    _onSelectDetalle = this.onSelectDetalle;
  }
  /**Control del evento del cuadro de texto */


  render() {
    // verificamos si hay cliente-------------
    if (document.querySelector("#pedido-contacto_id").value == '') {
      document.querySelector("#ModalPedidosLabel").innerHTML = 'No hay cliente';
      return /*#__PURE__*/React.createElement("h1", null, "Por favor seleccione un cliente");
    }

    if (this.state.estado === this.ESTADO_BUSQUEDA) {
      document.querySelector("#ModalPedidosLabel").innerHTML = 'Selector de Producto';
      document.querySelector(".modal-footer").style = "display:block";
      let panBusqueda = /*#__PURE__*/React.createElement(InputBuscar, {
        keyUpHandler: this.txtbusqHandler,
        onClickCancel: this.setDetalle
      });
      let panCatego = /*#__PURE__*/React.createElement(ListarCategorias, {
        categorias: this.state.categorias,
        selectHandler: this.selectCategHandler
      });
      return /*#__PURE__*/React.createElement("div", {
        className: "row marcoItems"
      }, /*#__PURE__*/React.createElement("div", {
        className: "col-12"
      }, this.state.paneles.busqueda ? panBusqueda : /*#__PURE__*/React.createElement("span", null), this.state.paneles.categorias ? panCatego : /*#__PURE__*/React.createElement("span", null), /*#__PURE__*/React.createElement(ListarProductos, {
        productos: this.state.lista,
        selectHandler: this.selectProductHandler
      })));
    }

    if (this.state.estado === this.ESTADO_ADD_DETALLE) {
      document.querySelector("#ModalPedidosLabel").innerHTML = 'Nuevo detalle';
      return /*#__PURE__*/React.createElement(DetalleProducto, {
        detalle: new Detalle(0, 0, this.state.productoSelect, 0),
        producto: this.state.productoSelect,
        cliente: this.state.clienteSel,
        detalleHandler: this.setDetalle
      });
    }

    if (this.state.estado === this.ESTADO_EDIT_DETALLE) {
      document.querySelector("#ModalPedidosLabel").innerHTML = 'Modificar detalle';
      return /*#__PURE__*/React.createElement(DetalleProducto, {
        detalle: this.state.detalleSelect,
        producto: this.state.productoSelect,
        cliente: this.state.clienteSel,
        detalleHandler: this.setDetalle
      });
    }
  }

} //----------------------------- Controla el detalle de----------------

/**
 * Encargado de cargar las compras del cliente
 *  según la unidad se debe adaptar a la carga
 * 
 */


class DetalleProducto extends React.Component {
  constructor(props) {
    super(props);

    _defineProperty(this, "setCantidad", cantidad => {
      if (cantidad != null) {
        let detalle = this.state.detalle;
        detalle.setCantidad(cantidad);
        this.setState({
          cantidad: detalle.cantidad,
          monto: detalle.monto,
          detalle: detalle
        });
      }
    });

    _defineProperty(this, "setfraccion", fraccion => {
      if (fraccion != null) {
        let detalle = this.state.detalle;
        if (this.state.precioDif) detalle.precioDif = parseFloat(this.state.precioDif.precio);
        detalle.alto = fraccion.alto ? fraccion.alto : 1;
        detalle.ancho = fraccion.ancho ? fraccion.ancho : 1;
        detalle.detalle = fraccion.comentario ? fraccion.comentario : '';
        detalle.setCantidad(fraccion.cantidad);
        this.setState({
          cantidad: detalle.cantidad,
          monto: detalle.monto,
          detalle: detalle
        });
      }
    });

    _defineProperty(this, "botAceptarHandler", () => {
      /* let newDetalle={
           id:0,
           productos_id:this.props.producto.id,
           producto:this.props.producto.nombre,
           cantidad:this.state.cantidad,
           ancho:1,
           alto:1,
           inst:0,
           detalle:'',
           monto:this.state.monto,
           estado:"ACTIVO"
       }*/
      //Entregamos el detalle nuevo
      this.props.detalleHandler(this.state.detalle.toJson()); //newDetalle)
    });

    _defineProperty(this, "botCancelarHandler", () => {
      this.props.detalleHandler(null);
    });

    _defineProperty(this, "panelXUnidades", () => {
      return /*#__PURE__*/React.createElement("div", {
        className: "col-md-12"
      }, /*#__PURE__*/React.createElement(TableroUnidad, {
        setfraccion: this.setfraccion
      }));
    });

    _defineProperty(this, "panelXM2", () => {
      return /*#__PURE__*/React.createElement("div", {
        className: "col-md-12"
      }, /*#__PURE__*/React.createElement(TableroFraccion, {
        setfraccion: this.setfraccion
      }));
    });

    this.state = {
      cantidad: 0,
      monto: 0,
      detalle: props.detalle,
      precioDif: null
    };
  }

  componentDidMount() {
    // Pedir Datos del producto Relacionado al cliente

    /**
     * Este metodo pide al servidor los datos del producto que relacionan al cliente
     * devuelve {precioDif}
     */
    let pto = this.props.producto;
    Producto.getInfoCliente(idApp, pto.id, this.props.cliente.id, rta => {
      if (rta) {
        this.setState({
          precioDif: rta.precioDif
        }); // Obtenemos un objeto o null
      }
    });
  }

  componentWillMount() {}

  render() {
    /*
     según la unidad el tablero debe cambiar
    */
    let panel = this.panelXUnidades;

    if (this.props.producto.unidad === Producto.UNIDAD_PRECIO_M2) {
      panel = this.panelXM2;
    }

    return /*#__PURE__*/React.createElement("div", {
      className: "row"
    }, /*#__PURE__*/React.createElement("div", {
      className: "col-md-12"
    }, /*#__PURE__*/React.createElement(PanelProducto, {
      precioDif: this.state.precioDif,
      producto: this.props.producto
    }), /*#__PURE__*/React.createElement("hr", {
      style: {
        margin: '5px 2px',
        borderColor: '#052b45'
      }
    })), /*#__PURE__*/React.createElement("div", {
      className: "col-md-12"
    }, /*#__PURE__*/React.createElement("h3", null, "Monto $", this.state.detalle.monto)), /*#__PURE__*/React.createElement("hr", {
      style: {
        margin: '5px 2px',
        borderColor: '#052b45'
      }
    }), panel(), /*#__PURE__*/React.createElement("div", {
      className: "col-xs-6"
    }, /*#__PURE__*/React.createElement("button", {
      onClick: this.botCancelarHandler,
      className: "btn btn-danger",
      style: {
        width: '100%',
        margin: '5px',
        height: '50px'
      }
    }, "Cancelar")), /*#__PURE__*/React.createElement("div", {
      className: "col-xs-6"
    }, /*#__PURE__*/React.createElement("button", {
      onClick: this.botAceptarHandler,
      className: "btn btn-success",
      style: {
        width: '100%',
        margin: '5px',
        height: '50px'
      }
    }, "Aceptar")));
  }

}

class TableroFraccion extends React.Component {
  constructor(props) {
    super(props);

    _defineProperty(this, "setDetalle", dt => {
      this.props.setfraccion(dt);
    });

    _defineProperty(this, "onchangeHandler", e => {
      let txt = e.target.value;
      let cant = txt.split(' ')[0];
      let txtFrac = txt.split(' ')[1];
      let txtComent = txt.split(' ')[2];
      let ancho = 1;
      let alto = 1;
      let fraccion = 1;
      let etapa = 0;
      let comentario = '';

      if (cant.length > 0 && !isNaN(cant)) {
        console.log(cant);
        cant = parseFloat(cant);
        etapa = 1;
      } else {
        cant = 0;
      }

      if (txtFrac && txtFrac.length > 0) {
        let tAncho = txtFrac.split(/[x,X,*]/g)[0];
        let tAlto = txtFrac.split(/[x,X,*]/g)[1];

        if (tAncho && tAncho.length > 0 && !isNaN(tAncho)) {
          ancho = parseFloat(tAncho);
          etapa = 2;
        } else {
          ancho = 1;
        }

        if (tAlto && tAlto.length > 0 && !isNaN(tAlto)) {
          alto = parseFloat(tAlto);
          etapa = 3;
        } else {
          alto = 1;
        }
      }

      if (txtComent && txtComent.length > 0) {
        comentario = txt.substr(txt.indexOf(' ', 3), txt.length);
        etapa = 4;
      }

      fraccion = alto * ancho;
      this.setState({
        cantidad: cant,
        ancho: ancho,
        alto: alto,
        fraccion: fraccion,
        etapa: etapa
      });
      this.setDetalle({
        cantidad: cant,
        ancho: ancho,
        alto: alto,
        fraccion: fraccion,
        comentario: comentario
      });
    });

    this.state = {
      cantidad: 0,
      alto: 1,
      ancho: 1,
      fraccion: 0,
      etapa: 0
    };
  }

  render() {
    let lblHelp = "Escriba la cantidad";

    if (this.state.etapa == 1) {
      lblHelp = "Haga un espacio para escribir  el ancho";
    }

    if (this.state.etapa == 2) {
      lblHelp = "Escriba el ancho por el alto separado por la letra 'X' (ej: '1.3x2.3')";
    }

    if (this.state.etapa == 3) {
      lblHelp = "Haga un espacio y  escribir un comentario para su detalle";
    }

    return /*#__PURE__*/React.createElement("div", null, PanelFraccion(this.state.cantidad, this.state.ancho.toFixed(2), this.state.alto.toFixed(2), this.state.fraccion.toFixed(2) + 'm2'), /*#__PURE__*/React.createElement("label", {
      className: "col-12"
    }, lblHelp, /*#__PURE__*/React.createElement("input", {
      className: "col-12 form-control",
      type: "text",
      onKeyUp: this.onchangeHandler
    })));
  }

}

class TableroUnidad extends React.Component {
  constructor(props) {
    super(props);

    _defineProperty(this, "setDetalle", dt => {
      this.props.setfraccion(dt);
    });

    _defineProperty(this, "onchangeHandler", e => {
      let txt = e.target.value;
      txt = txt.replace(/[X,x]/g, '*');
      let cant = txt.split(' ')[0];
      let cajas = 0;
      let pallet = 1;
      let txtComent = txt.split(' ')[1];
      let etapa = 0;
      let comentario = '';

      if (cant.length > 0) {
        console.log(cant);

        try {
          cant = parseFloat(eval(cant));
        } catch (e) {
          if (e instanceof SyntaxError) {
            console.log(e.message);
            cant = 0;
          } else {
            throw e;
          }
        }

        etapa = 1;
      } else {
        cant = 0;
      }

      if (txtComent && txtComent.length > 0) {
        comentario = txt.substr(txt.indexOf(' ', 1), txt.length);
        etapa = 2;
      }

      this.setState({
        cantidad: cant,
        etapa: etapa
      });
      this.setDetalle({
        cantidad: cant,
        comentario: comentario
      });
    });

    this.state = {
      cantidad: 0,
      etapa: 0
    };
  }

  render() {
    let lblHelp = "Escriba la cantidad";

    if (this.state.etapa == 1) {
      lblHelp = "Puede escribir una expresión usando '+' para sumar y '*' o 'X' para multiplicar, luego separado por un espacio el comentarios";
    }

    if (this.state.etapa == 2) {
      lblHelp = "Haga un espacio y  escribir un comentario para su detalle";
    }

    return /*#__PURE__*/React.createElement("div", null, PanelUnidad(this.state.cantidad, this.state.cantidad), /*#__PURE__*/React.createElement("label", {
      className: "col-12",
      style: {
        fontSize: '1.1em',
        fontWeight: 'lighter'
      }
    }, lblHelp, /*#__PURE__*/React.createElement("input", {
      style: {
        fontSize: '1.6em',
        fontWeight: 'bold'
      },
      className: "col-12 form-control",
      type: "text",
      onKeyUp: this.onchangeHandler
    })));
  }

} //---------------------------


class TableroNumerico extends React.Component {
  constructor(props) {
    super(props);

    _defineProperty(this, "TIPO_NUM_INT", 0);

    _defineProperty(this, "TIPO_NUM_FLOAT", 0);

    _defineProperty(this, "stylDisplay", {
      borderStyle: 'solid',
      padding: '5px',
      margin: '6px',
      borderRadius: '5px',
      background: '#e8e8e8',
      textAlign: 'right'
    });

    _defineProperty(this, "stylDisplayLbl", {
      borderStyle: 'solid',
      borderWidth: '1px',
      borderColor: 'gray',
      padding: '5px',
      margin: '6px',
      borderRadius: '5px',
      background: '#fff',
      textAlign: 'right'
    });

    this.state = {
      tipo: 'NUM-INT',
      botones: ['7', '8', '9', '4', '5', '6', '1', '2', '3', '0'],
      cantidad: 0,
      expresion: '0'
    };
  }

  botClickHandler(boton) {
    if (boton.length > 0) {
      let cantidad = this.state.cantidad;
      let expresion = this.state.expresion;

      switch (boton) {
        case 'del':
          //cantidad=cantidad.substring(0, cantidad.length - 1)
          expresion = expresion.substring(0, expresion.length - 1);
          if (expresion.length <= 0) expresion = '0';
          break;

        case 'delAll':
          //cantidad='0'
          expresion = '0';
          break;

        case 'plus':
          expresion += '+';
          break;

        case 'mult':
          expresion += '*';
          break;

        case '0':
          if (expresion.length <= 0 || isNaN(expresion.substring(expresion.length - 1, expresion.length))) {
            break;
          }

        default:
          //cantidad += boton
          if (expresion === '0') expresion = '';
          expresion += boton;
      }

      let val = cantidad;

      if (expresion.length <= 0) {
        val = 0;
        expresion = '';
      } else {
        try {
          val = parseFloat(eval(expresion));
        } catch (e) {
          if (e instanceof SyntaxError) {
            console.log(e.message);
          } else {
            throw e;
          }
        }
      }

      this.setState({
        cantidad: val,
        expresion: expresion
      });
      this.props.setCantidad(val);
    }
  }

  render() {
    return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
      className: "row",
      style: {
        fontSize: "40px"
      }
    }, /*#__PURE__*/React.createElement("div", {
      className: "col-md-4 col-xs-6"
    }, /*#__PURE__*/React.createElement("h3", {
      style: this.stylDisplayLbl
    }, /*#__PURE__*/React.createElement("span", {
      style: {
        fontSize: '0.5em',
        float: 'left',
        marginTop: '-2px'
      }
    }, "unidades"), this.state.cantidad)), /*#__PURE__*/React.createElement("div", {
      className: "col-md-8 col-xs-6"
    }, /*#__PURE__*/React.createElement("h3", {
      style: this.stylDisplay
    }, this.state.expresion))), /*#__PURE__*/React.createElement("div", {
      className: "row"
    }, this.state.botones.map(b => {
      return /*#__PURE__*/React.createElement("div", {
        key: b,
        className: "col-xs-4"
      }, /*#__PURE__*/React.createElement("button", {
        onClick: e => this.botClickHandler(b, e),
        className: "btn btn-primary",
        style: {
          width: '100%',
          margin: '5px'
        }
      }, b));
    }), /*#__PURE__*/React.createElement("div", {
      key: 'plus',
      className: "col-xs-4"
    }, /*#__PURE__*/React.createElement("button", {
      onClick: e => this.botClickHandler('plus', e),
      className: "btn btn-info",
      style: {
        width: '100%',
        margin: '5px'
      }
    }, /*#__PURE__*/React.createElement("img", {
      src: "assets/icons/plus.svg",
      alt: "<",
      style: {
        width: "2.8em",
        margin: '-5px'
      }
    }))), /*#__PURE__*/React.createElement("div", {
      key: 'mult',
      className: "col-xs-4"
    }, /*#__PURE__*/React.createElement("button", {
      onClick: e => this.botClickHandler('mult', e),
      className: "btn btn-info",
      style: {
        width: '100%',
        margin: '5px'
      }
    }, /*#__PURE__*/React.createElement("img", {
      src: "assets/icons/x.svg",
      alt: "<",
      style: {
        width: "2.8em",
        margin: '-5px'
      }
    }))), /*#__PURE__*/React.createElement("div", {
      key: 'del',
      className: "col-xs-4"
    }, /*#__PURE__*/React.createElement("button", {
      onClick: e => this.botClickHandler('del', e),
      className: "btn btn-success",
      style: {
        width: '100%',
        margin: '5px'
      }
    }, /*#__PURE__*/React.createElement("img", {
      src: "assets/icons/backspace.svg",
      alt: "<",
      style: {
        width: "2.8em",
        margin: '5px'
      }
    }))), /*#__PURE__*/React.createElement("div", {
      key: 'delAll',
      className: "col-xs-4"
    }, /*#__PURE__*/React.createElement("button", {
      onClick: e => this.botClickHandler('delAll', e),
      className: "btn btn-danger",
      style: {
        width: '100%',
        margin: '5px'
      }
    }, /*#__PURE__*/React.createElement("img", {
      src: "assets/icons/trash.svg",
      alt: "<",
      style: {
        width: "2.8em",
        margin: '5px'
      }
    })))));
  }

} //------------------------------------------------------------------------------------------

/**
 * Caja de busqueda
 */


class InputBuscar extends React.Component {
  constructor(...args) {
    super(...args);

    _defineProperty(this, "styleBusca", () => {
      let size = window.innerWidth;

      if (size <= 760) {
        return {
          position: 'fixed',
          width: '95%',
          bottom: '10px',
          zIndex: '100',
          padding: '5px',
          background: 'gray'
        };
      } else {
        return {
          width: '100%'
        };
      }
    });

    _defineProperty(this, "onClickHandler", () => {
      this.props.onClickCancel();
    });
  }

  render() {
    return /*#__PURE__*/React.createElement("div", {
      className: "row ",
      style: this.styleBusca()
    }, /*#__PURE__*/React.createElement("div", {
      className: "col-12"
    }, /*#__PURE__*/React.createElement("label", null, " Buscador:", /*#__PURE__*/React.createElement("input", {
      className: "form-control",
      type: "text",
      onKeyUp: this.props.keyUpHandler,
      placeholder: "Buscar"
    })), " ", /*#__PURE__*/React.createElement("span", {
      "data-dismiss": "modal",
      style: {
        height: '42px',
        marginLeft: '10px'
      }
    }, getIcon('x-circle', '42px', '42px', this.onClickHandler))));
  }

}
/**
* Lista de categorias
*/


class ListarCategorias extends React.Component {
  constructor(...args) {
    super(...args);

    _defineProperty(this, "styleCateg", {
      borderRadius: '10px 10px 2px 2px',
      margin: '4px 2px',
      color: '#052b45',
      background: '  linear-gradient(to bottom, rgba(186,216,242,1) 0%, rgba(119,161,168,1) 100%)'
    });
  }

  render() {
    return /*#__PURE__*/React.createElement("div", {
      className: "row"
    }, /*#__PURE__*/React.createElement("div", {
      className: "col-12"
    }, /*#__PURE__*/React.createElement("span", {
      style: {
        fontSize: '1.5em'
      }
    }, "Categorias"), /*#__PURE__*/React.createElement("hr", {
      style: {
        margin: '5px 2px',
        borderColor: '#052b45'
      }
    }), /*#__PURE__*/React.createElement("div", {
      style: {
        height: '80px',
        overflow: 'auto'
      }
    }, this.props.categorias ? this.props.categorias.map(por => /*#__PURE__*/React.createElement(ListElement, {
      key: por,
      selectHandler: this.props.selectHandler,
      codigo: por,
      nombre: por,
      style: this.styleCateg
    })) : /*#__PURE__*/React.createElement("span", null), /*#__PURE__*/React.createElement(ListElement, {
      key: 0,
      selectHandler: this.props.selectHandler,
      codigo: '',
      nombre: '',
      icono: 'assets/icons/arrow-left-circle.svg'
    }))));
  }

}
/**
* Lista de productos
*/


class ListarProductos extends React.Component {
  render() {
    return /*#__PURE__*/React.createElement("div", {
      className: "row"
    }, /*#__PURE__*/React.createElement("div", {
      className: "col-12"
    }, /*#__PURE__*/React.createElement("h3", null, "Productos"), /*#__PURE__*/React.createElement("div", {
      style: {
        height: '150px',
        overflow: 'auto'
      }
    }, this.props.productos ? this.props.productos.map(por => /*#__PURE__*/React.createElement(ListElement, {
      key: por.id,
      selectHandler: this.props.selectHandler,
      codigo: por.id,
      nombre: por.nombre,
      icono: por.urlIcono ? prompt.urlIcono : 'assets/icons/box.svg'
    })) : /*#__PURE__*/React.createElement("span", null))));
  }

} //=================Panel de presentacion del producto===


class PanelProducto extends React.Component {
  getLabelUnidad(codigo) {
    switch (codigo) {
      case Producto.UNIDAD_PRECIO_UNIDAD:
        return 'Unidad';

      case Producto.UNIDAD_PRECIO_CAJA:
        return 'Caja';

      case Producto.UNIDAD_PRECIO_PALLET:
        return 'Pallet';

      case Producto.UNIDAD_PRECIO_M2:
        return 'm2';

      case Producto.UNIDAD_PRECIO_MLINEAL:
        return 'ml';
    }

    return '-Desconocido-';
  }

  render() {
    let icono = 'assets/icons/box.svg'; //-----------------------------------------------------

    let precio = /*#__PURE__*/React.createElement("div", {
      className: "col-md-6 col-xs-8",
      style: {
        fontSize: '20px',
        height: '24px'
      }
    }, "$", this.props.producto.precio, /*#__PURE__*/React.createElement("span", {
      style: {
        fontSize: '0.7em',
        marginTop: '-2px'
      }
    }, ' x ' + this.getLabelUnidad(this.props.producto.unidad))); //-----------------------------------------------------

    if (this.props.producto && this.props.producto.urlIcono != null) {
      icono = this.props.producto.urlIcono;
    }

    if (this.props.precioDif) {
      precio = /*#__PURE__*/React.createElement("div", {
        className: "col-md-6 col-xs-8",
        style: {
          fontSize: '20px',
          height: '24px'
        },
        title: "El precio diferencial para el cliente se actializo el dia " + this.props.precioDif.fechaAct
      }, "$", /*#__PURE__*/React.createElement("span", {
        style: {
          textDecoration: 'line-through',
          marginRight: '5px',
          fontSize: '0.9em',
          color: 'gray'
        }
      }, this.props.producto.precio), /*#__PURE__*/React.createElement("span", null, /*#__PURE__*/React.createElement("strong", null, "$", this.props.precioDif.precio)), /*#__PURE__*/React.createElement("span", {
        style: {
          fontSize: '0.7em',
          marginTop: '-2px'
        }
      }, ' x ' + this.getLabelUnidad(this.props.producto.unidad)));
    }

    return /*#__PURE__*/React.createElement("div", {
      className: "row"
    }, /*#__PURE__*/React.createElement("div", {
      className: "col-md-2 col-xs-3"
    }, /*#__PURE__*/React.createElement("img", {
      src: icono,
      alt: "",
      style: {
        width: "42px",
        margin: '25px 5px 5px'
      }
    })), /*#__PURE__*/React.createElement("div", {
      className: "col-md-10 col-xs-9",
      style: {
        height: '90px',
        overflow: 'auto'
      }
    }, /*#__PURE__*/React.createElement("h3", {
      style: {
        marginTop: '2px'
      }
    }, this.props.producto.nombre), /*#__PURE__*/React.createElement("p", null, this.props.producto.descripcion)), precio, /*#__PURE__*/React.createElement("div", {
      className: "col-md-6 col-xs-4",
      style: {
        height: '24px'
      }
    }, "Stock:", this.props.producto.stock), /*#__PURE__*/React.createElement("div", {
      className: "col-md-6 col-xs-6",
      style: {
        fontSize: '1.3em',
        height: '24px'
      }
    }, this.props.producto.unxCaja, /*#__PURE__*/React.createElement("span", {
      style: {
        fontSize: '0.6em',
        marginTop: '-2px',
        height: '24px'
      }
    }, "un. x caja")), /*#__PURE__*/React.createElement("div", {
      className: "col-md-6 col-xs-6",
      style: {
        fontSize: '1.3em',
        height: '24px'
      }
    }, this.props.producto.cajaxPallet, /*#__PURE__*/React.createElement("span", {
      style: {
        fontSize: '0.6em',
        marginTop: '-2px'
      }
    }, "caja x pallet")));
  }

}
/** elementos de una lista */


class ListElement extends React.Component {
  constructor(...args) {
    super(...args);

    _defineProperty(this, "styleBot", {
      borderRadius: '10px 2px 10px 2px',
      margin: '4px 2px',
      color: '#052b45',
      background: '  linear-gradient(to bottom, rgba(186,216,242,1) 0%, rgba(232, 239, 241,1) 50%)'
    });

    _defineProperty(this, "onClickHandler", event => {
      //this.props.selectHandler(event.target.id)
      this.props.selectHandler(this.props.codigo);
    });
  }

  render() {
    let icono = null;

    if (this.props.icono != null) {
      icono = /*#__PURE__*/React.createElement("img", {
        src: this.props.icono,
        alt: "",
        style: {
          width: "16px",
          paddingRigth: '5px'
        }
      });
    }

    return /*#__PURE__*/React.createElement("button", {
      id: this.props.codigo,
      style: this.props.style ? this.props.style : this.styleBot,
      className: "btn btn-primary",
      onClick: this.onClickHandler
    }, icono, " ", this.props.nombre);
  }

}

class ListaDetalle extends React.Component {
  constructor(props) {
    super(props);

    _defineProperty(this, "clickEditDetalleHandler", (key, e) => {
      e.preventDefault();

      if (key >= 0) {
        let detalleSelect = detalles[key];

        _onSelectDetalle(detalleSelect);
      }
    });

    _defineProperty(this, "clickDeleteDetalleHandler", (key, e) => {
      e.preventDefault();

      if (key >= 0) {
        alert('click en el detalle ' + key);
      }
    });

    _defineProperty(this, "setDetalles", detalles => {
      if (detalles) {
        this.setState({
          detalles: detalles
        });
      }
    });

    _defineProperty(this, "getHederTabla", detalle => {
      return /*#__PURE__*/React.createElement("table", {
        className: "table"
      }, /*#__PURE__*/React.createElement("thead", null, /*#__PURE__*/React.createElement("tr", {
        style: {
          fontSize: '1.5rem'
        }
      }, /*#__PURE__*/React.createElement("th", {
        scope: "col"
      }, "Cant."), /*#__PURE__*/React.createElement("th", {
        scope: "col"
      }, "Detalle"), /*#__PURE__*/React.createElement("th", {
        scope: "col"
      }, "Monto"), /*#__PURE__*/React.createElement("th", {
        scope: "col"
      }))), /*#__PURE__*/React.createElement("tbody", null, detalle));
    });

    this.state = {
      detalles: detalles
    };
  }

  componentDidMount() {
    _setDetalles = this.setDetalles; // referenciamos una funcion de react con una externa
  } //----------------------


  getRow(dt, key) {
    return /*#__PURE__*/React.createElement("tr", {
      key: key,
      style: {
        fontSize: '1.5rem'
      }
    }, /*#__PURE__*/React.createElement("td", null, dt.cantidad), /*#__PURE__*/React.createElement("td", null, dt.detalle + ' ' + dt.producto), /*#__PURE__*/React.createElement("td", null, "$", dt.monto), /*#__PURE__*/React.createElement("td", null, /*#__PURE__*/React.createElement("a", {
      href: "#",
      "data-toggle": "modal",
      "data-target": "#ModalPedidos"
    }, /*#__PURE__*/React.createElement("img", {
      id: 'item_' + key,
      src: "assets/icons/pencil.svg",
      onClick: e => {
        this.clickEditDetalleHandler(key, e);
      },
      alt: "Edit",
      style: {
        width: '20px',
        marginRight: '15px',
        marginBottom: '10px'
      }
    })), /*#__PURE__*/React.createElement("a", {
      href: "#",
      "data-toggle": "modal",
      "data-target": "#ModalPedidos"
    }, /*#__PURE__*/React.createElement("img", {
      id: 'item_' + key,
      src: "assets/icons/trash.svg",
      alt: "Edit",
      onClick: e => this.clickDeleteDetalleHandler(key, e),
      style: {
        width: '20px',
        marginRight: '15px',
        marginBottom: '10px'
      }
    }))));
  }

  render() {
    let listaDetalles = /*#__PURE__*/React.createElement("h3", null, "sin detalles");
    let detalles = this.state.detalles;

    if (detalles != null) {
      listaDetalles = detalles.map((dt, index) => {
        return this.getRow(dt, index);
      });
      return this.getHederTabla(listaDetalles);
    }

    return listaDetalles;
  }

}

let listaDetalle = /*#__PURE__*/React.createElement(ListaDetalle, null); //ReactDOM.render(listaDetalle,document.getElementById('detallesPedido1') );
//ClienteSel es una variable gloval que será reemplazada por  App.cliente donde App es el objeto que abasteserá  la app

const detallePedido = /*#__PURE__*/React.createElement(DetallePedido, {
  cliente: clienteSel
});
ReactDOM.render(detallePedido, document.getElementById('idModalPedido'));

function PanelUnidad(total = 1, unidad = 1, cajas = 0, pallet = 0) {
  return /*#__PURE__*/React.createElement("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    width: "100%",
    height: "128.53",
    viewBox: "0 0 120.02 34.008"
  }, /*#__PURE__*/React.createElement("g", {
    transform: "translate(-64.568 -78.246)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "116.09",
    height: "29.901",
    x: "-182.5",
    y: "-110.13",
    fill: "#b7c4c8",
    ry: "4.009",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "119.72",
    height: "33.703",
    x: "64.721",
    y: "78.399",
    fill: "none",
    stroke: "#000",
    strokeLinecap: "round",
    strokeWidth: "0.305",
    ry: "3.401"
  }), /*#__PURE__*/React.createElement("g", {
    fontFamily: "sans-serif"
  }, /*#__PURE__*/React.createElement("text", {
    x: "69.701",
    y: "88.405",
    strokeWidth: "0.142",
    fontSize: "5.661",
    style: {
      lineHeight: "1.25"
    }
  }, /*#__PURE__*/React.createElement("tspan", {
    x: "69.701",
    y: "88.405"
  }, "Cantidad Total")), /*#__PURE__*/React.createElement("text", {
    x: "113.678",
    y: "89.192",
    strokeWidth: "0.179",
    fontSize: "7.895",
    style: {
      lineHeight: "1.25"
    }
  }, /*#__PURE__*/React.createElement("tspan", {
    x: "113.678",
    y: "89.192",
    fontWeight: "bold"
  }, total)), /*#__PURE__*/React.createElement("g", {
    strokeWidth: "0.104",
    fontSize: "3.881"
  }, /*#__PURE__*/React.createElement("text", {
    x: "70.398",
    y: "106.445",
    style: {
      lineHeight: "1.25"
    }
  }, /*#__PURE__*/React.createElement("tspan", {
    x: "70.398",
    y: "106.445"
  }, "Unidades: ", unidad)), /*#__PURE__*/React.createElement("text", {
    x: "114.333",
    y: "106.445",
    style: {
      lineHeight: "1.25"
    }
  }, /*#__PURE__*/React.createElement("tspan", {
    x: "114.333",
    y: "106.445"
  }, "Cajas: ", cajas)), /*#__PURE__*/React.createElement("text", {
    x: "150.579",
    y: "106.445",
    style: {
      lineHeight: "1.25"
    }
  }, /*#__PURE__*/React.createElement("tspan", {
    x: "150.579",
    y: "106.445"
  }, "Pallet: ", pallet)))), /*#__PURE__*/React.createElement("g", {
    fill: "gray",
    stroke: "#1a1a1a",
    strokeLinecap: "round",
    strokeWidth: "0.184"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "1.8",
    height: "5.894",
    x: "78.359",
    y: "94.91",
    ry: "0.721"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "1.8",
    height: "5.894",
    x: "81.122",
    y: "94.91",
    ry: "0.721"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "1.8",
    height: "5.894",
    x: "83.884",
    y: "94.91",
    ry: "0.721"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "1.8",
    height: "5.894",
    x: "86.647",
    y: "94.91",
    ry: "0.721"
  })), /*#__PURE__*/React.createElement("g", {
    stroke: "#000",
    strokeLinecap: "round",
    transform: "translate(82.204 81.122) scale(.33666)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    stroke: "#000",
    strokeLinecap: "round",
    transform: "translate(87.212 80.886) scale(.33666)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    stroke: "#000",
    strokeLinecap: "round",
    transform: "translate(84.802 76.634) scale(.33666)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    stroke: "#000",
    strokeLinecap: "round"
  }, /*#__PURE__*/React.createElement("g", {
    transform: "translate(-74.67 -52.518) scale(1.4893) translate(139.24 93.253) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-74.67 -52.518) scale(1.4893) translate(141.01 93.253) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-74.67 -52.518) scale(1.4893) translate(142.85 93.253) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-74.67 -52.518) scale(1.4893) translate(139.24 91.523) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-74.67 -52.518) scale(1.4893) translate(141.01 91.523) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-74.67 -52.518) scale(1.4893) translate(142.85 91.523) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-74.67 -52.518) scale(1.4893) translate(139.24 89.827) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-74.67 -52.518) scale(1.4893) translate(141.01 89.827) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-74.67 -52.518) scale(1.4893) translate(142.85 89.827) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("g", {
    transform: "translate(-75.752 -51.274) scale(1.4893) translate(139.24 93.253) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-75.752 -51.274) scale(1.4893) translate(141.01 93.253) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-75.752 -51.274) scale(1.4893) translate(142.85 93.253) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-75.752 -51.274) scale(1.4893) translate(139.24 91.523) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-75.752 -51.274) scale(1.4893) translate(141.01 91.523) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-75.752 -51.274) scale(1.4893) translate(142.85 91.523) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-75.752 -51.274) scale(1.4893) translate(139.24 89.827) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-75.752 -51.274) scale(1.4893) translate(141.01 89.827) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  })), /*#__PURE__*/React.createElement("g", {
    transform: "translate(-75.752 -51.274) scale(1.4893) translate(142.85 89.827) scale(.14916)"
  }, /*#__PURE__*/React.createElement("rect", {
    width: "10.999",
    height: "11.08",
    x: "-123.36",
    y: "-63.078",
    fill: "#d3bc5f",
    strokeWidth: "0.161",
    ry: "0",
    transform: "scale(-1)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.092",
    height: "10.926",
    x: "-192.7",
    y: "-201.21",
    fill: "#a80",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.6661 .74586 0 -1 0 0)"
  }), /*#__PURE__*/React.createElement("rect", {
    width: "7.093",
    height: "10.921",
    x: "62.69",
    y: "159.26",
    fill: "#fff6d5",
    strokeWidth: "0.129",
    ry: "0",
    transform: "matrix(-.67142 .74107 1 0 0 0)"
  }))))));
}