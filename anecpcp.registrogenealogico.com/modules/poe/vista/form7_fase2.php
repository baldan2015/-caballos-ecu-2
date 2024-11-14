<? require("../../../constante.php");
require(DIR_LEVEL_MOD_POE.DIR_VALIDAR);
//require("../header.php");
//if(ValidarSession())
	// {
   require("../libs2.php");
   //require("modules/poe/libs.php");
   $activo7="active";
   
?>

<style type="text/css">
	
.gridHtmlFallecido > tbody > tr > td {
			font-size: 10px!important;
}
.gridHtml   > tbody > tr > td {
			font-size: 10px!important;
}

</style>
<script src="modules/poe/script/form7_fase2.js"></script>

	 
	<table border=1 cellpadding=0 cellspacing=0 width=100%> 
	<? 
		/*require("../barra.php"); 
	   require("../validarPoe.php");*/
	?>
	</tr>
	</table>
<div class="container-fluid" >
	 		 
	 		<div class="row">
	 			<div class="col-md-7"> 
	 				 
	 			</div>
	 			<div  class="col-md-5 text-right">
	 							 <div class="btn-group" role="group" aria-label="...">
				 			<button id="btnPrint" title="Imprimir" class="btn btn-sm btn-default" >
				 			<span class="glyphicon glyphicon-print"></span>	
				 			 </button>
				 				<button id="btnCancelar" class="btn btn-sm btn-default"  title="Cancelar operación">
				 					<span class="glyphicon glyphicon-refresh"></span>	 Cancelar</button>
								<button id="btnGrabar" class="btn btn-sm btn-primary"  title="Registrar lista de adquisición o transferencia" onclick="insert()">
								<span class="glyphicon glyphicon-floppy-saved"></span>	
								Grabar</button>				 				
								
							 </div>

								<input type="hidden" id="hidIdProp" value="<?=$_SESSION['xid']?>"/>
								<!--<input type="hidden" id="hidIdPoe" value="<?/*=$_SESSION[VAR_PERIODO_SESION]*/?>"/>
								<input type="hidden" id="hidIdProp" value="8218"/>-->
								<input type="hidden" id="hidIdPoe" value="1"/>
	 			</div>
	 		</div>

	 		<div class="row" style="margin-top: 10px;">
	 			<div class="col-md-6">
	 				<div class="panel panel-success   ">
    <!--<div class="panel-heading">LISTA DE EJEMPLARES PARA SELECCIONAR</div>-->
    <div class="panel-body"><div id='divResultEjemplares' class="table-responsive" style='height: 400px;	 		overflow-y: scroll;'>
    </div>
    <!--<div class="panel-footer"></div> -->
	 			</div></div>
    
  </div>
 

	 			<div class="col-md-6">
	 				<div class="panel panel-success   ">
      <!--<div class="panel-heading">LISTA DE EJEMPLARES DE MI PROPIEDAD PARA EL PERIODO <?=$periodo?></div>-->
    <div class="panel-body"><div id='divResultFallecido' class="table-responsive" style='height: 400px; 	 	 	overflow-y: scroll;'></div>
	 			</div>
	 	<!--	<div class="panel-footer"></div> -->
		 
	 			</div>
	 		</div>
	 	</div>
	 </div>

<?	
//}else{
	// header("Location: ".DIR_LEVEL_MOD_POE);
//}
?> 