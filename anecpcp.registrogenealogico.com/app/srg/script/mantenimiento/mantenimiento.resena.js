var controls={
    actions:"#hidActionPopup",
    modalDialog:"#dialogNuevo",
    buttonNew:"#btnNuevo",
    buttonDel:"#btnEliminar",
    buttonEdit:"#btnEditar",
    buttonView:"#btnVer",
    buttonCancel:"#btnCancelar", 
    txtId:"#txtId" , 
    txtDescripcion:"#txtDescripcion",
    txtTipo:"#cboTipo",
    txtTelefono:"#txtTelefono",
    buttonSave:"#btnSaveresena",
    txtResenaFiltro:"#txtResena",
    txtTipoResenaFiltro:"#txtTipoResenaFiltro"
};
/* action:  objeto Json que contiene las operaciones que se estan realizando en la vista Html para las ventanas modales*/
var actions={
    insert:1,
    update:2,
    read:3
};
var events={
    click:"click",
    change:"change",
    keypress:"keypress"
};

var titles={
    modalNew:"Nuevo registro de Reseña",
    modalEdit:"Actualizacion de Reseña",
    modalRead:"Información de Reseña",
    modalNoDeterminated:"Titulo no determinado",
    modalNone:""
}
var controllers={
    resena:'ajax/ajaxResena.php'
}
var messages={
    inserted:'Reseña registrado correctamente',
    updated:'Reseña actualizado correctamente',
    noDeterminated:'Error de aplicación: Operación no determinada.'
}


$(function(){
   
$(controls.buttonSave).on(events.click,function (){  update($(controls.modalDialog));}); 
$(controls.buttonNew).on(events.click,function (){  nuevo();});
$(controls.buttonEdit).on(events.click,function (){ modificar();});
$(controls.buttonView).on(events.click,function (){
search();
}); 
$(controls.buttonDel).on(events.click,function (){  eliminar();});
$(controls.buttonCancel).on(events.click,function (){ 
clearParamSearch();
search();
});
$(controls.txtCodigo).on(events.keypress,function (e){ if (e.which == 13) {   update($(controls.modalDialog));       }});
initDataTable();
listarTipoResena('txtTipoResenaFiltro','SELECCIONE',0);  
//filtros
$(controls.txtResenaFiltro).on(events.keypress,function (e){ if (e.which == 13) {  search();       }});
//--    
});

function editar(){
   var key = $("#grid").jqGrid('getGridParam',"selrow");
          if (key){
                    grlEjecutarAccion(controllers.resena, {opc:'get',key:key},function(retorno){
                        if(retorno.result===K_ResultadoAjax.exito){
                            var resena=retorno.data;
                            if(resena!=null){
                                $(controls.txtId).val(resena.codigo);
                                $(controls.txtDescripcion).val(resena.descripcion);
                                $("#cboTipo").val(resena.tipo);
                              }
                        }else if(retorno.result===K_ResultadoAjax.error){
                             alertify.error(retorno.message);
                        }
                    });
                     resetPopUp();
                     $(controls.modalDialog).modal("show");
        }else{
            alertify.warning("Seleccione un dato");
        }
    
 }
function initDataTable(){
 jQuery("#grid").jqGrid({
                url:controllers.resena,
                postData: paramSearch(),
                datatype: "json",
                height: "auto",
                mtype: 'GET',
                colNames:['Id', 'Descripcion','Tipo','Estado'],
                colModel:[ 
                    {name:'id',index:'id',width:100, key: true},       
                    {name:'descripcion',index:'descripcion',width:130},
                    {name:'tipo',index:'tipo',width:100},
                    {name:'activo',index:'activo',width:100,
                    formatter: function (cellvalue, options, rowObject) {
                        var rowTable='';
                        if(cellvalue==1){
                            rowTable='ACTIVO';
                        }else{
                            rowTable='INACTIVO';
                        }
                        return rowTable;
                    }
                }
                ],
                rowNum:15,
                pager: '#opc_pag',
                sortname: 'id',
                sortorder: "ASC",
                viewrecords: true,          
                caption:"Resultado de Búsqueda",
                autowidth: true,
                shrinkToFit: true,
                height: '350'

            });
 }
  function paramSearch (){
      //console.log($("#txtTipoResenaFiltro").val());
return {
            opc:'jqgrid',
            nomResena:$(controls.txtResenaFiltro).val(),
           tipo:$("#txtTipoResenaFiltro").val()==0 ? '' : $("#txtTipoResenaFiltro").val()
          };
 };
 function clearParamSearch (){
 
       $(controls.txtResenaFiltro).val("");
       $(controls.txtTipoResenaFiltro).val(0);
             
          
 };
