/* controls: Objeto Json que contiene los  IDs de los controles que se crean en el html */
var controls={
    actions:"#hidActionPopup",
    modalDialog:"#dialogNuevo",
    buttonNew:"#btnNuevo",
    buttonDel:"#btnEliminar",
    buttonEdit:"#btnEditar",
    buttonView:"#btnVer",
    buttonSave:"#btnSavePelaje",
    buttonCancel:"#btnCancelar",    
    txtCodigo:"#txtCodigo",
    txtNombre:"#txtNombre",
    txtPelajeFiltro:"#txtPelaje"

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
    modalNew:"CONFIGURAR NUEVO PARTE DE OCURRENCIAS",
    modalEdit:"ACTUALIZAR PARTE DE OCURRENCIAS",
    modalRead:"INFORMACION DE PARTE DE OCURRENCIAS",
    modalNoDeterminated:"Titulo no determinado",
    modalNone:""
}
var controllers={
    pelaje:'ajax/ajaxPelaje.php'
}
var messages={
    inserted:'pelaje registrado correctamente',
    updated:'pelaje actualizado correctamente',
    noDeterminated:'Error de aplicación: Operación no determinada.'
}


$(function(){
 
$(controls.buttonSave).on(events.click,function (){  update($(controls.modalDialog));});        
$(controls.buttonNew).on(events.click,function (){  nuevo();});
$(controls.buttonEdit).on(events.click,function (){ modificar();});
$(controls.buttonDel).on(events.click,function (){  eliminar();});
$(controls.buttonView).on(events.click,function (){
search();
}); 

//filtro
$("#txtIdBus").on(events.keypress,function (e){ if (e.which == 13) {  search();    }});
//--
$(controls.buttonCancel).on(events.click,function (){ 
clearParamSearch();
search();
}); 

$(controls.txtPelajeFiltro).on(events.keypress,function (e){ if (e.which == 13) {  search();       }});
initDataTable();
    
});



function editar(){
    var key = $("#grid").jqGrid('getGridParam',"selrow");
    
        //console.log('... '+respuesta.key);
        if(key){
                    grlEjecutarAccion(controllers.pelaje, {opc:'get',key:key},function(retorno){
                        if(retorno.result===K_ResultadoAjax.exito){
                            var pelaje=retorno.data;
                            //console.log('... '+retorno.data);
                            if(pelaje!=null){
                                $(controls.txtCodigo).val(pelaje.codigo);
                                $(controls.txtNombre).val("Descripcion pARTE oCURRENCIAS");
                                $("#anio").val("2020");
                                $("#inicio").val("10/01/2020");
                                $("#fin").val("10/12/2020");
                              }
                        }else if(retorno.result===K_ResultadoAjax.error){
                             alertify.error(retorno.message);
                        }
                    });
                     resetPopUp();
                     $(controls.modalDialog).modal("show");
        }else{
            alertify.warning(respuesta.message);
        }
    
 }
function eliminar(){
    var key = $("#grid").jqGrid('getGridParam',"selrow");
          if (key){
    alertify.confirm('Advertencia', 'Está seguro de elminar los registros seleccionados?', 
                        function(){
                                                                      
                                            grlEjecutarAccion(controllers.pelaje, {opc:'del',key:key},function(retorno){
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
function initDataTable(){
  jQuery("#grid").jqGrid({
                url:'script/mantenimiento/dataPoe.txt',
 //               postData: paramSearch(),
                datatype: "json",
                height: "auto",
                mtype: 'GET',
                colNames:['Id', 'Periodo', 'Inicia', 'Finaliza', 'Descripcion', 'Modo Acceso'],
                colModel:[ 
                    {name:'id',index:'id',width:100, key: true},       
                    {name:'periodo',index:'periodo',width:130},
                    {name:'inicia',index:'inicia',width:130},
                    {name:'finaliza',index:'finaliza',width:130},
                    {name:'descripcion',index:'descripcion',width:130},
                    {name:'acceso',index:'acceso',width:130}
                   
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
return {
            opc:'jqgrid',
            nomPelaje:$(controls.txtPelajeFiltro).val()
           
          };
 };
  function clearParamSearch (){
 
       $(controls.txtPelajeFiltro).val("");
           
             
          
 };
var update=function(objModal){
var data={opc:'-',
codigo:$(controls.txtCodigo).val(),
nombre:$(controls.txtNombre).val()
};
if($(controls.actions).val()==actions.insert)  data.opc='ins';
if($(controls.actions).val()==actions.update)  data.opc='upd';
       if(grlValidarObligatorio(controls.modalDialog)){
            if(data.opc!="-"){
                 grlEjecutarAccion(controllers.pelaje, data,function(retorno){
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
            $(controls.btnSavePelaje).show();
    }else if($(controls.actions).val()==actions.read){ 
            $(controls.modalDialog + " .modal-title ").html(titles.modalRead); 
            $(controls.txtNombre).attr("disabled","disabled");
            $(controls.btnSavePelaje).hide();
    }else if($(controls.actions).val()==actions.insert){ 
            $(controls.modalDialog + " .modal-title ").html(titles.modalNew);  
            $(controls.txtNombre).removeAttr("disabled");
            $(controls.btnSavePelaje).show();
    }else{
            $(controls.modalDialog + " .modal-title ").html(titles.modalNoDeterminated);                          
    }
}
function search(){
    validarSesion(function(isLogout){
    if(isLogout!="1"){ 
/*
 $("#grid").jqGrid("clearGridData", true);
$("#grid").jqGrid('setGridParam', {     url: controllers.pelaje, datatype: 'json',  mtype: 'GET', postData: paramSearch()
 }).trigger('reloadGrid');
*/
  }
  });
}
function clearCtrlsPopup(){
    resetPopUp();
    grlLimpiarObligatorio(controls.modalDialog);
    $(controls.txtCodigo).val("");
    $(controls.txtNombre).val("");
}
function ver(){
    $(controls.actions).val(actions.read);  
    clearCtrlsPopup();
    editar();
}
function nuevo(){
   $(controls.actions).val(actions.insert);  
   clearCtrlsPopup();
   $(controls.modalDialog).modal("show");
}
function modificar(){   
   $(controls.actions).val(actions.update);  
   clearCtrlsPopup();
   editar();
}
function cancelar(){
     /*clearCtrlsPopup();     search();     initDataTable();*/
     var param=GetQueryStringParams("obj");
     document.location.href="shared.php?obj="+param;
}
/*
var paramShortcut={    "type": "keydown",    "propagate": false,    "target": document};
shortcut.add("Shift+N", function () {nuevo();}, paramShortcut);
shortcut.add("Shift+E", function () {modificar();}, paramShortcut);
shortcut.add("Shift+D", function () {eliminar();}, paramShortcut);
shortcut.add("Shift+V", function () {ver();}, paramShortcut);
shortcut.add("Shift+R", function () {cancelar();}, paramShortcut);
*/
 