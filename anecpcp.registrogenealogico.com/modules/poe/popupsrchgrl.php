<div id="divBuscarEjemplar" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">B&Uacute;SQUEDA DE EJEMPLARES</h4>
      </div>
      <div class="modal-body">
  <input type="hidden" id="hidCtrolId" />
	<input type="hidden" id="hidCtrolName" />
	<input type="hidden" id="hidTipoParents" />
<label>Ingrese nombre Ejemplar:</label>
<input type="text" id="txtBGNombre" class="form-controls" />
<button id="btnBGBuscar" class="btn btn-success btn-sm " title="Realizar busqueda" data-toggle='tooltip' ><span class="glyphicon glyphicon-search"></span></button> 
<input type='radio' class='cssItem' name='filtro' id='rdbtnProp' value='MP' onchange="addEjemplarExt()" checked style="margin-left: 13px;" /> <label  for='rdbtnProp' title='Mi propiedad' class='thItem' id="lblPropiedad">Mi propiedad</label>
<input type='radio' class='cssItem' name='filtro' id='rdbtnOT' value='OT' onchange="addEjemplarExt()" /> <label  for='rdbtnOT' title='Otros' class='thItem' id="lblOtros">Otros</label>
<input type='radio' class='cssItem ' name='filtro' id='rdbtnEE' value='EE' onchange="addEjemplarExt()" /> <label  for='rdbtnEE' title='Ejemplares Extranjeros' class='thItem' id="lblExtranjero">Ejemplares Extranjeros</label>
<button id="btnAgregarExt" class="btn btn-primary btn-sm "   title="Agregar ejemplar extranjero." data-toggle='tooltip' onclick="addExtranjero()">
  <span class="glyphicon glyphicon-plus" ></span>
</button>
<br>&nbsp;&nbsp;<span style="font-size: xx-small;">(*)Dejar vacio el nombre del ejemplar para listar ejemplares de su propiedad</span>
<hr>
 

<div id="divBody" class="panel-body">
     <!--<div class="panel-heading">Ejemplares   <span class="badge badge-success" id="lblCantidadSol">0</span>-->
    <table id="gridBusquedaEjemplar" class="table  row-border table-hover" style="width:100%">
      <thead>
      <tr>
      <th>Codigo</th>
      <th>Pref.</th>
      <th>Nombre de Ejemplar</th>
      <th>Fec. Nac</th>
      <th>Estado</th>
      <!--<th>Padre Caballo</th>
      <th>Madre Caballo</th>-->
      <th>Propietario</th>
      <th>Criador</th>
      <th>Selección</th>
      </tr>
      </thead>
      <tbody id="filasBody">

      </tbody>
    </table>
</div>


<div id="formEjemplarExt"> <table  class="table" >
  <tr>
    <!--<td>
      <label>Código</label>
      <input type="text" class="form-control" id="txtCodigoExt" >
    </td>-->
    <td>
      <label>Nombre <span class="etiqueta">(*)</span></label>
      <input type="text" class="form-control requeridoE" id="txtNombreExt" >
    </td>
    <td>
      <label>Prefijo <span class="etiqueta">(*)</span></label>
      <input type="text" class="form-control requeridoE" id="txtPrefijoExt" >
    </td>
    <td>
      <label>Fecha Nac.</label>
      <input type="date" class="form-control " id="dtpFechaNacExt" >
    </td>
  </tr>
  <tr>
    
    <td>
    <label>Pelaje</label>
    <select class="form-control" id="ddlIdPelaje">
    </select>
     </td>
     <td >
    <label>Pais</label>
    <select class="form-control" id="ddlIdPais">
    </select>
    <input type="hidden" id="hidGenero">
     </td>
     <td>
       <label>Origen</label>
       <input class="form-control" type="text" id="codOrigen">
     </td>
   </tr>
     <tr>
      <td colspan="5">
        <button type="button" class="btn btn-primary btn-sm" data-toggle='tooltip' title="Registrar ejemplar extranjero" onclick="saveEjemplarExt()">
  <span class="glyphicon glyphicon-floppy-saved"></span>
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