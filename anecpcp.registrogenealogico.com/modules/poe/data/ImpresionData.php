<?php
    include_once ("modelo.php");
    if (file_exists("../../entidad/Ejemplar.inc.php")) include_once("../../entidad/Ejemplar.inc.php");
    if (file_exists("../../entidad/Resultado.inc.php")) include_once("../../entidad/Resultado.inc.php");

    if (file_exists("../entidad/Ejemplar.inc.php")) include_once("../entidad/Ejemplar.inc.php");
    if (file_exists("../entidad/Resultado.inc.php")) include_once("../entidad/Resultado.inc.php");

  
    
    class ImpresionData extends dal{

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
        
         public function obtenerVecesImpresion($idHorse){
             $retorno=new Resultado();

            $sql = "CALL SGESS_OBTENER_ULTIMA_IMPRENSION('$idHorse')";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            if($result){
                if($fila = mysqli_fetch_array($result)){
                      $retorno->result=$fila[0];
                }
            }else{
                     $retorno->result=-1; 
            }
             
            return  $retorno;
        }
        
        //funcion para eliminar un registro
        public function insertarLog($idEjemplar,$usuaCrea,$tipo){
             $retorno=new Resultado();
            $sql = "CALL SGESI_IMPRESION_LOG('$idEjemplar','$usuaCrea','$tipo')";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            if($result){
                return true;
            }else{
                return false;
            }
        }
       
       
    }
?>
