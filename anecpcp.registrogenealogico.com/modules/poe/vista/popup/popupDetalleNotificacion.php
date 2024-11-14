
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
            
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle de Notificacion para socio</h4>


        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-md-12" style="font-size: 13px;">
                    <label  id="lblTexto" ></label>
                    <input type="hidden" id="txtCodigoNoti" />
                    <input type="hidden" id="txtCodigoProp" />
                 </div>  
                 <div class="col-md-12" id="divNoti" style="font-size: 13px;">
                    <br>
                     <label id="lblFechaRegistro"></label><br><br>
                    <label id="lblMensajeConfirmacion"></label>
                 </div> 
             </div> 
            
        </div>
            <div class="modal-footer">
          <button type="button" id="btnAprobarD" class="btn btn-primary" data-dismiss="modal" onclick="flagA(1)">
          <span class='glyphicon glyphicon-thumbs-up'></span> 
          Aprobar</button>
          <button type="button" id="btnRechazarD" class="btn btn-danger" data-dismiss="modal" onclick="flagR(2)">
          <span class='glyphicon glyphicon-thumbs-down'></span>Rechazar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
      </div>
    </div>
  </div>

 