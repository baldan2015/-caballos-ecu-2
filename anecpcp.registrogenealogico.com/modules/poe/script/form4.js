var K_PATH_ROOT="../";
$(function(){
$("#btnPrint").on("click",function(){ 	viewForm(4,$("#hidIdProp").val(),$("#hidIdPoe").val());}).button({icons: { primary: "ui-icon-print" }});
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


listarNacimiento();
//$("#btnVer").on("click",function(){ listarNacimiento(); }).button({icons: { primary: "ui-icon-search" }});
$("#btnCancelar").on("click",function(){ listarNacimiento(); }).button({icons: { primary: "ui-icon-cancel" }});
//$("#btnFin").on("click",function(){ }).button({icons: { primary: "ui-icon-circle-check" }});

});

var listarNacimiento=function(){
		$.ajax({
				data:  {opc:'lst',idPoe:$("#hidIdPoe").val(),idProp:$("#hidIdProp").val()},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario4.php',
				type:  'post',
				success:  function (response) {
				    $("#divResult").html(response);
				    initCtrolesGrilla();
				     
				}
		});
};
 
function agregarItems(){
			var fila=countRowDetails();
			fila=verificarRows(fila,'gridHtml','.cssItem','rdbtnMN_');
			var idDel=(fila*-1);
			var filaHtml="	<tr>"+
							"<td align='left'><label id='txtPotro_"+fila+"' ></label><input type='hidden' class='cssItem' id='hidPotro_"+fila+"' ></td>"+
							"<td align='center'><label  class='btnSearch btn  btn-sm btn-default glyphicon glyphicon-search' data-ctrlset='hidPotro_"+fila+"' data-ctrlsetdisplay='txtPotro_"+fila+"' > </label></td>"+	
							"<td align='left'><label id='txtYegua_"+fila+"' ></label><input type='hidden' class='cssItem' id='hidYegua_"+fila+"' ></td>"+
							"<td align='center'><label  class='btnSearch btn  btn-sm btn-default glyphicon glyphicon-search' data-ctrlset='hidYegua_"+fila+"' data-ctrlsetdisplay='txtYegua_"+fila+"' > </label></td>"+
				 			"<td align='left'>"+
							 
							"					<input type='radio' class='cssItem' name='metodo_"+fila+"' id='rdbtnMN_"+fila+"' value='MN' checked /> <label for='rdbtnMN_"+fila+"' title='Monta Natural' class='thItem'>Monta Natural</label>"+
							"					<input type='radio' class='cssItem' name='metodo_"+fila+"' id='rdbtnSF_"+fila+"' value='SF'  /> <label for='rdbtnSF_"+fila+"' title='Semen Seco' class='thItem'>Semen Fresco</label>"+
							"				    <input type='radio' class='cssItem' name='metodo_"+fila+"' id='rdbtnSR_"+fila+"' value='SR' /> <label for='rdbtnSR_"+fila+"' title='Semen Refrigerado' class='thItem'>Semen Refrig.</label>"+
							"					<input type='radio' class='cssItem' name='metodo_"+fila+"' id='rdbtnSC_"+fila+"' value='SC' /> <label for='rdbtnSC_"+fila+"' title='Semen Congelado'  class='thItem'>Semen Cong.</label>"+
							"					&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' class='cssItem' name='CheckMet_"+fila+"' id='rdbtnTE_"+fila+"' value='TE'  /> <label title='Transferencia de Embriones'  for='rdbtnTE_"+fila+"' class='thItem'>Transf. de Embriones</label>"+

 
							"</td>"+
							"<td><input type='text' class='cssFecha  cssItem'  style='width:80px;' name='txtFech_"+fila+"' id='txtFech_"+fila+"'/></td>"+
							"<td align='center'><label class='btnDel btn  btn-sm btn-default glyphicon glyphicon-trash' data-key='"+idDel+"'></label> </td>"+
							"</tr>";
			$(".gridHtml tbody ").append(filaHtml);
			initCtrolesGrilla();
}
/*
							"					<div class='div-columna'><input type='radio' class='cssItem' name='metodo_"+fila+"' id='rdbtnMN_"+fila+"' value='MN' checked /></div><div class='div-columna'><label for='rdbtnMN_"+fila+"' class='thItem'>Monta Natural</label></div>"+
							"					<div class='div-columna'><input type='radio' class='cssItem' name='metodo_"+fila+"' id='rdbtnSF_"+fila+"' value='SF'  /></div><div class='div-columna'><label for='rdbtnSF_"+fila+"' class='thItem'>Semen Fresco</label></div>"+
							"					<div class='div-columna'><input type='radio' class='cssItem' name='metodo_"+fila+"' id='rdbtnSR_"+fila+"' value='SR' /></div><div class='div-columna'><label for='rdbtnSR_"+fila+"' class='thItem'>Semen Refrigerado</label></div>"+
							"					<div class='div-columna'><input type='radio' class='cssItem' name='metodo_"+fila+"' id='rdbtnSC_"+fila+"' value='SC' /></div><div class='div-columna'><label for='rdbtnSC_"+fila+"' class='thItem'>Semen Congelado</label></div>"+
							"					<div class='div-columna'><input type='checkbox' class='cssItem' name='CheckMet_"+fila+"' id='rdbtnTE_"+fila+"' value='TE'  /></div><div class='div-columna'><label for='rdbtnTE_"+fila+"' class='thItem'>Transferencia de Embriones</label></div>"+
*/

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
	$( obj).datepicker({ dateFormat: 'dd/mm/yy',changeMonth: true, changeYear: true,
		beforeShow: function (input, inst) {
        var rect = input.getBoundingClientRect();
        setTimeout(function () {
	        inst.dpDiv.css({ top: rect.top + 20, left: rect.left + -80 });
        }, 0);
    }
	 });
	if($(obj).val()==""){
		$(obj).datepicker({defaultDate: new Date()});
		$(obj).datepicker("setDate","01/06/"+$("#hidAnioPer").val());
		
	}

});
$('.btnSearch').each(function(i, obj) {
$( obj).button({
icons: { primary: "ui-icon-search" },
text: false
});
		if(evaluarModoVigenciaPOE_Grilla(obj,$("#hidVigencia").val(),$("#hidAnioPer").val())){
     						$(obj).on("click",function(){
     							$("#txtBGNombre").val("");
     							var ctrl=$(this).data("ctrlset");
     							var ctrlName=$(this).data("ctrlsetdisplay");

     							$("#hidCtrolId").val(ctrl);
     							$("#hidCtrolName").val(ctrlName);
     							$("#divResultBG").html("");

								$("#hidTipoParents").val("Y");	
     							if(ctrl.indexOf("Potro")!=-1){
     								$("#hidTipoParents").val("P6");	
     							}
     							_buscar();
								$("#divBuscarEjemplar").modal("show");
     						 });
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
			    }
   			});
}
function countRowDetails() {
    var fila = 1;
    $(".gridHtml tbody tr ").each(function (index, value) { fila = fila + 1; });
    return fila;
}

