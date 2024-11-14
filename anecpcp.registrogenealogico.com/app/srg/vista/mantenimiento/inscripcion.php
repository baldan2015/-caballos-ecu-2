<script src="script/generales/general.buscar.ejemplar.js"></script>
<script src="script/generales/general.buscar.entidad.js"></script>
<script src="script/mantenimiento/mantenimiento.ejemplar.js"></script>
<script src="script/mantenimiento/mantenimiento.campeon.js"></script>
<!--<script src="libs/multiselect/multiselect.js"></script>-->
<style type="text/css">
  .bootstrap-select.btn-group .dropdown-toggle {
      max-width: 500px;
  }
</style>

<div style="float:left;background:#f6f6f6; width:100%; background:url('images/button/barra.png')100% 100% ;"> 
<div style=" float:left; margin-top:10px;  " >
<titulo>
    <span class="glyphicon glyphicon-list"></span>
    Bandeja de Ejemplares
</titulo>
</div>
<div style=" float:right;  " class="toolButton ">


      
     
    &nbsp;&nbsp;&nbsp;&nbsp;

   <button id="btnNewRE2"  title="Nuevo registro de ejemplar" class="btn btn-default    " >
   <span class="glyphicon glyphicon-file"></span>&nbsp;Nuevo
    </button>
  
    <button id="btnEditarR"  title="Editar datos de ejemplar. " class="btn btn-default   " >
           <span class="glyphicon glyphicon-pencil"></span>&nbsp;Editar
    </button>
    <button id="btnEliminar"  title="Eliminar ejemplar  " class="btn btn-default   " >
      <span class="glyphicon glyphicon-trash"></span>&nbsp;Eliminar
    </button>
  
      <button id="btnVer"   title="Buscar ejemplares  " class="btn btn-default   " >
    <span class="glyphicon glyphicon-search"></span>&nbsp;Buscar
    </button> 
    <button id="btnCancelar"  title="Reiniciar filtros de busqueda  " class="btn btn-default   " >
    <span class="glyphicon glyphicon-refresh"></span>&nbsp;Cancelar
    </button>

 
     <button id="btnPrintHorse"  title="Imprimir Certificado del Ejemplar" class="btn btn-default  " > 
          <span class="glyphicon glyphicon-print"></span>&nbsp;Certificado
          
    </button>
     <button id="btnPrintHorseTransf"  title="Imprimir Transferencias a Certificado del Ejemplar" class="btn btn-default   " > 
          <span class="glyphicon glyphicon-print"></span>&nbsp;Transfer
          
    </button>
    <button id="btnUpload"  title="Subir imagen del ejemplar" class="btn btn-default     " > 
          <span class="glyphicon glyphicon-open"></span>&nbsp;Imagenes
          
    </button>
    
   <button id="btnFallece"  title="Inactivar ejemplar por fallecimiento" class="btn btn-default   " > 
          <span class="glyphicon glyphicon-ban-circle"></span>&nbsp;Fallece
    </button>
    <button id="btnSuperCamp"  title="Historial de Campeón de Campeones" class="btn btn-default   " > 
          <span class="glyphicon glyphicon-star-empty"></span>&nbsp;Campeonatos
    </button>
 
</div>
 </div>   
     <br><br>
 <div class="container-fluid breadcrumb  ui-widget-content ">
        <div   class="row">
          <div class="col-md-1">
            <Label>Codigo</Label>
            <input type="text " style='width: 110px;' id="txtCodigoBus" class="form-control"  />
          </div>
          <div class="col-md-1">
            <Label>Prefijo</Label>
            <input type="text " id="txtPrefijoBus" class="form-control"  />
          </div>
           <div class="col-md-4">
            <Label>Nombre</Label>
            <input type="text " id="txtNombreBus" class="form-control" />
          </div>
 <div class="col-md-5">
          <Label>Propietario</Label>
            <select id="ddlProps" 
           class="selectpicker show-tick form-control " 
           data-live-search="true" 
           data-size="10"
           data-width="100%"  ></select> 
     
          <input type="hidden" id="hidIdPropBus" />
          <input type="hidden" id="hidIdEnteBus" />
         
