/* controls: Objeto Json que contiene los  IDs de los controles que se crean en el html */
//formulario:"#divContainer",
var controls={
    actions:"#hidActionPopup",
    modalDialogNovedades:"#mvNovedades",
    modalDialogNewPropietario:"#mvNuevoPropietario",
    buttonBuscar:"#btnBuscar",
    buttonPrint:"#btnPrint",
    buttonSaveNov:"#btnGrabarNovedad",    
    buttonSaveNewProp:"#btnSaveNP",
    buttonCancelar:"#btnCancelarNov",
   
    // BUSQUEDA POR COMBO
    cboProp:"ddlProps",


    // popup new prop

    cboTipoDocumento:"cboTipoDocumento",
    hidIdNewProp:"#hidIdNewProp",
    numDoc:"#txtNumeroCedula",
    nombreProp:"#txtNombrePropietario",
    apePatProp:"#txtApellidoPaternoPropietario",
    apeMatProp:"#txtApellidoMaternoPropietario",
    direccionProp:"#txtDireccionPropietario",
    correoProp:"#txtCorreoPropietario"

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
    modalNew:"Nuevo registro de inscripcion",
    modalEdit:"Actualizacion de inscripcion",
    modalRead:"Información de inscripcion",
    modalNoDeterminated:"Titulo no determinado",
    modalNone:"",
    modalImg:"Imagen del Ejemplar",
    modalEstado: "Actualizacion de Solicitud de inscripcion"
}
var controllers={
    ejemplar:'ajax/ajaxNovedad.php',
    ejemplarJQGRID:'ajax/ajaxNovedadJQgrid.php',
    impresion:'ajax/ajaxImpresion.php',
}
var messages={
    inserted:'inscripcion registrada correctamente',
    updated:'inscripcion actualizada correctamente',
    noDeterminated:'Error de aplicación: Operación no determinada.'
}
var id='';
var flag='CA';
$(function(){
 $(".nav-tabs a").click(function(){
//  console.log($(this).text());
  //console.log($(this).attr('id'));
    $(this).tab('show');
    
    if($(this).attr('id')=="castracion"){
      flag='CA';
      $(".lblAnio").html("Año Castración");
      $(".lblMes").html("Mes Castración");
      $("#jqgh_grid_fecha").html("Fecha Castración");
      //$("#grid").hideCol("nomContacto");
      search(flag);
    }else if($(this).attr('id')=="fallecido"){
      flag='FA';
      $(".lblAnio").html("Año Fallecimiento");
      $(".lblMes").html("Mes Fallecimiento");
      $("#jqgh_grid_fecha").html("Fecha Fallecido");
     // $("#grid").hideCol("nomContacto");
      search(flag);
    }else if($(this).attr('id')=="transferido"){
      flag='TR';
      $(".lblAnio").html("Año Transferencia");
      $(".lblMes").html("Mes Transferencia");
      //$("#jqgh_grid_fecha").html("Fecha transferido");
     // $("#grid").showCol("nomContacto");
      search(flag);
    }
    
  });

 listarPropietario(controls.cboProp, "TODOS", 0);
 listarDocumento(controls.cboTipoDocumento,"Seleccione",'');
//cantidadRegistrosxAprooRech();
cantidadRegistrosxAprooRech();
cantidadAllNovedades();
$(controls.buttonPrint).on(events.click,function (){  
    if($("#ddlProps").val()=='0'){
      alertify.warning("Debe Seleccionar un propietario");
    }else{
        //console.log(flag);
        if(flag=="TR"){
          viewForm5(5,$("#ddlProps").val(),1);    
        }else if(flag=="CA" || flag==''){
          viewForm7(7,$("#ddlProps").val(),1,'CA')
        }else if(flag=="FA"){
          viewForm7(7,$("#ddlProps").val(),1,'FA');
        }
      
    }


});
$(controls.buttonBuscar).on(events.click,function (){  
 // console
 //console.log(flag);
  if(flag=='CA'){
    search('CA');  
  }else if(flag=='FA'){
    search('FA');  
  }else if(flag=='TR'){
    search('TR');  
  }else{
    search("CA");  
  }
  
});        

initDataTable("CA"); /*INIT DATATABLE GRILLA PRINCIPAL*/
//initDataTable2("FA");  
//initDataTable3("TR");  


//filtros
$("#txtAnioBus").on(events.keypress,function (e){ if (e.which == 13) {
    if(flag=='CA'){
    search('CA');  
  }else if(flag=='FA'){
    search('FA');  
  }else if(flag=='TR'){
    search('TR');  
  }else{
    search("CA");  
  }
}});
$("#txtMesBus").on(events.keypress,function (e){ if (e.which == 13) { 
  if(flag=='CA'){
    search('CA');  
  }else if(flag=='FA'){
    search('FA');  
  }else if(flag=='TR'){
    search('TR');  
  }else{
    search("CA");  
  }
}});


$(controls.buttonSaveNov).on(events.click,function (){  
  guardarNovedad();
});
$(controls.buttonSaveNewProp).on(events.click,function(){
  updateDatosNewProp();
});


$(controls.buttonCancelar).on(events.click,function(){
  //clearParamSearch();
  if(flag=='CA'){
    clearParamSearch();
    search('CA');  
  }else if(flag=='FA'){
    clearParamSearch();
    search('FA');  
  }else if(flag=='TR'){
    clearParamSearch();
    search('TR');  
  }else{
    clearParamSearch();
    search("CA");  
  }
});

clearCtrlsPopup();
});




