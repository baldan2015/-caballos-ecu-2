var controllers={
    reporteADN:'ajax/ajaxReporte.php',
    ejemplarJQGRID:'ajax/ajaxEjemplarJQgrid.php'
}
$(function(){
listarPropietario("ddlProps", "TODOS", 0);
initDataTableADN();
$("#btnVer").on("click",function(){
    search();

});
$("#btnCancelar").on("click",function(){clearParamSearchRptAdn();search()});
$("#btnXls").on("click", function(){ exportarADNXls();	});
$(".clsListTMP").on("click", function(){ clsTMP();   });
$("#btnTmpXls").on("click", function(){ exportarTMPxls();   });

$("#txtCodigoBus").on("keypress", function(e){ 	
ValidarEnter(e,$(this).val(),"Ingrese id del ejemplar.");
});
$("#txtNombreBus").on("keypress", function(e){ 	
ValidarEnter(e,$(this).val(),"Ingrese nombre del ejemplar.");
});
$("#txtIdPadBus").on("keypress", function(e){ 	
ValidarEnter(e,$(this).val(),"Ingrese id del padre.");
});
$("#txtNomPadBus").on("keypress", function(e){ 	
ValidarEnter(e,$(this).val(),"Ingrese nombre del padre.");
});
$("#txtIdMadBus").on("keypress", function(e){ 	
ValidarEnter(e,$(this).val(),"Ingrese id de la madre.");
});
$("#txtNomMadBus").on("keypress", function(e){ 	
ValidarEnter(e,$(this).val(),"Ingrese nombre de la madre.");
});        


 $("#mvListaAdn").on('show.bs.modal', function () {
         listTMPADN();
         refreshGrillaTMP();
    });
});

function ValidarEnter(e,dato,msg){
	if (e.which == 13){
		if(dato!=""){
			search();
		}else{
			alertify.error(msg);
		}
	}
}
function search(){
 validarSesion(function(isLogout){
    if(isLogout!="1"){
            $("#grid").jqGrid("clearGridData", true);
            $("#grid").jqGrid('setGridParam', {    
                         url: controllers.reporteADN, 
                         datatype: 'json',  
                         mtype: 'GET', 
                         postData: paramSearchRptAdn()
             }).trigger('reloadGrid');
    }
 });
}

function paramSearchRptAdn (){
 
var vprop=0;
var vente=0;
var xdato=$('#ddlProps').val();
if(xdato!=null){
  var esIdProp=xdato.charAt(0); 
  if(esIdProp=="0"){
        vprop=eval($('#ddlProps').val());
        vente=0;
  }else{
        vprop=0;
        vente=eval($('#ddlProps').val());
  }
}

return {	opc:'lstAdn',
            id:$("#txtCodigoBus").val(),
            nombre:$("#txtNombreBus").val(),
            idPadre:$("#txtIdPadBus").val(),
            nomPadre:$("#txtNomPadBus").val(),
            idMadre:$("#txtIdMadBus").val(),
            nomMadre:$("#txtNomMadBus").val(),
            idProp: vprop,
            idEnte: vente                     
          };
 };
 function paramSearchRptAdnXls (){
 
var vprop=0;
var vente=0;
var xdato=$('#ddlProps').val();
if(xdato!=null){
  var esIdProp=xdato.charAt(0); 
  if(esIdProp=="0"){
        vprop=eval($('#ddlProps').val());
        vente=0;
  }else{
        vprop=0;
        vente=eval($('#ddlProps').val());
  }
}
//console.log($('#grid').getGridParam('page'));
//console.log($('#grid').getGridParam('rowNum'));
				
return {	opc:'lstAdnXls',
            id:$("#txtCodigoBus").val(),
            nombre:$("#txtNombreBus").val(),
            idPadre:$("#txtIdPadBus").val(),
            nomPadre:$("#txtNomPadBus").val(),
            idMadre:$("#txtIdMadBus").val(),
            nomMadre:$("#txtNomMadBus").val(),
            idProp: vprop,
            idEnte: vente,
            page: $('#grid').getGridParam('page'),
            rows: $('#grid').getGridParam('rowNum')
          };
 };
 function clearParamSearchRptAdn (){
 
            $("#txtCodigoBus").val("");
            $("#txtNombreBus").val("");
            $("#txtIdPadBus").val("");
            $("#txtNomPadBus").val("");
            $("#txtIdMadBus").val("");
            $("#txtNomMadBus").val("");
            $('#ddlProps').val(0);
            $("#ddlProps").selectpicker('refresh');
 };

 function  initDataTableADN(){
      
       jQuery("#grid").jqGrid({
                url:controllers.reporteADN,
                postData: paramSearchRptAdn(),
                datatype: "json",
                height: "auto",
                mtype: 'GET',
                colNames:['id', 'Nombre','fec. Nac','sexo','pelaje','Id. Padre',
                          'Padre', 'Id. Madre', 'Madre','propietario','capado'],
                colModel:[ 
                    {name:'id',index:'id',width:100, key: true},       
                    {name:'nombre',index:'nombre',width:300,align:"left"},
                    {name:'fecNace',index:'fecNace',width:100,align:"left"},
                    {name:'sexo',index:'sexo',width:100,align:"left"},
                    {name:'pelaje',index:'pelaje',width:150,align:"left"},
                    {name:'idPadre',index:'idPadre',width:100,align:"left"},                                        
                    {name:'nomPadre',index:'nomPadre',width:400,align:"left"},
                    {name:'idMadre',index:'idMadre',width:100,align:"left"},
                    {name:'nomMadre',index:'nomMadre',width:400,align:"left"},
                    {name:'propietario',index:'propietario',width:400,align:"left"},
                    {name:'capado',index:'capado',width:50,hidden: true }
                ],
                rowNum:18,
                pager: '#opc_pag',
                sortname: 'id',
                sortorder: "ASC",
                viewrecords: true,          
                caption:"Resultado de Búsqueda",
                autowidth: true,
                shrinkToFit: true,
                height: '400' ,
                 
                gridComplete: function()
                {
                    var rows = $("#grid").getDataIDs(); 
                    for (var i = 0; i < rows.length; i++)
                    {
                        var idEjemplar = $("#grid").getCell(rows[i],"id");
                        var status = $("#grid").getCell(rows[i],"capado");
                        if(status == "SI" || idEjemplar.indexOf("CN-")!=-1)
                        {
                            $("#grid").jqGrid('setRowData',rows[i],false, {  weightfont:'bold',background:'#CEF6CE'});            
                        }
                        
                    }
                },
                ondblClickRow: function (rowid, iRow,iCol) {
                      addTmpToExport(rowid);
                }
             });
 } 


