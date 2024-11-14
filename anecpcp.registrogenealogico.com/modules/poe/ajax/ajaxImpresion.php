<?php  session_start();
    include_once ("../logica/ImpresionLogica.php");
    include_once ("../entidad/Ejemplar.inc.php");
    include_once ("../entidad/Resultado.inc.php");    

     include_once ("../comunes/lib.comun.php");    
     include_once ("../constante.php");  

 
   if (file_exists("../entidad/Constantes.php")) {        include_once("../entidad/Constantes.php");    }
   
    if(isset($_POST["opc"])){
      
        $usuario_crea = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $usuario_modi = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $codigo_empresa =0;
        $codigo_local = 0;
    
        
        if($_POST["opc"]=="nveces"){
             $id = $_POST["id"];
            echo  vecesImpreso($id);
 
        } 
    }
    
     function vecesImpreso($codigo){
         $retorno=new Resultado();
        $objImagen = new ImpresionLogica();
        $result = $objImagen->obtenerVecesImpresion($codigo);

        if ($result->result != -1){
            $retorno->result=$result->result;
        }else{
            $retorno->result=0;
            $retorno->message = "OCURRIÓ UN ERROR ";
        }
       return json_encode($result);
    }
?>
