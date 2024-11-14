<?php session_start();
include_once("../logica/EjemplarLogica.php");
include_once("../logica/PropietarioLogLogica.php");
include_once("../entidad/Ejemplar.inc.php");
include_once("../entidad/Resultado.inc.php");
include_once("../logica/ResenaLogica.php");
include_once("../comunes/lib.comun.php");



if (file_exists("../entidad/Constantes.php")) {
    include_once("../entidad/Constantes.php");
}



if (isset($_POST["opc"])) {


    $usuario_crea = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
    $usuario_modi = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
    $codigo_empresa = 0;
    $codigo_local = 0;


    if ($_POST["opc"] == "lst") {
        $prefijo = $_POST["prefijo"];
        $nombre = addslashes($_POST["nombre"]);
        $fecNace = $_POST["fecNace"];
        $fecFallece = $_POST["fecFallece"];
        $idPelaje = $_POST["idPelaje"];
        $LugarNace = addslashes($_POST["LugarNace"]);
        $microchip = $_POST["microchip"];
        $adn = $_POST["adn"];

        echo  listarEjemplar($prefijo, $nombre, $fecNace, $fecFallece, $idPelaje, $LugarNace, $microchip, $adn);
    } else if ($_POST["opc"] == "ins") {
        $retorno = new Resultado();
        $codigo = $_POST["codigo"];
        $prefijo = $_POST["prefijo"];
        $nombre = addslashes($_POST["nombre"]);
        $fecNace = $_POST["fecNace"];
        $padre = $_POST["padre"];
        $madre = $_POST["madre"];
        $idPelaje = $_POST["idPelaje"];
        $lugarNace = addslashes($_POST["lugarNace"]);
        $microchip = $_POST["microchip"];
        $adn = $_POST["adn"];
        $descripcion = addslashes($_POST["descripcion"]);
        $entidad = $_POST["entidad"];
        $genero = $_POST["genero"];
        $fecCapado = $_POST["fecCapado"];
        $fecFallece = $_POST["fecFallece"];
        $motivoFallece = addslashes($_POST["motivoFallece"]);
        $idProvincia = $_POST["idProvincia"];
        $origen = $_POST["origen"];
        $resenias = $_POST["resenias"];
        $fecReg = $_POST["fecReg"];
        $nroLibro = $_POST["nroLibro"];
        $nroFolio = $_POST["nroFolio"];
        $fecServ = $_POST["fecServ"];
        $metodo = $_POST["idMetodo"];

        //print_r( $propie);
        echo insertar(
            $codigo,
            $prefijo,
            $nombre,
            $fecNace,
            $padre,
            $madre,
            $idPelaje,
            $lugarNace,
            $microchip,
            $adn,
            $descripcion,
            $usuario_crea,
            $genero,
            $fecCapado,
            $fecFallece,
            $motivoFallece,
            $idProvincia,
            $origen,
            $resenias,
            $fecReg,
            $nroLibro,
            $nroFolio,
            $fecServ,
            $metodo
        );
    } else if ($_POST["opc"] == "upd") {
        $codigo = $_POST["codigo"];
        $prefijo = $_POST["prefijo"];
        $nombre = addslashes($_POST["nombre"]);
        $fecNace = $_POST["fecNace"];
        $padre = $_POST["padre"];
        $madre = $_POST["madre"];
        $idPelaje = $_POST["idPelaje"];
        $lugarNace = addslashes($_POST["lugarNace"]);
        $microchip = $_POST["microchip"];
        $adn = $_POST["adn"];
        $descripcion = addslashes($_POST["descripcion"]);
        $genero = $_POST["genero"];
        $fecCapado = $_POST["fecCapado"];
        $fecFallece = $_POST["fecFallece"];
        $motivoFallece = addslashes($_POST["motivoFallece"]);
        $idProvincia = $_POST["idProvincia"];
        $origen = $_POST["origen"];
        $resenias = $_POST["resenias"];
        $fecReg = $_POST["fecReg"];
        $nroLibro = $_POST["nroLibro"];
        $nroFolio = $_POST["nroFolio"];
        $fecServ = $_POST["fecServ"];
        $metodo = $_POST["idMetodo"];

        echo editar($codigo, $prefijo, $nombre, $fecNace, $padre, $madre, $idPelaje, $lugarNace, $microchip, $adn, $descripcion, $usuario_modi, $genero, $fecCapado, $fecFallece, $motivoFallece, $idProvincia, $resenias, $fecReg, $nroLibro, $nroFolio, $fecServ, $metodo, $origen);
    } elseif ($_POST["opc"] == "del") {
        $codigo = $_POST["key"];
        echo eliminar($codigo, $usuario_modi);
    } elseif ($_POST["opc"] == "die") {
        $codigo = $_POST["key"];
        $motivoFallece = addslashes($_POST["motivo"]);
        $fecFallece = $_POST["fecFallece"];
        echo falleceEjemplar($codigo, $usuario_modi, $motivoFallece, $fecFallece);
    } elseif ($_POST["opc"] == "get") {
        $codigo = $_POST["codigo"];
        echo obtenerID($codigo);
    } elseif ($_POST["opc"] == "vdel") {
        echo validarEliminar($codigo);
    } elseif ($_POST["opc"] == "delAll") {
        $codigo = $_POST["keys"];
        echo eliminarVarios($codigo, $usuario_modi);
    } else if ($_POST["opc"] == "setProp") {
        $codigo = $_POST["codigo"];
        echo  setProp($codigo);
    } else if ($_POST["opc"] == "setEntSession") {

        $retorno = new Resultado();
        $codigo = $_POST["codigo"];
        $nombres = $_POST["nombre"];



        $result =  agregarEntidad($codigo, $nombres, $origen, $idProp);
        if ($result) {
            $retorno->result = 1;
            $retorno->html = listarPreEntidad($origen);
        } else {
            $retorno->result = 0;
        }
        echo json_encode($retorno);
    } else if ($_POST["opc"] == "resSession") {

        $retorno = new Resultado();

        $resenas = json_decode($_POST["data"]);
        //print_r($resenas);

        $result =  setResenas($resenas);

        if ($result != "") {
            $retorno->result = 1;
            $retorno->html = $result;
            //$retorno->html= listarPreEntidad($origen);
        } else {
            $retorno->result = 1;
            $retorno->message = "No hay items para registrar";
        }


        echo json_encode($retorno);
        //echo $result;

    } else if ($_POST["opc"] == "lstItemsSel") {
        $codigo = $_POST["codigo"];
        $descripcion = ""; //$_POST["descripcion"];
        echo listarComboReseniasRight($codigo, $descripcion);
    } else if ($_POST["opc"] == "clsSesionResena") {
        echo clsSessionResena();
    } else if ($_POST["opc"] == "lstMtdoReprop") {
        $id = "0"; //$_POST["codigo"];
        $descripcion = ""; //$_POST["descripcion"];
        echo listaComboMtdoReprop($id, $descripcion);
    } else if ($_POST["opc"] == "val") {
        $fechaServ = $_POST["fecServ"];
        $fechaNac = $_POST["fecNace"];
        $idMadre = $_POST["idmadre"];
        $idHijo = $_POST["idHijo"];
        echo validarFecha($fechaServ, $fechaNac, $idMadre, $idHijo);
    } else if ($_POST["opc"] == "listIdNac") {
        $id = "0";
        $descripcion = "";
        $prop = $_POST["prop"];
        $flag = $_POST["flag"];
        echo listaComboIdNac($prop, $flag);
    } else if ($_POST["opc"] == "info") {
        $id = $_POST["codigo"];
        echo obtenerDatosNacimientoEjemplar($id);
    } else if ($_POST["opc"] == "listIdMonta") {
        $id = "0";
        $descripcion = "";
        $prop = $_POST["prop"];
        $flag = $_POST["flag"];
        echo listaComboIdMonta($prop, $flag);
    } else if ($_POST["opc"] == "lstPais") {
        echo listarPais();
    } else if ($_POST["opc"] == "lstTipoDoc") {
        echo listarTipoDocumento();
    } else if ($_POST["opc"] == "lstMotivoBaja") {
        echo listarMotivoBaja();
    }
}



