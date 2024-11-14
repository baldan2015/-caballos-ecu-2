<?php  session_start();
    include_once ("../logica/EntidadLogica.php");
    include_once ("../entidad/Entidad.inc");
    include_once ("../entidad/Resultado.inc.php");    

    
 
    if (file_exists("../entidad/Constantes.php")) {
        include_once("../entidad/Constantes.php");
    }
//if(!isset($_POST["opc"]))   echo listarEntidad('','','','','','','')ajaxBuscarGralEntidad;

    if(isset($_POST["opc"])){

         $retorno=new Resultado();
     /*     $codigo = $_POST["codigo"];
        $nombre = $_POST["nombre"];
        $tlocal_codigo = $_POST["tlocal_codigo"];
        $responsable = $_POST["responsable"];
     */
      
        $usuario_crea = 1;
        $usuario_modi = 3;
        $codigo_empresa =1;
        $codigo_local = 1;
       
           // $hidTipoEnt=$_POST['hidTipoEnt'];
        if($_POST['opc']=='lstProp'){
             $nombre = trim($_POST['request']);
             echo buscarPropietario($nombre);
      }else if($_POST['opc']=='lstCri'){
             $nombre = trim($_POST['request']);
             echo buscarCriador($nombre);
      }
       
   }
        if($_GET['opc']=='lstAllPropjqgrid'){
              $response=buscarEntidadPropJQGrid();
             echo json_encode($response);
            }
            if($_GET['opc']=='lstAllCriajqgrid'){
              $response=buscarEntidadCriaJQGrid();
             echo json_encode($response);
            }
    function buscarPropietario($nombre){
            
            $servicio= new EntidadLogica();
            $data=$servicio->buscarPropietario($nombre);
          
          $html= "";
     
            if(count($data)>0){
        foreach ($data as $key => $value) {
         
            $html.= "<tr onclick=getIdProp('".$value->codigo."','".$value->idPropietario."'); >";
           
            $html.= "<td align='left'>
                  <input type='hidden' id='".$value->codigo.$value->idPropietario."' value='".$value->razonSocial."' >&nbsp;".$value->razonSocial."</td>";
           
            $html.= "</tr>";
            }
        }else {
            $html.= "<tr><td align='center' >".'No se encontraron datos'."</td></tr>";
        }
           

            return  $html;
        }
          function buscarCriador($nombre){
             $retorno=new Resultado();
            $servicio= new EntidadLogica();
            $data=$servicio->buscarCriador($nombre);

            $html = "";

            if(count($data)>0){
        foreach ($data as $key => $value) {
         
            $html.= "<tr onclick='getIdCri(".$value->codigo.");'>";
            $html.= "<td align='left'>".$value->razonSocial." <input type='hidden' id=".$value->codigo." value='".$value->razonSocial."'> </td>";
            $html.= "</tr>";
            }
        }else {
            $html.= "<tr><td align='center' colspan='6'>".'No se encontraron datos'."</td></tr>";
        }
           

            return  $html;
        }


        function buscarEntidadPropJQGrid(){
     $page = $_GET['page']; // Obtiene la petición de la página a mostrar
     $limit = $_GET['rows']; // Obtiene cuantas filas queremos tener dentro de la rejilla
     $sidx = $_GET['sidx']; // Obtiene el campo indice "index" para ordenar los datos
     $sord = $_GET['sord']; // Obtiene la forma de ordenamiento
     
     /*FILTROS DE BUSQUEDA*/
     $nomFiltro= $_GET['nomFiltro']; 
     //$prefEntidad=$_GET['prefEntidad'];

 
    if(!$sidx) $sidx =1;
  
    
     $entidadServicio= new EntidadLogica();
    $count = $entidadServicio->numeroRegistroGralEntidadProp($nomFiltro); 
     
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
     
     $resultado=$entidadServicio->buscarSearchGralEntidadProp($nomFiltro,$start,$limit,$sidx,$sord);
    //print_r ($resultado);
     foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id']=$fila->id.($fila->idProp==0?'':$fila->idProp);
        $responce->rows[$i]['cell']=array($fila->id,
                                         $fila->idProp,
                                        $fila->nombre,
                                        $fila->prefijo                                          
                                          );
        $i++;
     }
 
    // Se devuelven los datos a mostrar en la rejilla   
    return $responce;  
}
function buscarEntidadCriaJQGrid(){
     $page = $_GET['page']; // Obtiene la petición de la página a mostrar
     $limit = $_GET['rows']; // Obtiene cuantas filas queremos tener dentro de la rejilla
     $sidx = $_GET['sidx']; // Obtiene el campo indice "index" para ordenar los datos
     $sord = $_GET['sord']; // Obtiene la forma de ordenamiento
     
     /*FILTROS DE BUSQUEDA*/
     $nomFiltro= $_GET['nomFiltro']; 
     //$prefEntidad=$_GET['prefEntidad'];

 
    if(!$sidx) $sidx =1;
  
    
     $entidadServicio= new EntidadLogica();
    $count = $entidadServicio->numeroRegistroGralEntidadCria($nomFiltro); 
     
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
     
     $resultado=$entidadServicio->buscarSearchGralEntidadCria($nomFiltro,$start,$limit,$sidx,$sord);
    // print_r ($resultado);
     foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id']=$fila->id;
        $responce->rows[$i]['cell']=array($fila->id,
                                         $fila->idcria,
                                        $fila->nombre,
                                        $fila->prefijo                                          
                                          );
        $i++;
     }
 
    // Se devuelven los datos a mostrar en la rejilla   
    return $responce;  
}

?>
