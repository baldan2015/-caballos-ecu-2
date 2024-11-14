<? echo"<form name='f1'>";
echo"<b><span style='color:black;'>LISTADO DE USUARIOS REGISTRADOS</SPAN></b><br><br>";
require("Funciones/conectar.php");
require("Funciones/general.php");
if(isset($HTTP_GET_VARS['inicio'])){	$ini=$HTTP_GET_VARS['inicio'];	}else{$ini=1;}
if(isset($HTTP_GET_VARS['fin'])){	$fin=$HTTP_GET_VARS['fin'];	}else{$fin=20;}	
if(isset($HTTP_GET_VARS['data'])){	$dato=$HTTP_GET_VARS['data'];	}else{$dato="";}	
if(isset($HTTP_GET_VARS['indice'])){	$indice=$HTTP_GET_VARS['indice'];	}else{$indice=0;}	
if(isset($HTTP_GET_VARS['mail'])){	$email=$HTTP_GET_VARS['mail'];	}else{$email=0;}	
$opc=$HTTP_GET_VARS['opcbus'];
$ids=$HTTP_GET_VARS['set_id'];
$update=$HTTP_GET_VARS['update'];
if(!(empty($update)))
{
$neoestado=$HTTP_GET_VARS['status'];
$sql2="update usuario set estado='$neoestado' where id='$ids' ";
$rs=mysql_query($sql2,$link)or die(mysql_error($link));
}

if(empty($dato))
{
$sql="select id,nom_usu,ape_usu,correo,nom_sesion_usu,pwd_usu,estado,fec_reg from usuario ";
}
else
{
$sql="select id,nom_usu,ape_usu,correo,nom_sesion_usu,pwd_usu,estado,fec_reg from usuario where $opc like '%$dato%' ";

}
$rs=mysql_query($sql,$link)or die(mysql_error($link));
$n=mysql_num_rows($rs);
if($n>0)
{$c=1;
	while($rows=mysqli_fetch_array($rs))
		{
		$xfecha=explode("-",$rows[7]);
			if(is_array($xfecha))	
			{$fecha=$xfecha[2];$fecha.="/".$xfecha[1];$fecha.="/".$xfecha[0];}
			else
			{$fecha="00/00/0000";}

		$usuario[]=array('id'=>$rows[0],
                              	           'nombres'=>$rows[1]." , ".$rows[2],
			           'correo'=>$rows[3],
			           'sesion'=>$rows[4],
			           'pwd'=>$rows[5],
			           'estado'=>$rows[6],'fecha'=>$fecha,
				'n'=>$c);
		$c++;
		}
}
else
{
		$usuario[]=array('id'=>"-",
                              	           'nombres'=>"-",
			           'correo'=>"-",
			           'sesion '=>"-",
			           'pwd'=>"-",
			           'estado'=>"-", 'fecha'=>"-",'n'=>"-1");
}



//echo"<pre>";print_r($usuario);echo"</pre>";

//echo"<hr>";
echo"<table bgcolor=whitesmoke width=100% border=0 cellpadding=0 cellspacing=2 align=left  style='font-size:12px;'>";
echo"<tr class=bold style='color:brown;'><td>&nbsp;&nbsp;&nbspRealizar Filtro a usuario para habilitar/deshabilitar cuenta </td></tr>";
echo"<tr class=bold><td>&nbsp;&nbsp;&nbspBuscar por:<select name=cmb class=b1><option value='nom_usu'>Nombres</option><option value='ape_usu'>Apellidos</option></select>";

?>&nbsp;&nbsp;&nbsp;Ingrese dato:<input type=text name='txtdato' value="<?php echo $dato;?>">
&nbsp;&nbsp;&nbsp;<input type=button name='b1' value='Realizar Filtrar' class=b1 onclick="filtrar('<?=$ini?>','<?=$fin?>');"><?
echo"</td></tr>";

