var K_TOKEN_NAME = "Authorization";
$(function () {

    $("#btnXlsMisEjemplar").on("click", function () {
        document.location.href = "profileXls.php";
    });
    $("#divVerImagen .ui-dialog-titlebar").hide();
    listarMiPropiedad(2, 'asc');
    listarPelaje("cboPelaje", "SELECCIONE", 0);

    $("#btnBuscarFiltro").on("click", function () {
        listarMiPropiedad(2, 'asc');
    });

    $("#btnLimpiarFiltro").on("click", function () {
        limpiarFiltros();
        listarMiPropiedad(2, 'asc');
    });
    $("#btnAgregarConcurso").on("click",function(){
        $("#seccionAgregar").show();
        listarConcursos('selConcurso', 'SELECCIONE', 0);
    });
    $("#btnRegistrar").on("click", function(){
        insertarConcurso();
    })
    $("#btnCancelar").on("click", function () {
        limpiarControlesConcursos();
      });
    $("#selConcurso").on("change", function () {
        var id = $("#selConcurso").val(); 
        datosConcurso(id);
      });
});
var limpiarFiltros = function () {
    $("#filtroNombre").val('');
    $("#cboGenero").val('');
    $("#cboPelaje").val(0);
    $("#txtMadre").val('');
    $("#txtPadre").val('');
    $("#cboEstado").val('');
}
var listarPelaje = function (control, mensaje, valor) {
    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    $("#" + control).append("<option value='0'>" + mensaje + "</option>");
    $.ajax({
        url: 'ajaxPOE/ajaxPelaje.php',
        data: {
            opc: "lst"
        },
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            var tipoPelaje = dato.data;
            //console.log(dato);
            if (dato.result == "1") {
                $.each(tipoPelaje, function (index, tp) {
                    var selected = "";
                    if (val == tp.id) selected = "Selected";
                    $("#" + control).append("<option value='" + tp.nombre + "' " + selected + ">" + tp.nombre + "</option>");
                });
            } else {
                alertify.error(dato.message);
            }
        }
    });
}

var listarMiPropiedad = function (col, orden) {
    $.ajax({
        data: {
            opc: 'lstEcu',
            field: col,
            order: orden,
            idProp: $("#hidIdProp").val(),
            nombre: $("#filtroNombre").val(),
            genero: $("#cboGenero").val(),
            pelaje: $("#cboPelaje").val() == 0 ? '':$("#cboPelaje").val(),
            madre: $("#txtMadre").val(),
            padre: $("#txtPadre").val(),
            adn: $("#cboEstado").val()
        },
        url: '../modules/poe/services/ejemplarService.php',
        type: 'post',
        beforeSend: function (request) {
            request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
        },
        success: function (response) {

            var retorno = JSON.parse(response);
            if (retorno.result == "1") {
                var data = retorno.data;
                $("#cantidadMisEjemplares").text(retorno.cantidad);
                setDataTable(data, retorno.cantidad);
            } else {
                alertify.error(retorno.message);
            }
        },
        /*beforeSend: function() {
            	      ajaxindicatorstartB('Obteniendo datos..');
			    },*/
        complete: function () {
            ajaxindicatorstopB();
        }
    });
};


