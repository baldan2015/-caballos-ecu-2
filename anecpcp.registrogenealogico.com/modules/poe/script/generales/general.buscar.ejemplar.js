var K_PATH_ROOT="../";
$(function(){
 
$("#txtBGNombreEjemplar").on("keypress",function(e){
    var target=(e.target ? e.target : e.srcElement);
    var key=(e ? e.keyCode || e.which : window.event.keyCode);
    if(key==13){
      initDataTableGrlEjemplar();
    }else{
      return true;
    }
});

});
 

function initDataTableGrlEjemplar(){
  jQuery("#gridGralEjemplar").jqGrid("clearGridData", true);
  jQuery("#gridGralEjemplar").jqGrid('setGridParam', {
                url: K_PATH_ROOT+'ajax/ajaxBuscarGralEjemplar.php', 
                datatype: 'json',  
                mtype: 'GET', 
                postData: paramSearchGralEjemplar()
              }).trigger('reloadGrid');  

  jQuery("#gridGralEjemplar").jqGrid({
                url:K_PATH_ROOT+'ajax/ajaxBuscarGralEjemplar.php',
                postData: paramSearchGralEjemplar(),
                datatype: "json",
                height: "auto",
                mtype: 'GET',
                colNames:['Id', 'Prefijo','Nombre','Propietario','Pelaje'],
                colModel:[ 
                    {name:'id',index:'id',width:100, key: true},       
                    {name:'prefijo',index:'prefijo'},
                    {name:'nombre',index:'nombre'},
                    {name:'propietario',index:'propietario'},
                    {name:'pelaje',index:'pelaje'},
                   
                ],
                rowNum:10,
                pager: '#opc_pagGralEjemplar',
                sortname: 'id',
                sortorder: "ASC",
                viewrecords: true,          
                caption:"Resultado de Búsqueda",
                shrinkToFit: true,
                autowidth: true,
                
                height: '250',
                ondblClickRow: function(rowid,iRow,iCol, e){ 
                    var colPref = $(this).jqGrid("getCell", rowid, 1);
                    var colNombre = $(this).jqGrid("getCell", rowid, 2);
                    var colNombreProp = $(this).jqGrid("getCell", rowid, 3);
                    setDatoEjemplarSel(rowid,colPref,colNombre,colNombreProp);
               }


            });
 }


 function paramSearchGralEjemplar (){
    
return {
            opc:'lstAlljqgrid',
            nomFiltro:$("#txtBGNombreEjemplar").val(),
            genero:$("#hidOrigenBuscador").val()
          };
 };
 

 function setDatoEjemplarSel(rowid,colPref,colNombre,colNombreProp) 
{
  console.log(rowid,colPref,colNombre,colNombreProp);
                if($("#hidOrigenBuscador").val()=="Y"){
                     $("#txtNombreYegua").html(colPref + ' '+colNombre + ' '+rowid);   
                     $("#hidCodigoYegua").val(rowid);
                     //$("#lblBorrarMadre").show();
                     $("#mvBuscadorEjemplarGrl" ).modal('hide');
                  } else if($("#hidOrigenBuscador").val()=="P"){
                     $("#txtNombrePotro").html(colPref + ' '+colNombre + ' '+rowid);
                     $("#hidCodigoPotro").val(rowid); 
                    // $("#lblBorrarPadre").show();  
                     $("#mvBuscadorEjemplarGrl" ).modal('hide');
                  } else if($("#hidOrigenBuscador").val()==""){
                    /*ORIGEN 3 INDICA QUE  EL POPUP SE HA CARGADO DESDE TRANSFERENCIAS*/
                      $("#lblEjemplar").html(colPref + ' '+colNombre + ' '+rowid);
                      $("#hidIdEjamplar").val(rowid); 
                      $("#lblBorrarEjemplar").show();  
                      $("#lblPropietario").html(colNombreProp);
                      $("#mvBuscadorEjemplarGrl" ).modal('hide'); 
                 }
            /*FIN LOGICA PROPIETARIO*/
}