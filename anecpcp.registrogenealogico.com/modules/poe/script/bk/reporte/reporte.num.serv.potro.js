$(function(){

  var ano = (new Date).getFullYear();
	$("#txtDesde").val(ano-10);
	$("#txtHasta").val(ano);

$("#btnCancelar").on("click",function(){
	var ano = (new Date).getFullYear();
	$("#hidAnioSel").val(0);
	$("#txtDesde").val(ano-10);
	$("#txtHasta").val(ano);
	$("#divResult").html(" <table  class='tbDatoMain'><tr><th><b>A&Ntilde;O POE </b></th>  <th><b>NUM REGISTRO POE  </b></th> <th><b>NUM NACIDO A&Ntilde;O  SIGUIENTE - SGE  </b></th> <th><b>DIFERENCIA %</b></th></tr></table>");
	if(barra!=null)barra.destroy();
	$("#divResumen").html("Número de registros encontrados: 0");

});
  
$("#btnVer").on("click",function(){     
	$("#divResultDet").html("");
    $("#divResumenDet").html(""); 	
    if(barra!=null)barra.destroy();   reporte(); });
 $("#btnXls").on("click",function(){     reporte(1); });
 $("#btnXlsDet").on("click",function(){     reporteDet($("#hidAnioSel").val(),1); });


$("#mvListaDet").on('show.bs.modal', function () {
    $("#divResultDet").html("");
    $("#divResumenDet").html("");
 });


$("#txtNombreDet").on("keypress",function(e){

if(e.which==13){
	reporteDet($("#hidAnioSel").val());
}
})



});
var barra=null;
function fillGrafica(labels,data,bgcolors){
	// Bar chart
var titulo="CONSOLIDADO DE SERVICIO DE POTROS ENTRE POE - SGE ";
																
barra=new Chart(document.getElementById("bar-chart"), {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          label: " % CONCILIADO",
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

function reporte(isXls){
var  param={opc:'rptNumServP',desde:$("#txtDesde").val(),hasta:$("#txtHasta").val()};
															 
		if(isXls!=undefined && isXls==1)  param.xls=1;
				if($("#txtDesde").val()!="" || $("#txtHasta").val()!="" ){


							if(eval($("#txtDesde").val())>eval($("#txtHasta").val())){
								alertify.error("Año desde debe ser menor que año hasta.");
							}else{
										
							$.ajax({
												data:param,
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
																  var i=0;
																  var labels=new Array();
																  var data=new Array();
																  var bgcolors=new Array();
																   $.each(retorno.data,function(indice,valor) {
															        labels[i]=valor.anio;   
															        data[i]=valor.diferencia;
															        bgcolors[i]=coloresHTML();
															         
															         i++;
															      });

															    fillGrafica(labels,data,bgcolors);
														}
													}else{       
			                       						 alertify.error("Ocurrió un error al obtener los datos.");
			                						}
			                					}
											});

							}
							 
				}else{
					alertify.error("Debe ingresar rango de años a buscar.");
				}
		 
}
 
function viewDeta(anio){
	 $("#hidAnioSel").val(anio);
	 $("#mvListaDet").modal("show");
	 $(".modal-title").html("Detalle servicio potros año: "+anio);
	 reporteDet(anio);
}
function reporteDet(ianio,isXls){
var  param={opc:'rptNumServPDet',anio:ianio,nombre:$("#txtNombreDet").val()};
															 
		if(isXls!=undefined && isXls==1)  param.xls=1;
							$.ajax({
												data:param,
												url:   'ajax/ajaxReporte.php',
												type:  'post',
												success:  function (response) {
													var retorno=JSON.parse(response);
													if(retorno.result=="1"){
																if(isXls!=undefined && isXls==1){
																		window.open('data:application/vnd.ms-excel,' + encodeURIComponent(retorno.html));
												                        alertify.success("Datos exportados correctamente.");
																}else{
																	    $("#divResultDet").html(retorno.html);
																	    $("#divResumenDet").html('Número de registros encontrados: ' +retorno.cantidad);
																		  
																}
													}else{       
			                       						 alertify.error("Ocurrió un error al obtener los datos.");
			                						}
			                					}
											});

}
							 
				 
		 
 
 
