<?PHP require("constante.php");
require(DIR_CABECERA);
require(DIR_VALIDAR);
require("Clases/conexion.php");
require("Clases/resultado.php");
require("Funciones/general.php");


if (ValidarSession()) {

?>
	<link rel="stylesheet" href="styles/styles.css">
	<link href="styles/menu2.css" rel="stylesheet">

	<!--<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>-->

	<link href="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.css" rel="stylesheet">
	<script src="scripts/jquery-ui-1.11.4.custom.green/external/jquery/jquery.js"></script>
	<script src="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.js"></script>

	<script src="libs/bootstrap-3.3.7/js/bootstrap.js"></script>
	<link href="libs/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" />
	<meta charset="UTF-8">
	<!--
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.23/b-1.6.5/b-flash-1.6.5/b-print-1.6.5/r-2.2.7/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.23/b-1.6.5/b-flash-1.6.5/b-print-1.6.5/r-2.2.7/datatables.min.js" defer></script>
-->
	<link href="admin/scripts/alerts/themes/alertify.core.css" rel="stylesheet" />
	<link href="admin/scripts/alerts/themes/alertify.default.css" rel="stylesheet" />
	<script src="admin/scripts/alerts/lib/alertify.min.js"></script>


	<link rel="stylesheet" type="text/css" href="modules/poe/libs/datatables-1.10.23/datatables.min.css" />
	<script type="text/javascript" src="modules/poe/libs/datatables-1.10.23/datatables.min.js"></script>

	<script src="scripts/profile.js"></script>
	<style type="text/css">
		body {
			background: #fff;
			/* #f5f3e5;*/
		}#gridConcurso tbody tr td{			text-transform:uppercase;		}

		.tableFooter {
			font-size: 18px !important;
		}

		.ColOrden {
			background: #E36464;
			height: 100%;
			width: 100%;

		}

		.opacity {
			background-color: #fff;
			opacity: 0.7;
			/* Opacidad 60%  #459e00*/
			-webkit-transition: opacity 0.3s;
			transition: opacity 0.3s;
		}

		.opacity:hover {
			opacity: 1;
			/* Opacidad 60% */
		}

		.mainMessage {
			position: absolute;
			color: #FFF;
			margin-top: -100px;

			width: 50%;
			height: 70px;
			float: left;
		}

		.title_big {
			font-size: 20px;
			line-height: 56px;
			letter-spacing: -1;
			margin-bottom: 20px;
		}

		.sub_title_big {
			position: relative;
			font-size: 18px;
			line-height: 28px;
			margin: 0 0 30px;
			text-shadow: 1px 1px rgba(255, 255, 255, 0.25);
			font-family: 'Open Sans', sans-serif;
			font-weight: bold;
			color: #000;
		}

		th {
			font-size: 11px;
			text-transform: uppercase;
			background: #dff0d8;
			/*#f2dede;*/
			color: #3c763d;
			/* #a94442;*/
		}


		.badge-danger-tit {
			color: #fff;
			background-color: #dc3545;
			font-size: 15px;
		}

		.badge-danger {
			color: #fff;
			background-color: #dc3545;
		}

		.badge-warning {
			color: #fff;
			background-color: #f0ad4e;
		}

		.badge-success {
			color: #fff;
			background-color: #28a745;
		}

		.badge-primary {
			color: #fff;
			background-color: #007bff;
		}

		.badge-secondary {
			color: #fff;
			background-color: #6c757d;
		}

		.panel-success>.panel-heading {
			color: #3c763d;
			background-color: #dff0d8;
			border-color: #d6e9c6;
		}

		.panel-heading {
			font-weight: bold;
			font-size: 12px;
		}

		.panel-heading {
			padding: 10px 15px;
			border-bottom: 1px solid transparent;
			border-top-left-radius: 3px;
			border-top-right-radius: 3px;
		}

		html,
		body {
			max-width: 100%;
			overflow-x: hidden;
		}

		.tituloTop {
			margin-left: -20px;
		}

		@media only screen and (max-width: 600px) {
			.tituloTop {
				margin-left: 0px;
			}

		}

		@media only screen and (min-width: 768px) {
			.tituloTop {
				margin-left: 0px;
			}

		}
	</style>
	<tr>
		<td colspan=2 valign=top style="margin-left:10px;">
			<table border=0 cellpadding=0 cellspacing=0 width=100% style='border: hidden;'>
				<? $margin_top = "style='margin-top:-20px;'";
				require(DIR_BARRA);

				$dato = obtenerIdPropietario($_SESSION["xid"]);

				?>
	</tr>

	<div class="container-fluid   ">

		<div class="row">
			<div class="col-md-1">
				<img src="home/img/mis.jpg" class="image_redonda" />
			</div>
			<div class="col-md-8 tituloTop">
				<h3 class="tituloResp">RELACI&Oacute;N DE EJEMPLARES BAJO MI PROPIEDAD <span id="cantidadMisEjemplares" class="badge badge-success noti-icon-badge" style="margin-bottom: 5px;font-size: 20px;"></span> </h3>
			</div>
			<div class="col-md-3" style="margin-top: 15px;  ">
				<div style="float:right ;">
					<input type="hidden" id="hidIdProp" value="<?= $_SESSION['xid'] ?>" />
					<div class="btn-group" role="group" aria-label="...">
						<button title="Descargar mis ejemplares en formato Excel." class="btn  btn-info " id="btnXlsMisEjemplar">
							<span class="glyphicon glyphicon-download-alt"></span>&nbsp;Exportar datos
						</button>
						<button style="display: none;" onclick="listarMiPropiedad(2,'asc');" data-toggle='tooltip' title="refrescar datos " class="btn   btn-info">
							<span class="glyphicon glyphicon-refresh"></span>
						</button>
						&nbsp;&nbsp;
						<button onclick="window.location.href='socio.php';" data-toggle='tooltip' title="Ir a mis operaciones " class="btn   btn-primary">
							<span class="glyphicon glyphicon-home"></span> Ir a mis trámites
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
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
							<label>PREF. - NOMBRE:</label>
							<input type="text" class="form-control input-sm" id="filtroNombre" />
						</div>
						<div class="col-md-2">
							<label>GENERO:</label>
							<select class="form-control input-sm selectpicker show-tick " data-live-search="true" data-size="10" data-width="100%" id="cboGenero">
								<option value="">SELECCIONE</option>
								<option value="Y">YEGUA</option>
								<option value="P">POTRO</option>
							</select>
						</div>
						<div class="col-md-2">
							<label>PELAJE</label>
							<select class="form-control input-sm selectpicker show-tick " data-live-search="true" data-size="10" data-width="100%" id="cboPelaje"></select>
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
							<label>ADN</label>
							<select class="form-control input-sm selectpicker show-tick " data-live-search="true" data-size="10" data-width="100%" id="cboEstado">
								<option value="">Selecione</option>
								<option value="SI">SI</option>
								<option value="No">NO</option>
							</select>
						</div>
					</div>
				</div>

			</div>

		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel-bodyd" style="margin-top:10px !important;  margin-left:10px!important;">
					<table id="grid" class="table  row-border table-hover" style="margin-left:10px!important; width: 99%;">
						<thead>
							<tr>
								<th>Código</th>
								<th>Pref. - Nombre </th>
								<th>Pelaje</th>
								<th>Fec. Nac. </th>
								<th>V/M</th>
								<th>Criador </th>
								<th>Cod. Padre</th>
								<th>Padre</th>
								<th>Cod. Madre</th>
								<th>Madre</th>
								<th>M/H</th>
								<th>ADN</th>
								<th style="width: 100px;">...</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<!--</div>-->
		</div>
	</div>


<?
} else {
	if (isset($_SESSION['xstatus'])) {
		if ($_SESSION['xstatus'] == 0) {
			$message = "Su Cuenta esta Desactivada !&nbsp;&nbsp;<img src='img/s_status.png'> ";
		} else {
			if ($_SESSION['xstatus'] == -1)
				$message = "Error ! Usuario no existe !&nbsp;&nbsp;<img src='img/b_usrdrop.png'> ";
		}
	}
?>
	<tr ROWSPAN=0>
		<td align=center colspan=2>

		</td>
	</TR>
<?
	require(DIR_LOGIN);
}
//require DIR_PIEPAGINA;
//require("popupFalleceEjemplar.php");
//require("popupCastradoEjemplar.php");
//require("popupTransferidoEjemplar.php");

