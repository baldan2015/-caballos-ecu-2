<? session_start();
require("constante.php");
require(DIR_VALIDAR);
require(DIR_DATABASE);
require("Clases/log.php");
require_once("modules/poe/entidad/Constantes.php");

$usu = $_POST["txtusu"];
$pas = $_POST["txtpwd"];

$validacion = 1;
$retorno = new stdClass();
if (empty($usu)) {
	$validacion = 0;
	$message = "Se debe ingresar usuario.";
}

if (empty($pas)) {
	$validacion = 0;
	$message = "Se debe ingresar contraseña.";
}
if ($validacion == 1) {
	$recaptcha_url = ConstantesCatpcha::K_URL_GOOGLE_VERIFY;
	$recaptcha_secret = ConstantesCatpcha::K_CLAVE_SECRETA;
	$recaptcha_response = $_POST['recaptcha_response'];
	$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
	$recaptcha = json_decode($recaptcha);

	if ($recaptcha->success == 1 && $recaptcha->score >= ConstantesCatpcha::K_PUNTUACION) {

		if ($recaptcha->action == "qrsocio") {
			$usuarios = validar($usu, $pas, $link);
			if (is_array($usuarios)) {
				if (sizeof($usuarios) == 0) {
					$xusu = "Desconocido";
					$xid = "0";
					$xstatus = "-1";
				} else {
			
					$log = new Log();
					$log->registrarLog($usuarios[0]->idPropietario, $usuarios[0]->razonSocial);
				}
			}
			
			$_SESSION['usuarios'] = $usuarios;
			$_SESSION['xusu'] = $usuarios[0]->razonSocial;
			$_SESSION['xid'] = $usuarios[0]->idPropietario;
			$_SESSION['xstatus'] = $usuarios[0]->estado;
			$_SESSION['xflgTipo'] = $usuarios[0]->flgTipo;
			$id = session_id();
			$id = session_id();

			$retorno->data = Constantes::K_URL_TOKEN_GENERATOR;
			$retorno->code = $id;
			$retorno->result = 1;
		}else {
			$message = "Invalid action RECAPTCHA";
			$retorno->result = 2;
			$retorno->message = $message;
		}
	} else {
		$message = "VERIFICACIÓN RECAPCHA: ES UN POTENCIAL ROBOT. SOLICITUD DE CONSULTA RECHAZADO.";
		$retorno->result = 2;
		$retorno->message = $message;
	}
} else {
	$retorno->result = 2;
	$retorno->message = $message;
}

echo json_encode($retorno);
?>