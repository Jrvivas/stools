function days_between(date1, date2) {

    // The number of milliseconds in one day
    var ONE_DAY = 1000 * 60 * 60 * 24;

    // Convert both dates to milliseconds
    var date1_ms = date1.getTime();
    var date2_ms = date2.getTime();

    // Calculate the difference in milliseconds
    var difference_ms = Math.abs(date1_ms - date2_ms);

    // Convert back to days and return
    return Math.round(difference_ms/ONE_DAY);

}


function getFechaDMA(date){
    let dt=date
    if(!date instanceof Date){
        if(date instanceof string){
            dt=new Date(date)
        }
    }
    year  = dt.getFullYear();
    month = (dt.getMonth() + 1).toString().padStart(2, "0");
    day   = dt.getDate().toString().padStart(2, "0");

    return (day+'/'+month+'/'+year)
}


function isNumber(n) 
{
   return  Number(n*1)=== n*1;
}


    //--------------------------------Controles-------------------------------
    function continer(body){
        return'<div class="row" style="font-size:1.5em; background-color:rgba(255,255,255,0.5); border-style:solid; border-width:1px; border-radius:5px; border-color:var(--primary); padding:10px; margin:5px">'+body+'</div>';
    }

    function input(nombre,label,valor,col){
        if(!valor)valor='';
        return '<div class="col-md-'+col+'"> '+
               ' <div class="form-group field-'+nombre+' required">'+
               ' <label id="label-'+nombre+'" class="control-label" for="'+nombre+'">'+label+'</label>'+
               ' <input type="text" id="'+nombre+'" class="form-control" name="Pedido[nombre]"  aria-required="true" value="'+valor+'" >'+
               ' <div class="help-block"></div>'+
               ' </div>            </div>'
    }
    function selectSINO(nombre,label,valor){
        return'<div class="col-md-3"> <label class="control-label" id="label-'+nombre+'" for="'+nombre+'">'+label+'</label>'+
                '<select id="'+nombre+'" class="form-control" name="'+nombre+'" aria-invalid="false" value="'+valor+'">'+
                '<option value="0">No</option>'+
                '<option value="1">Si</option>'+
                '</select></div>';
    }

    function tabla(){
        return' <table class="table">'+
              '  <thead>'+
              '     <tr style="font-size: 1.5rem;">'+
              '     <th scope="col">Cant.</th>'+
              '     <th scope="col">Detalle</th>'+
              '     <th scope="col">Monto</th>'+
              '     <th scope="col"></th>'+
              '     </tr>'+
              ' </thead>'+
              ' <tbody>'+
              '     <tr>'+
              '     <th scope="row">-</th>'+
              '     <td>-</td>'+
              '     <td>-</td>'+
              '     <td>-</td>'+
              '     </tr>'+
              '  </tbody>'+
              ' </table>';  
    }

    /**
     * Obtienes el tamaño de la pantalla
     */
    function getSizes(){
        let width = window.innerWidth;
        let height = window.innerHeight - 200;
        return {width, height};
        }

    /**
     * Clase que maneja mensajes
     */    
    class Msg{

        static error(ambito,mensaje){
            console.log('ERROR: '+ambito+'('+mensaje+')');
        }
    }    
    //------------------------------------------------------------------------