var K_PATH_ROOT_IMPORTADO = "../";

var controllersRESTImportado = {
    ejemplar: K_PATH_ROOT_IMPORTADO + 'services/ejemplarService.php'
}

var controlsImportado = {
    modalDialogE: "#divBuscarEjemplar",

    buttonAgregarExt: "#btnAgregarExt", //

    codigoExt: "#txtCodigoExt", //
    nombreExt: "#txtNombreExt", //
    prefijoExt: "#txtPrefijoExt",
    fechaNacExt: "#dtpFechaNacExt",
    genero: "#ddlGenero",

    checkBoxEX: "#rdbtnEE",
    checkBoxProp: "#rdbtnProp",
    checkBoxOtros: "#rdbtnOT",

    dtFecServ: "#dtFecServ",
    cboPelaje: "ddlIdPelaje",
    cboPais: "ddlIdPais"
};


$(function () {
    $("#txtBGNombre").on("keypress", function (e) {
        var target = (e.target ? e.target : e.srcElement);
        var key = (e ? e.keyCode || e.which : window.event.keyCode);
        if (key == 13) {
            _buscar();
        } else {
            return true;
        }

    });

    $("#btnBGBuscar").on("click", _buscar);

});

var _buscar = function () {
    var request = $("#txtBGNombre").val().toUpperCase();
    var hidParents = $("#hidTipoParents").val();

    if ($("#txtBGNombre").val() == "") {
        var hidflag = "mine";
    } else {
        var hidflag = "all";
    }
    if ($("#rdbtnProp").is(":checked")) {
        var hidflag = "mine";
    }
    if ($("#rdbtnOT").is(":checked")) {
        var hidflag = "others";
    }
    if ($("#rdbtnEE").is(":checked")) {
        var hidflag = "foreign";
        $("#divBody").show();
        $("#formEjemplarExt").hide();
    }
    //console.log("AQUI 1");
    $.ajax({
        data: {
            request: request,
            hidParents: hidParents,
            idUser: $("#hidIdProp").val(),
            idPoe: $("#hidIdPoe").val(),
            flag: hidflag
        },
        url: '../ajaxPOE/ajaxBusGralEjemplar_fase2.php',
        type: 'post',
        success: function (response) {
            var retorno = JSON.parse(response);
            //$('#gridBusquedaEjemplar').DataTable();
            //console.log(retorno);
           /* if(retorno.cantidad == 0 ){
                $("#filasBody").html("<td colspan="7"><center>No se encontraron registros</center></td>");
            }else{*
                $("#filasBody").html("");*/
                setDataTable2(retorno.data, retorno.cantidad);
           // }
          // console.log("AQUI 3");
        }
    });
   // console.log("AQUI 4");
};

function saveEjemplarExt() {

    var data = {
      opc: "extIns",
      codigo: $(controlsImportado.codigoExt).val(),
      nombre: $(controlsImportado.nombreExt).val(),
      prefijo: $(controlsImportado.prefijoExt).val(),
      fecNace: $(controlsImportado.fechaNacExt).val(),
      idPelaje: $("#" + controlsImportado.cboPelaje).val(),
      idPais: $("#" + controlsImportado.cboPais).val(),
      genero: $("#hidGenero").val(),
      origen: $("#codOrigen").val()
    }
    //console.log(data);
    //divBuscarEjemplar
    if (grlValidarObligatorio(controlsImportado.modalDialogE)) {
      if (data.codigo != undefined || data.codigo != null || data.codigo != "") {
        grlEjecutarAccion(controllersRESTImportado.ejemplar, data, function (retorno) {
  
          if (retorno.result === 1) {
            $("#formEjemplarExt").hide();
            $("#divBody").show();
            _buscar();
            clearPopUpEjemplarExt();
            $(controlsImportado.codigoExt).removeClass("form-control requerido");
            $(controlsImportado.nombreExt).removeClass("form-control requerido");
  
          }
        });
      }
  
    }
  }

