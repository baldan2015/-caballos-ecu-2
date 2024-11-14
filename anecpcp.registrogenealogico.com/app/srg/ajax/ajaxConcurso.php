<?php session_start();
include_once("../logica/ConcursoLogica.php");
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
        $nombre = addslashes($_POST["nombre"]);
        $fecha = $_POST["fecha"];
        $juez = $_POST["juez"];
        echo  insertar($nombre, $fecha, $juez, $usuario_crea);
    } else if ($_POST["opc"] == "del") {
        $codigo = $_POST["key"];
        echo eliminar($codigo, $usuario_modi);
    } else if ($_POST["opc"] == "upd") {
        $codigo = $_POST["codigo"];
        $nombre = addslashes($_POST["nombre"]);
        $fecha = $_POST["fecha"];
        $juez = $_POST["juez"];
        echo editar($codigo, $nombre, $fecha, $juez, $usuario_modi);
    } else if ($_POST["opc"] == "datos") {
        $id = $_POST["key"]; //$_POST["codigo"];
        echo datosConcurso($id);
        //echo  buscar();
    }
}
if (isset($_GET["opc"])) {
    if ($_GET["opc"] == "search") {
        echo  buscar();
    }
}

function insertar($nombre, $fecha, $juez, $usuario)
{

    $retorno = new Resultado();
    if (validarSesion($retorno)->result == 1) {
        $ins = new ConcursoLogica();
        if (strlen($nombre) > 0) {
            $response = $ins->insertar($nombre, $fecha, $juez, $usuario);
            if ($response->result == 1) {
                $retorno->result = $response->result;
                $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
            } else if ($response->result == 0) {
                $retorno->result = $response->result;
                $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
            } else if ($response->result == 2) {
                $retorno->result = 0;
                $retorno->message = "Ya existe el nombre del concurso.";
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
        $objDel = new ConcursoLogica();

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
function editar($codigo, $nombre, $fecha, $juez, $usuario)
{
    $retorno = new Resultado();
    if (validarSesion($retorno)->result == 1) {
        $edi = new ConcursoLogica();
        $response = $edi->editar($codigo, $nombre, $fecha, $juez, $usuario);
        if ($response->result == 1) {
            $retorno->result = $response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
        } else if ($response->result == 0) {
            $retorno->result = $response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
        } else if ($response->result == 2) {
            $retorno->result = 0;
            $retorno->message = "El nombre del concurso que desea actualizar ya existe.";
        }
    }
    return json_encode($retorno);
}

function datosConcurso($id)
{
    $retorno = new Resultado();
    $obj = new ConcursoLogica();
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



    if (!$sidx) $sidx = 1;


    $entidadServicio = new ConcursoLogica();
    $count = $entidadServicio->numeroRegistro($nombre);
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

    $resultado = $entidadServicio->buscar($nombre, $start, $limit, $sidx, $sord);
    //echo '-----------------';
    //print_r($resultado);
    foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id'] = $fila->idConcurso;
        $responce->rows[$i]['cell'] = array(
            $fila->idConcurso,
            $fila->nombre,
            $fila->fecha,
            $fila->juez,
            $fila->activo
        );
        $i++;
    }
    //print_r($responce);
    // Se devuelven los datos a mostrar en la rejilla   
    return json_encode($responce);
    // return ($responce);
}
