<?PHP require("../../../constante.php");
require("../header.php");
require(DIR_LEVEL_MOD_POE.DIR_VALIDAR);
if(ValidarSession())
	{
  require("../libs.php");
   $activo1="active";
?>
<script src="../script/form1.js"></script>
<script src="../script/busquedaEjemplar.js"></script>

	<table border=0 cellpadding=0 cellspacing=0 width=100%> 
	<? 
		require("../barra.php"); 
	    require("../validarPoe.php");
	?>
	</tr>
	</table>

	 	<div class="container-fluid">
	 		<div class="row">
	 			<div class="col-md-12">
	 				 <? require("../headerPoe.php");?>
	 			</div>
	 		</div>
	 		<div class="row">
	 			<div class="col-md-8">
	 				<tituloForm> 
					Formulario N&deg; 1: Confirmación de Ejemplares de mi propiedad durante el Año 
					<span class="badge badge-pill badge-danger"id='lblTituloPoe'><?=$periodo?></span>
								</tituloForm>
	 			</div>
	 			<div  class="col-md-4 text-right">
	 							<button id="btnPrint" class="btn btn-sm btn-default" title="Imprimir">
	 						 <span class="glyphicon glyphicon-print"></span>	Imprimir mi declaración
	 						</button>
				 				<button id="btnAgregar" class="btn btn-default"title="Agregar un nuevo ajemplar"  style='display:none;'>Agregar</button>
				 				<button id="btnCancelar" class="btn"title="Cancelar operación" style='display:none;'>Cancelar</button>
								<button id="btnGrabar" class="btn"title="Registrar ejemplar" style='display:none;'>Grabar</button>
								<button id="btnBusEjeUPD" class="btn btn-success btn-sm" style='display:none;' title="Buscar ejemplar recien regularizado">
								<span class="glyphicon glyphicon-search"></span>
								Buscar Ejemplar No encontrado en Lista 1</button>
								<!--<button id="btnFin" title="Finalizar formulario">Finalizar</button>-->
								
								<input type="hidden" id="hidIdProp" value="<?=$_SESSION['xid']?>"/>
								<input type="hidden" id="hidIdPoe" value="<?=$_SESSION[VAR_PERIODO_SESION]?>"/>
	 			</div>
	 		</div>
	 		<div class="row">
	 			<div class="col-md-6">
	 				<div class="panel panel-success   ">
    <div class="panel-heading">

    	LISTA DE EJEMPLARES INSCRITOS EN  LA ANECPCP : <span class="badge badge-pill " id="lblMP">0</span>
    	
    </div>
    <div class="panel-body">

    	<div id='divResult' class="table-responsive" style='height: 400px;	 		overflow-y: scroll;'></div>
	 			</div></div>
    
  </div>
 

	 			<div class="col-md-6">
	 				<div class="panel panel-success   ">
    <div class="panel-heading">
    	LISTA DE EJEMPLARES DECLARADO BAJO MI PROPIEDAD PARA EL PERIODO <?=$periodo?> : 
    	<span class="badge badge-pill " id="lblMPC">0</span>			
    </div>

    <div class="panel-body"><div id='divResultSel' class="table-responsive" style='height: 400px; 	 	 	overflow-y: scroll;'></div>
	 			</div></div>
		 
	 			</div>
	 		</div>
	 	</div>

<?	
}else{
	 header("Location: ".DIR_LEVEL_MOD_POE);
}
?>
