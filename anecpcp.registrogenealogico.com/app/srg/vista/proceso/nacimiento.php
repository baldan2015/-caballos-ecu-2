<? session_start();
include_once("entidad/Constantes.php");
?>
<script src="script/generales/general.buscar.ejemplar.js"></script>
<script src="script/generales/general.buscar.entidad.js"></script>
<script src="script/mantenimiento/mantenimiento.nacimiento.js"></script>
<!--<script src="script/mantenimiento/mantenimiento.campeon.js"></script>-->
<!--<script src="libs/multiselect/multiselect.js"></script>-->
<script src="vista/upload/js/jquery.PrintArea.js"></script>
<script src="vista/upload/js/jquery.form.min.js"></script>
<script src="script/generales/modalresenas.js"></script>
<script src="script/generales/loadImagenNac.js"></script>
<script src="script/generales/loadNacPdf.js"></script>
<style type="text/css">
  /*.bootstrap-select.btn-group .dropdown-toggle {
      max-width: 500px;
  }*/
</style>
<div style="float:left;background:#f6f6f6; width:100%; background:url('images/button/barra.png')100% 100% ;">
  <div style=" float:left; margin-top:10px;  ">
    <titulo>
      <span class="glyphicon glyphicon-list"></span>
      Solicitudes de Nacimientos
    </titulo>
  </div>
  <div style=" float:right;margin-top: 5px;  " class="toolButton ">


    <STYLE>
      .cvteste {
        color: blue !important;
      }

      .badge1 {
        background-color: #f0ad4e;
        /*AMARILLO - INICIADO*/
      }

      .badge2 {
        background-color: #5bc0de;
        /*CELESTE - REVISION*/
      }

      .badge3 {
        background-color: #007bff;
        /*AZUL - OBSERVADO */
      }

      .badge4 {
        background-color: #28a745;
        /*VERDE - APROBADO*/
      }

      .badge5 {
        background-color: #dc3545;
        /*VERDE - RECHAZADO*/
      }

      .badge6 {
        background-color: #777;
        /*GRIS - DE BAJA*/
      }

      .etiqueta {
        color: red;
      }

      .control-btn {
        display: flex;
      }

      .bg-success {
        background-color: #dff0d8;
      }

      .bg-default {
        border-color: #A7A7A7;
      }

      .control-btn.left {
        width: 50%;
      }

      .control-btn.rigth {
        width: 50%;
      }
    </STYLE>
    <?

    /*echo "</prev>";
   echo $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
     echo "</prev>";*/
    ?>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <!--<button id="btnNewRE2"  title="Nuevo registro de ejemplar" class="btn btn-default    " >
   <span class="glyphicon glyphicon-file">&nbsp;Nuevo</span>
    </button>-->
    <input type="hidden" id="hidIdUsu" value="<?= $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO] ?>">
    <div class="btn-group" role="group" aria-label="...">
      <button id="btnUpdEstado" title="Procesar solicitud nacimiento. " class="btn btn-primary    ">
        <span class="glyphicon glyphicon-cog"></span>&nbsp;Procesar Solicitud
      </button>

      <button id="btnVer" title="Buscar Nacimiento  " class="btn btn-default   ">
        <span class="glyphicon glyphicon-search"></span> &nbsp;Buscar
      </button>

      <button id="btnCancelarNac" title="Reiniciar filtros de busqueda  " class="btn btn-default   ">
        <span class="glyphicon glyphicon-refresh">&nbsp;Cancelar</span>
      </button>

      <!--  <div class="btn-group    " role="group" aria-label="...">-->
      <button id="btnEditarR" title="Editar datos de ejemplar. " class="btn btn-default   ">
        <span class="glyphicon glyphicon-pencil"></span>&nbsp;Editar
      </button>
      <!-- <button id="btnPrintCert"  title="Subir archivo Certificado" class="btn btn-primary   " > 
          <span class="glyphicon glyphicon-open"></span>&nbsp;Certificados
          
    </button>
    <button id="btnUpload"  title="Subir imagen del ejemplar" class="btn btn-primary     " > 
          <span class="glyphicon glyphicon-open"></span>&nbsp;Imagenes
          
    </button>-->
      <button id="btnEliminar" title="Eliminar ejemplar  " class="btn btn-default   ">
        <span class="glyphicon glyphicon-trash"></span>&nbsp;Eliminar
      </button>

      <!--
   <button id="btnCancelar"  title="Reiniciar filtros de busqueda  " class="btn btn-default   " >
    <span class="glyphicon glyphicon-refresh">&nbsp;Cancelar</span>
    </button>-->


      <button id="btnPrintHorse" title="Imprimir Solicitud de Nacimiento" class="btn btn-default  ">
        <span class="glyphicon glyphicon-print"></span>&nbsp;Imprimir

      </button>

      <button id="btnLog" title="Seguimiento deL nacimiento" class="btn btn-default     ">
        <span class="glyphicon glyphicon-list-alt"></span>&nbsp;Seguimiento

      </button>
    </div>
  </div>
