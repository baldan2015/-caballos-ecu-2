<? session_start();
date_default_timezone_set("UTC");
require("../Clases/conexion.php");
require("../constante.php");
require("../Funciones/general.php");
	$cn=new Connection();
	$link=$cn->Conectar();

	 if($_POST["opc"]=="rptPedigree"){
		$data1 = trim($_POST['nombre']);


			// $genero='Y';
		 if($_POST['genero']=='M'){ 
		 	$genero=" genero = 'P' " ;
		 } else{
		 	$genero=" genero = 'Y' " ;
		 }
	 
				$sql=" SELECT id,prefijo,nombre,ifnull(DATE_FORMAT(fecNace,'%d/%m/%Y'),'-')as fecnac
								FROM sge_ejemplar WHERE  nombre LIKE '%$data1%' and  $genero 
							--	and fecFallece is null
				    order by 3 asc"; //and transfer_opc='0'e
		 	  

 //echo  $sql;
		$rs = mysql_query($sql,$link)or die("error ".mysql_error());
		
		while($rows=mysqli_fetch_array($rs))
			{
				$neofec="";	
				// include("../status.php");
				$neofec=$rows[3];
				$arrayrs[]=array('n'=>$f,
						 'codigo'=>$rows[0],	
						 'prefijo_caballo'=>$rows[1],
						 'nombre_caballo'=>($rows[2]),
						 'nacimiento_caballo'=>$neofec//,
				 		 );
				$f++;
			}
		$html = "";
		$html.= "<table class='gridHtmlBG' style='width:100%;border-collapse:collapse;' border=1 >";
		$html.= "<thead style='background:#d3d3d3;'>";
		$html.= "<tr>";
		$html.= "<th></th>";
		$html.= "<th>C&oacute;digo</th>";
		$html.= "<th>Pref.</th>";
		$html.= "<th>Nombre de Ejemplar</th>";
		$html.= "<th>Fec. Nac</th>";
		$html.= "</thead>";
		$html.= "<tbody>";
		$c=0;
			  $genero='Y';
		 if($_POST['genero']=='M'){ 
		 	$genero='P';
		 }  
		for ($fila=0; $fila < sizeof($arrayrs) ; $fila++) { 
			$html.= "<tr 
							onclick=ejeSelPedigree('$genero".$arrayrs[$fila][n]."','$genero');
							data-codigo='".$arrayrs[$fila][codigo]."' 
							id='filaSel_".$arrayrs[$fila][codigo]."' class='filaSel gridHtmlRow cursor' >
							";
			 
			$html.= "<td align='center'><input type='checkbox' name='$genero' id='$genero".$arrayrs[$fila][n]."' value='".$arrayrs[$fila][codigo]."' \></td>";
			$html.= "<td align='center'>".$arrayrs[$fila][codigo]."</td>";
			$html.= "<td align='left'>".$arrayrs[$fila][prefijo_caballo]."</td>";
			$html.= "<td align='left'>".$arrayrs[$fila][nombre_caballo]."</td>";
			$html.= "<td align='center'>".$arrayrs[$fila][nacimiento_caballo]."</td>";
			 
            $html.= "</tr>";
            $c++;
			}
	
		$html.= "</tbody>";

		$html.= "</table>";




		mysqli_free_result($rs);

		/*$resultado=new stdClass();
		$resultado->html=$html;
		$resultado->rowNum=$fila;
 		*/
 		echo $html;// json_encode($resultado);
		 

?>
 
		<script>
		function ejeSelPedigree(id,genero){
		 	$('input[name='+genero+']').each(function() {			this.checked = false;		});
 			$('#'+id+'').prop('checked',true);
 		 }
 		</script>
 	 
<?
}
if($_POST['opc']=="arbolPedigree"){
 
 
			$sql = "CALL SGESS_ARBOL_GEN_SIMULADOR('".$_POST['padre']."','".$_POST['madre']."')";
			//echo $sql."<br>";
            $db=new Connection();
            //echo  $db;
            $result = $db->ejecutar2($sql);
            $datos=[];
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->orden=$fila->orden;
				$obj->id=$fila->id==null?"":$fila->id;
                $obj->ejemplar=$fila->ejemplar==null?"":$fila->ejemplar;
                $obj->prefijo=$fila->prefijo==null?"":$fila->prefijo;
                $obj->per=$fila->per;
           
           		if($obj->id=='EP.00.0.0000' || $obj->id=='N/N'){
           			$obj->id="N.N";
           		}

                $datos[]=$obj;
            }
            echo  json_encode($datos);
}
if($_POST['opc']=="arbolGen"){
 
 
			$sql = "CALL SGESS_ARBOL_GEN_PORID('".$_POST['id']."')";
            $db=new Connection();
            $result = $db->ejecutar2($sql);
            $datos=[];
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->orden=$fila->orden;
                $obj->id=$fila->id==null?"":$fila->id;
                $obj->ejemplar=$fila->ejemplar==null?"":$fila->ejemplar;
                $obj->prefijo=$fila->prefijo==null?"":$fila->prefijo;
                $obj->per=$fila->per;
                $obj->pelaje=$fila->pelaje==null?"":$fila->pelaje;
                $obj->fecNace=$fila->fecNace==null?"":($fila->fecNace=="00/00/0000"?"":$fila->fecNace);
           
                $datos[]=$obj;
            }
            echo  json_encode($datos);
}
if($_POST['opc']=="arbolPedigreeCalc"){
 
 echo CalcPedigreeHtml($_POST['padre'],$_POST['madre']);
 
}
if($_POST['opc']=="arbolGenCalc"){
 
 echo CalcPedigreeArbolHtml($_POST['id']);
 
}
function CalcPedigreeHtml($padre,$madre){
	$sql = "CALL SGESS_ARBOL_GEN_SIMULADOR_CALC('".$padre."','".$madre."')";
 			 
            $db=new Connection();
 
            $result = $db->ejecutar2($sql);
 
            $sum=0;
            $html="<table width='100%' border='1' id='tblResumen' >
            <tr class='cssHeadTbl' ><td colspan=2>Visualización de consanguínidad</td> <tr>
            <tr class='cssHeadTbl' ><td>Antepasado</td><td>% de sangre</td><tr>";
            while($fila = mysqli_fetch_object($result)){
             
				 
					$html.= "<tr><td class='cssLabelArbol'>";
	                $html.= $fila->ejemplar==null?"-":$fila->ejemplar;
	                $html.= "</td><td class='cssLabelArbol' style='text-align:  right; '>";
	                $html.= number_format($fila->totalPer,2);
	                $html.= " %&nbsp;</td>";
	           		$html.= "</tr>";
	           		$sum=$sum+$fila->totalPer;
           		 
               
            }
        

            $html.= "</table>";
           return $html;
}
function CalcPedigreeArbolHtml($ejemplar){
	$sql = "CALL SGESS_ARBOL_GEN_PORID_CALC('".$ejemplar."')";
 		//	 echo $sql;
            $db=new Connection();
 
            $result = $db->ejecutar2($sql);
 
            $sum=0;
            $html="<table width='100%' border='1'style='border-collapse: collapse;' id='tblResumen' >
            <tr class='cssHeadTbl' ><td colspan=2>Visualización de consanguínidad</td> <tr>
            <tr class='cssHeadTbl' ><td>Antepasado</td><td>% de sangre</td><tr>";
            while($fila = mysqli_fetch_object($result)){
             
				 
					$html.= "<tr><td class='cssLabelArbol'>";
	                $html.= $fila->ejemplar==null?"-":$fila->ejemplar;
	                $html.= "</td><td class='cssLabelArbol' style='text-align:  right; '>";
	                $html.= number_format($fila->totalPer,2);
	                $html.= " %&nbsp;</td>";
	           		$html.= "</tr>";
	           		$sum=$sum+$fila->totalPer;
           		 
               
            }
        

            $html.= "</table>";
           return $html;
}
?>