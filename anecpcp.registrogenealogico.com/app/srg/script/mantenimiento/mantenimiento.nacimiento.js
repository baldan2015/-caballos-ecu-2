/* controls: Objeto Json que contiene los  IDs de los controles que se crean en el html */
//formulario:"#divContainer",
var separadorResenia = ", ";
var K_TOKEN_NAME = "Authorization";
var controls = {
  actions: "#hidActionPopup",
  modalDialog: "#mvNuevoNacimiento",
  modalDialogFac: "#mvFalleceEjemplar",
  modalDialogSuperCamp: "#mvSuperCamp",
  modalDialogPrint: "#mvPrintCertificado",
  buttonPrintCert: "#btnPrintCert",
  modalUploadImg: "#mvUploadImagen",
  modalDialogImg: "#mvImgEjemplar",
  modalDialogPdf: "#mvPdfEjemplar",
  modalDialogLog: "#mvLogSolicitudDetaNac",
  modalDialogEstado: "#mvEstadoNacimiento",
  buttonPrint: "#btnPrintHorse",
  buttonPrintCE: "#btnPrintCE",
  buttonDead: "#btnFallece",
  buttonNew: "#btnNewRE2",
  buttonSave: "#btnSaveNE",
  buttonDel: "#btnEliminar",
  buttonEdit: "#btnEditarR",
  buttonView: "#btnVer",
  buttonCancel: "#btnCancelarNac",
  buttonSaveFac: "#btnSaveFac",
  buttonSaveImg: "#btnUpload",
  buttonSuperCamp: "#btnSuperCamp",
  buttonLog: "#btnLog",
  buttonEstado: "#btnUpdEstado",
  buttonSaveE: "#btnSaveEI",
  /*CONTROLES MODALVIEW NEO-INSERT*/
  codigo: "#hidCodigo",
  nacimiento: "#hidCodigoNacimiento",
  prefijo: "#txtPrefijo",
  cboPelaje: "ddlTipoPel",
  nombre: "#txtNombre",
  fecNace: "#dtFechaNac",
  lugarNace: "#txtLugarNac",
  microchip: "#txtMicrochip",
  anotacion: "#txtDescripcion",
  sexo: "#ddlGenero",
  fecCapado: "#txtFecCapado",
  cboProvincia: "ddlProvinvia",
  cboDepartamento: "ddlProvinvia",
  origen: "#ddlOrigen",
  reseniasLeft: "#ddlReseniaLeft",
  reseniasRight: "#ddlReseniaRight",
  fecReg: "#dtpFechReg",
  areaResenas: "#txtAResenia",
  yegua: "#hidIdMadre",
  potro: "#hidIdPadre",
  metodoRep: "#lblMetRep",
  idMonta: "#lblIdMonta",
  idNac: "#lblIdNac",
  metodo: "#hidMetodo",
  hidIdMonta: "#hidIdMonta",
  hidIdNac: "#hidIdNac",
  hidFecMonta: "#hidFecMonta",
  // BUSQUEDA POR COMBO
  cboProp: "ddlProps",
  cboCria: "ddlCriador",

  /*popup estado*/
  codigoNacimientoE: "#lblCodigoNacimientoE",
  origenE: "#lblOrigenE",
  generoE: "#lblGeneroE",
  nombreE: "#lblNombreE",
  pelajeE: "#lblPelajeE",
  provinciaE: "#lblProvinciaE",
  lugarNaceE: "#lblLugarNaceE",
  fecNacE: "#dtFechaNacE",
  microchipE: "#lblMicrochipE",
  anotacionE: "#txtDescripcionE",
  reseniasE: "#txtAReseniaE",
  criadorE: "#lblCriadorE",
  madreE: "#lblYeguaE",
  padreE: "#lblPotroE",
  metodoRepE: "#lblMetRepE",
  idMontaE: "#lblIdMontaE",
  idNacE: "#lblIdNacE",
  cboIdMonta: "ddlIdMonta",



};
var K_PATH_ROOT = "../";
var setting = {
  limitDayBorn: 365,
  /*334=11 meses*/
  limitInitDayBorn: 304 /*10 meses*/
};

var controllersREST = {
  imagen: K_PATH_ROOT + 'services/ImagenService.php'
}
/* action:  objeto Json que contiene las operaciones que se estan realizando en la vista Html para las ventanas modales*/
var actions = {
  insert: 1,
  update: 2,
  read: 3
};
var events = {
  click: "click",
  change: "change",
  keypress: "keypress"
};

var titles = {
  modalNew: "Nuevo registro de nacimiento",
  modalEdit: "Actualización de nacimiento",
  modalRead: "Información de nacimiento",
  modalNoDeterminated: "Titulo no determinado",
  modalNone: "",
  modalImg: "Imagen del Ejemplar",
  modalEstado: "Actualizacion de Solicitud de nacimiento"
}
var controllers = {
  ejemplar: 'ajax/ajaxNacimiento.php',
  ejemplarJQGRID: 'ajax/ajaxNacimientoJQgrid.php',
  impresion: 'ajax/ajaxImpresion.php',
}
var messages = {
  inserted: 'Nacimiento registrada correctamente',
  updated: 'Nacimiento actualizada correctamente',
  noDeterminated: 'Error de aplicación: Operación no determinada.'
}
var id = '';

