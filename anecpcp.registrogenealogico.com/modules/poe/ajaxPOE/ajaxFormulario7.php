<?php session_start();
	require("../../../constante.php");
	require(DIR_LEVEL_MOD_POE."Clases/conexion.php");
	require(DIR_LEVEL_MOD_POE."Clases/resultado.php");
	require(DIR_LEVEL_MOD_POE."Funciones/general.php");
	date_default_timezone_set("UTC");
	$cn=new Connection();
	$link=$cn->Conectar();
	$retorno=new Resultado();

	if(isset($_POST['opc'])){
		if($_POST['opc'] == 'lst'){
			$idPoe = $_POST['idPoe'];
			$idUser =$_POST['idProp'];
			$idProp= obtenerIdPropietario( $idUser);
			echo listarEjemplares($link,$idPoe,$idUser,$idProp);

		}elseif($_POST['opc'] == 'insF'){

				$a=$_SESSION['_periodoPoe'];
				$b=$_SESSION['xid'];
				 if(!(EnvioForm($link,$a,$b))){

 			 $idUser = $_POST['idUser'];
			 $datos = $_POST['data'];
			 $idPoe = $_POST['idPoe'];

			 ///obtner el id del prop con el id del userlogeado.
			  $idProp= obtenerIdPropietario( $idUser);
			 //$datosDecode = json_decode('"' . $datos . '"');
        	  $historial = json_decode($datos);
        	//$historial = json_decode($datos);
			 //print_r($historial);
			if(is_array($historial) &&  sizeof($historial)>0){
				$msgValidate="";//validarObligatorios($historial);
				if($msgValidate==""){
						if(true){//!existeRepetidos($historial)){
						 	$result=insertarhistorialF($idPoe,$idUser,$idProp ,$historial,$link);
						 	$retorno->result=1;
						 	//$retorno->html=listarprestamo($link,$idPoe,$idUser);
						 	$retorno->message="Registros de fallecimientos actualizado.";
						 }else{
						 	$retorno->result=2;
						 	$retorno->message="Existen prestamos duplicados. No pueden existir prestamos con tipo, ejemplar y fecha iguales.";
						 }
				}else{
					$retorno->result=0;
				 	$retorno->message=$msgValidate;
				}

			}else{

				$retorno->result=0;
				$retorno->message="No hay items para registrar";
			}
 		}else{
		  	$retorno->result=2;
			$retorno->message="Los Formularios ya fueron enviados. No se puede grabar.";
 		 }
			echo json_encode($retorno);
			 
 		
 		}elseif($_POST['opc'] == 'insC'){

				$a=$_SESSION['_periodoPoe'];
				$b=$_SESSION['xid'];
				 if(!(EnvioForm($link,$a,$b))){

 			 $idUser = $_POST['idUser'];
			 $datos = $_POST['data'];
			 $idPoe = $_POST['idPoe'];

			 ///obtner el id del prop con el id del userlogeado.
			  $idProp= obtenerIdPropietario( $idUser);
			 //$datosDecode = json_decode('"' . $datos . '"');
        	  $historial = json_decode($datos);
        	//$historial = json_decode($datos);
			 //print_r($historial);
			if(is_array($historial) &&  sizeof($historial)>0){
				$msgValidate="";//validarObligatorios($historial);
				if($msgValidate==""){
						if(true){//!existeRepetidos($historial)){
						 	$result=insertarhistorialC($idPoe,$idUser,$idProp ,$historial,$link);
						 	$retorno->result=1;
						 	//$retorno->html=listarprestamo($link,$idPoe,$idUser);
						 	$retorno->message="Registros de castraciones actualizado";
						 }else{
						 	$retorno->result=2;
						 	$retorno->message="Existen prestamos duplicados. No pueden existir prestamos con tipo, ejemplar y fecha iguales.";
						 }
				}else{
					$retorno->result=0;
				 	$retorno->message=$msgValidate;
				}

			}else{

				$retorno->result=0;
				$retorno->message="No hay items para registrar";
			}
 		}else{
		  	$retorno->result=2;
			$retorno->message="Los Formularios ya fueron enviados. No se puede grabar.";
 		 }
			echo json_encode($retorno);
			 
		}elseif($_POST['opc'] == 'del'){
			
			$id = $_POST['id'];
		 
			if(eliminar($id,$link)){
					$retorno->result=1;
					$retorno->message="Eliminado correctamente";
			}else{
					$retorno->result=0;
					$retorno->message="Ocurrió un error al eliminar";
			}
			echo json_encode($retorno);

		}else if($_POST['opc'] == 'lstHistorialF'){
			$idPoe = $_POST['idPoe'];
			$idUser =$_POST['idProp'];
			$idProp= obtenerIdPropietario( $idUser);
			$tipo=$_POST['tipo'];
			echo listarHistorialF($link,$idPoe,$idProp,$tipo);

		}else if($_POST['opc'] == 'lstHistorialC'){
			$idPoe = $_POST['idPoe'];
			$idUser =$_POST['idProp'];
			$idProp= obtenerIdPropietario( $idUser);
			$tipo=$_POST['tipo'];
			echo listarHistorialC($link,$idPoe,$idProp,$tipo);

		}

			if($_POST['opc'] == 'lstView'){
 			$idPoe = $_POST['idPoe'];
			$idProp = $_POST['idProp'];
			$tipo = $_POST['tipo'];
			echo listarHtmlAdmin($link,$idPoe,$idProp,$tipo);
		}
		if($_POST['opc'] == 'lstPotros'){
			$idPoe = $_POST['idPoe'];
			$idUser =$_POST['idProp'];
			$idProp= obtenerIdPropietario( $idUser);
			echo listarMisPotros($link,$idPoe,$idUser,$idProp);

		}
		if($_POST['opc'] == 'valCastrado'){
			$idPoe = $_POST['idPoe'];
			$idUser =$_POST['idUser'];
			$idEjemplar =$_POST['codEjemplar'];
			echo ValidarCastrado($idEjemplar,$idPoe,$idUser,$link);
		}
		 
	}
	 
	function listarEjemplares($link,$idPoe,$idUser,$idProp){
		
		
		$finalizo=EnvioForm($link,$idPoe,$idUser);


		$html = "";
		$html.= "<table class='gridHtml  table table-striped'  >";
		$html.= "<thead style='background:#dff0d8;' >";
		$html.= "<tr>";
		$html.= "<th >Mis Ejemplares</th>";
		$html.= "<th style='height:35px; width:100px;'>...</th>";
	//	$html.= "<th style='height:35px; width:100px;'>...</th>";
//		$html.= "<th style='height:35px;'>...</th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		
 
		$sql = "select e.prefijo,e.nombre,e.id codigo,pl.idPropietario from sge_ejemplar e
						inner join sge_propietariolog pl on e.id=pl.idEjemplar
						where pl.fecFin is null and
						pl.idPropietario ='".$idProp."' 
						and not exists(select 1 from poe_historial h where h.codEjemplar=e.id and h.tipo='FA');";	
			
		
	  //echo $sql;
		$result = mysqli_query($link,$sql);
		$fila=1;
		$bgcolor="";
		while($res = mysqli_fetch_array($result)){

			

			$nombreEjem=$res['prefijo']."  ".($res['nombre'])." - ".$res['codigo']; 
			$html.= "<tr id='tbprestamo_".$res['codigo']."' >";
 			$html.= "<td align='left'  ".$bgcolor."><label  id='txtHorse_".$fila."' >".$nombreEjem."</label><input type='hidden' class='cssItem'  id='hidHorse_".$fila."' value='".$res['codigo']."'></td>";
			$html.= "<td align='left'  ".$bgcolor.">
						<label title='Agregar a lista de Fallecidos.' alt='Agregar a lista de Fallecidos.' class='btnFall btn btn-default btn-sm' data-key=".$res['codigo']."  data-label='".$nombreEjem."'  data-fin=".$finalizo."  >Falleció</label> 
					 </td>";

			$fila++;
				}
	 	mysqli_free_result($result);
		$html.= "</tbody>";
		$html.= "<tfoot><tr><td colspan=4 style='height:30px; '><b>Total ejemplares: ".($fila-1)."<b></td><tr></tfoot>";
		$html.= "</table>";
		return $html;
	}

	function listarHistorialF($link,$idPoe,$idProp,$tipo){

			$finalizo=EnvioForm($link,$idPoe,$_SESSION['xid']);

		$titulo="";
		if($tipo=="AB"){
			$titulo="Ejemplares que abortaron";$cssGrid="gridHtml ";
			$tituloFoot="con abortos";
		}
		if($tipo=="FA"){
			$titulo="Ejemplares Fallecidos";$cssGrid="gridHtmlFallecido  table table-striped";
			$tituloFoot="fallecidos";
		}


		$html = "";
		$html.= "<table class='".$cssGrid."'   >";
		$html.= "<thead  style='background:#dff0d8;'>";
		$html.= "<tr>";
		$html.= "<th style='width:65%;'>".$titulo."</th>";
		$html.= "<th style='height:35px;'>Fecha</th>";
		$html.= "<th style='height:35px;'>...</th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		

		$sql = " SELECT h.id, h.codEjemplar as codigo,
				ifnull(d.prefijo ,p.prefijo) AS prefijo,
				ifnull(d.nombre ,p.nombre) as ejemplar,
				h.fecha
				FROM poe_historial h 
				left join sge_ejemplar d on(d.id  =h.codEjemplar) 
				left join poe_propiedad p on(h.codEjemplar=p.codEjemplar and p.idProp =  '".$idProp."' and p.idPoe =  '".$idPoe."' ) 
				WHERE   
				h.idProp =  '".$idProp."' and h.idPoe =  '".$idPoe."' and 
				h.tipo =  '".$tipo."'  
 				order by  ejemplar
				";
		 //echo $sql;
		$bgcolor="";// style=' background:#F5DA81; ' ";
		$result = mysqli_query($link,$sql);
		$fila=1;
		//echo "<pre>";print_r($_SESSION);
		//echo $sql;
		while($res = mysqli_fetch_array($result)){
			 
				$botonHtml="<label class='btnDel btn btn-default btn-sm glyphicon glyphicon-trash' data-key=".$res['id']." data-fin=".$finalizo."></label> ";
					//if($finalizo==true){ 				$botonHtml="";			}

			$html.= "<tr ".$bgcolor."> ";
 			$html.= "<td align='left'><label  id='txtHorse_".$fila."' >".$res['prefijo']."  ".($res['ejemplar'])." - ".$res['codigo']."</label><input type='hidden' class='cssItemF'  id='hidHorse_".$fila."' value='".$res['codigo']."'></td>";
		 	$html.= "<td align='center'>
		  				<input type='date'  class='cssItemF' style='width:120px;' name='txtFecha_".$tipo."_".$fila."' id='txtFecha_".$tipo."_".$fila."' value='".$res['fecha']."' />
		 			</td>";			 
			$html.= "<td align='center'>".$botonHtml." </td>";					 
			$fila++;
				}
	 	mysqli_free_result($result);

	 	
		$html.= "</tbody>";

		if($fila==1){
 			//$html.= "<tfoot><tr><td align='left' style='height:40px;' colspan=3> </td></tr></tfoot>";
	 	}
	 	$html.= "<tfoot><tr><td colspan=4 style='height:30px; '><b>Total ejemplares $tituloFoot: ".($fila-1)."<b></td><tr></tfoot>";
		$html.= "</table>";
		return $html;
	}

	function listarHistorialC($link,$idPoe,$idProp,$tipo){

			$finalizo=EnvioForm($link,$idPoe,$_SESSION['xid']);

		$titulo="";
		if($tipo=="AB"){
			$titulo="Ejemplares que abortaron";$cssGrid="gridHtml ";
			$tituloFoot="con abortos";
		}
		if($tipo=="CA"){
			$tituloFoot="castrados";
			$titulo="Ejemplares Castrados";$cssGrid="gridHtmlCastrado table table-striped";
		}
		


		$html = "";
		$html.= "<table class='".$cssGrid."'   >";
		$html.= "<thead  style='background:#dff0d8;'>";
		$html.= "<tr>";
		$html.= "<th style='width:65%;'>".$titulo."</th>";
		$html.= "<th style='height:35px;'>Fecha</th>";
		$html.= "<th style='height:35px;'>...</th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		

		$sql = " SELECT h.id, h.codEjemplar as codigo,
				ifnull(d.prefijo ,p.prefijo) AS prefijo,
				ifnull(d.nombre ,p.nombre) as ejemplar,
				h.fecha
				FROM poe_historial h 
				left join sge_ejemplar d on(d.id  =h.codEjemplar) 
				left join poe_propiedad p on(h.codEjemplar=p.codEjemplar and p.idProp =  '".$idProp."' and p.idPoe =  '".$idPoe."' ) 
				WHERE   
				h.idProp =  '".$idProp."' and h.idPoe =  '".$idPoe."' and 
				h.tipo =  '".$tipo."'  
 				order by  ejemplar
				";
		 //echo $sql;
		$bgcolor="";// style=' background:#F5DA81; ' ";
		$result = mysqli_query($link,$sql);
		$fila=1;
		//echo "<pre>";print_r($_SESSION);
		//echo $sql;
		while($res = mysqli_fetch_array($result)){
			 
				$botonHtml="<label class='btnDel btn btn-default btn-sm glyphicon glyphicon-trash' data-key=".$res['id']." data-fin=".$finalizo."></label> ";
					//if($finalizo==true){ 				$botonHtml="";			}

			$html.= "<tr ".$bgcolor."> ";
 			$html.= "<td align='left'><label  id='txtHorse_".$fila."' >".$res['prefijo']."  ".($res['ejemplar'])." - ".$res['codigo']."</label><input type='hidden' class='cssItemC'  id='hidHorse_".$fila."' value='".$res['codigo']."'></td>";
		 	$html.= "<td align='center'>
		  				<input type='date'  class='cssItemC' style='width:120px;' name='txtFecha_".$tipo."_".$fila."' id='txtFecha_".$tipo."_".$fila."' value='".$res['fecha']."' />
		 			</td>";			 
			$html.= "<td align='center'>".$botonHtml." </td>";					 
			$fila++;
				}
	 	mysqli_free_result($result);

	 	
		$html.= "</tbody>";

		if($fila==1){
 			//$html.= "<tfoot><tr><td align='left' style='height:40px;' colspan=3> </td></tr></tfoot>";
	 	}
	 	$html.= "<tfoot><tr><td colspan=4 style='height:30px; '><b>Total ejemplares $tituloFoot: ".($fila-1)."<b></td><tr></tfoot>";
		$html.= "</table>";
		return $html;
	}
	 

	function insertarhistorialF($idPoe,$idUser,$idProp ,$historial,$link){
		$sql="";
		$contador=0;	
		//print_r($historial);
		if(is_array($historial)>0){
			foreach ($historial as $key => $value) {
				//print_r($value);
				$tipo=$value->tipo;
			}
		//echo $tipo;	
		}
		/* BEGIN ADDON DBS 20180302
		CODIGO AGREGADO AL CAMBIO CUANDO ES AGREGADO EL FALLECIMIENTO DESDE EL FORMULARIO 1
		*/
 		$delPrev=true;
 		if(is_array($historial)>0 && sizeof($historial)	==1){
						if($historial[0]->fecha=="X"){
										$delPrev=false;
										$historial[0]->fecha="";
						}
		}
 		if($delPrev)	
			$resultDel=eliminarhistorial($idPoe,$idUser,$tipo,$link);
		else
			$resultDel=1;
		/* END ADDON DBS 20180302*/


		if($resultDel){
			
			foreach ($historial as $key => $value) {
					//print_r($value);
					$mysqldate=$value->fecha;
					$codEjemplar = $value->codEjemplar;
					//$iid=getLastId($link);
					if($mysqldate==""){
						$sql= "INSERT INTO  poe_historial ( tipo, codEjemplar,idPoe,idProp,fecCrea,idUser,aprobado,rechazado)VALUES ('".$value->tipo."', '".$value->codEjemplar."','".$idPoe."','".$idProp."',now(),'".$idUser."',0,0);";
					}else{
						$sql= "INSERT INTO  poe_historial  ( tipo, codEjemplar,fecha,idPoe,idProp,fecCrea,idUser,aprobado,rechazado)VALUES ('".$value->tipo."', '".$value->codEjemplar."','".$mysqldate."','".$idPoe."','".$idProp."',now(),'".$idUser."',0,0);";	
					}
			       //echo $sql;
		 		    $result = mysqli_query($link,$sql);
				    if($result){
						$contador++;
				  	}
 			}
 		}
		  if(sizeof($historial)==$contador){
		  		return true;
		  }else{
			  	return false;
		  }
		
	}


	function insertarhistorialC($idPoe,$idUser,$idProp ,$historial,$link){
		$sql="";
		$contador=0;	
		//print_r($historial);
		if(is_array($historial)>0){
			foreach ($historial as $key => $value) {
				//print_r($value);
				$tipo=$value->tipo;
			}
		//echo $tipo;	
		}
		/* BEGIN ADDON DBS 20180302
		CODIGO AGREGADO AL CAMBIO CUANDO ES AGREGADO EL FALLECIMIENTO DESDE EL FORMULARIO 1
		*/
 		$delPrev=true;
 		if(is_array($historial)>0 && sizeof($historial)	==1){
						if($historial[0]->fecha=="X"){
										$delPrev=false;
										$historial[0]->fecha="";
						}
		}
 		if($delPrev)	
			$resultDel=eliminarhistorial($idPoe,$idUser,$tipo,$link);
		else
			$resultDel=1;
		/* END ADDON DBS 20180302*/


		if($resultDel){
			foreach ($historial as $key => $value) {
					//print_r($value);
					$mysqldate=$value->fecha;
				

					if($mysqldate==""){
						$sql= "INSERT INTO  poe_historial ( tipo, codEjemplar,idPoe,idProp,fecCrea,idUser,aprobado,rechazado)VALUES ('".$value->tipo."', '".$value->codEjemplar."','".$idPoe."','".$idProp."',now(),'".$idUser."',0,0);";
					}else{
						$sql= "INSERT INTO  poe_historial  ( tipo, codEjemplar,fecha,idPoe,idProp,fecCrea,idUser,aprobado,rechazado)VALUES ('".$value->tipo."', '".$value->codEjemplar."','".$mysqldate."','".$idPoe."','".$idProp."',now(),'".$idUser."',0,0);";	
					}
			      // echo $sql;
		 		    $result = mysqli_query($link,$sql);
				    if($result){
						$contador++;
				  	}
 			}
 		}
		  if(sizeof($historial)==$contador){
		  		return true;
		  }else{
			  	return false;
		  }
		
	}

	function eliminarhistorial($idPoe,$idProp,$tipo,$link){
 			$sql="DELETE FROM  poe_historial WHERE idPoe='".$idPoe."' AND idUser='".$idProp."' and tipo='".$tipo."' and aprobado=0 and rechazado=0";
 			//echo $sql;
 		    $result = mysqli_query($link,$sql);
			if($result){
				return true;
			}else{
				return false;
			}
		
	}
	function getLastId($link){
			$sql="SELECT IFNULL(MAX(id)+1,1)id FROM poe_movimiento";
			//echo $sql;
			$result = mysqli_query($link,$sql);
			$iid="";
			while($res = mysqli_fetch_array($result)){
				$iid=$res['id'];
			}
			return $iid;
	}

	function existeRepetidos($historial){
			$last="";
			$c=1;
          
			foreach ($historial as $key => $value) {
 					$date = explode('/', $value->fecha);
					$time = mktime(0,0,0,$date[1],$date[0],$date[2]);
					$mysqldate = date( 'Y-m-d', $time );	
			        
			        //$last=$mysqldate."".$value->tipo."".$value->codEjemplar;
			        	if($tipo=="FA"){
			        			$f=1;
			        			foreach ($historial as $key2 => $value2) {
 										$date2 = explode('/', $value2->fecha);
										$time2 = mktime(0,0,0,$date2[1],$date2[0],$date2[2]);
										$mysqldate2 = date( 'Y-m-d', $time2 );	
										//$last2=$mysqldate2."".$value2->tipo."".$value2->codEjemplar;
										if($time<$time2 && $c!=$f){
										//if($last==$last2 && $c!=$f){
											$c=1;
											return true;	

										}
										$f++;
								}
						}
		 		    $c++;
 			}
 			if($c==0){return false;}

	}
	function validarObligatorios($historial){
			$last="";
			$c=1;
          $msg="";
			foreach ($historial as $key => $value) {
					if($value->codEjemplar==""  && $msg==""){
						$msg="En la fila ".($key+1)." seleccione al ejemplar. ";
					}
					if($value->fecha=="" && $msg==""){
						$msg="En la fila ".($key+1).". La fecha es obligatorio. ";
					}
 					if($value->tipo=="" && $msg==""){
						$msg="En la fila ".($key+1)." Seleccione el tipo de prestamo. ";
					}
					if ($value->tipo!="CV" && strlen(strstr($value->codEjemplar,"Y"))>0 && $msg=="") {
						$msg="En la fila ".($key+1)." Para un prestamo debe seleccionar un potro. ";
					}
					if ($value->tipo!="PP" && strlen(strstr($value->codEjemplar,"P"))>0 && $msg=="") {
						$msg="En la fila ".($key+1)." Para una cesión de vientre debe seleccionar una yegua. ";
					}
					
			      
			      if($msg!=""){
						break;
			      }  

 			}
 			 
  		return $msg;
	}
	function eliminar($id,$link){

 			$sql="DELETE FROM  poe_historial WHERE id=".$id."";
 		    $result = mysqli_query($link,$sql);

			if($result){
				return true;
			}else{
				return false;
			}

	}


