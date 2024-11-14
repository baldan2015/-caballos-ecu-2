<?php session_start();
	require("../Clases/conexion.php");
	require("../Clases/resultado.php");
	require("../Funciones/general.php");


	$cn=new Connection();
	$link=$cn->Conectar();

	$retorno=new Resultado();
	$idUser= $_SESSION['xid'];
    $idProp=obtenerIdPropietario($idUser);// '00843';//session del usuario logeado [xid]
	if(isset($_POST['opc'])){

		if($_POST['opc'] == 'ins'){
			$retorno=new Resultado();
			$origen=$_POST['source'];
			$datos = $_POST['premio'];
			if($origen==1)$idProp=$_POST['idProp'];
			//$datosDecode = json_decode('"' . $datos . '"');
	        //$inscripciones = json_decode($datosDecode);
	         $inscripciones = json_decode($datos);
	         $msg="";
	         //print_r($inscripciones);
	         //echo "<pre>";
	         $retorno->result=1;			 
	         $flagCampeon=false;
	         $flagCampeonCatego=false;
	         foreach ($inscripciones as $key => $value) {

	         $flgPremCatego=$value->idCatego;
	         $desCategoria="";
	         $flagCampeon=esCampeon($link,$value->idEjemplar);
	         		 

	         if($value->idCatego=="0"){// && (!($flagCampeon))){
	         	    $flagCampeonCatego=false;
					$categoria=obtenerCategoriaEjemplar($link,$value->idEjemplar,$value->idConcurso,$flagCampeon);
					$desCategoria=$categoria['nombre'];
					$value->idCatego=$categoria['id'];
				  	 $flagCampeonCatego=false;
			 }else{
					$desCategoria=$value->categoria;
					$pos = strpos(strtoupper($desCategoria), "AMPE");
					if($pos ==true && !($flagCampeon)){
						$flagCampeon=true;
						$flagCampeonCatego=true;
					}
			 }
			   
			 	if(!$flagCampeonCatego){
			         if($desCategoria!=""){

			         	$textAddon=(($flgPremCatego=="0") ? '  ':' premio especial ').$desCategoria."  ";
			         	if(existeInscripcionBD($link,$idProp,$value->idConcurso,$value->idCatego,$value->idEjemplar)){
							$msg=$msg."<span class='msgError'>".$value->prefijo."  ".$value->nombre." - ".$value->idEjemplar." ya fu&eacute; inscrito a". $textAddon." Seleccione otro.</span> </br>";
						}else{
							$tarifa=obtieneTarifaConcurso($link,$value->idConcurso,$idProp);
		             		$added=  agregarInscripcion($idProp,
		             					$value->idConcurso,
		             					$value->idEjemplar,
		             					$value->idCatego,
		             					$value->prefijo,
		             					$value->nombre,
		             					$value->concurso,
		             					$desCategoria,$tarifa);

				             if($added!="true"){
				             	$msg=$msg."<span class='msgError'>".$value->prefijo."  ".$value->nombre." - ".$value->idEjemplar." ya está preinscrito a".$textAddon." . Seleccione otro.</span> </br>";
				             }else{
								$msg=$msg."<span class='msgSuccess'>".$value->prefijo."  ".$value->nombre." - ".$value->idEjemplar." ha sido agregado correctamente a".$textAddon." en la lista de preinscripción.</span> </br>";
				             } 
				         }

				     }else{
						$msg=$msg."<span class='msgError'>".$value->prefijo."  ".$value->nombre." - ".$value->idEjemplar." no cuenta con una categor&iacute;a para concursar.</span></br>";
						$retorno->result=0;			 
				     }   
				 }else{
				 	$retorno->result=0;	
				 	if($flagCampeonCatego){
				 		$msg=$msg."<span class='msgError'>".$value->prefijo."  ".$value->nombre." - ".$value->idEjemplar."  no ha sido campe&oacute;n. No puede participar en ".$desCategoria.".</span>  </br>";
							
				 	}
				 	/*else{
				 		$msg=$msg."<span class='msgError'>".$value->prefijo."  ".$value->nombre." - ".$value->idEjemplar." ya ha sido campe&oacute;n. No puede participar en categorias.</span> </br>";
				 	}*/
         			 $flagCampeonCatego=false;		 
				 }
	         }

	       
	         	$retorno->message=$msg;
	         	$retorno->html=listarPreInscripcion($origen,$link);
				echo json_encode($retorno);

		}elseif($_POST['opc'] == 'quit'){
			quitarPreInscripcion($_POST['idx']);
			echo listarPreInscripcion('');
		}elseif($_POST['opc'] == 'clsTmp'){
			limpiarPreInscripcion();
			echo listarPreInscripcion('');
		}elseif($_POST['opc'] == 'preview'){
			$propName=$_SESSION['xusu'];
			echo listarPreInscripcionPreview($link,$propName);
		}elseif($_POST['opc'] == 'insAddCon'){
			$origen='';
			$mailTo='';
			$idUser= $_SESSION['xid'];
			if($_POST['source']=="1"){
			 	$idProp=$_POST['idProp'];
			 	$idUser=$_SESSION['xidAdmin'];
			 	$origen="1";
			 	$mailTo=obtenerCorreoUserXidProp($idProp);
			 	$propName=obtenerNombreProp($idProp);

			}else{
				$mailTo=obtenerCorreoUser($idUser);
				$propName=$_SESSION['xusu'];
			}
			$resultado=insertarInscripcion($link,$idProp,$idUser,$origen);
			if($resultado==98){
	 
			$notificar= listarPreInscripcionPreview($link,$propName);
			$to=$mailTo; //descomentar eso en produccion

			//if(VerificarrDireccionCorreo($to)){
				//enviarcorreo($to,$notificar,$propName,$mailTo);
			//}

			$retorno->result=1;		
			$retorno->message="Inscripci&oacute;n registrada correctamente";
	        $retorno->html=listarPreInscripcion('');
	    	}else if($resultado==99){

	    	$retorno->result=0;		
			$retorno->message="No hay datos en preinscripción para registrar";
	       // $retorno->html=listarPreInscripcion('');
			}
			echo json_encode($retorno);
			
		}else if($_POST['opc']=='lstPremios'){

			$idConcurso=$_POST['idCon'] ;
			$retorno->result=1;		
	        $retorno->data=categoPremiosEspeciales($idConcurso,$link);
			echo json_encode($retorno);
		}else if($_POST['opc'] == 'lstMiPropByCod'){
			$idPoe = 0; 
			$idUser=0;
			if($_POST['source']=="1") 
			$idProp="";
	 		$pref = "";
	 		$nom = "";
	 		$code = $_POST['code'];
			echo listarMisEjemplares($link,$idPoe,$idUser,$idProp,$pref,$nom,$code);

		}else if($_POST['opc'] == 'lstMiProp'){
			$idPoe = 0; 
			$idUser=0;
			if($_POST['source']=="1") $idProp=$_POST['idProp'];
	 		$pref = $_POST['pref'];
	 		$nom = $_POST['nomb'];
	 		$code = $_POST['code'];
			echo listarMisEjemplares($link,$idPoe,$idUser,$idProp,$pref,$nom,$code);

		}else if($_POST['opc'] == 'lstAdmin'){
			$idConcurso = $_POST['idConcurso'];
	 		$nombres = $_POST['datos'];
		    echo listarInscripcionesAdmin($link,$idConcurso,$nombres);
		}else if($_POST['opc'] == 'lstAdminView'){
			$idConcurso = $_POST['idConcurso'];
	 		$idProp = $_POST['idProp'];
	 		$participante = $_POST['participante'];
		    echo viewDetalle($link,$idProp,$idConcurso,$participante);
		}else if($_POST['opc'] == 'adminDelIns'){

			$idConcurso = $_POST['idConcurso'];
	 		$idProp = $_POST['idProp'];
	 		 if(existeCatalogo($link,$idConcurso)!=1){
	 		 	
		    	$result= delInscripcionAdmin($link,$idProp,$idConcurso);
		    		if($result){
		    			$retorno->result=1;
		    			$retorno->message="Inscripción eliminado correctamene.";		
		    		}else{
						$retorno->result=0;
		    			$retorno->message="No se pudo eliminar la inscripción";
		    		}
		    }else{
		    		$retorno->result=0;
		    		$retorno->message="No se puede eliminar la inscripción. El concurso ya tiene un catalogo";
		    }
			echo json_encode($retorno);
		}else if($_POST['opc'] == 'adminDelInsEjemplar'){

			$idInscripcion = $_POST['idInscripcion'];
			$idConcurso = $_POST['idConcurso'];
			$idProp= $_POST['idProp'];
			
			if(existeCatalogo($link,$idConcurso)!=1){

		    	$result= delInscripcionEjemplarAdmin($link,$idInscripcion,$idProp);
		   			 if($result){
		    			$retorno->result=1;
		    			$retorno->message="Inscripción eliminado correctamene.";		
		    	}else{
						$retorno->result=0;
		    			$retorno->message="No se pudo eliminar la inscripción";
		   			}
		     }else{
		    		$retorno->result=0;
		    		$retorno->message="No se puede eliminar la inscripción. El concurso ya tiene un catalogo";
		    }
		
			echo json_encode($retorno);

		}else if($_POST['opc'] == 'lstAdminPrint'){
			$idConcurso = $_POST['idConcurso'];
		    echo printInscripcionesAdmin($link,$idConcurso);
		}else if($_POST['opc'] == 'genCatalAdmin'){
			$idConcurso = $_POST['idConcurso'];
		    echo generarCatalogo($link,$idConcurso);
		}else if($_POST['opc'] == 'insAdminEjemGrupo'){
			$idConcurso = $_POST['idConcurso'];
			$grupos = json_decode($_POST['grupos']);
			$result=actualizarEjemplaresaGrupo($link,$grupos);
			echo $result;
		}else if($_POST['opc'] == 'delCatalogo'){
			$idConcurso = $_POST['idConcurso'];
			if(existeCatalogo($link,$idConcurso)==1){
				$result=eliminarCatalogo($link,$idConcurso);
				if($result){
			    	$retorno->result=1;
			    	$retorno->message="Catalogo eliminado.";		
		    	}else{
					$retorno->result=0;
			    	$retorno->message="No se pudo eliminar el catalogo";
		    	}
			}else{
					$retorno->result=0;
			    	$retorno->message="No se pudo eliminar. No existe Catalogo.";
			}
			
			echo json_encode($retorno);

		}else if($_POST['opc'] == 'genCatalogo'){
			$idConcurso = $_POST['idConcurso'];
			
			if(existeInscripciones($link,$idConcurso)==1){
					if(existeCatalogo($link,$idConcurso)==0){
						$result=catalogo($link,$idConcurso);
				    	$retorno->result=1;
				    	$retorno->message="Catalogo generado.";		
				    	$retorno->html=$result;
				     }else{
				     	$retorno->result=0;
				    	$retorno->message="No se pudo generar Catalogo. Ya existe el catalogo";		
				    	 
				     }
		 	}else{
				     	$retorno->result=0;
				    	$retorno->message="No se pudo generar Catalogo. No hay ejemplares inscritos";		
				    	 
				     }
			echo json_encode($retorno);
			}else if($_POST['opc'] == 'xlsCatalogo'){
			$idConcurso = $_POST['idConcurso'];
			if(existeCatalogo($link,$idConcurso)==1){
				$result=exportarCatalogo($link,$idConcurso);
		    	$retorno->result=1;
		    	$retorno->message="Catalogo exportado.";		
		    	$retorno->html=$result;
		     }else{
		     	$retorno->result=0;
		    	$retorno->message="No se ha generado el catalogo para su exportación.";		
		    	$retorno->html="";
		     }
			echo json_encode($retorno);

		}else if($_POST['opc'] == 'genCatalogoAuto'){
			$idConcurso = $_POST['idConcurso'];
			
			if(existeInscripciones($link,$idConcurso)==1){
 				if(existeCatalogo($link,$idConcurso)==0){
						$result=generaCatalogoAuto($link,$idConcurso);
				    	$retorno->result=1;
				    	$retorno->message="Catalogo Automático generado.";		
				    	$retorno->html=$result;
				      }else{
				     	$retorno->result=0;
				    	$retorno->message="No se pudo generar Catalogo. Ya existe el catalogo";		
				    	 
				     }
		 		}else{
				     	$retorno->result=0;
				    	$retorno->message="No se pudo generar Catalogo. No hay ejemplares inscritos";		
				    	 
				} 
			echo json_encode($retorno);
		
		}else if ($_POST['opc'] == 'lstItemsProp') {
					$data=listarItemsPropietario($link) ;
				$retorno->result=1;
		    	$retorno->message="ok";		
		    	$retorno->data=$data;
					echo json_encode($retorno);
 		
	   }
	}

