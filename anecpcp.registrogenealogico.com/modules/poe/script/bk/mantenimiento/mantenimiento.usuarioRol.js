/* controls: Objeto Json que contiene los  IDs de los controles que se crean en el html */
var controls={
    actions:"#hidActionPopup",
    modalDialog:"#dialogNuevo",
    buttonNew:"#btnNuevo",
    buttonDel:"#btnEliminar",
    buttonEdit:"#btnEditar",
    buttonView:"#btnVer",
    buttonCancel:"#btnCancelar", 
    txtId:"#txtCodigo" , 
    txtDescripcion:"#txtDescripcion",
    txtTelefono:"#txtTelefono",
    buttonSave:"#btnSaveUsuarioRol",
    cboUsuario:"ddlUsuario",
    cboRol:"ddlRol",
    txtUsuario:"#txtUsuario",
    chkEstado:"#chkEstado",
    cboOficina:"ddlOficina",
    cboUsuarioBus:"ddlUsuarioBus",
    cboOficinaBus:"ddlOficinaBus",

    txtLogin:"#txtLogin",
    txtPwd:"#txtPwd"

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
    modalNew:"Nuevo registro de Oficna",
    modalEdit:"Actualizacion de Oficna",
    modalRead:"Información de UsuarioRol",
    modalNoDeterminated:"Titulo no determinado",
    modalNone:""
}
var controllers={
    UsuarioRol:'ajax/ajaxusuarioRol.php'
}
var messages={
    inserted:'UsuarioRol registrado correctamente',
    updated:'UsuarioRol actualizado correctamente',
    noDeterminated:'Error de aplicación: Operación no determinada.'
}


$(function(){
   /* $(controls.modalDialog).dialog({
    title:titles.modalNew,
    modal:true,
    autoOpen:false,
    width:500,
    heigth:400,
        buttons: {
          "Grabar": function(){ update(this);   },
          "Cancelar": function() { $(this).dialog("close"); }
            }
       } ); 
        */
$(controls.buttonSave).on(events.click,function (){  update($(controls.modalDialog));}); 
$(controls.buttonNew).on(events.click,function (){  nuevo();});
$(controls.buttonEdit).on(events.click,function (){ modificar();});
$(controls.buttonView).on(events.click,function (){ search();});
$(controls.buttonDel).on(events.click,function (){  eliminar();});
$(controls.buttonCancel).on(events.click,function (){ clearParamSearch();  search();});
$(controls.txtCodigo).on(events.keypress,function (e){ if (e.which == 13) {   update($(controls.modalDialog));       }});
initDataTable();
    listarUsuario("ddlUsuarioBus","seleccione");
    listarOficina("ddlOficinaBus","seleccione");
    showPassword();
});



