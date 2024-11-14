<style>
.modal-dialog-log { 
max-width : 80% ;
width : 43% ;
}

.badge1 {
    background-color: #f0ad4e; /*AMARILLO - INICIADO*/
}
.badge2 {
    background-color: #6c757d; /*PLOMO - REVISION*/
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
</style>
<div id="mvLogDetaAprobacion" class="modal fade">
    <div class="modal-dialog  modal-lg  modal-dialog-log">
        <div class="modal-content " id="divContainer">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">VER APROBACIÓN</h4>
            </div>
            <div class="modal-body">

<!--<img src="../img/log.png" width="550">-->
            <fieldset style="border: solid 1px #DDD !important;padding: 0 10px 10px 10px; border-bottom: none;">
            <legend>Detalle de aprobación</legend>
            <!--<table id="tbDetalle" style="width:100%" >
            
            <tr><div style="text-align: center"><label></label></div></tr>
             
            </table>-->
            <div class="container-fluid" >
                <div class="row">
                    <div class="col-md-4">
                        <label id="lblSocioP" >Responsable de Potro:</label>
                        
                    </div>

                    <div class="col-md-3">
                        <label id="lblNombreSocioPotro" ></label>
                    </div>

                    <div class="col-md-2">
                        <label id="lblEstadoMontaPotro" ></label>
                    </div>

                    <div class="col-md-3">
                        <label id="lblFechayHoraPotro" ></label>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <label id="lblSocioY" >Responsable de Yegua:</label>
                        
                    </div>

                    <div class="col-md-3">
                        <label id="lblNombreSocioYegua"></label>
                    </div>

                    <div class="col-md-2">
                        <label id="lblEstadoMontaYegua" ></label>
                    </div>

                    <div class="col-md-3">
                        <label id="lblFechayHoraYegua"></label>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-9">
                        <label id="lbltexto" style='text-align:center'></label>
                    </div>
                    <div class="col-md-3">
                        <label id="lbltextoFecha" style='text-align:center'></label>
                    </div>
                </div>
            </div>
            </fieldset>  
             </div>
            <div class="modal-footer">
               
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
   
             </div>
        </div>
    </div>
</div>

 