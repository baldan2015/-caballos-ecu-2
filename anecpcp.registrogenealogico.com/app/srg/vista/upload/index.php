<? session_start();
include_once("../../entidad/Constantes.php");
include_once("../../comunes/lib.comun.php");
require("../../constante.php");

$idHorse2=$_GET['idHorse'];

  
  

    if(!validarSesion2()){
        die("<center><br><br><br>".Constantes::K_SESSION_LOGOUT." <a href='#' onclick='return window.close();'>Cerrar esta ventana</a></center> ");
    }
 

?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: CARGA IMAGEN EJEMPLAR ::</title>
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/jquery.form.min.js"></script>

 
<LINK REL=StyleSheet href="../../libs/bootstrap-3.3.7/css/bootstrap.min.css" TYPE="text/css" MEDIA=screen />
<script src="../../libs/bootstrap-3.3.7/js/bootstrap.min.js"></script> 

<link rel="stylesheet" type="text/css" href="../../libs/alertifyjs/css/alertify.css" >
<link rel="stylesheet" type="text/css" href="../../libs/alertifyjs/css/themes/bootstrap.min.css" >    
<script src="../../libs/alertifyjs/alertify.min.js"></script>

<script type="text/javascript">
$(document).ready(function() { 
	var options = { 
			target: '#output',   // target element(s) to be updated with server response 
			beforeSubmit: beforeSubmit,  // pre-submit callback 
			success: afterSuccess,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 $('#MyUploadForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}); 


}); 
function eliminarImg(id,idHorse){
var datos={
    opc:'del',
    id:id,
    idHorse:idHorse
};
 $.ajax({
                data:datos,
                url: "../../ajax/ajaxImagen.php",
                type:'POST',
                success :function(response){
                        var obj=JSON.parse(response);
                        //$("#divResultNuevo").html(response);
                        // $("#divNuevo").dialog("close");
                        if(obj.result==1){
                        	// $("#output").html(response);
                 	listarImg(idHorse);
                        }else if(obj.result==0){
                            alertify.error(obj.message);
                        }
                }
        });
}
function listarImg(idHorse){
var datos={
    opc:'lst',
    id:idHorse
};
 $.ajax({
                data:datos,
                url: "../../ajax/ajaxImagen.php",
                type:'POST',
                success :function(response){
                        
                        $("#output").html(response);
                      
                        
                }
        });
}
function updPrincipal(id,isMain,idHorse){
//console.log(id+".."+isMain+".." +idHorse);
var datos={
    opc:'upd',
    id:id,
    main:isMain,
    idHorse:idHorse
};
 $.ajax({
                data:datos,
                url: "../../ajax/ajaxImagen.php",
                type:'POST',
                success :function(response){
                       var obj=JSON.parse(response);
                        if(obj.result==1){
                 			listarImg(idHorse);
                        }else if(obj.result==2){
                        	alertify.error(obj.message);
                        }else if(obj.result==0){
                        	alertify.error(obj.message);
                        }
                      
                        
                }
        });
}

function mostrarImgGrande(img){
 
$("#imgHorse").attr("src",img);
$("#mvImagen").modal("show");


}

function afterSuccess()
{
	$('#submit-btn').show(); //hide submit button
	$('#loading-img').hide(); //hide submit button

}

//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !$('#imageInput').val()) //check empty input filed
		{
//			$("#output").html("Are you kidding me?");
			alertify.error("seleccione imagen");
			return false
		}
		
		var fsize = $('#imageInput')[0].files[0].size; //get file size
		var ftype = $('#imageInput')[0].files[0].type; // get file type
		

		//allow only valid image file types 
		switch(ftype)
        {
            case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                break;
            default:
                //$("#output").html("<b>"+ftype+"</b> Unsupported file type!");
                alertify.error("<b>"+ftype+"</b> Unsupported file type!");
				return false
        }
		
		//Allowed file size is less than 1 MB (1048576)
		if(fsize>1048576) 
		{
			//$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
			alertify.error("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
			return false
		}
				
		$('#submit-btn').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#output").html("");  
	}
	else
	{
		//Output error to older browsers that do not support HTML5 File API
		alertify.error("Please upgrade your browser, because your current browser lacks some new features we need!");
		//$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

</script>
<link href="style/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="upload-wrapper">
<div align="center">
<h3>
	Agregar Imagenes del ejemplar: <?=$_GET['idHorse']?>  
		</h3>
<form action="processupload.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
<input name="image_file" id="imageInput" type="file" />
<input type="submit"  id="submit-btn" value="Upload" />
<img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
<input name="idHorse" id="idHorse" type="hidden" value='<?=$_GET["idHorse"]?>' />
<input name="hidNameHorse" id="hidNameHorse" type="hidden" value='<?=$_GET["nh"]?>' />
<input name="hidPrefijoHorse" id="hidPrefijoHorse" type="hidden" value='<?=$_GET["prefh"]?>' />
</form>
<div id="output" style="width: 100%;">
	
<script type="text/javascript">
listarImg('<?=$idHorse2?>');
</script>
</div>
<div>	

<img >

</div>	
</div>


</div>

</body>
</html>

<style>
.modal-dialog-customer-img { 
max-width : 80% ;
width : 80% ;
}
</style>
  <div class="modal fade" id="mvImagen" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-customer-img">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> </h4>
        </div>
        <div class="modal-body">
 	 <img src="" id="imgHorse" width="100%">
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>