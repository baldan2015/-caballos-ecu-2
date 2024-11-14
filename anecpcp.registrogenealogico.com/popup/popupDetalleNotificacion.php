
<!--
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="libs/bootstrap-3.3.7/js/bootstrap.js"></script>
<link href="libs/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet"/>
-->


<div class="modal fade" id="mvDetalleNoti" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-customer-grlEjemplar">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Detalle de Notificacion para socio</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-md-12">
                    <label  id="lblTexto" ></label>
                    <input type="hidden" id="txtCodigoNoti" />
                    <input type="hidden" id="txtCodigoProp" />
                 </div>  
                 <div class="col-md-12" id="divNoti">
                    <br>
                     <label id="lblFechaRegistro"></label><br><br>
                    <label id="lblMensajeConfirmacion"></label>
                 </div> 
             </div> 
            
        </div>
            <div class="modal-footer">
          <button type="button" id="btnAprobarD" class="btn btn-primary" data-dismiss="modal" onclick="flagA(1)">Aprobar</button>
          <button type="button" id="btnRechazarD" class="btn btn-danger" data-dismiss="modal" onclick="flagR(2)">Rechazar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
      </div>
    </div>
  </div>

 