function insert(){

alertify.confirm("Está seguro de registrar?", function (e) {
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
							var servicio={};
							$('.cssItem ', this).each(function() {
									inputName =  $(this).attr("id");
									inputNameB =  $(this).attr("name");
							  		values =  $(this).val(); 
										if(inputName.indexOf('txtFech_')!=-1) servicio.fecha=values;
							  			if(inputNameB!=undefined && flag==false && inputNameB.indexOf('metodo_')!=-1)
							  			{
										 servicio.metodo=$("input[name="+inputNameB+"]:checked").val();
										 flag=true;
							  			} 
										if(inputName.indexOf('hidYegua_')!=-1) servicio.codYegua=values;
										if(inputName.indexOf('hidPotro_')!=-1) servicio.codPotro=values;
										if(inputNameB!=undefined  && inputNameB.indexOf('CheckMet_')!=-1)
							  			{
							  				if($("input[name="+inputNameB+"]:checked").val()!=undefined){
							  					servicio.isTE=true;
							  				}else{
							  					servicio.isTE=false;
							  				}
							  			} 
							});
							collection.push(servicio);
					});
					if(collection.length==0){
						alertify.error("No hay datos para grabar");
					}else{
						datos=JSON.stringify(collection); 
						$.ajax({
							data:  {opc:'insServ',idPoe:$("#hidIdPoe").val(),idUser:$("#hidIdProp").val(),data:datos},
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario4.php',
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
							data:  {opc:'delNac',id:id},
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario4.php',
							type:  'post',
							success:  function (response) {
								 	var retorno=JSON.parse(response);
								 		callback({result:true});
									/*if(retorno.result==1){
							    		alertify.success(retorno.message);
							    		callback({result:true});
									}else if(retorno.result==0){
										alertify.error(retorno.message);
										callback({result:false});
									}else if(retorno.result==2){
										callback({result:false});
										alertify.alert(retorno.message);
									}
									*/
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