</div>
         
</div>
<div class="row">
<div class="col-md-2">
          
<Label>Sexo</Label>
            <select id="ddlGeneroBus"  class="form-control">
                <option value="">Todos</option>
                <option value="Y">Yegua</option>
                <option value="P">Potros</option>
            </select>  
    </div>
<div class="col-md-4">
    <div class="col-xs-4">
<Label>Edad desde</Label>
            <input type="number" max="100" min="1" id="txtMinBus" class="form-control" style="width: 70px;" />  
             </div>
 <div class="col-xs-4">
<Label>Edad Hasta</Label>
         
            <input type="number" id="txtMaxBus" class="form-control" style="width:70px;" />
</div>
</div>


      <div class="col-md-4">
            <Label>Criadero</Label> 
            <select id="ddlCria" class="selectpicker show-tick form-control"  
            data-live-search='true' 
            data-size=10
              data-width="100%"  
            ></select> 
            
</div>
<div class="col-md-2">
          
<Label>Estado</Label>
            <select id="ddlEstadoBus"  class="form-control">
                <option value="">Todos</option>
                <option value="A">Activo</option>
                <option value="I">Inactivo</option>
            </select>  
    </div>

</div> 
<!-- APLICANDO EL GRID CON JQGRID -->
<table id="grid" ></table>
<!-- APLICANDO CONTROLES PAGINACIÓN JQGRID -->
<div id="opc_pag"></div>

<!-- Modal HTML -->
<div id="mvFalleceEjemplar" class="modal fade">
    <div class="modal-dialog  modal-lg modal-dialog-customer-fallece">
        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Registrar Fallecimiento</h4>
                        </div>
                        <div class="modal-body">
                                             <input type="hidden" id="hidActionPopup" />
                                            <label> Ejemplar Fallecido:  </label>
                                             <label id="lblEjemplar" > </label>
                                            
                                            <br/> <br/>  
                                              <label> Fecha:  </label>
                                              <input type="date" id="dtFecha"  class="requerido form-control " />
                                             
                                            <br/> 
                                              
                                                 <label> Motivo:  </label> 
                                                <textarea rows="5" cols="40" id="txtMotivo" class="requerido form-control"  ></textarea> 
                        </div>
                        <div class="modal-footer">
                            <button id="btnSaveFac"    class="btn btn-primary" >Grabar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
               
                        </div>
            </div>
        </div>
    </div>        
 </div >
<!-- Modal HTML -->
<div id="mvSuperCamp" class="modal fade">
    <div class="modal-dialog  modal-lg modal-dialog-customer-fallece">
        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Registro de Ejemplar Campe&oacute;n de Campeones</h4>
                        </div>
                        <div class="modal-body">
                           <input type="hidden" id="hidPrefCamp" />
                           <input type="hidden" id="hidNombCamp" />
                           <input type="hidden" id="hidIdCamp" />
                           <input type="hidden" id="hidPropCamp" />
                           <input type="hidden" id="hidActionPopup" />

                                            <label> Ejemplar:  </label>
                                             <label id="lblEjemplarSC" > </label>
                                            
                                            <br/> <br/>  
                                              <label> A&ntilde;o del Campeonato:  </label>
                                              <input type="number" id="txtAnioCamp"  class="requerido form-control " max="2050" min="1980" />
                                             
                                            <br/> 
                                              
                                                <label for="chkSoloCamp">Sólo Campe&oacute;n </label> 
                                                <input type=checkbox name="chkSoloCamp" id="chkSoloCamp" /> 
                                                <hr/>

                                                <div id="tableLst"></div>
                        </div>
                        <div class="modal-footer">
                            <button id="btnSaveCamp"    class="btn btn-primary" >Grabar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
               
                        </div>
            </div>
        </div>
    </div>        
 </div >
 <!-- Button HTML (to Trigger Modal) -->
