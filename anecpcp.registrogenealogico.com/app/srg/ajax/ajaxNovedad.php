<?php  session_start();
    include_once ("../logica/EjemplarLogicaF2.php");
    include_once ("../logica/PropietarioLogLogica.php");
    include_once ("../entidad/Ejemplar.inc.php");
    include_once ("../entidad/Resultado.inc.php");    
    include_once("../logica/ResenaLogica.php");
     include_once ("../comunes/lib.comun.php");    

    
 
   if (file_exists("../entidad/Constantes.php")) {        include_once("../entidad/Constantes.php");    }
   
 

    if(isset($_POST["opc"])){

     
        $usuario_crea = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $usuario_modi = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $codigo_empresa =0;
        $codigo_local = 0;
    
        
        if($_POST["opc"]=="updHist"){
           $id=$_POST["id"];
           $accion=$_POST["accion"];
           $flag=$_POST["flag"];
           $prop=$_POST["prop"];
           $comentario=$_POST["comentario"];
           $fecha=$_POST['fecha'];
           echo insertLogHistorial($id,$accion,$flag,$prop,$comentario,$fecha);
        }else if($_POST["opc"]=="getCant"){
            //$id=$_POST["id"];
           
            echo cantidadRregistroxAproOrRech();
        }else if($_POST["opc"]=="allNov"){
            echo cantidadAllNovedades();
        }else if($_POST["opc"]=="getFecha"){
            $id=$_POST["id"];
            $flag=$_POST["flag"];
            echo getFechaNovedades($id,$flag);
        }else if($_POST["opc"]=="getNewProp"){
            $idProp=$_POST["idProp"];
            echo getInfoNewProp($idProp);
        }else if($_POST["opc"]=="updNewProp"){
            $id=$_POST["id"];
            $tipoDoc=$_POST["tipoDoc"];
            $numDoc=$_POST["numDoc"];
            $nombreProp=$_POST["nombreProp"];
            $apePatProp=$_POST["apePatProp"];
            $apeMatProp=$_POST["apeMatProp"];
            $direccion=$_POST["direccion"];
            $correo=$_POST["correo"];
            $idProp=$_POST["idProp"];
            echo updateDatosNewProp($id,$tipoDoc,$numDoc,$nombreProp,$apePatProp,$apeMatProp,$direccion,$correo,$idProp);
        }    
           
        
    }
    
   
    
   /*-------------------------------------------- fase 2 --------------------------*/
    function insertLogHistorial($id,$accion,$flag,$prop,$comentario,$fecha){
        $retorno=new Resultado();
         if(validarSesion($retorno)->result==1){
        $ins = new EjemplarLogica();

        $response = $ins->insertLogHistorial($id,$accion,$flag,$prop,$comentario,$fecha);


        if ($response->result == 1){
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
        }else if ($response->result == 0){
            $retorno->result=0;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
        }
    }
        return json_encode($retorno);
    }

    
    function cantidadRregistroxAproOrRech(){
         $retorno=new Resultado(); 
         $list = new EjemplarLogica();
         $retorno->validateTOKEN="1";
         if(validarSesion($retorno)->result==1){    
            $retorno->data=$list->cantidadRregistroxAproOrRech();
            }
         return json_encode($retorno);
       }  

    function cantidadAllNovedades(){
         $retorno=new Resultado(); 
         $list = new EjemplarLogica();
         $retorno->validateTOKEN="1";
         if(validarSesion($retorno)->result==1){    


            $response=$list->cantidadAllNovedades();
            //print_r($response);
            if($response->result == 0){
                $retorno->result=0;
            }else{
                $retorno->result=$response->result;
            }

         }
         return json_encode($retorno);
    }

    function getFechaNovedades($id,$flag){
         $retorno=new Resultado(); 
         $list = new EjemplarLogica();
         $retorno->validateTOKEN="1";
         if(validarSesion($retorno)->result==1){    
            $retorno->data=$list->getFechaNovedades($id,$flag);
            }
         return json_encode($retorno);
       }  


       function getInfoNewProp($idProp){
         $retorno=new Resultado(); 
         $list = new EjemplarLogica();
         $retorno->validateTOKEN="1";
         if(validarSesion($retorno)->result==1){    
            $retorno->data=$list->getInfoNewProp($idProp);
            }
         return json_encode($retorno);
       }  


       function updateDatosNewProp($id,$tipoDoc,$numDoc,$nombreProp,$apePatProp,$apeMatProp,$direccion,$correo,$idProp){
            $retorno=new Resultado();
             if(validarSesion($retorno)->result==1){
                $ins = new EjemplarLogica();

                $response = $ins->updateDatosNewProp($id,$tipoDoc,$numDoc,$nombreProp,$apePatProp,$apeMatProp,$direccion,$correo,$idProp);
                if ($response->result == 1){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
                }else if ($response->result == 0){
                    $retorno->result=0;
                    $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
                }
            }
            return json_encode($retorno);
        }
?>

