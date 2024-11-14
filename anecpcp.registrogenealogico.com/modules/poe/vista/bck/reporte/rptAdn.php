<script src="script/generales/general.buscar.ejemplar.js"></script>
<script src="script/generales/general.buscar.entidad.js"></script>
<script src="script/reporte/reporte.adn.js"></script>
<!--<script src="script/mantenimiento/mantenimiento.campeon.js"></script>
<script src="libs/multiselect/multiselect.js"></script>-->
<style type="text/css">
  .bootstrap-select.btn-group .dropdown-toggle {
      max-width: 500px;
  }
</style>

<div style="float:left;background:#f6f6f6; width:100%; background:url('images/button/barra.png')100% 100% ;"> 
<div style=" float:left; margin-top:10px;  " >
<titulo>
    <span class="glyphicon glyphicon-list-alt" style="color:#04B431;"></span>
    Reporte ADN  de Ejemplares
</titulo>
</div>
<div style=" float:right;  " class="toolButton ">
 
      <button id="btnVer"   title="Buscar ADN de ejemplares  " class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-search"></span>  
    </button> 
     <button id="btnXls"  title="Exportar Datos a Excel" class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-export"></span>
    </button>
    <button id="btnCancelar"  title="Reiniciar filtros de busqueda  " class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
&nbsp;&nbsp;
      <button id="btnClsTmp"  title="Eliminar reporte temporal de ADN" class="clsListTMP btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-remove"></span>
    </button>
 
</div>
 </div>   
 <div class="container-fluid breadcrumb table-responsive ">
<div   class="row">
          <div class="col-md-1">
            <Label>Codigo</Label>
            <input type="text " style='width: 100px;' id="txtCodigoBus" class="form-control"  />
          </div>
           <div class="col-md-2">
            <Label>Nombre</Label>
            <input type="text " id="txtNombreBus" class="form-control" />
          </div>


          <div class="col-md-1">
            <Label>Id Padre</Label>
            <input type="text " style='width: 100px;' id="txtIdPadBus" class="form-control"  />
          </div>
           <div class="col-md-2">
            <Label>Nombre Padre</Label>
            <input type="text " id="txtNomPadBus" class="form-control" />
          </div>
           <div class="col-md-1">
            <Label>Id Madre</Label>
            <input type="text " style='width: 100px;' id="txtIdMadBus" class="form-control"  />
          </div>
           <div class="col-md-3">
            <Label>Nombre Madre</Label>
            <input type="text " id="txtNomMadBus" class="form-control" />
          </div>

  
</div>
 
<div class="row"> 
   <div class="col-md-5">
    <Label> Propietario</Label>
   <select id="ddlProps" 
           class="selectpicker show-tick " 
           data-live-search="true" 
           data-size="10"
           data-width="auto"  ></select> 
          
          <input type="hidden" id="hidIdPropBus" />
          <input type="hidden" id="hidIdEnteBus" />
        </div>
</div>
 
<!-- APLICANDO EL GRID CON JQGRID -->
<table id="grid" ></table>
<!-- APLICANDO CONTROLES PAGINACIÓN JQGRID -->
<div id="opc_pag"></div>

   </div></div> 
 
    

    <div class="modal fade" id="mvListaAdn" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-customer-grlEjemplar">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Información Temporal a Exportar</h4>
        </div>
        <div class="modal-body">
          
                      <!-- APLICANDO EL GRID CON JQGRID -->
            <table id="grid_mv" ></table>
            <!-- APLICANDO CONTROLES PAGINACIÓN JQGRID -->
            <div id="opc_pag_mv"></div>

        </div>
          
        <div class="modal-footer">
          
          <button type="button" class="btn btn-primary" id="btnTmpXls"  >Exportar Lista</button>
          <button type="button" class="clsListTMP btn btn-danger" id="btnCancelTmpXls"  >Eliminar Lista</button>
          &nbsp;&nbsp;
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>