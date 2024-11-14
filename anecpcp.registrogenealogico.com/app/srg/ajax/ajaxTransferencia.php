<?php  session_start();
    include_once ("../logica/TransferenciaLogica.php");
    include_once ("../entidad/Transferencia.inc.php");
    include_once ("../entidad/TransferenciaDTO.inc.php");
    include_once ("../entidad/Resultado.inc.php");    

    include_once ("../comunes/lib.comun.php"); 
 
    if (file_exists("../entidad/Constantes.php")) {
        include_once("../entidad/Constantes.php");
    }
//if(!isset($_POST["opc"])) echo buscar();

    if(isset($_POST["opc"])){
        $usuario_crea = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $usuario_modi = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
         $retorno=new Resultado();
        
        if($_POST["opc"]=="lst"){
             //$nombre = $_POST["nombre"];
            //echo  buscar();
            //echo buscarDatos();
            $response=buscarDatos();
            echo json_encode($response);


        }elseif($_POST["opc"]=="ins"){
            $id = $_POST["id"];
            $idEjemplar = $_POST["idEjemplar"];
            $idNuevoProp = $_POST["idNuevoProp"];
            $idAntiguoProp = $_POST["idAntiguoProp"];
            $idNuevoCria = $_POST["idNuevoCria"];
            $idAntiguoCria = $_POST["idAntiguoCria"];            
            $fechaRegistro = $_POST["fechaRegistro"];
            $fechaTransferencia = $_POST["fechaTransferencia"]; 
            $estado = 'A';
            echo insertar($id, $idEjemplar, $idNuevoProp, $idAntiguoProp, $idNuevoCria, $idAntiguoCria, $fechaRegistro, $fechaTransferencia, $estado,$usuario_crea);
        }elseif($_POST["opc"]=="upd"){
            $id = $_POST["id"];
            $idEjemplar = $_POST["idEjemplar"];
            $idNuevoProp = $_POST["idNuevoProp"];
            $idAntiguoProp = $_POST["idAntiguoProp"];
            $idNuevoCria = $_POST["idNuevoCria"];
            $idAntiguoCria = $_POST["idAntiguoCria"];            
            $fechaRegistro = $_POST["fechaRegistro"];
            $fechaTransferencia = $_POST["fechaTransferencia"]; 
            $estado = 'A';

            echo editar($id, $idEjemplar, $idNuevoProp, $idAntiguoProp, $idNuevoCria, $idAntiguoCria, $fechaRegistro, $fechaTransferencia, $estado,$usuario_modi);
        }elseif ($_POST["opc"]=="confirm"){
            $id = $_POST["id"];
            $fechaTransferencia = $_POST["fechaTransferencia"]; 

            echo confirmar($id, $fechaTransferencia);
        }elseif ($_POST["opc"]=="bus"){
            echo  buscar();

        }elseif($_POST["opc"]=="del"){
            $id = $_POST["key"];
            echo eliminar($id,$usuario_modi);
        }elseif($_POST["opc"]=="cod"){
            echo generarCodigo($codigo_empresa);
        }elseif($_POST["opc"]=="get"){
             $id = $_POST["key"];
            echo obtenerID($id);
        }elseif($_POST["opc"]=="get1"){
             $id = $_POST["key"];
            echo obtenerID1($id);
        }elseif($_POST["opc"]=="id"){
            echo validarEliminar($codigo);
        }elseif($_POST["opc"]=="lstAlmDeault"){
            
            if($_SESSION[Constantes::K_SESSION_PERFIL_SEL]=="999"){
                $codigo_local = '';
            }else{
                $codigo_local = $_SESSION[Constantes::K_SESSION_CODIGO_LOCAL];
            }
            echo listarAlmLocal($codigo_local,$codigo_empresa);
        }elseif($_POST["opc"]=="delAll"){
            $codigo = $_POST["keys"];
            echo eliminarVarios($codigo);
        }else if($_POST["opc"]=="lstItems"){
           $codigo="";//$_POST["codigo"];
           $descripcion="";//$_POST["descripcion"];
           echo listarComboTipoPelaje($codigo,$descripcion);
        }
    }
    
    if($_POST["opc"]=="bus2"){
        $page = $_POST['page'];
        $limit = $_POST['rows'];
        $sidx = $_POST['sidx'];
        $sord = $_POST['sord'];

        $codigo = $_POST["codigo"];
        $nombre = $_POST["nombre"];

        if (!$sidx) $sidx = 1;
        
        echo mostrarAlmacenGrilla($codigo, $nombre, $page, $limit, $sidx, $sord);

    }
    
    if($_GET["opc"]=="jqgrid"){
        $response=buscarDatos();
        echo json_encode($response);
    }

    //Listar transferencias datatable
    function buscar(){
         $retorno=new Resultado();
        $servicio = new TransferenciaLogica();
        
        return json_encode($servicio->buscar());
    }
    //Insertar
    
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

    function insertar($id, $idEjemplar, $idNuevoProp, $idAntiguoProp, $idNuevoCria, $idAntiguoCria, $fechaRegistro, $fechaTransferencia, $estado,$usuario_crea){

        $propietarios=listPropietarios();
        //Inserta propietarios asociados

        $retorno=new Resultado();
   if(validarSesion($retorno)->result==1){ 
        if(is_array($propietarios)){
            if(count($propietarios)>0){
                $ins = new TransferenciaLogica();
                if(strlen($idEjemplar)>0){
                        $response = $ins->insertar($id, $idEjemplar, $idNuevoProp, $idAntiguoProp, $idNuevoCria, $idAntiguoCria, $fechaRegistro, $fechaTransferencia, $estado, $propietarios,$usuario_crea);
                        if ($response->result == 1){
                            $retorno->result=$response->result;
                            $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
                        }else if ($response->result == 0){
                            $retorno->result=$response->result;
                            $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
                        }else if ($response->result == 2){
                            $retorno->result=0;
                            $retorno->message = "Ya existe transferencia.";
                        }else if($response->result==5){
                            $retorno->result=0;
                            $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE;
                        }else if($response->result==6){
                            $retorno->result=0;
                            $retorno->message=Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE_ERROR;                    
                            
                        }
                }else{
                            $retorno->result=2;
                            $retorno->message = "Seleccione un ejemplar.";

                }            
            }else{

                $retorno->result=0;
                $retorno->message = "Seleccione nuevo propietario.";                 
            }
        }else{
            $retorno->result=0;
            $retorno->message = "Seleccione nuevo propietario.";              
        }
}
        return json_encode($retorno);
    }

    //Eliminar
    function eliminar($id,$usuario_modi){
         $retorno=new Resultado();
            if(validarSesion($retorno)->result==1){ 
        $objDel = new TransferenciaLogica();
        $result = $objDel->eliminar($id,$usuario_modi);

        if ($result == 1){
            $retorno->result=1;
            $retorno->message = Constantes::K_MENSAJE_DELETE_OK;
        }else{
            $retorno->result=0;
            $retorno->message = Constantes::K_MENSAJE_DELETE_NOOK;
        }
    }
       return json_encode($retorno);
    }
    //ELIMNAR VARIOS ITEMS
     function eliminarVarios($listCodigos){
         $retorno=new Resultado();
            if(validarSesion($retorno)->result==1){ 
        $objDel = new TransferenciaLogica();
        $c=0;
        foreach ($listCodigos as $key  ) {
            $result = $objDel->eliminar($key);
            if ($result == 1) $c++;
            else              $c--;
        }
        if (sizeof($listCodigos) == $c){
            $retorno->result=1;
            $retorno->message = "Se eliminaron correctamente transferencias con estado PENDIENTE";
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
    //Generar codigo
   /* function generarCodigo($codigo_empresa){
        $cod = new AlmacenBR();
        $entity = new Almacen();
        $entity->codigo_empresa = $codigo_empresa;
        $result = $cod->generarCodigo($entity);
        
        return json_encode($result);
    }*/
    //Obtener ID
    function obtenerID($id){
         $retorno=new Resultado();
            if(validarSesion($retorno)->result==1){ 
        $get = new TransferenciaLogica();
        $result = $get->obtenerID($id);
        if(is_null($result)){
                    $retorno->result=0;
                    $retorno->message="No se encontro datos";
        }else{
                    $retorno->result=1;
                    $retorno->message="dato encontrado";
                    $retorno->data=$result;
        }
}
        return json_encode($retorno);
    }

     function obtenerID1($id){
         $retorno=new Resultado();
            if(validarSesion($retorno)->result==1){ 
        $get = new TransferenciaLogica();
        $result = $get->obtenerID1($id);
        if(is_null($result)){
                    $retorno->result=0;
                    $retorno->message="No se encontro datos";
        }else{
                    $retorno->result=1;
                    $retorno->message="dato encontrado";
                    $retorno->data=$result;
        }
}
        return json_encode($retorno);
    }
    //Buscar
    function mostrarAlmacenJSON($codigo,$nombre,$codigo_empresa){
        $bus = new AlmacenBR();
        $entity = new Almacen();
        $entity->codigo = $codigo;
        $entity->nombre = $nombre;
        $entity->codigo_empresa = $codigo_empresa;
        
        $result = $bus->buscar();
        
        return json_encode($result);
    }
    //Editar OBSOLETO 20170605
    function editar($id, $idEjemplar, $idNuevoProp, $idAntiguoProp, $idNuevoCria, $idAntiguoCria, $fechaRegistro, $fechaTransferencia, $estado,$usuario_modi){
         $retorno=new Resultado();
            if(validarSesion($retorno)->result==1){ 
        $edi = new TransferenciaLogica();
        $response = $edi->editar($id, $idEjemplar, $idNuevoProp, $idAntiguoProp, $idNuevoCria, $idAntiguoCria, $fechaRegistro, $fechaTransferencia, $estado,$usuario_modi);        
        if ($response->result == 1){
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
        }else if ($response->result == 0){
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
        }else if ($response->result == 2){
            $retorno->result=0;
            $retorno->message = "El nombre del tipo de documento que desea actualizar ya existe.";
        }
    }
        return json_encode($retorno);


    }

    function confirmar($id, $fechaTransferencia){
         $retorno=new Resultado();
        $edi = new TransferenciaLogica();
        $response = $edi->confirmar($id, $fechaTransferencia);        
        if ($response->result == 1){
            $retorno->result=$response->result;
            $retorno->message = 'Transferencia confirmado exitosamente.';//Constantes::K_MENSAJE_UPDATE_OK;
        }else if ($response->result == 0){
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
        }else if ($response->result == 2){
            $retorno->result=0;
            $retorno->message = "El nombre del tipo de documento que desea actualizar ya existe.";
        }
        return json_encode($retorno);


    }    
    //Validar eliminar
   /* function validarEliminar($codigo){
        $vdel = new AlmacenBR();
        $entity = new Almacen();
        $entity->codigo = $codigo;
        
        $result = $vdel->validarEliminar($entity);
        
        return $result;
    };*/
    
    function mostrarAlmacenGrilla($codigo, $nombre, $page, $limit, $sidx, $sord){
        $codigo_empresa = $_SESSION[Constantes::K_SESSION_EMPRESA];
        $bus = new AlmacenBR();
        $entity = new Almacen();
        $entity->codigo = $codigo;
        $entity->nombre = $nombre;
        $entity->codigo_empresa = $codigo_empresa;
        
        $count = $bus->numeroRegistro($codigo, $nombre, $codigo_empresa);
        
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)

        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
        
        $almacenes = $bus->buscarSearch($entity, $start, $limit, $sidx, $sord);
        
        foreach ($almacenes as $fila){
            $responce->rows[$i]['id'] = $fila->codigo;
            $responce->rows[$i]['cell'] = array($fila->codigo, $fila->nombre,$fila->nombre_local,$fila->responsable);
            $i++;
        }
        
        return json_encode($responce);
    }

      function listarComboTipoPelaje($codigo,$descripcion){

        $retorno=new Resultado();
        $obj=new PelajeLogica();
        $result = $obj->listarComboTipoPelaje($codigo,$descripcion);

                    $retorno->result=1;
                    $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
                    $retorno->data=$result;
        //echo $result;
        return json_encode($retorno);
    }

function buscarDatos(){

    $page = $_GET['page']; // Obtiene la petición de la página a mostrar
    $limit = $_GET['rows']; // Obtiene cuantas filas queremos tener dentro de la rejilla
    $sidx = $_GET['sidx']; // Obtiene el campo indice "index" para ordenar los datos
    $sord = $_GET['sord']; // Obtiene la forma de ordenamiento
    $vid= $_GET['vid'];
    $vcodigo=$_GET['vcodigo'];
    $vprefijo = $_GET['vprefijo'];
    $vnombreEjemplar = $_GET['vnombreEjemplar'];
    $vnuevoProp = $_GET['prop'];
    $dfechaTransferencia = $_GET['dfechaTransferencia'];
    $ente=$_GET['ente'];
     /*FILTROS DE BUSQUEDA*/
     /*
    $numDoc= $_GET['numDoc']; 
    $nombre=$_GET['nombre'];  
    $rol=$_GET['rol'];  
    $estado=$_GET['estado']; 
    */
 
    if(!$sidx) $sidx =1;
 
    
     $entidadServicio= new TransferenciaLogica();
    $count = $entidadServicio->numeroRegistro($vid,$vcodigo,$vprefijo, $vnombreEjemplar, $vnuevoProp, $dfechaTransferencia,$ente); 
     
    if( $count >0 )
    { $total_pages = ceil($count/$limit); }
    else { $total_pages = 0; }
     
    if ($page > $total_pages) $page=$total_pages;
         
    $start = $limit*$page - $limit;
 
    // Se declara la variable objeto la cual va imprimir los datos
    $responce = new stdClass;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    $i=0;


     $resultado=$entidadServicio->buscarSearch($start,$limit,$sidx,$sord,$vid,$vcodigo,$vprefijo, $vnombreEjemplar, $vnuevoProp, $dfechaTransferencia,$ente);
    // print_r($fila);
     foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id']=$fila->id;
        $responce->rows[$i]['cell']=array($fila->id,
                                          $fila->idEjemplar,
                                          $fila->prefijo,
                                          $fila->nombre,
                                          $fila->antiguoProp,
                                          $fila->nuevoProp,
                                          $fila->fechaRegistro,
                                          $fila->fechaTransferencia,
                                          $fila->estadoDesc,
                                          $fila->capado
                                          );
        $i++;
     }
 
    // Se devuelven los datos a mostrar en la rejilla   
    return $responce;  


}


?>
