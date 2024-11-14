var K_PATH_ROOT="../";
$(function(){
$("#btnPrint").on("click",function(){ 	viewForm(2,$("#hidIdProp").val(),$("#hidIdPoe").val());}).button({icons: { primary: "ui-icon-print" }});
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


 
});

var listarNacimiento=function(){
		$.ajax({
				data:  {opc:'lstNac',idPoe:$("#hidIdPoe").val(),idProp:$("#hidIdProp").val()},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario2.php',
				type:  'post',
				success:  function (response) {
				    $("#divResult").html(response);
				    initCtrolesGrilla();
				     
				}
		});
};
var listarItemsPelaje=function(callback){

	var retorno={items:"",result:false};
		$.ajax({
				data:  {opc:'lst'},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxPelaje.php',
				type:  'post',
				success:  function (response) {
				   
				   respuesta=JSON.parse(response);
				   if(respuesta.data!=null){
				   		items=JSON.parse(respuesta.data);
				   			$.each(items,function(index, value){
				   				retorno.items= retorno.items+"<option value='"+value.nombre+"' > "+value.nombre+"</option> ";
				   			});
							retorno.result=true;
							callback(retorno);
				   }
				     
				}
		});

		// return callback(retorno);
};

function agregarItems(){

	
				     	 

	listarItemsPelaje(function(respuesta){

	if(respuesta.result){
			var fila=countRowDetails();
			fila=verificarRows(fila,'gridHtml','.cssItem','rdbtnM_')
			var idDel=(fila*-1);
									//"<td align='center'>"+fila+"</td> "+
									//"<td align='center'><input class='cssItem' type='text' style='width:200px;' id='txtMadre_"+fila+"' ><input type='hidden' class='cssItem' id='hidMadre_"+fila+"' ></td>"+
			$(".gridHtml tbody ").append("<tr>"+
									"<td><input type='text' class='cssFecha  cssItem  ' style='width:100px;'  name='txtFech_"+fila+"' id='txtFech_"+fila+"'/></td>"+
									"<td align='center'>"+
									"<input type='radio' class='cssItem ' checked name='sexo_"+fila+"' id='rdbtnM_"+fila+"' value='M'/><label for='rdbtnM_"+fila+"'>M</label>"+
									"<input type='radio'class='cssItem ' name='sexo_"+fila+"' id='rdbtnH_"+fila+"' value='H'/><label for='rdbtnH_"+fila+"'>H</label>"+
									"</td>"+
									"<td align='left' ><label id='txtMadre_"+fila+"' ></label><input type='hidden' class='cssItem' id='hidMadre_"+fila+"' ></td>"+
									"<td align='center'><label  class='btnSearch  btn  btn-sm btn-default glyphicon glyphicon-search' data-ctrlset='hidMadre_"+fila+"' data-ctrlsetdisplay='txtMadre_"+fila+"' ></label></td>"+
									"<td align='left'><label id='txtPadre_"+fila+"' ></label><input type='hidden' class='cssItem' id='hidPadre_"+fila+"' ></td>"+
									"<td align='center'><label  class='btnSearch  btn  btn-sm btn-default glyphicon glyphicon-search'  data-ctrlset='hidPadre_"+fila+"' data-ctrlsetdisplay='txtPadre_"+fila+"' ></label></td>"+
									
									"<td align='center'>"+
								//	"<input type='text'   name='txtPelaje_"+fila+"' id='txtPelaje_"+fila+"'/>"+
									"<select    class='cssItem  ' name='txtPelaje_"+fila+"' id='txtPelaje_"+fila+"' >"+
									respuesta.items +
									"</select>"+
									"</td>"+

									"<td align='center'><input class='cssItem  '  type='text'  style='width:130px;'  name='txtNombre_"+fila+"' id='txtNombre_"+fila+"'/></td>"+
									"<td align='center'><input type='text' class='cssFecha2  cssItem  ' style='width:80px;'  name='txtFecNacMuerto_"+fila+"' id='txtFecNacMuerto_"+fila+"'></td>"+
									"<td align='center'><label class='btnDel  btn  btn-sm btn-default glyphicon glyphicon-trash' data-key='"+idDel+"'></label> </td>"+
									"</tr>");
			//"<td align='center'><input type='text'   style='width:80px;'  name='txtNReg_"+fila+"' id='txtNReg_"+fila+"'/></td>"+
			initCtrolesGrilla();
		}else{
			alertify.error("No se pudo cargar pelaje");

		}

});
   
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

	$(obj).datepicker({ dateFormat: 'dd/mm/yy',changeMonth: true, changeYear: true });
	if($(obj).val()==""){
		$(obj).datepicker({defaultDate: new Date()});
		$(obj).datepicker("setDate","01/06/"+$("#hidAnioPer").val());
		
	}
});
$('.cssFecha2').each(function(i, obj) {
	$( obj).datepicker({ dateFormat: 'dd/mm/yy',changeMonth: true, changeYear: true ,
			beforeShow: function (input, inst) {
        var rect = input.getBoundingClientRect();
        setTimeout(function () {
	        inst.dpDiv.css({ top: rect.top + 20, left: rect.left + -62 });
        }, 0);
    }
    });
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

								$("#hidTipoParents").val("M");	
     							if(ctrl.indexOf("Padre")!=-1){
     								$("#hidTipoParents").val("P");	
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

alertify.confirm("Está seguro de registrar los nacimientos?", function (e) {
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
					param=param+"{";
					flag=false;
							var nacimiento={};
							$('.cssItem ', this).each(function() {
									inputName =  $(this).attr("id");
									inputNameB =  $(this).attr("name");
							  		values =  $(this).val(); 
										if(inputName.indexOf('txtFech_')!=-1) nacimiento.fecha=values;//param=param + " 'fecha':'"+values+"'";
							  			if(inputNameB!=undefined && flag==false && inputNameB.indexOf('sexo_')!=-1)
							  			{
										 nacimiento.sexo=$("input[name="+inputNameB+"]:checked").val();//
										 flag=true;
							  			} 
										if(inputName.indexOf('hidMadre_')!=-1) nacimiento.codMadre=values;//param=param + ", 'codMadre':'"+values+"'";
										if(inputName.indexOf('hidPadre_')!=-1) nacimiento.codPadre=values;//param=param + ", 'codPadre':'"+values+"'";
										if(inputName.indexOf('txtPelaje_')!=-1) nacimiento.pelaje=values;//param=param + ",'pelaje':'"+values+"'";
										if(inputName.indexOf('txtNombre_')!=-1) nacimiento.nombre=values;//param=param + ", 'nombre':'"+values+"'";
										if(inputName.indexOf('txtFecNacMuerto_')!=-1) nacimiento.fecNacMuerte=values;//param=param + " 'fecha':'"+values+"'";
										///debugger;
										//if(inputNameB!=undefined  && inputNameB.indexOf('chkNacMuerto_')!=-1)
							  			//{
										// nacimiento.nacMuerto=$("input[name="+inputNameB+"]:checked").val()=="on"?"1":"0";
							  			//} 
							});
							cuenta++;
							collection.push(nacimiento);
					});

					if(param==""){
						alertify.error("No hay datos para grabar");
					}else{
					    
						datos=JSON.stringify(collection);
						$.ajax({
							data:  {opc:'insNac',idPoe:$("#hidIdPoe").val(),idUser:$("#hidIdProp").val(),data:datos},
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario2.php',
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
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario2.php',
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

