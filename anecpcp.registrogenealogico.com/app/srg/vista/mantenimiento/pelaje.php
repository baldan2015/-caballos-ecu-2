<script src="script/mantenimiento/mantenimineto.pelaje.js"></script>
<style>
.mv-customer-pelaje { 
max-width : 100% ;
width : 90% ;
}
</style>
<div style="float:left;background:#f6f6f6; width:100%; background:url('images/button/barra.png')100% 100% ;"> 
<div style=" float:left; margin-top:10px;  " >
<titulo>
    <span class="glyphicon glyphicon-list"></span>
    Mantenimiento de Pelaje
</titulo>
</div>
<div style=" float:right;  " class="toolButton ">
   
    <button id="btnNuevo"  title="nuevo.. (Shift + N)" class="btn btn-default btn-lg" >
          <span class="glyphicon glyphicon-file"></span>
    </button>
    <button id="btnEditar"  title="editar.. (Shift + U)" class="btn btn-default btn-lg" >
           <span class="glyphicon glyphicon-pencil"></span>
    </button>
    <button id="btnEliminar"  title="eliminar.. (Shift + D)" class="btn btn-default btn-lg" >
      <span class="glyphicon glyphicon-trash"></span>
    </button>
    <button id="btnVer"   title="ver.. (Shift + V)" class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-search"></span>
    </button>
    <button id="btnCancelar"  title="regresar pantalla. (Shift + R)" class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
 
</div>
 </div>    
<div class="container-fluid breadcrumb table-responsive" style="margin-top:45px;">
<label> Nombre de Pelaje:  </label>
 <input type="text" id="txtPelaje"   style="width:280px;" class=" form-control" />

<!-- APLICANDO EL GRID CON JQGRID -->
<table id="grid"></table>
<!-- APLICANDO CONTROLES PAGINACIÓN JQGRID -->
<div id="opc_pag"></div>


</div>
<div class="modal fade" id="dialogNuevo" role="dialog">
    <div class="modal-dialog modal-xs ">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
<div id="___dialogNuevo">
<input type="hidden" id="hidActionPopup" />
    <div class="tabla">
     <div class="tfila">  
        <div class="tcelda"><label> Codigo:  </label></div>
        <div class="tcelda"><input type="text" id="txtCodigo" style="width:80px;" class="form-control" disabled /></div>
     </div>
     <div class="tfila">
        <div class="tcelda" style="height:10px;">  </div >
        <div class="tcelda"> </div >
        </div >
    <div class="tfila">  
        <div class="tcelda"><label> Nombre:  </label></div>
        <div class="tcelda"><input type="text" id="txtNombre" class="requerido form-control"  style="width:280px;"  /></div>
    </div>
    </div>
 </div>
 </div>
        <div class="modal-footer">
          <button type="button" id="btnSavePelaje" class="btn btn-primary" >Grabar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>