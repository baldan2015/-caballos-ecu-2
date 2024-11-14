<?php session_start();
	 date_default_timezone_set("UTC");
	require("../Clases/conexion.php");
	require("../Clases/resultado.php");
	require("../Funciones/general.php");

	$cn=new Connection();
	$link=$cn->Conectar();

	$retorno=new Resultado();

	if(isset($_POST['opc'])){
		if($_POST['opc'] == 'lst'){
			$idPoe = $_POST['idPoe'];
			$idProp = $_POST['idProp'];
			echo listar($link,$idPoe,$idProp);

		}elseif($_POST['opc'] == 'insServ'){


				$a=$_SESSION['_periodoPoe'];
				$b=$_SESSION['xid'];
				 if(!(EnvioForm($link,$a,$b))){

 			 $idUser = $_POST['idUser'];
			 $datos = $_POST['data'];
			 $idPoe = $_POST['idPoe'];
			 $datosDecode = json_decode('"' . $datos . '"');
        	// $servicios = json_decode($datosDecode);
        	 $servicios = json_decode($datos);
			 
			if(is_array($servicios) &&  sizeof($servicios)>0){
				$msgValidate=validarObligatorios($servicios);
				if($msgValidate==""){
						if(!existeRepetidos($servicios)){
						 	$result=insertar($idPoe,$idUser, $servicios,$link);
						 	$retorno->result=1;
						 	$retorno->html=listar($link,$idPoe,$idUser);
						 	$retorno->message="Formulario registrado Correctamente.";
						 }else{
						 	$retorno->result=2;
						 	$retorno->message="Existen servicios duplicados. No pueden existir Servicios con fecha,potro y yegua iguales.";
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
			 
		}elseif($_POST['opc'] == 'delNac'){
			
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
	 
	function listar($link,$idpoe,$idProp){

			 $finalizo=EnvioForm($link,$idpoe,$idProp);
			
		$html = "";
		$html.= "<table class='gridHtml' style='width:100%;border-collapse:collapse;' border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th style='height:35px;width:23%;'>Potros de mi propiedad y potros de terceros bajo mi responsabilidad</th>";
		$html.= "<th style='width:30px;'>...</th>";
		$html.= "<th style='width:23%;'>Yeguas de terceros</th>";
		$html.= "<th style='width:30px;'>...</th>";
		$html.= "<th>Metodo Reproductivo</th>";
		$html.= "<th style='width:100px;'>Fecha del Ultimo Servicio</th>";
		$html.= "<th style='width:30px;'>...</th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		
		$sql = " SELECT m.id,DATE_FORMAT(m.fecServ,'%d/%m/%Y') as fecha,m.metodo,codYegua,codPotro,idPoe,
				ifnull(mad.prefij,(select p.prefijo COLLATE utf8_unicode_ci from poe_propiedad p where p.codEjemplar=m.codYegua and  idPoe=".$idpoe." and idUser='".$idProp."')) prefYegua ,
				ifnull(mad.nombre,(select p.nombre COLLATE utf8_unicode_ci from poe_propiedad p where p.codEjemplar=m.codYegua and  idPoe=".$idpoe." and idUser='".$idProp."')) yegua ,
				ifnull(pad.prefij,(select p.prefijo COLLATE utf8_unicode_ci from poe_propiedad p where p.codEjemplar=m.codPotro and  idPoe=".$idpoe." and idUser='".$idProp."')) prefPotro ,
				ifnull(pad.nombre,(select p.nombre COLLATE utf8_unicode_ci from poe_propiedad p where p.codEjemplar=m.codPotro and  idPoe=".$idpoe." and idUser='".$idProp."')) potro ,
				isTE
				from poe_serviciop m 
				left join datos220206 pad on( pad.codigo  = m.codPotro) 
				left join datos220206 mad on(mad.codigo  =m.codYegua)where  idPoe=".$idpoe." and idUser='".$idProp."' order by 1
				";
		// echo $sql;  
		$result = mysqli_query($link,$sql);
		$fila=1;
		while($res = mysqli_fetch_array($result)){

			$botonHtml="<label class='btnDel' data-key=".$res['id'].">Eliminar</label> ";
			if($finalizo==true){
				$botonHtml="";
			}
			 	$checkedMN="  ";
				$checkedSF="  ";
				$checkedSR="  ";
				$checkedSC="  ";
				$checkedTE="  ";
			$html.= "<tr id='tbConcurso_".$res['id']."'>";
			if($res['metodo']=='MN'){
				$checkedMN=" checked";
			}else if($res['metodo']=='SF'){
				$checkedSF=" checked ";
			}else if($res['metodo']=='SR'){
				$checkedSR=" checked ";
			}else if($res['metodo']=='SC'){
				$checkedSC=" checked ";
			}
			if($res['isTE']=='1'){
				$checkedTE=" checked ";
			}
			$html.= "<td align='left'><label   id='txtPotro_".$fila."' >".$res['prefPotro']." ".($res['potro'])." - ".$res['codPotro']."</label><input type='hidden' class='cssItem'  id='hidPotro_".$fila."' value='".$res['codPotro']."' ></td>";
			$html.= "<td align='center'><label  class='btnSearch' data-ctrlset='hidPotro_".$fila."' data-ctrlsetdisplay='txtPotro_".$fila."' >Buscar</label></td>";
			$html.= "<td align='left'><label  id='txtYegua_".$fila."' >".$res['prefYegua']."  ".($res['yegua'])." - ".$res['codYegua']."</label><input type='hidden' class='cssItem'  id='hidYegua_".$fila."' value='".$res['codYegua']."'></td>";
			$html.= "<td align='center'><label  class='btnSearch' data-ctrlset='hidYegua_".$fila."' data-ctrlsetdisplay='txtYegua_".$fila."' >Buscar</label></td>";
			$html.= "<td align='center' style='width:500px;'>
						   				<div class='div-tabla'>
							 	 			<div class='div-fila'>
							 					<div class='div-columna'><input type='radio' class='cssItem' name='metodo_".$fila."' id='rdbtnMN_".$fila."' value='MN' $checkedMN /></div><div class='div-columna'><label for='rdbtnMN_".$fila."' class='thItem'>Monta Natural</label></div>
							 					<div class='div-columna'><input type='radio' class='cssItem' name='metodo_".$fila."' id='rdbtnSF_".$fila."' value='SF' $checkedSF /></div><div class='div-columna'><label for='rdbtnSF_".$fila."' class='thItem'>Semen Fresco</label></div>
							 					<div class='div-columna'><input type='radio' class='cssItem' name='metodo_".$fila."' id='rdbtnSR_".$fila."' value='SR' $checkedSR /></div><div class='div-columna'><label for='rdbtnSR_".$fila."' class='thItem'>Semen Refrigerado</label></div>
							 					<div class='div-columna'><input type='radio' class='cssItem' name='metodo_".$fila."' id='rdbtnSC_".$fila."' value='SC' $checkedSC /></div><div class='div-columna'><label for='rdbtnSC_".$fila."' class='thItem'>Semen Congelado</label></div>
							 					<div class='div-columna'><input type='checkbox' class='cssItem' name='CheckMet_".$fila."' id='rdbtnTE_".$fila."' value='TE' $checkedTE /></div><div class='div-columna'><label for='rdbtnTE_".$fila."' class='thItem'>Transferencia de Embriones</label></div>
							 	 			</div>
							 			</div>
					</td>";
			$html.= "<td>
			<input type='text'  class='cssFecha cssItem' style='width:80px;' name='txtFech_".$fila."' id='txtFech_".$fila."' value='".$res['fecha']."'/>
			</td>";
			$html.= "<td align='center'>".$botonHtml."</td>";
			$html.= "</tr>";
			$fila++;
				}
	 	mysqli_free_result($result);
		$html.= "</tbody>";
		$html.= "<tfoot><tr><td colspan=10 style='height:30px; '><b>Total registros: ".($fila-1)."<b></td><tr></tfoot>";
		$html.= "</table>";
		return $html;
	}


	function insertar($idPoe,$idProp, $servicios,$link){
		$sql="";
		$contador=0;	
		$resultDel=eliminarServicio($idPoe,$idProp, $link);
		if($resultDel){
			foreach ($servicios as $key => $value) {

					$isTE="0";
					if($value->isTE){ $isTE="1";}

 					$date = explode('/', $value->fecha);
					$time = mktime(0,0,0,$date[1],$date[0],$date[2]);
					$mysqldate = date( 'Y-m-d H:i:s', $time );
			        $sql= "INSERT INTO  poe_serviciop  (fecServ,metodo,codYegua,codPotro,idPoe,idUser,fecCrea,isTE)VALUES ('".$mysqldate."', '".$value->metodo."', '".$value->codYegua."', '".$value->codPotro."', '".$idPoe."','".$idProp."',now(),".$isTE.");";
		 		    $result = mysqli_query($link,$sql);
				    if($result){
						$contador++;
				  	}
 			}
 		}
		  if($servicios==$contador){
		  		return true;
		  }else{
			  	return false;
		  }
		
	}

	function eliminarServicio($idPoe,$idProp,$link){
			
 			$sql="DELETE FROM  poe_serviciop WHERE idPoe='".$idPoe."' AND idUser='".$idProp."'";
 		    $result = mysqli_query($link,$sql);

			if($result){
				return true;
			}else{
				return false;
			}
		
	}
	function existeRepetidos($servicios){
			$last="";
			$c=1;
          /*
			foreach ($servicios as $key => $value) {
 					$date = explode('/', $value->fecha);
					$time = mktime(0,0,0,$date[1],$date[0],$date[2]);
					$mysqldate = date( 'Y-m-d', $time );	
			        
			        $last=$mysqldate."".$value->codYegua."".$value->codPotro;
			        			$f=1;
			        			foreach ($servicios as $key2 => $value2) {
 										$date2 = explode('/', $value2->fecha);
										$time2 = mktime(0,0,0,$date2[1],$date2[0],$date2[2]);
										$mysqldate2 = date( 'Y-m-d', $time2 );	
										$last2=$mysqldate2."".$value2->codYegua."".$value2->codPotro;
										if($last==$last2 && $c!=$f){
											$c=1;
											return true;	

										}
										$f++;
								}
		 		    $c++;
 			}
 			if($c==0){return false;}
 			*/
 			return false;

	}
	function validarObligatorios($servicios){
			$last="";
			$c=1;
          $msg="";
			foreach ($servicios as $key => $value) {

					
 					/*if($value->metodo=="" && $msg==""){
						$msg="En la fila ".($key+1)." seleccione el sexo del recien nacido. ";
					}*/
					if($value->codPotro==""  && $msg==""){
						$msg="En la fila ".($key+1).". La selecci&oacute;n del Potro es obligatorio. ";
					}
					if($value->codYegua==""  && $msg==""){
						$msg="En la fila ".($key+1).". La selecci&oacute;n de la Yegua es obligatorio. ";
					}
					
					if($value->fecha=="" && $msg==""){
						$msg="En la fila ".($key+1).". La fecha es obligatorio. ";
					}
			      
			      if($msg!=""){
						break;
			      }  

 			}
 			 
  		return $msg;
	}
	function eliminar($id,$link){

 			$sql="DELETE FROM  poe_serviciop WHERE id=".$id."";
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
		$html .= "FORMULARIO 4 - ".$codPropietario;
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2><hr></td></tr>";
		$html .= "<tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2  style='height:40px;font-weight:bold;font-size:18px;'>";
		$html .= "<center>
		RELACION DE SERVICIOS EFECTUADOS DE MIS POTROS Y POTROS DE TERCEROS A YEGUAS DE TERCEROS DURANTE EL A&Ntilde;O $periodo</center>";
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<table>";

		$html.= "<table class='gridHtml' style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th style='width:2%;'>N&deg;</th>";
		$html.= "<th colspan=3 style='width:30%;'>POTROS DE MI PROPIEDAD Y TERCEROS BAJO MIS RESPONSABILIDAD</th>";
 
		$html.= "<th   colspan=3 style='width:30%;'>YEGUA DE TERCEROS</th>";		
		$html.= "<th colspan=5>Metodo Reproductivo</th>";
		$html.= "<th style='width:100px;'>Fecha del Servicio</th>";
		$html.= "</tr>";

		$html.= "<tr>";
		$html.= "<th></th>";
		$html.= "<th>Prefijo</th>";
		$html.= "<th>Nombre</th>";
		$html.= "<th>N&deg; Registro</th>";

		$html.= "<th>Prefijo</th>";
		$html.= "<th>Nombre</th>";
		$html.= "<th>N&deg; Registro</th>";

		$html.= "<th style='width:100px;'>Monta Natural (MN)</th>";
		$html.= "<th style='width:100px;'>Semen Fresco </th>";
		$html.= "<th style='width:100px;'>Semen Refrigerado</th>";
		$html.= "<th style='width:100px;'>Semen Congelado</th>";
		$html.= "<th style='width:100px;'>Transferencia de Embriones (TE)</th>";

		$html.= "<th></th>";
		$html.= "</tr>";

		$html.= "</thead>";
		$html.= "<tbody  >";
		
		$sql = " SELECT m.id,DATE_FORMAT(m.fecServ,'%d/%m/%Y') as fecha,m.metodo,codYegua,codPotro,idPoe,
				ifnull(mad.prefij,(select p.prefijo COLLATE utf8_unicode_ci from poe_propiedad p where p.codEjemplar=m.codYegua and  idPoe=".$idpoe." and idUser='".$idProp."')) prefYegua ,
				ifnull(mad.nombre,(select p.nombre COLLATE utf8_unicode_ci from poe_propiedad p where p.codEjemplar=m.codYegua and  idPoe=".$idpoe." and idUser='".$idProp."')) yegua ,
				ifnull(pad.prefij,(select p.prefijo COLLATE utf8_unicode_ci from poe_propiedad p where p.codEjemplar=m.codPotro and  idPoe=".$idpoe." and idUser='".$idProp."')) prefPotro ,
				ifnull(pad.nombre,(select p.nombre COLLATE utf8_unicode_ci from poe_propiedad p where p.codEjemplar=m.codPotro and  idPoe=".$idpoe." and idUser='".$idProp."')) potro,
				isTE 
				from poe_serviciop m 
				left join datos220206 pad on( pad.codigo  = m.codPotro) 
				left join datos220206 mad on(mad.codigo =m.codYegua)where  idPoe=".$idpoe." and idUser='".$idProp."' order by 1
				";
		   
		$result = mysqli_query($link,$sql);
		$fila=1;
		while($res = mysqli_fetch_array($result)){
			 	$checkedMN="  ";
				$checkedSF="  ";
				$checkedSR="  ";
				$checkedSC="  ";
				$checkedTE="  ";
			$html.= "<tr id='tbConcurso_".$res['id']."'>";
			if($res['metodo']=='MN'){
				$checkedMN=" X ";
			}else if($res['metodo']=='SF'){
				$checkedSF=" X ";
			}else if($res['metodo']=='SR'){
				$checkedSR=" X ";
			}else if($res['metodo']=='SC'){
				$checkedSC=" X ";
			}
			 if($res['isTE']=='1'){
				$checkedTE=" X ";
			}
			$html.= "<td align='left' style='width:20px;'>".$fila."</td>";

			$html.= "<td align='left'>".$res['prefPotro']." </td><td>".($res['potro'])." </td><td> ".$res['codPotro']."</td>";
			$html.= "<td align='left'>".$res['prefYegua']."</td><td>".($res['yegua'])." </td><td> ".$res['codYegua']."</td>";			

			$html.= "<td align='center' style='width:100px;'>".$checkedMN."</td>";
			$html.= "<td  align='center' style='width:100px;'>".$checkedSF."</td>";
			$html.= "<td  align='center' style='width:100px;'>".$checkedSR."</td>";
			$html.= "<td  align='center' style='width:100px;'>".$checkedSC."</td>";
			$html.= "<td  align='center' style='width:100px;'>".$checkedTE."</td>";

			 
			$html.= "<td>".$res['fecha']."</td>";
			
			$html.= "</tr>";
			$fila++;
				}
	 	mysqli_free_result($result);
		$html.= "</tbody>";
		$html.= "</table>";

		$html.= "<table border=0 style='width:100%;font-family:verdana;font-size:11px;'>";
		$html.= "<tr><td colspan=4 style='height:40px;'></td></tr>";		
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
