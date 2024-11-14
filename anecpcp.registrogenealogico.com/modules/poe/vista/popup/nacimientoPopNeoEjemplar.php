<script src="../script/generales/loadImagenNac.js"></script>
<script src="../script/generales/loadNacPdf.js"></script>

<style>
  .modal-dialog-customer {
    max-width: 100%;
    width: 95%;
  }

  .modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
  }

  .image_redonda_min {
    filter: drop-shadow(0 0 7px black);

    width: 30px;
    height: 30px;
    border-radius: 30px;

  }

  .bg-success {
    background-color: #dff0d8;
  }

  .bg-default {
    border-color: #A7A7A7;
  }

  .modal-title {
    font-size: 20px;
    margin-left: 10px;
    ;
    font-weight: bold;
  }

  .disabled {
    background-color: #eee;
    opacity: 1;
  }

  .control-btn {
    display: flex;
  }

  .control-btn.left {
    width: 50%;
  }

  .control-btn.rigth {
    width: 50%;
  }
</style>
<div id="mvNuevoNacEjemplar" class="modal fade">
  <div class="modal-dialog  modal-lg modal-dialog-customer">
    <div class="modal-content " id="divContainer">
      <div class="modal-header bg-success ">
        <div class="row">
          <div class="col-md-5">
            <h4><img src="../../../home/img/nac.jpg" class="image_redonda_min" /><span class="modal-title" style="padding-left: 10px;">NACIMIENTO DE EJEMPLAR.</span></h4>
          </div>
          <div class="col-md-2" style="margin-top: 10px;text-align: end;">
            <label> Código Servicio de Monta : <span class="etiqueta">(*)</span> &nbsp;</label>
          </div>
          <div class="col-md-4">
            <select id="ddlIdMonta" class="form-control  input-sm selectpicker show-tick " data-live-search="true" data-size="10" data-width="100%" onchange="getInfoMonta()">
            </select>
          </div>
          <div class="col-md-1">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
        </div>
      </div>
      <div class="modal-body">



        <div class="container-fluid">

          <div class="row">
            <div class="col-md-3">
              <label> Origen: <span class="etiqueta">(*)</span> </label>
              <select id="ddlOrigen" class="requeridoLst form-control">
                <option value="0">Seleccione</option>
                <option value="N" selected="selected">Nacional</option>
                <option value="I">Importado</option>
              </select>
            </div>
            <div class="col-md-3">
              <input type="hidden" id="hidCodigo" />
              <input type="hidden" id="hidCodigoNacimiento" />
              <td>
                <label>Genero: <span class="etiqueta">(*)</span> </label> <select id="ddlGenero" class="form-control requeridoLst">
                  <option value="0">Seleccione</option>
                  <option value="Y">Yegua</option>
                  <option value="P">Potro</option>
                </select>
            </div>
            <div class="col-md-3">
              <label>Nombre: <span class="etiqueta">(*)</span> </label>
              <input type="text" id="txtNombre" name="txtNombre" class="requerido form-control" />
            </div>
            <div class="col-md-3">
              <label>Pelaje: <span class="etiqueta">(*)</span> </label>
              <select id="ddlTipoPel" class="form-control  selectpicker show-tick"></select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3" style="margin-top: 7px;">
              <label> Departamento Nac. : <span class="etiqueta">(*)</span> </label>
              <select id="ddlProvinvia" class="requeridoLst form-control">
              </select>
            </div>
            <div class="col-md-3" style="margin-top: 7px;">
              <label> Lugar Nac. : </label>
              <input type="text" id="txtLugarNac" class="form-control" />
            </div>
            <div class="col-md-3" style="margin-top: 7px;">
              <label> Fecha Nac. : <span class="etiqueta">(*)</span> </label>
              <input type="date" id="dtFechaNac" class="requeridoLst form-control requerido" max="2050-12-31" />
            </div>
            <div class="col-md-3" style="margin-top: 7px;">
              <label>Microchip:</label>
              <input type="text" id="txtMicrochip" class="form-control" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-6" style="margin-top:  7px;" id="divResenas">
              <input type="hidden" id="array" name="array" value="" />
              <label>Rese&ntilde;as:</label>
              <button id="btnBuscarResenia" class="btn btn-info btn-xs" title="IR A SELECCIONAR RESE&Ntilde;AS">
                <span class="glyphicon glyphicon-new-window"></span>
              </button>

              <textarea class="form-control" rows="2" cols="17" id="txtAResenia" readonly="true"></textarea>
            </div>
            <div class="col-md-6" style="margin-top: 7px;" id="divAnotaciones">
              <label>Anotaciones:</label>
              <textarea rows="2" cols="17" id="txtDescripcion" class="form-control"></textarea>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12" style="margin-top: 7px;">
              <label> Criador: </label><span> <select id="ddlCriador" class="form-control disabled"></select></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3" style="margin-top: 7px;">
              <label>Madre</label>
              <label class="form-control" id="lblYegua" disabled style="font-size: 10px;"></label>
              <input type="hidden" id="hidIdMadre" />
            </div>
            <div class="col-md-3" style="margin-top:  7px;">
              <label>Padre</label><br>
              <label id="lblPotro" class="form-control" disabled style="font-size:  10px;"></label>
              <input type="hidden" id="hidIdPadre" />
            </div>
            <div class="col-md-2" style="margin-top:  7px;">
              <label> M&eacute;todo reproductivo: </label>
              <label class="form-control" disabled style="font-size:  10px;" id="lblMetRep"></label>
              <input type="hidden" id="hidMetodo" />
            </div>
            <div class="col-md-2" style="margin-top:  7px;">
              <label> Fecha de Embrion: </label>
              <label class="form-control" disabled style="font-size:  10px;" id="lblFecEmbrion"></label>
            </div>
            <div class="col-md-1" style="margin-top:  7px;">
              <label> ID Receptora: </label>
              <label class="form-control" disabled style="font-size: 10px;" id="lblIdReceptora"></label>
            </div>
            <div class="col-md-1" style="margin-top:  7px;">
              <label> Reporte Monta: </label>
              <label class="form-control" disabled style="font-size: 10px;" id="lblIdMonta"></label>
              <input type="hidden" id="hidIdMonta" />
              <input type="hidden" id="hidFecMonta">
            </div>
          </div>








          <div class="row">
            <div class="col-md-6">
              <div id="upload-wrapper">

                <h5 style="text-transform: uppercase;padding-left: 10px;font-weight: bold;">Agregar Imagenes del ejemplar: <span class="etiqueta">(*)</span>
                  <span class="badge badge-pill badge-warning-tit" id="lblDatoHorse" style="font-weight: bold;"></span>
                </h5>
                <form action="upload/processuploadNacImg.php" method="post" enctype="multipart/form-data" id="MyUploadForm">

                  <!--    <div class="container-fluid">-->
                  <div class="row" id="divImageInput">
                    <div class="col-md-8">
                      <input name="image_file" class="  btn  btn-default " id="imageInput" type="file" />
                    </div>

                    <div class="col-md-4">
                      &nbsp;
                      <input type="submit" class="btn   btn-info  " id="submit-btn" title="cargar imagen del ejemplar" value="&#9650; Cargar Imagen" />

                    </div>
                  </div>

                  <!-- </div>-->


                  <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait" />
                  <input name="idHorse" id="idHorse" type="hidden" value='<?= $_GET["idHorse"] ?>' />
                  <input name="hidNameHorse" id="hidNameHorse" type="hidden" value='<?= $_GET["nh"] ?>' />
                  <input name="hidPrefijoHorse" id="hidPrefijoHorse" type="hidden" value='<?= $_GET["prefh"] ?>' />
                  <input name="hidCodigoGenerado" id="hidCodigoGenerado" type="hidden">
                  <input name="hidFlagEdit" id="hidFlagEdit" type="hidden">
                </form>
                <div class="row">
                  <div class="col-md-12">
                    <div id="output" class="table table-responsive" style="width: 100%;"> </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div id="upload-wrapper">

                <h5 style="text-transform: uppercase;padding-left: 15px;font-weight: bold;">Agregar Certificados PDF:
                  <!--<span class="etiqueta">(*)</span>--> <span class="badge badge-pill badge-warning-tit" id="lblDatoHorsePdf" style="font-weight: bold;"></span>
                </h5>
                <form action="upload/processuploadNacPdf.php" method="post" enctype="multipart/form-data" id="MyUploadFormPdf">

                  <!--   
        <div class="row">
            <div class="col-md-5" style="margin-bottom: 3px;">
              <label id="lblTipoD">Tipo de documento</label>
            </div>
        </div>-->
                  <div class="row">
                    <div class="col-md-4">
                      <select class="form-control requerido" id="ddlTipoDocumento" onchange="tipoDoc()"></select>
                    </div>

                    <div class="col-md-6">
                      <input name="pdf_file" class="  btn   btn-default " id="pdfInput" type="file" />


                    </div>
                    <div class="col-md-2">
                      <input type="submit" class="btn   btn-info" id="submit-btn-pdf" title="Cargar documento PDF" value="&#9650; PDF " />
                    </div>
                  </div>



                  <input name="idHorsePdf" id="idHorsePdf" type="hidden" value='0' />
                  <input name="idTipoDoc" id="idTipoDoc" type="hidden" value='0' />
                  <!--<input name="hidNameHorse" id="hidNameHorse" type="hidden" value='<?= $_GET["nh"] ?>' />
        <input name="hidPrefijoHorse" id="hidPrefijoHorse" type="hidden" value='<?= $_GET["prefh"] ?>' />-->
                  <input name="hidCodigoGenerado" id="hidCodigoGenerado" type="hidden">
                  <input name="hidFlagEdit" id="hidFlagEdit" type="hidden">
                </form>
                <div class="row">
                  <div class="col-md-12">
                    <div id="outputPdf" class="table table-responsive" style="width: 100%;"> </div>
                  </div>
                </div>
              </div>


            </div>

          </div>
          <div class="modal-footer" id="divBaja" style="display: none;">
            <div class="row">

              <div class="col-md-2">
                <h5 style="text-transform: uppercase;padding-left: 10px;font-weight: bold;">Motivo de Baja: <span class="etiqueta">(*)</span></h5>
              </div>
              <div class="col-md-2">
                <select class="form-control selectpicker show-tick" id="txtMotivoBaja">
                </select>
              </div>

              <div class="col-md-1">
                <h5 style="text-transform: uppercase;padding-left: 10px;font-weight: bold;">Fecha: <span class="etiqueta">(*)</span></h5>
              </div>
              <div class="col-md-2">
                <input type="date" class="form-control" id="txtFechaBaja" />
              </div>

              <div class="col-md-2">
                <h5 style="text-transform: uppercase;padding-left: 10px;font-weight: bold;">Detalle: <span class="etiqueta">(*)</span></h5>
              </div>
              <div class="col-md-3">
                <textarea class="form-control" id="txtDetalleBaja"></textarea>
              </div>

            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button id="btnSaveNE" class="btn btn-primary">Grabar </button>
        <button id="btnSaveBaja" class="btn btn-primary" style="display: none;">Grabar Baja </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="mvBuscadorEjemplarGrl" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-customer-grlEjemplar">
    <div class="modal-content">
      <div class="modal-header bg">
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
  .modal-dialog-customer-grlRESE {
    max-width: 80%;
    width: 80%;
  }