echo"<tr><td><hr><br>";
echo"<script language='javascript'>document.f1.cmb.selectedIndex=".$indice."</script>";
if($usuario[0][n]==-1)
{
echo"<center><b><br><br><span style='background: 66FF33'>No se encontr&oacute; usuarios  !</span></b></center>";
}
else
{

echo"<table border=0 width=100% cellpadding=0 cellspacing=1 align=left  style='font-family:verdana;font-size:12px;'>";
$numrows=20;
xpaginador($usuario,$ini,$fin,$numrows);

echo"<tr bgcolor=gray style='color:white' height=30><td align=center>N&deg;</td><td>ID</td><td align=center>Nombres y apellidos</td><td align=center>E-Mail</td><td align=center>Nom sesi&oacute;n</td>"
 ."<td align=center>Clave</td><td align=center>Estado </td><td align=center>fec Suscrip</td></tr>";
$ntot=sizeof($usuario);

//for($c=0;$c<=sizeof($usuario);$c++)
	for($c=$ini-1;$c<$fin;$c++)
	{      
	if($ntot>$c)
   	   {
				if($usuario[$c]['estado']==1)
				{$img="<img src='img/bullet081.gif' border=0>";$botonvalor="Desactivar"; $msgb1="Habilitado";}
				else
				{$img="<img src='img/bullet083.gif' border=0>";$botonvalor="Activar"; $msgb1="Deshabilitado";}
		if($ids==$usuario[$c][id])
		{
				
				echo"<tr id='tr$c' onclick=filtrar3(".$ini.",".$fin.",".$usuario[$c][id].") class=bold bgcolor=gray style='color:yellow;' onmouseover=xover2('tr$c')  onmouseout=xout2('tr$c') style='cursor:hand;' height=20>";
				echo"<td bgcolor=gray>". $usuario[$c][n]."</td>";
				echo"<td>". $usuario[$c][id]."</td>";
				echo"<td>".$usuario[$c]['nombres']."</td>";
				echo"<td>". $usuario[$c]['correo']."</td>";
				echo"<td align=center>". $usuario[$c]['sesion']."</td>";
				echo"<td>". $usuario[$c]['pwd']."</td>";
				echo"<td align=center>". $img."</td>";
				echo"<td>". $usuario[$c]['fecha']."</td>";
				echo"</tr>";

				echo"<tr><td>&nbsp;</td><td colspan=7><table border=1 cellpadding=0 cellspacing=0 bgcolor=lightgrey width=100%>";
				echo"<tr style='color:darkblue;font-size:12px'><td><br><b>";					
				echo "USUARIO :&nbsp;&nbsp;&nbsp;".$usuario[$c]['nombres'];
				echo"<br>";
				echo "ESTADO DE CUENTA:&nbsp;&nbsp;&nbsp;".$msgb1."&nbsp;$img";
				echo"&nbsp;&nbsp;";
				echo"<input type=button value='$botonvalor' class=b1 onclick=actualizar(".$ini.",".$fin.",".$usuario[$c][id].",".$usuario[$c][estado].")>";
				echo"&nbsp;&nbsp;&nbsp;<input type=button value='Enviar Mail' class=b1 onclick=send_mail(".$ini.",".$fin.",".$usuario[$c][id].")>";
				echo"<hr></td></tr>";

				if($email=="1")
				{
				enviarmail($usuario[$c]['correo'],$usuario[$c]['sesion'],$usuario[$c]['pwd']);
				$mess="Mail Enviado!";
				echo"<TR><TD ALIGN=CENTER STYLE='COLOR:RED;BACKGROUND:LIGHTGREEN'><B>".$mess."<IMG SRC='img/s_okay.png'></TD></TR>";
				
				}
			echo"</table></td></tr>";
		}
		else
		{
		echo"<tr id='tr$c' onclick=filtrar2(".$ini.",".$fin.",".$usuario[$c][id].") class=bold  height=20  onmouseover=xover('tr$c')  onmouseout=xout('tr$c') style='cursor:hand;;font-family:verdana;'>";
		echo"<td bgcolor=gray style='color:white'>".$usuario[$c][n]."</td>";
		echo"<td>".$usuario[$c][id]."</td>";
		echo"<td>".$usuario[$c]['nombres']."</td>";
		echo"<td>".$usuario[$c]['correo']."</td>";
		echo"<td align=center>".$usuario[$c]['sesion']."</td>";
		echo"<td>".$usuario[$c]['pwd']."</td>";
		echo"<td align=center>". $img."</td>";
		echo"<td>". $usuario[$c]['fecha']."</td>";
		echo"</tr>";
		
				}
	}///finde reg encontrados		
		 
		
	}

echo"<tr><td colspan=6><br>";
echo"total de Usuarios encontrados :". sizeof($usuario);
echo"&nbsp;";
xpaginador($usuario,$ini,$fin,$numrows);
echo"</td></tr>";
}
echo"</table>";

