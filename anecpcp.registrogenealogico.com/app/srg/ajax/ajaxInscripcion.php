<?php  session_start();
    include_once ("../logica/EjemplarLogicaF2.php");
    include_once ("../logica/PropietarioLogLogica.php");
    include_once ("../entidad/Ejemplar.inc.php");
    include_once ("../entidad/Resultado.inc.php");    
    include_once("../logica/ResenaLogica.php");
     include_once ("../comunes/lib.comun.php");    

    if (file_exists("../logica/ImagenInsLogica.php")) {  include_once ("../logica/ImagenInsLogica.php");}
    if (file_exists("../constante.php")) {   include_once ("../constante.php");}
 
   if (file_exists("../entidad/Constantes.php")) {        include_once("../entidad/Constantes.php");    }
   
 

    if(isset($_POST["opc"])){

     
        $usuario_crea = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $usuario_modi = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $codigo_empresa =0;
        $codigo_local = 0;
    
        
        if($_POST["opc"]=="lst"){
             $prefijo = $_POST["prefijo"];
             $nombre=addslashes($_POST["nombre"]);
             $fecNace=$_POST["fecNace"];
             $fecFallece=$_POST["fecFallece"]; 
             $idPelaje = $_POST["idPelaje"];
             $LugarNace=addslashes($_POST["LugarNace"]);
             $microchip=$_POST["microchip"];
             $adn=$_POST["adn"];
           
        echo  listarEjemplar($prefijo,$nombre,$fecNace,$fecFallece,$idPelaje,$LugarNace,$microchip,$adn);
             
            
        }else if($_POST["opc"]=="ins"){
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
           
               //print_r( $propie);
                echo insertar($codigoIns,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$arrayResenias,$codigoGenerado);
            
        }else if($_POST["opc"]=="upd"){
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
            $reseniaBasica = $_POST["reseniaBasica"];
            $idImgEliminacion = json_decode($_POST["arrayIdImg"], true);
            $idPdfEliminacion = json_decode($_POST["arrayIdPdf"], true);
            echo editar($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$arrayResenias,$codigoGenerado, $idImgEliminacion, $idPdfEliminacion, $reseniaBasica);
            

            
        } elseif($_POST["opc"]=="del"){
            $codigo = $_POST["key"];
            echo eliminarIns($codigo,$usuario_modi);
        } elseif($_POST["opc"]=="get"){
             $codigo = $_POST["codigo"];
            echo obtenerIDINS($codigo);
        }elseif($_POST["opc"]=="vdel"){
            echo validarEliminar($codigo);
        
        }elseif($_POST["opc"]=="delAll"){
            $codigo = $_POST["keys"];
            echo eliminarVarios($codigo,$usuario_modi);
        }else if($_POST["opc"]=="setEntSession"){

            $retorno=new Resultado();
            $codigo=$_POST["codigo"];
            $nombres=$_POST["nombre"];
           

           
                $result=  agregarEntidad($codigo,$nombres,$origen,$idProp);
                 if($result){                    
                     $retorno->result=1;
                     $retorno->html= listarPreEntidad($origen);
                 }else{
                     $retorno->result=0;
                 }
           echo json_encode($retorno);
           
        }else if($_POST["opc"]=="resSession"){

            $retorno=new Resultado();
            
            $resenas=json_decode($_POST["data"]);
           //print_r($resenas);
           
            $result=  setResenas($resenas);
            $resenasBasica = $_POST["reseniaBasica"];
            if ($result != "" && trim($resenasBasica) != "") {
                $retorno->result = 2;
                $retorno->valorA = $result;
                $retorno->data = $resenas;
                $retorno->valorB = $resenasBasica;
               // $retorno->message = "Se completado el reseña básica y reseña avanzada. ¿Desea que permanezca la reseña básica?";
            } else {
                if ($result != "") {
    
                    $retorno->result = 1;
                    $retorno->html = $result;
                    $retorno->data = $resenas;
                    $retorno->code=2;
                    //$retorno->html= listarPreEntidad($origen);
                } else if ($resenasBasica != "") {
                    $retorno->result = 1;
                    $retorno->html = $resenasBasica;
                    $retorno->data = "";
                    $retorno->code=1;
                    //$retorno->html= listarPreEntidad($origen);
                } else {
                    $retorno->result = 1;
                    $retorno->message = "No hay items para registrar";
                }
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
        }else if($_POST["opc"]=="lstMtdoReprop"){
           $id="0";//$_POST["codigo"];
           $descripcion="";//$_POST["descripcion"];
           echo listaComboMtdoReprop($id,$descripcion);
        }else if($_POST["opc"]=="val"){
            $fechaServ=$_POST["fecServ"];
            $fechaNac=$_POST["fecNace"];
            $idMadre=$_POST["idmadre"];
            $idHijo=$_POST["idHijo"];
                echo validarFecha($fechaServ,$fechaNac,$idMadre,$idHijo);    
        }else if($_POST["opc"]=="lstTipoDoc"){
            echo listarTipoDocumento();
        }else if($_POST["opc"]=="lstEst"){
            $id=$_POST["codigo"];
            echo getEstadosLogInscripcion($id);
        }else if($_POST["opc"]=="getInsPrint"){
             $id=$_POST["codigo"];
             $codigoInscripcion=$_POST["codigoInscripcion"];
             $prop=$_POST["prop"];
            echo obteneDatosInscripcionPrint($id,$codigoInscripcion,$prop);
        }else if($_POST["opc"]=="updEst"){
            $id=$_POST["id"];
            $estado=$_POST["vestado"];
            $comentario=$_POST["vcomentario"];
            $idProp=$_POST["iidProp"];
            $vProp=$_POST["vProp"];
            $vCria=$_POST["vCria"];
            echo actualizarEstadoSol($id,$estado,$comentario,$idProp,$vProp,$vCria);
        }else if($_POST["opc"]=="allIns"){
            echo cantidadAllInscripciones();   
        }else if($_POST["opc"]=="getLastIDIns"){
            echo getLastInsertIns();
        }else if($_POST["opc"]=="getImgIns"){
            $codigo=$_POST["codigo"];
            $esPdf=$_POST["esPdf"];
            echo listarImgIns($codigo,$esPdf);
        }else if($_POST["opc"]=="getDocIns"){
            $codigo=$_POST["codigo"];
            $esPdf=$_POST["esPdf"];
            echo listarDocIns($codigo,$esPdf);
        }else if($_POST["opc"]=="lstMotivoBaja"){
            echo listarMotivoBaja();
        }
            
        
    }
    
   
    
     //Listar pelakes datatable
    function listarEjemplar2($prefijo,$nombre,$fecNace,$fecFallece,$idPelaje,$LugarNace,$microchip,$adn){
         $retorno=new Resultado();
        $servicio = new EjemplarLogica();
        return json_encode($servicio->buscarDataTable2($prefijo));
    };
    //Listar pelakes datatable
    function listarEjemplar($prefijo,$nombre,$fecNace,$fecFallece,$idPelaje,$LugarNace,$microchip,$adn){
         $retorno=new Resultado();
        $servicio = new EjemplarLogica();
        return json_encode($servicio->buscarDataTable());
    };
    //Insertar
    
    function insertar($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$usuario_crea,$genero,$fecCapado,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$arrayResenias,$codigoGenerado){
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

                $response = $ins->insertar($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$usuario_crea,$genero,$fecCapado,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$arrayResenias,$codigoGenerado);
                
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
            }
            return json_encode($retorno);
   //}
        }
    //Eliminar
    function eliminarIns($codigo,$usuario_modi){
         $retorno=new Resultado();
       // echo $codigo;
         $objDel = new EjemplarLogica();
         if(validarSesion($retorno)->result==1){
        $response = $objDel->eliminarIns($codigo,$usuario_modi);

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
    }
       return json_encode($retorno);
    }
    //ELIMNAR VARIOS ITEMS
     function eliminarVarios($listCodigos,$usuario_modi){
         $retorno=new Resultado();
         if(validarSesion($retorno)->result==1){
        $objDel = new EjemplarLogica();
        $c=0;
        foreach ($listCodigos as $key  ) {
            $result = $objDel->eliminar($key,$usuario_modi);
            if ($result == 1) $c++;
            else              $c--;
        }
        if (sizeof($listCodigos) == $c){
            $retorno->result=1;
            $retorno->message = "Se eliminaron correctamente todos los registros";
        }else if(sizeof($listCodigos) > $c){
            $retorno->result=0;
            $retorno->message = "No se eliminaron todos los registros, verifíque";
        }else if($c == 0){
            $retorno->result=0;
            $retorno->message = "No se envió la lista de codigos para eliminar";
        }else{
            $retorno->result=0;
            $retorno->message = "No se pudo eliminar los registros enviados.";

        }
    }
       return json_encode($retorno);
    }
     
    //Obtener ID
    function obtenerIDINS($codigo){

        $retorno=new Resultado();
             $servicio = new EjemplarLogica();
             $retorno=new Resultado(); 
             $retorno->validateTOKEN="1";
             $retorno->message=Constantes::K_MENSAJE_SELECT_NOOK;
             if(validarSesion($retorno)->result==1){    
                $obj = new EjemplarLogica();   
                   $result=$obj->obtenerIDINS($codigo);
                   //$retorno->data=$servicio->obtenerSolINS($id);
                       $result->idResenias=unserialize($result->idResenias);
            

                   if($result->idResenias!=null){
                    $res=$result->idResenias;
                    $resenastxt = "";
                    // unset($_SESSION['_datosRes']);
                    foreach ($res as $key => $resenas) {
                       // echo $key."gg".$resenas."<br>";
                          $get = new ResenaLogica();
                          $re=$get->obtenerID($resenas);
                           $list[]=array('id'=>$resenas,
                                                            'descripcion'=>$re->descripcion,
                                                            'tipo'=>$re->tipo
                                                             );
                           $resenastxt=($resenastxt=="" ? "" :$resenastxt.Constantes::K_SEPARADOR_RESENIA)." ".$re->descripcion;
                        } 
                            //echo "<pre>";
                            //print_r($_SESSION);
                          // echo "</pre>";
                      //echo $resenastxt."ff";
                      $resenastxt .= ".";
                      $esBasica=0;
                   }else{
                    $esBasica=1;
                    $resenastxt=$result->reseniaBasica;
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
                              $result->esBasica = $esBasica;
                    }






                $retorno->cantidad=0;
                $retorno->message=Constantes::K_MENSAJE_SELECT_OK;
              }

              return json_encode( $retorno);
    }
    
    //Editar
    function editar($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$arrayResenias,$codigoGenerado, $idImgEliminacion, $idPdfEliminacion, $reseniaBasica){
         $retorno=new Resultado(); 
              $retorno->validateTOKEN="1";
              if(validarSesion($retorno)->result==1){      
                $ins = new EjemplarLogica();
                $imgDelete = new ImagenLogica();
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

                    $response = $ins->editar($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado, $reseniaBasica);
                    
                    if ($response->result == 1){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
                        
                        $ides = $idImgEliminacion;
                        // print_r($ides);
                        foreach ($ides as $key => $id) {
                            $delete = $imgDelete->eliminarInsTMP($id);
                        }
            
                        $idesPdf = $idPdfEliminacion;
                        foreach ($idesPdf as $key => $id) {
                            $delete = $imgDelete->eliminarInsTMP($id);
                        }
                        
                    }else if ($response->result == 0){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
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
        }
            return json_encode($retorno);

    }
     


    function listPropietarios(){
         $entidad=$_SESSION['_datosProp'];    
            if(is_array($entidad)){
                foreach ($entidad as $key => $value) {
                     $list[]= array('idEntidad'=>$entidad[$key]['idEntidad'],
                                    'idPropietario'=> $entidad[$key]['idPropietario'],
                                    'origen'=> $entidad[$key]['origen'],
                                    'idPropLog'=>$entidad[$key]['codigo']);
                } 
            }
           return $list; 
    }
    function listCriadores(){
         $entidad=$_SESSION['_datosCri'];         
            if(is_array($entidad)){
                foreach ($entidad as $key => $value) {
                     $list[]= array('idEntidad'=>$entidad[$key]['idEntidad'],
                                    'origen'=> $entidad[$key]['origen'],
                                    'idCriaLog'=>$entidad[$key]['codigo']);
                } 
            }
            return $list; 
    }

    function listPropietariosDEL(){
         $entidad=$_SESSION['_datosPropDEL'];         
     
            if(is_array($entidad)){
                foreach ($entidad as $key => $value) {
                     $list[]= array('idPropLog'=>$entidad[$key]['codigo'],
                                    'idEntidad'=>$entidad[$key]['idEntidad']
                                    );
                } 
            }
                //echo("<PRE>");         print_r($entidad);
           return $list; 
    }
    function listCriadoresDEL(){
         $entidad=$_SESSION['_datosCriDEL'];         
            if(is_array($entidad)){
                foreach ($entidad as $key => $value) {
                     $list[]=array('idCriaLog'=>$entidad[$key]['codigo'],
                                    'idEntidad'=>$entidad[$key]['idEntidad']
                                    );
                } 
            }
            return $list; 
    }

    function setResenas($resenas){
          
        $resenastxt = "";
        if (is_array($resenas)) {
            foreach ($resenas as $key => $resenas) {
    
                $resenastxt = ($resenastxt == "" ? "" : $resenastxt . Constantes::K_SEPARADOR_RESENIA) . $resenas->descripcion . " ";
            }
            //  print_r($_SESSION['_datosRes']);
        }
        return  $resenastxt;
    }
    function listarComboReseniasRight($codigo,$descripcion,$resenias){
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
                              $re=$get->obtenerID($resenas);
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
     function clsSessionResena(){
          unset($_SESSION['_datosRes']);
          return "1";
    }

    function listaComboMtdoReprop($id,$descripcion){
        $retorno=new Resultado();
        $obj=new  EjemplarLogica();
        $result=$obj->listaComboMtdoReprop($id,$descripcion);

                    $retorno->result=1;
                    $retorno->message ="Cargo correctamente el combo";
                    $retorno->data=$result;

        return json_encode($retorno);
    }

    function validarFecha($fechaServ,$fechaNac,$idMadre,$idHijo){
        $retorno=new Resultado();
        if($fechaServ=="" || $fechaNac==""){
            $retorno->result=1;
            return json_encode($retorno);
        }else{

        $obj = new EjemplarLogica();
        $response=$obj->validarFecha($fechaServ,$fechaNac,$idMadre,$idHijo);
       // print_r($response);
        if ($response->result == 1){
                    $retorno->result=$response->result;
        }else if($response->result==2){
            $retorno->result=$response->result;
        }else{
            $retorno->result=$response->result;
        }

        }
        return json_encode($retorno);        
    }

    function listarTipoDocumento(){
        $retorno=new Resultado();
        $obj=new  EjemplarLogica();
        $result=$obj->listarTipoDocumento();

                    $retorno->result=1;
                    $retorno->message ="Cargo correctamente el combo";
                    $retorno->data=$result;

        return json_encode($retorno);
    }


    function getEstadosLogInscripcion($id){
              $retorno=new Resultado();
              $obj=new  EjemplarLogica();
              $result=$obj->getEstadosLogInscripcion($id);

                          $retorno->result=1;
                          $retorno->message ="Cargo correctamente la data";
                          $retorno->data=$result;


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

         function actualizarEstadoSol($id,$estado,$comentario,$idProp,$vProp,$vCria){
            $retorno=new Resultado(); 
              $retorno->validateTOKEN="1";
              if(validarSesion($retorno)->result==1){      
                $ins = new EjemplarLogica();

                    $response = $ins->actualizarEstadoSol($id,$estado,$comentario,$idProp,$vProp,$vCria);
                   // echo strlen($response->result);
                    if ($response->result == 1){
                        $retorno->result=$response->result;
                        if($estado == "APR"){
                            $re = $ins->getCodigoEjemplar($id);
                            //$retorno->message ="Se registró un ejemplar con el código ".$re->codEjemplar;
                            $retorno->message = Constantes::K_MENSAJE_INSCRIPCION_EXITO.$re->codEjemplar;
                        }else{
                            $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;    
                        }
                    }else if($response->result == 2){
                        $re = $ins->getCodigoEjemplar($id);
                        $retorno->result=$response->result;
                        $retorno->data=$re->codEjemplar;
                        $retorno->message = Constantes::K_MENSAJE_INSCRIPCION_EXITO.$re->codEjemplar;
                    }else if ($response->result == 0){
                        $retorno->result=$response->result;
                        $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
                    }else if($response->result == 999){
                        $retorno->result=999;
                        $retorno->message = "El ejemplar ya se encuentra registrado";
                    }else if($response->result==998){
                        $retorno->result=0;
                        $retorno->message=Constantes::K_MENSAJE_NOMBRE_SUPER_CAMP;                    
                    }
               }
            return json_encode($retorno);
         }

       function cantidadAllInscripciones(){
         $retorno=new Resultado(); 
         $list = new EjemplarLogica();
         $retorno->validateTOKEN="1";
         if(validarSesion($retorno)->result==1){    


            $response=$list->cantidadAllInscripciones();
            //print_r($response);
            if($response->result == 0){
                $retorno->result=0;
            }else{
                $retorno->result=$response->result;
            }

         }
         return json_encode($retorno);
    }

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


          function listarImgIns($codigo,$esPdf){
            $retorno=new Resultado();
            $obj=new  ImagenLogica();
            $retorno->validateTOKEN="1";
            $html="";
            $thumb_prefix           = "thumb_"; //Normal thumb Prefix
            if(validarSesion($retorno)->result==1){    
                $result=$obj->buscarSearchInsTMP($codigo,$esPdf,'');
                if(is_array($result)){
                        $html.="<div class='col-md-1' style='margin-top: 30px;'>
                                <label style='color: #b7adad;'>Imagenes:</label></div>";
                    foreach($result as $key => $value){
                       $html.="<div class='col-md-1' style='margin-top: 7px;'>";
                       $html.="<a href='".K_PATHWEB_INS_IMG.$value->ruta."' target='_blank'><img src='".K_PATHWEB_INS_IMG.$thumb_prefix.$value->ruta."' alt='Thumbnail' style=' cursor:pointer;' /></a>";
                       //$html.="<a href='".K_PATHWEB.$value->ruta."' target='_blank'><img src='".K_PATHWEB.$thumb_prefix.$value->ruta."' alt='Thumbnail' style=' cursor:pointer;' /></a>";
                       $html.="</div>";
                    }
                }

                $retorno->result=1;
                $retorno->message=Constantes::K_MENSAJE_SELECT_OK;
                $retorno->html=$html;
                $retorno->data=$result;
            }

            return json_encode($retorno);
        }

        function listarDocIns($codigo,$esPdf){
            $retorno=new Resultado();
            $obj=new  ImagenLogica();
            $retorno->validateTOKEN="1";
            $html="";
            $thumb_prefix           = "thumb_"; //Normal thumb Prefix
            if(validarSesion($retorno)->result==1){    
                $result=$obj->buscarSearchInsTMP($codigo,$esPdf,'');
                if(is_array($result)){
                        $html.="<div class='col-md-1' style='margin-top: 7px;'>
                                <label style='color: #b7adad;'>Documentos:</label></div>";
                    foreach($result as $key => $value){
                       $html.="<div class='col-md-1' style='margin-top: 7px;margin-left:10px;'>";
                       $html.="<a href='".K_PATHWEB_INS_PDF.$value->ruta."' target='_blank'><img  src='images/icono/pdf.png' alt='Thumbnail' style=' cursor:pointer; width:30px;' title='".$value->idTipoDocumento."'/></a>"; 
                       //$html.="<a href='".K_PATHWEB.$value->ruta."' target='_blank'><img  src='images/icono/pdf.png' alt='Thumbnail' style=' cursor:pointer; width:30px;' title='".$value->idTipoDocumento."'/></a>"; 
                       $html.="</div>";
                    }
                }

                $retorno->result=1;
                $retorno->message=Constantes::K_MENSAJE_SELECT_OK;
                $retorno->html=$html;
                $retorno->data=$result;
            }

            return json_encode($retorno);
        }

        function listarMotivoBaja(){
            $retorno=new Resultado();
            $obj=new  EjemplarLogica();
            $retorno->validateTOKEN="1";
            $result=$obj->listarMotivoBaja();

                $retorno->result=1;
                $retorno->message ="Cargo correctamente la data";
                $retorno->data=$result;


            return json_encode($retorno);
        }

?>