function agregarInscripcion($idProp,$idConcurso,$idEjemplar,$idCatego,$prefijo,$nombre,$concurso,$categoria,$tarifa){
 
$flag=aplicarTarifa($idEjemplar);
if($flag=="0")$tarifa=0;

$dato= array('idProp' => $idProp,
						  'idConcurso' => $idConcurso,
						  'catego' => $idCatego,
						  'idEjemplar' => $idEjemplar,
						  'prefijo' => $prefijo,
						  'nombre' => $nombre,
						  'concurso' => $concurso,
						  'categoria' => $categoria,
						  'tarifa'=>$tarifa
						   );
//print_r($dato);
if(!existeDuplicado($idEjemplar,$idConcurso,$idCatego)){
	$_SESSION['_datosInscripcion'][]= $dato;
	return "true";
}else{
	return "false";
}

}

function listarPreInscripcion($origen,$link=''){

$inscripciones=$_SESSION['_datosInscripcion'];
//print_r($inscripciones);
$fila=1;
$tarifa=0;
$total=0;
if(is_array($inscripciones)){
		foreach ($inscripciones as $key => $value) {
		# code...
				

			 	$total=$total+ $tarifa;
				$fila=$key.$opc;
				$html.= "<tr id='tbMovimientoTmp_".$fila."'>";

				$html.= "<td align='left'>
				<label  id='txtEjemplar_".$fila."' >".$inscripciones[$key]['idProp']."</label>
				<input type='hidden' class='cssItem'  id='hidEjemplar_".$fila."' value='".$inscripciones[$key]['idProp']."'>
				</td>";

				$html.= "<td align='left'>
				<label  id='txtEjemplar_".$fila."' >".$inscripciones[$key]['prefijo']." - ".$inscripciones[$key]['nombre']."</label>
				<input type='hidden' class='cssItem'  id='hidEjemplar_".$fila."' value='".$inscripciones[$key]['nombre']."'>
				</td>";

				$html.= "<td align='left'>
				<label  id='txtRegistro_".$fila."' >".$inscripciones[$key]['idEjemplar']."</label>
				<input type='hidden' class='cssItem'  id='hidRegistro_".$fila."' value='".$inscripciones[$key]['idEjemplar']."'>
				</td>";
				$html.= "<td align='left'>
				<label  id='categoria_".$fila."' >".($inscripciones[$key]['categoria'])."</label>
				</td>";
				if($origen==1){
				//$tarifa=$inscripciones[$key]['tarifa'];
				//$html.= "<td align='right'>".number_format($tarifa,2)."</td>";
				}
				 
				$html.= "<td align='center'>";
				$html.="<label ><label class='btnQuit' title='eliminar de preinscripción' data-nombre=".$inscripciones[$key]['nombre']." data-prefijo=".$inscripciones[$key]['prefijo']."  data-key=".$fila.">quitar</label></label>&nbsp;";

				$html.= "</td>";
				 
				$html.= "</tr>";

		}
		if($origen==1){
		//$html.= "<tr><td colspan=3 align=right style='font-weight:bold;'>Importe total de inscripci&oacute;n S/.</td><td align=right style='font-weight:bold;'>".number_format($total,2)."</td><td></td></tr>";

//print_r($_SESSION['_datosInscripcionAllProp']);
$tarifa=obtieneTarifaConcurso($link,$inscripciones[0]['idConcurso'],$inscripciones[0]['idProp']);
$numIns=cuentaEjemplaresDistintos();

$html.="
<tr>
<td colspan=4>
<b>N&deg; Ejemplares Inscritos:&nbsp;</b> ".$numIns."
<b>&nbsp;<br>Costo por Ejemplar :&nbsp;</b> S/.&nbsp;".number_format($tarifa,2)."&nbsp;
<b>&nbsp;<br>Costo Total de Inscripci&oacute;n:&nbsp;</b> S/.&nbsp;".number_format($tarifa*$numIns,2)." 

</td>
 
</tr>
"; 
		}
	}

 

	return $html;

}
function quitarPreInscripcion($idx){
$inscripciones=$_SESSION['_datosInscripcion'];
if(is_array($inscripciones)){
		unset($inscripciones[$idx]);
		$_SESSION['_datosInscripcion']=$inscripciones;
	}
}
function limpiarPreInscripcion(){
	unset($_SESSION['_datosInscripcion']);
}

