<?php

    include_once ("modelo.php");

    class LogData extends dal{

        

        public function LogData(){

            parent::dal();

        }

        

        public function ExisteSessionId($idSession){

            $sql = "CALL SGESS_EXISTE_SESSION('".$idSession."')";

      //  echo $sql;

            $resultado=0;

            $result = parent::ejecutar2($sql);

            while($fila = mysqli_fetch_object($result)){

                $resultado= $fila->result;

            }

            return $resultado;



        }

    }

?>

