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
			$idProp = $_POST['idProp'];
			echo listarprestamo($link,$idPoe,$idProp);

		}elseif($_POST['opc'] == 'ins'){

					$a=$_SESSION['_periodoPoe'];
				$b=$_SESSION['xid'];
				 if(!(EnvioForm($link,$a,$b))){

 			 $idUser = $_POST['idUser'];
			 $datos = $_POST['data'];
			 $idPoe = $_POST['idPoe'];
			 $datosDecode = json_decode('"' . $datos . '"');
        	 // $prestamos = json_decode($datosDecode);
        	 $prestamos = json_decode($datos);
			 
			if(is_array($prestamos) &&  sizeof($prestamos)>0){
				$msgValidate=validarObligatorios($prestamos);
				if($msgValidate==""){
						if(!existeRepetidos($prestamos)){
						 	$result=insertarprestamo($idPoe,$idUser, $prestamos,$link);
						 	$retorno->result=1;
						 	$retorno->html=listarprestamo($link,$idPoe,$idUser);
						 	$retorno->message="Formulario registrado Correctamente.";
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

		} 

		if($_POST['opc'] == 'lstView'){
 			$idPoe = $_POST['idPoe'];
			$idProp = $_POST['idProp'];
			echo listarHtmlAdmin($link,$idPoe,$idProp);
		}
	}
	 
	function listarprestamo($link,$idpoe,$idProp){

				$finalizo=EnvioForm($link,$idpoe,$idProp);
			
		$html = "";
		$html.= "<table class='gridHtml' style='width:100%;border-collapse:collapse;' border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th >Tipo</th>";
		$html.= "<th style='height:35px;width:30%;'>Ejemplar</th>";
		$html.= "<th>...</th>";
		$html.= "<th>Fecha Inicio</th>";
		$html.= "<th>Fecha Devoluci&oacute;n</th>";
		$html.= "<th><label>Prestamo o cesi&oacute;n al se&ntilde;or:</label></th>";
		$html.= "<th>...</th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		
		$sql = "SELECT m.id,DATE_FORMAT(m.fecIni,'%d/%m/%Y') as fechaIni,
				DATE_FORMAT(m.fecFin,'%d/%m/%Y') as fechaFin,m.tipo,m.nomContacto,m.idPoe,
				ifnull(mad.prefij ,p.prefijo) AS prefijo,
				ifnull(mad.nombre ,p.nombre) as ejemplar, 
				m.codEjemplar  as codigo
				from poe_prestamo m 
				left join datos220206 mad on(mad.codigo=m.codEjemplar)
				left join poe_propiedad p on(m.codEjemplar=p.codEjemplar AND p.idPoe=".$idpoe." and p.idUser='".$idProp."')
				where 
				m.idPoe=".$idpoe." and m.idUser='".$idProp."' 
				 
				order by 1 ";

		//echo $sql ;
		$result = mysqli_query($link,$sql);
		$fila=1;
		while($res = mysqli_fetch_array($result)){
				$botonHtml="<label class='btnDel' data-key=".$res['id'].">Eliminar</label>";
			if($finalizo==true){
				$botonHtml="";
			}
			 
			$html.= "<tr id='tbprestamo_".$res['id']."'>";
 			$checkedPP="  ";
 			$checkedCV="  ";
			if($res['tipo']=='CV'){
				$checkedCV=" checked ";
				$lblContacto="<label  id='lblStatusProp_".$fila."'>Cesión de vientre al señor:</label>";
			}else{
				$checkedPP=" checked ";
				$lblContacto="<label  id='lblStatusProp_".$fila."'>Prestamo al señor:</label>";
			}
			$html.= "<td align='left'>
				<div class='div-tabla' style='width:95%;'>
					<div class='div-fila'>
						<div class='div-columna'><input type='radio' class='cssItem cssRbtn' data-label='lblStatusProp_".$fila."' name='tipo_".$fila."' id='rdbtnCV_".$fila."' value='CV' $checkedCV /></div><div class='div-columna'><label for='rdbtnCV_".$fila."'>Cesi&oacute;n de vientre</label></div>
						<div class='div-columna'><input type='radio' class='cssItem cssRbtn' data-label='lblStatusProp_".$fila."' name='tipo_".$fila."' id='rdbtnPP_".$fila."' value='PP' $checkedPP /></div><div class='div-columna'><label for='rdbtnPP_".$fila."'>Prestamo de Potros a Terceros</label></div>
					</div>		
				</div>
				</td>";
			$html.= "<td align='left'><label  id='txtHorse_".$fila."' >".$res['prefijo']."  ".($res['ejemplar'])." - ".$res['codigo']."</label><input type='hidden' class='cssItem'  id='hidHorse_".$fila."' value='".$res['codigo']."'></td>";
			$html.= "<td align='center'><label  class='btnSearchAll' data-ctrlset='hidHorse_".$fila."' data-ctrlsetdisplay='txtHorse_".$fila."' data-ctrltipo='tipo_".$fila."'  >Buscar</label></td>";
			$html.= "<td align='center'>
			<input type='text'  class='cssFecha cssItem' style='width:100px;' name='txtFechIni_".$fila."' id='txtFechIni_".$fila."' value='".$res['fechaIni']."'/>
			</td>";
			$html.= "<td align='center'>
			<input type='text'  class='cssFecha cssItem' style='width:100px;' name='txtFechFin_".$fila."' id='txtFechFin_".$fila."' value='".$res['fechaFin']."'/>
			</td>";
			$html.= "<td align='left'>
			".$lblContacto."
			<input type='text' class='cssItem cssAutocmplte ui-widget'  name='txtNombre_".$fila."' id='txtNombre_".$fila."'  style='width:250px;' value='".($res['nomContacto'])."'/></td>";
			$html.= "<td align='center'>".$botonHtml." </td>";
			$html.= "</tr>";
			$fila++;
				}
	 	mysqli_free_result($result);
		$html.= "</tbody>";
		$html.= "<tfoot><tr><td colspan=7 style='height:30px; '><b>Total registros: ".($fila-1)."<b></td><tr></tfoot>";
		$html.= "</table>";
		return $html;
	}


	function insertarprestamo($idPoe,$idProp, $prestamos,$link){
		$sql="";
		$contador=0;	
		$resultDel=eliminarprestamo($idPoe,$idProp, $link);
		if($resultDel){
			foreach ($prestamos as $key => $value) {
 					$date = explode('/', $value->fecha);
					$time = mktime(0,0,0,$date[1],$date[0],$date[2]);
					$mysqldate = date( 'Y-m-d H:i:s', $time );

					$mysqldateFin=null;
					if(strlen($value->fechaFin)>0){
	 					$dateFin = explode('/', $value->fechaFin);
						$timeFin = mktime(0,0,0,$dateFin[1],$dateFin[0],$dateFin[2]);
						$mysqldateFin = date( 'Y-m-d H:i:s', $timeFin );
					}
					if($mysqldateFin==""){
						$sql= "INSERT INTO  poe_prestamo  ( tipo, codEjemplar,fecIni,nomContacto,idPoe,idUser,fecCrea)VALUES ('".$value->tipo."', '".$value->codEjemplar."','".$mysqldate."','".$value->nomContacto."', '".$idPoe."','".$idProp."',now());";
						//echo $sql;
					}else{
						$sql= "INSERT INTO  poe_prestamo  ( tipo, codEjemplar,fecIni,fecFin,nomContacto,idPoe,idUser,fecCrea)VALUES ('".$value->tipo."', '".$value->codEjemplar."','".$mysqldate."','".$mysqldateFin."', '".$value->nomContacto."', '".$idPoe."','".$idProp."',now());";	
						//echo $sql;
					}
			        
		 		    $result = mysqli_query($link,$sql);
				    if($result){
						$contador++;
				  	}
 			}
 		}
		  if(sizeof($prestamos)==$contador){
		  		return true;
		  }else{
			  	return false;
		  }
		
	}

	function eliminarprestamo($idPoe,$idProp,$link){
			
 			$sql="DELETE FROM  poe_prestamo WHERE idPoe='".$idPoe."' AND idUser='".$idProp."'";
 		    $result = mysqli_query($link,$sql);

			if($result){
				return true;
			}else{
				return false;
			}
		
	}
	function existeRepetidos($prestamos){
			$last="";
			$c=1;
          
			foreach ($prestamos as $key => $value) {
 					$date = explode('/', $value->fecha);
					$time = mktime(0,0,0,$date[1],$date[0],$date[2]);
					$mysqldate = date( 'Y-m-d', $time );	
			        
			        $last=$mysqldate."".$value->tipo."".$value->codEjemplar;
			       // echo $last;
			        			$f=1;
			        			foreach ($prestamos as $key2 => $value2) {
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
	function validarObligatorios($prestamos){
			$last="";
			$c=1;
          $msg="";
			foreach ($prestamos as $key => $value) {
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

 			$sql="DELETE FROM  poe_prestamo WHERE id=".$id."";
 		    $result = mysqli_query($link,$sql);

			if($result){
				return true;
			}else{
				return false;
			}

	}

	function listarHtmlAdmin($link,$idpoe,$idProp){

			 
			
		$codPropietario= obtenerIdPropietario( $idProp);
		$periodo=obtenerPeriodoPoe($idpoe);
			
		$html = "";

		$html .= "<table border=0 style='width:100%;font-family:verdana;font-size:11px;'>";
		$html .= "<tr>";
		$html .= "<td colspan=1 align=left >";
		$html .= "<img src='img/logo2.jpg' />";
		$html .= "</td>";
		$html .= "<td colspan=1 align=right style='font-weight:bold;font-size:10px;'>";
		$html .= "FORMULARIO 6 - ".$codPropietario;
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2><hr></td></tr>";
		$html .= "<tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2  style='height:40px;font-weight:bold;font-size:18px;'>";
		$html .= "<center>CESION DE VIENTRES Y PRESTAMO DE POTROS DURANTE EL A&Ntilde;O $periodo</center>";
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<table>";

		$html.= "<BR>CESION DE VIENTRES:<BR><table class='gridHtml' style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th rowspan=2 >N&deg;</th>";
		$html.= "<th colspan=3 style='width:40%;'>YEGUA</th>";
		$html.= "<th colspan=2 >PERIODO DE CESION</th>";
		$html.= "<th rowspan=2 style='width:30%;'>CESION DE VIENTRE AL SE&Ntilde;OR:</th>";
		$html.= "</tr>";

		$html.= "<tr>";
		$html.= "<th>Prefijo</th>";
		$html.= "<th>Nombre</th>";
		$html.= "<th>N&deg Registro</th>";
		$html.= "<th>Fecha Inicio</th>";
		$html.= "<th>Fecha Devoluci&oacute;n</th>";
		
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		
		$sql = "SELECT m.id,DATE_FORMAT(m.fecIni,'%d/%m/%Y') as fechaIni,
				DATE_FORMAT(m.fecFin,'%d/%m/%Y') as fechaFin,m.tipo,m.nomContacto,m.idPoe,
				ifnull(mad.prefij ,p.prefijo) AS prefijo,
				ifnull(mad.nombre ,p.nombre) as ejemplar, 
				m.codEjemplar  as codigo
				from poe_prestamo m 
				left join datos220206 mad on(mad.codigo  =m.codEjemplar)
				left join poe_propiedad p on(m.codEjemplar=p.codEjemplar and p.idPoe=".$idpoe." and p.idUser='".$idProp."'  )
				where 
				m.idPoe=".$idpoe." and m.idUser='".$idProp."'  and m.tipo='CV' 
				order by 1 ";
//and m.tipo='CV'
		//echo $sql ;
		$result = mysqli_query($link,$sql);
		$fila=1;
		while($res = mysqli_fetch_array($result)){
			 
			$html.= "<tr>";
			$html.= "<td align='center'>".$fila."</td>";
			$html.= "<td align='left'>".$res['prefijo']." </td><td> ".($res['ejemplar'])."  </td><td>  ".$res['codigo']."</td>";
			$html.= "<td align='center'>".$res['fechaIni']."</td>";
			$html.= "<td align='center'>".$res['fechaFin']."</td>";
			$html.= "<td align='left'>".($res['nomContacto'])."</td>";
			$html.= "</tr>";
			$fila++;
				}
	 	mysqli_free_result($result);
		$html.= "</tbody>";
		$html.= "</table>";


$html.= "<BR>PRESTAMO DE POTROS A TERCEROS:<BR><table class='gridHtml' style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th rowspan=2 >N&deg;</th>";
		$html.= "<th colspan=3 style='width:40%;'>POTRO</th>";
		$html.= "<th colspan=2 >PERIODO DE CESION</th>";
		$html.= "<th rowspan=2 style='width:30%;'>PRESTADO AL SE&Ntilde;OR:</th>";
		$html.= "</tr>";

		$html.= "<tr>";
		$html.= "<th>Prefijo</th>";
		$html.= "<th>Nombre</th>";
		$html.= "<th>N&deg Registro</th>";
		$html.= "<th>Fecha Inicio</th>";
		$html.= "<th>Fecha Devoluci&oacute;n</th>";
		
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		
		$sql = "SELECT m.id,DATE_FORMAT(m.fecIni,'%d/%m/%Y') as fechaIni,
				DATE_FORMAT(m.fecFin,'%d/%m/%Y') as fechaFin,m.tipo,m.nomContacto,m.idPoe,
				ifnull(mad.prefij ,p.prefijo) AS prefijo,
				ifnull(mad.nombre ,p.nombre) as ejemplar, 
				m.codEjemplar  as codigo
				from poe_prestamo m 
				left join datos220206 mad on(mad.codigo  =m.codEjemplar)
				left join poe_propiedad p on(m.codEjemplar=p.codEjemplar)
				where 
				m.idPoe=".$idpoe." and m.idUser='".$idProp."'
				and m.tipo='PP' 
				order by 1 ";
				//p.idPoe=".$idpoe." and p.idUser='".$idProp."
//and m.tipo='CV'
		//echo $sql ;
		$result = mysqli_query($link,$sql);
		$fila=1;
		while($res = mysqli_fetch_array($result)){
			 
			$html.= "<tr>";
			$html.= "<td align='center'>".$fila."</td>";
			$html.= "<td align='left'>".$res['prefijo']." </td><td> ".($res['ejemplar'])."  </td><td>  ".$res['codigo']."</td>";
			$html.= "<td align='center'>".$res['fechaIni']."</td>";
			$html.= "<td align='center'>".$res['fechaFin']."</td>";
			$html.= "<td align='left'>".($res['nomContacto'])."</td>";
			$html.= "</tr>";
			$fila++;
				}
	 	mysqli_free_result($result);
		$html.= "</tbody>";
		$html.= "</table>";


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
?>