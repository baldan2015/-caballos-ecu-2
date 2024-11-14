<?php session_start();
include_once("../logica/ResultadoConcursoLogica.php");
include_once("../entidad/Resultado.inc.php");

include_once("../comunes/lib.comun.php");

if (file_exists("../entidad/Constantes.php")) {
    include_once("../entidad/Constantes.php");
}


if (isset($_POST["opc"])) {

    $retorno = new Resultado();

    $usuario_crea = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
    $usuario_modi = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];

    if ($_POST["opc"] == "ins") {
        $concurso = $_POST["concurso"];
        $ejemplar = $_POST["codEjemplar"];
        $puesto = $_POST["puesto"];
        $propietario = $_POST["propietario"];
        $grupo = $_POST["grupo"];
        $categoria = $_POST["categoria"];
        $idProp=$_POST["idProp"];
        echo  insertar($concurso,$ejemplar,$puesto,$propietario,$grupo,$categoria,$idProp,$usuario_crea);
    } else if ($_POST["opc"] == "del") {
        $codigo = $_POST["key"];
        echo eliminar($codigo, $usuario_modi);
    } else if ($_POST["opc"] == "upd") {
        $codigo = $_POST["codigo"];
        $concurso = $_POST["concurso"];
        $ejemplar = $_POST["codEjemplar"];
        $puesto = $_POST["puesto"];
        $propietario = $_POST["propietario"];
        $grupo = $_POST["grupo"];
        $categoria = $_POST["categoria"];
        $idProp=$_POST["idProp"];
        echo editar($codigo,$concurso,$ejemplar,$puesto,$propietario,$grupo,$categoria,$idProp,$usuario_modi);
    } else if ($_POST["opc"] == "datos") {
        $id = $_POST["key"]; //$_POST["codigo"];
        echo datosConcurso($id);
        //echo  buscar();
    }else if($_POST["opc"] == "comboConcursos"){
        echo ComboConcursos();
    }
}
if (isset($_GET["opc"])) {
    if ($_GET["opc"] == "search") {
        echo  buscar();
    }else if($_GET["opc"]=="ejemplares"){
        echo  listarEjemplares();
    }
}

function ComboConcursos(){
   
    $retorno = new Resultado();
    $obj = new ResultadoConcursoLogica();
    $result = $obj-> ComboConcursos();

    $retorno->result = 1;
    $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
    $retorno->data = $result;
    //echo $result;
    return json_encode($retorno);
}

function insertar($concurso,$ejemplar,$puesto,$propietario,$grupo,$categoria,$idProp,$usuario)
{

    $retorno = new Resultado();
    if (validarSesion($retorno)->result == 1) {
        $ins = new ResultadoConcursoLogica();
        if ($concurso > 0) {
            $response = $ins->insertar($concurso,$ejemplar,$puesto,$propietario,$grupo,$categoria,$idProp,$usuario);
            if ($response->result == 1) {
                $retorno->result = $response->result;
                $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
            } else if ($response->result == 0) {
                $retorno->result = $response->result;
                $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
            } else if ($response->result == 2) {
                $retorno->result = 0;
                $retorno->message = "Ya existe el puesto número ".$puesto." del concurso, categoria y grupo seleccionado.";
            }
        } else {
            $retorno->result = 0;
            $retorno->message = "Ingrese el nombre del concurso.";
        }
    }
    return json_encode($retorno);
}

//Eliminar
function eliminar($codigo, $usuario)
{
    $retorno = new Resultado();
    if (validarSesion($retorno)->result == 1) {
        $objDel = new ResultadoConcursoLogica();

        $response = $objDel->eliminar($codigo, $usuario);

        if ($response->result  == 1) {
            $retorno->result = $response->result;
            $retorno->message = Constantes::K_MENSAJE_DELETE_OK;
        } else if ($response->result == 0) {
            $retorno->result = $response->result;
            $retorno->message = Constantes::K_MENSAJE_DELETE_NOOK_REF;
        }
    }
    return json_encode($retorno);
}



