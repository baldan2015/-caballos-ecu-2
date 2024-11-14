var K_PATH_ROOT="../";
var controllers={
    ejemplar:K_PATH_ROOT+'ajax/ajaxEjemplar.php',
    imgEjemplar:K_PATH_ROOT+'vista/upload/processuploadInsImg.php'
    //ejemplarJQGRID:K_PATH_ROOT+'ajax/ajaxEjemplarJQgrid.php',
    //impresion:K_PATH_ROOT+'ajax/ajaxImpresion.php',
}
var controllersREST={
    ejemplar:K_PATH_ROOT+'services/ejemplarService.php'
    //ejemplarJQGRID:K_PATH_ROOT+'ajax/ajaxEjemplarJQgrid.php',
    //impresion:K_PATH_ROOT+'ajax/ajaxImpresion.php',
}
/* controls: Objeto Json que contiene los  IDs de los controles que se crean en el html */
//formulario:"#divContainer",
var controls={
    actions:"#hidActionPopup",
    modalDialog:"#mvNuevoEjemplar",
    modalDialogImg:"#mvImgEjemplar",
    modalDialogPdf:"#mvPdfEjemplar",
    modalDialogPrint:"#mvNuevoEjemplarPrintIns",
    modalDialogLog:"#mvLogSolicitudDeta",
    modalDialogFac:"#mvFalleceEjemplar",
    modalDialogSuperCamp:"#mvSuperCamp",
    modalDialogPrint:"#mvPrintCertificado",
    buttonPrintTransf:"#btnPrintHorseTransf",
    modalUploadImg:"#mvUploadImagen",
    buttonPrint:"#btnPrintHorse",
    buttonPrintCE:"#btnPrintCE",
    buttonDead:"#btnFallece",
    buttonNew:"#btnNewRE2",
    buttonSave:"#btnSaveNE",
    buttonDel:"#btnEliminar",
    buttonEdit:"#btnEditarR",
    buttonView:"#btnVer",
    buttonCancel:"#btnCancelar",    
    buttonSaveFac:"#btnSaveFac",
    buttonSaveImg:"#btnUpload",
    buttonSuperCamp:"#btnSuperCamp",
    /*CONTROLES MODALVIEW NEO-INSERT*/
    codigo:"#hidCodigo",
    prefijo:"#txtPrefijo",
    cboPelaje:"ddlTipoPel",
    nombre:"#txtNombre",
    madre:"#hidIdMadre",
    padre:"#hidIdPadre",
    mostraMadre:"#lblMadre",
    mostraPadre:"#lblPadre",
    borrarMadre:"#lblBorrarMadre",
    borrarPadre:"#lblBorrarPadre",
    fecNace:"#dtFechaNac",
    lugarNace:"#txtLugarNac",
    microchip:"#txtMicrochip",
    adn:"#txtAdn",
    descripcion:"#txtDescripcion",
    sexo:"#ddlGenero",
    fecCapado:"#txtFecCapado",
    fecServ:"#dtpFechServ",
    cboMetodo:"ddlMetodo",
    yegua:"#lblYegua",
    potro:"#lblPotro",
    metodoReproductivo:"#lblMetRep",
    metodo:"#hidMetodo",
    codigoIns:"#hidCodigoInscripcion",
    popUpId:"#lblId",
    textoEstado:"#lblEstado",
    motivo:"#txtMotivo",
    fecFallece:"#dtFecha",
    ejemplar:"#lblEjemplar",
    ejemplarSuperCamp:"#lblEjemplarSC",
    idMonta:"#hidIdMonta",
    codigoMonta:"#lblIdMonta",
    codigoNacimiento:"#lblIdNac",
    idNac:"#hidIdNac",
    cboDepartamento:"ddlProvinvia",
    origen:"#ddlOrigen",
    reseniasLeftCA:"#ddlReseniaLeftCA",
    reseniasRightCA:"#ddlReseniaRightCA",
    fecReg:"#dtpFechReg",
    nroLibro:"#txtNumeroLibro",
    nroFolio:"#txtNumeroFolio",
    areaResenas:"#txtAResenia",
    hidFecMonta:"#hidFecMonta",
    // BUSQUEDA POR COMBO
    cboProp:"ddlProps",
    cboCria:"ddlCriador",
    cboIdNac:"ddlIdNac"
};
var events={
    click:"click",
    change:"change",
    keypress:"keypress"
};
var mensaje={
    mensajeBorrar :"Está seguro que desea eliminar la información?"
}
$(function(){
$('[data-toggle="tooltip"]').tooltip();
$("#btnPrint").on("click",function(){ 	viewForm(9,$("#hidIdProp").val(),$("#hidIdPoe").val());}).button({icons: { primary: "ui-icon-print" }});

 
  $("#btnAgregar").on("click",function(){ 
            agregarItems();
  });
  $("#btnSaveNE").on("click",function(){ 
          insert(); 
  });

$("#btnCancelar").on("click",function(){ listarTranf(); listarAdqui();}).button({icons: { primary: "ui-icon-cancel" }});

listarInscripciones();
 

/*INIT POPUP MODAL BUSCAR EJEMPLAR*/
$("#btnBuscarMadre" ).on( "click", function() {
      $("#hidOrigenBuscador").val("Y");
      $("#mvBuscadorEjemplarGrl" ).modal('show');
      $("#txtBGNombreEjemplar").val("");
       initDataTableGrlEjemplar();
});
$("#btnBuscarPadre" ).on( "click", function() { 
      $("#hidOrigenBuscador").val("P");
      $("#mvBuscadorEjemplarGrl" ).modal('show');
      $("#txtBGNombreEjemplar").val("");
       initDataTableGrlEjemplar();
    });
$( "#btnBuscarResenia" ).on( "click", function() {     openGrlResena();    });
/*FIN POPUP MODAL BUSCAR EJEMPLAR*/
limpiarLabelEjemplar(); 
listarCriador(controls.cboCria, "SELECCIONE", $("#hidIdProp").val());
listarPelaje("ddlTipoPel","SELECCIONE");
listarDeparmento("ddlProvinvia","SELECCIONE");
listarMetodoReprop("ddlMetodo","SELECCIONE");
listarResenia("ddlReseniaLeftCA", "","CA");
listarResenia("ddlReseniaLeftAD", "","AD");
listarResenia("ddlReseniaLeftAI", "","AI");
listarResenia("ddlReseniaLeftPD", "","PD");
listarResenia("ddlReseniaLeftPI", "","PI");
listarTipoDocumento("ddlTipoDocumento","SELECCIONE");
settingResenia();
$("#ddlCriador").attr("disabled","disabled");
//listarIdNacimiento("ddlIdNac","SELECCIONE");

});

