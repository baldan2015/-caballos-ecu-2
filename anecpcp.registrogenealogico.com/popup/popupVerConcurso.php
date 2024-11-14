 <!-- Modal -->
 <script src="scripts/concursos.js"></script>
 <style>
     div#seccionAgregar input.form-control, div#seccionAgregar select.form-control{
        text-transform: uppercase;
     }
 </style>
 <div id="mvConcursoEjemplarr" class="modal fade">
     <div class="modal-dialog  modal-lg modal-dialog-customer">
         <div class="modal-content " id="divContainer">
             <div class="modal-header bg-success ">
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <div class="row">
                     <div class="col-md-6">
                         <h4 class="modal-title">
                             <p id="txtejmplar"></p>
                         </h4>
                     </div>
                     <div class="col-md-1">
                         <button title="Agregar resultado a concurso de mi ejemplar" id="btnAgregarConcurso" class="btn btn-primary">
                             <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                             Agregar Resultado
                         </button>

                     </div>
                 </div>

             </div>
             <div class="modal-body">
                 <div id="resultado">
                 </div>
                 <div class="panel panel-default" id="seccionAgregar" style="display: none;">
                     <div class="panel-heading">
                         <div class="row">
                             <div class="col-md-6">
                                 Agregar resultado de concurso
                             </div>
                             <div class="col-md-6" style="text-align: end;">
                                 <button class="btn btn-primary btn-xs" id="btnRegistrar">
                                     <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                                     Registrar</button>
                                 <button class="btn btn-danger btn-xs" id="btnCancelar">
                                     <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                     Cancelar</button>
                             </div>
                         </div>

                     </div>
                     <div class="panel-body">
                         <div class="row">
                             <input type="hidden" id="txtcodejemplar">
                             <input type="hidden" id="txtnomejemplar">
                             <div class="col-md-4">
                                 <label>Concurso: </label>
                                 <select id="selConcurso" class="form-control selectpicker show-tick input-sm" data-live-search="true" data-size="10" data-width="100%">
                                 </select>
                             </div>
                             <div class="col-md-3">
                                 <label>Fecha: </label>
                                 <input type="date" class="form-control" id="txtfecha" disabled>
                             </div>
                             <div class="col-md-5">
                                 <label>Juez: </label>
                                 <input type="text" class="form-control" id="txtjuez" disabled>
                             </div>
                             <div class="col-md-5">
                                 <label>Categoria: </label>
                                 <input type="text" class="form-control" id="txtcategoria">
                             </div>
                             <div class="col-md-5">
                                 <label>Grupo: </label>
                                 <input type="text" class="form-control" id="txtgrupo">
                             </div>
                             <div class="col-md-2">
                                 <label>Puesto obtenido: </label>
                                 <input type="number" class="form-control" id="txtpuesto">
                             </div>
                         </div>
                     </div>
                 </div>

                 <br>
                 <table id="gridConcurso" class="table-responsive  table table-striped table-bordered table-hover  " style="width: 100%;">
                     <thead>
                         <tr>
                             <th>N°</th>
                             <th>CONCURSO</th>
                             <th>FECHA</th>
                             <th>JUEZ</th>
                             <th>CATEGORIA</th>
                             <th>GRUPO</th>
                             <th>PUESTO OBTENIDO</th>
                             <th></th>
                         </tr>
                     </thead>
                 </table>

             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
             </div>
         </div>
     </div>
 </div>