var setDataTable2 = function (data,numrow) {
   // console.log("AQUI 2.1.1");
    var tabla = $('#gridBusquedaEjemplar').DataTable();
    tabla.clear();
    $('#gridBusquedaEjemplar').DataTable({
        data: data,
        language: {
            search: "Búsqueda:",
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No se encontraron registros",
            info: "Página  _PAGE_ de _PAGES_",
            infoEmpty: "No se encontraron registros"
        },
        processing: true,
        info: true,
        responsive: true,
        destroy: true,
        searching: false,
        paging: true,
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
        pageLength: 5,
        recordsFiltered: 5,
        columns: [{
                "data": "codigo"
            },
            {
                "data": "prefijo_caballo"
            },
            {
                "data": "nombre_caballo"
            },
            {
                "data": "nacimiento_caballo",
                "render": function (datum, type, row) {
                    if (datum != '' && datum != null) {
                        var dia = (datum).split("/")[0];
                        var mes = (datum).split("/")[1];
                        var anio = (datum).split("/")[2];
                        return "<span class='hidden'>" + anio + mes + dia + "</span>" + datum;
                    } else {
                        return "";
                    }

                }
            },
            {
                "data": "fallecio",
                "render": function (datum, type, row) {
                    if (row.fallecio == "1") {
                        return "<img src='../../../img/qcruz.png' border=0 width='16' height=14 alt='Fallecido' title='fallecido'> ";
                    } else {
                        return "<img src='../../../img/silueta.png' border=0 width='16' height=14 alt='ejemplar vivo' title='ejemplar vivo '> ";
                    }
                }
            },
            {
                "data": "propietario_caballo"
            },
            {
                "data": "criador_caballo"
            },
        ]
    });

   // console.log("AQUI 2.1.2");
    $('[data-toggle="tooltip"]').tooltip();
   // console.log("AQUI 2.1.3");
    $('#gridBusquedaEjemplar').on('dblclick', 'tr', function () {
       // console.log("AQUI 2.1.4");
        var table = $('#gridBusquedaEjemplar').DataTable();
        var obj = table.row(this).data();
        ejeSel(obj);
       // console.log("AQUI 2.1.5");
    });
   // console.log("AQUI 2.1.6");
};

function ejeSelForm1(obj) {

    var id = $(obj).data("codigo");
    var prefijo = $(obj).data("prefijo");
    var ejemplar = $(obj).data("ejemplar");
    var hidCtrolId = $(obj).data("crtid");
    var hidCtrolName = $(obj).data("name");

    insertBoton(id, prefijo, ejemplar);

    $("#" + hidCtrolId).val(id);
    $("#" + hidCtrolName).html(prefijo + "  " + ejemplar + " - " + id);
    $("#divBuscarEjemplar").modal("hide");
}

function ejeSel(obj) {
    var tipo = $("#hidTipoParents").val();
    var codigo = obj.codigo;

    if (tipo == 'P') {
        var prefijo = obj.prefijo_caballo;
        var ejemplar = obj.nombre_caballo;
        $("#hidIdPadre").val(codigo);
        $("#lblPotroBuscar").html(prefijo + "  " + ejemplar + " - " + codigo);
        $("#divBuscarEjemplar").modal("hide");
    } else if (tipo == 'Y') {
        var prefijo = obj.prefijo_caballo;
        var ejemplar = obj.nombre_caballo;
        $("#hidIdMadre").val(codigo);
        $("#lblYeguaBuscar").html(prefijo + "  " + ejemplar + " - " + codigo);
        $("#divBuscarEjemplar").modal("hide");
    }
}

function addEjemplarExt() {
    if ($(controlsImportado.checkBoxEX).is(":checked")) {
        $(controlsImportado.buttonAgregarExt).show();
        $(controlsImportado.codigoExt).addClass("form-control requerido");
        $(controlsImportado.nombreExt).addClass("form-control requerido");
        $("#divBody").show();
    }
    if ($(controlsImportado.checkBoxProp).is(":checked")) {
        $(controlsImportado.buttonAgregarExt).hide();
        $("#formEjemplarExt").hide();
        $("#divBody").show();
        $(controlsImportado.codigoExt).removeClass("form-control requerido");
        $(controlsImportado.nombreExt).removeClass("form-control requerido");
    }
    if ($(controlsImportado.checkBoxOtros).is(":checked")) {
        $(controlsImportado.buttonAgregarExt).hide();
        $("#formEjemplarExt").hide();
        $("#divBody").show();
        $(controlsImportado.codigoExt).removeClass("form-control requerido");
        $(controlsImportado.nombreExt).removeClass("form-control requerido");
    }
}

function addExtranjero() {
    clearPopUpEjemplarExt();
    listarPelajeExt("ddlIdPelaje", "SELECCIONE");
    listarPaises("ddlIdPais", "SELECCIONE");
    $("#divBody").hide();
    $(controlsImportado.codigoExt).addClass("form-control requerido");
    $(controlsImportado.nombreExt).addClass("form-control requerido");
    $("#formEjemplarExt").show();
    $("#txtCodigoExt").css({
        'border': '1px solid #ccc'
    });
    $("#txtNombreExt").css({
        'border': '1px solid #ccc'
    });
}

function clearPopUpEjemplarExt() {
    $(controlsImportado.codigoExt).val("");
    $(controlsImportado.nombreExt).val("");
    $(controlsImportado.prefijoExt).val("");
    $(controlsImportado.fechaNacExt).val("");
    $(controlsImportado.genero).val("");
}