var listarInscripciones=function(){
		$.ajax({
				data:  {opc:'lstInscp',idPoe:$("#hidIdPoe").val(),idProp:$("#hidIdProp").val()},
				url:   controllersREST.ejemplar,
				type:  'POST',
        beforeSend: function(request) {
          request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
        },
				success:  function (response) {
                    var retorno=JSON.parse(response);
                    if(retorno.result=="1"){
                            var data=retorno.data;
                           // console.log(data);
                            setDataTable(data,retorno.cantidad);
                    }else{
                        alertify.error(retorno.message);
                    }
				}
		});
};

var setDataTable=function(data,numRow){
 $('#grid').DataTable( {
        data:data ,
       language: {
                  search: "Búsqueda:",
                  lengthMenu: "Mostrar _MENU_ registros por página",
                  zeroRecords: "No se encontraron registros",
                  info: "Página  _PAGE_ de _PAGES_",
                  infoEmpty: "No se encontraron registros"
         },
        responsive: true,
        //paging: false,
        //searching: false,
        destroy: true,
         columns: [
            { "data": "codigoInscripcion" },
            { "data": "prefijo" },
            { "data": "nombre" },
            { "data": "genero" ,render: function(datum, type, row){
                   if(datum==="Y")return "YEGUA";
                   else return "POTRO";
            }}, 
            { "data": "idPelaje" },
            { "data": "fecNace" },
            { "data": "criador" },
            { "data": "nombreMadre" },
            { "data": "nombrePadre" },
            { "data": "estadoSolTexto",render: function(datum, type, row){
                  var estadoTexto="";
                  switch(row.estadoSolId){
                        case 'INI':
                        estadoTexto= "<span class='badge badge-warning badge-normal  '>"+row.estadoSolTexto+"</span>";
                        break;
                        case 'APR':
                        estadoTexto= "<span class='badge badge-success badge-normal  '>"+row.estadoSolTexto+"</span>";
                        break;
                        case 'REC':
                        estadoTexto= "<span class='badge badge-danger badge-normal  '>"+row.estadoSolTexto+"</span>";
                        break;
                        case 'OBS':
                        estadoTexto= "<span class='badge badge-primary badge-normal  '>"+row.estadoSolTexto+"</span>";
                        break;
                        case 'REV':
                        estadoTexto= "<span class='badge badge-secondary badge-normal  '>"+row.estadoSolTexto+"</span>";
                        break;
                        case 'SUBS':
                        estadoTexto= "<span class='badge badge-info badge-normal  '>"+row.estadoSolTexto+"</span>";
                        break;
                  }

                  return estadoTexto
            }},
            { "data": "fecSolicitud" },
            {
             "className":      'edit',
             "orderable":      false,
             "data":           null,
             "defaultContent": "",
             "render": function (obj, type, row, meta) {
                            if(obj.estadoSolId === "APR" || obj.estadoSolId ==="REC"){
                                var rowTable="<span title='Modificar Solicitud' class='btn btn-success btn-xs glyphicon glyphicon-edit' data-toggle='tooltip'  data-id='"+obj.id+"' data-estado='"+obj.estadoSolTexto+"' onclick='edit(this);'></span> ";
                                  rowTable=rowTable+"<span title='Imprimir Inscripción del Ejemplar' class='btn btn-info btn-xs glyphicon glyphicon-print' data-toggle='tooltip' data-id='"+obj.id+"'  data-id2='"+obj.codigoInscripcion+"' onclick='printInscripcion(this);'></span> ";
                                  rowTable=rowTable+"<span title='Seguimiento a Solicitud' class='btn btn-basic btn-xs glyphicon glyphicon-comment' data-toggle='tooltip' data-id='"+obj.id+"'  data-id2='"+obj.codigoInscripcion+"' onclick='verLog(this);'></span>";    
                            }else{
                                var rowTable="<span title='Modificar Solicitud' class='btn btn-success btn-xs glyphicon glyphicon-edit' data-toggle='tooltip'  data-id='"+obj.id+"' data-estado='"+obj.estadoSolTexto+"' onclick='edit(this);'></span> ";
                                  rowTable=rowTable+"<span title='Imprimir Inscripción del Ejemplar' class='btn btn-info btn-xs glyphicon glyphicon-print' data-toggle='tooltip' data-id='"+obj.id+"'  data-id2='"+obj.codigoInscripcion+"' onclick='printInscripcion(this);'></span> ";
                                  rowTable=rowTable+"<span title='Seguimiento a Solicitud' class='btn btn-basic btn-xs glyphicon glyphicon-comment' data-toggle='tooltip' data-id='"+obj.id+"'  data-id2='"+obj.codigoInscripcion+"' onclick='verLog(this);'></span>";    
                                  rowTable=rowTable+"<span title='Eliminar Solicitud' class='btn btn-basic btn-xs glyphicon glyphicon-trash' data-toggle='tooltip'   data-id='"+obj.id+"' onclick='deleteINS(this);' ></span> ";    
                            }
                            return rowTable;
                          
                          
              }
            }
            ]
    } );
          $("#lblCantidadSol").html(numRow);
          $("#tbInscripcion tbody").html("");
          $('[data-toggle="tooltip"]').tooltip();
          ///$('#grid tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
}; 



var listarEstados=function(id){
    $.ajax({
        data:  {opc:'lstEst',codigo:id},
        url:   controllersREST.ejemplar,
        type:  'POST',
        success:  function (response) {
                    var retorno=JSON.parse(response);
                    if(retorno.result=="1"){
                            var data=retorno.data;
                            getEstado(id);
                            $("#tbEstado tbody").html("");
                            $.each(data,filldatalog);
                             $("#tbEstado tbody tr").css({"width":"100%"});
                             $("#tbEstado tbody td").css({"width":"100%"});
                    }else{
                        alertify.error(retorno.message);
                    }
        }
    });
};

var getEstado=function(id){
   $.ajax({
        data:  {opc:'getIns',codigo:id},
        url:   controllersREST.ejemplar,
        type:  'POST',
         beforeSend: function(request) {
          request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
        },
        success:  function (response) {
                    var retorno=JSON.parse(response);
                    if(retorno.result=="1"){
                      var data=retorno.data;
                        var estado="<span class='badge "+setCssEstado(data.estadoSol)+"'>"+data.estadoSolTexto+"</span>";
                        $(controls.textoEstado).html(estado);
                    }else{
                        alertify.error(retorno.message);
                    }
        }
    });
}

