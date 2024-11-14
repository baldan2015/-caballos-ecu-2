<?PHP require("constante.php");
require(DIR_CABECERA);
require(DIR_VALIDAR);

if(ValidarSession())
	{

	?>
 
  <link rel="stylesheet" href="styles/styles.css">
  <link href="styles/menu2.css" rel="stylesheet">
  <link href="styles/poeform.css" rel="stylesheet">
 
<link href="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.css" rel="stylesheet">
<script src="scripts/jquery-ui-1.11.4.custom.green/external/jquery/jquery.js"></script>
<script src="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.js"></script>
  <script src="libs/bootstrap-3.3.7/js/bootstrap.js"></script>
  <link href="libs/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet"/>
<link href="admin/scripts/alerts/themes/alertify.core.css" rel="stylesheet"/>
<link href="admin/scripts/alerts/themes/alertify.default.css" rel="stylesheet"/>
<script src="admin/scripts/alerts/lib/alertify.min.js"></script>

<script src="scripts/script.js"></script>
<script src="scripts/loading.js"></script>
<script src="scripts/reporte2.js"></script>

<style type="text/css">
 
#reporteTb tr:nth-child(odd){
    background: #EFEFEF;
    color: #000
}
 
#reporteTb tr:nth-child(even){
    background: #fff;
    color: #000
}
</style>
	<tr><td colspan=2 valign=top > 
	<center> 
	<table border=0 cellpadding=0 cellspacing=0 width=100% style='border: hidden;' > 
	<?  $margin_top="style='margin-top:-13px;'";
		require(DIR_BARRA); 
	?>
	</tr>
	 <tr><td colspan=1    align=left valign=top   >
	 	<center>
	 		<b>
	 		<h3  style="font-weight: bold;">REPORTE DE EJEMPLARES INSCRITOS POR PROPIETARIO.</h3></b>
<!--
			 <br><br>
			 Cantidad de ejemplares inscritos por año-->
	 	<table border=0 cellpadding=0 cellspacing=0 width=100% style='border: hidden;' >
		<tr   >
		<td   colspan=1 > <br> 
			 	
			 Ingrese año de inscripci&oacute;n: &nbsp;&nbsp;
			 &nbsp;Desde :<input type="number" id="txtDesde" value="2000"  max="2050" min="1920">
			 &nbsp;Hasta:	<input type="number" id="txtHasta" value="2018" max="2050" min="1920">
			 &nbsp;propietario: <input type="text" id="txtCriador">
			 &nbsp;<button id="btnBuscar" class="btn btn-success">Buscar</button>
			 &nbsp;<button id="btnLimpiar" class="btn btn-default">Limpiar</button>
			<hr><br> <br> 
			 		 <div id="divResult"></div>
			 		  <br><br> <br><br>
		</td>
		</tr> 
  		</table> 
  	 </center>
 	</td></tr> 
	<tr><td >  
	</td></tr>
	</table>
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
		<td align=center colspan=2   >
		 
		</td>
		</TR>
		<? 
		require(DIR_LOGIN);	
}
 // require DIR_PIEPAGINA;
 ?>
</table>

 