//Listar pelakes datatable
function listarEjemplar2($prefijo, $nombre, $fecNace, $fecFallece, $idPelaje, $LugarNace, $microchip, $adn)
{
    $retorno = new Resultado();
    $servicio = new EjemplarLogica();
    return json_encode($servicio->buscarDataTable2($prefijo));
};
//Listar pelakes datatable
function listarEjemplar($prefijo, $nombre, $fecNace, $fecFallece, $idPelaje, $LugarNace, $microchip, $adn)
{
    $retorno = new Resultado();
    $servicio = new EjemplarLogica();
    return json_encode($servicio->buscarDataTable());
};
//Insertar

function insertar($codigo, $prefijo, $nombre, $fecNace, $padre, $madre, $idPelaje, $lugarNace, $microchip, $adn, $descripcion, $usuario_crea, $genero, $fecCapado, $fecFallece, $motivoFallece, $idProvincia, $origen, $resenias, $fecReg, $nroLibro, $nroFolio, $fecServ, $metodo)
{
    $retorno = new Resultado();
    if (validarSesion($retorno)->result == 1) {
        $ins = new EjemplarLogica();

        $datos = $_SESSION['_datosRes'];
        if (is_array($datos)) {
            foreach ($datos as $key => $value) {
                $codResenas[] = $value['id'];
            }
        }
        $resenias = $codResenas;
        //if(strlen($nombre)>0 && strlen($prefijo) >0 ){
        $propietarios = listPropietarios();
        $criadores = listCriadores();

        $response = $ins->insertar($codigo, $prefijo, $nombre, $fecNace, $padre, $madre, $idPelaje, $lugarNace, $microchip, $adn, $descripcion, $usuario_crea, $genero, $fecCapado, $propietarios, $criadores, $fecFallece, $motivoFallece, $idProvincia, $origen, $resenias, $fecReg, $nroLibro, $nroFolio, $fecServ, $metodo);

        if ($response->result == 1) {
            $retorno->result = $response->result;
            $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
        } else if ($response->result == 0) {
            $retorno->result = $response->result;
            $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
        } else if ($response->result == 2) {
            $retorno->result = 0;
            $retorno->message = "El ejemplar ya existe";
        } else if ($response->result == 3) {
            $retorno->result = 0;
            $retorno->message = "No se puede repetir el número de libro con el númuero de folio";
        } else if ($response->result == 4) {
            $retorno->result = 0;
            $retorno->message = Constantes::K_MENSAJE_NOOK_CRIADOR;
        } else if ($response->result == 5) {
            $retorno->result = 0;
            $retorno->message = Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE;
        } else if ($response->result == 6) {
            $retorno->result = 0;
            $retorno->message = Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE_ERROR;
        } else if ($response->result == 999) {
            $retorno->result = 0;
            $retorno->message = Constantes::K_MENSAJE_PREF_NOMBRE_DUPLICATE;
        } else if ($response->result == 998) {
            $retorno->result = 0;
            $retorno->message = Constantes::K_MENSAJE_NOMBRE_SUPER_CAMP;
        } else {
            $retorno->result = 2;
            $retorno->message = "Ingrese el nombre del ejemplar.";
        }
    }
    return json_encode($retorno);
    //}
}
//Eliminar
function eliminar($codigo, $usuario_modi)
{
    $retorno = new Resultado();
    // echo $codigo;
    if (validarSesion($retorno)->result == 1) {
        $objDel = new EjemplarLogica();
        $result = $objDel->eliminar($codigo, $usuario_modi);

        if ($result == 1) {
            $retorno->result = 1;
            $retorno->message = Constantes::K_MENSAJE_DELETE_OK;
        } else {
            $retorno->result = 0;
            $retorno->message = Constantes::K_MENSAJE_DELETE_NOOK;
        }
    }
    return json_encode($retorno);
}
//ELIMNAR VARIOS ITEMS
function eliminarVarios($listCodigos, $usuario_modi)
{
    $retorno = new Resultado();
    if (validarSesion($retorno)->result == 1) {
        $objDel = new EjemplarLogica();
        $c = 0;
        foreach ($listCodigos as $key) {
            $result = $objDel->eliminar($key, $usuario_modi);
            if ($result == 1) $c++;
            else              $c--;
        }
        if (sizeof($listCodigos) == $c) {
            $retorno->result = 1;
            $retorno->message = "Se eliminaron correctamente todos los registros";
        } else if (sizeof($listCodigos) > $c) {
            $retorno->result = 0;
            $retorno->message = "No se eliminaron todos los registros, verifíque";
        } else if ($c == 0) {
            $retorno->result = 0;
            $retorno->message = "No se envió la lista de codigos para eliminar";
        } else {
            $retorno->result = 0;
            $retorno->message = "No se pudo eliminar los registros enviados.";
        }
    }
    return json_encode($retorno);
}

