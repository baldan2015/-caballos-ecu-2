var K_PATH_ROOT = "../";
var separadorResenia = ", ";
var datosDocYegua = [];
var datosDocPotro = [];
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
  modalDialog: "#mvNuevoEjemplar",
  modalDialogPrintY: "#mvNuevoEjemplar2",
  modalDialogImg: "#mvImgEjemplar",
  modalDialogPdf: "#mvPdfEjemplar",
  modalDialogLog: "#mvLogSolicitudDeta",
  modalDialogFac: "#mvFalleceEjemplar",
  modalDialogSuperCamp: "#mvSuperCamp",
  modalDialogPrint: "#mvPrintCertificado",
  buttonPrintTransf: "#btnPrintHorseTransf",
  modalDialogE: "#divBuscarEjemplar",

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
  buttonAgregarExt: "#btnAgregarExt",

  /*CONTROLES MODALVIEW NEO-INSERT*/
  codigo: "#hidCodigo",
  nombreYegua: "#txtNombreYegua",
  nombrePotro: "#txtNombrePotro",
  madre: "#hidCodigoYegua",
  padre: "#hidCodigoPotro",
  fecMonta: "#dtFecMonta",
  fecParir: "#dtFecParir",
  idReceptor: "#hidIDRec",
  idTextoRec: "#txtIdTE",
  checkBoxE: "#rdbtnTE",
  checkBoxEX: "#rdbtnEE",
  checkBoxProp: "#rdbtnProp",
  checkBoxOtros: "#rdbtnOT",
  madADN: "#lblADNY",
  padADN: "#lblANDP",
  fecEmbrion: "#dtFecEmbrion",
  lblFecE: "#lblFecEmbrion",

  /*CONTROLES FORMULARIOS EJEMPLAR EXTRANJERO*/
  codigoExt: "#txtCodigoExt",
  nombreExt: "#txtNombreExt",
  prefijoExt: "#txtPrefijoExt",
  fechaNacExt: "#dtpFechaNacExt",
  genero: "#ddlGenero",

  /*CONTROLES MODALVIEW FALLECIDO*/
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
  // BUSQUEDA POR COMBO
  cboProp: "ddlProps",
  cboCria: "ddlCriador",
  cboIdMonta: "ddlIdMonta",
  cboPelaje: "ddlIdPelaje",
  cboPais: "ddlIdPais"
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
  $('[data-toggle="tooltip"]').tooltip();
  $("#btnPrint").on("click", function () {
    viewForm(9, $("#hidIdProp").val(), $("#hidIdPoe").val());
  }).button({
    icons: {
      primary: "ui-icon-print"
    }
  });
  $("#btnAgregar").on("click", function () {
    agregarItems();
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

  $("#btnBuscarFiltro").on("click", function () {
    listaServicioY();
  });
  $("#btnLimpiarFiltro").on("click", function () {
    limpiarFiltros();
    listaServicioY();
  });
  listaServicioY();


  /*INIT POPUP MODAL BUSCAR EJEMPLAR*/
  $("#btnBuscarMadre").on("click", function () {
    $("#hidTipoParents").val("Y");
    $("#hidGenero").val("Y");
    $("#rdbtnProp").prop("checked", true);
    $(controls.buttonAgregarExt).hide();
    $("#formEjemplarExt").hide();
    // $("#rdbtnEE").hide();
    $("#lblPropiedad").html("Yeguas de mi propiedad");
    $("#lblOtros").html("Yeguas de terceros");
    //$("#lblExtranjero").hide();
    $("#lblExtranjero").html("Yeguas extranjeras");
    $("#divBody").show();
    _buscar()
    $("#divBuscarEjemplar").modal('show');
    $("#txtBGNombre").val("");

    // initDataTableGrlEjemplar();

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
    _buscar()
    $("#divBuscarEjemplar").modal('show');
    $("#txtBGNombre").val("");
    $("#gridBusquedaEjemplar").show();
    $("#formEjemplarExt").hide();
    $(controls.buttonAgregarExt).hide();

    //  initDataTableGrlEjemplar();
  });
  /*FIN POPUP MODAL BUSCAR EJEMPLAR*/
  limpiarLabelEjemplar();
  listarMetodoRepropL('cboMetRep', 'SELECCIONE', 0);
  //listarIdNacimiento("ddlIdNac","SELECCIONE");
});

var limpiarFiltros = function () {
  $("#cboMetRep").val(0);
  $("#txtidReceptora").val('');
  $("#txtMadre").val('');
  $("#txtPadre").val('');
  $("#txtanio").val('');
  $("#txtmes").val('');

  $("#cboMetRep").selectpicker("refresh");
  $("#txtmes").selectpicker("refresh");
}

var listaServicioY = function () {
  setDataTable(0, 0);
};



