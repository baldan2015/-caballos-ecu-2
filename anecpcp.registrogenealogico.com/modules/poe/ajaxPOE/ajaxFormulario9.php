<?php session_start();
require("../../../constante.php");
	date_default_timezone_set("UTC");
	require(DIR_LEVEL_MOD_POE."Clases/conexion.php");
	require(DIR_LEVEL_MOD_POE."Clases/resultado.php");
	require(DIR_LEVEL_MOD_POE."Funciones/general.php");
	$cn=new Connection();
	$link=$cn->Conectar();

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
						 	$retorno->message="Formulario registrado Correctamente.";
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
			$classHtml="class='gridHtml  table table-striped'";
			$propietario="Nuevo Propietario";
			$fecEvento="Fecha";
		}
		else{
			$prefijoTipo="Adqui";
			 $classHtml="class='gridHtmlAdqui  table table-striped'";
			 $propietario="Antiguo Propietario";
			 $fecEvento="Fecha";
		}
		$html = "";
		$html.= "<table $classHtml   >";
		$html.= "<thead  >";
		$html.= "<tr>";
		//$html.= "<th>Tipo</th>";
		$html.= "<th style='height:35px;width:10%;text-align:center;'> Nombre</th>";
		$html.= "<th style=' text-align:center;'>Sexo</th>";
		$html.= "<th style=' text-align:center;'>Pelaje</th>";
		$html.= "<th style='width:90px;text-align:center;'>Fec. Nac.</th>";
		$html.= "<th style=' width:11%;text-align:center;'>Padre</th>";
		$html.= "<th>...</th>";
		$html.= "<th style=' width:11%;text-align:center;'>Madre</th>";
		$html.= "<th>...</th>";
		$html.= "<th style='width:200px;text-align:center;'>Criador</th>";
		$html.= "<th style=' text-align:center;'>Metodo Reprod.</th>";
		$html.= "<th>Estado Sol.</th>";
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
 					SELECT  0 ,'','','',0,a.prefij,
 					a.nombre  as nombre , a.codigo
 				from datos2202062 a 
 				WHERE 
 				a.codigo  not in(select p.codEjemplar from poe_propiedad p WHERE p.idPoe =".$idpoe." and p.idUser='".$idUser."') and
 				a.codigo  not in(select h.codEjemplar from poe_historial h WHERE h.idPoe =".$idpoe." and h.idUser='".$idUser."' and h.tipo in('FA','CA')) and 
 				a.cod_propie ='".$codPro."' and
 				a.codigo not in (
	 							select mov.codEjemplar COLLATE utf8_unicode_ci AS codigo from 
	 								poe_movimiento mov 
									left join datos2202062 dat on(dat.codigo =mov.codEjemplar)
									left join poe_propiedad p on(mov.codEjemplar=p.codEjemplar)
								where 
								mov.idPoe=".$idpoe." and mov.idUser='".$idUser."' and mov.tipo='T'
							) ";
			}

			/*muestra ejemplares no seleccionados como mi propiedad(incluye los adquiridos) y no fallecidos 
			para regulartizar su situacion*/
			$sql = "SELECT DISTINCT * FROM (
