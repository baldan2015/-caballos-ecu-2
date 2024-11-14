<?
require("constante.php");
//require(DIR_CABECERA);

if(ValidarSession())
{
?>
 <style type="text/css">
 	.cssHeadTbl{
	background:#d3d3d3; font-weight: bold; font-size: 9px; 
}

 </style>
<!--  <script src="libs/bootstrap-3.3.7/js/bootstrap.js"></script>
  <link href="libs/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet"/>-->
 <!--ble  width="100%" border="0"  cellpadding="0"  cellspacing="0">
  	<tr>
  		<td>-->
 <table width="100%" border="1" style="border-collapse: collapse;background-color: #fff;font-weight: bold;"   id="tableResult" class="printMe">
<tr  style="background:#d3d3d3; font-weight: bold;"   > <td>HIJO</td> <td>PADRE</td><td>ABUELOS</td><td>BISABUELOS</td><td>TATARABUELO</td></tr>

<tr>
	<td rowspan="16"><label id='0'></label></td>
	<td rowspan="8"><label id='1'></label></td>
	<td rowspan="4"><label id='3'></label></td>
  	<td rowspan="2"><label id='7'></label></td>
	<td><label id='15'></label></td>
</tr>
<tr>
	<td><label id='16'></label></td>
</tr>
<tr>
  <td  rowspan="2"><label id='8'></label></td>
	<td><label id='17'></label></td>
</tr>
<tr>
	<td><label id='18'></label></td>
</tr>
<tr>
	<td  rowspan="4"><label id='4'></label></td>
	<td  rowspan="2"><label id='9'></label></td>
	<td><label id='19'></label></td>
</tr>
<tr>
	<td><label id='20'></label></td>
</tr>
<tr>
	<td  rowspan="2"><label id='10'></label></td>
	<td><label id='21'></label></td>
</tr>
<tr>
	<td><label id='22'></label></td>
</tr>


<tr>
	<td rowspan="8"><label id='2'></label></td>
	<td rowspan="4"><label id='5'></label></td>
  	<td  rowspan="2"> <label id='11'></label></td>
	<td><label id='23'></label></td>

</tr>
<tr>
	<td><label id='24'></label></td>
</tr>
<tr>
  <td  rowspan="2"><label id='12'></label></td>
	<td><label id='25'></label></td>
</tr>
<tr>
	<td><label id='26'></label></td>
</tr>
<tr>
	<td  rowspan="4"><label id='6'></label></td>
	<td  rowspan="2"><label id='13'></label></td>
	<td><label id='27'></label></td>
</tr>
<tr>
	<td><label id='28'></label></td>
</tr>
<tr>
	<td  rowspan="2"><label id='14'></label></td>
	<td><label id='29'></label></td>
</tr>
<tr>
	<td><label id='30'></label></td>
</tr>
</table>
<!--
</td><td valign="top">
-->
	<table width="100%" border="0" style="border-collapse: collapse;background-color: #fff;font-weight: bold;" class="printMe">
<tr>
	<td><div id="resultResumen" ></div></td>
</tr>
</table>

<!--
</td>
</tr>
</table>-->

<?	
}else{
	  	if(isset($_SESSION['xstatus']))
		{
			if($_SESSION['xstatus']==0)
			{
			$message="Su Cuenta esta Desactivada !&nbsp;&nbsp;<img src='img/s_status.png'> ";
			}
			else
			{
				if($_SESSION['xstatus']==-1)
					$message="Error ! Usuario no existe !&nbsp;&nbsp;<img src='img/b_usrdrop.png'> ";
			}
		}
		?>
	<!--	<tr ROWSPAN=0>
		<td align=center colspan=2   height=50>
	 
		</td>
		</TR>-->
		<? 
		require(DIR_LOGIN);	
}
// require DIR_PIEPAGINA;
 ?>
<script type="text/javascript">
loadArbolGen('<?=$id?>');

$(function(){
 	$("#btnPrint").on("click",function(){  		$('.printMe').printElem(); 	}); 
});
 
function loadArbolGen(idEjemplar){
		  
								$.ajax({
												data:  {opc:'arbolGen',
														id:idEjemplar
													},
												url:   'ajaxPOE/ajaxReporteGenPer.php',
												type:  'post',
												success:  function (response) {
													 var dato = JSON.parse(response);
													 
	  												   $.each(dato, function (index, fila) {

	  												   	  if(fila.orden<=6){
																	$("#"+fila.orden).html("<img src='img/dot_yellow.png'>&nbsp;"+fila.prefijo+" "+ fila.ejemplar +"   <br> <span ><a   title='Ver &aacute;rbol' style='color:#5983EC!important;'  onclick=loadArbolGen('"+fila.id+"'); > "+ fila.id+"</a></span><br>"+ fila.pelaje +"<br>  "+ fila.fecNace+"<br><span style='color:red;font-size:9px;'>"+ fila.per +"%</span>");
																}
																else{
																$("#"+fila.orden).html("<img src='img/dot_yellow.png'>&nbsp;"+fila.prefijo+" "+ fila.ejemplar +"<br> <span > <a    style='color:#5983EC!important;' title='Ver &aacute;rbol'  onclick=loadArbolGen('"+fila.id+"'); > "+ fila.id+"</a></span>&nbsp;-&nbsp;<span style='color:red;font-size:9px;'>"+ fila.per +"%</span>");	
																}
													   });
                    
               

												    
												}
										});

								$.ajax({
												data:  {opc:'arbolGenCalc',
														id:idEjemplar
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
</script>