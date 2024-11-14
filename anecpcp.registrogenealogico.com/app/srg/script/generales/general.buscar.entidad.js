
$(function(){
  
$origen="";
$sourceDelete="";


  

$("#txtBGNombreEntidad").on("keypress",function(e){
    var target=(e.target ? e.target : e.srcElement);
    var key=(e ? e.keyCode || e.which : window.event.keyCode);
    if(key==13){
      initDataTableGrlEntidadProp();
    }else{
      return true;
    }
});
 
});  

function getIdProp(idEntidad,pnombre,idPropietario){
  var source=$("#mvBuscadorEntidadGrl").data("source");
  //console.log("getIdProp... "+$("#mvBuscadorEntidadGrl").data("source"));
  // si sourc es 3 fue invocaco des de la buscqueda de la bandeja de ejamplar
  // sino desde el popu nuevo/editar ejemplar.
//  console.log(idEntidad+" - "+pnombre+" - "+idPropietario);
  if(source==3){
      //console.log(idEntidad+" - "+pnombre+" - "+idPropietario);
      $("#hidIdPropBus").val(idPropietario);
      $("#hidIdEnteBus").val(idEntidad);
      $("#lblPropBus").html(pnombre);
      $("#lblBorrarPropBus").show();
  }else{
   // console.log("...entrooooo");
   mostrarGrillaEnt(idEntidad,pnombre,idPropietario);
 }
   $( "#mvBuscadorEntidadGrl" ).modal('hide');
} 

function getIdCri(id){
  var nombre=$("#"+id).val();
  mostrarGrillaEnt(id,nombre,0);
  $( "#mvBuscadorEntidadGrl" ).modal('hide');
} 
function mostrarGrillaEnt(pcodigo,pnombre,idProp){
 //console.log("mostrarGrillaEnt... "+$("#mvBuscadorEntidadGrl").data("source"));
  var source=$("#mvBuscadorEntidadGrl").data("source");
     /*  if(source==1){
        $origen=1;
      }else{
        $origen=2;
      }*/
  $.ajax({
                 data:{opc:'setEntSession',
                       codigo:pcodigo,
                       nombre:pnombre,
                       origen:source,
                       idProp:idProp
                       
                 },
                 url:'ajax/ajaxEntidad.php',
                 type:'post',
                 success: function(response){
                var retorno=JSON.parse(response);
                //console.log(retorno);
                if(retorno.result==1){
                          if(source==1){
                              $(".gridHtmlBGProp tbody").html("");
                              $(".gridHtmlBGProp tbody").append(retorno.html);
                              initCtrolesGrillaTmp(1);
                          }else{
                              $(".gridHtmlBGCri tbody").html("");
                              $(".gridHtmlBGCri tbody").append(retorno.html);
                              initCtrolesGrillaTmp(2);
                          }
                 }else if(retorno.result==0){
                    alertify.error(retorno.message);
                 }  
               }
          });
}

var initCtrolesGrillaTmp=function(origenGrilla){
  
  if(origenGrilla==1){
    
  //$('.gridHtmlBGProp tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });    
  $('.btnQuit_1').each(function(i, obj) {
      $(obj).on("click",function(){
        var indice=$(this).data("key");
        var source=$(this).data("source");
        var index=$(this).data("index");
        quitarTmpProp(indice,source,index);  
      }).button();

    });
  }else{
  //  $('.gridHtmlBGCri tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
    $('.btnQuit_2').each(function(i, obj) {
    $(obj).on("click",function(){
        $sourceDelete=2;
        var indice=$(this).data("key");
        var source=$(this).data("source");
       quitarTmpCri(indice,source);  
    }).button({icons: {primary: "ui-icon-closethick"},text: false});});
  }


}

