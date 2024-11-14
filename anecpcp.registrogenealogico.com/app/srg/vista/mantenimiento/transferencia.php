<script src="script/mantenimiento/mantenimiento.transferencia.js"></script>
<script src="script/generales/general.buscar.ejemplar.js"></script>
<script src="script/generales/general.buscar.entidad.js"></script>
<div style="float:left;background:#f6f6f6; width:100%; background:url('images/button/barra.png')100% 100% ;"> 
    <div style=" float:left; margin-top:10px;  " >
    <titulo>
        <span class="glyphicon glyphicon-list"></span>
        Transferencias
    </titulo>
    </div>
    <div style=" float:right;  " class="toolButton ">
    <div class="btn-group" role="group" aria-label="...">
       <button id="btnVer"   title="buscar ejemplares  " class="btn btn-default  " >
           <span class="glyphicon glyphicon-search"> Buscar</span>  
    </button>
        <button id="btnNuevo"  title="nuevo.. (Shift + N)" class="btn btn-default " >
              <span class="glyphicon glyphicon-file"> Nuevo</span>
        </button>    

       

        
        <button id="btnEditar"  title="editar.. (Shift + U)" class="btn btn-default  " >
               <span class="glyphicon glyphicon-pencil"> Editar</span>
        </button>
        
        <button id="btnEliminar"  title="eliminar.. (Shift + D)" class="btn btn-default " >
          <span class="glyphicon glyphicon-trash"> Eliminar</span>
        </button>
        <!--
        <button id="btnVer"   title="ver.. (Shift + V)" class="btn btn-default btn-lg" >
        <span class="glyphicon glyphicon-search"></span>
        </button>
        -->

         <button id="btnPrint"  title="Imprimir Voucher de Transferencia" class="btn btn-default " > 
          <span class="glyphicon glyphicon-print"> Imprimir</span>
          
    </button>

        <button id="btnCancelar"  title="regresar pantalla. (Shift + R)" class="btn btn-default " >
        <span class="glyphicon glyphicon-refresh"> Cancelar</span>
        </button>

</div>
    </div>
 </div>    

    <!--table table-striped table-bordered  compact -->


<div class="container-fluid breadcrumb table-responsive">
    <div   class="row">
    <div class="col-md-1">
            <Label>ID Transf</Label>
            <input type="text" id="txtIdBus" class="form-control"  />
        </div>
       <div class="col-md-2">
            <Label>Codigo Ejemplar</Label>
            <input type="text" id="txtCodigoBus" class="form-control"  />
        </div>
        <div class="col-md-1">
            <Label>Prefijo</Label>
            <input type="text" id="txtPrefijoBus" class="form-control"  />
        </div>
        <div class="col-md-2">
            <Label>Ejemplar</Label>
            <input type="text" id="txtEjemplarBus" class="form-control"  />
        </div>
        <div class="col-md-3">
            <Label>Nuevo Propietario</Label>
              <button id="btnGralPropieBus"  class="btn btn-default btn-xs">
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
        <div class="col-md-2">
            <Label>Fecha</Label>
            <input type="date" id="txtFechaBus" size="10" class="form-control"  />
        </div>
    </div>


<!-- APLICANDO EL GRID CON JQGRID -->
<table id="grid"></table>
<!-- APLICANDO CONTROLES PAGINACIÓN JQGRID -->
<div id="opc_pag"></div>
</div>
<div class="modal fade" id="dialogNuevo" role="dialog">
    <div class="modal-dialog modal-lg ">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