<style>
.modal-dialog-customer { 
max-width : 100% ;
width : 90% ;
}
.modal-dialog-customer-fallece{ 
max-width : 50% ;
width : 40% ;
}
.modal-dialog-customer-imagen{ 
max-width : 100% ;
width : 90% ;
}
</style>
<!-- Modal HTML -->
<div id="mvNuevoEjemplar" class="modal fade">
    <div class="modal-dialog  modal-lg modal-dialog-customer">
        <div class="modal-content " id="divContainer">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">..</h4>

                 <div style="float:right; margin-top: -30px; margin-right:40px;">
            
           <input type="text" 
                            id="txtCodigo"  
                            class="form-control" 
                            disabled="disabled" 
                    ><!--disabled="disabled" addon dbs ecu-->
                </div>
                 <div style="float:right; margin-top: -20px;    ">
                 <label  > Codigo:  </label>
                 </div>
               
 
            </div>
            <div class="modal-body">

 
 

<div class="container-fluid table-responsive breadcrumb" >
    <!--  <div class="rowa breadcrumb">
          <div class="col-md-3">
              <div class=" form ">-->
                   
  <table class="tablex" style=" width:100%;" border="0" cellspacing="0" cellpadding="0"  >
      <tr><td>
      <label  > Origen:  </label>
           <select  id="ddlOrigen" class="requeridoLst form-control  ">
                  <option value="0" selected="selected">Seleccione</option> 
                  <option value="N" selected >Nacional</option>
                  <option value="I">Importado</option>
                 <!-- <option value="P">preparativo o base  B - L1</option>
                  <option value="P2">preparativo o base  B - L2</option>
                  <option value="P3">preparativo o base  B - L3</option>
                  <option value="E">Extranjero</option>-->
                </select>
                 </td> 
         <td class="tdSeparate"></td> 
           <td>
           <label>Genero:</label> <select id="ddlGenero" class="requeridoLst form-control  "   >
          <option value="0">Seleccione</option>
          <option value="Y">Yegua</option>
          <option value="P">Potro</option>
          </select>
          <td class="tdSeparate"></td> 
          <td>   <label  > Prefijo:  </label>
          <input type="text" id="txtPrefijo"  class="  form-control requerido"   />
          </td> 
          <td class="tdSeparate"></td> 
          <td> 
          <label  >Nombre: </label>
          <input type="text" id="txtNombre" 
          name="txtNombre" 
          class="requerido form-control"  
          />
          </td>
          <td class="tdSeparate"></td> 
          <td>
          <label>Pelaje:</label>
          <select id="ddlTipoPel" class="  form-control  "   ></select>
          </td> 
          
          </tr>


          <tr>
          <td>
             <label> Departamento Nac. :  </label>  
             <!--form-control requeridoLst-->
          <select id="ddlProvinvia" class="   form-control   "   >
          
          </select>
          </td>
          <td class="tdSeparate"></td> 
          <td>
             <label> Lugar Nac. :  </label>  
          <input type="text" id="txtLugarNac" class="form-control "   /> 

          </td>
         <td class="tdSeparate"></td> 
          <td>
          <label> Fecha Nac. :  </label> 
        
          <input type="date" id="dtFechaNac" class=" form-control requerido "   max="2050-12-31"
          />
          </td> 
            
          <!--<td>
          <label>ADN:</label>
          <input type="text" id="txtAdn" class="requerido form-control"   />
          </td>-->
          <td class="tdSeparate"></td> 
          <td>
          <label>Microchip:</label>
          <input type="text" id="txtMicrochip" class="form-control"   />
          </td>
          <td class="tdSeparate"></td> 
          <td rowspan="2" valign="top">
          <label>Anotaciones:</label>
          <textarea rows="4" cols="17" id="txtDescripcion" class="form-control"></textarea>
          </td>
          </tr>

          <tr>
          <td colspan="3">
          <label>Madre</label>
          <button id="btnBuscarMadre" class="btn btn-default btn-xs" title="IR A BUSCAR MADRES">
          <span class="glyphicon glyphicon-new-window"></span>
          </button>
          <div class="form-control">
          <label id="lblMadre" ></label>&nbsp;&nbsp;
          <label id="lblBorrarMadre"  class="cursorHand" title="Quitar selección" style="display: none;color:grey;">X</label>
          <input type="hidden" id="hidIdMadre" />
          </div>
          </td>
          <td class="tdSeparate"></td> 
          <td  colspan="3">
          <label>Padre</label>
          <button id="btnBuscarPadre" class="btn btn-default btn-xs" title="IR A BUSCAR PADRES">
          <span class="glyphicon glyphicon-new-window"></span>
          </button>
          <input type="hidden" id="hidIdPadre" />
          <div class="form-control">
          <label id="lblPadre" ></label>&nbsp;&nbsp;
          <label id="lblBorrarPadre" class="cursorHand" title="Quitar selección" style="display: none;color:grey;">X</label>
          </div>
          </td>
          <td class="tdSeparate"></td> 
          </tr>
          <tr >
           <td>
            <label> Fecha Fallece: </label> <input type="date" id="txtFecFallece"  class="form-control " min="2000-30-01" max="2050-30-01"  />
           </td> 