echo"</td></tr></table>";
echo"</form>";

function enviarmail($mail,$sesion,$pwd)
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
<table>
<tr><td colspan=2 align=center><b> Datos para acceder al sistema web.</td></tr>
<tr><td colspan=2 style='color:RED' align=center><b> SISTEMA DE REGISTRO GENEALOGICO(A.N.C.P.C.P.P)</td></tr>
<tr><td colspan=2>&nbsp; </td></tr>
<tr><td>Nombre de Usuario </td><td>$sesion</td></tr>
<tr><td>Contraseña </td><td>$pwd</td></tr>
<tr><td coslapn=2><a href=http://www.ancpcpp.org.pe/registro>http://www.ancpcpp.org.pe/registro</a></td></tr>

</table>
</body>
</html>";

	if (mail($destino, $asunto, $cuerpo, $headers)) 
	{// header("Location: $completed");
		} 
	 else {     //   header("Location: $error");
		}
}
?>


<script>

function next(inicio,fin)
{

//document.f1.inicio.value=inicio;
//document.f1.fin.value=fin;
document.location.replace("proceso.php?set=display&inicio="+inicio+"&fin="+fin);

}
function filtrar(inicio,fin)
{
try{
xdato=document.f1.txtdato.value;
opc=document.f1.cmb.value;
index=document.f1.cmb.selectedIndex;
if(xdato=="")
{              alert("Ingrese dato a buscar");
	return false;
}

	document.location.replace("proceso.php?set=display&inicio="+inicio+"&fin="+fin+"&data="+xdato+"&opcbus="+opc+"&indice="+index);
}
catch(ex)
{alert(ex.description);
}
}
function filtrar2(inicio,fin,id)
{
try{
xdato=document.f1.txtdato.value;
opc=document.f1.cmb.value;
index=document.f1.cmb.selectedIndex;


	document.location.replace("proceso.php?set=display&inicio="+inicio+"&fin="+fin+"&data="+xdato+"&opcbus="+opc+"&indice="+index+"&set_id="+id);
}
catch(ex)
{alert(ex.description);
}
}
function filtrar3(inicio,fin,id)
{
try{
xdato=document.f1.txtdato.value;
opc=document.f1.cmb.value;
index=document.f1.cmb.selectedIndex;


	document.location.replace("proceso.php?set=display&inicio="+inicio+"&fin="+fin+"&data="+xdato+"&opcbus="+opc+"&indice="+index);
}
catch(ex)
{alert(ex.description);
}
}

function actualizar(inicio,fin,id,status)
{
try
{
xdato=document.f1.txtdato.value;
opc=document.f1.cmb.value;
index=document.f1.cmb.selectedIndex;

	if(status==1)
	{neoestado=0;}
	else
	{neoestado=1;}

	update=1;
	document.location.replace("proceso.php?set=display&inicio="+inicio+"&fin="+fin+"&data="+xdato+"&opcbus="+opc+"&indice="+index+"&set_id="+id+"&status="+neoestado+"&update="+update);
	}
	catch(ex)
	{alert(ex.description);}
}
function send_mail(inicio,fin,id)
{
	try
	{
	xdato=document.f1.txtdato.value;
	opc=document.f1.cmb.value;
	index=document.f1.cmb.selectedIndex;
	document.location.replace("proceso.php?set=display&inicio="+inicio+"&fin="+fin+"&data="+xdato+"&opcbus="+opc+"&indice="+index+"&set_id="+id+"&mail=1");
	}
	catch(ex)
	{alert(ex.description);}
}
function xover(html)
{  document.getElementById(html).style.background="#FFFFCC";}
function xout(html)
{  document.getElementById(html).style.background="whitesmoke";}
function xover2(html)
{  document.getElementById(html).style.background="#cccccc";}
function xout2(html)
{  document.getElementById(html).style.background="gray";}
</script>