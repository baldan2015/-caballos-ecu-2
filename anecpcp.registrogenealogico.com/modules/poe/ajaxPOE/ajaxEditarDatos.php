<? session_start();
date_default_timezone_set("UTC");
require( "../../../constante.php");
//require("../comunes/lib.comun.php");
//require("../entidad/Constantes.php");
require(DIR_LEVEL_MOD_POE . "Clases/conexion.php");
require(DIR_LEVEL_MOD_POE . "Clases/resultado.php");
require(DIR_LEVEL_MOD_POE . "Funciones/general.php");
//C:\AppServ\www\caballos\sge.web\modules\poe\entidad\Constantes.php

//require("../comunes/lib.comun.php");
//require("../entidad/Constantes.php");
$cn = new Connection();
$link = $cn->Conectar();

$retorno = new Resultado();


if (isset($_POST['opc'])) {

    if ($_POST['opc'] == 'datosProp') {
        //echo $_SESSION['xid'];
        if (validarUsuarios($retorno)->result == 1) {
            foreach ($_SESSION["usuarios"] as $datos) {
                if ($datos->flgTipo == 'A') {
                    $idUsuarioActual = $datos->id;
                }
            }
            echo datosProp($idUsuarioActual, $link, $retorno);
        }else{
            echo json_encode($retorno);
        }
    } else if ($_POST["opc"] == 'lstItemsDepartamento') {
        echo listarDepartamentos($link, $retorno);
    } else if ($_POST["opc"] == 'editarDatos') {

        if (validarUsuarios($retorno)->result == 1) {
            $passnew =  (string)(hex2bin($_POST["passnew"]));
            $pass = (string)(hex2bin($_POST["pass"]));
            $vpass = (string)(hex2bin($_POST["vpass"]));

            foreach ($_SESSION["usuarios"] as $datos) {
                if ($datos->flgTipo == 'A') {
                    $idUsuarioActual = $datos->id;
                }
            }

            echo editarDatos(
                $idUsuarioActual,
                $_POST["numDoc"],
                $_POST["apePaterno"],
                $_POST["apeMaterno"],
                $_POST["nombres"],
                $_POST["correo"],
                $_POST["telefono1"],
                $_POST["telefono2"],
                //$_POST["DepCri"],
                //$_POST["lugarCrianza"],
                $_POST["login"],
                $pass,
                $passnew,
                $_POST["tipoEdit"],
                $link,
                $vpass,
                $_POST["correoOld"]
            );
        }else{
            echo json_encode($retorno);
        }
        
    }
}

