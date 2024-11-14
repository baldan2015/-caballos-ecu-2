var K_ResultadoCboAjax={ exito:1,error:0}

var listarDocumento = function (control, mensaje, valor) {
    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    $("#" + control).append("<option value='0'>" + mensaje + "</option>");
    $.ajax({
        url: 'ajax/ajaxTipoDoc.php',data:{opc:"lstItems"},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response); /*response*/
            var tipoDoc = dato.data;
            if (dato.result == K_ResultadoCboAjax.exito) {
                $.each(tipoDoc, function (index, tp) {
                    var selected = "";
                    if (val == tp.valor) selected = "Selected";
                    $("#" + control).append("<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>");
                });
            } else {
                alertify.error(dato.message);
            }
        }
    });
};

var listarPelaje = function (control, mensaje, valor) {
    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    $("#" + control).append("<option value='0'>" + mensaje + "</option>");   
    $.ajax({
        url: 'ajax/ajaxPelaje.php',data:{opc:"lstItems"},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            var tipoPelaje = dato.data;
            if (dato.result == K_ResultadoCboAjax.exito) {
                $.each(tipoPelaje, function (index, tp) {
                    var selected = "";
                    if (val == tp.valor) selected = "Selected";
                    $("#" + control).append("<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>");
                });
            } else {
                alertify.error(dato.message);
            }
        }
    });
}
 
 var listarResenia = function (control, mensaje, valor) {

    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    //$("#" + control).append("<option value='0'>" + mensaje + "</option>");
    
    $.ajax({
        url: 'ajax/ajaxResena.php',data:{opc:"lstItems",tipo:valor,descripcion:mensaje},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            var resenas = dato.data;
            if (dato.result == K_ResultadoCboAjax.exito) {
                  if(resenas!=null){
                $.each(resenas, function (index, item) {
                    var selected = "";
                    if (val == item.valor) selected = "Selected";
                    $("#" + control).append("<option value='" + item.valor + "' " + selected + "  title='" + item.descripcion + "'>" + item.descripcion + "</option>");
                });
              }
               //  $("#" + control).selectpicker('refresh');
            } else {
                alertify.error(dato.message);
            }
        }
    });
}
var listarReseniaSel = function (control, mensaje,valor) {

    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    //$("#" + control).append("<option value='0'>" + mensaje + "</option>");
    
    $.ajax({
        url: 'ajax/ajaxEjemplar.php',data:{opc:"lstItemsSel",codigo:$("#txtCodigo").val(),arrayResenias:$("#array").val(),tipo:valor},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            var resenas = dato.data;
           // console.log(resenas);
            if (dato.result == K_ResultadoCboAjax.exito) {
                if(resenas!=null){
                        $.each(resenas, function (index, item) {
                            var selected = "";
                            if (val == item.id) selected = "Selected";
                            $("#" + control).append("<option value='" + item.id + "' " + selected + "  title='" + item.descripcion + "'>" + item.descripcion + "</option>");
                        });
                }
               //  $("#" + control).selectpicker('refresh');
            } else {
                alertify.error(dato.message);
            }
        }
    });
}

var listarReseniaSelIns = function (control, mensaje,valor) {

    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    //$("#" + control).append("<option value='0'>" + mensaje + "</option>");
    
    $.ajax({
        url: 'ajax/ajaxInscripcion.php',data:{opc:"lstItemsSel",codigo:$("#txtCodigo").val(),arrayResenias:$("#array").val(),tipo:valor},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            var resenas = dato.data;
           // console.log(resenas);
            if (dato.result == K_ResultadoCboAjax.exito) {
                if(resenas!=null){
                        $.each(resenas, function (index, item) {
                            var selected = "";
                            if (val == item.id) selected = "Selected";
                            $("#" + control).append("<option value='" + item.id + "' " + selected + "  title='" + item.descripcion + "'>" + item.descripcion + "</option>");
                        });
                }
               //  $("#" + control).selectpicker('refresh');
            } else {
                alertify.error(dato.message);
            }
        }
    });
}