var filldatalog=function(index,ejemplarINS){
  //console.log(ejemplarINS);
//$('[data-toggle="tooltip"]').tooltip();
    var rowTable="";
    rowTable=rowTable+"<tr >"
    rowTable=rowTable+"<td width='100%' height='10px'> <label>Estado: </label style='margin-left:10px;'><span style='margin-left:140px;' class='badge "+setCssEstado(ejemplarINS.estado)+"'>"+ejemplarINS.estadoTexto + "</span></td>";
    rowTable=rowTable+"</tr>"
    rowTable=rowTable+"<tr>"
    rowTable=rowTable+"<td width='100%'><label>Fecha Solicitud:</label><span style='margin-left:90px;'> "+ejemplarINS.fecSol+"</span></td>";
    rowTable=rowTable+"</tr>"
    rowTable=rowTable+"<tr>"
    rowTable=rowTable+"<td style='width:100%'><label>Comentario:</label><span style='margin-left:110px;'> "+ejemplarINS.comentario+"</span></td>";
    rowTable=rowTable+"</tr>"
    rowTable=rowTable+"<tr>"
    rowTable=rowTable+"<td style='width:100%'><label>Responsable: </label><span style='margin-left:105px;'>"+ejemplarINS.usuCrea+"</span></td>";
    rowTable=rowTable+"</tr>"
    rowTable=rowTable+"<tr><td>"
    rowTable=rowTable+"<hr>";
    rowTable=rowTable+"</tr></td>"
    var contendor  = $("#tbEstado tbody").html();
    $("#tbEstado tbody").html(contendor+rowTable);
    //$("#tbEstado tbody").html(rowTable);
};  
function agregarItems(){
    clearCtrlsPopup();
    listarIdNacimiento("ddlIdNac","SELECCIONE","",$("#hidIdProp").val());
    listarPelaje("ddlTipoPel","seleccione");
    listarDeparmento("ddlProvinvia","seleccione");
    listarMetodoReprop("ddlMetodo","SELECCIONE");
    $("#ddlGenero").val(0);
    $("#ddlOrigen").val("N");
    $("#idHorse").val("");
    $("#idHorsePdf").val("");
    $("#hidFlagEdit").val("");
    
    grlEjecutarAccion(controllersREST.ejemplar, {opc:'getLastIDIns'},function(retorno){
        let id=0;
          if(retorno.data == null){
            id = 1;
          }else{
            var ejemplar=retorno.data;         
             id = parseInt(ejemplar.id) + 1;  
          }
        var idPropietario = $("#hidIdProp").val();
        var codigoGenerado = "00"+id+idPropietario;
        $("input[id=hidCodigoGenerado]").val(codigoGenerado);
        $(controls.modalDialog+" .modal-title").html("Nueva Solicitud Inscripcón.");
        $("#mvNuevoEjemplar").data("action","insert");
        $("#mvNuevoEjemplar").modal('show');
        listarImg("",codigoGenerado);
        listarPdf("",codigoGenerado);
    });
}


function insert(){
alertify.confirm("Está seguro de registrar la información?", function (e) {
if (e) {
	
	grlEjecutarAccion(controllers.ejemplar, {opc:'val',fecServ:$(controls.fecServ).val(),fecNace:$(controls.fecNace).val(),idmadre:$(controls.madre).val(),idHijo:$(controls.codigo).val()},function(retorno){
                                 // console.log(retorno.result);
              if(retorno.result===K_ResultadoAjax.exito){
               update();
              }else if(retorno.result===K_ResultadoAjax.error){
  						alertify.confirm('Advertencia', 'La fecha de nacimiento y la fecha de servicio es inconsistente verificarlo. Desea continuar ?', 
                  				function(){               update();                 },                   
                  				function(){                   }                  );
              }else if(retorno.result===K_ResultadoAjax.warning){
  						alertify.confirm('Advertencia', 'Existe traslape del ejemplar a registrar con las crias de la madre'+' : '+$("#lblMadre").html() +' '+'.Desea Continua ?', 
                  				function(){               update();                  }, 
                  				function(){                   }
                  		);
              }
	});
  		}
	});
}

/*function eliminar(id,callback){
	 
					 $.ajax({
							data:  {opc:'delMov',id:id},
							url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario9.php',
							type:  'post',
							success:  function (response) {
								 	var retorno=JSON.parse(response);
								 		callback({result:true});
									 
							}
						}); 
}*/

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
 

var update=function(){
//var codigo=controls.codigo;

var date1 = new Date($(controls.hidFecMonta).val());
var date2 = new Date($(controls.fecNace).val());
var diffTime = Math.abs(date2 - date1);
var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

var lstItemPropietario="";//getIdEntidad();

//console.log($("#hiddenImgIns").val());

var data={opc:'-',
codigo:$(controls.codigo).val(),
prefijo:$(controls.prefijo).val(),
nombre:$(controls.nombre).val(),
fecNace:$(controls.fecNace).val(),
padre:$(controls.padre).val(),
madre:$(controls.madre).val(),
//padre:$(controls.potro).text(),
//yegua:$(controls.yegua).text(),
idPelaje:$('#'+controls.cboPelaje).val(),
lugarNace:$(controls.lugarNace).val(),
microchip:$(controls.microchip).val(),
adn:$(controls.adn).val(),
descripcion:$(controls.descripcion).val(),
entidad:lstItemPropietario,//JSON.stringify(lstItemPropietario),
genero:$(controls.sexo).val(),
fecCapado:$(controls.fecCapado).val(),
idMonta:$(controls.idMonta).val(),
idNac:$(controls.idNac).val(),
idProvincia:$('#'+controls.cboDepartamento).val(),
origen:$(controls.origen).val(),
resenias:$(controls.areaResenas).val(),
fecReg:$(controls.fecReg).val(),
nroLibro:$(controls.nroLibro).val(),
nroFolio:$(controls.nroFolio).val(),
fecServ:$(controls.fecServ).val(),
idMetodo:$(controls.metodo).val(),
idPoe:$("#hidIdPoe").val(),
idProp:$("#hidIdProp").val(),
idCriador:$("#"+controls.cboCria).val(),
codigoIns:$(controls.codigoIns).val(),
arrayResenias:$("#array").val(),
codigoGenerado:$("input[id=hidCodigoGenerado]").val()
};

 if ($(controls.modalDialog).data("action") != "insert") {
    data.opc='updIns';
  }else{
    data.opc='insIns';
  }


      if(data.idNac===""){
         alertify.error("Debe seleccionar un código de nacimiento");
        }else {
          if(diffDays>=334){
            if(grlValidarObligatorio(controls.modalDialog)){
              if($("#ddlCriador").val() != 0 ){
                $("#ddlCriador").css({ 'border': '1px solid #ccc' });
                    if($("#hiddenImgIns").val() == undefined || $("#hiddenPdfIns").val() == undefined ){
                        alertify.error("Debe adjuntar mínimo una imagen y un documento del ejemplar");
                      }else{    if(data.opc!="-"){
                               grlEjecutarAccion(controllersREST.ejemplar, data,function(retorno){
                                 //console.log(retorno);
                                      if(retorno.result===K_ResultadoAjax.exito){
                                          grlEjecutarAccion(controllersREST.ejemplar, {opc:'getLastIDIns'},function(retorno){
                                              var ejemplar=retorno.data;
                                              if(retorno.result===K_ResultadoAjax.exito && data.opc=='insIns'){
                                                  alertify.alert("Se registró una inscripción con el código : " + ejemplar.codigoInscripcion, function(){alertify.success(retorno.message);});
                                                  //alertify.success(retorno.message);
                                                  $("#mvNuevoEjemplar").modal("hide");
                                                  //insertLog();
                                              }else{
                                                  alertify.alert("Se actualizó una inscripción con el código : " + $("#hidCodigoInscripcion").val(), function(){alertify.success(retorno.message);});
                                                  //alertify.success(retorno.message);
                                                  $("#mvNuevoEjemplar").modal("hide");      
                                              }
                                          });
                                      }else if(retorno.result===K_ResultadoAjax.error){
                                            alertify.set('notifier','delay', 10);
                                            alertify.error(retorno.message);
                                      }else if(retorno.result===K_ResultadoAjax.warning){
                                            alertify.warning(retorno.message);
                                      }else if(retorno.result===K_ResultadoAjax.duplicate){
                                            alertify.error(retorno.message);
                                      }
                                      search();
                                  });
                          }else{
                                  alertify.error(messages.noDeterminated);
                          }
                    }
              }else{
              alertify.error("Debe seleccionar un criador");
              $("#ddlCriador").css({ 'border': '1px solid red' });
            }
            }
         }else {
          alertify.alert("La fecha de nacimiento seleccionada no esta dentro del tiempo de gestación de ejemplares",function(){

          });
        }
        }
 };