function existeDuplicado($codigo,$idConcurso,$idCatego){
$inscripciones=$_SESSION['_datosInscripcion'];
if(is_array($inscripciones)){
	//print_r($inscripciones);
		foreach ($inscripciones as $key => $value) {
			if($inscripciones[$key]['idEjemplar']==$codigo &&
				$inscripciones[$key]['catego']==$idCatego &&
				$inscripciones[$key]['idConcurso']==$idConcurso ){
				return true;
			}
		}
	}
return false;
}
function obtenerCategoriaEjemplar($link,$idEjemplar,$idConcurso,$esCampeon){
	if(substr($idEjemplar, 0,1)=='P'){
		$genero="M";	
		/*addon dbs 20170706 por integracion sge*/
		if(esCapado($link,$idEjemplar)){ 				$genero="C";	}
	}
	if(substr($idEjemplar, 0,1)=='C'){		$genero="C";	}
	if(substr($idEjemplar, 0,1)=='Y'){		$genero="H";	}
	
$categoSel="";
if(!$esCampeon){
	// DATEDIFF(CURDATE(),'1981-03-30')/365
	 
$sql1="SELECT idCatego, nombre FROM categoria where genero='$genero' and 
			(SELECT fecnac FROM datos220206 where  codigo='".$idEjemplar."') between desde and  hasta and idConcurso=$idConcurso and activo=1";  
			/*
$sql1="SELECT idCatego, nombre FROM categoria where genero='$genero' and 
			(SELECT (TIMESTAMPDIFF(month,fecnac,CURDATE())/12) FROM datos220206 where  codigo='".$idEjemplar."') between edadMin and  edadMax and idConcurso=$idConcurso and activo=1"; 	*/		
}else{
	$sql1="SELECT idCatego, nombre FROM categoria 
			WHERE genero='$genero' AND idConcurso=$idConcurso 
			AND LOWER(nombre) like '%campe%'  
			AND 
			(LOWER(nombre) like '%Campeones%'
			OR 
			LOWER(nombre) like '%Campeonas%')
			and activo=1"; 
}
// echo $sql1;
		$result = mysql_query($sql1,$link)or die("error inscripciones - obtenerCategoriaEjemplar");
		if($res = mysqli_fetch_array($result)){
			$categoriaSel= array('nombre' =>$res['nombre'] ,
								 'id' =>$res['idCatego'] );	 
		}
	return $categoriaSel;
}
function obtieneTarifaConcurso($link,$id,$codPropie)
{
	$esSocio='0';
	$sqlSoc ="SELECT esSocio FROM usuario WHERE cod_propie='".$codPropie."'";
	//echo $sqlSoc;
	$resultSoc = mysql_query($sqlSoc,$link);
	if($resSoc = mysqli_fetch_array($resultSoc))$esSocio=$resSoc['esSocio'];
	
 	$precio=0;
	$sql ="SELECT tarifa,tarifaSocio FROM concurso WHERE idConcurso=$id";

	$result = mysqli_query($link,$sql);
	if($result){
			if($res = mysqli_fetch_array($result)){
				if($esSocio=='1')$precio=$res['tarifaSocio'];
				else $precio=$res['tarifa'];
			}
		 	mysqli_free_result($result);
 	}
	return $precio;
}
function listarPreInscripcionPreview($link,$propName){

$inscripciones=$_SESSION['_datosInscripcion']; 
//echo"<pre>"; print_r($inscripciones);echo"</pre>";
$concursoDesc="";
if(is_array($inscripciones) && count($inscripciones)>0){
$concursoDesc=$inscripciones[0]['concurso'];
}
$html.= "<table style='width:100%;'  cellpadding=0 ><tr>
<td>
<img src='http://www.registrogenealogico.org.pe/registro/img/logo2.jpg' />
</td>
<td style='font-weight:bold;font-size:13px;'>
FICHA DE INSCRIPCI&Oacute;N A CONCURSO
</td>
</tr>
<tr><td colspan=2><hr style=' height: 12px;
    border: 0;
    box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);'></td>
</tr>    
<tr><td colspan=2 align='center' style='color: #c00c15;font-weight:bold;font-size:15px;'>
".$concursoDesc."
<br><br>
</td>
</tr>
<tr>
<td colspan=2>
<b>Propietario:</b> ".$propName."
</td>
 
</tr>
";

$tarifa=obtieneTarifaConcurso($link,$inscripciones[0]['idConcurso'],$inscripciones[0]['idProp']);
$numIns=cuentaEjemplaresDistintos();

$html.="
<tr>
<td colspan=2>
<b>N&deg; Ejemplares Inscritos:&nbsp;&nbsp;</b> ".$numIns."
<b>&nbsp;Costo por Ejemplar :&nbsp;&nbsp;</b> S/.&nbsp;".number_format($tarifa,2)."&nbsp;
<b>&nbsp;Costo Total de Inscripci&oacute;n:&nbsp;&nbsp;</b> S/.&nbsp;".number_format($tarifa*$numIns,2)."&nbsp; 

</td>
 
</tr>
"; 
	  
	 
$html.= "<tr>
<td colspan=2><table style='width:100%;border-collapse:collapse;border:1px' border=1 >
		<thead style='background:#d3d3d3;border: 1px solid #d3d3d3;'> 
		<tr>
		<th style='height:40px;'>..</th>
		<th style='height:40px;  font-size: 11px;'>Ejemplar</th>
		<th style='height:35px; font-size: 11px;'>N° Registro</th>
		<th style='height:35px; font-size: 11px;'>Categoria o premio a participar</th>
		</tr>
      </thead>
		 <tbody  >
";
 
if(is_array($inscripciones)){
	$fila=0;
	$tarifa=0;
	$total=0;

	 	$idEjemplar='';
		foreach ($inscripciones as $key => $value) {
				
				
				$fila=$fila+1;
				$html.= "<tr><td align='left'>".$fila."</td>";

				$html.= "<td align='left'>
				<label>".$inscripciones[$key]['prefijo']." - ".$inscripciones[$key]['nombre']."</label>
				</td>";

				$html.= "<td align='left'>
				<label>".$inscripciones[$key]['idEjemplar']."</label>
				</td>";
				 
				$html.= "<td align='left'>
				<label>".($inscripciones[$key]['categoria'])."</label>
				</td>";
				//$tarifaCal=$inscripciones[$key]['tarifa'];//$tarifa;
			  

				//$total=$total+$tarifaCal;
				//$html.= "<td align='right'>".number_format($tarifaCal,2)."</td>";
			 
			 	//$idEjemplar=$inscripciones[$key]['idEjemplar'];

				$html.= "</tr>";

		}
	}

 
	$html.= "</tbody  >";
	//$html.= "<tfoot><tr><td colspan=4 align=right style='font-weight:bold;'>Importe total de inscripci&oacute;n S/.</td><td align=right style='font-weight:bold;'>".number_format($total,2)."</td></tr></tfoot>";
	$html.= "</table></td>
</tr></table>";
 
	return $html;

}
function insertarInscripcion($link,$idProp,$usuCrea,$origen=''){
$inscripciones=$_SESSION['_datosInscripcion'];
//print_r($inscripciones[0]);
$resultado=99;  #NO HAY DATTOS
$estado="PRE";
if(is_array($inscripciones)){
	if($origen=='1')$estado="POS";
	$resultado=98;  #NO HAY DATTOS
	
	//$numIns=cuentaEjemplaresDistintos();
	//$numProp=cuentaPropietariosDistintos();
	$tarifaCal=0;
	//$idEjemplar='';

	foreach ($inscripciones as $key => $value) {
		$tarifa=obtieneTarifaConcurso($link,$inscripciones[$key]['idConcurso'],$inscripciones[$key]['idProp']);

		$numProp=cuentaPropietariosDistintos($inscripciones[$key]['idProp']);
			$tarifaCal=$tarifa*$numProp;
			//echo '*'.$tarifaCal.'-';
 	$sql ="INSERT into inscripcion(idProp, idEjemplar, idConcurso, idCatego, fecCrea,usuCrea, estado,precioUnit,precioTotal) values('".$inscripciones[$key]['idProp']."','".$inscripciones[$key]['idEjemplar']."',".$inscripciones[$key]['idConcurso'].",".$inscripciones[$key]['catego'].",NOW(),".$usuCrea.",'".$estado."',".$tarifa.",".$tarifaCal.")";
	 	$result = mysqli_query($link,$sql);	


	 	//if($result)
	 	actualizarMontosTotales($link,$inscripciones[$key]['idProp']);
		
		}
		//echo $sql;
		
	}
	return $resultado;
}

function existeInscripcionBD($link,$idProp,$idConcurso,$idCatego,$idEjemplar){
$sql ="SELECT * from inscripcion where idProp=$idProp 
  			and idConcurso=$idConcurso 
  			and idCatego=$idCatego 
  			and idEjemplar='".$idEjemplar."'";

  			//echo $sql;
	 $result = mysql_query($sql,$link)or die('error en query existeInscripcionBD ');	
	 $num=mysql_num_rows($result) ;
	 if($num == 0){
	 	 return false;
	 }else{
	 	return true;
	}
}



