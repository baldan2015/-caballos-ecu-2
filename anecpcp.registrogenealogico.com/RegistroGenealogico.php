<?
require(DIR_FUNCTION."conectar.php");
require(DIR_FUNCTION."queries.php");
require(DIR_FUNCTION."general.php");


$dato1=trim($HTTP_GET_VARS['txtdato1']);
$dato2=trim($HTTP_GET_VARS['txtdato2']);

$opc=$HTTP_GET_VARS['opc'];
if(isset($HTTP_GET_VARS['inicio'])){
	$ini=$HTTP_GET_VARS['inicio'];
}else{
	$ini=1;
}
if(isset($HTTP_GET_VARS['fin'])){
			$fin=$HTTP_GET_VARS['fin'];
}else{
			$fin=10;
}	
if(isset($HTTP_GET_VARS['valor'])){
	$alternativa=$HTTP_GET_VARS['valor'];
}else{
	$alternativa=0;
}	

$data=$HTTP_GET_VARS['alt'];
$idhorse=$HTTP_GET_VARS['id_caballo'];
switch($opc)
{
case 3:
case 4:	
case 0: $des_dato1='Nombre del Ejemplar';
        $des_dato2='N&deg; de Registro';
	$colspan=" colspan=8 ";
	break;	
case 1: $des_dato1='Nombre del Criador';
        $des_dato2='ID del Criador';
	$colspan=" colspan=7";
	break;	

case 2: $des_dato1='Nombre del Propietario';
        $des_dato2='ID del Propietario';
	$colspan=" colspan=6";
	break;	
}
if(ValidarSession())
	{

	require("frmsearch.php");

	
	if(!(empty($dato1)) || !(empty($dato2)))
		{
			$reg=buscar($dato1,$dato2,$link,$opc);
			//echo"<pre>";print_r($reg);echo"</pre>";
			$regMuertos=$reg['muertos'];
			$reg=$reg['vivos'];
			
			$numVivo=sizeof($reg);
			$numMuerto=sizeof($regMuertos);
			

		echo"<br/><center>";
		echo"<table width=97%    cellpadding=0 cellspacing=0 border=0 class='text2' style=' border-collapse:collapse;'>"; //style='background-image:url(img/fondoarbol.jpg); 
		 if(sizeof($reg)>=0 || sizeof($regMuertos)>=0)
		   {
			$numrows=10;
			
			switch($opc)
		 	{
		 	case 5:					#padres
		 	case 3:					#pelaje
		 	case 4:					#microchip
			case 0:					#ejemplar
				//listarCaballos($reg,$ini,$fin,$idhorse,$numVivo,$colspan,'Ejemplares vivos',$numrows,'1');
				///listarCaballos($regMuertos,$ini,$fin,$idhorse,$numMuerto,$colspan,'Ejemplares fallecido',$numrows,'2');
		break;
			 case 1:				#criadror
		     case 2:				#propietario
		     	echo"<tr height=30 align=left><td  ".$colspan." >
			<table border=0 width=100%><tr><td>
            <label name='ancla' style='font-size:15px;color:gray;font-weight:bold;'>
			Resultados de B&uacute;squeda </label>
			</td><td height=30 colspan=1 align=right style='color:gray;font-size:11px;'>
			N&deg; de Registros encontrados ".$num."</td></tr></table></td></tr>";	
				 $id_propie=$idhorse;
				 $rol=" Criador ";
				if( $opc=="2" )	$rol=" Propietario ";
           	 	echo"<tr height=30 class='ui-dialog-titlebar ui-widget-header'><td >N&deg;</td><td colspan=2 >c&oacute;digo del ".$rol."</td><td colspan=3 align=center>Nombre y Apellido ".$rol."</td></tr>";
			for($c=$ini-1;$c<$fin;$c++)
				{
					if(!(empty($reg[$c][id])))
				 	{
				 			
					if($id_propie==$reg[$c][id]){
					 echo"<tr  class='ui-dialog-titlebar ui-widget-header'>";
					 $cssRow="  ui-dialog-titlebar ui-widget-header	";	
					}else{      		           
						echo"<tr class='gridHtmlRow cursor' >";					
						$cssRow="  normaltd	";	
					} 
					//$SRC="<a href='indice.php?id_caballo=".$reg[$c][id]."&txtdato1=".$dato1."&txtdato2=".$dato2."&opc=".$opc."&inicio=".$ini."&fin=".$fin."&valor=0#".$reg[$c][id]."' name=".$reg[$c][id]." title='Click para ver ejemplares que tiene propietario!'>".$reg[$c][nombre]."</a>";
					$urlA="indice.php?id_caballo=".str_replace($reg[$c][id],".","")."&txtdato1=".$dato1."&txtdato2=".$dato2."&opc=".$opc."&inicio=".$ini."&fin=".$fin."&valor=0#".$reg[$c][id];
					echo"<td class=' ".$cssRow." cursor' title='ver lista de ejemplares' onclick=detailSearch('".$urlA."')><a href=# name=".$reg[$c][id]." >".str_replace($reg[$c][id],".","")."</a>".$reg[$c][n]."</td>";
					echo"<td class=' ".$cssRow." cursor' title='ver lista de ejemplares'  colspan=2 onclick=detailSearch('".$urlA."') >".$reg[$c][id]."</td>";
					echo"<td class=' ".$cssRow." cursor' title='ver lista de ejemplares'  colspan=3 onclick=detailSearch('".$urlA."')>";
					//echo $SRC;			
					echo $reg[$c][nombre];
					echo"</td>";
					echo"</tr>";

					if(!(empty($reg[$c][id])))
					{
					   if($id_propie==$reg[$c][id])
						{		
						    $htmlSubCab=htmlItemsProp($id_propie,$reg[$c][nombre],$data,$link,$alternativa,$opc,$ini,$fin,$dato1,$dato2);
						    echo $htmlSubCab;
					    }
					}
					}
				}//fin de for

			break;

		}//end switch
		   }
		   else
		   {
			echo"<th height=30 align=left  colspan=5><a href=#ancla name=ancla style='font-size:15px;color:gray;'>Resultados de B&uacute;squeda </a> </th><th height=30 colspan=1 style='color:gray;font-size:10px;'>N&deg; de Registros encontrados ".$num."</th>";	
			echo"<tr height=30 bgcolor=lightgrey class=bold><td>N&deg;</td><td>c&oacute;digo</td><td>Prefijo</td><td>Nombre Caballo</td>";
			//echo"<td>Fecha de Nac.</td><td>Padre</td><td>Madre del Caballo</td><td>Criador</td>";
			echo"<td>Criador</td><td>Propietario</td></tr>";

			echo"<tr>";
			echo"<td colspan=6 height=100 align=center style='color:red;font-size:10px;'><img src='img/s_warn.png'>&nbsp; La B&uacute;squeda no produjo ning&uacute;n resultado !</td>";
			echo"</tr>";
			$dat=-1;
		   }	
			//echo"<tr><td bgcolor=lightgrey colspan=6>&nbsp</td></tr>";


			echo"</table></center>";
			//if($dat!=-1)
			//{xpaginador($reg,$ini,$fin,$numrows);}


		}

	}