//Obtener ID
function obtenerID($codigo)
{

    $retorno = new Resultado();
    if (validarSesion($retorno)->result == 1) {
        $get = new EjemplarLogica();

        $result = $get->obtenerID($codigo);
        // echo"<pre>";print_r($result);
        $result->idResenias = unserialize($result->idResenias);
        //$result->resenasDescripcion=$resenastxt;
        //$result->resenasDescripcion=
        // print_r($result->idResenias);
        //print_r(unserialize("a:2:{i:0;s:2:"12";i:1;s:1:"9";}"));
        unset($_SESSION['_datosRes']);
        unset($_SESSION['_datosProp']);
        unset($_SESSION['_datosCri']);


        //echo "<pre>"; print_r($result->propietarios);
        if ($result->propietarios != null) {
            foreach ($result->propietarios as $key => $propietario) {
                $_SESSION['_datosProp'][] = array(
                    'codigo' => $propietario->codigo,
                    'nombres' => $propietario->nombres,
                    'origen' => 'BD',
                    'idEntidad' => $propietario->idEntidad,
                    'idPropietario' => $propietario->idPropietario
                );
            }
        }
        if ($result->criadores != null) {
            foreach ($result->criadores as $key => $criador) {
                $_SESSION['_datosCri'][] = array(
                    'codigo' => $criador->codigo,
                    'nombres' => $criador->nombres,
                    'origen' => 'BD',
                    'idEntidad' => $criador->idCriador
                );
            }
        }
        if ($result->idResenias != null) {
            $res = $result->idResenias;
            // unset($_SESSION['_datosRes']);
            foreach ($res as $key => $resenas) {
                // echo $key."gg".$resenas."<br>";
                $get = new ResenaLogica();
                $re = $get->obtenerID($resenas);
                // print_r($re);
                $_SESSION['_datosRes'][] = array(
                    'id' => $resenas,
                    'descripcion' => $re->descripcion
                );
                //$resenastxt=$resenastxt.$resenas.",";
                $resenastxt = $resenastxt . " " . $re->descripcion;
            }
            //echo "<pre>";
            //print_r($_SESSION);
            // echo "</pre>";
            //echo $resenastxt."ff";
        }


        if (is_null($result)) {
            $retorno->result = 0;
            $retorno->message = "No se encontro datos";
        } else {
            $retorno->result = 1;
            $retorno->message = "dato encontrado";
            $retorno->data = $result;
            $retorno->html = listarCriaPropLog(1);
            $retorno->html2 = listarCriaPropLog(2);
            $result->resenasDescripcion = $resenastxt . "";
        }
    }
    return json_encode($retorno);
}

