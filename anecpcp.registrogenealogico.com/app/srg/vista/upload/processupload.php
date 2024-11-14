<? session_start();
//require("../Funciones/conectar2.php");
include_once ("../../logica/ImagenLogica.php");
//include_once ("../entidad/Ejemplar.inc.php");
include_once ("../../entidad/Resultado.inc.php"); 
include_once ("../../constante.php");  	
 
$idHorse=$_POST['idHorse'];

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
require("../../constante.php");


//echo (K_PATHWEB);
############ Configuration ##############
$thumb_square_size 		= 60; //Thumbnails will be cropped to 200x200 pixels
$max_image_size 		= 900; //Maximum image size (height and width)
$thumb_prefix			= "thumb_"; //Normal thumb Prefix
$destination_folder		= K_PATH; //upload directory ends with / (slash)
$jpeg_quality 			= 90; //jpeg quality


##########################################

//continue only if $_POST is set and it is a Ajax request
if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

	// check $_FILES['ImageFile'] not empty
	if(!isset($_FILES['image_file']) || !is_uploaded_file($_FILES['image_file']['tmp_name'])){
			die('Image file is Missing!'); // output error when above checks fail.
	}
	
	//uploaded file info we need to proceed
	$image_name = $_FILES['image_file']['name']; //file name
	$image_size = $_FILES['image_file']['size']; //file size
	$image_temp = $_FILES['image_file']['tmp_name']; //file temp

	$image_size_info 	= getimagesize($image_temp); //get image size
	
	if($image_size_info){
		$image_width 		= $image_size_info[0]; //image width
		$image_height 		= $image_size_info[1]; //image height
		$image_type 		= $image_size_info['mime']; //image type
	}else{
		die("Make sure image file is valid!");
	}

	//switch statement below checks allowed image type 
	//as well as creates new image from given file 
	switch($image_type){
		case 'image/png':
			$image_res =  imagecreatefrompng($image_temp); break;
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
		$new_file_name = $image_name_only. '_' .  rand(0, 9999999999) . '.' . $image_extension;
		
		//folder path to save resized images and thumbnails
		$thumb_save_folder 	= $destination_folder . $thumb_prefix . $new_file_name; 
		$image_save_folder 	= $destination_folder . $new_file_name;
		
		//call normal_resize_image() function to proportionally resize image
		if(normal_resize_image($image_res, $image_save_folder, $image_type, $max_image_size, $image_width, $image_height, $jpeg_quality))
		{
			//call crop_image_square() function to create square thumbnails
			if(!crop_image_square($image_res, $thumb_save_folder, $image_type, $thumb_square_size, $image_width, $image_height, $jpeg_quality))
			{
				die('Error Creating thumbnail');
			}
			
			/*insert tabla galeria*/
			//echo "1";
				/*--INSERTAR--*/
				
       				//echo "2";
        		//$retorno=new Resultado();
        		$ins = new ImagenLogica();
       			 
                $response = $ins->insertar($idHorse,$new_file_name,$esPrincipal=0,$activo=1);
                if ($response->result == 1){
                   echo Constantes::K_MENSAJE_INSERT_OK;
                }else if ($response->result == 0){
                   echo Constantes::K_MENSAJE_INSERT_NOOK;
                }

			 
			/*fin insert tabla galeria*/

			/* We have succesfully resized and created thumbnail image
			We can now output image to user's browser or store information in the database*/
			echo '<div align="center">';
			//echo '<img src="'.K_PATHWEB.$thumb_prefix . $new_file_name.'" alt="Thumbnail">';
			echo '<br />';
			echo listarImagenesEjemplares($idHorse,K_PATHWEB.$thumb_prefix);
			/*echo '<img src="'.K_PATHWEB.$new_file_name.'" alt="Resized Image">';*/
			echo '</div>';



		}
		
		imagedestroy($image_res); //freeup memory
	}

			 

}
	

