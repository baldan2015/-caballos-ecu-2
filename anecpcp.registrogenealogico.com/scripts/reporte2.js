$(function(){
  var ano = (new Date).getFullYear();
	$("#txtDesde").val(ano-10);
	$("#txtHasta").val(ano);
$("#btnBuscar").on("click",function(){		reporte2();}).button();
$("#txtCriador").on("keypress",function(e){		
	if(e.which == 13)reporte2();
});

$("#btnLimpiar").on("click",function(){
	var ano = (new Date).getFullYear();
	$("#txtDesde").val(ano-10);
	$("#txtHasta").val(ano);
	$("#txtCriador").val("");
	$("#divResult").html("");
}).button();
  

});

function reporte2(){
		if($("#txtCriador").val().length==0 || $("#txtCriador").val().length<4){
				alertify.error("Para realizar la busqueda ingrese 4 digitos del propietario");
		}else{		
				if($("#txtDesde").val()!="" || $("#txtHasta").val()!="" ){
					if(eval($("#txtDesde").val())>eval($("#txtHasta").val())){
						alertify.error("Año desde debe ser menor que año hasta.");
					}else{
								$.ajax({
												data:  {opc:'rpt2',
														desde:$("#txtDesde").val(),
														hasta:$("#txtHasta").val(),
														prop:$("#txtCriador").val()
													},
												url:   'ajaxPOE/ajaxReporte.php',
												type:  'post',
												success:  function (response) {
												    $("#divResult").html(response);
												}
										});
				}
				}else{
					alertify.error("Debe ingresar años de inscripción:  Desde - Hasta.");
				}
		}
}