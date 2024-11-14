var controls={
 txtDepartFiltro:"#txtDepart"
};
var controllers={
    departamento:'ajax/ajaxDepartamento.php'
}
$(function(){
 
initDataTable();
    
});

function initDataTable(){
 validarSesion(function(isLogout){
    if(isLogout!="1"){ 


  jQuery("#grid").jqGrid({
                url:controllers.departamento,
                postData: paramSearch(),
                datatype: "json",
                height: "auto",
                mtype: 'GET',
                colNames:['Id', 'Nombre'],
                colModel:[ 
                    {name:'id',index:'id',width:100, key: true},       
                    {name:'descripcion',index:'descripcion',width:130}
                   
                ],
                rowNum:25,
                pager: '#opc_pag',
                sortname: 'id',
                sortorder: "ASC",
                viewrecords: true,          
                caption:"Resultado de Búsqueda",
                autowidth: true,
                shrinkToFit: true,
                height: '500'

            });
  }
});
 }
  function paramSearch (){
return {
            opc:'jqgrid',
            nomDepart:$(controls.txtDepartFiltro).val()
           
          };
 };
  function clearParamSearch (){
 
       $(controls.txtDepartFiltro).val("");
           
             
          
 };

function search(){ 
 $("#grid").jqGrid("clearGridData", true);
$("#grid").jqGrid('setGridParam', {     url: controllers.departamento, datatype: 'json',  mtype: 'GET', postData: paramSearch()
 }).trigger('reloadGrid');
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
 