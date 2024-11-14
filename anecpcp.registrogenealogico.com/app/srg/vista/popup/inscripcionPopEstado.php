<!--<script src="script/generales/loadInsPdfEstadosPopup.js"></script>-->
<style>
    .modal-dialog-log-estado {
        max-width: 100%;
        width: 80%;
        background-color: #FFF !important;
    }

    #mvEstadoInscripcion .modal-body {
        background-color: #FFF !important;
    }

    fieldset {
        border: solid 1px #DDD !important;
        padding: 0 10px 10px 10px;
        border-bottom: none;
        background: #fff;
    }

    legend {
        width: auto !important;
        margin-bottom: 10px;
        font-size: 17px;

    }
</style>
<div id="mvEstadoInscripcion" class="modal fade">
    <div class="modal-dialog  modal-lg modal-dialog-log-estado">
        <div class="modal-content " id="divContainer">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Procesar Solicitud de Inscripci&oacute;n.</h4>
                <div style="float:right; margin-top: -30px; margin-right:40px;">
                    <label class="form-control" disabled id="lblCodigoInscripcionE"></label>
                </div>
                <div style="float:right; margin-top: -20px;    ">
                    <label> Código Inscripción: </label>

                </div>
            </div>
            <div class="modal-body">


                <div class="container-fluid">
                    <div class="panel panel-danger">
                        <div class="panel-heading" style="font-weight: bold;">Datos de solicitud</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="hidden" id="hidIdPropE" />
                                    <input type="hidden" id="hidCodigoE" />
                                    <label style="color: #b7adad;"> Origen: </label>
                                    <label id="lblOrigenE" disabled></label>
                                </div>
                                <div class="col-md-3">
                                    <input type="hidden" id="hidCodigo" />
                                    <input type="hidden" id="hidCodigoInscripcion" />
                                    <label style="color: #b7adad;">Genero:</label>
                                    <label disabled id="lblGeneroE"></label>
                                </div>
                                <div class="col-md-3">
                                    <label style="color: #b7adad;">Nombre: </label>
                                    <label disabled id="lblNombreE"></label>
                                </div>
                                <div class="col-md-3">
                                    <label style="color: #b7adad;">Pelaje:</label>
                                    <label disabled id="lblPelajeE"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3" style="margin-top: 7px;">
                                    <label style="color: #b7adad;"> Dpto. Nac. : </label>
                                    <label disabled id="lblProvinciaE"></label>
                                    </select>
                                </div>
                                <div class="col-md-3" style="margin-top: 7px;">
                                    <label style="color: #b7adad;"> Lugar Nac. : </label>
                                    <label disabled id="lblLugarNaceE"></label>
                                </div>
                                <div class="col-md-3" style="margin-top: 7px;">
                                    <label style="color: #b7adad;"> Fecha Nac. : </label>
                                    <label id="dtFechaNacE"></label>
                                    <!-- <input type="date" id="dtFechaNacE" disabled    max="2050-12-31"/>-->
                                </div>
                                <div class="col-md-3" style="margin-top: 7px;">
                                    <label style="color: #b7adad;">Microchip:</label>
                                    <label disabled id="lblMicrochipE"></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" style="margin-top: 7px;">
                                    <label style="color: #b7adad;">Madre</label>
                                    <label disabled id="lblYeguaE"></label>
                                    <input type="hidden" id="hidIdMadre" />
                                </div>
                                <div class="col-md-6" style="margin-top: 7px;">
                                    <label style="color: #b7adad;">Padre</label>
                                    <label disabled id="lblPotroE"></label>
                                    <input type="hidden" id="hidIdPadre" />
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3" style="margin-top: 7px;">
                                    <label style="color: #b7adad;"> M&eacute;todo reprod.: </label>
                                    <label disabled id="lblMetRepE"></label>
                                    <input type="hidden" id="hidMetodo" />
                                </div>
                                <div class="col-md-3" id="DivfecServ" style="margin-top: 7px;">
                                    <label style="color: #b7adad;">Fecha Servicio: </label>
                                    <label disabled id="lblFecServ"></label>
                                </div>
                                <div class="col-md-2" id="DivFecEmbrion" style="margin-top: 7px;">
                                    <label style="color: #b7adad;">Fecha Embrion: </label>
                                    <label disabled id="lblFecEmbrion"></label>
                                </div>
                                <div class="col-md-2" id="DivIdReceptora" style="margin-top: 7px;">
                                    <label style="color: #b7adad;">ID Receptora: </label>
                                    <label disabled id="lblIdReceptora"></label>
                                </div>
                                <div class="col-md-3" id="DivIdMontaE" style="margin-top: 7px;">
                                    <label style="color: #b7adad;"> Reporte Monta: </label>
                                    <label disabled id="lblIdMontaE"></label>
                                    <input type="hidden" id="hidIdMonta" />
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3" id="DivIdNacE" style="margin-top: 7px;">
                                    <label style="color: #b7adad;">Reporte Nac.:</label>
                                    <label disabled style="font-size: 15px;" id="lblIdNacE"></label>
                                    <input type="hidden" id="hidIdNac" />
                                </div>
                                <div class="col-md-3" style="margin-top: 7px;">
                                    <label style="color: #b7adad;">Fecha Inscripcion:</label>
                                    <label id="dtFechaSolE"></label>
                                    <!--<input type="date" id="dtFechaSolE" class=" form-control requerido " disabled   max="2050-12-31"/>-->
                                </div>
                                <div class="col-md-12" style="margin-top: 7px;">
                                    <label style="color: #b7adad;"> Criadero: </label>
                                    <label disabled id="lblCriadorE"></label>
                                    <input type="hidden" id="txtCodCriador">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 7px;">
                                    <input type="hidden" id="array" name="array" value="" />
                                    <label style="color: #b7adad;">Rese&ntilde;as:</label>
                                    <label id="txtAReseniaE"></label>
                                    <!--<textarea class="form-control" rows="4" cols="17" id="txtAReseniaE" readonly="true" disabled></textarea>-->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 7px;">
                                    <label style="color: #b7adad;">Anotaciones:</label>
                                    <label id="txtDescripcionE"></label>
                                    <!--<textarea rows="4" cols="17" disabled id="txtDescripcionE" class="form-control" readonly="true"></textarea> -->
                                </div>
                            </div>
                            <div class="row" id="divImagenNac">
                            </div>
                            <div class="row" id="divDocuNac">
                            </div>

                        </div>
                    </div>
                    <div class="panel panel-danger">
                        <div class="panel-heading" style="font-weight: bold;">Procesar Solicitud</div>
                        <div class="panel-body">
                            <!-- <form action="vista/upload/uploadF2/processuploadInsPdfEstadoPopup.php" method="post" enctype="multipart/form-data" id="MyUploadFormPdfE">-->
                            <div class="row">
                                <div class="col-md-3" style="margin-top: 4px">
                                    <label> Estados:</label>
                                    <select class="form-control" id="ddlEstadoSol">
                                        <option value="ACT"> Activar </option>
                                        <option value="INI"> Iniciado </option>
                                        <option value="REV"> En Revision </option>
                                        <option value="REC"> Rechazado</option>
                                        <option value="OBS"> Observado</option>
                                        <option value="APR"> Aprobado</option>
                                        <option value="BAJ"> De Baja</option>
                                    </select>
                                </div>

                                <div class="col-md-6" style="margin-top: 7px;">
                                    <label>Comentario:</label>
                                    <textarea rows="2" cols="17" id="txtComentarioE" class="form-control requerido"></textarea>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button id="btnSaveEI" class="btn btn-primary form-control"><span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Procesar Estado </button>&nbsp;
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-danger form-control" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;No Procesar</button>
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-9">
                                    <div id="upload-wrapperE">
                                        <form action="vista/upload/uploadF2/processuploadInsPdfEstadoPopup.php" method="post" enctype="multipart/form-data" id="MyUploadFormPdfE">
                                            <h5 style="text-transform: uppercase;padding-left: 15px;font-weight: bold;">Agregar Certificados del ejemplar: <span class="badge badge-pill badge-warning-tit" id="lblDatoHorsePdfE" style="font-weight: bold;"></span> </h5>

                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-5" style="margin-bottom: 3px;">
                                                        <label id="lblTipoD">Tipo de documento</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4" style="margin-bottom: 3px;">
                                                        <select class="form-control requerido" id="ddlTipoDoc" onchange="tipoDocE()"></select>
                                                    </div>
                                                    <div class="col-md-5" style="margin-bottom: 3px;">
                                                        <input name="pdf_fileE" class="  btn   btn-default " style="width: 100%;" id="pdfInputE" type="file" />
                                                    </div>
                                                    <div class="col-md-3" style="margin-bottom: 3px;display: none;">
                                                        <input type="submit" class="btn   btn-info" id="submit-btn-pdfE" value="&#9650; Subir Certificados" />
                                                    </div>
                                                </div>
                                                <br>
                                            </div>


                                            <input name="idHorsePdf" id="idHorsePdf" type="hidden" value='0' />
                                            <input name="idTipoDocE" id="idTipoDocE" type="hidden" value='1' />
                                            <input name="hidCodigoGenerado" id="hidCodigoGenerado" type="hidden">
                                            <input name="hidFlagEdit" id="hidFlagEdit" type="hidden">
                                        </form>
                                        <div id="outputPdfE" class="table table-responsive" style="width: 100%;"> </div>

                                    </div>
                                </div>
                            </div>
                            <!-- </form>-->
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-center">
                </div>
            </div>
        </div>
    </div>
</div>
</div>