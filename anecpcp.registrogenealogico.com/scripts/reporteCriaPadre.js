$(function(){
$("#txtCriador").on("keypress",function(e){	if(e.which == 13)reporte1();});  
$("#btnBuscar").on("click",function(){		reporte1(); }).button();

$("#btnLimpiar").on("click",function(){
	$("#txtDesde").val("2000");
	$("#txtHasta").val("2018");
	$("#txtCriador").val("");
	$("#divResult").html("");
}).button();
  

});

function reporte1(){

			if($("#txtDesde").val()!="" || $("#txtHasta").val()!="" ){
				if(eval($("#txtDesde").val())>eval($("#txtHasta").val())){
					alertify.error("Año desde debe ser menor que año hasta.");
				}else{
						$.ajax({
										data:  {opc:'rptCriaPadre',
												desde:$("#txtDesde").val(),
												hasta:$("#txtHasta").val(),
												ejemplar:$("#txtCriador").val()
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