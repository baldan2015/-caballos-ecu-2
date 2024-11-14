/* controls: Objeto Json que contiene los  IDs de los controles que se crean en el html */
var controls = {
    actions: "#hidActionPopup",
    modalDialog: "#dialogNuevo",
    buttonNew: "#btnNuevo",
    buttonDel: "#btnEliminar",
    buttonEdit: "#btnEditar",
    buttonView: "#btnVer",
    buttonSave: "#btnSaveConcurso",
    buttonCancel: "#btnCancelar",
    txtCodigo: "#txtCodigo",
    txtNombre: "#txtNombre",
    txtJuez: "#txtJuez",
    txtFecha: "#txtFecha",
    txtConcursoFiltro: "#txtConcurso"
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
    modalNew: "Nuevo registro del Concurso",
    modalEdit: "Actualización del Concurso",
    modalRead: "Información del Concurso",
    modalNoDeterminated: "Titulo no determinado",
    modalNone: ""
}
var controllers = {
    concurso: 'ajax/ajaxConcurso.php'
}
var messages = {
    inserted: 'Concurso registrado correctamente',
    updated: 'Concurso actualizado correctamente',
    noDeterminated: 'Error de aplicación: Operación no determinada.'
}


$(function () {

    $(controls.buttonSave).on(events.click, function () {
        update($(controls.modalDialog));
    });
    $(controls.buttonNew).on(events.click, function () {
        nuevo();
    });
    $(controls.buttonEdit).on(events.click, function () {
        modificar();
    });
    $(controls.buttonDel).on(events.click, function () {
        eliminar();
    });
    $(controls.buttonView).on(events.click, function () {
        search();
    });

    //filtro
    $("#txtIdBus").on(events.keypress, function (e) {
        if (e.which == 13) {
            search();
        }
    });
    //--
    $(controls.buttonCancel).on(events.click, function () {
        clearParamSearch();
        search();
    });

    $(controls.txtConcursoFiltro).on(events.keypress, function (e) {
        if (e.which == 13) {
            search();
        }
    });
    
    initDataTable();

});



function editar() {
    var key = $("#grid").jqGrid('getGridParam', "selrow");
   /* console.log(key);
    */
    if (key) {
        grlEjecutarAccion(controllers.concurso, {
            opc: 'datos',
            key: key
        }, function (retorno) {
            if (retorno.result === K_ResultadoAjax.exito) {
                var concurso = retorno.data;
                console.log(concurso);
                if (concurso != null) {
                    $(controls.txtCodigo).val(concurso[0].idConcurso);
                    $(controls.txtNombre).val(concurso[0].nombre);
                    $(controls.txtJuez).val(concurso[0].juez);
                    $(controls.txtFecha).val(concurso[0].fecha);
                }
            } else if (retorno.result === K_ResultadoAjax.error) {
                alertify.error(retorno.message);
            }
        });
        resetPopUp();
        $(controls.modalDialog).modal("show");
    } else {
        alertify.warning(respuesta.message);
    }

}

function eliminar() {
    var key = $("#grid").jqGrid('getGridParam', "selrow");
    if (key) {
        alertify.confirm('Advertencia', 'Está seguro de elminar los registros seleccionados?',
            function () {

                grlEjecutarAccion(controllers.concurso, {
                    opc: 'del',
                    key: key
                }, function (retorno) {
                    if (retorno.result === K_ResultadoAjax.exito) {
                        search();
                        alertify.success(retorno.message);
                    } else if (retorno.result === K_ResultadoAjax.error) {
                        alertify.error(retorno.message);
                    }
                });

            },
            function () {
                //alertify.error('Cancel')
            }
        );
    } else {
        //alertify.error(respuesta.message);
    }
}

