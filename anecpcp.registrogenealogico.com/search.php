<? require("constante.php");
require(DIR_FUNCTION."conectar.php");
require(DIR_FUNCTION."queries.php");
$mail=$HTTP_POST_VARS['txtcorreo'];
if(isset($mail))
{
ver($link,trim($mail));
}


function ver($link,$mail)
{

$sql="select * from usuario where correo='$mail'";
$rs=mysql_query($sql,$link)or die(mysql_error($link)) ;
$n=mysql_num_rows($rs);

if($n>0)
{
  for($i=0;$i<$n;$i++)
	{
	$sesion=mysql_result($rs,$i,'nom_sesion_usu');
	$pwd=mysql_result($rs,$i,'pwd_usu');
	$nom_usu=mysql_result($rs,$i,'nom_usu');
	$ape_usu=mysql_result($rs,$i,'ape_usu');
	$usuario=$nom_usu.' , '.$ape_usu;
	$correo=mysql_result($rs,$i,'correo');
	send_mail($sesion,$pwd,$usuario,$correo);
	}
echo "<center><br><br><span style='font-weight:bold;font-family:verdana;font-size:10px;color:black;'>Se ha enviado los datos necesarios a la cuenta :</span><br><span style='font-weight:bold;font-family:verdana;font-size:10px;color:red;'>".$correo."<a href='javascript:self.close()'><img src='img/s_okay.png' alt='Cerrar ventana' border=0></a>";
}
else
{echo"<br><br><center><span style='font-weight:bold;font-family:verdana;font-size:10px;color:red;'>El dirección del correo Ingresado no existe en la base de datos !<br><a href='javascript:self.close()'><img src='img/s_error.png' alt='Cerrar ventana' border=0></a></span>"; }

}
function send_mail($sesion,$pwd,$user,$mail)
{

$email=TEXT_MAIL;
$nombre=TEXT_FROMMAIL;
$destino = $mail;
$headers = "MIME-Version: 1.0\r\n"; 
$headers .="Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From:$nombre <$email>\r\n";
$asunto = "Acceso  al Registro Genealógico";
$cuerpo = "
<html>
<head><title>Datos para el acceso al Registro Genealógico (A.N.C.P.C.P.P)</title></head>
<body>
<table border=0>
<tr><td colspan=2 style='color:red'>Mensaje automático para el acceso al sistema web.</td></tr>
<tr><td colspan=2 style='color:black' align=center> SISTEMA DE REGISTRO GENEALOGICO(A.N.C.P.C.P.P)</td></tr>
<tr><td >Nombre de Usuario :&nbsp;<b>$sesion</td></tr>
<tr><td >Contraseña :&nbsp;<b>$pwd</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td coslapn=2><a href=http://www.ancpcpp.org.pe/registro>http://www.ancpcpp.org.pe/registro</a></td></tr>
</table>
</body>
</html>";

if (mail($destino, $asunto, $cuerpo, $headers)) { 
	//	header("Location: $completed");
} else {
//        header("Location: $error");
}




}



?>