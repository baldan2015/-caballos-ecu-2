var K_TOKEN_NAME="Authorization";
 var controls={

  modalDialogFac:"#mvEjemplarFallecido",
  modalDialogCas:"#mvEjemplarCastrado",
  modalDialogTras:"#mvEjemplarTransferencia",
  modalDialogDetalle:"#mvDetalleNoti",
  btnNotificacion:"#btnNotificacion"
}

  $(function(){
    listarNovedades();
    notificaciones($("#hidIdProp").val());
    
    $(controls.modalDialogFac).on('show.bs.modal', function () {
            listarMiEjemplarFac("cboEjemplarFac","SELECCIONE","",$("#hidIdProp").val());
            listarHistorialF();
            clearCtrlsPopupF();
    });
    $(controls.modalDialogCas).on('show.bs.modal', function () {
            listarMiEjemplarCas("cboEjemplarCas","SELECCIONE","",$("#hidIdProp").val());
            listarHistorialC();
    });
    $(controls.modalDialogTras).on('show.bs.modal', function () {
            listarMiPropiedad("cboEjemplar","SELECCIONE",'',$("#hidIdProp").val());
            listarPropietarioTransferencia("cboPropietario","SELECCIONE",'');
            listaTrasnferencias();
            listarDocumentoPropietario('cboTipoDocumento','SELECCIONE','');
    });
  });

  function listarNovedades(){
  	$.ajax({
				data:  {opc:'lstNov',idProp:$("#hidIdProp").val()},
				url:   'modules/poe/services/ejemplarService.php',
				type:  'POST',
                beforeSend: function(request) {
                  request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
                },
				success:  function (response) {
                    var retorno=JSON.parse(response);
                    if(retorno.result=="1"){
                            var data=retorno.data;
                             
                            $("#cantMisEjemplares").html(data.cantMisEjemplares);
                            $("#cantInscipcion").html(data.cantInscripcion);
                            $("#cantNacimiento").html(data.cantNacimiento);
                            $("#cantMonta").html(data.cantMonta);
                            var fallec = parseInt(data.cantFallecido);
                            var cast = parseInt(data.cantCastrado);
                            var trans = parseInt(data.cantTransferido);
                            var totalNovedades = fallec + cast + trans;
                            $("#cantNovedades").html(totalNovedades);
                            $("#cantFallecido").html(data.cantFallecido);
                            $("#cantCastrado").html(data.cantCastrado);
                            $("#cantTransferido").html(data.cantTransferido);
                    }else{
                        alertify.error(retorno.message);
                    }
				},
          complete: function() {
                  ajaxindicatorstopB();
        }
		});
  }



  function popupFallecidos(){
    $(controls.modalDialogFac).modal('show');
}

function popupCastracion(){
    $(controls.modalDialogCas).modal('show');
}

function popupTransferido(){
    $(controls.modalDialogTras).modal('show');

}



function notificaciones(idProp){

    $.ajax({
        data:  {opc:'resLogMonta',idProp:$("#hidIdProp").val()},
        url:   'modules/poe/services/ejemplarService.php',
        type:  'POST',
        beforeSend: function(request) {
          request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
        },
        success:  function (response) {
            //console.log(response);
            var retorno=JSON.parse(response);
           // console.log(retorno.data);
            if(retorno.result=="1"){
                 $("#divNotificaciones").html(retorno.html);
                 $('[data-toggle="tooltip"]').tooltip();
                // $('[data-toggle="tooltip"]').tooltip();
            }
        }
       }); 

}


function aprobarMonta(idMonta,idProp,vflagA){

if(vflagA == 1){
    $.ajax({
            data:  {opc:'aproMonta',idMonta:idMonta,idProp:idProp},
            url:   'modules/poe/services/ejemplarService.php',
            type:  'POST',
            beforeSend: function(request) {
              request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
            },
            success:  function (response) {
                var retorno=JSON.parse(response);
                if(retorno.result=="1"){
                    notificaciones(idProp);
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(retorno.message);
                }else{
                    alertify.error(retorno.message);
                }
            }
           }); 
}else{
  alertify.confirm('Esta seguro que desea aprobar la notificación de servicio de monta?', function(e){

    if (e) {
       $.ajax({
        data:  {opc:'aproMonta',idMonta:idMonta,idProp:idProp},
        url:   'modules/poe/services/ejemplarService.php',
        type:  'POST',
        beforeSend: function(request) {
          request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
        },
        success:  function (response) {
            var retorno=JSON.parse(response);
            if(retorno.result=="1"){
                notificaciones(idProp);
                alertify.set('notifier','position', 'top-right');
                alertify.success(retorno.message);
            }else{
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


function rechazarMonta(idMonta,idProp,vflagR){

if(vflagR == 1){
      $.ajax({
        data:  {opc:'rechMonta',idMonta:idMonta,idProp:idProp},
        url:   'modules/poe/services/ejemplarService.php',
        type:  'POST',
        beforeSend: function(request) {
          request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
        },
        success:  function (response) {
            var retorno=JSON.parse(response);
            if(retorno.result=="1"){
                notificaciones(idProp);
                alertify.success(retorno.message);
            }else{
                alertify.error(retorno.message);
            }
        }
       }); 
  
}else{
     alertify.confirm('Esta seguro que desea rechazar la notificación de servicio de monta?', function(e){

    if (e) {
      $.ajax({
        data:  {opc:'rechMonta',idMonta:idMonta,idProp:idProp},
        url:   'modules/poe/services/ejemplarService.php',
        type:  'POST',
        beforeSend: function(request) {
          request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
        },
        success:  function (response) {
            var retorno=JSON.parse(response);
            if(retorno.result=="1"){
                notificaciones(idProp);
                alertify.success(retorno.message);
            }else{
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
        url:   'modules/poe/services/ejemplarService.php',
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

function ajaxindicatorstartB(text) {
            if (jQuery('body').find('#resultLoading').attr('id') != 'resultLoading') {
                jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src="img/ajax-loader.gif"><div>' + text + '</div></div><div class="bg"></div></div>');
            }

            jQuery('#resultLoading').css({
                'width': '100%',
                'height': '100%',
                'position': 'fixed',
                'z-index': '10000000',
                'top': '0',
                'left': '0',
                'right': '0',
                'bottom': '0',
                'margin': 'auto'
            });

            jQuery('#resultLoading .bg').css({
                'background': '#000000',
                'opacity': '0.3',
                'width': '100%',
                'height': '100%',
                'position': 'absolute',
                'top': '0'
            });

            jQuery('#resultLoading>div:first').css({
                'width': '250px',
                'height': '75px',
                'text-align': 'center',
                'position': 'fixed',
                'top': '0',
                'left': '0',
                'right': '0',
                'bottom': '0',
                'margin': 'auto',
                'font-size': '16px',
                'z-index': '10',
                'color': '#ffffff'

            });

            jQuery('#resultLoading .bg').height('100%');
            jQuery('#resultLoading').fadeIn(200);
            jQuery('body').css('cursor', 'wait');
        }

        function ajaxindicatorstopB() {
            jQuery('#resultLoading .bg').height('100%');
            jQuery('#resultLoading').fadeOut(200);
            jQuery('body').css('cursor', 'default');
        }



