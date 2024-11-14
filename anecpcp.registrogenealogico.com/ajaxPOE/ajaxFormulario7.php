<?php session_start();
	require("../Clases/conexion.php");
	require("../Clases/resultado.php");
	require("../Funciones/general.php");
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

		}elseif($_POST['opc'] == 'ins'){

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
			 
			if(is_array($historial) &&  sizeof($historial)>0){
				$msgValidate="";//validarObligatorios($historial);
				if($msgValidate==""){
						if(true){//!existeRepetidos($historial)){
						 	$result=insertarhistorial($idPoe,$idUser,$idProp ,$historial,$link);
						 	$retorno->result=1;
						 	//$retorno->html=listarprestamo($link,$idPoe,$idUser);
						 	$retorno->message="Formulario 7 registrado Correctamente.";
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

		}else if($_POST['opc'] == 'lstHistorial'){
			$idPoe = $_POST['idPoe'];
			$idUser =$_POST['idProp'];
			$idProp= obtenerIdPropietario( $idUser);
			$tipo=$_POST['tipo'];
			echo listarHistorial($link,$idPoe,$idProp,$tipo);

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
		$html.= "<table class='xgridHtml' style='width:100%;border-collapse:collapse;' border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th >Mis Ejemplares</th>";
		$html.= "<th style='height:35px; width:100px;'>...</th>";
	//	$html.= "<th style='height:35px; width:100px;'>...</th>";
//		$html.= "<th style='height:35px;'>...</th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		
 
        $idPoeAnterior=tienePOEAnterior($link,$idProp,$idPoe);
        //echo $idPoeAnterior."<br>";
		if($idPoeAnterior>0){
			
		$sql = "SELECT * FROM (
					SELECT p.id,p.codEjemplar COLLATE utf8_unicode_ci as codigo, 
  								p.prefijo  COLLATE utf8_unicode_ci prefijo, 
  								p.nombre COLLATE utf8_unicode_ci ejemplar
						FROM poe_propiedad p WHERE  p.idPoe =".$idPoeAnterior." and p.idUser=".$idUser."
						 AND p.codEjemplar 
						 NOT IN (SELECT p.codEjemplar FROM poe_propiedad p WHERE p.idPoe =".$idPoe." and p.idUser=".$idUser." )
						 AND p.codEjemplar 
						 NOT IN(SELECT h.codEjemplar FROM poe_historial h where h.idPoe=".$idPoe." and h.idUser=".$idUser." and tipo='FA' )
						 union ALL
						 SELECT 0 , p.codEjemplar,a.prefij, a.nombre
	      		FROM poe_movimiento p INNER JOIN datos220206 a ON a.codigo =p.codEjemplar
	      		WHERE p.idPoe =".$idPoe." and p.idUser=".$idUser."  and p.tipo = 'A'   
    	  		and p.codEjemplar not in( select m.codEjemplar   FROM poe_propiedad m WHERE m.idPoe =".$idPoe."  and m.idUser=".$idUser." )
    	  		AND p.codEjemplar NOT IN(SELECT h.codEjemplar FROM poe_historial h where h.idPoe=".$idPoe." and h.idUser=".$idUser." and tipo='FA' ) 
    	  		) q
					ORDER BY q.ejemplar,q.codigo			    	  	
					";	
				 	//echo $sql;// " tiene poe anterior"; 
		}else{
			$sql = "SELECT * FROM(
								SELECT 0 as id, 
								a.codigo  AS codigo,
								 a.prefij  AS prefijo, 
								a.nombre  as ejemplar
								 FROM datos220206 a
								WHERE 
								a.codigo  not 
								IN(SELECT p.codEjemplar FROM poe_propiedad p WHERE p.idPoe =".$idPoe." and p.idUser=".$idUser." ) and  a.cod_propie  ='".$idProp."' 
								AND	a.codigo  
								NOT IN(SELECT h.codEjemplar FROM poe_historial h where h.idPoe=".$idPoe." and h.idUser=".$idUser." and tipo='FA' ) 
								AND a.codigo  
								NOT IN(SELECT mm.codEjemplar FROM poe_movimiento mm where mm.idPoe=".$idPoe." and mm.idUser=".$idUser." and tipo='T' )
						UNION ALL
						      	SELECT 0,p.codEjemplar, a.prefij, a.nombre 
						      	FROM poe_movimiento p INNER JOIN datos220206 a ON a.codigo =p.codEjemplar
						      	WHERE p.idPoe =".$idPoe." and p.idUser=".$idUser."  and p.tipo = 'A'   
					    	  	and p.codEjemplar not in( select m.codEjemplar   FROM poe_propiedad m WHERE m.idPoe =".$idPoe."  and m.idUser=".$idUser." ) AND
					    	  	p.codEjemplar NOT IN(SELECT h.codEjemplar FROM poe_historial h where h.idPoe=".$idPoe." and h.idUser=".$idUser." and tipo='FA' )  
			    	  	) Q
				ORDER BY Q.ejemplar,Q.codigo			    	  	
					";	
				//echo $sql;
					 //echo "no tiene poe anterior"; 
		}
		//echo $sql;
		$result = mysqli_query($link,$sql);
		$fila=1;
		$bgcolor="";
		while($res = mysqli_fetch_array($result)){

			

				/*	if($res["inBD"]=="0"){
						 	$bgcolor=" style=' background:white;' ";
					}else{
						 	$bgcolor=" style=' background:#F5DA81;color:gray;' ";
					}*/

			$nombreEjem=$res['prefijo']."  ".($res['ejemplar'])." - ".$res['codigo']; 
			$html.= "<tr id='tbprestamo_".$res['codigo']."' >";
 			$html.= "<td align='left'  ".$bgcolor."><label  id='txtHorse_".$fila."' >".$nombreEjem."</label><input type='hidden' class='cssItem'  id='hidHorse_".$fila."' value='".$res['codigo']."'></td>";
			$html.= "<td align='left'  ".$bgcolor.">
						<label title='Agregar a lista de Fallecidos.' alt='Agregar a lista de Fallecidos.' class='btnFall' data-key=".$res['codigo']."  data-label='".$nombreEjem."'  data-fin=".$finalizo."  >Falleció</label> 
					 </td>";
	/*	$html.= "<td align='left'  ".$bgcolor.">					 ";
			if(substr($res['codigo'],0,1)=='Y'){
				$html.= "<label alt='Agregar a lista de Abortos.' title='Agregar a lista de Abortos.' class='btnCA' data-key=".$res['codigo']." data-label='".$nombreEjem."' data-tipo='AB' >Abortó</label> ";
			}else if(substr($res['codigo'],0,1)=='P'){
				$html.= "<label title='Agregar a lista de Castrados.' alt='Agregar a lista de Castrados.' class='btnCA' data-key=".$res['codigo']." data-label='".$nombreEjem."' data-tipo='CA'>Castrado</label> ";
			}
			$html.= "	 </td></tr>";*/
			$fila++;
				}
	 	mysqli_free_result($result);
		$html.= "</tbody>";
		$html.= "<tfoot><tr><td colspan=4 style='height:30px; '><b>Total ejemplares: ".($fila-1)."<b></td><tr></tfoot>";
		$html.= "</table>";
		return $html;
	}

function listarHistorial($link,$idPoe,$idProp,$tipo){

			$finalizo=EnvioForm($link,$idPoe,$_SESSION['xid']);

		$titulo="";
		if($tipo=="AB"){
			$titulo="Ejemplares que abortaron";$cssGrid="gridHtmlAborto";
			$tituloFoot="con abortos";
		}
		if($tipo=="CA"){
			$tituloFoot="castrados";
			$titulo="Ejemplares Castrados";$cssGrid="gridHtmlCastrado";
		}
		if($tipo=="FA"){
			$titulo="Ejemplares Fallecidos";$cssGrid="gridHtmlFallecido";
			$tituloFoot="fallecidos";
		}


		$html = "";
		$html.= "<table class='".$cssGrid."' style='width:100%;border-collapse:collapse;' border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th style='width:70%;'>".$titulo."</th>";
		$html.= "<th style='height:35px;'>Fecha</th>";
		$html.= "<th style='height:35px;'>...</th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		

		$sql = " SELECT h.id, h.codEjemplar as codigo,
				ifnull(d.prefij ,p.prefijo) AS prefijo,
				ifnull(d.nombre ,p.nombre) as ejemplar,
				DATE_FORMAT(h.fecha,'%d/%m/%Y') fecha
				FROM poe_historial h 
				left join datos220206 d on(d.codigo  =h.codEjemplar) 
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
		while($res = mysqli_fetch_array($result)){
			 
				$botonHtml="<label class='btnDel' data-key=".$res['id']." data-fin=".$finalizo.">Eliminar</label> ";
					//if($finalizo==true){ 				$botonHtml="";			}

			$html.= "<tr ".$bgcolor."> ";
 			$html.= "<td align='left'><label  id='txtHorse_".$fila."' >".$res['prefijo']."  ".($res['ejemplar'])." - ".$res['codigo']."</label><input type='hidden' class='cssItem'  id='hidHorse_".$fila."' value='".$res['codigo']."'></td>";
			$html.= "<td align='center'>
		  				<input type='text'  class='datepicker cssItem' style='width:100px;' name='txtFecha_".$tipo."_".$fila."' id='txtFecha_".$tipo."_".$fila."' value='".$res['fecha']."'/>
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

	 

	function insertarhistorial($idPoe,$idUser,$idProp ,$historial,$link){
		$sql="";
		$contador=0;	
		//print_r($historial);
		if(is_array($historial)>0){
			foreach ($historial as $key => $value) {
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
					$mysqldate="";
					if($value->fecha!=""){
 						$date = explode('/', $value->fecha);
						$time = mktime(0,0,0,$date[1],$date[0],$date[2]);
						$mysqldate = date( 'Y-m-d H:i:s', $time );
					}
					if($mysqldate==""){
						$sql= "INSERT INTO  poe_historial ( tipo, codEjemplar,idPoe,idProp,fecCrea,idUser)VALUES ('".$value->tipo."', '".$value->codEjemplar."','".$idPoe."','".$idProp."',now(),'".$idUser."');";
					}else{
						$sql= "INSERT INTO  poe_historial  ( tipo, codEjemplar,fecha,idPoe,idProp,fecCrea,idUser)VALUES ('".$value->tipo."', '".$value->codEjemplar."','".$mysqldate."','".$idPoe."','".$idProp."',now(),'".$idUser."');";	
					}
			        
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
 			$sql="DELETE FROM  poe_historial WHERE idPoe='".$idPoe."' AND idUser='".$idProp."' and tipo='".$tipo."'";
 			//echo $sql;
 		    $result = mysqli_query($link,$sql);
			if($result){
				return true;
			}else{
				return false;
			}
		
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
		$periodo=obtenerPeriodoPoe($idPoe);
			
			$title="MUERTE ";
			if($tipo=="CA"){
				$title="CASTRACIONES ";
			}
		$html = "";

		$html .= "<table border=0 style='width:100%;font-family:verdana;font-size:11px;'>";
		$html .= "<tr>";
		$html .= "<td colspan=1 align=left >";
		$html .= "<img src='img/logo2.jpg' />";
		$html .= "</td>";
		$nf=$tipo=='CA'? 8:5 ;
		$html .= "<td colspan=1 align=right style='font-weight:bold;font-size:10px;'>";
		$html .= "FORMULARIO $nf - ".$codPropietario;
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2><hr></td></tr>";
		$html .= "<tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2  style='height:40px;font-weight:bold;font-size:18px;'>";
		$html .= "<center>$title DE EJEMPLARES DURANTE EL A&Ntilde;O $periodo</center>";
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<table>";
		
		//$tabla1=listarHtmlAdminHistorial($link,$idPoe,$codPropietario,'AB');
		//$html .= "<br>ABORTOS: ";
		//$html .=$tabla1;

		if($tipo=="CA"){
			$tabla1=listarHtmlAdminHistorial($link,$idPoe,$codPropietario,'CA');
			$html .= "<br>CASTRACIONES: ";
			$html .=$tabla1;
		}
		if($tipo=="FA"){
			$tabla1=listarHtmlAdminHistorial($link,$idPoe,$codPropietario,'FA');
			$html .= "<br>MUERTE DE EJEMPLARES ";
			$html .=$tabla1;
		}



	    $html.= "<table border=0 style='width:100%;font-family:verdana;font-size:11px;'>";
		$html.= "<tr><td colspan=4 style='height:50px;'></td></tr>";		
		$html.= "<tr>";
		$html.= "<td style='width:25%;' align=right>FECHA:</td><td  >&nbsp;&nbsp;".date('d/m/Y')."</td>";
		$html.= "<td style='width:25%;' align=right>FIRMA:</td><td  align='left' valign=bottom><div><hr style='border-color:black;width:150px;margin-left:10px;'></div></td>";
		$html.= "<tr><td colspan=4 style='height:40px;'></td></tr>";
		$html.= "<table>";


		$html.= "</td>";
		$html.= "</tr>";
		$html.= "</table>";

		$html.= "<center><div  id='lnkPrint'><a href=# onclick=document.getElementById('lnkPrint').style.display='none';window.print(); >Imprimir</a></div></center>";
	

return $html;
}
function listarHtmlAdminHistorial($link,$idPoe,$idProp,$tipo){
		$titulo="";
		if($tipo=="AB"){$titulo="YEGUA ";}
		if($tipo=="CA"){$titulo="CASTRACIONES";}
		if($tipo=="FA"){$titulo="MUERTE DE EJEMPLARES";}

		$html = "";
		$html.= "<table   style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th rowspan=2 style='width:3%;'>N&deg;</th>";
		$html.= "<th colspan=3 style='width:70%;'>".$titulo."</th>";
		$html.= "<th rowspan=2>Fecha</th>";
		$html.= "</tr>";

		$html.= "<tr>";
		$html.= "<th >Prefijo</th>";
		$html.= "<th >Nombre</th>";
		$html.= "<th >N&deg; Registro</th>";
		$html.= "</tr>";

		$html.= "</thead>";
		$html.= "<tbody  >";
		

		$sql = " SELECT h.id, h.codEjemplar as codigo,
				ifnull(d.prefij ,p.prefijo) AS prefijo,
				ifnull(d.nombre ,p.nombre) as ejemplar,
				DATE_FORMAT(h.fecha,'%d/%m/%Y') fecha
				FROM poe_historial h 
				LEFT join datos220206 d on(d.codigo  =h.codEjemplar) 
				LEFT join poe_propiedad p on(h.codEjemplar=p.codEjemplar and p.idProp =  '".$idProp."' and p.idPoe =  '".$idPoe."' ) 
				WHERE   
				h.idProp =  '".$idProp."' and h.idPoe =  '".$idPoe."' and 
				h.tipo =  '".$tipo."'  
 				order by h.id
				";
		//echo $sql;
		$result = mysqli_query($link,$sql);
		$fila=1;
		while($res = mysqli_fetch_array($result)){
			 
			$html.= "<tr>";
			$html.= "<td align='center'>".$fila."</td>";					 
 			$html.= "<td align='left' style='width:15%;'>".$res['prefijo']."</td><td style='width:40%;'> ".($res['ejemplar'])." </td><td style='width:15%;'> ".$res['codigo']."</td>";
			$html.= "<td align='center'>".$res['fecha']."</td>";					 
			$fila++;
				}
	 	mysqli_free_result($result);

	 	
		$html.= "</tbody>";

		if($fila==1){
 			$html.= "<tfoot><tr><td align='left' style='height:30px;' colspan=5> </td></tr></tfoot>";
	 	}
		$html.= "</table>";
		return $html;
	}
 
 
	function listarMisPotros($link,$idPoe,$idUser,$idProp){
		$finalizo=EnvioForm($link,$idPoe,$idUser);
		$html = "";
		$html.= "<table class='xgridHtml' style='width:100%;border-collapse:collapse;' border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th >Mis Ejemplares</th>";
		$html.= "<th style='height:35px; width:100px;'>...</th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		
		$sql =  " 	SELECT p.id,p.codEjemplar COLLATE utf8_unicode_ci as codigo, 
		  								p.prefijo  COLLATE utf8_unicode_ci prefijo, 
		  								p.nombre COLLATE utf8_unicode_ci ejemplar
								FROM poe_propiedad p WHERE  p.idPoe =".$idPoe." and p.idUser=".$idUser."
								AND LEFT(p.codEjemplar,1)='P'
								 AND p.codEjemplar 
								 NOT IN(SELECT h.codEjemplar FROM poe_historial h where h.idPoe=".$idPoe." and h.idUser=".$idUser." and tipo='CA' )
						 
						ORDER BY  ejemplar, codigo			    	  	
					";	
		//echo $sql ;
		$result = mysqli_query($link,$sql);
		$fila=1;
		$bgcolor="";
		while($res = mysqli_fetch_array($result)){
 

			$nombreEjem=$res['prefijo']."  ".($res['ejemplar'])." - ".$res['codigo']; 
			$html.= "<tr id='tbprestamo_".$res['codigo']."' >";
 			$html.= "<td align='left'  ".$bgcolor."><label  id='txtHorse_".$fila."' >".$nombreEjem."</label><input type='hidden' class='cssItem'  id='hidHorse_".$fila."' value='".$res['codigo']."'></td>";
			$html.= "<td align='left'  ".$bgcolor.">
						<label title='Agregar a lista de Castrados.' alt='Agregar a lista de Fallecidos.' class='btnCA' data-key=".$res['codigo']."  data-label='".$nombreEjem."'    data-fin=".$finalizo."  >Castrado</label> 
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

			$number_of_rows = mysql_num_rows($result);

			if($number_of_rows==0){
				return true;
			}else{
				return false;
			}

	}

?>