function listarHtmlAdmin($link,$idPoe,$idProp,$tipo){

	$codPropietario= obtenerIdPropietario( $idProp);
		//$periodo=obtenerPeriodoPoe($idPoe);
			
			$title="MUERTE DE MIS EJEMPLARES ";
			if($tipo=="CA"){
				$title="CASTRACIONES DE MIS EJEMPLARES";
			}
		$html = "";

		$html .= "<table border=0 style='width:100%;font-family:verdana;font-size:11px;'>";
		$html .= "<tr>";
		$html .= "<td colspan=1 align=left >";
		$html .= "<img src='img/anecpcp.jpg' />";
		$html .= "</td>";
		//$nf=$tipo=='CA'? 8:5 ;
		$html .= "<td colspan=1 align=right style='font-weight:bold;font-size:10px;'>";
		$html .= "$title - ".$codPropietario;
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2><hr></td></tr>";
		$html .= "<tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2  style='height:40px;font-weight:bold;font-size:18px;'>";
		$html .= "<center>$title</center>";
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<table>";
		
		//$tabla1=listarHtmlAdminHistorial($link,$idPoe,$codPropietario,'AB');
		//$html .= "<br>ABORTOS: ";
		//$html .=$tabla1;
		if($tipo=="CA"){
			$titulo="";
			$titulo2="";
			$texto1="APROBADAS";
			$texto2="RECHAZADAS";
			$texto3="INICIADA";
			if($tipo=="CA"){$titulo="CASTRACIONES";$titulo2="DE CASTRACIÓN";}
				// CASTRACIONES APROBADAS
				$fila1=1;
				$table1 = "";
				$table1 .= "<br>".$titulo." ".$texto1." : ";
				$table1.= "<table   style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
				//$table1.= "<thead style='background:#d3d3d3;'>";
				$table1.= "<thead>";
				$table1.= "<tr>";
				$table1.= "<th rowspan=2 style='width:3%;'>N&deg;</th>";
				$table1.= "<th colspan=5 style='width:70%;'>".$titulo."</th>";
				$table1.= "<th rowspan=3>FECHA ".$titulo2."</th>";
				$table1.= "</tr>";

				$table1.= "<tr>";
				$table1.= "<th >Prefijo</th>";
				$table1.= "<th >Nombre</th>";
				$table1.= "<th >N&deg; Registro</th>";
				$table1.= "<th >COMENTARIO ANECPCP</th>";
				$table1.= "<th >FECHA REVISIÓN</th>";
				$table1.= "</tr>";

				$table1.= "</thead>";
				$table1.= "<tbody  >";
				$retorno=listarHtmlAdminHistorial($link,$idPoe,$codPropietario,'CA');
				
					foreach($retorno as $key => $value){
						if($value->estado == "APROBADO"){
								$table1.= "<tr>";
								$table1.= "<td align='center'>".$fila1."</td>";					 
					 			$table1.= "<td align='left' style='width:15%;'>".$value->prefijo."</td><td style='width:20%;'> ".$value->ejemplar." </td><td style='width:15%;'> ".$value->codigo."</td><td style='width:30%;'> ".$value->comentario." </td> <td style='width:15%;'> ".$value->fecRevision." </td>";
								$table1.= "<td align='center'>".$value->fecha."</td>";					 
								$fila1++;
						}
					}
				$table1.= "</tbody>";
						/*if($fila==1){
				 			$table1.= "<tfoot><tr><td align='left' style='height:30px;' colspan=5> </td></tr></tfoot>";
					 	}*/
				$table1.= "</table>";
				//$html .= "<br>CASTRACIONES: ";
				$html .=$table1;


			 	 // CASTRACIONES RECHAZADAS
				$fila2=1;
				$table2 = "";
				$table2 .= "<br>".$titulo." ".$texto2." : ";
				$table2.= "<table   style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
				//$table2.= "<thead style='background:#d3d3d3;'>";
				$table2.= "<thead>";
				$table2.= "<tr>";
				$table2.= "<th rowspan=2 style='width:3%;'>N&deg;</th>";
				$table2.= "<th colspan=5 style='width:70%;'>".$titulo."</th>";
				$table2.= "<th rowspan=3>FECHA ".$titulo2."</th>";
				$table2.= "</tr>";

				$table2.= "<tr>";
				$table2.= "<th >Prefijo</th>";
				$table2.= "<th >Nombre</th>";
				$table2.= "<th >N&deg; Registro</th>";
				$table2.= "<th >COMENTARIO ANECPCP</th>";
				$table2.= "<th >FECHA REVISIÓN</th>";
				$table2.= "</tr>";

				$table2.= "</thead>";
				$table2.= "<tbody  >";
				$retorno=listarHtmlAdminHistorial($link,$idPoe,$codPropietario,'CA');
				
					foreach($retorno as $key => $value){
						if($value->estado == "RECHAZADO"){
								$table2.= "<tr>";
								$table2.= "<td align='center'>".$fila2."</td>";					 
					 			$table2.= "<td align='left' style='width:15%;'>".$value->prefijo."</td><td style='width:20%;'> ".$value->ejemplar." </td><td style='width:15%;'> ".$value->codigo."</td><td style='width:30%;'> ".$value->comentario." </td> <td style='width:15%;'> ".$value->fecRevision." </td>";
								$table2.= "<td align='center'>".$value->fecha."</td>";					 
								$fila2++;
						}
					}
				$table2.= "</tbody>";
						/*if($fila2==1){
				 			$table2.= "<tfoot><tr><td align='left' style='height:30px;' colspan=5> </td></tr></tfoot>";
					 	}*/
				$table2.= "</table>";
				//$html .= "<br>CASTRACIONES: ";
				$html .=$table2;


				// CASTRACIONES INICIADAS

				$fila3=1;
				$table3 = "";
				$table3 .= "<br>".$titulo." ".$texto3." : ";
				$table3.= "<table   style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
				//$table3.= "<thead style='background:#d3d3d3;'>";
				$table3.= "<thead>";
				$table3.= "<tr>";
				$table3.= "<th rowspan=2 style='width:3%;'>N&deg;</th>";
				$table3.= "<th colspan=5 style='width:70%;'>".$titulo."</th>";
				$table3.= "<th rowspan=3>FECHA ".$titulo2."</th>";
				$table3.= "</tr>";

				$table3.= "<tr>";
				$table3.= "<th >Prefijo</th>";
				$table3.= "<th >Nombre</th>";
				$table3.= "<th >N&deg; Registro</th>";
				$table3.= "<th >COMENTARIO ANECPCP</th>";
				$table3.= "<th >FECHA REVISIÓN</th>";
				$table3.= "</tr>";

				$table3.= "</thead>";
				$table3.= "<tbody  >";
				$retorno=listarHtmlAdminHistorial($link,$idPoe,$codPropietario,'CA');
				
					foreach($retorno as $key => $value){
						if($value->estado == "POR APROBAR"){
								$table3.= "<tr>";
								$table3.= "<td align='center'>".$fila3."</td>";					 
					 			$table3.= "<td align='left' style='width:15%;'>".$value->prefijo."</td><td style='width:20%;'> ".$value->ejemplar." </td><td style='width:15%;'> ".$value->codigo."</td><td style='width:30%;'> ".$value->comentario." </td> <td style='width:15%;'> ".$value->fecRevision." </td>";
								$table3.= "<td align='center'>".$value->fecha."</td>";					 
								$fila3++;
						}
					}
				$table3.= "</tbody>";
						/*if($fila2==1){
				 			$table2.= "<tfoot><tr><td align='left' style='height:30px;' colspan=5> </td></tr></tfoot>";
					 	}*/
				$table3.= "</table>";
				//$html .= "<br>CASTRACIONES: ";
				$html .=$table3;

		}
		if($tipo=="FA"){
			$titulo="";
			$titulo2="";
			$texto1="APROBADAS";
			$texto2="RECHAZADAS";
			$texto3="INICIADA";
			if($tipo=="FA"){$titulo="MUERTE DE EJEMPLARES";$titulo2="DE FALLECIMIENTO";}
			
			// FALLECIMIENTOS APROBADAS
				$fila1=1;
				$table1 = "";
				$table1 .= "<br>".$titulo." ".$texto1." : ";
				$table1.= "<table   style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
				//$table1.= "<thead style='background:#d3d3d3;'>";
				$table1.= "<thead>";
				$table1.= "<tr>";
				$table1.= "<th rowspan=2 style='width:3%;'>N&deg;</th>";
				$table1.= "<th colspan=5 style='width:70%;'>".$titulo."</th>";
				$table1.= "<th rowspan=3>FECHA ".$titulo2."</th>";
				$table1.= "</tr>";

				$table1.= "<tr>";
				$table1.= "<th >Prefijo</th>";
				$table1.= "<th >Nombre</th>";
				$table1.= "<th >N&deg; Registro</th>";
				$table1.= "<th >COMENTARIO ANECPCP</th>";
				$table1.= "<th >FECHA REVISIÓN</th>";
				$table1.= "</tr>";

				$table1.= "</thead>";
				$table1.= "<tbody  >";
				$retorno=listarHtmlAdminHistorial($link,$idPoe,$codPropietario,'FA');
				
					foreach($retorno as $key => $value){
						if($value->estado == "APROBADO"){
								$table1.= "<tr>";
								$table1.= "<td align='center'>".$fila1."</td>";					 
					 			$table1.= "<td align='left' style='width:15%;'>".$value->prefijo."</td><td style='width:20%;'> ".$value->ejemplar." </td><td style='width:15%;'> ".$value->codigo."</td><td style='width:30%;'> ".$value->comentario." </td> <td style='width:15%;'> ".$value->fecRevision." </td>";
								$table1.= "<td align='center'>".$value->fecha."</td>";					 
								$fila++;
						}
					}
				$table1.= "</tbody>";
						/*if($fila==1){
				 			$table1.= "<tfoot><tr><td align='left' style='height:30px;' colspan=5> </td></tr></tfoot>";
					 	}*/
				$table1.= "</table>";
				$html .=$table1;


			 	 // FALLECIMIENTOS RECHAZADAS
				$fila2=1;
				$table2 = "";
				$table2 .= "<br>".$titulo." ".$texto2." : ";
				$table2.= "<table   style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
				//$table2.= "<thead style='background:#d3d3d3;'>";
				$table2.= "<thead>";
				$table2.= "<tr>";
				$table2.= "<th rowspan=2 style='width:3%;'>N&deg;</th>";
				$table2.= "<th colspan=5 style='width:70%;'>".$titulo."</th>";
				$table2.= "<th rowspan=3>FECHA ".$titulo2."</th>";
				$table2.= "</tr>";

				$table2.= "<tr>";
				$table2.= "<th >Prefijo</th>";
				$table2.= "<th >Nombre</th>";
				$table2.= "<th >N&deg; Registro</th>";
				$table2.= "<th >COMENTARIO ANECPCP</th>";
				$table2.= "<th >FECHA REVISIÓN</th>";
				$table2.= "</tr>";

				$table2.= "</thead>";
				$table2.= "<tbody  >";
				$retorno=listarHtmlAdminHistorial($link,$idPoe,$codPropietario,'FA');
				
					foreach($retorno as $key => $value){
						if($value->estado == "RECHAZADO"){
								$table2.= "<tr>";
								$table2.= "<td align='center'>".$fila2."</td>";					 
					 			$table2.= "<td align='left' style='width:15%;'>".$value->prefijo."</td><td style='width:20%;'> ".$value->ejemplar." </td><td style='width:15%;'> ".$value->codigo."</td><td style='width:30%;'> ".$value->comentario." </td> <td style='width:15%;'> ".$value->fecRevision." </td>";
								$table2.= "<td align='center'>".$value->fecha."</td>";					 
								$fila2++;
						}
					}
				$table2.= "</tbody>";
						/*if($fila2==1){
				 			$table2.= "<tfoot><tr><td align='left' style='height:30px;' colspan=5> </td></tr></tfoot>";
					 	}*/
				$table2.= "</table>";
				$html .=$table2;


				// FALLECIMIENTOS INICIADAS

				$fila3=1;
				$table3 = "";
				$table3 .= "<br>".$titulo." ".$texto3." : ";
				$table3.= "<table   style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
				//$table3.= "<thead style='background:#d3d3d3;'>";
				$table3.= "<thead>";
				$table3.= "<tr>";
				$table3.= "<th rowspan=2 style='width:3%;'>N&deg;</th>";
				$table3.= "<th colspan=5 style='width:70%;'>".$titulo."</th>";
				$table3.= "<th rowspan=3>FECHA ".$titulo2."</th>";
				$table3.= "</tr>";

				$table3.= "<tr>";
				$table3.= "<th >Prefijo</th>";
				$table3.= "<th >Nombre</th>";
				$table3.= "<th >N&deg; Registro</th>";
				$table3.= "<th >COMENTARIO ANECPCP</th>";
				$table3.= "<th >FECHA REVISIÓN</th>";
				$table3.= "</tr>";

				$table3.= "</thead>";
				$table3.= "<tbody  >";
				$retorno=listarHtmlAdminHistorial($link,$idPoe,$codPropietario,'FA');
				
					foreach($retorno as $key => $value){
						if($value->estado == "POR APROBAR"){
								$table3.= "<tr>";
								$table3.= "<td align='center'>".$fila3."</td>";					 
					 			$table3.= "<td align='left' style='width:15%;'>".$value->prefijo."</td><td style='width:20%;'> ".$value->ejemplar." </td><td style='width:15%;'> ".$value->codigo."</td><td style='width:30%;'> ".$value->comentario." </td> <td style='width:15%;'> ".$value->fecRevision." </td>";
								$table3.= "<td align='center'>".$value->fecha."</td>";					 
								$fila3++;
						}
					}
				$table3.= "</tbody>";
						/*if($fila2==1){
				 			$table2.= "<tfoot><tr><td align='left' style='height:30px;' colspan=5> </td></tr></tfoot>";
					 	}*/
				$table3.= "</table>";
				$html .=$table3;
			
		}



	    $html.= "<table border=0 style='width:100%;font-family:verdana;font-size:11px;'>";
		$html.= "<tr><td colspan=4 style='height:50px;'></td></tr>";		
		$html.= "<tr>";
		$html.= "<td style='width:25%;font-weight:bold;' align=left>FECHA IMPPRESIÓN:</td><td style='font-weight:bold;' >&nbsp;&nbsp;".date('d/m/Y')."</td>";
		$nombre = nombreUsuarioImpresion($link,$_SESSION['xid']);
		$html.= "<tr><td style='width:30%;font-weight:bold;' align=left>RESPONSABLE IMPRESIÓN:</td><td style='font-weight:bold;'>&nbsp;&nbsp;".$nombre."</td></tr>";
		$html.= "<table>";


		$html.= "</td>";
		$html.= "</tr>";
		$html.= "</table>";

		$html.= "<center><div  id='lnkPrint'><a href=# onclick=document.getElementById('lnkPrint').style.display='none';window.print(); >Imprimir</a></div></center>";
	

return $html;
}
function listarHtmlAdminHistorial($link,$idPoe,$idProp,$tipo){
		

		$sql = " SELECT h.id, h.codEjemplar as codigo,
				d.prefij  AS prefijo,
				d.nombre  as ejemplar,
				DATE_FORMAT(h.fecha,'%d/%m/%Y')fecha,
				(select lh.comentario from poe_log_historial lh where lh.idHis = h.id)comentario,
				(select DATE_FORMAT(lh.fecCrea,'%d/%m/%Y') from poe_log_historial lh where lh.idHis = h.id)fecRevision,
				case 
					when h.aprobado = 1 THEN 'APROBADO'
					WHEN h.rechazado = 1 THEN 'RECHAZADO'
					ELSE 'POR APROBAR'
					END AS estado
				FROM poe_historial h 
				LEFT join datos220206 d on(d.codigo  =h.codEjemplar) 
				WHERE   
				h.idProp =  '".$idProp."' and 
				h.tipo =  '".$tipo."'  
 				order by h.id
				";
		//echo $sql;
		$result = mysqli_query($link,$sql);
		$fila=1;
		$ejemplar = [];
		while($res = mysqli_fetch_array($result)){
			$obj = new stdClass();
			$obj->id = $res['id'];
			$obj->codigo = $res['codigo'];
			$obj->prefijo = $res['prefijo'];
			$obj->ejemplar = $res['ejemplar'];
			$obj->fecha = $res['fecha'];
			$obj->comentario = $res['comentario'];
			$obj->fecRevision = $res['fecRevision']; 
			$obj->estado = $res['estado']; 
			$ejemplar[] = $obj;
		}
	 	mysqli_free_result($result);
		return $ejemplar;
	}
 
 	function nombreUsuarioImpresion($link,$codigo){
 			$sql = " SELECT   GROUP_CONCAT(e.razonSocial  order by p.correlativo asc SEPARATOR ' / ') nombre 
					FROM 
					sge_propietario p inner join sge_entidad e on(e.id= p.IdEntidad)  
					WHERE 
					p.idProp='".$codigo."' ";
		//echo $sql;
		$result = mysqli_query($link,$sql);
		$nombre ="";
		while($res = mysqli_fetch_array($result)){
			$nombre = $res['nombre'];
		}
	 	mysqli_free_result($result);
		return $nombre;
 	}

	function listarMisPotros($link,$idPoe,$idUser,$idProp){
		$finalizo=EnvioForm($link,$idPoe,$idUser);
		$html = "";
		$html.= "<table class='gridHtml table table-striped'  >";
		$html.= "<thead style=' background:#dff0d8;'  >";
		$html.= "<tr>";
		$html.= "<th >Mis Ejemplares para castración</th>";
		$html.= "<th style='height:35px; width:100px;'>...</th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		
		$sql =  " 	 select e.prefijo,e.nombre,e.id codigo,pl.idPropietario from sge_ejemplar e
						inner join sge_propietariolog pl on e.id=pl.idEjemplar
						where pl.fecFin is null and
						pl.idPropietario ='".$idProp."' 
                        and not exists(select 1 from poe_historial h where h.codEjemplar=e.id and h.tipo='CA') 
                        and e.genero='P';    			    	  	
					";	
	 	//echo $sql ;
		$result = mysqli_query($link,$sql);
		$fila=1;
		$bgcolor="";
		while($res = mysqli_fetch_array($result)){
 

			$nombreEjem=$res['prefijo']."  ".($res['nombre'])." - ".$res['codigo']; 
			$html.= "<tr id='tbprestamo_".$res['codigo']."' >";
 			$html.= "<td align='left'  ".$bgcolor."><label  id='txtHorse_".$fila."' >".$nombreEjem."</label><input type='hidden' class='cssItem'  id='hidHorse_".$fila."' value='".$res['codigo']."'></td>";
			$html.= "<td align='left'  ".$bgcolor.">
						<label title='Agregar a lista de Castrados.' alt='Agregar a lista de Castrados.' class='btnCA btn btn-default btn-sm' data-key=".$res['codigo']."  data-label='".$nombreEjem."'    data-fin=".$finalizo."  >Castrado</label> 
					 </td>";
	 
			$fila++;
				}
	 	mysqli_free_result($result);
		$html.= "</tbody>";
		$html.= "<tfoot><tr><td colspan=4 style='height:30px; '><b>Total ejemplares: ".($fila-1)."<b></td><tr></tfoot>";
		$html.= "</table>";
		return $html;
	}

function ValidarCastrado($idEjemplar,$idPoe,$idUser,$link){

 $sql="SELECT * FROM poe_historial WHERE tipo='CA' 
 				AND idPoe=$idPoe 
 				AND idUser=$idUser	
 				AND codEjemplar='$idEjemplar' ";
//echo $sql;
 		    $result = mysqli_query($link,$sql);

			$number_of_rows = mysqli_num_rows($result);

			if($number_of_rows==0){
				return true;
			}else{
				return false;
			}

	}

?>
