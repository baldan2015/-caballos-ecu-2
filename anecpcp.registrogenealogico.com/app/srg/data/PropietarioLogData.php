<?php
    include_once ("modelo.php");
    /*include_once("../entidad/PropietarioLog.inc.php");    
    include_once("../entidad/Resultado.inc.php");*/
    if (file_exists("../../entidad/PropietarioLog.inc.php"))include_once("../../entidad/PropietarioLog.inc.php");
    if (file_exists("../../entidad/Resultado.inc.php")) include_once("../../entidad/Resultado.inc.php");

    if (file_exists("../entidad/PropietarioLog.inc.php"))include_once("../entidad/PropietarioLog.inc.php");
    if (file_exists("../entidad/Resultado.inc.php")) include_once("../entidad/Resultado.inc.php");
    
    class PropietarioLogData extends dal{

        public $retorno;
          function __construct(){
            parent::dal();
            
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
        public function insertar($idEjemplar,$idPropietario){
             $retorno=new Resultado();
            $sql = "CALL SGESI_PROPIETARIOLOG('$idEjemplar','$idPropietario',@vresultado)";
       //   echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                  //  print_r($fila);
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
          public function insertarPorEntidad($idEjemplar,$idEntidad){
             $retorno=new Resultado();
            $sql = "CALL SGESI_PROPIETARIOLOG_X_ENTIDAD('$idEjemplar','$idEntidad',@vresultado)";
            //echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                  //  print_r($fila);
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
        public function buscarXEjemplar($idEjemplar){
            $sql = "CALL SGESS_PROP_X_EJEMPLAR('$idEjemplar')";
            //echo $sql;

            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){

              //echo"buscarXEjemplar <pre>";print_r($fila);
              if( $fila->id!="" && $fila->idPropietario!="" && 
                  $fila->idEjemplar!="" && $fila->fecInicio!="" && 
                  $fila->nombres!="" && $fila->idEntidad!=""){
                $obj = new PropietarioLog();
                $obj->codigo = $fila->id;
                $obj->idPropietario = $fila->idPropietario;
                $obj->idEjemplar = $fila->idEjemplar;
                $obj->fecInicio = $fila->fecInicio;
                $obj->fecFin = $fila->fecFin;
                $obj->nombres = $fila->nombres;
                $obj->idEntidad = $fila->idEntidad;
                $propLog[] = $obj;
              }
            }
            return $propLog;
        }

         public function actualizarXId($id){
             $retorno=new Resultado();
            $sql = "CALL SGESU_PROPIETARIOLOG('$id',@vresultado)";
            //echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                  //  print_r($fila);
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else{
                     $retorno->result=0;
                    }
               }
            }else{
                     $retorno->result=0; 
            }

            return  $retorno;
        }
       
   public function obtieneIdsCooPropietario($ids){
            $sql = "CALL SGESS_LISTAR_COOPROP_EVAL('$ids')";
           //echo $sql;
            $propLog=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $propLog[] = $fila->idProp;
            }
            return $propLog;
        }

          //ADDON DBS 20200121
        public function buscarPropOriginalXEjemplar($idEjemplar){
            $sql = "CALL SGESS_PROP_ORIGINAL_X_EJEMPLAR('$idEjemplar')";
            //echo $sql;

            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){

              //echo"buscarXEjemplar <pre>";print_r($fila);
              if( $fila->id!="" && $fila->idPropietario!="" && 
                  $fila->idEjemplar!="" && $fila->fecInicio!="" && 
                  $fila->nombres!="" && $fila->idEntidad!=""){
                $obj = new PropietarioLog();
                $obj->codigo = $fila->id;
                $obj->idPropietario = $fila->idPropietario;
                $obj->idEjemplar = $fila->idEjemplar;
                $obj->fecInicio = $fila->fecInicio;
                $obj->fecFin = $fila->fecFin;
                $obj->nombres = $fila->nombres;
                $obj->idEntidad = $fila->idEntidad;
                $propLog[] = $obj;
              }
            }
            return $propLog;
        }
         
      
    }
?>
