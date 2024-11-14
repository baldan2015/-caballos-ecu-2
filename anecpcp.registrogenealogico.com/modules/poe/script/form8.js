var K_PATH_ROOT="../";
var K_TIPO={aborto:"AB",castracion:"CA",fallecido:"FA"};
var K_GRILLA={aborto:"gridHtmlAborto",castracion:"gridHtmlCastrado",fallecido:"gridHtmlFallecido"};
var K_DIV_HISTORIAL={aborto:"#divResultAborto",castracion:"#divResultCastrado",fallecido:"#divResultFallecido"};
$(function(){
$("#btnPrint").on("click",function(){ 	viewForm(7,$("#hidIdProp").val(),$("#hidIdPoe").val(),'CA');}).button({icons: { primary: "ui-icon-print" }});	
 envioForm(function(response){
 			if(response==1){
 				$("#btnGrabar").on("click",function(){alertify.log("No se puede grabar. Parte de ocurrencias ya fue enviado")}).button({icons: { primary: "ui-icon-disk" }});
 			}else{
 				$("#btnGrabar").on("click",function(){ 
 					if(evaluarModoVigenciaPOE($("#hidVigencia").val(),$("#hidAnioPer").val())){
						insert();
					} 
				}).button({icons: { primary: "ui-icon-disk" }});
 			}
 });

listarEjemplares();
listarHistorial(K_TIPO.castracion);



$("#btnCancelar").on("click",function(){
 listarEjemplares();
 listarHistorial(K_TIPO.castracion);
  }).button({icons: { primary: "ui-icon-cancel" }});

});

var listarEjemplares=function(){
		$.ajax({
				data:  {opc:'lstPotros',idPoe:$("#hidIdPoe").val(),idProp:$("#hidIdProp").val()},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario7.php',
				type:  'post',
				success:  function (response) {
				    $("#divResult").html(response);
				    initCtrolesGrilla();
				     
				}
		});
};

 var listarHistorial=function(opc){
		var divResult="";
		var tipo=opc;
 		if(opc==K_TIPO.aborto) {idGrilla=K_GRILLA.aborto; divResult=K_DIV_HISTORIAL.aborto;}
		if(opc==K_TIPO.castracion) {idGrilla=K_GRILLA.castracion;divResult=K_DIV_HISTORIAL.castracion;}
		if(opc==K_TIPO.fallecido)  {idGrilla=K_GRILLA.fallecido;divResult=K_DIV_HISTORIAL.fallecido;}
		$.ajax({
				data:  {opc:'lstHistorial',idPoe:$("#hidIdPoe").val(),idProp:$("#hidIdProp").val(),tipo:tipo},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario7.php',
				type:  'post',
				success:  function (response) {
				    $(divResult).html(response);
				    initCtrolesGrillaForm(idGrilla);
				}
		});
};
  
 

