<? require("../../../constante.php");
require_once(DIR_LEVEL_MOD_POE."Clases/conexion.php");
require_once(DIR_LEVEL_MOD_POE."Clases/resultado.php");
 
	$cn=new Connection();
	$retorno=new Resultado();

	$link=$cn->Conectar();
	
	if(isset($_POST['opc'])){
		if($_POST['opc'] == 'lst'){
			$retorno->result=1;
			$retorno->data= json_encode(listarPelaje($link));
			echo json_encode($retorno);

		}
	}



function listarPelaje($link){
$sql="SELECT nombre,id FROM poe_pelaje order by 2 ";
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
?>