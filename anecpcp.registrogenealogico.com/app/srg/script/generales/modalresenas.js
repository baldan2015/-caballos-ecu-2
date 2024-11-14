var checkBox = {
    rdbtnCA: "#rdbtnCA",
    rdbtnAD: "#rdbtnAD",
    rdbtnAI: "#rdbtnAI",
    rdbtnPD: "#rdbtnPD",
    rdbtnPI: "#rdbtnPI",
    rdbtnCO: "#rdbtnCO",
    rdbtnALL: "#rdbtnALL"
}

function configCheckResenias(tipo) {
    if (tipo == 'ALL') {
        $(checkBox.rdbtnCA).prop('checked', false);
        $(checkBox.rdbtnAD).prop('checked', false);
        $(checkBox.rdbtnAI).prop('checked', false);
        $(checkBox.rdbtnPD).prop('checked', false);
        $(checkBox.rdbtnPI).prop('checked', false);
        $(checkBox.rdbtnCO).prop('checked', false);
    } else if (tipo == 'CA') {
        $(checkBox.rdbtnALL).prop('checked', false);
        $(checkBox.rdbtnAD).prop('checked', false);
        $(checkBox.rdbtnAI).prop('checked', false);
        $(checkBox.rdbtnPD).prop('checked', false);
        $(checkBox.rdbtnPI).prop('checked', false);
        $(checkBox.rdbtnCO).prop('checked', false);
    } else if (tipo == 'AI') {
        $(checkBox.rdbtnCA).prop('checked', false);
        $(checkBox.rdbtnAD).prop('checked', false);
        $(checkBox.rdbtnALL).prop('checked', false);
        $(checkBox.rdbtnPD).prop('checked', false);
        $(checkBox.rdbtnPI).prop('checked', false);
        $(checkBox.rdbtnCO).prop('checked', false);
    } else if (tipo == 'AD') {
        $(checkBox.rdbtnCA).prop('checked', false);
        $(checkBox.rdbtnALL).prop('checked', false);
        $(checkBox.rdbtnAI).prop('checked', false);
        $(checkBox.rdbtnPD).prop('checked', false);
        $(checkBox.rdbtnPI).prop('checked', false);
        $(checkBox.rdbtnCO).prop('checked', false);

    } else if (tipo == 'PD') {
        $(checkBox.rdbtnCA).prop('checked', false);
        $(checkBox.rdbtnAD).prop('checked', false);
        $(checkBox.rdbtnAI).prop('checked', false);
        $(checkBox.rdbtnALL).prop('checked', false);
        $(checkBox.rdbtnPI).prop('checked', false);
        $(checkBox.rdbtnCO).prop('checked', false);
    } else if (tipo == 'PI') {
        $(checkBox.rdbtnCA).prop('checked', false);
        $(checkBox.rdbtnAD).prop('checked', false);
        $(checkBox.rdbtnAI).prop('checked', false);
        $(checkBox.rdbtnPD).prop('checked', false);
        $(checkBox.rdbtnALL).prop('checked', false);
        $(checkBox.rdbtnCO).prop('checked', false);
    } else if (tipo == 'ALLNOT') {
        $(checkBox.rdbtnCA).prop('checked', false);
        $(checkBox.rdbtnAD).prop('checked', false);
        $(checkBox.rdbtnAI).prop('checked', false);
        $(checkBox.rdbtnPD).prop('checked', false);
        $(checkBox.rdbtnPI).prop('checked', false);
        $(checkBox.rdbtnCO).prop('checked', false);
    } else if (tipo == 'CO') {
        $(checkBox.rdbtnCA).prop('checked', false);
        $(checkBox.rdbtnAD).prop('checked', false);
        $(checkBox.rdbtnAI).prop('checked', false);
        $(checkBox.rdbtnPD).prop('checked', false);
        $(checkBox.rdbtnPI).prop('checked', false);
        $(checkBox.rdbtnALL).prop('checked', false);
    } else {
        //console.log('AQUI');
        $(checkBox.rdbtnCA).prop('checked', false);
        $(checkBox.rdbtnAD).prop('checked', false);
        $(checkBox.rdbtnAI).prop('checked', false);
        $(checkBox.rdbtnPD).prop('checked', false);
        $(checkBox.rdbtnPI).prop('checked', false);
        $(checkBox.rdbtnALL).prop('checked', true);
        $(checkBox.rdbtnCO).prop('checked', false);
    }
}

function openGrlResena(valorALL, valorCA, valorAI, valorAD, valorPD, valorPI, busqueda) {


    if (valorALL == 'ALL' && valorCA == '' && valorAI == '' && valorAD == '' && valorPD == '' && valorPI == '') {

        listarResenia("ddlReseniaLeftCA", busqueda, "");
    } else if (valorALL == '' && valorCA == 'CA' && valorAI == '' && valorAD == '' && valorPD == '' && valorPI == '') {

        listarResenia("ddlReseniaLeftCA", busqueda, "CA");
    } else if (valorALL == '' && valorCA == '' && valorAI == 'AI' && valorAD == '' && valorPD == '' && valorPI == '') {

        listarResenia("ddlReseniaLeftCA", busqueda, "AI");
    } else if (valorALL == '' && valorCA == '' && valorAI == '' && valorAD == 'AD' && valorPD == '' && valorPI == '') {

        listarResenia("ddlReseniaLeftCA", busqueda, "AD");
    } else if (valorALL == '' && valorCA == '' && valorAI == '' && valorAD == '' && valorPD == 'PD' && valorPI == '') {

        listarResenia("ddlReseniaLeftCA", busqueda, "PD");
    } else if (valorALL == '' && valorCA == '' && valorAI == '' && valorAD == '' && valorPD == '' && valorPI == 'PI') {

        listarResenia("ddlReseniaLeftCA", busqueda, "PI");
    } else if (valorALL == '' && valorCA == '' && valorAI == '' && valorAD == '' && valorPD == '' && valorPI == '') {

        listarResenia("ddlReseniaLeftCA", busqueda, "CO");
    }
    /*listarReseniaSelCA("ddlReseniaRightCA","","CA"); 
    listarReseniaSelAD("ddlReseniaRightAD","","AD");
    listarReseniaSelAI("ddlReseniaRightAI","","AI");
    listarReseniaSelPD("ddlReseniaRightPD","","PD"); 
    listarReseniaSelPI("ddlReseniaRightPI","","PI"); */
   
}

