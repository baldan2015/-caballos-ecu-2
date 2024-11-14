/* controls: Objeto Json que contiene los  IDs de los controles que se crean en el html */
var controls={
    actions:"#hidActionPopup",
    modalDialog:"#dialogNuevo",
    buttonNew:"#btnNuevo",
    buttonDel:"#btnEliminar",
    buttonEdit:"#btnEditar",
    buttonView:"#btnVer",
    buttonCancel:"#btnCancelar",    
    buttonSave:"#btnSaveEntidad",
    txtCodigo:"#txtCodigo",
    txtNroDoc:"#txtNroDoc",
    txtApePaterno:"#txtApePaterno",
    txtApeMaterno:"#txtApeMaterno",
    razonSoc:"#razonSoc",
    txtNombre:"#txtNombre",
    txtCorreo:"#txtCorreo",
    txtTelefono:"#txtTelefono",
    txtCelular:"#txtCelular",
    comboTipoDoc:"ddlTipoDoc",
    txtObservacion:"#txtObservacion",
    comboSituacion:"#ddlSituacion",
    hidIdProp:"#hidIdProp",
    cboDpto:"ddlProvinvia",
    txtLugarCria:"#txtLugarCria",
    txtPrefijo:"#txtPrefijo",
    txtLogin:"#txtUser",
    txtPwd:"#txtPass"
    
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
    modalNew:"Nuevo registro de entidad",
    modalEdit:"Actualizacion de entidad",
    modalRead:"Información de entidad",
    modalNoDeterminated:"Titulo no determinado",
    modalNone:""
}
var controllers={
    entidad:'ajax/ajaxEntidad.php',

}
var messages={
    inserted:'entidad registrada correctamente',
    updated:'entidad actualizada correctamente',
    noDeterminated:'Error de aplicación: Operación no determinada.'
}


$(function(){
 $("#ddlEstadoBus").val("A");
$(controls.buttonSave).on(events.click,function (){  update();});
$(controls.buttonNew).on(events.click,function (){  nuevo();});
$(controls.buttonEdit).on(events.click,function (){ modificar();});
//$(controls.buttonView).on(events.click,function (){ ver();});
$(controls.buttonDel).on(events.click,function (){  eliminar();});
//$(controls.buttonCancel).on(events.click,function (){ cancelar();});
$(controls.txtNombre).on(events.keypress,function (e){ if (e.which == 13) {   update($(controls.modalDialog));       }});
$("#"+controls.comboTipoDoc).on(events.change,function(){  selectorDeTipoDocumento($(this).val());});

//filtros evento enter 
$("#txtIdBus").on(events.keypress,function (e){ if (e.which == 13) {  search();    }});
$("#txtNumDocBus").on(events.keypress,function (e){ if (e.which == 13) {  search();    }});
$("#txtNombreBus").on(events.keypress,function (e){ if (e.which == 13) {  search();    }});
$("#txtPrefijoBus").on(events.keypress,function (e){ if (e.which == 13) {  search();    }});
//-----------------------
initDataTable();
showPassword();
$(controls.buttonView).on(events.click,function (){   search();});        
$(controls.buttonCancel).on(events.click,function (){   clearParamSearch();  search();});

$(controls.modalDialog).on('show.bs.modal', function () {

    if($("#chkCriador").prop("checked")){
    $("#trDataCriador").show();
}else{
    $("#trDataCriador").hide();
}      
});


$("#chkCriador").on(events.click,function(){
        if($("#chkCriador").prop("checked")){
    $("#trDataCriador").show();
}else{
    $("#trDataCriador").hide();
}      
});



});



