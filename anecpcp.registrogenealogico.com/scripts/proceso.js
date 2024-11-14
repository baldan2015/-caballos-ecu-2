var load="<div><br><br> Procesando, espere por favor...<div style='float:right;margin-top:-10px;margin-left:310px;'><img src='img/loader.gif'></div></div>";
var loadLst="<div><img src='img/loader.gif'></div>";
var K_TOKEN_NAME="Authorization";
$(function(){
	$(".eje").click("on", function() {
        document.location.href = "profile.php";
      });
	listarNovedades();
	$("#txtdato1").focus();
 	$("#divVerArbol").dialog({
				title:"Arbol Genealógico",
				autoOpen:false,
				width:1000,
				height:680,modal:true,
				position: {
				            my: 'top', 
				            at: 'top'
				    }
	});
	$("#divVerConcurso").dialog({
				title:"Resultado de Concurso",
				autoOpen:false,
				width:800,
				height:640,modal:true,
				position: {
				            my: 'top', 
				            at: 'top'
				    }
	});
	$("#divVerCrias").dialog({
				title:"Crias de Ejemplares",
				autoOpen:false,
				width:800,
				height:640,modal:true,
				position: {
				            my: 'top', 
				            at: 'top'
				}
	});

	$("#divVerImagen .ui-dialog-titlebar").hide();

	$("#btnBuscar").on("click",function(){Buscar();	 return false;}).button({icons: {primary: 'ui-icon-search'}});
	$("#txtdato1").on("keypress",function(e){$("#txtdato2").val('');iniciarBusqueda(e)});
	$("#txtdato2").on("keypress",function(e){$("#txtdato1").val('');iniciarBusqueda(e)});
	$("#btnBuscarResult").on("click",function(){

		var param={
			idConcurso:$("#ddlConcurso").val(),
			idCatego:$("#ddlCategoria").val(),
			idGrupo:$("#ddlGrupo").val()
		};

		if(param.idConcurso==-1 || param.idCatego==-1 ){
			$("#divResultConcurso").html("<center><div style='color:darkred;font-size:12px;margin-top:100px;'>La lista desplegable de concursos y categorias son datos obligatorios.</div></center>");
		}else{

					$.ajax({
					    type: "POST",
					    data:param,
					    url: "ajaxConcursoGral.php",
					    success:  function (response) { 
					  					   $("#divResultConcurso").html(response);
									},
						beforeSend: function () {
									    $("#divResultConcurso").html(load);
									},				
						error: function(jqXHR, textStatus, errorThrown) {
					                console.log('jqXHR:');
					                console.log(jqXHR);
					                console.log('textStatus:');
					                console.log(textStatus);
					                console.log('errorThrown:');
					                console.log(errorThrown);
					            }
					});
				}

				return false;
	}).button({icons: {primary: 'ui-icon-search'}});;

	
});

 function viewArbol(idHorse){
 			//var url="arbolgen.php?id="+idHorse;
			//$( "#resultadoArbol" ).load(url);
			$.ajax({
				data:  {id:idHorse},
				url:   'arbolgen.php',
				type:  'get',
				beforeSend: function () {
				     $("#resultadoArbol").html(load);
				},
				success:  function (response) {
				    $( "#resultadoArbol").html(response);

				}
			});
 }
 function viewDetaCria(url){			$( "#crias" ).load(url); }
function listarImagenes(idEjemplar,xpagina,opc,idImg){ 

		opc=(opc==undefined?"":opc);
		$.ajax({
				data:  {idhorse:idEjemplar,pagina:xpagina,opc:opc,idImg:idImg},
				url:   'upload/galeria.php',
				type:  'post',
				beforeSend: function () {
				    $("#galeria").html(load);
				},
				success:  function (response) {
					$("#galeria").slideDown("slow");
				    $("#galeria").html(response);
				}
		});

		return false;

}

 function cerrarGaleria(){$("#divVerImagen").dialog("close"); return false; }