$(function () {

  $("#busquedaRe").on("keypress", function (e) {
    buscarResenia();
  });
  $("#btnFiltrarResena").on("click", function () {
    buscarResenia();
  });

  filtrosResenias();
  botonesOrdenar();
  $("#btnBuscarResenia").on(events.click, function () {
    configCheckResenias('');
    openGrlResena('ALL', '', '', '', '', '');
    $("#mvBuscadorResenaGrl").modal('show');
  });
  $("#btnLimpiarResena").on("click", function () {
    limpiarBusqueda();
  });


  listarCriador(controls.cboCria, "TODOS", 0);
  listarPropietario(controls.cboProp, "TODOS", 0);
  listarTipoDocumento("ddlTipoDocumento", "SELECCIONE");
  settingResenia();
  cantidadAllNacimientos();
  $("#ddlEstadoBus").val('A');
  $(controls.buttonPrintCE).on(events.click, function () {
    window.print();
  });
  $(controls.buttonPrint).on(events.click, function () {
    /*printCertificado();printer(id)*/
    printNacimiento(id);
  });
  $(controls.buttonNew).on(events.click, function () {
    nuevo();
  });
  $(controls.buttonSave).on(events.click, function () {
    grlEjecutarAccion(controllers.ejemplar, {
      opc: 'val',
      fecServ: $(controls.fecServ).val(),
      fecNace: $(controls.fecNace).val(),
      idmadre: $(controls.madre).val(),
      idHijo: $(controls.codigo).val()
    }, function (retorno) {
      if (retorno.result === K_ResultadoAjax.exito) {
        update();
      } else if (retorno.result === K_ResultadoAjax.error) {
        alertify.confirm('Advertencia', 'La fecha de nacimiento y la fecha de servicio es inconsistente verificarlo. Desea continuar ?',
          function () {
            update();
          },
          function () {
            /*alertify.error('Cancel')*/
          });
      } else if (retorno.result === K_ResultadoAjax.warning) {
        alertify.confirm('Advertencia', 'Existe traslape del ejemplar a registrar con las crias de la madre' + ' : ' + $("#lblMadre").html() + ' ' + '.Desea Continuar ?',
          function () {
            update();
          },
          function () {
            /*alertify.error('Cancel')*/
          });
      }
    });
  });
  $(controls.buttonEdit).on(events.click, function () {
    modificar(id);
  });
  $(controls.buttonDel).on(events.click, function () {
    eliminar(id);
  });
  $(controls.buttonSaveImg).on(events.click, function () {
    /*uploadImagen(id);*/
    addImg(id);
  });
  $(controls.buttonPrintCert).on(events.click, function () {
    /*printTransferencia(id);*/
    addCert(id);
  });

  $(controls.buttonView).on(events.click, function () {
    search();
  });
  $(controls.buttonCancel).on(events.click, function () {
    clearParamSearch();
    search();
  });
  $(controls.buttonLog).on(events.click, function () {
    verLog(id);
  })
  $(controls.buttonEstado).on(events.click, function () {
    updateEstado(id);
  });

  //listarResenia("ddlReseniaLeftCA", "", "CA");
  //listarResenia("ddlReseniaLeftAD", "", "AD");
  //listarResenia("ddlReseniaLeftAI", "", "AI");
  //listarResenia("ddlReseniaLeftPD", "", "PD");
  //listarResenia("ddlReseniaLeftPI", "", "PI");
  initDataTable(); /*INIT DATATABLE GRILLA PRINCIPAL*/

  //filtros
  $("#txtCodigoBus").on(events.keypress, function (e) {
    if (e.which == 13) {
      search();
    }
  });
  $("#txtPrefijoBus").on(events.keypress, function (e) {
    if (e.which == 13) {
      search();
    }
  });
  $("#txtNombreBus").on(events.keypress, function (e) {
    if (e.which == 13) {
      search();
    }
  });
  /*INIT POPUP MODAL NUEVO EDIT EJEMPLAR*/
  $(controls.modalDialog).on('show.bs.modal', function () {

    clearCtrlsPopup();

    if ($(this).data("action") != "insert") {
      //$(controls.modalDialog+' .modal-title').html("ACTUALIZACIÓN DE NACIMIENTO");
    } else {
      $('.selectpicker').selectpicker();
      $('.selectpicker').selectpicker('val', []);

      $(controls.origen).val("0");
      // $(controls.origen).removeAttr("disabled");
      // $(controls.modalDialog+' .modal-title').html("REGISTRO DE NUEVA NACIMIENTO");
    }
  });
  /*FIN  POPUP MODAL NUEVO EDIT EJEMPLAR*/

  /* INICIO POPUP DE ACTUALIZAR ESTADO DE SOLICITUD */
  $(controls.buttonSaveE).on(events.click, function () {
    //console.log($("#hidIdPropE").val());
    // console.log($("#txtCodCriador").val());
    if (grlValidarObligatorio(controls.modalDialogEstado)) {
      grlEjecutarAccion(controllers.ejemplar, {
          opc: 'updEst',
          id: $("#hidCodigoE").val(),
          vestado: $("#ddlEstadoSol").val(),
          vcomentario: $("#txtComentarioE").val(),
          iidProp: $("#hidIdUsu").val(),
          vProp: $("#hidIdPropE").val(),
          vCria: $("#txtCodCriador").val()
        },
        function (retorno) {
          if (retorno == null) {
            //console.log("entro aquiiiiiiii!!!!");
          } else {

            //var id = retorno.data;
            //console.log(id);
            if (retorno.result === K_ResultadoAjax.exito) {
              $(controls.modalDialogEstado).modal("hide");
              search();
              cantidadAllInscripciones();
              alertify.success(retorno.message);
            } else if (retorno.result === 999) {
              alertify.warning(retorno.message);
            } else if (retorno.result === 2) {
              $(controls.modalDialogEstado).modal("hide");
              search();
              cantidadAllNacimientos();
              alertify.success(retorno.message);
            } else {
              alertify.warning(retorno.message);
            }
          }
        });
    }
  });
  /* FIN POPUP DE ACTUALIZAR ESTADO DE SOLICITUD */

  $(".btn-pref .btn").click(function () {
    $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
    $(this).removeClass("btn-default").addClass("btn-primary");
  });
});


function search() {
  validarSesion(function (isLogout) {
    if (isLogout != "1") {
      $("#grid").jqGrid("clearGridData", true);
      $("#grid").jqGrid('setGridParam', {
        url: controllers.ejemplarJQGRID,
        datatype: 'json',
        mtype: 'GET',
        postData: paramSearch()
      }).trigger('reloadGrid');
    }
  });
}

function eliminar(obj) {

  if (obj) {
    var key = $(obj).data("id");
  } else {
    var key = $("#grid").jqGrid('getGridParam', "selrow");
  }

  if (key) {
    alertify.confirm('Advertencia', 'Está seguro de eliminar los registros seleccionados?',
      function () {

        grlEjecutarAccion(controllers.ejemplar, {
          opc: 'del',
          key: key
        }, function (retorno) {
          if (retorno.result === K_ResultadoAjax.exito) {
            search();
            alertify.success(retorno.message);
          } else if (retorno.result === K_ResultadoAjax.error) {
            alertify.error(retorno.message);
          } else if (retorno.result == 2) {
            alertify.error(retorno.message);
            search();
            //listaNacimientos();
          }
        });

      },
      function () {
        //alertify.error('Cancel')
      }
    );
  } else {
    alertify.warning("Seleccionar Nacimiento");
  }
}

function paramSearch() {

  var vprop = eval($('#' + controls.cboProp).val());
  var vente = 0;


  return {
    idEjemplar: $("#txtCodigoBus").val(),
    prefijo: $("#txtPrefijoBus").val(),
    nombre: $("#txtNombreBus").val(),
    prop: vprop, //eval($('#'+controls.cboProp).val()),
    ente: vente, //$("#hidIdEnteBus").val(),
    estado: $("#ddlEstadoBus").val()
  };
};

function clearParamSearch() {

  $("#txtCodigoBus").val("");
  $("#txtPrefijoBus").val("");
  $("#txtNombreBus").val("");
  $("#ddlEstadoBus").val('A');
  $('#ddlProps').val(0);
  $('#ddlProps').selectpicker('refresh');
};

