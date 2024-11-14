<?php session_start();
include_once ("../entidad/Constantes.php");
include_once ("../logica/LoginLogica.php");
include_once ("../entidad/Login.php");
 
    $resultado=" ";
    
    if(isset($_POST["opc"])){
        if($_POST["opc"]=="login"){
                if(isset($_POST["usr"])){
                            if($_POST["usr"]!=""){
                                
                                    if(isset($_POST["pwd"])){
                                               if($_POST["pwd"]!=""){
                                                
                                               $objLogin = new LoginLogica();
                                                $entity = new Login();
                                                $entity->usuario = $_POST["usr"];
                                                $entity->contrasenia = $_POST["pwd"];
                                            
                                               
                                                $usuario = $objLogin->ValidarLogin($entity);

                                               if(is_object($usuario)){

                                                 $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO]=$usuario->idUsu;
                                                  $_SESSION[Constantes::K_SESSION_EMPRESA]=constantes::K_ID_EMPRESA_DEFAULT;
                                                  $_SESSION[Constantes::K_SESSION_USUARIO]=$usuario;
                                                  $_SESSION[Constantes::K_SESSION_NOMBRE_COMPLETO]= $usuario->razonSocial;
                                                  $_SESSION[Constantes::K_SESSION_CORREO_USUARIO]= $usuario->correo;
                                                  $_SESSION[Constantes::K_SESSION_ROL_USUARIO]= $usuario->rol;
                                                  $_SESSION[Constantes::K_SESSION_USUARIO_LOGIN]= $usuario->login;
                                                  $_SESSION[Constantes::K_SESSION_CARGO_USUARIO]= $usuario->idRol;
                                                  $resultado="OK";
                                               }else{
                                                  session_destroy();
                                                     $resultado="<span style='color:yellow;font-weight:bold;'>Login Incorrecto.</span>";
                                               }
                                              }else{
                                                    $resultado="<span style='color:orange;font-weight:bold;'>Ingrese clave del usuario del sistema.</span>"; 
                                               } 
                                     }else{
                                        $resultado="No se ha enviado la clave del usuario del sistema";
                                     }
                            }else{
                                  $resultado="<span style='color:yellow;font-weight:bold;'>Ingrese el usuario del sistema.</span>";
                            }
                }else{
                    $resultado="Error parametros esperados no enviados";
                }
        }else{
            $resultado="Error parametros esperados no enviados";
        }
    } 
   echo $resultado;

  //  echo "<pre>";
   //echo print_r($_SESSION);
?>