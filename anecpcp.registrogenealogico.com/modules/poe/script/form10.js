var K_PATH_ROOT = "../";
var separadorResenia = ", ";
var setting = {
  limitDayBorn: 365,
  /*334=11 meses*/
  limitInitDayBorn: 304 /*10 meses*/
};
var action = {
  insert: 1,
  modify: 2,
  view: 3,
  unsubcribe: 4 /**dar de baja */
}
var controllers = {
  ejemplar: K_PATH_ROOT + 'ajax/ajaxEjemplar.php'
  //ejemplarJQGRID:K_PATH_ROOT+'ajax/ajaxEjemplarJQgrid.php',
  //impresion:K_PATH_ROOT+'ajax/ajaxImpresion.php',
}
var controllersREST = {
  ejemplar: K_PATH_ROOT + 'services/ejemplarService.php',
  imagen: K_PATH_ROOT + 'services/ImagenService.php'
  //ejemplarJQGRID:K_PATH_ROOT+'ajax/ajaxEjemplarJQgrid.php',
  //impresion:K_PATH_ROOT+'ajax/ajaxImpresion.php',
}
/* controls: Objeto Json que contiene los  IDs de los controles que se crean en el html */
//formulario:"#divContainer",
var controls = {
  actions: "#hidActionPopup",
  modalDialog: "#mvNuevoNacEjemplar",
  mvNuevoEjemplarPrint: "#mvNuevoEjemplarPrint",
  modalDialogImg: "#mvImgEjemplar",
  modalDialogPdf: "#mvPdfEjemplar",
  modalDialogLog: "#mvLogSolicitudDeta",
  modalDialogFac: "#mvFalleceEjemplar",
  modalDialogSuperCamp: "#mvSuperCamp",
  modalDialogPrint: "#mvPrintCertificado",
  buttonPrintTransf: "#btnPrintHorseTransf",
  modalUploadImg: "#mvUploadImagen",
  buttonPrint: "#btnPrintHorse",
  buttonPrintCE: "#btnPrintCE",
  buttonDead: "#btnFallece",
  buttonNew: "#btnNewRE2",
  buttonSave: "#btnSaveNE",
  buttonDel: "#btnEliminar",
  buttonEdit: "#btnEditarR",
  buttonView: "#btnVer",
  buttonCancel: "#btnCancelar",
  buttonSaveFac: "#btnSaveFac",
  buttonSaveImg: "#btnUpload",
  buttonSuperCamp: "#btnSuperCamp",
  /*CONTROLES MODALVIEW NEO-INSERT*/
  codigo: "#hidCodigo",
  prefijo: "#txtPrefijo",
  cboPelaje: "ddlTipoPel",
  nombre: "#txtNombre",
  madre: "#hidIdMadre",
  padre: "#hidIdPadre",
  mostraMadre: "#lblMadre",
  mostraPadre: "#lblPadre",
  borrarMadre: "#lblBorrarMadre",
  borrarPadre: "#lblBorrarPadre",
  fecNace: "#dtFechaNac",
  lugarNace: "#txtLugarNac",
  microchip: "#txtMicrochip",
  adn: "#txtAdn",
  descripcion: "#txtDescripcion",
  sexo: "#ddlGenero",
  fecCapado: "#txtFecCapado",
  fecServ: "#dtpFechServ",
  cboMetodo: "ddlMetodo",
  yegua: "#lblYegua",
  potro: "#lblPotro",
  metodoReproductivo: "#lblMetRep",
  metodo: "#hidMetodo",
  codigoIns: "#hidCodigo",
  motivo: "#txtMotivo",
  fecFallece: "#dtFecha",
  ejemplar: "#lblEjemplar",
  ejemplarSuperCamp: "#lblEjemplarSC",
  idMonta: "#hidIdMonta",
  codigoMonta: "#lblIdMonta",
  codigoNacimiento: "#lblIdNac",
  idNac: "#hidIdNac",
  cboDepartamento: "ddlProvinvia",
  origen: "#ddlOrigen",
  reseniasLeft: "#ddlReseniaLeft",
  reseniasRight: "#ddlReseniaRight",
  fecReg: "#dtpFechReg",
  nroLibro: "#txtNumeroLibro",
  nroFolio: "#txtNumeroFolio",
  areaResenas: "#txtAResenia",
  hidFecMonta: "#hidFecMonta",
  mostrarFechaEmbrion: "#lblFecEmbrion",
  mostrarIdReceptora: "#lblIdReceptora",
  // BUSQUEDA POR COMBO
  cboProp: "ddlProps",
  cboCria: "ddlCriador",
  cboIdMonta: "ddlIdMonta",
  // BUSQUEDA POR FILTROS
  cboPelajeFiltro: "cboPelajeFiltro",
  filtroNombre: "#filtroNombre",
  cboGenero: "#cboGenero",
  txtFecNac: "#txtFecNac",
  txtMadre: "#txtMadre",
  txtPadre: "#txtPadre",
  cboEstado: "#cboEstado",
  //DAR BAJA
  txtMotivoBaja: "#txtMotivoBaja",
  txtFechaBaja: "#txtFechaBaja",
  txtDetalleBaja: "#txtDetalleBaja"
};
var events = {
  click: "click",
  change: "change",
  keypress: "keypress"
};
var mensaje = {
  mensajeBorrar: "Está seguro que desea eliminar la información?",
}
let $resenias = [];
$(document).ready(function () {

  listarPelaje("cboPelajeFiltro", "TODOS");

  $('[data-toggle="tooltip"]').tooltip();
  $("#btnPrint").on("click", function () {
    viewForm(9, $("#hidIdProp").val(), $("#hidIdPoe").val());
  }).button({
    icons: {
      primary: "ui-icon-print"
    }
  });
  listarEstados("cboEstado", "TODOS", 0);
  listarMotivoBaja("txtMotivoBaja", "SELECCIONE", 0);

  $("#btnAgregar").on("click", function () {
    agregarItems();
  });
  $("#btnSaveNE").on("click", function () {
    insert();
  });

  $("#btnBuscarFiltro").on("click", function () {
    listaNacimientos();
  });

  $("#btnSaveBaja").on("click", function () {
    btnSaveBaja();
  });
  $("#btnCancelar").on("click", function () {
    listarTranf();
    listarAdqui();
  }).button({
    icons: {
      primary: "ui-icon-cancel"
    }
  });
  $("#busquedaRe").on("keypress", function (e) {
    buscarResenia();
  });
  listaNacimientos();

  $("#btnLimpiarFiltro").on("click", function () {
    limpiarFiltros();
    listaNacimientos();
  });
  //limpiarBusqueda();
  /*INIT POPUP MODAL BUSCAR EJEMPLAR*/
  $("#btnBuscarMadre").on("click", function () {
    $("#hidOrigenBuscador").val("Y");
    $("#mvBuscadorEjemplarGrl").modal('show');
    $("#txtBGNombreEjemplar").val("");
    initDataTableGrlEjemplar();
  });
  $("#btnBuscarPadre").on("click", function () {
    $("#hidOrigenBuscador").val("P");
    $("#mvBuscadorEjemplarGrl").modal('show');
    $("#txtBGNombreEjemplar").val("");
    initDataTableGrlEjemplar();
  });


  $("#btnFiltrarResena").on("click", function () {
    buscarResenia();
  });

  filtrosResenias();

  $("#btnBuscarResenia").on("click", function () {
    configCheckResenias('');
    openGrlResena('ALL', '', '', '', '', '');
    $("#mvBuscadorResenaGrl").modal('show');
  });
  /*FIN POPUP MODAL BUSCAR EJEMPLAR*/
  limpiarLabelEjemplar();
  listarCriador(controls.cboCria, "SELECCIONE", $("#hidIdEntidad").val());
  listarPelaje("ddlTipoPel", "SELECCIONE");

  botonesOrdenar();

  listarDeparmento("ddlProvinvia", "SELECCIONE");
  listarMetodoReprop("ddlMetodo", "SELECCIONE");
  //listarResenia("ddlReseniaLeftCA", "", "");
  //configfiltrosReseniasesenas();
  // listarResenia("ddlReseniaLeftAD", "", "AD");
  // listarResenia("ddlReseniaLeftAI", "", "AI");
  // listarResenia("ddlReseniaLeftPD", "", "PD");
  // listarResenia("ddlReseniaLeftPI", "", "PI");
  listarTipoDocumento("ddlTipoDocumento", "SELECCIONE");
  settingResenia();

  //$('#'+controls.cboCria).attr("disabled",true);
  $("#ddlCriador").attr("disabled", "disabled");
  //listarIdNacimiento("ddlIdNac","SELECCIONE");
  $("#btnLimpiarResena").on("click", function () {
    limpiarBusqueda();
  });
  $(".btn-pref .btn").click(function () {
    $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
    $(this).removeClass("btn-default").addClass("btn-primary");
  });
});