function clearCtrlsPopup(){
   grlLimpiarObligatorio(controls.modalDialog);
    $(controls.prefijo).val("");
    $(controls.nombre).val("");
    $(controls.fecNace).val("");
    $(controls.padre).val("");
    $(controls.madre).val("");
    $(controls.mostraMadre).html("");
    $(controls.mostraPadre).html("");
   
    $(controls.pelaje).val("");
    $(controls.lugarNace).val("");
    $(controls.microchip).val("");
    $(controls.adn).val("");
    $(controls.descripcion).val("");
    $(controls.codigo).val("");
    $(controls.motivo).val("");
    $(controls.fecFallece).val("");
    $(controls.origen).val("");
    $(controls.reseniasRight).val("");
    $(controls.fecReg).val("");
    $(controls.nroLibro).val("");
    $(controls.nroFolio).val("");
    $(controls.areaResenas).text("");
    $(controls.areaResenas).val("");
    $(controls.fecServ).val("");
    $(controls.yegua).html("");
    $(controls.potro).html("");
    $(controls.metodoReproductivo).html("");
    $(controls.codigoMonta).html("");
    $(controls.idMonta).val("");
    $(controls.idNac).val(""); 
    $(controls.codigoNacimiento).html("");
    $(controls.metodo).val("");
    $(controls.codigoIns).val("");
     $(controls.sexo).attr("enable",false);
     //$(controls.idMonta).attr("disabled",false);
     //$(controls.idNac).attr("disabled",false);
     $("#"+controls.cboIdNac).prop("disabled",false);
     $("#hidCodigoInscripcion").val("");
     $("#array").val("");
     $("#lblResenia").text("");




    $(controls.prefijo).prop("disabled",false);
    $(controls.nombre).prop("disabled",false);
    $(controls.fecNace).prop("disabled",false);
    $("#ddlTipoPel").prop("disabled",false);
    $(controls.lugarNace).prop("disabled",false);
    $(controls.microchip).prop("disabled",false);
    $(controls.descripcion).prop("disabled",false);
    $(controls.motivo).prop("disabled",false);
   // $(controls.cboCria).prop("disabled",false);
    $(controls.sexo).prop("disabled",false);
    $("#ddlOrigen").prop("disabled",false);
    $("#ddlProvinvia").prop("disabled",false);
    $("#btnBuscarResenia").show();
    $("#btnSaveNE").show()





    //limpiarSesionTMPEntes();
  }
function search(){ listarInscripciones();}

function setCssEstado(estadoSolId){
    var cssEstado='';
    switch(estadoSolId){
        case 'INI': cssEstado=" badge-warning ";break;
        case 'REV': cssEstado=" badge-secondary";break;
        case 'APR': cssEstado=" badge-success ";break;
        case 'OBS': cssEstado=" badge-primary ";break;
        case 'REC': cssEstado=" badge-danger ";break;
        default:  cssEstado=" badge-info ";break;
    };

    return cssEstado;
}
function addImg(obj){
     var id=$(obj).data("id");
     var codigoInscripcion=$(obj).data("id2");
     $(controls.modalDialogImg).modal("show");
     $("#idHorse").val(id);
     $("#lblDatoHorse").html($(obj).data("nombre")+' - '+$(obj).data("prefijo"));
     $("#lblIdSol").html("Inscripcón código: "+codigoInscripcion);
    listarImg(id);
}
function addCert(obj){
     var id=$(obj).data("id");
     var codigoInscripcion=$(obj).data("id2");
     $(controls.modalDialogPdf).modal("show");
    $("#idHorsePdf").val(id);
   $("#lblDatoHorsePdf").html($(obj).data("nombre")+' - '+$(obj).data("prefijo"));
    $("#lblIdSolPdf").html("Inscripcón código: "+codigoInscripcion);
     listarPdf(id);
}
function  verLog(obj){
  //console.log(controls.modalDialogLog);
  // $(controls.modalDialogLog).modal("show");
  var id=$(obj).data("id");
  var codigoInscripcion=$(obj).data("id2");
  listarEstados(id);
  $(controls.popUpId).html(id);
   $(controls.modalDialogLog+" .modal-title").html("SEGUIMIENTO DE SOLICITUD " + codigoInscripcion);
   //$(controls.modalDialog).data("action","edit");
   $(controls.modalDialogLog).modal("show");

}
function edit(obj){
     var id=$(obj).data("id");
     var estado=$(obj).data("estado");
    // console.log(estado);
     if(estado=="APROBADO" || estado=="RECHAZADO"){
          $(controls.prefijo).prop("disabled",true);
          $(controls.nombre).prop("disabled",true);
          $(controls.fecNace).prop("disabled",true);
          $("#ddlTipoPel").prop("disabled",true);
          $(controls.lugarNace).prop("disabled",true);
          $(controls.microchip).prop("disabled",true);
          $(controls.descripcion).prop("disabled",true);
          $(controls.motivo).prop("disabled",true);
          $(controls.sexo).prop("disabled",true);
          $("#ddlOrigen").prop("disabled",true);
          $("#ddlProvinvia").prop("disabled",true);
          $("#btnBuscarResenia").hide();
          $("#ddlCriador").attr("disabled","disabled");
          $("#btnSaveNE").hide();
          $("#imageInput").hide();
          $("#submit-btn").hide();
          $("#pdfInput").hide();
          $("#submit-btn-pdf").hide();
          $("#ddlTipoDocumento").hide();
          $("#lblTipoD").hide();
     }else{
          $(controls.prefijo).prop("disabled",false);
          $(controls.nombre).prop("disabled",false);
          $(controls.fecNace).prop("disabled",false);
          $("#ddlTipoPel").prop("disabled",false);
          $(controls.lugarNace).prop("disabled",false);
          $(controls.microchip).prop("disabled",false);
          $(controls.descripcion).prop("disabled",false);
          $(controls.motivo).prop("disabled",false);
          $(controls.sexo).prop("disabled",false);
          $("#ddlOrigen").prop("disabled",false);
          $("#ddlProvinvia").prop("disabled",false);
          $("#btnBuscarResenia").show();
          $("#ddlCriador").attr("disabled","disabled");
          $("#btnSaveNE").show();
          $("#imageInput").show();
          $("#submit-btn").show();
          $("#pdfInput").show();
          $("#submit-btn-pdf").show();
          $("#ddlTipoDocumento").show();
          $("#lblTipoD").show();
     }
    // $(controls.codigo).val(id);
     editar(id);
}
function deleteINS(obj){
    var id=$(obj).data("id");
    if(id!=undefined){
         alertify.confirm(mensaje.mensajeBorrar, function (e) { 
    if (e) {
                    grlEjecutarAccion(controllersREST.ejemplar, {opc:'delIns',id:id},function(retorno){

                        //console.log(retorno);
                        if(retorno.result==K_ResultadoAjax.exito){
                            alertify.success(retorno.message);
                            listarInscripciones();
                        }else if (retorno.result==2){
                            alertify.error(retorno.message);
                            listarInscripciones();
                        }else if (retorno.result==995){
                            alertify.error(retorno.message);
                            listarInscripciones();
                        }

                    });
    }
  });
       }      
}


