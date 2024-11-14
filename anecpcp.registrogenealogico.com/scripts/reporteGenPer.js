$(function(){
 //loadEjemplares($("#txtMadre").val(),'Y',"madres","lblTotalH");
 //loadEjemplares($("#txtPadre").val(),'M',"padres","lblTotalM");
var tbInit="<table class='gridHtmlBG' style='width:100%;border-collapse:collapse;' border=1 > <thead style='background:#d3d3d3;'> <tr><th></th>  <th>C&oacute;digo</th> <th>Pref.</th>  <th>Nombre de Ejemplar</th> <th>Fec. Nac</th></tr> </thead></table>";
$("#txtMadre").on("keypress",function(e){ 
 
  var target = (e.target ? e.target : e.srcElement);
    var key = (e ? e.keyCode || e.which : window.event.keyCode);
    if (key == 13){
    	loadEjemplares($("#txtMadre").val(),'Y',"madres"); 
    } 
});
$("#txtPadre").on("keypress",function(e){ 
 
  var target = (e.target ? e.target : e.srcElement);
    var key = (e ? e.keyCode || e.which : window.event.keyCode);
    if (key == 13){
    	loadEjemplares($("#txtPadre").val(),'M',"padres"); 
    } 
});
 $("#btnBuscarY").on("click",function(){  loadEjemplares($("#txtMadre").val(),'Y',"madres"); });
 $("#btnBuscarM").on("click",function(){  loadEjemplares($("#txtPadre").val(),'M',"padres"); });
 $("#btnCleanY").on("click",function(){  $("#txtMadre").val(""); $("#madres").html(tbInit);	});
 $("#btnCleanM").on("click",function(){  $("#txtPadre").val(""); $("#padres").html(tbInit); 	});
 
 
 $("#btnPrint").on("click",function(){  		$('.printMe').printElem(); 	}); 
  
 $("#btnProcesar").on("click",function(){
var padre="";
var madre="";
$('input[name="Y"]').each(function() { 			if(this.checked){ 					madre=this.value;			}		});
$('input[name="P"]').each(function() { 			if(this.checked){					padre=this.value;			}		});
		if(padre!="" && madre!=""){
			$("#mvPedigree").modal("show");
			loadSimulador(padre,madre);
		}else{
			alertify.error("Seleccione ejemplar padre y madre para simular el pedigree resultante.");
		}
});

 $("#btnXls").on("click",function(){ 
 generateExcel($("#tableResult"),$("#tblResumen"));
});


});

function loadEjemplares(nombre,genero,contenedor,labelNR){
		if(nombre.length==0 || nombre.length<3){
				alertify.error("Para realizar la búsqueda ingrese nombre del ejemplar");
		}else{		
				 
								$.ajax({
												data:  {opc:'rptPedigree',
														nombre:nombre,
														genero:genero														 
													},
												url:   'ajaxPOE/ajaxReporteGenPer.php',
												type:  'post',
												success:  function (response) {
													var resultado = response;//JSON.parse(response);
												    $("#"+contenedor).html(resultado);

												   // $("#"+labelNR).html(resultado);
												}
										});
		}
				 
}
function loadSimulador(padre,madre){
		//if(nombre.length==0 || nombre.length<4){
		//		alertify.error("Para realizar la busqueda ingrese 4 digitos del ejepmplar");
		//}else{		
				 
								$.ajax({
												data:  {opc:'arbolPedigree',
														padre:padre,
														madre:madre														 
													},
												url:   'ajaxPOE/ajaxReporteGenPer.php',
												type:  'post',
												success:  function (response) {
													 var dato = JSON.parse(response);
	  												   $.each(dato, function (index, fila) {
													   	$("#"+fila.orden).html(fila.id+"<br>"+ fila.prefijo +" - "+ fila.ejemplar+" - <span style='color:red;'>"+ fila.per +'%</span>');
													   });
                    
               

												    
												}
										});
									$.ajax({
												data:  {opc:'arbolPedigreeCalc',
														padre:padre,
														madre:madre														 
													},
												url:   'ajaxPOE/ajaxReporteGenPer.php',
												type:  'post',
												success:  function (response) {
													 //var dato = JSON.parse(response);
	  												 //  $.each(dato, function (index, fila) {
													   	$("#resultResumen").html(response);//fila.id+"<br>"+ fila.prefijo +" - "+ fila.ejemplar+" - <span style='color:red;'>"+ fila.per +'%</span>');
													  // });
 												}
										});
								
			//	}
				 
}
 
function generateExcel(tblA,tblB) {
 var clon = tblA.clone();
    var html =  clon.wrap('<div>').parent().html();
     
    while (html.indexOf('á') != -1) html = html.replace(/á/g, '&aacute;');
    while (html.indexOf('é') != -1) html = html.replace(/é/g, '&eacute;');
    while (html.indexOf('í') != -1) html = html.replace(/í/g, '&iacute;');
    while (html.indexOf('ó') != -1) html = html.replace(/ó/g, '&oacute;');
    while (html.indexOf('ú') != -1) html = html.replace(/ú/g, '&uacute;');
    while (html.indexOf('º') != -1) html = html.replace(/º/g, '&ordm;');
    html = html.replace(/<td>/g, "<td>&nbsp;");

    var clon2 = tblB.clone();
    var html2 =  clon2.wrap('<div>').parent().html();
     
    while (html2.indexOf('á') != -1) html2 = html2.replace(/á/g, '&aacute;');
    while (html2.indexOf('é') != -1) html2 = html2.replace(/é/g, '&eacute;');
    while (html2.indexOf('í') != -1) html2 = html2.replace(/í/g, '&iacute;');
    while (html2.indexOf('ó') != -1) html2 = html2.replace(/ó/g, '&oacute;');
    while (html2.indexOf('ú') != -1) html2 = html2.replace(/ú/g, '&uacute;');
    while (html2.indexOf('º') != -1) html2 = html2.replace(/º/g, '&ordm;');
    html2 = html2.replace(/<td>/g, "<td>&nbsp;");

    window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html+html2));
  //	window.open('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,' + encodeURIComponent(html+html2));
 
}

jQuery.fn.extend({
	printElem: function() {
		var cloned = this.clone();
    var printSection = $('#printSection');
    if (printSection.length == 0) {
    	printSection = $('<div id="printSection"></div>')
    	$('body').append(printSection);
    }
    printSection.append(cloned);
    var toggleBody = $('body *:visible');
    toggleBody.hide();
    $('#printSection, #printSection *').show();
    window.print();
    printSection.remove();
    toggleBody.show();
	}
});