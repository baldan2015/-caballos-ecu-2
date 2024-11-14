var K_PATH_ROOT = "../";

$(function () {
	$("#txtBGNombre").on("keypress", function (e) {
		var target = (e.target ? e.target : e.srcElement);
		var key = (e ? e.keyCode || e.which : window.event.keyCode);
		if (key == 13) {
			_buscar();
		} else {
			return true;
		}

	});

	$("#btnBGBuscar").on("click", _buscar);

	/*ObtenerUrl(function(urlObtenida){
		if(urlObtenida!=''){
			console.log(urlObtenida.K_PATH_ROOT_SERVICIO);
		}
	});*/

});

var _buscar = function () {
	var request = $("#txtBGNombre").val().toUpperCase();
	//var hidCtrolId=$("#hidCtrolId").val();
	//var hidCtrolName=$("#hidCtrolName").val();
	var hidParents = $("#hidTipoParents").val();

	//console.log(hidParents);
	if ($("#txtBGNombre").val() == "") {
		var hidflag = "mine";
	} else {
		var hidflag = "all";
	}
	if ($("#rdbtnProp").is(":checked")) {
		var hidflag = "mine";
	}
	if ($("#rdbtnOT").is(":checked")) {
		var hidflag = "others";
	}
	if ($("#rdbtnEE").is(":checked")) {
		var hidflag = "foreign";
		$("#divBody").show();
		$("#formEjemplarExt").hide();
	}
	//	setDataTable2(request, hidParents,hidflag);
	/**/
	$.ajax({
		data: {
			request: request,
			//hidCtrolId:hidCtrolId,
			//hidCtrolName:hidCtrolName,
			hidParents: hidParents,
			idUser: $("#hidIdProp").val(),
			idPoe: $("#hidIdPoe").val(),
			flag: hidflag
		},
		url: K_PATH_ROOT + 'ajaxPOE/ajaxBusGralEjemplar_fase2.php',
		//url: '../ajaxPOE/ajaxBusGralEjemplar_fase2.php',
		type: 'post',
		success: function (response) {
			var retorno = JSON.parse(response);
			//if(retorno.cantidad == 0 ){
			//   $("#filasBody").html("<center>No se encontraron registros</center>");
			//}else{
			//   $("#filasBody").html("");
			setDataTable2(retorno.data, retorno.cantidad);
			// }
		}
	});

};



var setDataTable2 = function (data, numrow) {
	//console.log(data);
	var tabla = $('#gridBusquedaEjemplar').DataTable();
	tabla.clear();
	$('#gridBusquedaEjemplar').DataTable({
		/*	ajax:{
				type: 'POST',
				url: '../ajaxPOE/ajaxBusGralEjemplar_fase2.php',
				data: {
					request: request,
					hidParents: hidParents,
					idUser: $("#hidIdProp").val(),
					idPoe: $("#hidIdPoe").val(),
					flag: hidflag
				},
			},*/
		data: data,
		language: {
			search: "Búsqueda:",
			lengthMenu: "Mostrar _MENU_ registros por página",
			zeroRecords: "No se encontraron registros",
			info: "Página  _PAGE_ de _PAGES_",
			infoEmpty: "No se encontraron registros"
		},
		processing: true,
		//serverSide: true,
		info: true,
		responsive: true,
		destroy: true,
		searching: false,
		paging: true,
		lengthMenu: [
			[5, 10, 25, 50, -1],
			[5, 10, 25, 50, "All"]
		],
		pageLength: 5,
		recordsFiltered: 5,
		//bPaginate:false,
		columns: [{
				"data": "codigo"
			},
			{
				"data": "prefijo_caballo"
			},
			{
				"data": "nombre_caballo"
			},
			{
				"data": "nacimiento_caballo",
				"render": function (datum, type, row) {
					if (datum != '' && datum != null) {
						var dia = (datum).split("/")[0];
						var mes = (datum).split("/")[1];
						var anio = (datum).split("/")[2];
						return "<span class='hidden'>" + anio + mes + dia + "</span>" + datum;
					} else {
						return "";
					}

				}
			},
			{
				"data": "fallecio",
				"render": function (datum, type, row) {
					if (row.fallecio == "1") {
						return "<img src='../../../img/qcruz.png' border=0 width='16' height=14 alt='Fallecido' title='fallecido'> ";
					} else {
						return "<img src='../../../img/silueta.png' border=0 width='16' height=14 alt='ejemplar vivo' title='ejemplar vivo '> ";
					}
				}
			},
			{
				"data": "propietario_caballo"
			},
			{
				"data": "criador_caballo"
			},
			{
				"data": "codigo",
				"className": "text-center",
				render: function (datum, type, row) {
					return '<button title="Seleccionar ejemplar" onclick="ejeSel(this)" data-nombre_caballo="' + row.nombre_caballo + '" data-prefijo_caballo="' + row.prefijo_caballo + '" data-codigo="' + datum + '" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></button>';
				}
			}
		]
	});
	$('[data-toggle="tooltip"]').tooltip();
};

//var K_PATH_ROOT = "../../../../sge.service/services/";

