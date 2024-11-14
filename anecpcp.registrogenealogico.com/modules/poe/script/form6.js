var K_PATH_ROOT="../";
$(function(){
$("#btnPrint").on("click",function(){ 	viewForm(6,$("#hidIdProp").val(),$("#hidIdPoe").val());}).button({icons: { primary: "ui-icon-print" }});
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

listarMovimiento();
$("#btnVer").on("click",function(){ listarMovimiento(); }).button({icons: { primary: "ui-icon-search" }});
$("#btnCancelar").on("click",function(){ listarMovimiento(); }).button({icons: { primary: "ui-icon-cancel" }});

$("#btnFin").on("click",function(){ }).button({icons: { primary: "ui-icon-circle-check" }});

$("#divBuscarEjemplar").dialog({
modal:true,
autoOpen:false,
width:800,
height:500,
title:'Búsqueda General de Ejemplar',
buttons: {
        "Seleccionar": function() {
          $( this ).dialog( "close" );
        },
        Cerrar: function() {
          $( this ).dialog( "close" );
        }
      }


});

});

var listarMovimiento=function(){
		$.ajax({
				data:  {opc:'lst',idPoe:$("#hidIdPoe").val(),idProp:$("#hidIdProp").val()},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario6.php',
				type:  'post',
				success:  function (response) {
				    $("#divResult").html(response);
				    initCtrolesGrilla();
				     
				}
		});
};
 

function agregarItems(){
 
			var fila=countRowDetails();
			fila=verificarRows(fila,'gridHtml','.cssRbtn','rdbtnCV_');
			var idDel=(fila*-1);
			$(".gridHtml tbody ").append("<tr>"+
									"<td align='left'>"+
									"<div class='div-tabla' style='width:95%;'>"+
									"				<div class='div-fila'>"+
									"					<div class='div-columna'><input type='radio' class='cssItem cssRbtn' data-label='lblStatusProp_"+fila+"' name='tipo_"+fila+"' id='rdbtnCV_"+fila+"' value='CV' checked /></div><div class='div-columna'><label for='rdbtnCV_"+fila+"'>Cesi&oacute;n de vientre</label></div>"+
									"					<div class='div-columna'><input type='radio' class='cssItem cssRbtn' data-label='lblStatusProp_"+fila+"' name='tipo_"+fila+"' id='rdbtnPP_"+fila+"' value='PP' /></div><div class='div-columna'><label for='rdbtnPP_"+fila+"'>Prestamo de Potros a Terceros</label></div>"+
									"				</div>		"+
									"			</div>									"+
									"</td>"+
									"<td align='left'><label id='txtHorse_"+fila+"' ></label><input type='hidden' class='cssItem' id='hidHorse_"+fila+"' ></td>"+
									"<td align='center'><label  class='btnSearchAll' data-ctrlset='hidHorse_"+fila+"' data-ctrlsetdisplay='txtHorse_"+fila+"'  data-ctrltipo='tipo_"+fila+"' >Buscar</label></td>"+
									"<td align='center'><input type='text' class='cssFecha  cssItem'  style='width:100px;'  name='txtFechIni_"+fila+"' id='txtFechIni_"+fila+"'/></td>"+									
									"<td align='center'><input type='text' class='cssFecha  cssItem'  style='width:100px;'  name='txtFechFin_"+fila+"' id='txtFechFin_"+fila+"'/></td>"+									
									"<td align='left'><label id='lblStatusProp_"+fila+"'>Cesi&oacute;n de vientre al se&ntilde;or:</label><input class='cssItem cssAutocmplte ui-widget'  type='text' style='width:250px;'  name='txtNombre_"+fila+"' id='txtNombre_"+fila+"'/></td>"+
									"<td align='center'><label class='btnDel' data-key='"+idDel+"'>Eliminar</label> </td>"+
									"</tr>");

			initCtrolesGrilla();
}



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

	$( obj).datepicker({ dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true });
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
								var ctrlTipo=$(this).data("ctrltipo");
								
								var tipo=$("input[name="+ctrlTipo+"]:checked").val(); 
								$("#hidTipoParents").val("P6");	
								if(tipo=="CV"){ $("#hidTipoParents").val("M6");}
     							$("#hidCtrolId").val(ctrl);
     							$("#hidCtrolName").val(ctrlName);
     							_buscar(); 
     							$("#divResultBG").html("");
								$("#divBuscarEjemplar").dialog("open");
     						 });
     	}
});
$('.cssRbtn').each(function(i, obj) {
     					 

     						$(obj).on("click",function(){
     							var lbl=$(this).data("label");
     							if($(this).val()=="CV"){
											$("#"+lbl).html("Cesión de vientre al señor:");
     							}else{
											$("#"+lbl).html("Prestamo al señor:");
     							}
     						 });
});



$('.cssAutocmplte').each(function(i, obj) {
     					 
  $(obj).autocomplete({

      				source: "ajaxPOE/ajaxAutocompletar.php",
                                select: function(event,ui){
                                    $(obj).val(ui.item.value);
                                   // alert($obj);
                                }
     });
     					
});
}

function delRow(row,idDel) {
			eliminar(idDel,function(response){
				if(response.result){
			    	var td = $(row).parent();
			    	var tr = td.parent();
			    	tr.css("background-color", "#FF3700");
			    	tr.fadeOut(400, function () { tr.remove(); });
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
			var fila=countRowDetails();
			fila=(fila-1);
			var param="";
			var flag=false;
			var cuenta=0;
			var collection=Array();
					$('.gridHtml tbody tr:has(input)').each(function(index, value) {
					var inputName = "";
					var values = "";
					flag=false;
							var prestamo={};
							$('.cssItem ', this).each(function() {
									inputName =  $(this).attr("id");
									inputNameB =  $(this).attr("name");
							  		values =  $(this).val(); 
										if(inputName.indexOf('txtFechIni_')!=-1) prestamo.fecha=values;
										if(inputName.indexOf('txtFechFin_')!=-1) prestamo.fechaFin=values;
							  			if(inputNameB!=undefined && flag==false && inputNameB.indexOf('tipo_')!=-1)
							  			{
										 prestamo.tipo=$("input[name="+inputNameB+"]:checked").val();//
										 flag=true;
							  			} 
										if(inputName.indexOf('hidHorse_')!=-1) prestamo.codEjemplar=values;//param=param + ", 'codPadre':'"+values+"'";
										if(inputName.indexOf('txtNombre_')!=-1) prestamo.nomContacto=values;//param=param + ", 'nombre':'"+values+"'";
							});
							collection.push(prestamo);
					});

					if(collection.length==0){
						alertify.error("No hay datos para grabar");
					}else{
					    
						datos=JSON.stringify(collection);
						$.ajax({
							data:  {opc:'ins',idPoe:$("#hidIdPoe").val(),idUser:$("#hidIdProp").val(),data:datos},
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario6.php',
							type:  'post',
							success:  function (response) {
									var retorno=JSON.parse(response);
									if(retorno.result==1){
										$("#divResult").html(retorno.html);
							    		initCtrolesGrilla();
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
							data:  {opc:'del',id:id},
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario6.php',
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