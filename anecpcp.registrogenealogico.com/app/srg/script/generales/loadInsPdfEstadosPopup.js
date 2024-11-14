$(document).ready(function() { 
	var options = { 
			target: '#outputPdfE',   // target element(s) to be updated with server response 
			beforeSubmit: beforeSubmitPdfE,  // pre-submit callback 
			success: afterSuccessPdfE,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		}; 
  $('#MyUploadFormPdfE').submit(function() {$(this).ajaxSubmit(options); return false; }); 
  $("#btnClosePdfView").on("click",function(){$("#mvPdfE").modal("hide");});

}); 

function eliminarPdf(id,idHorse){
    alertify.confirm("Está seguro de eliminar el siguiente certificado?", function (e) {
        if (e) {
            var datos={
                opc:'delInsTMP',
                id:id,
                idHorse:idHorse
            };
             $.ajax({
                            data:datos,
                            url: "ajax/ajaxImagenIns.php",
                            type:'POST',
                            success :function(response){
                                    var obj=JSON.parse(response);
                                    if(obj.result==1){
                                        alertify.success(obj.message);
                                        listarPdf(idHorse);
                                    }else if(obj.result==999){
                                        alertify.error(obj.message);
                                    }else if(obj.result==0){
                                        alertify.error(obj.message);
                                    }
                            }
                    });
        }
    });
}
function listarPdfE(idHorse){
var datos={
    opc:'lstPdfIns',
    id:idHorse
};
 $.ajax({
                data:datos,
                url: "ajax/ajaxImagenIns.php",
                type:'POST',
                success :function(response){
                        $("#outputPdfE").html(response);
                }
        });
}
 
/*function mostrarImgGrande(img){
$("#ifrPDFE").attr("src",img);
$("#mvPdfE").modal("show");
}*/

function afterSuccessPdfE()
{
	$('#submit-btn-pdfE').show(); //hide submit button

}

//function to check file size before uploading.
function beforeSubmitPdfE(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{

        if($("#ddlTipoDoc").val()==0){
            alertify.error("Seleccione el tipo de documento");
            return false
         } 
         console.log($('#pdfInputE').val());
		if( !$('#pdfInputE').val()) //check empty input filed
		{
//			$("#output").html("Are you kidding me?");
			alertify.error("Seleccione documento");
			return false
		}
		
		var fsize = $('#pdfInputE')[0].files[0].size; //get file size
		var ftype = $('#pdfInputE')[0].files[0].type; // get file type
		

		//allow only valid image file types 
		switch(ftype)
        {
            case 'application/pdf':
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
				
		$('#submit-btn-pdfE').hide(); //hide submit button
		//$('#loading-img').show(); //hide submit button
		$("#outputPdfE").html("");  
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

function tipoDocE(){
    
    var docE = $("#ddlTipoDoc option:selected").val();
    //console.log(docE);
    $("#idTipoDocE").val(docE);
    //console.log($("#idTipoDoc").val(docE));
}