function limpiarLabelEjemplar(){
  $("#lblBorrarMadre").on('click',function(){
  $("#lblMadre").html("");
  $("#lblBorrarMadre").hide();
  $("#hidIdMadre").val("0");
});
$("#lblBorrarPadre").on('click',function(){
  $("#lblPadre").html("");
  $("#lblBorrarPadre").hide();
  $("#hidIdPadre").val("0");
});
$("#lblBorrarEjemplar").on('click',function(){
  $("#lblEjemplar").html("");
  $("#lblBorrarEjemplar").hide();
});
}

function settingResenia(){
  $("#rightSelectedCA").on(events.click,function (){ 
 var a=0;
        $("#ddlReseniaRightCA option").each(function (){ 
            if($(this).val()==$('#ddlReseniaLeftCA option:selected').val()){
                alertify.error("La reseña se encuentra agregada");
              a=a+1;

            }
      });
      if(a==0){
        var controlLeft=$('#ddlReseniaLeftCA option:selected');
        $("#ddlReseniaRightCA").append("<option value='" +controlLeft.val() + "' title='" + controlLeft.text() + "'>" + controlLeft.text() + "</option>");
      }

      concatenarResenia();

 });
  $("#rightSelectedAD").on(events.click,function (){ 
 var a=0;
        $("#ddlReseniaRightAD option").each(function (){ 
            if($(this).val()==$('#ddlReseniaLeftAD option:selected').val()){
                alertify.error("La reseña se encuentra agregada");
              a=a+1;
            }
      });
      if(a==0){
        var controlLeft=$('#ddlReseniaLeftAD option:selected');
        $("#ddlReseniaRightAD").append("<option value='" +controlLeft.val() + "' title='" + controlLeft.text() + "'>" + controlLeft.text() + "</option>");
    
      }

      concatenarResenia();
 });

   $("#rightSelectedAI").on(events.click,function (){ 
 var a=0;
        $("#ddlReseniaRightAI option").each(function (){ 
            if($(this).val()==$('#ddlReseniaLeftAI option:selected').val()){
                alertify.error("La reseña se encuentra agregada");
              a=a+1;
            }
      });
      if(a==0){
        var controlLeft=$('#ddlReseniaLeftAI option:selected');
        $("#ddlReseniaRightAI").append("<option value='" +controlLeft.val() + "' title='" + controlLeft.text() + "'>" + controlLeft.text() + "</option>");

      }
      concatenarResenia();
 });


    $("#rightSelectedPD").on(events.click,function (){ 
 var a=0;
        $("#ddlReseniaRightPD option").each(function (){ 
            if($(this).val()==$('#ddlReseniaLeftPD option:selected').val()){
                alertify.error("La reseña se encuentra agregada");
              a=a+1;
            }
      });
      if(a==0){
        var controlLeft=$('#ddlReseniaLeftPD option:selected');
        $("#ddlReseniaRightPD").append("<option value='" +controlLeft.val() + "' title='" + controlLeft.text() + "'>" + controlLeft.text() + "</option>");

      }
      concatenarResenia();
 });

     $("#rightSelectedPI").on(events.click,function (){ 
 var a=0;
        $("#ddlReseniaRightPI option").each(function (){ 
            if($(this).val()==$('#ddlReseniaLeftPI option:selected').val()){
                alertify.error("La reseña se encuentra agregada");
              a=a+1;
            }
      });
      if(a==0){
        var controlLeft=$('#ddlReseniaLeftPI option:selected');
        $("#ddlReseniaRightPI").append("<option value='" +controlLeft.val() + "' title='" + controlLeft.text() + "'>" + controlLeft.text() + "</option>");

      }
      concatenarResenia();
 });

$("#leftSelectedCA").on(events.click,function (){ 
      $('#ddlReseniaRightCA option:selected').remove(); 
      concatenarResenia();
 });

$("#leftSelectedAD").on(events.click,function (){ 
      $('#ddlReseniaRightAD option:selected').remove(); 
      concatenarResenia();
 });

$("#leftSelectedAI").on(events.click,function (){ 
      $('#ddlReseniaRightAI option:selected').remove(); 
      concatenarResenia();
 });
 $("#leftSelectedPD").on(events.click,function (){ 
      $('#ddlReseniaRightAD option:selected').remove(); 
      concatenarResenia();
 });
 $("#leftSelectedPI").on(events.click,function (){ 
      $('#ddlReseniaRightAD option:selected').remove(); 
      concatenarResenia();
 });    


$("#btnSaveResena").on(events.click,function(){
  //var concatValor = '';
  var collection=Array();
  
     $("#ddlReseniaRightCA option").each(function(){
        if ($(this).val() != "" ){        
        resena={id:$(this).val(),descripcion:$(this).text(),tipo:"CA"};        
        collection.push(resena);
        }
      });
     $("#ddlReseniaRightAD option").each(function(){
        if ($(this).val() != "" ){        
        resena={id:$(this).val(),descripcion:$(this).text(),tipo:"AD"};        
        collection.push(resena);
        }
      });
      $("#ddlReseniaRightAI option").each(function(){
        if ($(this).val() != "" ){        
        resena={id:$(this).val(),descripcion:$(this).text(),tipo:"AI"};        
        collection.push(resena);
        }
      });
       $("#ddlReseniaRightPD option").each(function(){
        if ($(this).val() != "" ){        
        resena={id:$(this).val(),descripcion:$(this).text(),tipo:"PD"};        
        collection.push(resena);
        }
      });
        $("#ddlReseniaRightPI option").each(function(){
        if ($(this).val() != "" ){        
        resena={id:$(this).val(),descripcion:$(this).text(),tipo:"PI"};        
        collection.push(resena);
        }
      });
    
            //console.log(collection);
            datos=JSON.stringify(collection);

            $.ajax({
              data:  {opc:'resSession',data:datos},
              //url:   K_PATH_ROOT+'ajax/ajaxEjemplar.php',
              url:    controllersREST.ejemplar,
              type:  'post',
              success:  function (response) {
                  var retorno=JSON.parse(response);
                  if(retorno.result==1){
                    $("#mvBuscadorResenaGrl").modal('hide');
                    $("#txtAResenia").val(retorno.html);
                    $('#array').val(JSON.stringify(retorno.data)); 
                   }else if(retorno.result==0){
                    alertify.error(retorno.message);
                  } 
                    
                 
              }
            });
      
});
}

