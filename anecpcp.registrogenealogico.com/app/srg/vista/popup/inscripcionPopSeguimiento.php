<style>
.modal-dialog-log { 
max-width : 100% ;
width : 45% ;
}

.badge1 {
    background-color: #f0ad4e; /*AMARILLO - INICIADO*/
}
.badge2 {
    background-color: #5bc0de; /*CELESTE - REVISION*/
}
.badge3 {
    background-color: #007bff; /*AZUL - OBSERVADO */
}
.badge4 {
    background-color: #28a745; /*VERDE - APROBADO*/
}
.badge5 {
    background-color: #dc3545; /*VERDE - RECHAZADO*/
}
.badge6{
  background-color: #777;/*GRIS - DE BAJA*/
}
</style>
<div id="mvLogSolicitudDeta" class="modal fade">
    <div class="modal-dialog  modal-lg  modal-dialog-log">
        <div class="modal-content " id="divContainer">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">SEGUIMIENTO DE SOLICITUD.</h4>
            </div>
            <div class="modal-body">

<!--<img src="../img/log.png" width="550">-->
            <fieldset style="border: solid 1px #DDD !important;padding: 0 10px 10px 10px; border-bottom: none;">
            <legend>Historial de seguimiento</legend>
            <table id="tbEstado" style="width:100%" >
            
            <tr><div style="text-align: center"><label></label></div></tr>
              
            </table>

            </fieldset>  
             </div>
            <div class="modal-footer">
               
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
   
             </div>
        </div>
    </div>
</div>

 