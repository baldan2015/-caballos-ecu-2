/* controlsBUS: Objeto Json que contiene los  IDs de los controles que se crean en el html */
var controlsBUS={
    buttonView:"#btnVer",
    buttonCancel:"#btnCancelar"    
 };
 
var eventsBUS={
    click:"click",
    change:"change",
    keypress:"keypress"
};
var controllersBUS={
    ejemplar:'ajax/ajaxEjemplarJQgrid.php'
}
 

$(function(){
    //filtros
 $("#txtCodigo").keypress(function (e){
  if (e.which == 13) {  
    validarSesion(function(isLogout){
    if(isLogout!="1"){ 
$("#grid").jqGrid("clearGridData", true);
$("#grid").jqGrid('setGridParam', {     url: controllersBUS.ejemplar, datatype: 'json',  mtype: 'GET', postData: paramSearch()
 }).trigger('reloadGrid');
    }
});
}
});
$("#txtPrefijo").keypress(function (e){
  if (e.which == 13) {  
    validarSesion(function(isLogout){
    if(isLogout!="1"){ 
$("#grid").jqGrid("clearGridData", true);
$("#grid").jqGrid('setGridParam', {     url: controllersBUS.ejemplar, datatype: 'json',  mtype: 'GET', postData: paramSearch()
 }).trigger('reloadGrid');
    }
});
}
});
$("#txtNombre").keypress(function (e){
  if (e.which == 13) {  
    validarSesion(function(isLogout){
    if(isLogout!="1"){ 
$("#grid").jqGrid("clearGridData", true);
$("#grid").jqGrid('setGridParam', {     url: controllersBUS.ejemplar, datatype: 'json',  mtype: 'GET', postData: paramSearch()
 }).trigger('reloadGrid');
    }
});
}
});
$("#txtMin").keypress(function (e){
  if (e.which == 13) {  
    validarSesion(function(isLogout){
    if(isLogout!="1"){ 
$("#grid").jqGrid("clearGridData", true);
$("#grid").jqGrid('setGridParam', {     url: controllersBUS.ejemplar, datatype: 'json',  mtype: 'GET', postData: paramSearch()
 }).trigger('reloadGrid');
    }
});
}
});
$("#txtMax").keypress(function (e){
  if (e.which == 13) {  
    validarSesion(function(isLogout){
    if(isLogout!="1"){ 
$("#grid").jqGrid("clearGridData", true);
$("#grid").jqGrid('setGridParam', {     url: controllersBUS.ejemplar, datatype: 'json',  mtype: 'GET', postData: paramSearch()
 }).trigger('reloadGrid');
    }
});
}
});

//----------------------------- 
$(controlsBUS.buttonView).on(eventsBUS.click,function (){
validarSesion(function(isLogout){
    if(isLogout!="1"){ 
$("#grid").jqGrid("clearGridData", true);
$("#grid").jqGrid('setGridParam', {     url: controllersBUS.ejemplar, datatype: 'json',  mtype: 'GET', postData: paramSearch()
 }).trigger('reloadGrid');
    }
});
});        
$(controlsBUS.buttonCancel).on(eventsBUS.click,function (){ 
clearParamSearch();
validarSesion(function(isLogout){
    if(isLogout!="1"){ 
$("#grid").jqGrid("clearGridData", true);
$("#grid").jqGrid('setGridParam', {     url: controllersBUS.ejemplar, datatype: 'json',  mtype: 'GET', postData: paramSearch()
 }).trigger('reloadGrid');
    }
});
});

initDataTable();
//filtros 
//$("#txtCodigo").on(events.keypress,function (e){ if (e.which == 13) {  search();       }});
//$("#txtPrefijo").on(events.keypress,function (e){ if (e.which == 13) {  search();       }});

//$("#txtCria").on(events.keypress,function (e){ if (e.which == 13) {  search();       }});
//---------------
// $( "#btnGralPropieBus" ).on( "click", function() {alert("entro");  openGrlPropietarioFilter();    });

  $("#lblBorrarPropBus").on('click',function(){
  $("#lblPropBus").html("");
  $("#lblBorrarPropBus").hide();
  $("#hidIdPropBus").val("");
  $("#hidIdEnteBus").val("");
});

});

function paramSearch (){
   // console.log($("#txtProp").val());
return {
            idEjemplar:$("#txtCodigo").val(),
            prefijo:$("#txtPrefijo").val(),
            nombre:$("#txtNombre").val(),
            prop:$("#hidIdPropBus").val(),
            ente:$("#hidIdEnteBus").val() ,
            cria:$("#txtCria").val(),
            sexo:$("#ddlGenero").val(),
            edadDesde:$("#txtMin").val(),
            edadhasta:$("#txtMax").val(),
            estado:$("#ddlEstado").val()
           
          };
 };
 function clearParamSearch (){
 
            $("#txtCodigo").val("");
            $("#txtPrefijo").val("");
            $("#txtNombre").val("");
            $("#txtProp").val("");
            $("#txtCria").val("");
            $("#ddlGenero").val("");
            $("#txtMin").val("");
            $("#txtMax").val("");
            $("#ddlEstado").val("");
            $("#lblPropBus").html("");
          
 };
function initDataTable(){

       jQuery("#grid").jqGrid({
                url:controllersBUS.ejemplar,
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
                height: '350',
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

 function openGrlPropietarioFilter(){
    //alert("entro");
    //console.log("... openGrlPropietarioFilter ");
        $("#mvBuscadorEntidadGrl").data("source", "3");
        $("#mvBuscadorEntidadGrl").modal('show');
      //  $("#hidOrigenBuscador").val("3");
        $("#txtBGNombreEntidad").val("");
        initDataTableGrlEntidadProp();
     //   console.log("... prop openGrlPropietarioFilter");
    }