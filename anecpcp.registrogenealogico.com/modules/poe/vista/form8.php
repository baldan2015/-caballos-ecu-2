<?PHP  require("../../../constante.php");
require("../header.php");
require(DIR_LEVEL_MOD_POE.DIR_VALIDAR);
if(ValidarSession())
	{
  require("../libs.php");
  $activo8="active";
?>
<script src="../script/form8.js"></script>

 	<table border=1 cellpadding=0 cellspacing=0 width=100%> 
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
									Formulario: Registro de  Castración de mis Ejemplares durante el Año <span class="badge badge-pill badge-danger"id='lblTituloPoe'><?=$periodo?></span>
								</tituloForm>		
	 			</div>
	 			<div  class="col-md-4 text-right">
	 							 <div class="btn-group" role="group" aria-label="...">
				 			<button id="btnPrint" title="Imprimir" class="btn btn-sm btn-default" >
				 			<span class="glyphicon glyphicon-print"></span>	
				 			Imprimir</button>
				 				<button id="btnCancelar" class="btn btn-sm btn-default"  title="Cancelar operación">
				 					<span class="glyphicon glyphicon-refresh"></span>	 Cancelar</button>
								<button id="btnGrabar" class="btn btn-sm btn-success"  title="Registrar lista de adquisición o transferencia">
								<span class="glyphicon glyphicon-floppy-saved"></span>	
								Grabar</button>				 				
								
							 </div>

								<input type="hidden" id="hidIdProp" value="<?=$_SESSION['xid']?>"/>
								<input type="hidden" id="hidIdPoe" value="<?=$_SESSION[VAR_PERIODO_SESION]?>"/>
	 			</div>
	 		</div>
	 		<div class="row">
	 			<div class="col-md-6">
	 				<div class="panel panel-success   ">
    <!--<div class="panel-heading">LISTA DE EJEMPLARES PARA SELECCIONAR</div>-->
    <div class="panel-body"><div id='divResult' class="table-responsive" style='height: 400px;	 		overflow-y: scroll;'>
    </div>
    <!--<div class="panel-footer"></div> -->
	 			</div></div>
    
  </div>
 

	 			<div class="col-md-6">
	 				<div class="panel panel-success   ">
      <!--<div class="panel-heading">LISTA DE EJEMPLARES DE MI PROPIEDAD PARA EL PERIODO <?=$periodo?></div>-->
    <div class="panel-body"><div id='divResultCastrado' class="table-responsive" style='height: 400px; 	 	 	overflow-y: scroll;'></div>
	 			</div>
	 	<!--	<div class="panel-footer"></div> -->
		 
	 			</div>
	 		</div>
	 	</div>
	 </div>

<?	
}else{
	 header("Location: ".DIR_LEVEL_MOD_POE);
}
?>