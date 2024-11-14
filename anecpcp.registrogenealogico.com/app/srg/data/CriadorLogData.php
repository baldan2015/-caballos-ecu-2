<?php
    include_once ("modelo.php");
    //include_once("../entidad/CriadorLog.inc.php");    
    //include_once("../entidad/Resultado.inc.php");

    if (file_exists("../../entidad/CriadorLog.inc.php")) include_once("../../entidad/CriadorLog.inc.php");   
    if (file_exists("../../entidad/Resultado.inc.php"))include_once("../../entidad/Resultado.inc.php");

    if (file_exists("../entidad/CriadorLog.inc.php")) include_once("../entidad/CriadorLog.inc.php");
    if (file_exists("../entidad/Resultado.inc.php"))include_once("../entidad/Resultado.inc.php");
    
    class CriadorLogData extends dal{

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
        public function insertar($idEjemplar,$idPropietario,$usuario_crea){
             $retorno=new Resultado();
            $sql = "CALL SGESI_CRIADORLOG('$idEjemplar','$idPropietario','$usuario_crea',@vresultado)";
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
            $sql = "CALL SGESS_CRIADOR_X_EJEMPLAR('$idEjemplar')";
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new CriadorLog();
                $obj->codigo = $fila->id;
                $obj->idCriador = $fila->idCriador;
                $obj->idEjemplar = $fila->idEjemplar;
                $obj->fecInicio = $fila->fecInicio;
                $obj->fecFin = $fila->fecFin;
                $obj->nombres = $fila->nombres;
                $criaLog[] = $obj;
            }
           // echo "<pre>..";print_r($criaLog);
            return $criaLog;
        }
       

           public function actualizarXID($id){
            $retorno=new Resultado();
            $sql = "CALL SGESU_CRIADORLOG('$id',@vresultado)";
           // echo $sql;
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
      
    }
?>
