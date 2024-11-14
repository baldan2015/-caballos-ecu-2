<?php
    include_once ("modelo.php");
    include_once ("../entidad/SelectedItems.php");
    include_once ("../entidad/Resultado.inc.php");      
    
    class CampeonData extends dal{

        public $retorno;
          function __construct(){
            parent::dal();
            $retorno=new Resultado();
        }

        public function listarComboCampeon($codigo,$descripcion){
            $retorno=new Resultado();
            $sql = "CALL SGESS_TIPO_Campeon_CBO('$codigo','$descripcion')";
          // echo $sql;
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new ListItem();
                $obj->valor = $fila->idEntidad;
                $obj->descripcion = $fila->Campeon;
                //$obj->nombreLargo = $fila->nombreLargo;
                $turno[] = $obj;
            }
            return $turno;
        }

         public function insertar($vanio,$vprefijo,$vejemplar,$vidEjemplar,$vpropietario,$iesSuperCamp){
            $retorno=new Resultado();
            $sql = "CALL SGESI_CAMPEON('$vanio','$vprefijo','$vejemplar','$vidEjemplar','$vpropietario','$iesSuperCamp',@vresultado)";
          // echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                  //  print_r($fila);
                   if($fila[0]==""){
                      $retorno->result=0;
                    }else if($fila[0]==3){
                      $retorno->result=3;
                    }else if($fila[0]==999){
                      $retorno->result=999;
                    }else if($fila[0]==998){
                      $retorno->result=998;
                    }else{
                      $retorno->result=1;
                      $retorno->code=$fila[0];
                    }
               }
            }else{
                     $retorno->result=0; 
            }
            return $retorno;
        }


           public function listar($vejemplar){
             $retorno=new Resultado();
            $sql = "CALL SGESS_CAMPEONATOS('$vejemplar')";
            $result = parent::ejecutar2($sql);
            $campeonatos=[];
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->id = $fila->id;
                $obj->esSuperCamp = $fila->esSuperCamp;
                $obj->anio = $fila->anio;
                $campeonatos[] = $obj;
            }
            return $campeonatos;
        }

         public function eliminar($vid){
            $retorno=new Resultado();
            $sql = "CALL SGESD_CAMPEON('$vid',@vresultado)";
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                   if($fila[0]==""){
                      $retorno->result=0;
                    }else if($fila[0]==3){
                      $retorno->result=3;
                    }else if($fila[0]==999){
                      $retorno->result=999;
                    }else if($fila[0]==998){
                      $retorno->result=998;
                    }else{
                      $retorno->result=1;
                      $retorno->code=$fila[0];
                    }
               }
            }else{
                     $retorno->result=0; 
            }
            return $retorno;
        }
    }
?>