function openGrlResena(){
  //$("#array").val();
 // console.log($("#array").val());
listarReseniaSelAll("","","");   
/*listarReseniaSelCA("ddlReseniaRightCA","","CA"); 
listarReseniaSelAD("ddlReseniaRightAD","","AD");
listarReseniaSelAI("ddlReseniaRightAI","","AI");
listarReseniaSelPD("ddlReseniaRightPD","","PD"); 
listarReseniaSelPI("ddlReseniaRightPI","","PI"); */
  $("#mvBuscadorResenaGrl").modal('show');     
}


function concatenarResenia(){
var collection1=Array();
    
     $("#ddlReseniaRightCA option").each(function(){
        if ($(this).val() != "" ){        
       textoResena={descripcion:$(this).text()};        
        collection1.push(textoResena);
        }
      });   
    
     $("#ddlReseniaRightAD option").each(function(){
        if ($(this).val() != "" ){        
        textoResena={descripcion:$(this).text()};        
        collection1.push(textoResena);
        }
      });   
    
      $("#ddlReseniaRightAI option").each(function(){
        if ($(this).val() != "" ){        
        textoResena={descripcion:$(this).text()};        
        collection1.push(textoResena);
        }
      });
       $("#ddlReseniaRightPD option").each(function(){
        if ($(this).val() != "" ){        
        textoResena={descripcion:$(this).text()};        
        collection1.push(textoResena);
        }
      });
        $("#ddlReseniaRightPI option").each(function(){
        if ($(this).val() != "" ){        
        textoResena={descripcion:$(this).text()};        
        collection1.push(textoResena);
        }
      });
var texto ="";
     $.each(collection1,function(index,value){
       // console.log(value);
        texto = texto + ' '+ value.descripcion;
     });
     //console.log(texto);
     $("#lblResenia").text(texto);
        //console.log(collection1);


}
function editar(codigo){
                if(codigo!=undefined){
                    grlEjecutarAccion(controllersREST.ejemplar, {opc:'getIns',codigo:codigo},function(retorno){
                      //console.log(retorno);
                        if(retorno.result==K_ResultadoAjax.exito){
                           var ejemplar=retorno.data;
                            if(ejemplar!=null){
                              //console.log(ejemplar);
                               var estado=  "<span class='badge "+setCssEstado(ejemplar.estadoSol)+"'>"+ejemplar.estadoSolTexto+"</span></td>";
                                //$(controls.modalDialog+" .modal-title").html("Modificar Solicitud Nro: "+ ejemplar.codigo + estado +  "Código Inscripcón: " + ejemplar.codigoInscripcion);
                                $(controls.modalDialog+" .modal-title").html("Modificar Inscripción: "+ ejemplar.codigoInscripcion + ' '+ estado );
                                $(controls.modalDialog).data("action","edit");
                                $(controls.modalDialog).modal("show");
                                listarImg(ejemplar.codigo,'');
                                listarPdf(ejemplar.codigo,'');
                                $("input[id=hidFlagEdit]").val("1");
                                $(controls.codigo).val(ejemplar.codigo);
                                $("#array").val(JSON.stringify(ejemplar.listResenas));
                                //console.log()
                                $("#hidCodigoInscripcion").val(ejemplar.codigoInscripcion)
                                //$(controls.codigoIns).val(ejemplar.codigoInscripcion);
                                $(controls.prefijo).val(ejemplar.prefijo);
                                $("input[id=idHorse]").val(ejemplar.codigo);
                                $("input[id=idHorsePdf]").val(ejemplar.codigo);

                                $(controls.nombre).val(ejemplar.nombre);
                                $(controls.madre).val(ejemplar.codYegua);
                                $(controls.padre).val(ejemplar.codPotro);


                                $(controls.yegua).html(ejemplar.nombreMadre);
                                $(controls.potro).html(ejemplar.nombrePadre);
                                $(controls.borrarMadre).show();
                                $(controls.borrarPadre).show();
                                 
                                $(controls.fecNace).val(ejemplar.fecNace);
                                $(controls.lugarNace).val(ejemplar.LugarNace);
                                $(controls.microchip).val(ejemplar.microchip);
                                $(controls.adn).val(ejemplar.adn);
                                $(controls.descripcion).val(ejemplar.descripcion);
                                $(controls.fecCapado).val(ejemplar.fecCapado);

                                $(controls.idMonta).val(ejemplar.idMonta);                               
                                $(controls.idNac).val(ejemplar.idNac);
                                $(controls.codigoMonta).html(ejemplar.codigoMonta);
                                $(controls.codigoNacimiento).html(ejemplar.codigoNacimiento);                               
                                $(controls.fecReg).val(ejemplar.fecReg);
                                $(controls.nroLibro).val(ejemplar.nroLibro);
                                $(controls.nroFolio).val(ejemplar.nroFolio);
                                $(controls.hidFecMonta).val(ejemplar.fecMonta);
                                $(controls.sexo).val(ejemplar.genero);
                                
                                if(ejemplar.idMetodo == 1){
                                  $(controls.metodoReproductivo).html("MONTA NATURAL");
                                  $(controls.metodo).val(ejemplar.idMetodo);
                                }else if(ejemplar.idMetodo==2){
                                  $(controls.metodoReproductivo).html("SEMEN FRESCO");
                                  $(controls.metodo).val(ejemplar.idMetodo);
                                }else if(ejemplar.idMetodo==3){
                                   $(controls.metodoReproductivo).html("SEMEN REFRIGERADO");
                                   $(controls.metodo).val(ejemplar.idMetodo);
                                }else if(ejemplar.idMetodo==4){
                                  $(controls.metodoReproductivo).html("SEMEN CONGELADO");
                                  $(controls.metodo).val(ejemplar.idMetodo);
                                }else if(ejemplar.idMetodo==5){
                                  $(controls.metodoReproductivo).html("Transferencia de embriones");
                                  $(controls.metodo).val(ejemplar.idMetodo);
                                }else if(ejemplar.idMetodo==6){
                                  $(controls.metodoReproductivo).html("Semen fresco con trasferencia de embriones");
                                  $(controls.metodo).val(ejemplar.idMetodo);
                                }

                                /*if(ejemplar.propietarios!=null){
                                      $(".gridHtmlBGProp tbody").html("");
                                      $(".gridHtmlBGProp tbody").append(retorno.html);
                                      initCtrolesGrillaTmpRE(1);
                                  }
                                  if(ejemplar.criadores!=null){
                                      $(".gridHtmlBGCri tbody").html("");
                                      $(".gridHtmlBGCri tbody").append(retorno.html2);
                                      initCtrolesGrillaTmpRE(2);
                                  }*/
                                 //$(controls.cboCria).val(idCriador);
                                // $(controls.sexo).attr("disabled","disabled");
                                 //$(controls.idMonta).attr("disabled","disabled");
                                 //$(controls.idNac).attr("disabled","disabled");
                                 $("#"+controls.cboIdNac).attr("disabled","disabled");
                                 //$("#trCastrado").hide();
                                   $("#txtFecCapado").attr("readonly",true); 
                                 if(ejemplar.genero=="P"){  
                                   //$("#trCastrado").show();
                                   $("#txtFecCapado").attr("readonly",false); 
                                    }
                                
                                  $(controls.areaResenas).val(ejemplar.resenasDescripcion);
                                  $("#lblResenia").text(ejemplar.resenasDescripcion);
                                  $(controls.fecServ).val(ejemplar.fecServ);
                              
                                  if(ejemplar.origen=="" || ejemplar.origen==null ){
                                    $(controls.origen).val(0);
                                  }else{
                                    $(controls.origen).val(ejemplar.origen);
                                  }
                             

                                //metodo reproductivo
                                //listarIdNacimiento("ddlIdNac","SELECCIONE","",$("#hidIdProp").val());
                                //console.log(ejemplar.idNac);
                               // console.log($("#hidIdProp").val());
                                //$("#ddlIdNac").val(ejemplar.idNac);
                                listarIdNacimiento(controls.cboIdNac,"SELECCIONE",ejemplar.idNac,$("#hidIdProp").val());
                                listarMetodoReprop(controls.cboMetodo,"SELECCIONE",ejemplar.idMetodo);
                                listarCriador(controls.cboCria, "SELECCIONE", ejemplar.idCriador);
                                listarPelaje(controls.cboPelaje,"SELECCIONE",ejemplar.idPelaje);
                                listarDeparmento(controls.cboDepartamento,"SELECCIONE",ejemplar.idProvincia);
                                $("#ddlCriador").attr("disabled","disabled");
                               
                        }else{ 
                             alertify.error(retorno.message);
                        }
                      }else if(retorno.result==K_ResultadoAjax.error){
                             alertify.error(retorno.message);
                        }
                    });
                }
}


