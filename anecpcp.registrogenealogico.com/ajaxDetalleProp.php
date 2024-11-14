<? session_start();
require("constante.php");
//require(DIR_CABECERA);
require(DIR_VALIDAR);
require(DIR_FUNCTION."conectar.php");
require(DIR_FUNCTION."queries.php");
require(DIR_FUNCTION."general.php");
 
$idProp=$_GET['idProp'];
$opc=$_GET['opc'];
$origen=$_GET['origen'];
$titulo="";

if($origen==1)$titulo="Ejemplares  VIVOS ";
if($origen==2)$titulo="Ejemplares FALLECIDOS  ";
if($origen==3)	$titulo="Ejemplares TRANFERIDOS ";
if($origen==4)	$titulo="Ejemplares CAPADOS ";
if($origen==5)	$titulo="Ejemplares POR CLASIFICAR ";
 
$htmlItemsProp="";
$posee=" registrados bajo el prefijo de ";
if($origen==2)$posee=" inscritos  bajo el prefijo de  ";
$rol="   ";
$rolU=" Propietario ";
//$nombreProp=obtieneNombreCriador($idProp,$link);

if( $opc=="2" ){
$posee=" registrados a nombre de ";
if($origen==2)$posee=" inscritos a nombre de  ";
if($origen==3)$posee=" por  ";
//if($origen==4)$posee=" por  ";
if($origen==5)$posee=" a nombre de   ";
$rol="  ";
$rolU=" Criador ";

//$nombreProp=obtieneNombrePropietario($idProp,$link);
}    
 

