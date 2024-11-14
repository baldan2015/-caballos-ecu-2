/* controls: Objeto Json que contiene los  IDs de los controles que se crean en el html */
var controls={
    actions:"#hidActionPopup",
    modalDialog:"#dialogNuevo",
    modalConfirmarDialog:"#dialogConfirmar",
    buttonSaveTranfer:"#btnSaveTransfer",
    buttonConfirmTranfer:"#btnConfirmTransfer",
    btnPrint:"#btnPrint",
    buttonNew:"#btnNuevo",
    btnConfirmar: "#btnConfirmar",
    buttonDel:"#btnEliminar",
    buttonEdit:"#btnEditar",
    buttonView:"#btnVer",
    buttonCancel:"#btnCancelar",    
    hidId:"#hidId",
    hidIdEjamplar:"#hidIdEjamplar",
    hidIdPropAntiguo:"#hidIdPropAntiguo",
    hidIdCriadorAntiguo:"#hidIdCriadorAntiguo",
    hidIdPropNuevo:"#hidIdPropNuevo",
    hidIdCriadorNuevo:"#hidIdCriadorNuevo",
    txtFecha:"#txtFecha",
    lblEjemplar:"#lblEjemplar",
    lblPropietario:"#lblPropietario",
    lblEstado:"#lblEstado",
    hidEstado:"#hidEstado",
    txtFechaTransfer: "#txtFechaTransf",

    lblEjemplarTransfer: "#lblEjemplarTransfer",    
    lblEstadoDescTransfer:"#lblEstadoDescTransfer",

    txtIdBus:"#txtIdBus",
    txtCodigoBus:"#txtCodigoBus",
    txtPrefijoBus: "#txtPrefijoBus",
    txtEjemplarBus: "#txtEjemplarBus",
    txtFechaBus: "#txtFechaBus",
    lblPropBus:"#lblPropBus"

};

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
    modalNew:"Nueva transferencia",
    modalEdit:"Actualización de transferencia",
    modalConfirmar:"Confirmación de transferencia",
    modalRead:"Información de transferencia",
    modalNoDeterminated:"Titulo no determinado",
    modalNone:""
}

var controllers={
    transferencia:'ajax/ajaxTransferencia.php'
}

var messages={
    inserted:'transferencia registrado correctamente',
    updated:'transferencia actualizado correctamente',
    confirmed:'transferencia confirmado correctamente',
    noDeterminated:'Error de aplicación: Operación no determinada.'
}

$(function(){
  
    $(controls.buttonConfirmTranfer).on(events.click,function (){  confirmarSave($(controls.modalConfirmarDialog));     });   
    $(controls.buttonSaveTranfer).on(events.click,function (){  update($(controls.modalDialog));     });
    $(controls.buttonNew).on(events.click,function (){  nuevo();});
    $(controls.buttonEdit).on(events.click,function (){ modificar();});
    $(controls.buttonView).on(events.click,function (){ search();});
    $(controls.btnPrint).on(events.click,function (){ printTransferencia();});

    
    $(controls.buttonDel).on(events.click,function (){  eliminar();});
    //$(controls.btnConfirmar).on(events.click,function (){  confirmarPopup();});
    $(controls.buttonCancel).on(events.click,function (){ 
        clearParamSearch();
        search();
    });
    $(controls.txtNombre).on(events.keypress,function (e){ if (e.which == 13) {   update($(controls.modalDialog));       }});
    initDataTable();
    
//filtros 
$("#txtIdBus").on(events.keypress,function (e){ if (e.which == 13) {  search();       }});
$("#txtCodigoBus").on(events.keypress,function (e){ if (e.which == 13) {  search();       }});
$("#txtPrefijoBus").on(events.keypress,function (e){ if (e.which == 13) {  search();       }});
$("#txtEjemplarBus").on(events.keypress,function (e){ if (e.which == 13) {  search();       }});
$("#txtFechaBus").on(events.keypress,function (e){ if (e.which == 13) {  search();       }});
//---------


      $( "#btnEjemplar").on( "click", function() {
              $("#hidOrigenBuscador").val("");
              $("#mvBuscadorEjemplarGrl" ).modal('show');
              $("#txtBGNombreEjemplar").val("");
               initDataTableGrlEjemplar();

      
    });
    $( "#btnPropie" ).on( "click", function() {
      $("#hidOrigenBuscador").val("1");
      $("#mvBuscadorEntidadGrl").data("source","1");
      $("#mvBuscadorEntidadGrl" ).modal('show');
      $("#txtBGNombreEjemplar").val("");
       initDataTableGrlEjemplar();
    });

    $( "#btnGralPropieBus" ).on( "click", function() {  openGrlPropietarioFilter();    });

  $("#lblBorrarPropBus").on('click',function(){
  $("#lblPropBus").html("");
  $("#lblBorrarPropBus").hide();
  $("#hidIdPropBus").val("");
  $("#hidIdEnteBus").val("");
});
});