function editar(){
          var key = $("#grid").jqGrid('getGridParam',"selrow");
          if (key){
                    grlEjecutarAccion(controllers.entidad, {opc:'get',key:key},function(retorno){
                        if(retorno.result===K_ResultadoAjax.exito){
                            var entidad=retorno.data;
                            //console.log($(controls.comboTipoDoc).val(entidad.comboTipoDoc));
                            if(entidad!=null){
                              $("#trDataCriador").hide();
                                $(controls.txtCodigo).val(entidad.codigo);
                                $(controls.txtNroDoc).val(entidad.numDoc);
 
                                 if(entidad.flagSocio==true){
                                    $( "#chkSocio" ).prop( "checked",true ); 
                                 }else{
                                    $( "#chkSocio" ).prop( "checked",false ); 
                                 }
                                 if(entidad.flagCriador==true){
                                    $("#chkCriador").prop("checked",true);

                                     $("#trDataCriador").show();

                                 }else{
                                     $("#chkCriador").prop("checked",false);
                                 }
                                 if(entidad.flagPropietario==true){
                                    $("#chkPropietario").prop("checked",true);
                                 }else{
                                    $("#chkPropietario").prop("checked",false);
                                 }

                                if(entidad.idTipoDoc==1){
                                   
                                    $(controls.txtApePaterno).val(entidad.apePaterno);
                                    $(controls.txtApeMaterno).val(entidad.apeMaterno);
                                    $(controls.txtNombre).val(entidad.nombres);
                                  
                                }else if(entidad.idTipoDoc==2){
                                    $(controls.razonSoc).val(entidad.razonSocial);
                                  
                                }else if(entidad.idTipoDoc==3){
                                  $(controls.txtApePaterno).val(entidad.apePaterno);
                                  $(controls.txtApeMaterno).val(entidad.apeMaterno);
                                  $(controls.txtNombre).val(entidad.nombres);  
                                }
                                $(controls.txtCorreo).val(entidad.correo);
                                $(controls.txtTelefono).val(entidad.telefono1);
                                $(controls.txtCelular).val(entidad.telefono2);
                                $(controls.txtObservacion).val(entidad.observacion);
                                $(controls.hidIdProp).val(entidad.idPropietario);
                                listarDocumento(controls.comboTipoDoc,"seleccione",entidad.idTipoDoc);
                                listarDeparmento(controls.cboDpto,"seleccione",entidad.idDpto);
                                $(controls.txtLugarCria).val(entidad.lugarCria);
                                selectorDeTipoDocumento(entidad.idTipoDoc);
                                $(controls.txtPrefijo).val(entidad.prefijo);
                                $(controls.txtLogin).val(entidad.login);
                                $(controls.txtPwd).val(entidad.password);
                                 //console.log();
                                //console.log($(controls.ddlSituacion).val());
                                 if(entidad.fecEliminado==null){
                                    $(controls.comboSituacion).val(entidad.flagSituacion);
                                }else if(entidad.fecEliminado!=null){
                                    $(controls.comboSituacion).val(entidad.flagSituacion);
                                }

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
                                     
                                            grlEjecutarAccion(controllers.entidad, {opc:'del',key:key},function(retorno){
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
 
var update=function(){
var esSocio=false;
var esCriador=false;
var esPropietario=false;

if($( "#chkSocio" ).prop( "checked" ) ){
    esSocio=true;
}
if($("#chkCriador").prop("checked")){
    esCriador=true;
}
if($("#chkPropietario").prop("checked")){
    esPropietario=true;
}

var situacion;


if($("#ddlSituacion").val()=="A"){
    situacion="A";
}
if($("#ddlSituacion").val()=="I"){
    situacion="I";
}

var data={opc:'-',
codigo:$(controls.txtCodigo).val(),
idTipoDoc:$('#'+controls.comboTipoDoc).val(),
numDoc:$(controls.txtNroDoc).val(),
apePaterno:$(controls.txtApePaterno).val(),
apeMaterno:$(controls.txtApeMaterno).val(),
nombres:$(controls.txtNombre).val(),
razonSocial:$(controls.razonSoc).val(),
correo:$(controls.txtCorreo).val(),
telefono1:$(controls.txtTelefono).val(),
telefono2:$(controls.txtCelular).val(),
observacion:$(controls.txtObservacion).val(),
esSocio:esSocio,
esCriador:esCriador,
esPropietario:esPropietario,
situacion:situacion,
idPropietario:$(controls.hidIdProp).val(),
idDpto:$('#'+controls.cboDpto).val(),
lugarCria:$(controls.txtLugarCria).val(),
prefijo:$(controls.txtPrefijo).val(),
login:$(controls.txtLogin).val(),
pwd:$(controls.txtPwd).val()
};
 //console.log(data);
if($(controls.actions).val()==actions.insert)  data.opc='ins';
if($(controls.actions).val()==actions.update)  data.opc='upd';
       if(grlValidarObligatorio(controls.modalDialog)){
            if(data.opc!="-"){

                 grlEjecutarAccion(controllers.entidad, data,function(retorno){
                        if(retorno.result===K_ResultadoAjax.exito){
                            //console.log(retorno.result);
                             alertify.success(retorno.message);
                             clearCtrlsPopup();
                             $(controls.modalDialog).modal("hide");
                             search();
                            
                        }else if(retorno.result===K_ResultadoAjax.error){
                             alertify.error(retorno.message);
                        }else if(retorno.result===K_ResultadoAjax.warning){
                             alertify.warning(retorno.message);
                        }else if(retorno.result===K_ResultadoAjax.duplicate){
                            alertify.error(retorno.message);
                        }
                        //search();
                    });
            }else{
                    alertify.error(messages.noDeterminated);
            }
        }
 }
function resetPopUp() {
    if($(controls.actions).val()==actions.update){ 

            $(controls.modalDialog +' .modal-title').html(titles.modalEdit);  
            $(controls.txtNroDoc).removeAttr("disabled");
            $(controls.txtApePaterno).removeAttr("disabled");
            $(controls.txtApeMaterno).removeAttr("disabled");
            $(controls.razonSoc).removeAttr("disabled");
            $(controls.txtNombre).removeAttr("disabled");
            $(controls.txtCorreo).removeAttr("disabled");
            $(controls.txtTelefono).removeAttr("disabled");
            $(controls.txtCelular).removeAttr("disabled");
            $(controls.txtObservacion).removeAttr("disabled");
            $(controls.buttonSave).show();
    }else if($(controls.actions).val()==actions.read){ 
            $(controls.modalDialog +' .modal-title').html(titles.modalRead);  
            $(controls.txtNroDoc).attr("disabled","disabled");
            $(controls.txtApePaterno).attr("disabled","disabled");
            $(controls.txtApeMaterno).attr("disabled","disabled");
            $(controls.razonSoc).attr("disabled","disabled");
            $(controls.txtNombre).attr("disabled","disabled");
            $(controls.txtCorreo).attr("disabled","disabled");
            $(controls.txtTelefono).attr("disabled","disabled");
            $(controls.txtCelular).attr("disabled","disabled");
           
            $(controls.razonSoc).attr("disabled","disabled");
            $(controls.txtObservacion).attr("disabled","disabled");
            $(controls.buttonSave).hide();
    }else if($(controls.actions).val()==actions.insert){ 
            $(controls.modalDialog +' .modal-title').html(titles.modalNew);  
            $(controls.txtNroDoc).removeAttr("disabled");
            $(controls.txtObservacion).removeAttr("disabled");
            $(controls.txtCorreo).removeAttr("disabled");
            $(controls.txtTelefono).removeAttr("disabled");
            $(controls.txtCelular).removeAttr("disabled");
            $(controls.buttonSave).show();
            $("#chkSocio").prop("checked",true); 
            $("#chkCriador").prop("checked",true);
            $("#chkPropietario").prop("checked",true);
    }else{
            $(controls.modalDialog +' .modal-title').html(titles.modalNoDeterminated);                          
    }
}
function search(){ 
validarSesion(function(isLogout){
    if(isLogout!="1"){
            $("#grid").jqGrid("clearGridData", true);
            $("#grid").jqGrid('setGridParam', {    
                         url: controllers.entidad, 
                         datatype: 'json',  
                         mtype: 'GET', 
                         postData: paramSearch()
             }).trigger('reloadGrid');
    }
 });

}
function clearCtrlsPopup(){
    resetPopUp();
    grlLimpiarObligatorio(controls.modalDialog);
    $(controls.txtCodigo).val("");
    $(controls.txtNroDoc).val("");
    $(controls.txtApePaterno).val("");
    $(controls.txtApeMaterno).val("");
    $(controls.razonSoc).val("");
    $(controls.txtNombre).val("");
    $(controls.txtCorreo).val("");
    $(controls.txtTelefono).val("");
    $(controls.txtCelular).val("");
    $(controls.razonSoc).val("");
    $(controls.txtObservacion).val("");
    $(controls.txtLugarCria).val("");
    $(controls.txtPrefijo).val("");
    $(controls.txtLogin).val("");
    $(controls.txtPwd).val("");
  }
function ver(){
    $(controls.actions).val(actions.read);  
    clearCtrlsPopup();
    editar();
}
function nuevo(){
   $("#chkSocio" ).prop( "checked" ,false) ;
   $("#chkCriador").prop("checked",false);
   $("#chkPropietario").prop("checked",false);

   listarDeparmento(controls.cboDpto,"seleccione");
   listarDocumento(controls.comboTipoDoc,"seleccione");
      
   $(controls.actions).val(actions.insert);  
   clearCtrlsPopup();
   $(controls.modalDialog).modal("show");
   $(controls.comboSituacion).val("A");

}
function modificar(){   
   
   $(controls.actions).val(actions.update);  
   clearCtrlsPopup();
   editar();
}
 
 

 function selectorDeTipoDocumento(comboValue){
   
 if(comboValue==0){
          $(controls.txtApePaterno).removeAttr("disabled");
          $(controls.txtApeMaterno).removeAttr("disabled");
          $(controls.txtNombre).removeAttr("disabled");
          $(controls.razonSoc).removeAttr("disabled");
          $(controls.txtApePaterno).addClass("requerido");
          $(controls.txtApeMaterno).addClass("requerido");
          $(controls.txtNombre).addClass("requerido");
      }
 if(comboValue==1){
          $(controls.razonSoc).val("");
          $(controls.txtApePaterno).removeAttr("disabled");
          $(controls.txtApeMaterno).removeAttr("disabled");
          $(controls.txtNombre).removeAttr("disabled");
          $(controls.razonSoc).attr("disabled", "disabled");
          $(controls.txtApePaterno).addClass("requerido");
          $(controls.txtApeMaterno).addClass("requerido");
          $(controls.txtNombre).addClass("requerido");
          $(controls.razonSoc).removeClass("requerido");
}
 if(comboValue==2){
          $(controls.txtApePaterno).val("");
          $(controls.txtApeMaterno).val("");
          $(controls.txtNombre).val("");
          $(controls.txtApePaterno).attr("disabled", "disabled");
          $(controls.txtApeMaterno).attr("disabled", "disabled");
          $(controls.txtNombre).attr("disabled", "disabled");
          $(controls.razonSoc).removeAttr("disabled");
          $(controls.txtApePaterno).removeClass("requerido");
          $(controls.txtApeMaterno).removeClass("requerido");
          $(controls.txtNombre).removeClass("requerido");
          $(controls.razonSoc).addClass("requerido");
 }
if(comboValue==3){
          $(controls.razonSoc).val("");
          $(controls.txtApePaterno).removeAttr("disabled");
          $(controls.txtApeMaterno).removeAttr("disabled");
          $(controls.txtNombre).removeAttr("disabled");
          $(controls.razonSoc).attr("disabled", "disabled");
          $(controls.txtApePaterno).addClass("requerido");
          $(controls.txtApeMaterno).addClass("requerido");
          $(controls.txtNombre).addClass("requerido");
          $(controls.razonSoc).removeClass("requerido");
}
 }

 function paramSearch (){
return {
            opc:'jqgrid',
            id:$("#txtIdBus").val(),
            numDoc:$("#txtNumDocBus").val(),
            nombre:$("#txtNombreBus").val(),
            rol:$("#ddlRolBus").val(),
            estado:$("#ddlEstadoBus").val(),
            prefijo:$("#txtPrefijoBus").val()
          };
 };
 function clearParamSearch (){
 
            $("#txtIdBus").val("");
            $("#txtNumDocBus").val("");
            $("#txtNombreBus").val("");
            $("#ddlRolBus").val("");
            $("#ddlEstadoBus").val("");
            $("#txtPrefijoBus").val("");
          
 };
function initDataTable(){

       jQuery("#grid").jqGrid({
                url:controllers.entidad,
                postData: paramSearch(),
                datatype: "json",
                height: "auto",
                mtype: 'GET',
                colNames:['Código', 'Tipo Doc', 'Numero','Razon Social','Prefijo','estado',
                          'Es Socio', 'Es Criador', 'Es Propietario','idProps'],
                colModel:[ 
                    {name:'id',index:'id',width:100, key: true},       
                    {name:'tipoDoc',index:'tipoDoc',width:130},
                    {name:'numDoc',index:'numDoc',width:150,align:"left"},
                    {name:'razon',index:'razon',width:450,align:"left"},
                    {name:'prefijo',index:'prefijo',width:300,align:"left"},
                    {name:'estado',index:'estado',width:150,align:"left"},                                        
                    {name:'socio',index:'socio',width:150,align:"center"},
                    {name:'criador',index:'criador',width:150,align:"center"},
                    {name:'propietario',index:'propietario',width:150,align:"center"},
                    {name:'idProps',index:'idProps',width:80,align:"left"}                    
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


 function showPassword (){

$('#check').click(function(){
    if('password' == $('#txtPass').attr('type')){
         $('#txtPass').prop('type', 'text');
    }else{
         $('#txtPass').prop('type', 'password');
    }
});
 }