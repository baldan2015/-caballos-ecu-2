<?php
    include_once ("../logica/EjemplarLogicaF2.php");

    $page = $_GET['page']; // Obtiene la petición de la página a mostrar
    $limit = $_GET['rows']; // Obtiene cuantas filas queremos tener dentro de la rejilla
    $sidx = $_GET['sidx']; // Obtiene el campo indice "index" para ordenar los datos
    $sord = $_GET['sord']; // Obtiene la forma de ordenamiento
     
     /*FILTROS DE BUSQUEDA*/
    $anio= $_GET['anio']; //:$("#txtCodigo").val(),
    $mes=$_GET['mes']; //:$("#txtPrefijo").val(),
   // $prop=$_GET['cboProp']; //:$("#dllProp").val(),
    $prop=$_GET['prop']; //:$("#ddlProps").val(),
    $estado=$_GET['estado']; 
    $activo=$_GET['activo']; 
 
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
    $count = $ejemplarServicio->numeroRegistroMonta($anio,$mes,$ls_prop,$estado,$activo);//$row['count'];
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
     
     $resultado=$ejemplarServicio->buscarSearchMonta($anio,$mes,$ls_prop,$estado,$start,$limit,$sidx,$sord,$activo);
// echo "<pre>";     print_r($resultado);
     foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id']=$fila->id;
        $responce->rows[$i]['cell']=array($fila->id,//0
        $fila->codigoMonta, //1
        $fila->yegua,//2
        $fila->codPotro,//3
        $fila->codYegua,//4
        $fila->idPotroExtranjero,//5
        $fila->idYeguaExtranjero,//6
        $fila->potro,//7
        $fila->idUser,//8
        $fila->metodo,//9
        $fila->idReceptor,//10
        $fila->fecEmbrion,//11
        $fila->fecMonta,     //12                                     
        $fila->fecParir,//13
        $fila->fecReg,//14
        $fila->estado,//15
        $fila->flagExtP,// 16
        $fila->flagExtY,// 17
        $fila->activo,// 18
        $fila->btnflag,// 19
        $fila->flagPeruP,// 20
        $fila->flagPeruY,//21
        $fila->flagTercero,// 22
        $fila->flagDocP,//23
        $fila->flagDocY//24
                                          //$fila->esSuperCamp==1?"<img src='images/icono/cc.png' width=12 />":""
                                          );
        $i++;
     }
 
    // Se devuelven los datos a mostrar en la rejilla   
    echo json_encode($responce);    
?>