//Editar
function editar($codigo,$concurso,$ejemplar,$puesto,$propietario,$grupo,$categoria,$idProp,$usuario)
{
    $retorno = new Resultado();
    if (validarSesion($retorno)->result == 1) {
        $edi = new ResultadoConcursoLogica();
        $response = $edi->editar($codigo,$concurso,$ejemplar,$puesto,$propietario,$grupo,$categoria,$idProp,$usuario);
        if ($response->result == 1) {
            $retorno->result = $response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
        } else if ($response->result == 0) {
            $retorno->result = $response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
        } else if ($response->result == 2) {
            $retorno->result = 0;
            $retorno->message = "Ya existe el puesto número ".$puesto." del concurso, categoria y grupo seleccionado.";
        }
    }
    return json_encode($retorno);
}

function datosConcurso($id)
{
    $retorno = new Resultado();
    $obj = new ResultadoConcursoLogica();
    $result = $obj->datosConcurso($id);

    $retorno->result = 1;
    $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
    $retorno->data = $result;
    //echo $result;
    return json_encode($retorno);
}

function buscar()
{

    $page = $_GET['page']; // Obtiene la petición de la página a mostrar
    $limit = $_GET['rows']; // Obtiene cuantas filas queremos tener dentro de la rejilla
    $sidx = $_GET['sidx']; // Obtiene el campo indice "index" para ordenar los datos
    $sord = $_GET['sord']; // Obtiene la forma de ordenamiento

    /*FILTROS DE BUSQUEDA*/
    $nombre = $_GET['nombre'];
    $fecha = $_GET['fecha'];


    if (!$sidx) $sidx = 1;


    $entidadServicio = new ResultadoConcursoLogica();
    $count = $entidadServicio->numeroRegistro($nombre,$fecha);
    //echo $count;
    if ($count > 0) {
        $total_pages = ceil($count / $limit);
    } else {
        $total_pages = 0;
    }

    if ($page > $total_pages) $page = $total_pages;

    $start = $limit * $page - $limit;

    // Se declara la variable objeto la cual va imprimir los datos
    $responce = new stdClass();
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    $i = 0;

    $resultado = $entidadServicio->buscar($nombre,$fecha,$start,$limit,$sidx,$sord);
    //echo '-----------------';
    //print_r($resultado);
    foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id'] = $fila->idResultado;
        $responce->rows[$i]['cell'] = array(
           $fila->idResultado,
           $fila->idConcurso,
           $fila->concurso,
           $fila->fecha,
           $fila->juez,
           $fila->idEjemplar,
           $fila->desCategoria,
           $fila->desGrupo,
           $fila->nroPuesto,
           $fila->idResultado,
           $fila->propietario

           
        );
        $i++;
    }
    //print_r($responce);
    // Se devuelven los datos a mostrar en la rejilla   
    return json_encode($responce);
    // return ($responce);
}
function listarEjemplares(){
   
    $page = $_GET['page']; // Obtiene la petición de la página a mostrar
    $limit = $_GET['rows']; // Obtiene cuantas filas queremos tener dentro de la rejilla
    $sidx = $_GET['sidx']; // Obtiene el campo indice "index" para ordenar los datos
    $sord = $_GET['sord']; // Obtiene la forma de ordenamiento

    /*FILTROS DE BUSQUEDA*/
    $nombre = $_GET['ejemplar'];


    if (!$sidx) $sidx = 1;


    $entidadServicio = new ResultadoConcursoLogica();
    $count = $entidadServicio->numeroRegistroEjemplares($nombre);
    if ($count > 0) {
        $total_pages = ceil($count / $limit);
    } else {
        $total_pages = 0;
    }

    if ($page > $total_pages) $page = $total_pages;

    $start = $limit * $page - $limit;

    $responce = new stdClass();
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    $i = 0;

    $resultado = $entidadServicio->listarEjemplares($nombre,$start,$limit,$sidx,$sord);
    foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id'] = $fila->codigo;
        $responce->rows[$i]['cell'] = array(
           $fila->codigo,
           $fila->ejemplar,
           $fila->idProp,
           $fila->propietario
        );
        $i++;
    }
    return json_encode($responce);
}