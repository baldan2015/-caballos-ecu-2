<?PHP require("constante.php");
require(DIR_CABECERA);

require(DIR_VALIDAR);
include(DIR_FUNCTION."queries.php");
include(DIR_FUNCTION."conectar.php");
require("barra2.php");
if(ValidarSession())
	{
	$des01=name($_GET['id'],$link);
	
	echo"</tr><tr><td colspan=2 valign=top align=center >";
	//echo"<img src='img/b_relations.png'>";
	//echo"&nbsp;&nbsp;<b>Registro Geneal&oacute;gico :&nbsp;&nbsp;&nbsp;<span style='color:red;'><b>&nbsp;[".$des01[0][prefijo]."]&nbsp;&nbsp;".$des01[0][nombre]."</span>&nbsp;<img src='img/log-aacp.gif' width=25 height=25></b>";
	echo"</td></tr>";
	
	echo"<tr><td colspan=2 valign=top >";
	$id=$_GET['id'];
	$xx=buscardescendencia($id,$link);?>
	<br>
	<a href="javascript:window.print();" name=print><img src='img/b_print.png' border=0>&nbsp;Imprimir </a>
	<?
	echo"</td></tr>";
	echo"<tr><td colspan=2 bgcolor=whitesmoke valign=top align=center >";?>
	
<?
echo"</td></tr>";

	
	}
else
	{

?></TR>
<tr ROWSPAN=0>
<td align=center colspan=2   height=50>
<img src="img/top.png"  border=0><hr>
</td>
<?
echo"</tr><tr><td colspan=2 valign=center >";
	///////////////////////////////////////////////////////////////////////////////////////////
		echo("<form  name='formlog' action='index.php' method='POST'>");
		echo("<table bgcolor=whitesmoke cellpadding=0 cellspacing=2 align=center border=0 class=text1>");
		echo"<tr><td background='img/tbl_header.png' ALIGN=CENTER style='color:white' colspan=2><b>VENTANA DE ACCESO<hr></td></tr>";
		echo"<tr><td colspan=2>&nbsp;</td></tr>";
		echo"<tr><td>Nombre de usuario&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type=text name='txtusu' size=15 class=logeo ></td></tr>";
echo"<tr><td>Contrase&ntilde;a&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type=password name='txtpwd' size=15 class=logeo></td></tr>";
		echo"<tr><td align=right colspan=2><input type=submit name='b1' value='Ingresar' class='b1'></td></tr>";
		
		////////////////////////////////////////////////////////////////////////////////////////////////

		echo("<tr><td height=0 valign=top align=center style='color:red;font-size:10px;'><b> Error ! Usuario no existe&nbsp;&nbsp;</b><img src='img/b_usrdrop.png'>");
		echo("</table>");
		echo("</form>");

		echo"<tr><td align=center colspan=2 style='color:red;font-size:10px;'><br><a href='javascript:datos();' style='color:red;' title='Petici&oacute;n  de datos para el Ingreso.'>&iquest;Olvid&oacute; su contrase&ntilde;a?</a></td></tr>";
		echo"<tr><td align=center colspan=2 style='color:red;font-size:10px;'> <a href='".LINKCUENTA."' style='color:red;' title='Obtener Cuenta de Acceso.'>Obtener una cuenta.</a></td></tr>";	

	


	}
?>
<?PHP// require DIR_PIEPAGINA;?>

</table>
<script>
function datos()
{
var vent;
vent=open("restaura.php","vent","menubar=0,height=130,width=300,top=240,left=250,status=1");

}


</script>