function search(flag){
 validarSesion(function(isLogout){
    if(isLogout!="1"){
               if(flag=="TR"){
                  $('#gbox_gridTransfer').show();
                  $('#gbox_grid').hide();
                  initDataTableTransfer(flag); 
                  $("#gridTransfer").jqGrid('setGridParam', {    
                               url: controllers.ejemplarJQGRID, 
                               datatype: 'json',  
                               mtype: 'GET', 
                               postData: paramSearch(flag)
                   }).trigger('reloadGrid');//.jqGrid('GridUnload'); 
              }
              else{
                  $('#gbox_gridTransfer').hide();
                  $('#gbox_grid').show();
                  $("#grid").jqGrid('setGridParam', {    
                               url: controllers.ejemplarJQGRID, 
                               datatype: 'json',  
                               mtype: 'GET', 
                               postData: paramSearch(flag)
                   }).trigger('reloadGrid');//.jqGrid('GridUnload');        
              }

       }
 });
}


function paramSearch (flag){
  //console.log(flag);
  //console.log($("#ddlProps").val());
  if(flag==undefined){
    flag="CA";
  }
 

return {
            anio:$("#txtAnioBus").val(),
            mes:$("#txtMesBus").val(),
            prop: $("#ddlProps").val(), //vprop,//eval($('#'+controls.cboProp).val()),
            flag:flag
          };
 };
 function clearParamSearch (){
 
            $("#txtAnioBus").val("");
            $("#txtMesBus").val("");
           $('#ddlProps').val(0);
           $('#ddlProps').selectpicker('refresh');
 };
