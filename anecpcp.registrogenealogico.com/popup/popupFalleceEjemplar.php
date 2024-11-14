<script src="modules/poe/script/generales/dropdownlist.js"></script>
<script src="modules/poe/script/form7_fase2.js"></script>
<!--<script src="modules/poe//script/generales/loadImagenTra.js"></script>-->
<script src="modules/poe//script/generales/generales.js"></script>
<link rel="stylesheet" type="text/css" href="modules/poe/css/modulo_poe.css">



<style type="text/css">
  .bootstrap-select.btn-group .dropdown-toggle {
      max-width: 500px;
  }
  .modal-dialog-customer-grlEjemplarF{ 
max-width : 90% ;
width : 100% ;
}
  .modal-dialog-customer-grlEjemplarNP{ 
max-width : 90% ;
width :70% ;
}
.badge1 {
    background-color: #f0ad4e; /*AMARILLO - INICIADO*/
}
.badge2 {
    background-color: #28a745; /*VERDE - APROBADO*/
}
.badge3 {
    background-color: #dc3545; /*VERDE - RECHAZADO*/
}
.thDataTable {
    font-size: 12px;
    text-transform: uppercase;
    background: #dff0d8 !important;
    color: #3c763d;
}
.cssSubtituloPop{
 height: 30px; 
background: #f5f5f5!important;
text-align: left; 
font-family: Arial Black; 
font-weight: bold; font-size: 15px; 
-webkit-background-clip: text; 
-moz-background-clip: text; 
background-clip: text; 
color: #333; 
text-shadow: 0px 3px 3px rgba(255,255,255,0.4),0px -1px 1px rgba(0,0,0,0.3);
}
.close {
    float: right;
    font-size: 21px;
    font-weight: bold;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    filter: alpha(opacity=20);
    /* opacity: .2; */
}
.bgRow{
  background: #f5f5f5!important;
}
</style>
<div class="modal fade" id="mvEjemplarFallecido" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-customer-grlEjemplarF" >
      <div class="modal-content">
        <div class="modal-header">
            <div class="row">
            <div class="col-md-8"><h3 class="modal-title">Novedades / Reportar Fallecimientos</h3></div>
            <div class="col-md-4"> <button type="button" class="close" data-dismiss="modal">&times;</button></div>
          </div>

         
        </div>
        
        <div class="modal-body">
          
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-12 cssSubtituloPop" >
                    1. Reportar Fallecimiento 
                  </div>
                </div>
              <div class="row bgRow">
                  <div class="col-md-4">
                    <label>Ejemplar: <span class="etiqueta">(*)</span></label>
                    <select 
                      id="cboEjemplarFac"
                      name="cboEjemplarFac" 
                      class="selectpicker show-tick form-control" 
                      data-live-search="true" 
                      data-size="10"
                      data-width="100%">
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label>Fecha de Fallecimiento:<span class="etiqueta">(*)</span></label>
                    <input type="date" id="dtFechaFa" class="form-control requerido"   max="2050-12-31"/>
                  </div>
                  <div class="col-md-3">
                    <br>
                    <button id="btnGrabarF" class="btn btn-sm btn-primary"  title="Reportar fallecimiento">
                    <span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Grabar</button> 
                     <button id="btnCancelarF" class="btn btn-sm btn-default" title="Cancelar registro">
                    <span class="glyphicon glyphicon-repeat"></span>&nbsp;Cancelar</button>  
                   
                  </div>
              </div>
              <br>
               <div class="row">
                  <div class="col-md-12 cssSubtituloPop" >
                    2. Mis Ejemplares Fallecidos <button id="btnRefresh" class="btn btn-sm btn-default" title="Refrescar lista">
                    <span class="glyphicon glyphicon-repeat"></span></button>
                  </div>
                </div>
              <div class="row">
                <div class="col-md-5" style="margin-top:10px !important;  margin-left:10px!important;width: 100%;">
                    <table id="gridF" class="table row-border table-hover" style="width: 100%;">
                      <thead class="thDataTable">
                        <tr>
                          <th>EJEMPLAR</th>
                          <th>FEC. FALLECIMIENTO</th>
                          <th>ESTADO</th>
                          <th>COMENTARIO ANECPCP</th>
                          <th>FECHA REVISIÓN</th>
                          <th>...</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
              </div>
            </div>
          
        </div>
        <div class="modal-footer">
          
           <button id="btnImprimirFa" title="Imprimir" class="btn btn-sm btn-default"  >
                    <span class="glyphicon glyphicon-print"></span> Imprimir
                     </button>

          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>                     
          
        </div>
      </div>
    </div>
  </div>