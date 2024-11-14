<?php
    include_once ("../logica/EjemplarLogicaF2.php");
    include_once ("../constante.php");
    $page = $_GET['page']; // Obtiene la petición de la página a mostrar
    $limit = $_GET['rows']; // Obtiene cuantas filas queremos tener dentro de la rejilla
    $sidx = $_GET['sidx']; // Obtiene el campo indice "index" para ordenar los datos
    $sord = $_GET['sord']; // Obtiene la forma de ordenamiento
     
     /*FILTROS DE BUSQUEDA*/
    $anio= $_GET['anio']; //:$("#txtCodigo").val(),
    $mes=$_GET['mes']; //:$("#txtPrefijo").val(),
   // $prop=$_GET['cboProp']; //:$("#dllProp").val(),
    $prop=$_GET['prop']; //:$("#ddlProps").val(),
    $flag=$_GET['flag']; 

 
    if(!$sidx) $sidx =1;
 
    
   /* if($anio==''){
      $ls_anio = 0;
    }else{
      $ls_anio = $anio;
    }
*/

    if($prop==0){
      $ls_prop = '';
    }else{
      $ls_prop = $prop;
    }

     $ejemplarServicio= new EjemplarLogica();
    // Cantidad de registros para la paginación
    $count = $ejemplarServicio->numeroRegistroNovedades($anio,$mes,$ls_prop,$flag);//$row['count'];
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
    $pathWeb = ConstantesPathWeb::K_PATHWEB_TRANS_IMG;
    $i=0;
     


     $resultado=$ejemplarServicio->buscarSearchNovedades($anio,$mes,$ls_prop,$flag,$start,$limit,$sidx,$sord);
 //echo "<pre>";     print_r($resultado);
     foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id']=$fila->id;
        $responce->rows[$i]['cell']=array($fila->id,
                                          $fila->codigo,
                                          $fila->prefijo,
                                          $fila->ejemplar,
                                          $fila->fecha,
                                          $fila->fecCrea,
                                          $fila->prop,
                                          $fila->nuevoPropietario,
                                          $fila->comentarioSocio,
                                          $fila->ruta,
                                          $fila->estado,
                                          $fila->comentario,
                                          $fila->fecRevision,
                                          $fila->flagNewProp,
                                          $fila->codContacto,
                                          $pathWeb
                                          );
        $i++;
     }
 
    // Se devuelven los datos a mostrar en la rejilla   
    echo json_encode($responce);    
?>