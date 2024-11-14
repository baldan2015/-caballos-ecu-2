<?PHP require("constante.php");
require(DIR_CABECERA);
require(DIR_VALIDAR);

if(ValidarSession())
	{

	?>
 
  <link rel="stylesheet" href="styles/styles.css">
<link href="styles/poeform.css" rel="stylesheet">
 
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="scripts/script.js"></script>
<link href="scripts/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet">
<script src="scripts/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script src="scripts/jquery-ui-1.11.4.custom/jquery-ui.js"></script>

<link href="admin/scripts/alerts/themes/alertify.core.css" rel="stylesheet"/>
<link href="admin/scripts/alerts/themes/alertify.default.css" rel="stylesheet"/>
<script src="admin/scripts/alerts/lib/alertify.min.js"></script>

<script src="scripts/loading.js"></script>
<script src="scripts/reporteCriaPadre.js"></script>

	<tr><td colspan=2 valign=top > 
	<center> 
	<table border=0 cellpadding=0 cellspacing=0 width=100%> 
	<? 
		require(DIR_BARRA); 
	?>
	</tr>
	 <tr><td colspan=1    align=left valign=top   >
	 	<center>
	 		<b>
	 		<span style="font-size: 18px;">REPORTE DE CRIAS DE EJEMPLARES PADRES.</span></b>

			 <br><br>
			 Cantidad de crias nacidas por año.
	 	<table border=1 cellpadding=0 cellspacing=0 width=100%>
		<tr   >
		<td   colspan=1 > <br><br><br>
			 	
			 Ingrese año de inscripci&oacute;n: &nbsp;&nbsp;
			 &nbsp;Desde :<input type="number" id="txtDesde" value="2000"  max="2050" min="1920">
			 &nbsp;Hasta:	<input type="number" id="txtHasta" value="2018" max="2050" min="1920">
			 &nbsp;Ejemplar: <input type="text" id="txtCriador">
			 &nbsp;<button id="btnBuscar">Buscar</button>
			 &nbsp;<button id="btnLimpiar">Limpiar</button>
			 <br><br>
			 		 <div id="divResult"></div>
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
		<td align=center colspan=2   height=50>
		<img src="img/logo.jpg"  border=0><hr>
		</td>
		</TR>
		<? 
		require(DIR_LOGIN);	
}
 require DIR_PIEPAGINA;
 ?>
</table>

 