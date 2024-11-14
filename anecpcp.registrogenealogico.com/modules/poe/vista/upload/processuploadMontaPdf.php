<? session_start();
include_once("../../logica/ImagenLogica.php");
include_once("../../logica/EjemplarLogica.php");
include_once("../../entidad/Resultado.inc.php");
include_once("../../../../constante.php");

if (!ValidarSession()) {
	die("<br/><br/><br/><center>La sesi&oacute;n ha finalizado. Cierre la ventana y vuelva a logearse.</center>");
}
function ValidarSession($param = '')
{
	if (!(isset($SESSION['xusuAdmin']))) {
		$retorno = false;
	} else {
		$retorno = true;
	}

	return true; //$retorno;

}
$retorno = new Resultado();
//$retorno->result = 1;
//$retorno->data = $_FILES;
//$retorno->html = $_POST;
//echo (K_PATHWEB);
############ Configuration ##############
$thumb_square_size 		= 60; //Thumbnails will be cropped to 200x200 pixels
$max_image_size 		= 900; //Maximum image size (height and width)
$thumb_prefix			= "thumb_"; //Normal thumb Prefix
$destination_folder		= K_PATH_MONTA_PDF; //upload directory ends with / (slash)
//$destination_folder		= K_PATH; //upload directory ends with / (slash)
$jpeg_quality 			= 90; //jpeg quality


##########################################
/**COLOCAR TODAS LAS VALIDACIONES DE LOS CONTROLES */

$idMonta = $_POST['hidCodigo'];
$CodigoMonta = $_POST["hidCodigoMonta"];
$padre = $_POST["hidCodigoPotro"];
$madre = $_POST["hidCodigoYegua"];
$idProp = $_SESSION['xid'];
$idPoe = 0;
$fecMonta = $_POST["dtFecMonta"];
$fecParir = $_POST["dtFecParir"];
$metodo = $_POST["metodo"];
$isTE = $_POST["txtIsTE"];
$idTextoRec = $_POST["txtIdTE"];
$fecEmbrion = $_POST["dtFecEmbrion"];

$edit = $_POST["hidFlagEdit"];

$rdbtnDelPotro = $_POST["rdbtnDelPotro"];
$rdbtnDelYegua = $_POST["rdbtnDelYegua"];
//$retorno->validateTOKEN = "1";
$fechaActual = date('YmdHis');
$validacion = 1;
$mensaje = "Falta el campo ";

/**INICIO VALIDACIONES */

if ($padre == "") {
	$validacion = 0;
	$mensaje .= "Potro";
} else if ($madre == "") {
	$validacion = 0;
	$mensaje .= "Yegua";
} else if ($fecMonta == "" 	||	$fecMonta == "0000-00-00") {
	$validacion = 0;
	$mensaje .= "Fecha de Monta";
} else if ($fecParir == ""	||	$fecParir == "0000-00-00") {
	$validacion = 0;
	$mensaje .= "Fecha Parir";
} else if ($metodo == "") {
	$validacion = 0;
	$mensaje .= "Metodo";
} else if ($isTE == 1 && ($fecEmbrion == "" || $idTextoRec == "")) {
	$validacion = 0;
	$mensaje .= "Datos de Transferencia de Embrion";
}
/**FIN VALIDACIONES */

/** FUNCION DE SUBIR ARCHIVO */

