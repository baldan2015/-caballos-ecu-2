<?










function xpaginador($reg,$ini,$fin,$filas,$source='0')
{
			$numrows=$filas;
			if(sizeof($reg) >(int)$fin)
			  {

			    if($ini==1)
				{
				///adelante
				$ini=1;$fin=$numrows;
				$neoinicio=$fin+1;
				$neofin=$fin+$numrows;

				echo"<tr><td colspan=9 align=center><a href='javascript:next(".$neoinicio.",".$neofin.",".$source.");' name=paginador>P&aacute;gina siguiente  <img src='img/b_nextpage.png' border=0></a>&nbsp;&nbsp;";
  	  			echo"</td></tr>";
				}
			    else
				{
				///adelante
				$neoinicio=$fin+1;
				$neofin=$fin+$numrows;

				////atras
				$backinicio=$neoinicio-$numrows-$numrows;
				$backfin=$neofin-$numrows-$numrows;

			        echo"<tr><td colspan=9 align=center  class='text2'>
			        <a href='javascript:next(".$backinicio.",".$backfin.",".$source.");'  name=paginador ><img src='img/b_prevpage.png' alt='anterior' border=0></a>&nbsp;&nbsp;P&aacute;ginas&nbsp;&nbsp;
			        <a href='javascript:next(".$neoinicio.",".$neofin.",".$source.");' >  <img src='img/b_nextpage.png'alt='siguiente ' border=0></a>&nbsp;&nbsp;";
  			        echo"</td></tr>";
				}

			   	
			  }
			  
		       elseif(sizeof($reg)<=(int)$fin)
				{
		
			     	$inix=$fin-$numrows-$numrows;
				$ini=$inix+1;
			   	$fin=$inix+$numrows;
				if($ini<0)
				{
				echo"<tr><td colspan=9 align=center>&nbsp;&nbsp;";    echo"</td></tr>";
				}
				else
				{
				echo"<tr><td colspan=9  align=center><a href='javascript:next(".$ini.",".$fin.",".$source.");'  name=paginador > <img src='img/b_prevpage.png' border=0>&nbsp;&nbsp; Volver </a>&nbsp;&nbsp;";
  	  			echo"</td></tr>";
				}
				

				}
				else
				{
					     echo"<tr><td colspan=9 align=center>&nbsp;&nbsp;";    echo"</td></tr>";
				}	



}





function xpaginadorNeo($reg,$ini,$fin,$filas,$source='0')
{
	
			$numrows=$filas;
			if(sizeof($reg) >(int)$fin)
			  {

			    if($ini==1)
				{
				///adelante
				$ini=1;$fin=$numrows;
				$neoinicio=$fin+1;
				$neofin=$fin+$numrows;

				echo"<tr><td colspan=9 align=center><label title='ir a siguiente pagina' onclick='next(".$neoinicio.",".$neofin.",".$source.");' >P&aacute;gina siguiente  <img src='img/b_nextpage.png' border=0></label>&nbsp;&nbsp;";
  	  			echo"</td></tr>";
				}
			    else
				{
				///adelante
				$neoinicio=$fin+1;
				$neofin=$fin+$numrows;

				////atras
				$backinicio=$neoinicio-$numrows-$numrows;
				$backfin=$neofin-$numrows-$numrows;

			       echo"<tr><td colspan=9 align=center  class='text2'>
			        <label onclick='next(".$backinicio.",".$backfin.",".$source.");'   title='ir a anterior pagina'  ><img src='img/b_prevpage.png' alt='anterior' border=0></label>&nbsp;&nbsp;P&aacute;ginas&nbsp;&nbsp;
			        <label onclick='next(".$neoinicio.",".$neofin.",".$source.");'  title='ir a siguiente pagina'>  <img src='img/b_nextpage.png'alt='siguiente ' border=0></label>&nbsp;&nbsp;";
  			       echo"</td></tr>";
				}

			   	
			  }
			  
		       elseif(sizeof($reg)<=(int)$fin)
				{
		
			     	$inix=$fin-$numrows-$numrows;
				$ini=$inix+1;
			   	$fin=$inix+$numrows;
				if($ini<0)
				{
				echo"<tr><td colspan=9 align=center>&nbsp;&nbsp;";    echo"</td></tr>";
				}
				else
				{
				echo"<tr><td colspan=9  align=center><label  title='ir a anterior pagina' onclick='next(".$ini.",".$fin.",".$source.");'   > <img src='img/b_prevpage.png' border=0>&nbsp;&nbsp; Volver </label>&nbsp;&nbsp;";
  	  			echo"</td></tr>";
				}
				

				}
				else
				{
					     echo"<tr><td colspan=9 align=center>&nbsp;&nbsp;";    
					     echo"</td></tr>";
				}	



} 
function obtenerIdPropietario($idUser)
{
$cn=new dal();
$link=$cn->conectar2();
$codPropie='0';

$sql="select idProp cod_propie from sge_propietario where IdEntidad='$idUser'   ";
//echo"<br><br><br><br><br> ---***----- ".$sql;
$rs=mysqli_query($link,$sql)or die("Error en cadena de obtenerIdPropietario ".mysqli_error($link));
$n=mysqli_num_rows($rs);	
//$n=1; 
//echo "<br>".$n;
if($n>0){ 	
   				$codPropie=mysqli_result_b($rs,0,'cod_propie');				
}
	//echo "<br><br><br><br><br><br><br><br><br>";
	//die($codPropie) ;



return $codPropie;
}	


