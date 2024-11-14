<?php session_start();
include_once("../entidad/Constantes.php");
include_once("../logica/LoginLogica.php");
include_once("../entidad/Login.php");

$resultado = " ";

if (isset($_POST["opc"])) {
    if ($_POST["opc"] == "login") {
        if (isset($_POST["usr"])) {
            if ($_POST["usr"] != "") {

                if (isset($_POST["pwd"])) {
                    if ($_POST["pwd"] != "") {
                        $recaptcha_url = ConstantesCatpcha::K_URL_GOOGLE_VERIFY;
                        $recaptcha_secret = ConstantesCatpcha::K_CLAVE_SECRETA;
                        $recaptcha_response = $_POST['recaptcha_response'];
                        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
                        $recaptcha = json_decode($recaptcha);

                        if ($recaptcha->success == 1 && $recaptcha->score >= ConstantesCatpcha::K_PUNTUACION) {

                            if ($recaptcha->action == "qradmin") {
                                $objLogin = new LoginLogica();
                                $entity = new Login();
                                $entity->usuario = $_POST["usr"];
                                $entity->contrasenia = $_POST["pwd"];
        
        
                                $usuario = $objLogin->ValidarLogin($entity);
        
                                if (is_object($usuario)) {
        
                                    $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO] = $usuario->idUsu;
                                    $_SESSION[Constantes::K_SESSION_EMPRESA] = constantes::K_ID_EMPRESA_DEFAULT;
                                    $_SESSION[Constantes::K_SESSION_USUARIO] = $usuario;
                                    $_SESSION[Constantes::K_SESSION_NOMBRE_COMPLETO] = $usuario->razonSocial;
                                    $_SESSION[Constantes::K_SESSION_CORREO_USUARIO] = $usuario->correo;
                                    $_SESSION[Constantes::K_SESSION_ROL_USUARIO] = $usuario->rol;
                                    $_SESSION[Constantes::K_SESSION_USUARIO_LOGIN] = $usuario->login;
                                    $_SESSION[Constantes::K_SESSION_CARGO_USUARIO] = $usuario->idRol;
                                    $resultado = "OK";
                                } else {
                                    session_destroy();
                                    $resultado = "<span style='color:yellow;font-weight:bold;'>Login Incorrecto.</span>";
                                }
                            } else {
                                $resultado= "<span style='color:orange;font-weight:bold;'>Invalid action RECAPTCHA</span>";
                            }
                        } else {
                            $resultado= "<span style='color:orange;font-weight:bold;'> VERIFICACIÓN RECAPCHA: ES UN POTENCIAL ROBOT. SOLICITUD DE CONSULTA RECHAZADO.</span>";
                        }
                    } else {
                        $resultado = "<span style='color:orange;font-weight:bold;'>Ingrese clave del usuario del sistema.</span>";
                    }
                } else {
                    $resultado = "No se ha enviado la clave del usuario del sistema";
                }
            } else {
                $resultado = "<span style='color:yellow;font-weight:bold;'>Ingrese el usuario del sistema.</span>";
            }
        } else {
            $resultado = "Error parametros esperados no enviados";
        }
    } else {
        $resultado = "Error parametros esperados no enviados";
    }
}
echo $resultado;

  //  echo "<pre>";
   //echo print_r($_SESSION);
