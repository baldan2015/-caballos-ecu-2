<?php session_start();
	require("../../../constante.php");
	date_default_timezone_set("UTC");
	require(DIR_LEVEL_MOD_POE."Clases/conexion.php");
	require(DIR_LEVEL_MOD_POE."Clases/resultado.php");
	require(DIR_LEVEL_MOD_POE."Funciones/general.php");
	require("ajaxPelaje.php");
	
	$cn=new Connection();
	$link=$cn->Conectar();

	$retorno=new Resultado();

	if(isset($_POST['opc'])){
		if($_POST['opc'] == 'lstNac'){
			$idPoe = $_POST['idPoe'];
			$idProp = $_POST['idProp'];
			echo listarNacimiento($link,$idPoe,$idProp);

		}elseif($_POST['opc'] == 'insNac'){

				$a=$_SESSION['_periodoPoe'];
				$b=$_SESSION['xid'];
				 if(!(EnvioForm($link,$a,$b))){

			 	$idUser = $_POST['idUser'];
			 $datos = $_POST['data'];
			 $idPoe = $_POST['idPoe'];
			 $datosDecode = json_decode('"' . $datos . '"');
        	// $nacimientos = json_decode($datosDecode);
        	 $nacimientos = json_decode($datos);
			
			if(is_array($nacimientos) &&  sizeof($nacimientos)>0){
				$msgValidate=validarObligatorios($nacimientos);
				if($msgValidate==""){
						if(!existeRepetidos($nacimientos)){
						 	$result=insertarNacimiento($idPoe,$idUser, $nacimientos,$link);
						 	$retorno->result=1;
						 	$retorno->html=listarNacimiento($link,$idPoe,$idUser);
						 	$retorno->message="Formulario registrado Correctamente.";
						 }else{
						 	$retorno->result=2;
						 	$retorno->message="Existen nacimientos duplicados. No pueden existir Nacimientos con fecha,sexo, padre y madre iguales.";
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
	function listarNacimiento($link,$idpoe,$idProp){

			$pelajes=listarPelaje($link);
			$itemsHtml="";

		$finalizo=EnvioForm($link,$idpoe,$idProp);
		



		$html = "";
		$html.= "<table class='gridHtml table table-striped'   >";
		$html.= "<thead  >";
		$html.= "<tr>";
		//$html.= "<th>Nro.</th>";
		$html.= "<th style='width:8%;'>Fecha Nac.</th>";
		$html.= "<th>Sexo</th>";
		$html.= "<th style='height:35px;width:20%;'>Madre</th>";
		$html.= "<th>...</th>";
		$html.= "<th style='width:20%;'>Padre</th>";
		$html.= "<th>...</th>";
		$html.= "<th>Pelaje</th>";
		//$html.= "<th>Nro Registro</th>";
		$html.= "<th>Nombre de Cría</th>";
		$html.= "<th>Fec. Muerte</th>";
		 
		$html.= "<th>...</th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		
		$sql = "select m.id,DATE_FORMAT(m.fecha,'%d/%m/%Y') as fecha,m.sexo,m.pelaje,nroReg,m.nombre,codMadre,codPadre,idPoe,
				mad.prefij prefMadre , mad.nombre madre ,pad.prefij prefPadre , pad.nombre padre
				,DATE_FORMAT(m.fecNacMuerto,'%d/%m/%Y')fecNacMuerto
				from poe_nacimiento m
				inner join datos2202062 pad on( pad.codigo  =  m.codPadre)
				inner join datos2202062 mad on(mad.codigo  =m.codMadre)where idPoe=".$idpoe." and idProp='".$idProp."' order by 1 ";
		// echo $sql ;
		$result = mysqli_query($link,$sql);
		$fila=1;
		
		while($res = mysqli_fetch_array($result)){
			 
				$botonHtml="<button class='btnDel  btn  btn-sm btn-default glyphicon glyphicon-trash' data-key=".$res['id']."> </button>";
			if($finalizo==true){
				$botonHtml="";
			}
			

			$html.= "<tr id='tbConcurso_".$res['id']."'>";
		//	$html.= "<td align='center'>";
		//	$html.= $fila;
		//	$html.= "</td>";
			$html.= "<td>
			<input type='text'  class='cssFecha cssItem  ' style='width:100px;' name='txtFech_".$fila."' id='txtFech_".$fila."' value='".$res['fecha']."'/>
			</td>";
			if($res['sexo']=='M'){
				$checkedM=" checked";
				$checkedH="  ";
			}else{
				$checkedH=" checked";
				$checkedM="  ";
			}
			/*if($res['nacMuerto']=='1'){
				$checkedNC=" checked ";
			}else{
				$checkedNC="  ";
			}*/
			$html.= "<td align='center'>
				<input type='radio' class='cssItem' name='sexo_".$fila."' id='rdbtnM_".$fila."' value='M' $checkedM/><label for='rdbtnM_".$fila."'>M</label>
				<input type='radio' class='cssItem' name='sexo_".$fila."' id='rdbtnH_".$fila."' value='H' $checkedH/><label for='rdbtnH_".$fila."'>H</label>

				</td>";
			$html.= "<td align='left' ><label   id='txtMadre_".$fila."' >".$res['prefMadre']."  ".$res['madre']." - ".$res['codMadre']."</label><input type='hidden' class='cssItem'  id='hidMadre_".$fila."' value='".$res['codMadre']."' ></td>";
			//$html.= "<td align='center'><input class='cssItem' type='text'  id='txtMadre_".$fila."' value='".$res['prefMadre']." - ".$res['madre']."' ><input type='hidden' class='cssItem'  id='hidMadre_".$fila."' value='".$res['codMadre']."' ></td>";
			$html.= "<td align='center'><label  class='btnSearch  btn  btn-sm btn-default  glyphicon glyphicon-search' data-ctrlset='hidMadre_".$fila."' data-ctrlsetdisplay='txtMadre_".$fila."' > </label></td>";

			$html.= "<td align='left'><label  id='txtPadre_".$fila."' >".$res['prefPadre']."  ".$res['padre']." - ".$res['codPadre']."</label><input type='hidden' class='cssItem'  id='hidPadre_".$fila."' value='".$res['codPadre']."'></td>";
			///$html.= "<td align='center'><input class='cssItem' type='text'   id='txtPadre_".$fila."'value='".$res['prefPadre']." - ".$res['padre']."' ><input type='hidden' class='cssItem'  id='hidPadre_".$fila."' value='".$res['codPadre']."'></td>";
			$html.= "<td align='center'><label  class='btnSearch  btn  btn-sm btn-default  glyphicon glyphicon-search' data-ctrlset='hidPadre_".$fila."' data-ctrlsetdisplay='txtPadre_".$fila."' > </label></td>";
			
			//<input type='text'   name='txtPelaje_".$fila."' id='txtPelaje_".$fila."' value='".$res['pelaje']."'/>
			$itemsHtml="";
			$html.= "<td align='center'>
					 <select class='cssItem' name='txtPelaje_".$fila."' id='txtPelaje_".$fila."'>";
					 foreach ($pelajes as $key => $value) {
					 	if($res['pelaje']==$value[nombre]){
								$itemsHtml.="<option selected value=".$value[id]."> ".($value[nombre])."</option>";
					 	}else{
					 			$itemsHtml.="<option value=".$value[id]."> ".($value[nombre])."</option>";
					 	}
				 		
			}
			$html.= "".$itemsHtml."
					 </select>
			</td>";
			//$html.= "<td align='center'>
			//<input type='text'   style='width:80px;'  name='txtNReg_".$fila."' id='txtNReg_".$fila."'/></td>";
			$html.= "<td align='center'>
			<input type='text' class='cssItem  '  style='width:130px;' name='txtNombre_".$fila."' id='txtNombre_".$fila."' value='".($res['nombre'])."'/></td>";
			$fecMuerto=$res['fecNacMuerto'];
			if($fecMuerto=="00/00/0000"){
					$fecMuerto="";
			}
			$html.= "<td align='center'>
			<input type='text'  class='cssFecha2 cssItem  ' style='width:80px;' name='txtFecNacMuerto_".$fila."' id='txtFecNacMuerto_".$fila."' value='".$fecMuerto."'/>
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


	function insertarNacimiento($idPoe,$idProp, $nacimientos,$link){
		$sql="";
		$contador=0;	
		$resultDel=eliminarNacimiento($idPoe,$idProp, $link);
		if($resultDel){
			foreach ($nacimientos as $key => $value) {
 					
 					$date = explode('/', $value->fecha);
					$time = mktime(0,0,0,$date[1],$date[0],$date[2]);
					$mysqldate = date( 'Y-m-d H:i:s', $time );

					$mysqldateMuerte=null;
					if(strlen($value->fecNacMuerte)==10){
						$dateAborto = explode('/', $value->fecNacMuerte);
						$timeAborto = mktime(0,0,0,$dateAborto[1],$dateAborto[0],$dateAborto[2]);
						$mysqldateMuerte = date( 'Y-m-d H:i:s', $timeAborto );
					}
			        $sql= "INSERT INTO  poe_nacimiento  (fecha,sexo,pelaje,nroReg,nombre,codMadre,CodPadre,idPoe,idProp,fecCrea,fecNacMuerto)VALUES ('".$mysqldate."', '".$value->sexo."', '".$value->pelaje."', '0', '".$value->nombre."', '".$value->codMadre."', '".$value->codPadre."', '".$idPoe."','".$idProp."',now(),'".$mysqldateMuerte."');";
		 		    $result = mysqli_query($link,$sql);
				    if($result){
						$contador++;
				  	}
 			}
 		}
		  if($nacimientos==$contador){
		  		return true;
		  }else{
			  	return false;
		  }
		
	}

	function eliminarNacimiento($idPoe,$idProp,$link){
			
 			$sql="DELETE FROM  poe_nacimiento WHERE idPoe='".$idPoe."' AND idProp='".$idProp."'";
 		    $result = mysqli_query($link,$sql);

			if($result){
				return true;
			}else{
				return false;
			}
		
	}
	function existeRepetidos($nacimientos){
			$last="";
			$c=1;
          
			foreach ($nacimientos as $key => $value) {
 					$date = explode('/', $value->fecha);
					$time = mktime(0,0,0,$date[1],$date[0],$date[2]);
					$mysqldate = date( 'Y-m-d', $time );	
			        
			        $last=$mysqldate."".$value->sexo."".$value->codMadre."".$value->codPadre;
			       // echo $last;
			        			$f=1;
			        			foreach ($nacimientos as $key2 => $value2) {
 										$date2 = explode('/', $value2->fecha);
										$time2 = mktime(0,0,0,$date2[1],$date2[0],$date2[2]);
										$mysqldate2 = date( 'Y-m-d', $time2 );	
										$last2=$mysqldate2."".$value2->sexo."".$value2->codMadre."".$value2->codPadre;
										 //echo "****".$last2."----c..".$c."f..".$f;
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
	function validarObligatorios($nacimientos){
			$last="";
			$c=1;
          $msg="";
			foreach ($nacimientos as $key => $value) {

					if($value->fecha==""){
						$msg="En la fila ".($key+1).". La fecha es obligatorio. ";
					}
 					if($value->sexo=="" && $msg==""){
						$msg="En la fila ".($key+1)." seleccione el sexo del recien nacido. ";
					}
					if($value->codMadre==""  && $msg==""){
						$msg="En la fila ".($key+1)." seleccione la madre. ";
					}
					if($value->codPadre==""  && $msg==""){
						$msg="En la fila ".($key+1)." seleccione al padre. ";
					}
			      
			      if($msg!=""){
						break;
			      }  

 			}
 			 
  		return $msg;
	}
	function eliminar($id,$link){

 			$sql="DELETE FROM  poe_nacimiento WHERE id=".$id."";
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
		$html .= "<img src='".DIR_LEVEL_MOD_POE."img/anecpcp.jpg'  />";
		$html .= "</td>";
		$html .= "<td colspan=1 align=right style='font-weight:bold;font-size:10px;'>";
		$html .= "FORMULARIO 2 - ".$codPropietario;
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2><hr></td></tr>";
		$html .= "<tr>";
		$html .= "<tr>";
		$html .= "<td colspan=2  style='height:40px;font-weight:bold;font-size:18px;'>";
		$html .= "<center>RELACION DE NACIMIENTOS AÑO $periodo</center>";
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<table>";

		 
		$html.= "<table class='gridHtml' style='width:100%;border-collapse:collapse;font-family:verdana;font-size:11px;' border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th style='width:20px;'>N&deg;</th>";
		$html.= "<th style='width:80px;'>Fec. Nac.</th>";
		$html.= "<th colspan=2>Sexo</th>";
		$html.= "<th colspan=3>Madre</th>";
		$html.= "<th colspan=3>Padre</th>";
		$html.= "<th>Pelaje</th>";
		$html.= "<th>Nombre de Cría</th>";
		$html.= "<th>Fec Nac Muerto</th>";
		$html.= "</tr>";
		$html.= "<th style='width:20px;'></th>";
		$html.= "<th style='width:80px;'></th>";
		$html.= "<th colspan=2></th>";
		$html.= "<th>Prefijo</th>";
		$html.= "<th>Nombre</th>";
		$html.= "<th>Codigo</th>";
		$html.= "<th>Prefijo</th>";
		$html.= "<th>Nombre</th>";
		$html.= "<th>Codigo</th>";
		$html.= "<th> </th>";
		$html.= "<th> </th>";
		$html.= "<th> </th>";
		$html.= "</tr>";
		$html.= "</thead>";
		$html.= "<tbody  >";
		
		$sql = "select m.id,DATE_FORMAT(m.fecha,'%d/%m/%Y') as fecha,m.sexo,m.pelaje,nroReg,m.nombre,codMadre,codPadre,idPoe,
				mad.prefij prefMadre , mad.nombre madre ,pad.prefij prefPadre , pad.nombre padre,DATE_FORMAT(m.fecNacMuerto,'%d/%m/%Y') fecNacMuerto
				from poe_nacimiento m
				inner join datos2202062 pad on( pad.codigo  =  m.codPadre)
				inner join datos2202062 mad on(mad.codigo  =m.codMadre)where idPoe=".$idpoe." and idProp='".$idProp."' order by 1 ";
		//echo $sql ;
		$result = mysqli_query($link,$sql);
		$fila=1;
		while($res = mysqli_fetch_array($result)){
			 
			$html.= "<tr>";
			$html.= "<td>".$fila."</td>";
			$html.= "<td>".$res['fecha']."</td>";
			if($res['sexo']=='M'){
				$checkedM=" M ";
				$checkedH=" &nbsp;&nbsp; ";
			}else{
				$checkedH=" H ";
				$checkedM=" &nbsp;&nbsp; ";
			}
			$html.= "<td align='center' style='width:20px;'>$checkedM</td>				
					 <td align='center' style='width:20px;'>$checkedH</td>";				
			$html.= "<td align='center'>".$res['prefMadre']."</td>";
			$html.= "<td align='center'>".$res['madre']."</td>";
			$html.= "<td align='center'>".$res['codMadre']."</td>";

			$html.= "<td align='center'>".$res['prefPadre']."</td>";
			$html.= "<td align='center'>".$res['padre']."</td>";
			$html.= "<td align='center'>".$res['codPadre']."</td>";

			$html.= "<td align='center'>".($res['pelaje'])."</td>";
			$html.= "<td align='center'>".($res['nombre'])."</td>";

			$fecNacMuerto="";
			if($res['fecNacMuerto']!="00/00/0000"){
				$fecNacMuerto=$res['fecNacMuerto'];
			}

			$html.= "<td align='center'>".$fecNacMuerto."</td>";
			$html.= "</tr>";
			$fila++;
				}
	 	mysqli_free_result($result);
		$html.= "</tbody>";
		$html.= "</table>";



		$html.= "<table border=0 style='width:100%;font-family:verdana;font-size:11px;'>";
		$html.= "<tr><td colspan=4 style='height:40px;'></td></tr>";		
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
