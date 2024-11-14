var K_PATH_ROOT="../";
$(function(){
$("#btnPrint").on("click",function(){ 	viewForm(5,$("#hidIdProp").val(),$("#hidIdPoe").val());}).button({icons: { primary: "ui-icon-print" }});
envioForm(function(response){
		if(response==1){
			$("#btnAgregar").on("click",function(){alertify.log("No se puede agregar. Parte de ocurrencias ya fue enviado")}).button({icons: { primary: "ui-icon-plusthick" }});
			$("#btnGrabar").on("click",function(){alertify.log("No se puede grabar. Parte de ocurrencias ya fue enviado")}).button({icons: { primary: "ui-icon-disk" }});
		}else{
			$("#btnAgregar").on("click",function(){ 
					if(evaluarModoVigenciaPOE($("#hidVigencia").val(),$("#hidAnioPer").val())){
						agregarItems();
					}
					}).button({icons: { primary: "ui-icon-plusthick" }});
			$("#btnGrabar").on("click",function(){ 
					if(evaluarModoVigenciaPOE($("#hidVigencia").val(),$("#hidAnioPer").val())){
						insert(); 
					}
			}).button({icons: { primary: "ui-icon-disk" }});
		}

}); 

listarTranf();
//listarAdqui();
//$("#btnVer").on("click",function(){ listarTranf();listarAdqui(); }).button({icons: { primary: "ui-icon-search" }});
$("#btnCancelar").on("click",function(){ listarTranf(); listarAdqui();}).button({icons: { primary: "ui-icon-cancel" }});
//$("#btnFin").on("click",function(){ }).button({icons: { primary: "ui-icon-circle-check" }});

 

});

var listarTranf=function(){
		$.ajax({
				data:  {opc:'lstMov',idPoe:$("#hidIdPoe").val(),idProp:$("#hidIdProp").val(),type:'T'},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario5.php',
				type:  'post',
				success:  function (response) {
				    $("#divResult").html(response);
				    initCtrolesGrilla();
				     
				}
		});
};
var listarAdqui=function(){
		$.ajax({
				data:  {opc:'lstMov',idPoe:$("#hidIdPoe").val(),idProp:$("#hidIdProp").val(),type:'A'},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario5.php',
				type:  'post',
				success:  function (response) {
				    $("#divResultAdqui").html(response);
				    initCtrolesGrillaAdqui();
				     
				}
		});
}; 

function agregarItems(){
 
 		
			var fila=countRowDetails();
			fila=verificarRows(fila,'gridHtmlAdqui','.cssRbtn','rdbtnT_');
			//console.log(fila);
			var idDel=(fila*-1);
			
			//alert(fila);
			$(".gridHtmlAdqui tbody ").append("<tr>"+
									"<td align='center' style='display:none;'>"+
									"<input type='radio' class='cssItem cssRbtn' data-label='lblStatusProp_"+fila+"' checked name='tipo_"+fila+"' id='rdbtnT_"+fila+"' value='T'/><label for='rdbtnT_"+fila+"'>Transferencia</label>"+
									"<input type='radio' class='cssItem cssRbtn' data-label='lblStatusProp_"+fila+"'  name='tipo_"+fila+"' id='rdbtnA_"+fila+"' value='A'/><label for='rdbtnA_"+fila+"'>Adquisición</label>"+
									"</td>"+
									"<td align='left'><label id='txtHorse_"+fila+"' ></label><input type='hidden' class='cssItem' id='hidHorse_"+fila+"' ></td>"+
									"<td align='center'><label  class='btnSearchAll btn btn-default btn-sm glyphicon glyphicon-search' data-ctrlset='hidHorse_"+fila+"' data-ctrlsetdisplay='txtHorse_"+fila+"'  data-nameradio='tipo_"+fila+"'></label></td>"+
									"<td align='center'><input type='text' class='cssFechaAdqui  cssItem'  style='width:100px;'  name='txtFech_"+fila+"' id='txtFech_"+fila+"'/></td>"+									
									"<td align='left'><label id='lblStatusProp_"+fila+"'> </label><input class='cssItem cssAutocmplte ui-widget'   type='text' style='width:90%;'  name='txtNombre_"+fila+"' id='txtNombre_"+fila+"'/></td>"+
									"<td align='center'><label class='btnDelAdqui btn btn-default btn-sm glyphicon glyphicon-trash' data-key='"+idDel+"'></label> </td>"+
									"</tr>");

			initCtrolesGrillaAdqui();

}