</div>
<br><br>
<div class="container-fluid breadcrumb  ui-widget-content ">
  <div class="row">
    <div class="col-md-1">
      <Label>Codigo Sol.</Label>
      <input type="text " style='width: 110px;' id="txtCodigoBus" class="form-control" />
    </div>
    <div class="col-md-1">
      <Label>Prefijo</Label>
      <input type="text " id="txtPrefijoBus" class="form-control" />
    </div>
    <div class="col-md-3">
      <Label>Nombre</Label>
      <input type="text " id="txtNombreBus" class="form-control" />
    </div>
    <div class="col-md-3">
      <Label>Propietario</Label>
      <select id="ddlProps" class="selectpicker show-tick form-control " data-live-search="true" data-size="10" data-width="100%"></select>

      <input type="hidden" id="hidIdPropBus" />
      <input type="hidden" id="hidIdEnteBus" />

    </div>
    <div class="col-md-4">

      <Label>Estado</Label>
      <select id="ddlEstadoBus" class="form-control">
        <option value="0">Todos</option>
        <option value="A">Activo</option>
        <option value="I">Inactivo</option>
      </select>
    </div>
  </div>
  <!-- APLICANDO EL GRID CON JQGRID -->
  <table id="grid"></table>
  <!-- APLICANDO CONTROLES PAGINACIÓN JQGRID -->
  <div id="opc_pag"></div>

  <!-- Modal HTML -->
</div>
<!-- Modal HTML -->

<!-- Button HTML (to Trigger Modal) -->
<style>
  .modal-dialog-customer {
    max-width: 100%;
    width: 90%;
    background-color: #fff !important;
  }

  .modal-dialog-customer-fallece {
    max-width: 50%;
    width: 40%;
  }

  .modal-dialog-customer-imagen {
    max-width: 100%;
    width: 90%;
  }

  .modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
    background-color: #fff !important;
  }

  .modal-footer {
    background-color: #fff !important;
  }

  .modal-content {
    background-color: #fff !important;
  }
</style>


