var K_PATH_ROOT="modules/poe/";
$(function(){
$("#btnImprimirCa").on("click",function(){ 	viewFormCas(7,$("#hidIdProp").val(),$("#hidIdPoe").val(),'CA');});
$("#btnGrabarC").on("click",function(){ insertC();	});
/*
listarEjemplaresP();
listarHistorialP(K_TIPO.castracion);
*/
$("#btnCancelarC").on("click",function(){
	$("#dtFechaCa").val("");
	$('select[name=cboEjemplarCas]').val(0);
  	$('.selectpicker').selectpicker('refresh'); 
});
$("#btnRefreshC").on("click",function(){listarHistorialC();});

});

 function listarHistorialC(){
		$.ajax({
				data:  {opc:'lstHistC',idProp:$("#hidIdProp").val()},
				url:   'modules/poe/services/ejemplarService.php',
				type:  'post',
				success:  function (response) {
				    var retorno = JSON.parse(response);
				    if(retorno.result=="1"){
				    	var data = retorno.data;
                        setDataTableC(data,retorno.cantidad);
                    }else{
                        alertify.error(retorno.message);
                    }
				}
		});
};
 
var setDataTableC=function(data,numRow){
 $('#gridC').DataTable( {
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
            { "data": "fecCas" },
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
                    var rowTable="<span title='Eliminar Solicitud' class='btn btn-basic btn-xs glyphicon glyphicon-trash' data-toggle='tooltip'   data-id='"+obj.id+"' onclick='deteteCas(this);' ></span> ";
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


function insertC(){
if($("#cboEjemplarCas").val()== 0){
	alertify.error("Debe seleccionar un ejemplar");
	return false;
}else{
	if(grlValidarObligatorio("#mvEjemplarCastrado")){
alertify.confirm("Está seguro de registrar la información?", function (e) {
if (e) {
			
						$.ajax({
							data:  {opc:'insC',
									idUser:$("#hidIdProp").val(),
									idEjemplar:$("#cboEjemplarCas").val(),
									fecha:$("#dtFechaCa").val()},
							url:   'modules/poe/services/ejemplarService.php',
							type:  'post',
							success:  function (response) {
								 var retorno = JSON.parse(response);
								 if(retorno.result==1){
								 	listarHistorialC();
								 	clearCtrlsPopupC();
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
 

function clearCtrlsPopupC(){
  	$("#dtFechaCa").val("");
  	listarMiEjemplarCas("cboEjemplarCas","SELECCIONE","",$("#hidIdProp").val());
  }




function deteteCas(obj){
var id=$(obj).data("id");
if(id!=undefined){
					  $.ajax({
							data:  {opc:'delCas',id:id},
							url:   'modules/poe/services/ejemplarService.php',
							type:  'post',
							success:  function (response) {
								 var retorno = JSON.parse(response);
								 if(retorno.result==1){
								 	listarHistorialC();
								 	listarMiEjemplarCas("cboEjemplarCas","SELECCIONE","",$("#hidIdProp").val());
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
				type:  'post',
				success:  function (response) {
				 //   alert(response);
				  retorno(response);
				     
				}
		});
		return retorno;
};
*/


function viewFormCas(idForm,idUser,idPoe,tipo){

var response="";
if(idForm==7){
			$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser,tipo:tipo},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario7.php',
				type:  'post',
				success:  function (response) {
					printRptCas(response,700,500,idUser);
				     
				     
				}
		});
}


return false; 
 
} 


function printRptCas(response,iwidth,iheight,idUser){
	  var reporte = window.open('../vista/printNovCastracion.php?idProp='+idUser+'','1456621267083','width='+iwidth+',height='+iheight+',toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');
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