//Editar
function editar($codigo, $prefijo, $nombre, $fecNace, $padre, $madre, $idPelaje, $lugarNace, $microchip, $adn, $descripcion, $usuario_modi, $genero, $fecCapado, $fecFallece, $motivoFallece, $idProvincia, $resenias, $fecReg, $nroLibro, $nroFolio, $fecServ, $metodo, $origen)
{
    $retorno = new Resultado();
    if (validarSesion($retorno)->result == 1) {
        $edi = new EjemplarLogica();

        $datos = $_SESSION['_datosRes'];
        // echo"<pre>"; print_r($datos);echo"</pre>";
        $i = 0;
        if (is_array($datos)) {
            foreach ($datos as $key => $value) {
                $codResenas[] = $value['id'];
                $i++;
            }
        }
        $resenias = $codResenas;
        /*addon dbs 20190901. 
                    si la session de reseñas falló o no cargó mantiene las reseñas actuales.
                */
        if ($i == 0) {
            $resultOriginal = $edi->obtenerID($codigo);
            $resenias = unserialize($resultOriginal->idResenias);
        }

        $propietarios = listPropietarios();
        $criadores = listCriadores();
        $propietariosDEL = listPropietariosDEL();
        $criadoresDEL = listCriadoresDEL();

        $response = $edi->editar($codigo, $prefijo, $nombre, $fecNace, $padre, $madre, $idPelaje, $lugarNace, $microchip, $adn, $descripcion, $usuario_modi, $genero, $fecCapado, $propietarios, $criadores, $propietariosDEL, $criadoresDEL, $fecFallece, $motivoFallece, $idProvincia, $resenias, $fecReg, $nroLibro, $nroFolio, $fecServ, $metodo, $origen);


        if ($response->result == 1) {
            $retorno->result = $response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
        } else if ($response->result == 0) {
            $retorno->result = 0;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
        } else if ($response->result == 2) {
            $retorno->result = 0;
            $retorno->message = "El ejemplar ya esta actualizado";
        } else if ($response->result == 3) {
            $retorno->result = 0;
            $retorno->message = "No se puede repetir el número de libro con el númuero de folio";
        } else if ($response->result == 4) {
            $retorno->result = 0;
            $retorno->message = Constantes::K_MENSAJE_NOOK_CRIADOR;
        } else if ($response->result == 5) {
            $retorno->result = 0;
            $retorno->message = Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE;
        } else if ($response->result == 6) {
            $retorno->result = 0;
            $retorno->message = Constantes::K_MENSAJE_COOPROPIEDAD_VALIDATE_ERROR;
        } else if ($response->result == 999) {
            $retorno->result = 0;
            $retorno->message = Constantes::K_MENSAJE_PREF_NOMBRE_DUPLICATE;
        } else if ($response->result == 998) {
            $retorno->result = 0;
            $retorno->message = Constantes::K_MENSAJE_NOMBRE_SUPER_CAMP;
        } else {
            $retorno->result = 0;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
        }
    }
    return json_encode($retorno);
}





