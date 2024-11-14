<? 
include(DIR_FUNCTION."conectar.php");
include(DIR_FUNCTION."queries.php");

?>

<table border=0 width=100% cellpadding=2 cellspacing=0 bgcolor=whitesmoke class='text2'>

<?
$genero1=$_GET['gen'];
$codigo=$_GET['id'];
$codigohijo=$_GET['deta'];
// addon dbs ecu
switch(strtoupper($genero1))
{
  case 'Y':$data="de la Yegua"; 
	   $sql="SELECT codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
	   -- codpad,prefpa,nompad,
	   -- codmad,prefma,nommad,
	   codpad,if(prefpa is null,epp.prefijo,d.prefpa) prefpa,if(d.nompad is null,epp.nombre,d.nompad)nompad,
	   codmad,if(prefma is null,epm.prefijo,d.prefma) prefma,if(d.nommad is null,epm.nombre,d.nommad)nompad,
	   d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec,fecnac  as orden,ifnull(d.idMetodo,0) as idMetodo,
	   d.genero FROM ".TABLE_DATO." d 
left join sge_ejemplar_peru epp on (epp.id=replace(d.codpad,'.','-')) 
left join sge_ejemplar_peru epm on (epm.id=replace(d.codmad,'.','-')) 
	   WHERE codmad='$codigo' order by orden desc ";
   	   break;

  case 'P':$data="del Caballo"; 
	   $sql="SELECT codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
	 --  codpad,prefpa,nompad,
	 --  codmad,prefma,nommad,
	   codpad,if(prefpa is null,epp.prefijo,d.prefpa) prefpa,if(d.nompad is null,epp.nombre,d.nompad)nompad,
	   codmad,if(prefma is null,epm.prefijo,d.prefma) prefma,if(d.nommad is null,epm.nombre,d.nommad)nompad,
	   d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec,fecnac as orden,ifnull(d.idMetodo,0) as idMetodo,
	   d.genero FROM ".TABLE_DATO." d
left join sge_ejemplar_peru epp on (epp.id=replace(d.codpad,'.','-')) 
left join sge_ejemplar_peru epm on (epm.id=replace(d.codmad,'.','-')) 
	    WHERE codpad='$codigo' order by orden desc";
   	   break;
  default :  $data="del Caballo"; 
	   $sql="SELECT codigo,prefij,d.nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,
	 --  codpad,prefpa,nompad,
	 --  codmad,prefma,nommad,
	   codpad,if(prefpa is null,epp.prefijo,d.prefpa) prefpa,if(d.nompad is null,epp.nombre,d.nompad)nompad,
	   codmad,if(prefma is null,epm.prefijo,d.prefma) prefma,if(d.nommad is null,epm.nombre,d.nommad)nompad,
	   d.pelaje,descri,lugnac,cod_criador,criador,cod_propie,propie,fallec, fecnac as orden,ifnull(d.idMetodo,0) as idMetodo,
	   d.genero FROM ".TABLE_DATO."  d
left join sge_ejemplar_peru epp on (epp.id=replace(d.codpad,'.','-')) 
left join sge_ejemplar_peru epm on (epm.id=replace(d.codmad,'.','-')) 
	   WHERE codpad='$codigo' order by orden desc";
   	   break;
 
}
$arreglo_crias=Buscar_cria($sql,$link);
$datoc=detalleCaballo($codigo,$link);


			//echo"<pre>";
			//print_r($arreglo_crias);
			//echo"</pre>";
if($datoc!=-1)
	{
	
				
			$x=0;
			
				echo"<tr><td height=40 colspan=15 align=center>";
				echo"<table border=0 width=100% class=bold3 cellpadding=0 cellspacing=0 >";
				echo"<th colspan=3 align=center height=30>Relaci&oacute;n de cr&iacute;as ".$data."  &nbsp;:".$datoc[$x]['codigo']."&nbsp;<span style='color:red;'>".$datoc[$x]['prefijo_caballo']."&nbsp;".$datoc[$x]['nombre_caballo']."</span> <img src='img/log-aacp.gif' ><hr></th>";	
				echo"<tR><TD width=150><b>Padre </td><td colspan=2>".$datoc[$x]['prefijo_padre_caballo']."&nbsp;".$datoc[$x]['nombre_padre_caballo']."</td></tr>";
				echo"<tR><TD><b>Madre</td><td colspan=1>".$datoc[$x]['prefijo_madre_caballo']."&nbsp;".$datoc[$x]['nombre_madre_caballo']."</td></tr>";
				
				if($datoc[$x]['nacimiento_caballo']=="0000-00-00"){	
						$fecnacx="&nbsp;";
				}else{
						$fecnacx=$datoc[$x]['nacimiento_caballo'];
				}
				echo"<tR><TD><b>Fecha Nacimiento</td><td colspan=1>".$fecnacx."</td></tr>";

				echo"<tR><TD><b>Lugar de Nacimiento </td><td >".$datoc[$x]['lugar_nac_caballo']."</td></tr>";
				echo"<tR><TD><b>Color</td><td colspan=1>".$datoc[$x]['pelaje_caballo']."</td></tr>";
				echo"<tR><TD><b>Criador</td><td colspan=2>".$datoc[$x]['nombre_criador_caballo']."</td></tr>";
				echo"<tR><TD><b>Propietario</td ><td colspan=2>".$datoc[$x]['nombre_propietario_caballo']."</td></tr>";
				echo"<tR><TD><b>Descripci&oacute;n</td ><td colspan=2>".$datoc[$x]['descripcion_caballo']."</td></tr>";
				echo"<tR><TD colspan=3 height=30><hr></td></tr>";
				echo"</table>";
				echo"</td></tr>";
	}