function editar(){
var key = $("#grid").jqGrid('getGridParam',"selrow");
    if(key){
                    grlEjecutarAccion(controllers.transferencia, {opc:'get',key:key},function(retorno){
                        if(retorno.result===K_ResultadoAjax.exito){
                            var transferencia=retorno.data;
                           // console.log(retorno.nuevoProp);
                            if(transferencia!=null){
                                $(controls.hidId).val(transferencia.id);
                                $(controls.hidIdEjamplar).val(transferencia.idEjemplar);                                 
                                $(controls.lblEjemplar).html(transferencia.prefijo+" "+transferencia.nombre+" "+transferencia.idEjemplar);                                
                                $(controls.hidIdPropAntiguo).val(transferencia.idAntiguoProp);
                                $(controls.lblPropietario).html(transferencia.antiguoProp);
                                $(controls.hidIdPropNuevo).val(transferencia.idNuevoProp);
                                $(controls.txtFecha).val(transferencia.fechaRegistro);
                                $(controls.txtFechaTransfer).val(transferencia.fechaTransferencia);                                                                
                                $(controls.hidEstado).val(transferencia.estado);
                                $(controls.lblEstadoDesc).html(transferencia.estadoDesc);
                                if(transferencia.nuevoProp!=null){
                                      $(".gridHtmlBGProp tbody").html("");
                                      $(".gridHtmlBGProp tbody").append(transferencia.nuevoProp);
                                    $('.btnQuit_1').each(function(i, obj) {
                                    $(obj).on("click",function(){
                                    var indice=$(this).data("key");
                                    var source=$(this).data("source");
                                    var index=$(this).data("index");
                                    quitarTmpProp(indice,source,index);  
                                    }).button();});
                                  }
                              }

                        }else if(retorno.result===K_ResultadoAjax.error){
                             alertify.error(retorno.message);
                        }
                    });
                     resetPopUp();
                     $(controls.modalDialog).modal("show");
        }else{
            alertify.warning("Seleccione una transferencia");
        }
 }

 function eliminar(){

    var key = $("#grid").jqGrid('getGridParam',"selrow");
    if(key){
        grlEjecutarAccion(controllers.transferencia, {opc:'get1',key:key},function(retorno){

            var transferencia=retorno.data;
            if(transferencia.estado == 'B'){
                //Valida que esté confirmado
                alertify.error("No se puede anular. La transferencia ya se encuentra anulado.");
                return false;
            }else{
                alertify.confirm('Advertencia', 'Está seguro de anular los registro seleccionado?', 
                    function(){
                            grlEjecutarAccion(controllers.transferencia, {opc:'del',key:key},function(retorno){
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
            }
        });


    }else{
        alertify.warning("Seleccione una transferencia");
    }

 }

/*
function getDatosconfirmar(){

    var table = $('#example').DataTable();
    var idxColumnKey ="0";//indice de la columna id
    var isOk = true;

    var key = $("#grid").jqGrid('getGridParam',"selrow");

        
            if (key){
                    //grlEjecutarAccion(controllers.transferencia, {opc:'get1',key:respuesta.key},function(retorno){
                    grlEjecutarAccion(controllers.transferencia, {opc:'get1',key:key},function(retorno){
                        if(retorno.result===K_ResultadoAjax.exito){
                            var transferencia=retorno.data;
                            if(transferencia!=null){
                                $(controls.hidId).val(transferencia.id);        
                                $(controls.lblEjemplarTransfer).html(transferencia.nombre);
                                $(controls.txtFechaTransfer).val(transferencia.fechaTransferencia); 
                                $(controls.lblEstadoDescTransfer).html(transferencia.estadoDesc);
                                $(controls.hidEstadoTransfer).html(transferencia.estado);
                                console.log(transferencia.estado);
                                if(transferencia.estado == 'C'){
                                    //Valida que esté confirmado
                                    alertify.error("Transferencia ya se encuentra confirmado.");
                                    isOk = false;
                                }
                            }

                             if (isOk){
                                resetPopUp();
                                $(controls.modalConfirmarDialog).modal("show");
                            }                           

                        }else if(retorno.result===K_ResultadoAjax.error){
                             alertify.error(retorno.message);
                        }
                    });


        }else{
            alertify.warning(K);
        }

    //});

 } 
*/
  

 function paramSearch (){

return {
            opc:'jqgrid',
            vid:$(controls.txtIdBus).val(),
            vcodigo:$(controls.txtCodigoBus).val(),
            vprefijo: $(controls.txtPrefijoBus).val(),
            vnombreEjemplar: $(controls.txtEjemplarBus).val(),
            //vnuevoProp: $("#lblPropBus").html(),
            dfechaTransferencia: $(controls.txtFechaBus).val(),
            prop:$("#hidIdPropBus").val(),
            ente:$("#hidIdEnteBus").val()    
          };
 };
 function clearParamSearch (){
 
       $(controls.txtIdBus).val("");
       $(controls.txtCodigoBus).val("");    
       $(controls.txtPrefijoBus).val("");      
       $(controls.txtEjemplarBus).val("");   
       $(controls.txtFechaBus).val("");
       $(controls.lblPropBus).html("");
      // $("#lblBorrarPropBus").html("");
 };

 function initDataTable(){
//postData: paramSearch(),
       jQuery("#grid").jqGrid({
                url:controllers.transferencia,
                postData: paramSearch(),                
                datatype: "json",
                height: "auto",
                mtype: 'GET',
                colNames:['Id', 'Código', 'Prefijo','Ejemplar','Antiguo Propietario','Nuevo Propietario',
                          'Fec. Reg.','Fec. Transfer.', 'Estado','capado'],
                colModel:[ 
                    {name:'id',index:'id',width:80, key: true},       
                    {name:'idEjemplar',index:'idEjemplar',width:130},
                    {name:'prefijo',index:'prefijo',width:80,align:"left"},
                    {name:'nombre',index:'nombre',width:250,align:"left"},
                    {name:'antiguoProp',index:'antiguoProp',width:350,align:"left"},
                    {name:'nuevoProp',index:'nuevoProp',width:350,align:"left"},                                        
                    {name:'fechaRegistro',index:'fechaRegistro',width:200,align:"left"},
                    {name:'fechaTransferencia',index:'fechaTransferencia',width:200,align:"left"},
                    {name:'estadoDesc',index:'estadoDesc',width:200,align:"left"},  
                    {name:'capado',index:'capado',hidden:true}                    
                ],
                rowNum:15,
                pager: '#opc_pag',
                sortname: 'id',
                sortorder: "ASC",
                viewrecords: true,          
                caption:"Resultado de Búsqueda",
                autowidth: true,
                shrinkToFit: true,
                height: '350' ,
                 gridComplete: function()
                {
                    var rows = $("#grid").getDataIDs(); 
                    for (var i = 0; i < rows.length; i++)
                    {
                        var idEjemplar = $("#grid").getCell(rows[i],"idEjemplar");
                        var status = $("#grid").getCell(rows[i],"capado");
                        if(status == "SI" || idEjemplar.indexOf("CN-")!=-1)
                        {
                            $("#grid").jqGrid('setRowData',rows[i],false, {  weightfont:'bold',background:'#CEF6CE'});            
                        }
                    }
                }
                 
            });

 }

function getIdEntidad(){
  var collection=Array();
          $('.gridHtmlBGProp tbody tr:has(input)').each(function(index, value) {
          var inputName = "";
          var servicio={};
              $('.cssItem ', this).each(function() {
                 
                    values =  $(this).val(); 
                    servicio.idProp=values;
                    collection.push(servicio);
                  
                  });
     });
               return (collection);

}

var update=function(objModal){

if ($(controls.hidIdEjamplar).val() == '0' || $(controls.hidIdEjamplar).val() == ''){
    alertify.error("Seleccione Ejemplar!");
    return;
}

if ($(controls.lblPropietario).html() == '' || $(controls.lblPropietario).html() == null){
    alertify.error("Ejemplar que intenta transferir no tiene propietario!");
    return;
}

var lstItemPropietario=getIdEntidad();

var data={opc:'-',
            id:$(controls.hidId).val(),
            idEjemplar:$(controls.hidIdEjamplar).val(),
            idNuevoProp:$(controls.hidIdPropNuevo).val(),
            idAntiguoProp:$(controls.hidIdPropAntiguo).val(),
            idNuevoCria:$(controls.hidIdCriadorNuevo).val(),
            idAntiguoCria:$(controls.hidIdCriadorAntiguo).val(),            
            fechaRegistro:$(controls.txtFecha).val(),
            fechaTransferencia: $(controls.txtFechaTransfer).val(), 
            estado:'A',

        };

//            entidad:JSON.stringify(lstItemPropietario)         

    if($(controls.actions).val()==actions.insert)  data.opc='ins';
    if($(controls.actions).val()==actions.update)  data.opc='upd'

       if(grlValidarObligatorio(controls.modalDialog)){
            if(data.opc!="-"){
                 grlEjecutarAccion(controllers.transferencia, data,function(retorno){
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

 var confirmarSave=function(objModal){

    var data={opc:'confirm',
                id:$(controls.hidId).val(),
                fechaTransferencia: $(controls.txtFechaTransfer).val()
            };

           if(grlValidarObligatorio(controls.modalConfirmarDialog)){

                alertify.confirm('Advertencia', 'Está seguro de confirmar la transferencia?', 
                function(){
                    if(data.opc!="-"){
                         grlEjecutarAccion(controllers.transferencia, data,function(retorno){
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
                },
                function(){
                   //nothing     
                }
            );

            }

     
 }

function resetPopUp() {
    if($(controls.actions).val()==actions.update){ 
            $(controls.modalDialog + ' .modal-title').html(titles.modalEdit);  
            $(controls.txtNombre).removeAttr("disabled");
            $("#btnPropie").attr("disabled");
            //$(".ui-dialog-buttonset button:contains('Grabar')").button().show();
    }else if($(controls.actions).val()==actions.read){ 
            $(controls.modalDialog + ' .modal-title').html(titles.modalRead); 
            $(controls.txtNombre).attr("disabled","disabled");
            //$(".ui-dialog-buttonset button:contains('Grabar')").button().hide();
    }else if($(controls.actions).val()==actions.insert){ 
        //console.log("continuar...");
            $(controls.modalDialog + ' .modal-title').html(titles.modalNew);  
            $(controls.txtNombre).removeAttr("disabled");
            $(controls.hidIdEjamplar).val('');
            $(controls.lblEjemplar).html('');
            $(controls.txtFecha).val('');
            $(controls.lblEstado).html('Confirmado');
            $(controls.hidIdPropAntiguo).val('');
            $(controls.lblPropietario).html('');

            //$(".ui-dialog-buttonset button:contains('Grabar')").button().show();
    }else{
            $(controls.modalDialog + ' .modal-title').html(titles.modalNoDeterminated);                          
    }
}

function search(){ 
    $("#grid").jqGrid("clearGridData", true);
    $("#grid").jqGrid('setGridParam', {     url: controllers.entidad, datatype: 'json',  mtype: 'GET', postData: paramSearch()
    }).trigger('reloadGrid');
}


function search1(){ 
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
    $(controls.txtFechaTransfer).val("");
    $("#lblPropBus").val("");
    $("#lblEjemplar").val("");

}
function ver(){
    $(controls.actions).val(actions.read);  
    clearCtrlsPopup();
    editar();
}
function nuevo(){
    $("#lblEstado").hide();
    $("#lblEstadoDesc").hide();
    $("#btnPropie").show();
   $("#btnEjemplar").show();
   limpiarSesionTMPEntes();
   $(controls.actions).val(actions.insert);  
   clearCtrlsPopup();
   $(controls.modalDialog).modal("show");
}
function modificar(){   
    $("#lblEstado").hide();
    //$("#lblEstadoDesc").hide();
   $("#btnPropie").hide();
   $("#btnEjemplar").hide();
   $(controls.actions).val(actions.update);  
   clearCtrlsPopup();
   editar();
}
//function confirmarPopup(){       getDatosconfirmar();}
function cancelar(){
     /*clearCtrlsPopup();     search();     initDataTable();*/
     var param=GetQueryStringParams("obj");
     document.location.href="shared.php?obj="+param;
}

 function limpiarSesionTMPEntes(){
    $.ajax({
                 data:{opc:'session'
                 },
                 url:'ajax/ajaxEntidad.php',
                 type:'post',
                 success: function(response){
                       $(".gridHtmlBGProp tbody").html("");
                       $(".gridHtmlBGCri tbody").html("");                  
                 }     
          });
}

/*
var paramShortcut={    "type": "keydown",    "propagate": false,    "target": document};
shortcut.add("Shift+N", function () {nuevo();}, paramShortcut);
shortcut.add("Shift+E", function () {modificar();}, paramShortcut);
shortcut.add("Shift+D", function () {eliminar();}, paramShortcut);
shortcut.add("Shift+V", function () {ver();}, paramShortcut);
shortcut.add("Shift+R", function () {cancelar();}, paramShortcut);
*/

function printTransferencia(){
    grlObtenerIdSelJQGrid("#grid",function (response) {
            if(response.result==1){
                grlCenterWindow(1000,600,50,'vista/impresion/transferenciaprint.php?id='+response.key,'demo_win');     
            }
    });
}

 function openGrlPropietarioFilter(){
    //console.log("... openGrlPropietarioFilter ");
        $("#mvBuscadorEntidadGrl").data("source", "3");
        $("#mvBuscadorEntidadGrl").modal('show');
      //  $("#hidOrigenBuscador").val("3");
        $("#txtBGNombreEntidad").val("");
        initDataTableGrlEntidadProp();
     //   console.log("... prop openGrlPropietarioFilter");
    }
var initCtrolesGrillaTmpRE=function(){
//  console.log(origen);
     // $('.gridHtmlBGProp tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });    
      $('.btnQuit_1').each(function(i, obj) {
      $(obj).on("click",function(){
          var indice=$(this).data("key");
          var source=$(this).data("source");
          var index=$(this).data("index");
          quitarTmpProp(indice,source,index);  
      }).button();
  });
  }

 