<div id="____dialogNuevo">
    <input type="hidden" id="hidActionPopup" />
    <input type="hidden" id="hidId" value="0" />
    <div >
          
          <div class="row">
                <div class="col-md-6 breadcrumb  ">
                    <label>Búsqueda de Ejemplar</label> &nbsp;
                    <button id="btnEjemplar" class="btn btn-default btn-xs ">
                        <span class="glyphicon glyphicon-new-window"></span>
                    </button>
                    <div class="form-control   "  style="background: lavender !important;">
                        <label id="lblEjemplar" ></label>&nbsp;&nbsp;
                        <label id="lblBorrarEjemplar"  class="cursorHand" title="Quitar selección" style="display: none;color:grey;"></label>
                        <input type="hidden" id="hidIdEjamplar" value="" />
                    </div>
             </div>
          
                <div class="col-md-6 breadcrumb ">
                    <label>Propietario</label> &nbsp;
                    <div class="form-control" style="background: lavender !important;">                        
                        <label id="lblPropietario" ></label>&nbsp;&nbsp;
                        <input type="hidden" id="hidIdPropAntiguo" value="1" />
                        <input type="hidden" id="hidIdCriadorAntiguo" value="1" />
                    </div>
                </div>
           </div>
    <div class="row">
                <div class="col-md-6  breadcrumb">
                    <label>Fecha Registro</label> &nbsp;                                      
                    <input type="date" id="txtFecha" size="5" class="requerido form-control" />
                </div>   
                <div class="col-md-6  breadcrumb">
                  <label>Fecha Transf.</label> &nbsp;                                      
                    <input type="date" id="txtFechaTransf" size="5" class="form-control" />
                </div>
                <div >
                    <label id="lblEstado">Estado</label> &nbsp;                                      
                    <div class="form-control" style="background: lavender !important; display: none;">                        
                        <label id="lblEstadoDesc" >Confirmado</label>&nbsp;&nbsp;
                        <input type="hidden" name="" id="hidEstado">
                    </div>
                </div>                                  
             </div>
    <div class="row">
            <div class="col-md-12 breadcrumb"  >
                    <label>Transferir a...</label> &nbsp;
                    <button id="btnPropie" class="btn btn-default btn-xs">
                        <span class="glyphicon glyphicon-new-window"></span>
                    </button>                    
                    <input type="hidden" id="hidIdPropNuevo" value="0" />
                    <input type="hidden" id="hidIdCriadorNuevo" value="2" />

                    <div style="margin-top:20px; margin-left: 20px;">
                      <table id="grillaPropietario" class="table table-striped table-bordered  compact  gridHtmlBGProp " cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th>Nombre</th>
                                  <th>Acci&oacute;n</th>
                              </tr>
                          </thead>
                        <tbody></tbody>  
                      </table>
                    </div>
                         
            </div>
            </div>
          
        </div>
    </div>
 </div>
  
        <div class="modal-footer">
          <button type="button" id="btnSaveTransfer" class="btn btn-primary" >Grabar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


<div class="modal fade" id="dialogConfirmar" role="dialog">
    <div class="modal-dialog modal-xs ">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">CONFIRMAR TRANSFERENCIA</h4>
        </div>
        <div class="modal-body">
<div id="___dialogConfirmar">
     
        
            <div class="col-md-12 breadcrumb">
                
                    <label>Ejemplar</label> &nbsp;
                    <div class="form-control" style="background: lavender !important;">
                        <label id="lblEjemplarTransfer" ></label>&nbsp;&nbsp;
                    </div>
                
            </div>
        
         <div class="col-md-12 breadcrumb">  
                
                    <label>Estado</label> &nbsp;                                      
                    <div class="form-control" style="background: lavender !important;">                        
                        <label id="lblEstadoDescTransfer" ></label>&nbsp;&nbsp;
                        <input type="hidden" name="" id="hidEstadoTransfer">
                    </div>
                                                
            </div>
         
        
            <div class="col-md-12 breadcrumb">
                <div class="form">
                    <label>Fecha de Transferiencia</label> &nbsp;                                      
                    <input type="date" id="txtFechaTransfer" size="5" class="requerido form-control" />
                </div>          
            </div>

         
        
           
         
    
 </div>
</div >
  <div class="modal-footer">
          <button type="button" id="btnConfirmTransfer" class="btn btn-primary" >Grabar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>






<!-- Modal -->
<style>
.modal-dialog-customer-grlEjemplar { 
max-width : 60% ;
width : 50% ;
}
</style>
  <div class="modal fade" id="mvBuscadorEjemplarGrl" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-customer-grlEjemplar">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">B&uacute;squeda de Ejemplar</h4>
        </div>
        <div class="modal-body">
          <!--  <div style="display:none" id="mvBuscadorEjemplarGrl">-->
            <input type="hidden" id="hidOrigenBuscador" />
            <label>Ingrese nombre del Ejemplar:</label>
            <input type="text" id="txtBGNombreEjemplar" />
            <button id="btnBGBuscarEjemplar" class="btn-xs btn-danger"
            onclick="return initDataTableGrlEjemplar();">Buscar</button>
            <hr>
             <div>
              <table id="gridGralEjemplar"></table>
              <!-- APLICANDO CONTROLES PAGINACIÓN JQGRID -->
              <div id="opc_pagGralEjemplar"></div>
    
            </div>
        </div>
          
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
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
  
  

<? 
//require_once("/vista/general/grlBuscarEjemplar.php");  
//require_once("/vista/general/grlBuscarEntidad.php"); 
?>

 <style type="text/css">
   @media print {
    /* on modal open bootstrap adds class "modal-open" to body, so you can handle that case and hide body */
    body.modal-open {
        visibility: hidden;
    }

    body.modal-open .modal .modal-header,
    body.modal-open .modal .modal-body {
        visibility: visible; /* make visible modal body and header */
    }
}

 </style>