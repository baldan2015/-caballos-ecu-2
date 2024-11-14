<?php
    include_once ("../logica/EjemplarLogica.php");

    $page = $_GET['page']; // Obtiene la petición de la página a mostrar
    $limit = $_GET['rows']; // Obtiene cuantas filas queremos tener dentro de la rejilla
    $sidx = $_GET['sidx']; // Obtiene el campo indice "index" para ordenar los datos
    $sord = $_GET['sord']; // Obtiene la forma de ordenamiento
     
     /*FILTROS DE BUSQUEDA*/
    $idEjemplar= $_GET['idEjemplar']; //:$("#txtCodigo").val(),
    $prefijo=$_GET['prefijo']; //:$("#txtPrefijo").val(),
    $nombre=addslashes($_GET['nombre']); //:$("#txtNombre").val(),
   // $prop=$_GET['cboProp']; //:$("#dllProp").val(),
    $prop=$_GET['prop']; //:$("#txtProp").val(),
    $ente=$_GET['ente']; //:$("#txtProp").val(),
    $cria=$_GET['cria']; //:$("#txtCria").val(),
    $sexo=$_GET['sexo']; //:$("#ddlGenero").val(),
    $edadDesde=$_GET['edadDesde']; //:$("#txtMin").val(),
    $edadhasta=$_GET['edadhasta']; //:$("#txtMax").val()
    $estado=$_GET['estado']; //:$("#txtMax").val()

 
    if(!$sidx) $sidx =1;
 
    
     $ejemplarServicio= new EjemplarLogica();
    // Cantidad de registros para la paginación
    $count = $ejemplarServicio->numeroRegistro($idEjemplar,$prefijo,$nombre,$prop,$cria,$sexo,$edadDesde,$edadhasta,$estado,$ente);//$row['count'];
    // echo $count." ..<br>";
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
     
     $resultado=$ejemplarServicio->buscarSearch($idEjemplar,$prefijo,$nombre,$prop,$cria,$sexo,$edadDesde,$edadhasta,$estado,$ente,$start,$limit,$sidx,$sord);
// echo "<pre>";     print_r($resultado);
     foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id']=$fila->codigo;
        $responce->rows[$i]['cell']=array($fila->codigo,
                                          $fila->prefijo,
                                          $fila->nombre,
                                          $fila->fecNace,
                                          $fila->fecReg,                                          
                                          $fila->propietarios,
                                          $fila->criadores,
                                          $fila->fecFallece,
                                          $fila->nombrePelaje,
                                          $fila->LugarNace,
                                          $fila->microchip,
                                          $fila->capado,
                                          $fila->esSuperCamp==1?"<img src='images/icono/cc.png' width=12 />":"",
                                          $fila->estado
                                          );
        $i++;
     }
 
    // Se devuelven los datos a mostrar en la rejilla   
    echo json_encode($responce);    
?>