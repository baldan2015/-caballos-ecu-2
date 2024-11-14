<? session_start();
	 date_default_timezone_set("UTC");
require("../Clases/conexion.php");
require("../constante.php");
require("../Funciones/general.php");
	$cn=new Connection();
	$link=$cn->Conectar();

	 	$idUser= $_POST['idUser'];
	 	$idPoe= $_POST['idPoe'];
	 	$idProp= obtenerIdPropietario( $idUser);
		$data1 = trim($_POST['request']);
		$hidCtrolId = $_POST['hidCtrolId'];
		$hidCtrolName = $_POST['hidCtrolName'];
		$flag=$_POST['flag']; 		


		 if($_POST['hidParents']=='M'){ //hembras
		 	if($flag=="mine"){

				$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' and codigo like 'Y%' and cod_propie=".$idProp." order by 3 asc"; //and transfer_opc='0'e
		 	}else{
		 		$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' and codigo like 'Y%'  order by 3 asc"; //and transfer_opc='0'e
		 	}
		 }else if($_POST['hidParents']=='P'){ //machos
		 	if($flag=="mine"){
				$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' and codigo not like 'Y%' and cod_propie=".$idProp." order by 3 asc"; //and transfer_opc='0'e
		 	}else{
		 		$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' and codigo not like 'Y%' order by 3 asc"; //and transfer_opc='0'e
		 	}
		 }else if($_POST['hidParents']=='ALL'){ // hembras y machos
				$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%'  order by 3 asc"; //and transfer_opc='0'e
		 }else if($_POST['hidParents']=='PO'){ //potros
		 		if($flag=="mine"){
		 			$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' and codigo not like 'Y%' and cod_propie=".$idProp." order by 3 asc"; //and transfer_opc='0'e	
		 		}else{
		 			$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' and codigo not like 'Y%' order by 3 asc"; //and transfer_opc='0'e	
		 		}

				
 		 }else if($_POST['hidParents']=='Y'){ //yeguas
 		 		if($flag=="mine"){
 		 		$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' and codigo like 'Y%' and cod_propie=".$idProp."  order by 3 asc"; //and transfer_opc='0'e	
 		 	}else{
 		 		$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' and codigo like 'Y%'  order by 3 asc"; //and transfer_opc='0'e	
 		 	}
				
		 }else if($_POST['hidParents']=='P6'){ //machos form 6
			 if($flag=="mine"){
			 	$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  
				  			FROM ".TABLE_DATO." 
				  			WHERE  nombre LIKE '$data1%' and 
				  			codigo not like 'Y%' and cod_propie=".$idProp." order by 3 asc"; 
		 		}else{
				$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  
				  			FROM ".TABLE_DATO." 
				  			WHERE  nombre LIKE '$data1%' and 
				  			codigo not like 'Y%'  order by 3 asc"; 
				  		}
				
		 }else if($_POST['hidParents']=='M6'){ //yeguas form 6
				 if($flag=="mine"){
				 $sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  
				  			FROM ".TABLE_DATO." 
				  			WHERE  nombre LIKE '$data1%' and 
				  			codigo like 'Y%' and cod_propie=".$idProp." order by 3 asc"; 
	
				 }else{
				 	 $sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  
				  			FROM ".TABLE_DATO." 
				  			WHERE  nombre LIKE '$data1%' and 
				  			codigo like 'Y%' order by 3 asc"; 
	
				 }
				  
		 }else if($_POST['hidParents']=='ALLMINE'){ //machos
		 	if($flag=="mine"){
		 		  $sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' and cod_propie=".$idProp." order by 3 asc"; //and transfer_opc='0'e
		 		}else{
		 			  $sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' order by 3 asc"; //and transfer_opc='0'e
		 		}
				
				 
		 }else if($_POST['hidParents']=='MINE_USER'){ //machos
		 $idPoe=$_SESSION['_periodoPoe'];
		 $cod_propie= obtenerIdPropietario($idUser);
		 $idPoeAnterior=tienePOEAnterior($link,$cod_propie,$idPoe);
		 
				  $sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO."
				   WHERE  nombre LIKE '$data1%' 
				   and  cod_propie=$cod_propie
				   and fallec=0
				   and codigo not in( 
							SELECT DISTINCT codigo
		  					FROM ( 
		  						SELECT p.codEjemplar COLLATE utf8_unicode_ci as codigo
								FROM poe_propiedad p WHERE  p.idPoe =".$idPoeAnterior." and p.idUser=".$idUser."
								 AND p.codEjemplar NOT IN (SELECT p.codEjemplar FROM poe_propiedad p WHERE p.idPoe =".$idPoe." and p.idUser=".$idUser." )
							UNION ALL
						      	SELECT p.codEjemplar FROM poe_movimiento p WHERE p.idPoe =".$idPoe." and p.idUser=".$idUser."  and p.tipo = 'A' and p.codEjemplar not in( select m.codEjemplar   FROM poe_propiedad m WHERE m.idPoe =".$idPoe."  and m.idUser=".$idUser." )
						    UNION ALL
						    	SELECT p.codEjemplar FROM poe_propiedad p WHERE p.idPoe =".$idPoe." and p.idUser=".$idUser."  	
								) as q 
							 		
				    )
				   order by 3 asc";  
				 
		 }
 //echo  $sql;
		$rs = mysql_query($sql,$link)or die("error ".mysql_error());
		
		while($rows=mysqli_fetch_array($rs))
			{
				$neofec="";	
				include("../status.php");
				$neofec=$rows[3];
				$arrayrs[]=array('n'=>$f,
						 'codigo'=>$rows[0],	
						 'prefijo_caballo'=>$rows[1],
						 'nombre_caballo'=>($rows[2]),
						 'nacimiento_caballo'=>$neofec,
						 'padre_caballo'=>($rows[6]),
						 'madre_caballo'=>($rows[9]),
						 'criador_caballo'=>($rows[14]),
						 'propietario_caballo'=>($rows[16]),
						 'fallecio'=>$status,
						 'microchip_caballo'=>$rows[18],
				 		 'adn_caballo'=>$rows[19],
				 		 'nombre'=>$rows[1]." ".($rows[2]),
				 		 'prefijo_padre'=>$rows[5],
						 'prefijo_madre'=>$rows[8],
				 		 );
				$f++;
			}
		
		






		$html = "";
		$html.= "<table class='gridHtmlBG' style='width:100%;border-collapse:collapse;' border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th>Codigo</th>";
		$html.= "<th>Pref.</th>";
		$html.= "<th>Nombre de Ejemplar</th>";
		$html.= "<th>Fec. Nac</th>";
		if($_POST['hidParents']!='MINE_USER'){
			$html.= "<th>Estado</th>";
			$html.= "<th>Propietario</th>";
			$html.= "<th>Criador</th>";
		}
		$html.= "</thead>";
		$html.= "<tbody>";
		for ($fila=0; $fila < sizeof($arrayrs) ; $fila++) { 

			if($hidCtrolId!="ADMIN"){
						if($_POST['hidParents']!='MINE_USER'){
							$html.= "<tr onclick='ejeSel(this);'";
						}else{
							$html.= "<tr onclick='ejeSelForm1(this);'";

						}
						
						$html.= "	data-codigo='".$arrayrs[$fila][codigo]."' 
							data-prefijo='".$arrayrs[$fila][prefijo_caballo]."' 
							data-ejemplar='".$arrayrs[$fila][nombre_caballo]."'
							data-crtid='".$hidCtrolId."' 
							data-name='".$hidCtrolName."' 
							id='filaSel_".$arrayrs[$fila][n]."' class='filaSel gridHtmlRow cursor' >";
			}else{


							$nCria=getNroCria($link,$arrayrs[$fila][codigo]);


						$nCria=edad($arrayrs[$fila][nacimiento_caballo]);

						$html.= "<tr 
							onclick='ejeSelAdmin(this);'
							data-codigo='".$arrayrs[$fila][codigo]."' 
							data-prefijo='".$arrayrs[$fila][prefijo_caballo]."' 
							data-ejemplar='".$arrayrs[$fila][nombre_caballo]."'
							data-madre='".$arrayrs[$fila][prefijo_madre]."  ".$arrayrs[$fila][madre_caballo]."' 
							data-padre='".$arrayrs[$fila][prefijo_padre]."  ".$arrayrs[$fila][padre_caballo]."' 
							data-chip='".$arrayrs[$fila][microchip_caballo]."' 
							data-adn='".$arrayrs[$fila][adn_caballo]."' 
							data-nace='".$arrayrs[$fila][nacimiento_caballo]."' 							
							data-ncria='".$nCria."' 
							id='filaSel_".$arrayrs[$fila][n]."' class='filaSel gridHtmlRow cursor' >

							<input type='hidden'  id='hidCriador_".$arrayrs[$fila][codigo]."' value='".$arrayrs[$fila][criador_caballo]."'>
							<input type='hidden'  id='hidPropietario_".$arrayrs[$fila][codigo]."' value='".$arrayrs[$fila][propietario_caballo]."'>
							";
			}

			$html.= "<td align='center'>".$arrayrs[$fila][codigo]."</td>";
			$html.= "<td align='left'>".$arrayrs[$fila][prefijo_caballo]."</td>";
			$html.= "<td align='left'>".$arrayrs[$fila][nombre_caballo]."</td>";
			$html.= "<td align='center'>".$arrayrs[$fila][nacimiento_caballo]."</td>";
			if($_POST['hidParents']!='MINE_USER'){
				$html.= "<td align='center'>".$arrayrs[$fila][fallecio]."</td>";
				$html.= "<td align='left'>".$arrayrs[$fila][propietario_caballo]."</td>";
				$html.= "<td align='left'>".$arrayrs[$fila][criador_caballo]."</td>";
			}	
            $html.= "</tr>";
			}
	
		$html.= "</tbody>";
		$html.= "</table>";

