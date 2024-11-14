
<script src="script/generales/general.buscar.ejemplar.js"></script>
<script src="script/generales/general.buscar.entidad.js"></script>
<script src="script/consulta/consulta.ejemplar.js"></script>
<div style="float:left;background:#f6f6f6; width:100%; background:url('images/button/barra.png')100% 100% ;"> 
<div style=" float:left; margin-top:10px;  " >
<titulo>
    <span class="glyphicon glyphicon-list-alt" style="color:#04B431;"></span>
    Consulta General de Ejemplares
</titulo>
</div>
<div style=" float:right;  " class="toolButton ">
           
     
    <button id="btnVer"   title="ver..  " class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-search"></span>  
    </button> 
    <button id="btnCancelar"  title="limpiar filtros de busqueda.  " class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
 
</div>
 </div>   
 <hr> 
 <div class="container-fluid breadcrumb table-responsive">
		<div   class="row">
		  <div class="col-md-1">
			<Label>Codigo</Label>
			<input type="text " id="txtCodigo" class="form-control"  />
		  </div>
		  <div class="col-md-1">
			<Label>Prefijo</Label>
			<input type="text " id="txtPrefijo" class="form-control"  />
		  </div>
		   <div class="col-md-4">
			<Label>Nombre</Label>
			<input type="text " id="txtNombre" class="form-control" />
		  </div>
 <div class="col-md-3">
		  <Label>Propietario</Label>
			 <button id="btnGralPropieBus"  class="btn btn-info btn-xs" onclick="return openGrlPropietarioFilter();">
            <span class="glyphicon glyphicon-new-window"></span>
            </button>
            <!--<input type="text" id="txtPropBus" class="form-control"   />
             -->
            <div class="form-control">
          <label id="lblPropBus" ></label>&nbsp;&nbsp;
          <label id="lblBorrarPropBus"  class="cursorHand" title="Quitar selección" style="display: none;color:grey;">X</label>
          <input type="hidden" id="hidIdPropBus" />
          <input type="hidden" id="hidIdEnteBus" />
          </div>
</div>
		   <div class="col-md-3">
		   <Label>Estado</Label>
			<select id="ddlEstado"  class="form-control">
				<option value="">Todos</option>
				<option value="A">Activo</option>
				<option value="I">Inactivo</option>
			</select>  
			<!--<Label>Criadero</Label>
			<input type="text " id="txtCria" class="form-control" />-->
		   </div>
</div>
<div class="row">
<div class="col-md-2">
		  
<Label>Sexo</Label>
			<select id="ddlGenero"  class="form-control">
				<option value="">Todos</option>
				<option value="Y">Yegua</option>
				<option value="P">Potros</option>
			</select>  
	</div>
<div class="col-md-4">
	<div class="col-xs-4">
<Label>Edad desde</Label>
			<input type="number" max="100" min="1" id="txtMin" class="form-control" style="width: 70px;" />  
			 </div>
 <div class="col-xs-4">
<Label>Edad Hasta</Label>
		 
			<input type="number" id="txtMax" class="form-control" style="width:70px;" />
</div>
</div>

</div>

<!-- APLICANDO EL GRID CON JQGRID -->
<table id="grid"></table>
<!-- APLICANDO CONTROLES PAGINACIÓN JQGRID -->
<div id="opc_pag"></div>
	<!--/*	<div>
		 
		     <table id="example" class="hover   stripe  " cellspacing="0" width="100%">
		        <thead>
		            <tr>
		                <th>Id</th>
		                <th>Prefijo</th>
		                <th>Nombre</th>
		                <th>Fecha Nac</th>
		                <th>Fecha Fal</th>
		                <th>Pelaje</th>
		                <th>Lugar Nac</th>
		                <th>Microchip</th>
		                <th>ADN</th>
		                <th>Capado</th>
		                <th>Estado</th>
		            </tr>
		        </thead>
		        
		    </table>
		   
		</div>
      */-->
 <style>     
.modal-dialog-customer-grlEnte { 
max-width : 60% ;
width : 50% ;
}
</style>
  <div class="modal fade" id="mvBuscadorEntidadGrl" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-customer-grlEnte">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">B&uacute;squeda de Entidades</h4>
        </div>
        <div class="modal-body">
  <!--<div style="display:none" id="mvBuscadorEntidadGrl">-->
  <input type="hidden" id="hidOrigenBuscador" />
    <label>Ingrese nombre :</label>
  <input type="text" id="txtBGNombreEntidad" />
    <button id="btnBGBuscarEntidad" class="btn-xs btn-danger"
    onclick="return initDataTableGrlEntidadProp();">Buscar</button>
    <hr>
    <div>
          <table id="gridGralEntidad"></table>
             <!-- APLICANDO CONTROLES PAGINACIÓN JQGRID -->
          <div id="opc_pagGralEntidad"></div>
     </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
 