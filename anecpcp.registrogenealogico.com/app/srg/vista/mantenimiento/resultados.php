<script src="script/mantenimiento/mantenimiento.resultado.js"></script>
<script src="libs/multiselect/multiselect.js"></script>
<style>
    .mv-customer-resultados {
        max-width: 100%;
        width: 90%;
    }
</style>
<style type="text/css">
    .bootstrap-select.btn-group .dropdown-toggle {
        max-width: 500px;
    }
</style>
<div style="float:left;background:#f6f6f6; width:100%; background:url('images/button/barra.png')100% 100% ;">
    <div style=" float:left; margin-top:10px;  ">
        <titulo>
            <span class="glyphicon glyphicon-list"></span>
            Mantenimiento de Resultados de Concursos
        </titulo>
    </div>
    <div style=" float:right;  " class="toolButton ">

        <button id="btnNuevo" title="nuevo.. (Shift + N)" class="btn btn-default btn-lg">
            <span class="glyphicon glyphicon-file"></span>
        </button>
        <button id="btnEditar" title="editar.. (Shift + U)" class="btn btn-default btn-lg">
            <span class="glyphicon glyphicon-pencil"></span>
        </button>
        <button id="btnVer" title="ver.. (Shift + V)" class="btn btn-default btn-lg">
            <span class="glyphicon glyphicon-search"></span>
        </button>
        <button id="btnCancelar" title="regresar pantalla. (Shift + R)" class="btn btn-default btn-lg">
            <span class="glyphicon glyphicon-refresh"></span>
        </button>

    </div>
</div>
<div class="container-fluid breadcrumb table-responsive" style="margin-top:45px;">
    <div class="row">
        <div class="col-md-4">
            <label> Nombre del Concurso: </label>
            <input type="text" id="txtNombreConcurso" class=" form-control" />
        </div>
        <div class="col-md-2">
            <label> Fecha: </label>
            <input type="date" id="txtFechaConcurso" class=" form-control" />
        </div>
    </div>


    <!-- APLICANDO EL GRID CON JQGRID -->
    <table id="grid"></table>
    <!-- APLICANDO CONTROLES PAGINACIÓN JQGRID -->
    <div id="opc_pag"></div>


</div>
<div class="modal fade" id="dialogNuevo" role="dialog">
    <div class="modal-dialog modal-xs ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div id="___dialogNuevo">
                    <input type="hidden" id="hidActionPopup" />
                    <div class="row">
                        <div class="col-md-2" >
                            <label> Codigo: </label>
                            <input type="text" id="txtCodigo" class="form-control" disabled />
                        </div>
                        <div class="col-md-5">
                            <label> Ejemplar: </label>
                            <div class="input-group">
                                <input id="txtEjemplar" class="requerido form-control" disabled />
                                <span class="input-group-btn">
                                    <button id="btnBuscarEjemplar" class="btn btn-default" type="button">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                    </button>
                                </span>
                            </div>
                           <!-- <select id="dllEjemplar" style="display:none;" style="width: 100%;"></select>-->

                            <input id="txtcodEjemplar" type="hidden">
                        </div>
                        <div class="col-md-5">
                            <label> Propietario: </label>
                            <input type="text" class="requerido form-control" id="txtprop" disabled>
                            <input id="txtidProp" type="hidden">
                        </div>
                        <div class="col-md-6">
                            <label> Concurso: </label>
                            <select id="dllConcurso" class="form-control"></select>
                        </div>
                        <div class="col-md-6">
                            <label> Fecha: </label>
                            <input id="txtFecha" type="date" class="requerido form-control" disabled>
                        </div>
                        <div class="col-md-12">
                            <label> Juez: </label>
                            <input id="txtJuez" type="text" class="requerido form-control" disabled>
                        </div>
                        <div class="col-md-6">
                            <label> Categoria: </label>
                            <input id="txtCategoria" type="text" class="requerido form-control" />
                        </div>
                        <div class="col-md-3">
                            <label> Grupo: </label>
                            <input type="text" id="txtgrupo" class="requerido form-control" />
                        </div>
                        <div class="col-md-3">
                            <label> N° Puesto: </label>
                            <input type="number" id="txtpuesto" class="requerido form-control"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSaveResultado" class="btn btn-primary">Grabar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEjemplares" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Buscar Ejemplar</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>NOMBRE DEL EJEMPLAR:</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="txtEjemplarFiltro" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button id="btnBuscarEjemplarNombre" class="btn btn-default">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
                <br>

                <table id="gridEjemplares">

                </table>
                <div id="opc_pag_ejemplares"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>