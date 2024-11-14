<?PHP require("constante.php");
require(DIR_CABECERA);
require(DIR_VALIDAR);

if(ValidarSession())
	{

	?>
 <head>
 	<meta name="viewport" content="initial-scale=1, width=device-width">
 </head>
  <link rel="stylesheet" href="styles/styles.css">
  <link href="styles/menu2.css" rel="stylesheet">
  <!--link href="styles/poeform.css" rel="stylesheet">-->
 

  <link href="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.css" rel="stylesheet">
  <script src="scripts/jquery-ui-1.11.4.custom.green/external/jquery/jquery.js"></script>
  <script src="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.js"></script>

<link href="admin/scripts/alerts/themes/alertify.core.css" rel="stylesheet"/>
<link href="admin/scripts/alerts/themes/alertify.default.css" rel="stylesheet"/>
<script src="admin/scripts/alerts/lib/alertify.min.js"></script>

<script src="scripts/script.js"></script>
<script src="scripts/loading.js"></script>

  <script src="libs/bootstrap-3.3.7/js/bootstrap.js"></script>
  <link href="libs/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet"/>
<script src="scripts/reporteGenPer.js"></script>
<style type="text/css">
.filtroText{  font-size: 14px; font-weight: bold;}
body{  background-image: url('images/logo/7742.jpg');  background-size: 100% 115%;}
.cssLabelArbol{
	font-size: 10px;
}
.cssHeadTbl{
	background:#d3d3d3; font-weight: bold; font-size: 9px; 
}
.modal-dialog{
	 
	/*height: 93%;*/
	 padding: 0;
	width: 90%;
}
.modal-content{
	/*height: 100%;*/
	border-radius: 0;

}
/*
@media screen {
  #printSection {
      display: none;
  }
}
@media print {
  body * {
    visibility:hidden;
  }
  #printSection, #printSection * {
    visibility:visible;
  }
  #printSection {
    position:absolute;
    left:0;
    top:0;
  }
}
*/
@media print{
   body{
   	 visibility: hidden;
   }
   .printMe{
    visibility:visible;
   }

}
</style>
	<tr><td colspan=2 valign=top class="fondoPage"> 
	  
	<table border=0 cellpadding=0 cellspacing=0 width=100% style='border: hidden;'> 
	<? 
	 $margin_top="style='margin-top:-20px;'";
		require(DIR_BARRA); 
	?>
	</tr>
	 <tr><td colspan=1    align=left valign=top   >
	 	<center>
	 		  <img src="images/icono/arbol.png" >&nbsp;&nbsp;<label  class="sub_title_big">SIMULADOR DE PEDIGREE DE EJEMPLARES </label>
	 		  

	 		 <div style="float: right;">
	 		  <button id="btnProcesar" class="btn btn-success glyphicon glyphicon-new-window " >&nbsp;SIMULAR PEDIGREE</button>&nbsp;  &nbsp;  
	 		   
	 		 </div>
<!--	
			 <br><br>
			 Cantidad de ejemplares nacidos e inscritos por criadores por año-->
	 	<table border=0 cellpadding=0 cellspacing=0 width=100% style="border: hidden; " >
		<tr   >
		<td   colspan=1 >  <br><br>
<div class="container-fluid" >
  <div class="row" >
 		<div class="col-md-6">
 			<div class="container-fluid">
				  	<div class="row" >
						 <!-- <div class="col-md-2"><label class="form-control">Codigo</label> </div>
						  <div class="col-md-3"><input  class="form-control"></input> </div>-->
						  <div class="col-md-5">
							<img src="img/iconDetails/madre.png">&nbsp;
						  	<label class="filtroText">Nombre del ejemplar madre</label>

						  </div>
						  <div class="col-md-5"><input  class="form-control" id="txtMadre"></input> </div>
						   <div class="col-md-2"> 
						   	<button id="btnBuscarY" class="btn btn-success glyphicon glyphicon-search" ></button> 
						   	<button id="btnCleanY" class="btn btn-success glyphicon glyphicon-refresh" ></button> 
						   	<br/>	<br/></div>
				 	</div>
				 	<div class="row">
				 	 	<div id="madres" style=" overflow-y:scroll; height: 420px;" >
				 	 		<table class='gridHtmlBG' style='width:100%;border-collapse:collapse;' border=1 > 
								 <thead style='background:#d3d3d3;'> 
								 <tr> 
								 <th></th> 
								 <th>C&oacute;digo</th> 
								 <th>Pref.</th> 
								 <th>Nombre de Ejemplar</th> 
								 <th>Fec. Nac</th> 
							 	</tr>
							 </thead>
							</table>

				 	 	</div>
				 	 	<!--	Total número de registros: <label id='lblTotalH'></label>-->
				 	 		 
				 	</div>
			</div>
		</div>

 <div class="col-md-6">
 	<div class="container-fluid">
				  	<div class="row">
						 <!--  <div class="col-md-2"><label class="form-control">Codigo</label> </div>
						  <div class="col-md-3"><input  class="form-control"></input> </div>-->
						  <div class="col-md-5">
						  	 <img src="img/iconDetails/padre.png">&nbsp;
						  	<label  class="filtroText">Nombre del ejemplar padre</label>
						 </div>
						  <div class="col-md-5"><input  class="form-control" id="txtPadre"></input> </div>
						    <div class="col-md-2"> 
						   <button id="btnBuscarM"  class="btn btn-success glyphicon glyphicon-search" ></button>
						   <button id="btnCleanM" class="btn btn-success glyphicon glyphicon-refresh" ></button>  		<br/><br/></div>
				 	</div>
				 	<div class="row">
				 	 	<div id="padres" style=" overflow-y:scroll; height: 420px;">
				 	 		 <table class='gridHtmlBG' style='width:100%;border-collapse:collapse;' border=1 > 
								 <thead style='background:#d3d3d3;'> 
								 <tr> 
								 <th></th> 
								 <th>C&oacute;digo</th> 
								 <th>Pref.</th> 
								 <th>Nombre de Ejemplar</th> 
								 <th>Fec. Nac</th> 
							 	</tr>
							 </thead>
							</table>
				 	 	</div>
				 	 	<!-- Total número de registros: <label id='lblTotalM'></label>-->
				 	</div>
			</div>
 </div>
  </div>

</div>
 


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
	 
		</td>
		</TR>
		<? 
		require(DIR_LOGIN);	
}
// require DIR_PIEPAGINA;
 ?>
