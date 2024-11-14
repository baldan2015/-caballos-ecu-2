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
};
var controllers = {
  ejemplar: K_PATH_ROOT + 'ajax/ajaxEjemplar.php',
  imgEjemplar: K_PATH_ROOT + 'vista/upload/processuploadInsImg.php'
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
  modalDialog: "#mvNuevoEjemplar",
  modalDialogImg: "#mvImgEjemplar",
  modalDialogPdf: "#mvPdfEjemplar",
  modalDialogPrint: "#mvNuevoEjemplarPrintIns",
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
  codigoIns: "#hidCodigoInscripcion",
  popUpId: "#lblId",
  textoEstado: "#lblEstado",
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
  reseniasLeftCA: "#ddlReseniaLeftCA",
  reseniasRightCA: "#ddlReseniaRightCA",
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
  cboIdNac: "ddlIdNac",

  // BUSQUEDA POR FILTROS
  PelajeFiltro: "cboPelajeFiltro",
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
  mensajeBorrar: "Está seguro que desea eliminar la información?"
}
$(function () {
  listarPelaje('cboPelajeFiltro', "TODOS", 0);
  listarEstados("cboEstado", "TODOS", 0);
  $('[data-toggle="tooltip"]').tooltip();
  $("#btnPrint").on("click", function () {
    viewForm(9, $("#hidIdProp").val(), $("#hidIdPoe").val());
  }).button({
    icons: {
      primary: "ui-icon-print"
    }
  });

  $("#btnLimpiarFiltro").on("click", function () {
    limpiarFiltros();
    listarInscripciones();
  });
  $("#busquedaRe").on("keypress", function (e) {
    buscarResenia();
  });
  $("#btnAgregar").on("click", function () {
    $("#btnSaveNE").show();
    $("#imageInput").show();
    $("#submit-btn").show();
    $("#pdfInput").show();
    $("#submit-btn-pdf").show();
    $("#ddlTipoDocumento").show();
    $("#lblTipoD").show();
    $("#divImageInput").show();
    agregarItems();
    listarMetodoReprop('cboMetodoReproductivo', 'SELECCIONE', 0);
    configImportadoControles('N', action.insert);
  });
  $("#btnSaveNE").on("click", function () {
    insert();
  });

  $("#btnCancelar").on("click", function () {
    listarTranf();
    listarAdqui();
  }).button({
    icons: {
      primary: "ui-icon-cancel"
    }
  });

  listarInscripciones();

  $("#btnBuscarFiltro").on("click", function () {
    listarInscripciones();
  });

  $("#btnSaveBaja").on("click", function () {
    btnSaveBaja();
  });
  /*INIT POPUP MODAL BUSCAR EJEMPLAR*/
  $("#btnBuscarMadre").on("click", function () {
    $("#hidTipoParents").val("Y");
    $("#hidGenero").val("Y");
    $("#rdbtnProp").prop("checked", true);

    $("#formEjemplarExt").hide();
    // $("#rdbtnEE").hide();
    $("#lblPropiedad").html("Yeguas de mi propiedad");
    $("#lblOtros").html("Yeguas de terceros");
    //$("#lblExtranjero").hide();
    $("#lblExtranjero").html("Yeguas extranjeras");
    $("#divBody").show();
    $("#divBuscarEjemplar").modal('show');
    $("#txtBGNombre").val("");

    _buscar();
  });
  $("#btnBuscarPadre").on("click", function () {
    $("#hidTipoParents").val("P");
    $("#hidGenero").val("P");
    $("#rdbtnProp").prop("checked", true);
    //$("#rdbtnEE").show();
    $("#lblPropiedad").html("Potros de mi propiedad");
    $("#lblOtros").html("Potros de terceros");
    $("#lblExtranjero").show();
    $("#lblExtranjero").html("Potros extranjeros");
    $("#divBody").show();
    $("#divBuscarEjemplar").modal('show');
    $("#txtBGNombre").val("");
    $("#gridBusquedaEjemplar").show();
    $("#formEjemplarExt").hide();
    _buscar();
  });

  $("#btnFiltrarResena").on("click", function () {
    buscarResenia();
  });
  $("#ddlOrigen").on(events.change, function () {
    configImportadoControles($("#ddlOrigen").val(), action.insert);
  });

  $("#cboMetodoReproductivo").on(events.change, function () {
    $("#hidMetodo").val($("#cboMetodoReproductivo").val());

  });
  filtrosResenias();

  $("#btnBuscarResenia").on("click", function () {
    configCheckResenias('');
    openGrlResena('ALL', '', '', '', '', '');
    $("#mvBuscadorResenaGrl").modal('show');
  });
  botonesOrdenar();
  /*FIN POPUP MODAL BUSCAR EJEMPLAR*/
  limpiarLabelEjemplar();
  listarCriador(controls.cboCria, "SELECCIONE", $("#hidIdEntidad").val());
  listarPelaje("ddlTipoPel", "SELECCIONE");
  listarDeparmento("ddlProvinvia", "SELECCIONE");
  listarMetodoReprop("ddlMetodo", "SELECCIONE");
  listarResenia("ddlReseniaLeftCA", "", "CA");
  listarResenia("ddlReseniaLeftAD", "", "AD");
  listarResenia("ddlReseniaLeftAI", "", "AI");
  listarResenia("ddlReseniaLeftPD", "", "PD");
  listarResenia("ddlReseniaLeftPI", "", "PI");
  listarTipoDocumento("ddlTipoDocumento", "SELECCIONE");
  settingResenia();
  $("#ddlCriador").attr("disabled", "disabled");
  //listarIdNacimiento("ddlIdNac","SELECCIONE");
  listarMotivoBaja("txtMotivoBaja", "SELECCIONE", 0);

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
  $("#" + controls.PelajeFiltro).val('');
  $(controls.cboGenero).val(0);
  $(controls.txtFecNac).val('');
  $(controls.txtPadre).val('');
  $(controls.txtMadre).val('');

  $("#cboEstado").selectpicker("refresh");
  $("#" + controls.PelajeFiltro).selectpicker("refresh");
  $(controls.cboGenero).selectpicker("refresh");
}

var vistaPrevia = function (obj) {
  var id = $(obj).data("id");
  // console.log(estado);
  $(controls.prefijo).prop("disabled", true);
  $(controls.nombre).prop("disabled", true);
  $(controls.fecNace).prop("disabled", true);
  $("#ddlTipoPel").prop("disabled", true);
  $(controls.lugarNace).prop("disabled", true);
  $(controls.microchip).prop("disabled", true);
  $(controls.descripcion).prop("disabled", true);
  $(controls.motivo).prop("disabled", true);
  $(controls.sexo).prop("disabled", true);
  $("#ddlOrigen").prop("disabled", true);
  $("#ddlProvinvia").prop("disabled", true);
  $("#btnBuscarResenia").hide();
  $("#ddlCriador").attr("disabled", "disabled");
  $("#btnSaveNE").hide();
  $("#imageInput").hide();
  $("#submit-btn").hide();
  $("#pdfInput").hide();
  $("#submit-btn-pdf").hide();
  $("#ddlTipoDocumento").hide();
  $("#lblTipoD").hide();

  // $(controls.codigo).val(id);
  editar(id, action.view);
}

function btnSaveBaja() {
  var codigo = $(controls.codigo).val();
  var motivoBaja = $("#txtMotivoBaja").val();
  var fechaBaja = $("#txtFechaBaja").val();
  var detalleBaja = $("#txtDetalleBaja").val();
  if (motivoBaja != '' && fechaBaja != '' && detalleBaja != '' && motivoBaja != null) {
    grlEjecutarAccion(controllersREST.ejemplar, {
      opc: 'updBajaIns',
      codigo: codigo,
      motivoBaja: motivoBaja,
      fechaBaja: fechaBaja,
      detalleBaja: detalleBaja,
      idProp: $("#hidIdProp").val()
    }, function (retorno) {
      // console.log(retorno);
      $("#mvNuevoEjemplar").modal("hide");
      $("#txtMotivoBaja").val('');
      $("#txtFechaBaja").val('');
      $("#txtDetalleBaja").val('');
      listarInscripciones();
      alertify.success(retorno.message);
    });
  } else {
    alertify.error("Complete todos los campos");
  }

}

function darBaja(obj) {
  var id = $(obj).data("id");

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
var listarInscripciones = function () {
  var pelaje = $("#" + controls.PelajeFiltro).val() != 0 && $("#" + controls.PelajeFiltro).val() != 'TODOS' ? $("#" + controls.PelajeFiltro).val() : '';
  var genero = $(controls.cboGenero).val() != 0 && $(controls.cboGenero).val() != 'TODOS' ? $(controls.cboGenero).val() : '';
  var estado = $(controls.cboEstado).val() != 0 && $(controls.cboEstado).val() != 'TODOS' ? $(controls.cboEstado).val() : '';

  $.ajax({
    data: {
      opc: 'lstInscp',
      idPoe: $("#hidIdPoe").val(),
      idProp: $("#hidIdProp").val(),
      estado: estado,
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
      if (retorno.result == "1") {
        var data = retorno.data;
        // console.log(data);
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
    pageLength: 100,
    //paging: false,
    //searching: false,
    aaSorting: [],
    destroy: true,
    columns: [{
        "data": "codigoInscripcion"
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
              estadoTexto = "<span class='badge badge-info badge-normal  ' style='background-color: #5bc0de;'>" + row.estadoSolTexto + "</span>";
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
        "render": function (obj, type, row, meta) {
          if (obj.estadoSolId === "REC") {
            // rowTable = "<span title='Modificar Solicitud' class='btn btn-default btn-xs glyphicon glyphicon-edit' data-toggle='tooltip'  data-id='" + obj.id + "' data-estado='" + obj.estadoSolTexto + "' onclick='edit(this);'></span> ";
            var rowTable = "<span title='Vista Previa' class='btn btn-default btn-xs glyphicon glyphicon-eye-open' data-toggle='tooltip'  data-id='" + obj.id + "' data-estado='" + obj.estadoSolTexto + "' onclick='vistaPrevia(this);'></span>";
            rowTable = rowTable + "<span title='Imprimir Inscripción del Ejemplar' class='btn btn-default btn-xs glyphicon glyphicon-print' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoInscripcion + "' onclick='printInscripcion(this);'></span>";
            rowTable = rowTable + "<span title='Seguimiento a Solicitud' class='btn btn-default btn-xs glyphicon glyphicon-comment' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoInscripcion + "' onclick='verLog(this);'></span>";
          } else if (obj.estadoSolId === "APR") {
            var rowTable = "<span title='Vista Previa' class='btn btn-default btn-xs glyphicon glyphicon-eye-open' data-toggle='tooltip'  data-id='" + obj.id + "' data-estado='" + obj.estadoSolTexto + "' onclick='vistaPrevia(this);'></span>";
            rowTable = rowTable + "<span title='Imprimir Inscripción del Ejemplar' class='btn btn-default btn-xs glyphicon glyphicon-print' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoInscripcion + "' onclick='printInscripcion(this);'></span>";
            rowTable = rowTable + "<span title='Seguimiento a Solicitud' class='btn btn-default btn-xs glyphicon glyphicon-comment' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoInscripcion + "' onclick='verLog(this);'></span>";
          } else if (obj.estadoSolId === "BAJ") {
            var rowTable = "<span title='Vista Previa' class='btn btn-default btn-xs glyphicon glyphicon-eye-open' data-toggle='tooltip'  data-id='" + obj.id + "' data-estado='" + obj.estadoSolTexto + "' onclick='vistaPrevia(this);'></span>";
            rowTable = rowTable + "<span title='Imprimir Inscripción del Ejemplar' class='btn btn-default btn-xs glyphicon glyphicon-print' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoInscripcion + "' onclick='printInscripcion(this);'></span>";
            rowTable = rowTable + "<span title='Seguimiento a Solicitud' class='btn btn-default btn-xs glyphicon glyphicon-comment' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoInscripcion + "' onclick='verLog(this);'></span> ";
          } else {
            var rowTable = "<span title='Modificar Solicitud' class='btn btn-default btn-xs glyphicon glyphicon-edit' data-toggle='tooltip'  data-id='" + obj.id + "' data-estado='" + obj.estadoSolTexto + "' onclick='edit(this);'></span>";
            rowTable = rowTable + "<span title='Vista Previa' class='btn btn-default btn-xs glyphicon glyphicon-eye-open' data-toggle='tooltip'  data-id='" + obj.id + "' data-estado='" + obj.estadoSolTexto + "' onclick='vistaPrevia(this);'></span>";
            rowTable = rowTable + "<span title='Imprimir Inscripción del Ejemplar' class='btn btn-default btn-xs glyphicon glyphicon-print' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoInscripcion + "' onclick='printInscripcion(this);'></span>";
            rowTable = rowTable + "<span title='Seguimiento a Solicitud' class='btn btn-default btn-xs glyphicon glyphicon-comment' data-toggle='tooltip' data-id='" + obj.id + "'  data-id2='" + obj.codigoInscripcion + "' onclick='verLog(this);'></span>";
            rowTable = rowTable + "<span title='Eliminar Solicitud' class='btn btn-default btn-xs glyphicon glyphicon-trash' data-toggle='tooltip'   data-id='" + obj.id + "' onclick='deleteINS(this);' ></span>";
            rowTable = rowTable + "<span title='Dar Baja' class='btn btn-default glyphicon btn-xs glyphicon-minus-sign' data-toggle='tooltip' data-id='" + obj.id + "' data-estado='" + obj.estadoSolTexto + "' onclick='darBaja(this);'></span>"
          }


          return rowTable;


        }
      }
    ]
  });
  $("#lblCantidadSol").html(numRow);
  $("#tbInscripcion tbody").html("");
  $('[data-toggle="tooltip"]').tooltip();
  ///$('#grid tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
};



var listarEstadosS = function (id) {
  $.ajax({
    data: {
      opc: 'lstEst',
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
      opc: 'getIns',
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

var filldatalog = function (index, ejemplarINS) {
  //console.log(ejemplarINS);
  //$('[data-toggle="tooltip"]').tooltip();
  var rowTable = "";
  rowTable = rowTable + "<tr >"
  rowTable = rowTable + "<td width='100%' height='10px'> <label>Estado: </label style='margin-left:10px;'><span style='margin-left:140px;' class='badge " + setCssEstado(ejemplarINS.estado) + "'>" + ejemplarINS.estadoTexto + "</span></td>";
  rowTable = rowTable + "</tr>"
  rowTable = rowTable + "<tr>"
  rowTable = rowTable + "<td width='100%'><label>Fecha Solicitud:</label><span style='margin-left:90px;'> " + ejemplarINS.fecSol + "</span></td>";
  rowTable = rowTable + "</tr>"
  rowTable = rowTable + "<tr>"
  rowTable = rowTable + "<td style='width:100%'><label>Comentario:</label><span style='margin-left:110px;'> " + ejemplarINS.comentario + "</span></td>";
  rowTable = rowTable + "</tr>"
  rowTable = rowTable + "<tr>"
  rowTable = rowTable + "<td style='width:100%'><label>Responsable: </label><span style='margin-left:105px;'>" + ejemplarINS.usuCrea + "</span></td>";
  rowTable = rowTable + "</tr>"
  rowTable = rowTable + "<tr><td>"
  rowTable = rowTable + "<hr>";
  rowTable = rowTable + "</tr></td>"
  var contendor = $("#tbEstado tbody").html();
  $("#tbEstado tbody").html(contendor + rowTable);
  //$("#tbEstado tbody").html(rowTable);
};

function agregarItems() {


  grlEjecutarAccion(controllersREST.ejemplar, {
    opc: 'getLastIDIns'
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
      /*console.log($(controls.fecServ).val());
      console.log($(controls.fecNace));
      console.log($(controls.madre).val());
      console.log($(controls.codigo).val());*/
      /**/
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

var envioForm = function (retorno) {

  $.ajax({
    data: {
      alt: 'get'
    },
    url: K_PATH_ROOT + 'ajaxPOE/ajaxEnvio.php',
    type: 'post',
    success: function (response) {
      //   alert(response);
      retorno(response);

    }
  });
  return retorno;
};


var update = function () {
  //var codigo=controls.codigo;
  var date1 = new Date($(controls.hidFecMonta).val());
  var fecServicio = '';
  if ($("#ddlOrigen").val() == 'I') {
    fecServicio = $("#dtFecServ").val();
    //   date1 = new Date(fecServicio);
  } else {
    fecServicio = $(controls.fecServ).val()
  }

  var date2 = new Date($(controls.fecNace).val());
  var diffTime = Math.abs(date2 - date1);
  var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

  var lstItemPropietario = ""; //getIdEntidad();

  /* console.log(date1);
   console.log(date2);
   console.log(diffDays);*/
  //console.log("PELAJE INSERT",$('#' + controls.cboPelaje).val());



  var data = {
    opc: '-',
    codigo: $(controls.codigo).val(),
    prefijo: $(controls.prefijo).val(),
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
    fecServ: fecServicio,
    idMetodo: $(controls.metodo).val(),
    idPoe: $("#hidIdPoe").val(),
    idProp: $("#hidIdProp").val(),
    idCriador: $("#" + controls.cboCria).val(),
    codigoIns: $(controls.codigoIns).val(),
    arrayResenias: $("#array").val(),
    codigoGenerado: $("input[id=hidCodigoGenerado]").val(),
    arrayIdImg: JSON.stringify(collectionID),
    arrayIdPdf: JSON.stringify(collectionIDPdf),
    reseniaBasica: $("#txtReseniaBasica").val()
  };

  if ($(controls.modalDialog).data("action") != "insert") {
    data.opc = 'updIns';
  } else {
    data.opc = 'insIns';
  }

  if ($(controls.origen).val() == 'I') diffDays = setting.limitDayBorn;

  if (data.idNac === "" && $(controls.origen).val() == "N") {
    alertify.error("Debe seleccionar un código de nacimiento");
  } else {
    if (diffDays >= setting.limitInitDayBorn && diffDays <= setting.limitDayBorn) {

      if ($(controls.padre).val() != "" && $(controls.madre).val() != "") {
        if (grlValidarObligatorio(controls.modalDialog)) {
          if ($("#ddlCriador").val() != 0) {
            $("#ddlCriador").css({
              'border': '1px solid #ccc'
            });


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
                    //console.log(retorno);
                    if (retorno.result === K_ResultadoAjax.exito) {
                      grlEjecutarAccion(controllersREST.ejemplar, {
                        opc: 'getLastIDIns'
                      }, function (retorno) {
                        var ejemplar = retorno.data;
                        if (retorno.result === K_ResultadoAjax.exito && data.opc == 'insIns') {
                          alertify.alert("Se registró una inscripción con el código : " + ejemplar.codigoInscripcion, function () {
                            alertify.success(retorno.message);
                          });
                          //alertify.success(retorno.message);
                          $("#mvNuevoEjemplar").modal("hide");
                          //insertLog();
                        } else {
                          alertify.alert("Se actualizó una inscripción con el código : " + $("#hidCodigoInscripcion").val(), function () {
                            alertify.success(retorno.message);
                          });
                          //alertify.success(retorno.message);
                          $("#mvNuevoEjemplar").modal("hide");
                        }
                      });
                    } else if (retorno.result === K_ResultadoAjax.error) {
                      alertify.set('notifier', 'delay', 10);
                      alertify.error(retorno.message);
                    } else if (retorno.result === K_ResultadoAjax.warning) {
                      alertify.error(retorno.message);
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
            alertify.error("Debe seleccionar un criador");
            $("#ddlCriador").css({
              'border': '1px solid red'
            });
          }
        }
      } else {
        alertify.alert("Se debe selecionar ambos padres para el ejemplar inscrito.", function () {

        });
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
  $("#" + controls.cboIdNac).prop("disabled", false);
  $("#hidCodigoInscripcion").val("");
  $("#array").val("");
  $("#lblResenia").text("");




  $(controls.prefijo).prop("disabled", false);
  $(controls.nombre).prop("disabled", false);
  $(controls.fecNace).prop("disabled", false);
  $("#ddlTipoPel").prop("disabled", false);
  $(controls.lugarNace).prop("disabled", false);
  $(controls.microchip).prop("disabled", false);
  $(controls.descripcion).prop("disabled", false);
  $(controls.motivo).prop("disabled", false);
  // $(controls.cboCria).prop("disabled",false);
  $(controls.sexo).prop("disabled", false);
  $("#ddlOrigen").prop("disabled", false);
  $("#ddlProvinvia").prop("disabled", false);
  $("#btnBuscarResenia").show();
  $("#btnSaveNE").show()





  //limpiarSesionTMPEntes();
}

function search() {
  listarInscripciones();
}

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

function addImg(obj) {
  var id = $(obj).data("id");
  var codigoInscripcion = $(obj).data("id2");
  $(controls.modalDialogImg).modal("show");
  $("#idHorse").val(id);
  $("#lblDatoHorse").html($(obj).data("nombre") + ' - ' + $(obj).data("prefijo"));
  $("#lblIdSol").html("Inscripción código: " + codigoInscripcion);
  listarImg(id);
}

function addCert(obj) {
  var id = $(obj).data("id");
  var codigoInscripcion = $(obj).data("id2");
  $(controls.modalDialogPdf).modal("show");
  $("#idHorsePdf").val(id);
  $("#lblDatoHorsePdf").html($(obj).data("nombre") + ' - ' + $(obj).data("prefijo"));
  $("#lblIdSolPdf").html("Inscripción código: " + codigoInscripcion);
  listarPdf(id);
}

function verLog(obj) {
  //console.log(controls.modalDialogLog);
  // $(controls.modalDialogLog).modal("show");
  var id = $(obj).data("id");
  var codigoInscripcion = $(obj).data("id2");
  listarEstadosS(id);
  $(controls.popUpId).html(id);
  $(controls.modalDialogLog + " .modal-title").html("SEGUIMIENTO DE SOLICITUD " + codigoInscripcion);
  //$(controls.modalDialog).data("action","edit");
  $(controls.modalDialogLog).modal("show");

}

function edit(obj) {
  var id = $(obj).data("id");
  var estado = $(obj).data("estado");
  // console.log(estado);
  if (estado == "APROBADO" || estado == "RECHAZADO") {
    $(controls.prefijo).prop("disabled", true);
    $(controls.nombre).prop("disabled", true);
    $(controls.fecNace).prop("disabled", true);
    $("#ddlTipoPel").prop("disabled", true);
    $(controls.lugarNace).prop("disabled", true);
    $(controls.microchip).prop("disabled", true);
    $(controls.descripcion).prop("disabled", true);
    $(controls.motivo).prop("disabled", true);
    $(controls.sexo).prop("disabled", true);
    $("#ddlOrigen").prop("disabled", true);
    $("#ddlProvinvia").prop("disabled", true);
    $("#btnBuscarResenia").hide();
    $("#ddlCriador").attr("disabled", "disabled");
    $("#btnSaveNE").hide();
    $("#imageInput").hide();
    $("#submit-btn").hide();
    $("#pdfInput").hide();
    $("#submit-btn-pdf").hide();
    $("#ddlTipoDocumento").hide();
    $("#lblTipoD").hide();
  } else {
    $(controls.prefijo).prop("disabled", false);
    $(controls.nombre).prop("disabled", false);
    $(controls.fecNace).prop("disabled", false);
    $("#ddlTipoPel").prop("disabled", false);
    $(controls.lugarNace).prop("disabled", false);
    $(controls.microchip).prop("disabled", false);
    $(controls.descripcion).prop("disabled", false);
    $(controls.motivo).prop("disabled", false);
    $(controls.sexo).prop("disabled", false);
    $("#ddlOrigen").prop("disabled", false);
    $("#ddlProvinvia").prop("disabled", false);
    $("#btnBuscarResenia").show();
    $("#ddlCriador").attr("disabled", "disabled");
    $("#btnSaveNE").show();
    $("#imageInput").show();
    $("#submit-btn").show();
    $("#pdfInput").show();
    $("#submit-btn-pdf").show();
    $("#ddlTipoDocumento").show();
    $("#lblTipoD").show();
  }
  // $(controls.codigo).val(id);
  editar(id, action.modify);
}

function deleteINS(obj) {
  var id = $(obj).data("id");
  if (id != undefined) {
    alertify.confirm(mensaje.mensajeBorrar, function (e) {
      if (e) {
        grlEjecutarAccion(controllersREST.ejemplar, {
          opc: 'delIns',
          id: id
        }, function (retorno) {

          //console.log(retorno);
          if (retorno.result == K_ResultadoAjax.exito) {
            alertify.success(retorno.message);
            listarInscripciones();
          } else if (retorno.result == 2) {
            alertify.error(retorno.message);
            listarInscripciones();
          } else if (retorno.result == 995) {
            alertify.error(retorno.message);
            listarInscripciones();
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
    /* console.log(collection);
     console.log(reseniaBasica);*/

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
        //console.log(retorno);
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
    // console.log(value);
    texto = (texto == "" ? texto : texto + separadorResenia) + value.descripcion;
  });
  //console.log(texto);
  $("#lblResenia").text(texto);
  //console.log(collection1);


}

function editar(codigo, operation) {
  EliminarDocumentosModal(0);
  EliminarDocumentosModal(1);
  //console.log(codigo);
  if (codigo != undefined) {
    grlEjecutarAccion(controllersREST.ejemplar, {
      opc: 'getIns',
      codigo: codigo
    }, function (retorno) {
      //console.log(retorno);
      if (retorno.result == K_ResultadoAjax.exito) {
        var ejemplar = retorno.data;
        if (ejemplar != null) {
          //console.log(ejemplar);
          var estado = "<span class='badge " + setCssEstado(ejemplar.estadoSol) + "'>" + ejemplar.estadoSolTexto + "</span></td>";
          //$(controls.modalDialog+" .modal-title").html("Modificar Solicitud Nro: "+ ejemplar.codigo + estado +  "Código Inscripcón: " + ejemplar.codigoInscripcion);

          $(controls.modalDialog).data("action", "edit");
          $(controls.modalDialog).modal("show");
          if (operation == action.view) {
            configView(ejemplar.codigoInscripcion, estado, ejemplar.codigo);

          } else if (operation == action.unsubcribe) {
            configUnsubcribe(ejemplar.codigoInscripcion, estado, ejemplar.codigo);

          } else {
            configModify(ejemplar.codigoInscripcion, estado, ejemplar.codigo);
          }


          $("#txtReseniaBasica").val(ejemplar.reseniaBasica);
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
          $(controls.madre).val(ejemplar.idMadre);
          $(controls.padre).val(ejemplar.idPadre);

          //console.log("codigos",ejemplar);
          $("#lblPotroBuscar").html(ejemplar.nombrePadre);
          $("#lblYeguaBuscar").html(ejemplar.nombreMadre);
          $("#dtFecServ").val(ejemplar.fecServ);

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

          $(controls.mostrarFechaEmbrion).html(ejemplar.fecEmbrion);
          $(controls.mostrarIdReceptora).html(ejemplar.idReceptor);

          if (ejemplar.idMetodo == 1) {
            $(controls.metodoReproductivo).html("MONTA NATURAL");
            listarMetodoReprop('cboMetodoReproductivo', 'SELECCIONE', ejemplar.idMetodo);
            $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 2) {
            $(controls.metodoReproductivo).html("SEMEN FRESCO");
            $(controls.metodo).val(ejemplar.idMetodo);
            listarMetodoReprop('cboMetodoReproductivo', 'SELECCIONE', ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 3) {
            $(controls.metodoReproductivo).html("SEMEN REFRIGERADO");
            $(controls.metodo).val(ejemplar.idMetodo);
            listarMetodoReprop('cboMetodoReproductivo', 'SELECCIONE', ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 4) {
            $(controls.metodoReproductivo).html("SEMEN CONGELADO");
            $(controls.metodo).val(ejemplar.idMetodo);
            listarMetodoReprop('cboMetodoReproductivo', 'SELECCIONE', ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 5) {
            $(controls.metodoReproductivo).html("Transferencia de embriones");
            $(controls.metodo).val(ejemplar.idMetodo);
            listarMetodoReprop('cboMetodoReproductivo', 'SELECCIONE', ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 6) {
            $(controls.metodoReproductivo).html("Semen fresco con trasferencia de embriones");
            $(controls.metodo).val(ejemplar.idMetodo);
            listarMetodoReprop('cboMetodoReproductivo', 'SELECCIONE', ejemplar.idMetodo);
          } else {
            listarMetodoReprop('cboMetodoReproductivo', 'SELECCIONE');
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
          $("#" + controls.cboIdNac).attr("disabled", "disabled");
          //$("#trCastrado").hide();
          $("#txtFecCapado").attr("readonly", true);
          if (ejemplar.genero == "P") {
            //$("#trCastrado").show();
            $("#txtFecCapado").attr("readonly", false);
          }
          editResenias(ejemplar.listResenas);
          $(controls.areaResenas).val(ejemplar.resenasDescripcion);
         
            $("#lblResenia").text(ejemplar.resenasDescripcion);
         

          //console.log(ejemplar.resenasDescripcion);
          $(controls.fecServ).val(ejemplar.fecServ);

          if (ejemplar.origen == "" || ejemplar.origen == null) {
            $(controls.origen).val(0);
          } else {
            $(controls.origen).val(ejemplar.origen);
          }
          configImportadoControles(ejemplar.origen, operation);
          $(controls.txtFechaBaja).val(ejemplar.fecFallece);
          $(controls.txtMotivoBaja).val(ejemplar.motivoFallece);
          //listarMotivoBaja("txtMotivoBaja","SELECCIONE",ejemplar.motivoFallece);
          $("#txtMotivoBaja").selectpicker("refresh");
          $(controls.txtDetalleBaja).val(ejemplar.detalleFallece);

          // console.log(ejemplar.motivoFallece);
          //metodo reproductivo
          //listarIdNacimiento("ddlIdNac","SELECCIONE","",$("#hidIdProp").val());
          //console.log(ejemplar.idNac);
          // console.log($("#hidIdProp").val());
          //$("#ddlIdNac").val(ejemplar.idNac);
          listarIdNacimiento(controls.cboIdNac, "SELECCIONE", ejemplar.idNac, $("#hidIdProp").val());
          listarMetodoReprop(controls.cboMetodo, "SELECCIONE", ejemplar.idMetodo);
          listarCriador(controls.cboCria, "SELECCIONE", ejemplar.idCriador);
          //listarPelaje(controls.cboPelaje, "SELECCIONE", ejemplar.idPelaje);
          //console.log(ejemplar.idPelaje);
          $("#" + controls.cboPelaje).val(ejemplar.idPelaje);
          $("#" + controls.cboPelaje).selectpicker("refresh");
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

function getInfoNacEjemplar() {

  var codigo = $("#" + controls.cboIdNac).val();
  //console.log(codigo);
  if (codigo != undefined && codigo != "SELECCIONE") {
    grlEjecutarAccion(controllersREST.ejemplar, {
      opc: 'infoNac',
      codigo: codigo
    }, function (retorno) {
      if (retorno.result == K_ResultadoAjax.exito) {
        var ejemplar = retorno.data;
        if (ejemplar != null) {
          // console.log(ejemplar.metodo);
          $("#txtReseniaBasica").val(ejemplar.reseniaBasica);
          $(controls.codigo).val(ejemplar.codigo);
          $("#array").val(JSON.stringify(ejemplar.listResenas));
          $(controls.nombre).val(ejemplar.nombre);
          $(controls.prefijo).val(ejemplar.prefijo);
          $(controls.madre).val(ejemplar.codYegua);
          $(controls.padre).val(ejemplar.codPotro);
          $(controls.yegua).html(ejemplar.nombreYegua);
          $(controls.potro).html(ejemplar.nombrePotro);
          $(controls.fecNace).val(ejemplar.fecha);
          if (ejemplar.sexo == "P") {
            $(controls.sexo).val(ejemplar.sexo);
          } else if (ejemplar.sexo == "Y") {
            $(controls.sexo).val(ejemplar.sexo);
          } else {
            $(controls.sexo).val("0");
          }

          $(controls.idMonta).val(ejemplar.idMonta);
          $(controls.idNac).val(ejemplar.id);
          $(controls.codigoMonta).html(ejemplar.codigoMonta);
          $(controls.codigoNacimiento).html(ejemplar.codigoNacimiento);

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

          $(controls.microchip).val(ejemplar.microchip);
          $(controls.descripcion).val(ejemplar.descripcion);
          $(controls.lugarNace).val(ejemplar.LugarNace);
          $(controls.hidFecMonta).val(ejemplar.fecMonta);
          editResenias(ejemplar.listResenas);
          $(controls.mostrarFechaEmbrion).html(ejemplar.fecEmbrion);
          $(controls.mostrarIdReceptora).html(ejemplar.idReceptor);
          //metodo reproductivo
          //listarMetodoReprop(controls.cboMetodo,"SELECCIONE",ejemplar.idMetodo);
          $(controls.areaResenas).val(ejemplar.resenasDescripcion);
          $("#lblResenia").html(ejemplar.resenasDescripcion);
          listarCriador(controls.cboCria, "SELECCIONE", ejemplar.idCriador);
          listarPelaje(controls.cboPelaje, "SELECCIONE", ejemplar.pelaje);
          listarDeparmento(controls.cboDepartamento, "SELECCIONE", ejemplar.idProvincia);
          //listarPelaje(controls.cboPelaje, "SELECCIONE", ejemplar.pelaje);
        } else {
          alertify.error(retorno.message);
        }
      } else if (retorno.result == K_ResultadoAjax.error) {
        alertify.error(retorno.message);
      }
    });

  } else {
    $(controls.codigo).val("");
    $("#array").val("");
    $(controls.nombre).val("");
    $(controls.prefijo).val("");
    $(controls.madre).val("");
    $(controls.padre).val("");
    $(controls.yegua).html("");
    $(controls.potro).html("");
    $(controls.fecNace).val("");
    $(controls.sexo).val("0");

    $(controls.idMonta).val("");
    $(controls.idNac).val("");
    $(controls.codigoMonta).html("");
    $(controls.codigoNacimiento).html("");

    $(controls.metodoReproductivo).html("");
    $(controls.metodo).val(0);

    $(controls.microchip).val("");
    $(controls.descripcion).val("");
    $(controls.lugarNace).val("");
    $(controls.hidFecMonta).val("");
    $(controls.mostrarFechaEmbrion).html("");
    $(controls.mostrarIdReceptora).html("");

    $(controls.areaResenas).val("");
    listarCriador(controls.cboCria, "SELECCIONE", 0);
    listarPelaje(controls.cboPelaje, "SELECCIONE", 0);
    listarDeparmento(controls.cboDepartamento, "SELECCIONE", 0);
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


function printInscripcion(obj) {

  var prop = $("#hidIdProp").val();
  var codigoInscripcion = $(obj).data("id2");
  var id = $(obj).data("id");
  window.open('printInscripcion.php?codigo=' + id + '&codigoInscripcion=' + codigoInscripcion + '&prop=' + prop);
  //grlCenterWindow(1000, 600, 50, , 'demo_win');

}

function configView(vcodigoIns, vestado, vcodigo) {
  limpiarBusqueda();
  listarImg(vcodigo, '', true, '');
  listarPdf(vcodigo, '', true, '');
  $("span.btnDel").css("display", "none");
  $("#btnSaveBaja").css("display", "none");
  //$("#divBaja").css("display", "none");
  $("#divImageInput").hide();
  $("#divResenas").css("display", "block");
  $("#divAnotaciones").css("display", "block");
  $(controls.modalDialog + " .modal-title").html("Vista Previa: " + vcodigoIns + ' ' + vestado);
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

function configUnsubcribe(vcodigoIns, vestado, vcodigo) {
  limpiarBusqueda();
  $("#txtMotivoBaja").prop("disabled", false);
  $("#txtFechaBaja").prop("disabled", false);
  $(controls.txtMotivoBaja).removeAttr("disabled");
  listarImg(vcodigo, '', true, '');
  listarPdf(vcodigo, '', true, '');
  $("#divImageInput").hide();
  $("span#btnDel").hide();
  $("#divResenas").css("display", "none");
  $("#divAnotaciones").css("display", "none");
  $("#btnSaveNE").css("display", "none");
  $(controls.modalDialog + " .modal-title").html("Dar de Baja Inscripción: " + vcodigoIns + ' ' + vestado);
  $("#btnSaveBaja").css("display", "initial");

  $("#divBaja").css("display", "block");
}

function configModify(vcodigoIns, vestado, vcodigo) {
  limpiarBusqueda();
  listarImg(vcodigo, '', false, 'edit');
  listarPdf(vcodigo, '', false, 'edit');
  //$(controls.txtMotivoBaja).removeAttr("disabled");
  $(controls.txtMotivoBaja).removeAttr("disabled");
  $("#divBaja").css("display", "none");
  $("#divResenas").css("display", "block");
  $("#divAnotaciones").css("display", "block");
  $("#btnSaveBaja").css("display", "none");
  $("#cboMetodoReproductivo").prop("disabled", false);
  $(controls.modalDialog + " .modal-title").html("Modificar Inscripción: " + vcodigoIns + ' ' + vestado);
  $("#ddlTipoPel").prop("disabled", false);
}

function configInsert(vcodigoGenerado) {
  EliminarDocumentosModal(0);
  EliminarDocumentosModal(1);
  limpiarBusqueda();
  clearCtrlsPopup();
  // configImportadoControles($("#ddlOrigen").val(),action.insert);
  $("#btnSaveBaja").css("display", "none");
  listarIdNacimiento("ddlIdNac", "SELECCIONE", "", $("#hidIdProp").val());
  // listarPelaje("ddlTipoPel", "seleccione",0);
  $("#ddlTipoPel").val(0);
  $(controls.txtMotivoBaja).removeAttr("disabled");
  listarDeparmento("ddlProvinvia", "seleccione");
  listarMetodoReprop("ddlMetodo", "SELECCIONE");
  $("#cboMetodoReproductivo").removeAttr("disabled");
  $("#ddlGenero").val(0);
  $("#txtMotivoBaja").val(0);
  $("#txtFechaBaja").val('');
  $("#txtDetalleBaja").val('');
  $("#ddlOrigen").val("N");
  $("#idHorse").val("");
  $("#idHorsePdf").val("");
  $("#hidFlagEdit").val("");
  $("#divBaja").hide();
  $("input[id=hidCodigoGenerado]").val(vcodigoGenerado);
  $(controls.modalDialog + " .modal-title").html("Nueva Solicitud Inscripcón.");
  $("#mvNuevoEjemplar").data("action", "insert");
  $("#mvNuevoEjemplar").modal('show');
  editResenias('');
  listarImg("", vcodigoGenerado, false, 'new');
  listarPdf("", vcodigoGenerado, false, 'new');
  $("#txtReseniaBasica").val('');
  $("#ddlTipoPel").prop("disabled", false);
}

function configImportadoControles(valor, action = 0) {
  //console.log(valor,action);

  if (valor == 'I') {
    $("#btnBuscarMadreSpan").show();
    $("#btnBuscarPadreSpan").show();
    $("#cboMetodoReproductivoDiv").show();
    $("#FecEmbrion").hide();
    $("#idReceptora").hide();
    $("#divReporte").hide();
    $("#divFechaServicio").show();
    $("#lblMetRep").hide();
    $("#lblPotro").hide();
    $("#lblYegua").hide();

    $("#").val();
  } else {
    $("#btnBuscarMadreSpan").hide();
    $("#btnBuscarPadreSpan").hide();
    $("#cboMetodoReproductivoDiv").hide();
    $("#FecEmbrion").show();
    $("#idReceptora").show();
    $("#divReporte").show();
    $("#divFechaServicio").hide();
    $("#lblMetRep").show();
    $("#lblPotro").show();
    $("#lblYegua").show();

    $("#").val();
  }

  if (action == 1) {
    $("#hidIdPadre").val("");
    $("#hidIdMadre").val("");
    $("#lblPotroBuscar").html("");
    $("#lblYeguaBuscar").html("");
    $("#dtFecServ").val("");
    $("#dtFecServ").prop("disabled", false);
    $("#cboMetodoReproductivo").prop("disabled", false);
    $("#ddlTipoPel").prop("disabled", false);
    $("#btnBuscarMadre").show();
    $("#btnBuscarPadre").show();

    listarPelaje(controls.cboPelaje, "SELECCIONE", 0);
  } else if (action == 3) {
    $("#ddlOrigen").prop("disabled", true);
    if (valor == "I") {
      $("#btnBuscarMadre").hide();
      $("#btnBuscarPadre").hide();

      $("#btnBuscarPadre").css("display", "none");
      $("#btnBuscarMadre").css("display", "none");

      $("#cboMetodoReproductivo").prop("disabled", true);

      $("#dtFecServ").prop("disabled", true);
    }
  } else if (action == 2) {
    $("#ddlOrigen").prop("disabled", true);
    $("#ddlTipoPel").prop("disabled", false);
    if (valor == "I") {
      $("#btnBuscarMadre").hide();
      $("#btnBuscarPadre").hide();
      $("#cboMetodoReproductivo").prop("disabled", false);
      $("#btnBuscarPadre").css("display", "block");
      $("#btnBuscarMadre").css("display", "block");
    } else {
      $("#btnBuscarMadre").show();
      $("#btnBuscarPadre").show();
      $("#cboMetodoReproductivo").prop("disabled", true);
      $("#btnBuscarPadre").css("display", "none");
      $("#btnBuscarMadre").css("display", "none");
    }
    $("#dtFecServ").prop("disabled", false);
  } else if (action == 4) {
    $("#ddlOrigen").prop("disabled", true);
    $("#dtFecServ").prop("disabled", true);
    $("#cboMetodoReproductivo").prop("disabled", true);
    $("#btnBuscarMadre").hide();
    $("#btnBuscarPadre").hide();
  }
}