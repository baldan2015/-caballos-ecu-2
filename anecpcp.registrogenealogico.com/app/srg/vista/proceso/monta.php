<?session_start();
include_once ("entidad/Constantes.php");
?>

<script src="script/mantenimiento/mantenimiento.monta.js"></script>
<script src="vista/upload/js/jquery.PrintArea.js"></script>
<script src="vista/upload/js/jquery.form.min.js"></script>
<style type="text/css">
  .bootstrap-select.btn-group .dropdown-toggle {
      max-width: 500px;
  }
</style>

<div style="float:left;background:#f6f6f6; width:100%; background:url('images/button/barra.png')100% 100% ;"> 
<div style=" float:left; margin-top:10px;  " >
<titulo>
    <span class="glyphicon glyphicon-list"></span>
    Recepción Servicios de Montas
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
    <button id="btnBuscar"   title="Buscar Monta" class="btn btn-default   " >
    <span class="glyphicon glyphicon-search"></span>&nbsp;Buscar
    </button> 
    <button id="btnCancelarMon"   title="Reinicia búsqueda  " class="btn btn-default   " >
    <span class="glyphicon glyphicon-refresh"></span>&nbsp;Cancelar
    </button> 
     <button id="btnPrint"  title="Imprimir" class="btn btn-default  " > 
          <span class="glyphicon glyphicon-print"></span>&nbsp;Imprimir
    </button>
    <button id="btnApro"  title="Aprobaciones" class="btn btn-default  " > 
          <span class="glyphicon glyphicon-list-alt"></span>&nbsp;Ver Aprobaciones
    </button> 
      </div>
</div>




 </div>   
     <br>
 <div class="container-fluid breadcrumb  ui-widget-content ">
        <div   class="row">
          <div class="col-md-1">
            <Label>Estado</Label>
            <select  id="cboEstadoMonta" class="form-control">
              <option value="0">Todos</option>
              <option value="CON">CONFIRMADO</option>
              <option value="PEN">POR CONFIRMAR</option>
              <option value="REC">RECHAZADO</option>
            </select>
          </div>
          <div class="col-md-1">
            <Label>Año Monta</Label>
            <input type="text "  id="txtAnioBus" class="form-control"  />
          </div>
          <div class="col-md-1">
            <Label>Mes Monta</Label>
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
          <div class="col-md-2">
            <Label>Situación</Label>
            <select  id="cboSituacion" class="form-control">
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>     
</div>

<table id="grid" ></table>

<div id="opc_pag"></div>
<!-- Modal HTML -->     
 </div >
<!-- Modal HTML -->



<?
require("vista/popup/montaPopAprobaciones.php");
require("vista/popup/popupExtranjeroMonta.php");
require("vista/popup/popupDocumentosMonta.php");
//require("vista/popup/inscripcionPopSeguimiento.php");
//require("vista/popup/printInscripcionEjemplar.php");
//require("vista/popup/inscripcionPopEstado.php");
?>

