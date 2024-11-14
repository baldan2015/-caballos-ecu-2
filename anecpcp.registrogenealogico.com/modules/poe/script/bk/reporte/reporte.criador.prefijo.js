$(function(){

$("#txtCriador").focus();
$("#txtCriador,#txtPrefijo").on("keypress",function(e){		if(e.which==13){ reporte(); }	});


$("#btnCancelar").on("click",function(){
	$("#txtCriador").val("");
	$("#txtPrefijo").val("");
	$("#divResult").html(" <table  class='tbDatoMain'><tr><th><b>Criador</b></th><th><b>Prefijo</b></th></tr></table>");
	$("#divResumen").html("Número de registros encontrados: 0");
});
  
$("#btnVer").on("click",function(){     reporte(); });
$("#btnXls").on("click",function(){     reporte(1); });

});
 

function reporte(isXls){
	if(($("#txtCriador").val().length==0 && $("#txtPrefijo").val().length==0)){
				alertify.error("Para realizar la búsqueda ingrese datos en criador o prefijo.");
	}else{		
				var  param= {opc:'rptPrefCria',nombre:$("#txtCriador").val(),pref:$("#txtPrefijo").val()}
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
 