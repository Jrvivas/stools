/**
 * Objeto para el maneja de caja a travez de movimientos 
 */
class Caja{
	constructor(fecha,idResponsable,monto){
		this.fechaInicio=fecha?fecha:new Date();;
		this.idResponsable=idResponsable;
		this.montoInicial=monto;
		this.monto=monto;
		this.movimientos=[];
		this.fechaAct=null;
		
	}
	
	/**
	*Agregamos una entrada
	*/
	entrada(movimiento){
		if(movimiento && movimiento.monto>0){
			let nMonto=movimiento.monto;
			this.monto+=nMonto;
			this.movimientos.push(movimiento)
			this.fechaAct=movimiento.fecha;
		}
		
	}
	
	/**
	*Agregamos una salida
	*/
	salida(movimiento){
		if(movimiento && movimiento.monto>0){
			let nMonto=movimiento.monto;
			this.monto-=nMonto;
			this.movimientos.push(movimiento)
			this.fechaAct=movimiento.fecha;
		}
	}
}

class Movimiento{
	constructor(fecha,monto,detalle,categoria,adjunto){
		this.fecha=fecha?fecha:new Date();
		this.monto=Math.abs(monto);
		this.detalle=detalle;
		this.categoria=categoria;
		this.adjunto=adjunto;
	}
}