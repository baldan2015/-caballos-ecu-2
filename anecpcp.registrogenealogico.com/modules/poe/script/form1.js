var K_PATH_ROOT="../";
$(function(){
 
envioForm(function(response){
				if(response==1){
					$("#btnGrabar").on("click",function(){alertify.log("No se puede grabar. Parte de ocurrencias ya fue enviado")}).button({icons: { primary: "ui-icon-disk" }});
				}else{
					$("#btnGrabar").on("click",function(){ insert(); }).button({icons: { primary: "ui-icon-disk" }});
				}

});	

$("#btnPrint").on("click",function(){ 	viewForm(1,$("#hidIdProp").val(),$("#hidIdPoe").val());}).button({icons: { primary: "ui-icon-print" }});
$("#btnBusEjeUPD").on("click",function(){
	$("#divResultBG").html("");
	$("#divBuscarEjemplar").dialog("open");
}).button({icons: { primary: "ui-icon-search" }});

listarMiPropiedad();
listarMiPropiedadAddon();
$("#btnCancelar").on("click",function(){ listarMiPropiedad(); }).button({icons: { primary: "ui-icon-cancel" }});

$("#divBuscarEjemplar").dialog({
modal:true,
autoOpen:false,
width:600,
height:500,
title:'Búsqueda ejemplar de periodo pasados ',
buttons: {
       
        Cerrar: function() {
          $( this ).dialog( "close" );
        }
      }


});

});

var listarMiPropiedad=function(){
		$.ajax({
				data:  {opc:'lstMov',idPoe:$("#hidIdPoe").val(),idProp:$("#hidIdProp").val()},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario1.php',
				type:  'post',
				success:  function (response) {
					var retorno=JSON.parse(response);
					if(retorno.result=="1"){
					  $("#lblMP").html(retorno.numRow);
				      $("#divResult").html(retorno.html);
				      initCtrolesGrilla();
				    }else{
				    	alertify.error(retorno.message);
				    }
				  //  countTotals();
				     
				}
		});
};
 

var initCtrolesGrilla=function(){
//$('.gridHtml tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });

$('.btnDel').each(function(i, obj) {
	$(obj).on("click",function(){
			var keyDel=$(this).data("key");
  			delRow(obj,keyDel);
	}).button({icons: {primary: "ui-icon-trash"},text: false});
});
$('.btnPorpiedad').each(function(i, obj) {
	
 			if($(obj).data("fin")=="1"){
 				$(obj).on("click",function(){alertify.log("No se puede agregar ejemplar. Parte de ocurrencias ya fue enviado")}).button({icons: { primary: "ui-icon-disk" }});
 			}else{
 	
				if(evaluarModoVigenciaPOE_Grilla(obj,$("#hidVigencia").val(),$("#hidAnioPer").val())){
				     		$(obj).on("click",function(){
     							var codigo=$(obj).data("codigo");
     							var nombre=$(obj).data("nombre");
     							var prefijo=$(obj).data("prefijo");
    							 insertBoton(codigo,prefijo,nombre)
     						 });
				}
			}


}).button();
//});


$('.btnTransferido').each(function(i, obj) {
 			if($(obj).data("fin")=="1"){
 				$(obj).on("click",function(){alertify.log("No se puede registrar transfencia del ejemplar. Parte de ocurrencias ya fue enviado")}).button({icons: { primary: "ui-icon-disk" }});
 			}else{
				if(evaluarModoVigenciaPOE_Grilla(obj,$("#hidVigencia").val(),$("#hidAnioPer").val())){
				     		$(obj).on("click",function(){
     							var codigo=$(obj).data("codigo");
	   							 insertarTransfer(codigo);
     						 });
				}
			}
}).button();

$('.btnCastrado').each(function(i, obj) {
	var ArrayCode=$(obj).data("codigo").split(".");
	var genero="H";
	if(ArrayCode!=undefined){
		if(ArrayCode.length==4){
			var num=ArrayCode[3];
			console.log(num);
			if(eval(num)%2!=0){
				genero="M";
			}

		}
	}
	console.log(genero);
	if(genero!="M"){
		$(obj).prop("disabled",true);
		$(obj).prop("title","Sólo ejemplar macho se puede castrar.");
	}
	/*if($(obj).data("codigo").indexOf("CN")!=-1 || $(obj).data("codigo").indexOf("Y")!=-1){
		$(obj).prop("disabled",true);
	}*/
 			if($(obj).data("fin")=="1"){
 				$(obj).on("click",function(){alertify.log("No se puede registrar castración del ejemplar. Parte de ocurrencias ya fue enviado")}).button({icons: { primary: "ui-icon-disk" }});
 			}else{
				if(evaluarModoVigenciaPOE_Grilla(obj,$("#hidVigencia").val(),$("#hidAnioPer").val())){
				     		$(obj).on("click",function(){
     							var codEjemplar=$(obj).data("codigo");
    							 insertarMuerteCastrado(codEjemplar,"CA");
     						 });
				}
			}
}).button();

$('.btnFallecio').each(function(i, obj) {
 			if($(obj).data("fin")=="1"){
 				$(obj).on("click",function(){alertify.log("No se puede registrar fallecimiento del ejemplar. Parte de ocurrencias ya fue enviado")}).button({icons: { primary: "ui-icon-disk" }});
 			}else{
				if(evaluarModoVigenciaPOE_Grilla(obj,$("#hidVigencia").val(),$("#hidAnioPer").val())){
				     		$(obj).on("click",function(){
     							var codEjemplar=$(obj).data("codigo");
     							insertarMuerteCastrado(codEjemplar,"FA");
     						 });
				} 
			}
}).button();

}

