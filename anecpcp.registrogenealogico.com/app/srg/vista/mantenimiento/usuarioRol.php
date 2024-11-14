<script src="script/mantenimiento/mantenimiento.usuarioRol.js"></script>
<div style="float:left;background:#f6f6f6; width:100%; background:url('images/button/barra.png')100% 100% ;"> 
<div style=" float:left; margin-top:10px;  " >
<titulo>
    <span class="glyphicon glyphicon-list"></span>
    Consulta Usuarios y Roles
</titulo>
</div>
<div style=" float:right;  " class="toolButton ">
      
    <button id="btnNuevo"  title="nuevo.. (Shift + N)" class="btn btn-default btn-lg" >
          <span class="glyphicon glyphicon-file"></span>
    </button>
   </a>        
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
 <div class="container-fluid breadcrumb table-responsive">
 <input type="hidden" id="txtUsuario"  />
  <label>Usuario:</label>
  <select id="ddlUsuarioBus" class="requeridoLst  selectpicker" data-live-search="true" data-size="5" ></select>
  <label>Oficina:</label>
  <select id="ddlOficinaBus" class="requeridoLst selectpicker" data-live-search="true" data-size="5" ></select>


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


<input type="hidden" id="hidActionPopup" />
    <div class="tabla">
     <div class="tfila">  
               
     </div>
     <div class="tfila">
        <div class="tcelda" style="height:10px;">  </div >
        <div class="tcelda"> </div >
        </div >
    <div class="tfila">  
          <input type="text" id="txtCodigo"  style="display: none"  />
          <label>Usuario:</label>
          <select id="ddlUsuario" class="requeridoLst form-control selectpicker" data-live-search="true" data-size="5"   ></select>

          <label>Rol:</label>
          <select id="ddlRol" class="requeridoLst form-control  "   ></select>
           <label>Oficina:</label>
          <select id="ddlOficina" class="requeridoLst form-control  "   ></select>
          <label><input type="checkbox" id="chkEstado"  checked="true"> Estado</label>
    </div>
    <div class="tfila">
      <label>Login:</label>
          <input type="text" id="txtLogin" style=" text-transform:none!important;" />
      <label>Password:</label>
      <input type="password" id="txtPwd" class="password" style=" text-transform:none!important;"  /><input type="checkbox" name="option" value='1' id="check"  />
    </div>
</div>
 </div>
        <div class="modal-footer">
          <button type="button" id="btnSaveUsuarioRol" class="btn btn-primary" >Grabar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    