</table>

<?
if(ValidarSession())
	{

?>

<!-- Modal
<div id="printSection"> -->
<div class="modal fade printMe" id="mvPedigree" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel"> <img src="images/icono/arbol2.png" >&nbsp;&nbsp;ANECPCP :: SIMULADOR DE PEDIGREE</h3>
        
        <div style="float: right;">
        <button type="button" id="btnXls" class="btn btn-success glyphicon glyphicon-save-file" title="descargar formato excel"></button>
		<button type="button" id="btnPrint" class="btn btn-success glyphicon glyphicon-print" title="Imprimir"></button>
 		<button type="button" class="btn btn-success  glyphicon glyphicon-remove" data-dismiss="modal" title="cerrar ventana"></button>
 	</div>
      </div>
      <div class="modal-body">
      	<div class="container-fluid">
      		<div class="row">
      			<div class="col-md-9">

<table width="100%" border="1" id="tableResult">
<tr  class="cssHeadTbl"   > <td><center>NUEVO EJEMPLAR</center></td> <td><center>PADRE</center></td><td><center>ABUELOS</center></td><td><center>BISABUELOS</center></td><td><center>TATARABUELO</center></td></tr>

<tr>
	<td rowspan="16"><center><label id='0' class='cssLabelArbol' >NUEVO EJEMPLAR</label></center></td>
	<td rowspan="8"><label id='1' class='cssLabelArbol' ></label></td>
	<td rowspan="4"><label id='3' class='cssLabelArbol' ></label></td>
  	<td rowspan="2"><label id='7' class='cssLabelArbol' ></label></td>
	<td><label id='15' class='cssLabelArbol' ></label></td>
</tr>
<tr>
	<td><label id='16' class='cssLabelArbol' ></label></td>
</tr>
<tr>
  <td  rowspan="2"><label id='8' class='cssLabelArbol' ></label></td>
	<td><label id='17' class='cssLabelArbol' ></label></td>
</tr>
<tr>
	<td><label id='18' class='cssLabelArbol' ></label></td>
</tr>
<tr>
	<td  rowspan="4"><label id='4' class='cssLabelArbol' ></label></td>
	<td  rowspan="2"><label id='9' class='cssLabelArbol' ></label></td>
	<td><label id='19' class='cssLabelArbol' ></label></td>
</tr>
<tr>
	<td><label id='20' class='cssLabelArbol' ></label></td>
</tr>
<tr>
	<td  rowspan="2"><label id='10' class='cssLabelArbol' ></label></td>
	<td><label id='21' class='cssLabelArbol' ></label></td>
</tr>
<tr>
	<td><label id='22' class='cssLabelArbol' ></label></td>
</tr>


<tr>
	<td rowspan="8"><label id='2' class='cssLabelArbol' ></label></td>
	<td rowspan="4"><label id='5' class='cssLabelArbol' ></label></td>
  	<td  rowspan="2"> <label id='11' class='cssLabelArbol' ></label></td>
	<td><label id='23' class='cssLabelArbol' ></label></td>

</tr>
<tr>
	<td><label id='24' class='cssLabelArbol' ></label></td>
</tr>
<tr>
  <td  rowspan="2"><label id='12' class='cssLabelArbol' ></label></td>
	<td><label id='25' class='cssLabelArbol' ></label></td>
</tr>
<tr>
	<td><label id='26' class='cssLabelArbol' ></label></td>
</tr>
<tr>
	<td  rowspan="4"><label id='6' class='cssLabelArbol' ></label></td>
	<td  rowspan="2"><label id='13' class='cssLabelArbol' ></label></td>
	<td><label id='27' class='cssLabelArbol' ></label></td>
</tr>
<tr>
	<td><label id='28' class='cssLabelArbol' ></label></td>
</tr>
<tr>
	<td  rowspan="2"><label id='14' class='cssLabelArbol' ></label></td>
	<td><label id='29' class='cssLabelArbol' ></label></td>
</tr>
<tr>
	<td><label id='30' class='cssLabelArbol' ></label></td>
</tr>
</table>
</div>
      			<div class="col-md-3">

      				<div id="resultResumen" ></div>
      			</div>
      		</div>
      	</div>
 
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="btnXls" class="btn btn-success glyphicon glyphicon-save-file">&nbsp;Descargar</button>
		<button type="button" id="btnPrint" class="btn btn-success glyphicon glyphicon-print">&nbsp;Imprimir</button>

      </div>
  -->
    </div>
  </div>
</div>
<!--</div>-->
<? 
}
?>