else    {
	echo"<tr><td height=40 colspan=15 align=center>No se encontraron datos!</td></tr>";					
	}
if($arreglo_crias!=-1){$n=sizeof($arreglo_crias);}
else{$n=0;}



echo"<td height=30 align=left  colspan=4>Resultados de B&uacute;squeda de cr&iacute;as </td><td height=30 colspan=10 style='color:red;font-size:10px;'>N&deg; de cr&iacute;as encontradas &nbsp;".$n."</td>";//<td><a href='javascript:window.history.back(1);'>Volver</a></td>";	
echo"<tr height=18 bgcolor=darkblue style=color:white;background-image:url('img/tbl_header.png') bgcolor=lightgrey class=bold><td>N&deg;</td><td>C&oacute;digo</td><td>Prefijo</td><td>Nombre Caballo</td><td>Pelaje</td><td>".TXTHEADERESTADO."</td>";
echo"<td>Fec Nac</td>";

switch(strtoupper($genero1))
{
  case 'Y' :
	echo"<td>Id Padre</td><td>Pref.</td><td>Padre del Caballo</td>";
	break;
 default :
	echo"<td>Id Madre</td><td>Pref.</td><td>Madre del Caballo</td>";
	break;	
}
if($arreglo_crias!=-1)
	{
		
	
	for($x=0;$x<sizeof($arreglo_crias);$x++)
			{
				if($codigohijo==$arreglo_crias[$x][codigo])
				{
				echo"<tr bgcolor=darkblue style=color:white;background-image:url('img/tbl_header.png');font-weight:bold; bgcolor=darkblue>";
				echo"<td colspan=1 style=color:white;background-image:url('img/tbl_header.png') bgcolor=darkblue>".$arreglo_crias[$x]['n']."</td>";
				echo"<td colspan=1 style=color:white;background-image:url('img/tbl_header.png');font-weight:bold;>";

				$url="crias.php?gen=".$genero1."&id=".$codigo."&title=1#".$arreglo_crias[$x][codigo];
				echo "<label class='cursor enlace' title='ocultar detalle' onclick=viewDetaCria('".$url."') >".$arreglo_crias[$x]['codigo']."</label>";
				?>	
				<!--
				<a href=crias.php?gen=<?=$genero1?>&id=<?=$codigo?>&title=1#<?=$arreglo_crias[$x][codigo]?> name=<?=$arreglo_crias[$x][codigo]?> title='Click para No ver detalle !' style='color:yellow'><?=$arreglo_crias[$x]['codigo']?></a>
			-->
				<? echo"</td>";

				echo"<td colspan=1 class='cursor enlace' title='ocultar detalle' onclick=viewDetaCria('".$url."') style=color:white;background-image:url('img/tbl_header.png');font-weight:bold;>".$arreglo_crias[$x]['prefijo_caballo']."</td>";
				echo"<td colspan=1 class='cursor enlace' title='ocultar detalle' onclick=viewDetaCria('".$url."') style=color:white;background-image:url('img/tbl_header.png');font-weight:bold;>".$arreglo_crias[$x]['nombre_caballo']."</td>";
				echo"<td colspan=1 class='cursor enlace' title='ocultar detalle' onclick=viewDetaCria('".$url."') style=color:white;background-image:url('img/tbl_header.png');font-weight:bold;>".$arreglo_crias[$x]['pelaje_caballo']."</td>";
				echo"<td colspan=1 class='cursor enlace' title='ocultar detalle' onclick=viewDetaCria('".$url."') style=color:white;background-image:url('img/tbl_header.png');font-weight:bold;>".$arreglo_crias[$x]['fallecio']."</td>";
					if($arreglo_crias[$x]['nacimiento_caballo']=="0000-00-00"){	
							$fecnacxx="&nbsp;";
					}else{
							$fecnacxx=$arreglo_crias[$x]['nacimiento_caballo'];
					}
				echo"<td colspan=1 >".$fecnacxx."</td>";
				     switch(strtoupper($genero1))
				     {
				  case 'Y' :echo"<td class='cursor enlace' title='ocultar detalle' onclick=viewDetaCria('".$url."') colspan=1 style=color:white;background-image:url('img/tbl_header.png');font-weight:bold;>".$arreglo_crias[$x]['codigo_padre_caballo']."</td>";
					echo"<td>".$arreglo_crias[$x]['prefijo_padre_caballo']."</td>";
					echo"<td class='cursor enlace' title='ocultar detalle' onclick=viewDetaCria('".$url."') colspan=1 style=color:white;background-image:url('img/tbl_header.png');font-weight:bold;>&nbsp;".$arreglo_crias[$x]['nombre_padre_caballo']."</td>";
					break;
				  default :echo"<td class='cursor enlace' title='ocultar detalle' onclick=viewDetaCria('".$url."') colspan=1 style=color:white;background-image:url('img/tbl_header.png');font-weight:bold;>".$arreglo_crias[$x]['codigo_madre_caballo']."</td>";
					echo"<td class='cursor enlace' title='ocultar detalle' onclick=viewDetaCria('".$url."') >".$arreglo_crias[$x]['prefijo_madre_caballo']."</td>";
				      echo"<td class='cursor enlace' title='ocultar detalle' onclick=viewDetaCria('".$url."') colspan=1 style=color:white;background-image:url('img/tbl_header.png');font-weight:bold;>&nbsp;".$arreglo_crias[$x]['nombre_madre_caballo']."</td>";
					break;
				    }	
				}
				else
				{
				echo"<tr  >";
				echo"<td   colspan=1 style=color:white;background-image:url('img/tbl_header.png') bgcolor=darkblue>".$arreglo_crias[$x]['n']."</td>";
				echo"<td colspan=1>";
//<a href=javascript:verdeta('".$arreglo_crias[$x][codigo]."','".$genero1."','".$codigo."') title='Click para ver detalle !' style='color:red'>".$arreglo_crias[$x]['codigo']."</a></td>";
?>	
<!--<a href=crias.php?gen=<?=$genero1?>&id=<?=$codigo?>&deta=<?=$arreglo_crias[$x][codigo]?>&title=1#<?=$arreglo_crias[$x][codigo]?> name=<?=$arreglo_crias[$x][codigo]?> title='Click para ver detalle !' style='color:red'><?=$arreglo_crias[$x]['codigo']?></a>-->
<? 
$url="crias.php?gen=".$genero1."&id=".$codigo."&deta=".$arreglo_crias[$x][codigo]."&title=1#".$arreglo_crias[$x][codigo];
echo "<label class='cursor enlace' title='ver detalle' onclick=viewDetaCria('".$url."') >".$arreglo_crias[$x]['codigo']."</label>";
echo"</td>";

				echo"<td colspan=1 class='cursor enlace' title='ver detalle' onclick=viewDetaCria('".$url."')>".$arreglo_crias[$x]['prefijo_caballo']."</td>";
				echo"<td colspan=1 class='cursor enlace' title='ver detalle' onclick=viewDetaCria('".$url."')>".$arreglo_crias[$x]['nombre_caballo']."</td>";
				echo"<td colspan=1 class='cursor enlace' title='ver detalle' onclick=viewDetaCria('".$url."')>".$arreglo_crias[$x]['pelaje_caballo']."</td>";
				echo"<td colspan=1 class='cursor enlace' title='ver detalle' onclick=viewDetaCria('".$url."')>".$arreglo_crias[$x]['fallecio']."</td>";
	
				if($arreglo_crias[$x]['nacimiento_caballo']=="0000-00-00"){	
						$fecnacxx="&nbsp;";
				}else{
						$fecnacxx=$arreglo_crias[$x]['nacimiento_caballo'];
				}
				echo"<td colspan=1 class='cursor enlace' title='ver detalle' onclick=viewDetaCria('".$url."')>".$fecnacxx."</td>";
				     switch(strtoupper($genero1))
				     {
				  case 'Y' :echo"<td colspan=1 class='cursor enlace' title='ver detalle' onclick=viewDetaCria('".$url."') style='font-weight:100;'>".$arreglo_crias[$x]['codigo_padre_caballo']."</td>";
					echo"<td>".$arreglo_crias[$x]['prefijo_padre_caballo']."</td>";
					echo"<td colspan=1 style='font-weight:100;'>".$arreglo_crias[$x]['nombre_padre_caballo']."</td>";
					break;
				  default :echo"<td colspan=1 class='cursor enlace' title='ver detalle' onclick=viewDetaCria('".$url."') style='font-weight:100;'>".$arreglo_crias[$x]['codigo_madre_caballo']."</td>";
					echo"<td class='cursor enlace' title='ver detalle' onclick=viewDetaCria('".$url."')>".$arreglo_crias[$x]['prefijo_madre_caballo']."</td>";
					echo"<td colspan=1  class='cursor enlace' title='ver detalle' onclick=viewDetaCria('".$url."') style='font-weight:100;'>".$arreglo_crias[$x]['nombre_madre_caballo']."</td>";
					break;
				    }		
				}	
					
				
				
				//$genero=substr($codigohijo,0,1);
				if($codigohijo==$arreglo_crias[$x][codigo])
					{
					echo"<tr ><td>&nbsp;</td><td colspan=15>";
   				              echo"<table border=0 bgcolor=white width=100% class=bold3 cellpadding=0 cellspacing=0 >";
					 $genero=substr($codigohijo,0,1);
					 $detahorse2=detalleCaballo($codigohijo,$link);
					 if($detahorse2 !=-1)
						{
						  $y=0;
						echo"<th colspan=3 align=left height=30>Detalle de C&oacute;digo &nbsp;".$detahorse2[$y]['codigo']."&nbsp;".$detahorse2[$y]['prefijo_caballo']."&nbsp;-&nbsp <span style=color:red;>".$detahorse2[$y]['nombre_caballo']."</span>&nbsp;<img src='img/log-aacp.gif'  ><hr></th>";
						echo"<tR><TD width=150><b>Padre </td><td colspan=2>".$detahorse2[$y]['prefijo_padre_caballo']."&nbsp;".$detahorse2[$y]['nombre_padre_caballo']." </td></tr>";
						echo"<tR><TD><b>Madre</td><td colspan=1>".$detahorse2[$y]['prefijo_madre_caballo']."&nbsp;".$detahorse2[$y]['nombre_madre_caballo']." </td></tr>";//<td rowspan=2><a href='arbolgen.php?id=".$codigohijo."' target=_blank style='font-weight:bold;color:blue;'><img src='img/dot_blue.png' border=0>&nbsp;Ver Arbol Genealógico &nbsp;<img src='img/b_relations.png' border=0></a></td></tr>";

						if($detahorse2[$y]['nacimiento_caballo']=='0000-00-00'){
							$fechax="&nbsp;";
						}else{
							$fechax=$detahorse2[$y]['nacimiento_caballo'];
						}
						echo"<tR><TD><b>Fecha Nacimiento</td><td colspan=1>".$fechax."</td></tr>";

						echo"<tR><TD><b>Lugar de Nacimiento </td><td >".$detahorse2[$y]['lugar_nac_caballo']."</td></tr>";//<td rowspan=2><a href='crias.php?gen=".$genero."&id=".$codigohijo."' target=_blank style='font-weight:bold;color:blue;'><img src='img/dot_blue.png' border=0>&nbsp;Ver Crías</a></td></tr>";
						echo"<tR><TD><b>Color</td><td colspan=1>".$detahorse2[$y]['pelaje_caballo']."</td></tr>";
						echo"<tR><TD><b>Criador</td><td colspan=2>".$detahorse2[$y]['nombre_criador_caballo']."</td></tr>";
						echo"<tR><TD><b>Propietario</td ><td colspan=2>".$detahorse2[$y]['nombre_propietario_caballo']."</td></tr>";
						echo"<tR><TD><b>Descripci&oacute;n</td ><td colspan=2>".$detahorse2[$y]['descripcion_caballo']."</td></tr>";
						echo"<tR><TD><b>".TXTESTADOACTUAL."</td ><td colspan=2>".$detahorse2[$y]['fallecio']."</td></tr>";
						echo"<tR><TD colspan=3 height=30><hr></td></tr>";
					              }	
		 			echo"</table>";
					echo" </td></tr>";echo"<tr><td colspan=10>&nbsp;</td></tr>";
					}

			}//end for
		echo"<tr><TD colspan=15 height=30><hr></td></tr>";
	}
else
	{
		echo"<tr><td height=40 colspan=15 align=center style='color:red;font-size:10px;'><img src='img/s_warn.png'>&nbsp;&nbsp;NO SE ENCONTRARON CRIAS!</td></tr>";
	}

?>
</tr></table>



<script language="javascript">
function verdeta(n,genero,id)
{
try
	{ 

document.location.replace("crias.php?gen="+genero+"&id="+id+"&deta="+n)

	}
catch(ex)	
{
alert(ex.description);
}
}

</script>