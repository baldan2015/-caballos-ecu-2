var collectionIDPdf = [];
$(document).ready(function() { 
    //console.log("111111111111");
	var options = { 
			target: '#outputPdf',   // target element(s) to be updated with server response 
			beforeSubmit: beforeSubmitPdf,  // pre-submit callback 
			success: afterSuccessPdf,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		}; 
  $('#MyUploadFormPdf').submit(function() {$(this).ajaxSubmit(options); return false; }); 
  $("#btnClosePdfView").on("click",function(){$("#mvPdf1").modal("hide");});

}); 

function eliminarPdf(id,idHorse, codigoGenerado,edit='new'){
    if (edit == 'new') {
        var datos = {
            opc: 'delInsTMP',
            id: id,
            idHorse: idHorse,
            tipo:edit
        };
       HideTr(id);
        $.ajax({
            data: datos,
            url: "ajax/ajaxImagenIns.php",
            type: 'POST',
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    alertify.success(obj.message);
                    listarPdf(idHorse,codigoGenerado,false,edit);
                } else if (obj.result == 998) {
                    alertify.error(obj.message);
                } else if (obj.result == 997) {
                    alertify.error(obj.message);
                } else if (obj.result == 0) {
                    alertify.error(obj.message);
                }
            }
        });
    }else{
        HideTrpdf(id);
        collectionIDPdf.push(id);
    }
}
function listarPdf(idHorse, codigoGenerado, vistaprevia = false,edit='edit') {
    var datos = {
        opc: 'lstPdfIns',
        id: idHorse,
        codigoGenerado: codigoGenerado,
        edit:edit
    };
    $.ajax({
        data: datos,
        //url: "../ajax/ajaxImagen.php",
        url: "ajax/ajaxImagenIns.php",
        type: 'POST',
        success: function (response) {
            $("#outputPdf").html(response);
            if (vistaprevia != false) {
                $(".btnDel.btn.btn-sm.btn-default.glyphicon.glyphicon-trash").hide();
                $("#acc").hide();
               // $("#pdfAd").hide();
                //$(".imgpdf").hide();
            }
        }
    });
}
function mostrarImgGrande(img){
    //console.log("imagen grandeeeeeeeeeee");
$("#ifrPDF1").attr("src",img);
$("#mvPdf1").modal("show");
}

function afterSuccessPdf()
{
	$('#submit-btn-pdf').show(); //hide submit button

}

//function to check file size before uploading.
function beforeSubmitPdf(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
        console.log($('#pdfInput').val());
        if($("#ddlTipoDocumento").val()==0){
            alertify.error("Seleccione el tipo de documento");
            return false
         } 
         console.log($('#pdfInput').val());
		if( !$('#pdfInput').val()) //check empty input filed
		{
//			$("#output").html("Are you kidding me?");
			alertify.error("Seleccione documento");
			return false
		}
		
		var fsize = $('#pdfInput')[0].files[0].size; //get file size
		var ftype = $('#pdfInput')[0].files[0].type; // get file type
		

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
				
		$('#submit-btn-pdf').hide(); //hide submit button
		//$('#loading-img').show(); //hide submit button
		$("#outputPdf").html("");  
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


function tipoDoc(){
    
    var doc = $("#ddlTipoDocumento").val();
    //console.log(docE);
    $("#idTipoDoc").val(doc);
    //console.log($("#idTipoDoc").val(docE));
}
function HideTrpdf(id) {
    $("#" + id + "_ins_pdf").hide();
}