?>


<!--
 <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="libs/bootstrap-3.3.7/js/bootstrap.js"></script>
 <link href="libs/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet"/>
-->

<!-- <div id="divVerCrias">
 <div id="crias" >
</div>
</div>
		<div id="divVerImagen" >

			

		
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

		
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Modal Header</h4>
		      </div>
		      <div class="modal-body">
		        <div id="galeria" >
				</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>

		  </div>
		</div>
	
</div>
<div id="divVerArbol" >
	<div id="resultadoArbol" >
	</div>
</div>
<div id="divVerConcurso" >
	<div id="resultado" >
	</div>
</div>-->




</table>



<style type="text/css">
	.panel-transparent {
		background: none;
	}

	.bg-form {
		margin-top: -23px !important;

	}

	.image_redonda {


		width: 80px;
		height: 80px;
		border-radius: 80px;
		filter: drop-shadow(0 0 7px black);

	}

	.ui-state-hover {
		color: #000 !important;
		background: #fcf0ba !important;

	}

	h3 {
		color: #3c763d;
		text-transform: uppercase;
		font-family: Franklin Gothic Medium;
	}
</style>


<?
require("popup/popupVerImagen.php");
require("popup/popupVerCrias.php");
require("popup/popupVerArbolGenealogico.php");
require("popup/popupVerConcurso.php");
?>