function obtenerPeriodoPoe($idPoe='')
{
$cn=new dal();
$link=$cn->conectar2();
$periodo='0';
$sql="Select periodo,fecIni,fecFin,descripcion FROM poe_programacion where idPoe='$idPoe'";
$rs=mysqli_query($link,$sql)or die("error al consultar obtenerIdPropietario ".mysqli_error($link));
$n=mysqli_num_rows($rs);
if($n==1){
		$periodo=mysqli_result_b($rs,0,"periodo");
}
	mysqli_close($link);
return $periodo;
}	

		
function EnvioForm($link,$poe,$user){

	$cn=new Connection();
$link=$cn->Conectar();

	$retorno=false;
	$sql="select idPoe,idUser,fecCrea from poe_enviado where idPoe='".$poe."' and idUser='".$user."' ";
	//echo $sql;
	$result = mysqli_query($link,$sql);
		$n=mysqli_num_rows($result);
		if($n>0){
			$retorno=true;
		}
		mysqli_close($link);
		return $retorno;
}
function obtenerCorreoUser($idUser='')
{
$cn=new Connection();
$link=$cn->Conectar();
$correo='';
$sql="select correo from usuario where id='$idUser'";
//echo($sql);
$rs=mysql_query($sql,$link)or die("error al consultar obtenerCorreoUser ".mysql_error($link));
$n=mysql_num_rows($rs);
if($n==1){
		$correo=mysql_result($rs,0,"correo");

	}
//mysql_close($link);
return $correo;
}
function obtenerCorreoUserXidProp($cod_propie='')
{
$cn=new Connection();
$link=$cn->Conectar();
$correo='';
$sql="select correo from usuario where cod_propie='$cod_propie'";
//echo($sql);
$rs=mysqli_query($link,$sql)or die("error al consultar obtenerCorreoUserXidProp ".mysql_error($link));
$n=mysqli_num_rows($rs);
if($n==1){
		$correo=mysqli_result_b($rs,0,"correo");

	}
//mysql_close($link);
return $correo;
}
function obtenerNombreProp($cod_propie='')
{
$cn=new Connection();
$link=$cn->Conectar();
$nombre='';
//$sql="SELECT upper(concat(u.nom_usu,' ',u.ape_paterno,' ',u.ape_materno,' ',u.razonSocial)) nombre FROM usuario u WHERE u.cod_propie='$cod_propie'";

$sql="SELECT  distinct upper(propie) nombre FROM datos220206 WHERE cod_propie='$cod_propie'";
//echo($sql);
$rs=mysql_query($sql,$link)or die("error al consultar obtenerNombreProp ".mysql_error($link));
$n=mysql_num_rows($rs);
if($n==1){
		$nombre=mysql_result($rs,0,"nombre");

	}
//mysql_close($link);
return $nombre;
}

function obtenerCorreoConcurso($idConcurso)
{
$cn=new Connection();
$link=$cn->Conectar();
$correo='';
$sql="select correo from concurso where idConcurso='$idConcurso'";
//echo($sql);
$rs=mysql_query($sql,$link)or die("error al consultar obtenerCorreoConcurso ".mysql_error($link));
$n=mysql_num_rows($rs);
if($n==1){
		$correo=mysql_result($rs,0,"correo");

	}
//mysql_close($link);
return $correo;
}
function tienePOEAnterior($link,$idProp,$idPoeSel){
	$n=0;
	if($idPoeSel=="")	$idPoeSel=0;
	$cn=new Connection();
	$link=$cn->Conectar();
		$idPoeLast="0";
		$sql = " SELECT * FROM ( 
			SELECT  max(periodo) as periodo,
(max(periodo)-1)periodoAnterior,
max(p.idPoe) as idPoe ,
(select pp.idPoe from poe_programacion pp where pp.periodo=(max(p.periodo)-1) )idPoeAnt,
(select count(*) from poe_propiedad where  idProp='$idProp' and   idPoe in(select pp.idPoe from poe_programacion pp where pp.periodo=(max(p.periodo)-1) ))  num
 from poe_programacion p 
		left join  poe_propiedad  prop  on(prop.idPoe=p.idPoe and idProp='$idProp') 
		where    p.idPoe=$idPoeSel 
		) q where periodo is not null";
	 	 //echo $sql;
		$result = mysqli_query($link,$sql) or die("Error  tienePOEAnterior: ".mysqli_error($link));
		$n=mysqli_num_rows($result);	

	//	echo $result;//"*****total registros..".$n;

		if($n>0){
			$periodoCorte=mysqli_result_b($result,0,"periodo");
			$idPoeLast=mysqli_result_b($result,0,"idPoeAnt");
			if(strlen($idPoeLast)==0){
				$idPoeLast="0";//mysql_result($result,0,"idPoe");
			}
			$tienePropiedad=mysqli_result_b($result,0,"num");
		} 
	 
	 
	 	if($tienePropiedad=="0" && $idPoeLast=="1"){
				$idPoeLast="0";
	 	}
		if($idPoeSel=="1"){
				$idPoeLast="0";
		 }
		 
		 mysqli_close($link);
		return $idPoeLast;
	}
/*
addon  obtiene nombre del ejemplar
*/
function obtieneNombreCaballo($id,$link)
{
$sql3="select  nombre from ".TABLE_DATO." where codigo='$id'";
$rs3=mysqli_query($link,$sql3)or die("Error en cadena de obtieneNombreCaballo ".mysqli_query($link));
$n3=mysqli_num_rows($rs3);	
 if($n3>0)
  { 	
   $nombre=mysqli_result_b($rs3,0,'nombre');				
  }
else
 {
   $nombre=" - ";				
 }
  return  $nombre;
}
function mysqli_result_b($res, $row, $field=0) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
} 
?>