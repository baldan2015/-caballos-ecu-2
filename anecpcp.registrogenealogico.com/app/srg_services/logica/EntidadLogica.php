<?php
    if (file_exists("../data/EntidadData.php")) {
        include_once("../data/EntidadData.php");
    }
    if (file_exists("../entidad/Entidad.inc")) {
        include_once("../entidad/Entidad.inc");
    }
    if (file_exists("../entidad/Constantes.php")) {
        include_once("../entidad/Constantes.php");
    }
    class EntidadLogica{
        public $context;
        public function EntidadLogica(){
            $this->context = new EntidadData();
        }
        //Guardar
        public function insertar($idTipoDoc,$numDoc,$apePaterno,$apeMaterno,$nombres,$razonSocial,$correo,$telefono1,$telefono2,$observacion,$usuario_crea,$flagSocio,$flagCriador,$flagPropietario,$idDpto,$lugarCria,$prefijo,$login,$pwd){
           $retorno = $this->context->insertar($idTipoDoc,$numDoc,$apePaterno,$apeMaterno,$nombres,$razonSocial,$correo,$telefono1,$telefono2,$observacion,$usuario_crea,$flagSocio,$flagCriador,$flagPropietario,$idDpto,$lugarCria,$prefijo,$login,$pwd);
           return $retorno;
        }
        //Obtener ID
        public function obtenerID($codEjemplar){
            $registros = $this->context->obtenerID($codEjemplar);
            return $registros;
        }
        //Editar
        public function editar($codigo,$idTipoDoc,$numDoc,$apePaterno,$apeMaterno,$nombres,$razonSocial,$correo,$telefono1,$telefono2,$observacion,$usuario_modi,$flagSocio,$flagCriador,$flagPropietario,$flagSituacion,$idPropietario,$idDpto,$lugarCria,$prefijo,$login,$pwd){
            $registros = $this->context->editar($codigo,$idTipoDoc,$numDoc,$apePaterno,$apeMaterno,$nombres,$razonSocial,$correo,$telefono1,$telefono2,$observacion,$usuario_modi,$flagSocio,$flagCriador,$flagPropietario,$flagSituacion,$idPropietario,$idDpto,$lugarCria,$prefijo,$login,$pwd);
            return $registros;
        }
        //Buscar
        public function buscar($entity){
            $registros = $this->context->buscar($entity);
            return $registros;
        }
        //Eliminar
        public function eliminar($codigo,$usuario_modi){
            $registros = $this->context->eliminar($codigo,$usuario_modi);
            return $registros;
        }
        //funcion Generar codigo
        public function generarCodigo($entity){
            $registros = $this->context->generarCodigo($entity);
            return $registros;
        }
        
        public function numeroRegistro($id,$numDoc,$nombre,$rol,$estado,$prefijo){
            return $this->context->numeroRegistro($id,$numDoc,$nombre,$rol,$estado,$prefijo);
        }
        
        public function buscarSearch($id,$numDoc,$nombre,$rol,$estado,$prefijo,$start=1, $limit=15,$sidx=1,$sord=""){
            $registros = $this->context->buscarSearch($id,$numDoc,$nombre,$rol,$estado,$prefijo,$start , $limit,$sidx,$sord);
            return $registros;
        }
        //funcion validar eliminación de categoria
        public function validarEliminar($entity){
            $registros = $this->context->validarEliminar($entity);
            return $registros;
        }
        public function buscarDataTable(){
            $registros = $this->context->buscarDataTable();
            return $registros;
        }
        public function buscarPropietario($nombre){
        $registros = $this->context->buscarPropietario($nombre);
            return $registros;
        }
         public function buscarCriador($nombre){
        $registros = $this->context->buscarCriador($nombre);
            return $registros;
        }

        public function buscarSearchGralEntidadProp($nomFiltro,$start=1, $limit=15,$sidx=1,$sord=""){
          //  echo "buscarSearch";
            $registros = $this->context->buscarSearchGralEntidadProp($nomFiltro, $start , $limit,$sidx,$sord);
            return $registros;
        }
        public function numeroRegistroGralEntidadProp($nomFiltro){
            
            return $this->context->numeroRegistroGralEntidadProp($nomFiltro);
        }

        public function buscarSearchGralEntidadCria($nomFiltro,$start=1, $limit=15,$sidx=1,$sord=""){
          //  echo "buscarSearch";
            $registros = $this->context->buscarSearchGralEntidadCria($nomFiltro, $start , $limit,$sidx,$sord);
            return $registros;
        }
        public function numeroRegistroGralEntidadCria($nomFiltro){
            
            return $this->context->numeroRegistroGralEntidadCria($nomFiltro);
        }

        public function listarComboProp($codigo,$descripcion){
            $registros = $this->context->listarComboProp($codigo,$descripcion);
            return $registros;
        }
        public function listarComboCria($codigo,$descripcion){
            $registros = $this->context->listarComboCria($codigo,$descripcion);
            return $registros;
        }
        public function listarIdEntidadXProp($idPropietario){
            return $this->context->listarIdEntidadXProp($idPropietario);
        }
       

    }
?>