var limpiarFiltros = function () {

  $(controls.cboEstado).val('');
  $(controls.filtroNombre).val('');
  $(controls.cboGenero).val(0);
  $("#" + controls.cboPelajeFiltro).val(0);
  $(controls.txtFecNac).val('');
  $(controls.txtPadre).val('');
  $(controls.txtMadre).val('');
  $("#cboEstado").selectpicker("refresh");
  $("#" + controls.cboPelajeFiltro, ).selectpicker("refresh");
  $(controls.cboGenero).selectpicker("refresh");
}


var listaNacimientos = function () {

  var pelaje = $("#" + controls.cboPelajeFiltro).val() != 0 && $("#" + controls.cboPelajeFiltro).val() != 'TODOS' ? $("#" + controls.cboPelajeFiltro).val() : '';
  var genero = $(controls.cboGenero).val() != 0 && $(controls.cboGenero).val() != 'TODOS' ? $(controls.cboGenero).val() : '';
  var estado = $(controls.cboEstado).val() != 0 && $(controls.cboEstado).val() != 'TODOS' ? $(controls.cboEstado).val() : '';

  /* console.log("pelaje",$("#" + controls.cboPelajeFiltro).val());
  console.log("estado",$(controls.cboEstado).val());
  console.log("genero",$(controls.cboGenero).val());
*/
  $.ajax({
    data: {
      opc: 'lstNac',
      idPoe: $("#hidIdPoe").val(),
      idProp: $("#hidIdProp").val(),
      estado: estado,
      nombre: $(controls.filtroNombre).val(),
      genero: genero,
      idPelaje: pelaje,
      fecNac: $(controls.txtFecNac).val(),
      madre: $(controls.txtMadre).val(),
      padre: $(controls.txtPadre).val()
    },
    url: controllersREST.ejemplar,
    type: 'POST',
    beforeSend: function (request) {
      request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
    },
    success: function (response) {
      var retorno = JSON.parse(response);
      //console.log(retorno);
      if (retorno.result == "1") {
        var data = retorno.data;
        setDataTable(data, retorno.cantidad);
      } else {
        alertify.error(retorno.message);
      }
    }
  });
};
var setDataTable = function (data, numRow) {
  $('#grid').DataTable({
    data: data,
    language: {
      search: "Búsqueda:",
      lengthMenu: "Mostrar _MENU_ registros por página",
      zeroRecords: "No se encontraron registros",
      info: "Página  _PAGE_ de _PAGES_",
      infoEmpty: "No se encontraron registros"
    },
    responsive: true,
    destroy: true,
    aaSorting: [],
    pageLength: 100,
    columns: [{
        "data": "codigoNacimiento"
      },
      {
        "data": "prefijo"
      },
      {
        "data": "nombre"
      },
      {
        "data": "genero",
        render: function (datum, type, row) {
          if (datum === "Y") return "YEGUA";
          else return "POTRO";
        }
      },
      {
        "data": "idPelaje"
      },
      {
        "data": "fecNace",
        "render": function (datum, type, row) {
          if (datum != '' && datum != null) {
            var dia = (datum).split("/")[0];
            var mes = (datum).split("/")[1];
            var anio = (datum).split("/")[2];
            return "<span class='hidden'>" + anio + mes + dia + "</span>" + datum;
          }

        }
      },
      {
        "data": "criador"
      },
      {
        "data": "nombreMadre"
      },
      {
        "data": "nombrePadre"
      },
      {
        "data": "estadoSolTexto",
        render: function (datum, type, row) {
          var estadoTexto = "";
          switch (row.estadoSolId) {
            case 'INI':
              estadoTexto = "<span class='badge badge-warning badge-normal  '>" + row.estadoSolTexto + "</span>";
              break;
            case 'APR':
              estadoTexto = "<span class='badge badge-success badge-normal  '>" + row.estadoSolTexto + "</span>";
              break;
            case 'REC':
              estadoTexto = "<span class='badge badge-danger badge-normal  '>" + row.estadoSolTexto + "</span>";
              break;
            case 'OBS':
              estadoTexto = "<span class='badge badge-primary badge-normal  '>" + row.estadoSolTexto + "</span>";
              break;
            case 'REV':
              estadoTexto = "<span class='badge badge-info badge-normal  style='background-color: #5bc0de;''>" + row.estadoSolTexto + "</span>";
              break;
            case 'SUBS':
              estadoTexto = "<span class='badge badge-info badge-normal  '>" + row.estadoSolTexto + "</span>";
              break;
            case 'BAJ':
              estadoTexto = "<span class='badge badge-default badge-normal  '>" + row.estadoSolTexto + "</span>";
              break;
          }

          return estadoTexto
        }
      },
      {
        "data": "fecSolicitud",
        "render": function (datum, type, row) {
          if (datum != '' && datum != null) {
            var dia = (datum).split("/")[0];
            var mes = (datum).split("/")[1];
            var anio = (datum).split("/")[2];
            return "<span class='hidden'>" + anio + mes + dia + "</span>" + datum;
          }

        }
      },
      {
        "className": 'edit',
        "orderable": false,
        "data": null,
        "defaultContent": "",
        "render": function (obj) {
          //console.log(obj.estadoSolId);
          var rowTable = '';
          if (obj.estadoSolId === "REC") {
            // rowTable = "<span title='Modificar Solicitud' class='btn btn-default btn-xs glyphicon glyphicon-edit' data-toggle='tooltip'  data-id='" + obj.id + "' data-estado='" + obj.estadoSolTexto + "' onclick='edit(this);'></span> ";
            rowTable = "<span title='Vista Previa' class='btn btn-default btn-xs glyphicon glyphicon-eye-open' data-toggle='tooltip'  data-id='" + obj.id + "' data-estado='" + obj.estadoSolTexto + "' onclick='vistaPrevia(this);'></span>";
            rowTable = rowTable + "<span title='Imprimir Nacimiento Ejemplar' class='btn btn-default btn-xs glyphicon glyphicon-print' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoNacimiento + "' onclick='printNacimiento(this);'></span>";
            rowTable = rowTable + "<span title='Seguimiento a Solicitud' class='btn btn-default btn-xs glyphicon glyphicon-comment' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoNacimiento + "' onclick='verLog(this);'></span>";
          } else if (obj.estadoSolId === "APR") {

            rowTable = "<span title='Vista Previa' class='btn btn-default btn-xs glyphicon glyphicon-eye-open' data-toggle='tooltip'  data-id='" + obj.id + "' data-estado='" + obj.estadoSolTexto + "' onclick='vistaPrevia(this);'></span>";
            rowTable = rowTable + "<span title='Imprimir Nacimiento Ejemplar' class='btn btn-default btn-xs glyphicon glyphicon-print' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoNacimiento + "' onclick='printNacimiento(this);'></span>";
            rowTable = rowTable + "<span title='Seguimiento a Solicitud' class='btn btn-default btn-xs glyphicon glyphicon-comment' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoNacimiento + "' onclick='verLog(this);'></span>";
            rowTable = rowTable + "<span title='Dar Baja' class='btn btn-default btn-xs glyphicon glyphicon-minus-sign' data-toggle='tooltip' data-id='" + obj.id + "' data-estado='" + obj.estadoSolTexto + "' onclick='darBaja(this);'></span>"
          } else if (obj.estadoSolId === "BAJ") {
            rowTable = "<span title='Vista Previa' class='btn btn-default btn-xs glyphicon glyphicon-eye-open' data-toggle='tooltip'  data-id='" + obj.id + "' data-estado='" + obj.estadoSolTexto + "' onclick='vistaPrevia(this);'></span>";
            rowTable = rowTable + "<span title='Imprimir Nacimiento Ejemplar' class='btn btn-default btn-xs glyphicon glyphicon-print' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoNacimiento + "' onclick='printNacimiento(this);'></span>";
            rowTable = rowTable + "<span title='Seguimiento a Solicitud' class='btn btn-default btn-xs glyphicon glyphicon-comment' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoNacimiento + "' onclick='verLog(this);'></span>";
          } else {
            rowTable = "<span title='Modificar Solicitud' class='btn btn-default btn-xs glyphicon glyphicon-edit' data-toggle='tooltip'  data-id='" + obj.id + "' data-estado='" + obj.estadoSolTexto + "' onclick='edit(this);'></span>";
            rowTable = rowTable + "<span title='Vista Previa' class='btn btn-default btn-xs glyphicon glyphicon-eye-open' data-toggle='tooltip'  data-id='" + obj.id + "' data-estado='" + obj.estadoSolTexto + "' onclick='vistaPrevia(this);'></span>";
            rowTable = rowTable + "<span title='Imprimir Nacimiento Ejemplar' class='btn btn-default btn-xs glyphicon glyphicon-print' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoNacimiento + "' onclick='printNacimiento(this);'></span>";
            rowTable = rowTable + "<span title='Seguimiento a Solicitud' class='btn btn-default btn-xs glyphicon glyphicon-comment' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoNacimiento + "' onclick='verLog(this);'></span>";
            rowTable = rowTable + "<span title='Dar Baja' class='btn btn-default glyphicon btn-xs glyphicon-minus-sign' data-toggle='tooltip' data-id='" + obj.id + "' data-estado='" + obj.estadoSolTexto + "' onclick='darBaja(this);'></span>"
            rowTable = rowTable + "<span title='Eliminar Solicitud' class='btn btn-default btn-xs glyphicon glyphicon-trash' data-toggle='tooltip'   data-id='" + obj.id + "' onclick='deleteNAC(this);' ></span>";
          }

          return rowTable;

        }
      }
    ]
  });
  $("#lblCantidadSol").html(numRow);
  $('[data-toggle="tooltip"]').tooltip();
  // $('#grid tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
};

