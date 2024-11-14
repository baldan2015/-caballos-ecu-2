<?php 
ini_set('safe_mode', false); 
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With,Authorization ");
header('Content-Type: application/json; charset=utf-8');
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');
 
 
date_default_timezone_set("UTC");


//session_start();
include_once ("../logica/LoginLogica.php");
include_once ("../logica/EjemplarLogica.php");
include_once ("../logica/PropietarioLogLogica.php");
include_once ("../entidad/Ejemplar.inc.php");
include_once ("../entidad/Resultado.inc.php");    
include_once ("../logica/ResenaLogica.php");
include_once ("../comunes/lib.comun.php");    
require_once '../jwt/vendor/autoload.php';
require_once '../jwt/auth.php';

if (file_exists("../entidad/Constantes.php")) {        include_once("../entidad/Constantes.php");    }
   


    $headers = getallheaders();
    $token = $headers['Authorization'];
    //echo "<pre>";print_r($headers);echo"</pre>";

    if($_SERVER["REQUEST_METHOD"]=='POST'){
                if($_POST['opc']=="test"){ 
                   $retorno=validateToken($token);
                    if($retorno->result==1){
                        echo getLastInsertNac();
                    }else{
                        header("HTTP/1.1 200 OK");
                        echo json_encode($retorno);
                    }
                }
              else if($_POST['opc']=="autentica"){
                   $usr= $_POST['usr'];
                   $pwd= $_POST['pwd'];
                   $retorno=new stdClass();
                   $usuario=new stdClass();
                   $usuario->usuario=$usr;
                   $usuario->contrasenia=$pwd;
                   $objAutentica = new LoginLogica();
                   
                   $response = $objAutentica->ValidarLogin($usuario);
                   if(is_object($response)){
                            $retorno->data=$response;
                            $retorno->result=1;
                            $retorno->message="LOGIN OK";
                            $retorno->isRedirect=1;
                            $tokenGen=Auth::SignIn($response);
                            $retorno->token=$tokenGen;
                    }else{
                            $retorno->result=0;
                            $retorno->message="LOGIN NO OK";
                            $retorno->isRedirect=0;
                            $retorno->validateTOKEN=0;
                   }
                    header("HTTP/1.1 200 OK");
                    echo json_encode($retorno);
                }
                else if($_POST["opc"]=="insIns"){
                     
                        $retorno=new Resultado();
                        $codigo=$_POST["codigo"];
                        $prefijo = $_POST["prefijo"];
                        $nombre = addslashes($_POST["nombre"]);
                        $fecNace=$_POST["fecNace"];
                        $padre = $_POST["padre"];
                        $madre = $_POST["madre"];
                        $idPelaje = $_POST["idPelaje"];
                        $lugarNace = addslashes($_POST["lugarNace"]);
                        $microchip=$_POST["microchip"];
                        $adn = $_POST["adn"];
                        $descripcion = addslashes($_POST["descripcion"]);
                        $entidad=$_POST["entidad"];
                        $genero=$_POST["genero"];
                        $fecCapado=$_POST["fecCapado"];
                        $idMonta=$_POST["idMonta"];
                        $idNac=addslashes($_POST["idNac"]);
                        $idProvincia=$_POST["idProvincia"];
                        $origen=$_POST["origen"];
                        $resenias=$_POST["resenias"];
                        $fecReg=$_POST["fecReg"];
                        $nroLibro=$_POST["nroLibro"];
                        $nroFolio=$_POST["nroFolio"];
                        $fecServ=$_POST["fecServ"];
                        $metodo=$_POST["idMetodo"];
                        $idProp=$_POST["idProp"];
                        $idPoe=$_POST["idPoe"];
                        $idCriador=$_POST["idCriador"];
                        $arrayResenias = json_decode($_POST["arrayResenias"],true);
                        $codigoGenerado=$_POST["codigoGenerado"];
                       
                           //print_r( $propie);
                            header("HTTP/1.1 200 OK");
                            echo insertarINS($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$usuario_crea,$genero,$fecCapado,$idMonta,$idNac,$idProvincia,
                                 $origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$arrayResenias,$codigoGenerado);

               } else if($_POST["opc"]=="lstInscp"){
                     $prop=$_POST['idProp'];
                     $estado="";
                     $situacion="";
                     $retorno=validateToken($token);
                     
                     if($retorno->result==1){
                     echo listarInscripcion($prop,$estado,$situacion);
                     }else{
                        header("HTTP/1.1 200 OK");
                        echo json_encode($retorno);
                    }
                }else if($_POST["opc"]=="getIns"){
                     $id=$_POST['codigo'];
                     $retorno=validateToken($token);
                     
                     if($retorno->result==1){
                        echo getInscripcion($id);
                     }else{
                        header("HTTP/1.1 200 OK");
                        echo json_encode($retorno);
                     }
                }else if($_POST["opc"]=="updIns"){

                        $retorno=new Resultado();
                        $codigo=$_POST["codigo"];
                        $prefijo = $_POST["prefijo"];
                        $nombre = addslashes($_POST["nombre"]);
                        $fecNace=$_POST["fecNace"];
                        $padre = $_POST["padre"];
                        $madre = $_POST["madre"];
                        $idPelaje = $_POST["idPelaje"];
                        $lugarNace = addslashes($_POST["lugarNace"]);
                        $microchip=$_POST["microchip"];
                        $adn = $_POST["adn"];
                        $descripcion = addslashes($_POST["descripcion"]);
                        $entidad=$_POST["entidad"];
                        $genero=$_POST["genero"];
                        $fecCapado=$_POST["fecCapado"];
                        $fecFallece=$_POST["fecFallece"];
                        $idMonta=addslashes($_POST["idMonta"]);
                        $idNac=$_POST["idNac"];
                        $idProvincia=$_POST["idProvincia"];
                        $origen=$_POST["origen"];
                        $resenias=$_POST["resenias"];
                        $fecModi=$_POST["fecReg"];
                        $nroLibro=$_POST["nroLibro"];
                        $nroFolio=$_POST["nroFolio"];
                        $fecServ=$_POST["fecServ"];
                        $metodo=$_POST["idMetodo"];
                        $idProp=$_POST["idProp"];
                        $idPoe=$_POST["idPoe"];
                        $idCriador=$_POST["idCriador"];
                        $codigoIns=$_POST["codigoIns"];
                        $arrayResenias = json_decode($_POST["arrayResenias"],true);
                        $codigoGenerado=$_POST["codigoGenerado"];
                        $retorno=validateToken($token);
                     
                        if($retorno->result==1){
                            echo updateIns($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$arrayResenias,$codigoGenerado);
                        }else{
                            header("HTTP/1.1 200 OK");
                            echo json_encode($retorno);
                        }
                }else if($_POST["opc"]=="delIns"){
                        $codigoIns=$_POST["id"];
                        $retorno=validateToken($token);
                     
                        if($retorno->result==1){
                            echo eliminarINS($codigoIns);
                        }else{
                            header("HTTP/1.1 200 OK");
                            echo json_encode($retorno);
                        }
                }else if($_POST["opc"]=="lstNac"){
                     $prop=$_POST['idProp'];
                     $estado="";
                     $situacion="";
                     $retorno=validateToken($token);
                     
                     if($retorno->result==1){
                     echo listarNacimientoNac($prop,$estado,$situacion);
                    }else{
                        header("HTTP/1.1 200 OK");
                        echo json_encode($retorno);
                    }
                }else if($_POST["opc"]=="insNac"){
                     
                        $retorno=new Resultado();
                        $codigo=$_POST["codigo"];
                        $prefijo = $_POST["prefijo"];
                        $nombre = addslashes($_POST["nombre"]);
                        $fecNace=$_POST["fecNace"];
                        $padre = $_POST["padre"];
                        $madre = $_POST["madre"];
                        $idPelaje = $_POST["idPelaje"];
                        $lugarNace = addslashes($_POST["lugarNace"]);
                        $microchip=$_POST["microchip"];
                        $adn = $_POST["adn"];
                        $descripcion = addslashes($_POST["descripcion"]);
                        $entidad=$_POST["entidad"];
                        $genero=$_POST["genero"];
                        $fecCapado=$_POST["fecCapado"];
                        $idMonta=$_POST["idMonta"];
                        $idProvincia=$_POST["idProvincia"];
                        $origen=$_POST["origen"];
                       // $resenias=$_POST["resenias"];
                        $fecReg=$_POST["fecReg"];
                        $nroLibro=$_POST["nroLibro"];
                        $nroFolio=$_POST["nroFolio"];
                        $fecServ=$_POST["fecServ"];
                        $metodo=$_POST["idMetodo"];
                        $idProp=$_POST["idProp"];
                        $idPoe=$_POST["idPoe"];
                        $idCriador=$_POST["idCriador"];
                        $arrayResenias = json_decode($_POST["arrayResenias"],true);
                        $retorno=validateToken($token);
                        $codigoGenerado=$_POST["codigoGenerado"];
                        /*echo "<br><br><br><br><pre>";
                        print_r($arrayResenias);
                        var_dump($arrayResenias);
                        echo "</pre>";*/
                       
                           //print_r( $propie);
                        if($retorno->result==1){
                        echo insertarNAC($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuario_crea,$fecCapado,$idMonta,$idProvincia,$origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$arrayResenias,$codigoGenerado);
                        }else{
                            header("HTTP/1.1 200 OK");
                            echo json_encode($retorno);
                        }

                }else if($_POST["opc"]=="getNac"){
                     $id=$_POST['codigo'];
                     $retorno=validateToken($token);
                     if($retorno->result==1){
                     echo obtenerNAC($id);
                     }else{
                        header("HTTP/1.1 200 OK");
                        echo json_encode($retorno);
                     }
                }else if($_POST["opc"]=="info"){
                     $id=$_POST['codigo'];
                     $retorno=validateToken($token);
                     if($retorno->result==1){
                        echo obtenerDatosMonta($id);
                     }else{
                        header("HTTP/1.1 200 OK");
                        echo json_encode($retorno);
                     }
                }else if($_POST["opc"]=="updNac"){

                        $retorno=new Resultado();
                        $codigo=$_POST["codigo"];
                        $prefijo = $_POST["prefijo"];
                        $nombre = addslashes($_POST["nombre"]);
                        $fecNace=$_POST["fecNace"];
                        $padre = $_POST["padre"];
                        $madre = $_POST["madre"];
                        $idPelaje = $_POST["idPelaje"];
                        $lugarNace = addslashes($_POST["lugarNace"]);
                        $microchip=$_POST["microchip"];
                        $adn = $_POST["adn"];
                        $descripcion = addslashes($_POST["descripcion"]);
                        $entidad=$_POST["entidad"];
                        $genero=$_POST["genero"];
                        $fecCapado=$_POST["fecCapado"];
                        $fecFallece=$_POST["fecFallece"];
                        $idMonta=$_POST["idMonta"];
                        $idProvincia=$_POST["idProvincia"];
                        $origen=$_POST["origen"];
                        $resenias=$_POST["resenias"];
                        $fecModi=$_POST["fecReg"];
                        $nroLibro=$_POST["nroLibro"];
                        $nroFolio=$_POST["nroFolio"];
                        $fecServ=$_POST["fecServ"];
                        $metodo=$_POST["idMetodo"];
                        $idProp=$_POST["idProp"];
                        $idPoe=$_POST["idPoe"];
                        $idCriador=$_POST["idCriador"];
                        $codigoIns=$_POST["codigoIns"];
                        $arrayResenias = json_decode($_POST["arrayResenias"],true);
                        $codigoGenerado=$_POST["codigoGenerado"];
                        $retorno=validateToken($token);

                        if($retorno->result==1){
                        echo updateNac($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$arrayResenias,$codigoGenerado);
                         }else{
                            header("HTTP/1.1 200 OK");
                            echo json_encode($retorno);
                        }

                }else if($_POST["opc"]=="delNac"){
                        $codigoIns=$_POST["id"];
                        $retorno=validateToken($token);
                        if($retorno->result==1){
                        echo eliminarNAC($codigoIns);
                         }else{
                            header("HTTP/1.1 200 OK");
                            echo json_encode($retorno);
                        }
                }else if($_POST["opc"]=="infoNac"){
                        $id=$_POST["codigo"];
                        $retorno=validateToken($token);
                        if($retorno->result==1){
                            echo obtenerDatosNacimientoEjemplar($id);
                        }else{
                            header("HTTP/1.1 200 OK");
                            echo json_encode($retorno);
                        }
                }else if($_POST["opc"]=="lstEst"){
                        $id=$_POST["codigo"];
                        echo getEstadosLogInscripcion($id);
                }else if($_POST["opc"]=="lstEstNac"){
                        $id=$_POST["codigo"];
                        echo getEstadosLogNacimiento($id);
                }else if($_POST["opc"]=="lstServY"){
                        $idPoe = $_POST['idPoe'];
                        $idProp = $_POST['idProp'];
                        $retorno=validateToken($token);
                        if($retorno->result==1){
                            echo listarServicioY($idPoe,$idProp);
                        }else{
                            header("HTTP/1.1 200 OK");
                            echo json_encode($retorno);
                        }
                }else if($_POST["opc"]=="insMonta"){
                        $padre=$_POST["padre"];
                        $madre=$_POST["madre"];
                        $idProp=$_POST["idProp"];
                        $idPoe=$_POST["idPoe"];
                        $fecMonta=$_POST["fecMonta"];
                        $fecParir=$_POST["fecParir"];
                        $metodo=$_POST["metodo"];
                        $isTE=$_POST["isTE"];
                        $idTextoRec=$_POST["idTextoRec"];
                        $fecEmbrion=$_POST["fecEmbrion"];
                        
                         $retorno=validateToken($token);
                        if($retorno->result==1){
                            echo insertarMonta($padre,$madre,$idProp,$idPoe,$fecMonta,$fecParir,$metodo,$isTE,$idTextoRec,$fecEmbrion);
                        }else{
                            header("HTTP/1.1 200 OK");
                            echo json_encode($retorno);
                        }
                }else if($_POST["opc"]=="getMonta"){
                         $id=$_POST["codigo"];
                        $retorno=validateToken($token);
                        if($retorno->result==1){
                           echo obteneDatosServicioMonta($id);
                        }else{
                            header("HTTP/1.1 200 OK");
                            echo json_encode($retorno);
                        }
                }else if($_POST["opc"]=="updMonta"){
                        $codigo=$_POST["codigo"];
                        $padre=$_POST["padre"];
                        $madre=$_POST["madre"];
                        $idProp=$_POST["idProp"];
                        $idPoe=$_POST["idPoe"];
                        $fecMonta=$_POST["fecMonta"];
                        $fecParir=$_POST["fecParir"];
                        $metodo=$_POST["metodo"];
                        $isTE=$_POST["isTE"];
                        $idTextoRec=$_POST["idTextoRec"];
                        $fecEmbrion=$_POST["fecEmbrion"];

                        $retorno=validateToken($token);
                        if($retorno->result==1){
                            echo editarMonta($codigo,$padre,$madre,$idProp,$idPoe,$fecMonta,$fecParir,$metodo,$isTE,$idTextoRec,$fecEmbrion);
                        }else{
                            header("HTTP/1.1 200 OK");
                            echo json_encode($retorno);
                        }
                }else if($_POST["opc"]=="delServy"){
                        $codigo=$_POST["id"];
                         $retorno=validateToken($token);
                        if($retorno->result==1){
                             echo eliminarServicioy($codigo);
                        }else{
                            header("HTTP/1.1 200 OK");
                            echo json_encode($retorno);
                        }

                }else if($_POST["opc"]=="getADN"){
                        $codigo=$_POST["id"];
                        echo getADN($codigo);
                }else if($_POST["opc"]=="extIns"){
                        $codigo=$_POST["codigo"];
                        $nombre=$_POST["nombre"];
                        $prefijo=$_POST["prefijo"];
                        $fecNace=$_POST["fecNace"];
                        $idPelaje=$_POST["idPelaje"];
                        $idPais=$_POST["idPais"];
                        $genero=$_POST["genero"];
                        echo insertEjemplarExtranjero($codigo,$nombre,$prefijo,$fecNace,$idPelaje,$idPais,$genero);
                }else if($_POST["opc"]=="getLastIDMonta"){
                        echo getLastInsertMonta();
                }else if($_POST["opc"]=="getMontaPrint"){
                         $id=$_POST["codigo"];
                         $codigoMonta=$_POST["codigoMonta"];
                         $prop=$_POST["prop"];
                         echo obteneDatosServicioMontaPrint($id,$codigoMonta,$prop);
                }else if($_POST["opc"]=="getLastIDNac"){
                        echo getLastInsertNac();
                }else if($_POST["opc"]=="insLogIns"){
                        $prop=$_POST["prop"];
                        echo insertLogInscripcion($prop);
                }else if($_POST["opc"]=="getLastIDIns"){
                        echo getLastInsertIns();
                }else if($_POST["opc"]=="getNacPrint"){
                         $id=$_POST["codigo"];
                         $codigoNacimiento=$_POST["codigoNacimiento"];
                         $prop=$_POST["prop"];
                        echo obteneDatosNacimientoPrint($id,$codigoNacimiento,$prop);
                }else if($_POST["opc"]=="getInsPrint"){
                         $id=$_POST["codigo"];
                         $codigoInscripcion=$_POST["codigoInscripcion"];
                         $prop=$_POST["prop"];
                        echo obteneDatosInscripcionPrint($id,$codigoInscripcion,$prop);
                }else if($_POST["opc"]=="resSession"){

                        $retorno=new Resultado();
                        
                        $resenas=json_decode($_POST["data"]);
                       
                       
                        $result=  setResenas($resenas);
                       //print_r($resenas); 
                             if($result!=""){                    
                                 $retorno->result=1;
                                 $retorno->html=$result;
                                 $retorno->data = $resenas;
                                 //$retorno->html= listarPreEntidad($origen);
                             }else{
                                 $retorno->result=1;
                                 $retorno->message="No hay items para registrar";
                             }
                           
                            
                       echo json_encode($retorno);
                             //echo $result;
                       
                    }else if($_POST["opc"]=="lstItemsSel"){
                       $codigo=$_POST["codigo"];
                       $descripcion="";//$_POST["descripcion"];
                       $resenias = json_decode($_POST['arrayResenias'],true);
                       $tipo=$_POST['tipo'];
                       echo listarComboReseniasRight($codigo,$descripcion,$resenias,$tipo);

                    }else if($_POST["opc"]=="clsSesionResena"){
                        echo clsSessionResena();
                }else if($_POST["opc"]=="lstEcu"){
                        $retorno=validateToken($token);
                        if($retorno->result==1){
                        $idProp = $_POST["idProp"];
                            echo listarMiPropiedad($idProp);
                        }else{
                            header("HTTP/1.1 200 OK");
                            echo json_encode($retorno);
                        }
                }else if($_POST["opc"]=="lstNov"){
                        $idProp = $_POST["idProp"];
                        //$retorno=validateToken($token);
                        //if($retorno->result==1){
                            echo listarNovedades($idProp);
                        /*}else{
                            header("HTTP/1.1 200 OK");
                            echo json_encode($retorno);
                        }*/
                }else if($_POST["opc"]=="lstLogMonta"){
                        $idProp= $_POST["idProp"];
                        echo listarNotificaciones($idProp);
                }else if($_POST["opc"]=="aproMonta"){
                        $idMonta= $_POST["idMonta"];
                        $idProp= $_POST["idProp"];
                        $retorno=validateToken($token);
                        if($retorno->result==1){
                            echo aprobarMonta($idMonta,$idProp);
                        }else{
                            header("HTTP/1.1 200 OK");
                            echo json_encode($retorno);
                        }
                }else if($_POST["opc"]=="rechMonta"){
                        $idMonta= $_POST["idMonta"];
                        $idProp= $_POST["idProp"];
                        $retorno=validateToken($token);
                        if($retorno->result==1){
                            echo rechazarMonta($idMonta,$idProp);
                        }else{
                            header("HTTP/1.1 200 OK");
                            echo json_encode($retorno);
                        }
                }else if($_POST["opc"]=="getTextoIns"){
                        $id = $_POST["id"];
                        $flag = $_POST["flag"];
                        echo getTextoInscripcionPopup($id,$flag);
                }else if($_POST["opc"]=="valStatus"){
                        $id = $_POST["id"];
                        $flag = $_POST["flag"];
                        echo valStatus($id,$flag);
                }else if($_POST["opc"]=="saveTrans"){
                        $ejemplar = $_POST["ejemplar"];
                        $newPropietario = $_POST["newPropietario"];
                        $fechaTrans = $_POST["fechaTrans"];
                        $comentario = $_POST["comentario"];
                        $idProp = $_POST["idProp"];
                        echo saveTransferencia($ejemplar,$newPropietario,$fechaTrans,$comentario,$idProp);
                }else if($_POST["opc"]=="lstMov"){
                        $idProp = $_POST["idProp"];
                        echo listarMovimiento($idProp);
                }else if($_POST["opc"]=="delMov"){
                        $id = $_POST["id"];
                        echo deleteMovimiento($id);
                }else if($_POST["opc"]=="saveNewProp"){
                        $tipoDoc = $_POST["tipoDoc"];
                        $numDoc = $_POST["numDoc"];
                        $nombre = $_POST["nombre"];
                        $apePat = $_POST["apePat"];
                        $apeMat = $_POST["apeMat"];
                        $direccion = $_POST["direccion"];
                        $correo = $_POST["correo"];
                        $idProp = $_POST["idProp"];
                        echo saveNewPropietario($tipoDoc,$numDoc,$nombre,$apePat,$apeMat,$direccion,$correo,$idProp);
                }else if($_POST["opc"]=="insF"){
                        $idEjemplar = $_POST["idEjemplar"];
                        $fechaF = $_POST["fecha"];
                        $idProp = $_POST["idUser"];
                        echo saveFallecimiento($idEjemplar,$fechaF,$idProp);
                }else if($_POST["opc"]=="lstHistF"){
                        $idProp = $_POST["idProp"];
                        echo listarHistorialF($idProp);
                }else if($_POST["opc"]=="delFac"){
                        $id = $_POST["id"];
                        echo deleteFallecimiento($id);
                }else{
                     $var=new stdClass();
                     $var->resultado="REQUEST_METHOD NOT FOUND POST****";
                     header("HTTP/1.1 200  OK");

                    echo json_encode($var);
                }
     
            }

             function validarKey($api_key)
             {
                if($api_key=="123456"){
                    return 1;
                }else{
                 return 0;
                }
                
             }
    

          function insertarINS($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$usuario_crea,$genero,$fecCapado,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$arrayResenias,$codigoGenerado){
                $retorno=new Resultado(); 
                $retorno->validateTOKEN="1";
                if(validarSesion($retorno)->result==1){      
                  $ins = new EjemplarLogica();

                  $datos=$arrayResenias;
                      if(is_array($datos)){
                        foreach ($datos as $key => $value) {
                              $codResenas[]= $value['id'];
                        }
                      }
                     // print_r($codResenas);
                $resenias=$codResenas;
             
         
                $propietarios="";//listPropietarios();
                $criadores="";//listCriadores();

                $response = $ins->insertarINS($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$usuario_crea,$genero,$fecCapado,$propietarios,$criadores,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado);
                
                if ($response->result == 1){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
                }else if ($response->result == 0){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
                }/*else if ($response->result == 2){
                    $retorno->result=0;
                    $retorno->message = "El ejemplar ya existe";
                }else if($response->result==3){
                    $retorno->result=0;
                    $retorno->message="No se puede repetir el número de libro con el númuero de folio";
                }else if($response->result==4){
                    $retorno->result=0;
                    $retorno->message=Constantes::K_MENSAJE_NOOK_CRIADOR;
                }else if($response->result==5){
                    $retorno->result=0;
                    $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE;                    
                }else if($response->result==6){
                    $retorno->result=0;
                    $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE_ERROR;                    
                            
                }*/else if($response->result==999){
                    $retorno->result=0;
                    $retorno->message=Constantes::K_MENSAJE_PREF_NOMBRE_DUPLICATE;                    
                            
                }else if($response->result==998){
                    $retorno->result=0;
                    $retorno->message=Constantes::K_MENSAJE_NOMBRE_SUPER_CAMP;                    
                }else{
                            $retorno->result=2;
                            $retorno->message = "Ingrese el nombre del ejemplar.";

                }
        }
            return json_encode($retorno);
    }
            function listarInscripcion($prop,$estado,$situacion){
                     $retorno=new Resultado();
                     $servicio = new EjemplarLogica();
                     $retorno=new Resultado(); 
                     $retorno->validateTOKEN="1";
                      $retorno->message=Constantes::K_MENSAJE_SELECT_NOOK;
                     if(validarSesion($retorno)->result==1){    
                        $retorno->data=$servicio->listarInscripcionINS($prop,$estado,$situacion);
                        $retorno->cantidad=sizeof($retorno->data);
                        $retorno->message=Constantes::K_MENSAJE_SELECT_OK;
                      }

                      return json_encode( $retorno);
                };

             function getEstadosLogInscripcion($id){
              $retorno=new Resultado();
              $obj=new  EjemplarLogica();
              $result=$obj->getEstadosLogInscripcion($id);

                          $retorno->result=1;
                          $retorno->message ="Cargo correctamente la data";
                          $retorno->data=$result;


              return json_encode($retorno);
          }

          function getEstadosLogNacimiento($id){
              $retorno=new Resultado();
              $obj=new  EjemplarLogica();
              $result=$obj->getEstadosLogNacimiento($id);

                          $retorno->result=1;
                          $retorno->message ="Cargo correctamente la data";
                          $retorno->data=$result;


              return json_encode($retorno);
          }

        function getInscripcion($id){
             $retorno=new Resultado();
             $servicio = new EjemplarLogica();
             $retorno=new Resultado(); 
             $retorno->validateTOKEN="1";
             $retorno->message=Constantes::K_MENSAJE_SELECT_NOOK;
             if(validarSesion($retorno)->result==1){    
                $obj = new EjemplarLogica();   
                   $result=$obj->obtenerSolINS($id);
                   //$retorno->data=$servicio->obtenerSolINS($id);
                       $result->idResenias=unserialize($result->idResenias);
            

                   if($result->idResenias!=null){
                    $res=$result->idResenias;
                    // unset($_SESSION['_datosRes']);
                    foreach ($res as $key => $resenas) {
                       // echo $key."gg".$resenas."<br>";
                          $get = new ResenaLogica();
                          $re=$get->obtenerID($resenas);
                           $list[]=array('id'=>$resenas,
                                                            'descripcion'=>$re->descripcion,
                                                             'tipo'=>$re->tipo
                                                             );
                             $resenastxt=$resenastxt." ".$re->descripcion;
                        } 
                            //echo "<pre>";
                            //print_r($_SESSION);
                          // echo "</pre>";
                      //echo $resenastxt."ff";
                   }

                    if(is_null($result)){
                                $retorno->result=0;
                                $retorno->message="No se encontro datos";
                    }else{
                              $retorno->data=$result;
                              $retorno->cantidad=0;
                              $retorno->message=Constantes::K_MENSAJE_SELECT_OK;
                              $result->resenasDescripcion=$resenastxt."";
                              $result->listResenas = $list;
                    }






                $retorno->cantidad=0;
                $retorno->message=Constantes::K_MENSAJE_SELECT_OK;
              }

              return json_encode( $retorno);
        };



      function updateIns($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$arrayResenias,$codigoGenerado){
              $retorno=new Resultado(); 
              $retorno->validateTOKEN="1";
              if(validarSesion($retorno)->result==1){      
                $ins = new EjemplarLogica();

                $datos=$arrayResenias;
                      if(is_array($datos)){
                        foreach ($datos as $key => $value) {
                              $codResenas[]= $value['id'];
                        }
                      }
                     // print_r($codResenas);
                $resenias=$codResenas;
             
             
                    $propietarios="";//listPropietarios();
                    $criadores="";//listCriadores();

                    $response = $ins->editarINS($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado);
                    
                    if ($response->result == 1){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
                    }else if ($response->result == 0){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
                    }/*else if ($response->result == 2){
                        $retorno->result=0;
                        $retorno->message = "El ejemplar ya existe";
                    }else if($response->result==3){
                        $retorno->result=0;
                        $retorno->message="No se puede repetir el número de libro con el númuero de folio";
                    }else if($response->result==4){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_NOOK_CRIADOR;
                    }else if($response->result==5){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE;                    
                    }else if($response->result==6){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE_ERROR;                    
                                
                    }*/else if($response->result==999){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_PREF_NOMBRE_DUPLICATE;                    
                                
                    }else if($response->result==998){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_NOMBRE_SUPER_CAMP;                    
                    }else{
                                $retorno->result=2;
                                $retorno->message = "Ingrese el nombre del ejemplar.";

                    }
        }
            return json_encode($retorno);
    }

          function eliminarINS($codigo){
                    $retorno=new Resultado();
                    $objDel = new EjemplarLogica();
                   //if(validarSesion($retorno)->result==1){   
                    $response = $objDel->eliminarINS($codigo);
                    //$retorno->validateTOKEN="1";
                    //echo $result;
                    if ($response->result == 1){
                        $retorno->result=1;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
                    }else if($response->result == 2){
                        $retorno->result=2;
                        //$retorno->data=$objDel->getCodInsbyCodNac($codigo);
                        $retorno->message = 'No se puede eliminar una solicitud de nacimiento porque se encuentra aprobada';
                    }else if($response->result == 995){
                        $retorno->result=995;
                        $retorno->message = 'No se puede eliminar una solicitud de inscripcion en proceso';
                    }else{
                        $retorno->result=995;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
                    }
              //  }

                return json_encode($retorno);

            }

         function listarNacimientoNac($prop,$estado,$situacion){
                     $retorno=new Resultado();
                     $servicio = new EjemplarLogica();
                     $retorno=new Resultado(); 
                     $retorno->validateTOKEN="1";
                      $retorno->message=Constantes::K_MENSAJE_SELECT_NOOK;
                     if(validarSesion($retorno)->result==1){    
                        $retorno->data=$servicio->listarNacimientoNac($prop,$estado,$situacion);
                        $retorno->cantidad=sizeof($retorno->data);
                        $retorno->message=Constantes::K_MENSAJE_SELECT_OK;
                      }

                      return json_encode( $retorno);
                };  



            function insertarNAC($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuario_crea,$fecCapado,$idMonta,$idProvincia,$origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$arrayResenias,$codigoGenerado){
              $retorno=new Resultado(); 
              $retorno->validateTOKEN="1";
              if(validarSesion($retorno)->result==1){      
                $ins = new EjemplarLogica();
                
                //echo $arrayResenias;
                //print_r($arrayResenias);
                $datos=$arrayResenias;
                      if(is_array($datos)){
                        foreach ($datos as $key => $value) {
                              $codResenas[]= $value['id'];
                        }
                      }
                     // print_r($codResenas);
                $resenias=$codResenas;
             
                    $propietarios="";//listPropietarios();
                    $criadores="";//listCriadores();

                    $response = $ins->insertarNAC($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuario_crea,$fecCapado,$idMonta,$idProvincia,$origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado);
                    
                    if ($response->result == 1){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
                    }else if ($response->result == 0){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
                    }/*else if ($response->result == 2){
                        $retorno->result=0;
                        $retorno->message = "El ejemplar ya existe";
                    }else if($response->result==3){
                        $retorno->result=0;
                        $retorno->message="No se puede repetir el número de libro con el númuero de folio";
                    }else if($response->result==4){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_NOOK_CRIADOR;
                    }else if($response->result==5){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE;                    
                    }else if($response->result==6){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE_ERROR;                    
                                
                    }*/else if($response->result==999){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_PREF_NOMBRE_DUPLICATE;                    
                                
                    }else if($response->result==998){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_NOMBRE_SUPER_CAMP;                    
                    }else{
                                $retorno->result=2;
                                $retorno->message = "Ingrese el nombre del ejemplar.";

                                  }
                      }
                          return json_encode($retorno);
                    }

              function obtenerNAC($id){
               $retorno=new Resultado();
               //$obj = new EjemplarLogica();
               $retorno->validateTOKEN="1";
               $retorno->message=Constantes::K_MENSAJE_SELECT_NOOK;
               if(validarSesion($retorno)->result==1){ 
               $obj = new EjemplarLogica();   
                   $result=$obj->obtenerNAC($id);
                   $result->idResenias=unserialize($result->idResenias);
            

                   if($result->idResenias!=null){
                    $res=$result->idResenias;
                    // unset($_SESSION['_datosRes']);
                    foreach ($res as $key => $resenas) {
                       // echo $key."gg".$resenas."<br>";
                          $get = new ResenaLogica();
                          $re=$get->obtenerID($resenas);
                           $list[]=array('id'=>$resenas,'descripcion'=>$re->descripcion,'tipo'=>$re->tipo);
                             $resenastxt=$resenastxt." ".$re->descripcion;
                        } 
                            //echo "<pre>";
                            //print_r($_SESSION);
                          // echo "</pre>";
                      //echo $resenastxt."ff";
                   }

                    if(is_null($result)){
                                $retorno->result=0;
                                $retorno->message="No se encontro datos";
                    }else{
                              $retorno->data=$result;
                              $retorno->cantidad=0;
                              $retorno->message=Constantes::K_MENSAJE_SELECT_OK;
                              $result->resenasDescripcion=$resenastxt."";
                              $result->listResenas = $list;
                    }
                }

                return json_encode( $retorno);
          };


            function obtenerDatosMonta($id){
              $retorno=new Resultado();
              $obj=new  EjemplarLogica();
              $result=$obj->obtenerDatosMonta($id);

                          $retorno->result=1;
                          $retorno->message ="Cargo correctamente la data";
                          $retorno->data=$result;


              return json_encode($retorno);
          }
          function updateNac($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$arrayResenias,$codigoGenerado){
          $retorno=new Resultado(); 
          $retorno->validateTOKEN="1";
          if(validarSesion($retorno)->result==1){      
            $ins = new EjemplarLogica();

           //$datos=$_SESSION['_datosRes'];
               // echo"<pre>"; print_r($datos);echo"</pre>";
                $i=0;
                 $datos=$arrayResenias;
                if(is_array($datos)){
                        foreach ($datos as $key => $value) {
                            $codResenas[]= $value['id'];
                            $i++;
                        }
                }
                $resenias=$codResenas;
         
                if($i==0){
                 $resultOriginal = $ins->obtenerNAC($codigo);
                 $resenias=unserialize($resultOriginal->idResenias);
                }

                $propietarios="";//listPropietarios();
                $criadores="";//listCriadores();

                $response = $ins->editarNAC($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$arrayResenias,$codigoGenerado);
                
                if ($response->result == 1){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
                }else if ($response->result == 0){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
                }/*else if ($response->result == 2){
                    $retorno->result=0;
                    $retorno->message = "El ejemplar ya existe";
                }else if($response->result==3){
                    $retorno->result=0;
                    $retorno->message="No se puede repetir el número de libro con el númuero de folio";
                }else if($response->result==4){
                    $retorno->result=0;
                    $retorno->message=Constantes::K_MENSAJE_NOOK_CRIADOR;
                }else if($response->result==5){
                    $retorno->result=0;
                    $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE;                    
                }else if($response->result==6){
                    $retorno->result=0;
                    $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE_ERROR;                    
                            
                }*/else if($response->result==999){
                    $retorno->result=0;
                    $retorno->message=Constantes::K_MENSAJE_PREF_NOMBRE_DUPLICATE;                    
                            
                }else if($response->result==998){
                    $retorno->result=0;
                    $retorno->message=Constantes::K_MENSAJE_NOMBRE_SUPER_CAMP;                    
                }else{
                            $retorno->result=2;
                            $retorno->message = "Ingrese el nombre del ejemplar.";

                      }
          }
              return json_encode($retorno);
      }

          function eliminarNAC($codigo){
                    $retorno=new Resultado();
                    $objDel = new EjemplarLogica();
                   //if(validarSesion($retorno)->result==1){   
                    $response = $objDel->eliminarNAC($codigo);
                    //$retorno->validateTOKEN="1";
                    //echo $result;
                    if ($response->result == 1){
                        $retorno->result=1;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
                    }/*else if($response->result == 995){
                        $retorno->result=995;
                        //$retorno->data=$objDel->getCodInsbyCodNac($codigo);
                        $retorno->message = Constantes::K_MENSAJE_VALIDADOR_NAC_INS;
                    }*/else if($response->result == 2){
                        $retorno->result=2;
                        //$retorno->data=$objDel->getCodInsbyCodNac($codigo);
                        $retorno->message = 'No se puede eliminar una solicitud de nacimiento porque se encuentra aprobada';
                    }else{
                        $retorno->result=0;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
                    }
              //  }

                return json_encode($retorno);

            }
        function obtenerDatosNacimientoEjemplar($id){
              $retorno=new Resultado();
              $obj=new  EjemplarLogica();
              $retorno->validateTOKEN="1";
              $result=$obj->obtenerDatosNacimientoEjemplar($id);
              $result->idResenias=unserialize($result->idResenias);
            

                   if($result->idResenias!=null){
                    $res=$result->idResenias;
                    // unset($_SESSION['_datosRes']);
                    foreach ($res as $key => $resenas) {
                       // echo $key."gg".$resenas."<br>";
                          $get = new ResenaLogica();
                          $re=$get->obtenerID($resenas);
                           $list[]=array('id'=>$resenas,
                                                            'descripcion'=>$re->descripcion,'tipo'=>$re->tipo
                                                             );
                             $resenastxt=$resenastxt." ".$re->descripcion;
                        } 
                            //echo "<pre>";
                            //print_r($_SESSION);
                          // echo "</pre>";
                      //echo $resenastxt."ff";
                   }
              
                          $retorno->result=1;
                          $retorno->message ="Cargo correctamente la data";
                          $retorno->data=$result;
                          $result->resenasDescripcion=$resenastxt."";
                          $result->listResenas = $list;
                         

              return json_encode($retorno);
         }


         function listarComboReseniasRight($codigo,$descripcion,$resenias,$tipo){
      //unset($_SESSION['_datosRes']);
        $retorno=new Resultado();
        //$obj=new ResenaLogica();
        //$datos=$_SESSION['_datosRes'];
        $datos = $resenias;
        $i=0;
        if(is_array($datos)){
       foreach ($datos as $key => $value) {
                 $list[]=array('id'=>$value['id'],
                               'descripcion'=>$value['descripcion'],
                                'tipo'=>$value['tipo']
                                    );
                 $i++;
                 }
        }
        /* addon dbs 20190901 */
            if($i==0){
                    $getEje = new EjemplarLogica();
                    $result = $getEje->obtenerNAC($codigo);

                if($result->idResenias!=""){
                    $result->idResenias=unserialize($result->idResenias);
                    if($result->idResenias!=null){
                        $get = new ResenaLogica();
                        foreach ($result->idResenias as $key => $resenas) {
                              $re=$get->obtenerID($resenas,$tipo);
                                 $list[]=array('id'=>$resenas,
                                                                'descripcion'=>$re->descripcion,
                                                                'tipo'=>$re->tipo
                                                                 );
                        } 
                    }
                }   
        }

                    $retorno->result=1;
                    $retorno->message = "OK";
                    $retorno->data=$list;

        return json_encode($retorno);
    }

         function setResenas($resenas){
        
        $resenastxt="";

       foreach ($resenas as $key => $resenas) {
                             
                             $resenastxt=$resenastxt.$resenas->descripcion." ";
                        }  
                      //  print_r($_SESSION['_datosRes']);

                   return  $resenastxt;
        }

         /*function clsSessionResena(){
          unset($_SESSION['_datosRes']);
          return "1";
         }*/

        function listarServicioY($idPoe,$idProp){
                     $retorno=new Resultado();
                     $servicio = new EjemplarLogica();
                     $retorno=new Resultado(); 
                     $retorno->validateTOKEN="1";
                      $retorno->message=Constantes::K_MENSAJE_SELECT_NOOK;
                     if(validarSesion($retorno)->result==1){    
                        $retorno->data=$servicio->listarServicioY($idPoe,$idProp);
                        $retorno->cantidad=sizeof($retorno->data);
                        $retorno->message=Constantes::K_MENSAJE_SELECT_OK;
                      }

                      return json_encode( $retorno);
                };  
      function insertarMonta($padre,$madre,$idProp,$idPoe,$fecMonta,$fecParir,$metodo,$isTE,$idTextoRec,$fecEmbrion){
               $retorno=new Resultado(); 
              $retorno->validateTOKEN="1";
              if(validarSesion($retorno)->result==1){      
                $ins = new EjemplarLogica();

                    $response = $ins->insertarMonta($padre,$madre,$idProp,$idPoe,$fecMonta,$fecParir,$metodo,$isTE,$idTextoRec,$fecEmbrion);

                    if ($response->result == 1){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
                    }else if ($response->result == 0){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
                    }/*else if ($response->result == 2){
                        $retorno->result=0;
                        $retorno->message = "El ejemplar ya existe";
                    }else if($response->result==3){
                        $retorno->result=0;
                        $retorno->message="No se puede repetir el número de libro con el númuero de folio";
                    }else if($response->result==4){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_NOOK_CRIADOR;
                    }else if($response->result==5){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE;                    
                    }else if($response->result==6){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE_ERROR;                    
                                
                    }*/else if($response->result==999){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_PREF_NOMBRE_DUPLICATE;                    
                                
                    }else if($response->result==998){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_NOMBRE_SUPER_CAMP;                    
                    }else{
                                $retorno->result=2;
                                $retorno->message = "Ingrese el nombre del ejemplar.";

                                  }
                      }
                          return json_encode($retorno);
      }


      function obteneDatosServicioMonta($id){
              $retorno=new Resultado();
              $obj=new  EjemplarLogica();
              $retorno->validateTOKEN="1";
              $result=$obj->obteneDatosServicioMonta($id);

                          $retorno->result=1;
                          $retorno->message ="Cargo correctamente la data";
                          $retorno->data=$result;


              return json_encode($retorno);
         }


         function editarMonta($codigo,$padre,$madre,$idProp,$idPoe,$fecMonta,$fecParir,$metodo,$isTE,$idTextoRec,$fecEmbrion){
               $retorno=new Resultado(); 
              $retorno->validateTOKEN="1";
              if(validarSesion($retorno)->result==1){
                $ins = new EjemplarLogica();

                    $response = $ins->editarMonta($codigo,$padre,$madre,$idProp,$idPoe,$fecMonta,$fecParir,$metodo,$isTE,$idTextoRec,$fecEmbrion);
                    
                    if ($response->result == 1){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
                    }else if ($response->result == 0){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
                    }/*else if ($response->result == 2){
                        $retorno->result=0;
                        $retorno->message = "El ejemplar ya existe";
                    }else if($response->result==3){
                        $retorno->result=0;
                        $retorno->message="No se puede repetir el número de libro con el númuero de folio";
                    }else if($response->result==4){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_NOOK_CRIADOR;
                    }else if($response->result==5){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE;                    
                    }else if($response->result==6){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE_ERROR;                    
                                
                    }*/else if($response->result==999){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_PREF_NOMBRE_DUPLICATE;                    
                                
                    }else if($response->result==998){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_NOMBRE_SUPER_CAMP;                    
                    }else{
                                $retorno->result=2;
                                $retorno->message = "Ingrese el nombre del ejemplar.";

                                  }
                      }
                          return json_encode($retorno);
      }


            function eliminarServicioy($codigo){
                    $retorno=new Resultado();
                    $objDel = new EjemplarLogica();
                   //if(validarSesion($retorno)->result==1){   
                    $response = $objDel->eliminarServicioy($codigo);
                    //$retorno->validateTOKEN="1";
                   // echo $result;
                    if ($response->result == 1){
                        $retorno->result=1;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
                    }else if($response->result == 995){
                        $retorno->result=995;
                        $retorno->data=$objDel->getCodNacbyCodMonta($codigo);
                        $retorno->message = Constantes::K_MENSAJE_VALIDADOR_MONTA_NAC;
                    }else if($response->result == 0){
                        $retorno->result=0;
                        $retorno->message = "No se puede eliminar una monta confirmada o rechazada";
                    }
                
              //  }

                return json_encode($retorno);

            }

            function getADN($codigo){
                     $retorno=new Resultado();
                      $obj=new  EjemplarLogica();
                      $retorno->validateTOKEN="1";
                      $result=$obj->getADN($codigo);

                          $retorno->result=1;
                          $retorno->message ="Cargo correctamente la data";
                          $retorno->data=$result;


              return json_encode($retorno);
          }

          function insertEjemplarExtranjero($codigo,$nombre,$prefijo,$fecNace,$idPelaje,$idPais,$genero){
                    $retorno=new Resultado(); 
              $retorno->validateTOKEN="1";
              if(validarSesion($retorno)->result==1){      
                $ins = new EjemplarLogica();

                    $response = $ins->insertEjemplarExtranjero($codigo,$nombre,$prefijo,$fecNace,$idPelaje,$idPais,$genero);
                    
                    if ($response->result == 1){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
                    }else if ($response->result == 0){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
                    }/*else if ($response->result == 2){
                        $retorno->result=0;
                        $retorno->message = "El ejemplar ya existe";
                    }else if($response->result==3){
                        $retorno->result=0;
                        $retorno->message="No se puede repetir el número de libro con el númuero de folio";
                    }else if($response->result==4){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_NOOK_CRIADOR;
                    }else if($response->result==5){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE;                    
                    }else if($response->result==6){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE_ERROR;                    
                                
                    }*/else if($response->result==999){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_PREF_NOMBRE_DUPLICATE;                    
                                
                    }else if($response->result==998){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_NOMBRE_SUPER_CAMP;                    
                    }else{
                                $retorno->result=2;
                                $retorno->message = "Ingrese el nombre del ejemplar.";

                                  }
                      }
                          return json_encode($retorno);
          }

          function getLastInsertMonta(){
             $retorno=new Resultado();
                      $obj=new  EjemplarLogica();
                      $retorno->validateTOKEN="1";
                      $result=$obj->getLastInsertMonta();

                          $retorno->result=1;
                          $retorno->message ="Cargo correctamente la data";
                          $retorno->data=$result;


              return json_encode($retorno);
          }
          function getLastInsertNac( ){
             $retorno=new Resultado();
                      $obj=new  EjemplarLogica();
                      $retorno->validateTOKEN="1";
                      $result=$obj->getLastInsertNac();

                          $retorno->result=1;
                          $retorno->message ="Cargo correctamente la data";
                          $retorno->data=$result;


              return json_encode($retorno);
          }
          
         /*function insertLogInscripcion($idProp){
              $retorno=new Resultado(); 
              $retorno->validateTOKEN="1";
                $ins = new EjemplarLogica();

                    $response = $ins->insertLogInscripcion($idProp);
                    if ($response->result == 1){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
                    }else if ($response->result == 0){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
                    }else if ($response->result == 2){
                        $retorno->result=0;
                        $retorno->message = "El ejemplar ya existe";
                    }else if($response->result==3){
                        $retorno->result=0;
                        $retorno->message="No se puede repetir el número de libro con el númuero de folio";
                    }else if($response->result==4){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_NOOK_CRIADOR;
                    }else if($response->result==5){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE;                    
                    }else if($response->result==6){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE_ERROR;                    
                                
                    }else if($response->result==999){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_PREF_NOMBRE_DUPLICATE;                    
                                
                    }else if($response->result==998){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_NOMBRE_SUPER_CAMP;                    
                    }else{
                                $retorno->result=2;
                                $retorno->message = "Ingrese el nombre del ejemplar.";

                                  }
                      
                          return json_encode($retorno);
         }*/
        function getLastInsertIns(){
             $retorno=new Resultado();
                      $obj=new  EjemplarLogica();
                      $retorno->validateTOKEN="1";
                      $result=$obj->getLastInsertIns();

                          $retorno->result=1;
                          $retorno->message ="Cargo correctamente la data";
                          $retorno->data=$result;


              return json_encode($retorno);
          }

          function obteneDatosServicioMontaPrint($id,$codigoMonta,$prop){
              $retorno=new Resultado();
              $obj=new  EjemplarLogica();
              $retorno->validateTOKEN="1";
              $retorno->data=$obj->obteneDatosServicioMontaPrint($id,$codigoMonta,$prop);

                          $retorno->result=1;
                          $retorno->message ="Cargo correctamente la data";
                         /* $retorno->data=$result;*/


              return json_encode($retorno);
         }

          function obteneDatosNacimientoPrint($id,$codigoNacimiento,$prop){
              $retorno=new Resultado();
              $obj=new  EjemplarLogica();
              $retorno->validateTOKEN="1";
              //$retorno->data=$obj->obteneDatosNacimientoPrint($id,$codigoNacimiento,$prop);
              $result=$obj->obteneDatosNacimientoPrint($id,$codigoNacimiento,$prop);

              foreach ($result as $key => $value) {
                  $data = unserialize($value->idResenias); 

                  foreach ($data as $key => $resenas) {
                      $get = new ResenaLogica();
                          $re=$get->obtenerID($resenas);
                             $resenastxt=$resenastxt." ".$re->descripcion;
                  }

              }

                               $retorno->data=$result;
                               $retorno->result=1;
                                $retorno->message ="Cargo correctamente la data";
                                $retorno->html=$resenastxt."";

              return json_encode($retorno);
         }

           function obteneDatosInscripcionPrint($id,$codigoInscripcion,$prop){
              $retorno=new Resultado();
              $obj=new  EjemplarLogica();
              $retorno->validateTOKEN="1";
              //$retorno->data=$obj->obteneDatosNacimientoPrint($id,$codigoNacimiento,$prop);
              $result=$obj->obteneDatosInscripcionPrint($id,$codigoInscripcion,$prop);

              foreach ($result as $key => $value) {
                  $data = unserialize($value->idResenias); 

                  foreach ($data as $key => $resenas) {
                      $get = new ResenaLogica();
                          $re=$get->obtenerID($resenas);
                             $resenastxt=$resenastxt." ".$re->descripcion;
                  }

              }

                               $retorno->data=$result;
                               $retorno->result=1;
                                $retorno->message ="Cargo correctamente la data";
                                $retorno->html=$resenastxt."";

              return json_encode($retorno);
         }
            
            function listarMiPropiedad($idProp){
                $retorno = new Resultado();
                $obj = new EjemplarLogica();
                $retorno->validateTOKEN="1";
                if(validarSesion($retorno)->result==1){    
                   $retorno->data=$obj->listarMiPropiedad($idProp);
                   $retorno->cantidad=sizeof($retorno->data);
                   $retorno->message="Cargo correctamente la data";
                }

                return json_encode($retorno);

            }

            function listarNovedades($idProp){
                $retorno = new Resultado();
                $obj = new EjemplarLogica();
                $retorno->validateTOKEN="1";
                if(validarSesion($retorno)->result==1){    
                   $retorno->data=$obj->listarNovedades($idProp);
                   $retorno->cantidad=sizeof($retorno->data);
                }

                return json_encode($retorno);
            }






            /* function listarLogMonta($idProp){
                $retorno = new Resultado();
                $obj = new EjemplarLogica();
                $retorno->validateTOKEN="1";
                $retorno->message=Constantes::K_MENSAJE_SELECT_NOOK;
                if(validarSesion($retorno)->result==1){    
                   $retorno->data=$obj->listarLogMonta($idProp);
                   $retorno->cantidad=sizeof($retorno->data);
                   $retorno->message=Constantes::K_MENSAJE_SELECT_OK;
                }

                return json_encode($retorno);
            }*/



            function listarNotificaciones($idProp){
                $retorno = new Resultado();
                $obj = new EjemplarLogica();
                $retorno->validateTOKEN="1";
                $contador=0;
                $retorno->message=Constantes::K_MENSAJE_SELECT_NOOK;
                if(validarSesion($retorno)->result==1){    
                   $result=$obj->listarNotificaciones($idProp);

                    foreach ($result as $key => $value) {
                        if(strlen($value->mensaje)==0){
                            $contador++;
                        }
                    }
                    $cantNoti=sizeof($result)-$contador;
                    

                     $html.=" <table class='table table-sm'  >";
                     $html.="<thead>";
                     $html.="<tr>";
                     $html.="<th scope='col' colspan='12'><span style='background-color:#dc3545;font-size:10px;' class='badge badge-danger'>".$cantNoti."</span>&nbsp;Notificaciones para socio</th>";
                     $html.="</tr>";
                     $html.="<tr>";
                     $html.="<th scope='col'>#</th>";
                     $html.="<th scope='col'colspan='4'>Mensaje</th>";
                     $html.="<th scope='col' colspan='3' style='text-align:right;'>Fecha</th>";
                     $html.="<th scope='col' colspan='4'  style='text-align:center;'>Acción</th>";
                     $html.="</tr>";
                     $html.="</thead>";
                     $html.="</table>";
                     $html.="<div  style='overflow:scroll;height:115px;'>";
                     $html.="<table >";
                     
                    if(is_array($result)){
                    foreach ($result as $key => $value) {
                        if(strlen($value->mensaje)>0){
                     $numero++;
                     $mensaje=$value->mensaje;
                     $html.="<tr>";
                     $html.="<th scope='row'>".$numero."</th>";
                     $html.="<td colspan='4' data-toggle='tooltip' style=' cursor:pointer;'  title='". $mensaje."' onclick='popupDetalle(".$value->codigo.",".$value->idPropPotro.",".$value->flag.")'><marquee SCROLLDELAY =180>".$mensaje." </marquee></td>";
                     $html.="<td colspan='2' style='padding-right: 60px;padding-left: 20px;'>".$value->fecCreacion."</td>";
                     if($value->flag =='1' ){
                     $html.="<td colspan='2'  >";
                     $html.="<a data-toggle='tooltip'  style='color: green; cursor:pointer;padding-right:10px;' title='Aprobar registro de monta' value=".$value->codigo."  onclick='aprobarMonta(".$value->codigo.",".$value->idPropPotro.",0);'>Aprobar</a>";
                     $html.="<a data-toggle='tooltip'  style='color: red;cursor:pointer;padding-right:15px;' title='Rechazar registro de monta' value=".$value->codigo."  onclick='rechazarMonta(".$value->codigo.",".$value->idPropPotro.",0);'>Rechazar</a>";
                     $html.="</td>";
                    }else {

                    }
                     $html.="</tr>";
                    }
                    }

                   }
                   $html.="</table>";
                   $html.="</div>";

                   $retorno->result=1;
                   $retorno->cantidad=sizeof($result);
                  // $retorno->cantidad=$numero;
                   $retorno->message=Constantes::K_MENSAJE_SELECT_OK;
                   $retorno->html=$html;
                   $retorno->data=$result;

                }

                return json_encode($retorno);
            }




            function aprobarMonta($idMonta,$idProp){
               $retorno=new Resultado(); 
              $retorno->validateTOKEN="1";
              if(validarSesion($retorno)->result==1){      
                $ins = new EjemplarLogica();

                    $response = $ins->aprobarMonta($idMonta,$idProp);
                    
                    if ($response->result == 1){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_NOTI_ACEP_OK;
                    }else if ($response->result == 0){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
                    
                      }
                  }
                          return json_encode($retorno);
             }


              function rechazarMonta($idMonta,$idProp){
               $retorno=new Resultado(); 
              $retorno->validateTOKEN="1";
              if(validarSesion($retorno)->result==1){      
                $ins = new EjemplarLogica();

                    $response = $ins->rechazarMonta($idMonta,$idProp);
                    
                    if ($response->result == 1){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_NOTI_REC_OK;
                    }else if ($response->result == 0){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
                    
                      }
                  }
                          return json_encode($retorno);
             }


             function getTextoInscripcionPopup($id,$flag){
                 $retorno=new Resultado(); 
              $retorno->validateTOKEN="1";
              if(validarSesion($retorno)->result==1){   
                $obj = new EjemplarLogica();
                    $retorno->html=$obj->getTextoInscripcionPopup($id,$flag);
                }

                return  json_encode($retorno);
             }

             function valStatus($id,$flag){
                 $retorno=new Resultado(); 
              $retorno->validateTOKEN="1";
              if(validarSesion($retorno)->result==1){   

                $obj = new EjemplarLogica();
                $response = $obj->valStatus($id,$flag);
               // print_r($response);
                if($response->result == 1){
                   // echo '1';
                    $retorno->result=$response->result;
                }else{
                  //  echo '0';
                    $retorno->result=$response->result;
                }
              }
               return json_encode($retorno);
             }

             function validateToken($paramToken){
                $retorno=new Resultado();
                    if($paramToken=="") {
                            $retorno->result=1;
                            $retorno->message='Debe especificar el token';
                    }else{
                        try {
                                $var=Auth::GetData($paramToken);
                                if(is_object($var)){
                                    $retorno->result=1;
                                    $retorno->message="TOKEN AUTORIZADO*****";
                                }else{
                                    $retorno->result=0;
                                    $retorno->message="*****TOKEN INCORRECTO";
                                }   
                        } catch (Exception $e) {
                                     $retorno->result=0;
                                    $retorno->message=$e->getMessage();
                        }
                    }
                return $retorno;
            }

            function saveTransferencia($ejemplar,$newPropietario,$fechaTrans,$comentario,$idProp){
                      $retorno=new Resultado(); 
                      $retorno->validateTOKEN="1";
                      if(validarSesion($retorno)->result==1){      
                        $ins = new EjemplarLogica();

                            $response = $ins->saveTransferencia($ejemplar,$newPropietario,$fechaTrans,$comentario,$idProp);
                            
                            if ($response->result == 1){
                                $retorno->result=$response->result;
                                $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
                            }else if ($response->result == 0){
                                $retorno->result=$response->result;
                                $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
                            }
                      }
                                  return json_encode($retorno);
            }

            function listarMovimiento($idProp){
                $retorno = new Resultado();
                $obj = new EjemplarLogica();
                $retorno->validateTOKEN="1";
                if(validarSesion($retorno)->result==1){    
                   $retorno->data=$obj->listarMovimiento($idProp);
                   $retorno->cantidad=sizeof($retorno->data);
                   $retorno->message="Cargo correctamente la data";
                   $retorno->pathWeb=ConstantesPathWeb::K_PATHWEB_TRANS_IMG;
                }

                return json_encode($retorno);

            }

            function deleteMovimiento($id){
                    $retorno=new Resultado();
                    $objDel = new EjemplarLogica();
                   //if(validarSesion($retorno)->result==1){   
                    $response = $objDel->deleteMovimiento($id);
                    //$retorno->validateTOKEN="1";
                    //echo $result;
                    if ($response->result == 1){
                        $retorno->result=1;
                        $retorno->message = Constantes::K_MENSAJE_DELETE_OK;
                    }else{
                        $retorno->result=0;
                        $retorno->message = Constantes::K_MENSAJE_DELETE_NOOK;
                    }
              //  }

                return json_encode($retorno);

            }

            function saveNewPropietario($tipoDoc,$numDoc,$nombre,$apePat,$apeMat,$direccion,$correo,$idProp){
                      $retorno=new Resultado(); 
                      $retorno->validateTOKEN="1";
                      $obj = new EjemplarLogica();
                      if(validarSesion($retorno)->result==1){      
                        
                        $retorno->data=$obj->saveNewPropietario($tipoDoc,$numDoc,$nombre,$apePat,$apeMat,$direccion,$correo,$idProp);
                        $retorno->message = Constantes::K_MENSAJE_INSERT_OK;    
                        
                        
                      }
                        
                      return json_encode($retorno);
            }

            function saveFallecimiento($idEjemplar,$fechaF,$idProp){
                      $retorno=new Resultado(); 
                      $retorno->validateTOKEN="1";
                      if(validarSesion($retorno)->result==1){      
                        $ins = new EjemplarLogica();

                            $response = $ins->saveFallecimiento($idEjemplar,$fechaF,$idProp);
                            
                            if ($response->result == 1){
                                $retorno->result=$response->result;
                                $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
                            }else if ($response->result == 0){
                                $retorno->result=$response->result;
                                $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
                            }
                      }
                return json_encode($retorno);
            }

            function listarHistorialF($idProp){
                $retorno = new Resultado();
                $obj = new EjemplarLogica();
                $retorno->validateTOKEN="1";
                if(validarSesion($retorno)->result==1){    
                   $retorno->data=$obj->listarHistorialF($idProp);
                   $retorno->cantidad=sizeof($retorno->data);
                   $retorno->message="Cargo correctamente la data";
                }

                return json_encode($retorno);

            }

            function deleteFallecimiento($id){
                    $retorno=new Resultado();
                    $objDel = new EjemplarLogica();
                   //if(validarSesion($retorno)->result==1){   
                    $response = $objDel->deleteFallecimiento($id);
                    //$retorno->validateTOKEN="1";
                    //echo $result;
                    if ($response->result == 1){
                        $retorno->result=1;
                        $retorno->message = Constantes::K_MENSAJE_DELETE_OK;
                    }else{
                        $retorno->result=0;
                        $retorno->message = Constantes::K_MENSAJE_DELETE_NOOK;
                    }
              //  }

                return json_encode($retorno);

            }
?>