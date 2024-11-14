<? 
function obtenerPoe($idPoe,$link){
$cn=new Connection();
$link=$cn->Conectar();
$sql=" SELECT idPoe,periodo,fecIni,fecFin,descripcion,modoLectura,
if(DATE_FORMAT(NOW(),'%Y%m%d')>=DATE_FORMAT(fecIni,'%Y%m%d') and DATE_FORMAT(NOW(),'%Y%m%d')<=DATE_FORMAT(fecFin,'%Y%m%d'),1,0) vigencia
	  FROM poe_programacion
	  WHERE  idPoe=".$idPoe."
";
//echo "<br><br><br><br><br>".$sql;

$rs=mysqli_query($link,$sql)or die("***Error en cadena de obtenerPoe ".mysqli_error($link));
$n=mysqli_num_rows($rs);	
$c=1;  

while($rows=mysqli_fetch_array($rs))
			{
				$arrayrs[]=array(
						 'id'=>$rows[0],	
						 'periodo'=>$rows[1],
						 'fecIni'=>$rows[2],
						 'fecFin'=>$rows[3],
						 'descripcion'=>$rows[4],
						 'modoLectura'=>$rows[5],
						 'vigencia'=>$rows[6]
						  );
				$c++;
			}
mysqli_close($link);
 
if($c==1){
		$arrayrs[]=array( 'id'=>'',	'periodo'=>'','fecIni'=>'','fecFin'=>'','descripcion'=>'','modoLectura'=>'','vigencia'=>'');
		 
}
print_r($arrayrs);
 
return $arrayrs;
}
function obtenerPoeActivo($link){
$sql="SELECT idPoe,periodo,fecIni,fecFin,descripcion,modoLectura
	  FROM poe_programacion order by 2 asc
";
/*WHERE fecIni+0 <=(DATE(NOW())+0) AND fecFin+0 >=(DATE(NOW())+0)*/
$rs=mysqli_query($link,$sql)or die("Error en cadena de obtenerPoeActivo ".mysqli_error($link));
$n=mysqli_num_rows($rs);	
$c=1; 	
while($rows=mysqli_fetch_array($rs))
			{
				$arrayrs[]=array(
						 'id'=>$rows[0],	
						 'periodo'=>$rows[1],
						 'fecIni'=>$rows[2],
						 'fecFin'=>$rows[3],
						 'descripcion'=>$rows[4],
						 'modoLectura'=>$rows[5]

						  );
				$c++;
			}
mysqli_close($link);
if($c==1){
		$arrayrs[]=array( 'id'=>'',	'periodo'=>'','fecIni'=>'','fecFin'=>'','descripcion'=>'');
		 
}
return $arrayrs;
}
function ConcursoItems($link){
$sql="SELECT idConcurso,nombre FROM concurso WHERE activo=1 and esPlantilla<>1 order by fecha desc";
$rs=mysqli_query($link,$sql)or die("Error en cadena de ConcursoItems ".mysqli_error($link));
$n=mysqli_num_rows($rs);	
while($rows=mysqli_fetch_array($rs))
			{
				$arrayrs[]=array(
						 'id'=>$rows[0],	
						 'nombre'=>$rows[1]
						  );
			}
mysqli_close($link);
return $arrayrs;
}
function ConcursoInscripcion($link){
$sql="SELECT idConcurso,nombre FROM concurso WHERE tieneCatal=1";
$rs=mysqli_query($link,$sql)or die("Error en cadena de ConcursoInscripcion ".mysqli_error($link));
$n=mysqli_num_rows($rs);	
while($rows=mysqli_fetch_array($rs))
			{
				$arrayrs[]=array(
						 'id'=>$rows[0],	
						 'nombre'=>$rows[1]
						  );
			}
mysqli_close($link);
return $arrayrs;
}
function CategoriaXConcursoItems($idConcurso,$link){
$sql="SELECT idCatego,nombre FROM categoria WHERE activo=1 and idConcurso=".$idConcurso;
$rs=mysqli_query($link,$sql)or die("Error en cadena de CategoriaXConcursoItems ".mysqli_error($link));
$n=mysqli_num_rows($rs);	
while($rows=mysqli_fetch_array($rs))
			{
				$arrayrs[]=array(
						 'id'=>$rows[0],	
						 'nombre'=>$rows[1]
						  );
			}
mysqli_close($link);
return $arrayrs;
}
function grupoXCategoriaItems($idCatego,$link){
$sql="SELECT idGrupo,nombre FROM grupo WHERE activo=1 and idCatego=".$idCatego;
$rs=mysqli_query($link,$sql)or die("Error en cadena de grupoXCategoriaItems ".mysqli_error($link));
$n=mysqli_num_rows($rs);	
while($rows=mysqli_fetch_array($rs))
			{
				$arrayrs[]=array(
						 'id'=>$rows[0],	
						 'nombre'=>$rows[1]
						  );
			}
mysqli_close($link);
return $arrayrs;
}
 
function buscar($data1,$data2,$link,$opc,$origen)
{
	date_default_timezone_set('UTC');
$data1=strtoupper($data1);
$data2=strtoupper($data2);
switch($opc)
	{
	case 0: $sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden,ifnull(idMetodo,0) as idMetodo  FROM ".TABLE_DATO." WHERE codigo LIKE '%$data2%' AND nombre LIKE '%$data1%' and fallec='0' ";//" order by orden desc"; //and transfer_opc='0'
			$sqlFallecido=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden,ifnull(idMetodo,0) as idMetodo FROM ".TABLE_DATO." WHERE codigo LIKE '%$data2%' AND nombre LIKE '%$data1%' and fallec='1'"; //" order by orden desc";
 
		break;
	case 1: $sql=" SELECT distinct cod_criador,criador FROM ".TABLE_DATO." WHERE cod_criador LIKE '%$data2%' AND criador LIKE '%$data1%' ";
	
		break;	
	case 2: $sql=" SELECT distinct cod_propie,propie FROM ".TABLE_DATO." WHERE cod_propie LIKE '%$data2%' AND propie LIKE '%$data1%' ";
	//echo $sql;
		break;	
	case 3: $sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden,ifnull(idMetodo,0) as idMetodo FROM ".TABLE_DATO." WHERE pelaje LIKE '%$data1%' and fallec='0' order by orden desc"; //and transfer_opc='0' 
			$sqlFallecido=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden,ifnull(idMetodo,0) as idMetodo FROM ".TABLE_DATO." WHERE pelaje LIKE '%$data1%'  and fallec='1' order by orden desc";
 
		break;
	case 4: $sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden,ifnull(idMetodo,0) as idMetodo FROM ".TABLE_DATO." WHERE microchip LIKE '%$data1%' and fallec='0'  order by orden desc"; //and transfer_opc='0's
			$sqlFallecido=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden,ifnull(idMetodo,0) as idMetodo  FROM ".TABLE_DATO." WHERE microchip LIKE '%$data1%'  and fallec='1' order by orden desc"; 
break;
case 5:  $sql="SELECT distinct if(left(codpad,1)='P',replace(codpad,'.','-'),codpad)codpad,prefpa,nompad FROM ".TABLE_DATO." WHERE codpad LIKE '%$data2%' AND nompad LIKE '%$data1%' ";
 		break;
case 6:   $sql="SELECT distinct if(left(codmad,1)='Y',replace(codmad,'.','-'),codmad)codmad,prefma,nommad FROM ".TABLE_DATO." WHERE codmad LIKE '%$data2%' AND nommad LIKE '%$data1%' ";

		break;		
	}
 
 //if($origen==1) echo $sql."<br>";
 //if($origen==2)	echo $sqlFallecido."<br>";

    mysqli_query($link,'SET NAMES utf8');
	mysqli_query($link,'SET CHARACTER_SET utf8');

if($origen==1)	{
	$rs=mysqli_query($link,$sql)or die("Error en cadena de consulta vivo ".mysqli_error($link));
	$n=mysqli_num_rows($rs);	
} 
 
 


 if(true)
  { $f=1;
     switch($opc)	
        {
 
	case 0: #ejemplar
    case 3: #pelaje
    case 4: #microchip
    		if($origen==2)	{
				$rsFallecido=mysqli_query($link,$sqlFallecido)or die("Error en cadena de consulta  sqlFallecido".mysqli_error($link));
				$nFallecido=mysqli_num_rows($rsFallecido);	
			}
			//$rsTransferido=mysql_query($sqlTransferido,$link)or die("Error en cadena de consulta  sqlTransferido".mysqli_error($link));
			//$nTransferido=mysqli_num_rows($rsTransferido);
			if($origen==1)	{
					while($rows=mysqli_fetch_array($rs))
					{
						/*addon dbs 20180228*/
						 if($rows[21]==K_TRANSFER_EMBRION && date("Ymd")>=K_FECHA_VALIDATE_TE){
		                    if(!(strpos($rows[2],"- TE")>0 || strpos($rows[2],"-TE")>0)){
		                            $rows[2]=$rows[2]." - TE";
		                    } 
		                  }

						$neofec="";	
						include("status.php");
						$neofec=$rows[3];
						$arrayrs['vivos'][]=array('n'=>$f,
								 'codigo'=>$rows[0],	
								 'prefijo_caballo'=>$rows[1],
								 'nombre_caballo'=>$rows[2],
								 'pelaje'=>$rows[10],
								 'nacimiento_caballo'=>$neofec,
								 'padre_caballo'=>$rows[6],
								 'madre_caballo'=>$rows[9],
								 'criador_caballo'=>$rows[14],
								 'propietario_caballo'=>$rows[16],
								 'fallecio'=>$status,
								 'microchip_caballo'=>$rows[18],
						 		 'adn_caballo'=>$rows[19],
						 		 'padre'=>$rows[5]." - ".$rows[6],
						 		 'madre'=>$rows[8]." - ".$rows[9]);
						$f++;
					}
			}
			$f=1;
			if($origen==2)	{
					while($rows=mysqli_fetch_array($rsFallecido))
					{
						/*addon dbs 20180228*/
						 if($rows[21]==K_TRANSFER_EMBRION && date("Ymd")>=K_FECHA_VALIDATE_TE){
		                    if(!(strpos($rows[2],"- TE")>0 || strpos($rows[2],"-TE")>0)){
		                            $rows[2]=$rows[2]." - TE";
		                    } 
		                  }
						$neofec="";	
						$neofec=$rows[3];
						include("status.php");
						$arrayrs['muertos'][]=array('n'=>$f,
								 'codigo'=>$rows[0],	
								 'prefijo_caballo'=>$rows[1],
								 'nombre_caballo'=>$rows[2],
								 'pelaje'=>$rows[10],
								 'nacimiento_caballo'=>$neofec,
								 'padre_caballo'=>$rows[6],
								 'madre_caballo'=>$rows[9],
								 'criador_caballo'=>$rows[14],
								 'propietario_caballo'=>$rows[16],
								 'fallecio'=>$status,
								 'microchip_caballo'=>$rows[18],
						 		 'adn_caballo'=>$rows[19],
						 		 'padre'=>$rows[5]." - ".$rows[6],
						 		 'madre'=>$rows[8]." - ".$rows[9]
						 		);
						$f++;
					}
			}
			/*$f=1;
			while($rows=mysqli_fetch_array($rsTransferido))
			{
				 
				 if($rows[21]==K_TRANSFER_EMBRION && date("Ymd")>=K_FECHA_VALIDATE_TE){
                    if(!(strpos($rows[2],"- TE")>0 || strpos($rows[2],"-TE")>0)){
                            $rows[2]=$rows[2]." - TE";
                    } 
                  }
				$neofec="";	
				$neofec=$rows[3];
				include("status.php");
				$arrayrs['transferidos'][]=array('n'=>$f,
						 'codigo'=>$rows[0],	
						 'prefijo_caballo'=>$rows[1],
						 'nombre_caballo'=>$rows[2],
						 'nacimiento_caballo'=>$neofec,
						 'padre_caballo'=>$rows[6],
						 'madre_caballo'=>$rows[9],
						 'criador_caballo'=>$rows[14],
						 'propietario_caballo'=>$rows[16],
						 'fallecio'=>$status,
						 'microchip_caballo'=>$rows[18],
				 		 'adn_caballo'=>$rows[19]);
				$f++;
			}*/

	break;

	case 1:
	   while($rows=mysqli_fetch_array($rs))
   	   {	
		/*$sql2="select * from  ".TABLE_DATO." WHERE cod_criador='$rows[0]'";
		 mysql_query('SET NAMES utf8');
		 mysql_query('SET CHARACTER_SET utf8');
		$rs2=mysql_query($sql2,$link)or die("Error en cadena de consulta ".mysqli_error($link));*/
		$arrayrs['criadores'][]=array('n'=>$f,
			             'id'=>$rows[0],//mysqli_result($rs2,0,'cod_criador'),
			             'nombre'=>$rows[1]);//mysqli_result($rs2,0,'criador'));
		$f++;
	     }break;
 
	case 2:
	   while($rows=mysqli_fetch_array($rs))
   	   {	
	/*	$sql23="select * from  ".TABLE_DATO." WHERE cod_propie='$rows[0]'";
	
		$rs23=mysql_query($sql23,$link)or die("Error en cadena de consulta 4".mysqli_error($link));*/
		$arrayrs['propietarios'][]=array('n'=>$f,
			             'id'=>$rows[0],//mysqli_result($rs23,0,'cod_propie'),
			             'nombre'=>$rows[1]);//mysqli_result($rs23,0,'propie'));
		$f++;
	     }break;
     case 5: #cria padre
     case 6: #cria madre
	   while($rows=mysqli_fetch_array($rs))
   	   {	
		/*$sql23="select * from  ".TABLE_DATO." WHERE cod_propie='$rows[0]'";
	
		$rs23=mysql_query($sql23,$link)or die("Error en cadena de consulta 4".mysqli_error($link));*/
		$arrayrs['propietarios'][]=array('n'=>$f,
			             'id'=>$rows[0], 
			             'nombre'=>$rows[1]." - ".$rows[2]);
		 $f++;
	     }break;
      }//fin de switch

  }
  else
  {
	$arrayrs=-1;	
  }	
//echo"<pre>";print_r($arrayrs);echo"</pre>";
return $arrayrs;




mysqli_close($link);


}

