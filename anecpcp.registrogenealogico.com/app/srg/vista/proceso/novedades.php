<?session_start();
include_once ("entidad/Constantes.php");
?>
<script src="script/generales/general.buscar.ejemplar.js"></script>
<script src="script/generales/general.buscar.entidad.js"></script>
<script src="script/mantenimiento/mantenimiento.novedades.js"></script>
<!--<script src="script/mantenimiento/mantenimiento.campeon.js"></script>-->
<!--<script src="libs/multiselect/multiselect.js"></script>-->
<script src="vista/upload/js/jquery.PrintArea.js"></script>
<script src="vista/upload/js/jquery.form.min.js"></script>
<style type="text/css">
  .bootstrap-select.btn-group .dropdown-toggle {
      max-width: 500px;
  }
  .ajs-input{
    width: 500px;
  }
  .ajs-ok{

    color: #fff;
    background-color: #428bca;
  }
  .etiqueta{
    color: red;
  }
</style>

<div style="float:left;background:#f6f6f6; width:100%; background:url('images/button/barra.png')100% 100% ;"> 
<div style=" float:left; margin-top:10px;  " >
<titulo>
    <span class="glyphicon glyphicon-list"></span>
    Bandeja de Reportes de Novedades
</titulo>
</div>
<div style=" float:right; margin-top: 5px; " class="toolButton ">


      <STYLE>

        .cvteste {
            color: blue !important;
        }

</STYLE>
   
    &nbsp;&nbsp;&nbsp;&nbsp;

    
    <input type="hidden" id="hidIdUsu" value="<?=$_SESSION[Constantes::K_SESSION_CODIGO_USUARIO]?>">
    <div class="btn-group" role="group" aria-label="...">
      <button id="btnBuscar"   title="Buscar ejemplares  " class="btn btn-default   " >
    <span class="glyphicon glyphicon-search"></span>&nbsp;Buscar
    </button> 
    <button id="btnCancelarNov"   title="Reinicia búsqueda  " class="btn btn-default   " >
    <span class="glyphicon glyphicon-refresh"></span>&nbsp;Cancelar
    </button> 
     <button id="btnPrint"  title="Imprimir" class="btn btn-default  " > 
          <span class="glyphicon glyphicon-print"></span>&nbsp;Imprimir
    </button>
      </div>
</div>




 </div>   
     <br><br>
 <div class="container-fluid breadcrumb  ui-widget-content " >
        <div   class="row">
          <div class="col-md-2">
            <Label class="lblAnio">Año Castración</Label>
            <input type="text "  id="txtAnioBus" class="form-control"  />
          </div>
          <div class="col-md-2">
            <Label  class="lblMes">Mes Castración</Label>
            <input type="text " id="txtMesBus" class="form-control"  />
          </div>
 <div class="col-md-3">
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
<br>
<ul class="nav nav-tabs">
  <li class="active"><a href="#menu1" id="castracion">Castraciones&nbsp;<span id="cantCap" class="badge badge-success"></span></a></li>
  <li ><a href="#menu2" id="fallecido">Fallecimientos&nbsp;<span id="cantFall" class="badge badge-success"></span></a></li>
  <li ><a href="#menu3" id="transferido">Transferencias&nbsp;<span id="cantTran" class="badge badge-success"></span></a></li>
</ul>  

<div class="tab-content" id="tabs">
    <div id="menu1" class="tab-pane fade in active">
      
      <!--<table id="grid" style="width: 100%;"></table>
      <div id="opc_pag"></div>-->
    </div>
    <div id="menu2" class="tab-pane fade">
     
      <!--<table id="grid2" style="width: 100%;" ></table>
      <div id="opc_pag2"></div>-->
    </div>
    <div id="menu3" class="tab-pane fade">
      
     <!--<table id="grid3" style="width: 100%;" ></table>
      <div id="opc_pag3"></div>-->
    </div>
  </div>  

<table id="grid" ></table>
<div id="opc_pag"></div>

<table id="gridTransfer" ></table>
<div id="opc_pagTransfer"></div>

<!-- Modal HTML -->     
 </div >
<!-- Modal HTML -->

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
.modal-dialog-customer{ 
max-width : 100% ;
width : 90% ;
}
</style>
<!-- Modal HTML -->


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



<div id="mvNovedades" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg  modal-dialog-log" role="document">
        <div class="modal-content " id="divContainer">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">SRG::CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-md-12" style="margin-top: 7px;">
                    <span id="txtMensaje"></span>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-4" style="margin-top: 10px;">
                    <input type="hidden" id="hidKey">
                    <input type="hidden" id="hidAccion">
                    <input type="hidden" id="hidFlag">
                    <label id="lbltextoFecha"> </label>
                    <input type="date" id="dtFechaNov" class=" form-control requerido "   max="2050-12-31"/>
                  </div>
                  <div class="col-md-7" style="margin-top: 10px;">
                    <label id="lblTextoMotivo"></label>
                    <textarea id="txtAreaComentario" rows="2" cols="15" class="form-control requerido">
                      
                    </textarea>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success"  id="btnGrabarNovedad"><span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Procesar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
   
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
                    <input type="hidden" id="hidIdNewProp">
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
            <button id="btnSaveNP"    class="btn btn-primary " >Grabar </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      
        </div>
      </div>
    </div>
  </div>


<?
require("vista/upload/uploadF2/inscripcionPopImgEjemplar.php");
require("vista/upload/uploadF2/inscripcionPopPdfEjemplar.php");
require("vista/popup/inscripcionPopSeguimiento.php");
require("vista/popup/printInscripcionEjemplar.php");
require("vista/popup/inscripcionPopEstado.php");
?>

