<?php session_start();
	
	require("../Clases/conexion.php");
	require("../Clases/resultado.php");
//	require("../Funciones/general.php");

	$cn=new Connection();
	$link=$cn->Conectar();

	$retorno=new Resultado();

	if(isset($_POST['opc'])){

		if($_POST['opc'] == 'lst'){
			$idPoe = $_POST['idPoe'];
			$idUser = $_POST['idProp'];
	 		//$idProp= obtenerIdPropietario( $idUser);
			//echo listarMovimiento($link,$idPoe,$idUser,$idProp);
		}
		if($_POST['opc'] == 'get'){
			$id = $_POST['idCon'];
			echo obtieneConcurso($link,$id);
		}
	}

	function obtieneConcurso($link,$id)
	{
		$sql ="SELECT idConcurso,nombre,fecha,juez,activo,tarifa FROM concurso WHERE idConcurso=$id";
		$result = mysqli_query($link,$sql);

		if($res = mysqli_fetch_array($result)){
			$concurso= array(
				'nombre' =>$res['nombre'],
				'fecha' =>$res['fecha'],
				'juez' =>$res['juez'],
				'activo' =>$res['activo'],
				'tarifa' =>$res['tarifa']
				 );
		}
	 	mysqli_free_result($result);
		 
		return json_encode($concurso);
	}	


?>