function countRowDetails() {
    var fila = 1;
    $(".gridHtml tbody tr ").each(function (index, value) { fila = fila + 1; });
    return fila;
}

function insert(){

alertify.confirm("Está seguro de registrar los ejemplares?", function (e) {
if (e) {
			var fila=countRowDetails();
			fila=(fila-1);
			var param="";
			var collection=Array();
			
					$('.gridHtml tbody tr:has(input)').each(function(index, value) {
					var inputName = "";
					var values = "";
					var movimiento={codEjemplar:'',prefijo:'',ejemplar:'',esNuevo:''};
					

					var isCheck=false;
						$('.cssItem ', this).each(function() {

								inputName =  $(this).attr("id");
						  		values =  $(this).val(); 
						  		 
								if(inputName.indexOf('rdbtnA_')!=-1) {
									isCheck=$(this).prop("checked")	;
									 
								}
								if(isCheck){
							  		if(inputName.indexOf('hidRegistro_')!=-1) movimiento.codEjemplar=values;
									if(inputName.indexOf('txtRegistro_')!=-1) movimiento.codEjemplar=values;
									if(inputName.indexOf('txtPrefijo_')!=-1) movimiento.prefijo=values;
									if(inputName.indexOf('hidPrefijo_')!=-1) movimiento.prefijo=values;
									if(inputName.indexOf('txtEjemplar_')!=-1) movimiento.ejemplar=values;
									if(inputName.indexOf('hidEjemplar_')!=-1) movimiento.ejemplar=values;
									if(inputName.indexOf('txtEsNuevo_')!=-1) movimiento.esNuevo=values;
								} 

						});
					if(isCheck) collection.push(movimiento);

					 

					});

					if(collection.length==0){
						 $.ajax({
							data:  {opc:'delAll',idPoe:$("#hidIdPoe").val(),idUser:$("#hidIdProp").val()},
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario1.php',
							type:  'post',
							success:  function (response) {
								 	var retorno=JSON.parse(response);
								 		var retorno=JSON.parse(response);
									if(retorno.result==1){
										alertify.success("Información actualizada");
									}else{
										alertify.error(retorno.message);
									}
									 
							}
						}); 
					}else{
					    
						datos=JSON.stringify(collection);
						$.ajax({
							data:  {opc:'insMov',idPoe:$("#hidIdPoe").val(),idUser:$("#hidIdProp").val(),data:datos},
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario1.php',
							type:  'post',
							success:  function (response) {
									var retorno=JSON.parse(response);
									if(retorno.result==1){
										//$("#divResult").html(retorno.html);
							    		//initCtrolesGrilla();
						    			listarMiPropiedad();
							    		alertify.success(retorno.message);
									}else if(retorno.result==0){
										alertify.error(retorno.message);
									}else if(retorno.result==2){
										listarMiPropiedad();
										alertify.alert(retorno.message);
									}
							}
						});
					}
  		}
	});
}

