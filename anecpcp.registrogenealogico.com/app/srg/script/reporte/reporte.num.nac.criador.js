$(function(){
	$("#txtCriador").focus();
  var ano = (new Date).getFullYear();
	$("#txtDesde").val(ano-10);
	$("#txtHasta").val(ano);
	$("#txtCriador").on("keypress",function(e){		
	if(e.which == 13)reporte2();
	});

$("#btnCancelar").on("click",function(){
	var ano = (new Date).getFullYear();
	$("#txtDesde").val(ano-10);
	$("#txtHasta").val(ano);
	$("#txtCriador").val("");
	$("#txtCriador").focus();
	$("#divResult").html(" <table  class='tbDatoMain'><tr><th><b>CRIADOR</b></th><th><b>PREFIJO</b></th><th ><b> AÑOS / CANTIDAD  </b></th><th><b>Total</b></th></tr></table>");
});
  
$("#btnVer").on("click",function(){     reporte2(); });
$("#btnXls").on("click",function(){     reporte2Xls(); });

});



function reporte2(){
		if($("#txtCriador").val().length==0 || $("#txtCriador").val().length<4){
				alertify.error("Para realizar la busqueda ingrese 4 digitos del Criador.");
		}else{		
				if($("#txtDesde").val()!="" || $("#txtHasta").val()!="" ){
					if(eval($("#txtDesde").val())>eval($("#txtHasta").val())){
						alertify.error("Año desde debe ser menor que año hasta.");
					}else{
								$.ajax({
												data:  {opc:'rptNumNacCriador',
														desde:$("#txtDesde").val(),
														hasta:$("#txtHasta").val(),
														nombre:$("#txtCriador").val()
													},
												url:   'ajax/ajaxReporte.php',
												type:  'post',
												success:  function (response) {
													var retorno=JSON.parse(response);
												    $("#divResult").html(retorno.html);
												    $("#divResumen").html('Número de registros encontrados: ' +retorno.cantidad);
												}
										});
				}
				}else{
					alertify.error("Debe ingresar años de inscripción:  Desde - Hasta.");
				}
		}
}
function reporte2Xls(){
	if($("#txtCriador").val().length==0 || $("#txtCriador").val().length<4){
				alertify.error("Para realizar la exportación de los datos ingrese 4 digitos del Criador.");
		}else{		
				if($("#txtDesde").val()!="" || $("#txtHasta").val()!="" ){
					if(eval($("#txtDesde").val())>eval($("#txtHasta").val())){
						alertify.error("Año desde debe ser menor que año hasta.");
					}else{
								$.ajax({
												data:  {opc:'rptNumNacCriador',
														desde:$("#txtDesde").val(),
														hasta:$("#txtHasta").val(),
														nombre:$("#txtCriador").val(),
														xls:1
													},
												url:   'ajax/ajaxReporte.php',
												type:  'post',
												success:  function (response) {
													var resultado= JSON.parse(response) ;
				                                    if(resultado.result=="1"){
				                                            window.open('data:application/vnd.ms-excel,' + encodeURIComponent(resultado.html));
				                                               alertify.success("Datos exportados correctamente.");
				                                        }
				                                         else       
				                                            alertify.error("Ocurrió un error al exportar los datos.");
				                                    }
													 
										});
				}
				}else{
					alertify.error("Debe ingresar años de inscripción:  Desde - Hasta.");
				}
		}
  
 }