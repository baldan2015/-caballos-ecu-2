$(function(){

$("#txtCriador").focus();
$("#txtCriador,#txtPrefijo").on("keypress",function(e){		if(e.which==13){ reporte(); }	});


$("#btnCancelar").on("click",function(){
	$("#txtCriador").val("");
	$("#lstDpto").val(0);
	$("#divResult").html(" <table  class='tbDatoMain'><tr><th><b>Tipo Doc</b></th><th><b>Num Doc</b></th>"+
						"<th><b>Nombres Apellidos /Razon Social</b></th><th><b>Prefijo</b></th><th><b>Dpto</b></th><th><b>Lugar Crianza</b></th>"+
						"</tr></table>");
	$("#divResultConsol").html(" <table  class='tbDatoMain'><tr><th><b>Departamento</b></th><th><b>Cantidad</b></th></tr></table>");
	
	$("#divResumen").html("Número de registros encontrados: 0");
});
  
$("#btnVer").on("click",function(){     reporte(); });
$("#btnXls").on("click",function(){     reporte(1); });
listarDeparmento("lstDpto", "-TODOS-", 0); 
});
 

function reporte(isXls){
	 	
				var  param= {opc:'rptCriaXDpto',
							 nombre:$("#txtCriador").val(),
							 idDpto:$("#lstDpto").val(),
							 isProp:$("#chkProp").prop("checked")
							}
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
											$("#divResultConsol").html(retorno.html2);
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
 