<? session_start();
include_once("../entidad/Constantes.php");  
include_once("../entidad/Resultado.inc.php");  
include_once("../comunes/lib.comun.php");   
if(isset($_POST["opc"])){
        if($_POST["opc"]=="valSession"){
 			$retorno=new Resultado();
 			validarSesion($retorno);
			echo json_encode($retorno);
        }
    }

?>