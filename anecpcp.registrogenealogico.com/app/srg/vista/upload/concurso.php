<?php
//require("../Funciones/conectar.php");
	class objetos{
		public $idConcurso;
		public $nombreConcurso;
		public $fechaConcurso;
		public $juezConcurso;
		public $activoConcurso;
		public $tarifaConcurso;
		
		public $idCategoria;
		public $nombreCategoria;
		public $activoCategoria;
		public $generoCategoria;
		public $premioCategoria;
		public $fechaDesde;
		public $fechaHasta;
		
		public $idGrupo;
		public $nombreGrupo;
		public $activoGrupo;
	}
	require("../Clases/conexion.php");
	$cn=new Connection();
	$link=$cn->Conectar();

	if(isset($_POST['opc'])){
		if($_POST['opc'] == 'listarConcurso'){
			echo listarConcurso($link);
		}elseif($_POST['opc'] == 'obtenerConcurso'){
			$idConcurso = $_POST['idConcurso'];
			echo obtenerConcurso($idConcurso,$link);
		}elseif($_POST['opc'] == 'grabarConcurso'){
			$nombre = $_POST['nombre'];
			$fecha = $_POST['fecha'];
			$juez = $_POST['juez'];
			$tarifa=$_POST['tarifa'];
			$estado = $_POST['estado'];
			echo grabarConcurso($nombre,$fecha,$juez,$tarifa,$estado,$link);
		}elseif($_POST['opc'] == 'editarConcurso'){
			$idConcurso = $_POST['idConcurso'];
			$nombre = $_POST['nombre'];
			$fecha = $_POST['fecha'];
			$juez = $_POST['juez'];
			$tarifa=$_POST['tarifa'];
			$estado = $_POST['estado'];
			echo editarConcurso($idConcurso,$nombre,$fecha,$juez,$tarifa,$estado,$link);
		}elseif($_POST['opc'] == 'grabarCategoria'){
			$idCategoria = $_POST['idCategoria'];
			$idConcurso = $_POST['idConcurso'];
			$nombre = $_POST['nombre'];
			$estado = $_POST['estado'];
			$genero=$_POST['genero'];
			$esPremio=$_POST['esPremio'];
			$desde=$_POST['desde'];
			$hasta=$_POST['hasta'];
			echo grabarCategoria($idConcurso,$nombre,$estado,$genero,$esPremio,$desde,$hasta,$link);
		}elseif($_POST['opc'] == 'editarCategoria'){
			$idCategoria = $_POST['idCategoria'];
			$idConcurso = $_POST['idConcurso'];
			$nombre = $_POST['nombre'];
			$estado = $_POST['estado'];
			$genero=$_POST['genero'];
			$esPremio=$_POST['esPremio'];
			$desde=$_POST['desde'];
			$hasta=$_POST['hasta'];
			echo editarCategoria($idCategoria,$idConcurso,$nombre,$estado,$genero,$esPremio,$desde,$hasta,$link);
		}elseif($_POST['opc'] == 'listarCategoria'){
			$idConcurso = $_POST['idConcurso'];
			echo listarCategoria($idConcurso,$link);
		}elseif($_POST['opc'] == 'obtenerCategoria'){
			$idCategoria = $_POST['idCategoria'];
			echo obtenerCategoria($idCategoria,$link);
		}elseif($_POST['opc'] == 'listarGrupo'){
			$idCategoria = $_POST['idCategoria'];
			echo listarGrupo($idCategoria,$link);
		}elseif($_POST['opc'] == 'grabarGrupo'){
			$idCategoria = $_POST['idCategoria'];
			$nombre = $_POST['nombre'];
			$estado = $_POST['estado'];
			echo grabarGrupo($idCategoria,$nombre,$estado,$link);
		}elseif($_POST['opc'] == 'editarGrupo'){
			$idCategoria = $_POST['idCategoria'];
			$idGrupo = $_POST['idGrupo'];
			$nombre = $_POST['nombre'];
			$estado = $_POST['estado'];
			echo editarGrupo($idGrupo,$idCategoria,$nombre,$estado,$link);
		}elseif($_POST['opc'] == 'obtenerGrupo'){
			$idGrupo = $_POST['idGrupo'];
			echo obtenerGrupo($idGrupo,$link);
		}elseif($_POST['opc'] == 'eliminarConcurso'){
			$idConcurso = $_POST['idConcurso'];
			$valor = $_POST['valor'];
			echo eliminarConcurso($idConcurso,$valor,$link);
		}elseif($_POST['opc'] == 'eliminarCategoria'){
			$idCategoria = $_POST['idCategoria'];
			$valor = $_POST['valor'];
			echo eliminarCategoria($idCategoria,$valor,$link);
		}elseif($_POST['opc'] == 'eliminarGrupo'){
			$idGrupo = $_POST['idGrupo'];
			$valor = $_POST['valor'];
			echo eliminarGrupo($idGrupo,$valor,$link);
		}
	}
	function eliminarGrupo($idGrupo,$valor,$link){
		$activo = $valor == 0 ? 1 : 0;
		$sql = "update grupo set activo = ".$activo." where idGrupo = ".$idGrupo;
		$result = mysqli_query($link,$sql);
		if($result){
			return true;
		}else{
			return false;
		}
	}
	function eliminarCategoria($idCategoria,$valor,$link){
		$activo = $valor == 0 ? 1 : 0;
		$sql = "update categoria set activo = ".$activo." where idCatego = ".$idCategoria;
		//echo $sql;
		$result = mysqli_query($link,$sql);
		if($result){
			return true;
		}else{
			return false;
		}
	}
	function eliminarConcurso($idConcurso,$valor,$link){
		$activo = $valor == 0 ? 1 : 0;
		$sql = "update concurso set activo = ".$activo." where idConcurso = ".$idConcurso;
		$result = mysqli_query($link,$sql);
		if($result){
			return true;
		}else{
			return false;
		}
	}
	function editarGrupo($idGrupo,$idCategoria,$nombre,$estado,$link){
		$sql = "update grupo set nombre = '".$nombre."',activo=".$estado." where idGrupo = ".$idGrupo." and idCatego = ".$idCategoria;
		$result = mysqli_query($link,$sql);
		if($result){
			return true;
		}else{
			return false;
		}
	}
	function grabarGrupo($idCategoria,$nombre,$estado,$link){
		$sql = "insert into grupo(idCatego,nombre,activo) values (".$idCategoria.",'".$nombre."',".$estado.")";
		$result = mysqli_query($link,$sql);
		if($result){
			return true;
		}else{
			return false;
		}
	}
	function editarCategoria($idCategoria,$idConcurso,$nombre,$estado,$genero,$esPremio,$desde,$hasta,$link){
		$sql = "update categoria set nombre = '".$nombre."',activo=".$estado." , genero='".$genero."', esPremio=".$esPremio.", desde='".$desde."', hasta='".$hasta."' where idCatego = ".$idCategoria." and idConcurso = ".$idConcurso;
		// echo $sql;
		$result = mysqli_query($link,$sql);
		if($result){
			return true;
		}else{
			return false;
		}
	}
	function grabarCategoria($idConcurso,$nombre,$estado,$genero,$esPremio,$desde,$hasta,$link){
		$sql = "insert into categoria(idConcurso,nombre,activo,genero,esPremio,desde,hasta) values ('".$idConcurso."','".$nombre."',".$estado.",'".$genero."','".$esPremio."','".$desde."','".$hasta."')";
		//echo $sql;
		$result = mysqli_query($link,$sql);
		if($result){
			return true;
		}else{
			return false;
		}
	}
	function editarConcurso($idConcurso,$nombre,$fecha,$juez,$tarifa,$estado,$link){
		$sql = "update concurso set nombre = '".$nombre."',fecha = '".$fecha."',juez='".$juez."',tarifa='".$tarifa."',activo=".$estado." where idConcurso = ".$idConcurso;
		$result = mysqli_query($link,$sql);
		if($result){
			return true;
		}else{
			return false;
		}
	}
	function grabarConcurso($nombre,$fecha,$juez,$tarifa,$estado,$link){
		$sql = "insert into concurso(nombre,fecha,juez,tarifa,activo) values ('".$nombre."','".$fecha."','".$juez."','".$tarifa."',".$estado.")";
		$result = mysqli_query($link,$sql);
		if($result){
			return true;
		}else{
			return false;
		}
	}
	function obtenerGrupo($idGrupo,$link){
		$sql = "select idGrupo,idCatego,nombre,activo from grupo where idGrupo = ".$idGrupo;
		$result = mysqli_query($link,$sql);
		$obj = new objetos();
		while($res = mysqli_fetch_array($result)){
			$obj->idCategoria = $res['idCatego'];
			$obj->idGrupo = $res['idGrupo'];
			$obj->nombreGrupo = $res['nombre'];
			$obj->activoGrupo = $res['activo']; 
		}
		return json_encode($obj);
	}
	function obtenerCategoria($idCategoria,$link){
		$sql = "select idCatego,idConcurso,nombre,activo,genero,esPremio,DATE_FORMAT(desde,'%d/%m/%Y') as desde,DATE_FORMAT(hasta,'%d/%m/%Y') as hasta from categoria where idCatego = ".$idCategoria;
		$result = mysqli_query($link,$sql);
		$obj = new objetos();
		while($res = mysqli_fetch_array($result)){
			$obj->idCategoria = $res['idCatego'];
			$obj->idConcurso = $res['idConcurso'];
			$obj->nombreCategoria = $res['nombre'];
			$obj->activoCategoria = $res['activo'];
			$obj->generoCategoria=$res['genero'];
		    $obj->premioCategoria=$res['esPremio'];
			$obj->fechaDesde=$res['desde'];
			$obj->fechaHasta=$res['hasta'];
		}
		return json_encode($obj);
	}
	function obtenerConcurso($idConcurso,$link){
		$sql = "select idConcurso,nombre,DATE_FORMAT(fecha,'%d/%m/%Y') as fecha,juez,activo,tarifa from concurso where idConcurso = ".$idConcurso;
		$result = mysqli_query($link,$sql);
		if($res = mysql_fetch_object($result)){
			$obj = new objetos();
			$obj->idConcurso = $res->idConcurso;
			$obj->nombreConcurso = $res->nombre;
			$obj->fechaConcurso = $res->fecha;
			$obj->juezConcurso = $res->juez;
			$obj->activoConcurso = $res->activo;
			$obj->tarifaConcurso=$res->tarifa;
		}
		return json_encode($obj);
	}
	function listarGrupo($idCategoria,$link){
		$html = "";
		$html.= "<table style='width:90%;' border=0>";
		$html.= "<thead>";
		// $html.= "<tr>";
		// $html.= "<th>NOMBRE</th>";
		// $html.= "<th>SITUACIÓN</th>";
		// $html.= "<th>ACCIÓN</th>";
		// $html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody>";
		$sql = "select idGrupo,idCatego,nombre,activo from grupo where idCatego = ".$idCategoria;
		$result = mysqli_query($link,$sql);
		while($res = mysqli_fetch_array($result)){
			if($res['activo'] == 0 ){
				$activo = "Inactivo";
				$cl = "icon-loop2 boton";
				$tl = "Habilitar grupo";
			}else{
				$activo = "Activo";
				$cl = "icon-bin boton";
				$tl = "Eliminar grupo";
			}
			$html.= "<tr>";
			$html.= "<td>".$res['nombre']."</td>";
			$html.= "<td align='center'>".$activo."</td>";
			$html.= "<td align='center'>";
			$html.= "<span class='icon-pen-alt-fill boton' onclick='return obtenerGrupo(".$res['idGrupo'].");' title='Editar grupo'></span>&nbsp;&nbsp;";
			$html.= "<span class='".$cl."' onclick='return eliminarGrupo(".$res['idGrupo'].",".$res['activo'].",".$res['idCatego'].");' title='".$tl."'></span>&nbsp;&nbsp;";
			$html.= "</td>";
			$html.= "</tr>";
		}
		mysqli_free_result($result);
		$html.= "</tbody>";
		$html.= "</table>";
		return $html;
	}
	function listarCategoria($idConcurso,$link){
		$html = "";
		$html.= "<table style='width:90%;' border=0>";
		$html.= "<thead>";
		$html.= "<tr>";
		// $html.= "<th></th>";
		// $html.= "<th>NOMBRE</th>";
		// $html.= "<th>SITUACIÓN</th>";
		// $html.= "<th>ACCIÓN</th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody>";
		$sql = "select idCatego,idConcurso,nombre,genero,desde,hasta,esPremio,activo from categoria where idConcurso = ".$idConcurso;
		$result = mysql_query($sql,$link)or die("error  ..  ".$sql );
		while($res = mysqli_fetch_array($result)){
			if($res['activo'] == 0 ){
				$activo = "Inactivo";
				$cl = "icon-loop2 boton";
				$tl = "Habilitar categoria";
			}else{
				$activo = "Activo";
				$cl = "icon-bin boton";
				$tl = "Eliminar categoria";
			}
			$html.= "<tr>";
			$html.= "<td align='center'>";
			$html.= "<span class='icon-plus-alt boton' onclick='return masGrupo(".$res['idCatego'].");' id='btnMasGrupo_".$res['idCatego']."'></span>";
			$html.= "<span class='icon-minus-alt boton' onclick='return menosGrupo(".$res['idCatego'].");' id='btnMenosGrupo_".$res['idCatego']."' style='display:none;color:#0047b3;'></span>";
			$html.= "</td>";
			$html.= "<td>".$res['nombre']."</td>";
			$html.= "<td>".$res['genero']."</td>";
			$html.= "<td>".$res['desde']."</td>";
			$html.= "<td>".$res['hasta']."</td>";
			$html.= "<td>".$res['esPremio']."</td>";
			$html.= "<td align='center'>".$activo."</td>";
			$html.= "<td align='center'>";
			$html.= "<span class='icon-pen-alt-fill boton' onclick='return obtenerCategoria(".$res['idCatego'].");' style='cursor:pointer;' title='Editar Categoria' ></span>&nbsp;&nbsp;";
			$html.= "<span class='icon-file boton' onclick='return agregarGrupo(".$res['idCatego'].");' style='cursor:pointer;' title='Agregar Grupo' ></span>&nbsp;&nbsp;";
			$html.= "<span class='".$cl."' onclick='return eliminarCategoria(".$res['idCatego'].",".$res['activo'].",".$res['idConcurso'].");' style='cursor:pointer;' title='".$tl."' ></span>";
			$html.= "</td>";
			$html.= "</tr>";
			$html.= "<tr><td colspan='4' align='right'><div id='divGrupo_".$res['idCatego']."'></div></td></tr>";
		}
		mysqli_free_result($result);
		$html.= "</tbody>";
		$html.= "</table>";
		return $html;
	}
	function listarConcurso($link){

		$html = "";
		$html.= "<table style='width:100%;border-collapse:collapse;' border=1 >";
		$html.= "<thead>";
		$html.= "<tr>";
		$html.= "<th></th>";
		$html.= "<th>NOMBRE</th>";
		$html.= "<th>FECHA</th>";
		$html.= "<th>JUEZ</th>";
		$html.= "<th>TARIFA</th>";
		$html.= "<th>SITUACIÓN</th>";
		$html.= "<th>ACCIÓN</th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody>";
		$sql = "select idConcurso,nombre,DATE_FORMAT(fecha,'%d/%m/%Y') as fecha,juez,tarifa,activo  from concurso";
		$result = mysqli_query($link,$sql);
		while($res = mysqli_fetch_array($result)){
			if($res['activo'] == 0 ){
				$activo = "Inactivo";
				$cl = "icon-loop2 boton";
				$tl = "Habilitar concurso";
			}else{
				$activo = "Activo";
				$cl = "icon-bin boton";
				$tl = "Eliminar concurso";
			}
			$html.= "<tr id='tbConcurso_".$res['idConcurso']."'>";
			$html.= "<td align='center'>";
			$html.= "<span class='icon-plus-alt boton' onclick='return masCategoria(".$res['idConcurso'].");' id='btnMasCatego_".$res['idConcurso']."' ></span>";
			$html.= "<span class='icon-minus-alt boton' onclick='return menosCategoria(".$res['idConcurso'].");' id='btnMenosCatego_".$res['idConcurso']."' style='display:none;color:#0047b3;'></span>";
			$html.= "</td>";
			$html.= "<td>".$res['nombre']."</td>";
			$html.= "<td align='center'>".$res['fecha']."</td>";
			$html.= "<td align='center'>".$res['juez']."</td>";
			$html.= "<td align='center'>".$res['tarifa']."</td>";
			$html.= "<td align='center'>".$activo."</td>";
			$html.= "<td align='center'>";
			$html.= "<span class='icon-pen-alt-fill boton' onclick='return obtenerConcurso(".$res['idConcurso'].");' title='Editar Concurso' style='cursor:pointer;'></span>&nbsp;";
			$html.= "<span class='icon-file boton' onclick='return agregarCategoria(".$res['idConcurso'].");' title='Agregar Categoria' style='cursor:pointer;'></span>&nbsp;";
			$html.= "<span class='".$cl."' onclick='return eliminarConcurso(".$res['idConcurso'].",".$res['activo'].");' title='".$tl."'></span>";
			$html.= "</td>";
			$html.= "</tr>";
			$html.= "<tr><td colspan='6'><div id='divCategoria_".$res['idConcurso']."'></div></td></tr>";
		}
		mysqli_free_result($result);
		$html.= "</tbody>";
		$html.= "</table>";
		return $html;
	}
?>