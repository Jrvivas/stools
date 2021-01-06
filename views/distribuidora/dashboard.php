<?php

use yii\web\View;



//$this->registerJsFile(Yii::getAlias('@web').'/js/html2canvas.min.js',['position'=>View::POS_END] ,null);
$this->registerJsFile('https://www.gstatic.com/charts/loader.js',['position'=>View::POS_END] ,null);
//$this->registerCssFile('https://bootswatch.com/4/yeti/bootstrap.min.css');

$script=<<<JS
       var idApp='$idApp'; var temp=0; 
       var _columns=[]
       var _datos=[]
       var _titulo=''


     function dibujarGraficas(){  
        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart','table']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);
        
        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {
        
                /*
                columns=[{tipo:'string',label:'topping'},{..}]
                data=[[data-col1,data-col2,..,data-coln],[]]
                */
               let values=[];
                // Create the data table.
               var data = new google.visualization.DataTable();
               for(col of _columns){
                    data.addColumn(col.tipo, col.label);
               }
               for(dt of _datos){
                   if(dt.monto*1>0){
                      values.push([dt.nombre,dt.monto*1]) 
                   }
                    
               }
            
                data.addRows(values)
                
                // Set chart options
                var options = {'title':_titulo,
                                'width':'95%',
                                'height':300};

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                chart.draw(data, options);
                
                
                var table = new google.visualization.Table(document.getElementById('table_div'));
                table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
                
                
        }
      }


        //  obtener los datos del reporte
        function getReporte(codigo,...parameters){
            let query='';
            var f=new Date();
            var ano = f.getFullYear();
            var mes = f.getMonth()+1;
            var mesSel=mes+'-'+ano

            let valSel=document.querySelector("#select-meses").value
            if (valSel){
                mesSel=valSel;
            }
            switch(codigo){
                case 'VENTA-MES':
                    document.querySelector("#select-meses").style.display = 'none';
                    _titulo='Ventas del Mes (10 primeros)'
                    query=`
                    
                       SELECT pt.nombre, sum(dp.monto) as 'monto' 
                        FROM detallePedido as dp LEFT JOIN pedido as p 
                        ON p.id=dp.pedido_id AND p.app_idApp= dp.app_idApp 
                        LEFT JOIN  productos as pt 
                        ON dp.productos_id=pt.id AND pt.app_idApp= dp.app_idApp 
                        WHERE p.app_idApp='$idApp' AND p.estado='ENTREGADO' AND (month(p.fechaFin)=month(Now()) AND year(p.fechaFin)=year(p.fechaFin)) GROUP by pt.id
                        ORDER BY monto DESC LIMIT 10
                        `
                       _columns=[{tipo:'string',label:'Producto'},{tipo:'number',label:'Montos($)'}]
                    break;
                case 'VENTAXMES':
                    document.querySelector("#select-meses").style.display = 'inline';
                    _titulo='Ventas Por Mes (10 primeros)'
                    
                    
                    if(parameters.length>0){
                        mesSel=parameters[0];
                    }
                     query=`
                        SELECT pt.nombre, sum(dp.monto) as 'monto'
                        FROM detallePedido as dp LEFT JOIN pedido as p 
                        ON p.id=dp.pedido_id AND p.app_idApp= dp.app_idApp 
                        LEFT JOIN  productos as pt 
                        ON dp.productos_id=pt.id AND pt.app_idApp= dp.app_idApp 
                        WHERE p.app_idApp='$idApp' AND p.estado='ENTREGADO' AND (concat(month(p.fechaFin),'-',year(p.fechaFin))='`+mesSel+`') GROUP by pt.id
                        ORDER BY monto DESC LIMIT 10
                        `
                       _columns=[{tipo:'string',label:'Producto'},{tipo:'number',label:'Montos($)'}]
                    break;
                case 'GANANCIAXMES':
                    document.querySelector("#select-meses").style.display = 'inline';
                    _titulo='Ventas Por Mes'
                    
                    
                    if(parameters.length>0){
                        mesSel=parameters[0];
                    }
                     query=`
                        SELECT pt.nombre, (sum(dp.monto) - sum(dp.cantidad*pt.costo)) as monto  
                        FROM detallePedido as dp LEFT JOIN pedido as p 
                        ON p.id=dp.pedido_id AND p.app_idApp= dp.app_idApp 
                        LEFT JOIN  productos as pt 
                        ON dp.productos_id=pt.id AND pt.app_idApp= dp.app_idApp 
                        WHERE p.app_idApp='$idApp' AND p.estado='ENTREGADO' AND (concat(month(p.fechaFin),'-',year(p.fechaFin))='`+mesSel+`') GROUP by pt.id
                        
                        `
                       _columns=[{tipo:'string',label:'Producto'},{tipo:'number',label:'Montos($)'}]
                    break;   


                default:
                    break
             }
             _datos=[];

             let data=btoa(query);
              _columns=[{tipo:'string',label:'Producto'},{tipo:'number',label:'cantidad'}]
                webGet('index.php?r=grafica/report-ajax&id='+idApp+'&data='+data).then((result)=>{
                    console.log(result)
                    result=JSON.parse(result)
                    _datos=result.data;
                    dibujarGraficas()

                 });
           }

    


        function getMeses(){
            let query=`SELECT month(fechaFin) AS 'mes', year(fechaFin) AS 'ano' FROM pedido WHERE (app_idApp='$idApp') AND (estado='ENTREGADO') GROUP BY concat(month(fechaFin), year(fechaFin))ORDER BY 'fechaFin' DESC`;
            let data=btoa(query);
            document.querySelector("#select-meses").innerHTML=" <option value=''>Cargando...</option>";

             webGet('index.php?r=grafica/report-ajax&id='+idApp+'&data='+data).then((result)=>{
                    console.log(result)
                    result=JSON.parse(result)
                    if(result.error===0){
                        let opciones='';
                        for(let d of result.data){
                            if(d.mes && d.ano){
                                opciones+=" <option value='"+d.mes+'-'+d.ano+"'>"+d.mes+'-'+d.ano+"</option>"
                            }
                            
                        }

                        document.querySelector("#select-meses").innerHTML=opciones;
                        
                    }else{
                        alert("Error: "+result.mensaje)
                    }
                    
                 });
        }

   document.querySelector('#select-report').onchange=(event)=>{
            let cod=event.target.options[event.target.selectedIndex].value
            getReporte(cod)
        };
    document.querySelector('#select-meses').onchange=(event)=>{
       
        getReporte(document.querySelector('#select-report').value)
    };

    getMeses();
    getReporte('VENTA-MES');
        
 


JS;

$this->registerJs($script, View::POS_END, 'my-options'); 

//$navBar=['nombre'=>'Grafica Sigma','urlHome'=>Yii::$app->urlManager->createUrl(['grafica/index','id'=>$idApp]),'urlIcon'=>'','links'=>[['label'=>'Pedidos','url'=>\Yii::$app->urlManager->createUrl(['/grafica/pedidos','id'=>$idApp]) ]]];

//echo $this->render('../controls/_navbarApp',['navbar'=>$navBar]);
?>

 <!--Div that will hold the pie chart-->
 <div class="row bg-primary " style=' padding: 5px 2px;'>
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
         <select id="select-report" name="select-report"  style="color: black;font-size: 2.0rem;border-radius: 10px;height: 40px;">
            
            <option value='VENTA-MES'>Ventas Mensual</option>
            <option value='VENTAXMES'>Ventas por Mes</option>
            <option value='GANANCIAXMES'>Productividad por Mes</option>
        </select>

        <select id="select-meses" name="select-meses" style="color: black;font-size: 2.0rem;border-radius: 10px;height: 40px;">
          
        </select>
    </div>
    <div class="col-sm-2"></div>
 </div>
 <div id="chart_div"></div>
 <div id="table_div"></div>
 