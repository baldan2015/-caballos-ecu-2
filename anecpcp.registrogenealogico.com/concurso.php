<?PHP require("constante.php");
require(DIR_CABECERA);
require(DIR_VALIDAR);

if(ValidarSession())
	{?>
 
<link href="styles/menu2.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/styles.css">
    
   
<link href="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.css" rel="stylesheet">
<script src="scripts/jquery-ui-1.11.4.custom.green/external/jquery/jquery.js"></script>
<script src="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.js"></script>

<script src="scripts/script.js"></script>
<script src="scripts/proceso.js"></script>
<?
	echo"<tr><td colspan=2 valign=top >";
	
echo"<table border=0 cellpadding=0 cellspacing=0 width=100%>";
	require(DIR_BARRA);
	echo"</tr>";
	echo"<tr><td colspan=1  style='height:100px;'  align=left  class='cssSearch2'>";
	echo"";
	echo"<table border=0 cellpadding=0 cellspacing=0 width=100%>";
	echo"<tr class=bold >";
	echo"<td align=left colspan=1>";
 ?>
 <div style=' margin-left:5px;  width:600px;border-radius: 10px 10px 10px 2px;
-moz-border-radius: 10px 10px 10px 2px;
-webkit-border-radius: 10px 10px 10px 2px;
border: 1px solid #ccc; float:left;   '> 
<div style='margin-left:20px;'>
 	<table border=0 cellspacing=2 cellpadding=2 width=90% style=" font-weight:bold;">
 		<tr>
	<td colspan=2>
		Criterios de B&uacute;squeda de resultados de concursos
	</td>
	</tr>
<tr>
<td>
<div style='width:150px;'> Concursos:  </div>
<div  id="lstConcurso">   </div>
 
</td>
<td>
	<div style=' width:150px;'> Categorias:  </div>
<div  id="lstCategoria">   </div>
</td>
</tr>

<tr>
<td colspan=2>
	<div style=' width:150px;'> Grupos:  </div>
	<div  id="lstGrupo">   </div>
 
</div >
</td>
</tr>
<tr>
	<td>
		<br><br><br><br><br><br>
	</td>
<td  >
	 <div style=' float:left; '> 
		<!--<img src='img/btnBuscar.png' id='btnBuscarResult' border=0  title='buscar resultados de concurso'/>-->
		<button   id='btnBuscarResult' border=0  title='buscar resultados de concurso'>
			Buscar
		</button>
	</div>
</td>
</tr>
<tr>
	<td colspan=1>
	</td>
	</tr>
 	</table>
 </div>
 </div>
  <div style='float:left; width:450px; '> 
<p>
	 	<div class="tituloBanner"  >
	 		Registro Geneal&oacute;gico del Caballo de Paso.


	 	</div>
	 	<div class="subTituloBanner"  >
	 		Base de datos de caballos de paso de Ecuador


	 	</div>

<p>
	
 <?
	echo"</td></tr>";
	 echo"<tr><td colspan=6 style='height:30px;'> </td></tr>";
									#Buscar Ahora!
	echo"
	<tr><td class='cssBarraFiltro' colspan=6 > ";

	 
	 echo"</td></tr>";
	 
	echo"</table>";
 	echo"</td></tr>";

	 echo"<tr><td   colspan=6 > 
<div id='divResultConcurso'>
</div>
	 ";
	echo"</table>";






	echo"</td></tr>";
	}
else
	{
  	if(session_is_registered('xstatus'))
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

</td>
</TR>
<?

require(DIR_LOGIN);

 
	/* 	echo"<tr><td colspan=2 valign=bottom >";
		echo("<form  name='formlog' action='index.php' method='POST'>");
		echo("<table bgcolor=whitesmoke cellpadding=0 cellspacing=2 align=center border=0 class=text1>");
		echo"<tr><td background='img/tbl_header.png' ALIGN=CENTER style='color:white' colspan=2><b>VENTANA DE ACCESO<hr></td></tr>";
		echo"<tr><td colspan=2>&nbsp;</td></tr>";
		echo"<tr><td>Nombre de Usuario&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type=text name='txtusu' size=15 class=logeo ></td></tr>";
		echo"<tr><td>Contrase&ntilde;a&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type=password name='txtpwd' size=15 class=logeo></td></tr>";
		echo"<tr><td colspan=2>&nbsp;</td></tr>";
		echo"<tr><td align=right colspan=2><input type=submit name='b1' value='Ingresar' class='b1'></td></tr>";
		echo("<tr><td height=0 valign=top align=center style='color:red;font-size:10px;font-weight:bold;'>".$message."&nbsp;");
		echo("</table>");
		echo("</form>");
		echo"<tr><td align=center colspan=2 style='color:red;font-size:10px;'><a href='javascript:datos();' style='color:red;' title='Petici&oacute;n  de datos para el Ingreso.'>&iquest;Olvid&oacute; su contrase&ntilde;a?</a></td></tr>";
		echo"<tr><td align=center colspan=2 style='color:red;font-size:10px;'><a href='".LINKCUENTA."' style='color:red;' title='Obtener Cuenta de Acceso.'>Obtener una cuenta.</a></td></tr>";
		*/ 
	}
?>
<?PHP //require DIR_PIEPAGINA;?>
</table>
<script>
listarConcurso();
listarCategoXConcurso(-1);
listarGrupoXCatego(-1);

</script>
 