function initDataTable() {

  jQuery("#grid").jqGrid({
    url: controllers.ejemplarJQGRID,
    postData: paramSearch(),
    datatype: "json",
    height: "auto",
    mtype: 'GET',
    colNames: ['id', 'Código Nac', 'Prefijo', 'Nombre', 'fec. Nac', 'fec. Sol', 'Propietario', 'Criador',
      'Pelaje', 'lugar Nac.', 'Estado', 'EstadoSol', 'Situación'
    ],
    colModel: [{
        name: 'idEjemplar',
        index: 'idEjemplar',
        width: 150,
        key: true,
        hidden: true
      },
      {
        name: 'codigoNacimiento',
        index: 'codigoNacimiento',
        width: 150
      },
      {
        name: 'prefijo',
        index: 'prefijo',
        width: 130
      },
      {
        name: 'nombre',
        index: 'nombre',
        width: 300,
        align: "left"
      },
      {
        name: 'fecNace',
        index: 'fecNace',
        width: 150,
        align: "left"
      },
      {
        name: 'fecReg',
        index: 'fecReg',
        width: 150,
        align: "left"
      },
      {
        name: 'propietarios',
        index: 'propietarios',
        width: 380,
        align: "left"
      },
      {
        name: 'criadores',
        index: 'criadores',
        width: 380,
        align: "left"
      },
      {
        name: 'nombrePelaje',
        index: 'nombrePelaje',
        width: 200,
        align: "left"
      },
      {
        name: 'LugarNace',
        index: 'LugarNace',
        width: 200,
        align: "left"
      },
      {
        name: 'estado',
        index: 'estado',
        width: 150,
        align: "left"
      },
      {
        name: 'estadoSol',
        index: 'estadoSol',
        hidden: true
      },
      {
        name: 'activo',
        index: 'activo',
        width: 150,
        align: "left"
      }



    ],
    afterInsertRow: function (rowId, data) {
      var rows = $("#grid").getDataIDs();
      for (var i = 0; i < rows.length; i++) {
        var status = $("#grid").getCell(rows[i], "estado");
        if (status == "INICIADO") {
          $("#grid").setCell(rowId, 'estado', "<span class='badge badge-primary badge-normal  ' style='background-color:#d39e00;'>" + status + "</span>");
        } else if (status == "APROBADO") {
          $("#grid").setCell(rowId, 'estado', "<span class='badge badge-success badge-normal  ' style='background-color:#28a745;'>" + status + "</span>");
        } else if (status == "RECHAZADO") {
          $("#grid").setCell(rowId, 'estado', "<span class='badge badge-success badge-normal  ' style='background-color:#bd2130;'>" + status + "</span>");
        } else if (status == "OBSERVADO") {
          $("#grid").setCell(rowId, 'estado', "<span class='badge badge-warning badge-normal  ' style='background-color:#0069d9;'>" + status + "</span>");
        } else if (status == "EN REVISION") {
          $("#grid").setCell(rowId, 'estado', "<span class='badge badge-warning badge-normal  ' style='background-color:#6c757d;'>" + status + "</span>");
        } else if (status == "SUBSANADO") {
          $("#grid").setCell(rowId, 'estado', "<span class='badge badge-info badge-normal  ' style='background-color:#117a8b;'>" + status + "</span>");
        } else if (status == "DE BAJA") {
          $("#grid").setCell(rowId, 'estado', "<span class='badge badge-info badge-normal  ' style='background-color:#777;'>" + status + "</span>");
        }
      }


    },
    rowNum: 15,
    pager: '#opc_pag',
    sortname: 'id',
    sortorder: "ASC",
    viewrecords: true,
    caption: "Resultado de Búsqueda",
    autowidth: true,
    shrinkToFit: true,
    height: '350',

    gridComplete: function () {
      var rows = $("#grid").getDataIDs();
      for (var i = 0; i < rows.length; i++) {
        var idEjemplar = $("#grid").getCell(rows[i], "idEjemplar");
        var status = $("#grid").getCell(rows[i], "capado");
        if (status == "SI" || idEjemplar.indexOf("CN-") != -1) {
          $("#grid").jqGrid('setRowData', rows[i], false, {
            weightfont: 'bold',
            background: '#CEF6CE'
          });
        }
      }
    }

  });
}




function clearCtrlsPopup() {
  //esetPopUp();
  grlLimpiarObligatorio(controls.modalDialog);
  $(controls.prefijo).val("");
  $(controls.nombre).val("");
  $(controls.fecNace).val("");
  $(controls.yegua).html("");
  $(controls.potro).html("");
  $(controls.pelaje).val("");
  $(controls.lugarNace).val("");
  $(controls.microchip).val("");
  $(controls.adn).val("");
  $(controls.anotacion).val("");
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
  $(controls.metodoRep).html("");
  $(controls.codigoMonta).html("");
  $(controls.idMonta).html("");
  $(controls.hidIdMonta).val("");
  $(controls.idNac).html("");
  $(controls.hidIdNac).val("");
  $(controls.codigoNacimiento).html("");
  $(controls.metodo).val("");
  $(controls.codigoIns).val("");
  $(controls.sexo).attr("enable", false);
  $("#hidCodigoNacimiento").val("");
  $("#array").val("");
  $("#lblResenia").text("");




  /* $(controls.prefijo).prop("disabled",false);
   $(controls.nombre).prop("disabled",false);
   $(controls.fecNace).prop("disabled",false);
   $("#ddlTipoPel").prop("disabled",false);
   $(controls.lugarNace).prop("disabled",false);
   $(controls.microchip).prop("disabled",false);
   $(controls.descripcion).prop("disabled",false);
   $(controls.motivo).prop("disabled",false);
   $(controls.cboCria).prop("disabled",false);
   $(controls.sexo).prop("disabled",false);
   $("#ddlOrigen").prop("disabled",false);
   $("#ddlProvinvia").prop("disabled",false);
   $("#btnBuscarResenia").show();
   $("#ddlCriador").prop("disabled",false);
   $("#btnSaveNE").show()*/

}





function nuevo() {
  clearCtrlsPopup()
  limpiarSesionTMPEntes();
  $(controls.areaResenas).val("");
  listarPelaje("ddlTipoPel", "seleccione");
  listarDeparmento("ddlProvinvia", "seleccione");
  listarMetodoReprop("ddlMetodo", "SELECCIONE");
  $(controls.sexo).val(0);
  $(controls.sexo).removeAttr("disabled");
  //$("#ddlGenero").val(0);
  $("#ddlOrigen").val("N");
  $("#idHorse").val("");
  $("#idHorsePdf").val("");
  $("#hidFlagEdit").val("");
  grlEjecutarAccion(controllersREST.ejemplar, {
    opc: 'getLastIDNac'
  }, function (retorno) {
    var ejemplar = retorno.data;
    var id = parseInt(ejemplar.id) + 1;
    var idPropietario = $("#hidIdProp").val();
    var codigoGenerado = "00" + id + idPropietario;
    $("input[id=hidCodigoGenerado]").val(codigoGenerado);
    // console.log(codigoGenerado);
  });

  $(controls.modalDialog).data("action", "insert");
  $(controls.modalDialog).modal('show');

}

