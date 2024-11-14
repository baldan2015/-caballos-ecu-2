/* controls: Objeto Json que contiene los  IDs de los controles que se crean en el html */
//formulario:"#divContainer",
var controls={
    actions:"#hidActionPopup",
    modalDialog:"#mvNuevoEjemplar",
    modalDialogFac:"#mvFalleceEjemplar",
    modalDialogSuperCamp:"#mvSuperCamp",
    modalDialogPrint:"#mvPrintCertificado",
    buttonPrintTransf:"#btnPrintHorseTransf",
    modalUploadImg:"#mvUploadImagen",
    buttonPrint:"#btnPrintHorse",
    buttonPrintCE:"#btnPrintCE",
    buttonDead:"#btnFallece",
    buttonNew:"#btnNewRE2",
    buttonSave:"#btnSaveNE",
    buttonDel:"#btnEliminar",
    buttonEdit:"#btnEditarR",
    buttonView:"#btnVer",
    buttonCancel:"#btnCancelar",    
    buttonSaveFac:"#btnSaveFac",
    buttonSaveImg:"#btnUpload",
    buttonSuperCamp:"#btnSuperCamp",
    buttonLog:"#btnLog",
    /*CONTROLES MODALVIEW NEO-INSERT*/
    codigo:"#txtCodigo",
    prefijo:"#txtPrefijo",
    cboPelaje:"ddlTipoPel",
    nombre:"#txtNombre",
    madre:"#hidIdMadre",
    padre:"#hidIdPadre",
    mostraMadre:"#lblMadre",
    mostraPadre:"#lblPadre",
    borrarMadre:"#lblBorrarMadre",
    borrarPadre:"#lblBorrarPadre",
    fecNace:"#dtFechaNac",
    lugarNace:"#txtLugarNac",
    microchip:"#txtMicrochip",
    adn:"#txtAdn",
    descripcion:"#txtDescripcion",
    sexo:"#ddlGenero",
    fecCapado:"#txtFecCapado",
    fecServ:"#dtpFechServ",
    cboMetodo:"ddlMetodo",

    /*CONTROLES MODALVIEW FALLECIDO*/
    motivo:"#txtMotivo",
    fecFallece:"#dtFecha",
    ejemplar:"#lblEjemplar",
    ejemplarSuperCamp:"#lblEjemplarSC",
    fecFalleceNeo:"#txtFecFallece",
    motivoFalleceNeo:"#txtMotivoFallece",
    cboDepartamento:"ddlProvinvia",
    origen:"#ddlOrigen",
    reseniasLeft:"#ddlReseniaLeft",
    reseniasRight:"#ddlReseniaRight",
    fecReg:"#dtpFechReg",
    nroLibro:"#txtNumeroLibro",
    nroFolio:"#txtNumeroFolio",
    areaResenas:"#txtAResenia",
    // BUSQUEDA POR COMBO
    cboProp:"ddlProps",
    cboCria:"ddlCria"

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
    modalNew:"Nuevo registro de ejemplar",
    modalEdit:"Actualizacion de ejemplar",
    modalRead:"Información de ejemplar",
    modalNoDeterminated:"Titulo no determinado",
    modalNone:"",
    modalImg:"Imagen del Ejemplar"
}
var controllers={
    ejemplar:'ajax/ajaxEjemplar.php',
    ejemplarJQGRID:'ajax/ajaxEjemplarJQgrid.php',
    impresion:'ajax/ajaxImpresion.php',
}
var messages={
    inserted:'ejemplar registrada correctamente',
    updated:'ejemplar actualizada correctamente',
    noDeterminated:'Error de aplicación: Operación no determinada.'
}


