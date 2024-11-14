<?php  session_start();
    include_once ("../logica/DepartamentoLogica.php");
    include_once ("../entidad/Departamento.inc");
    include_once ("../entidad/Resultado.inc.php");    

         
 
    if (file_exists("../entidad/Constantes.php")) {
        include_once("../entidad/Constantes.php");
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
     if($_POST["opc"]=="lstItems"){
           $codigo="0";//$_POST["codigo"];
           $descripcion="";//$_POST["descripcion"];
           echo listarComboTipoDepart($codigo,$descripcion);
        }
     
    

    }
     if(isset($_GET["opc"])){
        if($_GET["opc"]=="jqgrid"){
           
            $response=buscarDatos();
            echo json_encode($response);
        }
    }

     function listarComboTipoDepart($codigo,$descripcion){

        $retorno=new Resultado();
        $obj=new DepartamentoLogica();
        $result = $obj->listarComboTipoDepart($codigo,$descripcion);

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
    $nomDepart= $_GET['nomDepart']; 
    

 
    if(!$sidx) $sidx =1;
  
    
     $entidadServicio= new DepartamentoLogica();
    $count = $entidadServicio->numeroRegistro($nomDepart); 
     
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
     
     $resultado=$entidadServicio->buscarSearch($nomDepart,$start,$limit,$sidx,$sord);
    // print_r ($resultado);
     foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id']=$fila->id;
        $responce->rows[$i]['cell']=array($fila->id,
                                          $fila->descripcion
                                          );
        $i++;
     }
 
    // Se devuelven los datos a mostrar en la rejilla   
    return $responce;  


}    
?>
