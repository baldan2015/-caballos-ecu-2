/* controls: Objeto Json que contiene los  IDs de los controles que se crean en el html */
var controls = {
    actions: "#hidActionPopup",
    modalDialog: "#dialogNuevo",
    modalEjemplar: "#modalEjemplares",
    buttonNew: "#btnNuevo",
    buttonDel: "#btnEliminar",
    buttonEdit: "#btnEditar",
    buttonView: "#btnVer",
    buttonSave: "#btnSaveResultado",
    buttonCancel: "#btnCancelar",
    txtCodigo: "#txtCodigo",
    txtEjemplar: "#txtEjemplar",
    txtCodigoEjemplar: "#txtcodEjemplar",
    txtProp: "#txtprop",
    txtIdProp: "#txtidProp",
    dllConcurso: "dllConcurso",
    txtJuez: "#txtJuez",
    txtFecha: "#txtFecha",
    txtCategoria: "#txtCategoria",
    txtGrupo: "#txtgrupo",
    txtPuesto: "#txtpuesto",
    txtConcursoFiltro: "#txtNombreConcurso",
    txtFechaFiltro: "#txtFechaConcurso",
    buttonSearchEjemplar: "#btnBuscarEjemplar",
    txtEjemplarFiltro: "#txtEjemplarFiltro",
    buttonBuscarEjemplarNombre: "#btnBuscarEjemplarNombre"
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
    modalNew: "Nuevo registro del Resultado",
    modalEdit: "Actualización del Resultado",
    modalRead: "Información del Resultado",
    modalNoDeterminated: "Titulo no determinado",
    modalNone: ""
}
var controllers = {
    resultados: 'ajax/ajaxResultadoConcurso.php',
    concurso: 'ajax/ajaxConcurso.php'
}
var messages = {
    inserted: 'Resultado registrado correctamente',
    updated: 'Resultado actualizado correctamente',
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

    $(controls.buttonSearchEjemplar).on(events.click, function () {
        $(controls.txtEjemplarFiltro).val('');
        searchEjemplar();
        searchEjemplarIni();
    });

    $(controls.buttonBuscarEjemplarNombre).on(events.click, function () {
        //$(controls.txtEjemplarFiltro).val('');
        searchEjemplarIni();
    });
    $("#" + controls.dllConcurso).on(events.change, function () {
        datosComboConcurso($("#" + controls.dllConcurso).val());
    });
    $(controls.txtEjemplarFiltro).on(events.keypress, function (e) {
        if (e.which == 13) {
            searchEjemplarIni();
        }
    });
    initDataTable();

});

function searchEjemplar() {
    $(controls.txtEjemplarFiltro).val('');
    $(controls.modalEjemplar).modal('show');
    initDataTableEjemplares();
}

