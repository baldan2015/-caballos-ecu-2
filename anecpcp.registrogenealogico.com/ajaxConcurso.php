<?  
require("constante.php");
require(DIR_FUNCTION."conectar.php");
require(DIR_FUNCTION."queries.php");
require(DIR_FUNCTION."general.php");
require(DIR_VALIDAR);
   
$shtml="";
if(1)//ValidarSession())
{
			$idhorse=$_POST["idhorse"];
			$datos=concursoXEjemplar($idhorse,$link);

			 
			$cn=new Connection();
			$link=$cn->Conectar();
				 
			$num=sizeof($datos);
			$ejemplar=name($idhorse,$link);

$shtml.="<table border=0 width=100%><tr><td>
            <label name='ancla' style='font-size:15px;color:gray;font-weight:bold;'>
			Concursos que participó el ejemplar: ".$idhorse." - ".$ejemplar[0][nombre]." - ".$ejemplar[0][prefijo]." </label>
			</td> </table>";	
		 

$shtml.="<br/><table border=1 width=100% style='border-collapse:collapse;'>";
				$shtml.="<tr height=30   class='ui-dialog-titlebar ui-widget-header'>
				<td>N&deg;</td>
				<td align=center>Nombre del Concurso</td>
				<td align=center>Fecha Concurso</td>
				<td align=center>Juez </td>
				<td align=center>Categoria</td>
				<td align=center width=10%>Grupo</td>
				<td align=center>Puesto Obtenido</td></tr>";
				for($c=0;$c<sizeof($datos);$c++)
				{
						$cssRow=" class=normaltd	";
						   $shtml.="<tr valign=top class='gridHtmlRow'>";
						   $shtml.="<td ".$cssRow.">".($c+1)."</td>";
  					       $shtml.="<td ".$cssRow.">".$datos[$c][concurso]."</td>";
						   $shtml.="<td ".$cssRow.">".$datos[$c][fecha]."</td>";
		   	  			   $shtml.="<td ".$cssRow.">".$datos[$c][juez]."</td>";			
						   $shtml.="<td ".$cssRow.">".$datos[$c][categoria]."</td>";
						   $shtml.="<td ".$cssRow.">".$datos[$c][grupo]."</td>";
				     	   $shtml.="<td ".$cssRow." align=center>".$datos[$c][puesto]."</td>";
						   $shtml.="</tr>";

						   
				}


$shtml.="</table>";

$shtml.="<table border=0 width=100%><tr><td height=30 colspan=1 align=right style='color:gray;font-size:11px;'>
			N&deg; de participaciones en concursos: ".$num."</td></tr></table></td></tr>";	
		 

}
else{

		$shtml="Su sesion ha finalizado.";

}

 echo $shtml;

?>