else
	{
	require(DIR_LOGIN);	
	echo("<tr><td height=150 valign=top align=center style='color:red'>No ha iniciado  sesion ! <br>");
     	echo("</td></tr>");		


	}


function listarCaballos($reg,$ini,$fin,$idhorse,$num,$colspan,$titulo,$numrows,$origen){
			echo"<tr height=30 align=left><td  ".$colspan." >
					<table border=0 width=100%><tr><td>
            		<label name='ancla' style='font-size:15px;color:gray;font-weight:bold;'>
					".$titulo."  </label>
					</td><td height=30 colspan=1 align=right style='color:gray;font-size:11px;'>
					N&deg; de Registros encontrados ".$num."</td></tr></table></td></tr>";	
		   echo"<tr height=30   class='ui-dialog-titlebar ui-widget-header'><td>N&deg;</td>
				<td align=center>&nbsp;&nbsp;&nbsp;&nbsp;C&oacute;digo&nbsp;&nbsp;&nbsp;</td>
				<td align=center>Prefijo</td>
				<td align=center>Nombre </td>
				<td align=center>".TXTHEADERESTADO."</td>
				<td align=center width=10%>Fec Nac</td>";
				echo"<td align=center>Criador</td><td align=center> Propietario</td></tr>";
				for($c=$ini-1;$c<$fin;$c++)
				{
				if(!(empty($reg[$c][codigo])))
				 {
						$cssRow=" class=normaltd	";
						$htmldeta=""				 	;
						$url="indice.php?id_caballo=".$reg[$c][codigo]."&txtdato1=".$dato1."&txtdato2=".$dato2."&opc=".$opc."&inicio=".$ini."&fin=".$fin."&valor=".$alternativa."&alt=".$data."#".$reg[$c][codigo];
						echo"<tr valign=top class='gridHtmlRow cursor' onclick=detailSearch('".$url."') name=".$reg[$c][codigo].">";

						
						   if($idhorse==$reg[$c][codigo])
						   {		
							   $cssRow=" class=anormaltd	";				 	
						       $detah=detalleCaballo($idhorse,$link);			
							   $htmldeta=htmlDetalleEjemplar($detah);
							}
						   echo"<td ".$cssRow.">".$reg[$c][n]."</td>";
						   echo"<td ".$cssRow."><a href=".$url."  name=".$reg[$c][codigo]."></a>";
					  	   echo $reg[$c][codigo];
						   echo"</td>";	
		   	  			   echo"<td ".$cssRow.">&nbsp;&nbsp;".$reg[$c][prefijo_caballo]."&nbsp;&nbsp;</td>";			
						   echo"<td ".$cssRow.">";
					  	   echo "".$reg[$c][nombre_caballo]."</td>";
						   echo"<td align=center ".$cssRow.">".$reg[$c][fallecio]."</td>";
								if($reg[$c][nacimiento_caballo]=="00-00-0000" || $reg[$c][nacimiento_caballo]=="0000-00-00" || $reg[$c][nacimiento_caballo]=="00/00/0000"){			$fecnacca="&nbsp;";										}
								else{								$fecnacca=$reg[$c][nacimiento_caballo];						}
						   echo"<td ".$cssRow." align=center >".$fecnacca."</td>";
				     	   echo"<td ".$cssRow.">".$reg[$c][criador_caballo]."</td>";
						   echo"<td ".$cssRow.">".$reg[$c][propietario_caballo]."</td>";
						   echo"</tr>";

						   	if($htmldeta!=""){
						   		echo"<tr><td  class=normaltd>&nbsp</td><td colspan=8>";
						    	echo $htmldeta;
						    	echo "</td></tr>";
							}
				}
		     }//FIN DE FOR	

		     xpaginador($reg,$ini,$fin,$numrows,$origen);



}
function htmlItemsProp($idProp,$nombreProp,$idHorse,$link,$alternativa,$opc,$ini,$fin,$dato1,$dato2){

$htmlItemsProp="";
$posee=" cria ";
$rol=" Criador ";
$rolU=" Propietario ";
if( $opc=="2" ){
$posee=" posee ";
$rol=" Propietario ";
$rolU=" Criador ";
}    


	$htmlItemsProp="<tr><td></td><td colspan=9>";
							//$htmlItemsProp=$htmlItemsProp."<table bgcolor=white width=100% border=1 cellpadding=2 cellspacing=0  style='color:darkblue;font-size:9px;border-collapse:collapse;'>";
							$htmlItemsProp=$htmlItemsProp."<table bgcolor=white width=100% border=1 cellpadding=2 cellspacing=0  style=' font-size:9px;border-collapse:collapse;'>";
							$htmlItemsProp=$htmlItemsProp."<th colspan=10  class='ui-dialog-titlebar ui-widget-header' style='font-size:12px; '><div style='float:left;'>Ejemplares que ". $posee ." el ". $rol ." : ".$nombreProp."</div></th>";
							$htmlItemsProp=$htmlItemsProp."<tr height=25 bgcolor=lightgrey class=bold><td   >N&deg;</td><td>&nbsp;&nbsp;&nbsp;c&oacute;digo&nbsp;&nbsp;&nbsp;</td><td>Prefijo</td><td>Nombre Caballo</td><td>".TXTHEADERESTADO."</td>";
							$htmlItemsProp=$htmlItemsProp."<td align=center width=10%>Fec Nac</td><td>Padre</td><td>Madre</td><td>". $rolU."</td></tr>";//<td>Links</td></tr>";				

							
							if( $opc=="2" ){
								$array_ejem=buscarejemplarespropietario($idProp,$link);
							}else{
								$array_ejem=buscarejemplarescriador($idProp,$link);

							}
							
								if($array_ejem!=-1)
								{
									$attrRow="   ";
										for($d=0;$d<sizeof($array_ejem);$d++)
											{
												$attrRow="";
												$cssTR=" class='gridHtmlRow cursor' ";
												if($idHorse==$array_ejem[$d][codigo]){
													$attrRow=" class='ui-dialog-titlebar ui-widget-header'";
													$cssTR="  ";
												}
												$urlB="indice.php?id_caballo=".$idProp."&txtdato1=".$dato1."&txtdato2=".$dato2."&opc=".$opc."&inicio=".$ini."&fin=".$fin."&valor=1&alt=".$array_ejem[$d][codigo]."#".$array_ejem[$d][codigo] ;
												$htmlItemsProp=$htmlItemsProp."<tr  valign=top ".$cssTR.">";
												$htmlItemsProp=$htmlItemsProp."<td  ".$attrRow." class='cursor' title='ver detalle del ejemplar'    onclick=detailSearch('".$urlB."') >".$array_ejem[$d][n]."</td>";
												//$htmlItemsProp=$htmlItemsProp."<td ".$attrRow."  class='cursor' title='ver detalle del ejemplar'    onclick=detailSearch('".$urlB."') ><a href='indice.php?id_caballo=".$idProp."&txtdato1=".$dato1."&txtdato2=".$dato2."&opc=".$opc."&inicio=".$ini."&fin=".$fin."&valor=1&alt=".$array_ejem[$d][codigo]."#".$array_ejem[$d][codigo]."' name=".$array_ejem[$d][codigo]."  title='Ver detalles !' style='color:red'>".$array_ejem[$d][codigo]." </a></td>";
												$htmlItemsProp=$htmlItemsProp."<td ".$attrRow."  class='cursor' title='ver detalle del ejemplar'    onclick=detailSearch('".$urlB."') ><a href=# name=".$array_ejem[$d][codigo]."></a>".$array_ejem[$d][codigo]."</td>";
							 	 	 	        $htmlItemsProp=$htmlItemsProp."<td ".$attrRow."  class='cursor' title='ver detalle del ejemplar'    onclick=detailSearch('".$urlB."')  >".$array_ejem[$d][prefijo_caballo]."</td>";			
										  	 	$htmlItemsProp=$htmlItemsProp."<td ".$attrRow."  class='cursor' title='ver detalle del ejemplar'    onclick=detailSearch('".$urlB."') >".$array_ejem[$d][nombre_caballo]."</td>";
											 	$htmlItemsProp=$htmlItemsProp."<td  ".$attrRow."  class='cursor' title='ver detalle del ejemplar'    onclick=detailSearch('".$urlB."') >".$array_ejem[$d][fallecio]."</td>";#addon
												if($array_ejem[$d][nacimiento_caballo]=="00-00-0000" || $array_ejem[$d][nacimiento_caballo]=="0000-00-00"  || $array_ejem[$d][nacimiento_caballo]=="00/00/0000"){								$propfechanac="&nbsp;";								}
												else{									$propfechanac=$array_ejem[$d][nacimiento_caballo];								}
											 	$htmlItemsProp=$htmlItemsProp."<td  ".$attrRow."  class='cursor' title='ver detalle del ejemplar'    onclick=detailSearch('".$urlB."') >".$propfechanac."</td>";#addon
												$htmlItemsProp=$htmlItemsProp."<td  ".$attrRow."  class='cursor' title='ver detalle del ejemplar'    onclick=detailSearch('".$urlB."') >".$array_ejem[$d][prefijo_padre_caballo]."&nbsp;".$array_ejem[$d][padre_caballo]."</td>";
												$htmlItemsProp=$htmlItemsProp."<td  ".$attrRow."  class='cursor' title='ver detalle del ejemplar'    onclick=detailSearch('".$urlB."') >".$array_ejem[$d][prefijo_madre_caballo]."&nbsp;".$array_ejem[$d][madre_caballo]."</td>";
										  		
										  		$nombrePrincipal= $opc=="2" ?   $array_ejem[$d][criador_caballo] : $array_ejem[$d][propietario_caballo];

										  		$htmlItemsProp=$htmlItemsProp."<td ".$attrRow."   class='cursor' title='ver detalle del ejemplar'    onclick=detailSearch('".$urlB."') > ".$nombrePrincipal."</td>";


												$htmlItemsProp=$htmlItemsProp."</tr>";
							
											   /*DETALLE DE CABALLO*/
												$htmldeta="";
												if($alternativa==1 && $idHorse==$array_ejem[$d][codigo])
												{
												   $cssRow=" class=anormaltd	";				 	
											       $detahorse2=detalleCaballo($idHorse,$link);			
												   $htmldeta=htmlDetalleEjemplar($detahorse2);
												}
												if($htmldeta!=""){
											   		$htmlItemsProp=$htmlItemsProp."<tr><td  class=normaltd>&nbsp</td><td colspan=9>";
											    	$htmlItemsProp=$htmlItemsProp. $htmldeta;
											    	$htmlItemsProp=$htmlItemsProp. "</td></tr>";
												}
											/*FIN DETALLE DE CABALLO*/
										}
									$htmlItemsProp=$htmlItemsProp."<tr><td colspan=10>&nbsp;</td></tr>";	
								}
								else
								{
								$htmlItemsProp=$htmlItemsProp."<tr><td colspan=10>No se encontraron ejemplares !</td></tr>	";
								}
					
						$htmlItemsProp=$htmlItemsProp."</table></td></tr>";

						return 	$htmlItemsProp;
}

