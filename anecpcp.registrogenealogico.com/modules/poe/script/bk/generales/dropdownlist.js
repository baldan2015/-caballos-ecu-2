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
 
 var listarResenia = function (control, mensaje,valor) {

    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    //$("#" + control).append("<option value='0'>" + mensaje + "</option>");
    
    $.ajax({
        url: 'ajax/ajaxResena.php',data:{opc:"lstItems"},
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
        url: 'ajax/ajaxEjemplar.php',data:{opc:"lstItemsSel",codigo:$("#txtCodigo").val()},
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