var setDataTable = function (data, numRow) {
    $('#grid').DataTable({
        data: data,
        language: {
            search: "Búsqueda:",
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No se encontraron registros",
            info: "Página  _PAGE_ de _PAGES_",
            infoEmpty: "No se encontraron registros"
        },
        responsive: true,
        destroy: true,
        pageLength: 100,
        columns: [{
                "data": "codigo"
            },
            /*{ "data": "prefijo" },*/
            {
                "data": "nombre",
                "render": function (datum, type, row) {

                    return row.prefijo + ' - ' + row.nombre;

                }
            },
            {
                "data": "pelaje"
            },
            {
                "data": "fecnac",
                "render": function (datum, type, row) {
                    if (datum != '' && datum != null) {
                        var dia = (datum).split("/")[0];
                        var mes = (datum).split("/")[1];
                        var anio = (datum).split("/")[2];
                        return "<span class='hidden'>" + anio + mes + dia + "</span>" + datum;
                    }

                }
            },
            {
                "data": "fallec",
                "render": function (datum, type, row) {
                    if (row.fallec == "1") {
                        return "<img src='img/qcruz.png' border=0 width='16' height=14 alt='Fallecido' title='fallecido'> ";
                    } else {
                        return "<img src='../img/silueta.png' border=0 width='16' height=14 alt='ejemplar vivo' title='ejemplar vivo '> ";
                    }
                }
            },
            {
                "data": "criador"
            },
            {
                "data": "codpad"
            },
            /*  { "data": "prefpa" },*/
            {
                "data": "nompad",
                "render": function (datum, type, row) {
                    var pref = (row.prefpa === null) ? '' : row.prefpa;
                    var nom = (row.nompad === null) ? '' : row.nompad;
                    return pref + ' - ' + nom;
                }
            },
            {
                "data": "codmad"
            },
            /*{ "data": "prefma" },*/
            {
                "data": "nommad",
                "render": function (datum, type, row) {
                    var pref = (row.prefma === null) ? '' : row.prefma;
                    var nom = (row.nommad === null) ? '' : row.nommad;
                    return pref + ' - ' + nom;
                }
            },
            {
                "data": "genero",
                render: function (datum, type, row) {
                    if (datum === "Y") return "YEGUA";
                    else return "POTRO";
                }
            },
            {
                "data": "adn"
            },
            {
                "className": 'edit',
                "orderable": false,
                "data": null,
                "defaultContent": "",
                "render": function (obj) {
                    var rowTable = "<span title='Ver Imagenes del Ejemplar'  data-toggle='tooltip'  data-id='" + obj.codigo + "' onclick='verImagen(this);' ><img src='../img/iconDetails/foto.png'> </span> ";
                    rowTable = rowTable + "<span title='ir a ver crias del ejemplar'  data-toggle='tooltip' data-id='" + obj.codigo + "'  data-genero='" + obj.genero + "' data-title='1' onclick='verCrias(this);' ><img src='../img/iconDetails/uno.gif' width='20'></span> ";
                    rowTable = rowTable + "<span title='ir a ver arbol genealógico'  data-toggle='tooltip' data-id='" + obj.codigo + "'  onclick='verArbol(this);'><img src='../img/iconDetails/b_relations.png'></span> ";
                    rowTable = rowTable + "<span title='ir a ver concursos que participó el ejemplar.' data-toggle='tooltip' data-nombre='"+ obj.nombre +"' data-id='" + obj.codigo + "'  onclick='verConcurso(this);'><img src='../img/iconDetails/premio.png' height='15' width='20'></span>";
                    return rowTable;
                }
            }
        ]
    });
    $("#lblCantidadSol").html(numRow);
    $("#tbInscripcion tbody").html("");
    $('[data-toggle="tooltip"]').tooltip();
    // $('#grid tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
};






function viewArbol(idHorse) {
    var url = "arbolgen.php?id=" + idHorse;
    $("#resultadoArbol").load(url);
}

function viewDetaCria(url) {
    $("#crias").load(url);
}

function listarImagenes(idEjemplar, xpagina, opc, idImg) {

    opc = (opc == undefined ? "" : opc);
    $.ajax({
        data: {
            idhorse: idEjemplar,
            pagina: xpagina,
            opc: opc,
            idImg: idImg
        },
        url: 'upload/galeria.php',
        type: 'post',

        success: function (response) {
            $("#galeria").slideDown("slow");
            $("#galeria").html(response);
        }
    });

    return false;

}

function cerrarGaleria() {
    $("#divVerImagen").dialog("close");
    return false;
}



function verImagen(obj) {


    $("#mvImagenEjemplarr").modal("show");

    var idH = $(obj).data("id");

    listarImagenes(idH, 1, '', 0);
}

function verCrias(obj) {
    var idH = $(obj).data("id");
    var gen = $(obj).data("genero");
    var tit = $(obj).data("title");
    var url = "crias.php?gen=" + gen + "&id=" + idH + "&title=" + tit;


    $("#crias").load(url, function () {
        $('#mvCriasEjemplarr').modal({
            show: true
        });
    });

}


function verArbol(obj) {

    var idH = $(obj).data("id");
    var url = "arbolgen.php?id=" + idH;
    console.log(url);

    $("#resultadoArbol").load(url, function () {
        $('#mvEjemplarArbolGenealogico').modal({
            show: true
        });
    });


}

function ajaxindicatorstartB(text) {
    if (jQuery('body').find('#resultLoading').attr('id') != 'resultLoading') {
        jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src="img/ajax-loader.gif"><div>' + text + '</div></div><div class="bg"></div></div>');
    }

    jQuery('#resultLoading').css({
        'width': '100%',
        'height': '100%',
        'position': 'fixed',
        'z-index': '10000000',
        'top': '0',
        'left': '0',
        'right': '0',
        'bottom': '0',
        'margin': 'auto'
    });

    jQuery('#resultLoading .bg').css({
        'background': '#000000',
        'opacity': '0.3',
        'width': '100%',
        'height': '100%',
        'position': 'absolute',
        'top': '0'
    });

    jQuery('#resultLoading>div:first').css({
        'width': '250px',
        'height': '75px',
        'text-align': 'center',
        'position': 'fixed',
        'top': '0',
        'left': '0',
        'right': '0',
        'bottom': '0',
        'margin': 'auto',
        'font-size': '16px',
        'z-index': '10',
        'color': '#ffffff'

    });

    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeIn(200);
    jQuery('body').css('cursor', 'wait');
}

function ajaxindicatorstopB() {
    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeOut(200);
    jQuery('body').css('cursor', 'default');
}