SELECT m.id,if (m.fecMov!='0000-00-00',DATE_FORMAT(m.fecMov,'%d/%m/%Y') ,'') as fecha,m.tipo,m.nomContacto,0,
				ifnull(mad.prefij ,p.prefijo) AS prefijo,
				ifnull(mad.nombre ,p.nombre) as ejemplar, 
				m.codEjemplar COLLATE utf8_unicode_ci AS codigo
				from poe_movimiento m 
				left join datos2202062 mad on(mad.codigo  =m.codEjemplar)
				left join poe_propiedad p on(m.codEjemplar=p.codEjemplar and mad.codigo <>p.codEjemplar)
				where 
				m.idPoe=".$idpoe." and m.idUser='".$idUser."' 
				and tipo='T' 

				$queryAddonPeriodoIni

				UNION ALL							
				SELECT 0 ,'','','',0,a.prefij, a.nombre, p.codEjemplar 
	      		FROM poe_movimiento p INNER JOIN datos2202062 a ON a.codigo =p.codEjemplar
	      		WHERE p.idPoe =".$idpoe." and p.idUser=".$idUser."  and p.tipo = 'A'   
    	  		and p.codEjemplar not in( select m.codEjemplar   FROM poe_propiedad m WHERE m.idPoe =".$idpoe."  and m.idUser=".$idUser." )
    	  		AND p.codEjemplar NOT IN(SELECT h.codEjemplar FROM poe_historial h where h.idPoe=".$idpoe." and h.idUser=".$idUser." and tipo='FA' )
    	  		UNION ALL
    	  		SELECT 0,'','','',0, p.prefijo,p.nombre,
					p.codEjemplar COLLATE utf8_unicode_ci AS codigo
					from poe_propiedad p 
					where p.idPoe=".$idPoeAnterior." and p.idUser='".$idUser."'  
					AND p.codEjemplar NOT IN (SELECT p.codEjemplar FROM poe_propiedad p WHERE p.idPoe =".$idpoe." and p.idUser='".$idUser."'  ) 
					AND p.codEjemplar NOT IN(SELECT h.codEjemplar FROM poe_historial h where h.idPoe=".$idpoe." and h.idUser=".$idUser." and tipo='FA' )
					AND p.codEjemplar NOT IN(SELECT mm.codEjemplar FROM poe_movimiento mm where mm.idPoe=".$idpoe." and mm.idUser=".$idUser." and tipo='T' )
					) Q
		 		order by 7";
		 	//	echo $sql ;
			}
			if($tipo=='A'){
			$sql = "SELECT m.id,if (m.fecMov!='0000-00-00',DATE_FORMAT(m.fecMov,'%d/%m/%Y') ,'') as fecha,m.tipo,m.nomContacto,m.idPoe,
				ifnull(mad.prefij ,p.prefijo) AS prefijo,
				ifnull(mad.nombre ,p.nombre) as ejemplar, 
				m.codEjemplar COLLATE utf8_unicode_ci AS codigo,0  as predeterminado
				from poe_movimiento m 
				left join datos2202062 mad on(mad.codigo =m.codEjemplar)
				left join poe_propiedad p on(m.codEjemplar=p.codEjemplar and mad.codigo <>p.codEjemplar)
				where 
				1=0 and m.idPoe=".$idpoe." and m.idUser='".$idUser."'
				AND m.codEjemplar NOT IN(SELECT h.codEjemplar FROM poe_historial h where h.idPoe=".$idpoe." and h.idUser=".$idUser." and h.tipo='FA' )
				and m.tipo='A' ";
//echo $sql ;
			}
		
		$result = mysqli_query($link,$sql);
		$fila=1;
		while($res = mysqli_fetch_array($result)){
				$botonHtml="<label class='btnDel$prefijoTipo' data-key=".$res['id'].">Eliminar</label>";
				if($finalizo==true){
					$botonHtml="";
				}

			 
			$html.= "<tr id='tbMovimiento_".$res['id']."'>";
 		
			if($res['tipo']=='T'){
				$checkedM=" checked";
				$checkedH="  ";
			//	$lblContacto="<label  id='lblStatusProp_".$fila."'>Transferido a:</label>";
			}else{
				$checkedH=" checked";
				$checkedM="  ";
			//	$lblContacto="<label  id='lblStatusProp_".$fila."'>Adquirido de:</label>";
			}
		/*	if($res['predeterminado']=='1'){
				$checkedH=" ";
				$checkedM="  ";
			}*/
			$lblContacto="";
			$html.= "<td align='center'  style='display:none;'>
				<input type='radio' class='cssItem cssRbtn' data-label='lblStatusProp_".$fila."' name='tipo_".$fila."' id='rdbtnT_".$fila."' value='T' $checkedM/><label for='rdbtnT_".$fila."'>Transferencia</label>
				<input type='radio' class='cssItem cssRbtn' data-label='lblStatusProp_".$fila."' name='tipo_".$fila."' id='rdbtnA_".$fila."' value='A' $checkedH/><label for='rdbtnA_".$fila."'>Adquisición</label>
				</td>";
			$html.= "<td align='left'><label  id='txtHorse_".$fila."' >".$res['prefijo']."  ".($res['ejemplar'])." - ".$res['codigo']."</label><input type='hidden' class='cssItem'  id='hidHorse_".$fila."' value='".$res['codigo']."'></td>";
			$html.= "<td align='center'>";
			if($tipo=='A'){
				$html.= "<label  class='btnSearchAll' data-ctrlset='hidHorse_".$fila."' data-ctrlsetdisplay='txtHorse_".$fila."' data-nameradio='tipo_".$fila."' >Buscar</label>";
			}
			$html.= "</td>";
			$html.= "<td align='center'>
			<input type='text'  class='cssFecha$prefijoTipo cssItem' style='width:100px;' name='txtFech_".$fila."' id='txtFech_".$fila."' value='".$res['fecha']."'/>
			</td>";
			$html.= "<td align='left'>
			".$lblContacto."
			<input type='text' class='cssItem cssAutocmplte ui-widget'  name='txtNombre_".$fila."' id='txtNombre_".$fila."'  style='width:90%;' value='".($res['nomContacto'])."'/></td>";
			$html.= "<td align='center'>".$botonHtml." </td>";
			$html.= "</tr>";
			$fila++;
				}
	 	mysqli_free_result($result);
		$html.= "</tbody>";
		$html.= "<tfoot><tr><td colspan=14 style='height:30px; '><b>Total registros: ".($fila-1)."<b></td><tr></tfoot>";
		$html.= "</table>";
		return $html;
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
				$mysqldate="";
				if($value->fecha!="X"){
 					$date = explode('/', $value->fecha);
					$time = mktime(0,0,0,$date[1],$date[0],$date[2]);
					$mysqldate = date( 'Y-m-d H:i:s', $time );
				}else{
					$value->fecha="";
				}
			        $sql= "INSERT INTO  poe_movimiento  ( tipo, codEjemplar,fecMov,nomContacto,idPoe,idUser,fecCrea)VALUES ('".$value->tipo."', '".$value->codEjemplar."','".$mysqldate."',  '".$value->nomContacto."', '".$idPoe."','".$idProp."',now());";

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
		$periodo=obtenerPeriodoPoe($idpoe);
			
		$html = "";

		$html .= "<table border=0 style='width:100%;font-family:verdana;font-size:11px;'>";
		$html .= "<tr>";
		$html .= "<td colspan=1 align=left >";
		$html .= "<img src='".DIR_LEVEL_MOD_POE."img/anecpcp.jpg' />";
		$html .= "</td>";
		$html .= "<td colspan=1 align=right style='font-weight:bold;font-size:10px;'>";
		$html .= "FORMULARIO  - ".$codPropietario;
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2><hr></td></tr>";
		$html .= "<tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2  style='height:40px;font-weight:bold;font-size:18px;'>";
		$html .= "<center>ADQUISICIONES Y TRANSFERENCIAS REALIZADAS DURANTE EL A&Ntilde;O $periodo</center>";
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<table>";

		$html.= "ADQUISICIONES:<BR><table class='gridHtml' style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th>N&deg;</th>";
		$html.= "<th colspan=3 style='width:50%;'>Ejemplar Adquirido</th>";
		$html.= "<th>Fecha</th>";
		$html.= "<th style='width:20%;'>Adquirido de:</th>";
		$html.= "</tr>";
		$html.= "<tr>";
		$html.= "<th></th>";
		$html.= "<th>Prefijo</th>";
		$html.= "<th>Nombre</th>";
		$html.= "<th>N&deg; Registro</th>";
		$html.= "<th></th>";
		$html.= "<th></th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		
		$sql = "SELECT m.id,DATE_FORMAT(m.fecMov,'%d/%m/%Y') as fecha,m.tipo,m.nomContacto,m.idPoe,
				ifnull(mad.prefij ,p.prefijo) AS prefijo,
				ifnull(mad.nombre ,p.nombre) as ejemplar, 
				m.codEjemplar AS codigo
				from poe_movimiento m 
				left join datos2202062 mad on(mad.codigo  =m.codEjemplar)
				left join poe_propiedad p on(m.codEjemplar=p.codEjemplar  and mad.codigo  <>p.codEjemplar)
				where 
				m.idPoe=".$idpoe." and m.idUser='".$idProp."' and m.tipo='A'
				order by 1 ";
		//Secho $sql ;
		$result = mysqli_query($link,$sql);
		$fila=1;
		while($res = mysqli_fetch_array($result)){
			$html.= "<tr>";
			$html.= "<td align='center'>".$fila."</td>";				
			$html.= "<td align='left'>".$res['prefijo']." </td><td> ".($res['ejemplar'])." </td><td> ".$res['codigo']."</td>";
			$html.= "<td align='center'>".$res['fecha']."</td>";
			$html.= "<td align='left'>".($res['nomContacto'])."</td>";
			$html.= "</tr>";
			$fila++;
				}
	 	mysqli_free_result($result);
		$html.= "</tbody>";
		$html.= "</table>";


		///TRANSFERENMCIAS

		$html.= "<BR><BR>TRANSFERENCIAS A TERCEROS:<BR><table class='gridHtml' style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th>N&deg;</th>";
		$html.= "<th colspan=3 style='width:50%;'>Ejemplar Transferido</th>";
		$html.= "<th>Fecha</th>";
		$html.= "<th style='width:20%;'>Transferido a:</th>";
		$html.= "</tr>";
		$html.= "<tr>";
		$html.= "<th></th>";
		$html.= "<th>Prefijo</th>";
		$html.= "<th>Nombre</th>";
		$html.= "<th>N&deg; Registro</th>";
		$html.= "<th></th>";
		$html.= "<th></th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		
		$sql = "SELECT m.id,if (m.fecMov!='0000-00-00',DATE_FORMAT(m.fecMov,'%d/%m/%Y') ,'') as fecha,m.tipo,m.nomContacto,m.idPoe,
				ifnull(mad.prefij ,p.prefijo) AS prefijo,
				ifnull(mad.nombre ,p.nombre) as ejemplar, 
				m.codEjemplar AS codigo
				from poe_movimiento m 
				left join datos2202062 mad on(mad.codigo  =m.codEjemplar)
				left join poe_propiedad p on(m.codEjemplar=p.codEjemplar  and mad.codigo  <>p.codEjemplar)
				where 
				m.idPoe=".$idpoe." and m.idUser='".$idProp."' and m.tipo='T'
				order by 1 ";
		///echo $sql ;
		$result = mysqli_query($link,$sql);
		$fila=1;
		while($res = mysqli_fetch_array($result)){
			$html.= "<tr>";
			$html.= "<td align='center'>".$fila."</td>";				
			$html.= "<td align='left'>".$res['prefijo']." </td><td> ".($res['ejemplar'])." </td><td> ".$res['codigo']."</td>";
			$html.= "<td align='center'>".$res['fecha']."</td>";
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