var setDataTable = function (data, numRow) {

  $('#grid').DataTable({
    "processing": true,
    "serverSide": true,
    "ajax": {
      data: {
        opc: 'lstServY',
        idPoe: $("#hidIdPoe").val(),
        idProp: $("#hidIdProp").val(),
        metodoReproductivo: $("#cboMetRep").val() == 'SELECCIONE' ? '' : $("#cboMetRep").val(),
        idReceptora: $("#txtidReceptora").val(),
        madre: $("#txtMadre").val(),
        padre: $("#txtPadre").val(),
        anio: $("#txtanio").val(),
        mes: $("#txtmes").val()
      },
      url: controllersREST.ejemplar,
      type: 'POST',
      error: function () {
        $("#grid_processing").css("display", "none");
      },
      complete: function (response) {
        //console.log(response);
        $("#grid_processing").css("display", "none");
        if (response.responseJSON.validateToken != undefined && response.responseJSON.validateToken === 0)
          alertify.error(response.responseJSON.message);
        else
          $("#lblCantidadSol").html(response.responseJSON.recordsTotal);
      },
      beforeSend: function (request) {
        request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
      }
    },

    bFilter: false,
    ordering: false,
    language: {
      search: "Búsqueda:",
      lengthMenu: "Mostrar _MENU_ registros por página",
      zeroRecords: "No se encontraron registros",
      info: "Página  _PAGE_ de _PAGES_",
      infoEmpty: "No se encontraron registros"
    },
    responsive: true,
    destroy: true,
    pageLength: 100,
    columnDefs: [{
        width: "1%",
        targets: 0,
        visible: false,
        searchable: false
      },
      {
        width: "6%",
        targets: 1
      },
      {
        width: "18%",
        targets: 2
      },
      {
        width: "18%",
        targets: 3
      },
      {
        width: "1%",
        targets: 4,
        visible: false,
        searchable: false
      },
      {
        width: "5%",
        targets: 5
      },
      {
        width: "7%",
        targets: 6
      },
      {
        width: "5%",
        targets: 7
      },
      {
        width: "5%",
        targets: 8
      },
      {
        width: "5%",
        targets: 9
      },
      {
        width: "5%",
        targets: 10
      },
      {
        width: "7%",
        targets: 11
      },
      {
        width: "10%",
        targets: 12
      }
    ],
    autoWidth: false,
    order: [
      [0, "desc"]
    ],
    columns: [{
        "data": "id"
      },
      {
        "data": "codigoMonta"
      },
      {
        "data": "nombreYegua"
      },
      {
        "data": "nombrePotro"
      },
      {
        "data": "textoMetodo"
      },
      {
        "data": "transEmbrion",
        "render": function (datum, type, row) {
          return datum != 0 ? "SI" : "NO";
        }
      },
      {
        "data": "idReceptor"
      },
      {
        "data": "fechaDeEmbrion",
        "render": function (datum, type, row) {
          var dia = (datum).split("/")[0];
          var mes = (datum).split("/")[1];
          var anio = (datum).split("/")[2];
          var sort = "<span class='hidden'>" + anio + mes + dia + "</span>" + datum;

          return datum == "00/00/0000" ? "" : sort;
        }
      },
      {
        "data": "fechaMonta",
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
        "data": "fecAborto",
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
        "data": "fecCrea",
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
        "data": "estado",
        render: function (datum, type, row) {
          if (row.estado === "PEN")
            if (row.socioPotro == '' && row.socioYegua != '') {
              return "<span class='badge badge-warning badge-normal' title='Por confirmar " + row.socioYegua + "' data-toggle='tooltip' >" + row.estadoTexto + "</span>";
            } else if (row.socioPotro != '' && row.socioYegua == '') {
            return "<span class='badge badge-warning badge-normal' title='Por confirmar " + row.socioPotro + "' data-toggle='tooltip' >" + row.estadoTexto + "</span>";
          } else {
            return "<span class='badge badge-warning badge-normal' title='Por confirmar " + row.socioPotro + ", " + row.socioYegua + "' data-toggle='tooltip' >" + row.estadoTexto + "</span>";
          } else if (row.estado === "CON")
            return "<span class='badge badge-success badge-normal'>" + row.estadoTexto + "</span>";
          else if (row.estado === "REC")
            return "<span class='badge badge-danger badge-normal'>" + row.estadoTexto + "</span>";
        }
      },
      {
        "className": 'edit',
        "orderable": false,
        "data": null,
        "defaultContent": "",
        "render": function (obj, type, row, meta) {
          //console.log(obj.estado);
          var rowTable = '';
          if (obj.estado == 'PEN') {
            rowTable = "<span title='Modificar Solicitud' class='btn btn-default  btn-sm glyphicon glyphicon-edit' data-toggle='tooltip'  data-id='" + obj.id + "' data-estado='" + obj.estado + "' onclick='edit(this);'></span>";
            rowTable = rowTable + "<span title='Vista Previa'  class='btn btn-default  btn-sm glyphicon glyphicon-eye-open' data-toggle='tooltip' data-id='" + obj.id + "' data-estado='" + obj.estado + "' onclick='vistaPrevia(this);'></span>";
            rowTable = rowTable + "<span title='Imprimir Nacimiento Ejemplar' class='btn btn-default  btn-sm glyphicon glyphicon-print' data-toggle='tooltip' data-id='" + obj.id + "'  data-codigo='" + obj.codigoMonta + "' onclick='printServicioYegua(this);'></span>";
            rowTable = rowTable + "<span title='Eliminar Solicitud' class='btn btn-default  btn-sm glyphicon glyphicon-trash' data-toggle='tooltip'   data-id='" + obj.id + "' onclick='deleteServ(this);' ></span> ";

          } else if (row.idPropPotro == $("#hidIdProp").val() && row.idPropYegua == $("#hidIdProp").val()) {
            rowTable = "<span title='Modificar Solicitud' class='btn btn-default  btn-sm glyphicon glyphicon-edit' data-toggle='tooltip'  data-id='" + obj.id + "' data-estado='" + obj.estado + "' data-flag='" + 1 + "' onclick='edit(this);'></span>";
            rowTable = rowTable + "<span title='Vista Previa'  class='btn btn-default  btn-sm glyphicon glyphicon-eye-open' data-toggle='tooltip' data-id='" + obj.id + "' data-estado='" + obj.estado + "' onclick='vistaPrevia(this);'></span>";
            rowTable = rowTable + "<span title='Imprimir Nacimiento Ejemplar' class='btn btn-default  btn-sm glyphicon glyphicon-print' data-toggle='tooltip' data-id='" + obj.id + "'  data-codigo='" + obj.codigoMonta + "' onclick='printServicioYegua(this);'></span>";
            rowTable = rowTable + "<span title='Eliminar Solicitud' class='btn btn-default  btn-sm glyphicon glyphicon-trash' data-toggle='tooltip'   data-id='" + obj.id + "' onclick='deleteServ(this);' ></span>";

          } else {
            rowTable = "<span title='Vista Previa'  class='btn btn-default  btn-sm glyphicon glyphicon-eye-open' data-toggle='tooltip' data-id='" + obj.id + "' data-estado='" + obj.estado + "' onclick='vistaPrevia(this);'></span>";
            rowTable = rowTable + "<span title='Imprimir Nacimiento Ejemplar' class='btn btn-default  btn-sm glyphicon glyphicon-print' data-toggle='tooltip' data-id='" + obj.id + "'  data-codigo='" + obj.codigoMonta + "' onclick='printServicioYegua(this);'></span>";


          }
          return rowTable;
        }
      }
    ]
  });
  $('[data-toggle="tooltip"]').tooltip();
};

