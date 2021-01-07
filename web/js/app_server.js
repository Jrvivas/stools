function Server(){
    /**
     * Funcion que hace una consulta al servidor general ,
     * requiere el nombre de la funcion un objeto de datos (data) 
     * y una funcion de respuesta "done" 'nombFuncion(result)'
     */
     this.consulta=function( url,  data,  done){
            // Bouml preserved body begin 00024502
          
            //cf_app.espera.callDone=false;
            //var data={"id":cf_app.idSesion,"arg":arg};
            var me=this;
            /*
            $.ajax({
                  url: url,
                  type: "POST",
                  data: JSON.stringify(data),                  
                  dataType:'json',
                  contentType: "application/json",
                  traditional: true,
                  beforeSend: function(x) {
                    if (x && x.overrideMimeType) {
                      x.overrideMimeType("application/j-son;charset=UTF-8");
                    }
                  },
                  success: function(result) {
                           
                            if(result){
                                var obj=me.jsonResult(result);
                                console.log(obj);
                                if(done)done(obj);
    
                            }
    
    
                  }
                    });
*/
                    $.ajax({
                      url: url,
                      type: "POST",
                      data: JSON.stringify(data),                  
                      dataType:'json',
                      contentType: "application/json",
                      headers : {
                        'X-CSRF-Token' : _csrf
                    },
                    
                      success: function(result) {
                               
                                if(result){
                                    var obj=me.jsonResult(result);
                                    console.log(obj);
                                    if(done)done(obj);
        
                                }
        
        
                      },
                      fail:function(){
                        alert('Error en el servidor')
                      }
                        });

           
                   /*      fetch(url, {
                                  method: 'POST',
                                 body: JSON.stringify(data), 
                                 headers: {
                                  'Accept': 'application/json',
                                  'Content-Type': 'application/json',
                                  'X-Requested-With': 'XMLHttpRequest'
                                }
                                 })
                         .then(function(result) {
                                  if(result) {  
            
                                    var obj=result;
                                    console.log(obj);
                                    if(done)done(obj);
            
                                  } else {
            
                                      throw "Error en la llamada Ajax";
                                  }
                             
                             })
                           
                        .catch(function(err) {
                                console.log(err);
                             });*/
            
                    };
                  
                
            
    
    
            // Bouml preserved body end 00024502
        
        this.jsonResult=function( txtData){
            // Bouml preserved body begin 00026082
                 if (typeof txtData == "string")
                      txtData = $.parseJSON(txtData);
               return txtData;
            // Bouml preserved body end 00026082
      };
    
    }

    /*
    Ejemplo de uso------------------------
    get('http://fipo.equisd.com/api/products.json').then(function(response) {
      console.log("Success!", response);
      var datadiv = document.getElementById("data");
      datadiv.innerHTML = response;
    }, function(error) {

    });

    get('http://fipo.equisd.com/api/productsx.json').then(function(response) {

    }, function(error) {
      console.error("Failed!", error);
      var errordiv = document.getElementById("error");
      errordiv.innerHTML = error;  
    })
    */

function ServerNew() {
  this.consulta = function (url, data, done) {
    let xhr = new XMLHttpRequest();

    // 2. Configure it: GET-request for the URL /article/.../load
    xhr.open('POST', url);
    xhr.responseType = 'json';
    // 3. Send the request over the network
    xhr.send(JSON.stringify(data));

    // 4. This will be called after the response is received
    xhr.onload = function () {
      if (xhr.status != 200) { // analyze HTTP status of the response
        alert(`Error ${xhr.status}: ${xhr.statusText}`); // e.g. 404: Not Found
      } else { // show the result
        alert(`Done, got ${xhr.response.length} bytes`); // response is the server
        if(done)done(xhr.response)
      }
    };

    xhr.onprogress = function (event) {
      if (event.lengthComputable) {
        alert(`Received ${event.loaded} of ${event.total} bytes`);
      } else {
        alert(`Received ${event.loaded} bytes`); // no Content-Length
      }

    };

    xhr.onerror = function () {
      alert("Request failed");
    };
  }
}