function eliminar(id,callback){
	 
					 $.ajax({
							data:  {opc:'delMov',id:id},
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario1.php',
							type:  'post',
							success:  function (response) {
								 	var retorno=JSON.parse(response);
								 		callback({result:true});
									 
							}
						}); 
}
var envioForm=function(retorno){
	
		$.ajax({
				data:  {alt:'get'},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxEnvio.php',
				type:  'post',
				success:  function (response) {
				 console.log(response);
				  retorno(response);
				     
				}
		});
		return retorno;
};
/*
function countTotals() {
var filaSel=0;
var filaNoSel=0;
var total=0;
				$('.gridHtml tbody tr:has(input)').each(function(index, value) {
					var inputName = "";
					var values = "";
					var isCheck=false;
							$('.cssRbtn', this).each(function() {
								inputName =  $(this).attr("id");
								if(inputName.indexOf('rdbtnA_')!=-1)  isCheck=$(this).prop("checked")	;
							});
							 if(isCheck)filaSel++;
							 else filaNoSel++;
							total++;
						 
					});
$("#lblTotalEjSel").html(filaSel);
$("#lblTotalEjNoSel").html(filaNoSel);
$("#lblTotalEj").html(total);

}
*/

function insertBoton(codigo,prefijo,nombre){


var movimiento={};
var collection=Array();
	movimiento.codEjemplar=codigo;
	movimiento.prefijo=prefijo;
	movimiento.ejemplar=nombre;
	movimiento.esNuevo="h";
collection.push(movimiento);
///console.log(movimiento);
					if(collection.length==0){
						 $.ajax({
							data:  {opc:'delAll',idPoe:$("#hidIdPoe").val(),idUser:$("#hidIdProp").val()},
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario1.php',
							type:  'post',
							success:  function (response) {
								 	var retorno=JSON.parse(response);
								 		var retorno=JSON.parse(response);
									if(retorno.result==1){
										alertify.success("Información actualizada");
									}else{
										alertify.error(retorno.message);
									}
									 
							}
						}); 
					}else{
					    
						datos=JSON.stringify(collection);
						$.ajax({
							data:  {opc:'insMov',idPoe:$("#hidIdPoe").val(),idUser:$("#hidIdProp").val(),data:datos,insTipo:2},
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario1.php',
							type:  'post',
							success:  function (response) {
									var retorno=JSON.parse(response);
									if(retorno.result==1){
						    			listarMiPropiedad();
						    			listarMiPropiedadAddon();
							    		alertify.success(retorno.message);
									}else if(retorno.result==0){
										alertify.error(retorno.message);
									}else if(retorno.result==2){
										listarMiPropiedad();
										alertify.alert(retorno.message);
									}
							}
						});
					}
  		 
	 
}
var listarMiPropiedadAddon=function(){
		$.ajax({
				data:  {opc:'lstMineAdd',idPoe:$("#hidIdPoe").val(),idProp:$("#hidIdProp").val()},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario1.php',
				type:  'post',
				success:  function (response) {
					var retorno=JSON.parse(response);
					if(retorno.result=="1"){
					  $("#lblMPC").html(retorno.numRow);
				      $("#divResultSel").html(retorno.html);
				      initCtrolesGrillaSel();
				    }else{
				    	alertify.error(retorno.message);
				    }

				     
				     
				}
		});
}; 
var initCtrolesGrillaSel=function(){
$('.gridHtmlSel tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });

$('.btnQuitar').each(function(i, obj) {
	if($(obj).data("fin")=="1"){
 				$(obj).on("click",function(){alertify.log("No se puede quitar ejemplar. Parte de ocurrencias ya fue enviado")}).button({icons: { primary: "ui-icon-disk" }});
 			}else{
					if(evaluarModoVigenciaPOE_Grilla(obj,$("#hidVigencia").val(),$("#hidAnioPer").val())){
						     	$(obj).on("click",function(){
		     							var codigo=$(obj).data("id");
			   							eliminar(codigo,function(response){ 
		    								if(response.result){
		    									listarMiPropiedad();
												listarMiPropiedadAddon();
		    								}
										}); 
		  						 });
				    }
		}
}).button({icons: {primary: "ui-icon-trash"},text: true});
//});
}
 
function insertarTransfer(codEjemplar){
var collection=Array();
var transterencia={};

transterencia.tipo='T';
transterencia.fecha="X";
transterencia.nomContacto="-";
transterencia.codEjemplar=codEjemplar;
collection.push(transterencia);

	if(collection.length==0){
		alertify.error("No hay datos para grabar");
	}else{
		datos=JSON.stringify(collection);
		$.ajax({
			data:  {opc:'insMov',idPoe:$("#hidIdPoe").val(),idUser:$("#hidIdProp").val(),data:datos},
			url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario5.php',
			type:  'post',
			success:  function (response) {
					var retorno=JSON.parse(response);
					if(retorno.result==1){
						listarMiPropiedad();
			    		alertify.success("Transterencia registrado correctamente.");
					}else if(retorno.result==0){
						alertify.error(retorno.message);
					}else if(retorno.result==2){
						alertify.alert(retorno.message);
					}
			}
		});
	}

}


function insertarMuerteCastrado(codEjemplar,tipo){
var collection=Array();
var historial2={};
historial2.tipo=tipo;
historial2.fecha="X";
historial2.codEjemplar=codEjemplar;
collection.push(historial2);

	if(collection.length==0){
		alertify.error("No hay datos para grabar");
	}else{
		datos=JSON.stringify(collection);

		if(historial2.tipo=='CA'){
			validarCastrado(codEjemplar,$("#hidIdPoe").val(),$("#hidIdProp").val(),function(retorno){
				if(retorno=="1"){
					$.ajax({
								data:  {opc:'ins',idPoe:$("#hidIdPoe").val(),idUser:$("#hidIdProp").val(),data:datos},
								url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario7.php',
								type:  'post',
								success:  function (response) {
										var retorno=JSON.parse(response);
										if(retorno.result==1){
											listarMiPropiedad();
								    		alertify.success(tipo=='FA'?'Fallecimiento registrado correctamente.':'Castración registrada correctamente.');
										}else if(retorno.result==0){
											alertify.error(retorno.message);
										}else if(retorno.result==2){
											alertify.alert(retorno.message);
										}
								}
							});
				}else{
					alertify.error("El ejemplar ya se encuentra castrado.");
				}
			});
		}else{

			$.ajax({
						data:  {opc:'ins',idPoe:$("#hidIdPoe").val(),idUser:$("#hidIdProp").val(),data:datos},
						url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario7.php',
						type:  'post',
						success:  function (response) {
								var retorno=JSON.parse(response);
								if(retorno.result==1){
									listarMiPropiedad();
						    		alertify.success(tipo=='FA'?'Fallecimiento registrado correctamente.':'Castración registrada correctamente.');
								}else if(retorno.result==0){
									alertify.error(retorno.message);
								}else if(retorno.result==2){
									alertify.alert(retorno.message);
								}
						}
					});

		}



		
	}

}

function validarCastrado(codEjemplar,idPoe,idUser,callback){
 		$.ajax({
			data:  {opc:'valCastrado',idPoe:idPoe,idUser:idUser,codEjemplar:codEjemplar},
			url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario7.php',
			type:  'post',
			success:  function (response) {
					callback(response);
			}
		});
	 
return callback;
}