/*function enviarcorreo($mail,$body,$prop,$mailTo)
{
$inscripciones=$_SESSION['_datosInscripcion'];
$mailConcursoAdmin="";

if(is_array($inscripciones) && count($inscripciones)>0){
	$idConcurso=$inscripciones[0]['idConcurso'];
	$mailConcursoAdmin=" ,".obtenerCorreoConcurso($idConcurso); //CORREO SALIDA
}
$correoSocio="";
if(VerificarrDireccionCorreo($mail)){
	$correoSocio=$mail.",";
} 

//$mailFrom=obtenerCorreoConcurso($idConcurso); //CORREO SALIDA
$destinatario="promocion@ancpcpp.org.pe";
$asunto="Inscripcion a Concurso : ".$prop." ";
$cuerpo=$body;

//para el envío en formato HTML
/*incio esto es para prueba - comentar en produccion*/
/*$correoSocio="dbalvis@teon.pe,"; //comentar esta linea
$destinatario=$correoSocio;//comentar esta linea
$mailFrom="concursos@registrogenealogico.org.pe";
/*fin esto es para prueba - comentar en produccion*/

/*$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From: <$mailFrom>\r\n"; 
$headers .= "CC:concursos@registrogenealogico.org.pe $mailConcursoAdmin \r\n";

mail($destinatario,$asunto,$cuerpo,$headers); 

}*/
function categoPremiosEspeciales($idConcurso,$link){
		$sql = "select idCatego,nombre,genero from categoria where idConcurso = ".$idConcurso." and esPremio=1 and activo=1 ";
		$result = mysql_query($sql,$link)or die("error listar  categoPremiosEspeciales  ".$sql );
		while($res = mysqli_fetch_array($result)){
			$premios[]= array('id' => $res['idCatego'],
							  'nombre'=>$res['nombre'],
							  'genero'=>$res['genero']);
		}
		mysqli_free_result($result);
		return $premios;
	}
/*funciona agregada para la carga de ejemplares del usuario logeado para el
fomulario de inscriociones en linea*/
function listarMisEjemplares($link,$idPoe,$idUser,$idProp,$pref,$nombre,$codigo){
if($idProp=="")$idProp="-99";
		$html = "";
		

		if($codigo!=""){
			$sql ="SELECT DISTINCT id,cod_propie,propie,codigo,prefijo,nombre,capado 
				FROM ( SELECT 0 AS id,a.cod_propie,a.propie, a.codigo, a.prefij   AS prefijo,
					a.nombre  ,capado
				FROM datos220206 a WHERE a.codigo LIKE concat('%$codigo%')  and fallec=0
 				) AS q 
				ORDER BY q.nombre,q.codigo;
				";
		}else{
			$sql ="SELECT DISTINCT id,cod_propie,propie,codigo,prefijo,nombre,capado 
				FROM ( SELECT 0 AS id, a.cod_propie,a.propie,a.codigo, a.prefij   AS prefijo,
					a.nombre  ,capado
				FROM datos220206 a WHERE a.cod_propie =$idProp  and fallec=0
 				) AS q 
				WHERE q.prefijo LIKE concat('%$pref%') 
				AND q.nombre LIKE concat('%$nombre%')
				AND q.codigo LIKE concat('%$codigo%')
				ORDER BY q.nombre,q.codigo    	  	
				";
		}
		
		
				//echo 	$sql;
		$result = mysqli_query($link,$sql);
		$fila=1;
		$prefNameSelLast='';
		while($res = mysqli_fetch_array($result)){
			if($prefNameSelLast!=$res['prefijo'].$res['nombre']){
					$html.= "<tr id='tbMovimiento_".$res['id']."'>";

						$html.= "<td align='left' >
						<label  id='txtCodigoProp_".$res['codigo']."' >".$res['cod_propie']."</label>
						<input type='hidden' class='cssItem'  id='hidCodProp_".$res['codigo']."' value='".$res['cod_propie']."'>
						</td>";

						$html.= "<td align='left' >
						<label  id='txtPrefijo_".$fila."' >".$res['prefijo']."</label>
						<input type='hidden' class='cssItem'  id='hidPrefijo_".$fila."' value='".$res['prefijo']."'>
						</td>";
						
						$html.= "<td align='left'>
						<label  id='txtEjemplar_".$fila."' >".($res['nombre'])."</label>
						<input type='hidden' class='cssItem'  id='hidEjemplar_".$fila."' value='".($res['nombre'])."'>
						<input type='hidden' id='hidEjemplarNombre_".$res['codigo']."' value='".($res['nombre'])."'>
						</td>";

						$html.= "<td align='left'>
						<label  id='txtRegistro_".$fila."' >".$res['codigo']."</label>
						<input type='hidden' class='cssItem'  id='hidRegistro_".$fila."' value='".$res['codigo']."'>
						</td>";
						$html.= "<td align='center'>";
						//img src='img/catego.png' width=20
						$html.=" 
						<label class='btnGen' data-capado='".$res['capado']."' data-nombre='".($res['nombre'])."' data-prefijo='".$res['prefijo']."'  data-key='".$res['codigo']."' title='inscribir a categoria'>Categoria</label> &nbsp;";
						//img src='img/premio.png' width=20 
						$html.=" 
						<label class='btnCat' title='inscribir a premio especial' data-capado='".$res['capado']."'  data-nombre='".($res['nombre'])."' data-prefijo='".$res['prefijo']."'  data-key='".$res['codigo']."'>Premio</label>";
						$html.= "</td>";
				        $html.= "</tr>";
						$fila++;
				}
				$prefNameSelLast=$res['prefijo'].$res['nombre'];
		}
	 	mysqli_free_result($result);
 
		return $html;
	}

/*INICIO FUNCIONES PARA EL ADMIN*/	
function listarInscripcionesAdmin($link,$idConcurso,$nombre){

/*$sql="SELECT   u.cod_propie as id  ,upper(concat(u.nom_usu,' ',u.ape_paterno,' ',u.ape_materno,' ',u.razonSocial)) participante,i.idConcurso, (precioTotal)as costoInscripcion FROM inscripcion i  INNER JOIN usuario u  ON(u.cod_propie=i.idProp)
	WHERE i.idConcurso=$idConcurso and
	concat(u.nom_usu,' ',u.ape_paterno,' ',u.ape_materno,' ',u.razonSocial) like '%$nombre%'
	group by u.cod_propie
	ORDER BY upper(concat(u.nom_usu,' ',u.ape_paterno,' ',u.ape_materno,' ',u.razonSocial)) 
	"; precioTotal=0
	*/
$sql="	SELECT DISTINCT id,participante,idConcurso,costoInscripcion FROM(
		 SELECT i.idProp as id , SGEFN_PROPIETARIOS_X_ID(CONVERT(i.idProp,SIGNED)) participante,i.idConcurso, (precioTotal)as costoInscripcion 
		FROM inscripcion i 
		--  INNER JOIN datos220206 d ON(CONVERT(i.idProp,SIGNED)=d.cod_propie)
		 WHERE i.idConcurso=$idConcurso  -- and d.propie LIKE '%$nombre%'
		 -- GROUP BY  i.idProp 
UNION ALL
		SELECT i.idProp as id , e.razonSocial participante,i.idConcurso, (precioTotal)as costoInscripcion 
		FROM inscripcion i 
		 -- INNER JOIN datos220206 d ON(CONVERT(i.idProp,SIGNED)=d.cod_criador)
		  INNER JOIN sgev_entidad e  ON(CONVERT(i.idProp,SIGNED)=e.id)
		 WHERE i.idConcurso=$idConcurso  -- and  d.criador  LIKE '%$nombre%'
		 -- GROUP BY i.idProp 
 ) Q 
   WHERE Q.participante LIKE '%$nombre%'
 ORDER BY Q.participante
 ";
 //echo $sql;
