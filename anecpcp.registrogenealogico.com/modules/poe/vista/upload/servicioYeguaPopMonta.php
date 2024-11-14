 
 <script src="../script/generales/loadPdfMonta.js"></script>
 
<div id="mvNuevoEjemplar" class="modal fade" style="overflow-y: scroll;">
    <div class="modal-dialog  modal-lg">
    <form action="upload/processuploadMontaPdf.php"  method="post" enctype="multipart/form-data" id="MyUploadFormPdf">
        <div class="modal-content " id="divContainerdddddd">
            <div class="modal-header bg-success ">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">REGISTRAR SERVICIO DE MONTA.</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid   " >
                
                              <div class="row" >
                                    <div class="col-md-2">
                                         <label> Yegua   </label>
                                            <label  data-toggle='tooltip' title="ir a buscar mi ejemplar hembra o bajo mi propiedad" id="btnBuscarMadre" class='btnSearchxxxx  btn btn-xs   btn-success glyphicon glyphicon-search' ></label>
                                    </div>
                                    <div class="col-md-7">
                                            <input type="hidden" name="hidCodigoMonta" id="hidCodigoMonta"  />
                                            <input type="hidden" name="hidCodigo" id="hidCodigo"  />
                                            <label class="form-control requeridoLabel" name="txtNombreYegua" disabled  id="txtNombreYegua" ></label>
                                            <input type="hidden" id="hidCodigoYegua" name="hidCodigoYegua" class="requerido"  />
                                            <input type="hidden" id="hesExtTerYegua" name="hesExtTerYegua">
                                    </div>
                                    <div class="col-md-1" ><br>
                                            <label >ADN:</label>
                                    </div>
                                    <div class="col-md-2"> 
                                            <label id="lblADNY" name="lblADNY"  class="form-control" disabled > - </label> 
                                    </div>
                              </div>
                              <div class="row" >
                                    <div class="col-md-2">
                                            <label > Potro&nbsp; </label>
                                            <label  data-toggle='tooltip'title="ir a buscar potro reproductor" id="btnBuscarPadre" class='btnSearchss  btn  btn-xs   btn-success glyphicon glyphicon-search' style="margin-bottom: 5px;"></label>
                                    </div>       
                                    <div class="col-md-7">
                                            <input type="hidden" name="hesExtTerPotro" id="hesExtTerPotro">
                                            <label name="txtNombrePotro" class="form-control requeridoLabel" disabled  id="txtNombrePotro" ></label>
                                            <input name="hidCodigoPotro" type="hidden" id="hidCodigoPotro" class="requerido" />
                                    </div> 
                                       <div class="col-md-1" ><br>
                                            <label >ADN:</label>
                                    </div>      
                                    <div class="col-md-2"> 
                                            
                                            <label id="lblANDP" name="lblANDP" class="form-control" disabled > - </label> 
                                    </div>                  
                              </div>           
                              <div class="row" >
                                    <div class="col-md-6"><br>
                                            <label >Fecha Monta: </label>
                                            <input type="date" id="dtFecMonta" name="dtFecMonta" class="form-control requerido"  onchange="addMonths()"  max="2050-12-31"/>
                                            <br>
                                    </div>

                                    <div class="col-md-6"><br>
                                            <label>Debe parir:</label>
                                            <input type="date" id="dtFecParir" name="dtFecParir" class="form-control"    max="2050-12-31" />
                                            <br>
                                    </div>
                              </div>

                              <div class="row" >
                                    <div class="col-md-12">
                                             <div class="panel panel-success ">
                                                      <div class="panel-heading"> Método Reproductivo </div> 
                                                            <input type='radio' class='cssItem' name='metodo' id='rdbtnMN' value='MN' checked style="margin-left: 13px;" /> <label   for='rdbtnMN' title='Monta Natural' class='thItem'>Monta Natural</label><br>
                                                            <input type='radio' class='cssItem' name='metodo' id='rdbtnSF' value='SF'  style="margin-left: 13px;"/> <label for='rdbtnSF'  title='Semen Seco' class='thItem'>Semen Fresco</label><br>
                                                            <input type='radio' class='cssItem' name='metodo' id='rdbtnSR' value='SR' style="margin-left: 13px;"/> <label for='rdbtnSR' title='Semen Refrigerado' class='thItem'>Semen Refrigerado</label><br>
                                                            <input type='radio' class='cssItem' name='metodo' id='rdbtnSC' value='SC'style="margin-left: 13px;" /> <label  for='rdbtnSC' title='Semen Congelado'  class='thItem'>Semen Congelado</label> 
                                            </div>

                                    </div>
                              </div>        
                               <div class="row" >
                                    <div class="col-md-6">
                                              <ul class="list-group"  >
                                                <li class="list-group-item">
                                                  <label > </label>
                                                   <label for="rdbtnTE" >Transferencia de Embriones</label>
                                                              <div class="material-switch pull-right">
                                                                <input type="hidden" name="txtIsTE" id="txtIsTE">
                                                                    <input name="rdbtnTE" type='checkbox' class='cssItem' id='rdbtnTE' value='TE'  onchange="showInputText()" /> 
                                                                    <label title='Transferencia de Embriones' for="rdbtnTE" class='thItem'></label>
                                                               </div>
                                                </li>
                                           
                                              </ul>
                                    </div>
                                    <div class="col-md-2"> 
                                         <label id="hidIDRec">ID. Receptora: </label>
                                    </div>
                                    <div class="col-md-4">
                                          <input type="text" name="txtIdTE" id="txtIdTE" class="form-control"  >
                                    </div>
                                    <br>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <label id="lblFecEmbrion">Fecha de Embrión</label>
                                  <input type="date" name="dtFecEmbrion" id="dtFecEmbrion" class="form-control"    max="2050-12-31" />
                                </div>
                              </div>
                              <div class="row" id="seccionDocumentos">
                              
                                    <div class="col-md-12">
                                             <div class="panel panel-success ">
                                                      <div class="panel-heading"> Carga de documentos sustentos PDF </div> 
                                                      <!----> <ul class="list-group" id="lblsFront">
                                                        <li class="list-group-item" id="lblAutoYegua" >
                                                          <div class="row">
                                                            <input name="hidFlagEdit" id="hidFlagEdit" type="hidden">
                                                            <div class="col-md-3" id="lblYeguaTexto">
                                                                Autorizacion de Yegua: 
                                                              </div>
                                                              <div class="col-md-4"> 
                                                                <input type="file" name="pdfInputYegua" id="pdfInputYegua" style="width: 100%;"> 
                                                              </div>   
                                                            <div class="col-md-1">
                                                            <a id="aPDFMontaYegua"><img id="imgpdfYegua" class='imgpdf'   src='../../../images/icono/pdf.png' alt='Thumbnail' style=' cursor:pointer; width:30px;'  /></a>
                                                                
                                                              </div>
                                                              <div class="col-md-2" id="lblrdbtnDelYegua" style="text-align: end;">
                                                                Eliminar PDF
                                                              </div>
                                                              <div class="col-md-1" id="divrdbtnDelYegua">
                                                                <div class="material-switch pull-right">
                                                                    <input name="rdbtnDelYegua" type='checkbox' class='cssItem' id='rdbtnDelYegua' value='1'  /> 
                                                                    <label title='Eliminar PDF de Yegua' for="rdbtnDelYegua" class='thItem'></label>
                                                                </div>
                                                              </div>
                                                          </div>
                                                        </li>
                                                        <li class="list-group-item" id="lblAutoPotro">
                                                            <div class="row">
                                                             <div class="col-md-3"  id="lblPotroTexto">
                                                                Autorizacion de Potro: 
                                                              </div>
                                                              <div class="col-md-4">
                                                                <input type="file" accept="application/pdf" name="pdfInputPotro" id="pdfInputPotro" style="width: 100%;">
                                                              </div>
                                                              <div class="col-md-1">
                                                                <a id="aPDFMontaPotro"><img id="imgpdfPotro" class='imgpdf' src='../../../images/icono/pdf.png' alt='Thumbnail' style=' cursor:pointer; width:30px;'  /></a>
                                                              </div>
                                                              <div class="col-md-2" id="lblrdbtnDelPotro" style="text-align: end;">
                                                                Eliminar PDF
                                                              </div>
                                                              <div class="col-md-1" id="divrdbtnDelPotro">
                                                                <div class="material-switch pull-right">
                                                                    <input name="rdbtnDelPotro" type='checkbox' class='cssItem' id='rdbtnDelPotro' value='1'/> 
                                                                    <label title='Eliminar PDF de Potro' for="rdbtnDelPotro" class='thItem'></label>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        </li>
                                                       
                                                      </ul> 
                                                         <div id="outputPdf" style="display: none;">

                                                           </div>
                                            </div>

                                    </div>
                              </div>  
                              
                </div>
            </div> <!--FIN DE MODAL BODY-->
            <div class="modal-footer">
                    <button type="submit"  id="submit" class="btn btn-primary" >Grabar </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
       
             </div>
            </form> 
         </div><!--FIN DE MODAL CONTENT-->
        </div>
  </div>



<div class="modal fade" id="mvBuscadorEjemplarGrl" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-customer-grlEjemplar">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">B&uacute;squeda de Ejemplar</h4>
        </div>
        <div class="modal-body">
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