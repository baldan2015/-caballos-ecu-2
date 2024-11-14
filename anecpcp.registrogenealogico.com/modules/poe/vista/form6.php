<?PHP require("../../../constante.php");
require("../header.php");
require(DIR_LEVEL_MOD_POE.DIR_VALIDAR);
if(ValidarSession())
	 {
 
  require("../libs.php");
?>


<script src="../script/form6.js"></script>
<script src="../script/busquedaEjemplar.js"></script>
<script src="../script/loading.js"></script>
	<tr><td colspan=2 valign=top > 
	
	<center>
	<table border=1 cellpadding=0 cellspacing=0 width=100%> 
	<? 
	    require("../barra.php"); 
	    require("../validarPoe.php");
	?>
	</tr>
	 <tr><td colspan=1    align=left valign=top   >
	 	<table border=0 cellpadding=0 cellspacing=0 width=100%>
		<tr   >
		<td   colspan=1 >
			<center> 
				<table border=0 cellpadding=0 cellspacing=0 width=100%>
					<? require("../headerPoe.php");?>
					 <tr><td style='background:#d3d3d3;' >
							<div style='margin-top:10px; margin-left:20px; float:left;height:30px;' >
								<tituloForm>
									Formulario  : Cesi&oacute;n de Vientres y Prestamos de Potros durante el Año <span class="badge badge-pill badge-danger"id='lblTituloPoe'><?=$periodo?></span>
								</tituloForm>	
				 			</div>
				 			<div style=' margin-top:5px; float:right;height:30px;' >
				 			<!--	<button id="btnVer" title="ver lista de registros del formulario 5">Ver Formulario</button>-->
				 				<button id="btnPrint" title="Imprimir">Imprimir</button>
				 				<button id="btnAgregar" title="Agregar nueva adquisición o transferencia">Agregar</button>
				 				<button id="btnCancelar" title="Cancelar operación">Cancelar</button>
								<button id="btnGrabar" title="Registrar lista de adquisición o transferencia">Grabar</button>				 				
							<!--	<button id="btnFin" title="Finalizar formulario">Finalizar</button>-->

								<input type="hidden" id="hidIdProp" value="<?=$_SESSION['xid']?>"/>
								<input type="hidden" id="hidIdPoe" value="<?=$_SESSION[VAR_PERIODO_SESION]?>"/>
							</div>
					</td></tr>
				</table>
			</center>
		</td>
		</tr> 
  		</table> 
 	</td></tr> 
	<tr><td > <center> 
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
			 <tr><td >
			<div id='divResult'></div>
			</td></tr>
			</table>
		</center>
	</td></tr>
	</table>
</center>
	</td></tr>
<?	
}else{
	  	if(isset($_SESSION['xstatus']))
		{
			if($_SESSION['xstatus']==0)
			{
			$message="Su Cuenta esta Desactivada !&nbsp;&nbsp;<img src='img/s_status.png'> ";
			}
			else
			{
				if($_SESSION['xstatus']==-1)
					$message="Error ! Usuario no existe !&nbsp;&nbsp;<img src='img/b_usrdrop.png'> ";
			}
		}
		?>
		<tr ROWSPAN=0>
		<td align=center colspan=2   height=50>
		<img src="img/logo.jpg"  border=0><hr>
		</td>
		</TR>
		<? 
		require(DIR_LEVEL_MOD_POE.DIR_LOGIN);	
}
 require DIR_LEVEL_MOD_POE.DIR_PIEPAGINA;
 ?>
</table>


<div id='divBuscarEjemplar'>
	<input type="hidden" id="hidCtrolId" />
	<input type="hidden" id="hidCtrolName" />
	<input type="hidden" id="hidTipoParents" />
<label>Ingrese nombre Ejemplar:</label>
<input type="text" id="txtBGNombre" />
<button id="btnBGBuscar">Buscar</button>&nbsp;&nbsp;<span style="font-size: xx-small;">(*)Dejar vacio el nombre del ejemplar para listar ejemplares de su propiedad</span>
<hr>
<div id='divResultBG'> </div>
	
	
</div>