$result = mysqli_query($link,$sql);
		$i=0;
		$totalRecaudo=0;
		while($res = mysqli_fetch_array($result)){
			$totalRecaudo=$totalRecaudo+$res['costoInscripcion'];
			$html.= "<tr id='trInscripcion_".$res['id']."'>";
				$html.= "<td align='left' >".($i+1)."</td><td align='left' >
				<label  id='txtPrefijo_".$fila."' >".($res['participante'])."</label>
				<input type='hidden' class='cssItem'  id='hidIdUser_".$fila."' value='".$res['id']."'>
				<input type='hidden'   id='hidParticipante_".$res['id']."' value='".($res['participante'])."'>
				</td>";

			 $html.= "<td align='right' >".number_format($res['costoInscripcion'],2)."</td>";
			 $html.= "<td align='left' >
				<label class='btnView' data-key=".$res['id']." data-concurso=".$res['idConcurso']." title='ver detalle de inscripción'>Ver inscripcion</label>&nbsp;";
				$html.="<label >
				<label class='btnDel' data-key=".$res['id']." data-concurso=".$res['idConcurso']." title='eliminar inscripción del socio.'>Eliminar Inscripcion</label>";
				$html.= "</td>";
		        $html.= "</tr>";
				$i++;
				}
				if($i==0){
				 $html.= "<tr>";
				 $html.= "<td align='center' style='height:60px;' colspan=4 >No se encontraron registros de inscripciones.</td></tr>";

				}else{
				 $html.= "<tr>";
				 $html.= "<td align='right' colspan=2 ></td>
				 <td align='right' ><b>".number_format($totalRecaudo,2)."</b></td></tr>";
				 $html.= "<tr>";
				 $html.= "<td align='left' style='background:#d3d3d3;border: 1px solid #d3d3d3;'  colspan=4 ><b>Total registros encontrados:&nbsp;&nbsp;$i</b></td></tr>";
				}
				
	 	mysqli_free_result($result);
 
		return $html;



}
function printInscripcionesAdmin($link,$idConcurso){
/*
$sql="SELECT   u.cod_propie as id  ,upper(concat(u.nom_usu,' ',u.ape_paterno,' ',u.ape_materno,' ',u.razonSocial)) participante,i.idConcurso, precioTotal as costoInscripcion FROM inscripcion i  INNER JOIN usuario u  ON(u.cod_propie=i.idProp)
	WHERE i.idConcurso=$idConcurso  
	group by u.cod_propie
	ORDER BY upper(concat(u.nom_usu,' ',u.ape_paterno,' ',u.ape_materno,' ',u.razonSocial))
	";
	*/
	$sql="	SELECT DISTINCT id,participante,idConcurso,costoInscripcion FROM(
		 SELECT i.idProp as id ,SGEFN_PROPIETARIOS_X_ID(CONVERT(i.idProp,SIGNED))participante,i.idConcurso, (precioTotal)as costoInscripcion 
		FROM inscripcion i 
		-- INNER JOIN datos220206 d ON(CONVERT(i.idProp,SIGNED)=d.cod_propie)
		 WHERE i.idConcurso=$idConcurso  GROUP BY  i.idProp 
UNION ALL
		SELECT i.idProp as id ,e.razonSocial participante,i.idConcurso, (precioTotal)as costoInscripcion 
		FROM inscripcion i 
		 -- INNER JOIN datos220206 d ON(CONVERT(i.idProp,SIGNED)=d.cod_criador)
		  INNER JOIN sgev_entidad e  ON(CONVERT(i.idProp,SIGNED)=e.id)
		 WHERE i.idConcurso=$idConcurso  GROUP BY i.idProp 
 ) Q 
 ORDER BY Q.participante
 ";
 // echo $sql;
$html.= "<table  style='width:100%; font-size:11px;border-collapse:collapse;border:1px; background: #fff;' border=1 >
		 <thead style='background:#d3d3d3;border: 1px solid #d3d3d3;'> 
		 <tr>
		 <th>N&deg;</th>
		 <th>Participante Socio / Criador</th>
		 <th>Total S/.</th>
		 </tr>
		  
		 </thead>
		 <tbody>";
$result = mysqli_query($link,$sql);
		$i=0;
		$totalRecaudo=0;
		while($res = mysqli_fetch_array($result)){
			 $totalRecaudo=$totalRecaudo+$res['costoInscripcion'];
			 $html.= "<tr id='trInscripcion_".$res['id']."'>";
			 $html.= "<td align='left' >".($i+1)."</td>
				<td align='left' >".$res['participante']."</td>";

			 $html.= "<td align='right' >".number_format($res['costoInscripcion'],2)."</td>";
			 $html.= "</tr>";
				$i++;
			}
				if($i==0){
				 $html.= "<tr>";
				 $html.= "<td align='center' style='height:60px;' colspan=3 >No se encontraron registros de inscripciones.</td></tr>";

				}else{
				 $html.= "<tr>";
				 $html.= "<td align='right' colspan=2 ></td>
				 <td align='right' ><b>".number_format($totalRecaudo,2)."</b></td></tr>";
				 $html.= "<tr>";
				 $html.= "<td align='left' style='background:#d3d3d3;border: 1px solid #d3d3d3;'  colspan=3 ><b>Total registros encontrados:&nbsp;&nbsp;$i</b></td></tr>";
				}
	 	mysqli_free_result($result);
 $html.= "</tbody></table>";
		return $html;



}
function viewDetalle($link,$idProp,$idConcurso,$participante){

$concursoDesc="-";
//$participante="-";
 

$html.= "<tr>
<td colspan=2><table style='font-size:11px;width:100%;border-collapse:collapse;border:1px' border=1 >
		<thead style='background:#d3d3d3;border: 1px solid #d3d3d3;'> 
		<tr>
		<th style='height:40px;'>..</th>
		<th style='height:40px;  font-size: 11px;'>Ejemplar</th>
		<th style='height:35px; font-size: 11px;'>N° Registro</th>
		<th style='height:35px; font-size: 11px;'>Categoria o premio a participar</th>
		<!--<th style='height:35px; font-size: 11px;'>S/.</th>-->
		<th style='height:35px; font-size: 11px;'>..</th>
		</tr>
      </thead>
		 <tbody  >
";
/*
$sql=" SELECT distinct i.id,CONCAT(d.prefij,' - ',d.nombre) ejemplar,d.codigo,c.nombre as catego,i.precioUnit as precio,CONCAT(u.nom_usu,' ',u.ape_paterno,' ',u.ape_materno,' ',u.razonSocial) participante,con.nombre concursoDes,i.idConcurso,i.idProp
FROM inscripcion i  
INNER JOIN usuario u  ON(u.cod_propie=i.idProp)
INNER JOIN categoria c  ON(c.idCatego=i.idCatego)
INNER JOIN datos220206 d on(d.codigo  COLLATE utf8_general_ci=i.idEjemplar)
INNER JOIN concurso con on(con.idConcurso = i.idConcurso)
WHERE i.idConcurso=$idConcurso  AND u.cod_propie=$idProp order by d.codigo desc "; 
*/
$sql="SELECT distinct i.id,CONCAT(d.prefij,' - ',d.nombre) ejemplar,d.codigo,c.nombre as catego,i.precioUnit as precio,
'-' as participante,
con.nombre concursoDes,i.idConcurso,i.idProp 
FROM inscripcion i 
INNER JOIN categoria c ON(c.idCatego=i.idCatego) 
INNER JOIN datos220206 d on(d.codigo=i.idEjemplar) 
INNER JOIN concurso con on(con.idConcurso = i.idConcurso)
-- INNER JOIN datos220206 dp on(dp.cod_propie=i.idProp)  
WHERE i.idConcurso=$idConcurso AND i.idProp='$idProp'  order by d.codigo desc
";
$result = mysqli_query($link,$sql);
$fila=0;
$tarifa=0;
//$total=0;
$numIns=0;
$idEjemplar='';
	while($row = mysqli_fetch_array($result)){
				$concursoDesc=$row['concursoDes'];
				//$participante=$participante;

				$tarifa=$row['precio'];
				if($idEjemplar!=$row['codigo'])$numIns++;

				$fila=$fila+1;
				$html.= "<tr><td align='left'>".$fila."</td>";
				$html.= "<td align='left'><label>".($row['ejemplar'])."</label></td>";
				$html.= "<td align='left'><label>".$row['codigo']."</label></td>";
				$html.= "<td align='left'><label>".($row['catego'])."</label></td>";
				//$html.= "<td align='right'>".number_format($tarifa,2)."</td>";
				$html.= "<td align='left'><label class='ui-button-icon-primary ui-icon ui-icon-trash' style='cursor:hand;' title='eliminar ejemplar del concurso' onclick=quitarEjemplar(".$row['id'].",".$row['idConcurso'].",'".$row['idProp']."')></label></td>";
				$html.= "</tr>";
				$idEjemplar=$row['codigo'];
	}

	$html.= "</tbody  >";
	//$html.= "<tfoot><tr><td colspan=4 align=right style='font-weight:bold;'>Importe total de inscripci&oacute;n S/.</td><td align=right style='font-weight:bold;'>".number_format($total,2)."</td><td></td></tr></tfoot>";
	$html.= "</table></td>
</tr></table>";
 

$html1= "<table style='width:100%; font-size:12px;'  cellpadding=0 ><tr>
<td>
<img src='../img/logo2.jpg' />
</td> 
<td style='font-weight:bold;font-size:13px;'>
FICHA DE INSCRIPCI&Oacute;N A CONCURSO
</td>
</tr>
<tr><td colspan=2><hr style=' height: 12px;
    border: 0;
    box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);'></td>
<tr><td colspan=2 align='center' style='color: #c00c15;font-weight:bold;font-size:15px;'>
".$concursoDesc."
<br><br>
</td>
</tr>
<tr><td colspan=2><b>Propietario/Criador:</b> ".$participante."</td></tr>
";
$html1.="
<tr>
<td colspan=2>
<b>N&deg; Ejemplares Inscritos:&nbsp;&nbsp;</b> ".$numIns."
<b>&nbsp;Costo por Ejemplar :&nbsp;&nbsp;</b> S/.&nbsp;".number_format($tarifa,2)."&nbsp;
<b>&nbsp;Costo Total de Inscripci&oacute;n:&nbsp;&nbsp;</b> S/.&nbsp;".number_format($tarifa*$numIns,2)."&nbsp; 