function buscarResenia() {
    var busqueda = $("#busquedaRe").val();
    // console.log("bus",busqueda);

   // console.log($(checkBox.rdbtnALL).is(':checked'));
    if ($(checkBox.rdbtnALL).is(':checked') == true) {
        // console.log("tipo","ALL");
        openGrlResena('ALL', '', '', '', '', '', $("#busquedaRe").val());
    }
    if ($(checkBox.rdbtnCA).is(':checked') == true) {
        //  console.log("tipo","CA");
        openGrlResena('', 'CA', '', '', '', '', $("#busquedaRe").val());
    }
    if ($(checkBox.rdbtnAD).is(':checked') == true) {
        //  console.log("tipo","AD");
        openGrlResena('', '', '', 'AD', '', '', $("#busquedaRe").val());
    }
    if ($(checkBox.rdbtnAI).is(':checked') == true) {
        //  console.log("tipo","AI");
        openGrlResena('', '', 'AI', '', '', '', $("#busquedaRe").val());
    }
    if ($(checkBox.rdbtnPD).is(':checked') == true) {
        //   console.log("tipo","AI");
        openGrlResena('', '', '', '', 'AI', '', $("#busquedaRe").val());
    }
    if ($(checkBox.rdbtnPI).is(':checked') == true) {
        //   console.log("tipo","PI");
        openGrlResena('', '', '', '', '', 'PI', $("#busquedaRe").val());
    }
    if ($(checkBox.rdbtnCO).is(':checked') == true) {
        openGrlResena('', '', '', '', '', '', $("#busquedaRe").val());
    }
}

function filtrosResenias() {
    var busqueda = '';//$("#busquedaRe").val();
    $(checkBox.rdbtnALL).change(function () {
        //console.log(this.checked);
        if (this.checked == true) {
            // console.log();
            $("#busquedaRe").val('');
            configCheckResenias('ALL');
            openGrlResena('ALL', '', '', '', '', '',busqueda);

        } else {
            configCheckResenias('ALLNOT');
        }
    });
    $(checkBox.rdbtnCA).change(function () {
        if (this.checked == true) {
            $("#busquedaRe").val('');
            configCheckResenias('CA');

            openGrlResena('', 'CA', '', '', '', '', busqueda);

        }
    });
    $(checkBox.rdbtnAD).change(function () {
        if (this.checked == true) {
            $("#busquedaRe").val('');
            configCheckResenias('AD');

            openGrlResena('', '', '', 'AD', '', '', busqueda);
        }
    });
    $(checkBox.rdbtnAI).change(function () {
        if (this.checked == true) {
            $("#busquedaRe").val('');
            configCheckResenias('AI');

            openGrlResena('', '', 'AI', '', '', '', busqueda);
        }
    });
    $(checkBox.rdbtnPD).change(function () {
        if (this.checked == true) {
            $("#busquedaRe").val('');
            configCheckResenias('PD');

            openGrlResena('', '', '', '', 'PD', '', busqueda);
        }
    });
    $(checkBox.rdbtnPI).change(function () {
        if (this.checked == true) {
            $("#busquedaRe").val('');
            configCheckResenias('PI');

            openGrlResena('', '', '', '', '', 'PI', busqueda);
        }
    });
    $(checkBox.rdbtnCO).change(function () {
        if (this.checked == true) {
            $("#busquedaRe").val('');
            configCheckResenias('CO');

            openGrlResena('', '', '', '', '', '', busqueda);
        }
    });
}

function botonesOrdenar() {
    $('#SelectedUp').on("click", function () {
        console.log($('#ddlReseniaRightCA option:selected').val());
        var $op = $('#ddlReseniaRightCA option:selected');

        $op.first().prev().before($op);
        concatenarResenia();
    });
    $('#SelectedDown').on("click", function () {
        var $op = $('#ddlReseniaRightCA option:selected');

        $op.last().next().after($op);
        concatenarResenia();
    });
}

function editResenias(reseniasJson) {
    var reseniaSelect = $("#ddlReseniaRightCA");
    if (reseniasJson == '' || reseniasJson == null) {
        $("#ddlReseniaRightCA option").remove();
    } else {
        $("#ddlReseniaRightCA option").remove();
        //console.log(JSON.stringify(ejemplar.listResenas));
        const resenias = reseniasJson;
        $.each(resenias, function (item, tp) {
            reseniaSelect.append('<option data-tp=' + tp.tipo + ' value=' + tp.id + '>' + tp.descripcion + '</option>');
        });
    }

}

function limpiarBusqueda() {
    $("#busquedaRe").val('');
    buscarResenia();
}