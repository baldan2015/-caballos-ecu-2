//var K_PATH_ROOT="../";
var K_PATH_ROOT="modules/poe/";
$(function(){
$("#btnImprimirTrans").on("click",function(){ viewFormTra(5,$("#hidIdProp").val(),$("#hidIdPoe").val());});//.button({icons: { primary: "ui-icon-print" }});
/*
listarMiPropiedad("cboEjemplar","SELECCIONE",'',$("#hidIdProp").val());
listarPropietarioTransferencia("cboPropietario","SELECCIONE",'');
listaTrasnferencias();
listarDocumentoPropietario('cboTipoDocumento','SELECCIONE','');*/
$("#cboEjemplar").on("change",function(){
    var codigo = $("#cboEjemplar").val();
    $("#idHorseT").val(codigo);
});

$("#btnSaveT").on("click",function(){$("#submit-btn").click();return false; e.preventDefault();});
$("#btnSaveNP").on("click",function(){saveNewPropietario();});
$("#btnCancelarT").on("click",function(){
    $("#dtFechaTrans").val("");
    $("#txtAreaComentarioTra").val("");
    $('select[name=cboPropietario]').val(0);
    $('select[name=cboEjemplar]').val(0);
    $('.selectpicker').selectpicker('refresh');
});
$("#btnRefreshT").on("click",function(){listaTrasnferencias();});
var options = { 
            target: '#output',   // target element(s) to be updated with server response 
            beforeSubmit: beforeSubmit,  // pre-submit callback 
            success: afterSuccess,  // post-submit callback 
            resetForm: true        // reset the form after successful submit 
        }; 

$('#MyUploadForm').submit(function(e) { $(this).ajaxSubmit(options); return false; e.preventDefault(); });

$("#btnAddPropietario").on("click",function(){
    $("#mvNuevoPropietario").modal("show");
    //console.log("entro11");
});

});


function viewFormTra(idForm,idUser,idPoe,tipo){

var response="";
if(idForm==5){
            $.ajax({
                data:  {opc:'lstView',idPoe:idPoe,idProp:idUser,tipo:tipo},
                url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario5.php',
                type:  'post',
                success:  function (response) {
                    printRptTra(response,700,500,idUser);
                     
                     
                }
        });
}


return false; 
 
} 


