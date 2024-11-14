<?session_start();
	date_default_timezone_set("UTC");
	require("../Clases/conexion.php");
	require("../Clases/resultado.php");

	$cn=new Connection();
	$link=$cn->Conectar();

	$retorno=new Resultado();

	if(isset($_POST['opc'])){

		if($_POST['opc'] == 'rpt1'){
			$desde = $_POST['desde'];
			$hasta = $_POST['hasta'];
			$criador = $_POST['criador'];
			echo reporte1($link,$desde,$hasta,$criador);
		}
		if($_POST['opc'] == 'rpt2'){
			$desde = $_POST['desde'];
			$hasta = $_POST['hasta'];
			$prop = $_POST['prop'];
			echo reporte2($link,$desde,$hasta,$prop);
		}
		if($_POST['opc'] == 'rptPrefijo'){
			$criador = $_POST['criador'];
			if(isset($_POST['xls']) && $_POST['xls']=="1"){
				$file="usuarios_web_".date('d_n_Y');
				header("content-Disposition:attachment;filename=$file.xls");
				header("content-type:application/vnd.ms-excel");
				$html="Lista de Criadores - Prefijo";
			}
			$html.=reportePref($link,$criador);
			echo $html;
		}

		if($_POST['opc'] == 'rptCriaPadre'){
			$desde = $_POST['desde'];
			$hasta = $_POST['hasta'];
			$ejemplar = $_POST['ejemplar'];
			echo reporteCriaPadre($link,$desde,$hasta,$ejemplar);
		}
		
	}

	function reporte1($link,$desde,$hasta,$criador)
	{

		$min=$desde;
		$max=$hasta;
		$html="<table border=1 width=98% id='reporteTb'  >";
		/*
		$sql="SELECT cl.idCriador,ente.razonSocial, year(e.fecNace) anio ,count(*)totalNacido ,c.prefijo
		FROM registro_sge.sge_ejemplar  e
		INNER JOIN registro_sge.sge_criadorlog cl ON(cl.idEjemplar=e.id)
		INNER JOIN registro_sge.sge_entidad ente ON(ente.id=cl.idCriador) 
		INNER JOIN registro_sge.sge_criador c ON(c.id=cl.idCriador) 
		WHERE
		cl.fecFin is null  AND
		e.fecEliminado is null AND
		year(e.fecNace) >= $min  AND  year(e.fecNace) <= $max  AND
		ente.razonSocial LIKE '%".$criador."%'

		GROUP BY cl.idCriador,ente.razonSocial,year(e.fecNace),c.prefijo
		ORDER BY 2,3";
		*/
		$sql=" SELECT idCriador,razonSocial, anio ,sum(totalNacido) totalNacido ,prefijo from (
SELECT cl.idCriador,ente.razonSocial, year(e.fecNace) anio ,count(*)totalNacido ,c.prefijo 
FROM sge_ejemplar e 
INNER JOIN sge_criadorlog cl ON(cl.idEjemplar=e.id) 
INNER JOIN sge_entidad ente ON(ente.id=cl.idCriador) 
INNER JOIN sge_criador c ON(c.id=cl.idCriador) 
WHERE cl.fecFin is null 
AND e.fecEliminado is null 
AND year(e.fecNace) >= $min AND year(e.fecNace) <= $max 
AND ente.razonSocial LIKE '%".$criador."%'
GROUP BY cl.idCriador,ente.razonSocial,year(e.fecNace),c.prefijo 
 UNION ALL
SELECT cl.idCriador,ente.razonSocial, para_vnombre_parametro anio , 0 totalNacido ,c.prefijo 
FROM 
sge_criadorlog cl
INNER JOIN sge_entidad ente ON(ente.id=cl.idCriador) 
INNER JOIN sge_criador c ON(c.id=cl.idCriador) , sge_parametro param
WHERE cl.fecFin is null 
AND param.para_dvalor_numerico >= $min AND param.para_dvalor_numerico <= $max 
AND ente.razonSocial LIKE '%".$criador."%'
GROUP BY cl.idCriador,ente.razonSocial,para_vnombre_parametro,c.prefijo 
 ) Q 
