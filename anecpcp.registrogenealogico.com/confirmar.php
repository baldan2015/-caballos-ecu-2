<?PHP require("constante.php");
require(DIR_CABECERA);
require(DIR_VALIDAR);


if(ValidarSession())
	{
	echo"<tr><td colspan=2 valign=top >";
	require("save2.php");
	echo"</td></tr>";

	}
else
	{

	if($_SESSION['xstatus']==0)
	{
	$message="Su Cuenta esta Desactivada !&nbsp;&nbsp;<img src='img/s_status.png'>";
	}
	else
	{
	$message="Error ! Usuario no existe !&nbsp;&nbsp;<img src='img/b_usrdrop.png'>";
	}
?>
	<tr ROWSPAN=0>
<td align=center colspan=2   height=50>
<img src="img/logo.jpg"  border=0><hr><br><br><br><br>
</td>
</TR>
<?
	require(DIR_LOGIN);

/*echo"<tr><td colspan=2 valign=center >";
	///////////////////////////////////////////////////////////////////////////////////////////
		echo("<form  name='formlog' action='index.php' method='POST'>");
		echo("<table bgcolor=whitesmoke cellpadding=0 cellspacing=2 align=center border=0 class=text1>");
		echo"<tr><td background='img/tbl_header.png' ALIGN=CENTER style='color:white' colspan=2><b>VENTANA DE ACCESO<hr></td></tr>";
		echo"<tr><td colspan=2>&nbsp;</td></tr>";
		echo"<tr><td>Nombre de usuario&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type=text name='txtusu' size=15 ></td></tr>";
echo"<tr><td>Contraseña&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type=password name='txtpwd' size=15></td></tr>";
		echo"<tr><td align=right colspan=2><input type=submit name='b1' value='Ingresar' class='b1' ></td></tr>";
		
		////////////////////////////////////////////////////////////////////////////////////////////////

echo("<tr><td height=0 valign=top align=center style='color:red;font-size:10px;font-weight:bold;'>".$message."&nbsp;");
		echo("</table>");
		echo("</form>");
	


	echo"<tr><td align=center colspan=2 style='color:red;font-size:10px;'><a href='javascript:datos();' style='color:red;' title='Pedir datos para el logeo'>¿Olvidó su contraseña?</a></td></tr>";
	*/
	}
?>
<?PHP require DIR_PIEPAGINA;?>

</table>
<script>
function datos()
{
var vent;
vent=open("restaura.php","vent","menubar=0,height=130,width=300,top=240,left=250");

}


</script>