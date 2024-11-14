<?php  session_start();
    include_once ("../logica/ResenaLogica.php");
    include_once ("../entidad/Resena.inc.php");
    include_once ("../entidad/Resultado.inc.php");     

    include_once ("../comunes/lib.comun.php"); 
    
// echo getcwd()." - ";
    if (file_exists("../entidad/Constantes.php")) {
        include_once("../entidad/Constantes.php");
       // echo "include_once...consy...".Constantes::K_MENSAJE_INSERT_OK;;
    }
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
        $usuario_crea = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $usuario_modi = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $codigo_empresa =0;
        $codigo_local = 0;
        
        if($_POST["opc"]=="lst"){
             $nombre = addslashes($_POST["nombre"]);
           // echo  listarResena($nombre);
        }else if($_POST["opc"]=="ins"){
           // $id          = $_POST["id"];
            $descripcion = addslashes($_POST["descripcion"]);
            $tipo=            $_POST["tipo"];
           // $telefono    = $_POST["telefono"];
         echo insertar($descripcion,$usuario_crea,$tipo);
        }else if($_POST["opc"]=="upd"){
            $id          = $_POST["id"];
            $descripcion =addslashes($_POST["descripcion"]);
            $tipo=            $_POST["tipo"];
            echo editar($id,$descripcion,$usuario_modi,$tipo);

        }else if ($_POST["opc"]=="bus"){
            echo mostrarAlmacenJSON($codigo,$nombre,$codigo_empresa);
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
         
        }else if($_POST["opc"]=="delAll"){
            $codigo = $_POST["keys"];
            echo eliminarVarios($codigo,$usuario_modi);
        }else if($_POST["opc"]=="***lstItems"){
           $codigo="";//$_POST["codigo"];
           $descripcion="";//$_POST["descripcion"];
           //echo listarComboUsuario($codigo,$descripcion);
        }else if($_POST["opc"]=="lstItems"){
           $codigo="";//$_POST["codigo"];
           $descripcion=$_POST["descripcion"];
           $tipo=$_POST['tipo'];
           echo listarComboResenias($codigo,$descripcion,$tipo);
        }else if($_POST["opc"]=="lstTipo"){
            echo listarTipoResena();
        }
    }
        if(isset($_GET["opc"])){
            if($_GET["opc"]=="jqgrid"){
               
                $response=buscarDatos();
                echo json_encode($response);
            }
        }
       
   function listarTipoResena(){
    $retorno=new Resultado();
    $obj=new ResenaLogica();
   // $result = $obj->listarTipoResena();
    $result = $obj->listarResenaTipos();
                $retorno->result=1;
                $retorno->message = "OK";
                $retorno->data=$result;
    //echo"<pre>";         print_r($result);        echo"</pre>";
    return json_encode($retorno);
   }
    
    //Listar almacen por Local
    function listarAlmLocal($codigo_local,$codigo_empresa){
        $lis = new AlmacenBR();
        
        $result = $lis->BLocal($entity);
        
        return json_encode($result);
    }
    //Listar pelajes datatable
    function listarResena($id){
         $retorno=new Resultado();
        $servicio = new ResenaLogica();
        return json_encode($servicio->buscarDataTable());
    };
    //Insertar
    
    function insertar($descripcion,$usuario_crea,$tipo){
        $retorno=new Resultado();
        if(validarSesion($retorno)->result==1){ 
        $ins = new ResenaLogica();
        if(strlen($descripcion)>0){
                $response = $ins->insertar($descripcion,$usuario_crea,$tipo);
                //print_r($response);
                if ($response->result == 1){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
                }else if ($response->result == 0 ){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
                }else if ($response->result == 2){
                    $retorno->result=0;
                    $retorno->message = "Ya existe el descripcion de la Reseña.";
                }
        }else{
                    $retorno->result=2;
                    $retorno->message = "Ingrese la descripcion de la Reseña.";

        }
}
        return json_encode($retorno);
    }

    //Eliminar
    function eliminar($codigo){
       // echo $codigo;
         $retorno=new Resultado();
         if(validarSesion($retorno)->result==1){ 
        $objDel = new ResenaLogica();
        $response = $objDel->eliminar($codigo);

        if ($response->result == 1){
           $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_DELETE_OK;
        }else{
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_DELETE_NOOK_REF;
        }
    }
       return json_encode($retorno);
    }
    //ELIMNAR VARIOS ITEMS
     function eliminarVarios($listCodigos,$usuModi){
         $retorno=new Resultado();
         if(validarSesion($retorno)->result==1){ 
        $objDel = new ResenaLogica();
        $c=0;
        foreach ($listCodigos as $key  ) {
            $result = $objDel->eliminar($key,$usuModi);
            if ($result == 1) $c++;
            else              $c--;
        }
        if (sizeof($listCodigos) == $c){
            $retorno->result=1;
            $retorno->message = "Eliminaci&oacute;n exitosa.";
        }else if(sizeof($listCodigos) > $c){
            $retorno->result=0;
            $retorno->message = "No se eliminaron todos los registros, verifíque";
        }else if($c == 0){
            $retorno->result=0;
            $retorno->message = "No se envió la lista de codigos para eliminar";
        }else{
            $retorno->result=0;
            $retorno->message = "No se pudo eliminar los registros seleccionados.";

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
        $get = new ResenaLogica();
        
       
        $Resena = $get->obtenerID($codigo);
        if(is_null($Resena)){
                    $retorno->result=0;
                    $retorno->message="No se encontro datos";
        }else{
                    $retorno->result=1;
                    $retorno->message="dato encontrado";
                    $retorno->data=$Resena;
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
    function editar($id,$descripcion,$usuario_modi,$tipo){
         $retorno=new Resultado();
         if(validarSesion($retorno)->result==1){ 
        $edi = new ResenaLogica();
        $response = $edi->editar($id,$descripcion,$usuario_modi,$tipo);
        if ($response->result == 1){
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
        }else if ($response->result == 0){
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
        }else if ($response->result == 2){
            $retorno->result=0;
            $retorno->message = "El nombre de la reseña que desea actualizar ya existe.";
        }
    }
        return json_encode($retorno);


    }
   

      
     function buscarDatos(){

    $page = $_GET['page']; // Obtiene la petición de la página a mostrar
    $limit = $_GET['rows']; // Obtiene cuantas filas queremos tener dentro de la rejilla
    $sidx = $_GET['sidx']; // Obtiene el campo indice "index" para ordenar los datos
    $sord = $_GET['sord']; // Obtiene la forma de ordenamiento
     
     /*FILTROS DE BUSQUEDA*/
    $nomResena= $_GET['nomResena']; 
    $tipo=$_GET['tipo'];
      //  echo "TIPO:".$tipo;
    if(!$sidx) $sidx =1;
  
    
     $entidadServicio= new ResenaLogica();
    $count = $entidadServicio->numeroRegistro($nomResena); 
     
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
     
     $resultado=$entidadServicio->buscarSearch($nomResena,$tipo,$start,$limit,$sidx,$sord);
    // print_r ($resultado);
     foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id']=$fila->id;
        $responce->rows[$i]['cell']=array($fila->id,
                                          $fila->descripcion,
                                              $fila       ->tipo  , 
                                              $fila->activo                       
                                          );
        $i++;
     }
 
    // Se devuelven los datos a mostrar en la rejilla   
    return $responce;  


}    
  function listarComboResenias($codigo,$descripcion,$tipo){

        $retorno=new Resultado();
        $obj=new ResenaLogica();
        $result = $obj->listarCombo($codigo,$descripcion,$tipo);

                    $retorno->result=1;
                    $retorno->message = "OK";
                    $retorno->data=$result;
        //echo"<pre>";         print_r($result);        echo"</pre>";
        return json_encode($retorno);
    }
 
?>