</td>
 
</tr>
";  

	return $html1.$html;

}
function delInscripcionAdmin($link,$idUser,$idConcurso){

$sql="DELETE FROM  inscripcion 
			WHERE idConcurso=".$idConcurso." and idProp=".$idUser." ";
 		    $result = mysqli_query($link,$sql);
			if($result){
				return true;
			}else{
				return false;
			}


}
function delInscripcionEjemplarAdmin($link,$idInscripcion,$idProp){

$sql="DELETE FROM  inscripcion 
			WHERE id=".$idInscripcion."  ";
			
 		    $result = mysqli_query($link,$sql);
 		   //echo $sql;
			if($result){
				actualizarMontosTotales($link,$idProp);
				return true;
			}else{
				return false;
			}

}
/*OBSOLETO YA NO ES NECESARIO SE CAMBIO LOGICA DE APLCIAR TARIFA*/
function aplicarTarifa($idEjemplar){
$flag='1';

$inscripciones=$_SESSION['_datosInscripcion'];
 	if(is_array($inscripciones)){
		foreach ($inscripciones as $key => $value) {
			if($idEjemplar==$inscripciones[$key]['idEjemplar']){
				  $flag="0";  
			}
		}
	}	
	return $flag;
}	
function cuentaEjemplaresDistintos(){
$totalDistinct=0;
$cuenta=0;
$lista=$_SESSION['_datosInscripcion'];
$foundHorse=array();
$n=count($lista);
 if(is_array($lista)){
 	for ($i=0; $i < $n; $i++) { 
 		$foundHorse[$lista[$i]['idEjemplar']]=$lista[$i]['idEjemplar'];
 	}
}
return count($foundHorse);
}
function cuentaPropietariosDistintos($idProp){
$totalDistinct=0;
$cuenta=0;
$lista=$_SESSION['_datosInscripcion'];
//print_r($lista);
//$foundProp=array();
//$n=count($lista);
 if(is_array($lista)){
 	foreach ($lista as $key => $value) {
 		
 		if($idProp==$lista[$key]['idProp']){
 			//echo '1';
 			$cuenta=$cuenta+1;
 			//echo '--'.$cuenta.'--';
 		}
 	}
 }
 return $cuenta;
}

function actualizarMontosTotales($link,$idProp){
	//OBTIENE EL NUEVO PRECIO TOTAL
		//print_r($idProp);
			$sql="SELECT count(distinct (idEjemplar))*precioUnit as PrecioTotal 
							FROM inscripcion 
							WHERE  idProp='".$idProp."' ";
	
				
				$rs = mysqli_query($link,$sql);
				if (!$rs) die('No se pudo obtener total precio:' . mysql_error());
				$neoPrecio=mysql_result($rs,0);
		
			$sql="UPDATE inscripcion SET precioTotal=".$neoPrecio."
					 WHERE  idProp='".$idProp."'";
		
				//ACTULIZA EL NUEVO PRECIO TOTAL
 				
				$result = mysqli_query($link,$sql);
				 
}			
function generarCatalogo($link,$idConcurso){


$sql="select c.idCatego,i.idConcurso,c.nombre, count(i.id)inscritos,c.cantidad  from  categoria c left join inscripcion i 
on(c.idCatego=i.idCatego) where c.idConcurso=$idConcurso and c.activo=1
group by c.orden";
//echo $sql;
//mysql_query('SET NAMES iso-8859-1');
//mysql_query('SET CHARACTER_SET iso-8859-1');
$result = mysqli_query($link,$sql);
 $idCatego="";
 $fila=1;
 $cuentaGrupo=1;
 $grupo=1;
 $grupoLast=0;

 				$html="<table border=1 style='width:100%;border-collapse:collapse;font-size:11px;'>";
 				$html.= "<tr style=' height:30px;background:gray;color:white;font-size:12px;'>";
				$html.= "<td align='center'>..</td>";
				$html.= "<td align='center'>Nombre de Categoria</td>";
				$html.= "<td align='center'>N&uacute;mero  de inscritos</td>";
				$html.= "<td align='center'>N&deg; Max de ejemplar x grupo </td>";
				$html.= "</tr>";			 
	while($row = mysqli_fetch_array($result)){
				 
				 
				$html.= "<tr class='itemCatego' data-idinput='txtNumGrupo_".$fila."' data-concurso=".$row['idConcurso']." data-categoria=".$row['idCatego']." >";
				$html.= "<td align='left'>".$fila."</td>";
				$html.= "<td align='left'><label>".($row['nombre'])."</label></td>"; 
				$html.= "<td align='right'><label>".$row['inscritos']."</label></td>";
				$html.= "<td align='center'><input maxlength=3 type='text' id='txtNumGrupo_".$fila."' style='width:50px;' value='".$row['cantidad']."'></td>";
				$html.= "</tr>";
				$fila++;			 
	}
 				$html.="</table>";
                //catalogo($link,15);
return $html;

}
function parteDecimal($n ){
  return ($n-intval($n))*1000;	
}
function actualizarEjemplaresaGrupo($link,$datos){
 
if(is_array($datos)){
	foreach ($datos as $key => $value) {
  		
  		$sql ="UPDATE categoria set cantidad=".$value->numeroEjemplares." 
		WHERE idConcurso=".$value->idConcurso." and idCatego=".$value->idCategoria. "  		 ";
	 	$result = mysqli_query($link,$sql);	
	 	



		}
	}
	 
	return "1";
}

function catalogo($link,$idConcurso){
 
 
  		$sql ="SELECT c.idCatego,i.idConcurso,c.nombre, count(i.id)inscritos,c.cantidad  from  inscripcion i inner join categoria c 
on(i.idCatego=c.idCatego) WHERE i.idConcurso=".$idConcurso." GROUP BY c.idCatego,i.idConcurso,c.nombre,c.cantidad";
	 	$result = mysqli_query($link,$sql);	
	 
	 	while ($row = mysqli_fetch_array($result)) {
	 		$nEjemXGrupo= $row['cantidad'];
	 		$idCatego=$row['idCatego'];
	 		$totalInscritos=$row['inscritos'];
	 		$numGrupos=ceil(($totalInscritos/$nEjemXGrupo));
			$neoi=0;
	 		$cuenta=1;

			//$html.="<table border=1 style='font-size:10px;'>";
 			//$html.="<tr><td colspan=11>Categoria:".$row['nombre']."</td></tr>";

	 		for ($i=1; $i <= $numGrupos; $i++) { 
				 $neoi=$i==1?0:($neoi+$nEjemXGrupo);
	 			 $sqlGrupo="SELECT  i.id as idInscripcion,d.prefij,d.nombre,d.codigo,DATE_FORMAT(d.fecnac,'%d/%m/%Y')fecnac,d.prefpa,d.nompad,d.prefma,d.nommad
							,d.criador,d.propie FROM inscripcion i inner join datos220206 d on(i.idEjemplar=d.codigo COLLATE utf8_general_ci)
	 			    		WHERE idConcurso=".$idConcurso." and idCatego=".$idCatego."
	 			    		order by d.fecnac asc limit $neoi,$nEjemXGrupo  ";

	 			    $resultG = mysql_query($sqlGrupo,$link);	
	 			    //$html.=getHeaderHtmlCatalogo($i);
	 			   
	 			    $grupoName="Grupo ".$i;
	 			    #CREAMOS LOS GRUPOS PARA LA CATEGORIA
	 			    $sqlQueryGrupo="SELECT idGrupo FROM grupo WHERE idCatego=$idCatego AND nombre='".$grupoName."' and activo=1";
	 			    $resultQG = mysql_query($sqlQueryGrupo,$link);

	 			    if ($item = mysqli_fetch_array($resultQG)) {
	 			    	$idGrupo=$item['idGrupo'];
	 			    }else{
		 			    $sqlGrupoInsert="INSERT INTO grupo(idCatego,nombre,activo)VALUES(".$idCatego.",'".$grupoName."',1)";
		 			    $resultIG = mysql_query($sqlGrupoInsert,$link);	
	 				    $idGrupo=mysql_insert_id();
	 				}

	 			 	while ($item = mysqli_fetch_array($resultG)) {
	 			 		#ACTUALIZAMOS EL CATALOGO	
						$sqlGrupoUpd="UPDATE inscripcion SET idGrupo=$idGrupo,orderGrupo=$cuenta WHERE id=".$item['idInscripcion']."";
	 			    	$resultUG = mysql_query($sqlGrupoUpd,$link);
	 			 		//$html.=getRowsHtmlCatalogo($item,$cuenta);
						$cuenta++;
	 			 	}   

	    		}
	    		//$html.="</table>";
	    		$sqlConcursoUpd="UPDATE concurso SET tieneCatal='1' WHERE idConcurso=$idConcurso";
	 			$resultUC = mysql_query($sqlConcursoUpd,$link);
	    		
	 	}
		 
	return $html;
}
function eliminarCatalogo($link,$idConcurso){

	$sqlConcursoUpd="UPDATE concurso SET tieneCatal='0' WHERE idConcurso=$idConcurso";
	$resultUC = mysql_query($sqlConcursoUpd,$link);

	$sqlInsUpd="UPDATE inscripcion SET idGrupo=null, orderGrupo=0 WHERE idConcurso=$idConcurso";
	$resultUI = mysql_query($sqlInsUpd,$link);

	$sqlGrupopd="UPDATE grupo SET activo=0 WHERE idCatego in(select idCatego from  categoria where idConcurso=$idConcurso)";
	$resultUG = mysql_query($sqlGrupopd,$link);

	return $resultUG;
}

