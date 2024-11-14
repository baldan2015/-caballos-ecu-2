<table border=0 width=100% cellpadding=0 cellspacing=0>
<?
require("Funciones/conectar.php");
require("barra.php");
$pwd1=$HTTP_POST_VARS['txtpwd1'];
$pwd2=$HTTP_POST_VARS['txtpwd2'];
$pwd3=$HTTP_POST_VARS['txtpwd3'];
$neosesion=$HTTP_POST_VARS['txtsesion'];

if(isset($pwd1))    //|| isset($pwd1) || isset($pwd1) )
{
echo"</tr><tr><td colspan=2 align=center style='color:red;font-size:12px;'>";
$iduser=$_SESSION['xid'];
$sql="select * from usuario where id=$iduser and pwd_usu='$pwd1'";
$rsw=mysql_query($sql,$link)or die(mysql_error($link));
$n=mysql_num_rows($rsw);
   if($n>0)
   {
$sql2="Update usuario set pwd_usu='$pwd2', nom_sesion_usu='$neosesion' where id='$iduser' ";

$rsq=mysql_query($sql2,$link)or die(mysql_error($link));

	if($rsq>0)
	{echo"<span class='msgok'><b>Datos actualizados Correctamente !&nbsp;<img src='img/s_okay.png' width=11 height=11></span>";}
	else
	{echo"<span class='msgerror'><b>No se logr&oacute; actualizar los cambios! &nbsp;<img src='img/s_cancel2.png'></span>";}
  }
else
 {
  echo"<span class='msgerror'><b>Contrase&ntilde;a ingresada incorrecta!&nbsp;<img src='img/s_error2.png'></span>";
 }
echo"</td></tr>";
 echo"<tr><td colspan=2>";
?>
<link href="styles/menu2.css" rel="stylesheet">
<form name="Form1" method="post" action="confirmar.php">
<table border=0 cellpadding=0 cellspacing=0 width=100%  >
<?

 require("setpwd.php");
 echo"</td></tr>";
}
else
{
?>
</tr><tr><td colspan=2 height=180>&nbsp;</td></tr>
<? } ?>

</table>

