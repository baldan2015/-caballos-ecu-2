<?php
//echo getcwd();
if (file_exists("../../data/EjemplarDataF2.php")) include_once("../../data/EjemplarDataF2.php");
if (file_exists("../../entidad/Ejemplar.inc.php"))include_once("../../entidad/Ejemplar.inc.php");
if (file_exists("../../entidad/Constantes.php"))include_once("../../entidad/Constantes.php");
if (file_exists("../../data/PropietarioLogData.php"))include_once("../../data/PropietarioLogData.php");
if (file_exists("../../data/CriadorLogData.php"))include_once("../../data/CriadorLogData.php");
if (file_exists("../../data/EntidadData.php"))include_once("../../data/EntidadData.php");
if (file_exists("../../logica/PropietarioLogLogica.php"))include_once("../../logica/PropietarioLogLogica.php");


if (file_exists("../data/EjemplarDataF2.php"))  include_once("../data/EjemplarDataF2.php");
if (file_exists("../entidad/Ejemplar.inc.php"))include_once("../entidad/Ejemplar.inc.php");
if (file_exists("../entidad/Constantes.php"))include_once("../entidad/Constantes.php");
if (file_exists("../data/PropietarioLogData.php"))include_once("../data/PropietarioLogData.php");
if (file_exists("../data/CriadorLogData.php"))include_once("../data/CriadorLogData.php");
if (file_exists("../data/EntidadData.php"))include_once("../data/EntidadData.php");
if (file_exists("../logica/PropietarioLogLogica.php"))include_once("../logica/PropietarioLogLogica.php"); 


    class EjemplarLogica{
        public $context;
        public function EjemplarLogica(){
            $this->context = new EjemplarData();
        }
       
    
        /*----------------------------inciio fase 2 --------------------------------*/
       

         //Guardar
        public function insertar($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$usuario_crea,$genero,$fecCapado,$listPropietarios,$listCriadores,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado){


          $retorno=new Resultado();
          $data=$this->context->getPrefijoProp($idProp);
          $prefijoProp=$data->prefijo;
          if((is_array($listCriadores) && count($listCriadores)>1) ){
                $retorno->result=4;
          }else{
                          $retorno = $this->context->insertar($codigo,$prefijoProp,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$usuario_crea,$genero,$fecCapado,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado);

             }  
                return $retorno;
        }
         //Editar
        public function editar($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado, $reseniaBasica){
          
          $resultado=new Resultado();
           $data=$this->context->getPrefijoProp($idProp);
          $prefijoProp=$data->prefijo;
        if(is_array($criadores) && count($criadores)>1 ){
          $resultado->result=4;
        }else{
                      $resultado = $this->context->editar($codigo,$prefijoProp,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado, $reseniaBasica); 

          }
       
            return $resultado;
        }
        //Obtener ID
        public function obtenerID($codigo){
            $registros = $this->context->obtenerID($codigo); 

        if($registros!=null){
           $registroPadre = $this->context->obtenerID($registros->idPadre); 
           $registroMadre = $this->context->obtenerID($registros->idMadre); 
           
           if($registroPadre!=null)$registros->nombrePadre=$registroPadre->prefijo." ".$registroPadre->nombre." - ".$registroPadre->codigo;
           if($registroMadre!=null)$registros->nombreMadre=$registroMadre->prefijo." ".$registroMadre->nombre." - ".$registroMadre->codigo;

                   
        }
            return $registros;
        }



         public function obtenerIDINS($codigo){
            $registros = $this->context->obtenerIDINS($codigo); 

        if($registros!=null){
           $registroPadre = $this->context->obtenerID($registros->idPadre); 
           $registroMadre = $this->context->obtenerID($registros->idMadre); 
           
           if($registroPadre!=null)$registros->nombrePadre=$registroPadre->prefijo." ".$registroPadre->nombre." - ".$registroPadre->codigo;
           if($registroMadre!=null)$registros->nombreMadre=$registroMadre->prefijo." ".$registroMadre->nombre." - ".$registroMadre->codigo;

                   
        }
            return $registros;
        }
          /*INICIO metodos para JQGRID PAGINADO*/        
        public function numeroRegistro($id,$pref,$nom,$prop,$estado,$ente){
            return $this->context->numeroRegistro($id,$pref,$nom,$prop,$estado,$ente);
        }
        public function buscarSearch($id,$pref,$nom,$prop,$estado,$ente,$start=1, $limit=100,$sidx=1,$sord=""){
            $registros = $this->context->buscarSearch($id,$pref,$nom,$prop,$estado,$ente,$start,$limit,$sidx,$sord);
            return $registros;
        }
        /*FIN metodos para JQGRID PAGINADO*/  

        //Buscar
        public function buscar($entity){
            $registros = $this->context->buscar($entity);
            return $registros;
        }
        //Eliminar
        public function eliminarIns($codigo,$usuario_modi){
            $registros = $this->context->eliminarIns($codigo,$usuario_modi);
            return $registros;
        }

           public function getPrefijoProp($idProp){
          $registros=$this->context->getPrefijoProp($idProp);
          return $registros;
        }

        public function listarTipoDocumento(){
         $registros=$this->context->listarTipoDocumento();
          return $registros; 
        }

         public function getEstadosLogInscripcion($id){
          $registros=$this->context->getEstadosLogInscripcion($id);
          return $registros;
        }

        public function getEstadosLogNacimiento($id){
          $registros=$this->context->getEstadosLogNacimiento($id);
          return $registros;
        }
        public function obteneDatosInscripcionPrint($id,$codigoInscripcion,$prop,$origen){
          $registros=$this->context->obteneDatosInscripcionPrint($id,$codigoInscripcion,$prop,$origen);
          return $registros;
        }


        public function actualizarEstadoSol($id,$estado,$comentario,$idProp,$vProp,$vCria){
          $resultado=new Resultado();
          $registros = $this->context->actualizarEstadoSol($id,$estado,$comentario,$idProp,$vProp,$vCria); 
          return $registros;
        }
        
        public function getCodigoEjemplar($id){
          $resultado = new Resultado();
          $registros = $this->context->getCodigoEjemplar($id);
          return $registros;
        }


        public function numeroRegistroNovedades($anio,$mes,$prop,$flag){
            return $this->context->numeroRegistroNovedades($anio,$mes,$prop,$flag);
        }
        public function buscarSearchNovedades($anio,$mes,$prop,$flag,$start=1, $limit=100,$sidx=1,$sord=""){
            $registros = $this->context->buscarSearchNovedades($anio,$mes,$prop,$flag,$start,$limit,$sidx,$sord);
            return $registros;
        }
        public function insertLogHistorial($id,$accion,$flag,$prop,$comentario,$fecha){
            $registros = $this->context->insertLogHistorial($id,$accion,$flag,$prop,$comentario,$fecha);
            return $registros;
        }
        public function cantidadRregistroxAproOrRech(){
            $registros = $this->context->cantidadRregistroxAproOrRech();
            return $registros;
        }
          public function cantidadAllNovedades(){
            $registros = $this->context->cantidadAllNovedades();
            return $registros;
        }
         public function cantidadAllInscripciones(){
            $registros = $this->context->cantidadAllInscripciones();
            return $registros;
        }
        public function cantidadAllNacimientos(){
            $registros = $this->context->cantidadAllNacimientos();
            return $registros;
        }
        public function getInfoHistorialAll($id){
           $registros = $this->context->getInfoHistorialAll($id);
           return $registros;
        }
        public function getInfoUsuarioApro($id){
           $registros = $this->context->getInfoUsuarioApro($id);
           return $registros;
        }

        public function getLastInsertIns(){
            $retorno=new Resultado();
            $registros=$this->context->getLastInsertIns();
            return $registros;
        }
        public function numeroRegistroNacimiento($id,$pref,$nom,$prop,$estado,$ente){
            return $this->context->numeroRegistroNacimiento($id,$pref,$nom,$prop,$estado,$ente);
        }
        public function buscarSearchNacimiento($id,$pref,$nom,$prop,$estado,$ente,$start=1, $limit=100,$sidx=1,$sord=""){
            $registros = $this->context->buscarSearchNacimiento($id,$pref,$nom,$prop,$estado,$ente,$start,$limit,$sidx,$sord);
            return $registros;
        }
        public function insertarNac($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$usuario_crea,$genero,$fecCapado,$listPropietarios,$listCriadores,$idMonta,$idProvincia,$origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado){


          $retorno=new Resultado();
          $data=$this->context->getPrefijoProp($idProp);
          $prefijoProp=$data->prefijo;
          if((is_array($listCriadores) && count($listCriadores)>1) ){
                $retorno->result=4;
          }else{
                          $retorno = $this->context->insertarNac($codigo,$prefijoProp,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$usuario_crea,$genero,$fecCapado,$idMonta,$idProvincia,$origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado);

             }  
                return $retorno;
        }
         //Editar
        public function editarNac($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado,$reseniaBasica){
          
          $resultado=new Resultado();
           $data=$this->context->getPrefijoProp($idProp);
          $prefijoProp=$data->prefijo;
        if(is_array($criadores) && count($criadores)>1 ){
          $resultado->result=4;
        }else{
                      $resultado = $this->context->editarNac($codigo,$prefijoProp,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado,$reseniaBasica); 

          }
       
            return $resultado;
        }

        public function obtenerIDNAC($codigo){
            $registros = $this->context->obtenerIDNAC($codigo); 

        if($registros!=null){
           $registroPadre = $this->context->obtenerID($registros->idPadre); 
           $registroMadre = $this->context->obtenerID($registros->idMadre); 
           
           if($registroPadre!=null)$registros->nombrePadre=$registroPadre->prefijo." ".$registroPadre->nombre." - ".$registroPadre->codigo;
           if($registroMadre!=null)$registros->nombreMadre=$registroMadre->prefijo." ".$registroMadre->nombre." - ".$registroMadre->codigo;

                   
        }
            return $registros;
        }

        public function eliminarNAC($codigo){
            $registros = $this->context->eliminarNAC($codigo);
            return $registros;
        }
        public function obteneDatosNacimientoPrint($id,$codigoInscripcion,$prop,$origen){
          $registros=$this->context->obteneDatosNacimientoPrint($id,$codigoInscripcion,$prop,$origen);
          return $registros;
        }
        public function getLastInsertNac(){
            $retorno=new Resultado();
            $registros=$this->context->getLastInsertNac();
            return $registros;
        }
         public function actualizarEstadoSolNac($id,$estado,$comentario,$idProp,$vProp,$vCria){
          $resultado=new Resultado();
          $registros = $this->context->actualizarEstadoSolNac($id,$estado,$comentario,$idProp,$vProp,$vCria); 
          return $registros;
        }

        public function numeroRegistroMonta($anio,$mes,$prop,$estado,$activo){
          return $this->context->numeroRegistroMonta($anio,$mes,$prop,$estado,$activo);
      }
        public function buscarSearchMonta($anio,$mes,$prop,$estado,$start=1, $limit=100,$sidx=1,$sord="",$activo){
            $registros = $this->context->buscarSearchMonta($anio,$mes,$prop,$estado,$start,$limit,$sidx,$sord,$activo);
            return $registros;
        }
        public function aprobarMonta($id,$prop){
            $registros = $this->context->aprobarMonta($id,$prop);
            return $registros;
        }
        public function rechazarMonta($id,$prop){
            $registros = $this->context->rechazarMonta($id,$prop);
           return $registros;
        }
        public function obteneDatosServicioMontaPrint($id,$codigoMonta,$prop,$origen){
          $registros=$this->context->obteneDatosServicioMontaPrint($id,$codigoMonta,$prop,$origen);
          return $registros;
        }
        public function listarPais(){
         $registros=$this->context->listarPais();
          return $registros; 
        }
        public function getDatosExtranjero($id){
            $registros = $this->context->getDatosExtranjero($id);
            return $registros;
        }
        public function updateDatosExtranjero($id,$codigo,$nombre,$prefijo,$dtpFecNacExt,$pelaje,$pais){
            $registros = $this->context->updateDatosExtranjero($id,$codigo,$nombre,$prefijo,$dtpFecNacExt,$pelaje,$pais);
            return $registros;   
        }
        public function detalleAprobacion($id){
            $registros = $this->context->detalleAprobacion($id);
            return $registros;
        }
        public function listaComboIdMonta($prop,$flag){
          $registros=$this->context->listaComboIdMonta($prop,$flag);
          return $registros;
        }
        public function listaComboIdNac($prop,$flag){
          $registros=$this->context->listaComboIdNac($prop,$flag);
          return $registros;
        }

        public function getFechaNovedades($id,$flag){
          $registros=$this->context->getFechaNovedades($id,$flag);
          return $registros;
        }
        public function getInfoNewProp($idProp){
          $registros=$this->context->getInfoNewProp($idProp);
          return $registros;
        }
        public function updateDatosNewProp($id,$tipoDoc,$numDoc,$nombreProp,$apePatProp,$apeMatProp,$direccion,$correo,$idProp){
            $registros = $this->context->updateDatosNewProp($id,$tipoDoc,$numDoc,$nombreProp,$apePatProp,$apeMatProp,$direccion,$correo,$idProp);
            return $registros;   
        }
        public function listarMotivoBaja()
        {
           $registros=$this->context->listarMotivoBaja();
            return $registros;
        }
    }
?>
