//var K_PATH_ROOT="../";
var K_PATH_ROOT="modules/poe/";
$(function(){
$("#btnImprimirFa").on("click",function(){viewFormFac(7,$("#hidIdProp").val(),$("#hidIdPoe").val(),'FA');});
/*listarMiEjemplarFac("cboEjemplarFac","SELECCIONE","",$("#hidIdProp").val());
listarHistorialF();
clearCtrlsPopupF();
*/
$("#btnCancelarF").on("click",function(){
$("#dtFechaFa").val("");
$('select[name=cboEjemplarFac]').val(0);
$('.selectpicker').selectpicker('refresh');
});
$("#btnGrabarF").on("click",function(){
insertF();
});
$("#btnRefresh").on("click",function(){
listarHistorialF();
});


});



 function listarHistorialF(){
		$.ajax({
				data:  {opc:'lstHistF',idProp:$("#hidIdProp").val()},
				url:   'modules/poe/services/ejemplarService.php',
				type:  'post',
				success:  function (response) {
					var retorno = JSON.parse(response);
				    if(retorno.result=="1"){
				    	var data = retorno.data;
                        setDataTableF(data,retorno.cantidad);
                    }else{
                        alertify.error(retorno.message);
                    }
				}
		});
};
  
 var setDataTableF=function(data,numRow){
 $('#gridF').DataTable( {
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
        lengthMenu: [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
        pageLength:5,
        iDisplayLength:5,
         columns: [
            { "data": "ejemplar" },
            { "data": "fecFac" },
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
            { "data": "comentario" },
            { "data": "fecRev" },
            {
             "className":      'edit',
             "orderable":      false,
             "data":           null,
             "defaultContent": "",
             "render": function (obj, type, row, meta) {
                //console.log(obj.estado);
                if(obj.estado == 'INI'){
                    var rowTable="<span title='Eliminar Solicitud' class='btn btn-basic btn-xs glyphicon glyphicon-trash' data-toggle='tooltip'   data-id='"+obj.id+"' onclick='deleteFac(this);' ></span> ";
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


function insertF(){
if($("#cboEjemplarFac").val()== 0){
	alertify.error("Debe seleccionar un ejemplar");
	return false;
}else{
	if(grlValidarObligatorio("#mvEjemplarFallecido")){
alertify.confirm("Está seguro de registrar la información?", function (e) {
if (e) {
			
						$.ajax({
							data:  {opc:'insF',
									idUser:$("#hidIdProp").val(),
									idEjemplar:$("#cboEjemplarFac").val(),
									fecha:$("#dtFechaFa").val()},
							url:   'modules/poe/services/ejemplarService.php',
							type:  'post',
							success:  function (response) {
								 var retorno = JSON.parse(response);
								 if(retorno.result==1){
								 	listarHistorialF();
								 	clearCtrlsPopupF();
								 	 listarNovedades();
								 	alertify.success(retorno.message);
								 }else{
								 	alertify.error(retorno.message);
								 }
							}
						});
					
  		}
	});

	}
	}
}

function clearCtrlsPopupF(){
  	$("#dtFechaFa").val("");
  	listarMiEjemplarFac("cboEjemplarFac","SELECCIONE","",$("#hidIdProp").val());
  }

 



function deleteFac(obj){
var id=$(obj).data("id");
if(id!=undefined){
					  $.ajax({
							data:  {opc:'delFac',id:id},
							url:   'modules/poe/services/ejemplarService.php',
							type:  'post',
							success:  function (response) {
								 var retorno = JSON.parse(response);
								 if(retorno.result==1){
								 	listarHistorialF();
								 	listarMiEjemplarFac("cboEjemplarFac","SELECCIONE","",$("#hidIdProp").val());
								 	listarNovedades();
								 	alertify.success(retorno.message);
								 }else{
								 	alertify.error(retorno.message);
								 }
									 
							}
						});  
}
}
/*
//var envioForm=function(retorno){
function envioForm(retorno){
	
		$.ajax({
				data:  {alt:'get'},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxEnvio.php',
				//url:   'modules/poe/ajaxPOE/ajaxEnvio.php',
				type:  'post',
				success:  function (response) {
				 //   alert(response);
				  retorno(response);
				     
				}
		});
		return retorno;
};*/




function viewFormFac(idForm,idUser,idPoe,tipo){

var response="";
if(idForm==7){
			$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser,tipo:tipo},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario7.php',
				type:  'post',
				success:  function (response) {
					printRptFac(response,700,500,idUser);
				     
				     
				}
		});
}


return false; 
 
} 


function printRptFac(response,iwidth,iheight,idUser){
	  var reporte = window.open('../vista/printNovFallecimiento.php?idProp='+idUser+'','1456621267083','width='+iwidth+',height='+iheight+',toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');
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