GROUP BY idCriador,razonSocial,anio,prefijo 
ORDER BY 2,3";
 // echo  $sql;
		$result = mysqli_query($link,$sql);
		$colspanAnio=($max-$min)+1;
		$html.="
		<tr>
		<td style='background:gray;color:white;'><b>CRIADOR</b></td>
		<td style='background:gray;color:white;'><b>PREFIJO</b></td>
		<td  style='background:gray;color:white;' class='bordeReporte' colspan=$colspanAnio><b><center> AÑO / CANTIDAD NACIDOS</center> </b></td>
		</tr>
		";
		$idLast=0;
		$i=0;

		while($res = mysqli_fetch_array($result)){
			$cantidad=$res[3]==0?' - ':$res[3];
			if($res[0]!=$idLast ){
				 $html.="<tr>";
		   		 $html.="<td width=30%>".strtoupper($res[1])."</td><td  class='bordeReporte' >".strtoupper($res[4])."</td>
		   		 		 <td class='bordeReporte'><center>&nbsp;".$res[2]." &nbsp; <hr  class='bordeReporte' > ".$cantidad."</center></td> ";
			}else{
				 $html.="<td  class='bordeReporte' ><center>&nbsp;".$res[2]."&nbsp; <hr   class='bordeReporte' >".$cantidad."</center></td> ";
			}
			 
			 $idLast=$res[0];
		}
	 	mysqli_free_result($result);
		$html.="</table>";
		return $html;
	}	

	function reporte2($link,$desde,$hasta,$prop)
	{

		$min=$desde;
		$max=$hasta;
		$html="<table border=1 width=98% id='reporteTb'    >";
		/*$sql="SELECT c.idProp,ente.razonSocial, year(e.fecReg) anio ,count(*)totalInscritos -- ,c.prefijo
		FROM registro_sge.sge_ejemplar  e
		INNER JOIN registro_sge.sge_propietariolog cl ON(cl.idEjemplar=e.id)
		INNER JOIN registro_sge.sge_propietario c ON(c.idProp=cl.idPropietario) 
		INNER JOIN registro_sge.sge_entidad ente ON(ente.id=c.idEntidad) 
		WHERE
		cl.fecFin is null  AND
		e.fecEliminado is null AND
		year(e.fecReg) >= $min  AND  year(e.fecReg) <=  $max  AND
		ente.razonSocial LIKE '%$prop%'

		GROUP BY c.idProp,ente.razonSocial,year(e.fecReg) 
		ORDER BY 2,3;";
*/
		$sql="SELECT idProp,razonSocial,anio,SUM(totalInscritos) totalInscritos FROM (
   SELECT c.idProp,ente.razonSocial, year(e.fecReg) anio ,count(*)totalInscritos  
  FROM sge_ejemplar e 
  INNER JOIN sge_propietariolog cl ON(cl.idEjemplar=e.id) 
  INNER JOIN sge_propietario c ON(c.idProp=cl.idPropietario) 
  INNER JOIN sge_entidad ente ON(ente.id=c.idEntidad) 
  WHERE cl.fecFin is null AND e.fecEliminado is null 
  AND year(e.fecReg) >= $min AND year(e.fecReg) <= $max 
  AND ente.razonSocial LIKE '%$prop%'
  AND c.flgTipo!='C'
  GROUP BY c.idProp,ente.razonSocial,year(e.fecReg) 

 
   union all
 
  SELECT c.idProp,ente.razonSocial, param.para_vnombre_parametro anio ,0 totalInscritos  
  FROM 
  sge_propietariolog cl   
  INNER JOIN sge_propietario c ON(c.idProp=cl.idPropietario) 
  INNER JOIN sge_entidad ente ON(ente.id=c.idEntidad) 
  , sge_parametro param
  WHERE cl.fecFin is null
  AND param.para_dvalor_numerico >= $min AND param.para_dvalor_numerico <= $max 
  AND ente.razonSocial LIKE '%$prop%'
  AND c.flgTipo!='C'
 ) Q GROUP BY idProp,razonSocial,anio
 ORDER BY 2,3,1";
// echo  $sql;
		$result = mysqli_query($link,$sql);
		$colspanAnio=($max-$min)+1;
