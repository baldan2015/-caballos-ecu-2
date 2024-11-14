<?php session_start();

require("../Clases/conexion.php");
require("../Clases/resultado.php");
//	require("../Funciones/general.php");

$cn = new Connection();
$link = $cn->Conectar();

$retorno = new Resultado();

if (isset($_POST['opc'])) {

	if ($_POST['opc'] == 'lst') {
		$idPoe = $_POST['idPoe'];
		$idUser = $_POST['idProp'];
		//$idProp= obtenerIdPropietario( $idUser);
		//echo listarMovimiento($link,$idPoe,$idUser,$idProp);
	} else
		if ($_POST['opc'] == 'get') {
		$id = $_POST['idhorse'];
		echo obtieneConcursoResultado($link, $id);
	} else if ($_POST["opc"] == "insert") {
		if (validarUsuarios($retorno)->result == 1) {
			foreach ($_SESSION["usuarios"] as $datos) {
				if ($datos->flgTipo == 'A') {
					$idUsuarioActual = $datos->id;
					$nombreUsuarioActual = $datos->razonSocial;
				}
			}
			echo insertarConcurso($link, $_POST["concurso"], $_POST["idEjemplar"], $_POST["numPuesto"], $nombreUsuarioActual, $_POST["grupo"], $_POST["categoria"], $_POST["idProp"],$idUsuarioActual);
		} else {
			echo json_encode($retorno);
		}
	} elseif ($_POST["opc"] == "delete") {
		if (validarUsuarios($retorno)->result == 1) {
			foreach ($_SESSION["usuarios"] as $datos) {
				if ($datos->flgTipo == 'A') {
					$idUsuarioActual = $datos->id;
				}
			}
			echo deleteConcurso($link, $_POST["id"],$idUsuarioActual);
		} else {
			echo json_encode($retorno);
		}
	} elseif($_POST["opc"]=='datosConcurso'){
		$id=$_POST["id"];
		echo datosConcurso($link,$id);
	}
}

function obtieneConcursoResultado($link, $id)
{
	$sql = "CALL SGESS_RESULTADOS_CONCURSO_EJEMPLAR('$id');";
	$result = mysqli_query($link, $sql);
	$i = 1;
	//echo $sql;
	if($result){
		while ($rows = mysqli_fetch_array($result)) {
			$concurso[] = array(
				'numero' => $i,
				'id' => $rows[0],
				'concurso' => $rows[1],
				'fecha' => $rows[2],
				'juez' => $rows[3],
				'categoria' => $rows[4],
				'grupo' => $rows[5],
				'puesto' => $rows[6]
			);
			++$i;
		}
	}else{
		$concurso='';
	}
	
	mysqli_free_result($result);

	return json_encode($concurso);
}

function insertarConcurso($link, $concurso, $idEjemplar, $numPuesto, $propietario, $grupo, $categoria, $idProp,$usuario)
{
	$sql = "CALL SGESI_RESULTADO_CONCURSO_EJEMPLAR($concurso,'$idEjemplar',$numPuesto,'$propietario','$grupo','$categoria',$idProp,$usuario);";
	//echo $sql;
	$validacion = 1;
	if ($concurso == 0 || $idEjemplar == '' || $numPuesto == '' || $numPuesto == 0 || $grupo == '' || $categoria == '' ) {
		$validacion = 0;
		$mensaje = 'Campos Requeridos: ';
		if ($concurso == 0) {
			$mensaje .= ' <br> Nombre del Concurso. ';
		}
		if ($numPuesto == '' || $numPuesto == 0) {
			$mensaje .= ' <br> Puesto obtenido. ';
		}
		if ($grupo == '') {
			$mensaje .= ' <br> Grupo. ';
		}
		if ($categoria == '') {
			$mensaje .= ' <br> Categoria. ';
		}
	} else {
		$validacion = 1;
	}

	$retorno = new Resultado();

	if ($validacion == 1) {
		$result = mysqli_query($link, $sql);

		if ($fila = mysqli_fetch_array($result)) {
			if($fila[0]==1){
				$retorno->result = $fila[0];
				$retorno->message = "Se registro correctamente.";
			}else if($fila[0]==2){
				$retorno->result = $fila[0];
				$retorno->message = "Ya existe el resultado del concurso.";
			}else{
				$retorno->result = $fila[0];
				$retorno->message = "No se pudo registrar el resultado del concurso.";
			}
			
		} else {
			$retorno->result = 0;
			$retorno->message = "No se pudo registrar el resultado del concurso.";
		}
		mysqli_free_result($result);
	} else {
		$retorno->result = 0;
		$retorno->message = $mensaje;
	}


	return json_encode($retorno);
}

function deleteConcurso($link, $id,$usuario)
{
	$sql = "CALL SGESD_RESULTADOS_CONCURSO_X_ID($id,$usuario);";
	$result = mysqli_query($link, $sql);
	$retorno = new Resultado();
	if ($fila = mysqli_fetch_array($result)) {
		$retorno->result = $fila[0];
		$retorno->message = "Se elimino correctamente.";
	} else {
		$retorno->result = 0;
		$retorno->message = "No se pudo eliminar el resultado del concurso.";
	}
	mysqli_free_result($result);

	return json_encode($retorno);
}

function datosConcurso($link,$id){
	$sql = "CALL SGESS_CONCURSO_X_ID($id);";
	$result = mysqli_query($link, $sql);

	if($result){
		while ($rows = mysqli_fetch_array($result)) {
			$concurso[] = array(
				'idConcurso' => $rows[0],
				'nombre' => $rows[1],
				'fecha' => $rows[2],
				'juez' => $rows[3],
				'activo' => $rows[4]
			);
		}
	}else{
		$concurso=[];
	}
	mysqli_free_result($result);
	return json_encode($concurso);
}

function validarUsuarios($retorno)
{
	if (!(isset($_SESSION["usuarios"]))) {
		$retorno->result = -1;
		$retorno->message = "La sesión ha finalizado";
		$retorno->isRedirect = 1;
		$retorno->redirectUrl = 'http://localhost/ancpcpp-ecu/sge.ec/';
	} else {
		$retorno->result = 1;
		$retorno->message = "La sesión está activa";
	}
	return $retorno;
}
?>