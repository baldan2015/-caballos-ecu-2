/* controls: Objeto Json que contiene los  IDs de los controles que se crean en el html */
var controls={
    actions:"#hidActionPopup",
    modalDialog:"#dialogNuevo",
    buttonNew:"#btnNuevo",
    buttonDel:"#btnEliminar",
    buttonEdit:"#btnEditar",
    buttonView:"#btnVer",
    buttonSave:"#btnSaveUsuarios",
    buttonCancel:"#btnCancelar",    
    txtCodigo:"#txtCodigo",
    txtNombre:"#txtNombre"

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
    modalNew:"Nuevo registro de Usuario",
    modalEdit:"Actualizacion de Usuario",
    modalRead:"Información de Usuario",
    modalNoDeterminated:"Titulo no determinado",
    modalNone:""
}
var controllers={
    pelaje:'ajax/ajaxUsuarios.php'
}
var messages={
    inserted:'Usuario registrado correctamente',
    updated:'Usuario actualizado correctamente',
    noDeterminated:'Error de aplicación: Operación no determinada.'
}


$(function(){
 
$(controls.buttonSave).on(events.click,function (){  update($(controls.modalDialog));});        
$(controls.buttonNew).on(events.click,function (){  nuevo();});
$(controls.buttonEdit).on(events.click,function (){ modificar();});
$(controls.buttonView).on(events.click,function (){ ver();});
$(controls.buttonDel).on(events.click,function (){  eliminar();});
$(controls.buttonCancel).on(events.click,function (){ cancelar();});
$(controls.txtNombre).on(events.keypress,function (e){ if (e.which == 13) {   update($(controls.modalDialog));       }});
initDataTable();
    
});



function editar(){
    var table = $('#example').DataTable();
    var idxColumnKey ="0";//indice de la columna id
    grlObtieneIdDataTable( table ,idxColumnKey,function(respuesta){
        //console.log('... '+respuesta.key);
        if(respuesta.result){
                    grlEjecutarAccion(controllers.pelaje, {opc:'get',key:respuesta.key},function(retorno){
                        if(retorno.result===K_ResultadoAjax.exito){
                            var pelaje=retorno.data;
                            //console.log('... '+retorno.data);
                            if(pelaje!=null){
                                $(controls.txtCodigo).val(pelaje.codigo);
                                $(controls.txtNombre).val(pelaje.nombre);
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
    });
 }
function eliminar(){
    alertify.confirm('Advertencia', 'Está seguro de elminar los registros seleccionados?', 
                        function(){
                                    var table = $('#example').DataTable();
                                    var idxColumnKey ="0";
                                    grlObtieneIdsDataTable( table ,idxColumnKey,function(respuesta){
                                        if(respuesta.result){
                                            grlEjecutarAccion(controllers.pelaje, {opc:'delAll',keys:respuesta.keys},function(retorno){
                                                if(retorno.result===K_ResultadoAjax.exito){
                                                    search();
                                                    alertify.success(retorno.message);
                                                }else if(retorno.result===K_ResultadoAjax.error){
                                                     alertify.error(retorno.message);
                                                }
                                            });
                                        }else{
                                            alertify.warning(respuesta.message);
                                        }
                                    });
                        }, 
                        function(){ 
                            //alertify.error('Cancel')
                        }
                    );
 }
function initDataTable(){
 var table = $('#example').DataTable( {
        "bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "ajax/ajaxPelaje.php",
        "oLanguage": {
			"sLengthMenu": "Mostrar _MENU_ registros por pagina",
			"sZeroRecords": "No se encontraron registros",
			"sInfo": "Mostrar _START_ - _END_ de _TOTAL_ registros",
			"sInfoEmpty": "No se encontraron registros",
			"sInfoFiltered": "(registros filtrados de un total _MAX_ )"
		},
    "bJQueryUI": true
     
     
    } );
    
    $('#example tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            //table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
 }
var update=function(objModal){
var data={opc:'-',codigo:$(controls.txtCodigo).val(),nombre:$(controls.txtNombre).val()};
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
    var table = $('#example').DataTable();
    table.ajax.reload( function ( json ) {
                $('#myInput').val( json.lastInput );
    } );
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