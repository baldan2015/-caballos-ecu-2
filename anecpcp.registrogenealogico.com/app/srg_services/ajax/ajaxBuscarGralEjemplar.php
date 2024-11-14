<?php  session_start();
    include_once ("../logica/EjemplarLogica.php");
  //  include_once ("../entidad/Ejemplar.inc");
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
        if($_POST['opc']=='lstMadre'){
             $nombre = trim($_POST['request']);
             echo buscarMadre($nombre);
      }else if($_POST['opc']=='lstPadre'){
             $nombre = trim($_POST['request']);
             echo buscarPadre($nombre);
      
       }else if($_POST['opc']=='lstAll'){
             $nombre = trim($_POST['request']);
             echo buscarEjemplares($nombre);
      }  
      
       
   }
         if($_GET['opc']=='lstAlljqgrid'){
              $response=buscarEjemplarJQGrid();
             echo json_encode($response);
            }
    function buscarMadre($nombre){
            $retorno=new Resultado();
            $servicio= new EjemplarLogica();
            $data=$servicio->buscarMadre($nombre);
           
    
        if(count($data)>0){
        foreach ($data as $key => $value) {
            
            $html.= "<tr class='btnSelectBGEjemplar' data-prefijo=".$value->prefijo." data-codigo=".$value->codigo." data-nombre=".$value->nombre.">";
            $html.= "<td align='center'>".$value->codigo."</td>";
            $html.= "<td align='center'>".$value->prefijo."</td>";
            $html.= "<td align='center'>".$value->nombre."</td>";
            $html.= "<td align='center'>".$value->propietarios."</td>";
            //$html.= "<td align='center'>".$value->idPelaje."</td>";
            $html.= "</tr>";
            }
        }else {
            $html.= "<tr><td align='center' colspan='4'>".'No se encontraron datos'."</td></tr>";
        }
    
            return  $html;
        }
          function buscarPadre($nombre){
            $retorno=new Resultado();
            $servicio= new EjemplarLogica();
            $data=$servicio->buscarPadre($nombre);
            $html = "";
          
            if(count($data)>0){
        foreach ($data as $key => $value) {
         
            $html.= "<tr class='btnSelectBGEjemplar' data-prefijo=".$value->prefijo." data-codigo=".$value->codigo." data-nombre=".$value->nombre.">";
            $html.= "<td align='center'>".$value->codigo."</td>";
            $html.= "<td align='center'>".$value->prefijo."</td>";
            $html.= "<td align='center'>".$value->nombre."</td>";
            $html.= "<td align='center'>".$value->propietarios."</td>";
            //$html.= "<td align='center'>".$value->idPelaje."</td>";
            $html.= "</tr>";
            }
        }else {
             $html.= "<td align='center' colspan='5'>".'No se encontraron datos'."</td>";
        }
            return  $html;
    }

       function buscarEjemplares($nombre){
            $retorno=new Resultado();
            $servicio= new EjemplarLogica();
            $data=$servicio->buscarTodos($nombre);
            $html = "";
          
            if(count($data)>0){
        foreach ($data as $key => $value) {
         
            $html.= "<tr class='btnSelectBGEjemplar' data-prefijo=".$value->prefijo." data-codigo=".$value->codigo." data-nombre='".$value->nombre."' data-prop='".$value->propietarios."'>";
            $html.= "<td align='center'>".$value->codigo."</td>";
            $html.= "<td align='center'>".$value->prefijo."</td>";
            $html.= "<td align='center'>".$value->nombre."</td>";
            $html.= "<td align='center'>".$value->propietarios."</td>";
            //$html.= "<td align='center'>".$value->idPelaje."</td>";
            $html.= "</tr>";
            }
        }else {
             $html.= "<td align='center' colspan='5'>".'No se encontraron datos'."</td>";
        }
            return  $html;
    }

    function buscarEjemplarJQGrid(){
     $page = $_GET['page']; // Obtiene la petición de la página a mostrar
     $limit = $_GET['rows']; // Obtiene cuantas filas queremos tener dentro de la rejilla
     $sidx = $_GET['sidx']; // Obtiene el campo indice "index" para ordenar los datos
     $sord = $_GET['sord']; // Obtiene la forma de ordenamiento
     
     /*FILTROS DE BUSQUEDA*/
     $nomFiltro= $_GET['nomFiltro']; 
     $genero=$_GET['genero'];

 
    if(!$sidx) $sidx =1;
  
    
     $entidadServicio= new EjemplarLogica();
    $count = $entidadServicio->numeroRegistroGralEjemplar($nomFiltro,$genero); 
     
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
     
     $resultado=$entidadServicio->buscarSearchGralEjemplar($nomFiltro,$genero,$start,$limit,$sidx,$sord);
    // print_r ($resultado);
     foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id']=$fila->id;
        $responce->rows[$i]['cell']=array($fila->id,
                                          $fila->prefijo,
                                          $fila->nombre,
                                          $fila->propietarios,
                                          $fila->pelaje
                                          );
        $i++;
     }
 
    // Se devuelven los datos a mostrar en la rejilla   
    return $responce;  
}

?>
