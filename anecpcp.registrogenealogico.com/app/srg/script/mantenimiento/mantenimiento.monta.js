/* controls: Objeto Json que contiene los  IDs de los controles que se crean en el html */
//formulario:"#divContainer",
var K_TOKEN_NAME = "Authorization";
var mensajeBorrar = 'El procesamiento de este registro es irreversible y afectará a la base de datos del registro genealógico ¿Desea Continuar con el procesamiento?';

var controls = {
    actions: "#hidActionPopup",
    modalDialog: "#mvNuevoNacimiento",
    modalDialogSuperCamp: "#mvSuperCamp",
    modalDialogPrint: "#mvPrintCertificado",
    buttonPrintCert: "#btnPrintCert",
    modalDialogLog: "#mvLogDetaAprobacion",
    modalDialogEstado: "#mvEstadoNacimiento",
    modalDialogExtranjero: "#mvEjemplarExtranjero",
    modalDialogVerDocumentos: "#mvVerArchivo",
    buttonLog: "#btnLog",
    buttonApro: "#btnApro",
    buttonSearch: "#btnBuscar",
    buttonPrint: "#btnPrint",
    buttonCancel: "#btnCancelarMon",
    buttonDoc: "#btnDoc",
    cboProp: "ddlProps",

    /*CONTROLES MODAL EXTRANJERO*/
    txtCodigoE: "#txtCodigoExt",
    txtNombreE: "#txtNombreExt",
    txtPrefijoE: "#txtPrefijoExt",
    dtpFecNacExt: "#dtpFechaNacExt",
    cboPelaje: "ddlIdPelaje",
    cboPais: "ddlIdPais",

    lblSocioP: "#lblSocioP",
    lblSocioY: "#lblSocioY",
    lblNombreSocioPotro: "#lblNombreSocioPotro",
    lblEstadoMontaPotro: "#lblEstadoMontaPotro",
    lblFechayHoraPotro: "#lblFechayHoraPotro",
    lblNombreSocioYegua: "#lblNombreSocioYegua",
    lblEstadoMontaYegua: "#lblEstadoMontaYegua",
    lblFechayHoraYegua: "#lblFechayHoraYegua",

    lbltexto: "#lbltexto"
};

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
    modalNew: "Nuevo registro de monta",
    modalEdit: "Actualización de monta",
    modalRead: "Información de monta",
    modalNoDeterminated: "Titulo no determinado",
    modalNone: "",
    modalImg: "Imagen del Ejemplar",
    modalEstado: "Actualizacion de Solicitud de monta"
}
var controllers = {
    monta: 'ajax/ajaxMonta.php',
    montaJQGRID: 'ajax/ajaxMontaJQgrid.php',
    impresion: 'ajax/ajaxImpresion.php',
    imagen: 'ajax/ajaxImagen.php'
}
var messages = {
    inserted: 'Monta registrada correctamente',
    updated: 'Monta actualizada correctamente',
    noDeterminated: 'Error de aplicación: Operación no determinada.'
}
var id = '';
var datosDocYegua = [];
var datosDocPotro = [];

$(function () {
    $(controls.buttonPrint).on(events.click, function () {
        /*printCertificado();printer(id)*/
        printMonta();
    });
    $(controls.buttonSearch).on(events.click, function () {
        search();
    });
    $(controls.buttonApro).on(events.click, function () {
        verAprobaciones();
    });
    $(controls.buttonDoc).on(events.click, function () {
        verDocumentos();
    });
    $(controls.buttonCancel).on(events.click, function () {
        clearParamSearch();
        search();
    });
    /* FIN POPUP DE ACTUALIZAR ESTADO DE SOLICITUD */
    listarPropietario(controls.cboProp, "TODOS", 0);
    initDataTable();
    listarPelajeExt(controls.cboPelaje, "SELECCIONE", "");
    listarPaises(controls.cboPais, "SELECCIONE", "");
});


