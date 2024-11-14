<?PHP require("constante.php");
require(DIR_CABECERA);
require(DIR_VALIDAR);


if(ValidarSession())
	{
	?>
 
<link href="styles/menu2.css" rel="stylesheet">-
<link rel="stylesheet" href="styles/styles.css">
<link href="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.css" rel="stylesheet">
<script src="scripts/jquery-ui-1.11.4.custom.green/external/jquery/jquery.js"></script>
<script src="scripts/jquery-ui-1.11.4.custom/jquery-ui.js"></script>

<script src="scripts/proceso.js"></script>
<?
	echo"<tr><td colspan=2 valign=top >";
	?><form name="Form1" method="post" action="confirmar.php">
	<table border=0 cellpadding=0 cellspacing=0 width=100% >
	<? require(DIR_BARRA);
             	require("setpwd.php");
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
	/*
echo"<tr><td colspan=2 valign=center ><hr>";
	///////////////////////////////////////////////////////////////////////////////////////////
		echo("<form  name='formlog' action='index.php' method='POST'>");
		echo("<table bgcolor=whitesmoke cellpadding=0 cellspacing=2 align=center border=0 class=text1>");
		echo"<tr><td background='img/tbl_header.png' ALIGN=CENTER style='color:white' colspan=2><b>VENTANA DE ACCESO<hr></td></tr>";
		echo"<tr><td colspan=2>&nbsp;</td></tr>";
		echo"<tr><td>Nombre de Usuario&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type=text name='txtusu' size=15 ></td></tr>";
echo"<tr><td>Contrase&ntilde;a&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type=password name='txtpwd' size=15></td></tr>";
		echo"<tr><td align=right colspan=2><input type=submit name='b1' value='Ingresar' class='b1' ></td></tr>";
		
		////////////////////////////////////////////////////////////////////////////////////////////////

echo("<tr><td height=0 valign=top align=center style='color:red;font-size:10px;font-weight:bold;'>".$message."&nbsp;");
		echo("</table>");
		echo("</form>");
	

echo"<tr><td align=center colspan=2 style='color:red;font-size:10px;'><a href='javascript:datos();' style='color:red;' title='Petici&oacute;n  de datos para el Ingreso.'>¿Olvid&oacute; su contrase&ntilde;a?</a></td></tr>";
	
*/
	}
?>
<?PHP require DIR_PIEPAGINA;?>

</table>
<script>
function datos()
{
var vent;
vent=open("restaura.php","vent","menubar=0,height=130,width=300,top=240,left=250,status=1");

}


</script>