var listarReseniaSelInsAll = function (control, mensaje,valor) {

    var val = valor == undefined ? 0 : valor;
    //$("#" + control + " option").remove();
    //$("#" + control).append("<option value='0'>" + mensaje + "</option>");
    $("#ddlReseniaRightCA option").remove();
    $("#ddlReseniaRightAD option").remove();
    $("#ddlReseniaRightAI option").remove();
    $("#ddlReseniaRightPD option").remove();
    $("#ddlReseniaRightPI option").remove();
    $.ajax({
        url: 'ajax/ajaxInscripcion.php',data:{opc:"lstItemsSel",codigo:$("#txtCodigo").val(),arrayResenias:$("#array").val()},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            var resenas = dato.data;
            console.log(resenas);
            if (dato.result == K_ResultadoCboAjax.exito) {
                if(resenas!=null){
                        $.each(resenas, function (index, item) {
                            var selected = "";
                            if(item.tipo == "CA"){
                               // console.log('entro en CA');
                              if (val == item.id) selected = "Selected";
                              $("#ddlReseniaRightCA").append("<option value='" + item.id + "' " + selected + "  title='" + item.descripcion + "'>" + item.descripcion + "</option>");    
                            }else if(item.tipo == "AD"){
                              if (val == item.id) selected = "Selected";
                              $("#ddlReseniaRightAD").append("<option value='" + item.id + "' " + selected + "  title='" + item.descripcion + "'>" + item.descripcion + "</option>");    
                            }else if(item.tipo == "AI"){
                              if (val == item.id) selected = "Selected";
                              $("#ddlReseniaRightAI").append("<option value='" + item.id + "' " + selected + "  title='" + item.descripcion + "'>" + item.descripcion + "</option>");      
                            }else if(item.tipo == "PD"){
                              if (val == item.id) selected = "Selected";
                              $("#ddlReseniaRightPD").append("<option value='" + item.id + "' " + selected + "  title='" + item.descripcion + "'>" + item.descripcion + "</option>");        
                            }else if(item.tipo == "PI"){
                              if (val == item.id) selected = "Selected";
                              $("#ddlReseniaRightPI").append("<option value='" + item.id + "' " + selected + "  title='" + item.descripcion + "'>" + item.descripcion + "</option>");        
                            }
                        });
                }
               //  $("#" + control).selectpicker('refresh');
            } else {
                alertify.error(dato.message);
            }
        }
    });
}
var listarDeparmento = function (control, mensaje, valor) {

    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    $("#" + control).append("<option value='0'>" + mensaje + "</option>");
    
    $.ajax({
        url: 'ajax/ajaxDepartamento.php',data:{opc:"lstItems"},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
           //   console.log(dato);            
            var tipoDepart = dato.data;
            
            if (dato.result == K_ResultadoCboAjax.exito) {
                
                $.each(tipoDepart, function (index, tp) {
                    
                    var selected = "";
                    if (val == tp.valor) selected = "Selected";
                    $("#" + control).append("<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>");
                });
            } else {
                alertify.error(dato.message);
            }
        }
    });
}
var listarPropietario = function (control, mensaje, valor) {

    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    //$("#" + control).append("<option value='0'>" + mensaje + "</option>");
     var items = "<option   value='0'>" + mensaje + "</option>";
    $.ajax({
        url: 'ajax/ajaxEntidad.php',data:{opc:"lstItemsProp"},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            
            var tipoProp = dato.data;
            
            if (dato.result == K_ResultadoCboAjax.exito) {
                
                $.each(tipoProp, function (index, tp) {
                    
                    var selected = "";
                    if (val == tp.valor) selected = "Selected";
                    //$("#" + control).append("<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>");
                    items=items+"<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>";
                });
                 $("#" + control).html(items).selectpicker('refresh');
            } else {
                alertify.error(dato.message);
            }
        }
    });
   

}
var listarCriador = function (control, mensaje, valor) {

    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
   // $("#" + control).append("<option value='0'>" + mensaje + "</option>");
    var items = "<option value='0'>" + mensaje + "</option>";
    $.ajax({
        url: 'ajax/ajaxEntidad.php',data:{opc:"lstItemsCria"},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
           // console.log(response);
            var tipoPelaje = dato.data;
            
            if (dato.result == K_ResultadoCboAjax.exito) {
                if(tipoPelaje!=null){
                $.each(tipoPelaje, function (index, tp) {
                    
                    var selected = "";
                    if (val == tp.valor) selected = "Selected";
                    items=items+"<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>";
                   // $("#" + control).append("<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>");
                });
            }
                 $("#" + control).html(items).selectpicker('refresh');
            } else {
                alertify.error(dato.message);
            }
        }
    });
}


