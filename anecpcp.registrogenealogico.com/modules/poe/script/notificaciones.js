$(function () {
    listarNotificaciones('');

    $("#btnMensajesFiltro").on("click", function () {
        listarNotificaciones('M');
    });
    $("#btnAprobarFiltro").on("click", function () {
        listarNotificaciones('A');
    });
    $("#btnTodosFiltro").on("click", function () {
        listarNotificaciones('');
    });
});
var listarNotificaciones = function (filtro) {
    //console.log(filtro);
    $.ajax({
        data: {
            opc: 'lstLogMonta',
            idProp: $("#hidIdProp").val(),
            filtro: filtro
        },
        url: '../services/ejemplarService.php',
        type: 'POST',
        beforeSend: function (request) {
            request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
        },
        success: function (response) {
            var retorno = JSON.parse(response);
            if (retorno.result == "1") {
                var data = retorno.data;
               // console.log(data);
                if (data != null) {
                    setDataTable(data, retorno.cantidad);
                } else {
                    setDataTable('', retorno.cantidad);
                }

                //console.log('sdfs', data);
            } else {
                alertify.error(retorno.message);
            }
        }
    });
}
var setDataTable = function (data, numRow) {
  var tabla =  $('#grid').DataTable({
        data: data,
        language: {
            search: "Búsqueda:",
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No se encontraron registros",
            info: "Página  _PAGE_ de _PAGES_",
            infoEmpty: "No se encontraron registros"
        },
        responsive: true,
        pageLength: 100,
        destroy: true,
        columns: [{
                "data": "numero"
            },
            {
                "data": "fecha",
                "render": function (datum, type, row) {
                    if (datum != '' && datum != null) {
                      var dia = (datum).split("/")[0];
                      var mes = (datum).split("/")[1];
                      var anio = (datum).split("/")[2];
                      return "<span class='hidden'>" + anio + mes + dia + "</span>" + datum;
                    }
          
                  }
            },
            {
                "data": "mensaje"
            },
            {
                "data": "op"
            }
        ]
    });
    $("#lblCantidadSol").html(tabla.data().count());

};

function aprobarMonta(idMonta, idProp, vflagA) {
    if (vflagA == 1) {
        $.ajax({
            data: {
                opc: 'aproMonta',
                idMonta: idMonta,
                idProp: idProp
            },
            url: '../services/ejemplarService.php',
            type: 'POST',
            beforeSend: function (request) {
                request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
            },
            success: function (response) {
                var retorno = JSON.parse(response);
                if (retorno.result == "1") {
                    listarNotificaciones('');
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(retorno.message);
                } else {
                    alertify.error(retorno.message);
                }
            }
        });
    } else {
        alertify.confirm('Esta seguro que desea aprobar la notificación de servicio de monta?', function (e) {

            if (e) {
                $.ajax({
                    data: {
                        opc: 'aproMonta',
                        idMonta: idMonta,
                        idProp: idProp
                    },
                    url: '../services/ejemplarService.php',
                    type: 'POST',
                    beforeSend: function (request) {
                        request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
                    },
                    success: function (response) {
                        var retorno = JSON.parse(response);
                        if (retorno.result == "1") {
                            listarNotificaciones('');
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(retorno.message);
                        } else {
                            alertify.error(retorno.message);
                        }
                    }
                });
            } else {
                //after clicking Cancel
            }
        });
    }
}


function rechazarMonta(idMonta, idProp, vflagR) {

    if (vflagR == 1) {
        $.ajax({
            data: {
                opc: 'rechMonta',
                idMonta: idMonta,
                idProp: idProp
            },
            url: '../services/ejemplarService.php',
            type: 'POST',
            beforeSend: function (request) {
                request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
            },
            success: function (response) {
                var retorno = JSON.parse(response);
                if (retorno.result == "1") {
                    listarNotificaciones('');
                    alertify.success(retorno.message);
                } else {
                    alertify.error(retorno.message);
                }
            }
        });

    } else {
        alertify.confirm('Esta seguro que desea rechazar la notificación de servicio de monta?', function (e) {

            if (e) {
                $.ajax({
                    data: {
                        opc: 'rechMonta',
                        idMonta: idMonta,
                        idProp: idProp
                    },
                    url: '../services/ejemplarService.php',
                    type: 'POST',
                    beforeSend: function (request) {
                        request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
                    },
                    success: function (response) {
                        var retorno = JSON.parse(response);
                        if (retorno.result == "1") {
                            listarNotificaciones('');
                            alertify.success(retorno.message);
                        } else {
                            alertify.error(retorno.message);
                        }
                    }
                });
            } else {
                //after clicking Cancel
            }


        });
    }
}


function popupDetalle(id,codigoProp,flag){
    //console.log(id);
    //console.log(flag);
    //console.log(mensaje);
    $('#mvDetalleNoti').modal({show:true});
    $("#btnAprobarD").hide();
    $("#btnRechazarD").hide();
    
        $.ajax({
        data:  {opc:'getTextoIns',id:id,flag:flag},
        url:   '../services/ejemplarService.php',
        type:  'POST',
        success:  function (response) {
            var retorno=JSON.parse(response);
            //console.log(retorno);
            
            var msg = "El socio " + retorno.html.usuCrea +", registró un servicio de monta entre los siguientes ejemplares:<br><br> ";
                if(retorno.html.socioP == null){
                    msg = msg + "&nbsp;&nbsp;&nbsp;1. "+ retorno.html.nombrePotro + ", ejemplar extranjero<br>";
                }else{
                    msg = msg + "&nbsp;&nbsp;&nbsp;1. "+ retorno.html.nombrePotro + ", propiedad de " + retorno.html.socioP +"<br>";
                }
                msg = msg + "&nbsp;&nbsp;&nbsp;2. "+ retorno.html.nombreYegua + ", propiedad de " + retorno.html.socioY;
            if(flag==1){
              $("#lblTexto").html(msg);
              $("#divNoti").show();
              $("#lblFechaRegistro").html("Fecha de registro: " +  retorno.html.fecha);  
              $("#lblMensajeConfirmacion").html("¿Es conforme este servicio de monta asociado a su ejemplar?"); 
            }else{
              $("#lblTexto").html(retorno.html.mensaje);
              $("#divNoti").hide();  
              $("#lblFechaRegistro").html("");  
              $("#lblMensajeConfirmacion").html("");
            }
            $("#txtCodigoNoti").val(id);
            $("#txtCodigoProp").val(codigoProp);
            if(flag=="1"){
                $("#btnAprobarD").show();
                $("#btnRechazarD").show();
            }
        }
       });

}

function flagA(flag){
    if(flag==1){
        var id=$("#txtCodigoNoti").val();
        var prop=$("#txtCodigoProp").val();
        //console.log(id);
        aprobarMonta(id,prop,1);
    }

}
function flagR(flag){
    if(flag==2){
        var id=$("#txtCodigoNoti").val();
        var prop=$("#txtCodigoProp").val();
        rechazarMonta(id,prop,1);
    }

}