function setGeneroTexto(genero){

 if(genero=="Y") return "YEGUA";
 else if(genero=="P") return "POTRO";
 else return "-";

}

function getInfoNacEjemplar(){

    var codigo =$("#"+controls.cboIdNac).val();
    //console.log("entro aquiiiiiiiii");
    if(codigo!=undefined){
     grlEjecutarAccion(controllersREST.ejemplar, {opc:'infoNac',codigo:codigo},function(retorno){
                        if(retorno.result==K_ResultadoAjax.exito){
                           var ejemplar=retorno.data;
                            if(ejemplar!=null){
                            // console.log(ejemplar.metodo);
                                $(controls.codigo).val(ejemplar.codigo);
                                $("#array").val(JSON.stringify(ejemplar.listResenas));
                                $(controls.nombre).val(ejemplar.nombre);
                                $(controls.prefijo).val(ejemplar.prefijo);
                                $(controls.madre).val(ejemplar.codYegua);
                                $(controls.padre).val(ejemplar.codPotro);
                                $(controls.yegua).html(ejemplar.nombreYegua);
                                $(controls.potro).html(ejemplar.nombrePotro);
                                $(controls.fecNace).val(ejemplar.fecha);
                                if(ejemplar.sexo =="P"){
                                  $(controls.sexo).val(ejemplar.sexo);
                                }else if(ejemplar.sexo =="Y"){
                                  $(controls.sexo).val(ejemplar.sexo);
                                }else{
                                  $(controls.sexo).val("0");
                                }
                               
                                $(controls.idMonta).val(ejemplar.idMonta);                               
                                $(controls.idNac).val(ejemplar.id); 
                                $(controls.codigoMonta).html(ejemplar.codigoMonta);
                                $(controls.codigoNacimiento).html(ejemplar.codigoNacimiento);
                                
                                if(ejemplar.metodo=="SF" && ejemplar.isTE==1 ){
                                  $(controls.metodoReproductivo).html("Semen fresco con trasferencia de embriones");
                                  $(controls.metodo).val(6);
                                }else if(ejemplar.metodo=="SF" && ejemplar.isTE==0){
                                  $(controls.metodoReproductivo).html("Semen fresco");
                                  $(controls.metodo).val(2);
                                }else if(ejemplar.metodo=="SC"){
                                   $(controls.metodoReproductivo).html("Semen congelado");
                                   $(controls.metodo).val(4);
                                }else if(ejemplar.metodo=="SR"){
                                   $(controls.metodoReproductivo).html("Semen refrigerado");
                                   $(controls.metodo).val(3);
                                }else if(ejemplar.metodo=="MN"){
                                  $(controls.metodoReproductivo).html("Monta Natural");
                                  $(controls.metodo).val(1);
                                }else if(ejemplar.metodo=="TE"){
                                  $(controls.metodoReproductivo).html("Transferencia de embriones");
                                  $(controls.metodo).val(5);
                                }
                                 
                                $(controls.microchip).val(ejemplar.microchip);
                                $(controls.descripcion).val(ejemplar.descripcion);
                                $(controls.lugarNace).val(ejemplar.LugarNace);
                                $(controls.hidFecMonta).val(ejemplar.fecMonta);
                                //metodo reproductivo
                               //listarMetodoReprop(controls.cboMetodo,"SELECCIONE",ejemplar.idMetodo);
                                $(controls.areaResenas).val(ejemplar.resenasDescripcion);
                                listarCriador(controls.cboCria, "SELECCIONE", ejemplar.idCriador);
                                listarPelaje(controls.cboPelaje,"SELECCIONE",ejemplar.pelaje);
                                listarDeparmento(controls.cboDepartamento,"SELECCIONE",ejemplar.idProvincia);
                               
                        }else{ 
                             alertify.error(retorno.message);
                        }
                      }else if(retorno.result==K_ResultadoAjax.error){
                             alertify.error(retorno.message);
                        }
                    });

}

}



 /*
function printer(obj){
  
  var prop = $("#hidIdProp").val();
  var codigoInscripcion=$(obj).data("id2");
  var id=$(obj).data("id");

  
    $(controls.modalDialogPrint+" .modal-title").html("Solicitud de Inscripcón.");
    $("#mvNuevoEjemplarPrintIns").data("action","insert");
    $("#mvNuevoEjemplarPrintIns").modal('show');


    if(id!=undefined){
  grlEjecutarAccion(controllersREST.ejemplar, {opc:'getInsPrint',codigo:id,codigoInscripcion:codigoInscripcion,prop:prop},function(response){

        if(response.result==K_ResultadoAjax.exito){
            var ejemplar=response.data;
           // console.log(ejemplar);
            
            $.each(ejemplar,function(index,value){
             // console.log(value);
            $("#lblNombrePrint").html(value.nombre);
            $("#lblfechaCreaPrint").html(value.fecCrea);
            if(value.genero=="P"){
              $("#lblSexoPrint").html("POTRO");  
            }else{
              $("#lblSexoPrint").html("YEGUA");  
            }
            $("#lblPelajePrint").html(value.pelaje);
            $("#lblFechaNacPrint").html(value.fecNace);
            $("#lblCodigoMontaPrint").html(value.codigoMonta);
            $("#lblCodigoNacimientoPrint").html(value.codigoNacimiento);
            $("#txtFotoPrint").prop("disabled",true);
            if(value.foto==0){
            $("#txtFotoPrint").val("");  
            }else{
            $("#txtFotoPrint").val("X");  
            }

            if(value.foto==0){
            $("#txtFotoPrint1").val("");  
            }else{
            $("#txtFotoPrint1").val("X");  
            }
            

            $("#lblPropPrint").html(value.propietario);
            $("#lblIDCriadorPrint").html(value.idCriador);
            $("#lblCriadorPrint").html(value.criador);
            $("#lblLocalidadPrint").html(value.LugarNace);


            $("#lblPadrePrint").html(value.prefijoPadre + value.nombrePadre);
            $("#txtIdPadrePrint").val(value.idPadre);
            $("#txtIdPadrePrint").prop("disabled",true);
            $("#lblAbueloPadrePrint").html(value.prefijoAbueloPadre + value.nombreAbueloPadre);
            $("#txtIdAbueloPadrePrint").val(value.idAbueloPadre);
            $("#txtIdAbueloPadrePrint").prop("disabled",true);
            $("#lblAbuelaPadrePrint").html(value.prefijoAbuelaPadre + value.nombreAbuelaPadre);
            $("#txtIdAbuelaPadrePrint").val(value.idAbuelaPadre);
            $("#txtIdAbuelaPadrePrint").prop("disabled",true);
            $("#lblPelajePadrePrint").html(value.pelajePadre);

            $("#lblMadrePrint").html(value.prefijoMadre + value.nombreMadre);
            $("#txtIdMadrePrint").val(value.idMadre);
            $("#txtIdMadrePrint").prop("disabled",true);
            $("#lblAbueloMadrePrint").html(value.prefijoAbueloMadre + value.nombreAbueloMadre);
            $("#txtIdAbueloMadrePrint").val(value.idAbueloMadre);
            $("#txtIdAbueloMadrePrint").prop("disabled",true);
            $("#lblAbuelaMadrePrint").html(value.prefijoAbuelaMadre + value.nombreAbuelaMadre);
            $("#txtIdAbuelaMadrePrint").val(value.idAbuelaMadre);
            $("#txtIdAbuelaMadrePrint").prop("disabled",true);
            $("#lblPelajeMadrePrint").html(value.pelajeMadre);

            $("#lblReseñaPrint").html(response.html);

            if(value.metodo!=null){
                if(value.metodo=="MN"){
                  $("#tdMN").css({"background-color": "#37EE1A"});
                  $("#tdSF").css("background-color", "");
                  $("#tdSR").css("background-color", "");
                  $("#tdSC").css("background-color", "");
                }else if(value.metodo=="SF"){
                  $("#tdMN").css("background-color", "");
                  $("#tdSF").css({"background-color": "#37EE1A"});
                  $("#tdSR").css("background-color", "");
                  $("#tdSC").css("background-color", "");
                }else if(value.metodo=="SR"){
                  $("#tdMN").css("background-color", "");
                  $("#tdSF").css("background-color", "");
                  $("#tdSR").css({"background-color": "#37EE1A"});
                  $("#tdSC").css("background-color", "");
                }else if(value.metodo=="SC"){
                  $("#tdMN").css("background-color", "");
                  $("#tdSF").css("background-color", "");
                  $("#tdSR").css("background-color", "");
                  $("#tdSC").css({"background-color": "#37EE1A"});
                }
            }else{
                   $("#tdMN").css("background-color", "");
                  $("#tdSF").css("background-color", "");
                  $("#tdSR").css("background-color", "");
                  $("#tdSC").css("background-color", "");
            }

            $("#lblIdRecep").html(value.idReceptor);

            });
            

        }

      });
    }

}

function imprimir(){

 printElement(document.getElementById("printThis"));

}



function printElement(elem) {
    var domClone = elem.cloneNode(true);
    var $printSection = document.getElementById("printSection");
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
   }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
     var a = document.getElementById("printSection");
    let body = document.querySelector('body');

    body.style.setProperty('-webkit-print-color-adjust', 'exact');
   //window.print();
    $("div#printSection").printArea();
     return( false );
}*/


function printInscripcion(obj){
      
   var prop = $("#hidIdProp").val();
  var codigoInscripcion=$(obj).data("id2");
  var id=$(obj).data("id");


                grlCenterWindow(1000,600,50,'printInscripcion.php?codigo='+id+'&codigoInscripcion='+codigoInscripcion+'&prop='+prop,'demo_win');     
    
}