$(function(){

 listarCriador(controls.cboCria, "TODOS", 0);
 listarPropietario(controls.cboProp, "TODOS", 0);
 $(".btn-pref .btn").click(function () {
  $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
  $(this).removeClass("btn-default").addClass("btn-primary");
});
$(controls.buttonSuperCamp).on(events.click,function (){  CampeonHistorico();});          
$(controls.buttonPrintCE).on(events.click,function (){  window.print();});         
$(controls.buttonPrint).on(events.click,function (){  printCertificado();});         
$(controls.buttonDead).on(events.click,function (){  fallecido();});        
$(controls.buttonNew).on(events.click,function (){ nuevo();});
$(controls.buttonSave).on(events.click,function (){  


      grlEjecutarAccion(controllers.ejemplar, {opc:'val',fecServ:$(controls.fecServ).val(),fecNace:$(controls.fecNace).val(),idmadre:$(controls.madre).val(),idHijo:$(controls.codigo).val()},function(retorno){
                                 // console.log(retorno.result);
              if(retorno.result===K_ResultadoAjax.exito){
               update();
              }else if(retorno.result===K_ResultadoAjax.error){
  alertify.confirm('Advertencia', 'La fecha de nacimiento y la fecha de servicio es inconsistente verificarlo. Desea continuar ?', 
                  function(){
               update();
                 }, 
                  function(){ 
                  //alertify.error('Cancel')
                  }
                  );
              }else if(retorno.result===K_ResultadoAjax.warning){
  alertify.confirm('Advertencia', 'Existe traslape del ejemplar a registrar con las crias de la madre'+' : '+$("#lblMadre").html() +' '+'.Desea Continua ?', 
                  function(){
               update();
                  }, 
                  function(){ 
                  //alertify.error('Cancel')
                  }
                  );
                  }
                  });

});
$(controls.buttonEdit).on(events.click,function (){modificar();});
$(controls.buttonDel).on(events.click,function (){  eliminar();});
$(controls.buttonSaveFac).on(events.click,function (){  falleceEjemplar();});
$(controls.buttonSaveImg).on(events.click,function(){uploadImagen();});
$(controls.buttonPrintTransf).on(events.click,function (){  printTransferencia();});  

$(controls.buttonView).on(events.click,function (){    search();});        
$(controls.buttonCancel).on(events.click,function (){      clearParamSearch();    search(); });
$(controls.buttonLog).on(events.click,function(){logHistorial();})
listarResenia("ddlReseniaLeft", "","");

initDataTable(); /*INIT DATATABLE GRILLA PRINCIPAL*/
limpiarLabelEjemplar(); 

//filtros
$("#txtCodigoBus").on(events.keypress,function (e){ if (e.which == 13) {  search();       }});
$("#txtPrefijoBus").on(events.keypress,function (e){ if (e.which == 13) {  search();       }});
$("#txtNombreBus").on(events.keypress,function (e){ if (e.which == 13) {  search();       }});
$("#txtMinBus").on(events.keypress,function (e){ if (e.which == 13) {  search();       }});
$("#txtMaxBus").on(events.keypress,function (e){ if (e.which == 13) {  search();       }});
//----

$("#rightSelected").on(events.click,function (){ 
 var a=0;
        $("#ddlReseniaRight option").each(function (){ 
            if($(this).val()==$('#ddlReseniaLeft option:selected').val()){
                alertify.error("La reseña se encuentra agregada");
              a=a+1;
            }
      });
      if(a==0){
        var controlLeft=$('#ddlReseniaLeft option:selected');
        $("#ddlReseniaRight").append("<option value='" +controlLeft.val() + "' title='" + controlLeft.text() + "'>" + controlLeft.text() + "</option>");

      }
 });

$("#leftSelected").on(events.click,function (){ 
      $('#ddlReseniaRight option:selected').remove(); 
 });


$("#btnSaveResena").on(events.click,function(){
  //var concatValor = '';
  var collection=Array();
  var reseniaBasica = $("#txtReseniaBasica").val();
     $("#ddlReseniaRight option").each(function(){
        if ($(this).val() != "" ){        
        resena={id:$(this).val(),descripcion:$(this).text()};        
        collection.push(resena);
        }
      });
    
     //console.log(collection);
     /*if(collection.length==0){
             $.ajax({
              data:  {opc:'insRes'},
              url:   'ajaxPOE/ajaxFormulario1.php',
              type:  'post',
              success:  function (response) {
                  var retorno=JSON.parse(response);
                    var retorno=JSON.parse(response);
                  if(retorno.result==1){
                    alertify.success("Información actualizada");
                  }else{
                    alertify.error(retorno.message);
                  }
              }
            }); 
          }else{*/
            datos=JSON.stringify(collection);
            $.ajax({
              data:  {opc:'resSession',data:datos,
              reseniaBasica: reseniaBasica},
              url:   'ajax/ajaxEjemplar.php',
              type:  'post',
              success:  function (response) {
                  var retorno=JSON.parse(response);
                  if (retorno.result == 1) {
                    $("#mvBuscadorResenaGrl").modal('hide');
                    $("#txtAResenia").val(retorno.html);
                    $('#array').val(1);
          
                    if (retorno.code == 1) {
                      $("#txtReseniaBasica").val(retorno.html);
                    } else {
                      $("#txtReseniaBasica").val('');
                    }
                  } else if (retorno.result == 0) {
                    alertify.error(retorno.message);
                  } else if (retorno.result == 2) {
                    $("#mdlMensaje").modal("show");
                    $("#btnMantBasica").on(events.click, function () {
                      $("#mvBuscadorResenaGrl").modal('hide');
                      $("#mdlMensaje").modal("hide");
                      $("#txtAResenia").val(retorno.valorB);
                      $('#array').val(1);
                      $("#txtReseniaBasica").val(retorno.valorB);
                      $("#lblResenia").html('');
                      $("#ddlReseniaRight option").remove();
                      grlEjecutarAccion('ajax/ajaxEjemplar.php', {opc:'clsSesionResena'}, function(response){
                        $("#ddlReseniaRight option").remove();
                  },'1'); 
                    });
                    $("#btnManAvanzada").on(events.click, function () {
                      $("#txtReseniaBasica").val('');
                      $("#mvBuscadorResenaGrl").modal('hide');
                      $("#mdlMensaje").modal("hide");
                      $("#txtAResenia").val(retorno.valorA);
                      $('#array').val(0);
                    });
                  }
              }
            });
          //}
     //console.log(concatValor);
});
/*INIT POPUP MODAL NUEVO EDIT EJEMPLAR*/
$(controls.modalDialog).on('show.bs.modal', function () {
    //$("#trCastrado").hide();
    $("#txtFecCapado").attr("readonly",true); 
    $(controls.sexo).on(events.change,function (){ 
        if($(this).val()=="P"){   
         //$("#trCastrado").show(); 
          $("#txtFecCapado").attr("readonly",false); 

          }else{
           //   $("#trCastrado").hide();  
           $("#txtFecCapado").attr("readonly",true);
            }
    });

  clearCtrlsPopup();
  
  if ($(this).data("action") != "insert") {
    $(controls.modalDialog+' .modal-title').html("ACTUALIZACIÓN DE EJEMPLAR");
  }else{
     $('.selectpicker').selectpicker();
     $('.selectpicker').selectpicker('val',[]);

    $(controls.origen).val("0");
   // $(controls.origen).removeAttr("disabled");
    $(controls.modalDialog+' .modal-title').html("REGISTRO DE NUEVO EJEMPLAR");
  }
});
/*FIN  POPUP MODAL NUEVO EDIT EJEMPLAR*/


/*INIT POPUP MODAL BUSCAR EJEMPLAR*/
$("#btnBuscarMadre" ).on( "click", function() {
      $("#hidOrigenBuscador").val("Y");
      $("#mvBuscadorEjemplarGrl" ).modal('show');
      $("#txtBGNombreEjemplar").val("");
       initDataTableGrlEjemplar();
});
$("#btnBuscarPadre" ).on( "click", function() { 
      $("#hidOrigenBuscador").val("P");
      $("#mvBuscadorEjemplarGrl" ).modal('show');
      $("#txtBGNombreEjemplar").val("");
       initDataTableGrlEjemplar();
    });

/*FIN POPUP MODAL BUSCAR EJEMPLAR*/

/* INIT POPUP MODAL BUSCAR ENTIDAD*/

$( "#btnGralPropie" ).on( "click", function() {   openGrlPropietario();    });
$( "#btnGralCriador" ).on( "click", function() {     openGrlCriador();    });
$( "#btnGralPropieBus" ).on( "click", function() {  openGrlPropietarioFilter();    });
$( "#btnBuscarResenia" ).on( "click", function() {     openGrlResena();    });

    
/*FIN POPUP MODAL BUSCAR ENTIDAD*/
//setDel();
$("#lblBorrarPropBus").on('click',function(){
  $("#lblPropBus").html("");
  $("#lblBorrarPropBus").hide();
  $("#hidIdPropBus").val("");
  $("#hidIdEnteBus").val("");
});
});
function search(){
 validarSesion(function(isLogout){
    if(isLogout!="1"){
            $("#grid").jqGrid("clearGridData", true);
            $("#grid").jqGrid('setGridParam', {    
                         url: controllers.ejemplarJQGRID, 
                         datatype: 'json',  
                         mtype: 'GET', 
                         postData: paramSearch()
             }).trigger('reloadGrid');
    }
 });
}
function eliminar(){
var key = $("#grid").jqGrid('getGridParam',"selrow");
    if (key){    
                    alertify.confirm('Advertencia', 'Está seguro de eliminar los registros seleccionados?', 
                        function(){
                                    
                                            grlEjecutarAccion(controllers.ejemplar, {opc:'del',key:key},function(retorno){
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
         alertify.warning("Seleccione ejemplar");
     }
 }
function paramSearch (){
 
 //console.log("cboCria: "+ $('#'+controls.cboCria).val());
 //console.log("cboProp: "+ $('#'+controls.cboProp).val());
var vprop=0;
var vente=0;
var xdato=$('#'+controls.cboProp).val();
if(xdato!=null){
  var esIdProp=xdato.charAt(0); 
  if(esIdProp=="0"){
        vprop=eval($('#'+controls.cboProp).val());
        vente=0;
  }else{
        vprop=0;
        vente=eval($('#'+controls.cboProp).val());
  }
}

return {
            idEjemplar:$("#txtCodigoBus").val(),
            prefijo:$("#txtPrefijoBus").val(),
            nombre:$("#txtNombreBus").val(),
            prop: vprop,//eval($('#'+controls.cboProp).val()),
            ente:vente,//$("#hidIdEnteBus").val(),
           
            cria:$('#'+controls.cboCria).val(),
            sexo:$("#ddlGeneroBus").val(),
            edadDesde:$("#txtMinBus").val(),
            edadhasta:$("#txtMaxBus").val(),
            estado:$("#ddlEstadoBus").val()
          };
 };
 function clearParamSearch (){
 
            $("#txtCodigoBus").val("");
            $("#txtPrefijoBus").val("");
            $("#txtNombreBus").val("");
            $("#txtPropBus").val("");
            $("#txtCriaBus").val("");
            
            $("#ddlGeneroBus").val("");
            $("#txtMinBus").val("");
            $("#txtMaxBus").val("");
            $("#ddlEstadoBus").val("");

            $("#lblPropBus").html("");
            $("#lblBorrarPropBus").hide();
            $("#hidIdPropBus").val("");
            $("#hidIdEnteBus").val("");

           $('#'+controls.cboProp).val(0);
           $('#'+controls.cboCria).val(0);

           $("#" + controls.cboProp).selectpicker('refresh');
           $("#" + controls.cboCria).selectpicker('refresh');
 };
function  initDataTable(){
      
       jQuery("#grid").jqGrid({
                url:controllers.ejemplarJQGRID,
                postData: paramSearch(),
                datatype: "json",
                height: "auto",
                mtype: 'GET',
                colNames:['Código', 'Prefijo', 'Nombre','fec. Nac','fec. Reg','Propietario','Criador',
                          'fec. Fallece', 'Pelaje', 'lugar Nac.','microchip',
                            'Capado','C.C', 'Estado'],
                colModel:[ 
                    {name:'idEjemplar',index:'idEjemplar',width:150, key: true},       
                    {name:'prefijo',index:'prefijo',width:130},
                    {name:'nombre',index:'nombre',width:300,align:"left"},
                    {name:'fecNace',index:'fecNace',width:150,align:"left"},
                    {name:'fecReg',index:'fecReg',width:150,align:"left"},
                    {name:'propietarios',index:'propietarios',width:400,align:"left"},
                    {name:'criadores',index:'criadores',width:400,align:"left"},                                        
                    {name:'fecFallece',index:'fecFallece',width:170,align:"left"},
                    {name:'pelaje',index:'pelaje',width:200,align:"left"},
                    {name:'lugarNace',index:'lugarNace',width:200,align:"left"},
                    {name:'microchip',index:'microchip',width:200,align:"left"},
                    {name:'capado',index:'capado',width:130,align:"left"},                                                                                                    
                    {name:'campeon',index:'campeon',width:50,align:"left"},
                    {name:'estado',index:'estado',width:130,align:"left"}
                    
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


 
 
function clearCtrlsPopup(){
   //esetPopUp();
    grlLimpiarObligatorio(controls.modalDialog);
    $(controls.prefijo).val("");
    $(controls.nombre).val("");
    $(controls.fecNace).val("");
    $(controls.padre).val("");
    $(controls.madre).val("");
    $(controls.pelaje).val("");
    $(controls.lugarNace).val("");
    $(controls.microchip).val("");
    $(controls.adn).val("");
    $(controls.descripcion).val("");
    $(controls.codigo).val("");
    $(controls.motivo).val("");
    $(controls.fecFallece).val("");
    $(controls.areaResenas).val("");
    $(controls.motivoFalleceNeo).val("");
    $(controls.fecServ).val("");
  }
 
 function CampeonHistorico(){

        var key = $("#grid").jqGrid('getGridParam',"selrow");
        if (key){
            grlEjecutarAccion(controllers.ejemplar, {opc:'get',codigo:key},function(retorno){
                                                if(retorno.result===K_ResultadoAjax.exito){
                                                    var ejemplar=retorno.data;
                                                    if(retorno!=null){
                                                     $(controls.modalDialogSuperCamp).data("idEjemplar",ejemplar.codigo);
                                                            
                                                      $(controls.ejemplarSuperCamp).html(ejemplar.prefijo+' '+ejemplar.nombre+' '+ejemplar.codigo);
                                                      $("#hidPrefCamp").val(ejemplar.prefijo);
                                                      $("#hidNombCamp").val(ejemplar.nombre);
                                                      $("#hidIdCamp").val(ejemplar.codigo);
                                                      $("#hidPropCamp").val("-");


                                                      listarCampeonato();
                                                    }
                                                 
                                                }
                                            });
               // clearCtrlsPopup();
                $("#txtAnioCamp").val("");
                $("#chkSoloCamp").prop('checked',false);
                $(controls.modalDialogSuperCamp).modal("show");
         }else{
                                             alertify.warning("Seleccione ejemplar");            
        }
  
 }
function fallecido(){
     
        var key = $("#grid").jqGrid('getGridParam',"selrow");
        if (key){
            grlEjecutarAccion(controllers.ejemplar, {opc:'get',codigo:key},function(retorno){
                                                if(retorno.result===K_ResultadoAjax.exito){
                                                    var ejemplar=retorno.data;
                                                    if(retorno!=null){
                                                     $(controls.modalDialogFac).data("idEjemplar",ejemplar.codigo);
                                                            
                                                      $(controls.ejemplar).html(ejemplar.prefijo+' '+ejemplar.nombre+' '+ejemplar.codigo);
                                                      $(controls.fecFallece).val(ejemplar.fecFallece);
                                                      $(controls.motivo).val(ejemplar.motivoFallece);
                                                    }
                                                 
                                                }
                                            });
               // clearCtrlsPopup();
                $(controls.modalDialogFac).modal("show");
         }else{
                                             alertify.warning("Seleccione ejemplar");            
        }
        
        
   
}

function nuevo(){
    limpiarSesionTMPEntes();
    $(controls.areaResenas).val("");
    listarPelaje("ddlTipoPel","seleccione");
    listarDeparmento("ddlProvinvia","seleccione");
    listarMetodoReprop("ddlMetodo","SELECCIONE");
    $(controls.sexo).val(0);
    $(controls.sexo).removeAttr("disabled");
    $(controls.origen).removeAttr("disabled");
    $(controls.modalDialog).data("action","insert");
    $(controls.modalDialog).modal('show');
     
  $("#txtReseniaBasica").val("");
}

function modificar(){   

limpiarSesionTMPEntes();
var key = $("#grid").jqGrid('getGridParam',"selrow");
if (key){

        $(controls.modalDialog).data("action","edit");
        $(controls.modalDialog).modal("show");
        editar(key);
       
 }else{
        alertify.warning("Seleccione ejemplar");        
}
        
 
}


 function falleceEjemplar(){
    if(grlValidarObligatorio(controls.modalDialogFac)){
  /*  alertify.confirm('Advertencia', 'Está seguro de actualizar los registros seleccionados?', 
                        function(){
                                  */
                                 var idEjemplarFallece=$(controls.modalDialogFac).data("idEjemplar");
                                 if(idEjemplarFallece!=undefined){
                                            grlEjecutarAccion(controllers.ejemplar, {opc:'die',key:idEjemplarFallece,motivo:$(controls.motivo).val(),fecFallece:$(controls.fecFallece).val()},function(retorno){
                                                if(retorno.result===K_ResultadoAjax.exito){
                                                    $(controls.modalDialogFac).modal("hide");
                                                    search();
                                                    alertify.success(retorno.message);
                                                }else if(retorno.result===K_ResultadoAjax.error){
                                                     alertify.error(retorno.message);
                                                }
                                            });
                                  }else{
                                                alertify.warning("Problemas para obtener el codigo del ejemplar para registrar el fallecimiento");
                                  }
                                        
                      /*  }, 
                        function(){ 
                            //alertify.error('Cancel')
                        }
                    );*/
    }
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


    grlEjecutarAccion('ajax/ajaxEjemplar.php', {opc:'clsSesionResena'}, function(response){
          $("#ddlReseniaRight option").remove();
    },'1'); 
}

/* nuevo*/
function editar(codigo){
                if(codigo!=undefined){
                    grlEjecutarAccion(controllers.ejemplar, {opc:'get',codigo:codigo},function(retorno){
                        if(retorno.result==K_ResultadoAjax.exito){
                           var ejemplar=retorno.data;
                            if(ejemplar!=null){
                                $(controls.codigo).val(ejemplar.codigo);
                                $(controls.prefijo).val(ejemplar.prefijo);
                                listarPelaje(controls.cboPelaje,"seleccione",ejemplar.idPelaje);
                                listarDeparmento(controls.cboDepartamento,"seleccione",ejemplar.idProvincia);
                                $(controls.nombre).val(ejemplar.nombre);
                                $(controls.madre).val(ejemplar.idMadre);
                                $(controls.padre).val(ejemplar.idPadre);

                                $(controls.mostraMadre).html(ejemplar.nombreMadre);
                                $(controls.mostraPadre).html(ejemplar.nombrePadre);
                                $(controls.borrarMadre).show();
                                $(controls.borrarPadre).show();
                                 
                                $(controls.fecNace).val(ejemplar.fecNace);
                                $(controls.lugarNace).val(ejemplar.LugarNace);
                                $(controls.microchip).val(ejemplar.microchip);
                                $(controls.adn).val(ejemplar.adn);
                                $(controls.descripcion).val(ejemplar.descripcion);
                                $(controls.fecCapado).val(ejemplar.fecCapado);

                                $(controls.fecFalleceNeo).val(ejemplar.fecFallece);                               
                                $(controls.motivoFalleceNeo).val(ejemplar.motivoFallece);                               
                                $(controls.fecReg).val(ejemplar.fecReg);
                                $(controls.nroLibro).val(ejemplar.nroLibro);
                                $(controls.nroFolio).val(ejemplar.nroFolio);

                                $(controls.sexo).val(ejemplar.genero);
                                 if(ejemplar.propietarios!=null){
                                      $(".gridHtmlBGProp tbody").html("");
                                      $(".gridHtmlBGProp tbody").append(retorno.html);
                                      initCtrolesGrillaTmpRE(1);
                                  }
                                  if(ejemplar.criadores!=null){
                                      $(".gridHtmlBGCri tbody").html("");
                                      $(".gridHtmlBGCri tbody").append(retorno.html2);
                                      initCtrolesGrillaTmpRE(2);
                                  }
                                 $(controls.sexo).attr("disabled","disabled");

                                 //$("#trCastrado").hide();
                                   $("#txtFecCapado").attr("readonly",true); 
                                 if(ejemplar.genero=="P"){  
                                   //$("#trCastrado").show();
                                   $("#txtFecCapado").attr("readonly",false); 
                                    }
                                // $(controls.idProvincia).val(ejemplar.idProvincia==""?"0":ejemplar.idProvincia);
                                 //$('.selectpicker').selectpicker();

                                 //if(ejemplar.idResenias!=null){
                                  //console.log(ejemplar.idResenias+"aaa");
                                  $(controls.areaResenas).val(ejemplar.resenasDescripcion);
                                  $(controls.fecServ).val(ejemplar.fecServ);
                                 // if(ejemplar.idResenias!=null)
                                 //console.log(ejemplar.origen);
                                  if(ejemplar.origen=="" || ejemplar.origen==null ){
                                    $(controls.origen).val(0);
                                  }else{
                                    $(controls.origen).val(ejemplar.origen);
                                  }
                                  //addon dbs 20191111 - campo origen
                                 $(controls.origen).attr("disabled","disabled");
                                /*if(ejemplar.codigo!=null){
                                    var tipoOrigen=ejemplar.codigo.substring(0,2);
                                    if(tipoOrigen=="1"){
                                        $(controls.origen).val("P");  
                                    }else if(tipoOrigen=="2"){
                                        $(controls.origen).val("P2");
                                    }
                                    else if(tipoOrigen=="3" ){
                                        $(controls.origen).val("P3"); 
                                    }
                                    else {
                                        $(controls.origen).val(tipoOrigen);  
                                    }
                                }*/
                                $("#txtReseniaBasica").val(ejemplar.reseniaBasica);
                      
                                if (ejemplar.esBasica == 0) {
                                  $("#lblResenia").text(ejemplar.resenasDescripcion);
                                } else {
                                  $("#lblResenia").text("");
                                }
                                //metodo reproductivo
                                listarMetodoReprop(controls.cboMetodo,"SELECCIONE",ejemplar.idMetodo);
                               
                        }else{ 
                             alertify.error(retorno.message);
                        }
                      }else if(retorno.result==K_ResultadoAjax.error){
                             alertify.error(retorno.message);
                        }
                    });
                }
}
 

var update=function(){
//var codigo=controls.codigo;

  
  
var lstItemPropietario=getIdEntidad();

var data={opc:'-',
codigo:$(controls.codigo).val(),
prefijo:$(controls.prefijo).val(),
nombre:$(controls.nombre).val(),
fecNace:$(controls.fecNace).val(),
padre:$(controls.padre).val(),
madre:$(controls.madre).val(),
idPelaje:$('#'+controls.cboPelaje).val(),
lugarNace:$(controls.lugarNace).val(),
microchip:$(controls.microchip).val(),
adn:$(controls.adn).val(),
descripcion:$(controls.descripcion).val(),
entidad:JSON.stringify(lstItemPropietario),
genero:$(controls.sexo).val(),
fecCapado:$(controls.fecCapado).val(),
fecFallece:$(controls.fecFalleceNeo).val(),
motivoFallece:$(controls.motivoFalleceNeo).val(),
idProvincia:$('#'+controls.cboDepartamento).val(),
origen:$(controls.origen).val(),
resenias:$(controls.areaResenas).val(),
fecReg:$(controls.fecReg).val(),
nroLibro:$(controls.nroLibro).val(),
nroFolio:$(controls.nroFolio).val(),
fecServ:$(controls.fecServ).val(),
idMetodo:$('#'+controls.cboMetodo).val(),
reseniaBasica: $("#txtReseniaBasica").val(),
tieneBasica:$("#array").val()
};
 if ($(controls.modalDialog).data("action") != "insert") {
    data.opc='upd';
  }else{
    data.opc='ins';
  }
//console.log(data);
         if(grlValidarObligatorio(controls.modalDialog)){
            if(data.opc!="-"){
                 grlEjecutarAccion(controllers.ejemplar, data,function(retorno){
                   // console.log(retorno.result);
                        if(retorno.result===K_ResultadoAjax.exito){
                              alertify.success(retorno.message);
                              $("#mvNuevoEjemplar").modal("hide");
                        }else if(retorno.result===K_ResultadoAjax.error){
                              alertify.set('notifier','delay', 10);
                              alertify.error(retorno.message);
                        }else if(retorno.result===K_ResultadoAjax.warning){
                              alertify.warning(retorno.message);
                        }else if(retorno.result===K_ResultadoAjax.duplicate){
                              alertify.error(retorno.message);
                        }
                        search();
                    });
            }else{
                    alertify.error(messages.noDeterminated);
            }
        }
        
 };
function clearCtrlsPopup(){
   grlLimpiarObligatorio(controls.modalDialog);
    $(controls.prefijo).val("");
    $(controls.nombre).val("");
    $(controls.fecNace).val("");
    $(controls.padre).val("");
    $(controls.madre).val("");
    $(controls.mostraMadre).html("");
    $(controls.mostraPadre).html("");
   
    $(controls.pelaje).val("");
    $(controls.lugarNace).val("");
    $(controls.microchip).val("");
    $(controls.adn).val("");
    $(controls.descripcion).val("");
    $(controls.codigo).val("");
    $(controls.motivo).val("");
    $(controls.fecFallece).val("");
    $(controls.origen).val("");
    $(controls.reseniasRight).val("");
    $(controls.fecReg).val("");
    $(controls.nroLibro).val("");
    $(controls.nroFolio).val("");
    $(controls.areaResenas).text("");
    $(controls.motivoFalleceNeo).val("");
    $(controls.fecServ).val("");
    //limpiarSesionTMPEntes();
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

var initCtrolesGrillaTmpRE=function(origen){
//  console.log(origen);
  if(origen==1){
      //$('.gridHtmlBGProp tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });    
      $('.btnQuit_'+origen).each(function(i, obj) {
      $(obj).on("click",function(){
          var indice=$(this).data("key");
          var source=$(this).data("source");
          var index=$(this).data("index");
          quitarTmpProp(indice,source,index);  
      }).button();});
  }else{
      //$('.gridHtmlBGCri tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
      $('.btnQuit_'+origen).each(function(i, obj) {
      $(obj).on("click",function(){
          var indice=$(this).data("key");
          var source=$(this).data("source");
          quitarTmpCri(indice,source);  
      }).button({icons: {primary: "ui-icon-closethick"},text: false});});
  }
}

function contarPropietarios(){
    var fila = 0;
    $(".gridHtmlBGProp tbody tr ").each(function (index, value) { fila = fila + 1; });
    return fila;
 
}

function printAs(idEjemplar,type){
  /*type=0..como original
  type=1..como copia original
  type=2..como copia */
   grlCenterWindow(1000,600,50,'vista/impresion/certificado.php?idHorse='+idEjemplar+'&type='+type,'demo_win');  
}
 
function printCertificado(){
alertify.defaults.transition = "slide";
alertify.defaults.theme.ok = "btn btn-danger";
alertify.defaults.theme.cancel = "btn btn-danger";
alertify.defaults.theme.input = "form-control";


    grlObtenerIdSelJQGrid("#grid",function (response) {
          if(response.result==1){
             grlEjecutarAccion(controllers.impresion, {opc:'nveces',id:response.key},function(retorno){
                  if(retorno.result!=-1){
                        /*primera vez impresion*/
                          if(retorno.result>0){
                               alertify.alert('ANECPCP::ADVERTENCIA DE IMPRESION', 
                                  'El certificado inicial del ejemplar: <b>'+response.key+'</b> ya fue impreso.'+ 
                                  'Desea imprimir una copia o un certificado como original. '+
                                  '<br><br>Esta operación quedará registrado en el sistema como parte del seguimiento a la impresión'+
                                  ' de los certificados.<br><br>'+
                                  '<center><button class="btn btn-primary" onclick=printAs("'+response.key+'",1);>IMPRIMIR ORIGINAL</button>'+ 
                                  '&nbsp;&nbsp;&nbsp;&nbsp;'+
                                  '<button class="btn btn-info" onclick=printAs("'+response.key+'",2);>IMPRIMIR COPIA</button></center>', 
                                    function(){}
                                  );
                          }else{
                              alertify.defaults.theme.ok = "btn btn-primary";
                              alertify.defaults.theme.cancel = "btn btn-danger";
                              alertify.confirm('ANECPCP::ADVETENCIA DE IMPRESION', 
                                  'Ud va realizar la impresión de certificado del ejemplar: <b>'+response.key+'</b> por primera vez. ¿Desea continuar con la impresión? <br><br>Esta operación quedará registrado en el sistema como parte del seguimiento a la impresión de los certificados.' , 
                                    function(){printAs(response.key,0);},
                                    function(){}
                                  ).set('labels', {ok:'IMPRIMIR ORIGINAL', cancel:'CANCELAR'});
                          }
                  }else{
                    alertify.error(retorno.message);
                  }
            });
             
          }
        });




 

}
function printTransferencia(){
    grlObtenerIdSelJQGrid("#grid",function (response) {
            if(response.result==1){
                grlCenterWindow(1000,600,50,'vista/impresion/transferenciaprint.php?idHorse='+response.key,'demo_win');     
            }
    });
}

function uploadImagen(){

    grlObtenerIdSelJQGrid("#grid",function (response) {
        if(response.result==1){
            //console.log(response.key);
    grlCenterWindow(1000,600,50,'vista/upload/index.php?idHorse='+response.key,'demo_win'); 
        }
});
}
function limpiarLabelEjemplar(){
  $("#lblBorrarMadre").on('click',function(){
  $("#lblMadre").html("");
  $("#lblBorrarMadre").hide();
  $("#hidIdMadre").val("0");
});
$("#lblBorrarPadre").on('click',function(){
  $("#lblPadre").html("");
  $("#lblBorrarPadre").hide();
  $("#hidIdPadre").val("0");
});
$("#lblBorrarEjemplar").on('click',function(){
  $("#lblEjemplar").html("");
  $("#lblBorrarEjemplar").hide();
});
}



function openGrlPropietario(){
    //console.log("... prop ");
        $("#mvBuscadorEntidadGrl").data("source", "1");
        $("#mvBuscadorEntidadGrl").modal('show');
        //$("#hidOrigenBuscador").val("1");
        $("#txtBGNombreEntidad").val("");
        initDataTableGrlEntidadProp();
      //  console.log("... prop salio");
    }
function openGrlCriador(){
        $("#mvBuscadorEntidadGrl").data("source", "2");
        $("#mvBuscadorEntidadGrl").modal('show');
       // $("#hidOrigenBuscador").val("2");
        $("#txtBGNombreEntidad").val("");
        initDataTableGrlEntidadCria();
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
function openGrlResena(){
listarReseniaSel("ddlReseniaRight","",""); 
  $("#mvBuscadorResenaGrl").modal('show'); 
}



function logHistorial(){
  grlObtenerIdSelJQGrid("#grid",function (response) {
            if(response.result==1){

                window.open('vista/consulta/logHistorial.php?idHorse='+response.key+'','_blank');
               //grlCenterWindow(1000,600,50,'vista/consulta/logHistorial.php?idHorse='+response.key+'','demo_win');  
            }

    });
  
}

