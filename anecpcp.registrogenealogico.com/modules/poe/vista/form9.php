<?PHP require("../../../constante.php");
require(DIR_LEVEL_MOD_POE . "Funciones/general.php");
require("../header.php");
require(DIR_LEVEL_MOD_POE . DIR_VALIDAR);
if (ValidarSession()) {
	require("../libs.php");
	$activo9 = "active";
?>

	<style type="text/css">
		.badge-info {
			background-color: #5bc0de !important;
		}

		.tituloTop {
			color: #3c763d;
			text-transform: uppercase;
			font-family: Franklin Gothic Medium;
			font-size: 24px;

		}

		.button-text {
			display: block;
		}

		@media only screen and (max-width: 600px) {
			.tituloTop {
				margin-left: 0px !important;
			}

			.button-text {
				display: none;
			}
		}

		@media only screen and (min-width: 768px) {
			.tituloTop {
				margin-left: 0px !important;
			}

			.button-text {
				display: none;
			}
		}

		#lblCantidadSol {
			font-size: 20px;
		}

		html,
		body {
			max-width: 100%;
			overflow-x: hidden;
		}
	</style>
	<script src="../script/form9.js"></script>
	<!--<script src="../script/busquedaEjemplar.js"></script>
<script src="../script/generales/general.buscar.ejemplar.js"></script>-->
	<script src="../script/generales/dropdownlist.js"></script>
	<script src="../script/generales/modalresenas.js"></script>
	<script src="upload/js/jquery.form.min.js"></script>
	<script src="upload/js/jquery.PrintArea.js"></script>
	<link rel="stylesheet" type="text/css" href="../libs/datatables-1.10.23/datatables.min.css" />
	<script type="text/javascript" src="../libs/datatables-1.10.23/datatables.min.js"></script>

	<table border=1 cellpadding=0 cellspacing=0 width=100%>
		<?
		require("../barra.php");
		// require("../validarPoe.php");
		$dato = obtenerIdPropietario($_SESSION["xid"]);
		//echo "<br><br><br><br><br><br><br><br><br><br><br><br>".$_SESSION["xid"];
		if ($dato == 0) {
			die("<br><br><br><br><br><br><br><br><br><br><br><br><center><span style='font-weight:bold; font-size:12px';>Ud No puede registrar inscripciones de ejemplares. El usuario no tiene código del Propietario.<br>Contáctese con el administrador</span></center><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>");
			exit();
		}
		?>
		</tr>
	</table>

	<div class="container-fluid">
		<div class="row fondoFilaCabecera">

			<div class="col-md-8 tituloTop">
				<img src="../../../home/img/ins.jpg" class="image_redonda" />
				<span>
					&nbsp; Inscripción de nuevos ejemplares <span class="badge badge-pill badge-danger-tit" id='lblTituloPoe'><?= $periodo ?></span>
					<span class="badge badge-success" id="lblCantidadSol">0</span>
				</span>

			</div>
			<div class="col-md-4 text-right" style="margin-top: 16px;  ">

				<div class="btn-group" role="group" aria-label="...">
					<button data-toggle='tooltip' style="display: none;" id="btnPrint" class="btn btn-sm btn-default" title="Imprimir"><span class="glyphicon glyphicon-print"></span>&nbsp; Imprimir</button>

					<button id="btnCancelar" style="display: none;" data-toggle='tooltip' class="btn btn-sm btn-default" title="Cancelar operación"><span data-toggle='tooltip' class="glyphicon glyphicon-refresh"></span>&nbsp;Cancelar</button>
					<button data-toggle='tooltip' style="display: none;" id="btnGrabar" class="btn btn-sm btn-success" title="Registrar lista inscripciones"><span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Grabar</button>
				</div>
				<input type="hidden" id="hidIdProp" value="<?= $_SESSION['xid'] ?>" />
				<input type="hidden" id="hidIdEntidad" value="<?= $_SESSION['usuarios'][0]->id ?>" />
				<input type="hidden" id="hidIdPoe" value="<?= $_SESSION[VAR_PERIODO_SESION] ?>" />


				<div style="float: right; margin-top: -7px;">
					<div class="btn-group" role="group" aria-label="...">
						<button id="btnAgregar" data-toggle='tooltip' title="crear nueva solicitud de inscripción " class="btn btn-info">
							<span class="glyphicon glyphicon-plus"></span> Nueva Incripción
						</button>

						<button style="display: none;" onclick="listarInscripciones();" data-toggle='tooltip' title="refrescar datos " class="btn   btn-primary">
							<span class="glyphicon glyphicon-refresh"></span>
						</button>

						<button onclick="window.location.href='../../../socio.php';" data-toggle='tooltip' title="Ir a mis operaciones " class="btn   btn-primary">
							<span class="glyphicon glyphicon-home"></span> Ir a mis trámites
						</button>
					</div>
				</div>
			</div>
			<div class="container-fluid" style="padding-top: 70px;">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-success">
							<div class="panel-heading">
								<div class="row">
									<div class="col-md-8">
										<div class="" style="text-align:initial;">
											<label>Filtros de búsqueda</label>
										</div>
									</div>
									<div class="col-md-4">
										<div class="" style="text-align: end;">
											<div class="btn-group" role="group" aria-label="...">
												<button id="btnBuscarFiltro" data-toggle="tooltip" title="Buscar" class="btn btn-default">
													<span class="glyphicon glyphicon-search"></span> Buscar
												</button>

												<button id="btnLimpiarFiltro" data-toggle="tooltip" title="Limpiar filtros" class="btn btn-default">
													<span class="glyphicon glyphicon-refresh"></span> Limpiar Filtro
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="panel-body">
								<div class="col-md-2">
									<label>GENERO:</label>
									<select class="form-control input-sm selectpicker show-tick " data-live-search="true" data-size="10" data-width="100%" id="cboGenero">
										<option value="0">TODOS</option>
										<option value="Y">YEGUA</option>
										<option value="P">POTRO</option>
									</select>
								</div>
								<div class="col-md-1">
									<label>PELAJE</label>
									<select class="form-control input-sm selectpicker show-tick " data-live-search="true" data-size="10" data-width="100%" id="cboPelajeFiltro"></select>
								</div>
								<div class="col-md-2">
									<label>FECHA NACIMIENTO</label>
									<input class="form-control input-sm" type="date" id="txtFecNac" />
								</div>
								<div class="col-md-2">
									<label>MADRE</label>
									<input class="form-control input-sm" type="text" id="txtMadre" />
								</div>
								<div class="col-md-2">
									<label>PADRE</label>
									<input class="form-control input-sm" type="text" id="txtPadre" />
								</div>
								<div class="col-md-2">
									<label>ESTADO</label>
									<select class="form-control input-sm selectpicker show-tick " data-live-search="true" data-size="10" data-width="100%" id="cboEstado">

									</select>
								</div>
							</div>
						</div>

					</div>

				</div>
			</div>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12" style="margin-top:10px !important;">
						<table id="grid" class="table-responsive  table table-striped table-bordered     table-hover  " style="width: 100%;">
							<thead>
								<tr>
									<th>Código</th>
									<th>Pref. </th>
									<th>Nombre </th>
									<th>genero </th>
									<th>Pelaje</th>
									<th>Fec Nac. </th>
									<th>Criador </th>
									<th>Madre</th>
									<th>Padre</th>
									<th>Estado</th>
									<th>Fec Sol. </th>
									<th style="width: 160px;">Opc.</th>

								</tr>
							</thead>
						</table>




					</div>
				</div>
			</div>


		</div>
	<?
} else {
	header("Location: " . DIR_LEVEL_MOD_POE);
}
require("popup/printInscripcionEjemplar.php");
require("popup/inscripcionPopSeguimiento.php");
//require("upload/inscripcionPopPdfEjemplar.php");
//require("upload/inscripcionPopImgEjemplar.php");
//require("../popupsrchgrl.php");
require("popup/inscripcionPopNeoEjemplar.php");
require("../popupsrchgrl.php");



	?>