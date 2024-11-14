<?php  session_start();
    include_once ("../logica/PelajeLogica.php");
    include_once ("../entidad/Pelaje.inc");
    include_once ("../entidad/Resultado.inc.php");    

    
 include_once ("../comunes/lib.comun.php"); 
    if (file_exists("../entidad/Constantes.php")) {
        include_once("../entidad/Constantes.php");
    }
if(!isset($_POST["opc"]))   echo listarPelaje('');

    if(isset($_POST["opc"])){

         $retorno=new Resultado();
     /*     $codigo = $_POST["codigo"];
        $nombre = $_POST["nombre"];
        $tlocal_codigo = $_POST["tlocal_codigo"];
        $responsable = $_POST["responsable"];
     
      
        $usuario_crea = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $usuario_modi = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $codigo_empresa =$_SESSION[Constantes::K_SESSION_EMPRESA];
        $codigo_local = $_SESSION[Constantes::K_SESSION_CODIGO_LOCAL];
    */
        
        if($_POST["opc"]=="lst"){
             $nombre = $_POST["nombre"];
            echo  listarPelaje($nombre);
        }elseif($_POST["opc"]=="ins"){
            $nombre = $_POST["nombre"];
            echo insertar($nombre);
        }elseif($_POST["opc"]=="upd"){
            $codigo = $_POST["codigo"];
            $nombre = $_POST["nombre"];
            echo editar($codigo,$nombre);
        }elseif ($_POST["opc"]=="bus"){
            echo mostrarAlmacenJSON($codigo,$nombre,$codigo_empresa);
        }elseif($_POST["opc"]=="del"){
            $codigo = $_POST["key"];
            echo eliminar($codigo);
        }elseif($_POST["opc"]=="cod"){
            echo generarCodigo($codigo_empresa);
        }elseif($_POST["opc"]=="get"){
             $codigo = $_POST["key"];
            echo obtenerID($codigo);
        }elseif($_POST["opc"]=="vdel"){
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
    
    //Listar almacen por Local
    function listarAlmLocal($codigo_local,$codigo_empresa){
        $lis = new AlmacenBR();
        
        $result = $lis->BLocal($entity);
        
        return json_encode($result);
    }
    //Listar pelakes datatable
    function listarPelaje($nombre){
         $retorno=new Resultado();
        $servicio = new PelajeLogica();
        return json_encode($servicio->buscarDataTable());
    };
    //Insertar
    
    function insertar($nombre){
        $retorno=new Resultado();
           if(validarSesion($retorno)->result==1){ 
        $ins = new PelajeLogica();
        if(strlen($nombre)>0){
                $response = $ins->insertar($nombre);
                if ($response->result == 1){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
                }else if ($response->result == 0){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
                }else if ($response->result == 2){
                    $retorno->result=0;
                    $retorno->message = "Ya existe el nombre del pelaje.";
                }
        }else{
                    $retorno->result=2;
                    $retorno->message = "Ingrese el nombre del pelaje.";

        }
    }
        return json_encode($retorno);
    }

    //Eliminar
    function eliminar($codigo){
         $retorno=new Resultado();
            if(validarSesion($retorno)->result==1){ 
        $objDel = new PelajeLogica();
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
        $objDel = new PelajeLogica();
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
        $get = new PelajeLogica();
        
       
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
    function editar($codigo,$nombreCorto){
         $retorno=new Resultado();
            if(validarSesion($retorno)->result==1){ 
        $edi = new PelajeLogica();
        $response = $edi->editar($codigo,$nombreCorto);
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
?>
