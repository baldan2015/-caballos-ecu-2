$(function(){

misEjemplares("","","");
listarConcurso();
initEventoFiltro();

$("#mvCategorias").dialog({
modal:true,
autoOpen:false,
width:450,
height:250,
title:'Selección de participación en premio especial',
buttons: {
        "Seleccionar": function() {
          addInscripcionCatego();
        },
        Cerrar: function() {
          $( this ).dialog( "close" );
        }
      },
      my: "center",
   at: "top",
   of: window


});
$("#mvFinal").dialog({
modal:true,
autoOpen:false,
width:800,
height:530,
title:'CONFIRMACION DE INSCRIPCION',
buttons: {
        "Aceptar": function() {
          registrarInscripcion();
        },
        Cerrar: function() {
          $( this ).dialog( "close" );
        }
      },
      my: "center",
   at: "top",
   of: window
});

$("#btnCancelar").on("click",function(){limpiarTmp();}).button();
$("#btnConfirmar").on("click",function(){preview();}).button();

});



function misEjemplares(prefijo,nombre,codigo){
	$.ajax({
				data:  {opc:'lstMiProp',idPoe:0,idProp:0,pref:prefijo,nomb:nombre,code:codigo},
				url:   'ajaxPOE/ajaxInscripcion.php',
				type:  'POST',
				success:  function (response) {
					$(".gridHtml tbody").html("");
				    $(".gridHtml tbody").append(response);
				    initCtrolesGrilla();
				}
		});
}
var loadLst="<div><img src='img/loader.gif'></div>";
function listarConcurso(){
$.ajax({
    type: "POST",
    url: "ajaxConcursoListB.php",
    success:  function (response) { 
  					   $("#lstConcurso").html(response);
  					   $("#ddlConcurso").prop('selectedIndex', 1);
  					   listarCategoXConcurso();
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
function listarCategoXConcurso(){
	limpiarTmp();
	printDetaConcurso();
	printHtmlPremios();


 
}

function initEventoFiltro(){
$('#filterGrillaPref').on('keyup', function(event) {
	$('#filterGrillaNom').val("");
	$('#filterGrillaCode').val("");
	misEjemplares($(this).val(),"","");
});
$('#filterGrillaNom').on('keyup', function(event) {
	$('#filterGrillaPref').val("");
	$('#filterGrillaCode').val("");
	misEjemplares("",$(this).val(),"");
});
$('#filterGrillaCode').on('keyup', function(event) {
	$('#filterGrillaPref').val("");
	$('#filterGrillaNom').val("");
	misEjemplares("","",$(this).val());
});

$('.lblClearFilter').on("click",function(){
	$('#filterGrillaPref').val("");
	$('#filterGrillaNom').val("");
	$('#filterGrillaCode').val("");
	misEjemplares("","","");
});
}
var initCtrolesGrilla=function(){
$('.gridHtml tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
$('.btnGen').each(function(i, obj) {
	$(obj).on("click",function(){
			$("#hidIdEjemplar").val($(this).data("key"));
			$("#hidNombreEjemplar").val($(this).data("nombre"));
			$("#hidPrefijoEjemplar").val($(this).data("prefijo"));

  		    addInscripcion();
	}).button();//{icons: {primary: "ui-icon-circle-plus"},text: true});
});
 $('.btnCat').each(function(i, obj) {
	$(obj).on("click",function(){
			
			$("#hidIdEjemplar").val($(this).data("key"));
			$("#hidNombreEjemplar").val($(this).data("nombre"));
			$("#hidPrefijoEjemplar").val($(this).data("prefijo"));
  		    getCategoria($(this).data("key"),$(this).data("capado")); 

	}).button();//{icons: {primary: "ui-icon-circle-plus"},text: true});
});
 

 
 
}
var getCategoria=function(idEjemplar,capado){
		var idConcurso=$("#ddlConcurso").val();
		var generoSel=idEjemplar.substring(0,1);
		/*addon dbs 20170706 por integracion sge*/
		if(generoSel=="P" && capado=="1"){			generoSel="C";}
		
	if(idConcurso!=-1){
    	$(".chkCatego").each(function(index,value){
    		$(this).prop("disabled",true);
	    	if( $(this).data("genero")=="M" && generoSel=="P")$(this).prop("disabled",false);
	    	if( $(this).data("genero")=="H" && generoSel=="Y")$(this).prop("disabled",false);
	    	if( $(this).data("genero")=="C" && generoSel=="C")$(this).prop("disabled",false);
	    	if( $(this).data("genero")=="T" )$(this).prop("disabled",false);
    		$(this).prop("checked",false);
    	});
		$("#mvCategorias").dialog("open");
	}else{
		alertify.error("Seleccione un concurso");
	}
}
var addInscripcionCatego=function(){
			
			var colleccion=[];
			var idConcurso=$("#ddlConcurso").val();
			if(idConcurso!=-1){
				var horseId=$("#hidIdEjemplar").val();
				var horseName=$("#hidEjemplarNombre_"+horseId).val();//$("#hidNombreEjemplar").val();var horseName=$("#hidNombreEjemplar").val();
				var horsePref=$("#hidPrefijoEjemplar").val();
				$(".chkCatego").each(function(index,value){
						if($(this).prop("checked")){
								var valueId=$(this).val();//prop("id");
								var inscripciones={};
								inscripciones.idCatego=valueId 
								inscripciones.idEjemplar=horseId;
								inscripciones.idConcurso=idConcurso;
								inscripciones.prefijo=horsePref;
								inscripciones.nombre=horseName;
								inscripciones.concurso=$("#ddlConcurso option:selected").text();
								inscripciones.categoria=$("#lblChk"+valueId).html();
								colleccion.push(inscripciones);
						}
				});

				if(colleccion.length>0){
					$.ajax({
				data:  {opc:'ins',premio:JSON.stringify(colleccion)},
				url:   'ajaxPOE/ajaxInscripcion.php',
				type:  'post',
				success:  function (response) {
					   			var retorno=JSON.parse(response);
								$(".gridHtmlTmp tbody").html("");
							    $(".gridHtmlTmp tbody").append(retorno.html);
							    initCtrolesGrillaTmp();
							    $("#mvCategorias").dialog("close");
							    if(retorno.result==1)
							    	alertify.alert(retorno.message);
							    else if(retorno.result==2)
							    	alertify.alert(retorno.message);
							    else if(retorno.result==0)
							    	alertify.alert(retorno.message);
				}
		});

				}else{
					alertify.error("Seleccione algún premio especial");
				}
			}else{
				alertify.error("Seleccione un concurso");
			}

}
var addInscripcion=function(){
			
			var colleccion=[];
			var idConcurso=$("#ddlConcurso").val();
			if(idConcurso!=-1){
				var horseId=$("#hidIdEjemplar").val();
				//var horseName=$("#hidNombreEjemplar").val();
				var horsePref=$("#hidPrefijoEjemplar").val();
				var horseName=$("#hidEjemplarNombre_"+horseId).val();
				 
								var inscripciones={};
								inscripciones.idCatego="0";
								inscripciones.idEjemplar=horseId;
								inscripciones.idConcurso=idConcurso;
								inscripciones.prefijo=horsePref;
								inscripciones.nombre=horseName;
								inscripciones.concurso=$("#ddlConcurso option:selected").text();
								inscripciones.categoria="";
								colleccion.push(inscripciones);
						 
				}

				if(colleccion.length>0){
					$.ajax({
							data:  {opc:'ins',premio:JSON.stringify(colleccion)},
							url:   'ajaxPOE/ajaxInscripcion.php',
							type:  'post',
							success:  function (response) {
								
								var retorno=JSON.parse(response);
								$(".gridHtmlTmp tbody").html("");
							    $(".gridHtmlTmp tbody").append(retorno.html);
							    initCtrolesGrillaTmp();
							    if(retorno.result==1)
							    	alertify.alert(retorno.message);
							    else if(retorno.result==2)
							    	alertify.alert(retorno.message);
							     else if(retorno.result==0)
							    	alertify.alert(retorno.message);
							}
					});

				 
			}else{
				alertify.error("Seleccione concurso");
			}

}

var initCtrolesGrillaTmp=function(){
$('.gridHtmlTmp tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
$('.btnQuit').each(function(i, obj) {
	$(obj).on("click",function(){
			var indice=$(this).data("key");
  			quitarTmp(indice);	
	}).button({icons: {primary: "ui-icon-closethick"},text: false});});
}
function quitarTmp(id){
					 $.ajax({
							data:  {opc:'quit',idx:id},
							url:   'ajaxPOE/ajaxInscripcion.php',
							type:  'post',
							success:  function (response) {
								$(".gridHtmlTmp tbody").html("");
								$(".gridHtmlTmp tbody").append(response);
							    initCtrolesGrillaTmp();
									 
							}
						}); 
}

function limpiarTmp(){
					 $.ajax({
							data:  {opc:'clsTmp'},
							url:   'ajaxPOE/ajaxInscripcion.php',
							type:  'post',
							success:  function (response) {
								$(".gridHtmlTmp tbody").html("");
								$(".gridHtmlTmp tbody").append(response);
							    initCtrolesGrillaTmp();
									 
							}
						}); 
}
function preview(){
	$.ajax({
		data:  {opc:'preview'},
		url:   'ajaxPOE/ajaxInscripcion.php',
		type:  'post',
		success:  function (response) {
			$("#htmlPreview").html(response);
			$("#mvFinal").dialog("open");
		}
	}); 

}
function registrarInscripcion(){

	$.ajax({
		data:  {opc:'insAddCon'},
		url:   'ajaxPOE/ajaxInscripcion.php',
		type:  'post',
		success:  function (response) {
			var retorno=JSON.parse(response);
			if(retorno.result==1){
				$("#mvFinal").dialog("close");
				limpiarTmp();
		    	alertify.success(retorno.message);
		    	
			}
		    else{
		    	alertify.error(retorno.message);
		    }
		    

			
		}
		});
}
function printHtmlPremios(){
 $.ajax({
    type: "POST",
    url: "ajaxPOE/ajaxInscripcion.php",
    data:{opc:'lstPremios',idCon:$("#ddlConcurso").val()},
    success:  function (response) { 
    				$('#tblPremios').html("");
    				var premios=JSON.parse(response);
					if(premios!=null){
						if(premios.data!=null){
						 var fila="<tr>";
						 var cuenta=0;
						 $.each(premios.data,function(index,premio){
							if(cuenta!=0 && cuenta%2==0){fila=fila +'</tr><tr>';}
							fila=fila +'<td><input class="chkCatego" type="checkbox" id="chk'+premio.id+'" value="'+premio.id+'"  data-genero="'+premio.genero+'"><label id="lblChk'+premio.id+'" for="chk'+premio.id+'">'+premio.nombre+'</label></td>';
							cuenta++;									
						 });
						 $('#tblPremios').html(fila);
						}
						else{
							alertify.error("No se encontraron premios especiales para el concurso.");
						}
					} else{
					alertify.error("No se encontraron premios especiales.");
					}
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
function printDetaConcurso(){
	$.ajax({
    type: "POST",
    url: "ajaxPOE/ajaxConcurso.php",
    data:{opc:'get',idCon:$("#ddlConcurso").val()},
    success:  function (response) { 
    				var concurso=JSON.parse(response);
    					if(concurso!=null){
  					 		$("#lblDetaConcurso").html(  concurso.nombre );
  						}else{
  							$("#lblDetaConcurso").html("");
  						}
				},
	beforeSend: function () {
				    $("#lblDetaConcurso").html(loadLst);
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