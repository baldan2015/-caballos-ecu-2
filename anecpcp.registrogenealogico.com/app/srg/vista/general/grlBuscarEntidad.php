<style>
.modal-dialog-customer-grlEnte { 
max-width : 60% ;
width : 50% ;
}
</style>
  <div class="modal fade " id="mvBuscadorEntidadGrl" role="dialog">
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
 	
