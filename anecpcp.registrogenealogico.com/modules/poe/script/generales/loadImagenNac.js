var collectionID = [];
$(document).ready(function () {
    var options = {
        target: '#output', // target element(s) to be updated with server response 
        beforeSubmit: beforeSubmit, // pre-submit callback 
        success: afterSuccess, // post-submit callback 
        resetForm: true // reset the form after successful submit 
    };
    $('#MyUploadForm').submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
    $("#btnCloseImgView").on("click", function () {
        $("#mvImagen").modal("hide");
    });
});

function eliminarImg(id, idHorse, codigoGenerado, edit='new') {
    if (edit == 'new') {
        var datos = {
            opc: 'delNacTMP',
            id: id,
            idHorse: idHorse,
            tipo:edit
        };
        HidenDoc(id);
        $.ajax({
            data: datos,
            url: controllersREST.imagen,
            type: 'POST',
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    alertify.success(obj.message);
                    listarImg(idHorse, codigoGenerado,false,edit);
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
        HidenDoc(id);
        collectionID.push(id);
        
    }
}

function listarImg(idHorse, codigoGenerado, vistaprevia = false, edit = 'edit') {
    var datos = {
        opc: 'lstImgNac',
        id: idHorse,
        codigoGenerado: codigoGenerado,
        edit:edit
    };
    $.ajax({
        data: datos,
        //url: "../ajax/ajaxImagen.php",
        url:controllersREST.imagen,
        type: 'POST',
        success: function (response) {
            //console.log(response);
            $("#output").html(response);
            if (vistaprevia != false) {
                
                $("span#btnDelE").hide();
                //$("#btnDelE").hide();
            }

        }
    });
}
function EliminarDocumentosModal(esPdf) {
    var datos = {
        opc: 'dltDocNAC',
        esPDF: esPdf
    };
    $.ajax({
        data: datos,
        url: "../ajax/ajaxImagen.php",
        type: 'POST',
        success: function (response) {
            console.log(response);
        }
    });
}

function updPrincipal(id, isMain, idHorse) {
    //console.log(id+".."+isMain+".." +idHorse);
    var datos = {
        opc: 'upd',
        id: id,
        main: isMain,
        idHorse: idHorse
    };
    $.ajax({
        data: datos,
        url: "../../ajax/ajaxImagen.php",
        type: 'POST',
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                listarImg(idHorse);
            } else if (obj.result == 2) {
                alertify.error(obj.message);
            } else if (obj.result == 0) {
                alertify.error(obj.message);
            }


        }
    });
}

function mostrarImgGrande(img) {
    $("#imgHorse").attr("src", img);
    $("#mvImagen").modal("show");
}

function afterSuccess() {
    $('#submit-btn').show(); //hide submit button
    $('#loading-img').hide(); //hide submit button
}

//function to check file size before uploading.
function beforeSubmit() {
    //check whether browser fully supports all File API
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        if (!$('#imageInput').val()) //check empty input filed
        {
            //			$("#output").html("Are you kidding me?");
            alertify.error("seleccione imagen");
            return false
        }

        var fsize = $('#imageInput')[0].files[0].size; //get file size
        var ftype = $('#imageInput')[0].files[0].type; // get file type


        //allow only valid image file types 
        switch (ftype) {
            case 'image/png':
            case 'image/gif':
            case 'image/jpeg':
            case 'image/pjpeg':
                break;
            default:
                //$("#output").html("<b>"+ftype+"</b> Unsupported file type!");
                alertify.error("<b>" + ftype + "</b> Unsupported file type!");
                return false
        }

        //Allowed file size is less than 1 MB (1048576)
        if (fsize > 1048576) {
            //$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
            alertify.error("<b>" + bytesToSize(fsize) + "</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
            return false
        }

        $('#submit-btn').hide(); //hide submit button
        $('#loading-img').show(); //hide submit button
        $("#output").html("");
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

function HidenDoc(id) {
    var idTr = "#" + id + "_nac_img";
    $(idTr).css("display", "none");
    console.log(idTr);
}