function  initDataTable(flag){
    //console.log(flag);
      if(flag=="CA"){
        var col ="Fecha Castración";
        var ishidden=true;
      }else if(flag=="FA"){
        var col ="Fecha Fallecido";
        var ishidden=true;
      }else{
        var col ="Fecha Transferido";
        var ishidden=false;
      }
      

      jQuery("#grid").jqGrid({
                url:controllers.ejemplarJQGRID,
                postData: paramSearch(flag),
                datatype: "json",
                height: "auto",
                resizable: true,
                mtype: 'GET',
                colNames:['id','Código','Pref.','Ejemplar', col, 'Fecha Registro','Propietario','Nuevo Propietario','comentarioSocio','ruta','Estado','Comentario','Fecha Revisión','flagNewProp','codContacto','Acción'],
                colModel:[ 
                    {name:'id',index:'id',width:150, key: true, hidden:true}, 
                    {name:'codigo',index:'codigo',width:150},      
                    {name:'prefijo',index:'prefijo',width:50},       
                    {name:'nombre',index:'nombre',width:250}, 
                    {name:'fecha',index:'fecha',width:200,align:"left"},
                    {name:'fecCrea',index:'fecCrea',width:200,align:"left"},
                    {name:'propietarios',index:'propietarios',width:300,align:"left"},
                    {name:'nomContacto',index:'nomContacto',width:300,align:"left",fixed:true, hidden:true,

                        formatter: function (cellvalue, options, rowObject) {
                           //console.log(rowObject);
                            if(rowObject[13] == "1" && rowObject[10]=="REGISTRADO" ){
                                var rowTable=""+rowObject[7]+"  <span title='Editar' class='btn btn-primary btn-xs glyphicon glyphicon-pencil' data-toggle='tooltip'  data-id="+rowObject[0]+" data-prop="+rowObject[14]+" onclick='getInfoNewProp(this);'></span>"; 
                                return rowTable;          
                          }else{
                            //console.log(rowObject[7]);
                            var rowTable=""+rowObject[7]+"";
                            if(rowObject[7]==null){
                              var rowTable="";
                            }else{
                              var rowTable=""+rowObject[7]+"";
                            }
                           return rowTable;    
                          }
                            
                         }

                    },
                    {name:'comentarioSocio',index:'comentarioSocio',hidden:true},
                    {name:'ruta',index:'ruta',hidden:true},
                    {name:'estado',index:'estado',width:150,align:"left"},
                    {name:'comentario',index:'comentario',width:380,align:"left"},
                    {name:'fecRevision',index:'fecRevision',width:150,align:"left"},
                    {name:'flagNewProp',index:'flagNewProp',hidden:true},
                    {name:'codContacto',index:'codContacto',hidden:true},
                    {name:'editar',index:'editar',width:130,align:"center",fixed: true, 
                    formatter: function (cellvalue, options, rowObject) {

                       // console.log(rowObject);
                          if(rowObject[10] == "REGISTRADO"){
                            var rowTable="<span title='Aprobar' class='btn btn-success btn-xs glyphicon glyphicon-ok' data-toggle='tooltip' data-id="+rowObject[0]+" data-codigo="+rowObject[1]+" data-accion='A' data-flag='"+flag+"'' onclick='updateHistorial(this);' ></span>"; 
                           rowTable=rowTable+"<span title='Rechazar' class='btn btn-xs btn-danger glyphicon glyphicon-remove' data-toggle='tooltip'  data-id="+rowObject[0]+" data-codigo="+rowObject[1]+"  data-accion='R' data-flag='"+flag+"'' onclick='updateHistorial(this);' style='margin-left:10px;' ></span> ";
                           return rowTable;
                           }else{
                            var rowTable = '';
                            return rowTable;
                           }             
                      
                     
                      }
                    }
                    
                ],
                afterInsertRow: function(rowId,data){
                              var rows = $("#grid").getDataIDs(); 
                              for (var i = 0; i < rows.length; i++)
                            {
                                var status = $("#grid").getCell(rows[i],"estado");
                                if(status == "REGISTRADO")
                                {
                                    $("#grid").setCell(rowId,'estado',"<span class='badge badge-info' style='background-color:#ffc107;'>"+status+"</span>");  
                                }else if(status == "APROBADO"){
                                    $("#grid").setCell(rowId,'estado',"<span class='badge badge-warning' style='background-color:#28a745;'>"+status+"</span>");            
                                }else if(status == "RECHAZADO"){
                                    $("#grid").setCell(rowId,'estado',"<span class='badge badge-warning' style='background-color:#dc3545;'>"+status+"</span>");            
                                }

                            }
                          },
                rowNum:15,
                pager: '#opc_pag',
                sortname: 'id',
                sortorder: "ASC",
                viewrecords: true,          
                caption:"Resultado de Búsqueda",
                autowidth: true,
                shrinkToFit: true,
                fixed:true,
                height: '350',

            });
 }

 function  initDataTableTransfer(flag){
     

      jQuery("#gridTransfer").jqGrid({
                url:controllers.ejemplarJQGRID,
                postData: paramSearch(flag),
                datatype: "json",
                height: "auto",
                resizable: true,
                mtype: 'GET',
                colNames:['id','Código','Pref.','Ejemplar', 'Fec. Transfer', 'Fec. Registro','Propietario','Nuevo Propietario','Comentario Socio','Comprobante','Estado','Comentario ANECPCP','Fec. Revisión','flagNewProp','codContacto','Acción'],
                colModel:[ 
                    {name:'id',index:'id',width:150, key: true, hidden:true}, 
                    {name:'codigo',index:'codigo',width:120},      
                    {name:'prefijo',index:'prefijo',width:50},       
                    {name:'nombre',index:'nombre',width:250}, 
                    {name:'fecha',index:'fecha',width:120,align:"left"},
                    {name:'fecCrea',index:'fecCrea',width:120,align:"left"},
                    {name:'propietarios',index:'propietarios',width:300,align:"left"},
                    {name:'nomContacto',index:'nomContacto',width:300,align:"left",fixed:true,

                        formatter: function (cellvalue, options, rowObject) {
                           //console.log(rowObject);
                            if(rowObject[13] == "1" && rowObject[10]=="REGISTRADO" ){
                                var rowTable=""+rowObject[7]+"  <span title='Editar' class='btn btn-primary btn-xs glyphicon glyphicon-pencil' data-toggle='tooltip'  data-id="+rowObject[0]+" data-prop="+rowObject[14]+" onclick='getInfoNewProp(this);'></span>"; 
                                return rowTable;          
                          }else{
                            //console.log(rowObject[7]);
                            var rowTable=""+rowObject[7]+"";
                            if(rowObject[7]==null){
                              var rowTable="";
                            }else{
                              var rowTable=""+rowObject[7]+"";
                            }
                           return rowTable;    
                          }
                            
                         }

                    },
                    {name:'comentarioSocio',index:'comentarioSocio',width:380},
                    {name:'ruta',index:'ruta',width:150,fixed:true,
                      formatter: function (cellvalue, options, rowObject) {
                          //console.log(rowObject);
                          var rowTable="<a href="+rowObject[15]+""+rowObject[9]+" target='_blank'>Ver Comprobante</a>"; 
                          return rowTable;          
                            
                         }
                    },
                    {name:'estado',index:'estado',width:150,align:"left"},
                    {name:'comentario',index:'comentario',width:380,align:"left"},
                    {name:'fecRevision',index:'fecRevision',width:100,align:"left"},
                    {name:'flagNewProp',index:'flagNewProp',hidden:true},
                    {name:'codContacto',index:'codContacto',hidden:true},
                    {name:'editar',index:'editar',width:80,align:"center",fixed: true, 
                    formatter: function (cellvalue, options, rowObject) {

                        //console.log(rowObject);
                          if(rowObject[10] == "REGISTRADO"){
                            var rowTable="<span title='Aprobar' class='btn btn-success btn-xs glyphicon glyphicon-ok' data-toggle='tooltip' data-id="+rowObject[0]+" data-codigo="+rowObject[1]+" data-accion='A' data-flag='"+flag+"'' onclick='updateHistorial(this);' ></span>"; 
                           rowTable=rowTable+"<span title='Rechazar' class='btn btn-xs btn-danger glyphicon glyphicon-remove' data-toggle='tooltip'  data-id="+rowObject[0]+" data-codigo="+rowObject[1]+"  data-accion='R' data-flag='"+flag+"'' onclick='updateHistorial(this);' style='margin-left:10px;' ></span> ";
                           return rowTable;
                           }else{
                            var rowTable = '';
                            return rowTable;
                           }             
                      
                     
                      }
                    }
                    
                ],
                afterInsertRow: function(rowId,data){
                              var rows = $("#gridTransfer").getDataIDs(); 
                              for (var i = 0; i < rows.length; i++)
                            {
                                var status = $("#gridTransfer").getCell(rows[i],"estado");
                                if(status == "REGISTRADO")
                                {
                                    $("#gridTransfer").setCell(rowId,'estado',"<span class='badge badge-info' style='background-color:#ffc107;'>"+status+"</span>");  
                                }else if(status == "APROBADO"){
                                    $("#gridTransfer").setCell(rowId,'estado',"<span class='badge badge-warning' style='background-color:#28a745;'>"+status+"</span>");            
                                }else if(status == "RECHAZADO"){
                                    $("#gridTransfer").setCell(rowId,'estado',"<span class='badge badge-warning' style='background-color:#dc3545;'>"+status+"</span>");            
                                }

                            }
                          },
                rowNum:15,
                pager: '#opc_pagTransfer',
                sortname: 'id',
                sortorder: "ASC",
                viewrecords: true,          
                caption:"Resultado de Búsqueda",
                autowidth: true,
                shrinkToFit: true,
                fixed:true,
                height: '350',

            });
 }