function falleceEjemplar($codigo, $usuario_modi, $motivoFallece, $fecFallece)
{
    $retorno = new Resultado();
    if (validarSesion($retorno)->result == 1) {
        $objDel = new EjemplarLogica();
        $result = $objDel->fallece($codigo, $usuario_modi, $motivoFallece, $fecFallece);

        if ($result == 1) {
            $retorno->result = 1;
            $retorno->message = "Fallecimiento registrado correctamente";
        } else {
            $retorno->result = 0;
            $retorno->message = "Error al actualizar";
        }
    }
    return json_encode($retorno);
}
function setProp($codigo)
{
    $retorno = new Resultado();
    $objDel = new EjemplarLogica();
    $result = $objDel->setProp($codigo);
}
function listarCriaPropLog($origen)
{
    if ($origen == 1) {
        $entidad = $_SESSION['_datosProp'];
    } else {
        $entidad = $_SESSION['_datosCri'];
    }
    $html = listarFilasCriaProp($entidad, $origen);
    return $html;
}

function listPropietarios()
{
    $entidad = $_SESSION['_datosProp'];
    if (is_array($entidad)) {
        foreach ($entidad as $key => $value) {
            $list[] = array(
                'idEntidad' => $entidad[$key]['idEntidad'],
                'idPropietario' => $entidad[$key]['idPropietario'],
                'origen' => $entidad[$key]['origen'],
                'idPropLog' => $entidad[$key]['codigo']
            );
        }
    }
    return $list;
}
function listCriadores()
{
    $entidad = $_SESSION['_datosCri'];
    if (is_array($entidad)) {
        foreach ($entidad as $key => $value) {
            $list[] = array(
                'idEntidad' => $entidad[$key]['idEntidad'],
                'origen' => $entidad[$key]['origen'],
                'idCriaLog' => $entidad[$key]['codigo']
            );
        }
    }
    return $list;
}

function listPropietariosDEL()
{
    $entidad = $_SESSION['_datosPropDEL'];

    if (is_array($entidad)) {
        foreach ($entidad as $key => $value) {
            $list[] = array(
                'idPropLog' => $entidad[$key]['codigo'],
                'idEntidad' => $entidad[$key]['idEntidad']
            );
        }
    }
    //echo("<PRE>");         print_r($entidad);
    return $list;
}
function listCriadoresDEL()
{
    $entidad = $_SESSION['_datosCriDEL'];
    if (is_array($entidad)) {
        foreach ($entidad as $key => $value) {
            $list[] = array(
                'idCriaLog' => $entidad[$key]['codigo'],
                'idEntidad' => $entidad[$key]['idEntidad']
            );
        }
    }
    return $list;
}

