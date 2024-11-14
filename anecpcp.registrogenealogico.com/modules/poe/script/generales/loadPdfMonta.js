$(document).ready(function () {
    var options = {
        target: '#outputPdf', // target element(s) to be updated with server response 
        beforeSubmit: beforeSubmitPdf, // pre-submit callback 
        success: function(response){
            //console.log(response);
            var retorno = JSON.parse(response);
            //alert(retorno.message);
            if(retorno.result==1){
                alertify.alert(retorno.message);
                $("#mvNuevoEjemplar").modal("hide");
                listaServicioY();
            }else{
                alertify.error(retorno.message);
            }
            
           
            return false;
        },
            //afterSuccessPdf, // post-submit callback 
        resetForm: true // reset the form after successful submit 
    };
    $('#MyUploadFormPdf').submit(function (e) {
        //console.log("AQUI",options);
        $("#MyUploadFormPdf").ajaxSubmit(options);
        e.preventDefault();
       // console.log(options);
        return false;
      
    });
    $("#btnClosePdfView").on("click", function () {
        $("#mvPdf1").modal("hide");
    });
});

function afterSuccessPdf() {
   // $('#submit-btn-pdf').show(); //hide submit button
//console.log(options);
//console.log("FINALIZO CARGA");
}

//function to check file size before uploading.
function beforeSubmitPdf() {
    //check whether browser fully supports all File API
    if (window.File && window.FileReader && window.FileList && window.Blob) {

        //  console.log('#pdfInputPotro val',$('#pdfInputPotro').val());
        //  console.log('IpdfInputYegua val ',$('#pdfInputYegua').val());
        //  console.log("pdfInputPotro",$('#pdfInputPotro')[0].files[0] );
        //  console.log("pdfInputYegua",$('#pdfInputYegua')[0].files[0] );
        //  return false;
        if($('#pdfInputYegua')[0].files[0]!=undefined){
            var fsizeY = $('#pdfInputYegua')[0].files[0].size; //get file size
            var ftypeY = $('#pdfInputYegua')[0].files[0].type; // get file type
    
           
            //allow only valid image file types 
            switch (ftypeY) {
                case 'application/pdf':
                    break;
                default:
                    //$("#output").html("<b>"+ftype+"</b> Unsupported file type!");
                    alertify.error("<b>" + ftypeY + "</b> Unsupported file type!");
                    return false
            }
            
            //Allowed file size is less than 1 MB (1048576)
            if (fsizeY > 1572864) {
                //$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
                alertify.error("<b>" + bytesToSize(fsize) + "</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
                return false
            }

        }
        if($('#pdfInputPotro')[0].files[0]!=undefined){

      
            var fsizeP = $('#pdfInputPotro')[0].files[0].size; //get file size
            var ftypeP = $('#pdfInputPotro')[0].files[0].type; // get file type
            //allow only valid image file types 
           
            switch (ftypeP) {
                case 'application/pdf':
                    break;
                default:
                    //$("#output").html("<b>"+ftype+"</b> Unsupported file type!");
                    alertify.error("<b>" + ftypeP + "</b> Unsupported file type!");
                    return false
            }
            //Allowed file size is less than 1 MB (1048576)
            if (fsizeP > 1572864) {
                //$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
                alertify.error("<b>" + bytesToSize(fsize) + "</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
                return false
            }
        }

    } else {
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

function listarDoc(idMonta) {
    //console.log(idMonta);
    var datos = {
        opc: 'lstDocMonta',
        idMonta: idMonta
    };
    $.ajax({
        data: datos,
        url: "../ajax/ajaxImagen.php",
        type: 'POST',
        success: function (response) {
            var retorno = JSON.parse(response);
            //console.log(retorno);
            $("#outputPdf").html(response);
            datosDocYegua=[];
            datosDocPotro=[];

            if(retorno.length!=0){
                //console.log(retorno[0].esPadre);
                if(retorno[0]){
                    if(retorno[0].esPadre==0){
                        datosDocYegua=retorno[0];
                    }else if(retorno[0].esPadre==1){
                        datosDocPotro=retorno[0];
                    }   
                }
                if(retorno[1]){
                    if(retorno[1].esPadre==0){
                        datosDocYegua=retorno[1];
                    }else if(retorno[1].esPadre==1){
                        datosDocPotro=retorno[1];
                    }
                }
                 
            }
            //console.log("hesExtTerPotro",$("#hesExtTerPotro").val());
           // console.log("hesExtTerYegua",$("#hesExtTerYegua").val());
             //iniSeccionDocumentos(action,$("#hesExtTerPotro").val(),'P');
             //iniSeccionDocumentos(action,$("#hesExtTerYegua").val(),'Y');
           //console.log("POTRO",datosDocPotro);
           //console.log("YEGUA",datosDocYegua);
           
        }
    });
}

function mostrarImgGrande(doc,genero) {
    if(genero=='P'){
        //console.log(doc,genero);
        $('#aPDFMontaPotro').attr('target', '_blank'); 
        $("#aPDFMontaPotro").attr("href", doc);
    }else{
       // console.log(doc,genero);
        $('#aPDFMontaYegua').attr('target', '_blank'); 
        $("#aPDFMontaYegua").attr("href", doc);
    }
    
}