function agregarItems() {

  grlEjecutarAccion(controllersREST.ejemplar, {
    opc: 'getLastIDNac'
  }, function (retorno) {
    let id = 0;
    if (retorno.data == null) {
      id = 1;
    } else {
      var ejemplar = retorno.data;
      id = parseInt(ejemplar.id) + 1;
    }

    var idPropietario = $("#hidIdProp").val();
    var codigoGenerado = "00" + id + "-" + idPropietario;
    configInsert(codigoGenerado);
  });

}

function insert() {
  alertify.confirm("Está seguro de registrar la información?", function (e) {
    if (e) {

      grlEjecutarAccion(controllers.ejemplar, {
        opc: 'val',
        fecServ: $(controls.fecServ).val(),
        fecNace: $(controls.fecNace).val(),
        idmadre: $(controls.madre).val(),
        idHijo: $(controls.codigo).val()
      }, function (retorno) {
        // console.log(retorno.result);
        if (retorno.result === K_ResultadoAjax.exito) {
          update();
        } else if (retorno.result === K_ResultadoAjax.error) {
          alertify.confirm('Advertencia', 'La fecha de nacimiento y la fecha de servicio es inconsistente verificarlo. Desea continuar ?',
            function () {
              update();
            },
            function () {});
        } else if (retorno.result === K_ResultadoAjax.warning) {
          alertify.confirm('Advertencia', 'Existe traslape del ejemplar a registrar con las crias de la madre' + ' : ' + $("#lblMadre").html() + ' ' + '.Desea Continua ?',
            function () {
              update();
            },
            function () {}
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





var update = function () {


  var date1 = new Date($(controls.hidFecMonta).val());
  var date2 = new Date($(controls.fecNace).val());

  var diffTime = Math.abs(date2 - date1);
  var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

  //console.log(diffDays,' >= ',setting.limitDayBorn);

  var lstItemPropietario = ""; //getIdEntidad();
  // console.log("PELAJE INSERT", $('#' + controls.cboPelaje).val());
  var data = {
    opc: '-',
    codigo: $(controls.codigo).val() == undefined ? '' : $(controls.codigo).val(),
    prefijo: $(controls.prefijo).val() == undefined ? '' : $(controls.prefijo).val(),
    nombre: $(controls.nombre).val(),
    fecNace: $(controls.fecNace).val(),
    padre: $(controls.padre).val(),
    madre: $(controls.madre).val(),
    //padre:$(controls.potro).text(),
    //yegua:$(controls.yegua).text(),
    idPelaje: $('#' + controls.cboPelaje).val(),
    lugarNace: $(controls.lugarNace).val(),
    microchip: $(controls.microchip).val(),
    adn: $(controls.adn).val(),
    descripcion: $(controls.descripcion).val(),
    entidad: lstItemPropietario, //JSON.stringify(lstItemPropietario),
    genero: $(controls.sexo).val(),
    fecCapado: $(controls.fecCapado).val(),
    idMonta: $(controls.idMonta).val(),
    idNac: $(controls.idNac).val(),
    idProvincia: $('#' + controls.cboDepartamento).val(),
    origen: $(controls.origen).val(),
    resenias: $(controls.areaResenas).val(),
    fecReg: $(controls.fecReg).val(),
    nroLibro: $(controls.nroLibro).val(),
    nroFolio: $(controls.nroFolio).val(),
    fecServ: $(controls.fecServ).val(),
    idMetodo: $(controls.metodo).val(),
    idPoe: $("#hidIdPoe").val(),
    idProp: $("#hidIdProp").val(),
    idCriador: $("#" + controls.cboCria).val(),
    arrayResenias: $("#array").val(),
    codigoGenerado: $("input[id=hidCodigoGenerado]").val(),
    arrayIdImg: JSON.stringify(collectionID),
    arrayIdPdf: JSON.stringify(collectionIDPdf),
    reseniaBasica: $("#txtReseniaBasica").val()
  };

  console.log($("#txtReseniaBasica").val());
  //console.log(data);
  if ($(controls.modalDialog).data("action") != "insert") {
    data.opc = 'updNac';
  } else {
    data.opc = 'insNac';
  }

  if (data.idMonta === "") {
    alertify.error("Debe seleccionar un código de monta");
  } else {
    if (diffDays >= setting.limitInitDayBorn && diffDays <= setting.limitDayBorn) {
      if (grlValidarObligatorio(controls.modalDialog)) {
        if ($("#ddlCriador").val() != 0) {
          $("#ddlCriador").css({
            'border': '1px solid #ccc'
          });
          //console.log($("#ddlTipoPel").val());
          if ($("#ddlTipoPel").val() == 0 || $("#ddlTipoPel").val() == "SELECCIONE" || $("#ddlTipoPel").val() == "") {
            $("button[data-id='ddlTipoPel']").css({
              'border': '1px solid red'
            });
            alertify.error("Debe ingresar los campos requeridos ");
          } else {
            $("button[data-id='ddlTipoPel']").css({
              'border': '1px solid #ccc'
            });

            if ($("#hiddenImgIns").val() == undefined) {
              alertify.error("Debe adjuntar mínimo una imagen del ejemplar");
            } else {
              if (data.opc != "-") {
                grlEjecutarAccion(controllersREST.ejemplar, data, function (retorno) {
                  if (retorno.result === K_ResultadoAjax.exito) {

                    grlEjecutarAccion(controllersREST.ejemplar, {
                      opc: 'getLastIDNac'
                    }, function (retorno) {
                      var ejemplar = retorno.data;
                      // console.log(ejemplar);
                      if (retorno.result === K_ResultadoAjax.exito && data.opc == "insNac") {
                        alertify.alert("Se registró un nacimiento con el código : " + ejemplar.codigoNacimiento, function () {
                          alertify.success(retorno.message);
                        });
                        // alertify.success(retorno.message);
                        $("#mvNuevoNacEjemplar").modal("hide");
                      } else {
                        alertify.alert("Se actualizó un nacimiento con el código : " + $("#hidCodigoNacimiento").val(), function () {
                          alertify.success(retorno.message);
                        });
                        // alertify.success(retorno.message);
                        $("#mvNuevoNacEjemplar").modal("hide");
                      }
                    });
                  } else if (retorno.result === K_ResultadoAjax.error) {
                    alertify.set('notifier', 'delay', 10);
                    alertify.error(retorno.message);
                    //console.log('hola');
                  } else if (retorno.result === K_ResultadoAjax.warning) {
                    alertify.warning(retorno.message);
                    //console.log('hola');
                  } else if (retorno.result === K_ResultadoAjax.duplicate) {
                    alertify.error(retorno.message);

                  }
                  search();
                });
              } else {
                alertify.error(messages.noDeterminated);

              }
            }
          }

        } else {
          alertify.error("Debe Seleccionar un criador");
          $("#ddlCriador").css({
            'border': '1px solid red'
          });
        }
      }
    } else {
      alertify.alert("La fecha de nacimiento seleccionada no esta dentro del tiempo de gestación de ejemplares", function () {

      });
    }
  }
};

function clearCtrlsPopup() {
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
  $(controls.sexo).attr("enable", false);
  $(controls.mostrarFechaEmbrion).html("");
  $(controls.mostrarIdReceptora).html("");
  //$(controls.idMonta).attr("disabled",false);
  //$(controls.idNac).attr("disabled",false);
  $("#" + controls.cboIdMonta).prop("disabled", false);
  //limpiarSesionTMPEntes();
  $("#hidCodigoNacimiento").val("");
  $("#array").val("");
  $(controls.hidFecMonta).html("");
  $("#lblResenia").text("");

  $(controls.prefijo).prop("disabled", false);
  $(controls.nombre).prop("disabled", false);
  $(controls.fecNace).prop("disabled", false);

  $("#ddlTipoPel").prop("disabled", false);
  $(controls.lugarNace).prop("disabled", false);
  $(controls.microchip).prop("disabled", false);
  $(controls.descripcion).prop("disabled", false);
  $(controls.motivo).prop("disabled", false);
  $("#ddlOrigen").prop("disabled", false);
  $("#ddlGenero").prop("disabled", false);
  $("#ddlProvinvia").prop("disabled", false);
  $("#btnBuscarResenia").show();
  $("#ddlCriador").attr("disabled", "disabled");
  $("#btnSaveNE").show();
  $("#submit-btn").show();
  $("#submit-btn-pdf").show();
  $("#imageInput").show();
  $("#pdfInput").show();
  $("#ddlTipoDocumento").show();
  $("#lblTipoD").show();
  // $("#btnDelE").show();
}

function search() {
  listaNacimientos();
}


function addImg(obj) {
  var id = $(obj).data("id");
  var codigoNacimiento = $(obj).data("id2");
  $(controls.modalDialogImg).modal("show");
  $("#idHorse").val(id);
  $("#lblDatoHorse").html($(obj).data("nombre") + ' - ' + $(obj).data("prefijo"));
  $("#lblIdSol").html("Nacimiento código: " + codigoNacimiento);
  listarImg(id);
}

function addCert(obj) {
  $("#idTipoDoc").val("");
  var id = $(obj).data("id");
  var codigoNacimiento = $(obj).data("id2");
  $(controls.modalDialogPdf).modal("show");
  $("#idHorsePdf").val(id);
  $("#lblDatoHorsePdf").html($(obj).data("nombre") + ' - ' + $(obj).data("prefijo"));
  $("#lblIdSolPdf").html("Nacimiento código: " + codigoNacimiento);
  listarPdf(id);
}

function verLog(obj) {
  //console.log(controls.modalDialogLog);
  var id = $(obj).data("id");
  var codigoNacimiento = $(obj).data("id2");
  listarEstadosS(id);
  $(controls.modalDialogLog + " .modal-title").html("SEGUIMIENTO DE SOLICITUD " + codigoNacimiento);
  //$(controls.modalDialog).data("action","edit");
  $(controls.modalDialogLog).modal("show");
}

function vistaPrevia(obj) {
  var id = $(obj).data("id");

  $(controls.prefijo).prop("disabled", true);
  $(controls.nombre).prop("disabled", true);
  $(controls.fecNace).prop("disabled", true);

  $("#ddlTipoPel").prop("disabled", true);
  $(controls.lugarNace).prop("disabled", true);
  $(controls.microchip).prop("disabled", true);
  $(controls.descripcion).prop("disabled", true);
  $(controls.motivo).prop("disabled", true);
  $("#ddlOrigen").prop("disabled", true);
  $("#ddlGenero").prop("disabled", true);
  $("#ddlProvinvia").prop("disabled", true);
  $("#btnBuscarResenia").hide();
  $("#ddlCriador").attr("disabled", "disabled");
  $("#btnSaveNE").hide();
  $("#submit-btn").hide();
  $("#submit-btn-pdf").hide();
  $("#imageInput").hide();
  $("#pdfInput").hide();
  $("#ddlTipoDocumento").hide();
  $("#lblTipoD").hide();

  editar(id, action.view);

}

function darBaja(obj) {
  var id = $(obj).data("id");
  listarMotivoBaja("txtMotivoBaja", "SELECCIONE", 0);
  $(controls.prefijo).prop("disabled", true);
  $(controls.nombre).prop("disabled", true);
  $(controls.fecNace).prop("disabled", true);
  //console.log($(controls.codigo).val());
  $("#ddlTipoPel").prop("disabled", true);
  $(controls.lugarNace).prop("disabled", true);
  $(controls.microchip).prop("disabled", true);
  $(controls.descripcion).prop("disabled", true);
  $(controls.motivo).prop("disabled", true);
  $("#ddlOrigen").prop("disabled", true);
  $("#ddlGenero").prop("disabled", true);
  $("#ddlProvinvia").prop("disabled", true);
  $("#btnBuscarResenia").hide();
  $("#ddlCriador").attr("disabled", "disabled");
  $("#submit-btn").hide();
  $("#submit-btn-pdf").hide();
  $("#imageInput").hide();
  $("#pdfInput").hide();
  $("#ddlTipoDocumento").hide();
  $("#lblTipoD").hide();

  editar(id, action.unsubcribe);

}

function edit(obj) {

  var id = $(obj).data("id");
  var estado = $(obj).data("estado");

  if (estado == "APROBADO" || estado == "RECHAZADO") {
    $(controls.prefijo).prop("disabled", true);
    $(controls.nombre).prop("disabled", true);
    $(controls.fecNace).prop("disabled", true);

    $("#ddlTipoPel").prop("disabled", true);
    $(controls.lugarNace).prop("disabled", true);
    $(controls.microchip).prop("disabled", true);
    $(controls.descripcion).prop("disabled", true);
    $(controls.motivo).prop("disabled", true);
    $("#ddlOrigen").prop("disabled", true);
    $("#ddlGenero").prop("disabled", true);
    $("#ddlProvinvia").prop("disabled", true);
    $("#btnBuscarResenia").hide();
    $("#ddlCriador").attr("disabled", "disabled");
    $("#btnSaveNE").hide();
    $("#submit-btn").hide();
    $("#submit-btn-pdf").hide();
    $("#imageInput").hide();
    $("#pdfInput").hide();
    $("#ddlTipoDocumento").hide();
    $("#lblTipoD").hide();
    //$("#btnDelE").hide();
    editar(id, action.modify);
  } else {
    $(controls.prefijo).prop("disabled", false);
    $(controls.nombre).prop("disabled", false);
    $(controls.fecNace).prop("disabled", false);

    $("#ddlTipoPel").prop("disabled", false);
    $(controls.lugarNace).prop("disabled", false);
    $(controls.microchip).prop("disabled", false);
    $(controls.descripcion).prop("disabled", false);
    $(controls.motivo).prop("disabled", false);
    $("#ddlOrigen").prop("disabled", false);
    $("#ddlGenero").prop("disabled", false);
    $("#ddlProvinvia").prop("disabled", false);
    $("#btnBuscarResenia").show();
    $("#ddlCriador").attr("disabled", "disabled");
    $("#btnSaveNE").show();
    $("#submit-btn").show();
    $("#submit-btn-pdf").show();
    $("#imageInput").show();
    $("#pdfInput").show();
    $("#ddlTipoDocumento").show();
    $("#lblTipoD").show();
    //$("#btnDelE").show();
    editar(id, action.modify);
  }


  //editar(id);

}

function deleteNAC(obj) {
  var id = $(obj).data("id");
  if (id != undefined) {
    alertify.confirm(mensaje.mensajeBorrar, function (e) {
      if (e) {
        grlEjecutarAccion(controllersREST.ejemplar, {
          opc: 'delNac',
          id: id
        }, function (retorno) {

          //console.log(retorno);
          if (retorno.result == K_ResultadoAjax.exito) {

            alertify.success(retorno.message);
            listaNacimientos();
          }
          /*else if(retorno.result == 995){
                                      alertify.alert(retorno.message + " "+retorno.data.codigoInscripcion,function(){

                                      });
                                      listaNacimientos();
                                  }*/
          else if (retorno.result == 2) {
            alertify.error(retorno.message);
            listaNacimientos();
          }

        });
      }
    });
  }
}


function limpiarLabelEjemplar() {
  $("#lblBorrarMadre").on('click', function () {
    $("#lblMadre").html("");
    $("#lblBorrarMadre").hide();
    $("#hidIdMadre").val("0");
  });
  $("#lblBorrarPadre").on('click', function () {
    $("#lblPadre").html("");
    $("#lblBorrarPadre").hide();
    $("#hidIdPadre").val("0");
  });
  $("#lblBorrarEjemplar").on('click', function () {
    $("#lblEjemplar").html("");
    $("#lblBorrarEjemplar").hide();
  });
}

function settingResenia() {
  $("#rightSelectedCA").on(events.click, function () {
    var a = 0;
    $("#ddlReseniaRightCA option").each(function () {
      if ($(this).val() == $('#ddlReseniaLeftCA option:selected').val()) {
        alertify.error("La reseña se encuentra agregada");
        a = a + 1;

      }
    });
    if (a == 0) {
      var controlLeft = $('#ddlReseniaLeftCA option:selected');
      $("#ddlReseniaRightCA").append("<option data-tp='" + controlLeft.attr('data-tp') + "' value='" + controlLeft.val() + "' title='" + controlLeft.text() + "'>" + controlLeft.text() + "</option>");
    }

    concatenarResenia();

  });
  $("#rightSelectedAD").on(events.click, function () {
    var a = 0;
    $("#ddlReseniaRightAD option").each(function () {
      if ($(this).val() == $('#ddlReseniaLeftAD option:selected').val()) {
        alertify.error("La reseña se encuentra agregada");
        a = a + 1;
      }
    });
    if (a == 0) {
      var controlLeft = $('#ddlReseniaLeftAD option:selected');
      $("#ddlReseniaRightAD").append("<option value='" + controlLeft.val() + "' title='" + controlLeft.text() + "'>" + controlLeft.text() + "</option>");

    }

    concatenarResenia();
  });

  $("#rightSelectedAI").on(events.click, function () {
    var a = 0;
    $("#ddlReseniaRightAI option").each(function () {
      if ($(this).val() == $('#ddlReseniaLeftAI option:selected').val()) {
        alertify.error("La reseña se encuentra agregada");
        a = a + 1;
      }
    });
    if (a == 0) {
      var controlLeft = $('#ddlReseniaLeftAI option:selected');
      $("#ddlReseniaRightAI").append("<option value='" + controlLeft.val() + "' title='" + controlLeft.text() + "'>" + controlLeft.text() + "</option>");

    }
    concatenarResenia();
  });


  $("#rightSelectedPD").on(events.click, function () {
    var a = 0;
    $("#ddlReseniaRightPD option").each(function () {
      if ($(this).val() == $('#ddlReseniaLeftPD option:selected').val()) {
        alertify.error("La reseña se encuentra agregada");
        a = a + 1;
      }
    });
    if (a == 0) {
      var controlLeft = $('#ddlReseniaLeftPD option:selected');
      $("#ddlReseniaRightPD").append("<option value='" + controlLeft.val() + "' title='" + controlLeft.text() + "'>" + controlLeft.text() + "</option>");

    }
    concatenarResenia();
  });

  $("#rightSelectedPI").on(events.click, function () {
    var a = 0;
    $("#ddlReseniaRightPI option").each(function () {
      if ($(this).val() == $('#ddlReseniaLeftPI option:selected').val()) {
        alertify.error("La reseña se encuentra agregada");
        a = a + 1;
      }
    });
    if (a == 0) {
      var controlLeft = $('#ddlReseniaLeftPI option:selected');
      $("#ddlReseniaRightPI").append("<option value='" + controlLeft.val() + "' title='" + controlLeft.text() + "'>" + controlLeft.text() + "</option>");

    }
    concatenarResenia();
  });

  $("#leftSelectedCA").on(events.click, function () {
    $('#ddlReseniaRightCA option:selected').remove();
    concatenarResenia();
  });

  $("#leftSelectedAD").on(events.click, function () {
    $('#ddlReseniaRightAD option:selected').remove();
    concatenarResenia();
  });

  $("#leftSelectedAI").on(events.click, function () {
    $('#ddlReseniaRightAI option:selected').remove();
    concatenarResenia();
  });
  $("#leftSelectedPD").on(events.click, function () {
    $('#ddlReseniaRightAD option:selected').remove();
    concatenarResenia();
  });
  $("#leftSelectedPI").on(events.click, function () {
    $('#ddlReseniaRightAD option:selected').remove();
    concatenarResenia();
  });


  $("#btnSaveResena").on(events.click, function () {
    //var concatValor = '';
    var collection = Array();
    var reseniaBasica = $("#txtReseniaBasica").val();
    $("#ddlReseniaRightCA option").each(function () {
      if ($(this).val() != "") {
        resena = {
          id: $(this).val(),
          descripcion: $(this).text(),
          tipo: $(this).attr('data-tp')
        };
        collection.push(resena);
      }
    });
    $("#ddlReseniaRightAD option").each(function () {
      if ($(this).val() != "") {
        resena = {
          id: $(this).val(),
          descripcion: $(this).text(),
          tipo: "AD"
        };
        collection.push(resena);
      }
    });
    $("#ddlReseniaRightAI option").each(function () {
      if ($(this).val() != "") {
        resena = {
          id: $(this).val(),
          descripcion: $(this).text(),
          tipo: "AI"
        };
        collection.push(resena);
      }
    });
    $("#ddlReseniaRightPD option").each(function () {
      if ($(this).val() != "") {
        resena = {
          id: $(this).val(),
          descripcion: $(this).text(),
          tipo: "PD"
        };
        collection.push(resena);
      }
    });
    $("#ddlReseniaRightPI option").each(function () {
      if ($(this).val() != "") {
        resena = {
          id: $(this).val(),
          descripcion: $(this).text(),
          tipo: "PI"
        };
        collection.push(resena);
      }
    });

    //console.log(collection);
    datos = JSON.stringify(collection);
    //console.log(datos);

    $.ajax({
      data: {
        opc: 'resSession',
        data: datos,
        reseniaBasica: reseniaBasica
      },
      //url:   K_PATH_ROOT+'ajax/ajaxEjemplar.php',
      url: controllersREST.ejemplar,
      type: 'post',
      success: function (response) {
        var retorno = JSON.parse(response);
        if (retorno.result == 1) {
          $("#mvBuscadorResenaGrl").modal('hide');
          $("#txtAResenia").val(retorno.html);
          $('#array').val(JSON.stringify(retorno.data));

          if (retorno.code == 1) {
            $("#txtReseniaBasica").val(retorno.html);
          } else {
            $("#txtReseniaBasica").val('');
          }

        } else if (retorno.result == 0) {
          alertify.error(retorno.message);
        } else if (retorno.result == 2) {
          $("#mdlMensaje").modal("show");
          $("#btnMantBasica").on(events.click, function () {
            $("#mvBuscadorResenaGrl").modal('hide');
            $("#mdlMensaje").modal("hide");
            $("#txtAResenia").val(retorno.valorB);
            $('#array').val('');
            $("#txtReseniaBasica").val(retorno.valorB);
            $("#lblResenia").html('');
            editResenias('');
          });
          $("#btnManAvanzada").on(events.click, function () {
            $("#txtReseniaBasica").val('');
            $("#mvBuscadorResenaGrl").modal('hide');
            $("#mdlMensaje").modal("hide");
            $("#txtAResenia").val(retorno.valorA);
            $('#array').val(JSON.stringify(retorno.data));
          });
        }


      }
    });

  });
}



function concatenarResenia() {
  var collection1 = Array();

  $("#ddlReseniaRightCA option").each(function () {
    if ($(this).val() != "") {
      textoResena = {
        descripcion: $(this).text()
      };
      collection1.push(textoResena);
    }
  });

  $("#ddlReseniaRightAD option").each(function () {
    if ($(this).val() != "") {
      textoResena = {
        descripcion: $(this).text()
      };
      collection1.push(textoResena);
    }
  });

  $("#ddlReseniaRightAI option").each(function () {
    if ($(this).val() != "") {
      textoResena = {
        descripcion: $(this).text()
      };
      collection1.push(textoResena);
    }
  });
  $("#ddlReseniaRightPD option").each(function () {
    if ($(this).val() != "") {
      textoResena = {
        descripcion: $(this).text()
      };
      collection1.push(textoResena);
    }
  });
  $("#ddlReseniaRightPI option").each(function () {
    if ($(this).val() != "") {
      textoResena = {
        descripcion: $(this).text()
      };
      collection1.push(textoResena);
    }
  });
  var texto = "";
  $.each(collection1, function (index, value) {
    //console.log(value);
    texto = (texto == "" ? texto : texto + separadorResenia) + value.descripcion;
  });
  //console.log(texto);
  $("#lblResenia").text(texto);
  //console.log(collection1);


}

function btnSaveBaja() {
  var codigo = $(controls.codigo).val();
  var motivoBaja = $("#txtMotivoBaja").val();
  var fechaBaja = $("#txtFechaBaja").val();
  var detalleBaja = $("#txtDetalleBaja").val();
  if (motivoBaja != 'SELECCIONE' && fechaBaja != '' && detalleBaja != '' && motivoBaja != null && motivoBaja != '') {
    /**/
    grlEjecutarAccion(controllersREST.ejemplar, {
      opc: 'updBajaNac',
      codigo: codigo,
      motivoBaja: motivoBaja,
      fechaBaja: fechaBaja,
      detalleBaja: detalleBaja,
      idProp: $("#hidIdProp").val()
    }, function (retorno) {
      // console.log(retorno);
      $("#mvNuevoNacEjemplar").modal("hide");
      $("#txtMotivoBaja").val('');
      $("#txtFechaBaja").val('');
      $("#txtDetalleBaja").val('');
      listaNacimientos();
      alertify.success(retorno.message);
    });
    //console.log(motivoBaja);
  } else {
    alertify.error("Complete todos los campos");
  }

}

function editar(codigo, operation) {
  editResenias('');
  EliminarDocumentosModal(0);
  EliminarDocumentosModal(1);
  if (codigo != undefined) {
    grlEjecutarAccion(controllersREST.ejemplar, {
      opc: 'getNac',
      codigo: codigo
    }, function (retorno) {
      //console.log(retorno);
      if (retorno.result == K_ResultadoAjax.exito) {
        var ejemplar = retorno.data;
        // console.log(ejemplar);
        if (ejemplar != null) {
          var estado = "<span class='badge " + setCssEstado(ejemplar.estadoSol) + "'>" + ejemplar.estadoSolTexto + "</span></td>";

          $(controls.modalDialog).data("action", "edit");
          $(controls.modalDialog).modal("show");
          // if (bandera != false && baja == false) {
          if (operation == action.view) {
            configView(ejemplar.codigoNacimiento, estado, ejemplar.codigo);
          } else if (operation == action.unsubcribe) {
            configUnsubcribe(ejemplar.codigoNacimiento, estado, ejemplar.codigo);
          } else {
            configModify(ejemplar.codigoNacimiento, estado, ejemplar.codigo);
          }
          $("#txtReseniaBasica").val(ejemplar.reseniaBasica);
          $(controls.codigo).val(ejemplar.codigo);
          $("#array").val(JSON.stringify(ejemplar.listResenas));
          $("#hidCodigoNacimiento").val(ejemplar.codigoNacimiento);
          $(controls.prefijo).val(ejemplar.prefijo);
          $("input[id=idHorse]").val(ejemplar.codigo);
          $("input[id=idHorsePdf]").val(ejemplar.codigo);

          $(controls.nombre).val(ejemplar.nombre);
          $(controls.madre).val(ejemplar.idMadre);
          $(controls.padre).val(ejemplar.idPadre);

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
          $(controls.codigoMonta).html(ejemplar.codigoMonta);
          $(controls.idNac).val(ejemplar.codigo);
          $(controls.codigoNacimiento).html(ejemplar.codigoNacimiento);
          $(controls.fecReg).val(ejemplar.fecReg);
          $(controls.nroLibro).val(ejemplar.nroLibro);
          $(controls.nroFolio).val(ejemplar.nroFolio);
          $(controls.hidFecMonta).val(ejemplar.fecMonta)
          $(controls.sexo).val(ejemplar.genero);


          $(controls.mostrarFechaEmbrion).html(ejemplar.fecEmbrion);
          $(controls.mostrarIdReceptora).html(ejemplar.idReceptor);


          if (ejemplar.idMetodo == 1) {
            $(controls.metodoReproductivo).html("MONTA NATURAL");
            $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 2) {
            $(controls.metodoReproductivo).html("SEMEN FRESCO");
            $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 3) {
            $(controls.metodoReproductivo).html("SEMEN REFRIGERADO");
            $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 4) {
            $(controls.metodoReproductivo).html("SEMEN CONGELADO");
            $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 5) {
            $(controls.metodoReproductivo).html("Transferencia de embriones");
            $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 6) {
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
          $("#" + controls.cboIdMonta).attr("disabled", "disabled");
          //$("#trCastrado").hide();
          $("#txtFecCapado").attr("readonly", true);
          if (ejemplar.genero == "P") {
            //$("#trCastrado").show();
            $("#txtFecCapado").attr("readonly", false);
          }
          //collection.push(JSON.stringify(ejemplar.listResenas));


          editResenias(ejemplar.listResenas);
          $(controls.areaResenas).val(ejemplar.resenasDescripcion);

          $("#lblResenia").text(ejemplar.resenasDescripcion);
          
          $(controls.fecServ).val(ejemplar.fecServ);

          if (ejemplar.origen == "" || ejemplar.origen == null) {
            $(controls.origen).val(0);
          } else {
            $(controls.origen).val(ejemplar.origen);
          }

          ///Bajaq
          $(controls.txtFechaBaja).val(ejemplar.fecFallece);
          $(controls.txtMotivoBaja).val(ejemplar.motivoFallece);
          $("#txtMotivoBaja").selectpicker("refresh");
          $(controls.txtDetalleBaja).val(ejemplar.detalleFallece);

          //metodo reproductivo
          listarIdMonta(controls.cboIdMonta, "SELECCIONE", ejemplar.idMonta, $("#hidIdProp").val());
          listarMetodoReprop(controls.cboMetodo, "SELECCIONE", ejemplar.idMetodo);
          listarCriador(controls.cboCria, "SELECCIONE", ejemplar.idCriador);
          listarPelaje(controls.cboPelaje, "SELECCIONE", ejemplar.idPelaje);
          //console.log(ejemplar.idPelaje);
          listarDeparmento(controls.cboDepartamento, "SELECCIONE", ejemplar.idProvincia);
          $("#ddlCriador").attr("disabled", "disabled");

        } else {
          alertify.error(retorno.message);
        }
      } else if (retorno.result == K_ResultadoAjax.error) {
        alertify.error(retorno.message);
      }
    });
  }
}


function setGeneroTexto(genero) {

  if (genero == "Y") return "YEGUA";
  else if (genero == "P") return "POTRO";
  else return "-";

}

function getInfoMonta() {


  var codigo = $("#" + controls.cboIdMonta).val();


  if (codigo != undefined) {
    grlEjecutarAccion(controllersREST.ejemplar, {
      opc: 'info',
      codigo: codigo
    }, function (retorno) {
      if (retorno.result == K_ResultadoAjax.exito) {
        var ejemplar = retorno.data;
        if (ejemplar != null) {
          //console.log(ejemplar);
          $(controls.codigo).val(ejemplar.codigo);
          $(controls.yegua).html(ejemplar.nombreYegua);
          $(controls.potro).html(ejemplar.nombrePotro);
          $(controls.madre).val(ejemplar.codYegua);
          $(controls.padre).val(ejemplar.codPotro);
          $(controls.codigoMonta).html(ejemplar.codigoMonta);
          $(controls.idMonta).val(ejemplar.codigo);
          $(controls.hidFecMonta).val(ejemplar.fecMonta);

          if (ejemplar.metodo == "SF" && ejemplar.isTE == 1) {
            $(controls.metodoReproductivo).html("Semen fresco con trasferencia de embriones");
            $(controls.metodo).val(6);
          } else if (ejemplar.metodo == "SF" && ejemplar.isTE == 0) {
            $(controls.metodoReproductivo).html("Semen fresco");
            $(controls.metodo).val(2);
          } else if (ejemplar.metodo == "SC") {
            $(controls.metodoReproductivo).html("Semen congelado");
            $(controls.metodo).val(4);
          } else if (ejemplar.metodo == "SR") {
            $(controls.metodoReproductivo).html("Semen refrigerado");
            $(controls.metodo).val(3);
          } else if (ejemplar.metodo == "MN") {
            $(controls.metodoReproductivo).html("Monta Natural");
            $(controls.metodo).val(1);
          } else if (ejemplar.metodo == "TE") {
            $(controls.metodoReproductivo).html("Transferencia de embriones");
            $(controls.metodo).val(5);
          }
          $("#txtReseniaBasica").val(ejemplar.reseniaBasica);
          editResenias(ejemplar.listResenas);
          $(controls.mostrarFechaEmbrion).html(ejemplar.fecEmbrion);
          $(controls.mostrarIdReceptora).html(ejemplar.idReceptor);
          //listarIdMonta(controls.cboIdMonta,"SELECCIONE",ejemplar.id);
          //metodo reproductivo
          //listarMetodoReprop(controls.cboMetodo,"SELECCIONE",ejemplar.idMetodo);
          // listarCriador(controls.cboCria, "SELECCIONE", ejemplar.idCriador);
          // listarPelaje(controls.cboPelaje,"SELECCIONE",ejemplar.pelaje);
          //  listarDeparmento(controls.cboDepartamento,"SELECCIONE",ejemplar.idProvincia);

        } else {
          alertify.error(retorno.message);
        }
      } else if (retorno.result == K_ResultadoAjax.error) {
        alertify.error(retorno.message);
      }
    });

  }

}


function printNacimiento(obj) {

  var prop = $("#hidIdProp").val();
  var codigoNacimiento = $(obj).data("id2");
  var id = $(obj).data("id");

  window.open('printNacimiento.php?codigo=' + id + '&codigoNacimiento=' + codigoNacimiento + '&prop=' + prop);
  //grlCenterWindow(1000, 600, 50, , 'demo_win');

}


var listarEstadosS = function (id) {
  $.ajax({
    data: {
      opc: 'lstEstNac',
      codigo: id
    },
    url: controllersREST.ejemplar,
    type: 'POST',
    success: function (response) {
      var retorno = JSON.parse(response);
      if (retorno.result == "1") {
        var data = retorno.data;
        getEstado(id);
        $("#tbEstado tbody").html("");
        $.each(data, filldatalog);
        $("#tbEstado tbody tr").css({
          "width": "100%"
        });
        $("#tbEstado tbody td").css({
          "width": "100%"
        });
      } else {
        alertify.error(retorno.message);
      }
    }
  });
};

var getEstado = function (id) {
  $.ajax({
    data: {
      opc: 'getNac',
      codigo: id
    },
    url: controllersREST.ejemplar,
    type: 'POST',
    beforeSend: function (request) {
      request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
    },
    success: function (response) {
      var retorno = JSON.parse(response);
      if (retorno.result == "1") {
        var data = retorno.data;
        var estado = "<span class='badge " + setCssEstado(data.estadoSol) + "'>" + data.estadoSolTexto + "</span>";
        $(controls.textoEstado).html(estado);
      } else {
        alertify.error(retorno.message);
      }
    }
  });
}

var filldatalog = function (index, ejemplarNac) {
  //$('[data-toggle="tooltip"]').tooltip();
  var rowTable = "";
  rowTable = rowTable + "<tr >"
  rowTable = rowTable + "<td width='100%' height='10px'> <label>Estado: </label style='margin-left:10px;'><span style='margin-left:140px;' class='badge " + setCssEstado(ejemplarNac.estado) + "'>" + ejemplarNac.estadoTexto + "</span></td>";
  rowTable = rowTable + "</tr>"
  rowTable = rowTable + "<tr>"
  rowTable = rowTable + "<td width='100%'><label>Fecha Solicitud:</label><span style='margin-left:90px;'> " + ejemplarNac.fecSol + "</span></td>";
  rowTable = rowTable + "</tr>"
  rowTable = rowTable + "<tr>"
  rowTable = rowTable + "<td style='width:100%'><label>Comentario:</label><span style='margin-left:110px;'> " + ejemplarNac.comentario + "</span></td>";
  rowTable = rowTable + "</tr>"
  rowTable = rowTable + "<tr>"
  rowTable = rowTable + "<td style='width:100%'><label>Responsable: </label><span style='margin-left:105px;'>" + ejemplarNac.usuCrea + "</span></td>";
  rowTable = rowTable + "</tr>"
  rowTable = rowTable + "<tr><td>"
  rowTable = rowTable + "<hr>";
  rowTable = rowTable + "</tr></td>"
  var contendor = $("#tbEstado tbody").html();
  $("#tbEstado tbody").html(contendor + rowTable);
  //$("#tbEstado tbody").html(rowTable);
};


function setCssEstado(estadoSolId) {
  var cssEstado = '';
  switch (estadoSolId) {
    case 'INI':
      cssEstado = " badge-warning ";
      break;
    case 'REV':
      cssEstado = " badge-info ";
      break;
    case 'APR':
      cssEstado = " badge-success ";
      break;
    case 'OBS':
      cssEstado = " badge-primary ";
      break;
    case 'REC':
      cssEstado = " badge-danger ";
      break;
    case 'BAJ':
      cssEstado = " badge-secondary";
      break;
    default:
      cssEstado = " badge-info ";
      break;

  };

  return cssEstado;
}

function configView(vcodigoNac, vestado, vcodigo) {
  listarImg(vcodigo, '', true, '');
  listarPdf(vcodigo, '', true, '');
  $("span#btnDel").css("display", "none");
  $("#btnSaveBaja").css("display", "none");

  $("#divImageInput").hide();
  $("#divResenas").css("display", "block");
  $("#divAnotaciones").css("display", "block");
  $(controls.modalDialog + " .modal-title").html("Vista Previa: " + vcodigoNac + ' ' + vestado);

  if (vestado == "<span class='badge  badge-secondary'>DE BAJA</span></td>") {
    $("#divBaja").css("display", "block");
    $(controls.txtMotivoBaja).attr("disabled", "disabled");
    $("#txtFechaBaja").prop("disabled", true);
    $("#txtDetalleBaja").prop("disabled", true);
  } else {
    $("#divBaja").css("display", "none");
  }
  // console.log(vestado);
}

function configUnsubcribe(vcodigoNac, vestado, vcodigo) {
  $(controls.txtMotivoBaja).removeAttr("disabled");
  $("#txtFechaBaja").prop("disabled", false);
  $("#txtDetalleBaja").prop("disabled", false);
  listarImg(vcodigo, '', true, '');
  listarPdf(vcodigo, '', true, '');
  $("#divImageInput").hide();
  $("span#btnDel").hide();
  $("#divResenas").css("display", "none");
  $("#divAnotaciones").css("display", "none");
  $("#btnSaveNE").css("display", "none");
  $(controls.modalDialog + " .modal-title").html("Dar de Baja Nacimiento: " + vcodigoNac + ' ' + vestado);
  $("#btnSaveBaja").css("display", "initial");

  $("#divBaja").css("display", "block");
  limpiarBusqueda();
}

function configModify(vcodigoNac, vestado, vcodigo) {
  limpiarBusqueda();
  listarImg(vcodigo, '', false, 'edit');
  listarPdf(vcodigo, '', false, 'edit');
  $("#ddlOrigen").prop("disabled", true);
  $(controls.txtMotivoBaja).removeAttr("disabled");
  $("#divImageInput").show();
  $("#divBaja").css("display", "none");
  $("#divResenas").css("display", "block");
  $("#divAnotaciones").css("display", "block");
  $("#btnSaveBaja").css("display", "none");
  $(controls.modalDialog + " .modal-title").html("Modificar Nacimiento: " + vcodigoNac + ' ' + vestado);
}

function configInsert(vcodigoGenerado) {
  limpiarBusqueda();
  EliminarDocumentosModal(0);
  EliminarDocumentosModal(1);
  clearCtrlsPopup();
  $("#btnSaveBaja").css("display", "none");
  $("#divBaja").css("display", "none");
  listarIdMonta("ddlIdMonta", "SELECCIONE", "", $("#hidIdProp").val());
  //listarPelaje("ddlTipoPel", "seleccione");
  listarDeparmento("ddlProvinvia", "seleccione");
  listarMetodoReprop("ddlMetodo", "SELECCIONE");
  $("#ddlCriador").attr("disabled", "disabled");
  listarCriador(controls.cboCria, "SELECCIONE", $("#hidIdEntidad").val());
  $("#divImageInput").show();
  $("#ddlGenero").val(0);
  $("#ddlOrigen").val("N");
  $("#idHorse").val("");
  $("#idHorsePdf").val("");
  $("#hidFlagEdit").val("");
  $("#txtReseniaBasica").val('');
  $("#ddlOrigen").prop("disabled", true);
  $(controls.txtMotivoBaja).removeAttr("disabled");
  $("input[id=hidCodigoGenerado]").val(vcodigoGenerado);
  // console.log(codigoGenerado);
  $(controls.modalDialog + " .modal-title").html("Nuevo Nacimiento.");
  $("#mvNuevoNacEjemplar").data("action", "insert");
  $("#mvNuevoNacEjemplar").modal('show');
  editResenias('');
  // $("#ddlReseniaRightCA option").remove();
  listarImg("", vcodigoGenerado, false, 'new');
  listarPdf("", vcodigoGenerado, false, 'new');
}