function getRowsHtmlCatalogo($item,$cuenta){

return "<tr><td></td>
	 			  <td>$cuenta</td><td></td>
	 			  <td>".$item["prefij"]."</td>
	 			  <td>".htmlentities(($item["nombre"]),iso-8859-1)."</td><td>".$item["codigo"]."</td><td>".$item["fecnac"]."</td><td>".$item["prefpa"]."</td>
	 			  <td>".htmlentities(($item["nompad"]),iso-8859-1)."</td><td>".$item["prefma"]."</td>
	 			  <td>".htmlentities(($item["nommad"]),iso-8859-1)."</td>
	 			  <td>".htmlentities(($item["criador"]),iso-8859-1)."</td>
	 			  <td>".htmlentities(($item["propie"]),iso-8859-1)."</td>
	 			  <td>".htmlentities(($item["microchip"]),iso-8859-1)."&nbsp;</td>
	 			  </tr>";
}
function getHeaderHtmlCatalogo(){

	 return "<tr style='font-weight:bold;'><td>Result.</td>
	 			    <td>No.</td><td>No. Cancha</td><td>Prefijo</td><td>Nombre</td><td>c&oacute;digo</td>
	 			    <td>Fec/Nac</td><td></td><td>Padre</td><td></td>
	 			    <td>Madre</td><td>Criador</td><td>Propietario</td><td>Microchip</td>
	 			    </tr>";
}
function existeCatalogo($link,$idConcurso){
	$existe=0;
	$sqlConcursoUpd="select tieneCatal from concurso WHERE idConcurso=$idConcurso";
	//echo $sqlConcursoUpd;
	$resultUC = mysql_query($sqlConcursoUpd,$link);
	if($item = mysqli_fetch_array($resultUC)) {
			if($item[0]=="1"){
				$existe=1;
			}
	}
	return $existe;
}
function existeInscripciones($link,$idConcurso){
	$existe=0;
	$sqlConcursoUpd="select idConcurso from inscripcion WHERE idConcurso=$idConcurso";

	$resultUC = mysql_query($sqlConcursoUpd,$link);
	if($item = mysqli_fetch_array($resultUC)) {
				$existe=1;
	}
	return $existe;
}
/*OBSOLETOOOOOO*/
function exportarCatalogoBB($link,$idConcurso){
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header("Content-Disposition: filename=ficheroExcel.xls");
header("Pragma: no-cache");
header("Expires: 0");

$sql=" SELECT  i.id as idInscripcion,d.prefij,d.nombre,d.codigo,DATE_FORMAT(d.fecnac,'%d/%m/%Y')fecnac,d.prefpa,d.nompad,d.prefma,d.nommad
							,d.criador,d.propie,c.nombre as categoria ,g.nombre as grupo,i.orderGrupo,c.idCatego,g.idGrupo,cc.nombre as concurso
                            FROM 
                            inscripcion i 
                            inner join datos220206 d on(i.idEjemplar=d.codigo COLLATE utf8_general_ci)
                            inner join categoria c on(c.idCatego=i.idCatego)
                            inner join grupo g on(g.idGrupo=i.idGrupo)
                            inner join concurso cc on(cc.idConcurso=i.idConcurso)
	 			    		WHERE i.idConcurso=$idConcurso and
                            g.activo=1 and c.activo=1 
                            order by c.orden,g.idGrupo,g.nombre,i.orderGrupo
";
mysql_query('SET NAMES iso-8859-1');
mysql_query('SET CHARACTER_SET iso-8859-1');
$result = mysqli_query($link,$sql);
$colspan=12;
$html="<table border=1 style='font-size:10px;'>";
$categorialast="";
$grupolast="";
$cuenta=1;
$cuentaEjemplarGrupo=0;
$i=0;
$cuentaGrupo=1;
$numGrupoXCate=1;
while ($row = mysqli_fetch_array($result)) {
	if($i==0){
		$html.="<tr><td colspan=$colspan style='font-weight:bold;font-size:14px;'><b>".htmlentities($row['concurso'],iso-8859-1)."</b></td></tr>";
	}
	$categoria=$row['categoria'];
	$grupo=$row['grupo'];
	$orderGrupo=$row['orderGrupo'];

	if($grupo!=$grupolast && $i!=0){ # cuando hay mas de un grupo

		$html.="<tr><td colspan=$colspan> ".$cuentaEjemplarGrupo." Ejemplares</td></tr>";
		$flag=true;
		if($orderGrupo!=1){
			$html.="<tr><td colspan=$colspan style='background:whitesmoke;'><b> ".$grupo."</b></td></tr>";
			$numGrupoXCate++;
		}
	}else{
		$flag=false;
	}
	if($categoria!=$categorialast){
		# entra aqui cuando  tiene mas de un grupo
		$numGrupoXCate=1;
		if( $cuentaGrupo!=1 && $numGrupoXCate==1 && $flag==false) $html.="<tr><td colspan=11> ".$cuentaEjemplarGrupo." Ejemplares</td></tr>"; #DEL
		$html.="<tr><td colspan=$colspan style='background:#ccc;'>  ".htmlentities($categoria,iso-8859-1)."</td></tr>";
	//	$cuentaGrupo=1;
		
		$cuenta=1;
		$cuentaEjemplarGrupo=0;
	}

	if($orderGrupo==1){
		if($orderGrupo==0 && $cuentaEjemplarGrupo!=0){
			//$html.="<tr><td colspan=11>$grupo  ----  $grupolast ---- $orderGrupo  + ".$cuentaEjemplarGrupo." Ejemplares</td></tr>";
		}
		$html.="<tr><td colspan=$colspan style='background:whitesmoke;'><b> ".$grupo."</b></td></tr>";
		$numGrupoXCate++;
		
	}
	$cuentaGrupo=$orderGrupo;
	if($grupo!=$grupolast){
		$html.=getHeaderHtmlCatalogo();
		$cuentaEjemplarGrupo=0;
		 
	}

 	$html.=getRowsHtmlCatalogo($row,$cuenta);
 	$categorialast=$categoria;
 	$grupolast=$grupo;
 	$cuentaEjemplarGrupo++;
 	$cuenta++;
 	$i++;
}
$html.="<tr><td colspan=11>".$cuentaEjemplarGrupo." Ejemplares</td></tr>";
$html.="</table>";




return $html;
}
 function generaCatalogoAuto($link,$idConcurso){
/*
 	$max=25;
$totalInscritos=130  ;

echo "<br><br><br><br>";
for ($i=$max; $i >0 ; $i--) { 
   $numEjemxGrupo=$totalInscritos/$i;

   echo "num ejem x grupo:   ".$i."  num grupo:  ".ceil($numEjemxGrupo)."<br>";
 
 
}*/


$sql ="SELECT c.idCatego,i.idConcurso,c.nombre, count(i.id)inscritos,c.cantidad  from  inscripcion i 
  				inner join categoria c on(i.idCatego=c.idCatego) WHERE i.idConcurso=".$idConcurso." GROUP BY c.idCatego,i.idConcurso,c.nombre,c.cantidad";
	 	$result = mysqli_query($link,$sql);	
	 
	 	while ($row = mysqli_fetch_array($result)) {
	 		$nEjemXGrupo= $row['cantidad'];
	 		$idCatego=$row['idCatego'];
	 		$totalInscritos=$row['inscritos'];
			$maxNumGrupo=$nEjemXGrupo;
			$numInscrtos=$totalInscritos;
/*
					echo "<br>***********************<br>";
					echo "maximo grupo ".$maxNumGrupo."<br>";
					echo "inscritos ".$numInscrtos."<br>";
*/
					$partbase=0;
 					$valBase=[];
					for ($i=$maxNumGrupo; $i>0 ; $i--) { 

						$ng=$numInscrtos/$i;  
						if($i==$maxNumGrupo && parteDecimal($ng)==0){
								$valBase[$ng]=$i;
						}else{

						$entero=intval($ng);

						if($i==$maxNumGrupo){			$partbase=$entero;	}
						
						if($partbase==$entero){		$valBase[ceil($ng)]=$i;	}

						if(($partbase+1)==$entero){
								$partDecimal=parteDecimal($ng);	
								if($partDecimal==0){		$valBase[$ng]=$i;		}
							}
						}
					    
					}
				//echo "--------------------------------<br>";
			/*		echo"<pre>";
					print_r($valBase);
					echo"</pre>";
					*/
				if(count($valBase)>0){
				$i=0;
				foreach ($valBase as $numGrupo => $numEjemplar) {
					if($i==0){
						$ini=0;
						$fin=$numEjemplar;
						$fila=1;
						for ($i=1; $i <=$numGrupo ; $i++) { 
							$ini=$i==1?0:($ini+$numEjemplar);

							$grupoName="Grupo ".$i;
						    #CREAMOS LOS GRUPOS PARA LA CATEGORIA
							    $sqlGrupoInsert="INSERT INTO grupo(idCatego,nombre,activo)VALUES(".$idCatego.",'".$grupoName."',1)";
							    $resultIG = mysql_query($sqlGrupoInsert,$link);	
							    $idGrupo=mysql_insert_id();
							#FIN CREAMOS LOS GRUPOS PARA LA CATEGORIA

							/*$sqlGrupo="SELECT  i.id as idInscripcion,
							d.prefij,d.nombre,d.codigo,	DATE_FORMAT(d.fecnac,'%d/%m/%Y')fecnac,
							d.prefpa,d.nompad,d.prefma,d.nommad
							,d.criador,d.propie FROM inscripcion i 
							inner join datos220206 d on(i.idEjemplar=d.codigo)
	 			    		WHERE idConcurso=".$idConcurso." and idCatego=".$idCatego."
	 			    		order by d.fecnac desc limit $ini,$fin ";*/

	 			    		$sqlGrupo="SELECT  i.id as idInscripcion
							 FROM inscripcion i 
							inner join sgev_ejemplar d on(i.idEjemplar=d.id)
	 			    		WHERE idConcurso=".$idConcurso." and idCatego=".$idCatego."
	 			    		order by d.fecNace desc limit $ini,$fin ";

	 			    	//	 echo $sqlGrupo."<br>";
							$cuenta=1;
	 			    		$resultG = mysql_query($sqlGrupo,$link);	
							while ($item = mysqli_fetch_array($resultG)) {
			 			 		#ACTUALIZAMOS EL CATALOGO	
								$sqlGrupoUpd="UPDATE inscripcion SET idGrupo=$idGrupo,orderGrupo=$cuenta WHERE id=".$item['idInscripcion']."";
			 			    	$resultUG = mysql_query($sqlGrupoUpd,$link);
								$cuenta++;
							//	echo $sqlGrupoUpd."<br>";
			 			 	}   

							//$ini=$numEjemplar*$fila;
							$fila++;
						}
					}
				}
				}

			}
				$sqlConcursoUpd="UPDATE concurso SET tieneCatal='1' WHERE idConcurso=$idConcurso";
	 			$resultUC = mysql_query($sqlConcursoUpd,$link);
 }
