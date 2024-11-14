<?php

require("../admin/Funciones/conectar2.php");

//require("../admin/constante.php");



require("../constante.php");



$idHorse = $_POST["idhorse"];

$pagina = $_POST["pagina"];



$alt = $_POST["opc"];

$idImg = $_POST["idImg"];



if ($alt == 'DEL') {

	$sqlDel = "update imagen set activo=0 WHERE idImagen='" . $idImg . "' ";

	$rsDel = mysqli_query($link, $sqlDel) or die(mysqli_error($link));

}

if ($alt == 'MAIN') {

	$sqlUpdA = "update imagen set esPrincipal=0 WHERE idCaballo='" . $idHorse . "' ";

	$sUpdA = mysqli_query($link, $sqlUpdA) or die(mysqli_error($link));



	$sqlUpd = "update imagen set esPrincipal=1 WHERE idImagen='" . $idImg . "' ";

	$rsUpd = mysqli_query($link, $sqlUpd) or die(mysqli_error($link));

}









// echo $idHorse.'  **********  '.$pagina;

$sql = "SELECT  idImagen,idCaballo,ruta,esPrincipal,activo,'1' origen FROM sgev_imagen WHERE idCaballo='" . $idHorse . "' and activo=1" .

	" UNION ALL SELECT  di.idImagen,ei.codEjemplar,di.ruta,di.esPrincipal,di.activo,'2' origen FROM poe_ejemplar_ins ei INNER JOIN documento_ins di ON di.idInscripcion=ei.id WHERE di.esPDF=0 AND ei.codEjemplar='" . $idHorse . "' and di.activo=1";

	

 //	echo $sql;

$rs = mysqli_query($link, $sql) or die(mysqli_error($link));

$num_total_registros = mysqli_num_rows($rs);

$indice = 0;
//echo $sql;
if ($num_total_registros > 0) {

	$indice = 1;

	/*while ($rows = mysqli_fetch_array($rs)) {

		$colleccion[$indice] = $rows[2];

		$indice++;

	}*/
	while ($rows = mysqli_fetch_array($rs)) {
		if ($rows[5] == '1') {
			$pathThumb = K_PATHWEB."thumb_".$rows[2];
		} else {
			$pathThumb = K_PATHWEB_INS_IMG."thumb_".$rows[2];
		}
		//echo "---".$pathThumb;
		$colleccion[$indice] =$pathThumb;// $rows[2];

		$indice++;

	}
}





//Limito la busqueda

$TAMANO_PAGINA = 1;

//examino la página a mostrar y el inicio del registro a mostrar



if (!$pagina) {

	$inicio = 0;

	$pagina = 1;

} else {

	if ($pagina > $num_total_registros) {

		$inicio = 0;

		$pagina = 1;

	} else $inicio = ($pagina - 1) * $TAMANO_PAGINA;

}

//calculo el total de páginas

$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);



/*datos del caballo*/

$shtmltooltip = "";

$sql3 = "SELECT  codigo,prefij,nombre FROM datos220206 WHERE codigo='" . $idHorse . "'";

$rs3 = mysqli_query($link, $sql3) or die(mysqli_error($link));

$num_total_registros3 = mysqli_num_rows($rs3);

if ($num_total_registros3 > 0) {

	while ($rows = mysqli_fetch_array($rs3)) {

		$shtmltooltip = $shtmltooltip . "Codigo: " . $rows[0] . " - Prefijo: " . $rows[1] . "  Nombre del Ejemplar: " . $rows[2] . " ";

		$titulo = " " . $rows[0] . " -  " . $rows[1] . "  " . $rows[2] . " ";

	}

}

/*fin datos del caballo*/

echo "<center><b>Imagenes del ejemplar: $titulo</b></center>";





$shtml = "<center><div id='container'>";

$sql2 = "SELECT  idImagen,idCaballo,ruta,esPrincipal,activo,'1' origen FROM sgev_imagen WHERE idCaballo='" . $idHorse . "' and activo=1 UNION ALL " .

	" SELECT  di.idImagen,ei.codEjemplar,di.ruta,di.esPrincipal,di.activo,'2' origen FROM poe_ejemplar_ins ei INNER JOIN documento_ins di ON di.idInscripcion=ei.id WHERE di.esPDF=0 AND ei.codEjemplar='" . $idHorse . "' AND ei.activo=1  " . "LIMIT " . $inicio . "," . $TAMANO_PAGINA;

$rs2 = mysqli_query($link, $sql2) or die(mysqli_error($link));

$num_total_registros2 = mysqli_num_rows($rs2);

if ($num_total_registros2 > 0) {

	while ($rows = mysqli_fetch_array($rs2)) {

		if ($rows[5] == '1') {

			$shtml = $shtml . "<div id='row' style=' height:500px;'><img src='" . K_PATHWEB . $rows[2] . "'  title='" . $shtmltooltip . "'  class='cursor' width=550 height=500 /></div>";

		} else {

			$shtml = $shtml . "<div id='row' style=' height:500px;'><img src='" . K_PATHWEB_INS_IMG . $rows[2] . "'  title='" . $shtmltooltip . "'  class='cursor' width=550 height=500 /></div>";

		}

	}

} else {

	$shtmlMenu = "<div id='galeriaMenu'  class='tag'><br/>

						&nbsp;Galeria de Imagenes del Ejemplar: " . $rows[1] . " &nbsp;  

						<div style='float:right;'>

						&nbsp;<span class=paginador title='Cerrar galeria' onclick='cerrarGaleria();'>Cerrar</span> 

						</div>

						</div>";

	$shtml = "<br/><br/><br/><br/><br/><br/><center>No se encontraron imagenes del ejemplar</center>";

}

$shtml = $shtml . "<div id='row'>";

if ($total_paginas > 1) {

	//if ($pagina != 1)

	// $shtml.= '<label class=paginador  title="ver anterior imagen" onclick=listarImagenes("'.$idHorse.'",'.($pagina-1).');><img src="../img/b_prevpage.png" border="0"></label>';

	for ($i = 1; $i <= $total_paginas; $i++) {

		// if ($pagina == $i)

		//si muestro el índice de la página actual, no coloco enlace

		//    $shtml.= "<b><span style='color:darkred;'>".$pagina."</span></b>";

		//else

		//si el índice no corresponde con la página mostrada actualmente,

		//coloco el enlace para ir a esa página

		$shtml .= '<img src="' . $colleccion[$i] . '" class=paginador title="ver esta imagen" onclick=listarImagenes("' . $idHorse . '",' . $i . ',"",0);  />'; //.$i.'</label> &nbsp;&nbsp; ';

	}

	//if ($pagina != $total_paginas)

	//$shtml.= '<label class=paginador title="ver siguiente imagen" onclick=listarImagenes("'.$idHorse.'",'.($pagina+1).');  ><img src="../img/b_nextpage.png" border="0"></label>';

}

$shtml .= "</div>";

$shtml .= "</div></center>";

echo  $shtml;