<!-- Modal HTML -->
<input type="hidden" id="hidIdUsu" value="<?= $_SESSION["IDUSU"] ?>" />
<div id="mvNuevoNacimiento" class="modal fade">
  <div class="modal-dialog  modal-lg modal-dialog-customer">
    <div class="modal-content " id="divContainer">
      <div class="modal-header bg-success">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <span class="modal-title"></span>
        <div style="float:right; margin-top: -10px; margin-right:100px;">
          <select class="form-control" id="ddlIdMonta"></select>
        </div>
        <div style="float:right; margin-top: -2px;    ">
          <label> Código Servicio de Monta: <span class="etiqueta">(*)</span>&nbsp; </label>

        </div>
      </div>
      <div class="modal-body">


        <div class="container-fluid">


          <div class="row">
            <div class="col-md-3">
              <input type="hidden" id="hidIdProp" />
              <label> Origen: <span class="etiqueta">(*)</span></label>
              <select id="ddlOrigen" class="requeridoLst form-control  ">
                <option value="0">Seleccione</option>
                <option value="N" selected="selected">Nacional</option>
                <option value="I">Importado</option>
              </select>
            </div>
            <div class="col-md-3">
              <input type="hidden" id="hidCodigo" />
              <input type="hidden" id="hidCodigoNacimiento" />
              <label>Genero: <span class="etiqueta">(*)</span></label> <select id="ddlGenero" class="requeridoLst form-control">
                <option value="0">Seleccione</option>
                <option value="Y">Yegua</option>
                <option value="P">Potro</option>
              </select>
            </div>
            <div class="col-md-3">
              <label>Nombre: <span class="etiqueta">(*)</span></label>
              <input type="text" id="txtNombre" name="txtNombre" class="form-control requerido" />
            </div>
            <div class="col-md-3">
              <label>Pelaje: <span class="etiqueta">(*)</span></label>
              <select id="ddlTipoPel" class="form-control  requerido"></select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3" style="margin-top: 7px;">
              <label> Departamento Nac. : <span class="etiqueta">(*)</span></label>
              <select id="ddlProvinvia" class="form-control requerido">
              </select>
            </div>
            <div class="col-md-3" style="margin-top: 7px;">
              <label> Lugar Nac. : </label>
              <input type="text" id="txtLugarNac" class="form-control" />
            </div>
            <div class="col-md-3" style="margin-top: 7px;">
              <label> Fecha Nac. : <span class="etiqueta">(*)</span></label>
              <input type="date" id="dtFechaNac" class=" form-control requerido " max="2050-12-31" />
            </div>
            <div class="col-md-3" style="margin-top: 7px;">
              <label>Microchip:</label>
              <input type="text" id="txtMicrochip" class="form-control" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-6" style="margin-top: 7px;">
              <input type="hidden" id="array" name="array" value="" />
              <label>Rese&ntilde;as:</label>
              <button id="btnBuscarResenia" class="btn btn-default btn-xs" title="IR A SELECCIONAR RESE&Ntilde;AS">
                <span class="glyphicon glyphicon-new-window"></span>
              </button>
              <textarea class="form-control" rows="2" cols="17" id="txtAResenia" readonly="true"></textarea>
            </div>
            <div class="col-md-6" style="margin-top: 7px;">
              <label>Anotaciones:</label>
              <textarea rows="2" cols="17" id="txtDescripcion" class="form-control"></textarea>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12" style="margin-top: 7px;">
              <label> Criador: </label><span>
                <select id="ddlCriador" name="ddlCriador" class="selectpicker show-tick form-control requeridoLst" data-live-search="true" data-size="5" data-width="100%"></select></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3" style="margin-top: 7px;">
              <label>Madre</label>
              <label class="form-control" disabled style="font-size: 15px;" id="lblYegua"></label>
              <input type="hidden" id="hidIdMadre" />
            </div>
            <div class="col-md-3" style="margin-top: 7px;">
              <label>Padre</label><br>
              <label class="form-control" disabled style="font-size: 15px;" id="lblPotro"></label>
              <input type="hidden" id="hidIdPadre" />
            </div>
            <div class="col-md-2" style="margin-top: 7px;">
              <label> M&eacute;todo reproductivo: </label>
              <label class="form-control" disabled style="font-size: 15px;" id="lblMetRep"></label>
              <input type="hidden" id="hidMetodo" />
            </div>
            <div class="col-md-2" style="margin-top: 7px;">
              <label style="color: #b7adad;">Fecha Embrion: </label>
              <label class="form-control" style="font-size: 15px;" disabled id="lblFecEmbrion"></label>
            </div>
            <div class="col-md-2" style="margin-top: 7px;">
              <label style="color: #b7adad;">ID Receptora: </label>
              <label class="form-control" style="font-size: 15px;" disabled id="lblIdReceptora"></label>
            </div>

          </div>
          <div class="row">
            <div class="col-md-3" style="margin-top: 7px;">
              <label> Reporte Monta: </label>
              <label class="form-control" disabled style="font-size: 15px;" id="lblIdMonta"></label>
              <input type="hidden" id="hidIdMonta" />
            </div>
            <div class="col-md-3" style="margin-top: 7px;">
              <label>Reporte Nac.:</label>
              <label class="form-control" disabled style="font-size: 15px;" id="lblIdNac"></label>
              <input type="hidden" id="hidFecMonta">
            </div>
            <!--<div class="col-md-3" style="margin-top: 7px;">
            <label>Fecha Solicitud Inscripcion:</label>
            <input type="date" id="dtFechaSol" class=" form-control requerido " disabled   max="2050-12-31"/>
      </div>-->
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div id="upload-wrapper">

              <h5 style="text-transform: uppercase; padding-left: 15px;font-weight: bold;">Agregar Imagenes del ejemplar: <span class="etiqueta">(*)</span><span class="badge badge-pill badge-warning-tit" id="lblDatoHorse" style="font-weight: bold;"></span> </h5>
              <form action="vista/upload/uploadF2/processuploadNacImg.php" method="post" enctype="multipart/form-data" id="MyUploadForm">

                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-7">
                      <input name="image_file" class="  btn  btn-default " style="width: 100%;margin-left: 45px;" id="imageInput" type="file" />
                    </div>
                    <div class="col-md-5">
                      <input type="submit" class="btn btn-success" id="submit-btn" style="margin-left:10%;" value="&#9650; Subir Imagen" />
                    </div>
                  </div>
                  <br>
                </div>

                <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait" />
                <input name="idHorse" id="idHorse" type="hidden" />
                <input name="hidNameHorse" id="hidNameHorse" type="hidden" value='<?= $_GET["nh"] ?>' />
                <input name="hidPrefijoHorse" id="hidPrefijoHorse" type="hidden" value='<?= $_GET["prefh"] ?>' />
                <input name="hidCodigoGenerado" id="hidCodigoGenerado" type="hidden">
                <input name="hidFlagEdit" id="hidFlagEdit" type="hidden">
              </form>
              <div id="output" class="table table-responsive" style="width: 100%;"> </div>

            </div>
          </div>
          <div class="col-md-6">
            <div id="upload-wrapper">

              <h5 style="text-transform: uppercase;padding-left: 15px;font-weight: bold;">Agregar Certificados del ejemplar:
                <span class="badge badge-pill badge-warning-tit" id="lblDatoHorsePdf" style="font-weight: bold;"></span>
              </h5>
              <form action="vista/upload/uploadF2/processuploadNacPdf.php" method="post" enctype="multipart/form-data" id="MyUploadFormPdf">

                <div class="container-fluid">
                  <!-- <div class="row">
               <div class="col-md-5" style="margin-bottom: 3px;">
                  <label id="lblTipoD">Tipo de documento</label>
                </div>
            </div>-->
                  <div class="row">
                    <div class="col-md-3" style="margin-bottom: 3px;">
                      <select class="form-control requerido" id="ddlTipoDocumento" onchange="tipoDoc()"></select>
                    </div>
                    <div class="col-md-5" style="margin-bottom: 3px;">
                      <input name="pdf_file" class="  btn   btn-default " style="width: 100%;" id="pdfInput" type="file" />
                    </div>
                    <div class="col-md-3" style="margin-bottom: 3px;">
                      <input type="submit" class="btn   btn-info" id="submit-btn-pdf" value="&#9650; Subir Certificados" />
                    </div>
                  </div>
                  <br>
                </div>


                <input name="idHorsePdf" id="idHorsePdf" type="hidden" value='0' />
                <input name="idTipoDoc" id="idTipoDoc" type="hidden" value='0' />
                <!--<input name="hidNameHorse" id="hidNameHorse" type="hidden" value='<?= $_GET["nh"] ?>' />
            <input name="hidPrefijoHorse" id="hidPrefijoHorse" type="hidden" value='<?= $_GET["prefh"] ?>' />-->
                <input name="hidCodigoGenerado" id="hidCodigoGenerado" type="hidden">
                <input name="hidFlagEdit" id="hidFlagEdit" type="hidden">
              </form>
              <div id="outputPdf" class="table table-responsive" style="width: 100%;"> </div>

            </div>
          </div>

        </div>
        <div class="row" id="divBaja" style="display: none;">
          <div class="col-md-12">

            <div class="col-md-2">
              <h5 style="text-transform: uppercase;padding-left: 10px;font-weight: bold;">Motivo de Baja: <span class="etiqueta">(*)</span></h5>
            </div>
            <div class="col-md-2">
              <select class="form-control" id="txtMotivoBaja" disabled>
              </select>
            </div>

            <div class="col-md-1">
              <h5 style="text-transform: uppercase;padding-left: 10px;font-weight: bold;">Fecha: <span class="etiqueta">(*)</span></h5>
            </div>
            <div class="col-md-2">
              <input type="date" class="form-control " id="txtFechaBaja" disabled />
            </div>

            <div class="col-md-2">
              <h5 style="text-transform: uppercase;padding-left: 10px;font-weight: bold;">Detalle: <span class="etiqueta">(*)</span></h5>
            </div>
            <div class="col-md-2">
              <textarea class="form-control" id="txtDetalleBaja" disabled></textarea>
            </div>

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="btnSaveNE" class="btn btn-primary">Grabar </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

      </div>
    </div>
  </div>