//<td style='background:gray;color:white;'><b>Prefijo</b></td>
		$html.="
		<tr><td style='background:gray;color:white;'><b>PROPIETARIO</b></td>
		<td  style='background:gray; color:white;' class='bordeReporte' colspan=$colspanAnio><b> <center>AÑOS / CANTIDAD</center></b></td>
		</tr>";
		$idLast=0;
		$i=0;

		while($res = mysqli_fetch_array($result)){
			$cantidad=$res[3]==0?' - ':$res[3];
			if($res[0]!=$idLast ){
				 $html.="<tr>";
		   		 $html.="<td width=30%>".strtoupper($res[1])."</td>
		   		 		 <td class='bordeReporte'><center>&nbsp;".$res[2]." &nbsp; <hr  class='bordeReporte'> ".$cantidad."</center></td> ";
			}else{
				 $html.="<td class='bordeReporte'><center>&nbsp;".$res[2]."&nbsp; <hr  class='bordeReporte'>".$cantidad."</center></td> ";
			}
			 
			 $idLast=$res[0];
		}
	 	mysqli_free_result($result);
		$html.="</table>";
		return $html;
	}	

	function reportePref($link,$criador)
	{

		$min=$desde;
		$max=$hasta;
		$html="<table border=1 id='reporteTb'   >";
		$sql="SELECT razonSocial,prefijo FROM sge_criador c 
				INNER JOIN sge_entidad e on(e.id=c.id)
				WHERE razonSocial LIKE '%".$criador."%' order by 1;";

//echo  $sql;
		$result = mysqli_query($link,$sql);
		$html.=" <tr><td style='background:gray;color:white;'>&nbsp;...</td>
		<td style='background:gray;color:white;'><b>Criador</b></td>
		<td style='background:gray;color:white;' class='bordeReporte'><b> Prefijo </b></td></tr> ";
		$i=1;
		while($res = mysqli_fetch_object($result)){
			 
				 $html.="<tr>";
		   		 $html.="<td  class='bordeReporte'>$i</td><td  class='bordeReporte'>".strtoupper($res->razonSocial)."</td><td  class='bordeReporte'>".strtoupper($res->prefijo)."</td> ";
		   		 $html.="</tr>";
		   		 $i++;
		}
	 	mysqli_free_result($result);
		$html.="</table>";


		return $html;
	}	

	function reporteCriaPadre($link,$desde,$hasta,$criador)
	{

		$min=$desde;
		$max=$hasta;
		$html="<table border=1 width=98% >";
		$sql="SELECT cl.idCriador,ente.razonSocial, year(e.fecNace) anio ,count(*)totalNacido ,c.prefijo
		FROM sge_ejemplar  e
		INNER JOIN sge_criadorlog cl ON(cl.idEjemplar=e.id)
		INNER JOIN sge_entidad ente ON(ente.id=cl.idCriador) 
		INNER JOIN sge_criador c ON(c.id=cl.idCriador) 
		WHERE
		cl.fecFin is null  AND
		e.fecEliminado is null AND
		year(e.fecNace) >= $min  AND  year(e.fecNace) <= $max  AND
		ente.razonSocial LIKE '%".$criador."%'

		GROUP BY cl.idCriador,ente.razonSocial,year(e.fecNace),c.prefijo
		ORDER BY 2,3";

//echo  $sql;
		$result = mysqli_query($link,$sql);

		$html.="<th><tr><td style='background:gray;color:white;'><b>Criador</b></td>
		<td style='background:gray;color:white;'><b>Prefijo</b></td>
		<td  style='background:gray;border:1px solid #cd6a51;color:white;'><b> Años </b></td></tr></th>";
		$idLast=0;
		$i=0;

		while($res = mysqli_fetch_array($result)){
			if($res[0]!=$idLast ){
				 $html.="<tr>";
		   		 $html.="<td width=30%>".$res[1]."</td><td style='border:1px solid #cd6a51;'>".$res[4]."</td>
		   		 		 <td style='border:1px solid #cd6a51;'><center>&nbsp;".$res[2]." &nbsp; <hr  style='border:1px solid #cd6a51;'> ".$res[3]."</center></td> ";
			}else{
				 $html.="<td style='border:1px solid #cd6a51;'><center>&nbsp;".$res[2]."&nbsp; <hr  style='border:1px solid #cd6a51;'>".$res[3]."</center></td> ";
			}
			 
			 $idLast=$res[0];
		}
	 	mysqli_free_result($result);
		$html.="</table>";
		return $html;
	}




?>