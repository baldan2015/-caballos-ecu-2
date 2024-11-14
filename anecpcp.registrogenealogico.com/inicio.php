<? session_start();?>
<link href="style1.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	color: #d80000;
	font-weight: bold;
	font-size: 16px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style3 {
	font-size: 10;
	font-weight: bold;
}
-->
</style>

<?
if(session_is_registered('xstatus') && session_is_registered('xusu')&& session_is_registered('xid'))
	{
	if($_SESSION['xstatus']==1 || $_SESSION['xusu']!="Desconocido" || $_SESSION['xid']!=0)
	{
	?><center><table width="750" bgcolor=white height="400"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="399" rowspan="7" align=center><img src="img/caballo-de-paso-peruano-02.jpg" width="309" height="343"></td>
    <td width="351" height="62" VALIGN=TOP align="center" class="style1"><div align="center">ASOCIACION NACIONAL DE CRIADORES Y PROPIETARIOS DE CABALLOS PERUANOS DE PASO</div></td>
  </tr>
  <tr>
    <td height="154"  VALIGN=TOP><div align="center"><IMG SRC="img/logoinicial.gif" width="173" height="173"></div></td>
  </tr>
  <tr>
    <td class="style1"><div align="center">REGISTRO GENEALOGICO DEL CABALLO PERUANO DE PASO </div></td>
  </tr>
  <tr>
    <td><hr>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="indice.php" class="bold2" title="Ir a base de datos "><IMG SRC="img/b_nextpage.png" border=0>&nbsp;Buscar </a><br>
      <span class="titlebar2">Permite seleccionar ejemplares.</span>      <hr></td>
  </tr>
  <tr>
    <td><a href="logoff.php" class="bold2" title="Cerrar sesi&oacute;n" ><IMG SRC="img/b_nextpage.png" border=0>&nbsp;Salir</a> <br>
      <span class="titlebar2">Termina la sesi&oacute;n iniciada.</span>
    <hr></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table></center>
<div align="center"></div>
<?
    }
	else
	///require("indice.php");	
require("socio.php");  
	}
	else
	{
		//require("indice.php");
    require("socio.php");  
		
	}
	
?>