function modificar(obj) {

  limpiarSesionTMPEntes();

  if (obj) {
    var key = $(obj).data("id");
  } else {
    var key = $("#grid").jqGrid('getGridParam', "selrow");
    var estado = $("#grid").jqGrid('getCell', key, 'estadoSol');
  }

  if (key) {

    if (estado == "APR" || estado == "REC") {
      $(controls.prefijo).prop("disabled", true);
      $(controls.nombre).prop("disabled", true);
      $(controls.fecNace).prop("disabled", true);
      $('#' + controls.cboPelaje).attr("disabled", "disabled");
      $(controls.lugarNace).prop("disabled", true);
      $(controls.microchip).prop("disabled", true);
      $(controls.anotacion).prop("disabled", true);
      $(controls.sexo).prop("disabled", true);
      $('#' + controls.cboDepartamento).attr("disabled", "disabled");
      $(controls.origen).attr("disabled", "disabled");
      $("#" + controls.cboCria).attr("disabled", "disabled");
      $("#btnBuscarResenia").hide();
      $("#btnSaveNE").hide();
      $("#submit-btn").hide();
      $("#submit-btn-pdf").hide();
      editar(key);
    } else {
      $(controls.prefijo).prop("disabled", false);
      $(controls.nombre).prop("disabled", false);
      $(controls.fecNace).prop("disabled", false);
      $('#' + controls.cboPelaje).prop("disabled", false);
      $(controls.lugarNace).prop("disabled", false);
      $(controls.microchip).prop("disabled", false);
      $(controls.anotacion).prop("disabled", false);
      $(controls.sexo).prop("disabled", false);
      $('#' + controls.cboDepartamento).prop("disabled", false);
      $(controls.origen).attr("enabled", "enabled");
      $("#" + controls.cboCria).prop("disabled", false);
      $("#btnBuscarResenia").show();
      $("#btnSaveNE").show();
      $("#submit-btn").show();
      $("#submit-btn-pdf").show();
      editar(key);
    }


  } else {
    alertify.warning("Seleccionar Nacimiento");
  }


}


function limpiarSesionTMPEntes() {
  $.ajax({
    data: {
      opc: 'session'
    },
    url: 'ajax/ajaxEntidad.php',
    type: 'post',
    success: function (response) {
      $(".gridHtmlBGProp tbody").html("");
      $(".gridHtmlBGCri tbody").html("");
    }
  });


  grlEjecutarAccion('ajax/ajaxEjemplar.php', {
    opc: 'clsSesionResena'
  }, function (response) {
    $("#ddlReseniaRight option").remove();
  }, '1');
}

/* nuevo*/
function editar(codigo) {
  editResenias('');
  EliminarDocumentosModal(0);
  EliminarDocumentosModal(1);
  listarMotivoBaja('txtMotivoBaja', 'SELECCIONE', 0);
  if (codigo != undefined) {
    grlEjecutarAccion(controllers.ejemplar, {
      opc: 'get',
      codigo: codigo
    }, function (retorno) {
      if (retorno.result == K_ResultadoAjax.exito) {
        var ejemplar = retorno.data;
        //console.log(ejemplar);
        var ejemplar = retorno.data;
        let estado = '';
        if (ejemplar.estadoSol == "INI") {
          estado = "<span class='badge badge1'>" + ejemplar.estadoSolTexto + "</span></td>";
        } else if (ejemplar.estadoSol == "REV") {
          estado = "<span class='badge badge2'>" + ejemplar.estadoSolTexto + "</span></td>";
        } else if (ejemplar.estadoSol == "OBS") {
          estado = "<span class='badge badge3'>" + ejemplar.estadoSolTexto + "</span></td>";
        } else if (ejemplar.estadoSol == "APR") {
          estado = "<span class='badge badge4'>" + ejemplar.estadoSolTexto + "</span></td>";
        } else if (ejemplar.estadoSol == "REC") {
          estado = "<span class='badge badge5'>" + ejemplar.estadoSolTexto + "</span></td>";
        } else if (ejemplar.estadoSol == "BAJ") {
          estado = "<span class='badge badge6'>" + ejemplar.estadoSolTexto + "</span></td>";
        }

        //$(controls.modalDialog+" .modal-title").html("Modificar Solicitud Nro: "+ ejemplar.codigo + estado +  "Código Inscripcón: " + ejemplar.codigoInscripcion);
        $(controls.modalDialog + " .modal-title").html("Modificar Nacimiento: " + ejemplar.codigoNacimiento + ' ' + estado);
        $(controls.modalDialog).data("action", "edit");
        $(controls.modalDialog).modal("show");
        if (ejemplar != null) {
          //console.log(ejemplar);

          $(controls.codigo).val(ejemplar.codigo);
          $(controls.nacimiento).val(ejemplar.codigoNacimiento);

          $(controls.prefijo).val(ejemplar.prefijo);
          $("#array").val(JSON.stringify(ejemplar.listResenas));
          listarPelaje(controls.cboPelaje, "seleccione", ejemplar.idPelaje);
          listarDeparmento(controls.cboDepartamento, "seleccione", ejemplar.idProvincia);
          $(controls.nombre).val(ejemplar.nombre);
          $(controls.anotacion).val(ejemplar.descripcion);

          $(controls.fecNace).val(ejemplar.fecNace);
          $(controls.lugarNace).val(ejemplar.LugarNace);
          $(controls.microchip).val(ejemplar.microchip);
          $(controls.adn).val(ejemplar.adn);
          $(controls.descripcion).val(ejemplar.descripcion);
          $(controls.hidFecMonta).val(ejemplar.fecMonta);
          configModify(ejemplar.codigoNacimiento, estado, ejemplar.codigo)
          //listarImg(ejemplar.codigo);
          //listarPdf(ejemplar.codigo);
          $("input[id=hidFlagEdit]").val("1");
          $("input[id=idHorse]").val(ejemplar.codigo);
          $("input[id=idHorsePdf]").val(ejemplar.codigo);

          $(controls.fecReg).val(ejemplar.fecReg);
          $("#dtFechaSol").val(ejemplar.fecCrea);
          $(controls.sexo).val(ejemplar.genero);
          if (ejemplar.propietarios != null) {
            $(".gridHtmlBGProp tbody").html("");
            $(".gridHtmlBGProp tbody").append(retorno.html);
            initCtrolesGrillaTmpRE(1);
          }
          if (ejemplar.criadores != null) {
            $(".gridHtmlBGCri tbody").html("");
            $(".gridHtmlBGCri tbody").append(retorno.html2);
            initCtrolesGrillaTmpRE(2);
          }
          $(controls.sexo).attr("disabled", "disabled");
          $("#lblYegua").html(ejemplar.nombreMadre);
          $("#lblPotro").html(ejemplar.nombrePadre);
          $("#hidIdMadre").val(ejemplar.idMadre);
          $("#hidIdPadre").val(ejemplar.idPadre);
          if (ejemplar.idMetodo == 1) {
            $(controls.metodoRep).html("MONTA NATURAL");
            $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 2) {
            $(controls.metodoRep).html("SEMEN FRESCO");
            $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 3) {
            $(controls.metodoRep).html("SEMEN REFRIGERADO");
            $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 4) {
            $(controls.metodoRep).html("SEMEN CONGELADO");
            $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 5) {
            $(controls.metodoRep).html("Transferencia de embriones");
            $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 6) {
            $(controls.metodoRep).html("Semen fresco con trasferencia de embriones");
            $(controls.metodo).val(ejemplar.idMetodo);
          }
          //console.log(ejemplar.listResenas);
          editResenias(ejemplar.listResenas);
          $("#txtReseniaBasica").val(ejemplar.reseniaBasica);

          $(controls.areaResenas).val(ejemplar.resenasDescripcion);
          if (ejemplar.esBasica == 0) {
            $("#lblResenia").text(ejemplar.resenasDescripcion);
          } else {
            $("#lblResenia").text("");
          }

          $(controls.hidIdMonta).val(ejemplar.idMonta);
          $(controls.hidIdNac).val(ejemplar.idNac);
          $(controls.idMonta).html(ejemplar.codigoMonta);
          $(controls.idNac).html(ejemplar.codigoNacimiento);
          //$(controls.areaResenas).val(ejemplar.resenasDescripcion);
         // $("#lblResenia").text(ejemplar.resenasDescripcion);
          if (ejemplar.origen == "" || ejemplar.origen == null) {
            $(controls.origen).val(0);
          } else {
            $(controls.origen).val(ejemplar.origen);
          }
          if (ejemplar.estadoSolTexto == 'DE BAJA') {

            $("#txtMotivoBaja").val(ejemplar.motivoFallece);
            $("#txtFechaBaja").val(ejemplar.fecFallece);
            $("#txtDetalleBaja").val(ejemplar.detalleFallece);
            $("#divBaja").show();
          } else {
            $("#divBaja").hide();
          }

          $("#hidIdProp").val(ejemplar.idProp);

          $("#lblIdReceptora").html(ejemplar.idReceptora);
          $("#lblFecEmbrion").html(ejemplar.fecEmbrion);
          listarCriador(controls.cboCria, "SELECCIONE", ejemplar.idCriador);
          //$("#lblCodigoNacimiento").html(ejemplar.codigoNacimiento);
          listarIdMonta(controls.cboIdMonta, "SELECCIONE", ejemplar.idMonta, ejemplar.usuCrea);
          $("#" + controls.cboIdMonta).prop("disabled", true);
          //metodo reproductivo
          listarMetodoReprop(controls.cboMetodo, "SELECCIONE", ejemplar.idMetodo);

        } else {
          alertify.error(retorno.message);
        }
      } else if (retorno.result == K_ResultadoAjax.error) {
        alertify.error(retorno.message);
      }
    });
  }
}