function setResenas($resenas)
{

    unset($_SESSION['_datosRes']);
    $resenastxt = "";

    foreach ($resenas as $key => $resenas) {
        $_SESSION['_datosRes'][] = array(
            'id' => $resenas->id,
            'descripcion' => $resenas->descripcion,
            'tipo' => $resenas->tipo
        );
        $resenastxt = $resenastxt . $resenas->descripcion . " ";
    }

    return  $resenastxt;
}
function listarComboReseniasRight($codigo, $descripcion)
{
    //unset($_SESSION['_datosRes']);
    $retorno = new Resultado();
    //$obj=new ResenaLogica();
    $datos = $_SESSION['_datosRes'];
    // print_r($_SESSION['_datosRes'])
    $i = 0;
    if (is_array($datos)) {
        foreach ($datos as $key => $value) {
            $list[] = array(
                'id' => $value['id'],
                'descripcion' => $value['descripcion']
            );
            $i++;
        }
    }
    /*addon dbs 20190901 */
    if ($i == 0) {
        $getEje = new EjemplarLogica();
        $result = $getEje->obtenerID($codigo);

        if ($result->idResenias != "") {
            $result->idResenias = unserialize($result->idResenias);
            if ($result->idResenias != null) {
                $get = new ResenaLogica();
                foreach ($result->idResenias as $key => $resenas) {
                    $re = $get->obtenerID($resenas);
                    $_SESSION['_datosRes'][] = array(
                        'id' => $resenas,
                        'descripcion' => $re->descripcion
                    );
                    $list[] = array(
                        'id' => $resenas,
                        'descripcion' => $re->descripcion
                    );
                }
            }
        }
    }

    $retorno->result = 1;
    $retorno->message = "OK";
    $retorno->data = $list;

    return json_encode($retorno);
}

function clsSessionResena()
{
    unset($_SESSION['_datosRes']);
    return "1";
}

function listaComboMtdoReprop($id, $descripcion)
{
    $retorno = new Resultado();
    $obj = new  EjemplarLogica();
    $result = $obj->listaComboMtdoReprop($id, $descripcion);

    $retorno->result = 1;
    $retorno->message = "Cargo correctamente el combo";
    $retorno->data = $result;

    return json_encode($retorno);
}

function validarFecha($fechaServ, $fechaNac, $idMadre, $idHijo)
{
    $retorno = new Resultado();
    if ($fechaServ == "" || $fechaNac == "") {
        $retorno->result = 1;
        return json_encode($retorno);
    } else {

        $obj = new EjemplarLogica();
        $response = $obj->validarFecha($fechaServ, $fechaNac, $idMadre, $idHijo);
        // print_r($response);
        if ($response->result == 1) {
            $retorno->result = $response->result;
        } else if ($response->result == 2) {
            $retorno->result = $response->result;
        } else {
            $retorno->result = $response->result;
        }
    }
    return json_encode($retorno);
}

function listaComboIdNac($prop, $flag)
{
    $retorno = new Resultado();
    $obj = new  EjemplarLogica();
    $result = $obj->listaComboIdNac($prop, $flag);

    $retorno->result = 1;
    $retorno->message = "Cargo correctamente el combo";
    $retorno->data = $result;

    return json_encode($retorno);
}

function obtenerDatosNacimientoEjemplar($id)
{
    $retorno = new Resultado();
    $obj = new  EjemplarLogica();
    $result = $obj->obtenerDatosNacimientoEjemplar($id);

    $retorno->result = 1;
    $retorno->message = "Cargo correctamente la data";
    $retorno->data = $result;


    return json_encode($retorno);
}

function listaComboIdMonta($prop, $flag)
{
    $retorno = new Resultado();
    $obj = new  EjemplarLogica();
    $result = $obj->listaComboIdMonta($prop, $flag);

    $retorno->result = 1;
    $retorno->message = "Cargo correctamente el combo";
    $retorno->data = $result;

    return json_encode($retorno);
}

function listarPais()
{
    $retorno = new Resultado();
    $obj = new  EjemplarLogica();
    $result = $obj->listarPais();

    $retorno->result = 1;
    $retorno->message = "Cargo correctamente el combo";
    $retorno->data = $result;

    return json_encode($retorno);
}

function listarTipoDocumento()
{
    $retorno = new Resultado();
    $obj = new  EjemplarLogica();
    $result = $obj->listarTipoDocumento();

    $retorno->result = 1;
    $retorno->message = "Cargo correctamente el combo";
    $retorno->data = $result;

    return json_encode($retorno);
}

function listarMotivoBaja()
{
    $retorno = new Resultado();
    $obj = new  EjemplarLogica();
    $result = $obj->listarMotivoBaja();

    $retorno->result = 1;
    $retorno->message = "Cargo correctamente el combo";
    $retorno->data = $result;

    return json_encode($retorno);
}