function printRptTra(response,iwidth,iheight,idUser){
      var reporte = window.open('../vista/printNovTransferencia.php?idProp='+idUser+'','1456621267083','width='+iwidth+',height='+iheight+',toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');
                    reporte.document.write("<div id='xresult'>"+response+"</div>");
                    var lnk=reporte.document.getElementById("lnkPrint");
                    if(lnk!=null) lnk.style.display='none';
                    reporte.print();
                    reporte.focus();
}





  function listarNovedades(){
    $.ajax({
                data:  {opc:'lstNov',idProp:$("#hidIdProp").val()},
                url:   'modules/poe/services/ejemplarService.php',
                type:  'POST',
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
                }
        });
  }

  function savaTransferencia(idImgPdfGen,callback){
    //if(grlValidarObligatorio("#mvEjemplarTransferencia")){
  //  alertify.confirm("Está seguro de registrar la información?", function (e) {
 //   if (e) {
        $.ajax({
                data:  {opc:'saveTrans',ejemplar:$("#cboEjemplar  option:selected").val(),
                                    newPropietario:$("#cboPropietario").val(),
                                    fechaTrans:$("#dtFechaTrans").val(),
                                    comentario:$("#txtAreaComentarioTra").val(),
                                    idProp:$("#hidIdProp").val(),
                                    idImgPdfGen:idImgPdfGen},
                url:   'modules/poe/services/ejemplarService.php',
                type:  'POST',
                success:  function (response) {
                    var retorno=JSON.parse(response);
                    //console.log(retorno);
                    if(retorno.result=="1"){
                         callback(1);
                         alertify.success(retorno.message);
                        /* clearCtrlsPopup();
                         listaTrasnferencias();
                         listarNovedades();*/
                    }else{
                        callback(0);
                        alertify.error(retorno.message);
                        //listaTrasnferencias();
                    }
                }
        });
 return callback;
      //  }
  //  });
    //}
   }


  function clearCtrlsPopup(){
    $("#dtFechaTrans").val("");
    $("#txtAreaComentarioTra").val("");
    listarPropietarioTransferencia("cboPropietario","SELECCIONE",'');
    listarMiPropiedad("cboEjemplar","SELECCIONE",'',$("#hidIdProp").val());
  }


  function clearCtrlsPopupNuevoPropietario(){
    $("#txtNumeroCedula").val("");
    $("#txtNombrePropietario").val("");
    $("#txtApellidoPaternoPropietario").val("");
    $("#txtApellidoMaternoPropietario").val("");
    $("#txtDireccionPropietario").val("");
    $("#txtCorreoPropietario").val("");
    listarDocumentoPropietario('cboTipoDocumento','SELECCIONE','');
  }

  var listaTrasnferencias=function(){
    $.ajax({
        data:  {opc:'lstMov',idProp:$("#hidIdProp").val()},
        url:   'modules/poe/services/ejemplarService.php',
        type:  'POST',
        beforeSend: function(request) {
          request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
        },
        success:  function (response) {
                    var retorno=JSON.parse(response);
                    //console.log(retorno);
                    if(retorno.result=="1"){
                            var data=retorno.data;
                           setDataTable(data,retorno.cantidad,retorno.pathWeb);
                           //setDataTable('','');
                    }else{
                        alertify.error(retorno.message);
                    }
        }
    });
};
var setDataTable=function(data,numRow,pathWeb){
 $('#grid').DataTable( {
        data:data ,
       language: {
                  search: "Búsqueda:",
                  lengthMenu: "Mostrar _MENU_ registros por página",
                  zeroRecords: "No se encontraron registros",
                  info: "Página  _PAGE_ de _PAGES_",
                  infoEmpty: "No se encontraron registros"
         },
        responsive: true,
        destroy: true,
        iDisplayLength: 5,
        lengthMenu: [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
        pageLength:5,
         columns: [
            { "data": "nomContacto" },
            { "data": "ejemplar" },
            { "data": "ruta",render: function(datum, type, row){
                var K_PATHWEB_TRANS_IMG = pathWeb
                var imagen="<a href='"+K_PATHWEB_TRANS_IMG+row.ruta+"' target='_blank'>Ver Comprobante</a>";
                return imagen
            }},
            { "data": "estado",render: function(datum, type, row){
                  var estadoTexto="";
                  switch(row.estado){
                        case 'INI':
                        estadoTexto= "<span class='badge badge-warning badge1'>"+row.estadoTexto+"</span>";
                        break;
                        case 'APR':
                        estadoTexto= "<span class='badge badge-success badge2'>"+row.estadoTexto+"</span>";
                        break;
                        case 'REC':
                        estadoTexto= "<span class='badge badge-danger badge3'>"+row.estadoTexto+"</span>";
                        break;
                  }

                  return estadoTexto
            }},
            { "data": "fecCrea" },
            { "data": "fecMov" },
            { "data": "comentario" },
            { "data": "fecRevision" },
            {
             "className":      'edit',
             "orderable":      false,
             "data":           null,
             "defaultContent": "",
             "render": function (obj, type, row, meta) {
                //console.log(obj.estado);
                if(obj.estado == 'INI'){
                    var rowTable="<span title='Eliminar Solicitud' class='btn btn-basic btn-xs glyphicon glyphicon-trash' data-toggle='tooltip'   data-id='"+obj.id+"' onclick='deleteMov(this);' ></span> ";
                          return rowTable;
                      }else{
                          var 
                          rowTable="";
                          
                          return rowTable;
                      }
                          
              }
            }
            ]
    } );
          //$("#lblCantidadSol").html(numRow);
          $('[data-toggle="tooltip"]').tooltip();
         // $('#grid tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
}; 


function deleteMov(obj){
    var id=$(obj).data("id");
     if(id!=undefined){
                     $.ajax({
                            data:  {opc:'delMov',id:id},
                            url:   'modules/poe/services/ejemplarService.php',
                            type:  'POST',
                            beforeSend: function(request) {
                              request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
                            },
                            success:  function (response) {
                                        var retorno=JSON.parse(response);
                                        //console.log(retorno);
                                        if(retorno.result=="1"){
                                                var data=retorno.data;
                                               alertify.success(retorno.message);
                                               listaTrasnferencias();
                                               listarNovedades();
                                        }else{
                                            alertify.error(retorno.message);
                                        }
                            }
                        });
           }

}


function saveNewPropietario(){
    if(grlValidarObligatorio("#mvNuevoPropietario")){
        $.ajax({
                data:  {opc:'saveNewProp',tipoDoc:$("#cboTipoDocumento").val(),
                                    numDoc:$("#txtNumeroCedula").val(),
                                    nombre:$("#txtNombrePropietario").val(),
                                    apePat:$("#txtApellidoPaternoPropietario").val(),
                                    apeMat:$("#txtApellidoMaternoPropietario").val(),
                                    direccion:$("#txtDireccionPropietario").val(),
                                    correo:$("#txtCorreoPropietario").val(),
                                    idProp:$("#hidIdProp").val()},
                url:   'modules/poe/services/ejemplarService.php',
                type:  'POST',
                success:  function (response) {
                    var retorno=JSON.parse(response);
                    //console.log(retorno);
                    if(retorno.data.flag==1){
                         alertify.success(retorno.message);
                         $("#mvNuevoPropietario").modal("hide");
                         clearCtrlsPopupNuevoPropietario();
                         $('#cboPropietario').selectpicker('refresh');
                         listarPropietarioTransferencia("cboPropietario","SELECCIONE",retorno.data.id);
                    }else{
                        alertify.error("Ya existe el propietario");
                    }
                }
        });
    }
}





function afterSuccess(response)
{
    var idImgPdfGen=$("#txtFlatInsert").val();
    if(!isNaN(idImgPdfGen)){
        if(eval(idImgPdfGen)>0){
            //registrar datos transfer
            savaTransferencia(idImgPdfGen,function(response){
                         if(response==1){
                             clearCtrlsPopup();
                             listaTrasnferencias();
                             listarNovedades();
                         }
            });
        }
    }
    $('#submit-btn').show(); //hide submit button
    $('#loading-img').hide(); //hide submit button
}

//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
    //console.log($("#hidFlagEdit").val());
            if($("#cboEjemplar").val() == 0 ){
                alertify.error("Debe seleccionar un ejemplar");
                return false
            }else if($("#cboPropietario").val() == 0){
                alertify.error("Debe seleccionar un propietario");
                return false
            }else if($("#dtFechaTrans").val() == ''){
                alertify.error("Debe seleccionar una fecha de transferencia");
                return false
            }else if( !$('#imageInput').val()) //check empty input filed
            {
                alertify.error("Debe adjuntar una imagen");
                return false
            }/*
 alertify.confirm("Está seguro de registrar la información?", function (e) {
    if (e) {  *
                                 /* if($("#cboEjemplar").val() == 0 ){
                                        alertify.error("Debe seleccionar un ejemplar");
                                        return false
                                    }else if($("#cboPropietario").val() == 0){
                                        alertify.error("Debe seleccionar un propietario");
                                        return false
                                    }else if($("#dtFechaTrans").val() == ''){
                                        alertify.error("Debe seleccionar una fecha de transferencia");
                                        return false
                                    }else if( !$('#imageInput').val()) //check empty input filed
                                    {
                                        alertify.error("Debe adjuntar una imagen");
                                        return false
                                    }else */
                                    if (window.File && window.FileReader && window.FileList && window.Blob)
                                    {
                                        var fsize = $('#imageInput')[0].files[0].size; //get file size
                                        var ftype = $('#imageInput')[0].files[0].type; // get file type
                                        
                                        //allow only valid image file types 
                                        switch(ftype)
                                        {
                                            case 'image/png': 
                                            case 'image/gif': 
                                            case 'image/jpeg': 
                                            case 'image/pjpeg':
                                            case 'application/pdf':
                                                break;
                                            default:
                                                //$("#output").html("<b>"+ftype+"</b> Unsupported file type!");
                                                alertify.error("<b>"+ftype+"</b> Unsupported file type!");
                                                return false
                                        }
                                        
                                        //Allowed file size is less than 1 MB (1048576)
                                        if(fsize>1048576) 
                                        {
                                            //$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
                                            alertify.error("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
                                            return false
                                        }
                                                
                                        $('#submit-btn').hide(); //hide submit button
                                        $('#loading-img').show(); //hide submit button
                                        $("#output").html("");  
                                }
                                else
                                {
                                    //Output error to older browsers that do not support HTML5 File API
                                    alertify.error("Please upgrade your browser, because your current browser lacks some new features we need!");
                                    //$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
                                    return false;
                                }
        // }
  //  });
   
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}