var update = function () {
  //var codigo=controls.codigo;
  //console.log($(controls.hidFecMonta).val());
  //console.log($(controls.fecNace).val());
  var date1 = new Date($(controls.hidFecMonta).val());
  var date2 = new Date($(controls.fecNace).val());
  var diffTime = Math.abs(date2 - date1);
  var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

  //console.log(diffDays) ;
  var lstItemPropietario = getIdEntidad();

  var data = {
    opc: '-',
    codigo: $(controls.codigo).val(),
    prefijo: $(controls.prefijo).val(),
    nombre: $(controls.nombre).val(),
    fecNace: $(controls.fecNace).val(),
    padre: $(controls.padre).val(),
    madre: $(controls.madre).val(),
    idPelaje: $('#' + controls.cboPelaje).val(),
    lugarNace: $(controls.lugarNace).val(),
    microchip: $(controls.microchip).val(),
    adn: $(controls.adn).val(),
    descripcion: $(controls.anotacion).val(),
    entidad: JSON.stringify(lstItemPropietario),
    genero: $(controls.sexo).val(),
    fecCapado: $(controls.fecCapado).val(),
    fecFallece: $(controls.fecFalleceNeo).val(),
    motivoFallece: $(controls.motivoFalleceNeo).val(),
    idProvincia: $('#' + controls.cboDepartamento).val(),
    origen: $(controls.origen).val(),
    resenias: $(controls.areaResenas).val(),
    fecReg: $(controls.fecReg).val(),
    nroLibro: $(controls.nroLibro).val(),
    nroFolio: $(controls.nroFolio).val(),
    fecServ: $(controls.fecServ).val(),
    idMetodo: $(controls.metodo).val(),
    idMonta: $(controls.hidIdMonta).val(),
    idPoe: $("#hidIdPoe").val(),
    idProp: $("#hidIdProp").val(),
    idCriador: $("#" + controls.cboCria).val(),
    codigoIns: $(controls.inscripcion).val(),
    arrayResenias: $("#array").val(),
    codigoGenerado: $("input[id=hidCodigoGenerado]").val(),
    arrayIdImg: JSON.stringify(collectionID),
    arrayIdPdf: JSON.stringify(collectionIDPdf),
    reseniaBasica: $("#txtReseniaBasica").val()
  };
  if ($(controls.modalDialog).data("action") != "insert") {
    data.opc = 'upd';
  } else {
    data.opc = 'ins';
  }
  /*if(data.idNac===""){
          alertify.error("Debe seleccionar un código de nacimiento");
         }else {*/
  if (isNaN(diffDays) && $(controls.origen).val() == 'I') diffDays = setting.limitDayBorn;

  if (diffDays >= setting.limitInitDayBorn && diffDays <= setting.limitDayBorn) {
    if (grlValidarObligatorio(controls.modalDialog)) {
      if ($("#ddlCriador").val() != 0) {
        $("#ddlCriador").css({
          'border': '1px solid #ccc'
        });
        if ($("#hiddenImgIns").val() == undefined) {
          alertify.error("Debe adjuntar mínimo una imagen del ejemplar");
        } else {
          if (data.opc != "-") {
            grlEjecutarAccion(controllers.ejemplar, data, function (retorno) {
              //console.log(retorno);
              if (retorno.result === K_ResultadoAjax.exito) {
                grlEjecutarAccion(controllers.ejemplar, {
                  opc: 'getLastIDNac'
                }, function (retorno) {
                  var ejemplar = retorno.data;
                  if (retorno.result === K_ResultadoAjax.exito && data.opc == 'insIns') {
                    alertify.alert("Se registró un nacimiento con el código : " + ejemplar.codigoInscripcion, function () {
                      alertify.success(retorno.message);
                    });
                    //alertify.success(retorno.message);
                    $("#mvNuevoNacimiento").modal("hide");
                  } else {
                    alertify.alert("Notificación","Se actualizó un nacimiento con el código : " + $("#hidCodigoNacimiento").val(), function () {
                      alertify.success(retorno.message);
                    });
                    //alertify.success(retorno.message);
                    $("#mvNuevoNacimiento").modal("hide");
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
      } else {
        alertify.error("Debe seleccionar un criador");
        $("#ddlCriador").css({
          'border': '1px solid red'
        });
      }
    }
  } else {
    alertify.alert("La fecha de nacimiento seleccionada no se encuentra dentro del tiempo de gestación de ejemplares", function () {

    });
  }
  /*   }*/
};



function getIdEntidad() {
  var collection = Array();
  $('.gridHtmlBGProp tbody tr:has(input)').each(function (index, value) {
    var inputName = "";
    var servicio = {};
    $('.cssItem ', this).each(function () {

      values = $(this).val();
      servicio.idProp = values;
      collection.push(servicio);

    });
  });
  return (collection);

}

var initCtrolesGrillaTmpRE = function (origen) {
  //  console.log(origen);
  if (origen == 1) {
    //$('.gridHtmlBGProp tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });    
    $('.btnQuit_' + origen).each(function (i, obj) {
      $(obj).on("click", function () {
        var indice = $(this).data("key");
        var source = $(this).data("source");
        var index = $(this).data("index");
        quitarTmpProp(indice, source, index);
      }).button();
    });
  } else {
    //$('.gridHtmlBGCri tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
    $('.btnQuit_' + origen).each(function (i, obj) {
      $(obj).on("click", function () {
        var indice = $(this).data("key");
        var source = $(this).data("source");
        quitarTmpCri(indice, source);
      }).button({
        icons: {
          primary: "ui-icon-closethick"
        },
        text: false
      });
    });
  }
}

function contarPropietarios() {
  var fila = 0;
  $(".gridHtmlBGProp tbody tr ").each(function (index, value) {
    fila = fila + 1;
  });
  return fila;

}

function printAs(idEjemplar, type) {
  /*type=0..como original
  type=1..como copia original
  type=2..como copia */
  grlCenterWindow(1000, 600, 50, 'vista/impresion/certificado.php?idHorse=' + idEjemplar + '&type=' + type, 'demo_win');
}

function printCertificado() {
  alertify.defaults.transition = "slide";
  alertify.defaults.theme.ok = "btn btn-danger";
  alertify.defaults.theme.cancel = "btn btn-danger";
  alertify.defaults.theme.input = "form-control";


  grlObtenerIdSelJQGrid("#grid", function (response) {
    if (response.result == 1) {
      grlEjecutarAccion(controllers.impresion, {
        opc: 'nveces',
        id: response.key
      }, function (retorno) {
        if (retorno.result != -1) {
          /*primera vez impresion*/
          if (retorno.result > 0) {
            alertify.alert('ANECPCP::ADVERTENCIA DE IMPRESION',
              'El certificado inicial del ejemplar: <b>' + response.key + '</b> ya fue impreso.' +
              'Desea imprimir una copia o un certificado como original. ' +
              '<br><br>Esta operación quedará registrado en el sistema como parte del seguimiento a la impresión' +
              ' de los certificados.<br><br>' +
              '<center><button class="btn btn-primary" onclick=printAs("' + response.key + '",1);>IMPRIMIR ORIGINAL</button>' +
              '&nbsp;&nbsp;&nbsp;&nbsp;' +
              '<button class="btn btn-info" onclick=printAs("' + response.key + '",2);>IMPRIMIR COPIA</button></center>',
              function () {}
            );
          } else {
            alertify.defaults.theme.ok = "btn btn-primary";
            alertify.defaults.theme.cancel = "btn btn-danger";
            alertify.confirm('ANECPCP::ADVETENCIA DE IMPRESION',
              'Ud va realizar la impresión de certificado del ejemplar: <b>' + response.key + '</b> por primera vez. ¿Desea continuar con la impresión? <br><br>Esta operación quedará registrado en el sistema como parte del seguimiento a la impresión de los certificados.',
              function () {
                printAs(response.key, 0);
              },
              function () {}
            ).set('labels', {
              ok: 'IMPRIMIR ORIGINAL',
              cancel: 'CANCELAR'
            });
          }
        } else {
          alertify.error(retorno.message);
        }
      });

    }
  });






}

function printTransferencia() {
  grlObtenerIdSelJQGrid("#grid", function (response) {
    if (response.result == 1) {
      grlCenterWindow(1000, 600, 50, 'vista/impresion/transferenciaprint.php?idHorse=' + response.key, 'demo_win');
    }
  });
}

function uploadImagen(id) {

  grlObtenerIdSelJQGrid("#grid", function (response) {
    if (response.result == 1) {
      //console.log(response.key);
      grlCenterWindow(1000, 600, 50, 'vista/upload/index.php?idHorse=' + response.key, 'demo_win');
    }
  });
}


//$( "#btnBuscarResenia" ).on( "click", function() {   console.log("aquiiiiiiii");  openGrlResena();    });
//function resena(){
//  openGrlResena();
//}

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
      $("#ddlReseniaRightCA").append("<option value='" + controlLeft.val() + "' title='" + controlLeft.text() + "'>" + controlLeft.text() + "</option>");
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


  $("#btnSaveResena").on("click", function () {
    //var concatValor = '';
    var collection = Array();
    var reseniaBasica = $("#txtReseniaBasica").val();
    $("#ddlReseniaRightCA option").each(function () {
      if ($(this).val() != "") {
        resena = {
          id: $(this).val(),
          descripcion: $(this).text(),
          tipo: "CA"
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


    datos = JSON.stringify(collection);
    $.ajax({
      data: {
        opc: 'resSession',
        data: datos,
        reseniaBasica: reseniaBasica
      },
      //url:   K_PATH_ROOT+'ajax/ajaxEjemplar.php',
      url: controllers.ejemplar,
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


function openGrlPropietario() {
  //console.log("... prop ");
  $("#mvBuscadorEntidadGrl").data("source", "1");
  $("#mvBuscadorEntidadGrl").modal('show');
  //$("#hidOrigenBuscador").val("1");
  $("#txtBGNombreEntidad").val("");
  initDataTableGrlEntidadProp();
  //  console.log("... prop salio");
}

function openGrlCriador() {
  $("#mvBuscadorEntidadGrl").data("source", "2");
  $("#mvBuscadorEntidadGrl").modal('show');
  // $("#hidOrigenBuscador").val("2");
  $("#txtBGNombreEntidad").val("");
  initDataTableGrlEntidadCria();
}

function openGrlPropietarioFilter() {
  //console.log("... openGrlPropietarioFilter ");
  $("#mvBuscadorEntidadGrl").data("source", "3");
  $("#mvBuscadorEntidadGrl").modal('show');
  //  $("#hidOrigenBuscador").val("3");
  $("#txtBGNombreEntidad").val("");
  initDataTableGrlEntidadProp();
  //   console.log("... prop openGrlPropietarioFilter");
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

function addImg(obj) {

  if (obj) {
    var key = $(obj).data("id");
  } else {
    var key = $("#grid").jqGrid('getGridParam', "selrow");
    var codigoNacimiento = $("#grid").jqGrid('getCell', key, 'codigoNacimiento');
    var estado = $("#grid").jqGrid('getCell', key, 'estado');
  }

  if (key) {
    $(controls.modalDialogImg).modal("show");
    $("#idHorse").val(key);
    //$("#lblDatoHorse").html($(obj).data("nombre")+' - '+$(obj).data("prefijo"));
    $("#lblIdSol").html("Código Solicitud: " + codigoNacimiento + " " + estado);
    listarImg(key);

  } else {
    alertify.warning("Seleccionar nacimiento");
  }

}

function addCert(obj) {
  if (obj) {
    var key = $(obj).data("id");
  } else {
    var key = $("#grid").jqGrid('getGridParam', "selrow");
    var codigoNacimiento = $("#grid").jqGrid('getCell', key, 'codigoNacimiento');
    var estado = $("#grid").jqGrid('getCell', key, 'estado');
    //console.log(estado);
  }
  if (key) {
    $(controls.modalDialogPdf).modal("show");

    $("#idHorsePdf").val(key);
    //$("#lblDatoHorsePdf").html($(obj).data("nombre")+' - '+$(obj).data("prefijo"));
    $("#lblIdSolPdf").html("Nacimiento código: " + codigoNacimiento + " " + estado);
    listarPdf(key);

  } else {
    alertify.warning("Seleccionar nacimiento");
  }
}


function verLog(obj) {
  if (obj) {
    var key = $(obj).data("id");
  } else {
    var key = $("#grid").jqGrid('getGridParam', "selrow");
    var codigoNacimiento = $("#grid").jqGrid('getCell', key, 'codigoNacimiento');
  }
  if (key) {
    //console.log(key);
    listarEstados(key);
    $("#lblId").html(key);
    $(controls.modalDialogLog + " .modal-title").html("SEGUIMIENTO DE SOLICITUD  DE NACIMIENTO: " + codigoNacimiento);
    //$(controls.modalDialog).data("action","edit");
    $(controls.modalDialogLog).modal("show");
  } else {
    alertify.warning("Seleccionar nacimiento");
  }
}


var listarEstados = function (id) {
  $.ajax({
    data: {
      opc: 'lstEst',
      codigo: id
    },
    url: controllers.ejemplar,
    type: 'POST',
    success: function (response) {
      var retorno = JSON.parse(response);
      if (retorno.result == "1") {
        var data = retorno.data;
        //console.log(data);
        //getEstado(id);
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
    url: controllers.ejemplar,
    type: 'POST',
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
  //rowTable=rowTable+"<td width='100%' height='10px'> <label>Estado: </label style='margin-left:10px;'><span style='margin-left:140px;'  style='background-color:#007bff;' class='badge "+setCssEstado(ejemplarINS.estado)+"' >"+ejemplarINS.estadoTexto + "</span></td>";
  if (ejemplarINS.estadoTexto == 'INICIADO') {
    rowTable = rowTable + "<td width='100%' height='10px'> <label>Estado: </label style='margin-left:10px;'><span style='margin-left:140px;' class='badge badge1'>" + ejemplarINS.estadoTexto + "</span></td>";
  } else if (ejemplarINS.estadoTexto == 'APROBADO') {
    rowTable = rowTable + "<td width='100%' height='10px'> <label>Estado: </label style='margin-left:10px;'><span style='margin-left:140px;' class='badge badge4'>" + ejemplarINS.estadoTexto + "</span></td>";
  } else if (ejemplarINS.estadoTexto == 'RECHAZADO') {
    rowTable = rowTable + "<td width='100%' height='10px'> <label>Estado: </label style='margin-left:10px;'><span style='margin-left:140px;' class='badge badge5'>" + ejemplarINS.estadoTexto + "</span></td>";
  } else if (ejemplarINS.estadoTexto == 'OBSERVADO') {
    rowTable = rowTable + "<td width='100%' height='10px'> <label>Estado: </label style='margin-left:10px;'><span style='margin-left:140px;' class='badge badge3'>" + ejemplarINS.estadoTexto + "</span></td>";
  } else if (ejemplarINS.estadoTexto == 'EN REVISION') {
    rowTable = rowTable + "<td width='100%' height='10px'> <label>Estado: </label style='margin-left:10px;'><span style='margin-left:140px;' class='badge badge2'>" + ejemplarINS.estadoTexto + "</span></td>";
  } else if (ejemplarINS.estadoTexto == 'DE BAJA') {
    rowTable = rowTable + "<td width='100%' height='10px'> <label>Estado: </label style='margin-left:10px;'><span style='margin-left:140px;' class='badge badge6'>" + ejemplarINS.estadoTexto + "</span></td>";
  }
  rowTable = rowTable + "</tr>"
  rowTable = rowTable + "<tr>"
  rowTable = rowTable + "<td width='100%'><label>Fecha Solicitud:</label><span style='margin-left:85px;'> " + ejemplarINS.fecSol + "</span></td>";
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
    case 'BAJ':
      cssEstado = " badge6 ";
      break;
    default:
      cssEstado = " badge-info ";
      break;
  };

  return cssEstado;
}


function updateEstado(obj) {
  limpiarSesionTMPEntes();

  if (obj) {
    var key = $(obj).data("id");
  } else {
    var key = $("#grid").jqGrid('getGridParam', "selrow");
  }

  if (key) {

    $(controls.modalDialogEstado).data("action", "edit");
    $(controls.modalDialogEstado).modal("show");
    getInfo(key);

  } else {
    alertify.warning("Seleccionar nacimiento");
  }

}


function getInfo(codigo) {
  if (codigo != undefined) {
    grlEjecutarAccion(controllers.ejemplar, {
      opc: 'get',
      codigo: codigo
    }, function (retorno) {
      if (retorno.result == K_ResultadoAjax.exito) {
        var ejemplar = retorno.data;
        if (ejemplar != null) {
          //console.log(ejemplar);
          $("#hidCodigoE").val(ejemplar.codigo);
          $("#hidIdPropE").val(ejemplar.idProp);
          $(controls.codigoNacimientoE).html(ejemplar.codigoNacimiento);
          $(controls.prefijo).val(ejemplar.prefijo);
          $("#array").val(JSON.stringify(ejemplar.listResenas));
          listarPelaje(controls.cboPelaje, "seleccione", ejemplar.idPelaje);
          listarDeparmento(controls.cboDepartamento, "seleccione", ejemplar.idProvincia);
          $(controls.nombreE).html(ejemplar.nombre);
          $(controls.anotacionE).html(ejemplar.descripcion);
          $(controls.fecNacE).html(ejemplar.fecNaceString);
          $(controls.lugarNaceE).html(ejemplar.LugarNace);
          $(controls.microchipE).html(ejemplar.microchip);
          $(controls.criadorE).html(ejemplar.criador);
          $(controls.provinciaE).html(ejemplar.provincia);
          $(controls.pelajeE).html(ejemplar.pelaje);
          $(controls.fecReg).val(ejemplar.fecReg);
          //$(controls.fecSolE).html(ejemplar.fecCreaString);
          $(controls.sexo).attr("disabled", "disabled");
          $(controls.madreE).html(ejemplar.nombreMadre);
          $(controls.padreE).html(ejemplar.nombrePadre);
          if (ejemplar.genero == "Y") {
            $(controls.generoE).html("YEGUA");
          } else if (ejemplar.genero == "P") {
            $(controls.generoE).html("POTRO");
          }
          $("#txtReseniaBasica").val(ejemplar.reseniaBasica);
          if (ejemplar.idMetodo == 1) {
            $(controls.metodoRepE).html("MONTA NATURAL");
            // $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 2) {
            $(controls.metodoRepE).html("SEMEN FRESCO");
            // $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 3) {
            $(controls.metodoRepE).html("SEMEN REFRIGERADO");
            //  $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 4) {
            $(controls.metodoRepE).html("SEMEN CONGELADO");
            //  $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 5) {
            $(controls.metodoRepE).html("Transferencia de embriones");
            // $(controls.metodo).val(ejemplar.idMetodo);
          } else if (ejemplar.idMetodo == 6) {
            $(controls.metodoRepE).html("Semen fresco con trasferencia de embriones");
            // $(controls.metodo).val(ejemplar.idMetodo);
          }
          $(controls.idMontaE).html(ejemplar.codigoMonta);
          $(controls.idNacE).html(ejemplar.codigoNacimiento);
          $(controls.reseniasE).html(ejemplar.resenasDescripcion);
          $(controls.hidFecMonta).val(ejemplar.fecMonta);
          editResenias(ejemplar.listResenas);
          if (ejemplar.origen == "" || ejemplar.origen == null) {
            $(controls.origen).html("");
          } else if (ejemplar.origen == "N") {
            $(controls.origenE).html("Nacional");
          } else if (ejemplar.origenE == "I") {
            $(controls.origenE).html("Importado");
          }
          $("#hidIdPropE").val(ejemplar.idProp);
          $("#txtCodCriador").val(ejemplar.idCriador);
          $("#ddlEstadoSol").val(ejemplar.estadoSol);

          $("#txtComentarioE").val(ejemplar.comentario);

          if (ejemplar.estadoSol == "APR") {
            //console.log("1");
            $("#btnSaveEI").prop("disabled", true);
            $("#ddlEstadoSol").prop("disabled", true);
            $("#txtComentarioE").prop("disabled", true);
          } else {
            // console.log("1");
            $("#btnSaveEI").prop("disabled", false);
            $("#ddlEstadoSol").prop("disabled", false);
            $("#txtComentarioE").prop("disabled", false);
          }

          $(controls.areaResenas).val(ejemplar.resenasDescripcion);
          if (ejemplar.esBasica == 0) {
            $("#lblResenia").text(ejemplar.resenasDescripcion);
          } else {
            $("#lblResenia").text("");
          }

          listarImgNac(ejemplar.codigo, 0);
          listarDocNac(ejemplar.codigo, 1);

        } else {
          alertify.error(retorno.message);
        }
      } else if (retorno.result == K_ResultadoAjax.error) {
        alertify.error(retorno.message);
      }
    });
  }

}


function cantidadAllNacimientos() {

  $.ajax({
    data: {
      opc: "allNac"
    },
    url: 'ajax/ajaxNacimiento.php',
    type: 'post',
    beforeSend: function () {},
    success: function (response) {
      //console.log(response);
      var data = JSON.parse(response);
      //console.log(data.result);
      $("#cantNacimientos").text(data.result);
    }
  });


};



function printNacimiento(obj) {

  var key = $("#grid").jqGrid('getGridParam', "selrow");
  var row = $("#grid").jqGrid('getRowData', key);
  //console.log(row.codigoNacimiento);
  if (key) {
    var prop = $("#hidIdUsu").val();
    var codigoNacimiento = row.codigoNacimiento; //$(controls.nacimiento).val();
   // grlCenterWindow(1000, 600, 50, , 'demo_win');
   window.open('vista/impresion/printNacimiento.php?codigo=' + key + '&codigoNacimiento=' + codigoNacimiento + '&prop=' + prop);
  }
}

function configModify(vcodigoIns, vestado, vcodigo) {
  limpiarBusqueda();
  listarImg(vcodigo, '', false, 'edit');
  listarPdf(vcodigo, '', false, 'edit');
  $("#MyUploadFormPdf").show();
  $("#MyUploadForm").show();
  if (vestado == "<span class='badge badge4'>" + "APROBADO" + "</span></td>") {
    listarImg(vcodigo, '', true, 'edit');
    listarPdf(vcodigo, '', true, 'edit');
    $("#MyUploadFormPdf").hide();
    $("#MyUploadForm").hide();
  }
  //$("#divBaja").css("display", "none");
  //$("#divResenas").css("display", "block");
  // $("#divAnotaciones").css("display", "block");
  // $("#btnSaveBaja").css("display", "none");
  //$(controls.modalDialog + " .modal-title").html("Modificar Inscripción: " + vcodigoIns + ' ' + vestado);
}

function listarImgNac(codigo, esPdf) {
  grlEjecutarAccion(controllers.ejemplar, {
    opc: 'getImgNac',
    codigo: codigo,
    esPdf: esPdf
  }, function (retorno) {
    if (retorno.result == 1) {
      $("#divImagenNac").html(retorno.html);
    }

  });
}

function listarDocNac(codigo, esPdf) {
  grlEjecutarAccion(controllers.ejemplar, {
    opc: 'getDocNac',
    codigo: codigo,
    esPdf: esPdf
  }, function (retorno) {
    if (retorno.result == 1) {
      $("#divDocuNac").html(retorno.html);
    }

  });
}