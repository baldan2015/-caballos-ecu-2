	<?
require("constante.php");
require("admin/constante.php");
require(DIR_VALIDAR);
require(DIR_FUNCTION."conectar.php");
require(DIR_FUNCTION."queries.php");
require(DIR_FUNCTION."general.php");

$thumb_prefix           = "thumb_";

$idhorse=$_POST['idHorse'];
$detah=detalleCaballo($idhorse,$link);
$imagen=showImage($idhorse,$link);
//print_r($imagen);
$x=0;
	$htmldeta="";
				    if($detah !=-1)
					{  
						$genero=$detah[$x]['genero'];//substr(trim($detah[$x]['codigo']),0,1);
						$htmldeta="<table border=0 style=' background:#fff; border-collapse:collapse; width:100%;'  class=bold3 cellpadding=0 cellspacing=0 >";
					  	
						$fecha=$detah[$x]['nacimiento_caballo'];
						if($fecha=="00-00-0000" || $fecha=="0000-00-00" || $fecha=="00/00/0000" ){ 	
													$fecha="&nbsp;";						}

						/*
						addon dbs ecu no importa si es capado
						if($detah[$x]['capado']==1){
							$htmldeta=$htmldeta."<th colspan='5' height=50 ><table border=0 style=' border-collapse:collapse; width:100%;' class=bold3 cellpadding=0 cellspacing=0><tr height=40><td width='10%' height='100%' >
							<div style='border-right-width: 20px;padding-right: 75px;background:red;color:white;height:80%;font-size:160%;' >Capado</div></td>";	
						}else{
							
						}*/
						$htmldeta=$htmldeta."<th colspan='5' height=50><table   style=' background:#fff; border-collapse:collapse; width:100%;' class=bold3 cellpadding=0 cellspacing=0><tr height=40><!--<td width='10%'></td>-->";

						$htmldeta=$htmldeta."<td width='100%' height='100%' align=center><div class='tituloDetaHorse'>
						 Ejemplar: &nbsp;".$detah[$x]['codigo']."&nbsp;".$detah[$x]['prefijo_caballo']."&nbsp;".$detah[$x]['nombre_caballo']." <hr></div>
						</td></tr></table></th>";
						//logo <img src='img/log-aacp.gif' >
						/*$htmldeta=$htmldeta."<tr><td colspan=3><span class='verArbol cursor'  data-item-id='".$detah[$x]['codigo']."' title='ir a ver arbol genealogico.' style='left: 240px;'>Ver Arbol Geneal&oacute;gico </span><span class='verCria cursor'  data-item-id='".$detah[$x]['codigo']."' data-item-genere='".$genero."' data-item-title='1'  title='ir a ver crias del ejemplar' style='left: 300px;'>Ver Cr&iacute;as</span> <span class='verImagen cursor'  data-item-id='".$detah[$x]['codigo']."'  data-item-front='1' title='Ver galeria de imagenes del ejemplar.' style='left: 350px;'> Ver Galeria </span> <span class='verConcurso cursor'  data-item-id='".$detah[$x]['codigo']."'title='ir a ver concursos que participó el ejemplar.' style='left: 400px;'> Concursos</span>
							<span class='verMedida' data-item-ejemplar='".$detah[$x]['prefijo_caballo']."&nbsp;".$detah[$x]['nombre_caballo']."'  
											 data-item-adn='".$detah[$x]['adn_caballo']."'  
											 data-item-chip='".$detah[$x]['microchip_caballo']."'  
											 data-item-id='".$detah[$x]['codigo']."'  
											 data-item-fnac='".$fecha."'  
											 data-item-pa='".$detah[$x]['prefijo_padre_caballo']."&nbsp;".$detah[$x]['nombre_padre_caballo']."'  
											 data-item-ma='".$detah[$x]['prefijo_madre_caballo']."&nbsp;".$detah[$x]['nombre_madre_caballo']."'    
											 title='ver Medida.' style='left: 450px;'> Ver Medida Hipometricas</span></td></tr>";*/
						$htmldeta=$htmldeta."<tR><TD style='width:8%'><b>Padre</td><td style='width:3%'><img src='img/iconDetails/padre.png' ></td><td colspan=1 >".$detah[$x]['prefijo_padre_caballo']."&nbsp;".$detah[$x]['nombre_padre_caballo']."&nbsp;- ".$detah[$x]['codigo_padre_caballo']." </td>";	
						if($imagen[0][esPrincipal]==1){
							$htmldeta=$htmldeta."<td rowspan=12 width=25% valign='top'><table  style='width:75%;'><center><img style='width:300px;height:240px;' src='".K_PATHWEB_SGE.$imagen[0][ruta]."' ></center></table></td>
								<td rowspan=12><table  style=' border-collapse: separate;border-spacing: 10px; width:100%;'>
								<tr><td >&nbsp;<span class='btn btn-default  verArbol cursor'  data-item-id='".$detah[$x]['codigo']."' title='ir a ver arbol genealogico.' style='bottom: 10px;' ><img src='img/iconDetails/b_relations.png'>&nbsp;Ver Arbol Geneal&oacute;gico </span></td></tr>
								<tr><td>&nbsp;<span class='btn btn-default verCria cursor'  data-item-id='".$detah[$x]['codigo']."' data-item-genere='".$genero."' data-item-title='1'  title='ir a ver crias del ejemplar' style='bottom: 5px;' ><img src='img/iconDetails/uno.gif'>&nbsp;Ver Cr&iacute;as</span></td></tr>
								<tr><td>&nbsp;<span class='btn btn-default verImagen cursor'  data-item-id='".$detah[$x]['codigo']."'  data-item-front='1' title='Ver galeria de imagenes del ejemplar.' ><img src='img/iconDetails/foto.png'> Ver Galeria </span></td></tr>
								<tr><td>&nbsp;<span class='btn btn-default verConcurso cursor'  data-item-id='".$detah[$x]['codigo']."'title='ir a ver concursos que participó el ejemplar.' style='top: 5px;'><img src='img/iconDetails/premio.png' width='20' height='15'> Concursos</span></td></tr>
								 
								</table></td></tr>";
							//$htmldeta=$htmldeta."<td rowspan=12><table><center><img src='".K_PATHWEB.$thumb_prefix.$imagen[0][ruta]."' ></center></table></td></tr>";
						}else{
						$htmldeta=$htmldeta."<td rowspan=12 width=25% valign='top'><table style='width:75%;'><center><img style='width:280px;height:240px;' src='img/banner/horsegrey.jpg' alt='El ejemplar no tiene imagen' title='El ejemplar no tiene imagen' ></center></table></td><td rowspan=12>
								<table    style=' border-collapse: separate;border-spacing: 10px;width:100%;'>
								<tr><td >&nbsp;<span class='btn btn-default verArbol cursor'  data-item-id='".$detah[$x]['codigo']."' title='ir a ver arbol genealogico.' style='bottom: 12px;' ><img src='img/iconDetails/b_relations.png'>&nbsp;Ver Arbol Geneal&oacute;gico </span></td></tr>
								<tr><td>&nbsp;<span class='btn btn-default verCria cursor'  data-item-id='".$detah[$x]['codigo']."' data-item-genere='".$genero."' data-item-title='1'  title='ir a ver crias del ejemplar' style='bottom: 6px;' ><img src='img/iconDetails/uno.gif' width='20'>&nbsp;Ver Cr&iacute;as</span></td></tr>
								<tr><td>&nbsp;<span class='btn btn-default verImagen cursor'  data-item-id='".$detah[$x]['codigo']."'  data-item-front='1' title='Ver galeria de imagenes del ejemplar.' ><img src='img/iconDetails/foto.png'> Ver Galeria </span></td></tr>
								<tr><td>&nbsp;<span class='btn btn-default verConcurso cursor'  data-item-id='".$detah[$x]['codigo']."'title='ir a ver concursos que participó el ejemplar.' style='top: 5px;' ><img src='img/iconDetails/premio.png' height='15' width='20'> Concursos</span></td></tr>
								";
							/*	$htmldeta=$htmldeta."<tr><td>&nbsp;<span class='verMedida' data-item-ejemplar='".$detah[$x]['prefijo_caballo']."&nbsp;".$detah[$x]['nombre_caballo']."'  
											 data-item-adn='".$detah[$x]['adn_caballo']."'  
											 data-item-chip='".$detah[$x]['microchip_caballo']."'  
											 data-item-id='".$detah[$x]['codigo']."'  
											 data-item-fnac='".$fecha."'  
											 data-item-pa='".$detah[$x]['prefijo_padre_caballo']."&nbsp;".$detah[$x]['nombre_padre_caballo']."'  
											 data-item-ma='".$detah[$x]['prefijo_madre_caballo']."&nbsp;".$detah[$x]['nombre_madre_caballo']."'    
											 title='ver Medida.' style='top: 10px;' ><img src='img/iconDetails/b_search.png'> Ver Medida Hipometricas</span></td></tr>";*/

								$htmldeta=$htmldeta."</table></td></tr>";
						}
						
						$htmldeta=$htmldeta."<tR><TD width=15%><b>Madre </td><td style='width:1%'><img src='img/iconDetails/madre.png' ></td><td colspan=1  width=40%>".$detah[$x]['prefijo_madre_caballo']."&nbsp;".$detah[$x]['nombre_madre_caballo']."&nbsp;- ".$detah[$x]['codigo_madre_caballo']."</td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>Fecha Nacimiento</td><td style='width:1%'><img src='img/iconDetails/nacimiento.png' ></td><td colspan=1>".$fecha."</td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>Lugar de Nacimiento </td><td style='width:1%'><img src='img/iconDetails/lugar.png' ></td><td >".$detah[$x]['lugar_nac_caballo']."</td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>Color</td><td style='width:1%'><img src='img/iconDetails/color.png' ></td><td colspan=1>".$detah[$x]['pelaje_caballo']."</td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>Criador</td><td style='width:1%'><img src='img/iconDetails/criador.png' ></td><td colspan=1>".$detah[$x]['nombre_criador_caballo']."</td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>Propietario</td ><td style='width:1%'><img src='img/iconDetails/propietario.png' ></td><td colspan=1>".$detah[$x]['nombre_propietario_caballo']."</td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>Descripci&oacute;n</td ><td style='width:1%'><img src='img/iconDetails/descripcion.png' ></td><td colspan=1 width=20>".$detah[$x]['descripcion_caballo']."</td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>Microchip</td ><td style='width:1%'><img src='img/iconDetails/microchip.png' ></td><td  >".$detah[$x]['microchip_caballo']."</td></tr>";
						//$htmldeta=$htmldeta."<tR><TD><b>ADN</td ><td colspan=2>".$detah[$x]['adn_caballo']."</td></tr>";
						$htmldeta=$htmldeta."<tR><TD><b>ADN</td ><td style='width:1%'><img src='img/iconDetails/adn.png' ></td><td colspan=1>".$detah[$x]['adn_caballo']."</td></tr>";
						if($detah[$x]['fallecio']=="&nbsp;"){
							$txtestado="(Vivo)";
						}else{
							$txtestado="(Falleci&oacute;)";
						}
						
						$htmldeta=$htmldeta."<tR><TD><b>".TXTESTADOACTUAL."</td><td style='width:1%'></td><td colspan=1 align=left>$txtestado &nbsp;".$detah[$x]['fallecio']."</td></tr>";
						if($detah[$x]['capado']==1){
							$capado="Capado";
							$htmldeta=$htmldeta."<tR><TD><b>Situaci&oacute;n</td ><td style='width:1%'></td><td colspan=1 width=20>".$capado."</td>";
						}
						

						$htmldeta=$htmldeta."<tR><TD colspan=5 height=30></tr>";
				           
 				    $htmldeta=$htmldeta."</table>";
				   }
				   echo $htmldeta;


				   ?>
