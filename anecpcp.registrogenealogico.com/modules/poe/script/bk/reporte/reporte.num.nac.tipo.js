$(function(){

  var ano = (new Date).getFullYear();
	$("#txtDesde").val(ano-10);
	$("#txtHasta").val(ano);

$("#btnCancelar").on("click",function(){
	var ano = (new Date).getFullYear();
	$("#txtDesde").val(ano-10);
	$("#txtHasta").val(ano);
	$("#divResult").html(" <table  class='tbDatoMain'><tr><th><b>AÑO</b></th><th><b>CANTIDAD</b></th></tr></table>");
	if(barra!=null)barra.destroy();
	$("#ddlMetodo").val(5).selectpicker('refresh');
	$("#divResumen").html("Número de registros encontrados: 0");

});
  
$("#btnVer").on("click",function(){  	if(barra!=null)barra.destroy();   reporte(); });
$("#btnXls").on("click",function(){     reporteXls(); });
listarMetodoReprop("ddlMetodo","SELECCIONE",5);






});
var barra=null;
function fillGrafica(labels,data,bgcolors){
	// Bar chart
var titulo="Nacidos bajo el método: "+ $("#ddlMetodo  option:selected").text()+ " Desde "+ $("#txtDesde").val()+" hasta "+$("#txtHasta").val();
																
barra=new Chart(document.getElementById("bar-chart"), {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          label: "Cantidad nacidos",
          backgroundColor: bgcolors,
          data: data 
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: titulo
      }
    }
});
}

function reporte(){
		if($("#ddlMetodo").val()=="SELECCIONE"){
				alertify.error("Seleccione el método reproductor.");
		}else{		
				if($("#txtDesde").val()!="" || $("#txtHasta").val()!="" ){
							if(eval($("#txtDesde").val())>eval($("#txtHasta").val())){
								alertify.error("Año desde debe ser menor que año hasta.");
							}else{
										$.ajax({
														data:  {opc:'rptNumNacTipo',
																desde:$("#txtDesde").val(),
																hasta:$("#txtHasta").val(),
																metodo:$("#ddlMetodo").val()
															},
														url:   'ajax/ajaxReporte.php',
														type:  'post',
														success:  function (response) {
															var retorno=JSON.parse(response);
														    $("#divResult").html(retorno.html);
														    $("#divResumen").html('Número de registros encontrados: ' +retorno.cantidad);

														  var i=0;
														  var labels=new Array();
														  var data=new Array();
														  var bgcolors=new Array();
														   $.each(retorno.data,function(indice,valor) {
													        labels[i]=valor.anio;   
													        data[i]=valor.cantidad;
													        bgcolors[i]=coloresHTML();
													         
													         i++;
													      });

														    fillGrafica(labels,data,bgcolors);
														}
												});
							}
				}else{
					alertify.error("Debe ingresar años de inscripción:  Desde - Hasta.");
				}
		}
}
function reporteXls(){

		if($("#ddlMetodo").val()=="SELECCIONE"){
				alertify.error("Seleccione el método reproductor.");
		}else{		
				if($("#txtDesde").val()!="" || $("#txtHasta").val()!="" ){
							if(eval($("#txtDesde").val())>eval($("#txtHasta").val())){
								alertify.error("Año desde debe ser menor que año hasta.");
							}else{
										$.ajax({
														data:  {opc:'rptNumNacTipo',
																desde:$("#txtDesde").val(),
																hasta:$("#txtHasta").val(),
																metodo:$("#ddlMetodo").val(),
																metodoDes:$("#ddlMetodo  option:selected").text(),
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