function detailSearch(idHorse,param){
   
 
	var idElemento=idHorse.replace(/\./g,'');
 

	$( ".filaSel" ).each(function( index ){
  			$(this).removeClass("ui-dialog-titlebar ui-widget-header");
  	});
	$("#filaSel_"+idElemento).addClass("ui-dialog-titlebar ui-widget-header");

	$( ".detaRow" ).each(function( index ){
  			$(this).css({display:'none'});
  	});
	$('#tr_'+idElemento).show(); //'"'+'#div_'+idHorse+'"'
	$('#div_'+idElemento).show();//.css({display:'inline'}); "#div_"+idHorse

if(param==undefined){
	$.ajax({
				data:  {idHorse:idHorse},
				url:   'ajaxDetalleEjemplar.php',
				type:  'POST',
				beforeSend: function () {
				    $("#div_"+idElemento).html(load);
				},
				success:  function (response) { 
				    $("#div_"+idElemento).html(response);
				}
			});
}
if(param!=undefined){		listarDetalleProp(idHorse,param);	}
 


}

function listarDetalleProp(idProp,param){

 $( ".filaSel" ).each(function( index ){
  			$(this).removeClass("ui-dialog-titlebar ui-widget-header");
  	});
	$("#filaSel_"+idProp).addClass("ui-dialog-titlebar ui-widget-header");

	$( ".detaRow" ).each(function( index ){
  			$(this).css({display:'none'});
  	});
	$("#tr_"+idProp).show();//css({display:'inline'});
	$("#div_"+idProp).show();//.css({display:'inline'});


				loadDetaProp(idProp,'1',param,function(retorno){

				    	$("#div_"+idProp).html(retorno.html);
				     	html=retorno.html;
				     	
							loadDetaProp(idProp,'2',param,function(retorno){
						    	html=html+retorno.html;
								$("#div_"+idProp).html(html);

								//transferidos solo es para Propietarios.	
/*								if(param=="2"){
										loadDetaProp(idProp,'3',param,function(retorno){
											html=html+retorno.html;;
											$("#div_"+idProp).html(html);

											loadDetaProp(idProp,'4',param,function(retorno){
												html=html+retorno.html;;
												$("#div_"+idProp).html(html);

												loadDetaProp(idProp,'5',param,function(retorno){
													html=html+retorno.html;;
													$("#div_"+idProp).html(html);
												}); 

											});
										});

								}	
*/

							});	
					});	

/*
	$.ajax({
				data:  {idProp:idProp,origen:'1',opc:param},
				url:   "ajaxDetalleProp.php",
				type:  'GET',
				beforeSend: function () {
				    $("#div_"+idProp).html(load);
				},
				success:  function (response) { 
				    $("#div_"+idProp).html(response);
				     html=response;
						$.ajax({
								data:  {idProp:idProp,origen:'2',opc:param},
								url:   "ajaxDetalleProp.php",
								type:  'GET',
								success:  function (response) { 
										html=html+response;
										$("#div_"+idProp).html(html);
										if(param=="2"){
											    $.ajax({
															data:  {idProp:idProp,origen:'3',opc:param},
															url:   "ajaxDetalleProp.php",
															type:  'GET',
															success:  function (response) { 
															    html=html+response;
															    $("#div_"+idProp).html(html);
													  
															}
													});
											}
								}
						});

				}
			}); */


}
 

 function iniciarBusqueda(e) {
    var target = (e.target ? e.target : e.srcElement);
    var key = (e ? e.keyCode || e.which : window.event.keyCode);
    if (key == 13){
    	Buscar();
    } 
}