$classHidden=" trNoHidden";
			$linkVer="";
			$display="  ";
				if($origen=="2" ){
					$display=" style='display:none;' ";
					$linkVer="&nbsp;&nbsp; <img id='imgExpand_".($origen+$idProp)."' onclick='return deplegarMuerto(".($origen+$idProp).");' src='img/plus.png' width=15px; title='ver lista' class='cursor' />";	
				}
				if($origen=="3" || $origen=="4" || $origen=="5" || $origen=="6"  ){
					$display=" style='display:none;' ";
					$linkVer="&nbsp;&nbsp; <img id='imgExpand_".($origen+$idProp)."' onclick='return deplegarMuerto(".($origen+$idProp).");' src='img/plus.png' width=15px; title='ver lista' class='cursor' />";	
				}
							if( $opc=="2" ){
								$array_ejem=buscarejemplarespropietario($idProp,$link,$origen);
							}if( $opc=="5" || $opc=="6" ){
								$array_ejem=buscarejemplaresCrias($idProp,$link,$origen,$opc);
							}elseif( $opc=="1" ){
								$array_ejem=buscarejemplarescriador($idProp,$link,$origen);
							}
							$numTotal=0;		
							if($array_ejem!=-1)$numTotal=sizeof($array_ejem);

							if($numTotal>0){
								if( $opc=="2" ){
													$nombreProp= $array_ejem[0][propietario_caballo];
												}elseif( $opc=="1" ){
													$nombreProp=$array_ejem[0][criador_caballo] ;
												}
							}else{
								if( $opc=="2" ){
													$nombreProp=obtieneNombrePropietario($idProp,$link);
												}elseif( $opc=="1" ){
													$nombreProp=obtieneNombreCriador($idProp,$link);
												}
							}


							$htmlItemsProp=$htmlItemsProp."<center><table bgcolor=white width=90% border=1 cellpadding=2 cellspacing=0  style=' font-size:9px;border-collapse:collapse;'>";
							$htmlItemsProp=$htmlItemsProp."<thead><tr><th colspan=10  class='ui-dialog-titlebar ui-widget-header' style='font-size:12px; '><div style='float:left;'>";
							if( $opc=="5" || $opc=="6" ){
								$htmlItemsProp=$htmlItemsProp." ".str_replace("Ejemplares","Crías ",$titulo)." : ".$numTotal." &nbsp;&nbsp;".$linkVer."";
							}else{
								$htmlItemsProp=$htmlItemsProp." ".$titulo." ". $posee ." ". $rol ." ".$nombreProp.": ".$numTotal." &nbsp;&nbsp;".$linkVer."";
							}

							$htmlItemsProp=$htmlItemsProp." </div></th></tr></thead>";

							$htmlItemsProp=$htmlItemsProp."<thead id='thead_".($origen+$idProp)."' ".$display." ><tr height=25 bgcolor=lightgrey class=bold><td   >N&deg;</td><td>&nbsp;&nbsp;&nbsp;c&oacute;digo&nbsp;&nbsp;&nbsp;</td><td>Prefijo</td><td>Nombre Caballo</td>";
							$htmlItemsProp=$htmlItemsProp."<td>Pelaje</td><td align=center width=10%>Fec Nac</td><td>Padre</td><td>Madre</td><td>". $rolU."</td><td>Microchip</td></tr>";				//<td>".TXTHEADERESTADO."</td>
							$htmlItemsProp=$htmlItemsProp."</thead>";
							$htmlItemsProp=$htmlItemsProp."<tbody id='tbody_".($origen+$idProp)."' ".$display.">";
								if($array_ejem!=-1)
								{
									
									$attrRow="   ";
										for($d=0;$d<sizeof($array_ejem);$d++)
											{
												

												$idItemRow=str_replace( '.', '', $array_ejem[$d][codigo]);
												
												$htmlItemsProp=$htmlItemsProp."<tr  valign=top id='filaSelSub_".$idItemRow."' class='filaSelSub gridHtmlRow cursor ' onclick=detailSearchSub('".$array_ejem[$d][codigo]."')>";
												$htmlItemsProp=$htmlItemsProp."<td class='cursor' title='ver detalle del ejemplar'>".$array_ejem[$d][n]."</td>";
												$htmlItemsProp=$htmlItemsProp."<td class='cursor' title='ver detalle del ejemplar'>".$array_ejem[$d][codigo]."</td>";
							 	 	 	        $htmlItemsProp=$htmlItemsProp."<td class='cursor' title='ver detalle del ejemplar'>".$array_ejem[$d][prefijo_caballo]."</td>";			
										  	 	$htmlItemsProp=$htmlItemsProp."<td class='cursor' title='ver detalle del ejemplar'>  ".$array_ejem[$d][fallecio]."  ".$array_ejem[$d][nombre_caballo]."</td>";
										  	 	$htmlItemsProp=$htmlItemsProp."<td class='cursor' title='ver detalle del ejemplar'>  ".$array_ejem[$d][pelaje]."</td>";
											 	//$htmlItemsProp=$htmlItemsProp."<td class='cursor' title='ver detalle del ejemplar'>".$array_ejem[$d][fallecio]."</td>";#addon
												if($array_ejem[$d][nacimiento_caballo]=="00-00-0000" || $array_ejem[$d][nacimiento_caballo]=="0000-00-00"  || $array_ejem[$d][nacimiento_caballo]=="00/00/0000"){								$propfechanac="&nbsp;";								}
												else{									$propfechanac=$array_ejem[$d][nacimiento_caballo];								}
											 	$htmlItemsProp=$htmlItemsProp."<td class='cursor' title='ver detalle del ejemplar'>".$propfechanac."</td>";#addon
												$htmlItemsProp=$htmlItemsProp."<td class='cursor' title='ver detalle del ejemplar'>".$array_ejem[$d][prefijo_padre_caballo]."&nbsp;".$array_ejem[$d][padre_caballo]."</td>";
												$htmlItemsProp=$htmlItemsProp."<td class='cursor' title='ver detalle del ejemplar'>".$array_ejem[$d][prefijo_madre_caballo]."&nbsp;".$array_ejem[$d][madre_caballo]."</td>";
										  		$nombrePrincipal= $opc=="2" ?   $array_ejem[$d][criador_caballo] : $array_ejem[$d][propietario_caballo];
										  		$htmlItemsProp=$htmlItemsProp."<td class='cursor' title='ver detalle del ejemplar'> ".$nombrePrincipal."</td>";
										  		$htmlItemsProp=$htmlItemsProp."<td class='cursor' title='ver detalle del ejemplar'> ".$array_ejem[$d][microchip_caballo]."</td>";
												$htmlItemsProp=$htmlItemsProp."</tr>";

												 $htmlItemsProp=$htmlItemsProp."<tr >";
						   						 $htmlItemsProp=$htmlItemsProp."<td id='tr_".$idItemRow."' class='detaRowSubSub' style='display:none;' colspan='10' ><div id='div_".$idItemRow."' style='display:none;width:100%;'></div></td>";
						   						 $htmlItemsProp=$htmlItemsProp."</tr>";
							
											/*FIN DETALLE DE CABALLO*/
										}
									
									$htmlItemsProp=$htmlItemsProp."<tr><td colspan=10>&nbsp;</td></tr>";	
								}
								else
								{
								$htmlItemsProp=$htmlItemsProp."<tr><td colspan=10>No se encontraron ejemplares !</td></tr>	";
							}
						$htmlItemsProp=$htmlItemsProp."</tbody>";
						$htmlItemsProp=$htmlItemsProp."</table></center>";//</td></tr>";

						echo 	$htmlItemsProp;
 

?>


