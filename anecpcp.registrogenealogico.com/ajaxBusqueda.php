<? session_start();
require("constante.php");
//require(DIR_CABECERA);
require(DIR_VALIDAR);
require(DIR_FUNCTION."conectar.php");
require(DIR_FUNCTION."queries.php");
require(DIR_FUNCTION."general.php");

$origen=$_GET['origen'];
$dato1=trim($_GET['txtdato1']);
$dato2=trim($_GET['txtdato2']);

$opc=$_GET['opc'];
if(isset($_GET['inicio'])){
	$ini=$_GET['inicio'];
}else{
	$ini=1;
}
if(isset($_GET['fin'])){
			$fin=$_GET['fin'];
}else{
			$fin=10;
}	
if(isset($_GET['valor'])){
	$alternativa=$_GET['valor'];
}else{
	$alternativa=0;
}	

$data=$_GET['alt'];
$idhorse=$_GET['id_caballo'];


switch($opc)
{
case 6:	
case 5:	
case 3:
case 4:	
case 0: $des_dato1='Nombre del Ejemplar';
        $des_dato2='N&deg; de Registro';
	$colspan=" colspan=9 ";
	break;	
case 1: $des_dato1='Nombre del Criador';
        $des_dato2='ID del Criador';
	$colspan=" colspan=8";
	break;	

case 2: $des_dato1='Nombre del Propietario';
        $des_dato2='ID del Propietario';
	$colspan=" colspan=6";
	break;	
}
if(ValidarSession())
	{


	if(!(empty($dato1)) || !(empty($dato2)))
		{
			$reg=buscar($dato1,$dato2,$link,$opc,$origen);

			/* echo"<pre>";
			 print_r($reg);
			 echo"</pre>";*/


			if($opc!="1" && $opc!="2" &&  $opc!="5" && $opc!="6"){

				$regMuertos=$reg['muertos'];
				$regTransferidos=$reg['transferidos'];
				$reg=$reg['vivos'];
			
				$numVivo=sizeof($reg);
				$numMuerto=sizeof($regMuertos);
				$numTransferidos=sizeof($regTransferidos);
			}
			else{
				if($opc=="1"){
					$reg=$reg['criadores'];
					$num=sizeof($reg);
				}
				if($opc=="2" ){
					$reg=$reg['propietarios'];
					$num=sizeof($reg);
				}
				if(  $opc=="5" || $opc=="6"){
					
					/*$regMuertos=$reg['muertos'];
					$reg=$reg['vivos'];
				
					$numVivo=sizeof($reg);
					$numMuerto=sizeof($regMuertos);*/

				$reg=$reg['propietarios'];
					$num=sizeof($reg);


				}
			}
		 

		echo"<br/><center>";
		echo"<table width=97%    cellpadding=0 cellspacing=0 border=1 class='text2' style=' border-collapse:collapse;'>"; //style='background-image:url(img/fondoarbol.jpg); 
		 if(sizeof($reg)>=0)
		   {
			$numrows=10;
			
			switch($opc)
		 	{
 
		 	case 3:					#pelaje
		 	case 4:					#microchip
			case 0:					#ejemplar
				if($origen=='1')   listarCaballos($reg,$ini,$fin,$idhorse,$numVivo,$colspan,'Ejemplares vivos',$numrows,$origen,$opc);
				if($origen=='2')   listarCaballos($regMuertos,$ini,$fin,$idhorse,$numMuerto,$colspan,'Ejemplares fallecidos',$numrows,$origen,$opc);
				if($origen=='3')   listarCaballos($regTransferidos,$ini,$fin,$idhorse,$numTransferidos,$colspan,'Ejemplares Transferidos',$numrows,$origen,$opc);
		break;
			 case 1:				#criadror
		     case 2:				#propietario
		     case 5:				#padre
		     case 6:				#madre
		      
		    echo"<tr height=30 align=left><td  ".$colspan." >
				 <table border=0 width=100%><tr><td>
            	 <label name='ancla' style='font-size:15px;color:brown;font-weight:bold;'>
				 Resultados de B&uacute;squeda: ".$num." </label>
				 </td>
				 <td height=30 colspan=1 align=right style='color:gray;font-size:11px;'>
			 	 </td></tr></table></td></tr>";	

				 $id_propie=$idhorse;

				 $rol=" Criador ";
				 $headerNombre="Nombre y Apellido ";

				if( $opc=="2" )	$rol="del Propietario ";
				if( $opc=="5" )	{$rol="del Padre ";  $headerNombre="Prefijo y Nombre ";}
				if( $opc=="6" )	{$rol="de la Madre "; $headerNombre="Prefijo y Nombre ";}

           	 	echo"<tr height=30 class='ui-dialog-titlebar ui-widget-header ui-state-default ui-th-column ui-th-ltr'><td >N&deg;</td><td colspan=2 >c&oacute;digo ".$rol."</td><td colspan=3 align=center>$headerNombre ".$rol."</td></tr>";
           	  
			for($c=$ini-1;$c<$fin;$c++)
				{
					 
					if(!(empty($reg[$c][id])))
				 	{
				 	$idRow=str_replace(".","",$reg[$c][id]);
					echo"<tr id=filaSel_".$idRow." class='filaSel gridHtmlRow cursor' >";								 
					echo"<td class='   cursor' title='ver lista de ejemplares' onclick=detailSearch('".$idRow."','".$opc."')>".$reg[$c][n]."</td>";
					echo"<td class='   cursor' title='ver lista de ejemplares'  colspan=2 onclick=detailSearch('".$idRow."','".$opc."') >".$reg[$c][id]."</td>";
					echo"<td class='   cursor' title='ver lista de ejemplares'  colspan=3 onclick=detailSearch('".$idRow."','".$opc."')>".$reg[$c][nombre]."</td>";
					echo"</tr>";
					echo"<tr >";
					echo"<td id='tr_".$idRow."' class='detaRow' style='display:none;' colspan='9' ><div id='div_".$idRow."' style='display:none;width:100%;'></div></td>";
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
 			xpaginadorNeo($reg,$ini,$fin,$numrows,$origen);
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


			echo"</table><br/>";
			
			echo"</center>";
			//if($dat!=-1)
			//{xpaginador($reg,$ini,$fin,$numrows);}


		}

	}
else
	{
	//require(DIR_LOGIN);	
	//echo("<tr><td height=150 valign=top align=center style='color:red'>No ha iniciado  sesion ! <br>");
     //	echo("</td></tr>");		


	}


function listarCaballos($reg,$ini,$fin,$idhorse,$num,$colspan,$titulo,$numrows,$origen,$opc){
	 
			$classHidden=" trNoHidden";
			$linkVer="";
				if($origen=="2"){
					$linkVer="&nbsp;&nbsp;<img id='imgExpand' onclick='return verDatosExpand();' src='img/plus.png' title='ver lista' class='cursor'  width=15px;/>";	
					$classHidden=" trHidden  ";
				}

			 echo"<thead><tr height=30 align=left><td  ".$colspan." >
	 
					<table border=0 width=100%><tr><td> 
            		<label name='ancla' style='font-size:15px;color:brown;font-weight:bold;'>
					".$titulo."  : ".$num."</label>". $linkVer."
					</td><td height=30 colspan=1 align=right style='color:gray;font-size:11px;'>
					 </td></tr></table></td></tr>";	
		   echo"<tr height=30   class=' ".$classHidden." ui-dialog-titlebar ui-widget-header ui-state-default ui-th-column ui-th-ltr'><td>N&deg;</td>
				<td align=center>&nbsp;&nbsp;&nbsp;&nbsp;C&oacute;digo&nbsp;&nbsp;&nbsp;</td>
				<td align=center>Prefijo</td>
				<td align=center>Nombre </td>
				<td align=center>Pelaje </td>
				<td align=center width=10%>Fec Nac</td>";
				echo"<td align=center>Criador</td><td align=center> Propietario</td>";

				if($opc=="5") 				echo"<td align=center>Padre</td>";
				if($opc=="6") 				echo"<td align=center>Madre</td>";
				if($opc!="5" && $opc!="6") 				echo"<td align=center>Microchip</td>";
				
				echo"</tr></thead>";
				echo"<tbody id='tb_".$origen."' >";
				for($c=$ini-1;$c<$fin;$c++)
				{
				if(!(empty($reg[$c][codigo])))
				 {
						$cssRow=" class=normaltd	";
						$htmldeta=""				 	;
						$idItemRow=str_replace( '.', '', $reg[$c][codigo]);
						//$url="indice.php?id_caballo=".$reg[$c][codigo]."&txtdato1=".$dato1."&txtdato2=".$dato2."&opc=".$opc."&inicio=".$ini."&fin=".$fin."&valor=".$alternativa."&alt=".$data."#".$reg[$c][codigo];
						echo"<tr valign=top id='filaSel_".$idItemRow."' class='  ".$classHidden."  filaSel gridHtmlRow cursor ' 
						onclick=detailSearch('".$reg[$c][codigo]."') >";

						
						/*   if($idhorse==$reg[$c][codigo])
						   {		
							   $cssRow=" class=anormaltd	";				 	
						       $detah=detalleCaballo($idhorse,$link);			
							   $htmldeta=htmlDetalleEjemplar($detah);
							}
							*/
						   echo"<td ".$cssRow.">".$reg[$c][n]."</td>";
						   echo"<td ".$cssRow.">";//<a href=".$url."  name=".$reg[$c][codigo]."></a>";
					  	   echo $reg[$c][codigo];
						   echo"</td>";	
		   	  			   echo"<td ".$cssRow.">&nbsp;&nbsp;".$reg[$c][prefijo_caballo]."&nbsp;&nbsp;</td>";			
						   echo"<td ".$cssRow.">";
					  	   echo "&nbsp;".$reg[$c][fallecio]." ".$reg[$c][nombre_caballo]."</td>";
					  	   echo"<td ".$cssRow.">".$reg[$c][pelaje]."</td>";
						   //echo"<td align=center ".$cssRow.">".$reg[$c][fallecio]."</td>";
								if($reg[$c][nacimiento_caballo]=="00-00-0000" || $reg[$c][nacimiento_caballo]=="0000-00-00" || $reg[$c][nacimiento_caballo]=="00/00/0000"){			$fecnacca="&nbsp;";										}
								else{								$fecnacca=$reg[$c][nacimiento_caballo];						}
						   echo"<td ".$cssRow." align=center >".$fecnacca."</td>";
				     	   echo"<td ".$cssRow.">".$reg[$c][criador_caballo]."</td>";
						   echo"<td ".$cssRow.">".$reg[$c][propietario_caballo]."</td>";

				if($opc=="5") 				  echo"<td ".$cssRow.">".$reg[$c][padre]."</td>";
				if($opc=="6") 				  echo"<td ".$cssRow.">".$reg[$c][madre]."</td>";
				if($opc!="5" && $opc!="6") 	  echo"<td ".$cssRow.">".$reg[$c][microchip]."</td>";
						 


						   echo"</tr>";
						   echo"<tr >";
						   echo"<td id='tr_".$idItemRow."' class='detaRow' style='display:none;' colspan='9' ><div id='div_".$idItemRow."' style='display:none;width:100%;'></div></td>";
						   echo"</tr>";

				}
				
		     }//FIN DE FOR	
		      xpaginadorNeo($reg,$ini,$fin,$numrows,$origen);
echo"</tbody>";
		    

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
							$htmlItemsProp=$htmlItemsProp."<th colspan=10  class='ui-dialog-titlebar ui-widget-header ' style='font-size:12px; '><div style='float:left;'>Ejemplares que ". $posee ." el ". $rol ." : ".$nombreProp."</div></th>";
							$htmlItemsProp=$htmlItemsProp."<tr height=25 bgcolor=lightgrey class=bold><td   >N&deg;</td><td>&nbsp;&nbsp;&nbsp;c&oacute;digo&nbsp;&nbsp;&nbsp;</td><td>Prefijo</td><td>Nombre Caballo</td><td>".TXTHEADERESTADO."</td>";
							$htmlItemsProp=$htmlItemsProp."<td align=center width=10%>Fec Nac</td><td>Padre</td><td>Madre</td><td>". $rolU."</td></tr>";//<td>Links</td></tr>";				
							$array_ejem=buscarejemplarespropietario($idProp,$link);
								if($array_ejem!=-1)
								{
									$attrRow="   ";
										for($d=0;$d<sizeof($array_ejem);$d++)
											{
												$attrRow="";
												$cssTR=" class='gridHtmlRow cursor' ";
												if($idHorse==$array_ejem[$d][codigo]){
													$attrRow=" class='ui-dialog-titlebar ui-widget-header  '";
													$cssTR="  ";
												}
												$urlB="indice.php?id_caballo=".$idProp."&txtdato1=".$dato1."&txtdato2=".$dato2."&opc=".$opc."&inicio=".$ini."&fin=".$fin."&valor=1&alt=".$array_ejem[$d][codigo]."#".$array_ejem[$d][codigo] ;
												$htmlItemsProp=$htmlItemsProp."<tr  valign=top ".$cssTR.">";
												$htmlItemsProp=$htmlItemsProp."<td  ".$attrRow." class='cursor' title='ver detalle del ejemplar'    onclick=detailSearch('".$urlB."') >".$array_ejem[$d][n]."</td>";
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

<script>
$(function(){


/*	$("#imgExpand").on("click",function(){  
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


	
  	});
*/
});
</script>