function editar(){
     var key = $("#grid").jqGrid('getGridParam',"selrow");
    //console.log("entro");
        //console.log('... '+respuesta.key);
        if(key){
                    grlEjecutarAccion(controllers.UsuarioRol, {opc:'get',key:key},function(retorno){
                        if(retorno.result===K_ResultadoAjax.exito){
                            var usuarioRol=retorno.data;
                            if(usuarioRol!=null){
                                $(controls.txtId).val(usuarioRol.id);
                                listarUsuario(controls.cboUsuario,"seleccione",usuarioRol.idUsuario); 
                                listarRol(controls.cboRol,"seleccione",usuarioRol.idRol);
                                listarOficina(controls.cboOficina,"seleccione",usuarioRol.idOficina);
                                $(controls.txtLogin).val(usuarioRol.Usuario);
                                $(controls.txtPwd).val(usuarioRol.Password);
                                if(usuarioRol.estado==1){
                                    $( "#chkEstado" ).prop( "checked",true ); 
                                 }else {
                                    $( "#chkEstado" ).prop( "checked",false); 
                                 }
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
    console.log(key);
          if (key){
    alertify.confirm('Advertencia', 'Está seguro de elminar los registros seleccionados?', 
                        function(){
                                                                      
                                            grlEjecutarAccion(controllers.UsuarioRol, {opc:'del',key:key},function(retorno){
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
                url:controllers.UsuarioRol,
                postData: paramSearch(),
                datatype: "json",
                height: "auto",
                mtype: 'GET',
                colNames:['Id', 'Usuario','Rol','Oficina','Estado'],
                colModel:[ 
                    {name:'id',index:'id',width:100, key: true},       
                    {name:'usuario',index:'usuario',width:130},
                    {name:'rol',index:'rol',width:130},
                    {name:'oficina',index:'oficina',width:130},
                    {name:'estado',index:'estado',width:130}
                   
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
            nomUsu:$("#ddlUsuarioBus").val(),
            nomOfic:$("#ddlOficinaBus").val()
          };
 };
var update=function(objModal){
var estado=0;
if($("#chkEstado").prop("checked")){
    estado=1;
}


var data={
opc:'-',
id:$(controls.txtId).val(),
idRol:$("#"+controls.cboRol).val(),
idUsuario:$("#"+controls.cboUsuario).val(),
idOficina:$("#"+controls.cboOficina).val(),
estado:estado,
login:$(controls.txtLogin).val(),
pwd:$(controls.txtPwd).val()
};
//console.log(data);
if($(controls.actions).val()==actions.insert)  data.opc='ins';
if($(controls.actions).val()==actions.update)  data.opc='upd';
       if(grlValidarObligatorio(controls.modalDialog)){
            if(data.opc!="-"){
                 grlEjecutarAccion(controllers.UsuarioRol, data, function(retorno){
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
               $("#ddlUsuario").removeAttr("disabled","disabled");
                $("#ddlRol").removeAttr("disabled","disabled");
                $("#ddlOficina").removeAttr("disabled","disabled");
           // $(".ui-dialog-buttonset button:contains('Grabar')").button().show();
    }else{
            $(controls.modalDialog + " .modal-title ").html(titles.modalNoDeterminated);                          
    }
}
function search(){ 
  validarSesion(function(isLogout){
    if(isLogout!="1"){ 

 $("#grid").jqGrid("clearGridData", true);
$("#grid").jqGrid('setGridParam', {     url: controllers.UsuarioRol, datatype: 'json',  mtype: 'GET', postData: paramSearch()
 }).trigger('reloadGrid');
  }
});
}
function clearParamSearch (){
 
            $("#txtUsuario").val("");
            listarUsuario("ddlUsuarioBus","seleccione"); 
            listarOficina("ddlOficinaBus","seleccione");

 };
function clearCtrlsPopup(){
    resetPopUp();
    grlLimpiarObligatorio(controls.modalDialog);
    $(controls.txtDescripcion).val("");
    $(controls.txtTelefono).val("");
    $("#txtLogin").val("");
    $("#txtPwd").val("");
          
}
function ver(){
    $(controls.actions).val(actions.read);  
    clearCtrlsPopup();
    editar();
}
function nuevo(){
   $(controls.actions).val(actions.insert);
   listarUsuario("ddlUsuario","seleccione"); 
   listarRol("ddlRol","seleccione");
   listarOficina("ddlOficina","seleccione");
   clearCtrlsPopup();
   $(controls.modalDialog).modal("show");
}
function modificar(){   
   $(controls.actions).val(actions.update);  
   clearCtrlsPopup();
   editar();
   $("#ddlUsuario").attr("disabled","disabled");
   $("#ddlRol").attr("disabled","disabled");
   $("#ddlOficina").attr("disabled","disabled");
}
function cancelar(){
     /*clearCtrlsPopup();     search();     initDataTable();*/
     var param=GetQueryStringParams("obj");
     document.location.href="shared.php?obj="+param;
}
var paramShortcut={    "type": "keydown",    "propagate": false,    "target": document};
shortcut.add("Shift+N", function () {nuevo();}, paramShortcut);
shortcut.add("Shift+E", function () {modificar();}, paramShortcut);
shortcut.add("Shift+D", function () {eliminar();}, paramShortcut);
shortcut.add("Shift+V", function () {ver();}, paramShortcut);
shortcut.add("Shift+R", function () {cancelar();}, paramShortcut);
 function showPassword (){

$('#check').click(function(){
    if('password' == $('#txtPwd').attr('type')){
         $('#txtPwd').prop('type', 'text');
    }else{
         $('#txtPwd').prop('type', 'password');
    }
});
 }