function subirArchivoYegua($image_temp, $image_save_folder, $idMonta, $new_file_name, $CodigoMonta, $retorno)
{
	if (move_uploaded_file($image_temp, $image_save_folder)) {
		//echo "El fichero es válido y se subió con éxito.\n";
		$insY = new ImagenLogica();
		$selectCodMonta = new EjemplarLogica();

		if ($CodigoMonta == "") {
			$reponseSelectCod = $selectCodMonta->getLastInsertMonta();
			$CodigoMonta = $reponseSelectCod->codigoMonta;
		}

		$responseY = $insY->insertarMontaDocumento($idMonta, $new_file_name, 1, '0');
		if ($responseY->result == 1) {
			$retorno->message = 'Se registro La monta con el codigo ' . $CodigoMonta;
			$retorno->result = 1;
			// PREGUNTAR SI X ES UN OBJETO -> ACCEDER A ATRIBUTO ID,DOC PARA DARLE 
			// DE BAJA POR DB Y A RUTA

		} else if ($responseY->result == 0) {
			$retorno->message = 'Se registro La monta pero no se cargo el pdf de la yegua, intentar nuevamente la carga.';
			$retorno->result = 1;
			$retorno->valorA = 0;
			//ELIMINAR EL ARCHIVO FISICO CARGADO AL SISTEMA
			//SETEAR LA VARIABLE A FALSE 
		} else {
			$retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
		}
	} else {
		//echo "¡fichero es válido para subir al servidor!\n";
		if ($retorno->result == 1) {
			if ($retorno->valorA == 0) {
				$retorno->message .= 'Se registro La monta pero no se cargo el pdf de la yegua, intentar nuevamente la carga.';
			} else {
				$retorno->message = 'Se registro La monta pero no se cargo el pdf de la yegua, intentar nuevamente la carga.';
			}

			$retorno->valorA = 0;
		}
	}
}

function subirArchivoPotro($image_tempP, $image_save_folderP, $idMonta, $new_file_nameP, $CodigoMonta, $retorno)
{
	if (move_uploaded_file($image_tempP, $image_save_folderP)) {
		$insP = new ImagenLogica();
		$selectCodMonta = new EjemplarLogica();

		if ($CodigoMonta == "") {
			$reponseSelectCod = $selectCodMonta->getLastInsertMonta();
			$CodigoMonta = $reponseSelectCod->codigoMonta;
		}
		$responseP = $insP->insertarMontaDocumento($idMonta, $new_file_nameP, 1, '1');
		if ($responseP->result == 1) {
			$retorno->message = 'Se registro La monta con el codigo ' . $CodigoMonta;
		} else if ($responseP->result == 0) {
			$retorno->message = 'Se registro La monta pero no se cargo el pdf del potro, intentar nuevamente la carga.';
		} else {
			$retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
		}
	} else {
		if ($retorno->result == 1) {
			if ($retorno->valorA == 0) {
				$retorno->message .= 'Se registro La monta pero no se cargo el pdf del potro, intentar nuevamente la carga.';
			} else {
				$retorno->message = 'Se registro La monta pero no se cargo el pdf del potro, intentar nuevamente la carga.';
			}
		}
	}
}
/**FIN DE FUNCION DE SUBIR ARCHIVO */