function initDataTable() {
    jQuery("#grid").jqGrid({
        url: controllers.concurso,
        postData: paramSearch(),
        datatype: "json",
        height: "auto",
        mtype: 'GET',
        //idConcurso,nombre,fecha,juez,activo
        colNames: ['ID', 'Nombre del concurso', 'Fecha', 'Apellido y Nombre del Juez', 'Activo'],
        colModel: [{
                name: 'idConcurso',
                index: 'idConcurso',
                width: 50,
                key: true
            },
            {
                name: 'nombre',
                index: 'nombre',
                width: 90
            },
            {
                name: 'fecha',
                index: 'fecha',
                width: 50
            },
            {
                name: 'juez',
                index: 'juez',
                width: 90
            },
            {
                name: 'activo',
                index: 'activo',
                hidden: true

            }

        ],
        rowNum: 15,
        pager: '#opc_pag',
        sortname: 'idConcurso',
        sortorder: "ASC",
        viewrecords: true,
        caption: "Resultado de Búsqueda",
        autowidth: true,
        shrinkToFit: true,
        height: '350'

    });
}

function paramSearch() {
    return {
        opc: 'search',
        nombre: $(controls.txtConcursoFiltro).val()

    };
};

function clearParamSearch() {

    $(controls.txtConcursoFiltro).val("");



};
var update = function (objModal) {
    var data = {
        opc: '-',
        codigo: $(controls.txtCodigo).val(),
        nombre: $(controls.txtNombre).val(),
        juez: $(controls.txtJuez).val(),
        fecha: $(controls.txtFecha).val()
    };
    if ($(controls.actions).val() == actions.insert) data.opc = 'ins';
    if ($(controls.actions).val() == actions.update) data.opc = 'upd';
    if (grlValidarObligatorio(controls.modalDialog)) {
        if (data.opc != "-") {
            grlEjecutarAccion(controllers.concurso, data, function (retorno) {
                if (retorno.result === K_ResultadoAjax.exito) {
                    alertify.success(retorno.message);
                    clearCtrlsPopup();
                    $(objModal).modal("hide");
                    search();

                } else if (retorno.result === K_ResultadoAjax.error) {
                    alertify.error(retorno.message);
                } else if (retorno.result === K_ResultadoAjax.warning) {
                    alertify.warning(retorno.message);
                }
                search();
            });
        } else {
            alertify.error(messages.noDeterminated);
        }
    }
}

function resetPopUp() {
    if ($(controls.actions).val() == actions.update) {
        $(controls.modalDialog + " .modal-title ").html(titles.modalEdit);
        $(controls.txtNombre).removeAttr("disabled");
        $(controls.btnSaveConcurso).show();
    } else if ($(controls.actions).val() == actions.read) {
        $(controls.modalDialog + " .modal-title ").html(titles.modalRead);
        $(controls.txtNombre).attr("disabled", "disabled");
        $(controls.btnSaveConcurso).hide();
    } else if ($(controls.actions).val() == actions.insert) {
        $(controls.modalDialog + " .modal-title ").html(titles.modalNew);
        $(controls.txtNombre).removeAttr("disabled");
        $(controls.btnSaveConcurso).show();
    } else {
        $(controls.modalDialog + " .modal-title ").html(titles.modalNoDeterminated);
    }
}

function search() {
    validarSesion(function (isLogout) {
        if (isLogout != "1") {

            $("#grid").jqGrid("clearGridData", true);
            $("#grid").jqGrid('setGridParam', {
                url: controllers.concurso,
                datatype: 'json',
                mtype: 'GET',
                postData: paramSearch()
            }).trigger('reloadGrid');

           /* console.log(paramSearch());
            console.log(controllers.concurso);*/
        }
    });
}

function clearCtrlsPopup() {
    resetPopUp();
    grlLimpiarObligatorio(controls.modalDialog);
    $(controls.txtCodigo).val("");
    $(controls.txtNombre).val("");
    $(controls.txtJuez).val("");
    $(controls.txtFecha).val("");
}

function ver() {
    $(controls.actions).val(actions.read);
    clearCtrlsPopup();
    editar();
}

function nuevo() {
    $(controls.actions).val(actions.insert);
    clearCtrlsPopup();
    $(controls.modalDialog).modal("show");
}

function modificar() {
    $(controls.actions).val(actions.update);
    clearCtrlsPopup();
    editar();
}

function cancelar() {
    var param = GetQueryStringParams("obj");
    document.location.href = "shared.php?obj=" + param;
}