<td class="tdSeparate"></td> 
           <td colspan="1" ><label>Motivo Fallece:</label><input type="text" id="txtMotivoFallece"  class="form-control" /></td> 
          <td class="tdSeparate"></td> 
         
            <td colspan="1">
         <div id="trCastrado"  > <label>Fecha  Capado&nbsp;&nbsp; </label>
          <input type="date" name="txtFecCapado" id="txtFecCapado" readonly="true" class="form-control" min="2000-30-01" max="2050-30-01" >
        </div>
          </td>  
 
         <!-- <td class="tdSeparate"></td> 
          <td>
            <label>Microchip:</label>
          <input type="text" id="txtMicrochip" class="form-control"   />

          </td>-->
          <td class="tdSeparate"></td> 
           <td colspan="3" rowspan="2" valign="top">
          <label>Rese&ntilde;as:</label>
 <button id="btnBuscarResenia" class="btn btn-default btn-xs" title="IR A SELECCIONAR RESE&Ntilde;AS">
          <span class="glyphicon glyphicon-new-window"></span>
          </button>
            <textarea class="form-control" rows="4" id="txtAResenia" readonly="true"></textarea>

</td>
          </tr>

          <tr >
           <td>
            <label> Fecha Reg.: </label> <input type="date" id="dtpFechReg"  class="form-control" min="2000-30-01" max="2050-30-01" />
           </td> 
          <td class="tdSeparate"></td> 
           <td colspan="1" ><label>N&uacute;mero de Libro:</label><input type="text" id="txtNumeroLibro"  class="form-control" /></td> 
          <td class="tdSeparate"></td> 
           <td colspan="1" >
          <label>N&uacute;mero de Folio:</label>
                     <input type="text" id="txtNumeroFolio"  class="form-control" /></td> 
           </tr>
           <tr>
           <td>
            <label> Fecha Serv.: </label> <input type="date" id="dtpFechServ"  class="form-control" min="2000-30-01" max="2050-30-01" />
           </td> 
           <td class="tdSeparate"></td>
           <td colspan="3">
            <label> M&eacute;todo reproductivo: </label><span> <select id="ddlMetodo" class="requeridoLst form-control"></select></span>
           </td>
           <td class="tdSeparate"></td>
          <td colspan="1">
           <label>ADN:</label>
          <input type="text" id="txtAdn" class="form-control requerido"   />
          </td>

           </tr>
<!--<tr>
<td colspan="9" >
 <label>Rese&ntilde;as:</label>
<select  id="ddlResenia" class="selectpicker" multiple data-width="100%">
                        <option value="N" data-tokens="N" >Nacional</option>
                        <option value="I" data-tokens="I" >Internacional</option>
                        <option value="P" data-tokens="P" >preparativo o base  B</option>
                        <option value="E" data-tokens="E" >Entranjero</option>
                </select>