</div>

<!-- FIN DE CARGA DE IMAGEN  -->

<!-- Modal -->
<style>
  .modal-dialog-customer-grlEjemplar {
    max-width: 60%;
    width: 50%;
  }
</style>
<div class="modal fade" id="mvBuscadorEjemplarGrl" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-customer-grlEjemplar">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">B&uacute;squeda de Ejemplar</h4>
      </div>
      <div class="modal-body">
        <!--  <div style="display:none" id="mvBuscadorEjemplarGrl">-->
        <input type="hidden" id="hidOrigenBuscador" />
        <label>Ingrese nombre del Ejemplar:</label>
        <input type="text" id="txtBGNombreEjemplar" />
        <button id="btnBGBuscarEjemplar" class="btn-xs btn-danger" onclick="return initDataTableGrlEjemplar();">Buscar</button>
        <hr>
        <div>
          <table id="gridGralEjemplar"></table>
          <!-- APLICANDO CONTROLES PAGINACIÓN JQGRID -->
          <div id="opc_pagGralEjemplar"></div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<style>
  .modal-dialog-customer-grlEnte {
    max-width: 60%;
    width: 50%;
  }
</style>
<div class="modal fade" id="mvBuscadorEntidadGrl" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-customer-grlEnte">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">B&uacute;squeda de Entidades</h4>
      </div>
      <div class="modal-body">
        <!--<div style="display:none" id="mvBuscadorEntidadGrl">-->
        <input type="hidden" id="hidOrigenBuscador" />
        <label>Ingrese nombre :</label>
        <input type="text" id="txtBGNombreEntidad" />
        <button id="btnBGBuscarEntidad" class="btn-xs btn-danger" onclick="return initDataTableGrlEntidadProp();">Buscar</button>
        <hr>
        <div>
          <table id="gridGralEntidad"></table>
          <!-- APLICANDO CONTROLES PAGINACIÓN JQGRID -->
          <div id="opc_pagGralEntidad"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<style>
  .modal-dialog-customer-grlRESE {
    max-width: 80%;
    width: 80%;
  }
