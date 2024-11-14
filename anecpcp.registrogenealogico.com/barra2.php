<tr height=18>
 <!-- <td class=header><div align="left">
		<span class="Estilo1">&nbsp;[<a href="indice.php" class="menuBoxHeadingLink">Inicio
		<img src="img/b_home.png" border="0" width="15" height="15" alt="Inicio" hspace="0" vspace="0"></a>]</span> 
		<span class="Estilo1">[<a href="logoff.php" class="menuBoxHeadingLink">Cerrar
		  <img src="img/s_loggoff.png" border="0" alt="Cerrar Sesion" hspace="0" vspace="0"></a>] </span>
      </div>
  </td>-->
<?
if(empty($_GET['title']))
{
?>
<td class=header >
&Aacute;RBOL GENEAL&Oacute;GICO  &nbsp; : &nbsp;<span style='color:yellow;'><?php echo $_GET['id'];?></span>
 <?php 
  $dato=name($_GET['id'],$link);
  echo $dato[0][nombre] ." - ".$dato[0][prefijo];
?>
</td>
<?
}
?>
<td colspan=1 align=right class=header>
  <?php 
  
  /*
if(session_is_registered('xusu') && session_is_registered('xid'))
{
if($_SESSION['xusu']=="Desconocido")
{ echo "<img src='img/b_usrdrop.png'>Usuario :".$_SESSION['xusu'];}
else
{
   echo "<img src='img/b_usrcheck.png'>Usuario :".$_SESSION['xusu'];
  //echo "cod doc :".$_SESSION['xid'];
}
}
else
{
echo "<img src='img/b_usrdrop.png'>Usuario no ha iniciado session !";
}*/
?>
<td></tr>




