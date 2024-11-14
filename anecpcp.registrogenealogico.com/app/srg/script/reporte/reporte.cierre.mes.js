$(function(){


$('#radioBtn a').on('click', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel);
    
    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
});
 
$('#radioBtnTipoReporte a').on('click', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel);
    
    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
});

 var d = new Date();
  var year = d.getFullYear();
  var month = d.getMonth();
  month++;
  	$("#txtPeriodo").val(year);
	$("#txtMes").val(month);
  $("#txtPeriodo").focus();
$("#txtPeriodo,#txtMes").on("keypress",function(e){		if(e.which==13){ reporte(); }	});


$("#btnCancelar").on("click",function(){
 document.location.href='shared.php?obj=d7ad7483b61f109db2464d858287ff26';
});
  
$("#btnVer").on("click",function(){     reporte(); });
$("#btnXls").on("click",function(){     reporte(1); });
$("#btnPrint").on("click",function(){
  grlCenterWindow(1000,600,50,'vista/impresion/cierreMensual.php?per='+$("#txtPeriodo").val()+'&mes='+$("#txtMes").val(),'demo_win');});
  
});
 

function reporte(isXls){


	if(($("#txtPeriodo").val().length==0 && $("#txtMes").val().length==0)){
				alertify.error("Para realizar la búsqueda ingrese el periodo y mes.");
	}else{		
				var  param= {
							opc:'rptCierreCaja',
							anio:$("#txtPeriodo").val(),
							mes:$("#txtMes").val(),
							origen:$("#hidOrigen").val(),
							castrado:$("#hidCastrado").val(),
							tipoReporte:$("#hidTipoReporte").val()
							};

			 
				if(param.tipoReporte=="T")param.opc="rptCierreCajaTransfer";
				if(isXls!=undefined && isXls==1)param.xls=1;
			 	$.ajax({
						data: param,
						url:   'ajax/ajaxReporte.php',
						type:  'post',
						success:  function (response) {
							var retorno=JSON.parse(response);
							if(retorno.result=="1"){
									if(isXls!=undefined && isXls==1){
											window.open('data:application/vnd.ms-excel,' + encodeURIComponent(retorno.html));
					                        alertify.success("Datos exportados correctamente.");
									}else{
											$("#divResult").html(retorno.html);
									    	$("#divResumen").html('Número de registros encontrados: ' +retorno.cantidad);
									}
			                }else{       
			                        alertify.error("Ocurrió un error al obtener los datos.");
			                }
						    
						  },
						 error: function (xhr, ajaxOptions, thrownError) {
						 	alertify.error(xhr.status+ ""+thrownError);
			        	} 
				});
 }
					 
}
 