</style>
<div class="modal fade " id="mvBuscadorResenaGrl" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-customer-grlRESE">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Selecci&oacute;n de Resenas</h4>
      </div>
      <div class="modal-body">
        <!--<div style="display:none" id="mvBuscadorEntidadGrl">-->
        <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
          <div class="btn-group" role="group">
            <button type="button" id="basica" class="btn btn-primary" href="#tab1" data-toggle="tab">
              <div class="hidden-xs">Reseña Básica</div>
            </button>
          </div>
          <div class="btn-group" role="group">
            <button type="button" id="avanzada" class="btn btn-default" href="#tab2" data-toggle="tab">
              <div class="hidden-xs">Reseña Avanzada</div>
            </button>
          </div>
        </div>
        <div class="well">
          <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1">
              <label style="font-size:14px; font-weight:bold;">Ingrese descripción de reseña</label>
              <textarea id="txtReseniaBasica" class="form-control"></textarea>
            </div>
            <div class="tab-pane fade in" id="tab2">
              <div class="row" style="margin-left: 15px;">
                <div class="col-xs-3">

                  <span style="font-size:14px; font-weight:bold;">
                    <li> Filtros de Búsqueda</li>
                  </span>
                  <ul class="list-group">

                    <li class="list-group-item">
                      <label for="rdbtnALL">Todas las reseñas</label>
                      <div class="material-switch pull-right">
                        <input type='checkbox' class='cssItem' checked id='rdbtnALL' value='ALL' />
                        <label title='activar o desactivar todos los tipos para buscar' for="rdbtnALL" class='thItem label-success'></label>

                      </div>
                    </li>
                    <!-- <li class="list-group-item">
                <label for="rdbtnCA">Cabeza</label>
                <div class="material-switch pull-right">
                  <input type='checkbox' class='cssItem' id='rdbtnCA' value='CA' />
                  <label title='filtrar por Cabeza' for="rdbtnCA" class='thItem label-success'></label>

                </div>
              </li>
              <li class="list-group-item">
                <label>Anterior Derecho.</label>
                <div class="material-switch pull-right">
                  <input type='checkbox' class='cssItem' id='rdbtnAD' value='AD' />
                  <label title='filtrar por Anterior Derecho' for="rdbtnAD" class='thItem label-success'></label>

                </div>
              </li>
              <li class="list-group-item">
                <label>Anterior Izquierdo.</label>
                <div class="material-switch pull-right">
                  <input type='checkbox' class='cssItem' id='rdbtnAI' value='AI' />
                  <label title='filtrar por Anterior Derecho' for="rdbtnAI" class='thItem  label-success'></label>

                </div>
              </li>
              <li class="list-group-item">
                <label>Posterior Derecho.</label>
                <div class="material-switch pull-right">
                  <input type='checkbox' class='cssItem' id='rdbtnPD' value='PD' />
                  <label title='filtrar por Anterior Derecho' for="rdbtnPD" class='thItem  label-success'></label>

                </div>
              </li>
              <li class="list-group-item">
                <label>Posterior Izquierdo.</label>
                <div class="material-switch pull-right">
                  <input type='checkbox' class='cssItem' id='rdbtnPI' value='PI' />
                  <label title='filtrar por Anterior Derecho' for="rdbtnPI" class='thItem  label-success '></label>

                </div>
              </li> -->
                    <li class="list-group-item">
                      <label>Otros</label>
                      <div class="material-switch pull-right">
                        <input type='checkbox' class='cssItem' id='rdbtnCO' value='PO' />
                        <label title='filtrar por complementario' for="rdbtnCO" class='thItem  label-success '></label>

                      </div>
                    </li>
                    <li class="list-group-item">
                      <input id="busquedaRe" type="text" class="form-control" placeholder="ingrese reseña...">
                      <div class="control-btn">
                        <div class="control-btn rigth">
                          <button class="btn form-control btn-xs  bg-default" id="btnLimpiarResena">Limpiar <span class="glyphicon glyphicon-refresh"></button>
                        </div>
                        <div class="control-btn rigth">
                          <button class="btn  form-control   btn-xs   bg-success" id="btnFiltrarResena">Buscar <span class="glyphicon glyphicon-search"></button>
                        </div>
                      </div>
                    </li>
                  </ul>

                </div>
                <div class="col-xs-4">
                  <span style="font-size:14px; font-weight:bold;">
                    <li> Reseñas seleccionables</li>
                  </span>

                  <select name="from[]" multiple="multiple" id="ddlReseniaLeftCA" size="20" class="form-control ">

                  </select>
                  <!-- data-live-search="true" 
             data-size="10" 
             data-width="100%"  -->
                </div>
                <div class="col-xs-1 " style='margin-top:100px;'>

                  <button id="rightSelectedCA" class="btn btn-block bg-success"><i class="glyphicon glyphicon-chevron-right"></i></button>
                  <button id="leftSelectedCA" class="btn btn-block bg-success"><i class="glyphicon glyphicon-chevron-left"></i></button>

                </div>
                <div class="col-xs-3">
                  <span style="font-size:14px; font-weight:bold;">
                    <li> Reseñas seleccionadas</li>
                  </span>
                  <select name="to[]" id="ddlReseniaRightCA" class="form-control" size="20" multiple="multiple"></select>
                </div>
                <div class="col-xs-1" style='margin-top:100px;'>
                  <button id="SelectedUp" class="btn btn-block bg-success"><i class="glyphicon glyphicon-chevron-up"></i></button>
                  <button id="SelectedDown" class="btn btn-block bg-success"><i class="glyphicon glyphicon-chevron-down"></i></button>
                </div>
              </div>
              <div class="row" style=" margin-top:10px;margin-left:13px;">
                <label style="font-size:14px; font-weight:bold;"> Reseña:</label> <label style="font-size:14px; font-weight:bold;" id="lblResenia"></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="btnSaveResena" class="btn btn-primary">Guardar </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<style>
  .hover-primary:hover {
    background-color: #337AB7 !important;
    color: #fff !important;
  }