/*INICIALIZA LA GRILLA DE TRANSFERENCIAS*/
var initCtrolesGrilla=function(){
$('.gridHtml tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
$('.btnDel').each(function(i, obj) {
$( obj).button({
icons: { primary: "ui-icon-trash" },
text: false
});	
	if(evaluarModoVigenciaPOE_Grilla(obj,$("#hidVigencia").val(),$("#hidAnioPer").val())){
		$(obj).on("click",function(){
				var keyDel=$(this).data("key");
	  			delRow(obj,keyDel);
		});
	}
});
$('.cssFecha').each(function(i, obj) {
	$( obj).datepicker({ dateFormat: 'dd/mm/yy',changeMonth: true, changeYear: true });
	if($(obj).val()==""){
		$(obj).datepicker({defaultDate: new Date()});
		$(obj).datepicker("setDate","01/06/"+$("#hidAnioPer").val());
		
	}

});
$('.cssAutocmplte').each(function(i, obj) {
  $(obj).autocomplete({

      				source: K_PATH_ROOT+"ajaxPOE/ajaxAutocompletar.php",
                                select: function(event,ui){
                                    $(obj).val(ui.item.value);
                                    var arrCtrl=($(obj).prop("id")).split("_");
                                    //console.log(arrCtrl);
                                    if(arrCtrl.length==2){
                                    	$("#txtCodContacto_"+arrCtrl[1]).val(ui.item.codContacto);
                                    }
                                    
                                    //console.log(ui);
                                }
     });
     					
});
}
var initCtrolesGrillaAdqui=function(){
$('.gridHtmlAdqui tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
$('.btnDelAdqui').each(function(i, obj) {
$( obj).button({
icons: { primary: "ui-icon-trash" },
text: false
});	
	if(evaluarModoVigenciaPOE_Grilla(obj,$("#hidVigencia").val(),$("#hidAnioPer").val())){
		$(obj).on("click",function(){
				var keyDel=$(this).data("key");
	  			delRow(obj,keyDel);
		});
	}
});
$('.cssFechaAdqui').each(function(i, obj) {
	$( obj).datepicker({ dateFormat: 'dd/mm/yy',changeMonth: true, changeYear: true });
	if($(obj).val()==""){
		$(obj).datepicker({defaultDate: new Date()});
		$(obj).datepicker("setDate","01/06/"+$("#hidAnioPer").val());
		
	}

});
 

$('.btnSearchAll').each(function(i, obj) {
$( obj).button({
icons: { primary: "ui-icon-search" },
text: false
});
		if(evaluarModoVigenciaPOE_Grilla(obj,$("#hidVigencia").val(),$("#hidAnioPer").val())){
     						$(obj).on("click",function(){
     							$("#txtBGNombre").val("");
     							var ctrl=$(this).data("ctrlset");
     							var ctrlName=$(this).data("ctrlsetdisplay");
     							var ctrlRdbtnName=$(this).data("nameradio");
								
     							$("#hidCtrolId").val(ctrl);
     							$("#hidCtrolName").val(ctrlName);
     							$("#divResultBG").html("");
								$("#hidTipoParents").val("ALL");
								//alert($("input[name="+ctrlRdbtnName+"]:checked").val());
     							if($("input[name="+ctrlRdbtnName+"]:checked").val()=="T"){
     								$("#hidTipoParents").val("ALLMINE");	
     							}

     							_buscar();
								$("#divBuscarEjemplar").modal("show");
     						 });
		}
});
/*$('.cssRbtn').each(function(i, obj) {
     					 

     						$(obj).on("click",function(){
     							var lbl=$(this).data("label");
     							if($(this).val()=="A"){
											$("#"+lbl).html("Adquirido de:");
     							}else{
											$("#"+lbl).html("Transferido a:");
     							}
     						 });
});
*/



$('.cssAutocmplte').each(function(i, obj) {
     					 
  $(obj).autocomplete({

      				source: K_PATH_ROOT+"ajaxPOE/ajaxAutocompletar.php",
                                select: function(event,ui){
                                    $(obj).val(ui.item.value);

                                    console.log(obj);
                                   // alert($obj);
                                }
     });
     					
});
}
function delRow(row,idDel) {
			eliminar(idDel,function(response){
				//alert(response);
				if(response.result){
			    	var td = $(row).parent();
			    	var tr = td.parent();
			    	//alert(tr);
			    	tr.css("background-color", "#FF3700");
			    	tr.fadeOut(400, function () { tr.remove(); });
			    	//alert(row);
			    }
   			});
}
function countRowDetails() {
    var fila = 1;
    $(".gridHtml tbody tr ").each(function (index, value) { fila = fila + 1; });
    return fila;
}

function insert(){

alertify.confirm("Está seguro de registrar la información?", function (e) {
if (e) {
					var collection=Array();
					collection=getCollection("gridHtmlAdqui",collection);
					collection=getCollection("gridHtml",collection);

					if(collection.length==0){
						alertify.error("No hay datos completos para grabar información");
					}else{
					    
						datos=JSON.stringify(collection);
						$.ajax({
							data:  {opc:'insMov',idPoe:$("#hidIdPoe").val(),idUser:$("#hidIdProp").val(),data:datos},
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario5.php',
							type:  'post',
							success:  function (response) {
									var retorno=JSON.parse(response);
									if(retorno.result==1){
										 listarTranf();
										 listarAdqui();
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

function eliminar(id,callback){
	 
					 $.ajax({
							data:  {opc:'delMov',id:id},
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario5.php',
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
function getCollection(idGrilla,collection){
	$('.'+idGrilla+' tbody tr:has(input)').each(function(index, value) {
					var inputName = "";
					var values = "";
					//param=param+"{";
					//flag=false;
							var movimiento={};
							$('.cssItem ', this).each(function() {
									inputName =  $(this).attr("id");
									inputNameB =  $(this).attr("name");
							  		values =  $(this).val(); 
							  			movimiento.tipo='A';
								  		if(idGrilla=="gridHtml") movimiento.tipo='T';
								  		if(inputName.indexOf('txtFech_')!=-1) movimiento.fecha=values;
										if(inputName.indexOf('hidHorse_')!=-1) movimiento.codEjemplar=values;//param=param + ", 'codPadre':'"+values+"'";
										if(inputName.indexOf('txtNombre_')!=-1) movimiento.nomContacto=values;//param=param + ", 'nombre':'"+values+"'";
										if(inputName.indexOf('txtCodContacto_')!=-1) movimiento.codContacto=values;//param=param + ", 'nombre':'"+values+"'";
							});
							if(movimiento.nomContacto!="" && movimiento.codEjemplar!="" && movimiento.fecha!=""){
								collection.push(movimiento);
								console.log(collection);
							}
					});

	return collection;
}