var listarUsuario = function (control, mensaje, valor) {

    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    //$("#" + control).append("<option value='0'>" + mensaje + "</option>");
     var items = "<option  data-tokens='0'>" + mensaje + "</option>";
    $.ajax({
        url: 'ajax/ajaxusuarioRol.php',data:{opc:"lstItemUsu"},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            
            var tipoUsuario = dato.data;
            
            if (dato.result == K_ResultadoCboAjax.exito) {
                
                $.each(tipoUsuario, function (index, tp) {
                    
                    var selected = "";
                    if (val == tp.valor) selected = "Selected";
                    //$("#" + control).append("<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>");
                    items=items+"<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>";
                });
                 $("#" + control).html(items).selectpicker('refresh');
            } else {
                alertify.error(dato.message);
            }
        }
    });
   

}
var listarRol = function (control, mensaje, valor) {

    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    //$("#" + control).append("<option value='0'>" + mensaje + "</option>");
     var items = "<option  data-tokens='0'>" + mensaje + "</option>";
    $.ajax({
        url: 'ajax/ajaxusuarioRol.php',data:{opc:"lstItemsRol"},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            
            var tipoPelaje = dato.data;
            
            if (dato.result == K_ResultadoCboAjax.exito) {
                
                $.each(tipoPelaje, function (index, tp) {
                    
                    var selected = "";
                    if (val == tp.valor) selected = "Selected";
                    //$("#" + control).append("<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>");
                    items=items+"<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>";
                });
                 $("#" + control).html(items).selectpicker('refresh');
            } else {
                alertify.error(dato.message);
            }
        }
    });
   

}
var listarOficina = function (control, mensaje, valor) {

    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    //$("#" + control).append("<option value='0'>" + mensaje + "</option>");
     var items = "<option  data-tokens='0'>" + mensaje + "</option>";
    $.ajax({
        url: 'ajax/ajaxOficina.php',data:{opc:"lstItemsOfic"},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            
            var tipoPelaje = dato.data;
            
            if (dato.result == K_ResultadoCboAjax.exito) {
                
                $.each(tipoPelaje, function (index, tp) {
                    
                    var selected = "";
                    if (val == tp.valor) selected = "Selected";
                    //$("#" + control).append("<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>");
                    items=items+"<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>";
                });
                 $("#" + control).html(items).selectpicker('refresh');
            } else {
                alertify.error(dato.message);
            }
        }
    });
}

var listarMetodoReprop=function(control,mensaje,valor){
    var val=valor==undefined ? 0 : valor;
    $("#" + control + "option").remove();
    $("#" + control).append("<option value='0'>" + mensaje + "</option>");
    var items="<option data-tokens='0'>"+ mensaje + "</option>";

    $.ajax({
        url:'ajax/ajaxEjemplar.php',data:{opc:"lstMtdoReprop"},
        type:'POST',
        success:function(response){
            var dato=JSON.parse(response);

            var metodo=dato.data;
           // console.log(metodo);
            if(dato.result==K_ResultadoCboAjax.exito){
                
                $.each(metodo,function(index,tp){
                    
                    var selected="";
                    if(val==tp.id) selected="Selected";

                    items=items+"<option value='" + tp.id + "' "+selected+">"+ tp.descripcion+"</option>";
                });
                $("#"+control).html(items).selectpicker('refresh');
            }else{
                alertify.error(dato.message);
            }
        }

    });
}

