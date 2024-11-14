<?php
    //INICIO DE CAMBIOS
    if (file_exists("../../data/TransferenciaData.php")) include_once("../../data/TransferenciaData.php");
    if (file_exists("../../entidad/Constantes.php")) include_once("../../entidad/Constantes.php");    
    if (file_exists("../../entidad/Transferencia.inc.php")) include_once("../../entidad/Transferencia.inc.php");
    if (file_exists("../../entidad/TransferenciaDTO.inc.php")) include_once("../../entidad/TransferenciaDTO.inc.php");
    if (file_exists("../../data/PropietarioLogData.php")) include_once("../../data/PropietarioLogData.php");
    if (file_exists("../../data/EntidadData.php")) include_once("../../data/EntidadData.php");

    //FIN DE CAMBIOS

	if (file_exists("../data/TransferenciaData.php")){
		include_once("../data/TransferenciaData.php");
	}

    if (file_exists("../entidad/Constantes.php")) {
        include_once("../entidad/Constantes.php");
    }
    
    if (file_exists("../entidad/Transferencia.inc.php")){
        include_once("../entidad/Transferencia.inc.php");
    }   

    if (file_exists("../entidad/TransferenciaDTO.inc.php")){
        include_once("../entidad/TransferenciaDTO.inc.php");
    }   

    if (file_exists("../data/PropietarioLogData.php")){
        include_once("../data/PropietarioLogData.php");
    }      

    if (file_exists("../data/EntidadData.php")){
        include_once("../data/EntidadData.php");
    }      

if (file_exists("../logica/EjemplarLogica.php")){
        include_once("../logica/EjemplarLogica.php");
    }  

    class TransferenciaLogica{
    	public $context;
    	public function TransferenciaLogica(){
            $this->context = new TransferenciaData();
    	}

    	public function insertar($id, $idEjemplar, $idNuevoProp, $idAntiguoProp, $idNuevoCria, $idAntiguoCria, $fechaRegistro, $fechaTransferencia, $estado, $listPropietarios,$usuario_crea){
              $usuCrea=$usuario_crea;
              $retorno=  new Resultado();
              $servicioEjemplarLog=new EjemplarLogica();
              $retornoProps=$servicioEjemplarLog->editarPropietarios($idEjemplar,$listPropietarios,null,0,$usuCrea); 
              //print_r($retornoProps); 
              if($retornoProps->code>0){
                  $idNuevoProp =$retornoProps->code;
    		      $retorno = $this->context->insertar($id, $idEjemplar, $idNuevoProp, $idAntiguoProp, $idNuevoCria, $idAntiguoCria, $fechaRegistro, $fechaTransferencia, $estado,$usuario_crea);
              }else{
                     if($retornoProps->result==5){
                              $retorno->result=5;
                        }else{
                              /*ocurrio un errro al registrar o actualizar propietarios*/
                              $retorno->result=6;
                        }
              }
             
           	return $retorno;	
    	}

    	public function editar($id, $idEjemplar, $idNuevoProp, $idAntiguoProp, $idNuevoCria, $idAntiguoCria, $fechaRegistro, $fechaTransferencia, $estado,$usuario_modi){
    		$retorno = $this->context->editar($id, $idEjemplar, $idNuevoProp, $idAntiguoProp, $idNuevoCria, $idAntiguoCria, $fechaRegistro, $fechaTransferencia, $estado,$usuario_modi);
    		return $retorno;
    	}

    	public function eliminar($id,$usuario_modi){
    		$retorno = $this->context->eliminar($id,$usuario_modi);
    		return $retorno;	
    	}

        public function confirmar($id, $fechaTransferencia){
            $retorno = $this->context->confirmar($id, $fechaTransferencia);
            return $retorno;    
        }

    	public function obtenerID($id){
    		$retorno = $this->context->obtenerID($id);
    		return $retorno;
    	}

        public function obtenerID1($id){
            $retorno = $this->context->obtenerID1($id);
            return $retorno;
        }

		public function buscar(){
			$retorno = $this->context->buscar();
			return $retorno;	
		}

        public function numeroRegistro($vid,$vcodigo,$vprefijo, $vnombreEjemplar, $vnuevoProp, $dfechaTransferencia,$ente){
            return $this->context->numeroRegistro($vid,$vcodigo,$vprefijo, $vnombreEjemplar, $vnuevoProp, $dfechaTransferencia,$ente);
        }
        
        public function buscarSearch($start=1, $limit=15,$sidx=1,$sord="",$vid,$vcodigo,$vprefijo, $vnombreEjemplar, $vnuevoProp, $dfechaTransferencia,$ente){
            $registros = $this->context->buscarSearch($start,$limit,$sidx,$sord,$vid,$vcodigo,$vprefijo,$vnombreEjemplar,$vnuevoProp,$dfechaTransferencia,$ente);
            return $registros;
        }

        public function getTransferenciaByEjemplar($vidEjemplar){
            $registros = $this->context->getTransferenciaByEjemplar($vidEjemplar);
            return $registros;
        }

    }


?>