function editar() {
    var key = $("#grid").jqGrid('getGridParam', "selrow");

    if (key) {
        grlEjecutarAccion(controllers.resultados, {
            opc: 'datos',
            key: key
        }, function (retorno) {
            if (retorno.result === K_ResultadoAjax.exito) {
                var concurso = retorno.data;
                console.log(concurso);
                if (retorno.length != 0) {
                    $(controls.txtCodigo).val(concurso[0].idResultado);
                    $(controls.txtJuez).val(concurso[0].juez);
                    $(controls.txtFecha).val(concurso[0].fecha);
                    //listarEjemplares("dllEjemplar", "SELECCIONE", concurso[0].idEjemplar); 
                    listarConcursos("dllConcurso", "SELECCIONE", concurso[0].idConcurso);
                    $(controls.txtCodigoEjemplar).val(concurso[0].idEjemplar);
                    $(controls.txtIdProp).val(concurso[0].idProp);
                    $(controls.txtProp).val(concurso[0].propietario);
                    $(controls.txtEjemplar).val(concurso[0].nombreEjemplar);
                    $(controls.txtCategoria).val(concurso[0].desCategoria);
                    $(controls.txtGrupo).val(concurso[0].desGrupo);
                    $(controls.txtPuesto).val(concurso[0].nroPuesto);
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

function eliminar(id) {

    alertify.confirm('Advertencia', 'Está seguro de elminar los registros seleccionados?',
        function () {

            grlEjecutarAccion(controllers.resultados, {
                opc: 'del',
                key: id
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

}

function paramSearchEjemplares() {
    return {
        opc: 'ejemplares',
        ejemplar: $(controls.txtEjemplarFiltro).val(),
    };
}

function initDataTableEjemplares() {
    jQuery("#gridEjemplares").jqGrid({
        url: controllers.resultados,
        postData: paramSearchEjemplares(),
        datatype: "json",
        height: "auto",
        mtype: 'GET',
        colNames: ['CODIGO', 'NOMBRE DE EJEMPLAR', 'IDPROP', 'PROPIETARIO', 'OPC'],
        colModel: [{
                name: 'codigo',
                index: 'codigo',
                width: 80,
                key: true
            },
            {
                name: 'ejemplar',
                index: 'ejemplar',
                width: 170,
            },
            {
                name: 'idProp',
                index: 'idProp',
                width: 50,
                hidden: true
            },
            {
                name: 'propietario',
                index: 'propietario',
                width: 260
            },
            {
                name: 'seleccion',
                index: 'codigo',
                width: 60,
                align: "center"
            }

        ],
        afterInsertRow: function (rowId, data) {
            var rows = $("#gridEjemplares").getDataIDs();
            for (var i = 0; i < rows.length; i++) {
                var status = $("#gridEjemplares").getCell(rows[i], "codigo");
                $("#gridEjemplares").setCell(rowId, 'seleccion', '<button title="Seleccionar ejemplar" class="btn btn-default btn-xs" onclick="seleccionar(\'' + status + '\')"\'' + '>' + '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' + '</button>');

            }


        },
        rowNum: 15,
        pager: '#opc_pag_ejemplares',
        sortname: 'nombre',
        sortorder: "ASC",
        viewrecords: true,
        caption: "Resultado de Búsqueda",
        autowidth: true,
        shrinkToFit: true,
        height: '350'

    });
}

function seleccionar(codigo) {
    $(controls.txtEjemplarFiltro).val('');
    var Prop = $("#gridEjemplares").jqGrid('getRowData', codigo).idProp;
    var nomProp = $("#gridEjemplares").jqGrid('getRowData', codigo).propietario;
    var nomEjemplar = $("#gridEjemplares").jqGrid('getRowData', codigo).ejemplar;
    $(controls.txtCodigoEjemplar).val(codigo);
    $(controls.txtIdProp).val(Prop);
    $(controls.txtProp).val(nomProp);
    $(controls.txtEjemplar).val(nomEjemplar);
    $(controls.modalEjemplar).modal("hide");
}

function initDataTable() {
    jQuery("#grid").jqGrid({
        url: controllers.resultados,
        postData: paramSearch(),
        datatype: "json",
        height: "auto",
        mtype: 'GET',
        //idConcurso,nombre,fecha,juez,activo
        colNames: ['ID', 'idConcurso', 'Nombre del concurso', 'Fecha', 'Apellido y Nombre del Juez' , 'Ejemplar', 'Categoria', 'Grupo', 'Puesto obtenido', 'Eliminar'],
        colModel: [{
                name: 'idResultado',
                index: 'idResultado',
                width: 20,
                key: true
            },
            {
                name: 'idConcurso',
                index: 'idConcurso',
                hidden: true
            },
            {
                name: 'concurso',
                index: 'concurso',
                width: 150
            },
            {
                name: 'fecha',
                index: 'fecha',
                width: 90,
                align: "center"
            },
            {
                name: 'juez',
                index: 'juez',
                width: 150

            },
            {
                name: 'idEjemplar',
                index: 'idEjemplar',
                with: 40,
                align: "center"
            },
            {
                name: 'desCategoria',
                index: 'desCategoria',
                with: 40
            },
            {
                name: 'desGrupo',
                index: 'desGrupo',
                with: 40
            },
            {
                name: 'nroPuesto',
                index: 'nroPuesto',
                with: 20
            },
             {
                name: 'eliminar',
                index: 'idResultado',
                align: "center",
                with: 20
            }

        ],
        afterInsertRow: function (rowId, data) {
            var rows = $("#grid").getDataIDs();
            for (var i = 0; i < rows.length; i++) {
                var status = $("#grid").getCell(rows[i], "idResultado");
                $("#grid").setCell(rowId, 'eliminar', "<button class='btn btn-default btn-xs' title='Eliminar Registro' onclick='eliminar(" + status + ")'>" + "<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>" + "</button>");

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

function paramSearch() {
    return {
        opc: 'search',
        nombre: $(controls.txtConcursoFiltro).val(),
        fecha: $(controls.txtFechaFiltro).val()
    };
};

function clearParamSearch() {

    $(controls.txtConcursoFiltro).val("");
    $(controls.txtFechaFiltro).val("");


};




var update = function (objModal) {


    var data = {
        opc: '-',
        codigo:$(controls.txtCodigo).val(),
        codEjemplar:  $(controls.txtCodigoEjemplar).val(),
        concurso: $("#"+controls.dllConcurso).val(),
        juez: $(controls.txtJuez).val(),
        categoria: $(controls.txtCategoria).val(),
        grupo: $(controls.txtGrupo).val(),
        puesto: $(controls.txtPuesto).val(),
        propietario: $(controls.txtProp).val(),
        idProp: $(controls.txtIdProp).val(),
    };
    if ($(controls.actions).val() == actions.insert) data.opc = 'ins';
    if ($(controls.actions).val() == actions.update) data.opc = 'upd';


    if (grlValidarObligatorio(controls.modalDialog)) {
        if (data.opc != "-") {
            grlEjecutarAccion(controllers.resultados, data, function (retorno) {
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
        $("#"+controls.dllConcurso).attr("disabled", "disabled"); 
        $(controls.buttonSearchEjemplar).hide();
        $(controls.btnSaveConcurso).show();
    } else if ($(controls.actions).val() == actions.read) {
        $(controls.modalDialog + " .modal-title ").html(titles.modalRead);
        $(controls.btnSaveConcurso).hide();
    } else if ($(controls.actions).val() == actions.insert) {
        $(controls.modalDialog + " .modal-title ").html(titles.modalNew);
        $("#"+controls.dllConcurso).removeAttr("disabled");
        $(controls.buttonSearchEjemplar).show();
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
                url: controllers.resultados,
                datatype: 'json',
                mtype: 'GET',
                postData: paramSearch()
            }).trigger('reloadGrid');

            /* console.log(paramSearch());
             console.log(controllers.concurso);*/
        }
    });
}

function searchEjemplarIni() {
    validarSesion(function (isLogout) {
        if (isLogout != "1") {

            $("#gridEjemplares").jqGrid("clearGridData", true);
            $("#gridEjemplares").jqGrid('setGridParam', {
                url: controllers.resultados,
                datatype: 'json',
                mtype: 'GET',
                postData: paramSearchEjemplares()
            }).trigger('reloadGrid');
        }
    });
}

function clearCtrlsPopup() {
    resetPopUp();
    grlLimpiarObligatorio(controls.modalDialog);
    $(controls.txtCodigoEjemplar).val('');
    $(controls.txtIdProp).val('');
    $(controls.txtProp).val('');
    $(controls.txtEjemplar).val('');
    listarConcursos("dllConcurso", "SELECCIONE", 0);
    $(controls.txtJuez).val('');
    $(controls.txtFecha).val('');
    $(controls.txtCodigo).val('');
    //listarEjemplares("dllEjemplar", "SELECCIONE", 0);
    $(controls.txtCategoria).val('');
    $(controls.txtGrupo).val('');
    $(controls.txtPuesto).val('');
    $(controls.txtEjemplarFiltro).val('');
    searchEjemplarIni();
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

function datosComboConcurso(id) {

    var data = {
        opc: 'datos',
        key: id
    };

    grlEjecutarAccion(controllers.concurso, data, function (retorno) {
        if (retorno.result === K_ResultadoAjax.exito) {
            var objetos = retorno.data;
            if(retorno.data.length >0){
                $(controls.txtJuez).val(objetos[0].juez);
                $(controls.txtFecha).val(objetos[0].fecha);
            }else{
                $(controls.txtJuez).val('');
                $(controls.txtFecha).val('');
            }
            console.log(retorno);
            

        } else {
            alertify.error("Error. Contactarse con el administrador.");
        }
    });
}