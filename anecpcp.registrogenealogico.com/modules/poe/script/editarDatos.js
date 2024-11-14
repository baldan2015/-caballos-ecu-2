$(function () {
    $('#modalEditarDatos').on('shown.bs.modal', function () {
        datosSocio();
    });
    $("#btnClaveNew").click(function(event) {
        verClave('btnClaveNew',2);
    });
    $("#btnClave").click(function(event) {
        verClave('btnClave',1);
    });
});

function utf8ToHex(str) {
    var resultado='';
    var sinespacios = str.trim();

    if(sinespacios!=''){
        resultado = Array.from(str).map(c =>
                c.charCodeAt(0) < 128 ? c.charCodeAt(0).toString(16) :
                encodeURIComponent(c).replace(/\%/g, '').toLowerCase()
            ).join('');
    }else{
        resultado = '';
    }
    return resultado;
}

var listarDeparmentoEditarDatos = function (control, mensaje, valor) {

    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    $("#" + control).append("<option value='0'>" + mensaje + "</option>");

    $.ajax({
        url: '../ajaxPOE/ajaxEditarDatos.php',
        data: {
            opc: "lstItemsDepartamento"
        },
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            //console.log(dato);
            var tipoDepart = dato.data;

            if (dato.result == 1) {

                $.each(tipoDepart, function (index, tp) {

                    var selected = "";
                    if (val == tp.valor) selected = "Selected";
                    $("#" + control).append("<option value='" + tp.valor + "' " + selected + ">" + tp.descripcion + "</option>");
                });
            } else {
                alertify.error(dato.message);
            }
        }
    });
}

function datosSocio() {
     limpiarModalEditDatos();
    $.ajax({
        type: "POST",
        data: {
            opc: 'datosProp'
        },
        url: "../ajaxPOE/ajaxEditarDatos.php",
        success: function (response) {
            //console.log(response);
            var datos = JSON.parse(response);
            var entidad = datos.data;
            $("#txtNumDoc").val(entidad.numDoc);
            $("#txtApePaterno").val(entidad.apePaterno);
            $("#txtApeMaterno").val(entidad.apeMaterno);
            $("#txtNombres").val(entidad.nombres);
            $("#txtcorreo").val(entidad.correo);
            $("#txttel").val(entidad.telefono1);
            $("#txtcel").val(entidad.telefono2);
            //$("#cboDepCri").val(entidad.idDpto);
            //$("#txtlugarCrianza").val(entidad.lugarCria);
            $("#txtprefijo").val(entidad.prefijo);
            $("#txtlogin").val(entidad.login);
            $("#txtcorreoOld").val(entidad.correo);
            //listarDeparmentoEditarDatos("cboDepCri", "seleccione", entidad.idDpto);
        }
    });
}

function validarCampos(numButton) {
    EditarDatos(numButton);
}

function limpiarModalEditDatos(){
    $("#txtNumDoc").val('');
    $("#txtApePaterno").val('');
    $("#txtApeMaterno").val('');
    $("#txtNombres").val('');
    $("#txtcorreo").val('');
    $("#txttel").val('');
    $("#txtcel").val('');
   // $("#cboDepCri").val('');
   // $("#txtlugarCrianza").val('');
    $("#txtlogin").val('');
    $("#txtpassword").val('');
    $("#txtpasswordNew").val('');
    $("#txtvpassword").val('');
    $("#txtcorreoOld").val('');
}

function EditarDatos(tipoEdit){
    $.ajax({
        type: "POST",
        data: {
            opc: 'editarDatos',
            numDoc: $("#txtNumDoc").val(),
            apePaterno: $("#txtApePaterno").val(),
            apeMaterno: $("#txtApeMaterno").val(),
            nombres: $("#txtNombres").val(),
            correo: $("#txtcorreo").val(),
            telefono1: $("#txttel").val(),
            telefono2: $("#txtcel").val(),
            //DepCri: $("#cboDepCri").val(),
            //lugarCrianza: $("#txtlugarCrianza").val(),
            login: $("#txtlogin").val(),
            pass: utf8ToHex($("#txtpassword").val()),
            passnew: utf8ToHex($("#txtpasswordNew").val()),
            tipoEdit: tipoEdit,
            vpass :utf8ToHex($("#txtvpassword").val()),
            correoOld: $("#txtcorreoOld").val()
        },
        url: "../ajaxPOE/ajaxEditarDatos.php",
        success: function (response) {
            var datos = JSON.parse(response);
            if (datos.result == 1) {
                $('#txtpassword').val('');
                $('#txtpasswordNew').val('');
                $("#txtvpassword").val('');
                modalClave("hide");
                datosSocio();
                alertify.success(datos.message);
            } else if (datos.result == 2) {
                $('#txtpassword').val('');
                $('#txtpasswordNew').val('');
                $("#txtvpassword").val('');
                datosSocio();
                modalClave("hide");
                alertify.error(datos.message);
            } else {
                modalClave("hide");
                datosSocio();
                alertify.error(datos.message);
            }
        }
    });
}

function modalClave(action){
    $("#myModalPassword").modal(action);
}

function verClave(control,tipo) {
    if(tipo==2){
        input='txtpasswordNew';
    }else{
        input='txtpassword';
    }

    if ('password' == $('#'+input).attr('type')) {
        $('#'+input).prop('type', 'text');
        $('#'+control).html('<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>');
    } else {
        $('#'+input).prop('type', 'password');
        $('#'+control).html('<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>');
    }
}