<?php  session_start();
    include_once ("../logica/EjemplarLogicaF2.php");
    include_once ("../entidad/Ejemplar.inc.php");
    include_once ("../entidad/Resultado.inc.php");    
     include_once ("../comunes/lib.comun.php");    

    
 
   if (file_exists("../entidad/Constantes.php")) {        include_once("../entidad/Constantes.php");    }
   
 

    if(isset($_POST["opc"])){

     
        $usuario_crea = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $usuario_modi = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $codigo_empresa =0;
        $codigo_local = 0;
    
        
       if($_POST["opc"]=="aproMon"){
           $id=$_POST["id"];
           $prop=$_POST["prop"];
           echo aprobarMonta($id,$prop);
        }else if($_POST["opc"]=="recMon"){
           $id=$_POST["id"];
           $prop=$_POST["prop"];
           echo rechazarMonta($id,$prop);
        }else if($_POST["opc"]=="lstPais"){
            echo listarPais();
        }else if($_POST["opc"]=="getExt"){
            $id=$_POST["id"];
            echo getDatosExtranjero($id);
        }else if($_POST["opc"]=="updExt"){
            $id=$_POST["hidCodigo"];
            $codigo=$_POST["codigo"];
            $nombre=$_POST["nombre"];
            $prefijo=$_POST["prefijo"];
            $dtpFecNacExt=$_POST["dtpFecNacExt"];
            $pelaje=$_POST["idPelaje"];
            $pais=$_POST["idpais"];
            echo updateDatosExtranjero($id,$codigo,$nombre,$prefijo,$dtpFecNacExt,$pelaje,$pais);
        }else if($_POST["opc"]=="getApro"){
            $id=$_POST["id"];
            echo getDatosExtranjero($id);
        }else if($_POST["opc"]=="detApro"){
            $id=$_POST["id"];
            echo detalleAprobacion($id);
        }else if($_POST["opc"]=="listIdMonta"){
            $id="0";
            $descripcion="";
            $prop=$_POST["prop"];
            $flag=$_POST["flag"];
            echo listaComboIdMonta($prop,$flag);
        }else if($_POST["opc"]=="dltMonta"){
            $id=$_POST["id"];
            $usuEliminado=$_POST["prop"];
            echo eliminarMonta($id,$usuEliminado);
        }


    }

        function aprobarMonta($id,$prop){
            $retorno=new Resultado();
             if(validarSesion($retorno)->result==1){
            $ins = new EjemplarLogica();

            $response = $ins->aprobarMonta($id,$prop);


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
        function rechazarMonta($id,$prop){
            $retorno=new Resultado();
             if(validarSesion($retorno)->result==1){
            $ins = new EjemplarLogica();

            $response = $ins->rechazarMonta($id,$prop);
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

          function listarPais(){
                $retorno=new Resultado();
                $obj=new  EjemplarLogica();
                $result=$obj->listarPais();

                            $retorno->result=1;
                            $retorno->message ="Cargo correctamente el combo";
                            $retorno->data=$result;

                return json_encode($retorno);
            }


            function getDatosExtranjero($id){
            $retorno=new Resultado();
             if(validarSesion($retorno)->result==1){
            $ins = new EjemplarLogica();

            $result = $ins->getDatosExtranjero($id);


                    $retorno->result=1;
                    $retorno->message ="Cargo correctamente la información";
                    $retorno->data=$result;
                }
                return json_encode($retorno);
            }

            function updateDatosExtranjero($id,$codigo,$nombre,$prefijo,$dtpFecNacExt,$pelaje,$pais){
            $retorno=new Resultado();
             if(validarSesion($retorno)->result==1){
            $ins = new EjemplarLogica();

            $response = $ins->updateDatosExtranjero($id,$codigo,$nombre,$prefijo,$dtpFecNacExt,$pelaje,$pais);


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


            function detalleAprobacion($id){
            $retorno=new Resultado();
             if(validarSesion($retorno)->result==1){
            $ins = new EjemplarLogica();

            $result = $ins->detalleAprobacion($id);


                    $retorno->result=1;
                    $retorno->message ="Cargo correctamente la información";
                    $retorno->data=$result;
                }
                return json_encode($retorno);
            }

            function listaComboIdMonta($prop,$flag){
                $retorno=new Resultado();
                $obj=new  EjemplarLogica();
                $result=$obj->listaComboIdMonta($prop,$flag);

                            $retorno->result=1;
                            $retorno->message ="Cargo correctamente el combo";
                            $retorno->data=$result;

                return json_encode($retorno);
    }

    function eliminarMonta($id,$usuEliminado){
        $retorno=new Resultado();
         if(validarSesion($retorno)->result==1){
        $ins = new EjemplarLogica();

        $response = $ins->eliminarMonta($id,$usuEliminado);
                if ($response->result == 1){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_DELETE_OK;
                }else if ($response->result == 2){
                    $retorno->result=0;
                    $retorno->message = Constantes::K_MENSAJE_DELETE_NOOK_TIENE_NAC;
                }else if ($response->result == 0){
                    $retorno->result=0;
                    $retorno->message = Constantes::K_MENSAJE_DELETE_NOOK;
                }
        }
            return json_encode($retorno);
         
    }
?>

