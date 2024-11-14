<?PHP require("../../../constante.php");
require(DIR_LEVEL_MOD_POE . "Funciones/general.php");
require("../header.php");
require(DIR_LEVEL_MOD_POE . DIR_VALIDAR);
if (ValidarSession()) {
	require("../libs.php");
	$activo9 = "active";
?>



	<script src="../script/form11.js"></script>
	<script src="../script/busquedaEjemplar_fase2.js"></script>
	<!--<script src="../script/generales/general.buscar.ejemplar.js"></script>-->

	<script src="../script/generales/dropdownlist.js"></script>
	<script src="upload/js/jquery.form.min.js"></script>
	<script src="upload/js/jquery.PrintArea.js"></script>

	<link rel="stylesheet" type="text/css" href="../libs/datatables-1.10.23/datatables.min.css" />
	<script type="text/javascript" src="../libs/datatables-1.10.23/datatables.min.js"></script>

	<style type="text/css">
		.tituloTop {
			color: #3c763d;
			text-transform: uppercase;
			font-family: Franklin Gothic Medium;
			font-size: 24px;

		}

		.button-text {
			display: none;
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

	<div class="container-fluid ">

		<div class="row fondoFilaCabecera">


			<div class="col-md-7 tituloTop">
				<img src="../../../home/img/mon.jpg" class="image_redonda" />
				<span>
					&nbsp;Mis Servicios de Monta
					<span class="badge badge-success" id="lblCantidadSol">0</span>
				</span>

			</div>
			<div class="col-md-5" style="margin-top: 16px;  ">
				<div style="float:right ;">
					<div class="btn-group" role="group" aria-label="...">
						<button data-toggle='tooltip' style="display: none;" id="btnPrint" class="btn btn-sm btn-default" title="Imprimir"><span class="glyphicon glyphicon-print"></span>&nbsp; Imprimir</button>

						<button id="btnCancelar" style="display: none;" data-toggle='tooltip' class="btn btn-sm btn-default" title="Cancelar operación"><span data-toggle='tooltip' class="glyphicon glyphicon-refresh"></span>&nbsp;Cancelar</button>
						<button data-toggle='tooltip' style="display: none;" id="btnGrabar" class="btn btn-sm btn-success" title="Registrar lista nacimientos"><span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Grabar</button>
					</div>
					<input type="hidden" id="hidIdProp" value="<?= $_SESSION['xid'] ?>" />
					<input type="hidden" id="hidIdPoe" value="<?= $_SESSION[VAR_PERIODO_SESION] ?>" />
					<div class="btn-group" role="group" aria-label="...">


						<button style="display: none;" onclick="listaServicioY();" data-toggle='tooltip' title="refrescar datos " class="btn   btn-default">
							<span class="glyphicon glyphicon-refresh"></span>
						</button>



						<button id="btnAgregar" data-toggle='tooltip' title="crear nuevo registro de monta" class="btn btn-info">
							<span class="glyphicon glyphicon-plus"></span>
							Nuevo servicio
							<!--	<label class="button-text"> Generar Nuevo Monta</label>-->
						</button>
						<button onclick="window.location.href='../../../socio.php';" data-toggle='tooltip' title="Ir a mis operaciones " class="btn   btn-primary">
							<span class="glyphicon glyphicon-home"></span>
							Ir a mis trámites
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
													<span class="glyphicon glyphicon-refresh"></span> Limpiar filtros
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="panel-body">
								<div class="col-md-2">
									<label>METODO REPRODUCTIVO:</label>
									<select class="form-control input-sm selectpicker show-tick" data-live-search="true" data-size="10" data-width="100%" id="cboMetRep">
									</select>
								</div>
								<div class="col-md-2">
									<label>ID RECEPTORA</label>
									<input class="form-control input-sm" type="text" id="txtidReceptora" />
								</div>
								<div class="col-md-2">
									<label>NOMBRE MADRE</label>
									<input class="form-control input-sm" type="text" id="txtMadre" />
								</div>
								<div class="col-md-2">
									<label>NOMBRE PADRE</label>
									<input class="form-control input-sm" type="text" id="txtPadre" />
								</div>
								<div class="col-md-2">
									<label>AÑO DE MONTA</label>
									<input type="number" class="form-control input-sm" max="2050" maxlength="4" id="txtanio" />
								</div>
								<div class="col-md-2">
									<label>MES DE MONTA.</label>
									<select class="form-control selectpicker show-tick input-sm" data-live-search="true" data-size="10" data-width="100%" id="txtmes">
										<option value="">SELECCIONE</option>
										<option value="1">ENERO</option>
										<option value="2">FEBRERO</option>
										<option value="3">MARZO</option>
										<option value="4">ABRIL</option>
										<option value="5">MAYO</option>
										<option value="6">JUNIO</option>
										<option value="7">JULIO</option>
										<option value="8">AGOSTO</option>
										<option value="9">SETIEMBRE</option>
										<option value="10">OCTUBRE</option>
										<option value="11">NOVIEMBRE</option>
										<option value="12">DICIEMBRE</option>
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
									<th>ID</th>
									<th>Código</th>
									<th>MIS YEGUAS O DE TERCEROS</th>
									<th>POTRO REPRODUCTOR</th>
									<th>METODO REPRODUCTIVO</th>
									<th>TRANSF. EMBRION</th>
									<th>CODIGO RECEPTOR</th>
									<th>FEC. EMBRION</th>
									<th>FEC. MONTA </th>
									<th>FEC. A PARIR </th>
									<th>FEC. REGISTRO </th>
									<th>ESTADO</th>
									<th>OPC.</th>

								</tr>
							</thead>


						</table>





					</div>

				</div>
			</div>

		</div>

	</div>
<?
} else {
	header("Location: " . DIR_LEVEL_MOD_POE);
}
//require("upload/inscripcionPopSeguimiento.php");

//require("upload/inscripcionPopNeoEjemplar.php");
require("upload/printServicioMonta.php");
require("upload/servicioYeguaPopMonta.php");
require("../popupsrchgrl.php");

//require("upload/inscripcionPopImgEjemplar.php");
//require("upload/inscripcionPopPdfEjemplar.php");


?>