function detalleCaballo($idhorse,$link)
{
date_default_timezone_set('UTC');
/*$sql="select codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec,microchip,adn_horse,capado,ifnull(idMetodo,0) as idMetodo from ".TABLE_DATO." where codigo='$idhorse'";
*/
/*addon dbs ecu*/
$sql=" select codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
ifnull(codpad,(select ee.codigo FROM sgev_ejemplares_extranjeros ee WHERE ee.codigo=d.codpad))codpad , 
ifnull(prefpa, (select ee.prefijo FROM sgev_ejemplares_extranjeros ee WHERE ee.codigo=d.codpad))prefpa,
ifnull(nompad, (select ee.nombre FROM sgev_ejemplares_extranjeros ee WHERE ee.codigo=d.codpad))nompad,
IFNULL(codmad, (select ee.codigo FROM sgev_ejemplares_extranjeros ee WHERE ee.codigo=d.codmad))codmad, 
IFNULL(prefma, (SELECT ee.prefijo FROM sgev_ejemplares_extranjeros ee WHERE ee.codigo=d.codmad))prefma,
IFNULL(nommad, (SELECT ee.nombre FROM sgev_ejemplares_extranjeros ee WHERE ee.codigo=d.codmad))nommad,
d.pelaje,descri,lugnac,
cod_criador,criador,cod_propie,propie,fallec,d.microchip,adn_horse,capado,ifnull(d.idMetodo,0) as idMetodo,
d.genero
from datos220206 d
where codigo='$idhorse'" ;

 //echo $sql;
$rs=mysqli_query($link,$sql)or die("Error en cadena de consulta detalleCaballo ".mysqli_error($link));
$n=mysqli_num_rows($rs);	

 if($n>0)
  { $f=1;
	while($rows=mysqli_fetch_array($rs))
	{	
		/*addon dbs 20180228*/
				 if($rows[21]==K_TRANSFER_EMBRION && date("Ymd")>=K_FECHA_VALIDATE_TE){
                    if(!(strpos($rows[2],"- TE")>0 || strpos($rows[2],"-TE")>0)){
                            $rows[2]=$rows[2]." - TE";
                    } 
                  }
		include("status.php");
		if($rows[3]=="00-00-000"){
			$neofec="&nbsp;";				
		}

		$arrayrs2[]=array('n'=>$f,
				 'codigo'=>$rows[0],	
				 'prefijo_caballo'=>$rows[1],
				 'nombre_caballo'=>($rows[2]),
				 'nacimiento_caballo'=>$rows[3],
				 'codigo_padre_caballo'=>$rows[4],
				 'prefijo_padre_caballo'=>$rows[5],
				 'nombre_padre_caballo'=>($rows[6]),
				 'codigo_madre_caballo'=>$rows[7],
				 'prefijo_madre_caballo'=>$rows[8],
				 'nombre_madre_caballo'=>($rows[9]),
				 'pelaje_caballo'=>($rows[10]),
				 'descripcion_caballo'=>(deserializarData($rows[11],$link)),
				 'lugar_nac_caballo'=>($rows[12]),	
				 'codigo_criador_caballo'=>$rows[13],
				 'nombre_criador_caballo'=>$rows[14],
				 'codigo_propietario_caballo'=>$rows[15],
				 'nombre_propietario_caballo'=>($rows[16]),
   			     'microchip_caballo'=>$rows[18],
				 'adn_caballo'=>$rows[19],
				 'fallecio'=>$status,
				 'capado'=>$rows[20],
				 'genero'=>$rows[22]);
		$f++;
	}
  }
  else
  {
	$arrayrs2=-1;	
  }	
//  echo"<pre>";print_r($arrayrs2);echo"</pre>";
return $arrayrs2;



mysqli_close($link);

}








function Buscar_cria($sql,$link)
{  
date_default_timezone_set('UTC');
$rs=mysqli_query($link,$sql)or die("Error en cadena de consulta 2 ".mysqli_error($link));
$n=mysqli_num_rows($rs);	

 if($n>0)
  { $f=1;
	while($rows=mysqli_fetch_array($rs))
	{	
		/*addon dbs 20180228*/
				 if($rows[19]==K_TRANSFER_EMBRION && date("Ymd")>=K_FECHA_VALIDATE_TE){
                    if(!(strpos($rows[2],"- TE")>0 || strpos($rows[2],"-TE")>0)){
                            $rows[2]=$rows[2]." - TE";
                    } 
                  }

		include("status.php");
		if($rows[3]=="00-00-000"){
			$neofec="&nbsp;";				
		}

		$arraycria[]=array('n'=>$f,
				 'codigo'=>$rows[0],	
				 'prefijo_caballo'=>$rows[1],
				 'nombre_caballo'=>($rows[2]),
				 'nacimiento_caballo'=>$rows[3],
				 'codigo_padre_caballo'=>$rows[4],
				 'prefijo_padre_caballo'=>$rows[5],
				 'nombre_padre_caballo'=>($rows[6]),
				 'codigo_madre_caballo'=>$rows[7],
				 'prefijo_madre_caballo'=>$rows[8],
				 'nombre_madre_caballo'=>($rows[9]),
				 'pelaje_caballo'=>($rows[10]),
				 'descripcion_caballo'=>($rows[11]),
				 'lugar_nac_caballo'=>$rows[12],	
				 'codigo_criador_caballo'=>$rows[13],
				 'nombre_criador_caballo'=>($rows[14]),
				 'codigo_propietario_caballo'=>$rows[15],
				 'nombre_propietario_caballo'=>($rows[16]),
				 'fallecio'=>$status);
		$f++;
	}
  }
  else
  {
	$arraycria=-1;	
  }	
// echo"<pre>";print_r($arraycria);echo"</pre>";
						return $arraycria;

mysqli_close($link);

}

/*
addon  obtiene nombre de criador
*/
function obtieneNombreCriador($id,$link)
{
 // $sql3="select criador from ".TABLE_DATO." where cod_criador='$id'";
  $sql3=" SELECT e.razonSocial criador  from sge_entidad e where e.id=$id";

$rs3=mysqli_query($link,$sql3)or die("Error en cadena de consulta 2 ".mysqli_error($link));
$n3=mysqli_num_rows($rs3);	
 if($n3>0)
  { 	
   $nombre=mysqli_result($rs3,0,'criador');				
  }
else
 {
   $nombre=" - ";				
 }
  return  ($nombre);
}
/*
addon  obtiene nombre de propietario
*/
function obtieneNombrePropietario($id,$link)
{

//$sql3="select propie from ".TABLE_DATO." where cod_propie='$id'";
$sql3="SELECT GROUP_CONCAT(e.razonSocial  ORDER BY p.correlativo ASC SEPARATOR ' / ') propie
            FROM sge_propietario p JOIN sge_entidad e ON (e.id = p.IdEntidad)
            WHERE           p.idProp = $id
            ";

// echo $sql3;
$rs3=mysqli_query($link,$sql3)or die("Error en cadena de consulta 2 ".mysqli_error($link));
$n3=mysqli_num_rows($rs3);	
 if($n3>0)
  { 	
   $nombre=mysqli_result($rs3,0,'propie');	
  // echo $nombre;			
  }
else
 {
   $nombre=" - ";				
 }
  return  ($nombre);
}
/*
addon dbs 20151202
*/
function concursoXEjemplar($idhorse,$link)
{

$sql="select c.nombre,ifnull(DATE_FORMAT(c.fecha,'%d/%m/%Y'),'')as fecha,
c.juez,r.desCategoria,r.desGrupo,r.nroPuesto from resultado  r 
        inner join concurso c on(r.idConcurso=c.idConcurso)
        where r.idEjemplar='".$idhorse."' and
        r.activo=1 and
        c.activo=1
         order by c.fecha desc ";
 
$rs=mysqli_query($link,$sql)or die("Error en cadena de concursoXEjemplar  ".mysqli_error($link));
$n=mysqli_num_rows($rs);	
$i=1;
 if($n>0)
  {  
	while($rows=mysqli_fetch_array($rs))
	{	
 		$arrayrs2[]=array(
			 	 'numero'=>$i,
				 'concurso'=>$rows[0],	
				 'fecha'=>$rows[1],
				 'juez'=>$rows[2],
				 'categoria'=>$rows[3],
				 'grupo'=>$rows[4],
				 'puesto'=>$rows[5]
				);
				++$i;
	}
  }
mysqli_close($link);  
return $arrayrs2;
}

function listarResultadoConcurso($idConcurso,$idCatego,$idGrupo,$link)
{

$sql="select   d.nombre,d.prefij,r.nroPuesto,
d.codigo,ifnull(DATE_FORMAT(d.fecnac,'%d/%m/%Y'),'-')as fecnac, d.prefpa,d.nompad,d.prefma,d.nommad,d.criador,

CASE WHEN r.propietario IS NULL OR r.propietario = '' 
       THEN d.propie
       ELSE r.propietario END AS propietario,

d.microchip
from resultado r 
inner join datos220206 d on(d.codigo =r.idEjemplar) 
        where
       
        r.idConcurso=".$idConcurso." and
         r.idCatego=".$idCatego." and
         r.idGrupo=".$idGrupo."
         order by r.nroPuesto asc ";
//echo $sql;

$rs=mysqli_query($link,$sql)or die("Error en cadena de listarResultadoConcurso  ".mysqli_error($link));
$n=mysqli_num_rows($rs);	

 if($n>0)
  {  
	while($rows=mysqli_fetch_array($rs))
	{	
 		$arrayrs2[]=array('n'=>$f,
				 'ejemplar'=>$rows[0],
				 'prefijo'=>$rows[1],
				 'puesto'=>$rows[2],
				 'codigo'=>$rows[3],
				 'fecnac'=>$rows[4],
				 'prefpa'=>$rows[5],
				 'nompad'=>$rows[6],
				 'prefma'=>$rows[7],
				 'nommad'=>$rows[8],
				 'criador'=>$rows[9],
				 'propie'=>$rows[10],
				 'microchip'=>$rows[11]
				);
	}
  }
  
return $arrayrs2;
}

function listarCabResultadoConcurso($idConcurso,$idCatego,$idGrupo,$link)
{

$sql="select  c.nombre,ifnull(DATE_FORMAT(fecha,'%d/%m/%Y'),'-')as fecha,juez,cat.nombre,g.nombre from 
concurso c inner join categoria cat on(c.idConcurso = cat.idConcurso)
           left join grupo g on(cat.idCatego = g.idCatego)
 where 
		c.activo=1 and g.activo=1
		and cat.activo=1 and
        c.idConcurso=".$idConcurso." and
         g.idCatego=".$idCatego." and
         (g.idGrupo=".$idGrupo." or ".$idGrupo."=0)
         order by c.fecha desc ";

$rs=mysqli_query($link,$sql)or die("Error en cadena de listarCabResultadoConcurso  ".mysqli_error($link));
$n=mysqli_num_rows($rs);	

 if($n>0)
  {  
	while($rows=mysqli_fetch_array($rs))
	{	
 		$arrayrs2[]=array('n'=>$f,
				 'concurso'=>$rows[0],	
				 'fecha'=>$rows[1],
				 'juez'=>$rows[2],
				 'categoria'=>$rows[3],
				 'grupo'=>$rows[4]
				);
	}
  }
  
return $arrayrs2;
}

