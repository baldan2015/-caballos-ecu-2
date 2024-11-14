<?
session_start();
	
require("../Clases/conexion.php");
require("../Clases/resultado.php");
	$cn=new Connection();
	$retorno=new Resultado();

	$link=$cn->Conectar();
	mysqli_set_charset($link, 'utf8');
	if(isset($_POST['opc'])){
		if($_POST['opc'] == 'lst'){
			
			$retorno->result=1;
			$retorno->data= listarPelaje($link);
			echo json_encode($retorno);

		}
	}



function listarPelaje($link){
$sql="SELECT nombre,id FROM poe_pelaje order by 2 ";
$rs=mysqli_query($link,$sql) or die("Error en cadena de listarPelaje ".mysqli_error($link));
$n=mysqli_num_rows($rs);
//$arrayrs=[]	;

while($rows=mysqli_fetch_array($rs))
			{
			
				$arrayrs[]=array(
						 'id'=>$rows[1],	
						 'nombre'=>$rows[0]
						  );
			}
 
return $arrayrs;
//print_r($arrayrs);
}
?>