</style>
<div class="modal fade" id="mdlMensaje" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="btnCloseImgView">&times;</button>
        <h4 class="modal-title">Aviso :: Confirmación </h4>
      </div>
      <div class="modal-body">
        <div class="row" style="text-align: center;">
          <div class="col-md-12">
            <h4>Ud. ha registrado información para reseñas del tipo básica y avanzada. ¿Cúal desea Mantener?</h4>
          </div>
        </div>
        <div class="row" style="text-align: center;">
          <div class="col-xs-6">
            <button id="btnMantBasica" style="border-color: #337AB7;color: #337AB7;" class="btn btn-default hover-primary">Mantener Reseña Básica</button>
          </div>
          <div class="col-xs-6">
            <button id="btnManAvanzada" style="border-color: #337AB7;color: #337AB7;" class="btn btn-default hover-primary">Mantener Reseña Avanzada</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
  .modal-dialog-customer-img {
    max-width: 80%;
    width: 80%;
  }
</style>
<div class="modal fade" id="mvImagen2" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-customer-img">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" id="btnCloseImgView" >&times;</button>-->
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"> </h4>
      </div>
      <div class="modal-body">
        <img src="" id="imgHorse2" width="100%">
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
      </div>
    </div>
  </div>
</div>

<style>
  .modal-dialog-customer-pdf {
    max-width: 80%;
    width: 80%;
  }

  .doc-container {
    position: relative;
    padding-bottom: 100%;
    height: 100%;

  }

  .doc-container iframe,
  .doc-container object,
  .doc-container embed {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    margin: 0px;
  }
</style>
<div class="modal fade" id="mvPdf2" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-customer-pdf">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" id="btnClosePdfView" >&times;</button>-->
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"> </h4>
      </div>
      <div class="modal-body">
        <!--<img src="" id="imgHorse" width="100%">-->
        <div class="doc-container">
          <iframe id="ifrPDF2" style="width: 100%;" frameborder="0" allowfullscreen></iframe>
          <div class="modal-footer">
            <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<?
//require_once("/vista/general/grlBuscarEjemplar.php");  
//require_once("/vista/general/grlBuscarEntidad.php");  
// require("../upload/upload/inscripcionPopPdfEjemplar.php");
?>

<style type="text/css">
  @media print {

    /* on modal open bootstrap adds class "modal-open" to body, so you can handle that case and hide body */
    body.modal-open {
      visibility: hidden;
    }

    body.modal-open .modal .modal-header,
    body.modal-open .modal .modal-body {
      visibility: visible;
      /* make visible modal body and header */
    }

  }
</style>



<?
require("vista/popup/nacimientoPopSeguimiento.php");
require("vista/popup/nacimientoPopEstado.php");

?>