function listarImagenesEjemplares($idHorse,$thumb_prefix){

		$thumb_prefix           = "thumb_"; 
		//echo "ingreso";

		$retorno=new Resultado();
        $objImagen = new ImagenLogica();

		$html = "";
		$html.= "<table class='gridHtml'style='width:100%;border-collapse: collapse;
    border: 1px solid #CCC; background:white;'  border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th style='height:35px;width:10%;'>Id</th>";
		$html.= "<th style='height:35px;width:10%;'>IdCaballo</th>";
		$html.= "<th style='height:35px;width:10%;'>Ruta</th>";
		$html.= "<th style='height:35px;width:10%;'>Fecha</th>";
		$html.= "<th style='height:35px;width:25%;'>Imagen</th>";
		//$html.= "<th style='height:35px;width:25%;'>Activo</th>";
		$html.= "<th style='height:35px;width:35%;'>Es principal</th>";
		$html.= "<th style='height:35px;width:25%;'>...</th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";

	 
		$datos = $objImagen->buscarSearch($idHorse);

		//echo (print_r($datos));
		
		if(is_array($datos)){


        foreach ($datos as $key => $fila) {
        
            $botonHtml="<label class='btnDel' style=' cursor:pointer;'
             onclick=eliminarImg(".$fila->id.",'".$fila->idCaballo."'); >Eliminar</label>";


			$isMain=$fila->esPrincipal==1?"SI":"NO";
            $botonHtmlEsprincipal="<label class='btnUpd'  style='cursor:pointer;' onclick=updPrincipal(".$fila->id.",".$fila->esPrincipal.",'".$fila->idCaballo."'); >".$isMain."</label>";
             
            $html.= "<tr>";
            

                $html.= "<td align='left' >
                <label  >".$fila->id."</label>
                <input type='hidden' class='cssItem'   value='".$fila->id."'>
                <input class='cssItem'  type='hidden'   value='".$res['esNuevo']."'/>
                </td>";

                $html.= "<td align='left'>
                <label  id='txtEjemplar_".$fila->id."' >".$fila->idCaballo."</label>
                <input type='hidden' class='cssItem'  value='".$fila->idCaballo."'>
                </td>";

                $html.= "<td align='center'>
                <label  id='txtRuta_".$fila->id."' >".$fila->ruta."</label>
                <input type='hidden' class='cssItem'  value='".$fila->ruta."'>
                </td>";

                
                $html.= "<td align='center'>
                <label  id='txtFecha_".$fila->id."' >".$fila->fecha."</label>
                <input type='hidden' class='cssItem' value='".$fila->fecha."'>
                </td>";

                $html.= "<td align='center'>
                <img src='".K_PATHWEB.$thumb_prefix.$fila->ruta."' style=' cursor:pointer;'  onclick=mostrarImgGrande('".K_PATHWEB.$fila->ruta."');  alt='Thumbnail' > 
                </td>";

               /* $html.= "<td align='center'>
                <label  id='txtActivo_".$fila->id."' >".$fila->activo."</label>
                <input type='hidden' class='cssItem'   value='".$fila->activo."'>
                </td>";*/

                
                $html.= "<td align='center'>
                <label  id='txtActivo_".$fila->id."' style='cursor:pointer;' >".$botonHtmlEsprincipal."</label>
                <input type='hidden' class='cssItem'   value='".$fila->esPrincipal."'>
                </td>";

                $html.= "<td align='center'>";

                //if($res['esNuevo']=='1'){
                $html.=$botonHtml;//"<label ><label class='btnDel'  data-key=".$res['id'].">Eliminar</label></label>";
                //}
                
                 $html.= "</td>";
            $html.= "</tr>";
          //  $fila++;
           //     }
             $i++;
        }
        }
		$html.= "</tbody>";
		$html.= "</table>";
		return $html;
}


#####  This function will proportionally resize image ##### 
function normal_resize_image($source, $destination, $image_type, $max_size, $image_width, $image_height, $quality){
	
	if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize
	
	//do not resize if image is smaller than max size
	if($image_width <= $max_size && $image_height <= $max_size){
		if(save_image($source, $destination, $image_type, $quality)){
			return true;
		}
	}
	
	//Construct a proportional size of new image
	$image_scale	= min($max_size/$image_width, $max_size/$image_height);
	$new_width		= ceil($image_scale * $image_width);
	$new_height		= ceil($image_scale * $image_height);
	
	$new_canvas		= imagecreatetruecolor( $new_width, $new_height ); //Create a new true color image
	
	//Copy and resize part of an image with resampling
	if(imagecopyresampled($new_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height)){
		save_image($new_canvas, $destination, $image_type, $quality); //save resized image
	}

	return true;
}

##### This function corps image to create exact square, no matter what its original size! ######
function crop_image_square($source, $destination, $image_type, $square_size, $image_width, $image_height, $quality){
	if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize
	
	if( $image_width > $image_height )
	{
		$y_offset = 0;
		$x_offset = ($image_width - $image_height) / 2;
		$s_size 	= $image_width - ($x_offset * 2);
	}else{
		$x_offset = 0;
		$y_offset = ($image_height - $image_width) / 2;
		$s_size = $image_height - ($y_offset * 2);
	}
	$new_canvas	= imagecreatetruecolor( $square_size, $square_size); //Create a new true color image
	
	//Copy and resize part of an image with resampling
	if(imagecopyresampled($new_canvas, $source, 0, 0, $x_offset, $y_offset, $square_size, $square_size, $s_size, $s_size)){
		save_image($new_canvas, $destination, $image_type, $quality);
	}

	return true;
}

##### Saves image resource to file ##### 
function save_image($source, $destination, $image_type, $quality){
	switch(strtolower($image_type)){//determine mime type
		case 'image/png': 
			imagepng($source, $destination); return true; //save png file
			break;
		case 'image/gif': 
			imagegif($source, $destination); return true; //save gif file
			break;          
		case 'image/jpeg': case 'image/pjpeg': 
			imagejpeg($source, $destination, $quality); return true; //save jpeg file
			break;
		default: return false;
	}
}