<div id="mvEjemplarExtranjero" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">B&Uacute;SQUEDA DE EJEMPLARES</h4>
      </div>
      <div class="modal-body">
  

<div id="formEjemplarExt"> <table  class="table " >
  <tr>
    <td>
      <input type="hidden" id="hidCtrolId" />
      <label>Código</label>
      <input type="text" class="form-control requeridoE"  id="txtCodigoExt" >
    </td>
    <td>
      <label>Nombre</label>
      <input type="text" class="form-control requeridoE" id="txtNombreExt" >
    </td>
    <td>
      <label>Prefijo</label>
      <input type="text" class="form-control " id="txtPrefijoExt" >
    </td>
  </tr>
  <tr>
    <td>
      <label>Fecha Nac.</label>
      <input type="date" class="form-control " id="dtpFechaNacExt" >
    </td>
    <td>
    <label>Pelaje</label>
    <select class="   form-control   " id="ddlIdPelaje">
    </select>
     </td>
     <td>
    <label>Pais</label>
    <select class="   form-control   " id="ddlIdPais">
    </select>
    <input type="hidden" id="hidGenero">
     </td>
   </tr>
     <tr>
      <td><button type="button" 
        class="btn btn-primary btn-sm" 
        data-toggle='tooltip' 
        title="Registrar ejemplar extranjero" 
        onclick="updateDatosEjemplar()">
  <span class="glyphicon glyphicon-floppy-saved" ></span>
      Guardar</button>
      <button type="button" class="btn btn-default btn-sm" onclick="Cancelar()">Cancelar</button></td>
      
    </tr>
</table></div> 
<!--<div id='divResultBG' style=" overflow-y:scroll;overflow-x: hidden; height: 400px;" > </div>-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>