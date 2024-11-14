$(function(){
$("#txtCriador").on("keypress",function(e){	if(e.which == 13)reporte1();});  
$("#btnBuscar").on("click",function(){		reporte1(); }).button();
var ano = (new Date).getFullYear();
	$("#txtDesde").val(ano-10);
	$("#txtHasta").val(ano);
$("#btnLimpiar").on("click",function(){
	var ano = (new Date).getFullYear();
	$("#txtDesde").val(ano-10);
	$("#txtHasta").val(ano);
	$("#txtCriador").val("");
	$("#divResult").html("");
}).button();
  
  

});

function reporte1(){
if($("#txtCriador").val().length==0 || $("#txtCriador").val().length<4){
		alertify.error("Para realizar la busqueda ingrese 4 digitos del Criador");
}else{	
			if($("#txtDesde").val()!="" || $("#txtHasta").val()!="" ){
				if(eval($("#txtDesde").val())>eval($("#txtHasta").val())){
					alertify.error("Año desde debe ser menor que año hasta.");
				}else{
						$.ajax({
										data:  {opc:'rpt1',
												desde:$("#txtDesde").val(),
												hasta:$("#txtHasta").val(),
												criador:$("#txtCriador").val()
											},
										url:   'ajaxPOE/ajaxReporte.php',
										type:  'post',
										success:  function (response) {
										    $("#divResult").html(response);
										}
								});

				}
			}else{
				alertify.error("Debe ingresar años de nacimiento:  Desde - Hasta.");
			}
}
}