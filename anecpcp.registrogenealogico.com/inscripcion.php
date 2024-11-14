<?PHP require("constante.php");
require(DIR_CABECERA);
require(DIR_VALIDAR);
if(ValidarSession())
	{?>
 
<link href="styles/menu2.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/styles.css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="scripts/script.js"></script>
<link href="scripts/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet">
<script src="scripts/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script src="scripts/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script src="scripts/inscripcion.js"></script>

<link href="admin/scripts/alerts/themes/alertify.core.css" rel="stylesheet"/>
<link href="admin/scripts/alerts/themes/alertify.default.css" rel="stylesheet"/>
<script src="admin/scripts/alerts/lib/alertify.min.js"></script>
<?
	echo"<tr><td colspan=2 valign=top >";
	
echo"<table border=0 cellpadding=0 cellspacing=0 width=100%>";
	require(DIR_BARRA);
	echo"</tr>";
	echo"<tr><td colspan=1  style='height:100px;'  align=left  >";
	echo"";
	echo"<table border=0 cellpadding=0 cellspacing=0 width=100%>";
	echo"<tr class=bold >";
	echo"<td align=left colspan=1> ";
 ?>
 
 <div style=' margin-left:5px;  width:99%;border-radius: 10px 10px 10px 2px;
-moz-border-radius: 10px 10px 10px 2px;
-webkit-border-radius: 10px 10px 10px 2px;
border: 1px solid #ccc; float:left;   '> 
<div style='margin-left:5px;'>
 	<table border=0 cellspacing=0 cellpadding=2 width=100% style=" font-weight:bold;">
 		<tr>
	<td  >
	<table border=0 cellspacing=0 cellpadding=0  style="background-image:url('img/banner/inscripcion5.jpg');opacity: 0.9;
    filter: alpha(opacity=90); box-shadow: 5px 5px 5px #888888; " cellspacing=0 cellpadding=2 width=100% >
 		<tr>
	<td valign="top" style=" height: 30px;font-size: 18px;" >
	<center> 	Inscripciones en l&iacute;nea a concursos. </center>
	</td>
	</tr>
	<tr>
<td>
<div> <b>Concursos:</b>   </div>
<div style=" float:left;" class='mainselectiond' id="lstConcurso">   </div>
&nbsp;&nbsp;&nbsp;
<div style="  font-size: 18px;color:#c00c15;  
    font-weight: 700; float:left; margin-left:50px; margin-top:2px;" id="lblDetaConcurso">   </div>

</td>
 </tr>
 <tr><td style="height:60px;">  &nbsp;	 </td></tr>
 <tr><td>  &nbsp;	 </td></tr>
<tr>
</tr>
 </table>

	</td>
	</tr>

 
<tr>
</tr>

<tr>
<td style="height:300px;" valign=top class='cssSearch22'  >
<table width=100% border=0 >
<tr><td colspan=3 style="height:10px;"></td></tr>
<tr><td style=" color: #82B93A; font-size:14px; font-weight:bold;">
Mis ejemplares disponibles  </td>
<td></td>
<td style=" color: #82B93A; font-size:14px;font-weight:bold;">
Mis ejemplares preinscritos </td></tr>
<tr><td style='width:45%;' valign=top >
	  <table class='gridHtml' style='width:100%;border-collapse:collapse;border:1px solid lightgray;' border=1 >
		 <thead style='background:#d3d3d3;  '> 

		
 
		<th style='height:35px;width:10%;font-size: 11px;'>Prefijo</th>
		<th style='height:35px;width:40%;font-size: 11px;'>Ejemplar</th>
		<th style='height:35px;width:20%; font-size: 11px;'>N° Registro</th>
		<th style='height:35px;width:30%;font-size: 11px;'>Inscripción a:</th>

		</tr>
		<tr>
		<th style='width:3%;'><input style="width:60%;" id="filterGrillaPref"><label class='lblClearFilter' style="cursor:hand;" title="limpiar filtro de búsqueda."><span style="font-size:11px;"> X </span></label></th>
		 <th style='width:10%;'><input style="width:70%;" id="filterGrillaNom"><label class='lblClearFilter' style="cursor:hand;" title="limpiar filtro de búsqueda."> <span style="font-size:11px;"> X </span> </label></th>
		 <th ><input style="width:70%;" id="filterGrillaCode"><label class='lblClearFilter' style="cursor:hand;" title="limpiar filtro de búsqueda."> <span style="font-size:11px;"> X </span> </label></th>
		 <th ></th>
		 <tr>
		 </tr>
		 </thead>
		 <tbody  >
		 </tbody  >
		 </table>
	</td>
	<td style="width:10px;"> </td>
	<td valign=top>
		<table class='gridHtmlTmp' style='width:100%;border-collapse:collapse;border:1px' border=1 >
		 <thead style='background:#d3d3d3;border: 1px solid #d3d3d3;'> 

		 <tr>
		<!--<th style='height:35px;width:7%;'>Prefijo</th>-->
		<th style='height:60px; font-size: 11px;width:25%'>Ejemplar</th>
		<th style='height:35px; font-size: 11px;width:10%'>N° Registro</th>
		<!--<th style='height:35px; width: 35%; font-size: 11px;'>Concurso</th>-->
		<th style='height:35px; font-size: 11px;width:60%'>Categoria o Premio a participar</th>
		<th style='height:35px; font-size: 11px;width:5%'>...</th>
		</tr>
		 
		
		 </thead>
		 <tbody  >
		 </tbody  >
		 </table>
		 <center>
		 <br/><br/>
<img src="img/btnConfirmar.png" id='btnConfirmar' title='confirmar la seleccion de ejemplar e incribirse a concurso.'	 />
&nbsp;&nbsp;
<img src="img/btnCancelar.png"	id='btnCancelar' title='volver a iniciar selección de ejemplares' />
</center>
	</td>
	</tr>
	</table>		 

</td>

</tr>
 
 
</table>
 </div>
 </div>
  
 </td></tr> 
 
 </table>
 </td></tr>
  
 </table> 
 </td></tr> 
<?}
else
	{
  	if(isset($_SESSION['xstatus']))
	{
		if($_SESSION['xstatus']==0)
		{
		$message="Su Cuenta esta Desactivada !&nbsp;&nbsp;<img src='img/s_status.png'>";
		}
		else
		{
		
		if($_SESSION['xstatus']==-1)
		{$message="Error ! Usuario no existe !&nbsp;&nbsp;<img src='img/b_usrdrop.png'>";	}
		
		}
	}
?>
<tr ROWSPAN=0>
<td align=center colspan=2   height=50>
<img src="img/logo.jpg"  border=0><hr>
</td>
</TR>
<?

require(DIR_LOGIN);

 
	}
?>
<?PHP require DIR_PIEPAGINA;?>
</table>

<div id="mvCategorias">
<table id="tblPremios"></table>
<input type="hidden" class="hidMVCatego" id="hidIdEjemplar" />
<input type="hidden" class="hidMVCatego" id="hidPrefijoEjemplar" />
<input type="hidden" class="hidMVCatego" id="hidNombreEjemplar" />
</div>
<div id="mvFinal"><div id='htmlPreview' ></div></div>