function clearCtrlsPopup(){
   $("#txtAreaComentario").html("");
   $("#txtAreaComentario").val("");
   $("#txtAreaComentario").text("");
   $("#hidKey").val("");
   $("#hidFlag").val("");
   $("#hidAccion").val("");
}
 

 

function updateHistorial(obj){
  
  clearCtrlsPopup();
  //console.log(obj);
  var codigoEjemplar=$(obj).data("codigo");
  var key=$(obj).data("id");
  var accion=$(obj).data("accion");
  var msgAccion=accion=='A'?"aprobar":"rechazar";
  var msgQuestion="";
  var comentario = $("#txtAreaComentario").val();
  var fecha = $("#dtFechaNov").val();
  $("#hidKey").val(key);
  $("#hidFlag").val(flag);
  $("#hidAccion").val(accion);

  if(flag=='CA')msgQuestion= '¿Está seguro que desea '+msgAccion+' el  reporte de castración del ejemplar: '+codigoEjemplar+'?'; 
  if(flag=='FA')msgQuestion= '¿Está seguro que desea '+msgAccion+' el  reporte de fallecimiento del ejemplar: '+codigoEjemplar+'?'; 
  if(flag=='TR')msgQuestion= '¿Está seguro que desea '+msgAccion+' el  reporte de transferencia del ejemplar: '+codigoEjemplar+'?'; 

  if(flag=='CA')$("#lbltextoFecha").html("Fecha de Castración");
  if(flag=='FA')$("#lbltextoFecha").html("Fecha de Fallecimiento");
  if(flag=='TR')$("#lbltextoFecha").html("Fecha de Transferencia");
  
  if(accion=='A'){
    $("#lblTextoMotivo").html("Ingrese motivo de aprobación.:");
    $("#btnGrabarNovedad").removeClass("btn btn-danger"); 
    $("#btnGrabarNovedad").addClass("btn btn-success");
  }
  if(accion=='R'){
    $("#lblTextoMotivo").html("Ingrese motivo de rechazo.:");
    $("#btnGrabarNovedad").removeClass("btn btn-success"); 
    $("#btnGrabarNovedad").addClass("btn btn-danger"); 
  }
  if(accion=='R'){
      $("#txtAreaComentario").addClass("requerido");
  }else{
      $("#txtAreaComentario").removeClass("requerido");
      //$("#txtAreaComentario").removeClass("form-control");
    }

  

  $(controls.modalDialogNovedades).modal('show');
 // $(controls.modalDialogNovedades).modal({backdrop: 'static', keyboard: false})
  $("#txtMensaje").html(msgQuestion);
  getFechaFallecimiento(key,flag);

}