</style>
<div class="modal fade " id="mvBuscadorResenaGrl" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-customer-grlRESE">
    <div class="modal-content">
      <div class="modal-header bg-success ">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Selecci&oacute;n de Rese&ntilde;as</h4>
      </div>
      <div class="modal-body">
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
              <div class="row">
                <div class="col-xs-3">

                  <span style="font-size:14px; font-weight:bold;">
                    <li> Filtros de Búsqueda</li>
                  </span>
                  <ul class="list-group">
                    <li class="list-group-item" bg-success>

                    </li>
                    <li class="list-group-item">
                      <label for="rdbtnCA">Todas las reseñas</label>
                      <div class="material-switch pull-right">
                        <input type='checkbox' class='cssItem' checked id='rdbtnALL' value='ALL' />
                        <label title='activar o desactivar todos los tipos para buscar' for="rdbtnALL" class='thItem label-success'></label>

                      </div>
                    </li>
                    <!--<li class="list-group-item">
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
              </li>-->
                    <li class="list-group-item">
                      <label>Otros</label>
                      <div class="material-switch pull-right">
                        <input type='checkbox' class='cssItem' id='rdbtnCO' value='PO' />
                        <label title='filtrar por otros' for="rdbtnCO" class='thItem  label-success '></label>

                      </div>
                    </li>
                    <li class="list-group-item">
                      <input id="busquedaRe" type="text" class="form-control" placeholder="ingrese reseña...">
                      <div class="control-btn">
                        <div class="control-btn left">
                          <button class="btn form-control btn-xs bg-default" id="btnLimpiarResena" sty>Limpiar <span class="glyphicon glyphicon-refresh"></button>
                        </div>
                        <div class="control-btn rigth">
                          <button class="btn form-control btn-xs  bg-success" id="btnFiltrarResena" sty>Buscar <span class="glyphicon glyphicon-search"></button>
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


              <!-- <div class="row" style="margin-left: 15px;">
          <div class="col-xs-5">
            <label> Anterior Derecho</label>
            <select name="from[]" multiple="multiple" id="ddlReseniaLeftAD" size="3" class="form-control   "></select>
          </div>
          <div class="col-xs-1">
            <br>
            <button id="rightSelectedAD" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
            <button id="leftSelectedAD" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>

          </div>
          <div class="col-xs-5">
            <label> Rese&ntilde;as Seleccionadas</label>
            <select name="to[]" id="ddlReseniaRightAD" class="form-control" size="3" multiple="multiple"></select>
          </div>
        </div>

        <div class="row" style="margin-left: 15px;">
          <div class="col-xs-5">
            <label> Anterior Izquierdo</label>
            <select name="from[]" multiple="multiple" id="ddlReseniaLeftAI" size="3" class="form-control   "></select>
          </div>
          <div class="col-xs-1">
            <br>
            <button id="rightSelectedAI" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
            <button id="leftSelectedAI" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>

          </div>
          <div class="col-xs-5">
            <label>Rese&ntilde;as Seleccionadas</label>
            <select name="to[]" id="ddlReseniaRightAI" class="form-control" size="3" multiple="multiple"></select>
          </div>
        </div>


        <div class="row" style="margin-left: 15px;">
          <div class="col-xs-5">
            <label> Posterior Derecho</label>
            <select name="from[]" multiple="multiple" id="ddlReseniaLeftPD" size="3" class="form-control   "></select>
          </div>
          <div class="col-xs-1">
            <br>
            <button id="rightSelectedPD" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
            <button id="leftSelectedPD" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>

          </div>
          <div class="col-xs-5">
            <label> Rese&ntilde;as Seleccionadas</label>
            <select name="to[]" id="ddlReseniaRightPD" class="form-control" size="3" multiple="multiple"></select>
          </div>
        </div>

        <div class="row" style="margin-left: 15px;">
          <div class="col-xs-5">
            <label> Posterior Izquierdo</label>
            <select name="from[]" multiple="multiple" id="ddlReseniaLeftPI" size="3" class="form-control   "></select>
          </div>
          <div class="col-xs-1">
            <br>
            <button id="rightSelectedPI" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
            <button id="leftSelectedPI" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>

          </div>
          <div class="col-xs-5">
            <label> Rese&ntilde;as Seleccionadas</label>
            <select name="to[]" id="ddlReseniaRightPI" class="form-control" size="3" multiple="multiple"></select>
          </div>
        </div> -->

              <div class="row" style=" margin-top:10px;margin-left:13px;">
                <label style="font-size:14px; font-weight:bold;"> Reseña:</label> <label style="font-size:14px; font-weight:bold;" id="lblResenia"></label>

              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button id="btnSaveResena" class="btn btn-primary">Guardar </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
<div class="modal fade" id="mvImagen" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-customer-img">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="btnCloseImgView">&times;</button>
        <h4 class="modal-title"> </h4>
      </div>
      <div class="modal-body">
        <img src="" id="imgHorse" width="100%">
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
<div class="modal fade" id="mvPdf" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-customer-pdf">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="btnClosePdfView">&times;</button>
        <h4 class="modal-title"> </h4>
      </div>
      <div class="modal-body">
        <!--<img src="" id="imgHorse" width="100%">-->
        <div class="doc-container">
          <iframe id="ifrPDF" style="width: 100%;" frameborder="0" allowfullscreen></iframe>
          <div class="modal-footer">
            <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
          </div>

        </div>
      </div>
    </div>
  </div>
</div>