/*FIN FUNCIONES PARA EL ADMIN*/	

function VerificarrDireccionCorreo($direccion)
{
   $Sintaxis='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
   if(preg_match($Sintaxis,$direccion))
      return true;
   else
     return false;
}


function exportarCatalogo($link,$idConcurso){
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header("Content-Disposition: filename=ficheroExcel.xls");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT cat.idCatego,cat.idConcurso, cat.nombre categoria,c.nombre concurso,esPremio
				FROM categoria cat inner join concurso c on (cat.idConcurso=c.idConcurso) 
                WHERE cat.idConcurso = ".$idConcurso." and cat.activo=1 order by cat.orden asc
				";

mysql_query('SET NAMES  iso-8859-1');
mysql_query('SET CHARACTER_SET  iso-8859-1');
$result = mysqli_query($link,$sql);
$colspan=14;
$html="<table border=1 style='font-size:11px;font-family:calibri;'>";
 
$i=0;
$cuenta=1; 
while ($row = mysqli_fetch_array($result)) {
	if($i==0){
		$html.="<tr><td colspan=$colspan style='font-weight:bold;font-size:14px;'><b>".htmlentities($row['concurso'],iso-8859-1)."</b></td></tr>";
	}
	$categoria=$row['categoria'];
	$idConcurso=$row['idConcurso'];
	$idCatego=$row['idCatego'];
	$esPremio=$row['esPremio'];
	
	$html.="<tr><td colspan=$colspan >  </td></tr>";
	$html.="<tr><td colspan=$colspan >  </td></tr>";
	$html.="<tr><td colspan=$colspan style='font-weight:bold;' >  ".htmlentities($categoria,iso-8859-1)."</td></tr>";

	$sqlGrupos = " SELECT  i.id as idInscripcion,d.prefij,CONVERT(d.nombre USING UTF8) AS nombre,d.codigo,DATE_FORMAT(d.fecnac,'%d/%m/%Y')fecnac,
							d.prefpa,d.nompad,d.prefma,d.nommad,d.criador,d.propie ,g.nombre as grupo,i.orderGrupo,d.microchip 
                            FROM 
                            inscripcion i 
                            INNER JOIN datos220206 d on(i.idEjemplar=d.codigo)
                            INNER JOIN grupo g on(g.idGrupo=i.idGrupo)
	 			    		WHERE i.idConcurso=".$idConcurso."  and i.idCatego=".$idCatego." and g.activo=1 
                            ORDER BY g.idGrupo,g.nombre,i.orderGrupo
				";
			mysql_query('SET NAMES iso-8859-1');
			mysql_query('SET CHARACTER_SET iso-8859-1');
			$resultGrupos = mysql_query($sqlGrupos,$link);
			$ig=0;
			$cuentaEjemplarGrupo=0;
			$grupolast="";
			while ($rowG = mysqli_fetch_array($resultGrupos)) {
					$grupo=$rowG['grupo'];
					if($ig==0) {
						$html.="<tr><td colspan=$colspan  ><b> ".$grupo."</b></td></tr>";
						$html.=getHeaderHtmlCatalogo();
					}else{
						if($grupolast!=$grupo){
						$html.="<tr><td colspan=$colspan> ".$cuentaEjemplarGrupo." Ejemplares</td></tr>";
						$html.="<tr><td colspan=$colspan style='background:whitesmoke;'><b> ".$grupo."</b></td></tr>";
						$html.=getHeaderHtmlCatalogo();
						$cuentaEjemplarGrupo=0;
						}

					}
					$cuentaNro="";
					if($esPremio==0){
						$ejemplarAsignado[$rowG["codigo"]]=$cuenta;
						$cuentaNro=$cuenta;
					}else{
						/*echo "<pre>";
						print_r($ejemplarAsignado);
						echo "</pre>";*/
						foreach ($ejemplarAsignado as $key => $value) {
							if($key==$rowG["codigo"]){
								$cuentaNro=$value;
							}
						}
					}
					$html.=getRowsHtmlCatalogo($rowG,$cuentaNro);


					$ig++;
					if($esPremio==0) $cuenta++;
					$cuentaEjemplarGrupo++;
					$grupolast=$grupo;

			}
			if($cuentaEjemplarGrupo>0){
				$html.="<tr><td colspan=$colspan> ".$cuentaEjemplarGrupo." Ejemplares</td></tr>";
			}

	 
 	$i++;
}
//$html.="<tr><td colspan=11>".$cuentaEjemplarGrupo." Ejemplares</td></tr>";
$html.="</table>";

 

return $html;
}

function esCampeon($link,$idEjemplar){
 
$sql1="SELECT * FROM campeon WHERE idEjemplar='".$idEjemplar."' "; 
//echo $sql1;

$result = mysql_query($sql1,$link)or die("error inscripciones - esCampeon");
$n=mysql_num_rows($result);	
		if($n==0){
			return false;
		}else{
			return true;
		}

}
function listarItemsPropietario($link){
		//$sql ="SELECT id as cod_propie,razonSocial as nombres from sgev_entidad order by 2";
	$sql ="select * from (select distinct idProp cod_propie,SGEFN_PROPIETARIOS_X_ID(idProp) nombres from sgev_propietario  
			) q where q.nombres <>''  order by 2 ";
			// echo $sql;
		$result = mysqli_query($link,$sql);
   
		while($res = mysql_fetch_object($result)){
			 $items[]= array('valor' => $res->cod_propie, 
 				 			 'descripcion'=>($res->nombres));
		}
		//echo "<pre>";
//print_r($items);
		return $items;

}
function esCapado($link,$idEjemplar){

$sql="select * from datos220206 where codigo='".$idEjemplar."' and capado=1";
$result=mysql_query($sql,$link) or die("error  - esCapado"); 
$n=mysql_num_rows($result);	
		if($n>0){
			return true;
		}else{
			return false;
		}
}
?>