function getFechaFallecimiento(key,flag){
           grlEjecutarAccion(controllers.ejemplar, 
                                              {opc:'getFecha',id:key,
                                              flag:flag},function(retorno){
                                               // var id = retorno.result;
                                               //console.log(retorno.data.fecha);
                                  if(retorno.result===K_ResultadoAjax.exito){
                                       if(flag=='CA'){
                                        $("#dtFechaNov").val(retorno.data.fecha);
                                      }else if(flag=='FA'){
                                        $("#dtFechaNov").val(retorno.data.fecha);
                                      }else if(flag=='TR'){
                                        $("#dtFechaNov").val(retorno.data.fecha);
                                      }
                                  }
                          

                  });
}


function guardarNovedad(){
  var key = $("#hidKey").val();
  var flag= $("#hidFlag").val();
  var accion= $("#hidAccion").val();
  var fecha = $("#dtFechaNov").val();
  var comentario = $("#txtAreaComentario").val();
  var mensajeBorrar = 'El procesamiento de este registro es irreversible y afectará a la base de datos del registro genealógico ¿Desea Continuar con el procesamiento?';
      //console.log(grlValidarObligatorio(controls.modalDialogNovedades));
      if(grlValidarObligatorio(controls.modalDialogNovedades)){
            alertify.confirm(mensajeBorrar, function (e) { 
              
               if (e) {
                        
                        $("#mvNovedades").css('display','block');
                                    grlEjecutarAccion(controllers.ejemplar, 
                                                          {opc:'updHist',id:key,
                                                          accion:accion,
                                                          flag:flag,
                                                          prop:$("#hidIdUsu").val(),
                                                          fecha:fecha,
                                                          comentario:comentario
                                                          },function(retorno){
                                                           // var id = retorno.result;
                                              if(retorno.result===K_ResultadoAjax.exito){
                                                   //search();
                                                   if(flag=='CA'){
                                                    search('CA');  
                                                  }else if(flag=='FA'){
                                                    search('FA');  
                                                  }else if(flag=='TR'){
                                                    search('TR');  
                                                  }else{
                                                    search("CA");  
                                                  }
                                                  cantidadRegistrosxAprooRech();
                                                  cantidadAllNovedades();
                                                  alertify.success(retorno.message);
                                                  $("#mvNovedades").modal("hide");
                                              }else{
                                                alertify.warning(retorno.message);

                                              }
                                      

                                  });
                      
                      }
                      
            });
      }
  
}

