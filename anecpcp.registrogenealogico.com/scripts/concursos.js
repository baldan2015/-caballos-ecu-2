function verConcurso(obj, action = 'crud') {
    $("#mvConcursoEjemplarr").modal("show");
    var idH = $(obj).data("id");
    var nomH = $(obj).data("nombre");

    if (action != 'crud') {
        idH = obj;
        nomH = $("#txtnomejemplar").val();
    }

    $.ajax({
        data: {
            opc: 'get',
            idhorse: idH
        },
        url: 'ajaxPOE/ajaxConcurso.php',
        type: 'post',
        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor...");
        },
        success: function (response) {
            $("#resultado").html('');
            var resultado = JSON.parse(response);
            limpiarControlesConcursos();
            $("#txtejmplar").html("Concursos del Ejemplar " + nomH + " " + idH);

            $("#txtcodejemplar").val(idH);
            $("#txtnomejemplar").val(nomH);

           
            if (response !== "null" && response !== null) {
                setDataTableConcurso(resultado, action);
            } else {
                
                //  console.log("AQUI");
                var table = $('#gridConcurso').DataTable({
                    retrieve: true,
                    paging: false,
                    language: {
                        search: "Búsqueda:",
                        lengthMenu: "Lista de Concursos",
                        zeroRecords: "No se encontraron registros",
                        info: "Página  _PAGE_ de _PAGES_",
                        infoEmpty: "No se encontraron registros",
                        paginate: {
                            "first": "Primero",
                            "last": "Último",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    }
                });

                table
                    .clear()
                    .draw();
                $("#gridConcurso_filter").css("display", "none");
            }

            //console.log(resultado);
        }
    });

}

var setDataTableConcurso = function (data, action) {
    $('#gridConcurso').DataTable({
        data: data,
        language: {
            search: "Búsqueda:",
            lengthMenu: "Lista de Concursos",
            zeroRecords: "No se encontraron registros",
            info: "Página  _PAGE_ de _PAGES_",
            infoEmpty: "No se encontraron registros",
            paginate: {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        responsive: true,
        destroy: true,
        bFilter: (action == 'view' ? true : false),
        pageLength: 5,
        columns: [{
                "data": "numero"
            },
            {
                "data": "concurso"
            },
            {
                "data": "fecha",
                "render": function (datum,type,row){
                    if (datum != '' && datum != null) {
                        var dia = (datum).split("/")[0];
                        var mes = (datum).split("/")[1];
                        var anio = (datum).split("/")[2];
                        return "<span class='hidden'>" + anio + mes + dia + "</span>" + datum;
                    }
                }
            },
            {
                "data": "juez"
            },
            {
                "data": "categoria"
            },
            {
                "data": "grupo"
            },
            {
                "data": "puesto"
            },
            {
                "data": "id",
                "render": function (datum, type, row) {
                    return "<button class='btn btn-default btn-sm' data-id='" + row.id + "' onclick='deleteResultado(this)'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button>";
                }
            }

        ],
        order: [[3, 'desc']]
    });
    //console.log(action);
    if (action == 'view') {
        var table = $('#gridConcurso').DataTable();

        table.columns([7]).visible(false);
        $("#gridConcurso_filter").css("display", "block");
    } else {
        $("#gridConcurso_filter").css("display", "none");
    }

}

function listarConcursos(control, mensaje, valor) {
    var val = valor == undefined ? 0 : valor;
    $("#" + control + " option").remove();
    $("#" + control).append("<option value='0'>" + mensaje + "</option>");
    $.ajax({
        url: 'ajaxConcursoList.php',
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            var concursos = dato.data;
            if (dato.result == "1") {
                $.each(concursos, function (index, tp) {
                    var selected = "";
                    if (val == tp.id) selected = "Selected";
                    $("#" + control).append("<option value='" + tp.id + "' " + selected + ">" + tp.nombre + "</option>");
                });
            } else {
                alertify.error(dato.message);
            }
        }
    });
}

function datosConcurso(id) {
    $.ajax({
        url: 'ajaxPOE/ajaxConcurso.php',
        data: {
            opc: 'datosConcurso',
            id: id
        },
        type: 'post',
        success: function (response) {
            // console.log(response);
            var datos = JSON.parse(response);
            if (response == 'null') {
                $("#txtfecha").val('');
                $("#txtjuez").val('');
            } else {
                $("#txtfecha").val(datos[0].fecha);
                $("#txtjuez").val(datos[0].juez);
            }

        }
    });
}

function insertarConcurso() {
    var ejemplar = $("#txtcodejemplar").val();
    var concurso = $("#selConcurso").val();
    //var fecha = $("#txtfecha").val();
    var categoria = $("#txtcategoria").val();
    var grupo = $("#txtgrupo").val();
    var puesto = $("#txtpuesto").val();


    $.ajax({
        url: 'ajaxPOE/ajaxConcurso.php',
        data: {
            opc: 'insert',
            concurso: concurso,
            idEjemplar: ejemplar,
            numPuesto: puesto,
            grupo: grupo,
            categoria: categoria,
            idProp: $("#hidIdProp").val()
        },
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            if (dato.result == 1) {
                limpiarControlesConcursos();
                verConcurso(ejemplar, 'list');
                alertify.success(dato.message);
            } else if (dato.result == 2) {
                limpiarControlesConcursos();
                alertify.error(dato.message);
            } else {
                alertify.error(dato.message);
            }
        }
    });
}

function limpiarControlesConcursos() {
    $("#seccionAgregar").hide();
    $("#selConcurso").val('');
    $("#txtfecha").val('');
    $("#txtcategoria").val('');
    $("#txtgrupo").val('');
    $("#txtpuesto").val('');
    $("#txtjuez").val('');
}

function deleteResultado(obj) {
    var idR = $(obj).data("id");
    $.ajax({
        url: 'ajaxPOE/ajaxConcurso.php',
        data: {
            opc: 'delete',
            id: idR
        },
        type: 'POST',
        success: function (response) {
            var dato = JSON.parse(response);
            var id = $("#txtcodejemplar").val()
            if (dato.result == 1) {
                limpiarControlesConcursos();

                verConcurso(id, 'list');
                alertify.success(dato.message);
            } else {
                alertify.error(dato.message);
            }
        }
    });
}