function htmlDetalleEjemplar($detah){
	$x=0;
	$htmldeta="";
				    if($detah !=-1)
					{  
						$genero=substr(trim($detah[$x]['codigo']),0,1);
						$htmldeta="<table border=0 style=' border-collapse:collapse;' width=100% class=bold3 cellpadding=2 cellspacing=0 >";
					  	
						$fecha=$detah[$x]['nacimiento_caballo'];
						if($fecha=="00-00-0000" || $fecha=="0000-00-00" || $fecha=="00/00/0000" ){ 								$fecha="&nbsp;";						}

						$htmldeta=$htmldeta."<th colspan=3 align=center height=30><br>Detalle de c&oacute;digo &nbsp;".$detah[$x]['codigo']." <img src='img/log-aacp.gif' ><hr></th>";
						$htmldeta=$htmldeta."<tR><TD><b>Padre </td><td colspan=2>".$detah[$x]['prefijo_padre_caballo']."&nbsp;".$detah[$x]['nombre_padre_caballo']." </td></tr>";
						$htmldeta=$htmldeta."<tR><TD  width=20%><b>Madre</td><td colspan=1  width=50%>".$detah[$x]['prefijo_madre_caballo']."&nbsp;".$detah[$x]['nombre_madre_caballo']."</td><td rowspan=2  width=30%><span class='verArbol paginador'  data-item-id='".$detah[$x]['codigo']."' title='ir a ver arbol genealogico.' >Ver Arbol Geneal&oacute;gico </span></td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>Fecha Nacimiento</td><td colspan=1>".$fecha."</td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>Lugar de Nacimiento </td><td >".$detah[$x]['lugar_nac_caballo']."</td><td rowspan=2><span class='verCria paginador'  data-item-id='".$detah[$x]['codigo']."' data-item-genere='".$genero."' data-item-title='1'  title='ir a ver crias del ejemplar'>Ver Cr&iacute;as</span></td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>Color</td><td colspan=1>".$detah[$x]['pelaje_caballo']."</td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>Criador</td><td colspan=1>".$detah[$x]['nombre_criador_caballo']."</td><td rowspan=2><span class='verImagen paginador'  data-item-id='".$detah[$x]['codigo']."'  data-item-front='1' title='Ver galeria de imagenes del ejemplar.'> Ver Galeria </span></td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>Propietario</td ><td colspan=1>".$detah[$x]['nombre_propietario_caballo']."</td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>Descripci&oacute;n</td ><td colspan=1>".$detah[$x]['descripcion_caballo']."</td><td rowspan=2><span class='verConcurso paginador'  data-item-id='".$detah[$x]['codigo']."'title='ir a ver concursos que participó el ejemplar.'> Concursos</span></td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>Microchip</td ><td  >".$detah[$x]['microchip_caballo']."</td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>ADN</td ><td colspan=2>".$detah[$x]['adn_caballo']."</td></tr>";
						if($detah[$x]['fallecio']=="&nbsp;"){
							$txtestado="(Vivo)";
						}else{
							$txtestado="(Falleci&oacute;)";
						}
						$htmldeta=$htmldeta."<tR><TD><b>".TXTESTADOACTUAL."</td><td colspan=2 align=left>$txtestado &nbsp;".$detah[$x]['fallecio']."</td></tr>";
						$htmldeta=$htmldeta."<tR><TD colspan=3 height=30></td></tr>";
				           
 				    $htmldeta=$htmldeta."</table>";
				   }
				   return $htmldeta;
}