function buscardescendencia($id,$link)
{

$xid=$id;
$codigo=$id;
$x=1;
//    echo"descendencia del padre<br>";
        for($i=0;$i<4;$i++)
	{
		/*$sql2="SELECT codpad,codmad FROM (
				SELECT idPadre codpad,idMadre codmad FROM sge_ejemplar WHERE id='$id'
				UNION ALL
			   SELECT idPadre codpad,idMadre codmad FROM sge_ejemplar_peru ep 
			 	WHERE id='".str_replace(".", "-", $id)."'
			 	 ) q LIMIT 1
			";	*/

$sql2=" SELECT codpad,codmad,nombrePad,prefijoPad,pelajePad,fecnacPad,nombreMad,prefijoMad,pelajeMad,fecnacMad FROM
		 (
		 SELECT hijo.idPadre codpad,hijo.idMadre codmad,
		 

		ifnull(padre.nombre,ppp.nombre) nombrePad,
		ifnull(padre.prefijo,ppp.prefijo) prefijoPad,
		ifnull(pp.nombre,ppp.pelaje) pelajePad,
		ifnull(DATE_FORMAT(ifnull(padre.fecNace,ppp.fecNace),'%d/%m/%Y'),'-')as fecnacPad, 

		ifnull(madre.nombre,ppm.nombre) nombreMad,
		ifnull(madre.prefijo,ppm.prefijo) prefijoMad,
		ifnull(pm.nombre,ppm.pelaje) pelajeMad,
		ifnull(DATE_FORMAT(ifnull(madre.fecNace,ppm.fecNace),'%d/%m/%Y'),'-')as fecnacMad

		 FROM sge_ejemplar hijo 
		 LEFT JOIN  sge_ejemplar padre on(hijo.idPadre=padre.id)
		 LEFT JOIN  sge_ejemplar madre on(hijo.idMadre=madre.id)


		 LEFT JOIN sge_ejemplar_peru ppp on(REPLACE(hijo.idPadre,'.','-')=ppp.id) 
		 LEFT JOIN sge_ejemplar_peru ppm on(REPLACE(hijo.idMadre,'.','-')=ppm.id) 

		 LEFT JOIN  sge_pelaje pp on(pp.id=padre.idPelaje)
		 LEFT JOIN  sge_pelaje pm on(pm.id=madre.idPelaje)
		 WHERE hijo.id='$id'
		 UNION  ALL
		 SELECT  hijo.idPadre codpad,hijo.idMadre codmad,
		padre.nombre nombrePad,padre.prefijo prefijoPad, padre.pelaje pelajePad,ifnull(DATE_FORMAT(padre.fecNace,'%d/%m/%Y'),'-')as fecnacPad,
		madre.nombre nombreMad,madre.prefijo prefijoMad, madre.pelaje pelajeMad,ifnull(DATE_FORMAT(madre.fecNace,'%d/%m/%Y'),'-')as fecnacMad
		 FROM sge_ejemplar_peru hijo  
		 LEFT JOIN  sge_ejemplar_peru padre on(hijo.idPadre=padre.id)
		 LEFT JOIN  sge_ejemplar_peru madre on(hijo.idMadre=madre.id)
		 WHERE hijo.id='".str_replace(".", "-", $id)."'
		 ) q limit 1
 ";

		//echo $i." - ".$sql2."</br>";
		$rs2=mysql_query($sql2,$link)or die("Error en cadena de consulta 2 ".mysqli_error($link));
		$n2=mysqli_num_rows($rs2);	
		
		if($n2>0)
		  { 
			
	  		 $papa=mysqli_result($rs2,0,'codpad');				
			 $xmama=mysqli_result($rs2,0,'codmad');
				
			 $nombreP=mysqli_result($rs2,0,'nombrePad');				
   			 $prefijoP=mysqli_result($rs2,0,'prefijoPad');
   			 $pelajeP=mysqli_result($rs2,0,'pelajePad');
   			 $fecnacP=mysqli_result($rs2,0,'fecnacPad');					

   			 $nombreM=mysqli_result($rs2,0,'nombreMad');				
   			 $prefijoM=mysqli_result($rs2,0,'prefijoMad');
   			 $pelajeM=mysqli_result($rs2,0,'pelajeMad');
   			 $fecnacM=mysqli_result($rs2,0,'fecnacMad');	

			 $id=$papa;

			 
		}else{
			
			/* $sql2="SELECT idPadre codpad,idMadre codmad from sge_ejemplar_peru ep 
			 where id='".str_replace(".", "-", $id)."'";
			 echo $i." - ".$sql2."</br>";
			 $rs2=mysql_query($sql2,$link)or die("Error en cadena de consulta PERU ".mysqli_error($link));
				$n2=mysqli_num_rows($rs2);	
				 if($n2>0)
				  { 
			  		 $papa=mysqli_result($rs2,0,'codpad');				
					 $xmama=mysqli_result($rs2,0,'codmad');				

					 $id=$papa;
				}else{
					*/
					$id=0;
					$papa="-";				
					$xmama="-";	

					 $nombreP="N.N";			
		   			 $prefijoP=" ";
		   			 $pelajeP="N.N";
		   			 $fecnacP="N.N";

		   			 $nombreM="N.N";
		   			 $prefijoM=" ";
		   			 $pelajeM="N.N";
		   			 $fecnacM="N.N";
				//}
			}
		$x++;
		$padre1[]=array('papa'=>$papa,'mama'=>$xmama,
						'nombreP'=>$nombreP,
						'prefijoP'=>$prefijoP,
						'pelajeP'=>$pelajeP,
						'fecnacP'=>$fecnacP,
						'nombreM'=>$nombreM,
						'prefijoM'=>$prefijoM,
						'pelajeM'=>$pelajeM,
						'fecnacM'=>$fecnacM
					   );
	}



	//para yeguas
	$x=1;

 	for($i=0;$i<4;$i++)
	{
		/*$sql3=" SELECT codpad, codmad FROM(
				SELECT idPadre codpad,idMadre codmad from sge_ejemplar  where id='$xid'
				UNION ALL
				SELECT idPadre codpad,idMadre codmad from sge_ejemplar_peru ep where id='".str_replace(".", "-", $xid)."'
			    ) q LIMIT 1
		";*/
		$sql3=" SELECT codpad,codmad,nombrePad,prefijoPad,pelajePad,fecnacPad,nombreMad,prefijoMad,pelajeMad,fecnacMad FROM
		 (
		 SELECT hijo.idPadre codpad,hijo.idMadre codmad,
		 
		ifnull(padre.nombre,ppp.nombre) nombrePad,
		ifnull(padre.prefijo,ppp.prefijo) prefijoPad,
		ifnull(pp.nombre,ppp.pelaje) pelajePad,
		ifnull(DATE_FORMAT(ifnull(padre.fecNace,ppp.fecNace),'%d/%m/%Y'),'-')as fecnacPad, 

		ifnull(madre.nombre,ppm.nombre) nombreMad,
		ifnull(madre.prefijo,ppm.prefijo) prefijoMad,
		ifnull(pm.nombre,ppm.pelaje) pelajeMad,
		ifnull(DATE_FORMAT(ifnull(madre.fecNace,ppm.fecNace),'%d/%m/%Y'),'-')as fecnacMad

		 FROM sge_ejemplar hijo 
		 LEFT JOIN  sge_ejemplar padre on(hijo.idPadre=padre.id)
		 LEFT JOIN  sge_ejemplar madre on(hijo.idMadre=madre.id)

		 LEFT JOIN sge_ejemplar_peru ppp on(REPLACE(hijo.idPadre,'.','-')=ppp.id) 
		 LEFT JOIN sge_ejemplar_peru ppm on(REPLACE(hijo.idMadre,'.','-')=ppm.id) 

		 LEFT JOIN  sge_pelaje pp on(pp.id=padre.idPelaje)
		 LEFT JOIN  sge_pelaje pm on(pm.id=madre.idPelaje)
		 WHERE hijo.id='$xid'
		 UNION  ALL
		 SELECT  hijo.idPadre codpad,hijo.idMadre codmad,
		padre.nombre nombrePad,padre.prefijo prefijoPad, padre.pelaje pelajePad,ifnull(DATE_FORMAT(padre.fecNace,'%d/%m/%Y'),'-')as fecnacPad,
		madre.nombre nombreMad,madre.prefijo prefijoMad, madre.pelaje pelajeMad,ifnull(DATE_FORMAT(madre.fecNace,'%d/%m/%Y'),'-')as fecnacMad
		 FROM sge_ejemplar_peru hijo  
		 LEFT JOIN  sge_ejemplar_peru padre on(hijo.idPadre=padre.id)
		 LEFT JOIN  sge_ejemplar_peru madre on(hijo.idMadre=madre.id)
		 WHERE hijo.id='".str_replace(".", "-", $xid)."'
		 ) q limit 1
 ";
// echo "<br>".$sql3;
		$rs3=mysqli_query($link,$sql3)or die("Error en cadena de madres 2 ".mysqli_error($link));
		$n3=mysqli_num_rows($rs3);	

		 if($n3>0)
		  { 	

			$mama=mysqli_result($rs3,0,'codmad');				
			$xpapa=mysqli_result($rs3,0,'codpad');	

			 $nombreP=mysqli_result($rs3,0,'nombrePad');				
   			 $prefijoP=mysqli_result($rs3,0,'prefijoPad');
   			 $pelajeP=mysqli_result($rs3,0,'pelajePad');
   			 $fecnacP=mysqli_result($rs3,0,'fecnacPad');					

   			 $nombreM=mysqli_result($rs3,0,'nombreMad');				
   			 $prefijoM=mysqli_result($rs3,0,'prefijoMad');
   			 $pelajeM=mysqli_result($rs3,0,'pelajeMad');
   			 $fecnacM=mysqli_result($rs3,0,'fecnacMad');	

			$xid=$mama;
			
		  }else{
		  	 
					$xid=0;
					$mama="-";				
					$xpapa="-";	

					 $nombreP="N.N";			
		   			 $prefijoP=" ";
		   			 $pelajeP="N.N";
		   			 $fecnacP="N.N";

		   			 $nombreM="N.N";
		   			 $prefijoM=" ";
		   			 $pelajeM="N.N";
		   			 $fecnacM="N.N";
			 
		  }
		$x++;
		$madre1[]=array('mama'=>$mama,'papa'=>$xpapa,
						'nombreP'=>$nombreP,
						'prefijoP'=>$prefijoP,
						'pelajeP'=>$pelajeP,
						'fecnacP'=>$fecnacP,
						'nombreM'=>$nombreM,
						'prefijoM'=>$prefijoM,
						'pelajeM'=>$pelajeM,
						'fecnacM'=>$fecnacM
						);
	}


	


	
mostrararbol($codigo,$madre1,$padre1,$link);


}//fin de funcion

/*
addon  obtiene nombre de ejemplar
*/
function name($id,$link)
{
//$sql3="select nombre,prefij,pelaje,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac  from ".TABLE_DATO." where codigo='$id'";
 $sql3=" SELECT * FROM (
		SELECT ep.nombre,prefijo prefij,p.nombre pelaje,ifnull(DATE_FORMAT(fecnace,'%d/%m/%Y'),'-')as fecnac  FROM sge_ejemplar ep
		LEFT JOIN sge_pelaje p on(p.id=ep.idPelaje) WHERE ep.id='$id'
		UNION ALL
		SELECT nombre,prefijo prefij,pelaje,ifnull(DATE_FORMAT(fecnace,'%d/%m/%Y'),'-')as fecnac  
		FROM sge_ejemplar_peru ep WHERE id='".str_replace(".", "-", $id)."'
		 ) Q LIMIT 1
";

//mysql_query('SET NAMES utf8');
//	mysql_query('SET CHARACTER_SET utf8');
$rs3=mysqli_query($link,$sql3)or die("Error en cadena de consulta 2 ".mysqli_error($link));
$n3=mysqli_num_rows($rs3);	
 if($n3>0)
  { 	
  	while($row = mysqli_fetch_assoc($rs3)){
   			$nombre=$row['nombre'];				
   			$prefijo=$row['prefij'];
   			$pelaje=$row['pelaje'];
   			$fecnac=$row['fecnac'];
   }	
  }
