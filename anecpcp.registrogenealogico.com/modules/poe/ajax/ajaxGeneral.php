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
        if($_POST["opc"]=="valUrl"){
            $retorno=new Resultado();
            $obj= new stdClass();
            $obj->K_PATH_ROOT_SERVICIO=Constantes::K_URL_SERVICIO_GENERAL;
            
            $retorno->data = $obj;
            $retorno->result = 1;
           echo json_encode($retorno);
       }
    }
?>