
<?php session_start();
	require("../../../constante.php");
	date_default_timezone_set("UTC");
	require(DIR_LEVEL_MOD_POE."Clases/conexion.php");
	require(DIR_LEVEL_MOD_POE."Funciones/general.php");

	$cn=new Connection();
	$link=$cn->Conectar();

	 	$idUser= $_POST['idUser'];
	 	$idPoe= $_POST['idPoe'];
	 	$idProp= obtenerIdPropietario( $idUser);
		$data1 = trim($_POST['request']);
		$hidCtrolId = $_POST['hidCtrolId'];
		$hidCtrolName = $_POST['hidCtrolName'];
		$flag=$_POST['flag']; 
		$tipo=$_POST['hidParents'];		


		 if($_POST['hidParents']=='M'){ //hembras
		 	if($flag=="mine"){

				$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' and genero='Y' and cod_propie=".$idProp." order by 3 asc"; //and transfer_opc='0'e
		 	}else{
		 		$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' and codigo like 'Y%'  order by 3 asc"; //and transfer_opc='0'e
		 	}
		 }else if($_POST['hidParents']=='P'){ //machos
		 	
		 	if($flag=="mine"){
				$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM sgev_ejemplar_srch WHERE  nombre LIKE '$data1%' and genero!='Y' and cod_propie=".$idProp." order by 3 asc"; //and transfer_opc='0'e
		 //	echo $sql;
		 	}else if($flag=="others"){
		 		$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM sgev_ejemplar_srch WHERE  nombre LIKE '%$data1%' and genero!='Y' and cod_propie!=".$idProp." order by 3 asc";

		 		
		 	}else if($flag=="foreign"){
		 			$sql="SELECT codigo,prefijo as prefij,nombre,fecnac,fallec,criador,propie FROM sgev_ejemplares_extranjeros 
							where nombre LIKE '$data1%' and genero!='Y' order by 3 asc";
		 	}else{
		 		$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' and codigo not like 'Y%' order by 3 asc"; //and transfer_opc='0'e
		 	}


		 	//echo "entroooo".$sql;


		 }else if($_POST['hidParents']=='ALL'){ // hembras y machos
				$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%'  order by 3 asc"; //and transfer_opc='0'e
		 }else if($_POST['hidParents']=='PO'){ //potros
		 		if($flag=="mine"){
		 			$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' and genero !='Y' and cod_propie=".$idProp." order by 3 asc"; //and transfer_opc='0'e	
		 		}else{
		 			$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' and genero !='Y' order by 3 asc"; //and transfer_opc='0'e	
		 		}

				
 		 }else if($_POST['hidParents']=='Y'){ //yeguas
 		 		if($flag=="mine"){
 		 		$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM sgev_ejemplar_srch WHERE  nombre LIKE '$data1%' and genero ='Y' and cod_propie=".$idProp."  order by 3 asc"; //and transfer_opc='0'e	
 		 	}else if($flag=="others"){
 		 		$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM sgev_ejemplar_srch WHERE  nombre LIKE '$data1%' and genero ='Y' and cod_propie!=".$idProp."  order by 3 asc";
 		 	}else if($flag=="foreign"){
				$sql="SELECT codigo,prefijo as prefij,nombre,fecnac,fallec,criador,propie FROM sgev_ejemplares_extranjeros 
					   where nombre LIKE '$data1%' and genero='Y' order by 3 asc";
			}else{
 		 		$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  FROM ".TABLE_DATO." WHERE  nombre LIKE '$data1%' and genero ='Y'  order by 3 asc"; //and transfer_opc='0'e	
 		 	}
				
		 }else if($_POST['hidParents']=='P6'){ //machos form 6
			 if($flag=="mine"){
			 	$sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  
				  			FROM ".TABLE_DATO." 
				  			WHERE  nombre LIKE '$data1%' and 
				  			genero !='Y' and cod_propie=".$idProp." order by 3 asc"; 
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
				  			genero ='Y' and cod_propie=".$idProp." order by 3 asc"; 
	
				 }else{
				 	 $sql=" SELECT codigo,prefij,nombre,ifnull(DATE_FORMAT(fecnac,'%d/%m/%Y'),'-')as fecnac,codpad,prefpa,nompad,codmad,prefma,nommad,pelaje,descri,lugnac,cod_criador,ifnull(criador,'-')as criador,cod_propie,ifnull(propie,'-')as propie,fallec,ifnull(microchip,'-')as microchip ,ifnull(adn_horse,'-')as adn_horse,fecnac as orden  
				  			FROM ".TABLE_DATO." 
				  			WHERE  nombre LIKE '$data1%' and 
				  			genero = 'Y' order by 3 asc"; 
	
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
 		// echo  $sql;
		$rs = mysqli_query($link,$sql)or die("error ".mysqli_error());
		$metodo=[];
		while($rows=mysqli_fetch_array($rs))
		//while($rows=mysqli_fetch_object($rs))
			{
				$obj = new stdClass();
				$obj->codigo = $rows['codigo'];
                $obj->prefijo_caballo = $rows['prefij'];
                $obj->nombre_caballo = $rows['nombre'];
                $obj->nacimiento_caballo = $rows['fecnac'];
                $obj->padre_caballo = $rows['codpad'];
                $obj->madre_caballo = $rows['codmad'];
                $obj->criador_caballo = $rows['criador'];
                $obj->propietario_caballo = $rows['propie'];
                $obj->fallecio = $rows['fallec'];
                $metodo[] = $obj;
			}
		
	mysqli_free_result($rs);
	$retorno = new stdClass();
	$retorno->data=$metodo ;
	$retorno->cantidad= sizeof($metodo);
	echo json_encode($retorno);


?>
