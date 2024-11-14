<?php  session_start();
    include_once ("../logica/UsuarioRolLogica.php");
    include_once ("../entidad/UsuarioRol.inc.php");
    include_once ("../entidad/Resultado.inc.php");     

     include_once ("../comunes/lib.comun.php"); 
 
    if (file_exists("../entidad/Constantes.php")) {
        include_once("../entidad/Constantes.php");
    }
  

    if(isset($_POST["opc"])){

         $retorno=new Resultado();
     /* $codigo = $_POST["codigo"];
        $nombre = $_POST["nombre"];
        $tlocal_codigo = $_POST["tlocal_codigo"];
        $responsable = $_POST["responsable"];
     
      
        $usuario_crea = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $usuario_modi = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $codigo_empresa =$_SESSION[Constantes::K_SESSION_EMPRESA];
        $codigo_local = $_SESSION[Constantes::K_SESSION_CODIGO_LOCAL]; */

        $usuario_crea = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $usuario_modi = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $codigo_empresa =1;
        $codigo_local = 1;
        
       if($_POST["opc"]=="ins"){
            $idUsuario = $_POST["idUsuario"];
            $idRol = $_POST["idRol"];
            $idOficina=$_POST["idOficina"];
           $estado=$_POST["estado"];
           $login=$_POST["login"];
           $pwd=$_POST["pwd"];
         echo insertar($idUsuario,$idRol,$idOficina,$usuario_crea,$estado,$login,$pwd);
        }else if($_POST["opc"]=="upd"){
             $codigo=$_POST["id"];
             $idUsuario = $_POST["idUsuario"];
             $idOficina=$_POST["idOficina"];
             $estado=$_POST["estado"];
             $login=$_POST["login"];
             $pwd=$_POST["pwd"];  
            echo editar($codigo,$idUsuario,$idOficina,$estado,$usuario_modi,$login,$pwd);
        }else if ($_POST["opc"]=="bus"){
            echo mostrarAlmacenJSON($codigo,$nombre,$codigo_empresa);
        }else if($_POST["opc"]=="del"){
            $id = $_POST["key"];
            echo eliminar($id);
        }else if($_POST["opc"]=="cod"){
            echo generarCodigo($codigo_empresa);
        }else if($_POST["opc"]=="get"){
             $codigo = $_POST["key"];
            echo obtenerID($codigo);
        }else if($_POST["opc"]=="vdel"){
            echo validarEliminar($codigo);
        }else if($_POST["opc"]=="lstAlmDeault"){
            
            if($_SESSION[Constantes::K_SESSION_PERFIL_SEL]=="999"){
                $codigo_local = '';
            }else{
                $codigo_local = $_SESSION[Constantes::K_SESSION_CODIGO_LOCAL];
            }
            echo listarAlmLocal($codigo_local,$codigo_empresa);
        }else if($_POST["opc"]=="delAll"){
            $codigo = $_POST["keys"];
            echo eliminarVarios($codigo);
        }else if($_POST["opc"]=="lstItemsRol"){
           $id="";//$_POST["codigo"];
           $descripcion="";//$_POST["descripcion"];
           echo listarComboTipoRol($id,$descripcion);
        }else if($_POST["opc"]=="lstItemUsu"){
            $id="";//$_POST["codigo"];
           $descripcion="";//$_POST["descripcion"];
           echo listarComboUsuario($id,$descripcion);
        }
    }
    if($_GET["opc"]=="jqgrid"){
           
            $response=buscarDatos();
            echo json_encode($response);
        }
   
    
    //Listar almacen por Local
    function listarAlmLocal($codigo_local,$codigo_empresa){
        $lis = new AlmacenBR();
        
        $result = $lis->BLocal($entity);
        
        return json_encode($result);
    }
    //Listar las usuarios con los roles diferentes
    function listarUsuarioRol($id){
         $retorno=new Resultado();
        $servicio = new UsuarioRolLogica();
        return json_encode($servicio->buscarDataTable());
    };
    //Insertar
    
    function insertar($idUsuario,$idRol,$idOficina,$usuario_crea,$estado,$login,$pwd){
        $retorno=new Resultado();
        if(validarSesion($retorno)->result==1){
        $ins = new UsuarioRolLogica();
        
                $response = $ins->insertar($idUsuario,$idRol,$idOficina,$usuario_crea,$estado);
                if ($response->result == 1){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_INSERT_OK;

                    $ins->insertarLogin($idUsuario,$login,$pwd,$estado,$usuario_crea);
                    
                }else if ($response->result == 0){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
                }else if ($response->result == 2){
                    $retorno->result=0;
                    $retorno->message = "El usuario , rol , oficina debe ser unico";
                }else if($response->result==3){
                    $retorno->result=0;
                    $retorno->message = "El usuario solo puede tener un perfil activo";
                }
            }
        return json_encode($retorno);
    }

    //Eliminar
    function eliminar($id){
         $retorno=new Resultado();
         if(validarSesion($retorno)->result==1){
        $objDel = new UsuarioRolLogica();
        $result = $objDel->eliminar($id);

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
        $objDel = new UsuarioRolLogica();
        $c=0;
        foreach ($listCodigos as $key  ) {
            $result = $objDel->eliminar($key);
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
    //Generar codigo
   /* function generarCodigo($codigo_empresa){
        $cod = new AlmacenBR();
        $entity = new Almacen();
        $entity->codigo_empresa = $codigo_empresa;
        $result = $cod->generarCodigo($entity);
        
        return json_encode($result);
    }*/
    //Obtener ID
    function obtenerID($codigo){
         $retorno=new Resultado();
         if(validarSesion($retorno)->result==1){
        $get = new UsuarioRolLogica();
        
       
        $usuario = $get->obtenerID($codigo);
        if(is_null($usuario)){
                    $retorno->result=0;
                    $retorno->message="No se encontro datos";
        }else{
                    $retorno->result=1;
                    $retorno->message="dato encontrado";
                    $retorno->data=$usuario;
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
        
        $result = $bus->buscar($entity);
        
        return json_encode($result);
    }
    //Editar
    function editar($codigo,$idUsuario,$idOficina,$estado,$usuario_modi,$login,$pwd){
         $retorno=new Resultado();
         if(validarSesion($retorno)->result==1){
        $edi = new UsuarioRolLogica();
        $response = $edi->editar($codigo,$idUsuario,$idOficina,$estado,$usuario_modi);
        if ($response->result == 1){
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;

            $edi->editarLogin($idUsuario,$login,$pwd,$estado,$usuario_modi);
        }else if ($response->result == 0){
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
        }else if ($response->result == 2){
            $retorno->result=0;
            $retorno->message = "El usuario solo puede tener un perfil activo";
        }
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

      function listarComboTipoRol($id,$descripcion){

        $retorno=new Resultado();
        $obj=new UsuarioRolLogica();
        $result = $obj->listarComboTipoRol($id,$descripcion);

                    $retorno->result=1;
                    $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
                    $retorno->data=$result;
        //echo $result;
        return json_encode($retorno);
    }
   function listarComboUsuario($id,$descripcion){

        $retorno=new Resultado();
        $obj=new UsuarioRolLogica();
        $result = $obj->listarComboUsuario($id,$descripcion);

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
     
     /*FILTROS DE BUSQUEDA*/
    $nomUsu= $_GET['nomUsu']; 
    $nomOfic=$_GET['nomOfic'];

 
    if(!$sidx) $sidx =1;
  
    
     $entidadServicio= new UsuarioRolLogica();
    $count = $entidadServicio->numeroRegistro($nomUsu,$nomOfic); 
     
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
     
     $resultado=$entidadServicio->buscarSearch($nomUsu,$nomOfic,$start,$limit,$sidx,$sord);
    // print_r ($resultado);
     foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id']=$fila->id;
        $responce->rows[$i]['cell']=array($fila->id,
                                          $fila->usuario,
                                          $fila->rol,
                                          $fila->oficina,
                                          $fila->estado
                                          );
        $i++;
     }
 
    // Se devuelven los datos a mostrar en la rejilla   
    return $responce;  


}    
?>