function agregarItems(opc,grilla,id,label){  
	//console.log(opc+" - "+grilla+" - "+id+" - "+label);
		var textoAlert="";
		var idGrilla="";
		if(opc==K_TIPO.aborto) {idGrilla=K_GRILLA.aborto; textoAlert=" que abortaron.";}
		if(opc==K_TIPO.castracion) {idGrilla=K_GRILLA.castracion;textoAlert=" castrados.";}
		if(opc==K_TIPO.fallecido)  {idGrilla=K_GRILLA.fallecido;textoAlert=" fallecido.";}

	if(!existeFallecido(grilla,id)){
		var fila=0;
 		fila=countRowDetailItems(idGrilla);
			var idDel=(fila*-1);
			$("."+grilla+" tbody ").append("<tr>"+
			 			"<td align='left'><label  id='txtHorse_"+fila+"' >"+label+"</label><input type='hidden' class='cssItem'  id='hidHorse_"+fila+"' value="+id+"></td>"+
						"<td align='center'>"+
		  				"<input type='text'  class='cssFecha cssItem' style='width:100px;' name='txtFecha_"+opc+"_"+fila+"' id='txtFecha_"+opc+"_"+fila+"' value='' />"+
		 				"</td>"+					 
			 			"<td align='center'>"+
						"<label class='btnDel  btn btn-default btn-sm glyphicon glyphicon-trash' data-key="+idDel+"></label> "+
					 	"</td>"+
						"</tr>");
			 
			 initCtrolesGrillaForm(idGrilla);
	}else{
		alertify.error("Ya existe el ejemplar agregado a la lista de ejemplares "+textoAlert);
	}
}
var initCtrolesGrilla=function(){
$('.xgridHtml tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
$('.btnCA').each(function(i, obj) {
$( obj).button({
icons: { primary: "ui-icon-check" },
text: true
});	
	if($(obj).data("fin")=="1"){
 		$(obj).on("click",function(){alertify.log("No se puede agregar ejemplar. Parte de ocurrencias ya fue enviado")});
 	}else{
		if(evaluarModoVigenciaPOE_Grilla(obj,$("#hidVigencia").val(),$("#hidAnioPer").val())){
			$(obj).on("click",function(){
					var keyDel=$(this).data("key");
					var label=$(this).data("label");
					var tipo=$(this).data("tipo");
		  			agregarItems(K_TIPO.castracion,K_GRILLA.castracion,keyDel,label);
			});
		}	
	}
});
}
 
var initCtrolesGrillaForm=function(cssOpc){
$('.'+cssOpc+' tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
$('.btnDel').each(function(i, obj) {
$( obj).button({
icons: { primary: "ui-icon-trash" },
text: false
});	
		if($(obj).data("fin")=="1"){
 				$(obj).on("click",function(){alertify.log("No se puede quitar ejemplar. Parte de ocurrencias ya fue enviado")});
 			}else{
				if(evaluarModoVigenciaPOE_Grilla(obj,$("#hidVigencia").val(),$("#hidAnioPer").val())){
					$(obj).on("click",function(){
							var keyDel=$(this).data("key");
				  			delRow(obj,keyDel);
					});
				}
		}
});

$('.cssFecha').each(function(i, obj) {
	$( obj).datepicker({
	 dateFormat: 'dd/mm/yy', 
	 changeMonth: true,
     changeYear: true,
     beforeShow: function (input, inst) {
        var rect = input.getBoundingClientRect();
        setTimeout(function () {
	        inst.dpDiv.css({ top: rect.top + 20, left: rect.left + -70 });
        }, 0);
    }
     }); 
	if($(obj).val()==""){
		$(obj).datepicker({defaultDate: new Date()});
		$(obj).datepicker("setDate","01/06/"+$("#hidAnioPer").val());
		
	}
});
}


function delRow(row,idDel) {
			eliminar(idDel,function(response){
				if(response.result){
			    	var td = $(row).parent();
			    	var tr = td.parent();
			    	tr.css("background-color", "#FF3700");
			    	tr.fadeOut(400, function () { tr.remove(); });
			    	listarEjemplares();
			    }
   			});
}
function countRowDetails() {
    var fila = 1;
    $(".gridHtml tbody tr ").each(function (index, value) { fila = fila + 1; });
    return fila;
}
function countRowDetailItems(grilla) {
    var fila = 1;
    $("."+grilla+" tbody tr ").each(function (index, value) { fila = fila + 1; });
    return fila;
}

function insert(){

alertify.confirm("Está seguro de registrar la información?", function (e) {
if (e) {
			var fila=countRowDetails();
			var collection=Array();
			var tipo=K_TIPO.aborto;

					/*RECORRE  INPUTS DE CASTRADOS*/
					tipo=K_TIPO.castracion;
					$('.gridHtmlCastrado tbody tr:has(input)').each(function(index, value) {
					var inputName = "";
					var values = "";
							var historial2={};
							historial2.tipo=tipo;
							$('.cssItem ', this).each(function() {
									inputName =  $(this).attr("id");
							  		values =  $(this).val(); 
									if(inputName.indexOf('txtFecha_')!=-1) historial2.fecha=values;
									if(inputName.indexOf('hidHorse_')!=-1) historial2.codEjemplar=values;
							});
							collection.push(historial2);
					});

					if(collection.length==0){
						alertify.error("No hay datos para grabar");
					}else{
					    
						datos=JSON.stringify(collection);
						$.ajax({
							data:  {opc:'ins',idPoe:$("#hidIdPoe").val(),idUser:$("#hidIdProp").val(),data:datos},
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario7.php',
							type:  'post',
							success:  function (response) {
									var retorno=JSON.parse(response);
									if(retorno.result==1){
										listarEjemplares();
								 
										listarHistorial(K_TIPO.castracion);
							    		alertify.success(retorno.message);
									}else if(retorno.result==0){
										alertify.error(retorno.message);
									}else if(retorno.result==2){
										alertify.alert(retorno.message);
									}
							}
						});
					}
  		}
	});
}
 

function existeFallecido(grid,idSel){
	var flag=false;
				$('.'+grid+' tbody tr:has(input)').each(function(index, value) {
					var inputName = "";
					var values = "";
							$('.cssItem ', this).each(function() {
									inputName =  $(this).attr("id");
							  		values =  $(this).val(); 
									if(inputName.indexOf('hidHorse_')!=-1) 
									{
											if(values==idSel){
												flag=true;
											}
									}
							});
				});

return flag;
}

function eliminar(id,callback){

					  $.ajax({
							data:  {opc:'del',id:id},
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario7.php',
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
				 //   alert(response);
				  retorno(response);
				     
				}
		});
		return retorno;
};