/*-----------------------------------FASE 2 ---------------------------------*/
var listarTipoDocumento = function (control, mensaje, valor) {
    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    $("#" + control).append("<option value='0'>" + mensaje + "</option>");   
    $.ajax({
        url: 'ajax/ajaxInscripcion.php',data:{opc:"lstTipoDoc"},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            var tipoPelaje = dato.data;
            if (dato.result == K_ResultadoCboAjax.exito) {
                $.each(tipoPelaje, function (index, tp) {
                    var selected = "";
                    if (val == tp.valor) selected = "Selected";
                    $("#" + control).append("<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>");
                });
            } else {
                alertify.error(dato.message);
            }
        }
    });
}

var listarPelajeExt = function (control, mensaje, valor) {
    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    $("#" + control).append("<option value='0'>" + mensaje + "</option>");   
    $.ajax({
        url: 'ajax/ajaxPelaje.php',data:{opc:"lstItems"},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            var tipoPelaje = dato.data;
            //console.log(tipoPelaje);
            if (dato.result == K_ResultadoCboAjax.exito) {
                $.each(tipoPelaje, function (index, tp) {
                    var selected = "";
                    if (val == tp.valor) selected = "Selected";
                    $("#" + control).append("<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>");
                });
            } else {
                alertify.error(dato.message);
            }
        }
    });
}

var listarPaises = function (control, mensaje, valor) {
    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    $("#" + control).append("<option value='0'>" + mensaje + "</option>");   
    $.ajax({
        url: 'ajax/ajaxMonta.php',data:{opc:"lstPais"},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            var tipoPelaje = dato.data;
            if (dato.result == K_ResultadoCboAjax.exito) {
                $.each(tipoPelaje, function (index, tp) {
                    var selected = "";
                    if (val == tp.valor) selected = "Selected";
                    $("#" + control).append("<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>");
                });
            } else {
                alertify.error(dato.message);
            }
        }
    });
}


var listarIdMonta=function(control,mensaje,valor,prop){
    var val=valor==undefined ? 0 : valor;
    /*if(val==0){
        var flag="I";
    }else{*/
        var flag="U";
    //}
    $("#" + control + "option").remove();
    $("#" + control).append("<option value='0'>" + mensaje + "</option>");
    //var items="<option data-tokens='0'>"+ mensaje + "</option>";
    //console.log(val);
    $.ajax({
        url:'ajax/ajaxMonta.php',data:{opc:"listIdMonta",prop:prop,flag:flag},
        type:'POST',
        success:function(response){
            var dato=JSON.parse(response);

            var metodo=dato.data;
            
            
            if(dato.result==K_ResultadoCboAjax.exito){
                
                $.each(metodo,function(index,tp){
                   // console.log(tp);
                    var selected="";
                    if(val==tp.id) selected="Selected";
                    //items=items+"<option value='" + tp.id + "' "+selected+">"+ tp.descripcion+"</option>";
                    $("#" + control).append("<option value='" + tp.id + "' " + selected + ">" + tp.descripcion + "</option>");
                });
               // $("#"+control).html(items).selectpicker('refresh');
            }else{
                alertify.error(dato.message);
            }
        }

    });
}

