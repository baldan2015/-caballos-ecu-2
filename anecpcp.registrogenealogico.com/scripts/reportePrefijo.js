$(function(){
$("#txtCriador").on("keypress",function(e){	if(e.which == 13)reportePrefijo(0);});  
$("#btnBuscar").on("click",function(){		reportePrefijo(0); }).button();

$("#btnLimpiar").on("click",function(){
	$("#txtCriador").val("");
	$("#divResult").html("");
}).button();
$("#btnExcel").on("click",function(){
	 reportePrefijo(1);
}).button();
  

});

function reportePrefijo(esXls){

	var param={opc:'rptPrefijo',criador:$("#txtCriador").val(),xls:0};
	if(esXls!="1"){
	 	param.xls=0;
	}else{
		param.xls=1;
	}
			$.ajax({
							data:param,
							url:   'ajaxPOE/ajaxReporte.php',
							type:  'post',
							success:  function (response) {
								if(param.xls!="1"){
							    	$("#divResult").html(response);
							    }else{	
							    	window.open('data:application/vnd.ms-excel,' + encodeURIComponent(response));
								}
							}
					});

	 
}