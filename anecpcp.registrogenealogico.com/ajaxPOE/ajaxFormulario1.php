<?php session_start();
	require("../constante.php");
	date_default_timezone_set("UTC");
	require("../Clases/conexion.php");
	require("../Clases/resultado.php");
	require("../Funciones/general.php");
//	require("../Funciones/queries.php");

	$cn=new Connection();
	$link=$cn->Conectar();

	$retorno=new Resultado();

	if(isset($_POST['opc'])){

		if($_POST['opc'] == 'lstMov'){
			$idPoe = $_POST['idPoe'];
			$idUser = $_POST['idProp'];
	 		$idProp= obtenerIdPropietario( $idUser);
			echo listarPropiedad($link,$idPoe,$idUser,$idProp);
		}elseif($_POST['opc'] == 'insMov'){

				$a=$_SESSION['_periodoPoe'];
				$b=$_SESSION['xid'];

			 
			if(!(EnvioForm($link,$a,$b))){
	 			 $idUser = $_POST['idUser'];
				 $datos = $_POST['data'];
				 $idPoe = $_POST['idPoe'];
				 $insTipo = $_POST['insTipo'];
				 $codProp =  obtenerIdPropietario($idUser);
				 $datosDecode = json_decode('"' . $datos . '"');
	       		 //$movimientos = json_decode($datosDecode);
	         	 $movimientos = json_decode($datos);
			 
			if(is_array($movimientos) &&  sizeof($movimientos)>0){
				$msgValidate=validarObligatorios($movimientos);
				if($msgValidate==""){
						if(true){
						 	$result=insertarPropiedad($idPoe,$idUser,$codProp, $movimientos,$insTipo,$link);
						 	$retorno->result=1;
						 	$retorno->html=listarPropiedad($link,$idPoe,$idUser ,$codProp );
						 	$retorno->message="Ejemplar registrado como mi propiedad correctamente.";
						 }else{
						 	$retorno->result=2;
						 	$retorno->message="Existen movimientos duplicados. No pueden existir Movimientos con fecha,tipo y ejemplar iguales.";
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
			 
		}elseif($_POST['opc'] == 'delMov'){
			
			$id = $_POST['id'];

			if(eliminar($id,$link)){
					$retorno->result=1;
					$retorno->message="Eliminado correctamente";
			}else{
					$retorno->result=0;
					$retorno->message="Ocurrió un error al eliminar";
			}
			echo json_encode($retorno);

		}elseif($_POST['opc'] == 'delAll'){
			
			$idPoe = $_POST['idPoe'];
			$idUser = $_POST['idUser'];

			if(eliminarTodo($idPoe,$idUser,$link)){
					$retorno->result=1;
					$retorno->message="Eliminado correctamente";
			}else{
					$retorno->result=0;
					$retorno->message="Ocurrió un error al eliminar";
			}
			echo json_encode($retorno);

		} 

		if($_POST['opc'] == 'lstView'){
			$idPoe = $_POST['idPoe'];
			$idUser = $_POST['idProp'];
	 		$idProp= obtenerIdPropietario( $idUser);
			echo listarHtml($link,$idPoe,$idUser,$idProp);

		}
		if($_POST['opc'] == 'lstMineAdd'){
			$idPoe = $_POST['idPoe'];
			$idUser = $_POST['idProp'];
	 		$idProp= obtenerIdPropietario( $idUser);
			echo listarPropiedadAgregado($link,$idPoe,$idUser,$idProp);
		 }
		if($_POST['opc'] == 'lstEcu'){
			
			$orden = $_POST['order'];
			$columna = $_POST['field'];
			$format=$_POST['format'];
	 		
			

			if($format=='xls'){
			header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
			header("Content-Disposition: filename=ficheroExcel.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			}
			echo listarPropiedadEcu($link,$_SESSION['xid'],$columna,$orden,$format);


		}
	}
	 
	function listarPropiedad($link,$idPoe,$idUser,$idProp){

	$finalizo=EnvioForm($link,$idPoe,$idUser);
	//if($finalizo!=true){
		$html = "";
		$html1 = "";
		$html1.= "<table class='gridHtml' style='width:100%;border-collapse:collapse;' border=1 >";
		$htmlth1.= "<thead style='background:#d3d3d3;'>";
		$htmlth1.= "<tr>";
		//$html.= "<th style='height:35px;width:5%;'></th>";
		$htmlth1.= "<th style='height:35px;width:10%;'>Prefijo</th>";
		$htmlth1.= "<th style='height:35px;width:30%;'>Nombre del Ejemplar</th>";
		$htmlth1.= "<th style='height:35px;width:15%;'>N° del Registro</th>";
		$htmlth1.= "<th style='height:35px;width:45%;'>...</th>";
		$htmlth1.= "</tr>";
		$htmlth1.= "</thead>";
		$html.= "<tbody  >";
		
		$idPoeAnterior=tienePOEAnterior($link,$idProp,$idPoe);
		// echo $idPoeAnterior." ...";

		if($idPoeAnterior>0){
			/*$sqlInicioPoe="SELECT 0 as id, a.codigo COLLATE utf8_unicode_ci AS codigo, a.prefij COLLATE utf8_unicode_ci AS prefijo, 
  						a.nombre COLLATE utf8_unicode_ci as nombre, '' esNuevo,false esBD FROM datos220206 a
  						WHERE 
    					a.codigo COLLATE utf8_unicode_ci not in(select p.codEjemplar from poe_propiedad p WHERE p.idPoe =".$idPoe." and p.idUser=".$idUser." ) and
    					a.cod_propie  ='".$idProp."'
  					UNION ALL";
  					 */
		$sql = "SELECT DISTINCT id,codigo,prefijo,nombre,esNuevo,esBD 
  				FROM ( 
  						SELECT p.id,p.codEjemplar  as codigo, 
  								p.prefijo   prefijo, 
  								p.nombre  nombre, p.esNuevo ,false as esBD
						FROM poe_propiedad p WHERE  p.idPoe =".$idPoeAnterior." and p.idUser=".$idUser."
						 AND p.codEjemplar NOT IN (SELECT p.codEjemplar FROM poe_propiedad p WHERE p.idPoe =".$idPoe." and p.idUser=".$idUser." )
					UNION ALL
				      	SELECT 0,p.codEjemplar, a.prefij, a.nombre, '' ,false 
				      	FROM poe_movimiento p INNER JOIN datos220206 a ON a.codigo =p.codEjemplar
				      	WHERE p.idPoe =".$idPoe." and p.idUser=".$idUser."  and p.tipo = 'A'   
			    	  	and p.codEjemplar not in( select m.codEjemplar   FROM poe_propiedad m WHERE m.idPoe =".$idPoe."  and m.idUser=".$idUser." )
						) as q 
						WHERE q.codigo NOT IN 
					  (
						SELECT t.codEjemplar FROM (
						SELECT codEjemplar FROM poe_historial WHERE tipo in('FA') AND idPoe=".$idPoe." AND idUser=".$idUser."
						UNION ALL
						SELECT codEjemplar FROM poe_movimiento WHERE tipo='T' AND idUser=".$idUser." AND idPoe=".$idPoe."
						) as t
 					  ) 
					ORDER BY q.nombre,q.codigo			    	  	
					";	
				 //	echo $sql;// " tiene poe anterior"; 
		}else{
			//echo "<br>no tiene poe<br>";
			$sql = " SELECT DISTINCT id,codigo,prefijo,nombre,esNuevo,esBD 
  				FROM ( 
  						SELECT 0 as id, a.codigo  AS codigo, a.prefij  AS prefijo, 
  						a.nombre  as nombre, '' esNuevo,false esBD FROM datos220206 a
  						WHERE 
    					a.codigo  not in(select p.codEjemplar from poe_propiedad p WHERE p.idPoe =".$idPoe." and p.idUser=".$idUser." ) and
    					a.cod_propie  ='".$idProp."'
  					-- UNION ALL
  						-- SELECT p.id,p.codEjemplar, p.prefijo, p.nombre, p.esNuevo ,true 
						-- FROM poe_propiedad p WHERE  p.idPoe =".$idPoe." and p.idUser=".$idUser."  
					UNION ALL
				      	SELECT 0,p.codEjemplar, a.prefij, a.nombre, '' ,false 
				      	FROM poe_movimiento p INNER JOIN datos220206 a ON a.codigo=p.codEjemplar
				      	WHERE p.idPoe =".$idPoe." and p.idUser=".$idUser."  and p.tipo = 'A'   
			    	  	and p.codEjemplar not in( select m.codEjemplar   FROM poe_propiedad m WHERE m.idPoe =".$idPoe."  and m.idUser=".$idUser." )
						) as q 
					  WHERE q.codigo NOT IN 
					  (
						SELECT t.codEjemplar FROM (
						SELECT codEjemplar FROM poe_historial WHERE tipo in('FA') AND idPoe=".$idPoe." AND idUser=".$idUser."
						UNION ALL
						SELECT codEjemplar FROM poe_movimiento WHERE tipo='T' AND idUser=".$idUser." AND idPoe=".$idPoe."
						) as t
 					  ) 
					ORDER BY q.nombre,q.codigo			    	  	
					";	
				//	 echo "no tiene poe anterior"; 
		}
	//	echo $sql;
		$result = mysqli_query($link,$sql) or die("Error : listarPropiedad ".mysqli_error($link));
		$fila=1;
		while($res = mysqli_fetch_array($result)){
			$ejemplar=$res['nombre'];
			$botonHtml="<label class='btnDel'  data-key=".$res['id'].">Eliminar</label>";
			 if($finalizo==true){
			 	$botonHtml="";
			 }

			$html.= "<tr id='tbMovimiento_".$res['id']."'>";
 			$checked='';
 			$prefijo='';
 			$nombre='';
 			$codigo='';
			if($res['esBD']){
				$checked='checked';
						 
			}
			/*	$html.= "<td align='center'>
				<input type='checkbox' class='cssItem cssRbtn' data-label='lblStatusProp_".$fila."' id='rdbtnA_".$fila."' value='' $checked />
				</td>";*/

				$html.= "<td align='left' >
				<label  id='txtPrefijo_".$fila."' >".$res['prefijo']."</label>
				<input type='hidden' class='cssItem'  id='hidPrefijo_".$fila."' value='".$res['prefijo']."'>
				<input class='cssItem'  type='hidden' name='txtEsNuevo_".$fila."' id='txtEsNuevo_".$fila."' value='".$res['esNuevo']."'/>
				</td>";

				$html.= "<td align='left'>
				<label  id='txtEjemplar_".$fila."' >".($ejemplar)."</label>
				<input type='hidden' class='cssItem'  id='hidEjemplar_".$fila."' value='".($res['nombre'])."'>
				</td>";

				$html.= "<td align='center'>
				<label  id='txtRegistro_".$fila."' >".$res['codigo']."</label>
				<input type='hidden' class='cssItem'  id='hidRegistro_".$fila."' value='".$res['codigo']."'>
				</td>";

			 

				
			$html.= "<td align='center'>";
			$html.= "<button class='btnPorpiedad' data-codigo=".$res['codigo']." data-nombre='".$ejemplar."' data-prefijo=".$res['prefijo']." data-fin=".$finalizo." >Mi prop.</button>";

			$html.= "&nbsp;&nbsp;<button class='btnFallecio' data-codigo=".$res['codigo']." data-nombre='".$ejemplar."' data-prefijo=".$res['prefijo']." data-fin=".$finalizo." >Falleci&oacute;</button>";

			$html.= "&nbsp;&nbsp;<button class='btnTransferido' data-codigo=".$res['codigo']." data-nombre='".$ejemplar."' data-prefijo=".$res['prefijo']." data-fin=".$finalizo." >Transf.</button>";

			$html.= "&nbsp;&nbsp;<button class='btnCastrado' data-codigo=".$res['codigo']." data-nombre='".$ejemplar."' data-prefijo=".$res['prefijo']." data-fin=".$finalizo." >Castrado</button>";

			if($res['esNuevo']=='1'){
				$html.=$botonHtml;//"<label ><label class='btnDel'  data-key=".$res['id'].">Eliminar</label></label>";
			}
				
				 $html.= "</td>";
			$html.= "</tr>";
			$fila++;
				}
	 	mysqli_free_result($result);
		$html.= "</tbody>";
		$htmlTotal= "<tfoot><tr><td colspan=4 style='height:30px; '><b>Total ejemplares: ".($fila-1)."<b></td><tr></tfoot>";

		$html.= "</table>";

		$htmlTabla=$html1.$htmlth1.$html.$htmlTotal;
	//}
		return $htmlTabla;
	}

	function insertarPropiedad($idPoe,$idUser,$codProp,$movimientos,$insTipo,$link){
		$sql="";
		$contador=0;	

		$resultDel=true;
		if($insTipo!="2"){
			$resultDel=eliminarMovimiento($idPoe,$idProp,$codProp, $link);
		}
		if($resultDel){
			foreach ($movimientos as $key => $value) {
				if($value->esNuevo=="h"){
				//	$value->ejemplar=hexToStr($value->ejemplar);
					$value->esNuevo="";
				}
				$value->ejemplar=obtieneNombreCaballo($value->codEjemplar,$link);

			        $sql= "INSERT INTO poe_propiedad(codEjemplar,idPoe,idUser,idProp,fecCrea,esNuevo,nombre,prefijo) VALUES ('".$value->codEjemplar."','".$idPoe."','".$idUser."','".$codProp."',now(),'".$value->esNuevo."','".$value->ejemplar."','".$value->prefijo."');";
			       // echo $sql."<br>";
				    $result = mysqli_query($link,$sql);
				    if($result){
						$contador++;
				  	}
 			}
 		}

		  if(sizeof($movimientos)==$contador){
		  		return true;
		  }else{
			  	return false;
		  }
		
	}

	function eliminarMovimiento($idPoe,$idProp,$codProp,$link){
			
 			$sql="DELETE FROM  poe_propiedad WHERE idProp='".$codProp."' and idPoe=".$idPoe."";
 		    $result = mysqli_query($link,$sql);

			if($result){
				return true;
			}else{
				return false;
			}
		
	}
	function eliminarTodo($idPoe,$idUser,$link){
			
 			$sql="DELETE FROM  poe_propiedad WHERE idPoe='".$idPoe."' and  idUser='".$idUser."' ";
 		    $result = mysqli_query($link,$sql);

			if($result){
				return true;
			}else{
				return false;
			}
		
	}

	function existeRepetidos($movimientos){
			$last="";
			$c=1;
          
			foreach ($movimientos as $key => $value) {
 					$date = explode('/', $value->fecha);
					$time = mktime(0,0,0,$date[1],$date[0],$date[2]);
					$mysqldate = date( 'Y-m-d', $time );	
			        
			        $last=$mysqldate."".$value->tipo."".$value->codEjemplar;
			       // echo $last;
			        			$f=1;
			        			foreach ($movimientos as $key2 => $value2) {
 										$date2 = explode('/', $value2->fecha);
										$time2 = mktime(0,0,0,$date2[1],$date2[0],$date2[2]);
										$mysqldate2 = date( 'Y-m-d', $time2 );	
										$last2=$mysqldate2."".$value2->tipo."".$value2->codEjemplar;
										if($last==$last2 && $c!=$f){
											$c=1;
											return true;	

										}
										$f++;
								}
		 		    $c++;
 			}
 			if($c==0){return false;}

	}
	function validarObligatorios($movimientos){
			$last="";
			$c=1;
          $msg="";
			foreach ($movimientos as $key => $value) {

					if($value->esNuevo=="1" ){

					if($value->prefijo==""  && $msg==""){
						$msg="En la fila ".($key+1).". El prefijo es obligatorio. ";
					}
					if($value->ejemplar==""  && $msg==""){
						$msg="En la fila ".($key+1).". El nombre del ejemplar es obligatorio. ";
					}
					
					if($value->codEjemplar=="" && $msg==""){
						$msg="En la fila ".($key+1).". El codigo de ejemplar es obligatorio. ";
					}
					}
			      
			      if($msg!=""){
						break;
			      }  

 			}
 			 
  		return $msg;
	}
	function eliminar($id,$link){

 			$sql="DELETE FROM  poe_propiedad WHERE id=".$id."";
 		    $result = mysqli_query($link,$sql);

			if($result){
				return true;
			}else{
				return false;
			}

	}

	function listarHtml($link,$idPoe,$idUser,$idProp){

		$sql1="Select propie,cod_criador,criador FROM datos220206 where cod_propie='".$idProp."'";
		//echo $sql1;
		$result = mysql_query($sql1,$link);
		while($res = mysqli_fetch_array($result)){
				$propietario=$res['propie'];
				//$criador=$res['criador'];
		}
		$criador="";
		$periodo=obtenerPeriodoPoe($idPoe);

		$html = "";
		$html .= "<table border=0 style='width:100%;font-family:verdana;font-size:11px;'>";
		$html .= "<tr>";
		$html .= "<td colspan=1 align=left >";
		$html .= "<img src='img/logo2.jpg' />";
		$html .= "</td>";
		$html .= "<td colspan=1 align=right style='font-weight:bold;font-size:10px;'>";
		$html .= "FORMULARIO 1 - ".$idProp;
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2><hr></td></tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2  style='height:40px;font-weight:bold;font-size:18px;'>";
		$html .= "<center>PARTE DE OCURRENCIAS DE EJEMPLARES AÑO $periodo</center>";
		$html .= "</td>";
		$html .= "</tr>";

		$html .= "<tr>";
		$html .= "<td style='height:30px; width:55%;'>";
		$html .= "APELLIDOS Y NOMBRES DEL PROPIETARIO: ";
		$html .= "</td>";
		$html .= "<td>";
		$html .= "<input type='text' style='width:100%;' value='$propietario' /> ";
		$html .= "</td>";
		$html .= "</tr>";

		$html .= "<tr>";
		$html .= "<td  style='height:30px; width:55%;'>";
		$html .= "NOMBRE DEL CRIADERO: ";
		$html .= "</td>";
		$html .= "<td>";
		$html .= "<input type='text' style='width:100%;' value='$criador' /> ";
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<table>";

		$html.= "<label style='font-family:verdana; '><br><CENTER><b>EJEMPLARES  DE MI PROPIEDAD</b></CENTER></label><br>";
		$html.= "<table class='gridHtml' style='width:100%;border-collapse:collapse; font-family:verdana;font-size:11px;' border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th style='height:35px;width:20%;'>Prefijo</th>";
		$html.= "<th style='height:35px;width:35%;'>Nombre del Ejemplar</th>";
		$html.= "<th style='height:35px;width:25%;'>N° del Registro</th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		
		$sql = "SELECT p.id,p.codEjemplar, p.prefijo, p.nombre, p.esNuevo ,true 
						FROM poe_propiedad p WHERE  p.idPoe =".$idPoe." and p.idUser=".$idUser."  
					";
		$result = mysqli_query($link,$sql);
		$fila=0;
		$totMac=0;
		$totHem=0;
		$totCap=0;
		while($res = mysqli_fetch_array($result)){
			 
		if (strpos($res['codEjemplar'],"P") !== false)   $totMac++;
		if (strpos($res['codEjemplar'],"Y") !== false)   $totHem++;
		if (strpos($res['codEjemplar'],"C") !== false)   $totCap++;

		$html.= "<tr id='tbMovimiento_".$res['id']."'>";
		$html.= "<td align='center'>
				<label  id='txtPrefijo_".$fila."' >".$res['prefijo']."</label>
				<input type='hidden' class='cssItem'  id='hidPrefijo_".$fila."' value='".$res['prefijo']."'>
				<input class='cssItem'  type='hidden' name='txtEsNuevo_".$fila."' id='txtEsNuevo_".$fila."' value='".$res['esNuevo']."'/>
				</td>";

				$html.= "<td align='center'>
				<label  id='txtEjemplar_".$fila."' >".($res['nombre'])."</label>
				<input type='hidden' class='cssItem'  id='hidEjemplar_".$fila."' value='".($res['nombre'])."'>
				</td>";

				$html.= "<td align='center'>
				<label  id='txtRegistro_".$fila."' >".$res['codEjemplar']."</label>
				<input type='hidden' class='cssItem'  id='hidRegistro_".$fila."' value='".$res['codEjemplar']."'>
				</td>";

 
			$html.= "</tr>";
			$fila++;
				}
	 	mysqli_free_result($result);

		$html.= "</tbody>";
		$html.= "</table>";

		$html.= "<table style='width:100%;'>";
		$html.= "<tr>";
		$html.= "<td >";

		$html.= "<table border=0 style='width:100%;font-family:verdana;font-size:11px;'>";
		$html.= "<tr><td colspan=4 style='height:20px;'></td></tr>";		
		$html.= "<tr>";
		$html.= "<td>N&deg; de Machos</td>";
		$html.= "<td>$totMac</td><td rowspan=2 style='width:15%;' align=right>FECHA:</td><td rowspan=2 style='width:50%;'>&nbsp;&nbsp;".date('d/m/Y')."</td>";
		$html.= "</tr>";
		$html.= "<tr>";
		$html.= "<td>N&deg; de Hembras</td>";
		$html.= "<td>$totHem</td>";
		$html.= "</tr>";
		$html.= "<tr>";
		$html.= "<td>N&deg; de Capones</td>";
		$html.= "<td>$totCap</td><td rowspan=2  style='width:15%;'align=right>FIRMA:</td><td rowspan=2 style='width:50%;' align='left' valign=bottom><div><hr style='border-color:black;width:150px;margin-left:10px;'></div></td>";
		$html.= "</tr>";
		$html.= "<tr>";
		$html.= "<td><b>N&deg; Total de Ejemplares</b></td>";
		$html.= "<td><b>$fila</b></td>";
		$html.= "</tr>";
		$html.= "<tr><td colspan=4 style='height:40px;'></td></tr>";
		$html.= "<table>";


		$html.= "</td>";
		$html.= "</tr>";
		$html.= "</table>";

		$html.= "<center><div  id='lnkPrint'><a href=# onclick=document.getElementById('lnkPrint').style.display='none';window.print(); >Imprimir</a></div></center>";
	
		return $html;
	}
/*
	function tienePOEAnterior($link,$idProp,$idPoeSel){
		$idPoeLast="0";
		$sql = "SELECT  max(periodo) as periodo,
(max(periodo)-1)periodoAnterior,
max(p.idPoe) as idPoe ,
(select pp.idPoe from poe_programacion pp where pp.periodo=(max(p.periodo)-1))idPoeAnt,
(select count(*) from poe_propiedad where  idProp='$idProp' )  num
 from poe_programacion p 
		left join  poe_propiedad  prop  on(prop.idPoe=p.idPoe and idProp='$idProp') 
		where    p.idPoe=$idPoeSel";
		//echo $sql;
		$result = mysqli_query($link,$sql);
		$n=mysql_num_rows($result);	

		if($n>0){
			$periodoCorte=mysql_result($result,0,"periodo");
			$idPoeLast=mysql_result($result,0,"idPoeAnt");
			if(strlen($idPoeLast)==0){
				$idPoeLast=mysql_result($result,0,"idPoe");
			}
			$tienePropiedad=mysql_result($result,0,"num");
		} 
	 
	 
	 	 
		if($idPoeSel=="1"){
				$idPoeLast="0";
	 	}
		return $idPoeLast;
	}
*/
	function strToHex($string){
    $hex='';
    for ($i=0; $i < strlen($string); $i++){
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}


function hexToStr($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}
function listarPropiedadAgregado($link,$idPoe,$idUser,$idProp){

	$finalizo=EnvioForm($link,$idPoe,$idUser);
		$htmlth1 = "";
		$html = "";
		$html1.= "<table class='gridHtmlSel' style='width:100%;border-collapse:collapse;' border=1 >";
		$htmlth1.= "<thead style='background:#d3d3d3;'>";
		$htmlth1.= "<tr>";
		$htmlth1.= "<th style='height:35px;width:10%;'>Prefijo</th>";
		$htmlth1.= "<th style='height:35px;width:35%;'>Nombre del Ejemplar</th>";
		$htmlth1.= "<th style='height:35px;width:25%;'>N° del Registro</th>";
		$htmlth1.= "<th style='height:35px;width:30%;'>...</th>";
		$htmlth1.= "</tr>";
		$htmlth1.= "</thead>";
		$html.= "<tbody  >";
		 
		$sql = " SELECT p.id,p.codEjemplar codigo, p.prefijo, p.nombre, p.esNuevo ,true esBD 
						FROM poe_propiedad p WHERE  p.idPoe =".$idPoe." and p.idUser=".$idUser."  
						ORDER BY p.nombre,codigo			    	  	
					";

		$result = mysqli_query($link,$sql);
		$fila=1;
		while($res = mysqli_fetch_array($result)){
				$html.= "<tr>";
				$html.= "<td align='left' ><label  id='txtPrefijo_".$fila."' >".$res['prefijo']."</label></td>";
				$html.= "<td align='left'><label  id='txtEjemplar_".$fila."' >".($res['nombre'])."</label></td>";
				$html.= "<td align='center'><label  id='txtRegistro_".$fila."' >".$res['codigo']."</label></td>";
				$html.= "<td align='center'>";
				// if($finalizo!=true){
				 	$html.= "<button class='btnQuitar' data-id=".$res['id']." data-fin=".$finalizo.">Quitar propiedad</button>";
				 //}
				$html.= "</td>";
				$html.= "</tr>";
				$fila++;
				}
	 	mysqli_free_result($result);
		$html.= "</tbody>";
		$htmlTotal= "<tfoot><tr><td colspan=4 style='height:30px; '><b>Total ejemplares de mi propiedad: ".($fila-1)."<b></td><tr></tfoot>";
		$html.= "</table>";
		

			return $html1.$htmlth1.$html.$htmlTotal;
	}
	function listarPropiedadEcu($link,$idEntidad,$columna,$orden,$format){
 		
		$html = "";
		$html1 = "";
		$html1.= "<table class='gridHtml' style='width:100%;border-collapse:collapse;' border=1 >";
		$htmlth1.= "<thead class='  trNoHidden ui-dialog-titlebar ui-widget-header ui-state-default ui-th-column ui-th-ltr'>";
		$htmlth1.= "<tr >";
		//$html.= "<th style='height:35px;width:5%;'></th>";
		if($format=="xls"){
			$htmlth1.= "<th style='height:35px;'> C&oacute;digo </th>";
			$htmlth1.= "<th style='height:35px;'> Prefijo</th>";
			$htmlth1.= "<th style='height:35px;'> Ejemplar </th>";
			$htmlth1.= "<th style='height:35px;'> Pelaje </th>";
			$htmlth1.= "<th style='height:35px;'> Fec Nac. </th>";
			$htmlth1.= "<th style='height:35px;'> Estado </th>";		
			$htmlth1.= "<th style='height:35px;'> Criador </th>";		
			$htmlth1.= "<th style='height:35px;'> C&oacute;digo Padre </th>";		
			$htmlth1.= "<th style='height:35px;'> Prefijo Padre </th>";
			$htmlth1.= "<th style='height:35px;'> Nombre Padre </th>";		
			$htmlth1.= "<th style='height:35px;'> C&oacute;digo Madre </th>";		
			$htmlth1.= "<th style='height:35px;'> Prefijo Madre </th>";
			$htmlth1.= "<th style='height:35px;'> Nombre Madre </th>";		
			 
		}else{
			$htmlth1.= "<th style='height:35px;'>".str_replace("{0}","C&oacute;digo",SetOrdenar(2,$orden,$columna))."</th>";
			$htmlth1.= "<th style='height:35px;'>".str_replace("{0}","Prefijo",SetOrdenar(3,$orden,$columna))."</th>";
			$htmlth1.= "<th style='height:35px;'>".str_replace("{0}","Ejemplar",SetOrdenar(4,$orden,$columna))."</th>";
			$htmlth1.= "<th style='height:35px;'>".str_replace("{0}","Pelaje",SetOrdenar(5,$orden,$columna))."</th>";
			$htmlth1.= "<th style='height:35px;'>".str_replace("{0}","Fec Nac.",SetOrdenar(16,$orden,$columna))."</th>";
			$htmlth1.= "<th style='height:35px;'>".str_replace("{0}","Estado",SetOrdenar(7,$orden,$columna))."</th>";		
			$htmlth1.= "<th style='height:35px;'>".str_replace("{0}","Criador",SetOrdenar(8,$orden,$columna))."</th>";		
			$htmlth1.= "<th style='height:35px;'>".str_replace("{0}","C&oacute;digo Padre",SetOrdenar(9,$orden,$columna))."</th>";		
			$htmlth1.= "<th style='height:35px;'>".str_replace("{0}","Prefijo Padre",SetOrdenar(10,$orden,$columna))."</th>";
			$htmlth1.= "<th style='height:35px;'>".str_replace("{0}","Nombre Padre",SetOrdenar(11,$orden,$columna))."</th>";		
			$htmlth1.= "<th style='height:35px;'>".str_replace("{0}","C&oacute;digo Madre",SetOrdenar(12,$orden,$columna))."</th>";		
			$htmlth1.= "<th style='height:35px;'>".str_replace("{0}","Prefijo Madre",SetOrdenar(13,$orden,$columna))."</th>";
			$htmlth1.= "<th style='height:35px;'>".str_replace("{0}","Nombre Madre",SetOrdenar(14,$orden,$columna))."</th>";		
			$htmlth1.= "<th style='height:35px;'>...</th>";
		}
		$htmlth1.= "</tr>";
		$htmlth1.= "</thead>";
		$html.= "<tbody  >";
		
		 
			//echo "<br>no tiene poe<br>";
			$sql = " 
  				SELECT 0 as id, a.codigo  AS codigo, a.prefij  AS prefijo, a.nombre  as nombre,pelaje,
  				DATE_FORMAT(fecnac, '%d/%m/%Y') fecnac,fallec,criador,
  				codpad,prefpa,nompad,
  				codmad,prefma,nommad,
  				genero,fecnac xfecnac

  				 FROM datos220206 a
  						WHERE 
    					a.cod_propie  =(SELECT idProp FROM sge_propietario WHERE idEntidad=$idEntidad AND flgTipo!='C' limit 0,1) ORDER BY $columna $orden
					";	
				//	 echo "no tiene poe anterior"; 
		 
		//echo $sql;mysqli_query("SET NAMES 'utf8'");
		//mysql_set_charset('utf8',$link);
		mysqli_query($link,'SET NAMES iso-8859-1');
		mysqli_query($link,'SET CHARACTER_SET iso-8859-1');
		$result = mysqli_query($link,$sql);
		$fila=1;
		while($res = mysqli_fetch_array($result)){
			$ejemplar=$res['nombre'];
			 

			$html.= "<tr class='gridHtmlRow' id='tbMovimiento_".$res['id']."'>";
 			$checked='';
 			$prefijo='';
 			$nombre='';
 			$codigo='';
 				if($format!="xls"){
 				if(	$res['fallec']==1){
					$status="<img src='img/silueta.png' border=0 width='16' height=14 alt='Fallecido' title='Fallecido'>&nbsp;<img src='img/qcruz.png' border=0 width='16' height=14 alt='Fallecido' title='fallecido'> ";
					}else{
					$status="<img src='img/silueta.png' border=0 width='16' height=14 alt='ejemplar vivo' title='ejemplar vivo '> ";
					}
				}else{
					if(	$res['fallec']==1){
					$status="Fallecido";
					}else{
					$status="Vivo";
					}
				}
				$html.= "<td align='center'>
				<label  id='txtRegistro_".$fila."' >".$res['codigo']."</label>
				</td>";

				$html.= "<td align='left' >
				<label  id='txtPrefijo_".$fila."' >".$res['prefijo']."</label>
				<input type='hidden' class='cssItem'  id='hidPrefijo_".$fila."' value='".$res['prefijo']."'>
				<input class='cssItem'  type='hidden' name='txtEsNuevo_".$fila."' id='txtEsNuevo_".$fila."' value='".$res['esNuevo']."'/>
				</td>";

				$html.= "<td align='left'>
				<label  id='txtEjemplar_".$fila."' >".htmlentities($ejemplar,iso-8859-1)."</label>
				</td>";

				$html.= "<td align='left'>
				<label  id='txtEjemplar_".$fila."' >".htmlentities($res['pelaje'],iso-8859-1)."</label>
				</td>";

				$html.= "<td align='left'>
				<label  id='txtEjemplar_".$fila."' >".$res['fecnac']."</label>
				</td>";
				
				$html.= "<td align='center'>
				<label  id='txtEjemplar_".$fila."' >".$status."</label></td>";

				$html.= "<td align='left'>
				<label  id='txtRegistro_".$fila."' >".htmlentities($res['criador'],iso-8859-1)."</label>
				</td>";

				$html.= "<td align='left'>
				<label  id='txtRegistro_".$fila."' >".$res['codpad']."</label>
				</td>";

				$html.= "<td align='left'>
				<label  id='txtRegistro_".$fila."' >".$res['prefpa']."</label>
				</td>";
				$html.= "<td align='left'>
				<label  id='txtRegistro_".$fila."' >".htmlentities($res['nompad'],iso-8859-1)."</label>
				</td>";

				$html.= "<td align='left'>
				<label  id='txtRegistro_".$fila."' >".$res['codmad']."</label>
				</td>";
				$html.= "<td align='left'>
				<label  id='txtRegistro_".$fila."' >".$res['prefma']."</label>
				</td>";
				$html.= "<td align='left'>
				<label  id='txtRegistro_".$fila."' >".htmlentities($res['nommad'],iso-8859-1)."</label>
				</td>";
				if($format!="xls"){
				 $html.= "<td align='center'>
				 
				

 						<table border=0 style=' border-collapse:collapse;width:100%;border: hidden!important;'>
								<tr><td >&nbsp;<span class='verArbol cursor'  data-item-id='".$res['codigo']."' title='ir a ver arbol genealogico.' style='bottom: 12px;' ><img src='img/iconDetails/b_relations.png'>&nbsp; Arbol  </span></td>
								<!--</tr>
								<tr>-->
								<td>&nbsp;<span class='verCria cursor'  data-item-id='".$res['codigo']."' data-item-genere='".$res['genero']."' data-item-title='1'  title='ir a ver crias del ejemplar' style='bottom: 6px;' ><img src='img/iconDetails/uno.gif' width='20'>&nbsp; Cr&iacute;as</span></td>
								<!--</tr>
								<tr>-->
								<td>&nbsp;<span class='verImagen cursor'  data-item-id='".$res['codigo']."'  data-item-front='1' title='Ver galeria de imagenes del ejemplar.' ><img src='img/iconDetails/foto.png'>  Galeria </span></td>
								<!--</tr>
								<tr>-->
								<td>&nbsp;<span class='verConcurso cursor'  data-item-id='".$res['codigo']." 'title='ir a ver concursos que participó el ejemplar.' style='top: 5px;' ><img src='img/iconDetails/premio.png' height='15' width='20'> Concursos</span>
								</td></tr>
								</table>

		</td>";
		}

			$html.= "</tr>";
			$fila++;
				}
	 	mysqli_free_result($result);
		$html.= "</tbody>";
		$htmlTotal= "<tfoot><tr><td colspan=4 style='height:30px; ' class='tableFooter'><b>Total ejemplares: ".($fila-1)."<b></td><tr></tfoot>";
		$html.= "</table>";

		$htmlTabla=$html1.$htmlth1.$html.$htmlTotal;
	//}
		return $htmlTabla;
	}
	function SetOrdenar($col,$orden,$colActual){
		if($colActual==$col){
			$htmlth1="<div class='ColOrden'>";
		}else{
			$htmlth1="<div>";
		}
				if( $orden=='asc' ){
			$htmlth1.= "<a href=javascript:listarMiPropiedad($col,'desc'); title='ordernar descendente por {0}' alt='ordernar descendente por {0}'>";
			$iconDesc="<img src='img/desc.png'>";
		}elseif( $orden=='desc' ){
			$htmlth1.= "<a href=javascript:listarMiPropiedad($col,'asc'); title='ordernar ascendente por {0}' alt='ordernar ascendente por {0}'>";
			$iconDesc="<img src='img/asc.png'>";
		}
		$htmlth1.= "{0} $iconDesc </a>";

		$htmlth1.="</div>";

		return $htmlth1;
	}
?>