var listarIdNacimiento=function(control,mensaje,valor,prop){
    var val=valor==undefined ? 0 : valor;
   /* if(val==0){
        var flag="I";
    }else{*/
        var flag="U";
  //  }

    $("#" + control + "option").remove();
    $("#" + control).append("<option value='0'>" + mensaje + "</option>");
    //var items="<option data-tokens='0'>"+ mensaje + "</option>";
    $.ajax({
        url:'ajax/ajaxNacimiento.php',data:{opc:"listIdNac",prop:prop,flag:flag},
        type:'POST',
        success:function(response){
            //console.log(response);
            var dato=JSON.parse(response);
            //console.log(dato.data);
            var metodo=dato.data;
            
            
            if(dato.result==K_ResultadoCboAjax.exito){
                
                $.each(metodo,function(index,tp){
                   // console.log(tp);
                    var selected="";
                    if(val==tp.id) selected="Selected";
                    //items=items+"<option value='" + tp.id + "' "+selected+">"+ tp.descripcion+"</option>";
                    $("#" + control).append("<option value='" + tp.id + "' " + selected + ">" + tp.descripcion + "</option>");
                });
                //$("#"+control).html(items).selectpicker('refresh');
            }else{
                alertify.error(dato.message);
            }
        }

    });
}

var listarTipoResena = function (control,mensaje,valor) {
    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    $("#" + control).append("<option value='0'>" + mensaje + "</option>");   
    $.ajax({
        url: 'ajax/ajaxResena.php',data:{opc:"lstTipo"},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            var tipoPelaje = dato.data;
            if (dato.result == K_ResultadoCboAjax.exito) {
                $.each(tipoPelaje, function (index, tp) {
                    var selected = "";
                    if (val == tp.valor) selected = "Selected";
                    $("#" + control).append("<option value='" + tp.valor + "' " + selected + ">" + tp.tipo + "</option>");
                });
            } else {
                alertify.error(dato.message);
            }
        }
    });
  }

  var listarMotivoBaja = function (control,mensaje,valor) {
    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    $("#" + control).append("<option value='0'>" + mensaje + "</option>");   
    $.ajax({
        url: 'ajax/ajaxInscripcion.php',data:{opc:"lstMotivoBaja"},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            var tipoPelaje = dato.data;
            if (dato.result == K_ResultadoCboAjax.exito) {
                $.each(tipoPelaje, function (index, tp) {
                    var selected = "";
                    if (val == tp.id) selected = "Selected";
                    $("#" + control).append("<option value='" + tp.id + "' " + selected + ">" + tp.motivo + "</option>");
                });
            } else {
                alertify.error(dato.message);
            }
        }
    });
  }


  var listarEjemplares = function (control, mensaje, valor) {
    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    $("#" + control).append("<option value='0'>" + mensaje + "</option>");   
    $.ajax({
        url: 'ajax/ajaxResultadoConcurso.php',data:{opc:"ejemplares"},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            var ejemplares = dato.data;
            if (dato.result == K_ResultadoCboAjax.exito) {
                //console.log(response);
                $.each(ejemplares, function (index, tp) {
                    var selected = "";
                    if (val == tp.id) selected = "Selected";
                   /*console.log(tp.id);
                   console.log(tp.ejemplar);*/
                    $("#" + control).append("<option value='" + tp.id + "' " + selected + ">" + tp.ejemplar + "</option>");
                });
            } else {
                alertify.error(dato.message);
            }
        }
    });
}
 var listarConcursos = function(control, mensaje, valor){
    var val = valor == undefined ? 0:valor;
    $("#"+control+" option").remove();
    $("#"+control).append("<option value='0'>"+ mensaje + "</option>");
    $.ajax({
        url: 'ajax/ajaxResultadoConcurso.php',data:{opc:"comboConcursos"},
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            var concursos = dato.data;
            if (dato.result == K_ResultadoCboAjax.exito) {
                //console.log(response);
                $.each(concursos, function (index, tp) {
                   /* console.log(tp.id);
                    console.log(val);*/
                    var selected = "";
                    if (val == tp.id) selected = "Selected";
                    $("#" + control).append("<option value='" + tp.id + "' " + selected + ">" + tp.nombre + "</option>");
                });
            } else {
                alertify.error(dato.message);
            }
        }
    });
 }