function detailSearchSub(idHorse,param){

	var idElemento=idHorse.replace(/\./g,'');

	$( ".filaSelSub" ).each(function( index ){
  			$(this).removeClass("ui-dialog-titlebar ui-widget-header");
  	});
	$("#filaSelSub_"+idElemento).addClass("ui-dialog-titlebar ui-widget-header");

	$( ".detaRowSubSub" ).each(function( index ){
  			$(this).css({display:'none'});
  	});
	$("#tr_"+idElemento).show();//.css({display:'inline'});
	$("#div_"+idElemento).show();//.css({display:'inline'});
  
	$.ajax({
				data:  {idHorse:idHorse},
				url:   'ajaxDetalleEjemplar.php',
				type:  'POST',
				beforeSend: function () {
				    $("#div_"+idElemento).html(load);
				},
				success:  function (response) { 
				    $("#div_"+idElemento).html(response);
				}
			});

 


}


function listarConcurso(){
$.ajax({
    type: "POST",
    url: "ajaxConcursoList.php",
    success:  function (response) { 
  					   $("#lstConcurso").html(response);
				},
	beforeSend: function () {
				    $("#lstConcurso").html(loadLst);
				},					
	error: function(jqXHR, textStatus, errorThrown) {
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
});
  

}

function listarCategoXConcurso(idConcurso){
$.ajax({
    type: "POST",
    data:{id:idConcurso},
    url: "ajaxCategoriaList.php",
    success:  function (response) { 
  					   $("#lstCategoria").html(response);
				},
	beforeSend: function () {
				    $("#lstCategoria").html(loadLst);
				},				
	error: function(jqXHR, textStatus, errorThrown) {
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
});
  

}
function listarGrupoXCatego(idCatego){
$.ajax({
    type: "POST",
    data:{id:idCatego},
    url: "ajaxGrupoList.php",
    success:  function (response) { 
  					   $("#lstGrupo").html(response);
				},
	beforeSend: function () {
				    $("#lstGrupo").html(loadLst);
				},				
	error: function(jqXHR, textStatus, errorThrown) {
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
});
  

}


function deplegarMuerto(idConcat){
//alert(idConcat);
    	  var controlPlusMinus="imgExpand_"+idConcat;

			if ($("#"+controlPlusMinus).attr("src")=="img/minus.png") {
				$("#tbody_"+idConcat).hide();
				$("#thead_"+idConcat).hide();
				$("#"+controlPlusMinus).attr("src","img/plus.png");
				$("#"+controlPlusMinus).attr("title","ver lista");
				 
			} else {
				$("#tbody_"+idConcat).show();
				$("#thead_"+idConcat).show();
				$("#"+controlPlusMinus).attr("src","img/minus.png");
				$("#"+controlPlusMinus).attr("title","ocultar lista");
				 
			}
			return false;
 

}

 
  
function loadDetaProp(idProp,origen,param,callback)						{
	var obj={};
$.ajax({
		data:  {idProp:idProp,origen:origen,opc:param},
		url:   "ajaxDetalleProp.php",
		type:  'GET',
		beforeSend: function () {
				    $("#div_"+idProp).html(load);
				},
		success:  function (response) { 
			obj.html=response;
			//console.log(response);
			callback(obj);
		}
});
	return callback;
} 
function listarNovedades(){
	$.ajax({
			  data:  {opc:'lstNov',idProp:$("#hidIdProp").val()},
			  url:   'modules/poe/services/ejemplarService.php',
			  type:  'POST',
			  beforeSend: function(request) {
				request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
			  },
			  success:  function (response) {
				  var retorno=JSON.parse(response);
				  if(retorno.result=="1"){
						  var data=retorno.data;
						   
						  $("#cantMisEjemplares").html(data.cantMisEjemplares);
				  }else{
					  alertify.error(retorno.message);
				  }
			  },
		complete: function() {
				ajaxindicatorstopB();
	  }
	  });
}
function ajaxindicatorstopB() {
	jQuery('#resultLoading .bg').height('100%');
	jQuery('#resultLoading').fadeOut(200);
	jQuery('body').css('cursor', 'default');
}