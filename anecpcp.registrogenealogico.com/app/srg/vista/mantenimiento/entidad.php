<script src="script/mantenimiento/mantenimiento.entidad.js"></script>
<div style="float:left;background:#f6f6f6; width:100%; background:url('images/button/barra.png')100% 100% ;"> 
<div style=" float:left; margin-top:10px;  " >
<titulo>
    <span class="glyphicon glyphicon-list"></span>
   Bandeja de Entidades
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
 
<div class="container-fluid breadcrumb table-responsive">
        <div   class="row">
          <div class="col-md-1">
            <Label>ID:</Label>
            <input type="text " id="txtIdBus" class="form-control"  />
          </div>

          <div class="col-md-2">
            <Label>Num Documento:</Label>
            <input type="text " id="txtNumDocBus" class="form-control"  />
          </div>
          
           <div class="col-md-4">
            <Label>Nombres / Razon social</Label>
            <input type="text " id="txtNombreBus" class="form-control" />
          </div>
           <div class="col-md-2">
            <Label>Prefijo</Label>
            <input type="text " id="txtPrefijoBus" class="form-control" />
          </div>
  
 <!-- 
<div class="col-md-2">
         
<Label>Rol</Label>
            <select id="ddlRolBus"  class="form-control">
                <option value="">Todos</option>
                <option value="P">Propietario</option>
                <option value="S">Socio</option>
                <option value="C">Criador</option>
            </select>  
    </div>
 -->
<div class="col-md-2">
          
<Label>Estado</Label>
            <select id="ddlEstadoBus"  class="form-control">
                <option value="">Todos</option>
                <option value="A" selected="selected">Activo</option>
                <option value="I">Inactivo</option>
            </select>  
    </div>

</div> 
<!-- APLICANDO EL GRID CON JQGRID -->
<table id="grid"></table>
<!-- APLICANDO CONTROLES PAGINACIÓN JQGRID -->
<div id="opc_pag"></div>


