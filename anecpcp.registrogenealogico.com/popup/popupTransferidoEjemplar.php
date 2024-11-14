<script src="modules/poe/vista/upload/js/jquery.form.min.js"></script>
<script src="modules/poe/script/generales/dropdownlist.js"></script>
<script src="modules/poe/script/form5_fase2.js"></script>
<!--<script src="modules/poe//script/generales/loadImagenTra.js"></script>-->
<script src="modules/poe//script/generales/generales.js"></script>
<link rel="stylesheet" type="text/css" href="modules/poe/css/modulo_poe.css">



<style type="text/css">
  .bootstrap-select.btn-group .dropdown-toggle {
      max-width: 500px;
  }
  .modal-dialog-customer-grlEjemplarT{ 
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
<div class="modal fade" id="mvEjemplarTransferencia" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-customer-grlEjemplarT" >
      <div class="modal-content">
        <div class="modal-header">
          <div class="row">
            <div class="col-md-8"><h3 class="modal-title">Reporte de transferencias</h3></div>
            <div class="col-md-4"> <button type="button" class="close" data-dismiss="modal">&times;</button></div>
          </div>
        	
         
        </div>
        
        <div class="modal-body">
          
            <div class="container-fluid">
            
               <div class="row">
                  <div class="col-md-12 cssSubtituloPop" >
                    1. Registro de Transferencias 
                  </div>
                </div>
              <div class="row bgRow">
                  <div class="col-md-4 "   >
                    <label>Ejemplar: <span class="etiqueta">(*)</span></label>
                    <select 
                      id="cboEjemplar"
                      name="cboEjemplar" 
                      class="selectpicker show-tick form-control requeridoLst" 
                      data-live-search="true" 
                      data-size="10"
                      data-width="100%" 
                    >
                    </select>
                  </div>
                  
             
                <div class="col-md-5" >
                    <label>Nuevo Propietario:&nbsp;<span class="etiqueta">(*)</span>&nbsp;<button id="btnAddPropietario"
                        title="Agregar persona a quien se realizará la transferencia." 
                     class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span></button></label>
                    <select 
                      id="cboPropietario"
                      name="cboPropietario" 
                      class="selectpicker show-tick form-control requeridoLst" 
                      data-live-search="true" 
                      data-size="10"
                      data-width="100%" 
                     
                    ></select>
                  </div>
         
                <div class="col-md-3" style="margin-top: 5px;">
                  <label>Fecha de transferencia: <span class="etiqueta">(*)</span></label>
                  <input type="date" id="dtFechaTrans" class="form-control"   max="2050-12-31"/>
                </div>
              
                
               
              </div>
               
              <div class="row bgRow">
                
                <div class="col-md-4">
                    <div id="upload-wrapper">
                         <form action="modules/poe/vista/upload/processuploadTraImg.php" method="post" enctype="multipart/form-data" id="MyUploadForm"> 
                        <label style="font-weight: bold;">Comprobante de Pago (Foto o PDF) tama&ntilde;o : <span class="etiqueta">(*)</span>
                          <span class="badge badge-pill badge-warning-tit" id="lblDatoHorsePdfE" style="font-weight: bold;"></span> </label>
                        <!--
                        <div class="row">
                          <div class="col-md-12" style="margin-bottom: 3px;">-->
                              <input name="image_file" class="  btn  btn-default "   id="imageInput" type="file"  style="width:100%" />
                       <!--   </div>
                        </div> 
                        <div class="row">-->
                          <div class="col-md-2" style="margin-bottom: 3px;display: none;">
                              <input  type="submit" class="btn   btn-primary  " id="submit-btn"  title="cargar imagen del ejemplar"  value="&#9650; Cargar Imagen" / >
                          </div>
                      <!--
                      </div>-->

                 
                        <input name="idHorseT" id="idHorseT" type="hidden" value='0' />
                        <input name="idTipoDocT" id="idTipoDocT" type="hidden" value='3' />
                        <!--<input name="flag" id="flag" type="hidden" value='0'>-->
                        </form>
                       <!--   <div class="row">
                        <div class="col-md-12"     >-->
                            <div id="output"  class="table table-responsive" style="width: 100%;"> </div>
                       <!--   </div>
                        </div>-->
              
                    </div>
                   
                </div>
                <div class="col-md-5">
                  <label>Comentario:</label>
                  <textarea  class="form-control" style="width:100%;" rows="1" cols="17" id="txtAreaComentarioTra"></textarea>
                </div>
                <div class="col-md-3" style="vertical-align: middle;margin-top: 20px;">
                   <button title="registrar nueva transferencia" id="btnSaveT"    class="btn btn-primary pull-left" >
                   <span class="glyphicon glyphicon-floppy-saved"></span>
                   Grabar Transferencia </button>
                   &nbsp;
            <button type="button" id="btnCancelarT" class="btn btn-default" title="Cancelar registro" ><span class="glyphicon glyphicon-repeat"></span>&nbsp;Cancelar</button>
      
                </div>
              </div>
                
              <br>
               <div class="row">
                  <div class="col-md-12 cssSubtituloPop">
                   2.  Mis Transferencias <button id="btnRefreshT" class="btn btn-sm btn-default" title="Refrescar lista">
                    <span class="glyphicon glyphicon-repeat"></span></button>
                  </div>
                </div>
              <div class="row">
                <div class="col-md-12">

                    <table id="grid" class="table row-border table-hover" style="width: 100%;">
                      <thead class="thDataTable">
                        <tr>
                          <th>NUEVO PROPIETARIO</th>
                          <th>EJEMPLAR</th>
                          <th>DOCUMENTO</th>
                          <th>ESTADO</th>
                          <th>FEC. REGISTRO</th>
                          <th>FEC. TRANSFERENCIA</th>
                          <th>COMENTARIO</th>
                          <th>FEC. REVISIÓN</th>
                          <th>...</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
              </div>
            </div>
          
        </div>
        <div class="modal-footer">
         
          <button id="btnImprimirTrans" type="button" class="btn btn-default"> <span class="glyphicon glyphicon-print"></span>
&nbsp;Imprimir</button>
             <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



<div class="modal fade" id="mvNuevoPropietario" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-customer-grlEjemplarNP" >
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Nuevo Propietario</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-md-4">
                    <label>Tipo de Documento: <span class="etiqueta">(*)</span></label>
                    <select class="form-control requeridoLst" id="cboTipoDocumento">
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label>N&uacute;mero de C&eacute;dula: <span class="etiqueta">(*)</span></label>
                    <input type="text" class="form-control requerido" id="txtNumeroCedula">
                  </div>
                  <div class="col-md-4">
                    <label>Nombres: <span class="etiqueta">(*)</span></label>
                    <input type="text" class="form-control requerido" id="txtNombrePropietario">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <label>Apellido Paterno: <span class="etiqueta">(*)</span></label>
                    <input type="text" class="form-control requerido" id="txtApellidoPaternoPropietario">
                  </div>
                  <div class="col-md-4">
                    <label>Apellido Materno: <span class="etiqueta">(*)</span></label>
                    <input type="text" class="form-control requerido" id="txtApellidoMaternoPropietario">
                  </div>
                  <div class="col-md-4">
                    <label>Dirección: </label>
                    <input type="text" class="form-control" id="txtDireccionPropietario">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <label>Correo: </label>
                    <input type="text" class="form-control" id="txtCorreoPropietario">
                  </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button id="btnSaveNP"    class="btn btn-primary " >
              <span class="glyphicon glyphicon-floppy-saved"></span>Grabar </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      
        </div>
      </div>
    </div>
  </div>