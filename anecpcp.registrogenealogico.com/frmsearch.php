	<!-- <table border=3 cellpadding=0 cellspacing=0 width=100%> -->
	<?
 	 $margin_top="style='margin-top:-20px;'";
	 require(DIR_BARRA);?>
<!--	 </tr> 
	 <tr><td colspan=2      class='cssSearch'> 
	 <table  cellpadding=0 cellspacing=0 width=50%> -->
	 <input type=hidden name=opc id=opc > 
	 <input type=hidden name=inicio id=inicio  > 
	 <input type=hidden name=fin id=fin > 
	 <input type=hidden name=id_caballo id=id_caballo  > 
	 <input type=hidden name=alt id=alt  > 
	 <input type=hidden name=valor id=valor  >  
<!--	<tr class=bold  >
    <td    style='width:50%' > 
	--> 
	<div class="container-fluid " >
	<div class="row cssSearch">
		<div class="col-md-2 secFiltro1"  >
						<div id="radioMoneda"  >
						 <div class="divRadio" > 							 <input type="hidden" id="hidIdProp" value="<?php echo $_SESSION["xid"]; ?>">
						   <input type=radio class='radio' name='optiongroup' id='rdbtnEjemplar' value='0' onclick='modi(this.value);' checked >  
					 	   <label for='rdbtnEjemplar'> Ejemplar</label>  
						 </div> 
					 	 <div class="divRadio"> 
						 	<input type=radio  class='radio'  name='optiongroup' id='rdbtnCriador' value='1'onclick='modi(this.value);'>  
							<label for='rdbtnCriador'>Criador</label> 
						 </div> 
					 	 <div class="divRadio"> 
						  <input type=radio  class='radio'  name='optiongroup' id='rdbtnProp' value='2'onclick='modi(this.value);'> 
					   	  <label for='rdbtnProp'>Propietario</label> 
					 	 </div> 
					 	 <div class="divRadio"> 
						  <input type=radio   class='radio'  name='optiongroup' id='rdbtnPelaje' value='3'onclick='modi(this.value);'> 
					      <label for='rdbtnPelaje'>Pelaje del Ejemplar</label> 
					 	 </div> 
						 <div class="divRadio"> 
						  <input type=radio class='radio' name='optiongroup' id='rdbtnEjemplarPad' value='5' onclick='modi(this.value);' >  
					   	  <label for='rdbtnEjemplarPad'> Cr&iacute;as por Padre</label>  
						 </div> 
						 <div class="divRadio">  	 
					   	  <input type=radio class='radio' name='optiongroup' id='rdbtnEjemplarMad' value='6' onclick='modi(this.value);' >  
					 	  <label for='rdbtnEjemplarMad'> Cr&iacute;as por Madre</label>  
						 </div> 
					</div>
 		</div>
		<div class="col-md-3 secFiltro2" style=" float:left;margin-left:20px;">
 	 	<!--<div class="divCtrlSearchd" style='float:left; margin-top:10px; margin-left:30px; '> -->
			<div class="container-fluid">
				 <div class="row" > 
					 <label name='label1' id='label1'  >Nombre del Ejemplar  </label>  
					 <input type=text name=txtdato1 id='txtdato1'      class="form-control   "  > 
				 </div>
				 <div class="row"   > 
					 <label name='label2' id='label2'>Nro de Registro  </label> 
					 <input type=text name=txtdato2   id='txtdato2'    class="form-control  " > 
				 </div> 
				 <div class="row" style="height: 50px;"  > 
					 
					 <button style="margin-top: 10px;"    id='btnBuscar' class="btn btn-success" title='realizar busqueda de ejemplar'><span class="glyphicon glyphicon-search"></span>	Buscar</button> 

				 </div> 
			</div>  
		</div>  
	<!-- </div> -->
	 
		<div class="col-md-4 "  >
	  <div style='float:left; visibility: visible;  '> 
		<p>
		 	<div class="tituloBanner">Registro Geneal&oacute;gico del Caballo de Paso del Ecuador.</div>
		 	<div class="subTituloBanner">Base de datos de caballos de paso de Ecuador</div>			<div style="text-align: center;padding-top: 7px;">			 <button class="eje btn btn-success btn-md">Ver mis ejemplares! <span style="color:#fff;background-color: #343a40;" class="badge badge-dark" id="cantMisEjemplares"></span></button>			 </div>
		</p>
	 </div>
	  </div>
</div>

</div>
<div class="row cssBarraFiltro">

</div>
	
<!-- </td></tr> 
	 <tr><td colspan=1 style='height:40px;'>&nbsp; </td></tr> 
	 <tr><td class='cssBarraFiltro'  > 
	 </td></tr> 
	 </table> 
	 </table> 
	-->