if ($validacion == 1) {
	$ins = new EjemplarLogica();

	if ($edit == '1') {

		$response = $ins->editarMonta($idMonta, $padre, $madre, $idProp, $idPoe, $fecMonta, $fecParir, $metodo, $isTE, $idTextoRec, $fecEmbrion);
		//print_r($response);
		if ($response->result == 1) {
			$retorno->result = $response->result;
			$retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
			$retorno->code = $response->code;
		} else if ($response->result == 0) {
			$retorno->result = $response->result;
			$retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
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
	} else {

		$response = $ins->insertarMonta($padre, $madre, $idProp, $idPoe, $fecMonta, $fecParir, $metodo, $isTE, $idTextoRec, $fecEmbrion);

		if ($response->result == 1) {
			$retorno->result = $response->result;
			$retorno->message = Constantes::K_MENSAJE_INSERT_OK;
			$retorno->code = $response->code;
		} else if ($response->result == 0) {
			$retorno->result = $response->result;
			$retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
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
	//}

	//continue only if $_POST is set and it is a Ajax request
	if ($retorno->result == 1 && isset($_POST)) { //&& isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

		/**VALIDACION DEL RADIOBUTTON ELIMINAR POTRO/YEGUA */
		if ($rdbtnDelYegua == 1) {
			$valDocYegua = new ImagenLogica();
			$deleteDocYegua = new ImagenLogica();

			$validacionDocumentoYegua = $valDocYegua->listarDocumentosMonta($idMonta, '0');

			if (is_array($validacionDocumentoYegua)) {
				if (sizeof($validacionDocumentoYegua) > 0) {
					foreach ($validacionDocumentoYegua as $key => $fila) {
						$idDocYegua = $fila->id;
						$rutaDocYegua = $fila->ruta;
					}
					$deleteYegua = $deleteDocYegua->eliminarDocumentoMonta($idDocYegua, '0');
					if ($deleteYegua->result == 1 && unlink(K_PATH_MONTA_PDF . $rutaDocYegua)) {
						$retorno->result = 1;
						$retorno->message .= " <br>Se elimino el documento de autotización de Yegua.";
					}
				}
			}
		}

		if ($rdbtnDelPotro == 1) {
			$valDocPotro = new ImagenLogica();
			$deleteDocPotro = new ImagenLogica();

			$validacionDocumentoPotro = $valDocPotro->listarDocumentosMonta($idMonta, '1');

			if (is_array($validacionDocumentoPotro)) {
				if (sizeof($validacionDocumentoPotro) > 0) {
					foreach ($validacionDocumentoPotro as $key => $fila) {
						$idDocPotro = $fila->id;
						$rutaDocPotro = $fila->ruta;
					}
					$deletePotro = $deleteDocPotro->eliminarDocumentoMonta($idDocPotro, '1');
					if ($deletePotro->result == 1 && unlink(K_PATH_MONTA_PDF . $rutaDocPotro)) {
						$retorno->result = 1;
						$retorno->message .= " <br>Se elimino el documento de autotización de Potro.";
					}
				}
			}
		}
		/** FIN VALIDACION DEL RADIOBUTTON ELIMINAR POTRO/YEGUA */


		// check $_FILES['ImageFile'] not empty
		if (isset($_FILES['pdfInputYegua']) || is_uploaded_file($_FILES['pdfInputYegua']['tmp_name'])) {



			//uploaded file info we need to proceed
			$image_name = $_FILES['pdfInputYegua']['name']; //file name
			$image_size = $_FILES['pdfInputYegua']['size']; //file size
			$image_temp = $_FILES['pdfInputYegua']['tmp_name']; //file temp
			$image_type = $_FILES['pdfInputYegua']['type']; //file temp

			//switch statement below checks allowed image type 
			//as well as creates new image from given file 
			switch ($image_type) {
				case 'application/pdf':
					$image_res =  true;
					break; // imagecreatefrompng($image_temp); break;
				default:
					$image_res = false;
			}

			if ($image_res) {
				//Get file extension and name to construct new file name 
				$image_info = pathinfo($image_name);
				$image_extension = strtolower($image_info["extension"]); //image extension
				$image_name_only = strtolower($image_info["filename"]); //file name only, no extension

				//create a random name for new image (Eg: fileName_293749.jpg) ;
				if ($edit == 0) {
					$idMonta = $retorno->code;
				}
				$new_file_name =  $_SESSION['xid'] . $idMonta . "_" . $fechaActual . "_" . 'Y' . '.' . $image_extension;
				$image_save_folder 	= $destination_folder . $new_file_name;
				//folder path to save resized images and thumbnails
				if ($edit == 1) {
					$valDocY = new ImagenLogica();
					$deleteDocY = new ImagenLogica();

					$validacionDocumentoY = $valDocY->listarDocumentosMonta($idMonta, '0');

					if (is_array($validacionDocumentoY)) {
						if (sizeof($validacionDocumentoY) > 0) {
							foreach ($validacionDocumentoY as $key => $fila) {
								$idDocY = $fila->id;
								$rutaDocY = $fila->ruta;
							}
							//C:\AppServ\www\sge.documentos\pdfmonta\8174300_20220512190205_Y.pdf
							//$retorno->html = $idDocY . '-' . K_PATH_MONTA_PDF . $rutaDocY;
							$deleteY = $deleteDocY->eliminarDocumentoMonta($idDocY, '0');

							if ($deleteY->result == 1 && unlink(K_PATH_MONTA_PDF . $rutaDocY)) {
								subirArchivoYegua($image_temp, $image_save_folder, $idMonta, $new_file_name, $CodigoMonta, $retorno);
							} else {
								$retorno->message = "No se puedo Eliminar el documento registrado anteriormente.";
							}
						} else {
							subirArchivoYegua($image_temp, $image_save_folder, $idMonta, $new_file_name, $CodigoMonta, $retorno);
						}
					} else {
						subirArchivoYegua($image_temp, $image_save_folder, $idMonta, $new_file_name, $CodigoMonta, $retorno);
					}
				} else {
					subirArchivoYegua($image_temp, $image_save_folder, $idMonta, $new_file_name, $CodigoMonta, $retorno);
				}
			}
		}


		//echo $retorno->result;
		if ($retorno->result == 1 && (isset($_FILES['pdfInputPotro']) || is_uploaded_file($_FILES['pdfInputPotro']['tmp_name']))) {



			//uploaded file info we need to proceed
			$image_nameP = $_FILES['pdfInputPotro']['name']; //file name
			$image_sizeP = $_FILES['pdfInputPotro']['size']; //file size
			$image_tempP = $_FILES['pdfInputPotro']['tmp_name']; //file temp
			$image_typeP = $_FILES['pdfInputPotro']['type']; //file temp

			//switch statement below checks allowed image type 
			//as well as creates new image from given file 
			switch ($image_typeP) {
				case 'application/pdf':
					$image_resP =  true;
					break; // imagecreatefrompng($image_temp); break;
				default:
					$image_resP = false;
			}

			if ($image_resP) {
				//Get file extension and name to construct new file name 
				$image_infoP = pathinfo($image_nameP);
				$image_extensionP = strtolower($image_infoP["extension"]); //image extension
				$image_name_onlyP = strtolower($image_infoP["filename"]); //file name only, no extension

				//create a random name for new image (Eg: fileName_293749.jpg) ;
				$new_file_nameP =  $_SESSION['xid'] . $idMonta . "_" . $fechaActual . "_" . 'P' . '.' . $image_extensionP;

				//folder path to save resized images and thumbnails

				$image_save_folderP	= $destination_folder . $new_file_nameP;
				if ($edit == 0) {
					$idMonta = $retorno->code;
				}

				if ($edit == 1) {
					$valDocP = new ImagenLogica();
					$deleteDocP = new ImagenLogica();

					$validacionDocumentoP = $valDocP->listarDocumentosMonta($idMonta, '1');
					if (is_array($validacionDocumentoP)) {
						if (sizeof($validacionDocumentoP) > 0) {
							foreach ($validacionDocumentoP as $key => $fila) {
								$idDocP = $fila->id;
								$rutaDocP = $fila->ruta;
							}
							$deleteP = $deleteDocP->eliminarDocumentoMonta($idDocP, '0');

							if ($deleteP->result == 1 && unlink(K_PATH_MONTA_PDF . $rutaDocP)) {
								subirArchivoPotro($image_tempP, $image_save_folderP, $idMonta, $new_file_nameP, $CodigoMonta, $retorno);
							} else {
								$retorno->result == 0;
								$retorno->message = "No se puedo Eliminar el documento registrado anteriormente.";
							}
						} else {
							subirArchivoPotro($image_tempP, $image_save_folderP, $idMonta, $new_file_nameP, $CodigoMonta, $retorno);
						}
					} else {
						subirArchivoPotro($image_tempP, $image_save_folderP, $idMonta, $new_file_nameP, $CodigoMonta, $retorno);
					}
				} else {
					subirArchivoPotro($image_tempP, $image_save_folderP, $idMonta, $new_file_nameP, $CodigoMonta, $retorno);
				}
			}
		}
	}
} else {
	$retorno->result = 2;
	$retorno->message = $mensaje;
}


echo json_encode($retorno);
