<?php
require("../Funciones/conectar2.php");
require("../constante.php");



$idHorse=$_POST["idhorse"];
$pagina = $_POST["pagina"];

$alt=$_POST["opc"];
$idImg=$_POST["idImg"];
 
if($alt=='DEL'){
$sqlDel="update imagen set activo=0 WHERE idImagen='".$idImg."' ";
$rsDel=mysql_query($sqlDel,$link)or die(mysql_error($link));
}
if($alt=='MAIN'){
$sqlUpdA="update imagen set esPrincipal=0 WHERE idCaballo='".$idHorse."' ";
$sUpdA=mysql_query($sqlUpdA,$link)or die(mysql_error($link));

$sqlUpd="update imagen set esPrincipal=1 WHERE idImagen='".$idImg."' ";
$rsUpd=mysql_query($sqlUpd,$link)or die(mysql_error($link));
}




//echo $idHorse.'  **********  '.$pagina;
$sql="SELECT  idImagen,idCaballo,ruta,esPrincipal,activo FROM imagen WHERE idCaballo='".$idHorse."' and activo=1";
$rs=mysql_query($sql,$link)or die(mysql_error($link));
$num_total_registros=mysql_num_rows($rs);
$indice=0;
if($num_total_registros>0)
{ 
	$indice=1;
	while($rows=mysqli_fetch_array($rs))
		{
			$colleccion[$indice]=$rows[2];
			$indice++;
		}

}


//Limito la busqueda
$TAMANO_PAGINA = 1;
//examino la página a mostrar y el inicio del registro a mostrar

if (!$pagina) {
   $inicio = 0;
   $pagina = 1;
}
else {
  if($pagina>$num_total_registros)	{ $inicio = 0;    $pagina = 1;}
  else $inicio = ($pagina - 1) * $TAMANO_PAGINA;
}
//calculo el total de páginas
$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);



$shtml="<center><br/><br/><div id='container'>";
$sql2="SELECT  idImagen,idCaballo,ruta,esPrincipal,activo FROM imagen WHERE idCaballo='".$idHorse."' and activo=1   LIMIT ".$inicio."," . $TAMANO_PAGINA;
$rs2 = mysql_query($sql2, $link)or die(mysql_error($link));
$num_total_registros2=mysql_num_rows($rs2);
if($num_total_registros2>0)
{ 
	while($rows=mysqli_fetch_array($rs2))
		{
			$shtml=$shtml."<div id='row' style=' height:500px;'><img src='".K_PATHWEB.$rows[2]."' /></div>";
			$shtmlMenu="<div id='galeriaMenu'  class='tag'><br/>
						&nbsp;Galeria de Imagenes del Ejemplar: ".$rows[1]." &nbsp;  
						<div style='float:right;'>
						&nbsp;<span class=paginador title='Eliminar imagen del ejemplar' onclick=listarImagenes('".$idHorse."',".$pagina.",'DEL',".$rows[0].");>Eliminar</span>&nbsp;|
						&nbsp;<span class=paginador title='Configurar como imagen principal'onclick=listarImagenes('".$idHorse."',".$pagina.",'MAIN',".$rows[0]."); >Principal</span>&nbsp;|
						&nbsp;<span class=paginador title='Cerrar galeria' onclick='cerrarGaleria();'>Cerrar</span> 
						</div>
						</div>";

		}
}else{
$shtmlMenu="<div id='galeriaMenu'  class='tag'><br/>
						&nbsp;Galeria de Imagenes del Ejemplar: ".$rows[1]." &nbsp;  
						<div style='float:right;'>
						&nbsp;<span class=paginador title='Cerrar galeria' onclick='cerrarGaleria();'>Cerrar</span> 
						</div>
						</div>";	
$shtml="<br/><br/><br/><br/><br/><br/><center>No se encontraron imagenes del ejemplar</center>";
}
	$shtml=$shtml."<div id='row'>";
		if ($total_paginas > 1) {
		   //if ($pagina != 1)
		     // $shtml.= '<label class=paginador  title="ver anterior imagen" onclick=listarImagenes("'.$idHorse.'",'.($pagina-1).');><img src="../img/b_prevpage.png" border="0"></label>';
		      for ($i=1;$i<=$total_paginas;$i++) {
		        // if ($pagina == $i)
		            //si muestro el índice de la página actual, no coloco enlace
		        //    $shtml.= "<b><span style='color:darkred;'>".$pagina."</span></b>";
		         //else
		            //si el índice no corresponde con la página mostrada actualmente,
		            //coloco el enlace para ir a esa página
		            $shtml.= '<img src="'.K_PATHWEB."thumb_".$colleccion[$i].'" class=paginador title="ver esta imagen" onclick=listarImagenes("'.$idHorse.'",'.$i.',"",0);  />';//.$i.'</label> &nbsp;&nbsp; ';
		      }
		      //if ($pagina != $total_paginas)
		         //$shtml.= '<label class=paginador title="ver siguiente imagen" onclick=listarImagenes("'.$idHorse.'",'.($pagina+1).');  ><img src="../img/b_nextpage.png" border="0"></label>';
		}
	$shtml.="</div>";
$shtml.="</div></center>";
echo $shtmlMenu.$shtml;

?>

<style>
  #container {
    display: table;
     width: :100%;
    }

  #row  {
    display: table-row;
    }
.paginador{

 cursor: pointer; cursor: hand; 
}
 .tag {

 	color:whitesmoke;
 	  font-weight: bold;
 	height: 40px;
 	width: 80%;
    float: left;
    position: absolute;
    left: 0px;
    top: 0px;

    background-color: gray;
    -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);

}
</style>