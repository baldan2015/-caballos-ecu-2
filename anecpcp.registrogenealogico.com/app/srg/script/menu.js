/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
    
    cantidadAllNovedades();
    cantidadAllInscripciones();
    cantidadAllNacimientos();
    $('[data-toggle="tooltip"]').tooltip();
});

function cantidadAllNovedades(){
  
  $.ajax({
     data: {opc: "allNov"},
     url: 'ajax/ajaxNovedad.php',
     type: 'post',
     beforeSend: function(){},
     success: function(response){
        //console.log(response);
        var data = JSON.parse(response);
        //console.log(data.result);
        $("#cantNovedades").text(data.result);
     }
  });
  
  
};


function cantidadAllInscripciones(){
  
  $.ajax({
     data: {opc: "allIns"},
     url: 'ajax/ajaxInscripcion.php',
     type: 'post',
     beforeSend: function(){},
     success: function(response){
        //console.log(response);
        var data = JSON.parse(response);
        //console.log(data.result);
        $("#cantInscripciones").text(data.result);
     }
  });
};


function cantidadAllNacimientos(){
  
  $.ajax({
     data: {opc: "allNac"},
     url: 'ajax/ajaxNacimiento.php',
     type: 'post',
     beforeSend: function(){},
     success: function(response){
        //console.log(response);
        var data = JSON.parse(response);
        //console.log(data.result);
        $("#cantNacimientos").text(data.result);
     }
  });
};