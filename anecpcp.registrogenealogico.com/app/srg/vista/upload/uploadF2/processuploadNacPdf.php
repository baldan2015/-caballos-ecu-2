<? session_start();
include_once ("../../../logica/ImagenInsLogica.php");
include_once ("../../../entidad/Resultado.inc.php"); 
include_once ("../../../constante.php");  	
$idHorse=$_POST['idHorsePdf'];
$idTipoDocumento=$_POST['idTipoDoc'];
$codigoGenerado=$_POST['hidCodigoGenerado'];
$edit=($_POST["hidFlagEdit"]=='1' ? 'edit':'new');
if(!ValidarSession()){
	 die("<br/><br/><br/><center>La sesi&oacute;n ha finalizado. Cierre la ventana y vuelva a logearse.</center>");
}
function ValidarSession($param='')
{
if(!(isset($SESSION['xusuAdmin'])))
	{
	$retorno=false;
	}
else
	{
		$retorno=true;
	}

return true;//$retorno;

}

//echo (K_PATHWEB);
############ Configuration ##############
$thumb_square_size 		= 60; //Thumbnails will be cropped to 200x200 pixels
$max_image_size 		= 900; //Maximum image size (height and width)
$thumb_prefix			= "thumb_"; //Normal thumb Prefix
$destination_folder		= K_PATH_NAC_PDF; //upload directory ends with / (slash)
//$destination_folder		= K_PATH; //upload directory ends with / (slash)
$jpeg_quality 			= 90; //jpeg quality


##########################################

//continue only if $_POST is set and it is a Ajax request
if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	
	// check $_FILES['ImageFile'] not empty
	if(!isset($_FILES['pdf_file']) || !is_uploaded_file($_FILES['pdf_file']['tmp_name'])){
			die('Image file is Missing!'); // output error when above checks fail.
	}
 
	//uploaded file info we need to proceed
	$image_name = $_FILES['pdf_file']['name']; //file name
	$image_size = $_FILES['pdf_file']['size']; //file size
	$image_temp = $_FILES['pdf_file']['tmp_name']; //file temp
	$image_type = $_FILES['pdf_file']['type']; //file temp
 
	//switch statement below checks allowed image type 
	//as well as creates new image from given file 
	switch($image_type){
		case 'application/pdf':
			$image_res =  true; break;// imagecreatefrompng($image_temp); break;
		case 'image/gif':
			$image_res =  imagecreatefromgif($image_temp); break;			
		case 'image/jpeg': case 'image/pjpeg':
			$image_res = imagecreatefromjpeg($image_temp); break;
		default:
			$image_res = false;
	}

	if($image_res){
		//Get file extension and name to construct new file name 
		$image_info = pathinfo($image_name);
		$image_extension = strtolower($image_info["extension"]); //image extension
		$image_name_only = strtolower($image_info["filename"]);//file name only, no extension
		
		//create a random name for new image (Eg: fileName_293749.jpg) ;
		$new_file_name =  $_SESSION['xid']."_".$idHorse."_".rand(0, 9999999999) . '.' . $image_extension;
		
		//folder path to save resized images and thumbnails
	
		$image_save_folder 	= $destination_folder . $new_file_name;
		if(move_uploaded_file($image_temp, $image_save_folder))
		{
		    //echo "El fichero es válido y se subió con éxito.\n";
			$ins = new ImagenLogica();
       			 
                $response = $ins->insertarNacTMP($idHorse,$new_file_name,$esPrincipal=0,$activo=1,1,$idTipoDocumento,$codigoGenerado);
                if ($response->result == 1){
                   echo Constantes::K_MENSAJE_INSERT_OK;
                }else if($response->result == 999){
                   echo Constantes::K_MENSAJE_VALIDACION_INS;
                }else if ($response->result == 0){
                   echo Constantes::K_MENSAJE_INSERT_NOOK;
                }
			echo '<div align="left">';
			echo '<br />';
			require("../../../ajax/ajaxImagenIns.php");
			echo listarPdfEjemplarNac($idHorse,$codigoGenerado,$edit);
			echo '</div>';


		} else {
    		echo "¡fichero es válido para subir al servidor!\n";
		}
	}

			 

}
	
 
