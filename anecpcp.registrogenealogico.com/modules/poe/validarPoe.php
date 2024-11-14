<?
require(DIR_LEVEL_MOD_POE."Funciones/general.php");
if(is_array($datoPoe) && sizeof($datoPoe)>0 && $datoPoe[0][periodo]==""){
  	die("<br><br><br><br><center>No hay Periodo activo para ver los formularios del parte de ocurrencias.</center>");
 	exit();
	}
if(isset($_GET["SetIdPoe"])){
	$_SESSION[VAR_PERIODO_SESION]=$_GET["SetIdPoe"];
}

//echo "session.-...".$_SESSION[VAR_PERIODO_SESION];


$peridoSesion="0";
$modo="Sss";
if(isset($_SESSION[VAR_PERIODO_SESION])) $peridoSesion=$_SESSION[VAR_PERIODO_SESION];

 $periodo="0";
 $varDato=obtenerPoe($peridoSesion,$link);
/*echo "<pre>";print_r($varDato);*/
 if(is_array($varDato) && sizeof($varDato)>0 && $varDato[0][periodo]!=""){
 	$periodo=$varDato[0]["periodo"];
 	$modo=$varDato[0]["modoLectura"];
 	$vigencia=$varDato[0]["vigencia"];
 }else{

 	die("<br><br><br><br><center>El código del Periodo no es válido. No podrá ver los formularios del parte de ocurrencias. Contáctese con el administrador</center><br><br><br><br><br><br><br><br>");
 	exit();
 }
 
echo"<input type='hidden' value='".$periodo."' id='hidAnioPer' />";
echo"<input type='hidden' value='".$periodoActual."' id='hidPeridoActual' />";
echo"<input type='hidden' value='".$modo."' id='hidModoLectura' />";
echo"<input type='hidden' value='".$vigencia."' id='hidVigencia' />";

//echo "<br><br><br><br>xid...".$_SESSION["xid"];
$dato=obtenerIdPropietario($_SESSION["xid"]);
 
///echo "<pre>";print_r($_SESSION);
if($dato==0){
	die("<br><br><br><br><br><br><br><br><br><br><br><br><center><span style='font-weight:bold; font-size:12px';>No puede registrar el parte de ocurrencias del periodo ".$periodo.". El usuario no tiene código del Propietario .<br>Contáctese con el administrador</span></center><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>");
	exit();
}
?>