<div class="modal fade" id="dialogNuevo" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-customer-grlEnte">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">B&uacute;squeda de Entidades</h4>
        </div>
        <div class="modal-body">
                    <div id="__dialogNuevo">
                    <input type="hidden" id="hidActionPopup" />
                    <input type="hidden" id="hidIdProp" />

                    <div class="container-fluid table-responsive breadcrumb" id="divContainer">
                        <!--  <div class="rowa breadcrumb">
                              <div class="col-md-3">
                                  <div class=" form ">-->
                                       
                      <table class="tablex" style=" width:100%;"  >
                       
                       
                    <tr>
                    <td>
                        <label  > Codigo:  </label>
                        <input type="text" id="txtCodigo"  class="form-control" disabled="disabled" />
                    <td class="tdSeparate"></td> 
                    </td> 
                    <td>
                        <label>Tipo de Doc.</label>
                        <select id="ddlTipoDoc" class="requeridoLst form-control" ></select>
                    </td>
                    <td class="tdSeparate"></td> 
                    <td>
                        <label> Numero de Documento  </label>
                        <input type="text" id="txtNroDoc" class="requerido  form-control"  maxlength="15"   />
                    </td>
                    </tr>
                    </tr>
                    <tr>
                    <td>
                             <label> Apellido Paterno:  </label> 
                             <input type="text" id="txtApePaterno" class="requerido form-control"    /> 
                    </td>          
                    <td class="tdSeparate"></td> 

                    <td>
                             <label> Apellido Materno:  </label> 
                             <input type="text" id="txtApeMaterno" class="requerido form-control"    /> 
                    </td>
                    <td class="tdSeparate"></td> 
                    <td>
                             <label> Nombres:  </label> 
                             <input type="text" id="txtNombre" class="requerido form-control"    /> 
                    </td>
                    </tr>

                    <tr>
                    <td colspan="3">
                             <label>Razon Social</label>
                             <input type="text" id="razonSoc" class="requerido form-control"    /> 

                    </td>
                    <td class="tdSeparate"></td> 
                    <td>
                         <label> Correo:  </label>
                            <input type="text" id="txtCorreo" class="requerido form-control"    />
                    </td>
                    </tr>

                    <tr>
                    <td colspan="5">
                    <table border="0"   style="width: 100%;">
                    <tr> 
                        <td>
                        <label> Telefono: </label>
                            <input type="text" id="txtTelefono" class=" form-control" /> 
                    </td> 
                    <td class="tdSeparate"></td> 
                    
                    <td>
                            <label> Celular: </label>
                            <input type="text" id="txtCelular" class=" form-control"  />
                    </td>
                    <td class="tdSeparate"></td> 
                    <td>
                            <label> Observación: </label>
                            <input type="text" id="txtObservacion" class=" form-control"/>
                    </td>
                    <td class="tdSeparate"></td> 
                    <td>
                         <label>Situación:</label>  
                            <select id="ddlSituacion" class="form-control" >
                                <option value="A">Activo</option>
                                <option value="I">Inactivo</option>
                            </select>   
                    </td> 
                    </tr>
                    </tr></table>
                    </td>
                    </tr>

                      <tr >
                    <td colspan="5">
                    
                    <table border="0"   style="width: 100%; background: lavender;">
                    <tr><td colspan="4">
                   <span style="font-size: 10px; font-weight: bold;" >Datos de Crianza:</span>         
                   </td>        
                        </tr>
                    <tr> 
                        <td>
                        <label id="lblDept"> Dpto Crianza: </label>
                        </td>
                        <td>
                             <select id="ddlProvinvia" class="  form-control   "   >
                            </select>
                          </td>  
                  <!--  <td class="tdSeparate"></td> 
                    </td> 
                    <td>-->
                       <td>
                            <label id="lblLugar"> Lugar Crianza: </label>
                            </td>
                            <td>
                            <input type="text" id="txtLugarCria" class=" form-control"  />
                              </td>
                              
                                </tr>
                                </table>
                           <!--  </fieldset>-->
                    </td>
                    </tr>

                    <tr>
                    <td colspan="5" valign="middle">
                        <fieldset  style="border:2px groove #ccc;"   >
                                <legend style="width:80px" ><span  style=" margin-left: 10px; font-size: 16px; font-weight: bold;" >Perfil</span></legend>
                                
                                <div style=" margin-top: -15px;">
                                    <input type='checkbox' tabindex='20' id='chkSocio'      name='perfil'  >
                                    <label for ="chkSocio" >Socio</label>
                                    <input type='checkbox' tabindex='21' id='chkCriador'    name='perfil' >
                                    <label for ="chkCriador">Criador</label>
                                    <input type='checkbox' tabindex='22' id='chkPropietario'     name='perfil' >
                                    <label for ="chkPropietario">Propietario</label>
                                    </div>
                                </fieldset>
                                <br>
                     </td>
                     </tr>
                   
                    
                                        
                     <tr id="trDataCriador" style="display: none;">
                    <td colspan="5">
                    
                    <table border="0"   style="width: 100%; background: lavender;">
                    <tr><td colspan="4">
                   <span style="font-size: 10px; font-weight: bold;" >Datos del Criador:</span>         
                   </td>        
                        </tr>
                    <tr> 
                       <td>
                            <label id="lblPrefijo"> Prefijo: </label>
                            </td>
                            <td>
                            <input type="text" id="txtPrefijo" class=" form-control"  />
                              </td>
                              
                                </tr>
                                </table>
                           <!--  </fieldset>-->
                    </td>
                    </tr>


                                       </table>

                                       <br>
                                       <div class="tfila">
                      <table border="0"   style="width: 100%; background: lavender;">
                     <tr><td colspan="4">
                   <span style="font-size: 10px; font-weight: bold;" >Datos para acceso web:</span>         
                   </td>        
                        </tr>
                        <tr>
                        <td>
                  <label>Login:</label>
                      <input type="text" id="txtUser" style=' text-transform:none!important;'/>
                  <label>Password:</label>
                  <input type="password" id="txtPass" class="password" style=' text-transform:none !important;' /><input type="checkbox" name="option"  id="check"  />
                  </td>
                  </tr>
                  </table>
                </div>

                                       </div>
   </div>
        <div class="modal-footer">
          <button type="button" id="btnSaveEntidad" class="btn btn-primary" >Grabar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
 </div>