?>
<script src="scripts/concursos.js"></script>
<div id="divBusqueda">
 <div id="busquedaVivo"  >
	</div>
	<div id="busquedaMuerto"   >
	</div>
	<div id="busquedaTransf"   >
	</div>
</div>
<div id="divVerCrias">
 <div id="crias" >
	</div>
</div>
<div id="divVerImagen" >
	<div id="galeria" >
	</div>
</div>
<div id="divVerConcurso" >
<table id="gridConcurso" class="table-responsive  table table-striped table-bordered table-hover  " style="display:none; width:100%;">
                     <thead>
                         <tr>
                             <th>N°</th>
                             <th>CONCURSO</th>
                             <th>FECHA</th>
                             <th>JUEZ</th>
                             <th>CATEGORIA</th>
                             <th>GRUPO</th>
                             <th>PUESTO OBTENIDO</th>
                             <th></th>
                         </tr>
                     </thead>
                 </table>
</div>
<div id="divVerArbol" >
	<div id="resultadoArbol" >
	</div>
</div>
<script language="javascript">
var load="<center><div style='width:300px;'><br><br>  Procesando, espere por favor... <div style='float:left;margin-top:-10px;'><img src='img/loader.gif'></div></div></center>"
function modi(dato)
{
	//document.f1.txtdato2.style.display = "inline";
	$("#txtdato2").show();
switch(dato)
	{
	case '0':
		label1="Nombre del Ejemplar";		
		label2="Nro de Registro";		
		break;
	case '1':
		label1="Nombre del Criador";		
		label2="ID del Criador";	
		break;
	case '2':
		label1="Nombre del Propietario";		
		label2="ID del Propietario";		
		break;
	case '3':
		label1="Pelaje del Ejemplar";		
		label2=" ";		
		//document.f1.txtdato2.style.display = "none";
		$("#txtdato2").hide();
		break;
	case '4':
		label1="Nro. de Microchip";	
		//document.f1.txtdato2.style.display = "none";
		$("#txtdato2").hide();
		label2="";		
		break;		
	case '5':
		label1="Nombre de Padre";		
		label2="Nro de Registro Padre";	
		break;			
	case '6':
		label1="Nombre de Madre";		
		label2="Nro de Registro Madre";	
		break;				
	}
//document.f1.txtdato1.value="";
//document.f1.txtdato2.value="";
//document.f1.label1.value=label1;
//document.f1.label2.value=label2;
$("#txtdato1").val("");
$("#txtdato2").val("");
$("#txtdato1").focus();
$("#label1").html(label1);
$("#label2").html(label2);
$("#opc").val(dato);

}
function Buscar()
{
if($("#txtdato1").val()==""  && $("#txtdato2").val()=="" )
{
alertify.error("Ingrese los datos para  realizar b&uacute;squeda");
}
else
{
if($("#txtdato1").val()=="" && $("#txtdato2").val()!=""  || $("#txtdato1").val()!="" && $("#txtdato2").val()=="" )
	{

	$("#inicio").val(1);
	$("#fin").val(10);
	$("#id_caballo").val("");
	dato1=$("#txtdato1").val();
	dato2=$("#txtdato2").val();
	dato1=dato1.toUpperCase();
	dato2=dato2.toUpperCase();

var param={
	txtdato1:dato1.toUpperCase(),
	txtdato2:dato2.toUpperCase(),
	opc:$("#opc").val(),
	inicio:$("#inicio").val(),
	fin:$("#fin").val(),
	origen:'1'
};

$("#busquedaVivo").html("");
$("#busquedaMuerto").html("");
$("#busquedaTransf").html("");

	 $.ajax({	async: true,
				data:  param,
				url:   'ajaxBusqueda.php',
				type:  'get',
				beforeSend: function () {
				    $("#busquedaVivo").html(load);
				},
				success:  function (response) {  
				    $("#busquedaVivo").html(response);
				}
			}); 
		if(param.opc!="1" && param.opc!="2" && param.opc!="5" && param.opc!="6"){
				param.origen='2';
				$.ajax({ 	async: true,
							data:  param,
							url:   'ajaxBusqueda.php',
							type:  'get',
							beforeSend: function () {
							    $("#busquedaMuerto").html(load);
							},
							success:  function (response) {
							    $("#busquedaMuerto").html(response);
							    $("#tb_2").hide();  
							}
						});
			/*	param.origen='3'; 
					if(param.opc=="2"){
					$.ajax({
							data:  param,
							url:   'ajaxBusqueda.php',
							type:  'get',
							beforeSend: function () {
							    $("#busquedaTransf").html(load);
							},
							success:  function (response) {
							    $("#busquedaTransf").html(response);
							}
						});
					}	
					*/
		}

	}
else
	{
	//alert("Debe ingresar uno de los dos datos para iniciar búsqueda");
	   $("#busqueda").html("Ingrese los paramentros para la busqueda");
	}

}

}	
function next(inicio,fin,origen)
{


/*origen de la paginacion*/

 

if(origen==undefined)origen=0;
dato1=$("#txtdato1").val();
dato2=$("#txtdato2").val();
opc=$("#opc").val();
idcaballo=$("#id_caballo").val();
alt=$("#alt").val();
valor=$("#valor").val();

var param={
	txtdato1:dato1.toUpperCase(),
	txtdato2:dato2.toUpperCase(),
	opc:$("#opc").val(),
	inicio:$("#inicio").val(),
	fin:$("#fin").val(),
	origen:origen,
	inicio:inicio,
	fin:fin
};
idControl="";
if(origen==1){idControl="#busquedaVivo";}
if(origen==2){idControl="#busquedaMuerto";}
if(origen==3){idControl="#busquedaTransferido";}
	$.ajax({
				data:  param,
				url:   'ajaxBusqueda.php',
				type:  'get',
				beforeSend: function () {
				    $(idControl).html(load);
				},
				success:  function (response) {  
				    $(idControl).html(response);
				    if(origen==2){
				    		$('#imgExpand').attr("src","img/minus.png"); /*muestra detalle de cab allo*/
				    		$('#imgExpand').attr("title","ocultar lista");
					}
				}
			});

//linker="indice.php?id_caballo="+idcaballo+"&txtdato1="+dato1+"&txtdato2="+dato2+"&opc="+opc+"&inicio="+inicio+"&fin="+fin+"&valor=1&alt="+alt+"&source="+origen+"#paginador ";
//document.location.replace(linker);




}
function verdeta(id)
{

try
	{ 
/*
	$.ajax({
				data:  param,
				url:   'ajaxDetaEjemplar.php',
				type:  'get',
				beforeSend: function () {
				    $("detalleEjemplar").html("Procesando, espere por favor...");
				},
				success:  function (response) {  
				    $("detalleEjemplar").html(response);
				}
			});
*/

	//document.f1.id_caballo.value=n;
	//document.f1.submit();
//	alert(n);
	}
catch(ex)	
{
alert(ex.description);
}


}

function crias(gen,id)
{
try
{ }
catch(ex)	
{alert(ex.description);}

}
function verejemplar(id)
{
try
	{ 
	document.f1.id_caballo.value=id;
	document.f1.submit();
	}
catch(ex)	
	{alert(ex.description);}
}

function deta_ejemplar(id)
{

	document.f1.alt.value=id;
	document.f1.valor.value=1;
	document.f1.submit();


}
function limpiar1()
{

document.f1.txtdato2.value="";
}
function limpiar2()
{
document.f1.txtdato1.value="";
}

function verDatosExpand(){
 
			var query = $('#tb_2');
 			// check if element is Visible
			var isVisible = query.is(':visible');
			if (isVisible === true) {
				$("#tb_2").hide();
				$('#imgExpand').attr("src","img/plus.png");
				$('#imgExpand').attr("title","ver lista");
				
			} else {
				$("#tb_2").show();
				$('#imgExpand').attr("src","img/minus.png");
				$('#imgExpand').attr("title","ocultar lista");
			}
	return false;
}
</script>