function search() {
    validarSesion(function (isLogout) {
        if (isLogout != "1") {
            $("#grid").jqGrid("clearGridData", true);
            $("#grid").jqGrid('setGridParam', {
                url: controllers.montaJQGRID,
                datatype: 'json',
                mtype: 'GET',
                postData: paramSearch()
            }).trigger('reloadGrid');
        }
    });
}

function paramSearch() {
    //console.log(flag);
    //console.log($("#cboEstadoMonta").val());
    let vestado;
    if ($("#cboEstadoMonta").val() == 0) {
        vestado = '';
    } else {
        vestado = $("#cboEstadoMonta").val();
    }

    return {
        anio: $("#txtAnioBus").val(),
        mes: $("#txtMesBus").val(),
        prop: $("#ddlProps").val(),
        estado: vestado,
        activo: $("#cboSituacion").val()
    };
};

function clearParamSearch() {
    $('#cboEstadoMonta').val(0);
    $("#txtAnioBus").val("");
    $("#txtMesBus").val("");
    $('#ddlProps').val(0);
    $('#ddlProps').selectpicker('refresh');
    $('#cboSituacion').val(1);
};

function initDataTable() {

    jQuery("#grid").jqGrid({
        url: controllers.montaJQGRID,
        postData: paramSearch(),
        datatype: "json",
        height: "auto",
        mtype: 'GET',
        colNames: ['id', 'Código Monta', 'Yegua', 'Codigo Potro', 'Codigo Yegua', 'Id Extranjero Potro',
            'Id Extranjero Yegua', 'Potro', 'Propietario', 'Metodo Rep.', 'Cod. Receptor', 'Fec. Embrion',
            'Fec. Monta', 'Fec. Parir', 'Fec. Reg',
            'Estado', 'flagExtP', 'flagExtY', 'btnflag', 'flagPeruY', 'flagPeruP', 'flagTercero', 'flagDocP', 'flagDocY', 'opc'
        ],
        colModel: [{
                name: 'id',
                index: 'id',
                width: 150,
                key: true,
                hidden: true
            },
            {
                name: 'codigoMonta',
                index: 'codigoMonta',
                width: 150,
                align: "center"
            },
            {
                name: 'yegua',
                index: 'yegua',
                width: 300,
                align: "center",
                fixed: true,
                formatter: function (cellvalue, options, rowObject) {
                    //console.log(rowObject);
                    var rowTable = "" + rowObject[2] + "";
                    if (rowObject[15] == "PEN" && rowObject[17] == 1 && rowObject[19] == 1 && rowObject[18] == 1) {
                        rowTable = rowTable + "  <span title='Editar' class='btn btn-primary btn-xs glyphicon glyphicon-pencil' data-toggle='tooltip'  data-id=" + rowObject[0] + " data-codigoext=" + rowObject[6] + " onclick='updateDatosExt(this);'></span>";

                    }
                    if (rowObject[22] == 1 && rowObject[24] == 1) {
                        rowTable = rowTable + "<span title='Ver documento de autorización' class='btn btn-default btn-xs glyphicon glyphicon-file' style='cursor:pointer;color:#d9534f;' data-toggle='tooltip' onclick='DetalleDocumentos(" + rowObject[0] + ",0)' >PDF</span>";

                    }

                    return rowTable;


                }
            },
            {
                name: 'codPotro',
                index: 'codPotro',
                width: 300,
                align: "center",
                hidden: true
            },
            {
                name: 'codYegua',
                index: 'codYegua',
                width: 300,
                align: "center",
                hidden: true
            },
            {
                name: 'idPotroExtranjero',
                index: 'idPotroExtranjero',
                width: 300,
                align: "center",
                hidden: true
            },
            {
                name: 'idYeguaExtranjero',
                index: 'idYeguaExtranjero',
                width: 300,
                align: "center",
                hidden: true
            },
            {
                name: 'potro',
                index: 'potro',
                width: 300,
                align: "center",
                fixed: true,
                formatter: function (cellvalue, options, rowObject) {
                    //console.log(rowObject);
                    var rowTable = "" + rowObject[7] + "";
                    if (rowObject[15] == "PEN" && rowObject[16] == 1 && rowObject[19] == 1 && rowObject[18] == 1) {
                        rowTable = rowTable + "  <span title='Editar' class='btn btn-primary btn-xs glyphicon glyphicon-pencil' data-toggle='tooltip'  data-id=" + rowObject[0] + " data-codigoext=" + rowObject[5] + " onclick='updateDatosExt(this);'></span>";

                    }
                    if (rowObject[22] == 1 && rowObject[23] == 1) {
                        rowTable = rowTable + "  <span title='Ver documento de autorización' class='btn btn-default btn-xs glyphicon glyphicon-file' style='cursor:pointer;color:#d9534f;' data-toggle='tooltip' onclick='DetalleDocumentos(" + rowObject[0] + ",1)' >PDF</span>";

                    }

                    return rowTable;


                }
            },
            {
                name: 'idUser',
                index: 'idUser',
                width: 150,
                align: "center"
            },
            {
                name: 'metodo',
                index: 'metodo',
                width: 150,
                align: "center"
            },
            {
                name: 'idReceptor',
                index: 'idReceptor',
                width: 150,
                align: "center"
            },
            {
                name: 'fecEmbrion',
                index: 'fecEmbrion',
                width: 120,
                align: "center"
            },
            {
                name: 'fecMonta',
                index: 'fecMonta',
                width: 120,
                align: "center"
            },
            {
                name: 'fecParir',
                index: 'fecParir',
                width: 120,
                align: "center"
            },
            {
                name: 'fecReg',
                index: 'fecReg',
                width: 120,
                align: "center"
            },
            {
                name: 'estado',
                index: 'estado',
                width: 170,
                align: "center"
            },
            {
                name: 'flagExtP',
                index: 'flagExtP',
                hidden: true
            },
            {
                name: 'flagExtY',
                index: 'flagExtY',
                hidden: true
            },
            {
                name: 'btnflag',
                index: 'btnflag',
                hidden: true
            },
            //{name:'activo',index:'activo'},
            {
                name: 'flagPeruY',
                index: 'btnflagPeruP',
                hidden: true
            },
            {
                name: 'flagPeruP',
                index: 'btnflagPeruY',
                hidden: true
            },
            {
                name: 'flagTercero',
                index: 'btnflagTercero',
                hidden: true
            },
            {
                name: 'flagDocP',
                index: 'btnflagDocP',
                hidden: true
            },
            {
                name: 'flagDocY',
                index: 'btnflagDocY',
                hidden: true
            },
            {
                name: 'opc',
                index: 'opc',
                width: 130,
                align: "center",
                fixed: true,
                formatter: function (cellvalue, options, rowObject) {
                    //console.log(rowObject);
                    if (rowObject[15] == "PEN" && rowObject[16] == 1 && rowObject[19] == 1 && rowObject[18] == 1) {
                        //console.log("entrooooooooooo");
                        var rowTable = "<span title='Aprobar Servicio de monta' class='btn btn-success btn-xs glyphicon glyphicon-ok' data-toggle='tooltip'  data-id=" + rowObject[0] + " onclick='aprobarMonta(this);'></span>";
                        rowTable = rowTable + "<span title='Rechazar Servicio de monta' class='btn btn-xs btn-danger glyphicon glyphicon-remove' data-toggle='tooltip' data-id=" + rowObject[0] + " style='margin-left:10px;' onclick='rechazarMonta(this);'></span> ";
                        rowTable = rowTable + "<span title='ELIMINAR REGISTRO DE SERVICIO DE MONTA' class='btn btn-xs btn-default glyphicon glyphicon-trash' data-toggle='tooltip' data-padre='"+rowObject[7]+"' data-madre='"+rowObject[2]+"' data-codigo='"+rowObject[1]+"' data-id=" + rowObject[0] + " style='margin-left:10px;' onclick='eliminarMonta(this);'></span> ";
                        return rowTable;
                    } else if (rowObject[15] == "PEN" && rowObject[17] == 1 && rowObject[19] == 1 && rowObject[18] == 1) {
                        var rowTable = "<span title='Aprobar Servicio de monta' class='btn btn-success btn-xs glyphicon glyphicon-ok' data-toggle='tooltip'  data-id=" + rowObject[0] + " onclick='aprobarMonta(this);'></span>";
                        rowTable = rowTable + "<span title='Rechazar Servicio de monta' class='btn btn-xs btn-danger glyphicon glyphicon-remove' data-toggle='tooltip' data-id=" + rowObject[0] + " style='margin-left:10px;' onclick='rechazarMonta(this);'></span> ";
                        rowTable = rowTable + "<span title='ELIMINAR REGISTRO DE SERVICIO DE MONTA' class='btn btn-xs btn-default glyphicon glyphicon-trash' data-toggle='tooltip' data-padre='"+rowObject[7]+"' data-madre='"+rowObject[2]+"' data-codigo='"+rowObject[1]+"' data-id=" + rowObject[0] + " style='margin-left:10px;' onclick='eliminarMonta(this);'></span> ";

                        return rowTable;
                    } else if (rowObject[15] == "PEN" && rowObject[19] == 1 && rowObject[20] == 1 && rowObject[18] == 1) {
                        var rowTable = "<span title='Aprobar Servicio de monta' class='btn btn-success btn-xs glyphicon glyphicon-ok' data-toggle='tooltip'  data-id=" + rowObject[0] + " onclick='aprobarMonta(this);'></span>";
                        rowTable = rowTable + "<span title='Rechazar Servicio de monta' class='btn btn-xs btn-danger glyphicon glyphicon-remove' data-toggle='tooltip' data-id=" + rowObject[0] + " style='margin-left:10px;' onclick='rechazarMonta(this);'></span> ";
                        rowTable = rowTable + "<span title='ELIMINAR REGISTRO DE SERVICIO DE MONTA' class='btn btn-xs btn-default glyphicon glyphicon-trash' data-toggle='tooltip' data-padre='"+rowObject[7]+"' data-madre='"+rowObject[2]+"' data-codigo='"+rowObject[1]+"' data-id=" + rowObject[0] + " style='margin-left:10px;' onclick='eliminarMonta(this);'></span> ";

                        return rowTable;
                    } else if (rowObject[15] == "PEN" && rowObject[19] == 1 && rowObject[21] == 1 && rowObject[18] == 1) {
                        var rowTable = "<span title='Aprobar Servicio de monta' class='btn btn-success btn-xs glyphicon glyphicon-ok' data-toggle='tooltip'  data-id=" + rowObject[0] + " onclick='aprobarMonta(this);'></span>";
                        rowTable = rowTable + "<span title='Rechazar Servicio de monta' class='btn btn-xs btn-danger glyphicon glyphicon-remove' data-toggle='tooltip' data-id=" + rowObject[0] + " style='margin-left:10px;' onclick='rechazarMonta(this);'></span> ";
                        rowTable = rowTable + "<span title='ELIMINAR REGISTRO DE SERVICIO DE MONTA' class='btn btn-xs btn-default glyphicon glyphicon-trash' data-toggle='tooltip' data-padre='"+rowObject[7]+"' data-madre='"+rowObject[2]+"' data-codigo='"+rowObject[1]+"' data-id=" + rowObject[0] + " style='margin-left:10px;' onclick='eliminarMonta(this);'></span> ";

                        return rowTable;
                    } else if (rowObject[15] == "PEN" && rowObject[22] == 1 && rowObject[18] == 1) {
                        var rowTable = "<span title='Aprobar Servicio de monta' class='btn btn-success btn-xs glyphicon glyphicon-ok' data-toggle='tooltip'  data-id=" + rowObject[0] + " onclick='aprobarMonta(this);'></span>";
                        rowTable = rowTable + "<span title='Rechazar Servicio de monta' class='btn btn-xs btn-danger glyphicon glyphicon-remove' data-toggle='tooltip' data-id=" + rowObject[0] + " style='margin-left:10px;' onclick='rechazarMonta(this);'></span> ";
                        rowTable = rowTable + "<span title='ELIMINAR REGISTRO DE SERVICIO DE MONTA' class='btn btn-xs btn-default glyphicon glyphicon-trash' data-toggle='tooltip' data-padre='"+rowObject[7]+"' data-madre='"+rowObject[2]+"' data-codigo='"+rowObject[1]+"' data-id=" + rowObject[0] + " style='margin-left:10px;' onclick='eliminarMonta(this);'></span> ";

                        return rowTable;
                    } else {
                        var rowTable = "";
                        if (rowObject[18] == 1) {
                            rowTable = rowTable + "<span title='ELIMINAR REGISTRO DE SERVICIO DE MONTA' class='btn btn-xs btn-default glyphicon glyphicon-trash' data-toggle='tooltip' data-padre='"+rowObject[7]+"' data-madre='"+rowObject[2]+"' data-codigo='"+rowObject[1]+"' data-id=" + rowObject[0] + " style='margin-left:10px;' onclick='eliminarMonta(this);'></span> ";

                        }

                        return rowTable;
                    }
                }
            },

        ],
        afterInsertRow: function (rowId, data) {
            var rows = $("#grid").getDataIDs();
            for (var i = 0; i < rows.length; i++) {
                var status = $("#grid").getCell(rows[i], "estado");

                if (status == "PEN") {
                    $("#grid").setCell(rowId, 'estado', "<span class='badge badge-primary badge-normal' data-status='PEN' style='background-color:#d39e00;'>POR CONFIRMAR</span>");
                } else if (status == "CON") {
                    $("#grid").setCell(rowId, 'estado', "<span class='badge badge-success badge-normal' data-status='CON' style='background-color:#28a745;'>CONFIRMADO</span>");
                } else if (status == "REC") {
                    $("#grid").setCell(rowId, 'estado', "<span class='badge badge-success badge-normal'  data-status='REC' style='background-color:#bd2130;'>RECHAZADO</span>");
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
        height: '350'



    });
}



function printMonta() {
    var selRowId = $("#grid").jqGrid('getGridParam', "selrow");
    var celValue = $("#grid").jqGrid('getCell', selRowId, "codigoMonta");
    if (selRowId) {
        var prop = $("#hidIdUsu").val();
        var codigoNacimiento = $(controls.nacimiento).val();
        //grlCenterWindow(1000, 600, 50, , 'demo_win');
        window.open('vista/impresion/printServicioYegua.php?codigo=' + selRowId + '&codigoNacimiento=' + celValue + '&prop=' + prop);
    } else {
        alertify.warning("Seleccionar monta");
    }

}


function aprobarMonta(obj) {
    var key = $(obj).data("id");

    alertify.confirm(mensajeBorrar, function (e) {
        if (e) {
            grlEjecutarAccion(controllers.monta, {
                    opc: 'aproMon',
                    id: key,
                    prop: $("#hidIdUsu").val()
                },
                function (retorno) {
                    // var id = retorno.result;
                    if (retorno.result === K_ResultadoAjax.exito) {
                        search();
                        alertify.success(retorno.message);
                    } else if (retorno.result === 0) {
                        alertify.warning(retorno.message);
                    }


                });

        }

    });
}

function rechazarMonta(obj) {
    var key = $(obj).data("id");
    alertify.confirm(mensajeBorrar, function (e) {
        if (e) {
            grlEjecutarAccion(controllers.monta, {
                    opc: 'recMon',
                    id: key,
                    prop: $("#hidIdUsu").val()
                },
                function (retorno) {
                    // var id = retorno.result;
                    if (retorno.result === K_ResultadoAjax.exito) {
                        search();
                        alertify.success(retorno.message);
                    } else if (retorno.result === 0) {
                        alertify.warning(retorno.message);
                    }


                });

        }

    });
}

function verAprobaciones() {
    var selRowId = $("#grid").jqGrid('getGridParam', "selrow");
    var celValue = $("#grid").jqGrid('getCell', selRowId, "estado");
    var estado = $(celValue).data("status");
    //var estado='';
    if (selRowId) {
        $(controls.modalDialogLog).modal('show');
        detalleAprobaciones(selRowId, estado);
    } else {
        alertify.warning("Seleccionar monta");
    }

}


function updateDatosExt(obj) {

    var key = $(obj).data("codigoext");
    //console.log(key);
    if (key) {
        $(controls.modalDialogExtranjero).modal('show');
        getInfoExtranjero(key);
    } else {
        alertify.warning("Seleccionar monta");
    }

}

function getInfoExtranjero(key) {
   /*  console.log(key);
    */
    grlEjecutarAccion(controllers.monta, {
            opc: 'getExt',
            id: key
        },
        function (retorno) {
            var ejemplar = retorno.data;
           // console.log(ejemplar);
            if (retorno.result === K_ResultadoAjax.exito) {
                $("#hidCtrolId").val(ejemplar.id);
                $(controls.txtCodigoE).val(ejemplar.codigo);
                $(controls.txtNombreE).val(ejemplar.nombre);
                $(controls.txtPrefijoE).val(ejemplar.prefijo);
                $(controls.dtpFecNacExt).val(ejemplar.fecNace);
                listarPelajeExt(controls.cboPelaje, "", ejemplar.idPelaje);
                listarPaises(controls.cboPais, "", ejemplar.idPais);

            }


        });
}


function updateDatosEjemplar() {

    var data = {
        opc: 'updExt',
        hidCodigo: $("#hidCtrolId").val(),
        codigo: $(controls.txtCodigoE).val(),
        nombre: $(controls.txtNombreE).val(),
        prefijo: $(controls.txtPrefijoE).val(),
        dtpFecNacExt: $(controls.dtpFecNacExt).val(),
        idPelaje: $('#' + controls.cboPelaje).val(),
        idpais: $('#' + controls.cboPais).val()

    };

    grlEjecutarAccion(controllers.monta, data, function (retorno) {
        // var id = retorno.result;
        if (retorno.result === K_ResultadoAjax.exito) {
            $(controls.modalDialogExtranjero).modal("hide");
            search();
            alertify.success(retorno.message);
        } else if (retorno.result === 0) {
            alertify.warning(retorno.message);
        }


    });
}


var detalleAprobaciones = function (id, estado) {
    $.ajax({
        data: {
            opc: 'detApro',
            id: id
        },
        url: controllers.monta,
        type: 'POST',
        success: function (response) {
            //console.log(response);
            var retorno = JSON.parse(response);
            if (retorno.result == "1") {
                var data = retorno.data;
                //console.log(data);
                $(controls.lblSocioP).show();
                $(controls.lblSocioY).show();
                $(controls.lblNombreSocioPotro).show();
                $(controls.lblEstadoMontaPotro).show();
                $(controls.lblFechayHoraPotro).show();
                $(controls.lblNombreSocioYegua).show();
                $(controls.lblEstadoMontaYegua).show();
                $(controls.lblFechayHoraYegua).show();
                if (data != null) {
                    $(controls.lblNombreSocioPotro).html(data.sociop);
                    $(controls.lblEstadoMontaPotro).html(data.mensajeP);
                    $(controls.lblEstadoMontaPotro).removeClass("badge badge4");
                    $(controls.lblEstadoMontaPotro).removeClass("badge badge5");
                    $(controls.lblEstadoMontaPotro).removeClass("badge badge1");

                    $(controls.lblEstadoMontaYegua).removeClass("badge badge4");
                    $(controls.lblEstadoMontaYegua).removeClass("badge badge5");
                    $(controls.lblEstadoMontaYegua).removeClass("badge badge1");
                    if (data.mensajeP == "CONFIRMADO") {
                        $(controls.lblEstadoMontaPotro).addClass("badge badge4");
                    } else if (data.mensajeP == "RECHAZADO") {
                        $(controls.lblEstadoMontaPotro).addClass("badge badge5");
                    } else {
                        $(controls.lblEstadoMontaPotro).addClass("badge badge1");
                    }

                    $(controls.lblFechayHoraPotro).html(data.fecAproPotro);

                    $(controls.lblNombreSocioYegua).html(data.socioy);
                    $(controls.lblEstadoMontaYegua).html(data.mensajeY);
                    if (data.mensajeY == "CONFIRMADO") {
                        $(controls.lblEstadoMontaYegua).addClass("badge badge4");
                    } else if (data.mensajeY == "RECHAZADO") {
                        $(controls.lblEstadoMontaYegua).addClass("badge badge5");
                    } else {
                        $(controls.lblEstadoMontaYegua).addClass("badge badge1");
                    }

                    $(controls.lblFechayHoraYegua).html(data.fecAproYegua);
                    $(controls.lbltexto).html("<span class='badge glyphicon glyphicon-briefcase' aria-hidden='true'></span> " +
                        data.origenAprRec);
                    if (data.origenAprRec != '') {
                        $("#lbltextoFecha").html(data.fecOrigen);
                    } else {
                        $("#lbltextoFecha").html('');
                    }

                }
            } else {
                alertify.error(retorno.message);
            }
        }
    });
};

function DetalleDocumentos(id, genero) {

    $.ajax({
        data: {
            opc: 'detDocumentos',
            id: id,
            genero: genero
        },
        url: controllers.imagen,
        type: 'POST',
        success: function (response) {
            var retorno = JSON.parse(response);

            datosDocYegua = [];
            datosDocPotro = [];

            if (retorno.length != 0) {
                if (retorno[0]) {
                    if (retorno[0].esPadre == 0) {
                        datosDocYegua = retorno[0];
                    } else if (retorno[0].esPadre == 1) {
                        datosDocPotro = retorno[0];
                    }

                }
                if (retorno[1]) {
                    if (retorno[1].esPadre == 0) {
                        datosDocYegua = retorno[1];
                    } else if (retorno[1].esPadre == 1) {
                        datosDocPotro = retorno[1];
                    }

                }
                if (genero == 1) {
                    mostrarImgGrande(datosDocPotro.ruta);
                    $("#mvVerArchivo").modal("show");
                } else {
                    mostrarImgGrande(datosDocYegua.ruta);
                    $("#mvVerArchivo").modal("show");
                }


            } else {
                ocultarControles();
            }
        }
    });
}

function mostrarImgGrande(img) {
    $("#verpdf").attr("src", img);
    $("#mvVerArchivo").modal("show");
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
        mostrarImgGrande(img);
    } else {
        $("#divDocYegua").hide();
    }
}

function datosDocPotroControls() {
    var img = datosDocPotro.ruta;
    if (tieneDocPotro() == true) {
        mostrarImgGrande(img);
    } else {
        $("#divDocPotro").hide();
    }
}

function ocultarControles() {
    $("#divDocPotro").hide();
    $("#divDocYegua").hide();
    $("#divNoDoc").show();
}


function eliminarMonta(obj) {
    var key = $(obj).data("id");
    var monta = $(obj).data("codigo");
    var padre = $(obj).data("padre");
    var madre = $(obj).data("madre");
    var mensajeBorrarMonta = '¿ESTÁ SEGURO DE ELIMINAR EL SERVICIO DE MONTA CON CÓDIGO:  <b>'+monta+'</b> , PADRE: <b>'+padre+'</b> Y MADRE: <b>'+madre+'</b>?'+'<br><br>'+

    'ESTA ACCIÓN ES IRREVERSIBLE. Y NO PODRÁ SER RECUPERADA, VERIFIQUE BIEN LA INFORMACIÓN ANTES DE CONFIRMAR LA ELIMINACIÓN.'+'<br><br>'+
    
    '¿ELIMINAR DE TODOS MODOS?';
    alertify.confirm(mensajeBorrarMonta, function (e) {
        if (e) {
            grlEjecutarAccion(controllers.monta, {
                    opc: 'dltMonta',
                    id: key,
                    prop: $("#hidIdUsu").val()
                },
                function (retorno) {
                    if (retorno.result === K_ResultadoAjax.exito) {
                        search();
                        alertify.success(retorno.message);
                    } else if (retorno.result === 0) {
                        alertify.warning(retorno.message);
                    }
                });
        }
    });
}