function ejeSelForm1(obj) {

	var id = $(obj).data("codigo");
	var prefijo = $(obj).data("prefijo");
	var ejemplar = $(obj).data("ejemplar");
	var hidCtrolId = $(obj).data("crtid");
	var hidCtrolName = $(obj).data("name");

	insertBoton(id, prefijo, ejemplar);

	$("#" + hidCtrolId).val(id);
	$("#" + hidCtrolName).html(prefijo + "  " + ejemplar + " - " + id);
	$("#divBuscarEjemplar").modal("hide");
}

function ejeSel(control) {
	//console.log(obj);
	var tipo = $("#hidTipoParents").val();
	var codigo = $(control).data("codigo");
	var hidIdProp = $("#hidIdProp").val();

	if ($("#rdbtnEE").is(":checked")) {

		ObtenerUrl(function (urlObtenida) {
			if (urlObtenida != '') {
				$.ajax({
					data: {
						opc: 'valMiEjemplar',
						codigo: codigo,
						idProp: hidIdProp
					},
					url: urlObtenida.K_PATH_ROOT_SERVICIO + 'EjemplarService.php',
					type: 'post',
					success: function (response) {
						if (tipo == 'P') {
							var id = $(control).data("codigo");
							var prefijo = $(control).data("prefijo_caballo");
							var ejemplar = $(control).data("nombre_caballo");
							//var hidCtrolId=$(obj).data("crtid");
							//var hidCtrolName=$(obj).data("name");
							$("#hidCodigoPotro").val(id);
							$("#txtNombrePotro").html(prefijo + "  " + ejemplar + " - " + id);
							$("#divBuscarEjemplar").modal("hide");
							$("#lblANDP").html("NO");
							$("#hesExtTerPotro").val(response.result);
							//$("#divBody").show();
						} else if (tipo == 'Y') {
							//console.log("2333333");
							var id = $(control).data("codigo");
							var prefijo = $(control).data("prefijo_caballo");
							var ejemplar = $(control).data("nombre_caballo");
							//var hidCtrolId=$(obj).data("crtid");
							//var hidCtrolName=$(obj).data("name");
							$("#hidCodigoYegua").val(id);
							$("#txtNombreYegua").html(prefijo + "  " + ejemplar + " - " + id);
							$("#divBuscarEjemplar").modal("hide");
							$("#lblADNY").html("NO");
							$("#hesExtTerYegua").val(response.result);
						}
						mostrarSeccionDocumentos(response.result, tipo);
					}
				});
			}
		});


	} else {
		ObtenerUrl(function (urlObtenida) {
			if (urlObtenida != '') {
				/**VALIDACION PARA SABER SI ES SU PROPIEDAD */
				$.ajax({
					data: {
						opc: 'valMiEjemplar',
						codigo: codigo,
						idProp: hidIdProp
					},
					url: urlObtenida.K_PATH_ROOT_SERVICIO + 'EjemplarService.php',
					type: 'post',
					success: function (response) {
						if (tipo == 'P') {
							$("#hesExtTerPotro").val(response.result);
						} else {
							$("#hesExtTerYegua").val(response.result);
						}
						mostrarSeccionDocumentos(response.result, tipo);
					}
				});
				/** FIN DE LA VALIDACION */
				$.ajax({
					data: {
						opc: 'getADN',
						id: codigo
					},
					url: urlObtenida.K_PATH_ROOT_SERVICIO + 'EjemplarService.php',
					type: 'post',
					success: function (response) {
						let retorno;
						try {
							retorno = JSON.parse(response);
						} catch (e) {
							retorno = response;
						}

						if (tipo == 'P') {
							//var retorno=JSON.parse(response);
							var id = $(control).data("codigo");
							var prefijo = $(control).data("prefijo_caballo");
							var ejemplar = $(control).data("nombre_caballo");
							var dniPadre = retorno.data.adn;
							//var hidCtrolId=$(obj).data("crtid");
							//var hidCtrolName=$(obj).data("name");
							$("#hidCodigoPotro").val(id);
							$("#txtNombrePotro").html(prefijo + "  " + ejemplar + " - " + id);
							if (dniPadre.length > 0) {
								$("#lblANDP").html(retorno.data.adn);
							} else {
								$("#lblANDP").html("NO");
							}

							//$("#divBody").show();
							$("#divBuscarEjemplar").modal("hide");

						} else if (tipo == 'Y') {
							//var retorno=JSON.parse(response);
							//console.log(retorno.data.adn);
							var id = $(control).data("codigo");
							var prefijo = $(control).data("prefijo_caballo");
							var ejemplar = $(control).data("nombre_caballo");
							var dniMadre = retorno.data.adn;
							$("#hidCodigoYegua").val(id);
							$("#txtNombreYegua").html(prefijo + "  " + ejemplar + " - " + id);
							if (dniMadre.length > 0) {
								$("#lblADNY").html(retorno.data.adn);
							} else {
								$("#lblADNY").html("NO");
							}



							$("#divBuscarEjemplar").modal("hide");
						}
					}

				});
			}
		});

	}
}