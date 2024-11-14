<?
require("constante.php");
require(DIR_FUNCTION."conectar.php");
require(DIR_FUNCTION."queries.php");
require(DIR_FUNCTION."general.php");
require(DIR_VALIDAR);
$shtml="";
 			$idConcurso=$_POST["idConcurso"];
			$idCatego=$_POST["idCatego"];
			$idGrupo=$_POST["idGrupo"];
		//	echo "$idGrupo...".$idGrupo;
if($idGrupo==-1){
	$data=grupoXCategoriaItems($idCatego,$link);
	if(sizeof($data)>0){
			for ($i=0; $i < sizeof($data); $i++) { 
				 
						$datos=listarResultadoConcurso($idConcurso,$idCatego,$data[$i]["id"],$link);
						//echo "<br>Total partivipantes..".sizeof($datos)."param concur.. ".$idConcurso." catego.. ".$idCatego." grupo.. ".$data[$i]["id"];
						$datosCab=listarCabResultadoConcurso($idConcurso,$idCatego,$data[$i]["id"],$link);

						$shtml=$shtml.detaConcurso($datos,$datosCab);
			}
	 }else{
	 		$datos=listarResultadoConcurso($idConcurso,$idCatego,0,$link);
	 		$datosCab=listarCabResultadoConcurso($idConcurso,$idCatego,0,$link);
			$shtml=detaConcurso($datos,$datosCab);
	 }
}else{
			$datos=listarResultadoConcurso($idConcurso,$idCatego,$idGrupo,$link);
			$datosCab=listarCabResultadoConcurso($idConcurso,$idCatego,$idGrupo,$link);
			$shtml=detaConcurso($datos,$datosCab);
}

 echo $shtml;
 echo"<br>";


function detaConcurso($datos,$datosCab){

$num=sizeof($datos);
$shtml.="<br><center><div  style='    border-radius: 25px;
    border: 1px solid brown;
    padding: 20px; 
    width: 95%;
     '><br/><center><table border=0 width=100% style='border-collapse:collapse;'>";
				$shtml.="<tr height=30   class='ui-dialog-titlebar ui-widget-header'>
				<td align=center>Nombre del Concurso</td>
				<td align=center>Fecha Concurso</td>
				<td align=center>Juez </td>
				<td align=center>Categoria</td>
				<td align=center width=10%>Grupo</td>
				</tr>";
				if(sizeof($datosCab)>0)
				{
						   $cssRow=" class=normaltd	";
						   $shtml.="<tr valign=top >";
  					       $shtml.="<td ".$cssRow.">".$datosCab[0][concurso]."</td>";
						   $shtml.="<td ".$cssRow.">".$datosCab[0][fecha]."</td>";
		   	  			   $shtml.="<td ".$cssRow.">".$datosCab[0][juez]."</td>";			
						   $shtml.="<td ".$cssRow.">".$datosCab[0][categoria]."</td>";
						   $shtml.="<td ".$cssRow.">".$datosCab[0][grupo]."</td>";
						   $shtml.="</tr>";
				}
$shtml.="</table></center>"; 		 

$shtml.="<br/><br/><center>	<table border=1 width=100% style='border-collapse:collapse;'>";
				$shtml.="
				<tr><td colspan=10>Resultados del Concurso: </td></tr>
				<tr height=30   class='ui-dialog-titlebar ui-widget-header'>
				<td align=center style='width:10px;'>Result. Nro.</td>
				<td align=center style='width:70px;'>C&oacute;digo</td>
				<td align=center>Nombre</td>
				<td align=center>Pref.</td>
				<td align=center>Fec/Nac</td>
				<td align=center>Padre</td>
				<td align=center>Madre</td>
				<td align=center>Criador</td>
				<td align=center>Propietario</td>
				<td align=center>Microchip</td></tr>";
				for($c=0;$c<sizeof($datos);$c++)
				{
					if($c%2==0){
						$cssRow=" ";
					}else{
						$cssRow=" style= background:#E3F6CE;	";
					}
						   $shtml.="<tr valign=top class='xxgridHtmlRow'>";
						   $shtml.="<td ".$cssRow." align=center>".$datos[$c][puesto]."</td>";
						   $shtml.="<td ".$cssRow.">".$datos[$c][codigo]."</td>";
						   $shtml.="<td ".$cssRow.">".$datos[$c][ejemplar]."</td>";
						   $shtml.="<td ".$cssRow.">".$datos[$c][prefijo]."</td>";
  					       $shtml.="<td ".$cssRow.">".$datos[$c][fecnac]."</td>";
  					       $shtml.="<td ".$cssRow.">".$datos[$c][prefpa]." ".$datos[$c][nompad]."</td>";
  					       $shtml.="<td ".$cssRow.">".$datos[$c][prefma]." ".$datos[$c][nommad]."</td>";
  					       $shtml.="<td ".$cssRow.">".$datos[$c][criador]."</td>";
  					       $shtml.="<td ".$cssRow.">".$datos[$c][propie]."</td>";
  					       $shtml.="<td ".$cssRow.">".$datos[$c][microchip]."</td>";

						   $shtml.="</tr>";

						   
				}


$shtml.="</table></center>";

if($num==0){
$shtml.="<br><center><table border=0 width=50%><tr><td height=30  style='color:gray;font-size:11px;'>
			No se encontraron resultados del concurso.</td></tr></table></center>";	
}
$shtml.="</div></center>";
return $shtml;

}
?>