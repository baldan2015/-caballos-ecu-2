/* controls: Objeto Json que contiene los  IDs de los controles que se crean en el html */
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
    txtTelefono:"#txtTelefono",
    buttonSave:"#btnSaveOficina",
    txtOficinaFiltro:"#txtOficina",
    

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
    modalNew:"Nuevo registro de Oficina",
    modalEdit:"Actualizacion de Oficina",
    modalRead:"Información de Oficina",
    modalNoDeterminated:"Titulo no determinado",
    modalNone:""
}
var controllers={
    Oficina:'ajax/ajaxOficina.php'
}
var messages={
    inserted:'Oficina registrado correctamente',
    updated:'Oficina actualizado correctamente',
    noDeterminated:'Error de aplicación: Operación no determinada.'
}


$(function(){
  
$(controls.buttonSave).on(events.click,function (){  update($(controls.modalDialog));}); 
$(controls.buttonNew).on(events.click,function (){  nuevo();});
$(controls.buttonEdit).on(events.click,function (){ modificar();});
//$(controls.buttonView).on(events.click,function (){ ver();});
$(controls.buttonDel).on(events.click,function (){  eliminar();});
//$(controls.buttonCancel).on(events.click,function (){ cancelar();});
$(controls.txtCodigo).on(events.keypress,function (e){ if (e.which == 13) {   update($(controls.modalDialog));       }});
initDataTable();
 $(controls.buttonView).on(events.click,function (){

search();

});        
$(controls.buttonCancel).on(events.click,function (){ 
clearParamSearch();
search();
});   

//filtros
$("#txtOficina").on(events.keypress,function (e){ if (e.which == 13) {  search();     }});

//----------------


});



function editar(){
var key = $("#grid").jqGrid('getGridParam',"selrow");
          if (key){
                    grlEjecutarAccion(controllers.Oficina, {opc:'get',key:key},function(retorno){
                        if(retorno.result===K_ResultadoAjax.exito){
                            var oficina=retorno.data;
                            console.log('... '+retorno.data);
                            if(oficina!=null){
                                $(controls.txtId).val(oficina.codigo);
                                $(controls.txtDescripcion).val(oficina.descripcion);
                                $(controls.txtTelefono).val(oficina.telefono);
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
                                  
                                            grlEjecutarAccion(controllers.Oficina, {opc:'del',key:key},function(retorno){
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
            alertify.warning("Seleccione dato");
        }  
 }
function initDataTable(){
  jQuery("#grid").jqGrid({
                url:controllers.Oficina,
                postData: paramSearch(),
                datatype: "json",
                height: "auto",
                mtype: 'GET',
                colNames:['Código', 'Descripcion','Telefono','Estado'],
                colModel:[ 
                    {name:'id',index:'id',width:100, key: true},       
                    {name:'descripcion',index:'descripcion',width:130},
                    {name:'telefono',index:'telefono'},
                    {name:'estado',index:'estado'}
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
            nomOficina:$(controls.txtOficinaFiltro).val()
           
          };
 };
 function clearParamSearch (){
 
       $(controls.txtOficinaFiltro).val("");
           
             
          
 };

var update=function(objModal){

var data={
opc:'-',
id:$(controls.txtId).val(),
descripcion:$(controls.txtDescripcion).val(),
telefono:$(controls.txtTelefono).val()
};
console.log(data);
if($(controls.actions).val()==actions.insert)  data.opc='ins';
if($(controls.actions).val()==actions.update)  data.opc='upd';
       if(grlValidarObligatorio(controls.modalDialog)){
            if(data.opc!="-"){
                 grlEjecutarAccion(controllers.Oficina, data, function(retorno){
                   // console.log(retorno);
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
                      //  search();
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
$("#grid").jqGrid('setGridParam', {     url: controllers.oficina, datatype: 'json',  mtype: 'GET', postData: paramSearch()
 }).trigger('reloadGrid');
  }
});
}
function clearCtrlsPopup(){
    resetPopUp();
    grlLimpiarObligatorio(controls.modalDialog);
    $(controls.txtDescripcion).val("");
    $(controls.txtTelefono).val("");
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
     clearCtrlsPopup(); 
        search();    
        //initDataTable();
     
}
 