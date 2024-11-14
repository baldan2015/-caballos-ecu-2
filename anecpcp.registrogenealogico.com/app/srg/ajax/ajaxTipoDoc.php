<?php  session_start();
    include_once ("../logica/TipoDocLogica.php");
    include_once ("../entidad/TipoDoc.inc");
    include_once ("../entidad/Resultado.inc.php");    

    include_once ("../comunes/lib.comun.php"); 
 
    if (file_exists("../entidad/Constantes.php")) {
        include_once("../entidad/Constantes.php");
    }


    if(isset($_POST["opc"])){

         $retorno=new Resultado();
    
      
        $usuario_crea = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $usuario_modi = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $codigo_empresa =0;
        $codigo_local = 0;
    
        
        if($_POST["opc"]=="lst"){
             $nombreCorto = $_POST["nombreCorto"];
             $nombreLargo = $_POST["nombreLargo"];
            echo  listarTipoDocDatable($nombreCorto,$nombreLargo);
        }else if($_POST["opc"]=="ins"){
            $nombreCorto = $_POST["nombreCorto"];
            $nombreLargo = $_POST["nombreLargo"];
            echo insertar($nombreCorto,$nombreLargo,$usuario_crea);
        }else if($_POST["opc"]=="upd"){
            $codigo = $_POST["codigo"];
            $nombreCorto = $_POST["nombreCorto"];
            $nombreLargo = $_POST["nombreLargo"];
            echo editar($codigo,$nombreCorto,$nombreLargo,$usuario_modi);
        }else if ($_POST["opc"]=="bus"){
            echo mostrarAlmacenJSON($codigo,$nombreCorto,$nombreLargo,$codigo_empresa);
        }else if($_POST["opc"]=="del"){
            $codigo = $_POST["key"];
            echo eliminar($codigo);
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
        }
    }
    if($_GET["opc"]=="jqgrid"){
            $response=buscarDatos();
            echo json_encode($response);
        }
    if($_POST["opc"]=="bus2"){
        $page = $_POST['page'];
        $limit = $_POST['rows'];
        $sidx = $_POST['sidx'];
        $sord = $_POST['sord'];

        $codigo = $_POST["codigo"];
        $nombreCorto = $_POST["nombreCorto"];
        $nombreLargo = $_POST["nombreLargo"];
        if (!$sidx) $sidx = 1;
        
        echo mostrarAlmacenGrilla($codigo, $nombreCorto,$nombreLargo, $page, $limit, $sidx, $sord);
    }
    if($_POST["opc"]=="lstItems"){
           $codigo="0"; 
           $descripcion=""; 
           echo listarComboTipoDoc($codigo,$descripcion);
    }

    //Listar almacen por Local
    function listarAlmLocal($codigo_local,$codigo_empresa){
        $lis = new AlmacenBR();
        
        $result = $lis->BLocal($entity);
        
        return json_encode($result);
    }
    //Listar pelakes datatable
    function listarTipoDocDatable($nombreCorto,$nombreLargo){
        $servicio = new TipoDocLogica();
        return json_encode($servicio->buscarDataTable());
    };
    //Insertar
    
    function insertar($nombreCorto,$nombreLargo,$usuario_crea){
       $retorno=new Resultado();
       if(validarSesion($retorno)->result==1){ 
        $ins = new TipoDocLogica();
        if(strlen($nombreCorto)>0 and strlen($nombreLargo) >0 ){
                $response = $ins->insertar($nombreCorto,$nombreLargo,$usuario_crea);
                if ($response->result == 1){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
                }else if ($response->result == 0){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
                }else if ($response->result == 2){
                    $retorno->result=0;
                    $retorno->message = "Ya existe el nombre del tipo de documento.";
                }
        }else{
                    $retorno->result=2;
                    $retorno->message = "Ingrese el nombre del tipo de documento.";

        }
    }
        return json_encode($retorno);
    }

    //Eliminar
    function eliminar($codigo){
        $retorno=new Resultado();
        if(validarSesion($retorno)->result==1){ 
        $objDel = new TipoDocLogica();
        $result = $objDel->eliminar($codigo);

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
        $objDel = new TipoDocLogica();
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
    function generarCodigo($codigo_empresa){
        $cod = new AlmacenBR();
        $entity = new Almacen();
        $entity->codigo_empresa = $codigo_empresa;
        $result = $cod->generarCodigo($entity);
        
        return json_encode($result);
    }
    //Obtener ID
    function obtenerID($codigo){
        $retorno=new Resultado();
        if(validarSesion($retorno)->result==1){ 
        $get = new TipoDocLogica();
        
       
        $result = $get->obtenerID($codigo);
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
    /*function mostrarAlmacenJSON($codigo,$nombreCorto,$nombreLargo,$codigo_empresa){
        $bus = new AlmacenBR();
        $entity = new Almacen();
        $entity->codigo = $codigo;
        $entity->nombreCorto = $nombreCorto;
        $entity->nombreLargo = $nombreLargo;
        $entity->codigo_empresa = $codigo_empresa;
        
        $result = $bus->buscar($entity);
        
        return json_encode($result);
    }*/
    //Editar
    function editar($codigo,$nombreCorto,$nombreLargo,$usuario_modi){
        $retorno=new Resultado();
        if(validarSesion($retorno)->result==1){ 
        $edi = new TipoDocLogica();
        $response = $edi->editar($codigo,$nombreCorto,$nombreLargo,$usuario_modi);
        if ($response->result == 1){
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
        }else if ($response->result == 0){
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
        }else if ($response->result == 2){
            $retorno->result=0;
            $retorno->message = "El nombre del documento que desea actualizar ya existe.";
        }
    }
        return json_encode($retorno);


    }
    
    function listarComboTipoDoc($codigo,$descripcion){
        $retorno2=new Resultado();
        $obj=new TipoDocLogica();
        $result = $obj->listarComboTipoDoc($codigo,$descripcion);
        $retorno2->result=1;
        $retorno2->message = Constantes::K_MENSAJE_INSERT_OK;
        $retorno2->data=$result;
        return json_encode($retorno2);
    }
     function buscarDatos(){

    $page = $_GET['page']; // Obtiene la petición de la página a mostrar
    $limit = $_GET['rows']; // Obtiene cuantas filas queremos tener dentro de la rejilla
    $sidx = $_GET['sidx']; // Obtiene el campo indice "index" para ordenar los datos
    $sord = $_GET['sord']; // Obtiene la forma de ordenamiento
     
     /*FILTROS DE BUSQUEDA*/
    $nomTipoDoc= $_GET['nomTipoDoc']; 
    

 
    if(!$sidx) $sidx =1;
  
    
     $entidadServicio= new TipoDocLogica();
    $count = $entidadServicio->numeroRegistro($nomTipoDoc); 
     
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
     
     $resultado=$entidadServicio->buscarSearch($nomTipoDoc,$start,$limit,$sidx,$sord);
    // print_r ($resultado);
     foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id']=$fila->id;
        $responce->rows[$i]['cell']=array($fila->id,
                                          $fila->nombreCorto,
                                          $fila->nombreLargo
                                          );
        $i++;
     }
 
    // Se devuelven los datos a mostrar en la rejilla   
    return $responce;  
} ?>