function initDataTableGrlEntidadProp(){
 
  jQuery("#gridGralEntidad").jqGrid("clearGridData", true);
  jQuery("#gridGralEntidad").jqGrid('setGridParam', {
                url: 'ajax/ajaxBuscarGralEntidad.php', 
                datatype: 'json',  
                mtype: 'GET', 
                postData: paramSearchGralEntidadProp()
              }).trigger('reloadGrid');  

  jQuery("#gridGralEntidad").jqGrid({
                url:'ajax/ajaxBuscarGralEntidad.php',
                postData: paramSearchGralEntidadProp(),
                datatype: "json",
                height: "auto",
                mtype: 'GET',
                colNames:['IdEnte','Id Prop','Nombre o Razón Social','Prefijo'],
                colModel:[ 
                    {name:'id',index:'id',width:100, hidden:true},
                    {name:'idProp',index:'idProp', hidden:true,align:"left"},
                    {name:'nombre',index:'nombre',align:"left"},
                    {name:'prefijo',index:'prefijo',width:50,align:"left"}

                ],
                rowNum:10,
                pager: '#opc_pagGralEntidad',
                sortname: 'id',
                sortorder: "ASC",
                viewrecords: true,          
                caption:"Resultado de Búsqueda",
                shrinkToFit: true,
                width: '585',
                height: 'auto',
                ondblClickRow: function(rowid,iRow,iCol, e){ 
                    var colidEnte = $(this).jqGrid("getCell", rowid, 0);
                    var colidProp = $(this).jqGrid("getCell", rowid, 1);
                    var colNombre = $(this).jqGrid("getCell", rowid, 2);
                    //var nombre = $(this).jqGrid("getCell", rowid, 3);
                    //console.log("fff"+colidProp+colNombre);

                    getIdProp(colidEnte,colNombre,colidProp);
               }


            });
 }

 function paramSearchGralEntidadProp(){
    
return {
            opc:'lstAllPropjqgrid',
            nomFiltro:$("#txtBGNombreEntidad").val()
            // prefEntidad:$("#hidOrigenBuscador").val()
          };
 };
 


function initDataTableGrlEntidadCria(){
  jQuery("#gridGralEntidad").jqGrid("clearGridData", true);
  jQuery("#gridGralEntidad").jqGrid('setGridParam', {
                url: 'ajax/ajaxBuscarGralEntidad.php', 
                datatype: 'json',  
                mtype: 'GET', 
                postData: paramSearchGralEntidadCria()
              }).trigger('reloadGrid');  

  jQuery("#gridGralEntidad").jqGrid({
                url:'ajax/ajaxBuscarGralEntidad.php',
                postData: paramSearchGralEntidadCria(),
                datatype: "json",
                height: "auto",
                mtype: 'GET',
                //shrinkToFit: true,
                colNames:['Id','Id Entidad','Nombre o Razón Social','Prefijo'],
                colModel:[ 
                    {name:'id',index:'id',key:true,hidden:true},
                    {name:'idCria',index:'idCria',hidden:true,align:"left"},
                    {name:'nombre',index:'nombre',width:100,align:"left"},
                    {name:'prefijo',index:'prefijo',width:50,align:"left"}

                ],
                rowNum:10,
                pager: '#opc_pagGralEntidad',
                sortname: 'id',
                sortorder: "ASC",
                viewrecords: true,          
                caption:"Resultado de Búsqueda",
                shrinkToFit: true,
                width: '585',
                height: '120',
                ondblClickRow: function(rowid,iRow,iCol, e){ 
                    var colidProp = $(this).jqGrid("getCell", rowid, 1);
                    var colNombre = $(this).jqGrid("getCell", rowid, 2);
                    //var nombre = $(this).jqGrid("getCell", rowid, 3);
                    //console.log("fff"+colidProp+colNombre);
                    getIdProp(rowid,colNombre,colidProp)
               },


            });
 }
function paramSearchGralEntidadCria(){
    
return {
            opc:'lstAllCriajqgrid',
            nomFiltro:$("#txtBGNombreEntidad").val()//,
           // prefEntidad:$("#hidOrigenBuscador").val()
          };
 };
 

function quitarTmpProp(id,esSourceBD,index){
  //console.log("id quitar..."+id + " index: "+index);
var datos={opc:'quit',id:id,origen:"1",isBD:esSourceBD=="BD"?1:0,idxArray:index };
           $.ajax({
              data:  datos,
              url:   'ajax/ajaxEntidad.php',
              type:  'post',
              success:  function (response) {
                 var retorno=JSON.parse(response);
                 if(retorno.result==1){
                      
                    $(".gridHtmlBGProp tbody").html("");
                    $(".gridHtmlBGProp tbody").append(retorno.html);    
                   // console.log("quitoo");
                    initCtrolesGrillaTmp(1);
                 
                 }else if(retorno.result==2){
                    alertify.alert(retorno.message);
                 
                  }
              }
            }); 
}

function quitarTmpCri(id,esSourceBD){

           $.ajax({
              data:  {opc:'quit',id:id,origen:"2",isBD:esSourceBD=="BD"?1:0},
              url:   'ajax/ajaxEntidad.php',
              type:  'post',
              success:  function (response) {
                 var retorno=JSON.parse(response);
                 if(retorno.result==1){
                     
                    $(".gridHtmlBGCri tbody").html("");
                    $(".gridHtmlBGCri tbody").append(retorno.html);    
                    initCtrolesGrillaTmp(2);
                    
                 }else if(retorno.result==2){
                    alertify.alert(retorno.message);
                 
                  }
              }
            }); 
}
/*
function contarPropietariosB(){
    var fila = 0;
    $(".gridHtmlBGProp tbody tr ").each(function (index, value) { fila = fila + 1; });
    return fila;
 
}*/