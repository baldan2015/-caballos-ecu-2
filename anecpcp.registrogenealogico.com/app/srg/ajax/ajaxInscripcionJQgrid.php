<?php
    include_once ("../logica/EjemplarLogicaF2.php");

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
    $estado=$_GET['estado']; //:$("#txtMax").val()

    //echo "<span>".$_GET['prop']."-".$_GET['sord']."</span>";
 
    if(!$sidx) $sidx =1;
    if($estado == "A"){
        $vestado=1;
    }else if($estado == "I"){
        $vestado=0;
    }else{
        $vestado=2;
    }
    
     $ejemplarServicio= new EjemplarLogica();
    // Cantidad de registros para la paginación
    $count = $ejemplarServicio->numeroRegistro($idEjemplar,$prefijo,$nombre,$prop,$vestado,$ente);//$row['count'];
    // echo $count." ..<br>";
    if( $count >0 )
    { $total_pages = ceil($count/$limit); }
    else { $total_pages = 0; }
     
    if ($page > $total_pages) $page=$total_pages;
         
    $start = $limit*$page - $limit;
    if($start == -15){
        $start = 0;
    }
    // Se declara la variable objeto la cual va imprimir los datos
    $responce = new stdClass;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    $i=0;
     
     $resultado=$ejemplarServicio->buscarSearch($idEjemplar,$prefijo,$nombre,$prop,$vestado,$ente,$start,$limit,$sidx,$sord);
// echo "<pre>";     print_r($resultado);
     foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id']=$fila->codigo;
        $responce->rows[$i]['cell']=array($fila->codigo,
                                          $fila->codigoInscripcion,
                                          $fila->codEjemplar,
                                          $fila->prefijo,
                                          $fila->nombre,
                                          $fila->fecNace,
                                          $fila->fecCrea,                                          
                                          $fila->propietarios,
                                          $fila->criadores,
                                          $fila->nombrePelaje,
                                          $fila->LugarNace,
                                          $fila->estado,
                                          $fila->estadoSol
                                          //$fila->esSuperCamp==1?"<img src='images/icono/cc.png' width=12 />":""
                                          );
        $i++;
     }
 
    // Se devuelven los datos a mostrar en la rejilla   
    echo json_encode($responce);    
?>