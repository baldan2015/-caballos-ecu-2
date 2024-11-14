<?php
    if (file_exists("../data/ConcursoData.php")) {         include_once("../data/ConcursoData.php");    }
    if (file_exists("../entidad/Constantes.php")) {        include_once("../entidad/Constantes.php");  }

    if (file_exists("../../data/ConcursoData.php")) {    include_once("../../data/ConcursoData.php");    }
    if (file_exists("../../entidad/Constantes.php")) {  include_once("../../entidad/Constantes.php");  }


    class ConcursoLogica{
        public $context;
        public function ConcursoLogica(){
            $this->context = new ConcursoData();
        }
        public function insertar($nombre,$fecha,$juez,$usuario){
           $retorno = $this->context->insertar($nombre,$fecha,$juez,$usuario);
           return $retorno;
        }
        public function editar($codigo,$nombre,$fecha,$juez,$usuario){
            $retorno = $this->context->editar($codigo,$nombre,$fecha,$juez,$usuario);
            return $retorno;
        }
        public function eliminar($codigo,$usuario){
            $retorno = $this->context->eliminar($codigo,$usuario);
            return $retorno;
         }
         public function buscar($nombre,$start,$limit,$sidx,$sord){
            $retorno = $this->context->buscar($nombre,$start,$limit,$sidx,$sord);
            return $retorno;
         }
         public function  numeroRegistro($nomConcurso){
            $retorno = $this->context-> numeroRegistro($nomConcurso);
            return $retorno;
         }
         public function datosConcurso($id){
            $retorno = $this->context-> datosConcurso($id);
            return $retorno;
         }
    }
?>