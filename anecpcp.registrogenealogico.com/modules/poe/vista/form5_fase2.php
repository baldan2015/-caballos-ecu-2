<?PHP require("../../../constante.php");
require(DIR_LEVEL_MOD_POE.DIR_VALIDAR);
//require("../header.php");
//if(ValidarSession())
	// {
   require("../libs2.php");
   $activo7="active";
?>
    
      
<script src="modules/poe/script/form5_fase2.js"></script>

	<table border=1 cellpadding=0 cellspacing=0 width=100%> 
	<? 
	    //require("../validarPoe.php");
	?>
	</tr>
	</table>
<div class="container-fluid">
	 		<div class="row">
	 			<div class="col-md-7"> 
	 			 <tituloForm><!-- y adquisición-->
									Formulario: Registro transferencias <span class="badge badge-pill badge-danger"id='lblTituloPoe'></span>
								</tituloForm>	
	 			</div>
	 			<div  class="col-md-5 text-right">
	 				<div class="btn-group" role="group" aria-label="...">
					<button id="btnPrint" class="btn btn-sm btn-default" title="Imprimir"><span class="glyphicon glyphicon-print"></span>&nbsp; Imprimir</button>
					 
					<button id="btnCancelar" class="btn btn-sm btn-default"  title="Cancelar operación"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Cancelar</button>
					<button id="btnGrabar" class="btn btn-sm btn-success"  title="Registrar lista nacimientos"><span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Grabar</button>
</div>
								<input type="hidden" id="hidIdProp" value="<?=$_SESSION['xid']?>"/>
								<!--<input type="hidden" id="hidIdPoe" value="<?//=$_SESSION[VAR_PERIODO_SESION]?>"/>	-->
								<input type="hidden" id="hidIdPoe" value="1"/>	 
	 			</div>
	 		</div>
	 	 
<div class="row">
	 			<div class="col-md-12" style="margin-top: 10px;">
	 				<div class="panel panel-success   ">
    <div class="panel-heading">LISTA DE TRANSFERENCIAS    (S&oacute;lo se va a registar la informaci&oacute;n de transferidos si ha completado datos como: fecha y nombre del nuevo propietario) </div>
    <div class="panel-body">
    	<div id='divResultTras' class="table-responsive" style="overflow-x: auto;height:470px;" ></div>	</div>
     
</div>
    
  </div>
</div>
</div>