</td>
</tr>
-->
 <tr>
  <td colspan="9"> 
  <table border="0" cellpadding="0" cellspacing="0"  style="width: 100%;">
 
                  <tr>
                  <td valign="top" style="width: 48%;" >
                                <div style="margin-top:10px;  width: 100%;">
                                <!--id="grillaPropietario"  table-bordered table table-striped table-bordered  border-collapse:collapse; compact -->
                    <table class=" table-bordered  gridHtmlBGProp " style="width:100%;" border=0 cellspacing="0"  >
                                        <thead>
                                            <tr>
                                                <th><label>Propietarios  </label>
                             <button id="btnGralPropie"  class="btn btn-default btn-xs" title="IR A SELECCIONAR PROPIETARIOS">
                                          <span class="glyphicon glyphicon-new-window"></span>
                             </button></th>
                                                <th style="width: 5%;"></th>
                                            </tr>
                                        </thead>
                                      <tbody></tbody>  
                    </table>
                                 </div>
                               

                  </td>
                  <td   class="tdSeparate"></td>
                  <td   valign="top"  style="width: 48%;">
                           <div style="margin-top: 10px;width: 100%;">
                           <!--id="Criador"  table table-striped table-bordered  compact-->
                                <table class=" table-bordered  gridHtmlBGCri" style="width:100%;" border="0" cellspacing="0" >
                                    <thead>
                                        <tr>
                                            <th> <label>Criadero  </label> &nbsp;
                                    <button id="btnGralCriador"   class="btn btn-default btn-xs" title="IR A SELECCIONAR CRIADORES">
                                        <span class="glyphicon glyphicon-new-window"></span>
                                    </button></th>
                                            <th  style="width: 5%;"></th>
                                        </tr>
                                    </thead>
                                     <tbody></tbody>
                                    </table>
                                    
                            </div> 
                  </td>
                  </tr>
     </table>

</td>
</tr>
</table>     
     </div>


      
  </div>
            <div class="modal-footer">
                <button id="btnSaveNE"    class="btn btn-primary" >Grabar </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
   
             </div>
        </div>
    </div>
</div>

<!-- CARGAR IMAGE-->

 <!-- FIN DE CARGA DE IMAGEN  -->

<!-- Modal -->
<style>
.modal-dialog-customer-grlEjemplar { 
max-width : 60% ;
width : 50% ;
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
            <button id="btnBGBuscarEjemplar" class="btn-xs btn-danger"
            onclick="return initDataTableGrlEjemplar();">Buscar</button>
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
max-width : 60% ;
width : 50% ;
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
    <button id="btnBGBuscarEntidad" class="btn-xs btn-danger"
    onclick="return initDataTableGrlEntidadProp();">Buscar</button>
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
max-width : 70% ;
width : 70% ;
}
</style>
  <div class="modal fade " id="mvBuscadorResenaGrl" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-customer-grlRESE">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">SELECCI&Oacute;N  de Resenas</h4>
        </div>
        <div class="modal-body" >
  <!--<div style="display:none" id="mvBuscadorEntidadGrl">-->
    <div class="row">
    <div class="col-xs-5">
           Rese&ntilde;as Disponibles
           <select name="from[]" multiple="multiple" id="ddlReseniaLeft" size="10" class="form-control   "   ></select>
    </div>
    <div class="col-xs-2">
    <br><br><br>
    <button id="rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
    <button id="leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
    
    </div>
    <div class="col-xs-5">
        Rese&ntilde;as Seleccionadas
        <select name="to[]" id="ddlReseniaRight" class="form-control" size="10" multiple="multiple"></select>
    </div>
    </div>
    
      </div>
        <div class="modal-footer">
        <button id="btnSaveResena"    class="btn btn-primary" >Guardar </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<? 
//require_once("/vista/general/grlBuscarEjemplar.php");  
//require_once("/vista/general/grlBuscarEntidad.php");  
 
?>

 <style type="text/css">
   @media print {
    /* on modal open bootstrap adds class "modal-open" to body, so you can handle that case and hide body */
    body.modal-open {
        visibility: hidden;
    }

    body.modal-open .modal .modal-header,
    body.modal-open .modal .modal-body {
        visibility: visible; /* make visible modal body and header */
    }
    
}

 </style>