<?php
    if (file_exists("../data/ResultadoConcursoData.php")) {         include_once("../data/ResultadoConcursoData.php");    }
    if (file_exists("../entidad/Constantes.php")) {        include_once("../entidad/Constantes.php");  }

    if (file_exists("../../data/ResultadoConcursoData.php")) {    include_once("../../data/ResultadoConcursoData.php");    }
    if (file_exists("../../entidad/Constantes.php")) {  include_once("../../entidad/Constantes.php");  }


    class ResultadoConcursoLogica{
        public $context;
        public function ResultadoConcursoLogica(){
            $this->context = new ResultadoConcursoData();
        }
        public function insertar($concurso,$ejemplar,$puesto,$propietario,$grupo,$categoria,$idProp,$usuario){
           $retorno = $this->context->insertar($concurso,$ejemplar,$puesto,$propietario,$grupo,$categoria,$idProp,$usuario);
           return $retorno;
        }
        public function editar($codigo,$concurso,$ejemplar,$puesto,$propietario,$grupo,$categoria,$idProp,$usuario){
            $retorno = $this->context->editar($codigo,$concurso,$ejemplar,$puesto,$propietario,$grupo,$categoria,$idProp,$usuario);
            return $retorno;
        }
        public function eliminar($codigo,$usuario){
            $retorno = $this->context->eliminar($codigo,$usuario);
            return $retorno;
         }
         public function buscar($nombre,$fecha,$start,$limit,$sidx,$sord){
            $retorno = $this->context->buscar($nombre,$fecha,$start,$limit,$sidx,$sord);
            return $retorno;
         }
         public function numeroRegistro($nomConcurso,$fecha){
            $retorno = $this->context-> numeroRegistro($nomConcurso,$fecha);
            return $retorno;
         }
         public function datosConcurso($id){
            $retorno = $this->context-> datosConcurso($id);
            return $retorno;
         }
         public function listarEjemplares($nombreEjemplar,$start,$limit,$sidx,$sord){
            $retorno = $this->context->listarEjemplares($nombreEjemplar,$start,$limit,$sidx,$sord);
            return $retorno;
         }
         public function numeroRegistroEjemplares($nomConcurso){
            $retorno = $this->context-> numeroRegistroEjemplares($nomConcurso);
            return $retorno;
         }
         public function ComboConcursos(){
            $retorno = $this->context-> ComboConcursos();
            return $retorno;
         }
    }
?>