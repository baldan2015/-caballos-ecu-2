<?php
    include_once ("modelo.php");
    if (file_exists("../entidad/Departamento.inc")) include_once ("../entidad/Departamento.inc");
   if (file_exists("../entidad/Resultado.inc.php"))  include_once ("../entidad/Resultado.inc.php"); 

   if (file_exists("../../entidad/Departamento.inc")) include_once ("../../entidad/Departamento.inc");
   if (file_exists("../../entidad/Resultado.inc.php"))  include_once ("../../entidad/Resultado.inc.php"); 
    
    class DepartamentoData extends dal{

        public $retorno;
          function __construct(){
            parent::dal();
            $retorno=new Resultado();
        }

        /*
        autor: dbs - 20160725
        nombre function
            insertar
        parametro entrada
            $nombre: nombre del pelaje obligatorio y no debe repetirse
        parametro de retorno
            $retorno->result: [0 1 2]
            0=error en el ejecucion del store
            1=inserto ok
            2=no inserto. Ya existe el parametro nombre como data/
        */
       
        public function numeroRegistro($nomDepart){
            // $retorno=new Resultado();
            $sql = "CALL SGESS_CUENTA_DEPART_JQGRID('$nomDepart')";
            //echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        public function buscarSearch($nomDepart,$start,$limit,$sidx,$sord){
            //$retorno=new Resultado();
            $sql = "CALL SGESS_DEPART_JQGRID('$nomDepart','$start','$limit','$sidx','$sord')";
            // echo $sql;
            $result = parent::ejecutar2($sql);
            $deps=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->id;
                  $obj->descripcion = $fila->descripcion;
                  $deps[] = $obj;
            }
            return $deps;
        }
        public function listarComboTipoDepart($codigo,$descripcion){
            $retorno=new Resultado();
            $sql = "CALL SGESS_TIPO_DEPART_CBO('$codigo','$descripcion')";
           // echo $sql;
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new ListItem();
                $obj->valor = $fila->id;
                $obj->descripcion = $fila->descripcion;
                //$obj->nombreLargo = $fila->nombreLargo;
                $turno[] = $obj;
            }
            return $turno;
        }
         public function obtenerID($id){
             $retorno=new Resultado();
            $sql = "CALL SGESS_DEPARTAMENTO_X_ID('$id')";
            //echo $sql;
             $obj = new Departamento();
            $result = parent::ejecutar2($sql);
            if($fila = mysqli_fetch_object($result)){
                 
                      $obj->codigo = $fila->id;
                      $obj->descripcion = $fila->descripcion;               
            }
            return $obj;
    }
         
    }
?>