mysqli_free_result($rs);
	echo $html;

function edad($fecha){
$fecha = str_replace("/","-",$fecha);
$fecha = date('Y/m/d',strtotime($fecha));
// $hoy = date('Y/m/d');

$hoy= str_replace("/","-","2018/03/26");
$hoy = date('Y/m/d',strtotime($hoy));


$edad = $hoy - $fecha; 
return $edad; }

function getNroCria($link,$id){
	
			if(substr($id,0,1)=="Y"){
					$sqls="select count(*) from  datos220206  where  codmad ='".$id."'";
			}else{
					$sqls="select count(*) from  datos220206  where  codpad ='".$id."'";
			}
			$rs = mysql_query($sqls,$link);
			$fila = mysql_fetch_row($rs);

			return $fila[0];

}
?>
<script>
function ejeSelForm1(obj){

var id=$(obj).data("codigo");
var prefijo=$(obj).data("prefijo");
var ejemplar=$(obj).data("ejemplar");
var hidCtrolId=$(obj).data("crtid");
var hidCtrolName=$(obj).data("name");

//console.log(id+" , "+prefijo+" , "+ejemplar);
insertBoton(id,prefijo,ejemplar);

	//$("#"+hidCtrolId).val(id);
	//$("#"+hidCtrolName).html(prefijo + "  "+ejemplar+ " - "+id);
	$("#divBuscarEjemplar").dialog("close");
}
function ejeSel(obj){

var id=$(obj).data("codigo");
var prefijo=$(obj).data("prefijo");
var ejemplar=$(obj).data("ejemplar");
var hidCtrolId=$(obj).data("crtid");
var hidCtrolName=$(obj).data("name");

	$("#"+hidCtrolId).val(id);
	$("#"+hidCtrolName).html(prefijo + "  "+ejemplar+ " - "+id);
	$("#divBuscarEjemplar").dialog("close");
}

