<?php

class dal {
    
    private $servidor;
    private $usuario;
    private $password;
    private $basedatos;
    
    //Constructor
    public function dal() { 
        
        $this->servidor = "localhost";
        $this->usuario = "root";
        $this->password = "rootroot";
        $this->basedatos = "ecu_registro_sge";
        
      /*  $this->servidor = "50.62.209.108:3306";
        $this->usuario = "sge";
        $this->password = "E&w141sr";
        $this->basedatos = "teonsolutions_sge"; */
    }

    public function conectar2() {
        $mysqli = new mysqli($this->servidor, $this->usuario, $this->password, $this->basedatos);
       if (mysqli_connect_errno()) {
            echo "Connection Failed: " . mysqli_connect_errno();
            exit();
        }
        return $mysqli;
    }
    public function ejecutar2($sql,$param='') {
        $db = $this->conectar2();
        $db->query('SET NAMES UTF8');
		$db->query('SET CHARACTER_SET UTF8');
		$db->query('SET SESSION sql_mode = "" '); 
        $resultado= $db->query($sql);
         if(strlen($param)>0){
               $output=" SELECT $param ";
                return $db->query($output);
         }else{
             return $resultado;
         }
    }
      
     public function ejecutarParam($SpName,$param='') {
        $db = $this->conectar2();
        
         $mysqli= $db;
         $call = $mysqli->prepare('CALL SGESI_PELAJE(?, @vresultado)');
         $call->bind_param( $param);
         $call->execute();

         $select = $mysqli->query('SELECT @vresultado');
         return $select;
    }
    /*SOLO PARA LA GRILLA DATATABLE JQUERY*/
    public function loadDataTable($aColumns,$sIndexColumn,$sTable){
    $db = $this->conectar2();
    /* 	  Paging	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysqli_real_escape_string( $db, $_GET['iDisplayStart'] ).", ".
			mysqli_real_escape_string(  $db, $_GET['iDisplayLength'] );
	}
	/* Ordering	 */
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysqli_real_escape_string( $db, $_GET['sSortDir_'.$i] ) .", ";
			}
		}
    	$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($db, $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	//echo $aColumns;
    /* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )		$sWhere = "WHERE ";
			else        				$sWhere .= " AND ";
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($db,$_GET['sSearch_'.$i])."%' ";
		}
	}
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "	SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
	";

    $rResult =  $db->query($sQuery); 
	//$rResult = mysqli_query( $sQuery, $gaSql['link'] ) or die(mysqli_error());
	
	/* Data set length after filtering */
	$sQuery = " SELECT FOUND_ROWS()	";
    $rResultFilterTotal =  $db->query($sQuery);     
	//$rResultFilterTotal = mysqli_query( $sQuery, $gaSql['link'] ) or die(mysqli_error());
	$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "	SELECT COUNT(".$sIndexColumn.")		FROM   $sTable	";
    $rResultTotal =  $db->query($sQuery);    
	//$rResultTotal = mysqli_query( $sQuery, $gaSql['link'] ) or die(mysqli_error());
	$aResultTotal = mysqli_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];

	/* Output	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
    while ( $aRow = mysqli_fetch_array( $rResult ) )
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == "version" )
			{
				/* Special output formatting for 'version' column */
				$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
			else if ( $aColumns[$i] != ' ' )
			{
				/* General output */
				$row[] = $aRow[ $aColumns[$i] ];
			}
		}
		$output['aaData'][] = $row;
	}
    return $output;

            
        }
}
?>