//$("#btnPrint").on("click",function(){ viewForm(5,$("#hidIdProp").val(),$("#hidIdPoe").val());});//.button({icons: { primary: "ui-icon-print" }});


function viewForm5(idForm,idUser,idPoe,tipo){

var response="";
if(idForm==5){
      $.ajax({
        data:  {opc:'lstView',idPoe:idPoe,idProp:idUser,tipo:tipo},
       // url:   '../../caballos/sge.web/modules/poe/ajaxPOE/ajaxFormulario5.php',
       // url:   '../../caballos/sge.ec/ajax/ajaxFormulario5.php',
        url:   '../../fase2/sge.ec/ajax/ajaxFormulario5.php',
        type:  'post',
        success:  function (response) {
          printRpt5(response,700,500);
             
             
        }
    });
}


return false; 
 
} 


function printRpt5(response,iwidth,iheight){
    var reporte = window.open('../../../sge.ec/vista/formRpt.php','1456621267083','width='+iwidth+',height='+iheight+',toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');
            reporte.document.write("<div id='xresult'>"+response+"</div>");
            var lnk=reporte.document.getElementById("lnkPrint");
            if(lnk!=null) lnk.style.display='none';
          reporte.print();
            reporte.focus();
}


function viewForm7(idForm,idUser,idPoe,tipo){

var response="";
if(idForm==7){
      $.ajax({
        data:  {opc:'lstView',idPoe:idPoe,idProp:idUser,tipo:tipo},
        //url:   '../../caballos/sge.web/modules/poe/ajaxPOE/ajaxFormulario7.php',
        //url:   '../../caballos/sge.ec/ajax/ajaxFormulario7.php',
        url:   '../../fase2/sge.ec/ajax/ajaxFormulario7.php',
        type:  'post',
        success:  function (response) {
          printRpt7(response,700,500);
             
             
        }
    });
}


return false; 
 
} 