function ejeSelAdmin(obj){

var id=$(obj).data("codigo");
var prefijo=$(obj).data("prefijo");
var ejemplar=$(obj).data("ejemplar");
var madre=$(obj).data("madre");
var padre=$(obj).data("padre");
var chip=$(obj).data("chip");
var adn=$(obj).data("adn");
var nace=$(obj).data("nace");
var ncria=$(obj).data("ncria");
var criador=$("#hidCriador_"+id).val();
var propietario=$("#hidPropietario_"+id).val();

$("#txtSexo").val("-");
if(id.indexOf("P")!=-1 || id.indexOf("C")!=-1 ){
	$("#txtSexo").val("MACHO");
}
if(id.indexOf("Y")!=-1){
	$("#txtSexo").val("HEMBRA");
}


$.ajax({
				data:  {opc:'getMH',idEjemplar:id},
				url:   'ajaxPOE/ajaxFormAdminPoe.php',
				type:  'post',
				success:  function (response) {
				     
				     var entidad= JSON.parse(response);

				     if(entidad.codEjemplar!=null){
				     	//console.log("entro codejmplar !=null");
				     	/*OBTENER DATOS MH REGISTRADDOS Y ACTUALIZAR*/ 
				     	
						 $("#txtPrintCriador").val(entidad.criador);
            			 $("#txtPrintPropietario").val(entidad.propietario);

						$("#txtBGralNombre").val(entidad.NomEjemplar);
						$("#txtBGralCodigo").val(entidad.codEjemplar);
						$("#txtBGralADN").val(entidad.adnEjemplar);
						$("#txtBGralMicrochip").val(entidad.chipEjemplar);
						$("#txtBGralPadre").val(entidad.PadEjemplar);
						$("#txtBGralMadre").val(entidad.MadEjemplar);


						$("#txtBGralNace").val(entidad.naceEjemplar)
						//$("#txtBGralPrenez").val(entidad.prenezEjemplar);
						$("#txtBGralCria").val(entidad.nCriaEjemplar);

       $("#txtHCruz").val(entidad.hCruz);
       $("#txtHGrupa").val(entidad.hGrupa);
       $("#txtLCabeza").val(entidad.lCabeza);
       $("#txtWCabeza").val(entidad.wCabeza);
       $("#txtLCuello").val(entidad.lCuello);
       $("#txtLEspalda").val(entidad.lEspalda);
       $("#txtLBrazo").val(entidad.lBrazo);
       $("#txtWPecho").val(entidad.wPecho);
       $("#txtPTorax").val(entidad.pTorax);
       $("#txtPCania").val(entidad.pCania);
       $("#txtHEsternon").val(entidad.lEsternon);
       $("#txtLDorso").val(entidad.lDorso);
       $("#txtLAnimal").val(entidad.lAnimal);
       $("#txtLGrupa").val(entidad.lGrupa);
       $("#txtLFemur").val(entidad.lFemur);
       $("#txtWGrupa").val(entidad.wGrupa);
       $("#txtIncEspalda").val(entidad.incEspalda);
       $("#txtIncGrupa").val(entidad.incGrupa);
       $("#txtAngEspalda").val(entidad.angEspalda);
       $("#txtAngBrazo").val(entidad.angBrazo);
       $("#txtAngGrupa").val(entidad.angGrupa);
       $("#txtAngFemur").val(entidad.angFemur);
       $("#txtAngCorvejon").val(entidad.angCorvejon);


       $("#txtHCruzObserv").val(entidad.hCruzObserv);
       $("#txtHGrupaObserv").val(entidad.hGrupaObserv);
       $("#txtLCabezaObserv").val(entidad.lCabezaObserv);
       $("#txtWCabezaObserv").val(entidad.wCabezaObserv);
       $("#txtLCuelloObserv").val(entidad.lCuelloObserv);
       $("#txtLEspaldaObserv").val(entidad.lEspaldaObserv);
       $("#txtLBrazoObserv").val(entidad.lBrazoObserv);
       $("#txtWPechoObserv").val(entidad.wPechoObserv);
       $("#txtPToraxObserv").val(entidad.pToraxObserv);
       $("#txtPCaniaObserv").val(entidad.pCaniaObserv);
       $("#txtHEsternonObserv").val(entidad.lEsternonObserv);
       $("#txtLDorsoObserv").val(entidad.lDorsoObserv);
       $("#txtLAnimalObserv").val(entidad.lAnimalObserv);
       $("#txtLGrupaObserv").val(entidad.lGrupaObserv);
       $("#txtLFemurObserv").val(entidad.lFemurObserv);
       $("#txtWGrupaObserv").val(entidad.wGrupaObserv);
       $("#txtIncEspaldaObserv").val(entidad.incEspaldaObserv);
       $("#txtIncGrupaObserv").val(entidad.incGrupaObserv);
       $("#txtAngEspaldaObserv").val(entidad.angEspaldaObserv);
       $("#txtAngBrazoObserv").val(entidad.angBrazoObserv);
       $("#txtAngGrupaObserv").val(entidad.angGrupaObserv);
       $("#txtAngFemurObserv").val(entidad.angFemurObserv);
       $("#txtAngCorvejonObserv").val(entidad.angCorvejonObserv);
 


       $("#txtFrenCer").val(entidad.frenCerConj);
       $("#txtFrenAbi").val(entidad.frenAbiConj);
       $("#txtFrenPat").val(entidad.frenPatizambo);
       $("#txtFrenZamb").val(entidad.frenZambo);
       $("#txtFrenEst").val(entidad.frenEstevado);
       $("#txtFrenIzq").val(entidad.frenIzquierdo);
       $("#txtPerfAntPlan").val(entidad.perfAntPlantado);
       $("#txtPerfAntRem").val(entidad.perfAntRemitido);
       $("#txtPerfAntCorvo").val(entidad.perfAntCorvo);
       $("#txtPerfAntTrans").val(entidad.perfAntTranscorvo);
       $("#txtPerfAntSentCuar").val(entidad.perfAntSentCuar);
       $("#txtPerfAntParCuar").val(entidad.perfAntParCuar);
       $("#txtAtrCerConj").val(entidad.atrCerConj);
       $("#txtAtrAbiConj").val(entidad.atrAbiConj);
       $("#txtAtrCerCorv").val(entidad.atrCerCorv);
       $("#txtAtrAbiCorv").val(entidad.atrAbiCorv);
       $("#txtAtrEst").val(entidad.atrEstevado);
       $("#txtAtrIzq").val(entidad.atrIzquierdo);
       $("#txtPerfPostPlan").val(entidad.perfPostPlantado);
       $("#txtPerfPostRem").val(entidad.perfPostRemitido);
       $("#txtPerfPostCerCorv").val(entidad.perfPostCerCorv);
       $("#txtPerfPostAbiCorv").val(entidad.perfPostAbiCorv);
       $("#txtPerfPostSentCuar").val(entidad.perfPostSentCuar);
       $("#txtPerfPostParCuar").val(entidad.perfPostParCuar);

				     }else{

				     //	console.log("entro codejmplar ==null");
				     	/*NO SE ENCONTRARON EJEMPLAR MH REGISTRADO ...NUEVO REGISTRO*/
				     	$("#txtBGralNombre").val(prefijo + " "+ejemplar);
						$("#txtBGralCodigo").val(id);
						$("#txtBGralADN").val(adn);
						$("#txtBGralMicrochip").val(chip);
						$("#txtBGralPadre").val(padre);
						$("#txtBGralMadre").val(madre);
						$("#txtBGralNace").val(nace);
						$("#txtBGralCria").val(ncria);

						$("#txtPrintCriador").val(criador);
            			$("#txtPrintPropietario").val(propietario);

						$("#txtHCruz").val("");//(entidad.hCruz);
       $("#txtHGrupa").val("");//(entidad.hGrupa);
       $("#txtLCabeza").val("");//(entidad.lCabeza);
       $("#txtWCabeza").val("");//(entidad.wCabeza);
       $("#txtLCuello").val("");//(entidad.lCuello);
       $("#txtLEspalda").val("");//(entidad.lEspalda);
       $("#txtLBrazo").val("");//(entidad.lBrazo);
       $("#txtWPecho").val("");//(entidad.wPecho);
       $("#txtPTorax").val("");//(entidad.pTorax);
       $("#txtPCania").val("");//(entidad.pCania);
       $("#txtLEsternon").val("");//(entidad.lEsternon);
       $("#txtLDorso").val("");//(entidad.lDorso);
       $("#txtLAnimal").val("");//(entidad.lAnimal);
       $("#txtLGrupa").val("");//(entidad.lGrupa);
       $("#txtLFemur").val("");//(entidad.lFemur);
       $("#txtWGrupa").val("");//(entidad.wGrupa);
       $("#txtIncEspalda").val("");//(entidad.incEspalda);
       $("#txtIncGrupa").val("");//(entidad.incGrupa);
       $("#txtAngEspalda").val("");//(entidad.angEspalda);
       $("#txtAngBrazo").val("");//(entidad.angBrazo);
       $("#txtAngGrupa").val("");//(entidad.angGrupa);
       $("#txtAngFemur").val("");//(entidad.angFemur);
       $("#txtAngCorvejon").val("");//(entidad.angCorvejon);


       $("#txtHCruzObserv").val("");//(entidad.hCruzObserv);
       $("#txtHGrupaObserv").val("");//(entidad.hGrupaObserv);
       $("#txtLCabezaObserv").val("");//(entidad.lCabezaObserv);
       $("#txtWCabezaObserv").val("");//(entidad.wCabezaObserv);
       $("#txtLCuelloObserv").val("");//(entidad.lCuelloObserv);
       $("#txtLEspaldaObserv").val("");//(entidad.lEspaldaObserv);
       $("#txtLBrazoObserv").val("");//(entidad.lBrazoObserv);
       $("#txtWPechoObserv").val("");//(entidad.wPechoObserv);
       $("#txtPToraxObserv").val("");//(entidad.pToraxObserv);
       $("#txtPCaniaObserv").val("");//(entidad.pCaniaObserv);
       $("#txtLEsternonObserv").val("");//(entidad.lEsternonObserv);
       $("#txtLDorsoObserv").val("");//(entidad.lDorsoObserv);
       $("#txtLAnimalObserv").val("");//(entidad.lAnimalObserv);
       $("#txtLGrupaObserv").val("");//(entidad.lGrupaObserv);
       $("#txtLFemurObserv").val("");//(entidad.lFemurObserv);
       $("#txtWGrupaObserv").val("");//(entidad.wGrupaObserv);
       $("#txtIncEspaldaObserv").val("");//(entidad.incEspaldaObserv);
       $("#txtIncGrupaObserv").val("");//(entidad.incGrupaObserv);
       $("#txtAngEspaldaObserv").val("");//(entidad.angEspaldaObserv);
       $("#txtAngBrazoObserv").val("");//(entidad.angBrazoObserv);
       $("#txtAngGrupaObserv").val("");//(entidad.angGrupaObserv);
       $("#txtAngFemurObserv").val("");//(entidad.angFemurObserv);
       $("#txtAngCorvejonObserv").val("");//(entidad.angCorvejonObserv);

       $("#txtFrenCer").val("");
       $("#txtFrenAbi").val("");
       $("#txtFrenPat").val("");
       $("#txtFrenZamb").val("");
       $("#txtFrenEst").val("");
       $("#txtFrenIzq").val("");
       $("#txtPerfAntPlan").val("");
       $("#txtPerfAntRem").val("");
       $("#txtPerfAntCorvo").val("");
       $("#txtPerfAntTrans").val("");
       $("#txtPerfAntSentCuar").val("");
       $("#txtPerfAntParCuar").val("");
       $("#txtAtrCerConj").val("");
       $("#txtAtrAbiConj").val("");
       $("#txtAtrCerCorv").val("");
       $("#txtAtrAbiCorv").val("");
       $("#txtAtrEst").val("");
       $("#txtAtrIzq").val("");
       $("#txtPerfPostPlan").val("");
       $("#txtPerfPostRem").val("");
       $("#txtPerfPostCerCorv").val("");
       $("#txtPerfPostAbiCorv").val("");
       $("#txtPerfPostSentCuar").val("");
       $("#txtPerfPostParCuar").val("");
						 
				     }
		     
				}
		});






	$("#divBuscarEjemplar").dialog("close");
}

</script>