function agregarItems() {


  var html1 = '';
  $("#submit").show();
  clearCtrlsPopup();
  $("#hidFlagEdit").val(0);
  //mostrarSeccionDocumentos("","");
  valorTransfEmbrion(0);
  $("#btnSaveNE").show();
  $(controls.modalDialog + " .modal-title").html("Nuevo Servicio de Monta.");
  $("#mvNuevoEjemplar").data("action", "insert");
  $("#mvNuevoEjemplar").modal('show');
  $(controls.idReceptor).hide();
  $(controls.idTextoRec).hide();
  $(controls.fecEmbrion).hide();
  $(controls.lblFecE).hide();
  $("#pdfInputYegua").val('');
  $("#pdfInputPotro").val('');

  iniSeccionDocumentos("insert", '', '');
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


function showInputText() {
  if ($(controls.checkBoxE).is(":checked")) {
    $(controls.idReceptor).show();
    $(controls.idTextoRec).show();
    $(controls.fecEmbrion).show();
    $(controls.lblFecE).show();
    $(controls.idTextoRec).val("");
    $(controls.fecEmbrion).val("");
    //$(controls.idTextoRec).removeClass("form-control");
    $(controls.idTextoRec).addClass("requerido");
    $(controls.fecEmbrion).addClass("requerido");
    valorTransfEmbrion(1);
  } else {
    $(controls.idReceptor).hide();
    $(controls.idTextoRec).hide();
    $(controls.fecEmbrion).hide();
    $(controls.lblFecE).hide();
    $(controls.idTextoRec).val("");
    $(controls.fecEmbrion).val("");
    $(controls.idTextoRec).removeClass("requerido");
    $(controls.fecEmbrion).removeClass("requerido");
    $(controls.idTextoRec).css({
      'border': '1px solid #ccc'
    });
    $(controls.fecEmbrion).css({
      'border': '1px solid #ccc'
    });
    valorTransfEmbrion(0);
    //$(controls.idTextoRec).addClass("form-control");
  }
}


function valor() {
  var a = $("input[type=radio][name=metodo]:checked").val();
  //console.log(a);
}

var update = function () {
  //var codigo=controls.codigo;
  var checkMetodo = $("input[type=radio][name=metodo]:checked").val();
  if ($(controls.checkBoxE).is(":checked")) {
    var checktransf = 1;
  } else {
    var checktransf = 0;
  }
  var lstItemPropietario = ""; //getIdEntidad();

  var data = {
    opc: '-',
    codigo: $(controls.codigo).val(),
    padre: $(controls.padre).val(),
    madre: $(controls.madre).val(),
    //padre:$(controls.potro).text(),
    //yegua:$(controls.yegua).text(),
    idPoe: $("#hidIdPoe").val(),
    idProp: $("#hidIdProp").val(),
    fecMonta: $(controls.fecMonta).val(),
    fecParir: $(controls.fecParir).val(),
    metodo: checkMetodo,
    isTE: checktransf,
    idTextoRec: $(controls.idTextoRec).val(),
    fecEmbrion: $(controls.fecEmbrion).val()
  };
  //console.log($(controls.potro).text());
  if ($(controls.modalDialog).data("action") != "insert") {
    data.opc = 'updMonta';
  } else {
    data.opc = 'insMonta';
  }
  if (grlValidarObligatorio(controls.modalDialog)) {
    if (data.opc != "-") {
      grlEjecutarAccion(controllersREST.ejemplar, data, function (retorno) {
        //console.log(retorno);
        if (retorno.result === K_ResultadoAjax.exito) {

          grlEjecutarAccion(controllersREST.ejemplar, {
            opc: 'getLastIDMonta'
          }, function (retorno) {
            var ejemplar = retorno.data;
            if (retorno.result === K_ResultadoAjax.exito && data.opc == "insMonta") {
              subirArchivo(ejemplar.codigoMonta);
              alertify.alert("Se registró una monta con el código : " + ejemplar.codigoMonta, function () {
                alertify.success(retorno.message);
              });
              // alertify.success(retorno.message);
              $("#mvNuevoEjemplar").modal("hide");
            } else {
              subirArchivo(ejemplar.codigoMonta);
              alertify.alert("Se actualizó una monta con el código : " + $("#hidCodigoMonta").val(), function () {
                alertify.success(retorno.message);
              });
              // alertify.success(retorno.message);
              $("#mvNuevoEjemplar").modal("hide");
            }
          });
        } else if (retorno.result === K_ResultadoAjax.error) {
          alertify.set('notifier', 'delay', 10);
          alertify.error(retorno.message);
        } else if (retorno.result === K_ResultadoAjax.warning) {
          alertify.warning(retorno.message);
        } else if (retorno.result === K_ResultadoAjax.duplicate) {
          alertify.error(retorno.message);
        }
        search();
      });
    } else {
      alertify.error(messages.noDeterminated);
    }
  }

};

function clearCtrlsPopup() {
  grlLimpiarObligatorio(controls.modalDialog);
  $(controls.fecNace).val("");
  $(controls.nombreYegua).html("");
  $(controls.nombrePotro).html("");
  $(controls.fecMonta).val("");
  $(controls.fecParir).val("");
  $(controls.potro).html("");
  $(controls.metodo).val("");
  $(controls.idReceptor).hide();
  $(controls.idTextoRec).hide();
  $("#rdbtnTE").prop('checked', false);
  $(controls.padADN).html("");
  $(controls.madADN).html("");
  $("hidTipoParents").val("");
  $(controls.buttonAgregarExt).hide();
  $("#formEjemplarExt").hide();
  $("#hidCodigoMonta").val("");
  $('#rdbtnMN').prop('checked', true);

  $(controls.fecNace).prop("disabled", false);
  $(controls.fecMonta).prop("disabled", false);
  $(controls.fecParir).prop("disabled", false);
  $(controls.idTextoRec).prop("disabled", false);
  $(controls.fecEmbrion).prop("disabled", false);
  $("#rdbtnTE").prop('disabled', false);
  $('input[name=metodo]').attr("disabled", false);
  $("#btnBuscarMadre").show();
  $("#btnBuscarPadre").show();
}

function search() {
  listaServicioY();
}

function setCssEstado(estadoSolId) {
  var cssEstado = '';
  switch (estadoSolId) {
    case 'INI':
      cssEstado = " badge-info ";
      break;
    case 'REV':
      cssEstado = " badge-primary";
      break;
    case 'APR':
      cssEstado = " badge-success ";
      break;
    case 'OBS':
      cssEstado = " badge-warning ";
      break;
    case 'REC':
      cssEstado = " badge-danger ";
      break;
    default:
      cssEstado = " badge-info ";
      break;
  };

  return cssEstado;
}


function verLog(obj) {
  //console.log(controls.modalDialogLog);
  $(controls.modalDialogLog).modal("show");
}

function vistaPrevia(obj) {
  clearCtrlsPopup();
  var id = $(obj).data("id");
  $(controls.fecNace).prop("disabled", true);
  $(controls.fecMonta).prop("disabled", true);
  $(controls.fecParir).prop("disabled", true);
  //$(".metodo").prop("disabled",true);
  $(controls.idTextoRec).prop("disabled", true);
  $(controls.fecEmbrion).prop("disabled", true);
  $("#rdbtnTE").prop('disabled', true);
  $("#btnBuscarMadre").hide();
  $("#btnBuscarPadre").hide();
  $("#btnSaveNE").hide()
  $('input[name=metodo]').attr("disabled", true);
  editar(id, 1);
}

function edit(obj) {
  clearCtrlsPopup();
  $("#hidFlagEdit").val(1);
  var id = $(obj).data("id");
  var estado = $(obj).data("estado");
  var flagProp = $(obj).data("flag");
  grlEjecutarAccion(controllersREST.ejemplar, {
    opc: 'valStatus',
    id: id,
    flag: 'MON'
  }, function (retorno) {

    if (retorno.result == 1 || estado == 'REC') {
      //console.log(retorno);
      if (flagProp == 1) {
        $(controls.fecNace).prop("disabled", false);
        $(controls.fecMonta).prop("disabled", false);
        $(controls.fecParir).prop("disabled", false);
        //$(".metodo").prop("disabled",true);
        $(controls.idTextoRec).prop("disabled", false);
        $(controls.fecEmbrion).prop("disabled", false);
        $("#rdbtnTE").prop('disabled', false);
        $("#btnBuscarMadre").hide();
        $("#btnBuscarPadre").hide();
        $("#btnSaveNE").show()
        $('input[name=metodo]').attr("disabled", false);

      } else {
        $(controls.fecNace).prop("disabled", true);
        $(controls.fecMonta).prop("disabled", true);
        $(controls.fecParir).prop("disabled", true);
        //$(".metodo").prop("disabled",true);
        $(controls.idTextoRec).prop("disabled", true);
        $(controls.fecEmbrion).prop("disabled", true);
        $("#rdbtnTE").prop('disabled', true);
        $("#btnBuscarMadre").hide();
        $("#btnBuscarPadre").hide();
        $("#btnSaveNE").hide()
        $('input[name=metodo]').attr("disabled", true);
      }
      editar(id);
    } else {
      $(controls.fecNace).prop("disabled", false);
      $(controls.fecMonta).prop("disabled", false);
      $(controls.fecParir).prop("disabled", false);
      //$(".metodo").prop("disabled",false);
      $(controls.idTextoRec).prop("disabled", false);
      $(controls.fecEmbrion).prop("disabled", false);
      $("#rdbtnTE").prop('disabled', false);
      $("#btnBuscarMadre").show();
      $("#btnBuscarPadre").show();
      $("#btnSaveNE").show()
      $('input[name=metodo]').attr("disabled", false);
      editar(id);
    }


  });

}

function deleteServ(obj) {
  var id = $(obj).data("id");
  if (id != undefined) {
    alertify.confirm(mensaje.mensajeBorrar, function (e) {
      if (e) {


        grlEjecutarAccion(controllersREST.ejemplar, {
          opc: 'delServy',
          id: id
        }, function (retorno) {
          if (retorno.result == K_ResultadoAjax.exito) {

            alertify.success(retorno.message);
            listaServicioY();
          } else if (retorno.result == 995) {
            alertify.alert(retorno.message + " " + retorno.data.codigoNacimiento, function () {

            });
            listaServicioY();
          } else if (retorno.result == 0) {
            alertify.error(retorno.message);
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

function editar(codigo, valor = 0) {
  // console.log(codigo);
  if (codigo != undefined) {
    grlEjecutarAccion(controllersREST.ejemplar, {
      opc: 'getMonta',
      codigo: codigo
    }, function (retorno) {
      //  console.log(retorno);
      if (retorno.result == K_ResultadoAjax.exito) {
        var ejemplar = retorno.data;
        if (ejemplar != null) {
          //console.log(ejemplar);
          //console.log(valor);
          if (valor != 0) {
            $(controls.modalDialog + " .modal-title").html("Vista Previa de monta -  Código:<span class='badge badge-default'>" + ejemplar.codigoMonta + "</span>");
            $("#submit").hide();
          } else {
            $(controls.modalDialog + " .modal-title").html("Modificar Servicio de Monta -  Código:<span class='badge badge-default'>" + ejemplar.codigoMonta + "</span>");
            $("#submit").show();
            $("#pdfInputYegua").show();
            $("#pdfInputPotro").show();
          }

          $(controls.modalDialog).data("action", "edit");
          $(controls.modalDialog).modal("show");
          $(controls.codigo).val(ejemplar.id);
          $("#hidCodigoMonta").val(ejemplar.codigoMonta);
          $(controls.nombrePotro).html(ejemplar.prefPotro + ' ' + ejemplar.potro + ' ' + ejemplar.codPotro);
          $(controls.nombreYegua).html(ejemplar.prefYegua + ' ' + ejemplar.yegua + ' ' + ejemplar.codYegua);
          $(controls.madre).val(ejemplar.codYegua);
          $(controls.padre).val(ejemplar.codPotro);
          if (ejemplar.padreADN != null) {
            $(controls.padADN).html(ejemplar.padreADN.adn);
          } else {
            $(controls.padADN).html("NO");
          }
          if (ejemplar.madreADN != null) {
            $(controls.madADN).html(ejemplar.madreADN.adn);
          } else {
            $(controls.madADN).html("NO");
          }

          //$(controls.fecMonta).val(ejemplar.fecMonta);
          $("#dtFecMonta").val(ejemplar.fecMonta);
          $(controls.fecParir).val(ejemplar.fecParir);
          if (ejemplar.metodo == "MN") {
            //console.log("111111111111111111");
            $('#rdbtnMN').prop('checked', true);
          } else if (ejemplar.metodo == "SF") {
            // console.log("222222222222222");
            $('#rdbtnSF').prop('checked', true);
          } else if (ejemplar.metodo == "SR") {
            $('#rdbtnSR').prop('checked', true);
          } else if (ejemplar.metodo == "SC") {
            $('#rdbtnSC').prop('checked', true);
          } else if (ejemplar.metodo == "TE") {
            $('#rdbtnTE').prop('checked', true);
          }

          if (ejemplar.isTE == 1) {
            $("#rdbtnTE").prop("checked", true);
            $(controls.idReceptor).show();
            $(controls.idTextoRec).show();
            $(controls.lblFecE).show();
            $(controls.fecEmbrion).show();
            $(controls.idTextoRec).val(ejemplar.idReceptor);
            $(controls.fecEmbrion).val(ejemplar.fecEmbrion);
            valorTransfEmbrion(1);
          } else {
            $(controls.idReceptor).hide();
            $(controls.idTextoRec).hide();
            $(controls.lblFecE).hide();
            $(controls.fecEmbrion).hide();
            valorTransfEmbrion(0);
          }

          var action = "edit";
          if (valor == 1) {
            action = 'view'
          }

          validarEjemplar(ejemplar.codPotro, $("#hidIdProp").val(), 'P', action);
          validarEjemplar(ejemplar.codYegua, $("#hidIdProp").val(), 'Y', action);

          listarDoc(ejemplar.id);
          //console.log($("#hesExtTerPotro").val());
          //console.log($("#hesExtTerYegua").val());
          /*iniSeccionDocumentos(action,$("#hesExtTerPotro").val(),'P');
           iniSeccionDocumentos(action,$("#hesExtTerYegua").val(),'Y');*/
        } else {
          alertify.error(retorno.message);
        }
      } else if (retorno.result == K_ResultadoAjax.error) {
        alertify.error(retorno.message);
      }
    });
  }
}

function validarEjemplar(codigo, hidIdProp, tipo, action) {
  ObtenerUrl(function (urlObtenida) {
    if (urlObtenida != '') {
      $.ajax({
        data: {
          opc: 'valMiEjemplar',
          codigo: codigo,
          idProp: hidIdProp
        },
        url: urlObtenida.K_PATH_ROOT_SERVICIO + 'EjemplarService.php',
        type: 'post',
        success: function (response) {
          //console.log(response);
          //console.log(response.result);
          if (tipo == 'P') {
            $("#hesExtTerPotro").val(response.result);
          } else {
            $("#hesExtTerYegua").val(response.result);
          }
          iniSeccionDocumentos(action, $("#hesExtTerPotro").val(), 'P');
          iniSeccionDocumentos(action, $("#hesExtTerYegua").val(), 'Y');
          // mostrarSeccionDocumentos(response.result,tipo);
        }
      });
    }
  });
}

function addMonths() {
  var x = 11;
  var myDate = new Date($(controls.fecMonta).val());
  myDate.setMonth(myDate.getMonth() + x);
  var date = formatDate(myDate);

  $(controls.fecParir).val(date);
}


function formatDate(date) {
  var year = date.getFullYear().toString();
  var month = (date.getMonth() + 101).toString().substring(1);
  var day = (date.getDate() + 100).toString().substring(1);
  return year + "-" + month + "-" + day;
}

function addEjemplarExt() {
  if ($(controls.checkBoxEX).is(":checked")) {
    $(controls.buttonAgregarExt).show();
    $(controls.codigoExt).addClass("form-control requerido");
    $(controls.nombreExt).addClass("form-control requerido");
    $("#divBody").show();
    //console.log('1');
  }
  if ($(controls.checkBoxProp).is(":checked")) {
    $(controls.buttonAgregarExt).hide();
    $("#formEjemplarExt").hide();
    $("#divBody").show();
    $(controls.codigoExt).removeClass("form-control requerido");
    $(controls.nombreExt).removeClass("form-control requerido");
    //console.log('2');
  }
  if ($(controls.checkBoxOtros).is(":checked")) {
    $(controls.buttonAgregarExt).hide();
    $("#formEjemplarExt").hide();
    $("#divBody").show();
    $(controls.codigoExt).removeClass("form-control requerido");
    $(controls.nombreExt).removeClass("form-control requerido");
    // console.log('3');
  }
}

function addExtranjero() {
  clearPopUpEjemplarExt();
  listarPelajeExt("ddlIdPelaje", "SELECCIONE");
  listarPaises("ddlIdPais", "SELECCIONE");
  $("#divBody").hide();
  $(controls.codigoExt).addClass("form-control requerido");
  $(controls.nombreExt).addClass("form-control requerido");
  $("#formEjemplarExt").show();
  $("#txtCodigoExt").css({
    'border': '1px solid #ccc'
  });
  $("#txtNombreExt").css({
    'border': '1px solid #ccc'
  });
}

function clearPopUpEjemplarExt() {
  $(controls.codigoExt).val("");
  $(controls.nombreExt).val("");
  $(controls.prefijoExt).val("");
  $(controls.fechaNacExt).val("");
  $(controls.genero).val("");
}


function saveEjemplarExt() {

  var data = {
    opc: "extIns",
    codigo: $(controls.codigoExt).val(),
    nombre: $(controls.nombreExt).val(),
    prefijo: $(controls.prefijoExt).val(),
    fecNace: $(controls.fechaNacExt).val(),
    idPelaje: $("#" + controls.cboPelaje).val(),
    idPais: $("#" + controls.cboPais).val(),
    genero: $("#hidGenero").val(),
    origen: $("#codOrigen").val()
  }
  //console.log(data);
  //divBuscarEjemplar
  if (grlValidarObligatorio(controls.modalDialogE)) {
    if (data.codigo != undefined || data.codigo != null || data.codigo != "") {
      grlEjecutarAccion(controllersREST.ejemplar, data, function (retorno) {

        if (retorno.result === K_ResultadoAjax.exito) {
          $("#formEjemplarExt").hide();
          $("#divBody").show();
          _buscar();
          clearPopUpEjemplarExt();
          $(controls.codigoExt).removeClass("form-control requerido");
          $(controls.nombreExt).removeClass("form-control requerido");

        }
      });
    }

  }
}

function Cancelar() {
  $("#formEjemplarExt").hide();
}



function printServicioYegua(obj) {

  var prop = $("#hidIdProp").val();
  var codigoMonta = $(obj).data("codigo");
  var id = $(obj).data("id");

  //grlCenterWindow(1000, 600, 50, , 'demo_win');
  window.open('printServicioYegua.php?codigo=' + id + '&codigoMonta=' + codigoMonta + '&prop=' + prop);
}

function valorTransfEmbrion(val) {
  $("#txtIsTE").val(val);
}

function mostrarSeccionDocumentos(val, genero) {
  //console.log("mostrarSeccionDocumentos - "+val + " - "+genero);
  $("#seccionDocumentos").show();

  if (val == 0 && genero == 'P') {
    //	$("#seccionDocumentos").show();
    $("#lblAutoPotro").show();
    $("#pdfInputPotro").show();
    $("#imgpdfPotro").hide();
    $("#divrdbtnDelPotro").hide();
    $("#lblrdbtnDelPotro").hide();
  } else if (val == 0 && genero == 'Y') {
    //	$("#seccionDocumentos").show();
    $("#lblAutoYegua").show();
    $("#pdfInputYegua").show();
    $("#imgpdfYegua").hide();
    $("#divrdbtnDelYegua").hide();
    $("#lblrdbtnDelYegua").hide();
  } else if (val == 1 && genero == "P") {
    //$("#seccionDocumentos").hide();
    $("#lblAutoPotro").hide();
    $("#pdfInputPotro").hide();
    $("#imgpdfPotro").hide();
    $("#divrdbtnDelPotro").hide();
    $("#lblrdbtnDelPotro").hide();
  } else if (val == 1 && genero == "Y") {
    //$("#seccionDocumentos").hide();
    $("#lblAutoYegua").hide();
    $("#pdfInputYegua").hide();
    $("#imgpdfYegua").hide();
    $("#divrdbtnDelYegua").hide();
    $("#lblrdbtnDelYegua").hide();
  }
}

function tieneDocPotro() {
  var resultado = false;
  if (datosDocPotro.length != 0) {
    resultado = true
  } else {
    resultado = false;
  }
  return resultado;
}

function tieneDocYegua() {
  var resultado = false;
  if (datosDocYegua.length != 0) {
    resultado = true
  } else {
    resultado = false;
  }
  return resultado;
}

function datosDocYeguaControls() {
  var img = datosDocYegua.ruta;
  if (tieneDocYegua() == true) {
    mostrarImgGrande(img, 'Y');

  }
}

function datosDocPotroControls() {
  var img = datosDocPotro.ruta;
  if (tieneDocPotro() == true) {
    mostrarImgGrande(img, 'P');
  }
}

function iniSeccionDocumentos(action, esPropiedad, genero) {
  //console.log(action);
  if (action == "insert") {
    $("#seccionDocumentos").hide();
    $("#lblAutoPotro").hide();
    $("#lblAutoYegua").hide();
  } else if (action == "view") {
    if ($("#hesExtTerYegua").val() == 1 && $("#hesExtTerPotro").val() == 1) {
      $("#seccionDocumentos").hide();
    } else {
      $("#seccionDocumentos").show();
      if (esPropiedad == 0 && genero == "P") {
        $("#lblAutoPotro").show();
        if (tieneDocPotro() == true) {
          $("#imgpdfPotro").show();
          $("#divrdbtnDelPotro").hide();
          $("#lblrdbtnDelPotro").hide();
          $("#pdfInputPotro").hide();
          datosDocPotroControls();
        } else {
          $("#imgpdfPotro").hide();
          $("#divrdbtnDelPotro").hide();
          $("#lblrdbtnDelPotro").hide();
          $("#pdfInputPotro").hide();
        }


      } else if (esPropiedad == 1 && genero == "P") {
        $("#lblAutoPotro").hide();
      }

      if (esPropiedad == 0 && genero == "Y") {
        $("#lblAutoYegua").show();
        if (tieneDocYegua() == true) {
          $("#imgpdfYegua").show();
          $("#divrdbtnDelYegua").hide();
          $("#lblrdbtnDelYegua").hide();
          $("#pdfInputYegua").hide();
          datosDocYeguaControls();
        } else {
          $("#imgpdfYegua").hide();
          $("#divrdbtnDelYegua").hide();
          $("#lblrdbtnDelYegua").hide();
          $("#pdfInputYegua").hide();
        }
      } else if (esPropiedad == 1 && genero == "Y") {
        $("#lblAutoYegua").hide();
      }
    }

  } else {
    $("#seccionDocumentos").show();
    if (esPropiedad == 0 && genero == "P") {
      //MONTAR LA SECCIOND E POTRO
      //VALIDAR SI CARGO DOCUMENTO
      // TRAERMOS LOS DATOS LO QUE ACTIVARA EL ELIMINAR
      $("#lblAutoPotro").show();
      if (tieneDocPotro() == true) {
        //HABILIAR PARA VER DOC O ELIMNAR
        $("#imgpdfPotro").show();
        $("#divrdbtnDelPotro").show();
        $("#lblrdbtnDelPotro").show();
        datosDocPotroControls();
      } else {
        // OCULTAR CONTROLES
        $("#imgpdfPotro").hide();
        $("#divrdbtnDelPotro").hide();
        $("#lblrdbtnDelPotro").hide();
      }


    } else if (esPropiedad == 1 && genero == "P") {
      //console.log("AQUI");
      //mostrarSeccionDocumentos(esPropiedad,genero);
      $("#lblAutoPotro").hide();
    }

    if (esPropiedad == 0 && genero == "Y") {
      $("#lblAutoYegua").show();
      if (tieneDocYegua() == true) {
        $("#imgpdfYegua").show();
        $("#divrdbtnDelYegua").show();
        $("#lblrdbtnDelYegua").show();
        datosDocYeguaControls();
      } else {
        $("#imgpdfYegua").hide();
        $("#divrdbtnDelYegua").hide();
        $("#lblrdbtnDelYegua").hide();
      }
    } else if (esPropiedad == 1 && genero == "Y") {
      //mostrarSeccionDocumentos(esPropiedad,genero);
      $("#lblAutoYegua").hide();
    }
  }
}