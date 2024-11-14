/* controls: Objeto Json que contiene los  IDs de los controles que se crean en el html */
var controls={
    actions:"#hidActionPopup",
    modalDialog:"#dialogNuevo",
    buttonNew:"#btnNuevo",
    buttonDel:"#btnEliminar",
    buttonEdit:"#btnEditar",
    buttonView:"#btnVer",
    buttonSave:"#btnSaveTipoDoc",
    buttonCancel:"#btnCancelar",    
    txtCodigo:"#txtCodigo",
    txtNombreCorto:"#txtNombreCorto",
    txtNombreLargo:"#txtNombreLargo",
    txtTipoDocFiltro:"#txtTipoDoc"

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
    modalNew:"Nuevo registro de tipo documento",
    modalEdit:"Actualizacion de tipo documento",
    modalRead:"Información de tipo documento",
    modalNoDeterminated:"Titulo no determinado",
    modalNone:""
}
var controllers={
    tipoDocumento:'ajax/ajaxTipoDoc.php'
}
var messages={
    inserted:'tipo documento registrado correctamente',
    updated:'tipo document actualizado correctamente',
    noDeterminated:'Error de aplicación: Operación no determinada.'
}


$(function(){
 
$(controls.buttonSave).on(events.click,function (){    update($(controls.modalDialog));});        
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
$(controls.txtNombreCorto).on(events.keypress,function (e){ if (e.which == 13) {   update($(controls.modalDialog));       }});
$(controls.txtNombreLargo).on(events.keypress,function (e){ if (e.which == 13) {   update($(controls.modalDialog));       }});
initDataTable();
    
//filtro
$(controls.txtTipoDocFiltro).on(events.keypress,function (e){ if (e.which == 13) {  search();       }});
//----    
});



function editar(){
   //  console.log('... ppppppp');
   var key = $("#grid").jqGrid('getGridParam',"selrow");
        //console.log('... '+respuesta.key);
        if(key){
                    grlEjecutarAccion(controllers.tipoDocumento, {opc:'get',key:key},function(retorno){
                        if(retorno.result===K_ResultadoAjax.exito){
                            var tipoDocumento=retorno.data;
                           // console.log('... '+retorno.data);
                             if(tipoDocumento!=null){
                                $(controls.txtCodigo).val(tipoDocumento.codigo);
                                $(controls.txtNombreCorto).val(tipoDocumento.nombreCorto);
                                $(controls.txtNombreLargo).val(tipoDocumento.nombreLargo);
                              }
                        }else if(retorno.result===K_ResultadoAjax.error){
                             alertify.error(retorno.message);
                        }
                    });
                     resetPopUp();
                     $(controls.modalDialog).modal("show");
        }else{
            alertify.warning("Seleccione dato");
        }
    
 }
function eliminar(){
     var key = $("#grid").jqGrid('getGridParam',"selrow");
          if (key){
    alertify.confirm('Advertencia', 'Está seguro de elminar los registros seleccionados?', 
                        function(){
                                          grlEjecutarAccion(controllers.tipoDocumento, {opc:'del',key:key},function(retorno){
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
                url:controllers.tipoDocumento,
                postData: paramSearch(),
                datatype: "json",
                height: "auto",
                mtype: 'GET',
                colNames:['Id', 'Nombre Corto','Nombre Largo'],
                colModel:[ 
                    {name:'id',index:'id',width:100, key: true},       
                    {name:'nombreCorto',index:'nombreCorto',width:130},
                    {name:'nombreLargo',index:'nombreLargo',width:130}
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
            nomTipoDoc:$(controls.txtTipoDocFiltro).val()
           
          };
 };
 function clearParamSearch (){
 
       $(controls.txtTipoDocFiltro).val("");
           
             
          
 };
var update=function(objModal){
var data={opc:'-',
codigo:$(controls.txtCodigo).val(),
nombreCorto:$(controls.txtNombreCorto).val(),
nombreLargo:$(controls.txtNombreLargo).val()};
if($(controls.actions).val()==actions.insert)  data.opc='ins';
if($(controls.actions).val()==actions.update)  data.opc='upd';
       if(grlValidarObligatorio(controls.modalDialog)){
        //console.log(data.opc);
            if(data.opc!="-"){
                 grlEjecutarAccion(controllers.tipoDocumento, data,function(retorno){
                        if(retorno.result===K_ResultadoAjax.exito){
                           // console.log(retorno.result);
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
            $(controls.modalDialog + "  .modal-title").html(titles.modalEdit);  
            $(controls.txtNombreCorto).removeAttr("disabled");
            $(controls.txtNombreLargo).removeAttr("disabled");
            $(controls.buttonSave).show();
    }else if($(controls.actions).val()==actions.read){ 
            $(controls.modalDialog + "  .modal-title").html(titles.modalRead); 
            $(controls.txtNombreCorto).attr("disabled","disabled");
             $(controls.txtNombreLargo).attr("disabled","disabled");
            $(controls.buttonSave).hide();
    }else if($(controls.actions).val()==actions.insert){ 
            $(controls.modalDialog + "  .modal-title").html(titles.modalNew);  
            $(controls.txtNombreCorto).removeAttr("disabled");
            $(controls.txtNombreLargo).removeAttr("disabled");
            $(controls.buttonSave).show();
    }else{
            $(controls.modalDialog + "  .modal-title").html(titles.modalNoDeterminated);                          
    }
}
function search(){ 
     validarSesion(function(isLogout){
    if(isLogout!="1"){ 

 $("#grid").jqGrid("clearGridData", true);
$("#grid").jqGrid('setGridParam', {     url: controllers.tipoDocumento, datatype: 'json',  mtype: 'GET', postData: paramSearch()
 }).trigger('reloadGrid');

 }
});
}
function clearCtrlsPopup(){
    resetPopUp();
    grlLimpiarObligatorio(controls.modalDialog);
    $(controls.txtCodigo).val("");
    $(controls.txtNombreCorto).val("");
    $(controls.txtNombreLargo).val("");
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
shortcut.add("Shift+R", function () {cancelar();}, paramShortcut);*/
 