else
 {

				   $nombre="N.N";				
				   $prefijo="N.N";
				   $pelaje="N.N";
				   $fecnac="N.N";
			
 }

     $desc[0]=array('nombre'=>$nombre,'prefijo'=>$prefijo,'pelaje'=>$pelaje,'fecnac'=>$fecnac);

         return $desc;



}


function mostrararbol($hijo,$xm,$xp,$link)
{

?>
<style type="text/css">

.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}
.link2{    color: #5983EC!important;}
.link2:hover { color: #0F3CAD !important; } /* CSS link hover (green) */

</style>
 
<table width="100%"  border="0" cellspacing="0" cellpadding="0"   >
  <tr>
    <td>
<table width="100%" border=1 cellpadding="0" cellspacing="0" bgcolor=white
 style="font-weight:bold;font-size:10px; border-collapse:collapse;   ">
  <tr>
  	 
    <td rowspan="16">
<center>
  
<img src="img/dot_yellow.png">
<?	
 /////////////////obtener nombre nivel 1////////////////////////////
	$des0=name($hijo,$link);
	echo"<span class='nameCab'>&nbsp;".$des0[0][prefijo]."&nbsp;".$des0[0][nombre];
	echo "<br><label name='arbol'>".$hijo."</label>";
	echo "<br><label name='arbol' alt='Pelaje' title='Pelaje'>".$des0[0][pelaje]."</label>";
	echo "<br><label name='arbol' alt='Fecha Nacimiento' title='Fecha Nacimiento'>".$des0[0][fecnac]."</label>";
	/////////////////////////////////////////////////////////////
?>
</center>
<br>	
<center>    
</center></td>
    <td rowspan="8" align=center>
	<center>
	</center>
	<div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
        <?
        /////////////////obtener nombre nivel  papa..////////////////////////////
	$des15=$xp;//name($xp[0][papa],$link);
	//print_r($des15[0]);
	echo"<span class='nameCab'>&nbsp;".$des15[0][prefijoP]."&nbsp; ".$des15[0][nombreP];

	
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$xp[0][papa]."'); title='ver &aacute;rbol..' >".$xp[0][papa]."</label>";
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Pelaje' title='Pelaje'>".$des15[0][pelajeP]."</label>";
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Fecha Nacimiento' title='Fecha Nacimiento'>".$des15[0][fecnacP]."</label>";
	 //echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='arbolgen.php?id=".$xp[0][papa]."' title='ver &aacute;rbol..'  >".$xp[0][papa]."</a>";
	 //href='arbolgen.php?id=".$xp[0][papa]."'
	/////////////////obtener nombre////////////////////////////
	
	/////////////////////////////////////////////////////////////
	?>
        <br>	
    </div>
	<center>    
</center></td>
    <td rowspan="4" align="center">
		<center>
		</center>
        <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
            <? 
	 	 
	/////////////////obtener nombre  abuelo 1////////////////////////////
	$des16=$xp;// name($xp[1][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des16[1][prefijoP]."&nbsp;".$des16[1][nombreP];
	
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$xp[1][papa]."'); title='ver &aacute;rbol..'  >".$xp[1][papa]."</label>";
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Pelaje' title='Pelaje'>".$des16[1][pelajeP]."</label>";
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Fecha Nacimiento' title='Fecha Nacimiento'>".$des16[1][fecnacP]."</label>";
	//echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='arbolgen.php?id=".$xp[1][papa]."' title='ver &aacute;rbol..'  >".$xp[1][papa]."</a>";
//echo("(".$des16[0][prefijo].")");
	/////////////////////////////////////////////////////////////
	?>
            <br>	
        </div>
        <center>    
</center>

</td>
    <td rowspan="2" align="center">      <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
          <?
	
	/////////////////obtener nombre abuelo 2////////4-1/////////////////
	$des17=$xp;//name($xp[2][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des17[2][prefijoP]."&nbsp;".$des17[2][nombreP];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$xp[2][papa]."'); title='ver &aacute;rbol..'  >".$xp[2][papa]."</label>";
 	echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Pelaje' title='Pelaje'>".$des17[2][pelajeP]."</label>";
	 echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Fecha Nacimiento' title='Fecha Nacimiento'>".$des17[2][fecnacP]."</label>";
	?>
      </div></td>
   <!-- <td>&nbsp;&nbsp; <img src="img/dot_yellow.png">-->
 <? 
 
	/////////////////obtener nombre abuel3 5ta //////5-1///////////////////
	/*$des18=$xp; //name($xp[3][papa],$link);
	echo"<span class='nameCab'>&nbsp;pppppppp".$des18[3][prefijoP]."&nbsp; ".$des18[3][nombreP];
		echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$xp[3][papa]."'); title='ver &aacute;rbol..'  >".$xp[3][papa]."</label>";
*/
	/////////////////////////////////////////////////////////////
	?>
  <!--</td>-->
  </tr>
  <tr>
     <!-- <td>&nbsp;&nbsp; <img src="img/dot_yellow.png">-->
    <?
	/////////////////obtener nombre////////5-2/////////////////
	/*
	$des19=$xp;//name($xp[3][mama],$link);
	echo"<span class='nameCab'>&nbsp;".$des19[3][prefijoM]."&nbsp;".$des19[3][nombreM];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$xp[3][mama]."'); title='ver &aacute;rbol..'  >".$xp[3][mama]."</label>";
	*/
	/////////////////////////////////////////////////////////////
	?>
	<!--</td>-->
  </tr>
  <tr>
    <td rowspan="2" align="right">
	  <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
          <?	
          		/* 4-2 */
          		//$dato=findMP($xp[2][mama],$link);
				$des21=$xp;//name($xp[2][mama],$link);
	echo"<span class='nameCab'>&nbsp;".$des21[2][prefijoM]."&nbsp;".$des21[2][nombreM];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$xp[2][mama]."'); title='ver &aacute;rbol..'  >".$xp[2][mama]."</label>";

	echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Pelaje' title='Pelaje'>".$des21[2][pelajeM]."</label>";
	 echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Fecha Nacimiento' title='Fecha Nacimiento'>".$des21[2][fecnacM]."</label>";
	 ?>
      </div></td>
    <!--<td><div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">    -->    
      <?
    //////////////5-3///////////////
      
	/*$des22=name($dato[0][papa],$link);
	echo"<span class='nameCab'>xxxxxxxxx&nbsp;".$des22[0][prefijo]."&nbsp; ".$des22[0][nombre];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$dato[0][papa]."'); title='ver &aacute;rbol..'  >".$dato[0][papa]."</label>";
	*/
	 ?> 
    <!--</div></td>-->
  </tr>
  <tr>
   <!--<td><div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">    -->    
	 <? /*
	 /////////////5-4////////////
     $des23=name($dato[0][mama],$link);
	 echo"<span class='nameCab'>&nbsp;qqqqqqqqqqqqqq".$des23[0][prefijo]."&nbsp;".$des23[0][nombre];
	 echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$dato[0][mama]."'); title='ver &aacute;rbol..'  >".$dato[0][mama]."</label>";
	 */
	 ?> 
	 <!--</div></td>-->
  </tr>
  <tr>
    <td rowspan="4">
	<div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">	
	    <? 
	 	
		$datox=findMP($xp[1][mama],$link);
		$des20=$xp;//name($xp[1][mama],$link);
	 echo"<span class='nameCab'>&nbsp;".$des20[1][prefijoM]."&nbsp;".$des20[1][nombreM];
	 echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$xp[1][mama]."'); title='ver &aacute;rbol..'  >".$xp[1][mama]."</label>";
	 echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Pelaje' title='Pelaje'>".$des20[1][pelajeM]."</label>";
	 echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Fecha Nacimiento' title='Fecha Nacimiento'>".$des20[1][fecnacM]."</label>";
	
	?>
	  </div>
	<center>
	</center>	</td>
    <td rowspan="2" align="center">
      <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
	   
	    <?
	    /* 4-3 */
		$des30=name($datox[0][papa],$link);
	    echo"<span class='nameCab'>&nbsp;".$des30[0][prefijo]."&nbsp; ".$des30[0][nombre];
 
	//$datoy=findMP($datox[0][papa],$link);
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$datox[0][papa]."'); title='ver &aacute;rbol..'  >".$datox[0][papa]."</label>";

	echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Pelaje' title='Pelaje'>".$des30[0][pelaje]."</label>";
	 echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Fecha Nacimiento' title='Fecha Nacimiento'>".$des30[0][fecnac]."</label>";
	
	?>   
        </div></td>
   <!-- <td><div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">  --><?
    //////////////5-5////////////////
	
/*
	$des24=name($datoy[0][papa],$link);
	echo"<span class='nameCab'>yyyyyy&nbsp;".$des24[0][prefijo]."&nbsp;".$des24[0][nombre];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$datoy[0][papa]."'); title='ver &aacute;rbol..'  >".$datoy[0][papa]."</label>";
    */
    ?>
   <!--</div></td>-->
  </tr>
  <tr>
   <!-- <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png"> -->
   	<?

/* 
    //////////5-6///////////
	$des25=name($datoy[0][mama],$link);
	echo"<span class='nameCab'>&nbsp;ooooooo".$des25[0][prefijo]."&nbsp;".$des25[0][nombre];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$datoy[0][mama]."'); title='ver &aacute;rbol..'  >".$datoy[0][mama]."</label>";
	 */
	 ?>
	 <!--</td>-->
  </tr>
  <tr>
    <td rowspan="2" align="center">
      <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
   	      <?
   	      ///////4-4///////////////////
	   
		$des31=name($datox[0][mama],$link);
		echo"<span class='nameCab'>&nbsp;".$des31[0][prefijo]."&nbsp;".$des31[0][nombre];
		echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$datox[0][mama]."'); title='ver &aacute;rbol..'  >".$datox[0][mama]."</label>";		
    	 echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Pelaje' title='Pelaje'>".$des31[0][pelaje]."</label>";
echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Fecha Nacimiento' title='Fecha Nacimiento'>".$des31[0][fecnac]."</label>";	
	
	?>
      </div></td>
    <!--<td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">--> <? 
/*
	///////5-7///////////////////
    $datoz=findMP($datox[0][mama],$link);
	$des26=name($datoz[0][papa],$link);
	echo"<span class='nameCab'>&nbsp;zzzzzzzzzzzzzzz".($des26[0][prefijo])."&nbsp;".$des26[0][nombre];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$datoz[0][papa]."'); title='ver &aacute;rbol..'  >".$datoz[0][papa]."</label>";		
     */   	
	?>
	<!--</td>-->
  </tr>
  <tr>
    <!--<td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">  -->
    	<?
    ///////5-8///////////////////
	/*$des27=name($datoz[0][mama],$link);
	echo "<span class='nameCab'>sssssss&nbsp;".$des27[0][prefijo]."&nbsp;";
	echo" ".$des27[0][nombre];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$datoz[0][mama]."'); title='ver &aacute;rbol..'  >".$datoz[0][mama]."</label>";		
     */   	
   ?>
   <!--  </td>-->
  </tr>
  <tr>
    <td rowspan="8" align=center>
	<center>
	</center>
	<div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
	    <?

$des=$xm;//name($xm[0][mama],$link);
echo"<span class='nameCab'>&nbsp;".$des[0][prefijoM]."&nbsp; ".$des[0][nombreM];
echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$xm[0][mama]."'); title='ver &aacute;rbol..'  >".$xm[0][mama]."</label>";	
echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Pelaje' title='Pelaje'>".$des[0][pelajeM]."</label>";
echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Fecha Nacimiento' title='Fecha Nacimiento'>".$des[0][fecnacM]."</label>";	
//echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='arbolgen.php?id=".$xm[0][mama]."' title='ver &aacute;rbol..'  >".$xm[0][mama]."</a>";

//echo("(".$des[0][prefijo].")");



?>	
	  </div>
	<center>
	</center></td>
    <td rowspan="4">
	<center>
	</center>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">	    <? 
	/////////////////obtener nombre////////////////////////////
	$des1=$xm;//name($xm[1][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des1[1][prefijoP]."&nbsp; ".$des1[1][nombreP];
	//echo("(".$des1[0][prefijo].")");
	///////////////////////////////////3-3///////////////////
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$xm[1][papa]."'); title='ver &aacute;rbol..'  >".$xm[1][papa]."</label>";
	echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Pelaje' title='Pelaje'>".$des1[1][pelajeP]."</label>";
echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Fecha Nacimiento' title='Fecha Nacimiento'>".$des1[1][fecnacP]."</label>";		
	//echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='arbolgen.php?id=".$xm[1][papa]."' title='ver &aacute;rbol..'  >".$xm[1][papa]."</a>";
?>
	  <center>
	</center></td>
    <td rowspan="2" align="right">
      <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
	        <?
	$dato=findMP($xm[1][papa],$link);
	/////////////////obtener nombre///////////4-5//////////////
	$des2=name($dato[0][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des2[0][prefijo]."&nbsp;".$des2[0][nombre];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$dato[0][papa]."'); title='ver &aacute;rbol..'  >".$dato[0][papa]."</label>";		
   echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Pelaje' title='Pelaje'>".$des2[0][pelaje]."</label>";
   echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Fecha Nacimiento' title='Fecha Nacimiento'>".$des2[0][fecnac]."</label>";		
	?>
            </center>    
          </div></td>

   <!-- <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">-->
      <?
      /////////////////obtener nombre//////5-9///////////////////	
	/*$dato2=findMP($dato[0][papa],$link);
	$des3=name($dato2[0][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des3[0][prefijo]."&nbsp; ".$des3[0][nombre];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$dato2[0][papa]."'); title='ver &aacute;rbol..'  >".$dato2[0][papa]."</label>";		
*/
	/////////////////////////////////////////////////////////////
	?>   
	<!--   </td>-->
  </tr>
  <tr>
    <!--<td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">-->
      <?

	/////////////////obtener nombre////5-10//////////////////
/*	$des4=name($dato2[0][mama],$link);
	echo"<span class='nameCab'>&nbsp;++++++".$des4[0][prefijo]."&nbsp; ".$des4[0][nombre];

	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$dato2[0][mama]."'); title='ver &aacute;rbol..'  >".$dato2[0][mama]."</label>";		
*/
	/////////////////////////////////////////////////////////////
	?>    <!--  </td>-->
  </tr>
  <tr>
    <td rowspan="2" align="right">   <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
	      <? 

	
	/////////////////obtener nombre////////////4-6////////////
	$des5=name($dato[0][mama],$link);
	echo"<span class='nameCab'>&nbsp;".$des5[0][prefijo]."&nbsp;".$des5[0][nombre];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$dato[0][mama]."'); title='ver &aacute;rbol..'  >".$dato[0][mama]."</label>";		
 	   echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Pelaje' title='Pelaje'>".$des5[0][pelaje]."</label>";
   echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Fecha Nacimiento' title='Fecha Nacimiento'>".$des5[0][fecnac]."</label>";	

	/////////////////////////////////////////////////////////////
	?>
    </div></td>
    <!--<td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">-->
      <?
	
	/////////////////obtener nombre///////////5-11///////////////
    /*$dato3=findMP($dato[0][mama],$link);
	$des6=name($dato3[0][papa],$link);
	echo"<span class='nameCab'>-----------------&nbsp;".$des6[0][prefijo]."&nbsp; ".$des6[0][nombre];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$dato3[0][papa]."'); title='ver &aacute;rbol..'  >".$dato3[0][papa]."</label>";		
	*/
	/////////////////////////////////////////////////////////////
	?>    <!--  </td>-->
  </tr>
  <tr>
   <!-- <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">-->
      <?

	/////////////////obtener nombre//////5-12/////////////////
      /*
	$des7=name($dato3[0][mama],$link);
	echo"<span class='nameCab'>&nbsp;************".$des7[0][prefijo]."&nbsp; ".$des7[0][nombre];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$dato3[0][mama]."'); title='ver &aacute;rbol..'  >".$dato3[0][mama]."</label>";		
	*/
	/////////////////////////////////////////////////////////////
	?>   <!--   </td>-->
  </tr>
  <tr>
    <td rowspan="4" align="center"><center>
    </center>      <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">        <?
	 
	/////////////////obtener nombre////////////////////////////
	$des8=$xm;//name($xm[1][mama],$link);
	echo"<span class='nameCab'>&nbsp;".$des8[1][prefijoM]."&nbsp;".$des8[1][nombreM];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$xm[1][mama]."'); title='ver &aacute;rbol..'  >".$xm[1][mama]."</label>";	
	echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Pelaje' title='Pelaje'>".$des8[1][pelajeM]."</label>";
echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Fecha Nacimiento' title='Fecha Nacimiento'>".$des8[1][fecnacM]."</label>";	
	 
	/////////////////////////////////////////////////////////////
	?>
      </div>
    <center>  
   </center> </td>
    <td rowspan="2" align="right">
      <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
	  
	    <? 	// $dato=findMP($xm[2][papa],$link);
	/////////////////obtener nombre//////////4-7//////////////
	$des9=$xm; //name($xm[2][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des9[2][prefijoP]."&nbsp;".$des9[2][nombreP];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$xm[2][papa]."'); title='ver &aacute;rbol..'  >".$xm[2][papa]."</label>";		
	  echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Pelaje' title='Pelaje'>".$des9[0][pelajeP]."</label>";
   echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Fecha Nacimiento' title='Fecha Nacimiento'>".$des9[0][fecnacP]."</label>";	
	/////////////////////////////////////////////////////////////
	?>
      </div></td>
   <!-- <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">-->
      <?
	/////////////////obtener nombre///////////5-13//////////////
    /*$dato=findMP($xm[2][papa],$link);
	$des10=name($dato[0][papa],$link);
	echo"<span class='nameCab'>&nbsp; ".$des10[0][prefijo]."&nbsp;".$des10[0][nombre];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$dato[0][papa]."'); title='ver &aacute;rbol..'  >".$dato[0][papa]."</label>";		
     */
	/////////////////////////////////////////////////////////////
	?>   <!--   </td>-->
  </tr>
  <tr>
  <!--  <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">-->
      <?
		/////////////////obtener nombre/////////////5-14///////////
	/*
	$des11=name($dato[0][mama],$link);
	echo"<span class='nameCab'> &nbsp;".$des11[0][prefijo]."&nbsp; ".$des11[0][nombre];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$dato[0][mama]."'); title='ver &aacute;rbol..'  >".$dato[0][mama]."</label>";		
 	*/
	/////////////////////////////////////////////////////////////
	?>      </td>
  </tr>
  <tr>
    <td rowspan="2" align="right"><div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
	      <? 

	/////////////////obtener nombre//////////4-8///////////////
	$des12=$xm;//name($xm[2][mama],$link);
	echo"<span class='nameCab'>&nbsp;".$des12[2][prefijoM]."&nbsp; ".$des12[2][nombreM];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$xm[2][mama]."'); title='ver &aacute;rbol..'  >".$xm[2][mama]."</label>";		
  echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Pelaje' title='Pelaje'>".$des12[0][pelajeM]."</label>";
   echo"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label name='arbol' alt='Fecha Nacimiento' title='Fecha Nacimiento'>".$des12[0][fecnacM]."</label>";
	?>
    </div></td>
   <!-- <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png"> -->
   	<? 

	/////////////////obtener nombre///////////5-15///////////
    /*
	$des13=$xm;//name($xm[3][papa],$link);
	echo"<span class='nameCab'>&nbsp;yyyyyy".$des13[3][prefijoP]."&nbsp;".$des13[3][nombreP];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$xm[3][papa]."'); title='ver &aacute;rbol..'  >".$xm[3][papa]."</label>";		
   */
	/////////////////////////////////////////////////////////////
	?>      
	<!--</td>-->
  </tr>
  <tr>
  <!--  <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">-->
   <?

	/////////////////obtener nombre///////////5-16//////////////
	/*
	$des14=$xm;//name($xm[3][mama],$link);
	echo"<span class='nameCab'>&nbsp;rrrrrr".$des14[3][prefijoM]."&nbsp; ".$des14[3][nombreM];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='cursor link2' onclick=viewArbol('".$xm[3][mama]."'); title='ver &aacute;rbol..'  >".$xm[3][mama]."</label>";		
   */
	/////////////////////////////////////////////////////////////?>     
  <!-- </td>-->
  </tr>
</table>
</td>
  </tr>
</table>

<?
}

function findMP($id,$link)
{
$sql3="select codmad,codpad from ".TABLE_DATO." where codigo='$id'";
$rs3=mysqli_query($link,$sql3)or die("Error en cadena de consulta 2 ".mysqli_error($link));
$n3=mysqli_num_rows($rs3);	
 if($n3>0)
  { 	
   $mama=mysqli_result($rs3,0,'codmad');				
   $papa=mysqli_result($rs3,0,'codpad');	
  }
else
 {
		 	    $sql3="SELECT idPadre codpad,idMadre codmad from sge_ejemplar_peru ep where id='".str_replace(".", "-", $id)."'";
				$rs3=mysqli_query($link,$sql3)or die("Error en cadena de consulta 2 ".mysqli_error($link));
				$n3=mysqli_num_rows($rs3);	
				 if($n3>0)
				  { 	
				   $mama=mysqli_result($rs3,0,'codmad');				
				   $papa=mysqli_result($rs3,0,'codpad');	
				  }
				else
				 {
				   $mama="N-N";
				   $papa="N-N";
				}
 }

     $desc[0]=array('mama'=>$mama,'papa'=>$papa);

         return $desc;



}




function buscarejemplaresCrias($cod,$link,$opc=0,$tipo)				
{
	$cod=str_replace("-", "", $cod);
	$cod=str_replace(".", "", $cod);
	$cod=str_replace(" ", "", $cod);

if($tipo==5){
				if($opc=="0")
						$sqlCrias="SELECT codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
						codpad,prefpa,nompad,
						codmad,prefma,nommad,
						d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec from ".TABLE_DATO."  d
						where  replace(replace(codpad,'.',''),'-','')='$cod' order by fecnac ASC ";
				if($opc=="1")
						$sqlCrias="SELECT codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
						codpad,prefpa,nompad,
						codmad,prefma,nommad,
						d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec,d.microchip,fecnac as orden
						 from ".TABLE_DATO." d 
						where  replace(replace(codpad,'.',''),'-','')='$cod' and fallec='0'   order by orden desc ";
				if($opc=="2")
						$sqlCrias="SELECT codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
						codpad,prefpa,nompad,
						codmad,prefma,nommad,
						d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec,d.microchip,fecnac as orden 
						from ".TABLE_DATO." d 
						where  replace(replace(codpad,'.',''),'-','')='$cod' and fallec='1'  order by orden desc ";
 }elseif($tipo==6){
 				if($opc=="0")
						$sqlCrias="SELECT codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
						codpad,prefpa,nompad,
						codmad,prefma,nommad,
						d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec from ".TABLE_DATO."  d
							where   replace(replace(codmad,'.',''),'-','')='$cod' order by fecnac ASC ";
				if($opc=="1")
						$sqlCrias="SELECT codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
						codpad,prefpa,nompad,
						codmad,prefma,nommad,
						d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec,d.microchip,fecnac as orden
						 from ".TABLE_DATO." d 
						where  replace(replace(codmad,'.',''),'-','')='$cod' and fallec='0'   order by orden desc";
				if($opc=="2")
						$sqlCrias="SELECT codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
						codpad,prefpa,nompad,
						codmad,prefma,nommad,
						d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec,d.microchip,fecnac as orden 
						from ".TABLE_DATO." d 
						where  replace(replace(codmad,'.',''),'-','')='$cod' and fallec='1'  order by orden desc";
 }
// echo $sqlCrias;

$rsCrias=mysqli_query($link,$sqlCrias)or die("Error en cadena de consulta 3 crias - $opc ".mysqli_error($link));
$n4=mysqli_num_rows($rsCrias);	


 if($n4>0)
  { 	
$f=1;
     while($rows=mysqli_fetch_array($rsCrias))
	{	
		if($rows[1]=="")
		{$pref="";}
		else
		{$pref=$rows[1];}
		include("status.php");
		$arrayrs[]=array('n'=>$f,
				 'codigo'=>$rows[0],	
				 'prefijo_caballo'=>$pref,
				 'nombre_caballo'=>($rows[2]),
				 'pelaje'=>$rows[10],
				 'nacimiento_caballo'=>$rows[3],
				 'prefijo_madre_caballo'=>$rows[8],
				 'prefijo_padre_caballo'=>$rows[5],
				 'padre_caballo'=>($rows[6]),
				 'madre_caballo'=>($rows[9]),
				 'criador_caballo'=>($rows[14]),
				 'propietario_caballo'=>($rows[16]),
				 'microchip_caballo'=>$rows[18],
				 'fallecio'=>$status);

					
				
				
		$f++;
	}
   }
  else
  {
	$arrayrs=-1;	
  }	
 return $arrayrs;

}

function buscarejemplarescriador($cod,$link,$opc=0)				
{

if($opc=="0")
$sql4="SELECT   codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
codpad,prefpa,nompad,
-- if(prefpa is null,epp.prefijo,d.prefpa) prefpa,if(d.nompad is null,epp.nombre,d.nompad)nompad,
codmad,prefma,nommad,
-- if(prefma is null,epm.prefijo,d.prefma) prefma,if(d.nommad is null,epm.nombre,d.nommad)nommad,
d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec from ".TABLE_DATO."  d
-- left join sge_ejemplar_peru epp on (epp.id=replace(d.codpad,'.','-')) 
-- left join sge_ejemplar_peru epm on (epm.id=replace(d.codmad,'.','-')) 
	where cod_criador='$cod' order by fecnac ASC ";
if($opc=="1") # vivos
$sql4="SELECT  codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
codpad,prefpa,nompad,
-- if(prefpa is null,epp.prefijo,d.prefpa) prefpa,if(d.nompad is null,epp.nombre,d.nompad)nompad,
codmad,prefma,nommad,
-- if(prefma is null,epm.prefijo,d.prefma) prefma,if(d.nommad is null,epm.nombre,d.nommad)nommad,
d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec,d.microchip,fecnac as orden
 from ".TABLE_DATO." d 
 -- left join sge_ejemplar_peru epp on (epp.id=replace(d.codpad,'.','-')) 
 -- left join sge_ejemplar_peru epm on (epm.id=replace(d.codmad,'.','-')) 
	where cod_criador='$cod' and fallec='0' and transfer_opc='0' order by orden desc";
if($opc=="2") # fallecidos
$sql4=" SELECT codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
codpad,prefpa,nompad,
-- if(prefpa is null,epp.prefijo,d.prefpa) prefpa,if(d.nompad is null,epp.nombre,d.nompad)nompad,
codmad,prefma,nommad,
-- if(prefma is null,epm.prefijo,d.prefma) prefma,if(d.nommad is null,epm.nombre,d.nommad)nommad,
d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec,d.microchip,fecnac as orden 
from ".TABLE_DATO." d 
-- left join sge_ejemplar_peru epp on (epp.id=replace(d.codpad,'.','-')) 
-- left join sge_ejemplar_peru epm on (epm.id=replace(d.codmad,'.','-')) 
where cod_criador='$cod' and fallec='1'  order by orden desc";
if($opc=="3")  #TRANSFERIDOS - OBSOLETO
$sql4="SELECT  codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
codpad,prefpa,nompad,
-- if(prefpa is null,epp.prefijo,d.prefpa) prefpa,if(d.nompad is null,epp.nombre,d.nompad)nompad,
codmad,prefma,nommad,
-- if(prefma is null,epm.prefijo,d.prefma) prefma,if(d.nommad is null,epm.nombre,d.nommad)nommad,
d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec,d.microchip,fecnac as orden 
from ".TABLE_DATO." d
-- left join sge_ejemplar_peru epp on (epp.id=replace(d.codpad,'.','-')) 
-- left join sge_ejemplar_peru epm on (epm.id=replace(d.codmad,'.','-')) 
where cod_criador='$cod' and fallec='0' and transfer_opc='1' order by orden desc";

// echo $sql4."<br>";
$rs4=mysqli_query($link,$sql4)or die("Error en cadena de consulta 3 criador****** - $opc ".mysqli_error($link));
$n4=mysqli_num_rows($rs4);	
 if($n4>0)
  { 	
$f=1;
     while($rows=mysqli_fetch_array($rs4))
	{	
		if($rows[1]=="")
		{$pref="";}
		else
		{$pref=$rows[1];}
		include("status.php");
		$arrayrs[]=array('n'=>$f,
				 'codigo'=>$rows[0],	
				 'prefijo_caballo'=>$pref,
				 'nombre_caballo'=>($rows[2]),
				 'pelaje'=>$rows[10],
				 'nacimiento_caballo'=>$rows[3],
				 'prefijo_madre_caballo'=>$rows[8],
				 'prefijo_padre_caballo'=>$rows[5],
				 'padre_caballo'=>($rows[6]),
				 'madre_caballo'=>($rows[9]),
				 'criador_caballo'=>($rows[14]),
				 'propietario_caballo'=>($rows[16]),
				 'microchip_caballo'=>$rows[18],
				 'fallecio'=>$status);

					
				
				
		$f++;
	}
   }
  else
  {
	$arrayrs=-1;	
  }	
 return $arrayrs;

}


function buscarejemplarespropietario($cod,$link,$opc=0)				
{
//$poe=obtenerMaxIdPoe($link,$cod);
//print_r($poe);
if($opc=="0")
$sql4="select codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec,microchip,fecnac as orden from ".TABLE_DATO." where cod_propie='$cod' order by orden desc";
/*VIVOS*/
if($opc=="1")
//$sql4="select codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec,microchip,fecnac as orden from ".TABLE_DATO." where cod_propie='$cod' and fallec='0' and transfer_opc='0' and codigo not like 'C%'order by orden desc";

$sql4="SELECT  codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
codpad,prefpa,nompad,
-- if(prefpa is null,epp.prefijo,d.prefpa) prefpa,
-- if(d.nompad is null,epp.nombre,d.nompad)nompad,
codmad,prefma,nommad,
-- if(prefma is null,epm.prefijo,d.prefma) prefma,
-- if(d.nommad is null,epm.nombre,d.nommad)nommad,
d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie, fallec,d.microchip,
fecnac as orden
FROM datos220206 d
-- left join sge_ejemplar_peru epp on (epp.id=replace(d.codpad,'.','-')) 
-- left join sge_ejemplar_peru epm on (epm.id=replace(d.codmad,'.','-')) 
WHERE cod_propie='$cod' and fallec='0'
ORDER BY orden DESC
";

/*FALLECIDOS*/
if($opc=="2")
$sql4="SELECT  codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
codpad,prefpa,nompad,
-- if(prefpa is null,epp.prefijo,d.prefpa) prefpa,if(d.nompad is null,epp.nombre,d.nompad)nompad,
codmad,prefma,nommad,
-- if(prefma is null,epm.prefijo,d.prefma) prefma,if(d.nommad is null,epm.nombre,d.nommad)nommad,
d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie, fallec,d.microchip,
fecnac as orden
FROM datos220206 d
-- left join sge_ejemplar_peru epp on (epp.id=replace(d.codpad,'.','-')) 
-- left join sge_ejemplar_peru epm on (epm.id=replace(d.codmad,'.','-')) 
WHERE cod_propie='$cod' and fallec='1'
ORDER BY orden DESC";
/*
$sql4=" SELECT  codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
codpad,if(prefpa is null,epp.prefijo,d.prefpa) prefpa,if(d.nompad is null,epp.nombre,d.nompad)nompad,
codmad,if(prefma is null,epm.prefijo,d.prefma) prefma,if(d.nommad is null,epm.nombre,d.nommad)nommad,
d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,'1' AS fallec,d.microchip,
fecnac as orden
FROM poe_historial p 
INNER JOIN datos220206 d ON p.codEjemplar  COLLATE utf8_unicode_ci =d.codigo
left join sge_ejemplar_peru epp on (epp.id=replace(d.codpad,'.','-')) 
left join sge_ejemplar_peru epm on (epm.id=replace(d.codmad,'.','-')) 
WHERE p.idProp='$cod' AND p.idPoe='$poe' AND p.tipo='FA' 
ORDER BY orden DESC 
";*/

/*TRANSFERIDOS*/
if($opc=="3")
$sql4="SELECT  codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
codpad,if(prefpa is null,epp.prefijo,d.prefpa) prefpa,if(d.nompad is null,epp.nombre,d.nompad)nompad,
codmad,if(prefma is null,epm.prefijo,d.prefma) prefma,if(d.nommad is null,epm.nombre,d.nommad)nommad,
d.pelaje,descri,lugnac,cod_criador,criador,d.cod_propie,propie,'0' AS fallec,d.microchip,
fecnac as orden
FROM poe_movimiento p 
INNER JOIN usuario u ON(p.idUser=u.id) 
INNER JOIN datos220206 d ON (p.codEjemplar  COLLATE utf8_unicode_ci =d.codigo)
left join sge_ejemplar_peru epp on (epp.id=replace(d.codpad,'.','-')) 
left join sge_ejemplar_peru epm on (epm.id=replace(d.codmad,'.','-')) 
WHERE u.cod_propie='$cod' AND p.idPoe='$poe' AND p.tipo='T' 
ORDER BY orden DESC ";

/*CAPADOS*/
if($opc=="4")
$sql4=" SELECT * FROM (
SELECT   codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
codpad,if(prefpa is null,epp.prefijo,d.prefpa) prefpa,if(d.nompad is null,epp.nombre,d.nompad)nompad,
codmad,if(prefma is null,epm.prefijo,d.prefma) prefma,if(d.nommad is null,epm.nombre,d.nommad)nommad,
d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,'0' AS fallec,d.microchip,
fecnac as orden
from poe_historial p 
inner join datos220206 d on p.codEjemplar  COLLATE utf8_unicode_ci =d.codigo
left join sge_ejemplar_peru epp on (epp.id=replace(d.codpad,'.','-')) 
left join sge_ejemplar_peru epm on (epm.id=replace(d.codmad,'.','-')) 
where p.idProp='$cod' and p.idPoe='$poe' and p.tipo='CA'   
)Q ORDER BY Q.orden DESC ";

/*POR REGULARIZAR*/
if($opc=="5") 
$sql4 ="SELECT codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
codpad,if(prefpa is null,epp.prefijo,d.prefpa) prefpa,if(d.nompad is null,epp.nombre,d.nompad)nompad,
codmad,if(prefma is null,epm.prefijo,d.prefma) prefma,if(d.nommad is null,epm.nombre,d.nommad)nommad,
d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,'0' AS fallec,d.microchip,
fecnac as orden 
FROM datos220206 d
left join sge_ejemplar_peru epp on (epp.id=replace(d.codpad,'.','-')) 
left join sge_ejemplar_peru epm on (epm.id=replace(d.codmad,'.','-')) 
 WHERE cod_propie='$cod' ORDER BY orden DESC";
/*
$sql4 =" SELECT * FROM(
SELECT codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,
codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,'0' AS fallec,microchip,
fecnac as orden 
FROM datos220206 d WHERE cod_propie='$cod' 
-- AND fallec='0' AND transfer_opc='0' 
AND
codigo NOT IN( SELECT  codEjemplar  COLLATE utf8_unicode_ci FROM poe_propiedad  WHERE idProp='$cod' AND idPoe='$poe' ) AND
codigo NOT IN( SELECT  codEjemplar COLLATE utf8_unicode_ci   FROM poe_historial h WHERE h.idProp='$cod' AND h.idPoe='$poe' and h.tipo in('CA','FA') ) AND
codigo NOT IN( SELECT  codEjemplar  COLLATE utf8_unicode_ci FROM poe_movimiento p 
                        INNER JOIN usuario u ON(p.idUser=u.id) 
                        WHERE u.cod_propie='$cod' AND idPoe='$poe' and tipo='T' ) 
UNION ALL
select codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,
codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,criador,d.cod_propie,propie,'0' AS fallec,microchip,
fecnac as orden 
FROM poe_movimiento p 
INNER JOIN usuario u ON(p.idUser=u.id) 
INNER JOIN datos220206 d ON(p.codEjemplar COLLATE utf8_unicode_ci=d.codigo)
WHERE 
u.cod_propie='$cod' AND p.idPoe='$poe' and p.tipo='A'
AND codEjemplar NOT IN( SELECT  h.codEjemplar   FROM poe_historial h WHERE idProp='$cod' AND h.idPoe='$poe' and h.tipo in('CA','FA') ) 
AND codEjemplar NOT IN( SELECT  mm.codEjemplar   FROM poe_movimiento  mm INNER JOIN usuario u ON(mm.idUser=u.id) 
                        WHERE u.cod_propie='$cod' AND mm.idPoe='$poe' and mm.tipo='T' )   

)Q ORDER BY Q.orden DESC
";*/
  // echo $sql4 ;
$rs4=mysqli_query($link,$sql4)or die("Error en cadena de consulta prop!! 3 - $opc ".mysqli_error($link));
$n4=mysqli_num_rows($rs4);	
 if($n4>0)
  { 	
$f=1;
     while($rows=mysqli_fetch_array($rs4))
	{	
		if($rows[1]=="")
		{$pref="";}
		else
		{$pref=$rows[1];}
		include("status.php");
		$arrayrs[]=array('n'=>$f,
				 'codigo'=>$rows[0],	
				 'prefijo_caballo'=>$pref,
				 'nombre_caballo'=>($rows[2]),
				 'pelaje'=>$rows[10],
				 'nacimiento_caballo'=>$rows[3],
				 'codigo_padre_caballo'=>$rows[4],
				 'prefijo_padre_caballo'=>$rows[5],
				 'padre_caballo'=>($rows[6]),
				 'codigo_madre_caballo'=>$rows[7],
				 'prefijo_madre_caballo'=>$rows[8],
				 'madre_caballo'=>($rows[9]),
				 'pelaje_caballo'=>($rows[10]),
				 'descripcion_caballo'=>($rows[11]),
				 'lugar_nac_caballo'=>$rows[12],	
				 'codigo_criador_caballo'=>$rows[13],
				 'criador_caballo'=>($rows[14]),
				 'codigo_propietario_caballo'=>$rows[15],
				 'propietario_caballo'=>($rows[16]),
				 'microchip_caballo'=>$rows[18],
				 'fallecio'=>$status);
				




		$f++;
	}
   }
  else
  {
	$arrayrs=-1;	
  }	
 return $arrayrs;

}

function buscardescendencia2($id,$link)
{

$xid=$id;
$codigo=$id;
$x=1;
//    echo"descendencia del padre<br>";
        for($i=0;$i<5;$i++)
	{
		$sql2="select codpad,codmad from ".TABLE_DATO." where codigo='$id'";	
		$rs2=mysqli_query($link,$sql2)or die("Error en cadena de consulta 2 ".mysqli_error($link));
		$n2=mysqli_num_rows($rs2);	
		 if($n2>0)
		  { 
			
	  		 $papa=mysqli_result($rs2,0,'codpad');				
			 $xmama=mysqli_result($rs2,0,'codmad');				

			 $id=$papa;

			 
		  }
		$x++;
		$padre1[]=array('papa'=>$papa,'mama'=>$xmama);
	}



	//para yeguas
	$x=1;

 	for($i=0;$i<5;$i++)
	{
		$sql3="select codmad,codpad from ".TABLE_DATO." where codigo='$xid'";
		$rs3=mysqli_query($link,$sql3)or die("Error en cadena de consulta 2 ".mysqli_error($link));
		$n3=mysqli_num_rows($rs3);	

		 if($n3>0)
		  { 	

			$mama=mysqli_result($rs3,0,'codmad');				
			$xpapa=mysqli_result($rs3,0,'codpad');	
			$xid=$mama;
			
		  }
		$x++;
		$madre1[]=array('mama'=>$mama,'papa'=>$xpapa);
	}


	


	
mostrararbol2($codigo,$madre1,$padre1,$link);


}
function mostrararbol2($hijo,$xm,$xp,$link)
{
$datoc=detalleCaballo($hijo,$link);
if($datoc!=-1)
{
$name=$datoc[0][nombre_caballo];
$fec_nac=$datoc[0][nacimiento_caballo];
$dueno=$datoc[0][nombre_propietario_caballo];
$criador=$datoc[0][nombre_criador_caballo];
}
else
{
$result="No se encontró dato de este Id";
}

?>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}
-->
</style>
<!--
<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="font-size:10px">
  <tr>
    <td><span class="style1">C&oacute;digo </span></td>
    <td colspan=3><?=$hijo?></td>
  </tr>
  <tr>
    <td class="style1">Fecha Nacimiento </td>
    <td colspan=3><?=$fec_nac?></td>
  </tr>
  <tr>
    <td class="style1">Propietario</td>
    <td colspan=3><?=$dueno?></td>
  </tr>
  <tr>
    <td height="30" class="style1" valign="top">Criador</td>
    <td valign="top" colspan=3> <?=$criador?></td><td align=right><a href="javascript:self.close();">cerrar ventana &nbsp<img src='img/s_error2.png' border=0></a>
</td>
  </tr>
</table>!-->	
  <center><table width="100%"  border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td>
<table width="100%" border=1 cellpadding="0" cellspacing="0" bgcolor=white style="font-weight:bold;color:black;font-size:10px;">
  <tr>
    <td rowspan="16">
<center>
  
<img src="img/dot_yellow.png">
<?	
 /////////////////obtener nombre////////////////////////////
	$des0=name($hijo,$link);
	echo"<span class='nameCab'>&nbsp;".$des0[0][prefijo]."&nbsp;".$des0[0][nombre];
	echo "</span><br>".$hijo."";
	/////////////////////////////////////////////////////////////
?>
</center>
<br>	
<center>    
</center></td>
    <td rowspan="8" align=center>
	<center>
	</center>
	<div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
        <?
	$des15=name($xp[0][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des15[0][prefijo]."&nbsp; ".$des15[0][nombre];

	 echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$xp[0][papa]."&nbsp;";
	/////////////////obtener nombre////////////////////////////
	
	/////////////////////////////////////////////////////////////
	?>
        <br>	
    </div>
	<center>    
</center></td>
    <td rowspan="4" align="center">
		<center>
		</center>
        <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
            <? 
	 	 
	/////////////////obtener nombre////////////////////////////
	$des16=name($xp[1][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des16[0][prefijo]."&nbsp;".$des16[0][nombre];
	echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$xp[1][papa]."&nbsp;";
//echo("(".$des16[0][prefijo].")");
	/////////////////////////////////////////////////////////////
	?>
            <br>	
        </div>
        <center>    
</center>

</td>
    <td rowspan="2" align="center">      <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
          <?
	
	/////////////////obtener nombre////////////////////////////
	$des17=name($xp[2][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des17[0][prefijo]."&nbsp;".$des17[0][nombre];
//echo("(".$des17[0][prefijo].")");
 echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$xp[2][papa]."&nbsp;";
	?>
      </div></td>
    <td>&nbsp;&nbsp;
<img src="img/dot_yellow.png">
<? 
 
	/////////////////obtener nombre////////////////////////////
	$des18=name($xp[3][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des18[0][prefijo]."&nbsp; ".$des18[0][nombre];
	echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$xp[3][papa]."&nbsp;";
//echo("(".$des18[0][prefijo].")");
	/////////////////////////////////////////////////////////////
	?></td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png"> <?
	/////////////////obtener nombre////////////////////////////
	$des19=name($xp[3][mama],$link);
	echo"<span class='nameCab'>&nbsp;".$des19[0][prefijo]."&nbsp;".$des19[0][nombre];
//echo("(".$des19[0][prefijo].")");
	 echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$xp[3][mama]."&nbsp;";
	/////////////////////////////////////////////////////////////
	?></td>
  </tr>
  <tr>
    <td rowspan="2" align="right">
	  <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
          <?	$dato=findMP($xp[2][mama],$link);
				$des21=name($xp[2][mama],$link);
	echo"<span class='nameCab'>&nbsp;".$des21[0][prefijo]."&nbsp;".$des21[0][nombre];
	echo"</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$xp[2][mama]."&nbsp;";
//echo("(".$des21[0][prefijo].")");?>
      </div></td>
    <td><div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">          <?
      
	$des22=name($dato[0][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des22[0][prefijo]."&nbsp; ".$des22[0][nombre];
	 echo"</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dato[0][papa]."&nbsp;";

//    echo("(".$des22[0][prefijo]).")";?> 
        </div></td>
  </tr>
  <tr>
    <td >&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png"> <?
	 
     $des23=name($dato[0][mama],$link);
	 echo"<span class='nameCab'>&nbsp;".$des23[0][prefijo]."&nbsp;".$des23[0][nombre];
	 echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dato[0][mama]."&nbsp;";
   // echo("(".$des23[0][prefijo]).")";?> </td>
  </tr>
  <tr>
    <td rowspan="4">
	<center>
	</center>
	<div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">	
	    <? 
	 	
		$datox=findMP($xp[1][mama],$link);
		$des20=name($xp[1][mama],$link);
	 echo"<span class='nameCab'>&nbsp".$des20[0][prefijo]."&nbsp;".$des20[0][nombre];
	 echo"</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$xp[1][mama]."&nbsp;"; 
//echo("(".$des20[0][prefijo].")");
	?>
	  </div>
	<center>
	</center>	</td>
    <td rowspan="2" align="center">
      <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
	   
	    <?
		$des30=name($datox[0][papa],$link);
	    echo"<span class='nameCab'>&nbsp;".$des30[0][prefijo]."&nbsp; ".$des30[0][nombre];
//    echo("(".$des30[0][prefijo].")");
	$datoy=findMP($datox[0][papa],$link);
	 echo"</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$datox[0][papa]."&nbsp;";
	?>   
        </div></td>
    <td><div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">          <?
	

	$des24=name($datoy[0][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des24[0][prefijo]."&nbsp;".$des24[0][nombre];
		 echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$datoy[0][papa]."&nbsp;";      
   // echo("(".$des24[0][prefijo]).")";?>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png"> <?

	$des25=name($datoy[0][mama],$link);
	echo"<span class='nameCab'>&nbsp;".$des25[0][prefijo]."&nbsp;".$des25[0][nombre];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$datoy[0][mama]."&nbsp;";
//    echo("(".$des25[0][prefijo]).")";?></td>
  </tr>
  <tr>
    <td rowspan="2" align="center">
      <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
   	      <?
	   
		$des31=name($datox[0][mama],$link);
		echo"<span class='nameCab'>&nbsp;".$des31[0][prefijo]."&nbsp;".$des31[0][nombre];
    	 echo"</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$datox[0][mama]."&nbsp;"; 
	
	$datoz=findMP($datox[0][mama],$link);?>
      </div></td>
    <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png"> <?

	$des26=name($datoz[0][papa],$link);
	echo"<span class='nameCab'>&nbsp;".($des26[0][prefijo])."&nbsp;".$des26[0][nombre];
    echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$datoz[0][papa]."&nbsp;";      	
	?>
	</td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png"> <?
	$des27=name($datoz[0][mama],$link);
	echo "<span class='nameCab'>&nbsp;".$des27[0][prefijo]."&nbsp;";
	echo" ".$des27[0][nombre];
    echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$datoz[0][mama]."&nbsp;";      	
   ?>
     </td>
  </tr>
  <tr>
    <td rowspan="8" align=center>
	<center>
	</center>
	<div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
	    <?

$des=name($xm[0][mama],$link);
echo"<span class='nameCab'>&nbsp;".$des[0][prefijo]."&nbsp; ".$des[0][nombre];

echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$xm[0][mama]."&nbsp;";

//echo("(".$des[0][prefijo].")");



?>	
	  </div>
	<center>
	</center></td>
    <td rowspan="4">
	<center>
	</center>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">	    <? 
	/////////////////obtener nombre////////////////////////////
	$des1=name($xm[1][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des1[0][prefijo]."&nbsp; ".$des1[0][nombre];
	//echo("(".$des1[0][prefijo].")");
	/////////////////////////////////////////////////////////////
	echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$xm[1][papa]."&nbsp;";
?>
	  <center>
	</center></td>
    <td rowspan="2" align="right">
      <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
	        <?
	$dato=findMP($xm[1][papa],$link);
	/////////////////obtener nombre////////////////////////////
	$des2=name($dato[0][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des2[0][prefijo]."&nbsp;".$des2[0][nombre];
    echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dato[0][papa]."&nbsp;";
	//echo("(".$des2[0][prefijo].")");
	/////////////////////////////////////////////////////////////
	?>
            </center>    
          </div></td>
    <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
      <?	
	$dato2=findMP($dato[0][papa],$link);
	$des3=name($dato2[0][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des3[0][prefijo]."&nbsp; ".$des3[0][nombre];
	echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dato2[0][papa]."&nbsp;";	
//echo("(".$des3[0][prefijo].")");
	/////////////////////////////////////////////////////////////
	?>      </td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
      <?

	/////////////////obtener nombre////////////////////////////
	$des4=name($dato2[0][mama],$link);
	echo"<span class='nameCab'>&nbsp;".$des4[0][prefijo]."&nbsp; ".$des4[0][nombre];
//echo("(".$des4[0][prefijo].")");
	 echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dato2[0][mama]."&nbsp;";
	/////////////////////////////////////////////////////////////
	?>      </td>
  </tr>
  <tr>
    <td rowspan="2" align="right">   <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
	      <? 

	$dato3=findMP($dato[0][mama],$link);
	/////////////////obtener nombre////////////////////////////
	$des5=name($dato[0][mama],$link);
	echo"<span class='nameCab'>&nbsp;".$des5[0][prefijo]."&nbsp;".$des5[0][nombre];
 	 echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dato[0][mama]."&nbsp;";
//echo("(".$des5[0][prefijo].")");
	/////////////////////////////////////////////////////////////
	?>
    </div></td>
    <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
      <?
	
	/////////////////obtener nombre////////////////////////////
	$des6=name($dato3[0][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des6[0][prefijo]."&nbsp; ".$des6[0][nombre];
	 echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dato3[0][papa]."&nbsp;";
//	echo("(".$des6[0][prefijo].")");
	/////////////////////////////////////////////////////////////
	?>      </td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
      <?

	/////////////////obtener nombre////////////////////////////
	$des7=name($dato3[0][mama],$link);
	echo"<span class='nameCab'>&nbsp;".$des7[0][prefijo]."&nbsp; ".$des7[0][nombre];
	 echo"</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dato3[0][mama]."&nbsp;";
//echo("(".$des7[0][prefijo].")");
	/////////////////////////////////////////////////////////////
	?>      </td>
  </tr>
  <tr>
    <td rowspan="4" align="center"><center>
    </center>      <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">        <?
	 
	/////////////////obtener nombre////////////////////////////
	$des8=name($xm[1][mama],$link);
	echo"<span class='nameCab'>&nbsp;".$des8[0][prefijo]."&nbsp;".$des8[0][nombre];
	echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$xm[1][mama]."&nbsp;";
//	echo("(".$des8[0][prefijo].")");
	/////////////////////////////////////////////////////////////
	?>
      </div>
    <center>  
   </center> </td>
    <td rowspan="2" align="right">
      <div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
	  
	    <? 	 $dato=findMP($xm[2][papa],$link);
	/////////////////obtener nombre////////////////////////////
	$des9=name($xm[2][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des9[0][prefijo]."&nbsp;".$des9[0][nombre];
	echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$xm[2][papa]."&nbsp;";
	//echo("(".$des9[0][prefijo].")");
	/////////////////////////////////////////////////////////////
	?>
      </div></td>
    <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
      <? $dato=findMP($xm[2][papa],$link);
	/////////////////obtener nombre////////////////////////////
	$des10=name($dato[0][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des10[0][prefijo]."&nbsp;".$des10[0][nombre];
    echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dato[0][papa]."&nbsp;";
//echo("(".$des10[0][prefijo].")");
	/////////////////////////////////////////////////////////////
	?>      </td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
      <?
		/////////////////obtener nombre////////////////////////////
	$des11=name($dato[0][mama],$link);
	echo"<span class='nameCab'>&nbsp;".$des11[0][prefijo]."&nbsp; ".$des11[0][nombre];
	 echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dato[0][mama]."&nbsp;";
//echo("(".$des11[0][prefijo].")");
	/////////////////////////////////////////////////////////////
	?>      </td>
  </tr>
  <tr>
    <td rowspan="2" align="right"><div align="left">&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
	      <? 

	/////////////////obtener nombre////////////////////////////
	$des12=name($xm[2][mama],$link);
	echo"<span class='nameCab'>&nbsp;".$des12[0][prefijo]."&nbsp; ".$des12[0][nombre];
	echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$xm[2][mama]."&nbsp;";
//	echo("(".$des12[0][prefijo].")");
	?>
    </div></td>
    <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png"> <? 

	/////////////////obtener nombre////////////////////////////
	$des13=name($xm[3][papa],$link);
	echo"<span class='nameCab'>&nbsp;".$des13[0][prefijo]."&nbsp;".$des13[0][nombre];
    echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$xm[3][papa]."&nbsp;";
//	echo("(".$des13[0][prefijo].")");
	/////////////////////////////////////////////////////////////
	?>      </td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;<img src="img/dot_yellow.png">
 <?
 /////////////////obtener nombre////////////////////////////
	$des14=name($xm[3][mama],$link);
	echo"<span class='nameCab'>&nbsp;".$des14[0][prefijo]."&nbsp; ".$des14[0][nombre];
              echo "</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$xm[3][mama]."&nbsp;";
//	echo("(".$des14[0][prefijo].")");
	/////////////////////////////////////////////////////////////?>      </td>
  </tr>
</table>
</td>
  </tr>
</table>

<?
} ?>


<?

function buscarAdmin($data1,$data2,$link,$opc)
{
$data1=strtoupper($data1);
$data2=strtoupper($data2);
switch($opc)
	{
	case 0: $sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE codigo LIKE '%$data2%' AND nombre LIKE '%$data1%'    order by orden desc"; //and transfer_opc='0'
			//$sqlFallecido=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden FROM ".TABLE_DATO." WHERE codigo LIKE '%$data2%' AND nombre LIKE '%$data1%' and fallec='1' order by orden desc";
			///$sqlTransferido=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE codigo LIKE '%$data2%' AND nombre LIKE '%$data1%' and fallec='0' and transfer_opc='1' order by orden desc";
	#case 0: $sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec FROM ".TABLE_DATO." WHERE codigo LIKE '%$data2%' AND nombre LIKE '%$data1%' order by fecnac Desc";
		break;
	case 1: $sql=" SELECT distinct cod_criador,criador FROM ".TABLE_DATO." WHERE cod_criador LIKE '%$data2%' AND criador LIKE '%$data1%' ";
		break;	
	case 2: $sql=" SELECT distinct cod_propie,propie FROM ".TABLE_DATO." WHERE cod_propie LIKE '%$data2%' AND propie LIKE '%$data1%' ";
		break;	
	case 3: $sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden FROM ".TABLE_DATO." WHERE pelaje LIKE '%$data1%'   order by orden desc"; //and transfer_opc='0' 
			//$sqlFallecido=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden FROM ".TABLE_DATO." WHERE pelaje LIKE '%$data1%'  and fallec='1' order by orden desc";
			//$sqlTransferido=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden FROM ".TABLE_DATO." WHERE pelaje LIKE '%$data1%'  and fallec='0' and transfer_opc='1' order by orden desc";
		break;
	case 4: $sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden FROM ".TABLE_DATO." WHERE microchip LIKE '%$data1%'   order by orden desc"; //and transfer_opc='0's
			//$sqlFallecido=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE microchip LIKE '%$data1%'  and fallec='1' order by orden desc";
			//$sqlTransferido=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse ,fecnac as orden FROM ".TABLE_DATO." WHERE microchip LIKE '%$data1%'  and fallec='0' and transfer_opc='1' order by orden desc";
break;

	}
 
 

$rs=mysqli_query($link,$sql)or die("Error en cadena de consulta ".mysqli_error($link));
$n=mysqli_num_rows($rs);	

//echo $sql;



 if(true)
  { $f=1;
     switch($opc)	
        {
	case 0:
    case 3:
    case 4:
			///$rsFallecido=mysql_query($sqlFallecido,$link)or die("Error en cadena de consulta  sqlFallecido".mysqli_error($link));
			//$nFallecido=mysqli_num_rows($rsFallecido);	

			//$rsTransferido=mysql_query($sqlTransferido,$link)or die("Error en cadena de consulta  sqlTransferido".mysqli_error($link));
			//$nTransferido=mysqli_num_rows($rsTransferido);

			while($rows=mysqli_fetch_array($rs))
			{
				$neofec="";	
				include("status.php");
				$neofec=$rows[3];
				$arrayrs[]=array('n'=>$f,
						 'codigo'=>$rows[0],	
						 'prefijo_caballo'=>$rows[1],
						 'nombre_caballo'=>$rows[2],
						 'nacimiento_caballo'=>$neofec,
						 'padre_caballo'=>$rows[6],
						 'madre_caballo'=>$rows[9],
						 'criador_caballo'=>$rows[14],
						 'propietario_caballo'=>$rows[16],
						 'fallecio'=>$status,
						 'microchip_caballo'=>$rows[18],
				 		 'adn_caballo'=>$rows[19]);
				$f++;
			}
	break;

	case 1:
	   while($rows=mysqli_fetch_array($rs))
   	   {	
		$sql2="select * from  ".TABLE_DATO." WHERE cod_criador='$rows[0]'";
		$rs2=mysql_query($sql2,$link)or die("Error en cadena de consulta ".mysqli_error($link));
		$arrayrs[]=array('n'=>$f,
			             'id'=>mysqli_result($rs2,0,'cod_criador'),
			             'nombre'=>mysqli_result($rs2,0,'criador'));
		$f++;
	     }break;
 
	case 2:
	   while($rows=mysqli_fetch_array($rs))
   	   {	
		$sql23="select * from  ".TABLE_DATO." WHERE cod_propie='$rows[0]'";
		$rs23=mysql_query($sql23,$link)or die("Error en cadena de consulta 4".mysqli_error($link));
		$arrayrs[]=array('n'=>$f,
			             'id'=>mysqli_result($rs23,0,'cod_propie'),
			             'nombre'=>mysqli_result($rs23,0,'propie'));
		$f++;
	     }break;
      }//fin de switch

  }
  else
  {
	$arrayrs=-1;	
  }	
//echo"<pre>";print_r($arrayrs);echo"</pre>";
return $arrayrs;




mysqli_close($link);


}

function listarPelaje($link){
$sql="SELECT nombre FROM pelaje ";
$rs=mysqli_query($link,$sql)or die("Error en cadena de listarPelaje ".mysqli_error($link));
$n=mysqli_num_rows($rs);	
while($rows=mysqli_fetch_array($rs))
			{
				$arrayrs[]=array(
						 'id'=>$rows[0],	
						 'nombre'=>$rows[0]
						  );
			}
 
return $arrayrs;
}
function obtenerMaxIdPoe($link,$cod){
$sql="SELECT max(poe) poeMax from (
select idPoe poe,sum(numReg) from (
select idPoe,count(id) numReg from poe_propiedad where idUser in(select  id from usuario where cod_propie=".$cod.")  group by  idPoe
union all
select idPoe,count(id) from poe_historial where idUser in(select  id from usuario where cod_propie=".$cod.") group by  idPoe
union all
select idPoe,count(id) from poe_movimiento where idUser in(select  id from usuario where cod_propie=".$cod.") group by  idPoe
) q
where q.idPoe is not null
 group by  q.idPoe
) p ";
$rs=mysqli_query($link,$sql)or die("Error en cadena de obtener ".mysqli_error($link));
$n=mysqli_num_rows($rs);	
while($rows=mysqli_fetch_array($rs))
			{
				$idPoe= $rows[0];
						 
			}
 //$idPoe=array_column($arrayrs, 'poeMax');

return  $idPoe;
}
function showImage($idhorse,$link){
	
	$sql="SELECT idImagen,idCaballo,ruta,esPrincipal,activo FROM sgev_imagen where idCaballo='".$idhorse."'  order by 4 desc";
	//echo $sql;
	$rs=mysqli_query($link,$sql)or die("Error en cadena de obtener".mysqli_error($link));
	$n=mysqli_num_rows($rs);
	while($rows=mysqli_fetch_array($rs)){
			$arrayrs[]=array('n'=>$f,
				 'idImagen'=>$rows[0],	
				 'idCaballo'=>$rows[1],
				 'ruta'=>($rows[2]),
				 'esPrincipal'=>$rows[3],
				 'activo'=>$rows[4]);
	}
return $arrayrs;
}
function deserializarData($str,$link){


			$resena=unserialize($str);
			//print_r($resena);
			if(is_array($resena)){	
					if(count($resena)>0){
				foreach ($resena as $key => $value) {
					//$res[]=array('id' => $value	 );
					$sql3="select descripcion from sgev_resenas where id='$value'";
					//echo $sql;
					$rs3=mysqli_query($link,$sql3)or die("Error en cadena de consulta 2 ".mysqli_error($link));
					$n3=mysqli_num_rows($rs3);	
 				if($n3>0)
  				{ 	
   				$nomRes=mysqli_result($rs3,0,'descripcion');				
  				}
				else
 				{
  				 $nomRes=" ";				
 				}
					$allRes=($allRes=="" ? "" : $allRes.", ").$nomRes."" ;
					
			  }	
			}
			}else{
			$allRes=$str;
		}
		if($allRes!=""){
			$allRes.=". ";
		}
		//print_r($res);
		return $allRes;
}

function mysqli_result($res, $row, $field=0) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
} 

?>