function printRpt7(response,iwidth,iheight){
    var reporte = window.open('.../../../sge.ec/vista/formRpt.php','1456621267083','width='+iwidth+',height='+iheight+',toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');
            reporte.document.write("<div id='xresult'>"+response+"</div>");
            var lnk=reporte.document.getElementById("lnkPrint");
            if(lnk!=null) lnk.style.display='none';
          reporte.print();
            reporte.focus();
}


function cantidadRegistrosxAprooRech(){
  
    grlEjecutarAccion(controllers.ejemplar, {opc:'getCant'},function(retorno){
          //var retorno=JSON.parse(retorno);
//  console.log(retorno);
          
        $.each(retorno.data,function(index,value){

          //console.log(value.cantidad);

          if(value.cantidad>=0 && value.tipo=='CA'){
            $("#cantCap").text(value.cantidad);
          }else if(value.cantidad>=0 && value.tipo=='FA'){
            $("#cantFall").text(value.cantidad);
          }else if(value.cantidad>=0 && value.tipo=='TR'){
            $("#cantTran").text(value.cantidad);
          }


        });


    });
}


function cantidadAllNovedades(){
  
  $.ajax({
     data: {opc: "allNov"},
     url: 'ajax/ajaxNovedad.php',
     type: 'post',
     beforeSend: function(){},
     success: function(response){
        //console.log(response);
        var data = JSON.parse(response);
       // console.log(data.result);
        $("#cantNovedades").text(data.result);
     }
  });
  
  
};


function getInfoNewProp(obj){
  $(controls.modalDialogNewPropietario).modal('show');
 var idProp=$(obj).data("prop");
 //console.log(idProp);
 $.ajax({
     data: {opc: "getNewProp",idProp:idProp},
     url: 'ajax/ajaxNovedad.php',
     type: 'post',
     beforeSend: function(){},
     success: function(response){
        var retorno = JSON.parse(response);
        //console.log(retorno.data.numDoc);
        //console.log(data.numDoc);
        $(controls.hidIdNewProp).val(retorno.data.id);
        listarDocumento(controls.cboTipoDocumento,'',retorno.data.idTipoDoc);
        $(controls.numDoc).val(retorno.data.numDoc);
        $(controls.nombreProp).val(retorno.data.nombres);
        $(controls.apePatProp).val(retorno.data.apePaterno);
        $(controls.apeMatProp).val(retorno.data.apeMaterno);
        $(controls.direccionProp).val(retorno.data.observacion);
        $(controls.correoProp).val(retorno.data.correo);
     }
  });
}


function updateDatosNewProp(){
  

 $.ajax({
     data: {opc: "updNewProp",
     id:$("#hidIdNewProp").val(),
     tipoDoc:$("#cboTipoDocumento").val(),
     numDoc:$("#txtNumeroCedula").val(),
     nombreProp:$("#txtNombrePropietario").val(),
     apePatProp:$("#txtApellidoPaternoPropietario").val(),
     apeMatProp:$("#txtApellidoMaternoPropietario").val(),
     direccion:$("#txtDireccionPropietario").val(),
     correo:$("#txtCorreoPropietario").val(),
     idProp:$("#hidIdUsu").val()},
     url: 'ajax/ajaxNovedad.php',
     type: 'post',
     beforeSend: function(){},
     success: function(response){
      var retorno = JSON.parse(response);
        if(retorno.result===1){
          alertify.success(retorno.message);
           $(controls.modalDialogNewPropietario).modal('hide');
           search('TR');
        }

     }
  });
}