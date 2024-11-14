<?php session_start();
		if (file_exists("../entidad/Constantes.php")) {        include_once("../entidad/Constantes.php");    }
	include_once ("../data/modelo.php");    
	include_once("../data/general.php");
	 include_once ("../entidad/Ejemplar.inc.php");
	 include_once ("../entidad/Resultado.inc.php");    
	include_once ("../comunes/lib.comun.php");
	
 	//require("../logica/EntidadLogica.php");
 	date_default_timezone_set("UTC");
	$cn=new dal();
	$link=$cn->conectar2();

	$retorno=new Resultado();

	if(isset($_POST['opc'])){
		if($_POST['opc'] == 'lstMov'){
			$idPoe = $_POST['idPoe'];
			$idProp = $_POST['idProp'];
			$tipo = $_POST['type'];
			$codPro= obtenerIdPropietario($idProp);
			echo listarMovimiento($link,$idPoe,$idProp,$codPro,$tipo);

		}elseif($_POST['opc'] == 'insMov'){
				$a=$_SESSION['_periodoPoe'];
				$b=$_SESSION['xid'];
				 if(!(EnvioForm($link,$a,$b))){

 			 $idUser = $_POST['idUser'];
			 $datos = $_POST['data'];
			 $idPoe = $_POST['idPoe'];
			 $codPro= obtenerIdPropietario($idUser);
			 $datosDecode = json_decode('"' . $datos . '"');
         	 // $movimientos = json_decode($datosDecode);
        	$movimientos = json_decode($datos);
			 
			if(is_array($movimientos) &&  sizeof($movimientos)>0){
				$msgValidate=validarObligatorios($movimientos);
				if($msgValidate==""){
						if(!existeRepetidos($movimientos)){
						 	$result=insertarMovimiento($idPoe,$idUser, $movimientos,$link);
						 	$retorno->result=1;
						 //	$retorno->html=listarMovimiento($link,$idPoe,$idUser,$codPro);
						 	$retorno->message="Se registrado Correctamente.";
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

		} 
		if($_POST['opc'] == 'lstView'){
 			$idPoe = $_POST['idPoe'];
			$idProp = $_POST['idProp'];
			$codPro= obtenerIdPropietario($idProp);
			echo listarHtmlAdmin($link,$idPoe,$idProp,$codPro);
		}
	}
	 
	function listarMovimiento($link,$idpoe,$idUser,$codPro,$tipo){
//echo $tipo;
		$finalizo=EnvioForm($link,$idpoe,$idUser);
		$prefijoTipo="";
		if($tipo=="T"){
			$classHtml="class='gridHtmlT table table-striped'";
			$propietario="Nuevo Propietario";
			$fecEvento="Fecha";
		}
		else{
			$prefijoTipo="Adqui";
			 $classHtml="class='gridHtmlAdqui table table-striped'";
			 $propietario="Antiguo Propietario";
			 $fecEvento="Fecha";
		}
		$html = "";
		$html.= "<table $classHtml   >";
		$html.= "<thead  >";
		$html.= "<tr>";
		//$html.= "<th>Tipo</th>";
		$html.= "<th style='height:35px;width:25%;'>Ejemplar</th>";
		$html.= "<th>...</th>";
		$html.= "<th>$fecEvento</th>";
		$html.= "<th><label>$propietario</label></th>";
		$html.= "<th>...</th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		
		
		if($tipo=='T'){
			$idPoeAnterior=tienePOEAnterior($link,$codPro,$idpoe);
			$queryAddonPeriodoIni=" ";
			if(!($idPoeAnterior>0)){
				/* si es el primer poe - lista ejemplares de la tabla Datos20062206, para incluir*/
				$queryAddonPeriodoIni="UNION ALL
 					SELECT distinct 0,'','','',0,e.prefijo,e.nombre as ejemplar,e.id codigo,'0'codContacto 
						FROM sge_ejemplar e 
						INNER JOIN   sge_propietariolog pl ON e.id=pl.idEjemplar 
					WHERE 
						pl.fecFin IS NULL AND
						e.id NOT IN (
											SELECT h.codEjemplar 
											FROM poe_historial h
											WHERE 		
											h.codEjemplar = e.id AND 
											h.idProp='".$codPro."' AND 
											h.tipo in('FA'))  AND
						e.id NOT IN( 
											SELECT mov.codEjemplar COLLATE utf8_unicode_ci  codigo 
											FROM poe_movimiento mov  
											WHERE  
											e.id =mov.codEjemplar AND 
											mov.idUser='".$codPro."' AND 
											mov.tipo='T'
							) and
						pl.idPropietario ='".$codPro."' ";
			}

			/*muestra ejemplares no seleccionados como mi propiedad(incluye los adquiridos) y no fallecidos 
			para regulartizar su situacion*/
			$sql = "SELECT DISTINCT * FROM ( 
							SELECT m.id,if (m.fecMov!='0000-00-00',m.fecMov ,'') as fecha,
							m.tipo,m.nomContacto,0, 
							ej.prefijo prefijo, 
							ej.nombre ejemplar, 
							m.codEjemplar COLLATE utf8_unicode_ci AS codigo, m.codContacto 
							from poe_movimiento m inner join sge_ejemplar ej on(ej.id =m.codEjemplar) 
							where 
							m.idUser='".$idUser."' 
				and tipo='T' 

				$queryAddonPeriodoIni

				
					) Q
		 		order by  4 desc ";
		 		//echo $sql ;
			}
			
			
			$data = listarPropietario($link,$codigo,$descripcion);
			$datos = $data;
			//print_r($datos);
			/*foreach ($datos as $key => $value){
				echo $value->codContacto;
			}*/
			//echo $data;
		//echo $sql ;	
		$result = mysqli_query($link,$sql);
		//print_r($result);
		$fila=1;
		while($res = mysqli_fetch_array($result)){
				$botonHtml="<label class='btnDel$prefijoTipo   btn btn-default btn-sm glyphicon glyphicon-trash ' data-key=".$res['id']."></label>";
				if($finalizo==true){
					$botonHtml="";
				}

			 
			$html.= "<tr id='tbMovimiento_".$res['id']."'>";
 		
			if($res['tipo']=='T'){
				$checkedM=" checked";
				$checkedH="  ";
			}else{
				$checkedH=" checked";
				$checkedM="  ";
			}
		
			$lblContacto="";
			$html.= "<td align='center'  style='display:none;'>
				<input type='radio' class='cssItemC cssRbtn' data-label='lblStatusProp_".$fila."' name='tipo_".$fila."' id='rdbtnT_".$fila."' value='T' $checkedM/><label for='rdbtnT_".$fila."'>Transferencia</label>
				<input type='radio' class='cssItemC cssRbtn' data-label='lblStatusProp_".$fila."' name='tipo_".$fila."' id='rdbtnA_".$fila."' value='A' $checkedH/><label for='rdbtnA_".$fila."'>Adquisición</label>
				</td>";
			$html.= "<td align='left'><label  id='txtHorse_".$fila."' >".$res['prefijo']."  ".($res['ejemplar'])." - ".$res['codigo']."</label><input type='hidden' class='cssItemC'  id='hidHorse_".$fila."' value='".$res['codigo']."'></td>";
			$html.= "<td align='center'>";
			if($tipo=='A'){
				$html.= "<label  class='btnSearchAll btn btn-default btn-sm glyphicon glyphicon-search' data-ctrlset='hidHorse_".$fila."' data-ctrlsetdisplay='txtHorse_".$fila."' data-nameradio='tipo_".$fila."' > </label>";
			}
			$html.= "</td>";
			$html.= "<td align='center'>
			<input type='date'  class='cssItemC' style='width:130px;' name='txtFech_".$fila."' id='txtFech_".$fila."' value='".$res['fecha']."'/>
			</td>";
			$html.= "<td align='left'>
			".$lblContacto."
			<select   class='cssItemC cssData selectpicker show-tick form-control '  data-live-search='true'  data-size='10'  data-width='100%' id='CodContacto_".$fila."' name='CodContacto_".$fila."' onchange='getVal(this);' >";
			$html.="<option value='0'>SELECCIONE</option>";
			foreach ($datos as $key => $value) {
				//echo $value->value;
				if($value->value == ($res['codContacto']) ){
				$html.="<option value='".($res['codContacto'])."' selected>".$value->descripcion."</option>";
				}else{
				$html.="<option value='".$value->value."'>".$value->descripcion."</option>";	
				}
			}
			$html.="</select>
			<input type='hidden' class='cssItemC cssItemCod'  name='txtCodContacto_".$fila."' id='txtCodContacto_".$fila."' value='".($res['codContacto'])."'/>
			<input type='hidden' class='cssItemC cssItemName'  name='NameContacto_".$fila."' id='NameContacto_".$fila."' value='".($res['nomContacto'])."' />
			</td>";
			$html.= "<td align='center'>".$botonHtml." </td>";
			$html.= "</tr>";
			$fila++;
				}
	 	mysqli_free_result($result);
		$html.= "</tbody>";
		$html.= "<tfoot><tr><td colspan=10 style='height:30px; '><b>Total registros: ".($fila-1)."<b></td><tr></tfoot>";
		$html.= "</table>";
		return $html;
	}


	function listarPropietario($link,$id,$descripcion){
			$sql =" SELECT razonSocial as a,id from sge_entidad order by 1 asc; ";
			//echo $sql;
			$result = mysqli_query($link,$sql);
			 while($fila = mysqli_fetch_array($result)){
                 $obj = new stdClass();
                 $obj->value = $fila['id'];
                 $obj->descripcion = $fila['a']; 
                 $obj->codContacto = $fila['id']; 

                 $producto[] = $obj;
                }
                //print_r($producto);
                mysqli_free_result($result);
               return $producto; 

	}

	function insertarMovimiento($idPoe,$idProp, $movimientos,$link){
		$sql="";
		$contador=0;


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
			$resultDel=eliminarMovimiento($idPoe,$idProp, $link);
		else
			$resultDel=1;
		/* END ADDON DBS 20180302*/

		if($resultDel){
			foreach ($movimientos as $key => $value) {
				$mysqldate=$value->fecha;
				
			        $sql= "INSERT INTO  poe_movimiento  ( tipo, codEjemplar,fecMov,nomContacto,idPoe,idUser,fecCrea,codContacto,aprobado,rechazado)VALUES ('".$value->tipo."', '".$value->codEjemplar."','".$mysqldate."',  '".$value->nomContacto."', '".$idPoe."','".$idProp."',now(),'".$value->codContacto."',0,0);";
			        //echo $sql;
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

	function eliminarMovimiento($idPoe,$idProp,$link){
			
 			$sql="DELETE FROM  poe_movimiento WHERE idPoe='".$idPoe."' AND idUser='".$idProp."'";
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
				if($value->fecha!="X"){
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
 			}
 			if($c==0){return false;}

	}
	function validarObligatorios($movimientos){
			$last="";
			$c=1;
          $msg="";
			foreach ($movimientos as $key => $value) {
				  if($value->fecha!="X"){
					if($value->fecha==""){
						$msg="En la fila ".($key+1).". La fecha es obligatorio. ";
					}
 					if($value->tipo=="" && $msg==""){
						$msg="En la fila ".($key+1)." seleccione el tipo de movimiento. ";
					}
					if($value->codEjemplar==""  && $msg==""){
						$msg="En la fila ".($key+1)." seleccione al ejemplar. ";
					}
			      
			      	if($value->nomContacto=="" && $msg==""){
			      		$msg="En la fila ".($key+1)." el nombre nuevo o antiguo propietario es obligatorio.";
			      	}
			      }
			      if($msg!=""){
						break;
			      }  

 			}
 			 
  		return $msg;
	}
	function eliminar($id,$link){

 			$sql="DELETE FROM  poe_movimiento WHERE id=".$id."";
 		    $result = mysqli_query($link,$sql);

			if($result){
				return true;
			}else{
				return false;
			}

	}

	function listarHtmlAdmin($link,$idpoe,$idProp){

			 
		$codPropietario= obtenerIdPropietario( $idProp);
		//$periodo=obtenerPeriodoPoe($idpoe);
		$txt1="APROBADOS";
		$txt2="RECHAZADOS";
		$txt3="INICIADOS";
		$html = "";

		$html .= "<table border=0 style='width:100%;font-family:verdana;font-size:11px;'>";
		$html .= "<tr>";
		$html .= "<td colspan=1 align=left >";
		$html .= "<img src='images/anecpcp.jpg' />";
		$html .= "</td>";
		$html .= "<td colspan=1 align=right style='font-weight:bold;font-size:10px;'>";
		$html .= "TRANSFERENCIAS A TERCEROS - ".$codPropietario;
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2><hr></td></tr>";
		$html .= "<tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2  style='height:40px;font-weight:bold;font-size:18px;'>";
		$html .= "<center> TRANSFERENCIAS DE MIS EJEMPLARES</center>";
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "</table>";

		$retorno = listarHtmlAdminHistorial($link,$idProp);
		//print_r($retorno);
			// TRANSFERENCIAS APROBADAS 
				$fi1=1;
				$tb1 = "";
				$tb1.= "<BR><BR>TRANSFERENCIAS A TERCEROS ".$txt1.":<BR><table class='gridHtmlT' style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
				//$tb1.= "<thead style='background:#d3d3d3;'>";
				$tb1.= "<thead>";
				$tb1.= "<tr>";
				$tb1.= "<th>N&deg;</th>";
				$tb1.= "<th colspan=3 style='width:50%;'>Ejemplar Transferido</th>";
				$tb1.= "<th>Fecha de registro</th>";
				$tb1.= "<th>Comentario</th>";
				$tb1.= "<th>Fecha de revisión</th>";
				$tb1.= "<th>Fecha de transferencia</th>";
				$tb1.= "<th style='width:20%;'>Transferido a:</th>";
				$tb1.= "</tr>";
				$tb1.= "<tr>";
				$tb1.= "<th></th>";
				$tb1.= "<th>Prefijo</th>";
				$tb1.= "<th>Nombre</th>";
				$tb1.= "<th>N&deg; Registro</th>";
				$tb1.= "<th></th>";
				$tb1.= "<th></th>";
				$tb1.= "<th></th>";
				$tb1.= "<th></th>";
				$tb1.= "<th></th>";
				$tb1.= "</tr>";
				$tb1.= "</thead>";
				$tb1.= "<tbody  >";
					foreach($retorno as $key => $value){
							if($value->estado == "APROBADO"){
								//echo "entrooooooo";
								$tb1.= "<tr>";
								$tb1.= "<td align='center'>".$fi1."</td>";				
								$tb1.= "<td align='left'>".$value->prefijo." </td><td> ".$value->ejemplar." </td><td> ".$value->codigo."</td>";
								$tb1.= "<td align='center'>".$value->fecRegistro."</td>";
								$tb1.= "<td align='center'>".$value->comentario."</td>";
								$tb1.= "<td align='center'>".$value->fecRevision."</td>";
								$tb1.= "<td align='center'>".$value->fecha."</td>";
								$tb1.= "<td align='left'>".$value->nomContacto."</td>";
								$tb1.= "</tr>";
								$fi1++;
							}
					}
			    $tb1.= "</tbody>";
				$tb1.= "</table>";

				$html.=$tb1;

			// TRANSFERENCIAS RECHAZADAS 	

				$fi2=1;
				$tb2 = "";
				$tb2.= "<BR><BR>TRANSFERENCIAS A TERCEROS ".$txt2.":<BR><table class='gridHtmlT' style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
				//$tb2.= "<thead style='background:#d3d3d3;'>";
				$tb2.= "<thead>";
				$tb2.= "<tr>";
				$tb2.= "<th>N&deg;</th>";
				$tb2.= "<th colspan=3 style='width:50%;'>Ejemplar Transferido</th>";
				$tb2.= "<th>Fecha de registro</th>";
				$tb2.= "<th>Comentario</th>";
				$tb2.= "<th>Fecha de revisión</th>";
				$tb2.= "<th>Fecha de transferencia</th>";
				$tb2.= "<th style='width:20%;'>Transferido a:</th>";
				$tb2.= "</tr>";
				$tb2.= "<tr>";
				$tb2.= "<th></th>";
				$tb2.= "<th>Prefijo</th>";
				$tb2.= "<th>Nombre</th>";
				$tb2.= "<th>N&deg; Registro</th>";
				$tb2.= "<th></th>";
				$tb2.= "<th></th>";
				$tb2.= "<th></th>";
				$tb2.= "<th></th>";
				$tb2.= "<th></th>";
				$tb2.= "</tr>";
				$tb2.= "</thead>";
				$tb2.= "<tbody  >";
					foreach($retorno as $key => $value){
							if($value->estado == "RECHAZADO"){
								//echo "entrooooooo";
								$tb2.= "<tr>";
								$tb2.= "<td align='center'>".$fi2."</td>";				
								$tb2.= "<td align='left'>".$value->prefijo." </td><td> ".$value->ejemplar." </td><td> ".$value->codigo."</td>";
								$tb2.= "<td align='center'>".$value->fecRegistro."</td>";
								$tb2.= "<td align='center'>".$value->comentario."</td>";
								$tb2.= "<td align='center'>".$value->fecRevision."</td>";
								$tb2.= "<td align='center'>".$value->fecha."</td>";
								$tb2.= "<td align='left'>".$value->nomContacto."</td>";
								$tb2.= "</tr>";
								$fi2++;
							}
					}
			    $tb2.= "</tbody>";
				$tb2.= "</table>";

				$html.=$tb2;

			// TRANSFERENCIAS INICIADAS
			
				$fi3=1;
				$tb3 = "";
				$tb3.= "<BR><BR>TRANSFERENCIAS A TERCEROS ".$txt3.":<BR><table class='gridHtmlT' style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
				//$tb3.= "<thead style='background:#d3d3d3;'>";
				$tb3.= "<thead>";
				$tb3.= "<tr>";
				$tb3.= "<th>N&deg;</th>";
				$tb3.= "<th colspan=3 style='width:50%;'>Ejemplar Transferido</th>";
				$tb3.= "<th>Fecha de registro</th>";
				$tb3.= "<th>Comentario</th>";
				$tb3.= "<th>Fecha de revisión</th>";
				$tb3.= "<th>Fecha de transferencia</th>";
				$tb3.= "<th style='width:20%;'>Transferido a:</th>";
				$tb3.= "</tr>";
				$tb3.= "<tr>";
				$tb3.= "<th></th>";
				$tb3.= "<th>Prefijo</th>";
				$tb3.= "<th>Nombre</th>";
				$tb3.= "<th>N&deg; Registro</th>";
				$tb3.= "<th></th>";
				$tb3.= "<th></th>";
				$tb3.= "<th></th>";
				$tb3.= "<th></th>";
				$tb3.= "<th></th>";
				$tb3.= "</tr>";
				$tb3.= "</thead>";
				$tb3.= "<tbody  >";
					foreach($retorno as $key => $value){
							if($value->estado == "POR APROBAR"){
								//echo "entrooooooo";
								$tb3.= "<tr>";
								$tb3.= "<td align='center'>".$fi3."</td>";				
								$tb3.= "<td align='left'>".$value->prefijo." </td><td> ".$value->ejemplar." </td><td> ".$value->codigo."</td>";
								$tb3.= "<td align='center'>".$value->fecRegistro."</td>";
								$tb3.= "<td align='center'>".$value->comentario."</td>";
								$tb3.= "<td align='center'>".$value->fecRevision."</td>";
								$tb3.= "<td align='center'>".$value->fecha."</td>";
								$tb3.= "<td align='left'>".$value->nomContacto."</td>";
								$tb3.= "</tr>";
								$fi3++;
							}
					}
			    $tb3.= "</tbody>";
				$tb3.= "</table>";

				$html.=$tb3;


				$html.= "<table border=0 style='width:100%;font-family:verdana;font-size:11px;'>";
				$html.= "<tr><td colspan=4 style='height:50px;'></td></tr>";		
				$html.= "<tr>";
				$html.= "<td style='width:25%;font-weight:bold;' align=left>FECHA IMPPRESIÓN:</td><td style='font-weight:bold;' >&nbsp;&nbsp;".date('d/m/Y')."</td>";
				$nombre = nombreUsuarioImpresion($link,$_SESSION[Constantes::K_SESSION_CODIGO_USUARIO]);
				$html.= "<tr><td style='width:30%;font-weight:bold;' align=left>RESPONSABLE IMPRESIÓN:</td><td style='font-weight:bold;'>&nbsp;&nbsp;".$nombre."</td></tr>";
				$html.= "<table>";


				$html.= "</td>";
				$html.= "</tr>";
				$html.= "</table>";
				$html.= "<center><div  id='lnkPrint'><a href=# onclick=document.getElementById('lnkPrint').style.display='none';window.print(); >Imprimir</a></div></center>";
	
				return $html;
	}

	function listarHtmlAdminHistorial($link,$idProp){


		$sql = "SELECT m.id,if (m.fecMov!='0000-00-00',DATE_FORMAT(m.fecMov,'%d/%m/%Y') ,'') as fecha,m.tipo,m.nomContacto,m.idPoe,
				mad.prefij  AS prefijo,
				mad.nombre  as ejemplar, 
				m.codEjemplar AS codigo,
				(select lh.comentario from poe_log_historial lh where lh.idMovimiento = m.id)comentario,
				(select DATE_FORMAT(lh.fecCrea,'%d/%m/%Y') from poe_log_historial lh where lh.idMovimiento = m.id)fecRevision,
				DATE_FORMAT(m.fecCrea,'%d/%m/%Y')fecRegistro,
				case 
					when m.aprobado = 1 THEN 'APROBADO'
					WHEN m.rechazado = 1 THEN 'RECHAZADO'
					ELSE 'POR APROBAR'
					END AS estado
				from poe_movimiento m 
				left join datos220206 mad on(mad.codigo  =m.codEjemplar)
				where 
				m.idUser='".$idProp."' and m.tipo='T'
				order by 1 ";
		//echo $sql ;
		$result = mysqli_query($link,$sql);
		$fila=1;
		$ejemplar=[];
		while($res = mysqli_fetch_array($result)){
			$obj = new stdClass();
			$obj->id = $res['id'];
			$obj->fecha = $res['fecha'];
			$obj->tipo = $res['tipo'];
			$obj->nomContacto = $res['nomContacto'];
			$obj->idPoe = $res['idPoe'];
			$obj->prefijo = $res['prefijo'];
			$obj->ejemplar = $res['ejemplar'];
			$obj->codigo = $res['codigo'];
			$obj->comentario = $res['comentario'];
			$obj->fecRevision = $res['fecRevision'];
			$obj->fecRegistro = $res['fecRegistro'];
			$obj->estado = $res['estado'];
			$ejemplar[] = $obj;
		}
	 	mysqli_free_result($result);
		return $ejemplar;
	}

	 function nombreUsuarioImpresion($link,$codigo){
 			$sql = "SELECT   GROUP_CONCAT(e.razonSocial  order by p.correlativo asc SEPARATOR ' / ')nombre
					FROM 
					sge_propietario p inner join sge_entidad e on(e.id= p.IdEntidad)  
					WHERE 
					p.IdEntidad='".$codigo."'";
		//echo $sql;
		$result = mysqli_query($link,$sql);
		$nombre ="";
		while($res = mysqli_fetch_array($result)){
			$nombre = $res['nombre'];
		}
	 	mysqli_free_result($result);
		return $nombre;
 	}
?>