function listarDepartamentos($link, $retorno)
{
    $sql = "CALL SGESS_TIPO_DEPART_CBO(0,'');";
    // echo $sql;
    $finalResult = [];
    $result =  mysqli_query($link, $sql) or die("Error : Datos de departamento: " . mysqli_error($link));
    while ($res = mysqli_fetch_object($result)) {
        $obj = new stdClass();
        $obj->valor = $res->id;
        $obj->descripcion = $res->descripcion;
        //$obj->nombreLargo = $fila->nombreLargo;
        $finalResult[] = $obj;
    }

    $retorno->result = 1;
    $retorno->data = $finalResult;
    echo json_encode($retorno);
}
function datosProp($idProp, $link, $retorno)
{

    $sql = "CALL SGESS_ENTIDAD_X_ID($idProp);";
    $result = mysqli_query($link, $sql) or die("Error : Datos de socio: " . mysqli_error($link));;
    $finalResult = [];
    while ($res = mysqli_fetch_array($result)) {
        $obj = new stdClass();
        $obj->numDoc = $res['numDoc'];
        $obj->apePaterno = $res["apePaterno"];
        $obj->apeMaterno = $res["apeMaterno"];
        $obj->nombres = $res["nombres"];
        $obj->correo = $res["correo"];
        $obj->telefono1 = $res["telefono1"];
        $obj->telefono2 = $res["telefono2"];
        $obj->idDpto = $res["idDpto"];
        $obj->lugarCria = $res["lugarCria"];
        $obj->prefijo = $res["prefijo"];
        $obj->login = $res["login"];

        $finalResult = $obj;
    }
    $retorno->result = 1;
    $retorno->data = $finalResult;
    //$retorno->code = $idProp;
    return json_encode($retorno);
}
function editarDatos(
    $codigo,
    $numDoc,
    $apePaterno,
    $apeMaterno,
    $nombres,
    $correo,
    $telefono1,
    $telefono2,
   // $DepCri,
   // $lugarCrianza,
    $login,
    $pass,
    $passnew,
    $tipoEditar,
    $link,
    $modalpass,
    $correoOld
) {
    $retorno = new Resultado();
    $razonSocial = $apePaterno . ' ' . $apeMaterno . ' ' . $nombres;

   

        $validacion = 1;

        switch ($tipoEditar) {
            case 1:
                if ($numDoc == '' || $apePaterno == '' || $nombres == '' || $razonSocial == '') {
                    $validacion = 0;
                    $retorno->message = 'Ingrese datos obligatorios: <br> <li>Número de documento</li> <li>Apellido Paterno</li><li>Nombres</li><li>Correo</li>';
                } else if($modalpass == ''){
                    $validacion = 0;
                    $retorno->message = 'Ingrese contraseña para validacion de usuario.';
                }elseif($correo == '' || $correo == $correoOld){
                    $sql = "CALL SGESU_ENTIDAD_SOCIO($codigo,'$numDoc','$apePaterno','$apeMaterno','$nombres','$razonSocial','$correoOld','$telefono1','$telefono2','$login','$modalpass');";
                } else {
                    if(filter_var( $correo , FILTER_VALIDATE_EMAIL)){
                        $sql = "CALL SGESU_ENTIDAD_SOCIO($codigo,'$numDoc','$apePaterno','$apeMaterno','$nombres','$razonSocial','$correo','$telefono1','$telefono2','$login','$modalpass');";
                    }else{
                        $validacion = 0;
                        $retorno->message = 'Correo invalido. ';
                    }
                   
                }
                break;
                /*case 2:
                if ($DepCri == '' || $lugarCrianza == '' || $DepCri==0) {
                    $validacion = 0;
                    $retorno->message = 'Ingrese datos obligatorios: <br> <li>Departamento de crianza</li><li>Lugar de crianza</li>';
                } else {
                    $sql = "CALL SGESU_ENTIDAD_CRIADOR($codigo,$DepCri,'$lugarCrianza');";
                }
                break;*/
            case 3:
                if ($login == '') {
                    $validacion = 0;
                    $retorno->message = 'Es necesario el login para actualizar la contraseña.';
                } elseif ($pass == '' || $passnew == '') {
                    $validacion = 0;
                    $retorno->message = 'Ingrese datos obligatorios: <br> <li>Nueva contraseña </li><li>Contraseña actual</li>';
                } else {
                    $sql = "CALL SGESU_ENTIDAD_ACCESI_WEB($codigo,'$login','$pass','$passnew');";
                }
                break;
        }

        if ($validacion == 1) {
            $result = mysqli_query($link, $sql) or die("Error : Datos de socio: " . mysqli_error($link));
            if ($fila = mysqli_fetch_array($result)) {
                if ($fila[0] == 1) {
                    $retorno->result = 1;
                    $retorno->message = 'Datos actualizados.';
                } else if ($fila[0] == 2) {
                    $retorno->result = 2;

                    if ($tipoEditar == 1) {
                        $retorno->message = 'Número de documento ya registrado. Por favor ingrese otro número de documento.';
                    } elseif ($tipoEditar == 3) {
                        $retorno->message = 'Contraseña actual incorrecta.';
                    }

                } else if($fila[0] == 3){
                    $retorno->result = 2;

                    if($tipoEditar == 1){
                        $retorno->message = 'Contraseña actual incorrecta.';
                    }
                } else {
                    $retorno->result = 0;
                    $retorno->message = 'Error del sistema. Comunicarse con el administrador';
                }
            }
            $result->free_result();
        } else {
            $retorno->result = 0;
        }


    return json_encode($retorno);
}
function validarUsuarios( $retorno){
	if(!(isset($_SESSION["usuarios"]))){
    $retorno->result=-1;
    $retorno->message="La sesión ha finalizado";   
    $retorno->isRedirect=1;
    $retorno->redirectUrl='http://localhost/ancpcpp-ecu/sge.ec/';
   }else{
    $retorno->result=1;
    $retorno->message="La sesión está activa";    
    }
    return $retorno;
}
?>