var update=function(objModal){

var data={
opc:'-',
id:$(controls.txtId).val(),
descripcion:$(controls.txtDescripcion).val(),
tipo:$(controls.txtTipo).val()
//telefono:$(controls.txtTelefono).val()
};
if($(controls.actions).val()==actions.insert)  data.opc='ins';
if($(controls.actions).val()==actions.update)  data.opc='upd';
       if(grlValidarObligatorio(controls.modalDialog)){
            if(data.opc!="-" && data.tipo!=0 && data.tipo!=''){
                 grlEjecutarAccion(controllers.resena, data, function(retorno){
                    //console.log(retorno);
                        if(retorno.result===K_ResultadoAjax.exito){
                             alertify.success(retorno.message);
                             clearCtrlsPopup();
                             $(objModal).modal("hide");
                             search();
                            
                        }else if(retorno.result===K_ResultadoAjax.error){
                             alertify.error(retorno.message);
                        }else if(retorno.result===K_ResultadoAjax.warning){
                             alertify.warning(retorno.message);
                        }
                        search();
                    });
            }else{
                    alertify.error(messages.noDeterminated);
            }
        }
 }
function resetPopUp() {
    if($(controls.actions).val()==actions.update){ 
            $(controls.modalDialog + " .modal-title ").html(titles.modalEdit);  
            $(controls.txtNombre).removeAttr("disabled");
           // $(".ui-dialog-buttonset button:contains('Grabar')").button().show();
    }else if($(controls.actions).val()==actions.read){ 
            $(controls.modalDialog + " .modal-title ").html(titles.modalRead); 
            $(controls.txtNombre).attr("disabled","disabled");
          //  $(".ui-dialog-buttonset button:contains('Grabar')").button().hide();
    }else if($(controls.actions).val()==actions.insert){ 
            $(controls.modalDialog + " .modal-title ").html(titles.modalNew);  
            $(controls.txtNombre).removeAttr("disabled");
           // $(".ui-dialog-buttonset button:contains('Grabar')").button().show();
    }else{
            $(controls.modalDialog + " .modal-title ").html(titles.modalNoDeterminated);                          
    }
}
function search(){ 
 validarSesion(function(isLogout){
    if(isLogout!="1"){ 

 $("#grid").jqGrid("clearGridData", true);
$("#grid").jqGrid('setGridParam', {     url: controllers.resena, datatype: 'json',  mtype: 'GET', postData: paramSearch()
 }).trigger('reloadGrid');
  
    }
  });
}

function clearCtrlsPopup(){
    resetPopUp();
    grlLimpiarObligatorio(controls.modalDialog);
    $(controls.txtId).val("");
    $(controls.txtDescripcion).val("");
    $(controls.txtTelefono).val("");
    $(controls.txtTipo).val(0)
}
function ver(){
    $(controls.actions).val(actions.read);  
    clearCtrlsPopup();
    editar();
}
function nuevo(){
   $(controls.actions).val(actions.insert);  
   listarTipoResena('cboTipo','SELECCIONE',0);
  // listarUsuario(controls.comboTipoDoc,"seleccione");
   clearCtrlsPopup();
   $(controls.modalDialog).modal("show");
}
function modificar(){   
   $(controls.actions).val(actions.update);  
   listarTipoResena('cboTipo','SELECCIONE',0);
   clearCtrlsPopup();
   editar();
}
function cancelar(){
     /*clearCtrlsPopup();     search();     initDataTable();*/
     var param=GetQueryStringParams("obj");
     document.location.href="shared.php?obj="+param;
}
 
 function eliminar(){
    var key = $("#grid").jqGrid('getGridParam',"selrow");
    //console.log('..'+key);
          if (key){
    alertify.confirm('Advertencia', 'Está seguro de elminar los registros seleccionados?', 
                        function(){
                                            grlEjecutarAccion(controllers.resena, {opc:'del',key:key},function(retorno){
                                                if(retorno.result===K_ResultadoAjax.exito){
                                                    search();
                                                    alertify.success(retorno.message);
                                                }else if(retorno.result===K_ResultadoAjax.error){
                                                     alertify.error(retorno.message);
                                                }
                                            });
                                        
                                   
                        }, 
                        function(){ 
                            //alertify.error('Cancel')
                        }
                    );
        }else{
         alertify.warning(respuesta.message);
        }
 }
 