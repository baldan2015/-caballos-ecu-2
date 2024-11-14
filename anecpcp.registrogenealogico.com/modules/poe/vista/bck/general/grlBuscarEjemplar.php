
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
					<!--	<div style="display:none" id="mvBuscadorEjemplarGrl">-->
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
 	