function addTmpToExport(idEjemplar){
                         $.ajax({
                                    data:  {opc:'tmpAdn',id:idEjemplar},
                                    url:   controllers.reporteADN,
                                    type:  'post',
                                    success:  function (response) {
                                        var resultado= JSON.parse(response) ;
                                         if(resultado.result=="1"){
                                            alertify.success(resultado.message);
                                        }
                                         else       
                                            alertify.error(resultado.message);
                                    }
                                });
}

function quitTmpToExport(idEjemplar){
                         $.ajax({
                                    data:  {opc:'quitTmpAdn',id:idEjemplar},
                                    url:   controllers.reporteADN,
                                    type:  'post',
                                    success:  function (response) {
                                        var resultado= JSON.parse(response) ;
                                         if(resultado.result=="1"){
                                            alertify.success(resultado.message);
                                            refreshGrillaTMP();
                                        }
                                         else       
                                            alertify.error(resultado.message);
                                    }
                                });
}


 function exportarADNXls(){
   $("#mvListaAdn").modal("show");
 }
 function listTMPADN(){
     jQuery("#grid_mv").jqGrid({
                url:controllers.reporteADN,
                postData: {opc:'listTMPADN',},
                datatype: "json",
                height: "auto",
                mtype: 'GET',
                colNames:['id', 'Nombre','fec. Nac','sexo','pelaje','Id. Padre',
                          'Padre', 'Id. Madre', 'Madre','propietario','capado'],
                colModel:[ 
                    {name:'id',index:'id',width:60, key: true},       
                    {name:'nombre',index:'nombre',width:150,align:"left"},
                    {name:'fecNace',index:'fecNace',width:70,align:"left"},
                    {name:'sexo',index:'sexo',width:50,align:"left"},
                    {name:'pelaje',index:'pelaje',width:50,align:"left"},
                    {name:'idPadre',index:'idPadre',width:60,align:"left"},                                        
                    {name:'nomPadre',index:'nomPadre',width:115,align:"left"},
                    {name:'idMadre',index:'idMadre',width:60,align:"left"},
                    {name:'nomMadre',index:'nomMadre',width:115,align:"left"},
                    {name:'propietario',index:'propietario',width:120,align:"left"},
                    {name:'capado',index:'capado',width:50,hidden: true }
                ],
                rowNum:0,
                pager: '#opc_pag_mv',
                sortname: 'id',
                sortorder: "ASC",
                viewrecords: true,          
                caption:"Resultado de Búsqueda",
                autowidth: true,
                shrinkToFit: true,
                height: '400' ,
                 
                gridComplete: function()
                {   
                    var rows = $("#grid").getDataIDs(); 
                    console.log(rows.length);
                    for (var i = 0; i < rows.length; i++)
                    {
                        var idEjemplar = $("#grid").getCell(rows[i],"id");
                        var status = $("#grid").getCell(rows[i],"capado");
                        if(status == "SI" || idEjemplar.indexOf("CN-")!=-1)
                        {
                            $("#grid").jqGrid('setRowData',rows[i],false, {  weightfont:'bold',background:'#CEF6CE'});            
                        }
                        
                    }
                },
                ondblClickRow: function (rowid, iRow,iCol) {
                      quitTmpToExport(rowid);
                }
             });
 } 
 function clsTMP(){
                            $.ajax({
                                    data:  {opc:'clsTmp'},
                                    url:   controllers.reporteADN,
                                    type:  'post',
                                    success:  function (response) {
                                        var resultado= JSON.parse(response) ;
                                         if(resultado.result=="1"){
                                            alertify.success(resultado.message);
                                            refreshGrillaTMP();
                                        }
                                         else       
                                            alertify.error(resultado.message);
                                    }
                                });
 }
 function exportarTMPxls(){
    $.ajax({
                                    data:  paramSearchRptAdnXls(),
                                    url:   controllers.reporteADN,
                                    type:  'get',
                                    success:  function (response) {
                                        var resultado= JSON.parse(response) ;
                                         if(resultado.result=="1"){
                                            window.open('data:application/vnd.ms-excel,' + encodeURIComponent(resultado.html));
                                            alertify.success(resultado.message);
                                        }
                                         else       
                                            alertify.error(resultado.message);
                                    }
                                });
 }
 function refreshGrillaTMP(){

    $("#grid_mv").jqGrid("clearGridData", true);
                                            $("#grid_mv").jqGrid('setGridParam', {    
                                                         url: controllers.reporteADN, 
                                                         datatype: 'json',  
                                                         mtype: 'GET', 
                                                         postData: {opc:'listTMPADN'}
                                             }).trigger('reloadGrid');


 }