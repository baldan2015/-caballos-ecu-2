<?php
	include_once("modelo.php");
	if (file_exists("../entidad/Transferencia.inc.php")) include_once("../entidad/Transferencia.inc.php");
	if (file_exists("../entidad/Resultado.inc.php")) include_once("../entidad/Resultado.inc.php");
	if (file_exists("../entidad/TransferenciaDTO.inc.php")) include_once("../entidad/TransferenciaDTO.inc.php");

	class TransferenciaData extends dal{
		public $retorno;
		function __construct(){
			parent::dal();
			$retorno=new Resultado();
		}

		public function insertar($id, $idEjemplar, $idNuevoProp, $idAntiguoProp, $idNuevoCria, $idAntiguoCria, $fechaRegistro, $fechaTransferencia, $estado,$usuario_crea){
			$retorno = new Resultado();			
		     $sql = "CALL SGESI_TRANSFERENCIA('$id', '$idEjemplar', '$idNuevoProp', '$idAntiguoProp', '$idNuevoCria', '$idAntiguoCria', '$fechaRegistro', '$fechaTransferencia', '$estado','$usuario_crea', @vresultado)";
		    // echo  $sql;
					$result = parent::ejecutar2($sql, '@vresultado');
			if ($result){

				if($fila = mysqli_fetch_array($result)){
					//echo $fila[0]." ... <br>";
					if ($fila[0] > 0){
						$retorno->result=1;
					}else{
						$retorno->result=0;
					}
				}
			}else{
				$retorno->result=0;
			}
			return $retorno;
		} 

		public function editar($id, $idEjemplar, $idNuevoProp, $idAntiguoProp, $idNuevoCria, $idAntiguoCria, $fechaRegistro, $fechaTransferencia, $estado,$usuario_modi){
			$retorno = new Resultado();			
		     $sql = "CALL SGESU_TRANSFERENCIA('$id', '$idEjemplar', '$idNuevoProp', '$idAntiguoProp', '$idNuevoCria', '$idAntiguoCria', '$fechaRegistro', '$fechaTransferencia', '$estado','$usuario_modi',@vresultado)";
		     //echo $sql;
			$result = parent::ejecutar2($sql, '@vresultado');
			if ($result){
				if($fila = mysqli_fetch_array($result)){
					if ($fila[0] == 1){
						$retorno->result=1;
					}else{
						$retorno->result=2;
					}
				}
			}else{
				$retorno->result=0;
			}
			return $retorno;
		}

		public function eliminar($id,$usuario_modi){
			$retorno = new Resultado();
		     $sql = "CALL SGESD_TRANSFERENCIA('$id','$usuario_modi',@vresultado)";			
			$result = parent::ejecutar2($sql, '@vresultado');
			if ($result){
				return true;
			}else{
				return false;
			}
		}

		public function confirmar($id, $fechaTransferencia){
			$retorno = new Resultado();			
		     $sql = "CALL SGESU_TRANSFERENCIA_CONFIRMAR('$id', '$fechaTransferencia', @vresultado)";
			$result = parent::ejecutar2($sql, '@vresultado');
			if ($result){
				if($fila = mysqli_fetch_array($result)){
					if ($fila[0] == 1){
						$retorno->result=1;
					}else{
						$retorno->result=2;
					}
				}
			}else{
				$retorno->result=0;
			}
			return $retorno;
		}

		public function obtenerID($id){
			$retorno = new Resultado();
			$sql = "CALL SGESS_TRANSFERENCIA_X_ID('$id')";
			//echo $sql;
			$result = parent::ejecutar2($sql);
			if ($fila = mysqli_fetch_object($result)){
				$obj = new Transferencia();
				$obj->id = $fila->id;
				$obj->idEjemplar = $fila->idEjemplar;
				$obj->idNuevoProp = $fila->idNuevoProp;
				$obj->idAntiguoProp = $fila->idAntiguoProp;
				$obj->idNuevoCria = $fila->idNuevoCria;
				$obj->idAntiguoCria = $fila->idNuevoCria;	
				$obj->fechaRegistro = $fila->fechaRegistro;	
				$obj->fechaTransferencia = $fila->fechaTransferencia;
				$obj->estado = $fila->estado;
				$obj->antiguoProp=$fila->antiguoProp;
				$obj->nuevoProp=$fila->nuevoProp;
				$obj->nombre=$fila->nombre;	
				$obj->prefijo=$fila->prefijo;

			}
			return $obj;
		}

		public function obtenerID1($id){
			$retorno = new Resultado();
			$sql = "CALL SGESS_TRANSFERENCIA_VIEW_X_ID('$id')";
			$result = parent::ejecutar2($sql);
			if ($fila = mysqli_fetch_object($result)){
				$obj = new TransferenciaDTO();
				$obj->id = $fila->id;
				$obj->idEjemplar = $fila->idEjemplar;
				$obj->idNuevoProp = $fila->idNuevoProp;
				$obj->idAntiguoProp = $fila->idAntiguoProp;
				$obj->nombre = $fila->nombre;
				$obj->antiguoProp = $fila->antiguoProp;
				$obj->nuevoProp = $fila->nuevoProp;	
				$obj->prefijo = $fila->prefijo;		
				$obj->fechaRegistro = $fila->fechaRegistro;	
				$obj->fechaTransferencia = $fila->fechaTransferencia;
				$obj->estado = $fila->estado;	
				$obj->estadoDesc = $fila->estadoDesc;	

								
			}
			return $obj;
		}

		/*
       public function buscar(){

            $sql = "CALL SGESS_LIST_TRANSFERENCIA()";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            
            while($fila = mysqli_fetch_object($result)){
                $obj = new TransferenciaDTO();
                $obj->id = $fila->id;
                $obj->fechaRegistro = $fila->fechaRegistro;
                $obj->estado = $fila->estado;
                $obj->idEjemplar = $fila->idEjemplar;
                $obj->nombre = $fila->nombre;
                $obj->antiguoProp = $fila->antiguoProp;
                $obj->nuevoProp = $fila->nuevoProp;
                $obj->prefijo = $fila->prefijo;
                
                $trans[] = $obj;
            }
            return $trans;
        }*/

		public function numeroRegistro($vid,$vcodigo,$vprefijo, $vnombreEjemplar, $vnuevoProp, $dfechaTransferencia,$ente){
            // $retorno=new Resultado();
            $sql = "CALL SGESS_CUENTA_TRANSFERENCIA_JQGRID('$vid','$vcodigo','$vprefijo', '$vnombreEjemplar', '$vnuevoProp', '$dfechaTransferencia','$ente')";
           //echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }

        public function buscarSearch($start,$limit,$sidx,$sord,$vid,$vcodigo, $vprefijo, $vnombreEjemplar, $vnuevoProp, $dfechaTransferencia,$ente){
            $sql = "CALL SGESS_TRANSFERENCIA_JQGRID('$start','$limit','$sidx','$sord','$vid','$vcodigo', '$vprefijo', '$vnombreEjemplar', '$vnuevoProp', '$dfechaTransferencia','$ente')";
           //echo $sql;
            $result = parent::ejecutar2($sql);
            $entidades=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->id;
                  $obj->idEjemplar = $fila->idEjemplar;
                  $obj->prefijo = $fila->prefijo;
                  $obj->nombre=$fila->nombre;
                  $obj->antiguoProp=$fila->antiguoProp;                  
                  $obj->nuevoProp=$fila->nuevoProp;
                  $obj->fechaRegistro=$fila->fechaRegistro;
                  $obj->fechaTransferencia=$fila->fechaTransferencia;
                  $obj->estadoDesc=$fila->estadoDesc;
                  $obj->capado=$fila->capado;
                $entidades[] = $obj;
            }
            return $entidades;
        }


        public function buscar(){
             $retorno=new Resultado();
            $aColumns=array("id","idEjemplar","prefijo","nombre","antiguoProp","nuevoProp","fechaRegistro","fechaTransferencia","estadoDesc");
            $sIndexColumn="id";
            $sTable="sgev_transferencia";
            return parent::loadDataTable($aColumns,$sIndexColumn,$sTable);
        }

        public function getTransferenciaByEjemplar($vidEjemplar){
            $sql = "CALL SGESS_TRANSFERENCIA_X_EJEMPLAR('$vidEjemplar')";
           // echo $sql;
            $result = parent::ejecutar2($sql);
            $entidades=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->id;
                  $obj->idEjemplar = $fila->idEjemplar;
                  $obj->prefijo = $fila->prefijo;
                  $obj->nombre=$fila->nombre;
                  $obj->antiguoProp=$fila->antiguoProp;                  
                  $obj->nuevoProp=$fila->nuevoProp;
                  $obj->fechaTransferencia=$fila->fechaTransferencia;
                  $obj->estadoDesc=$fila->estadoDesc;
                $entidades[] = $obj;
            }
            return $entidades;
        }

	}

?>