<script>

	    $(".verImagen").on("click",function(){
		$("#divVerImagen .ui-dialog").dialog("destroy");
		$("#divVerImagen").dialog({
				title:"Galeria de Imagenes de Ejemplares",
				autoOpen:false,
				width:800,
				height:670,modal:true,
				position: {
				            my: 'top', 
				            at: 'top'
				    }
		});
		$("#divVerImagen .ui-dialog-titlebar").hide();
		$("#divVerImagen").dialog("open");
		var idH=$(this).data("item-id");
		listarImagenes(idH,1,'',0);

	}).button();//{icons: {        primary: "ui-icon-image"      } });
 
	$(".verCria").on("click",function(){
			var idH=$(this).data("item-id");
			var gen=$(this).data("item-genere");
			var tit=$(this).data("item-title");
			var url="crias.php?gen="+gen+"&id="+idH+"&title="+tit;
			$("#divVerCrias").dialog("open");
			$("#crias" ).load(url); 
	}).button();//{icons: {        primary: "ui-icon-search"      } });

	$(".verArbol").on("click",function(){
			var idH=$(this).data("item-id");
 		/*	var url="arbolgen.php?id="+idH;
 		    $("#divVerArbol").dialog("open");
 		    $( "#resultadoArbol").html("");
			$( "#resultadoArbol").load(url);

*/
  			$("#divVerArbol").dialog("open");
 		    
				$.ajax({
				data:  {id:idH},
				url:   'arbolgen.php',
				type:  'get',
				beforeSend: function () {
				     $("#resultadoArbol").html(load);
				},
				success:  function (response) {
				    $( "#resultadoArbol").html(response);

				}
			});



	}).button();//{icons: {        primary: "ui-icon-search"      } });

	$(".verConcurso").on("click",function(){
			$("#divVerConcurso").dialog("open");
			var idH=$(this).data("item-id");
			
			$("#gridConcurso").show();
			verConcurso(idH,'view');	
			
			/*$.ajax({
				data:  {idhorse:idH},
				url:   'ajaxConcurso.php',
				type:  'post',
				beforeSend: function () {
				    $("#resultado").html("Procesando, espere por favor...");
				},
				success:  function (response) {
				    $("#resultado").html(response);
				}
			});*/
	}).button();//{icons: {        primary: "ui-icon-search"      } });

$(".verMedida").on("click",function(){
			var idEje=$(this).data("item-id");
			var nom=$(this).data("item-ejemplar");
			var nomMa=$(this).data("item-ma");
			var nomPa=$(this).data("item-pa");

			var chip=$(this).data("item-chip");
			var adn=$(this).data("item-adn");

			var fecna=$(this).data("item-fnac");
			var cria="";
			var periodo=0;	
 
			var randNumber = Math.floor(Math.random()*99);
			var url="admin/RegistroMedHipoPrint.php?idEj="+idEje+"&nom="+nom+"&nma="+nomMa+"&npa="+nomPa+"&chip="+chip+"&adn="+adn+"&ncria="+cria+"&nace="+fecna+"&xx="+randNumber+"&isFront=1&periodoMH=0";
			var ww=window.open(url,'popimpr','width=850,height=600,scrollbars=YES');
			ww.focus();

				}).button();//{icons: {        primary: "ui-icon-search"      } });

 
</script>
