<? include("constante.php");
echo"<tr><td colspan=2 valign=top>";
echo"<div  class='printable'>";
$id=$_GET['id'];
//buscardescendencia($id,$link);
include("genealogia.php");
echo "<div>";
echo"</td></tr>";
echo"<tr><td colspan=2 bgcolor=whitesmoke valign=top align=center >";

?>
	<a href="#" id="btnPrint"   ><img src='img/b_print.png' border=0>&nbsp;Vista de Impresi&oacute;n </a>
<?
echo"</td></tr>";


?>





<!--<table border=0 width=100% > href="printarbol.php?id=<?=$id?>#print" target=_Blank
</table>-->