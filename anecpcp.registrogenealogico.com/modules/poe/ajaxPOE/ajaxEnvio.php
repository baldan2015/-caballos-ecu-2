<? session_start();
	require("../../../constante.php");
	require(DIR_LEVEL_MOD_POE."Clases/conexion.php");
	require(DIR_LEVEL_MOD_POE."Clases/resultado.php");
	require(DIR_LEVEL_MOD_POE."Funciones/general.php");

	$cn=new Connection();
	$link=$cn->Conectar();
	
	 
		$a=$_SESSION['_periodoPoe'];
		$b=$_SESSION['xid'];

		if($_POST['opc']=='dll'){
		 
		 $periodo=$_SESSION['periodoActual'];
		 $nomProp=$_SESSION['xusu'];
		 $correoUser=obtenerCorreoUser($b);

		echo envioDatos2($link,$a,$b,$correoUser,$periodo,$nomProp);
		}

		 if($_POST['alt']=='get'){
			echo EnvioForm2($link,$a,$b);
		}


		function envioDatos2($link,$a,$b,$correoUser,$periodo,$nomProp){
				$sql="INSERT into poe_enviado (idPoe,idUser,fecCrea) 
				values('".$a."','".$b."',now()) ";
				//echo $sql;
 		    $result = mysqli_query($link,$sql);

			if($result){
				enviarcorreoB($correoUser,$nomProp,$periodo);
				return true;

			}else{
				return false;
			}

			
		}	
		function EnvioForm2($link,$poe,$user){
	$retorno=false;
	$sql="select idPoe,idUser,fecCrea from poe_enviado where idPoe='".$poe."' and idUser='".$user."' ";
	// echo $sql;
		$result = mysqli_query($link,$sql);
		$n2=mysqli_num_rows($result);
		if($n2>0){
			$retorno=true;
		}
		//echo "***".$retorno;
		return $retorno;
}		

function enviarcorreoB($mailUser,$nomUser,$periodo)
{

$destinatario="concursos@registrogenealogico.org.pe";

$asunto="Envío Parte de Ocurrencias de Ejemplares - Periodo: ".$periodo ."  - ".$nomUser;
$cuerpo="El Usuario: ".$nomUser."  ha finalizado y enviado el parte de ocurrencias del Periodo: ".$periodo;

//para el envío en formato HTML
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From: $destinatario\r\n"; 
$headers .= "CC: $mailUser \r\n"; 
$headers .= 'Bcc: dbalvis@teon.pe' . "\r\n";

 

mail($destinatario,$asunto,$cuerpo,$headers); 

}
?>