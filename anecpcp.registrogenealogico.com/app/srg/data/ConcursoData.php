<?php
    include_once ("modelo.php");
    if (file_exists("../entidad/Concurso.php")) include_once ("../entidad/Concurso.php");
   if (file_exists("../entidad/Resultado.inc.php"))  include_once ("../entidad/Resultado.inc.php"); 

   if (file_exists("../../entidad/Concurso.php")) include_once ("../../entidad/Concurso.php");
   if (file_exists("../../entidad/Resultado.inc.php"))  include_once ("../../entidad/Resultado.inc.php"); 
    
    class ConcursoData extends dal{

        public $retorno;
          function __construct(){
            parent::dal();
            $retorno=new Resultado();
        }

       
        public function insertar($nombre,$fecha,$juez,$usuario){
             $retorno=new Resultado();

            $sql = "CALL SGESI_CONCURSO('$nombre','$fecha','$juez','$usuario',@vresultado)";
            $result = parent::ejecutar2($sql,'@vresultado');
            //echo $sql;
            if($result){
                if($fila = mysqli_fetch_array($result)){
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else{
                     $retorno->result=2;
                    }
               }
            }else{
                     $retorno->result=0; 
            }

            return  $retorno;
        }

        public function editar($codigo,$nombre,$fecha,$juez,$usuario){
             $retorno=new Resultado();
            $sql = "CALL SGESU_CONCURSO('$codigo','$nombre','$fecha','$juez','$usuario',@vresultado)";
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else{
                     $retorno->result=2;
                    }
               }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }

        public function eliminar($codigo,$usuario){
             $retorno=new Resultado();
            $sql = "CALL SGESD_CONCURSO('$codigo','$usuario',@vresultado)";
            $result = parent::ejecutar2($sql,'@vresultado');
            //ECHO $sql;
            if($result){
                if($fila = mysqli_fetch_array($result)){
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else{
                     $retorno->result=2;
                    }
               }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }
        
        //function para buscar
        public function buscar($nombre,$start,$limit,$sidx,$sord){
             $retorno=new Resultado();
            $sql = "CALL SGESS_CONCURSOS_JQGRID('$nombre','$start','$limit','$sidx','$sord')";
             //echo $sql ;
            $result = parent::ejecutar2($sql);
            $collection=[];
            while($fila = mysqli_fetch_object($result)){
                $obj = new Concurso();
                $obj->idConcurso = $fila->idConcurso;
                $obj->nombre = $fila->nombre;
                $obj->fecha = $fila->fecha;
                $obj->juez = $fila->juez;
                $obj->activo = $fila->activo;
                $collection[] = $obj;
            }
            return $collection;
        }
        public function numeroRegistro($nomConcurso){
            // $retorno=new Resultado();
            $sql = "CALL SGESS_CUENTA_CONCURSO_JQGRID('$nomConcurso')";
           // echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        public function datosConcurso($id){
            $sql="CALL SGESS_CONCURSO_X_ID('$id')";
            $result = parent::ejecutar2($sql);
            $collection=[];
            while($fila = mysqli_fetch_object($result)){
                $obj = new Concurso();
                $obj->idConcurso = $fila->idConcurso;
                $obj->nombre = $fila->nombre;
                $obj->fecha = $fila->fecha;
                $obj->juez = $fila->juez;
                $obj->activo = $fila->activo;
                $collection[] = $obj;
            }
            return $collection;

        }
    }
?>
